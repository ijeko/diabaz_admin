<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->date('date');
            $table->float('qty');
            $table->integer('user_id');
            $table->string('soldTo');
            $table->boolean('isConfirmed')->default('0');
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
        Schema::dropIfExists('sold_plans');
    }
}
