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
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->integer('duration_days')->nullable();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('destination_id')->nullable()->constrained();
            
            // Status and Progress
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->json('completed_steps')->nullable();
            
            // Terms & Conditions
            $table->longText('terms_conditions')->nullable();
            $table->longText('cancellation_policy')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            
            // Inclusions & Exclusions
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');   
            
            // Master and custom itinerary fields
            $table->boolean('is_master')->default(false);
            $table->foreignId('master_itinerary_id')->nullable()->constrained('itineraries')->onDelete('cascade');
            $table->boolean('is_custom')->default(false);
            $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
