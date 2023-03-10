<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->text('image')->nullable();
            $table->text('short_desc')->nullable();
            $table->longText('desc')->nullable();
            $table->integer('points')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('is_trending')->comment('1: yes, 0:no')->default(0);
            $table->tinyInteger('is_best_seller')->comment('1: yes, 0:no')->default(0);
            $table->tinyInteger('status')->comment('1: active, 0: inactive')->default(1);
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
        Schema::dropIfExists('reward_products');
    }
}
