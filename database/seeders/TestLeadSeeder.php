<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\LeadPriority;
use App\Models\LeadSource;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestLeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Create a test lead source if none exists
        $source = LeadSource::first();
        if (!$source) {
            $source = LeadSource::create([
                'name' => 'Website',
                'description' => 'Website Lead',
                'is_active' => true,
            ]);
        }

        // Create a test lead priority if none exists
        $priority = LeadPriority::first();
        if (!$priority) {
            $priority = LeadPriority::create([
                'name' => 'High',
                'description' => 'High Priority',
                'level' => 1,
                'color' => '#EF4444',
                'is_default' => true,
            ]);
        }

        // Create a test lead
        $lead = Lead::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'company' => 'Test Company',
            'job_title' => 'CEO',
            'website' => 'https://example.com',
            'address' => '123 Test St',
            'city' => 'Test City',
            'state' => 'Test State',
            'country' => 'Test Country',
            'postal_code' => '12345',
            'description' => 'This is a test lead',
            'status' => 'new',
            'lead_source_id' => $source->id,
            'lead_priority_id' => $priority->id,
            'assigned_user_id' => $user->id,
            'last_contacted_at' => now(),
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $this->command->info('Test lead created with ID: ' . $lead->id);
    }
}
