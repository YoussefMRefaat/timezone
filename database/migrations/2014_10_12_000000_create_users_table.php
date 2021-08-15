<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name' , 15);
            $table->string('last_name' , 15);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('gender' , ['male' , 'female']);
            $table->string('primary_phone' , 20);
            $table->string('sec_phone' , 20)->nullable();
            $table->string('primary_address' , 100);
            $table->string('sec_address' , 100)->nullable();
            $table->enum('role' , ['user' , 'admin' , 'moderator']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
