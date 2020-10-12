<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_agen')->unique()->nullable();
            $table->string('name');
            $table->text('address')->nullable();
            $table->text('npwp')->nullable();
            $table->text('phone')->nullable();
            $table->text('website')->nullable();
            $table->string('logo')->default('logos/default.jpg');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('agens');
    }
}
