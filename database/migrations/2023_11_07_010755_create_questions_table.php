<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('edited_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
