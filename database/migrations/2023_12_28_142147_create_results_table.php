<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();

            $table->integer('users_id');
            $table->unsignedBigInteger('ball');
            $table->integer('quizzes_id');

            $table->integer('examtypes_id');

//            $table->unsignedBigInteger('examtypes_id')->nullable();
//            $table->foreign('examtypes_id')->references('id')->on('examtypes');

            $table->unsignedBigInteger('subjects_id');
            $table->foreign('subjects_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->unsignedBigInteger('semesters_id');
            $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');

            $table->string('correct');

            $table->string('incorrect');

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
        Schema::dropIfExists('results');
    }
}
