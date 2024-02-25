<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_checks', function (Blueprint $table) {
            $table->id();
            $table->boolean('absent');

            $table->unsignedBigInteger('exercises_id');
            $table->foreign('exercises_id')->references('id')->on('exercises');

            $table->unsignedBigInteger('students_id');
            $table->foreign('students_id')->references('id')->on('students');

            $table->integer('topics_id');
            $table->integer('subjects_id');

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
        Schema::dropIfExists('attendance_checks');
    }
}
