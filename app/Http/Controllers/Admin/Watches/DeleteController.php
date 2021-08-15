<?php

namespace App\Http\Controllers\Admin\Watches;

use App\Http\Controllers\Controller;
use App\Traits\WatchFinder;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    use WatchFinder;

    /**
     * Delete a watch
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $watch = $this->findWatch($id);

        File::delete($watch->img);

        $watch->delete();

        return response()->json([
            'Message' => 'Watch has been deleted successfully',
        ] , 200);
    }
}
