<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->integer('product_id');
        $table->date('shippingDate');
        $table->float('qty');
        $table->integer('user_id');
        $table->string('client');
        $table->text('comment')->default(' ');
        $table->boolean('isConfirmed')->default(0);
        $table->boolean('isSuccess')->default(0);
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
        Schema::dropIfExists('orders');

    }
}
