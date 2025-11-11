<?php

namespace Database\Seeders;

use App\Models\LeadType;
use Illuminate\Database\Seeder;

class LeadTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leadTypes = [
            ['name' => 'Hot Lead', 'color_code' => '#ef4444', 'description' => 'Highly interested and ready to buy'],
            ['name' => 'Warm Lead', 'color_code' => '#f59e0b', 'description' => 'Interested but needs more information'],
            ['name' => 'Cold Lead', 'color_code' => '#3b82f6', 'description' => 'Initial contact, needs nurturing'],
            ['name' => 'New Inquiry', 'color_code' => '#10b981', 'description' => 'New customer inquiry'],
            ['name' => 'Referral', 'color_code' => '#8b5cf6', 'description' => 'Referred by existing customer'],
            ['name' => 'Returning Customer', 'color_code' => '#6366f1', 'description' => 'Previous customer returning'],
            ['name' => 'Qualified', 'color_code' => '#14b8a6', 'description' => 'Qualified lead ready for sales'],
            ['name' => 'Unqualified', 'color_code' => '#64748b', 'description' => 'Not a good fit at this time'],
            ['name' => 'General', 'color_code' => '#94a3b8', 'description' => 'General lead type'],
        ];

        foreach ($leadTypes as $type) {
            LeadType::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }

        $this->command->info('Lead types seeded successfully!');
    }
}
