<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait TokenHandler{

    /**
     * Generate a token
     *
     * @param int $length
     * @return string
     */
    protected function generateToken(int $length): string
    {
        return Str::random($length);
    }

    /**
     * Store a token in the DB
     *
     * @param string $table
     * @param string $indexKey
     * @param mixed $indexValue
     * @return string
     */
    protected function storeToken(string $table, string $indexKey , mixed $indexValue): string
    {
        DB::table($table)
            ->where($indexKey , $indexValue)->delete();
        $token = $this->generateToken(12);
        DB::table($table)->insert([
            $indexKey => $indexValue,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);
        return $token;
    }

    /**
     * Try to get the valid token
     *
     * @param int $seconds
     * @param string $table
     * @param string $indexKey
     * @param mixed $indexValue
     *
     * @return string
     */
    private function getToken(int $seconds, string $table, string $indexKey, mixed $indexValue): string
    {
        $timeBeforeExpire = Carbon::now()->subSeconds($seconds);
        if(! $token = DB::table($table)
            ->where($indexKey , $indexValue)
            ->where('created_at' , '>' , $timeBeforeExpire)
            ->latest()->first())
            abort(401 , 'Invalid or expired token');
        return $token->token;
    }

}
