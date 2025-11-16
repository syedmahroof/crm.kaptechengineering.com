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
        // Add indexes for reminders table
        Schema::table('reminders', function (Blueprint $table) {
            $table->index(['user_id', 'is_completed', 'reminder_at'], 'reminders_user_completed_date_idx');
        });

        // Add indexes for tasks table
        Schema::table('tasks', function (Blueprint $table) {
            $table->index(['assigned_to', 'status', 'due_date'], 'tasks_assigned_status_date_idx');
        });

        // Add indexes for lead_follow_ups table
        Schema::table('lead_follow_ups', function (Blueprint $table) {
            $table->index(['status', 'scheduled_at'], 'follow_ups_status_scheduled_idx');
            $table->index(['assigned_to', 'status', 'scheduled_at'], 'follow_ups_assigned_status_scheduled_idx');
            $table->index(['created_by', 'status', 'scheduled_at'], 'follow_ups_created_status_scheduled_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            $table->dropIndex('reminders_user_completed_date_idx');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_assigned_status_date_idx');
        });

        Schema::table('lead_follow_ups', function (Blueprint $table) {
            $table->dropIndex('follow_ups_status_scheduled_idx');
            $table->dropIndex('follow_ups_assigned_status_scheduled_idx');
            $table->dropIndex('follow_ups_created_status_scheduled_idx');
        });
    }
};
