<?php

namespace App\Http\Controllers\Moderator\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteController extends Controller
{

    /**
     * Delete an admin
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $admin = User::where('role' , 'admin')->find($id);
        if(!$admin)
            abort(404 , 'Admin not found');

        $admin->delete();
        return response()->json([
            'Message' => 'Admin has been deleted successfully',
        ] , 200);
    }
}
