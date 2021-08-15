<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\UpdateRequest;
use App\Traits\CartChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    use CartChecker;

    /**
     * Update the quantity of a watch in the user's cart
     *
     * @param int $watchID
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuantity(int $watchID , UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $cartID = auth()->user()->cart->id;

        if(!$this->exists($watchID , $cartID))
            abort(409 , 'Watch isn\'t in the cart');

        DB::table('cart_watch')
            ->where('cart_id' , $cartID)->where('watch_id' , $watchID)
            ->update([
            'quantity' => $request->validated()['quantity'],
        ]);

        return response()->json([
            'Message' => 'Cart has been updated successfully',
        ], 200);
    }
}
