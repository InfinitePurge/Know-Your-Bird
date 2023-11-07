<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wrong_answers', function (Blueprint $table) {
            $table->id('WrongAnswerID');
            $table->unsignedBigInteger('QuestionID');
            $table->string('AnswerText');
            $table->timestamps();

            $table->foreign('QuestionID')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wrong_answers');
    }
};
