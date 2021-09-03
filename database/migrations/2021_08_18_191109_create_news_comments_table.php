<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('news_comments', function (Blueprint $table) {
            $db = DB::connection('mysql')->getDatabaseName();
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('competition_news_id')->references('id')->on(new Expression($db . '.competition_news'));
            $table->integer('parent_comment_id')->nullable();
            $table->foreignId('user_id')->references('id')->on(new Expression($db . '.users'));
            $table->longText('content');
            $table->enum('language',['English','Portuguese','Spanish','Russian'])->default('English');
            $table->enum('status',['blocked','visible'])->default('visible');
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
        Schema::dropIfExists('news_comments');
    }
}
