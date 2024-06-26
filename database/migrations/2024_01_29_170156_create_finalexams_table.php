<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalexamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finalexams', function (Blueprint $table) {
            $table->id();
            $table->integer('number');

            $table->integer('user_id')->nullable();

            $table->string('limit')->nullable();

            $table->unsignedBigInteger('examtypes_id')->nullable();
            $table->foreign('examtypes_id')->references('id')->on('examtypes')->onDelete('cascade');

            $table->unsignedBigInteger('subjects_id');
            $table->foreign('subjects_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->unsignedBigInteger('groups_id');
            $table->foreign('groups_id')->references('id')->on('groups')->onDelete('cascade');

            $table->unsignedBigInteger('semesters_id');
            $table->foreign('semesters_id')->references('id')->on('semesters')->onDelete('cascade');

            $table->integer('attempts')->nullable();

            $table->integer('passing')->nullable();

            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
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
        Schema::dropIfExists('finalexams');
    }
}
