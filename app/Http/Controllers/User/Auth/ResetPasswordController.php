<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Traits\TokenHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    use TokenHandler;

    /**
     * Seconds before a token expires
     *
     * @var int
     */
    protected int $seconds = 90;

    /**
     * Table where tokens are stored
     *
     * @var string
     */
    protected string $table = 'password_resets';

    /**
     * Index that is used to store and get tokens
     *
     * @var string
     */
    protected string $indexKey = 'email';

    /**
     * Send the token
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(ForgotPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $this->storeToken($this->table, $this->indexKey, $request->input('email'));
        try {
            Mail::to($request->input('email'))->send(new VerifyEmail($token , $this->seconds));
        } catch (\Exception){
            abort(502 , 'Failed to send the code');
        }
        return response()->json([
            'Message' => 'Token has been created and sent to the user\'s email. It will expire after: '. $this->seconds .  ' seconds',
        ], 201);
    }

    /**
     * Find and update the user
     *
     * @param array $validated
     * @return User
     */
    public function handle(array $validated): User
    {
        $user = User::where('email' , $validated['email'])->first();
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);
        return $user;
    }

    /**
     * Reset the password and login
     *
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $this->getToken($this->seconds, $this->table, $this->indexKey, $request->input('email') , $request->input('code'));
        $user = $this->handle($request->only('email' , 'password'));
        $user->tokens()->delete();
        $code = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'Message' => 'Password has been updated successfully',
            'token' => $code,
            'type' => 'Bearer',
            'Role' => $user->role,
        ], 200);
    }
}
