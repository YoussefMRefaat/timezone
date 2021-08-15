<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{

    /**
     * Delete the account
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(): \Illuminate\Http\JsonResponse
    {
        DB::transaction(function(){
            auth()->user()->tokens()->delete();

            User::find(auth()->id())->delete();
        });

        return response()->json([
            'User has been deleted successfully',
        ], 200);
    }
}
