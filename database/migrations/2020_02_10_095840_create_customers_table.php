<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('no_customer')->unique()->nullable();
            $table->enum('member',['gold','silver','platinum'])->nullable();
            $table->text('address')->nullable();
            $table->text('npwp')->nullable();
            $table->text('phone')->nullable();
            $table->text('website')->nullable();
            $table->string('logo')->default('logos/default.jpg');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('agen_id');
            $table->foreign('agen_id')->references('id')->on('agens')->onDelete('cascade');
            $table->bigInteger('reward')->default(0);
            $table->bigInteger('coupon')->default(0);
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
        Schema::dropIfExists('customers');
    }
}
