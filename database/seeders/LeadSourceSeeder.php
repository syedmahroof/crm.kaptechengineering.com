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
        $sources = [
            [
                'name' => 'Website',
                'description' => 'Leads from company website forms',
                'is_active' => true,
            ],
            [
                'name' => 'Referral',
                'description' => 'Leads from customer referrals',
                'is_active' => true,
            ],
            [
                'name' => 'Social Media',
                'description' => 'Leads from social media platforms',
                'is_active' => true,
            ],
            [
                'name' => 'Email Campaign',
                'description' => 'Leads from email marketing campaigns',
                'is_active' => true,
            ],
            [
                'name' => 'Event',
                'description' => 'Leads from trade shows and events',
                'is_active' => true,
            ],
            [
                'name' => 'Cold Call',
                'description' => 'Leads from outbound calling',
                'is_active' => true,
            ],
            [
                'name' => 'Partner',
                'description' => 'Leads from business partners',
                'is_active' => true,
            ],
        ];

        foreach ($sources as $source) {
            LeadSource::updateOrCreate(
                ['name' => $source['name']],
                $source
            );
        }
    }
}
