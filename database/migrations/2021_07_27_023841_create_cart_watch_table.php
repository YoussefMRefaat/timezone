<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartWatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_watch', function (Blueprint $table) {
            $table->foreignId('cart_id')->index();
            $table->foreignId('watch_id');
            $table->unsignedTinyInteger('quantity');
            $table->timestamp('created_at')->nullable();

            $table->foreign('cart_id' , 'cart_watch_cart_id_foreign')
                ->references('id')->on('cart')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('watch_id' , 'cart_watch_watch_id_foreign')
                ->references('id')->on('watches')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_watch');
    }
}
