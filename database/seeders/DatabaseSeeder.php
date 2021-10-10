<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => Str::random(6),
            'last_name' => Str::random(6),
            'email' => 'moderator@test',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'gender' => 'male',
            'primary_phone' => '01 234 5678',
            'primary_address' => Str::random(8),
            'role' => 'moderator',
            'created_at' => now(),
        ]);
    }
}
