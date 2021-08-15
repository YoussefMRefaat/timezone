<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * Get all orders
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $orders = Order::with('user')->get();

        $data = $this->collectOrders($orders);

        return response()->json([
            'Message' => 'Orders have been retrieved successfully',
            'Data' => $data,
        ], 200);
    }

    /**
     * Get orders based on status
     *
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(string $status): \Illuminate\Http\JsonResponse
    {
        if(!in_array($status , ['pending' , 'shipped' , 'cancelled' , 'delivered']))
            abort(404);

        $orders = Order::where('status' , $status)->with('user')->get();

        $data = $this->collectOrders($orders);

        return response()->json([
            'Message' => 'Orders have been retrieved successfully',
            'Data' => $data,
        ], 200);
    }

    /**
     * Collect orders
     *
     * @param Collection $orders
     * @return Collection
     */
    private function collectOrders(Collection $orders): Collection
    {
        $data = new Collection();
        foreach ($orders as $order){
            $data->push([
                'id' => $order->id,
                'ordered_at' => $order->created_at,
                'total_price' => $order->total,
                'status' => $order->status,
                'shipped_at' => $order->shipped_at,
                'delivered_at' => $order->delivered_at,
                'user_id' => $order->user_id,
                'user_name' => $order->user->first_name . ' ' .$order->user->last_name,
            ]);
        }
        return $data;
    }

    /**
     * Get an order with details
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $order = Order::with('watches')->with('user')->find($id);
        if(!$order)
            abort(404 , 'Order not found');

        $watches = $this->collectWatches($order);

        return response()->json([
            'Message' => 'Order has been retrieved successfully',
            'Data' => [
                'id' => $order->id,
                'total_price' => $order->total,
                'status' => $order->status,
                'shipped_at' => $order->shipped_at,
                'delivered_at' => $order->delivered_at,
                'ordered_at' => $order->created_at,
                'user_id' => $order->user_id,
                'user_name' => $order->user->first_name . ' ' .$order->user->last_name,
                'watches' => $watches,
            ]
        ], 200);
    }

    /**
     * Collect watches that are in an order
     *
     * @param Order $order
     * @return Collection
     */
    private function collectWatches(Order $order): Collection
    {
        $data = new Collection();

        foreach($order->watches as $watch){
            $data->push([
                'id' => $watch->id,
                'name' => $watch->name,
                'quantity' => $watch->pivot->quantity,
                'price' => $watch->pivot->price_in_order,
            ]);
        }
        return $data;
    }

}
