<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->references('id')->on('competitions');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->date('follow_date');
            $table->string('updates_enabled');
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
        Schema::dropIfExists('competition_followers');
    }
}
