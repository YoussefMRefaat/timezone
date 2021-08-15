<?php

namespace App\Http\Controllers\Moderator\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateController extends Controller
{

    /**
     * Store an admin
     *
     * @param AdminStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'primary_phone' => $validated['primary_phone'],
            'sec_phone' => $validated['sec_phone'] ?? null,
            'primary_address' => $validated['primary_address'],
            'sec_address' => $validated['sec_address'] ?? null,
            'role' => 'admin',
        ]);

        return response()->json([
            'Message' => 'Admin has been created successfully'
        ] , 201);
    }
}
