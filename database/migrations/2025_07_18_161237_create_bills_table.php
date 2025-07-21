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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->enum('send_from', ['WebDaVinci', 'RVParkHQ']);
            $table->integer('sales_rep_id')->nullable();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->enum('schedule', ['once', 'monthly', 'yearly']);
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['draft', 'sent', 'paid'])->default('draft');
            $table->string('payment_link')->nullable();
            $table->integer('customer_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};