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
        Schema::table('suggest_park', function (Blueprint $table) {
            $table->enum('submitted_by',['park_owner', 'guest', 'other'])->default('guest');
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->longText('description')->nullable();
            $table->string('country')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suggest_park', function (Blueprint $table) {
            $table->dropColumn(['submitted_by', 'address_line_1', 'address_line_2', 'description', 'country']);
        });
    }
};