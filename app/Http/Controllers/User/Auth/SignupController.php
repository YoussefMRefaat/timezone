<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{

    /**
     * Handle a signup request
     *
     * @param SignupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SignupRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->create($request->validated());
        $token = $user->createToken('authToken');
        return response()->json([
            'Message' => 'Registered successfully',
            'token' => $token->plainTextToken,
            'type' => 'Bearer',
            'Role' => $user->role,
        ] , 201);
    }

    /**
     * Store the user
     *
     * @param $validated
     * @return User
     */
    private function create($validated): User
    {
        $validated['role'] = 'user';
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        Cart::create([
            'user_id' => $user->id,
        ]);
        return $user;
    }
}
