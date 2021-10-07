<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->create('forum_threads', function (Blueprint $table) {
            $db = DB::connection('mysql')->getDatabaseName();
            $table->id();
            $table->string('title');
            $table->longText('body');
            $table->foreignId('user_id')->references('id')->on(new Expression($db . '.users'));
            $table->string('url_slug')->unique();
            $table->foreignId('forum_category_id')->references('id')->on('forum_categories');
            $table->enum('status',['published','draft','underreview','trash','reported'])->default('published');
            $table->integer('numRecommends')->default(0);
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
        Schema::dropIfExists('forum_threads');
    }
}
