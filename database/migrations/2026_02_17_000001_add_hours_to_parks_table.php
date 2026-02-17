<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parks', function (Blueprint $table) {
            $table->json('hours_of_operation')->nullable()->after('google_review_count');
            $table->unsignedSmallInteger('quality_score')->default(0)->after('hours_of_operation');
        });
    }

    public function down(): void
    {
        Schema::table('parks', function (Blueprint $table) {
            $table->dropColumn(['hours_of_operation', 'quality_score']);
        });
    }
};
