<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditorFailedLoginAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editor_failed_login_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('editor_id')->references('id')->on('editors');
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
        Schema::dropIfExists('editor_failed_login_attempts');
    }
}
