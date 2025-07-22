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
        Schema::create('user_billing_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('first_billed_date')->nullable();
            $table->date('last_billed_date')->nullable();
            $table->integer('total_bills_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_billing_details');
    }
};
