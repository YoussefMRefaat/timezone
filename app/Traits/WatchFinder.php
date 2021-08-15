<?php

namespace App\Traits;

use App\Models\Watch;

trait WatchFinder{

    /**
     * Try to find the watch
     *
     * @param int $id
     * @return Watch
     */
    protected function findWatch(int $id): Watch
    {
        $watch = Watch::find($id);
        if(!$watch)
            abort(404 , 'Watch not found');

        return $watch;
    }
}
