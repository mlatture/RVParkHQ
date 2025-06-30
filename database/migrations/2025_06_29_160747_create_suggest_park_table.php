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
        Schema::create('suggest_park', function (Blueprint $table) {
            $table->id();
            $table->string('park_name');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip')->nullable();
            $table->string('website_url')->nullable();
            $table->string('social_url')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_name');
            $table->string('user_email');
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggest_park');
    }
};
