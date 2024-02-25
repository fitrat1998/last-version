<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamHasTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_has_topic', function (Blueprint $table) {
            $table->id();

            $table->string('exams_id');

            $table->unsignedBigInteger('topics_id');
            $table->foreign('topics_id')->references('id')->on('topics');

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
        Schema::dropIfExists('exam_has_topic');
    }
}
