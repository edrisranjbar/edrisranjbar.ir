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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('seoTitle');
            $table->text('seoDescription')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->integer('order_id')->nullable();
            $table->enum('status', ['public', 'private', 'draft']);
            $table->integer('duration');
            $table->boolean('isFree')->nullable();
            $table->string('file_path')->nullable();
            $table->string('video_path')->nullable();
            $table->unsignedBigInteger('tutorial_id');
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('tutorial_id')->references('id')->on('tutorials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
