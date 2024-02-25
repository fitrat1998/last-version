<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentHasAttachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_has_attach', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('students_id');
            $table->foreign('students_id')->references('id')->on('students');

            $table->unsignedBigInteger('faculties_id');
            $table->foreign('faculties_id')->references('id')->on('faculties');

            $table->unsignedBigInteger('educationtypes_id');
            $table->foreign('educationtypes_id')->references('id')->on('educationtypes');


            $table->unsignedBigInteger('groups_id');
            $table->foreign('groups_id')->references('id')->on('groups');

            $table->unsignedBigInteger('educationyears_id');
            $table->foreign('educationyears_id')->references('id')->on('educationyears');

            $table->unsignedBigInteger('semesters_id');
            $table->foreign('semesters_id')->references('id')->on('semesters');

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
        Schema::dropIfExists('student_has_attach');
    }
}
