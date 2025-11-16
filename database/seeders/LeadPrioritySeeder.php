<?php

namespace Database\Seeders;

use App\Models\LeadPriority;
use Illuminate\Database\Seeder;

class LeadPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [
                'name' => 'Urgent',
                'description' => 'Highest priority - requires immediate attention',
                'level' => 1,
                'color' => '#EF4444', // Red
                'is_default' => false,
            ],
            [
                'name' => 'High',
                'description' => 'High priority - important to address soon',
                'level' => 2,
                'color' => '#F59E0B', // Amber
                'is_default' => false,
            ],
            [
                'name' => 'Medium',
                'description' => 'Standard priority - normal attention',
                'level' => 3,
                'color' => '#3B82F6', // Blue
                'is_default' => true, // This will be the default priority
            ],
            [
                'name' => 'Low',
                'description' => 'Low priority - can be addressed later',
                'level' => 4,
                'color' => '#6B7280', // Gray
                'is_default' => false,
            ],
        ];

        // First, reset any existing default
        LeadPriority::where('is_default', true)->update(['is_default' => false]);

        foreach ($priorities as $priority) {
            // Check if priority exists by name
            $existing = LeadPriority::where('name', $priority['name'])->first();
            
            if ($existing) {
                // Update existing priority
                $existing->update($priority);
            } else {
                // Create new priority
                LeadPriority::create($priority);
            }
        }
    }
}
