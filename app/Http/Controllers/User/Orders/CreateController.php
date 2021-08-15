<?php

namespace App\Http\Controllers\User\Orders;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{

    /**
     * Make an order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): \Illuminate\Http\JsonResponse
    {

        $watches = $this->getCart();

        $totalPrice = $this->calcTotalPrice($watches);

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => $totalPrice,
        ]);

        $this->storeWatches($order , $watches);

        $this->clearCart();

        return response()->json([
            'Message' => 'Order has been made successfully'
        ] , 201);
    }

    /**
     * Get cart's details
     *
     * @return Collection
     */
    private function getCart(): Collection
    {
        $watches = Cart::where('user_id' , auth()->id())->with('watch')->first()->watch;

        if(empty($watches->all()))
            abort(409 , 'Cart is empty');

        return $watches;
    }

    /**
     * Delete the ordered watches from the cart
     */
    private function clearCart(){
        $cartID = auth()->user()->cart->id;
        DB::table('cart_watch')->where('cart_id' , $cartID)->delete();
    }

    /**
     * Store order details
     *
     * @param Order $order
     * @param Collection $watches
     */
    private function storeWatches( Order $order ,Collection $watches){

        foreach ($watches as $watch){
            $order->watches()->attach($watch->id , [
                'price_in_order' => $watch->price,
                'quantity' => $watch->pivot->quantity,
            ]);
            $watch->decrement('quantity' , $watch->pivot->quantity);
        }
    }

    /**
     * Calculate total price of the order
     *
     * @param Collection $watches
     * @return float|int
     */
    private function calcTotalPrice(Collection $watches): float|int
    {
        $totalPrice = 0;
        foreach ($watches as $watch){
            $totalPrice += $watch->price * $watch->pivot->quantity;
        }
        return $totalPrice;
    }
}
