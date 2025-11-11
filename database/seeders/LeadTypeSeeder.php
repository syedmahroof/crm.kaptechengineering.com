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
            ['name' => 'Builders and Developers', 'color_code' => '#ef4444', 'description' => 'Builders and real estate developers', 'is_active' => true],
            ['name' => 'Hospitals', 'color_code' => '#f59e0b', 'description' => 'Hospital and healthcare facilities', 'is_active' => true],
            ['name' => 'MEP Consultants', 'color_code' => '#3b82f6', 'description' => 'Mechanical, Electrical, and Plumbing consultants', 'is_active' => true],
            ['name' => 'Architects', 'color_code' => '#10b981', 'description' => 'Architecture and design professionals', 'is_active' => true],
            ['name' => 'Project', 'color_code' => '#8b5cf6', 'description' => 'Project-based leads', 'is_active' => true],
            ['name' => 'Plumbing Contractors', 'color_code' => '#ec4899', 'description' => 'Plumbing installation and maintenance contractors', 'is_active' => true],
            ['name' => 'Electrical Contractors', 'color_code' => '#14b8a6', 'description' => 'Electrical installation and maintenance contractors', 'is_active' => true],
            ['name' => 'HVAC Contractors', 'color_code' => '#64748b', 'description' => 'Heating, Ventilation, and Air Conditioning contractors', 'is_active' => true],
            ['name' => 'Petrol Pump Contractors', 'color_code' => '#6b7280', 'description' => 'Petrol pump installation and maintenance contractors', 'is_active' => true],
            ['name' => 'Civil Eng. Contractors', 'color_code' => '#dc2626', 'description' => 'Civil engineering contractors', 'is_active' => true],
            ['name' => 'Fire Fighting Contractors', 'color_code' => '#ea580c', 'description' => 'Fire safety and fire fighting system contractors', 'is_active' => true],
            ['name' => 'Interior Designers', 'color_code' => '#c026d3', 'description' => 'Interior design professionals', 'is_active' => true],
            ['name' => 'Swimming pool & STP', 'color_code' => '#0284c7', 'description' => 'Swimming pool and Sewage Treatment Plant contractors', 'is_active' => true],
            ['name' => 'Biomedicals', 'color_code' => '#059669', 'description' => 'Biomedical equipment and services', 'is_active' => true],
            ['name' => 'Shop & Retail', 'color_code' => '#7c3aed', 'description' => 'Retail shops and commercial spaces', 'is_active' => true],
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
