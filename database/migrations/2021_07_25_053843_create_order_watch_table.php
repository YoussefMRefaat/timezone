<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderWatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_watch', function (Blueprint $table) {
            $table->foreignId('order_id');
            $table->foreignId('watch_id');
            $table->tinyInteger('quantity')->unsigned();
            $table->decimal('price_in_order' , 7,2);

            $table->foreign('order_id' , 'order_watch_order_id_foreign')
                ->references('id')->on('orders')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('watch_id' , 'order_watch_watch_id_foreign')
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
        Schema::dropIfExists('order_watch');
    }
}
