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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('card_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['credit_card', 'ACH'])->default('credit_card');
            $table->timestamp('processed_at')->nullable();
            $table->enum('status', ['success', 'failed', 'duplicate'])->default('success');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
