<?php

namespace App\Http\Controllers\User\Watches;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{

    /**
     * Get all watches ordered by date in descending order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function new(): \Illuminate\Http\JsonResponse
    {
        $watches = Watch::select('id' ,'name' , 'description' , 'img' , 'price')
            ->latest()->get();

        return response()->json([
            'Message' => 'Watches have been retrieved successfully',
            'Data' => $watches,
        ] ,200);
    }

    /**
     * Get all watches ordered by price in descending order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function highest(): \Illuminate\Http\JsonResponse
    {
        $watches = Watch::select('id' ,'name' , 'description' , 'img' , 'price')
            ->orderBy('price' , 'desc')->get();

        return response()->json([
            'Message' => 'Watches have been retrieved successfully',
            'Data' => $watches,
        ] ,200);
    }

    /**
     * Get all watches ordered by price in ascending order
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lowest(): \Illuminate\Http\JsonResponse
    {
        $watches = Watch::select('id' ,'name' , 'description' , 'img' , 'price')
            ->orderBy('price' , 'asc')->get();

        return response()->json([
            'Message' => 'Watches have been retrieved successfully',
            'Data' => $watches,
        ] ,200);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function popular(): \Illuminate\Http\JsonResponse
    {
        $watchesIDs = DB::table('order_watch')
            ->groupBy('watch_id')->orderByRaw('SUM(quantity) DESC')
            ->limit(3)->pluck('watch_id')->toArray();

        $orderedIDs = implode(',' , $watchesIDs);
        $watches = Watch::select('id' , 'name' , 'description' , 'img' , 'price')->whereIn('id' , $watchesIDs)
            ->orderByRaw('FIELD(id,' . $orderedIDs . ")")->get();

        return response()->json([
            'Message' => 'Watches have been retrieved successfully',
            'Data' => $watches
        ]);
    }

    /**
     * Show a specific watch
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $watch = Watch::findOrFail($id);

        return response()->json([
            'Message' => 'Watch has been retrieved successfully',
            'Data' => ['id' => $watch->id , 'name' => $watch->name ,
                'description' => $watch->description , 'price' => $watch->price ,
                'in_cart' => $this->InCart($id) ],
        ] , 200);
    }

    /**
     * Get the quantity of a watch in the user's cart
     *
     * @param int $watchID
     * @return int
     */
    private function InCart(int $watchID): int
    {
        $user = auth()->guard('sanctum')->user();
        if(!$user)
            return 0;

        $cartID = $user->cart->id;
        $watch = DB::table('cart_watch')
            ->where('cart_id' , $cartID)->where('watch_id' , $watchID)->first();
        if($watch)
            return $watch->quantity;
        return 0;
    }
}
