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
        // 회원
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 32);
            $table->string('email', 256)->unique();
            $table->string('password', 64);
            $table->tinyInteger('grade');
            $table->timestamps();
        });

        // 상품
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_register');
            $table->string('title', 255);
            $table->unsignedInteger('price');
            $table->unsignedInteger('inventory');
            $table->timestamps();

            $table->foreign('user_register')->references('id')->on('users');
        });

        // 주문
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_buy');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('amt');
            $table->text('requirements');
            $table->timestamps();

            $table->foreign('user_buy')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });

        // 수수료(회원과 주문/상품간 1:1 다형성 관계)
        Schema::create('fees', function (Blueprint $table) {
            $table->id('id');
            $table->string('memo', 256);
            $table->unsignedInteger('amt');
            $table->unsignedBigInteger('billed_id');
            $table->string('billed_type', 64);
            $table->timestamps();
        });

        // 스케쥴러 테스트
        Schema::create('scheduled', function (Blueprint $table) {
            $table->id('id');
            $table->string('memo', 256);
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
        Schema::dropIfExists('fees');
        Schema::dropIfExists('scheduled');
    }
}
