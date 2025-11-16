<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reminders', function (Blueprint $table) {
            // Rename reminder_date to reminder_at
            $table->renameColumn('reminder_date', 'reminder_at');
            
            // Add missing fields
            $table->foreignId('lead_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type')->default('general');
            $table->string('priority')->default('medium');
        });
    }

    public function down()
    {
        Schema::table('reminders', function (Blueprint $table) {
            // Remove added fields
            $table->dropForeign(['lead_id']);
            $table->dropColumn(['lead_id', 'type', 'priority']);
            
            // Rename back
            $table->renameColumn('reminder_at', 'reminder_date');
        });
    }
};