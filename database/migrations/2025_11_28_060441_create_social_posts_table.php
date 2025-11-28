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
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_id')->nullable();   // Flow tenant_id
            $table->string('tenant_name')->nullable();             // For display
            $table->string('tenant_domain')->nullable();           // e.g. https://www.kayuta.com

            $table->unsignedBigInteger('idea_id')->nullable();     // ContentIdea id from Flow
            $table->string('article_url');                         // book.<park>.com article URL

            $table->json('variants');                              // social variants[]
            $table->json('media')->nullable();                     // media[]

            $table->string('status')->default('pending');          // pending, scheduled, sent, failed
            $table->timestamp('scheduled_for')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_posts');
    }
};
