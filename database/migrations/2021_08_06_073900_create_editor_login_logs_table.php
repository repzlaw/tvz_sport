<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditorLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editor_login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('editor_id')->references('id')->on('editors');
            $table->enum('action',['login','logout'])->default('login');
            $table->string('last_login_ip')->nullable();
            $table->string('session_id')->nullable();
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
        Schema::dropIfExists('editor_login_logs');
    }
}
