<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name');
            $table->string('url_slug')->unique();
            $table->date('birth_date')->nullable();
            $table->string('country')->nullable();
            $table->string('status');
            $table->longText('summary')->nullable();
            $table->string('featured_image')->nullable();
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->string('role')->nullable();
            $table->string('signature_hero')->nullable();
            $table->string('total_earnings')->nullable();
            $table->foreignId('sport_type_id')->references('id')->on('sport_types');
            $table->string('followers')->nullable();
            $table->date('active_since');
            $table->string('page_title')->nullable();
            $table->string('meta_description')->nullable();
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
        Schema::dropIfExists('players');
    }
}
