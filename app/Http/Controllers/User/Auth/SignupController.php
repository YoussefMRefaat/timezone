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
        $validated = $request->validated();

        $user = $this->create($validated);

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
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'primary_phone' => $validated['primary_phone'],
            'sec_phone' => $validated['sec_phone'] ?? null,
            'primary_address' => $validated['primary_address'],
            'sec_address' => $validated['sec_address'] ?? null,
            'role' => 'user',
        ]);

        Cart::create([
            'user_id' => $user->id,
        ]);

        return $user;
    }
}
