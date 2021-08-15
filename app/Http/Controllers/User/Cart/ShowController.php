<?php

namespace App\Http\Controllers\User\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Watch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{

    /**
     * Get cart's information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $watches = Cart::where('user_id' , auth()->id())->with('watch')->first()->watch;

        $data = $this->collectWatches($watches);

        $totalPrice = $this->calcTotalPrice($watches);

        return response()->json([
            'Message' => 'Watches have been retrieved successfully',
            'Data' => [
                'Watches' => $data,
                'Total' => $totalPrice,
            ],
        ]);
    }

    /**
     * Collect watches that are in the cart
     *
     * @param Collection $watches
     * @return Collection
     */
    private function collectWatches(Collection $watches): Collection
    {
        $data = new Collection();
        foreach ($watches as $watch) {
            $price = $watch->price * $watch->pivot->quantity;
            $data->push([
                'id' => $watch->id,
                'name' => $watch->name,
                'image' => $watch->img,
                'quantity' => $watch->pivot->quantity,
                'price' => $price,
            ]);
        }
        return $data;
    }

    /**
     * Calculate total price of the cart
     *
     * @param Collection $watches
     * @return float|int
     */
    private function calcTotalPrice(Collection $watches): float|int
    {
        $totalPrice = 0;

        foreach ($watches as $watch) {
            $price = $watch->price * $watch->pivot->quantity;
            $totalPrice += $price;
        }
        return $totalPrice;
    }

}
