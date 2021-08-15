<?php

namespace App\Http\Controllers\User\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * Get user's orders
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $orders = Order::where('user_id' , auth()->id())->with('watches')->get();

        $data = $this->collectOrders($orders);

        return response()->json([
            'Message' => 'Orders have been retrieved successfully',
            'Data' => $data,
        ]);
    }

    /**
     * Collect user's orders
     *
     * @param Collection $orders
     * @return Collection
     */
    private function collectOrders(Collection $orders): Collection
    {
        $data = new Collection();
        foreach ($orders as $order){

            $watches = $this->collectWatches($order->watches);

            $data->push([
                'id' => $order->id,
                'ordered_at' => $order->created_at,
                'total_price' => $order->total,
                'status' => $order->status,
                'shipped_at' => $order->shipped_at,
                'delivered_at' => $order->delivered_at,
                'watches' => $watches,
            ]);
        }
        return $data;
    }

    /**
     * Collect watches that are in an order
     *
     * @param Collection $watches
     * @return Collection
     */
    private function collectWatches(Collection $watches): Collection
    {
        $watchesCollection = new Collection();

        foreach($watches as $watch){
            $watchesCollection->push([
                'id' => $watch->id,
                'name' => $watch->name,
                'image' => $watch->img,
                'quantity' => $watch->pivot->quantity,
                'price' => $watch->pivot->quantity * $watch->pivot->price_in_order,
            ]);
        }
        return $watchesCollection;
    }
}
