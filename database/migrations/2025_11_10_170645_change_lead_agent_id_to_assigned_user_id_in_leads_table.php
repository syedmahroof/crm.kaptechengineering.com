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
        Schema::table('leads', function (Blueprint $table) {
            // Drop the old foreign key and index
            $table->dropForeign(['lead_agent_id']);
            $table->dropIndex(['lead_agent_id']);
        });

        // Rename the column
        DB::statement('ALTER TABLE leads CHANGE lead_agent_id assigned_user_id BIGINT UNSIGNED NULL');

        Schema::table('leads', function (Blueprint $table) {
            // Add new foreign key to users table
            $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
            // Add index for better query performance
            $table->index('assigned_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Drop the new foreign key and index
            $table->dropForeign(['assigned_user_id']);
            $table->dropIndex(['assigned_user_id']);
        });

        // Rename the column back
        DB::statement('ALTER TABLE leads CHANGE assigned_user_id lead_agent_id BIGINT UNSIGNED NULL');

        Schema::table('leads', function (Blueprint $table) {
            // Restore the old foreign key to lead_agents table
            $table->foreign('lead_agent_id')->references('id')->on('lead_agents')->onDelete('set null');
            // Restore index
            $table->index('lead_agent_id');
        });
    }
};
