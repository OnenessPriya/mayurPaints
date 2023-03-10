<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrochuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brochures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('image');
            $table->string('pdf');
            $table->tinyInteger('is_current')->comment('1: active, 0: inactive')->default(1);
            $table->string('start_date');
            $table->string('end_date');
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
        Schema::dropIfExists('brochures');
    }
}
