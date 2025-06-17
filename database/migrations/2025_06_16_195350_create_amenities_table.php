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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('amenity');
            $table->enum('category', [
                'Water & Recreation',
                'Sports & Games',
                'Convenience & Comfort',
                'Experiences & Events',
                'Kid & Family Friendly',
                'Other Features',
            ]);
            $table->string('blackicon')->nullable();
            $table->string('whiteicon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
