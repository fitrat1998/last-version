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
            $table->foreign('students_id')->references('id')->on('students')->onDelete('cascade');

            $table->unsignedBigInteger('faculties_id');
            $table->foreign('faculties_id')->references('id')->on('faculties')->onDelete('cascade');

            $table->unsignedBigInteger('educationtypes_id');
            $table->foreign('educationtypes_id')->references('id')->on('educationtypes')->onDelete('cascade');

            $table->unsignedBigInteger('groups_id');
            $table->foreign('groups_id')->references('id')->on('groups')->onDelete('cascade');

            $table->unsignedBigInteger('educationyears_id');
            $table->foreign('educationyears_id')->references('id')->on('educationyears')->onDelete('cascade');

            $table->unsignedBigInteger('semesters_id');
            $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');

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
