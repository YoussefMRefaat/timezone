<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerificationCodeRequest;
use App\Mail\VerifyEmail;
use App\Traits\TokenHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    use TokenHandler;

    /**
     * Seconds before a token expires
     *
     * @var int $seconds
     */
    protected int $seconds = 180;

    /**
     * Table where tokens are stored
     *
     * @var string $table
     */
    protected string $table = 'email_verifications';

    /**
     * Index that is used to store and get tokens
     *
     * @var string
     */
    protected string $indexKey = 'user_id';


    /**
     * Send the token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(): \Illuminate\Http\JsonResponse
    {
        if(auth()->user()->email_verified_at)
            abort (409 , 'Email is already verified');
        $token = $this->storeToken($this->table , $this->indexKey , auth()->id());
        try {
            Mail::to(auth()->user())->send(new VerifyEmail($token , $this->seconds));
        } catch (\Exception){
            abort(502 , 'Failed to send the code');
        }
        return response()->json([
            'Message' => 'Token has been created and sent to the user\'s email.
            It will expire after: '. $this->seconds .  ' seconds',
        ], 201);
    }


    /**
     * Verify the email
     *
     * @param VerificationCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerificationCodeRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $this->getToken($this->seconds, $this->table, $this->indexKey, auth()->id() , $request->input('code'));
        auth()->user()->update([
            'email_verified_at' => Carbon::now(),
        ]);
        return response()->json([
            'Message' => 'The email has been verified successfully'
        ] , 200);
    }

}
