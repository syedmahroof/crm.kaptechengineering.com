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
        // Create pivot table for visit report relationships
        Schema::create('visit_reportables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_report_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('visit_reportable_id');
            $table->string('visit_reportable_type');
            $table->timestamps();
            
            // Use shorter custom index names to avoid MySQL 64 character limit
            $table->index(['visit_report_id', 'visit_reportable_id', 'visit_reportable_type'], 'vr_reportable_idx');
            $table->index(['visit_reportable_type', 'visit_reportable_id'], 'vr_type_id_idx');
        });

        // Migrate existing project_id data to the pivot table
        if (Schema::hasTable('visit_reports') && Schema::hasColumn('visit_reports', 'project_id')) {
            \DB::statement('
                INSERT INTO visit_reportables (visit_report_id, visit_reportable_id, visit_reportable_type, created_at, updated_at)
                SELECT id, project_id, "App\\\\Models\\\\Project", created_at, updated_at
                FROM visit_reports
                WHERE project_id IS NOT NULL
            ');
        }

        // Remove the old project_id foreign key and column
        Schema::table('visit_reports', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
            $table->dropIndex(['project_id', 'visit_date']);
            $table->index('visit_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back project_id column
        Schema::table('visit_reports', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->after('user_id');
        });

        // Migrate data back from pivot table (only projects)
        if (Schema::hasTable('visit_reportables')) {
            \DB::statement('
                UPDATE visit_reports vr
                INNER JOIN visit_reportables vrp ON vr.id = vrp.visit_report_id
                SET vr.project_id = vrp.visit_reportable_id
                WHERE vrp.visit_reportable_type = "App\\\\Models\\\\Project"
                LIMIT 1
            ');
        }

        // Add foreign key and index back
        Schema::table('visit_reports', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->index(['project_id', 'visit_date']);
        });

        // Drop pivot table
        Schema::dropIfExists('visit_reportables');
    }
};
