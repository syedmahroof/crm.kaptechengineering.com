<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'New', 'color_code' => '#17a2b8'],
            ['name' => 'Quotation Sent', 'color_code' => '#fd7e14'],
            ['name' => 'Follow-Up', 'color_code' => '#ffc107'],
            ['name' => 'Won', 'color_code' => '#28a745'],
            ['name' => 'Lost', 'color_code' => '#dc3545'],
            ['name' => 'On Hold', 'color_code' => '#6c757d'],
        ];

        foreach ($statuses as $status) {
            LeadStatus::create($status);
        }

        $this->command->info('Lead statuses created successfully!');
    }
}
