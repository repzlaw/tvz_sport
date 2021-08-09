<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminFailedLoginAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_failed_login_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->references('id')->on('admins');
            $table->string('email')->nullable();
            $table->string('login_ip')->nullable();
            $table->json('browser_info')->nullable();
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
        Schema::dropIfExists('admin_failed_login_attempts');
    }
}
