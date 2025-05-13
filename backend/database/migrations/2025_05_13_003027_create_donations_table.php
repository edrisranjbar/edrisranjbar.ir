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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('amount');
            $table->string('currency')->default('T'); // T for Toman, R for Rial
            $table->text('message')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->default('zarinpal');
            $table->string('card_number')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('ref_id')->nullable();
            $table->string('status')->default('pending'); // pending, successful, failed
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
