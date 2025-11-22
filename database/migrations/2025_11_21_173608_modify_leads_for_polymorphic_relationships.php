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
        // Create pivot table for lead relationships
        Schema::create('leadables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('leadable_id');
            $table->string('leadable_type');
            $table->timestamps();
            
            // Use shorter custom index names to avoid MySQL 64 character limit
            $table->index(['lead_id', 'leadable_id', 'leadable_type'], 'lead_leadable_idx');
            $table->index(['leadable_type', 'leadable_id'], 'lead_type_id_idx');
        });

        // Migrate existing project_id data to the pivot table
        if (Schema::hasTable('leads') && Schema::hasColumn('leads', 'project_id')) {
            \DB::statement('
                INSERT INTO leadables (lead_id, leadable_id, leadable_type, created_at, updated_at)
                SELECT id, project_id, "App\\\\Models\\\\Project", created_at, updated_at
                FROM leads
                WHERE project_id IS NOT NULL
            ');
        }

        // Remove the old project_id foreign key and column
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'project_id')) {
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back project_id column
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'project_id')) {
                $table->foreignId('project_id')->nullable()->after('branch_id');
            }
        });

        // Migrate data back from pivot table (only projects)
        if (Schema::hasTable('leadables')) {
            \DB::statement('
                UPDATE leads l
                INNER JOIN leadables lp ON l.id = lp.lead_id
                SET l.project_id = lp.leadable_id
                WHERE lp.leadable_type = "App\\\\Models\\\\Project"
                LIMIT 1
            ');
        }

        // Add foreign key back
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'project_id')) {
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            }
        });

        // Drop pivot table
        Schema::dropIfExists('leadables');
    }
};
