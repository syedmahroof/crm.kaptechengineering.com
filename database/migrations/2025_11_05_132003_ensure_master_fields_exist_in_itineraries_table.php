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
        if (!Schema::hasTable('itineraries')) {
            return;
        }

        Schema::table('itineraries', function (Blueprint $table) {
            if (!Schema::hasColumn('itineraries', 'is_master')) {
                $table->boolean('is_master')->default(false)->after('user_id');
            }
            if (!Schema::hasColumn('itineraries', 'master_itinerary_id')) {
                $table->unsignedBigInteger('master_itinerary_id')->nullable()->after('is_master');
            }
            if (!Schema::hasColumn('itineraries', 'is_custom')) {
                $table->boolean('is_custom')->default(false)->after('master_itinerary_id');
            }
            if (!Schema::hasColumn('itineraries', 'lead_id')) {
                $table->unsignedBigInteger('lead_id')->nullable()->after('is_custom');
            }
        });

        // Add foreign key constraints separately to avoid issues
        if (Schema::hasColumn('itineraries', 'master_itinerary_id')) {
            try {
                Schema::table('itineraries', function (Blueprint $table) {
                    $table->foreign('master_itinerary_id')->references('id')->on('itineraries')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist, ignore
            }
        }
        
        if (Schema::hasColumn('itineraries', 'lead_id')) {
            try {
                Schema::table('itineraries', function (Blueprint $table) {
                    $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist, ignore
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('itineraries')) {
            return;
        }

        Schema::table('itineraries', function (Blueprint $table) {
            if (Schema::hasColumn('itineraries', 'master_itinerary_id')) {
                try {
                    $table->dropForeign(['master_itinerary_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
            }
            if (Schema::hasColumn('itineraries', 'lead_id')) {
                try {
                    $table->dropForeign(['lead_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
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
