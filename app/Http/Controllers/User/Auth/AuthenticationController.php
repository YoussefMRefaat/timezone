<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    /**
     * Handle a login request
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        if(!Auth::attempt($validated)){
            abort(401 , 'Invalid email or password');
        }
        $token = $request->user()->createToken('authToken');

        return response()->json([
            'Message' => 'Logged in successfully',
            'token' => $token->plainTextToken,
            'type' => 'Bearer',
            'Role' => $request->user()->role,
        ] , 201);
    }

    /**
     * Handle a logout request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'Message' => 'Logged out successfully',
        ] , 200);
    }
}
