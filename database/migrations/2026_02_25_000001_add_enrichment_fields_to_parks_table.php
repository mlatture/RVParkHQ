<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parks', function (Blueprint $table) {
            // Enrichment data (JSON blobs for flexibility)
            $table->json('rates')->nullable()->after('hours_of_operation');
            $table->json('facilities')->nullable()->after('rates');
            $table->json('site_types')->nullable()->after('facilities');
            $table->json('policies')->nullable()->after('site_types');

            // Additional enrichment fields
            $table->string('manager_name')->nullable()->after('policies');
            $table->unsignedSmallInteger('total_sites')->nullable()->after('manager_name');
            $table->decimal('acreage', 8, 2)->nullable()->after('total_sites');
            $table->string('reservation_url')->nullable()->after('acreage');
            $table->string('facebook_url')->nullable()->after('reservation_url');

            // Enrichment tracking
            $table->string('enrichment_source')->nullable()->after('facebook_url');
            $table->timestamp('enrichment_updated_at')->nullable()->after('enrichment_source');
        });
    }

    public function down(): void
    {
        Schema::table('parks', function (Blueprint $table) {
            $table->dropColumn([
                'rates', 'facilities', 'site_types', 'policies',
                'manager_name', 'total_sites', 'acreage',
                'reservation_url', 'facebook_url',
                'enrichment_source', 'enrichment_updated_at',
            ]);
        });
    }
};
