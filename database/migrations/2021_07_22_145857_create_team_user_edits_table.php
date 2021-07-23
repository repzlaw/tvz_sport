<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamUserEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_user_edits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->string('team_name');
            $table->string('url_slug')->unique();
            $table->foreignId('sport_type_id')->references('id')->on('sport_types');
            $table->longText('summary')->nullable();
            $table->string('featured_image')->nullable();
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
        Schema::dropIfExists('team_user_edits');
    }
}
