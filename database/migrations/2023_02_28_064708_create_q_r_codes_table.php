<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQRCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_r_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('generate_number')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->integer('points')->nullable();
            $table->integer('max_time_of_use')->nullable();
            $table->integer('max_time_one_can_use')->nullable();
            $table->integer('no_of_usage')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('status')->comment('0:inactive,1:active');
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
        Schema::dropIfExists('q_r_codes');
    }
}
