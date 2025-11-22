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
        Schema::table('projects', function (Blueprint $table) {
            // Make user_id nullable
            // Note: MySQL unique constraints handle NULL values correctly (each NULL is distinct)
            $table->foreignId('user_id')->nullable()->change();
            
            // Add address field
            $table->text('address')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique(['user_id', 'name']);
        });
        
        Schema::table('projects', function (Blueprint $table) {
            // Remove address field
            $table->dropColumn('address');
            
            // Revert user_id to required (if needed)
            // Note: This might fail if there are null values
            // $table->foreignId('user_id')->nullable(false)->change();
            
            // Re-add original unique constraint
            $table->unique(['user_id', 'name']);
        });
    }
};
