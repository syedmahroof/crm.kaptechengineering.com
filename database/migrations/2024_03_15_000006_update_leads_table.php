<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Add new columns
            $table->string('company')->nullable()->after('phone');
            $table->string('job_title')->nullable()->after('company');
            $table->string('website')->nullable()->after('job_title');
            $table->text('address')->nullable()->after('website');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('postal_code', 20)->nullable()->after('country');
            $table->text('description')->nullable()->after('status');
            
            // Foreign keys
            $table->foreignId('lead_source_id')->nullable()->constrained('lead_sources')->after('description');
            $table->foreignId('lead_priority_id')->nullable()->constrained('lead_priorities')->after('lead_source_id');
            $table->foreignId('lead_agent_id')->nullable()->constrained('lead_agents')->after('lead_priority_id');
            
            // Timestamps
            $table->timestamp('last_contacted_at')->nullable()->after('lead_agent_id');
            $table->timestamp('converted_at')->nullable()->after('last_contacted_at');
            $table->text('lost_reason')->nullable()->after('converted_at');
            $table->timestamp('lost_at')->nullable()->after('lost_reason');
            
            // User tracking
            $table->foreignId('created_by')->nullable()->constrained('users')->after('lost_at');
            $table->foreignId('updated_by')->nullable()->constrained('users')->after('created_by');
            
            // Make email non-unique since we might have multiple leads with the same email
            $table->dropUnique('leads_email_unique');
            
            // Add index for better query performance
            $table->index('status');
            $table->index('lead_source_id');
            $table->index('lead_priority_id');
            $table->index('lead_agent_id');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['lead_source_id']);
            $table->dropForeign(['lead_priority_id']);
            $table->dropForeign(['lead_agent_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            
            // Drop indexes
            $table->dropIndex(['status']);
            $table->dropIndex(['lead_source_id']);
            $table->dropIndex(['lead_priority_id']);
            $table->dropIndex(['lead_agent_id']);
            $table->dropIndex(['created_by']);
            
            // Drop columns
            $table->dropColumn([
                'company',
                'job_title',
                'website',
                'address',
                'city',
                'state',
                'country',
                'postal_code',
                'description',
                'lead_source_id',
                'lead_priority_id',
                'lead_agent_id',
                'last_contacted_at',
                'converted_at',
                'lost_reason',
                'lost_at',
                'created_by',
                'updated_by',
            ]);
            
            // Restore email unique constraint
            $table->unique('email');
        });
    }
};
