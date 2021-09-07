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
            $table->foreignId('sport_type_id')->references('id')->on('sport_types');
            $table->string('headline');
            $table->longText('content');
            $table->string('url_slug')->unique();
            $table->string('page_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->foreignId('posted_by')->references('id')->on('editors');
            $table->enum('enable_comment',['1','0'])->default('1');
            $table->integer('comment_count')->default(0);
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
