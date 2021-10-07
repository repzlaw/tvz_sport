<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql3')->create('reported_posts', function (Blueprint $table) {
            $db = DB::connection('mysql')->getDatabaseName();
            $table->id();
            $table->foreignId('post_id')->references('id')->on('forum_posts')->onDelete('cascade');
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
        Schema::dropIfExists('reported_posts');
    }
}
