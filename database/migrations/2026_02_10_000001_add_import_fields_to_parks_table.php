<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parks', function (Blueprint $table) {
            $table->enum('park_type', [
                'private', 'federal_nps', 'federal_forest', 'federal_blm',
                'federal_corps', 'state_park', 'county', 'harvest_host', 'other'
            ])->default('private')->after('status');
            $table->string('data_source')->nullable()->after('park_type');
            $table->unsignedBigInteger('osm_id')->nullable()->unique()->after('data_source');
            $table->string('google_place_id')->nullable()->after('osm_id');
            $table->decimal('google_rating', 2, 1)->nullable()->after('google_place_id');
            $table->unsignedInteger('google_review_count')->nullable()->after('google_rating');
            $table->timestamp('last_enriched_at')->nullable()->after('google_review_count');
            $table->timestamp('last_verified_at')->nullable()->after('last_enriched_at');
            $table->boolean('is_claimed')->default(false)->after('last_verified_at');
            $table->string('owner_email')->nullable()->after('is_claimed');
            $table->string('owner_phone')->nullable()->after('owner_email');
        });
    }

    public function down(): void
    {
        Schema::table('parks', function (Blueprint $table) {
            $table->dropColumn([
                'park_type', 'data_source', 'osm_id', 'google_place_id',
                'google_rating', 'google_review_count', 'last_enriched_at',
                'last_verified_at', 'is_claimed', 'owner_email', 'owner_phone',
            ]);
        });
    }
};
