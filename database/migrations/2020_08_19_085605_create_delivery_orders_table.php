<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('delivery_order_number');
            $table->date('effective_date_start')->nullable();
            $table->date('effective_date_end')->nullable();
            $table->string('product');
            $table->double('quantity');
            $table->string('shipped_with');
            $table->tinyInteger('shipped_via');
            $table->string('no_vehicles');
            $table->bigInteger('km_start');
            $table->string('km_end');
            $table->string('sg_meter');
            $table->string('top_seal');
            $table->string('bottom_seal');
            $table->string('temperature');
            $table->timestamp('departure_time')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->timestamp('unloading_start_time')->nullable();
            $table->timestamp('unloading_end_time')->nullable();
            $table->timestamp('departure_time_depot')->nullable();
            $table->tinyInteger('status');
            $table->text('bast')->nullable();
            $table->time('estimate')->nullable();
            $table->unsignedBigInteger('sales_order_id');
            $table->foreign('sales_order_id')->references('id')->on('sales_orders')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
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
        Schema::dropIfExists('delivery_orders');
    }
}
