<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait CartChecker{

    /**
     * Check if a watch exists in a cart
     *
     * @param int $watchID
     * @param int $cartID
     * @return bool
     */
    protected function exists(int $watchID , int $cartID): bool
    {
        $watch = DB::table('cart_watch')
            ->where('cart_id' , $cartID)->where('watch_id' , $watchID)->first();

        if($watch)
            return true;

        return false;
    }
}
