<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->create('forum_posts', function (Blueprint $table) {
            $db = DB::connection('mysql')->getDatabaseName();
            $table->id();
            $table->string('title')->nullable();
            $table->longText('body');
            $table->foreignId('forum_thread_id')->references('id')->on('forum_threads');
            $table->foreignId('user_id')->references('id')->on(new Expression($db . '.users'));
            $table->integer('numRecommends')->default(0);
            $table->enum('status',['published','draft','underreview','trash','reported'])->default('published');
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
        Schema::dropIfExists('forum_posts');
    }
}
