<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update sort_order for existing statuses after Hot Lead
        DB::table('lead_statuses')
            ->where('slug', 'cold_lead')
            ->update(['sort_order' => 5]);
        
        DB::table('lead_statuses')
            ->where('slug', 'converted')
            ->update(['sort_order' => 6]);
        
        DB::table('lead_statuses')
            ->where('slug', 'lost')
            ->update(['sort_order' => 7]);

        // Insert "Convert this week" status after Hot Lead (sort_order 4)
        DB::table('lead_statuses')->insert([
            'name' => 'Convert this week',
            'slug' => 'convert_this_week',
            'color' => '#F59E0B', // Amber/Orange
            'description' => 'Lead to be converted this week',
            'is_active' => true,
            'sort_order' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the status
        DB::table('lead_statuses')
            ->where('slug', 'convert_this_week')
            ->delete();

        // Restore original sort orders
        DB::table('lead_statuses')
            ->where('slug', 'cold_lead')
            ->update(['sort_order' => 4]);
        
        DB::table('lead_statuses')
            ->where('slug', 'converted')
            ->update(['sort_order' => 5]);
        
        DB::table('lead_statuses')
            ->where('slug', 'lost')
            ->update(['sort_order' => 6]);
    }
};

