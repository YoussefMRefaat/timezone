<?php

namespace App\Http\Controllers\Admin\Watches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Watches\StoreRequest;
use App\Models\Watch;
use App\Traits\ImageStorer;

class CreateController extends Controller
{

    use ImageStorer;
    /**
     * Store a watch
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $path = $this->storeImage($validated['image']);

        Watch::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'img' => $path,
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
        ]);

        return response()->json([
            'Message' => 'Watch has been added successfully',
        ] , 201);
    }
}
