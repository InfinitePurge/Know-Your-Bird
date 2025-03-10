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
        Schema::create('pauksciai_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pauksciai_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('pauksciai_id')->references('id')->on('pauksciai')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pauksciai_tags');
    }
};
