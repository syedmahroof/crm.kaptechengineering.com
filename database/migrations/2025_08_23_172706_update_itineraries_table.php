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
            if (!Schema::hasColumn('itineraries', 'start_date')) {
                $table->date('start_date')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('itineraries', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('itineraries', 'status')) {
                $table->string('status', 20)->default('draft')->after('is_public');
            }
            
            // Only try to modify description if it exists and is not already text
            if (Schema::hasColumn('itineraries', 'description')) {
                $table->text('description')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itineraries', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('itineraries', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('itineraries', 'end_date')) {
                $table->dropColumn('end_date');
            }
            if (Schema::hasColumn('itineraries', 'status')) {
                $table->dropColumn('status');
            }
            
            // Revert description to string if it exists
            if (Schema::hasColumn('itineraries', 'description')) {
                $table->string('description')->change();
            }
        });
    }
};
