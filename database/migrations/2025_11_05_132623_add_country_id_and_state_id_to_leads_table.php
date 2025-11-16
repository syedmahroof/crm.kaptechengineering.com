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
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'state_id')) {
                $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');
            }
            if (!Schema::hasColumn('leads', 'country_id')) {
                $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            }
        });

        // Add indexes for better query performance
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'state_id') && !Schema::hasColumn('leads', 'leads_state_id_index')) {
                try {
                    $table->index('state_id');
                } catch (\Exception $e) {
                    // Index might already exist
                }
            }
            if (Schema::hasColumn('leads', 'country_id') && !Schema::hasColumn('leads', 'leads_country_id_index')) {
                try {
                    $table->index('country_id');
                } catch (\Exception $e) {
                    // Index might already exist
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'state_id')) {
                try {
                    $table->dropForeign(['state_id']);
                    $table->dropIndex(['state_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key or index doesn't exist
                }
                $table->dropColumn('state_id');
            }
            if (Schema::hasColumn('leads', 'country_id')) {
                try {
                    $table->dropForeign(['country_id']);
                    $table->dropIndex(['country_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key or index doesn't exist
                }
                $table->dropColumn('country_id');
            }
        });
    }
};
