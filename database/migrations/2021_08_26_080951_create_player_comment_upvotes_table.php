<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerCommentUpvotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::connection('mysql2')->create('player_comment_upvotes', function (Blueprint $table) {
        //     $db = DB::connection('mysql')->getDatabaseName();
        //     $table->id();
        //     $table->foreignId('user_id')->references('id')->on(new Expression($db . '.users'))->onDelete('cascade');
        //     $table->foreignId('comment_id')->references('id')->on('player_comments')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_comment_upvotes');
    }
}
