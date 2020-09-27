<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('critics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('critics_suggestion')->nullable();
            $table->text('service')->nullable();
            $table->integer('rating')->nullable();
            $table->unsignedBigInteger('delivery_order_id')->nullable();
            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders')->onDelete('cascade');
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
        Schema::dropIfExists('critics');
    }
}
