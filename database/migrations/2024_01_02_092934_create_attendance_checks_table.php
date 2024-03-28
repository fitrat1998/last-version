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
            $table->foreign('exercises_id')->references('id')->on('exercises')->onDelete('cascade');

            $table->unsignedBigInteger('students_id');
            $table->foreign('students_id')->references('id')->on('students')->onDelete('cascade');

            $table->unsignedBigInteger('topics_id');
            $table->foreign('topics_id')->references('id')->on('topics')->onDelete('cascade');

            $table->unsignedBigInteger('subjects_id');
            $table->foreign('subjects_id')->references('id')->on('subjects')->onDelete('cascade');

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
