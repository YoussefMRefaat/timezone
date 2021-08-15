<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Traits\CartChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    use CartChecker;

    /**
     * Delete a watch from the user's cart
     *
     * @param int $watchID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $watchID): \Illuminate\Http\JsonResponse
    {

        $cartID = auth()->user()->cart->id;

        if(!$this->exists($watchID , $cartID))
            abort(409 , 'Watch isn\'t in the cart');

        DB::table('cart_watch')
            ->where('cart_id' , $cartID)->where('watch_id' , $watchID)
            ->delete();

        return response()->json([
            'Message' => 'Cart has been updated successfully',
        ], 200);
    }
}
