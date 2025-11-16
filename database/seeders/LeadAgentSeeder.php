<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LeadAgent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first 5 users to make them lead agents
        $users = User::limit(5)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        // Create lead agents
        foreach ($users as $index => $user) {
            // Check if agent already exists
            $agent = LeadAgent::where('user_id', $user->id)->first();
            
            if (!$agent) {
                // Create new lead agent
                $agent = LeadAgent::create([
                    'user_id' => $user->id,
                    'is_active' => true,
                    'leads_count' => 0,
                    'converted_leads_count' => 0,
                ]);
            }
            
            // Update user's role to 'agent' if not already set
            if (!$user->hasRole('agent')) {
                $user->assignRole('agent');
            }
        }
        
        $this->command->info('Lead agents seeded successfully!');
    }
}
