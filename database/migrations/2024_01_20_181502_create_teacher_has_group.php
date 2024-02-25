<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherHasGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_has_group', function (Blueprint $table) {
            $table->id();

            $table->string('teachers_id');

             $table->unsignedBigInteger('faculties_id');
            $table->foreign('faculties_id')->references('id')->on('faculties');

            $table->unsignedBigInteger('groups_id');
            $table->foreign('groups_id')->references('id')->on('groups');


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
        Schema::dropIfExists('teacher_has_group');
    }
}
