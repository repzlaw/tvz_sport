<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamNewsRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_news_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->foreignId('competition_news_id')->references('id')->on('competition_news');
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
        Schema::dropIfExists('team_news_relationships');
    }
}
