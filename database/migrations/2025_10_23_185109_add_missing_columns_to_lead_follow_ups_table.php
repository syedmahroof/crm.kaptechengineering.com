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
        Schema::table('lead_follow_ups', function (Blueprint $table) {
            $table->string('title')->after('type');
            $table->text('description')->nullable()->after('title');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->after('created_by');
            $table->dateTime('reminder_at')->nullable()->after('scheduled_at');
            $table->string('location')->nullable()->after('reminder_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_follow_ups', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'assigned_to', 'reminder_at', 'location']);
        });
    }
};
