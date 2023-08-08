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
        Schema::create('tutorials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('price')->default(0);
            $table->integer('duration');
            $table->foreignId('tutor')->constrained('admins');
            $table->text('description')->nullable();
            $table->enum('status', ['public', 'private', 'draft'])->default('draft');
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutorial_id');
            $table->string('title');
            $table->timestamps();

            $table->foreign('tutorial_id')->references('id')->on('tutorials')->onDelete('cascade');
        });
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('tutorials');
    }
};
