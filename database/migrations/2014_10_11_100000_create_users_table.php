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
            $table->id();
            $table->string('uuid')->unique();
            $table->string('username')->unique();
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->enum('status',['active','banned'])->default('active');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->dateTime('two_factor_expiry')->nullable();
            $table->date('ban_date')->nullable();
            $table->time('ban_time')->nullable();
            $table->date('ban_till')->nullable();
            $table->foreignId('policy_id')->nullable()->references('id')->on('ban_policies');
            $table->foreignId('role_id')->nullable()->references('id')->on('user_roles');
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
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
