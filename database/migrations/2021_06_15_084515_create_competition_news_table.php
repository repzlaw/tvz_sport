<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->references('id')->on('competitions');
            $table->string('headline');
            $table->longText('content');
            $table->string('url_slug');
            $table->foreignId('posted_by')->references('id')->on('users');
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
        Schema::dropIfExists('competition_news');
    }
}
