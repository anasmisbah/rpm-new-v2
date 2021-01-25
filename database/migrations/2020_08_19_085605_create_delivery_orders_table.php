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
            $table->double('quantity');
            $table->string('shipped_with');
            $table->tinyInteger('shipped_via')->nullable();
            $table->string('no_vehicles');
            $table->bigInteger('km_start')->nullable();
            $table->string('km_end')->nullable();;
            $table->string('sg_meter')->nullable();;
            $table->string('top_seal')->nullable();;
            $table->string('bottom_seal')->nullable();;
            $table->string('temperature')->nullable();;
            $table->timestamp('departure_time')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->timestamp('unloading_start_time')->nullable();
            $table->timestamp('unloading_end_time')->nullable();
            $table->timestamp('departure_time_depot')->nullable();
            $table->string('distribution')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('knowing')->nullable();
            $table->tinyInteger('status');
            $table->text('bast')->nullable();
            $table->time('estimate')->nullable();
            $table->unsignedBigInteger('sales_order_id');
            $table->foreign('sales_order_id')->references('id')->on('sales_orders')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('piece')->nullable();
            $table->string('depot')->nullable();
            $table->string('quantity_text')->nullable();
            $table->string('detail_address')->nullable();
            $table->string('transportir')->nullable();
            $table->string('address_transportir')->nullable();
            $table->string('qrcode')->nullable();
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
