<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Get user's information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo(): \Illuminate\Http\JsonResponse
    {
        $user = User::select('first_name' , 'last_name' , 'email' , 'gender' , 'primary_address' , 'sec_address', 'primary_phone' , 'sec_phone')
            ->find(auth()->id());

        return response()->json([
            'Message' => 'User has been retrieved successfully',
            'Data' => $user,
        ], 200);
    }

}
