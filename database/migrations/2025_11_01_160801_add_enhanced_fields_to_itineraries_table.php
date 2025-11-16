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
        Schema::table('itineraries', function (Blueprint $table) {
            // Travel information
            $table->integer('adult_count')->nullable()->after('duration_days');
            $table->integer('child_count')->nullable()->after('adult_count');
            $table->integer('infant_count')->nullable()->after('child_count');
            $table->string('hotel_category')->nullable()->after('infant_count');
            $table->string('vehicle_type')->nullable()->after('hotel_category');
            
            // Images
            $table->string('cover_image')->nullable()->after('vehicle_type');
            $table->string('og_image')->nullable()->after('cover_image');
            
            // SEO
            $table->string('slug')->nullable()->unique()->after('og_image');
        });
        
        // Add fields to itinerary_days for meals and media
        Schema::table('itinerary_days', function (Blueprint $table) {
            $table->json('meals')->nullable()->after('description'); // ['breakfast', 'lunch', 'dinner']
            $table->json('images')->nullable()->after('meals');
            $table->json('videos')->nullable()->after('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itinerary_days', function (Blueprint $table) {
            $table->dropColumn(['meals', 'images', 'videos']);
        });
        
        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropColumn([
                'adult_count',
                'child_count',
                'infant_count',
                'hotel_category',
                'vehicle_type',
                'cover_image',
                'og_image',
                'slug',
            ]);
        });
    }
};
