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
            $table->string('sales_rep')->nullable();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->enum('schedule', ['one-time', 'monthly', 'yearly']);
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->integer('user_id')->nullable();
            $table->string('payment_link_token')->nullable();
            $table->date('next_reminder_date')->nullable();
            $table->boolean('paid_at_creation')->default(false);
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