<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerUserEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_user_edits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->references('id')->on('players');
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
            $table->foreignId('user_id')->references('id')->on('users');
            $table->enum('approval_status', ['approved', 'pending', 'declined'])->default('pending');
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
        Schema::dropIfExists('player_user_edits');
    }
}
