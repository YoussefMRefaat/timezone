<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * Get all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = User::where('role' , 'user')
            ->select('id' ,'first_name' , 'last_name', 'email' , 'gender')
            ->geT();

        return response()->json([
            'Message' => 'Users have been retrieved successfully',
            'Data' => $users
        ], 200);
    }


    /**
     * Get a specific user
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);
        if(!$user)
            abort(404 , 'User not found');

        return response()->json([
            'Message' => 'User has been retrieved successfully',
            'Data' => $user
        ], 200);
    }


    /**
     * Get users based on their gender
     *
     * @param $gender
     * @return \Illuminate\Http\JsonResponse
     */
    public function gender($gender): \Illuminate\Http\JsonResponse
    {
        if(!in_array($gender , ['male' , 'female']))
            abort(404);

        $users = User::where('role' , 'user')
            ->where('gender' , $gender)
            ->select('id' ,'first_name' , 'last_name', 'email')
            ->get();

        return response()->json([
            'Message' => 'Users have been retrieved successfully',
            'Data' => $users
        ], 200);
    }

    /**
     * Get user's orders
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrders(int $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);
        if(!$user)
            abort(404 , 'User not found');

        $orders = Order::select('id' , 'status' , 'total' , 'created_at')->where('user_id' , $id)->get();

        return response()->json([
            'Message' => 'Orders have been retrieved successfully',
            'Data' => $orders,
        ]);
    }

}
