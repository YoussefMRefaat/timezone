<?php

namespace App\Http\Controllers\Admin\Watches;

use App\Http\Controllers\Controller;
use App\Models\Watch;
use App\Traits\WatchFinder;

class ShowController extends Controller
{
    use WatchFinder;

    /**
     * Get all watches
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $watches = Watch::select('id' , 'name' , 'description' , 'img')->get();

        return response()->json([
            'Message' => 'Watches have been retrieved successfully',
            'Data' => $watches,
        ], 200);
    }

    /**
     * Show a watch
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $watch = $this->findWatch($id);

        return response()->json([
            'Message' => 'Watch has been retrieved successfully',
            'Data' => $watch,
        ] , 200);
    }
}
