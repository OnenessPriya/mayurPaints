<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('mobile')->unique();
            $table->integer('whatsapp_no')->nullable();
            $table->integer('address')->nullable();
            $table->integer('landmark')->nullable();
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->integer('pin')->nullable();
            $table->integer('aadhar')->nullable();
            $table->integer('type')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('otp')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->string('google_id')->nullable();
            $table->integer('total_points')->nullable();
            $table->integer('status')->comment('1: active, 0: inactive')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
