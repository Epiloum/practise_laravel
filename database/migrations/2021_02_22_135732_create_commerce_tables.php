<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommerceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('no');
            $table->string('name', 32);
            $table->string('email', 256)->unique();
            $table->string('password', 64);
            $table->tinyInteger('grade');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id('no');
            $table->unsignedBigInteger('user_register');
            $table->string('title', 255);
            $table->unsignedInteger('price');
            $table->unsignedInteger('inventory');
            $table->timestamps();

            $table->foreign('user_register')->references('no')->on('users');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id('no');
            $table->unsignedBigInteger('user_buy');
            $table->unsignedBigInteger('product_no');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('amt');
            $table->text('requirements');
            $table->timestamps();

            $table->foreign('user_buy')->references('no')->on('users');
            $table->foreign('product_no')->references('no')->on('products');
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
    }
}
