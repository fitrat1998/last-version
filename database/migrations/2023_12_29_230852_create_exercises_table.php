<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->string('date');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('lessontypes_id');
            $table->foreign('lessontypes_id')->references('id')->on('lessontypes');

            $table->unsignedBigInteger('teachers_id');
            $table->foreign('teachers_id')->references('id')->on('teachers');

            $table->unsignedBigInteger('groups_id');
            $table->foreign('groups_id')->references('id')->on('groups');

            $table->unsignedBigInteger('semesters_id');
            $table->foreign('semesters_id')->references('id')->on('semesters');

            $table->unsignedBigInteger('subjects_id');
            $table->foreign('subjects_id')->references('id')->on('subjects');

            $table->unsignedBigInteger('topics_id');
            $table->foreign('topics_id')->references('id')->on('topics');

            $table->unsignedBigInteger('educationyears_id');
            $table->foreign('educationyears_id')->references('id')->on('educationyears');

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
        Schema::dropIfExists('exercises');
    }
}
