<?php

namespace App\Http\Controllers\Moderator\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * Get all admins
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $admins = User::where('role' , 'admin')
            ->select('id' , 'first_name' , 'last_name' , 'email')
            ->get();

        return response()->json([
            'Message' => 'Admins have been retrieved successfully',
            'Data' => $admins,
        ] , 200);
    }

    /**
     * Get an admin
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $admin = User::where('role' , 'admin')->find($id);
        if(!$admin)
            abort(404 , 'Admin not found');

        return response()->json([
            'Message' => 'Admin has been retrieved successfully',
            'Data' => $admin,
        ] , 200);
    }
}
