<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Diagnose;
use Carbon\Carbon;

class InventoryAndDiagnoseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test inventories
        $inventories = [
            [
                'imei' => '123456789012346',
                'status' => 'available',
            ],
            [
                'imei' => '987654321098766',
                'status' => 'available',
            ],
            [
                'imei' => '456789123456790',
                'status' => 'available',
            ],
        ];

        foreach ($inventories as $inventoryData) {
            $inventory = Inventory::create($inventoryData);

            // Create multiple diagnoses for each inventory
            $diagnoses = [
                [
                    'status' => 'completed',
                    'notes' => 'Initial diagnostic test completed successfully',
                    'result_data' => json_encode([
                        'battery_health' => '95%',
                        'screen_test' => 'passed',
                        'touch_test' => 'passed',
                        'camera_test' => 'passed',
                    ]),
                    'started_at' => Carbon::now()->subHours(2),
                    'ended_at' => Carbon::now()->subHours(1),
                ],
                [
                    'status' => 'in_progress',
                    'notes' => 'Running deep diagnostic scan',
                    'result_data' => json_encode([
                        'battery_health' => '92%',
                        'screen_test' => 'in_progress',
                        'touch_test' => 'passed',
                        'camera_test' => 'pending',
                    ]),
                    'started_at' => Carbon::now()->subMinutes(30),
                    'ended_at' => null,
                ],
                [
                    'status' => 'pending',
                    'notes' => 'Scheduled for tomorrow',
                    'result_data' => null,
                    'started_at' => null,
                    'ended_at' => null,
                ],
            ];

            foreach ($diagnoses as $diagnoseData) {
                Diagnose::create(array_merge(
                    $diagnoseData,
                    ['inventory_id' => $inventory->id]
                ));
            }
        }
    }
}
