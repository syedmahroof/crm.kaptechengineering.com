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
        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->default('#6B7280'); // Default gray color
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default lead statuses
        DB::table('lead_statuses')->insert([
            [
                'name' => 'New',
                'slug' => 'new',
                'color' => '#3B82F6',
                'description' => 'Newly created lead',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Itinerary Sent',
                'slug' => 'itinerary_sent',
                'color' => '#10B981',
                'description' => 'Itinerary has been sent to the lead',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hot Lead',
                'slug' => 'hot_lead',
                'color' => '#EF4444',
                'description' => 'High priority lead with strong potential',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cold Lead',
                'slug' => 'cold_lead',
                'color' => '#6B7280',
                'description' => 'Low priority lead with minimal activity',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Converted',
                'slug' => 'converted',
                'color' => '#059669',
                'description' => 'Lead has been successfully converted to customer',
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lost',
                'slug' => 'lost',
                'color' => '#DC2626',
                'description' => 'Lead has been lost or is no longer interested',
                'is_active' => true,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_statuses');
    }
};
