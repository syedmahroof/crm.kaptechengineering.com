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
        Schema::table('tasks', function (Blueprint $table) {
            // Add project/category support
            $table->string('project')->nullable()->after('title');
            $table->string('category')->nullable()->after('project');
            
            // Enhanced status with Kanban columns
            $table->string('status')->default('todo')->change(); // todo, in_progress, hold, review, done
            
            // Enhanced priority with more levels
            $table->string('priority')->default('medium')->change(); // low, medium, high, urgent
            
            // Add tags for better organization
            $table->json('tags')->nullable()->after('priority');
            
            // Add effort estimation
            $table->integer('story_points')->nullable()->after('tags');
            $table->string('estimated_hours')->nullable()->after('story_points');
            
            // Add more date tracking
            $table->dateTime('started_at')->nullable()->after('due_date');
            $table->dateTime('reviewed_at')->nullable()->after('started_at');
            
            // Add attachments support
            $table->json('attachments')->nullable()->after('reviewed_at');
            
            // Add comments/notes
            $table->text('notes')->nullable()->after('attachments');
            
            // Add color coding for visual organization
            $table->string('color')->nullable()->after('notes');
            
            // Add position for drag-and-drop ordering
            $table->integer('position')->default(0)->after('color');
            
            // Add parent-child relationship for subtasks
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks')->after('position');
            
            // Add deadline type
            $table->string('deadline_type')->default('due_date')->after('parent_task_id'); // due_date, start_date, milestone
            
            // Add visibility
            $table->boolean('is_public')->default(true)->after('deadline_type');
            
            // Add completion percentage
            $table->integer('completion_percentage')->default(0)->after('is_public');
        });

        // Create indexes for better performance
        Schema::table('tasks', function (Blueprint $table) {
            $table->index(['status', 'assigned_to']);
            $table->index(['project', 'status']);
            $table->index(['priority', 'due_date']);
            $table->index(['created_by', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['parent_task_id']);
            $table->dropIndex(['status', 'assigned_to']);
            $table->dropIndex(['project', 'status']);
            $table->dropIndex(['priority', 'due_date']);
            $table->dropIndex(['created_by', 'status']);
            
            $table->dropColumn([
                'project',
                'category',
                'tags',
                'story_points',
                'estimated_hours',
                'started_at',
                'reviewed_at',
                'attachments',
                'notes',
                'color',
                'position',
                'parent_task_id',
                'deadline_type',
                'is_public',
                'completion_percentage'
            ]);
        });
    }
};

