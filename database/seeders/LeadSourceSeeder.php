<?php

namespace Database\Seeders;

use App\Models\LeadSource;
use Illuminate\Database\Seeder;

class LeadSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leadSources = [
            ['name' => 'Website', 'color_code' => '#3b82f6', 'description' => 'Leads from company website'],
            ['name' => 'Email Campaign', 'color_code' => '#8b5cf6', 'description' => 'Leads from email marketing campaigns'],
            ['name' => 'Social Media', 'color_code' => '#ec4899', 'description' => 'Leads from social media platforms'],
            ['name' => 'Phone Call', 'color_code' => '#10b981', 'description' => 'Leads from incoming phone calls'],
            ['name' => 'Walk-in', 'color_code' => '#f59e0b', 'description' => 'Walk-in customers'],
            ['name' => 'Referral', 'color_code' => '#6366f1', 'description' => 'Referred by existing customers'],
            ['name' => 'Trade Show', 'color_code' => '#14b8a6', 'description' => 'Leads from trade shows and exhibitions'],
            ['name' => 'Online Ad', 'color_code' => '#ef4444', 'description' => 'Leads from online advertisements'],
            ['name' => 'Partner', 'color_code' => '#06b6d4', 'description' => 'Leads from business partners'],
            ['name' => 'Direct Marketing', 'color_code' => '#a855f7', 'description' => 'Leads from direct marketing efforts'],
        ];

        foreach ($leadSources as $source) {
            LeadSource::firstOrCreate(
                ['name' => $source['name']],
                $source
            );
        }

        $this->command->info('Lead sources seeded successfully!');
    }
}
