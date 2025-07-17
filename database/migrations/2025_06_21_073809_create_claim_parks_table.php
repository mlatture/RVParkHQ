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
        Schema::create('claim_parks', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_role', 100)->nullable();
            $table->boolean('is_owner_or_manager')->default(false);
            $table->unsignedBigInteger('park_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('booking_url', 255)->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->unsignedInteger('sites_50amp_full')->default(0);
            $table->unsignedInteger('sites_30amp_full')->default(0);
            $table->unsignedInteger('sites_30amp_water_electric')->default(0);
            $table->unsignedInteger('sites_50amp_water_electric')->default(0);
            $table->unsignedInteger('sites_30amp_electric')->default(0);
            $table->unsignedInteger('sites_50amp_electric')->default(0);
            $table->unsignedInteger('sites_dry_camping')->default(0);
            $table->unsignedInteger('tent_sites_utilities')->default(0);
            $table->unsignedInteger('tent_sites_primitive')->default(0);
            $table->unsignedInteger('seasonal_sites')->default(0);
            $table->unsignedInteger('group_campsites')->default(0);
            $table->unsignedInteger('deluxe_cabins')->default(0);
            $table->unsignedInteger('primitive_cabins')->default(0);
            $table->unsignedInteger('yurts_glamping')->default(0);
            $table->text('other_rentals')->nullable();
            $table->unsignedInteger('boat_slips')->default(0);
            $table->boolean('canoe_kayak_rental')->default(false);
            $table->boolean('paddle_boats')->default(false);
            $table->boolean('boat_ramp')->default(false);
            $table->boolean('fishing_available')->default(false);
            $table->string('reservation_provider', 100)->nullable();
            $table->boolean('happy_with_provider')->nullable();
            $table->boolean('contact_about_reservation')->default(false);
            $table->json('amenities')->nullable()->comment('JSON array of amenity names');
            $table->json('images')->nullable()->comment('JSON array of image paths and metadata');
            $table->string('logo_path')->nullable()->comment('Main logo image path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('park_id')
                ->references('id')
                ->on('parks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_parks');
    }
};