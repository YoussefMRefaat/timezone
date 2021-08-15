<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Models\Cart;
use App\Traits\CartChecker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    use CartChecker;

    /**
     * Add the watch in the user's cart
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {

        $cartID = auth()->user()->cart->id;

        $validated = $request->validated();

        if($this->exists($validated['watch_id'] , $cartID))
            abort(409 , 'Watch is already in the cart');


        DB::table('cart_watch')->insert([
            'cart_id' => $cartID,
            'watch_id' => $validated['watch_id'],
            'quantity' => $validated['quantity'],
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'Message' => 'Watch has been added successfully'
        ], 201);
    }

}
