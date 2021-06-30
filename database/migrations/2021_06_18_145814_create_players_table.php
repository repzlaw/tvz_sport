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
            $table->date('birth_date');
            $table->string('country');
            $table->string('status');
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->string('role');
            $table->string('signature_hero');
            $table->string('total_earnings');
            $table->foreignId('sport_type_id')->references('id')->on('sport_types');
            $table->string('followers');
            $table->date('active_since');
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
