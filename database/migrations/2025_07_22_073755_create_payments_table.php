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
        $table->integer('bill_id');
        $table->decimal('amount', 10, 2);
        $table->enum('payment_method', ['credit_card', 'ACH']);
        $table->string('sola_transaction_id');
        $table->string('sola_payment_token');
        $table->timestamp('processed_at');
        $table->enum('status', ['success', 'failed']);
        $table->string('processed_by_admin');
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
