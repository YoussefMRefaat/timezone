<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{

    /**
     * Update user's information
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        auth()->user()->update([
            'first_name' => $validated['first_name'] ,
            'last_name' => $validated['last_name'],
            'email' => $validated['email'] ,
            'gender' => $validated['gender'],
            'primary_phone' => $validated['primary_phone'] ,
            'sec_phone' => $validated['sec_phone'],
            'primary_address' => $validated['primary_address'],
            'sec_address' => $validated['sec_address'],
        ]);

        return response()->json([
            'Message' => 'User updated successfully',
        ], 200);
    }


    /**
     * Update user's password
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        auth()->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json([
            'Message' => 'Password updated successfully',
        ], 200);
    }
}
