<?php

namespace App\Http\Controllers\Admin\Watches;

use App\Http\Controllers\Controller;
use App\Http\Requests\Watches\UpdateImageRequest;
use App\Http\Requests\Watches\UpdateRequest;
use App\Models\Watch;
use App\Traits\ImageStorer;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
    use ImageStorer;

    /**
     * Update a watch
     *
     * @param int $id
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id , UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $watch = Watch::findOrFail($id);

        $validated = $request->validated();

        $watch->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
        ]);

        return response()->json([
            'Message' => 'Watch has been updated successfully',
        ], 200);
    }

    /**
     * Update a watch's image
     *
     * @param int $id
     * @param UpdateImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImage(int $id , UpdateImageRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $watch = Watch::findOrFail($id);

        $path = $this->storeImage($validated['image']);

        File::delete($watch->img);

        $watch->update([
            'img' => $path
        ]);

        return response()->json([
            'Message' => 'Watch has been updated successfully',
        ], 200);
    }
}
