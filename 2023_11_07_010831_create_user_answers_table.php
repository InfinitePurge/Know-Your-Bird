<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('QuestionID');
            $table->unsignedBigInteger('SelectedAnswerID');
            $table->boolean('IsCorrect');
            $table->timestamps();

            $table->foreign('UserID')->references('id')->on('users');
            $table->foreign('QuestionID')->references('id')->on('questions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
