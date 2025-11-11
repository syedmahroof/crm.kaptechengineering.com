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
            if (!Schema::hasColumn('leads', 'country_id')) {
                $table->foreignId('country_id')->nullable()->after('branch_id')->constrained('countries')->onDelete('set null');
            }
            if (!Schema::hasColumn('leads', 'state_id')) {
                $table->foreignId('state_id')->nullable()->after('country_id')->constrained('states')->onDelete('set null');
            }
            if (!Schema::hasColumn('leads', 'city_id')) {
                $table->foreignId('city_id')->nullable()->after('state_id')->constrained('cities')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['country_id', 'state_id', 'city_id']);
        });
    }
};
