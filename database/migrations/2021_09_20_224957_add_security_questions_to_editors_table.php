<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityQuestionsToEditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editors', function (Blueprint $table) {
            $table->unsignedBigInteger('security_question_id')->nullable();
            $table->foreign('security_question_id')->references('id')->on('security_questions');
            $table->string('security_answer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editors', function (Blueprint $table) {
            //
        });
    }
}
