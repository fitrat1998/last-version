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
            $table->foreign('lessontypes_id')->references('id')->on('lessontypes')->onDelete('cascade');

            $table->unsignedBigInteger('teachers_id');
            $table->foreign('teachers_id')->references('id')->on('teachers')->onDelete('cascade');

            $table->unsignedBigInteger('groups_id');
            $table->foreign('groups_id')->references('id')->on('groups')->onDelete('cascade');

            $table->unsignedBigInteger('semesters_id');
            $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');

            $table->unsignedBigInteger('subjects_id');
            $table->foreign('subjects_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->unsignedBigInteger('topics_id');
            $table->foreign('topics_id')->references('id')->on('topics')->onDelete('cascade');

            $table->unsignedBigInteger('educationyears_id');
            $table->foreign('educationyears_id')->references('id')->on('educationyears')->onDelete('cascade');

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
