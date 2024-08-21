<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizHasDurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_has_duration', function (Blueprint $table) {
           $table->id();
            $table->bigInteger('quiz_id')->unsigned();
            $table->integer('duration');
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('middleexams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_has_duration');
    }
}
