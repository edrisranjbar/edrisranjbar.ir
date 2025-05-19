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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('page_type')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->string('ip_address', 45);
            $table->string('user_agent')->nullable();
            $table->string('session_id')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('device')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();
            
            $table->index(['page_type', 'page_id']);
            $table->index('ip_address');
            $table->index('session_id');
            $table->index('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
