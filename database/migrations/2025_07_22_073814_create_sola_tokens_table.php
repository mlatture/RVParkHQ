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
        Schema::create('sola_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('token_id');
            $table->enum('payment_method_type', ['credit_card', 'ACH']);
            $table->string('last_four_digits');
            $table->date('expiry_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sola_tokens');
    }
};
