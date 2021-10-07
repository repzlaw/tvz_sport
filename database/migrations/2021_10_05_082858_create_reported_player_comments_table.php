<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportedPlayerCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('reported_player_comments', function (Blueprint $table) {
            $db = DB::connection('mysql')->getDatabaseName();
            $table->id();
            $table->foreignId('comment_id')->references('id')->on('player_comments')->onDelete('cascade');
            $table->foreignId('policy_id')->references('id')->on(new Expression($db . '.ban_policies'))->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on(new Expression($db . '.users'))->onDelete('cascade');
            $table->string('user_notes');
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
        Schema::dropIfExists('reported_player_comments');
    }
}
