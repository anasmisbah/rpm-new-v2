<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifDoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notif_do', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date')->nullable();
            $table->string('driver')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('notif_do');
    }
}
