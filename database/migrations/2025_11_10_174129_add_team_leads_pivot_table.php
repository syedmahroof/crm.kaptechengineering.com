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
        // Create pivot table for team leads (many-to-many)
        Schema::create('team_lead', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate entries
            $table->unique(['team_id', 'user_id']);
        });

        // Migrate existing team_lead_id to the pivot table
        DB::statement('
            INSERT INTO team_lead (team_id, user_id, created_at, updated_at)
            SELECT id, team_lead_id, NOW(), NOW()
            FROM teams
            WHERE team_lead_id IS NOT NULL
        ');

        // Drop the old team_lead_id column
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['team_lead_id']);
            $table->dropColumn('team_lead_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back team_lead_id column
        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('team_lead_id')->nullable()->constrained('users')->onDelete('set null')->after('name');
        });

        // Migrate data back (take first team lead if multiple)
        DB::statement('
            UPDATE teams t
            INNER JOIN (
                SELECT team_id, MIN(user_id) as first_lead_id
                FROM team_lead
                GROUP BY team_id
            ) tl ON t.id = tl.team_id
            SET t.team_lead_id = tl.first_lead_id
        ');

        Schema::dropIfExists('team_lead');
    }
};
