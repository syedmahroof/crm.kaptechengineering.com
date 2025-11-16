<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Good Vacation',
                'code' => 'GV-KOCHI',
                'address' => 'South Janatha Rd, Palarivattom, Kochi, Kerala 682025, India',
                'is_active' => true,
            ],
            [
                'name' => 'Dubai',
                'code' => 'GV-DUBAI',
                'address' => 'Burjuman',
                'is_active' => true,
            ],
            [
                'name' => 'Calicut',
                'code' => 'GV-CALICUT',
                'address' => 'Calicut',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branchData) {
            Branch::updateOrCreate(
                ['code' => $branchData['code']],
                $branchData
            );
        }
    }
}
