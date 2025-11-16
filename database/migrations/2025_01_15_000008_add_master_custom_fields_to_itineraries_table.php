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
        if (!Schema::hasTable('itineraries')) {
            return; // Table doesn't exist yet, skip this migration
        }

        Schema::table('itineraries', function (Blueprint $table) {
            if (!Schema::hasColumn('itineraries', 'is_master')) {
                $table->boolean('is_master')->default(false)->after('user_id');
            }
            if (!Schema::hasColumn('itineraries', 'master_itinerary_id')) {
                $table->foreignId('master_itinerary_id')->nullable()->constrained('itineraries')->onDelete('cascade')->after('is_master');
            }
            if (!Schema::hasColumn('itineraries', 'is_custom')) {
                $table->boolean('is_custom')->default(false)->after('master_itinerary_id');
            }
            if (!Schema::hasColumn('itineraries', 'lead_id')) {
                $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('cascade')->after('is_custom');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('itineraries')) {
            return; // Table doesn't exist, nothing to rollback
        }

        Schema::table('itineraries', function (Blueprint $table) {
            if (Schema::hasColumn('itineraries', 'master_itinerary_id')) {
                $table->dropForeign(['master_itinerary_id']);
            }
            if (Schema::hasColumn('itineraries', 'lead_id')) {
                $table->dropForeign(['lead_id']);
            }
            
            $columnsToDrop = [];
            if (Schema::hasColumn('itineraries', 'is_master')) {
                $columnsToDrop[] = 'is_master';
            }
            if (Schema::hasColumn('itineraries', 'master_itinerary_id')) {
                $columnsToDrop[] = 'master_itinerary_id';
            }
            if (Schema::hasColumn('itineraries', 'is_custom')) {
                $columnsToDrop[] = 'is_custom';
            }
            if (Schema::hasColumn('itineraries', 'lead_id')) {
                $columnsToDrop[] = 'lead_id';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
