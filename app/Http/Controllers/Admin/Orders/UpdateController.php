<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{

    /**
     * Try to get an order
     *
     * @param int $id
     * @return Order
     */
    private function findOrder(int $id): Order
    {
        $order = Order::find($id);
        if(!$order)
            abort(404 , 'Order not found');

        return $order;
    }


    /**
     * Mark an order as shipped
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ship(int $id): \Illuminate\Http\JsonResponse
    {
        $order = $this->findOrder($id);

        if($order->status != 'pending')
            abort(409 , 'Order has already been shipped or cancelled');

        $order->update([
            'shipped_at' => now(),
            'status' => 'shipped',
        ]);

        return response()->json([
            'Message' => 'Order has been shipped successfully',
        ], 200);
    }


    /**
     * Mark an order as delivered
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliver(int $id): \Illuminate\Http\JsonResponse
    {
        $order = $this->findOrder($id);

        if($order->status != 'shipped')
            abort(409 , 'Order cannot be delivered');

        $order->update([
            'delivered_at' => now(),
            'status' => 'delivered',
        ]);

        return response()->json([
            'Message' => 'Order has been delivered successfully',
        ], 200);
    }


    /**
     * Mark an order as cancelled and restore the watches
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(int $id): \Illuminate\Http\JsonResponse
    {
        $order = $this->findOrder($id);

        if(in_array($order->status , ['delivered' , 'cancelled']))
            abort(409 , 'Order has already been delivered or cancelled');

        $this->restore($order);

        $order->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'Message' => 'Order has been cancelled successfully'
        ], 200);
    }


    /**
     * Restore the watches of an order
     *
     * @param Order $order
     */
    private function restore(Order $order){
        $watches = $order->getRelationValue('watches');

        foreach ($watches as $watch){
            $watch->increment('quantity' , $watch->pivot->quantity);
        }
        DB::table('order_watch')->where('order_id' , $order->id)->delete();
    }

}
