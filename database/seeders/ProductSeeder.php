<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $adminUser = $users->first();

        if (!$adminUser) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $products = [
            // Pipes and Fittings
            [
                'name' => 'PVC Pipe 4 inch',
                'sku' => 'PVC-4IN-001',
                'code' => 'PP-001',
                'description' => 'High-quality PVC pipe, 4 inch diameter, suitable for water supply and drainage systems.',
                'category' => 'Pipes & Fittings',
                'unit' => 'Meter',
                'price' => 450.00,
                'cost' => 320.00,
                'stock_quantity' => 500,
                'min_stock_level' => 100,
                'specifications' => [
                    'diameter' => '4 inch',
                    'material' => 'PVC',
                    'pressure_rating' => '10 bar',
                    'length' => '6 meters',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'GI Pipe 2 inch',
                'sku' => 'GI-2IN-001',
                'code' => 'GP-001',
                'description' => 'Galvanized Iron pipe, 2 inch diameter, corrosion resistant.',
                'category' => 'Pipes & Fittings',
                'unit' => 'Meter',
                'price' => 380.00,
                'cost' => 280.00,
                'stock_quantity' => 300,
                'min_stock_level' => 50,
                'specifications' => [
                    'diameter' => '2 inch',
                    'material' => 'Galvanized Iron',
                    'thickness' => '2.5mm',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'CPVC Pipe 1 inch',
                'sku' => 'CPVC-1IN-001',
                'code' => 'CP-001',
                'description' => 'Chlorinated Polyvinyl Chloride pipe for hot water systems.',
                'category' => 'Pipes & Fittings',
                'unit' => 'Meter',
                'price' => 280.00,
                'cost' => 200.00,
                'stock_quantity' => 400,
                'min_stock_level' => 80,
                'specifications' => [
                    'diameter' => '1 inch',
                    'material' => 'CPVC',
                    'temperature_rating' => '93°C',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],

            // Electrical Components
            [
                'name' => 'MCB 16A Single Pole',
                'sku' => 'MCB-16A-SP-001',
                'code' => 'EL-001',
                'description' => 'Miniature Circuit Breaker, 16 Ampere, Single Pole, for residential and commercial use.',
                'category' => 'Electrical',
                'unit' => 'Piece',
                'price' => 450.00,
                'cost' => 320.00,
                'stock_quantity' => 200,
                'min_stock_level' => 30,
                'specifications' => [
                    'current_rating' => '16A',
                    'type' => 'Single Pole',
                    'voltage' => '230V',
                    'breaking_capacity' => '6kA',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'LED Panel Light 36W',
                'sku' => 'LED-PANEL-36W-001',
                'code' => 'EL-002',
                'description' => 'Energy efficient LED panel light, 36W, suitable for false ceiling installation.',
                'category' => 'Electrical',
                'unit' => 'Piece',
                'price' => 850.00,
                'cost' => 600.00,
                'stock_quantity' => 150,
                'min_stock_level' => 25,
                'specifications' => [
                    'wattage' => '36W',
                    'lumen' => '3600',
                    'color_temperature' => '4000K',
                    'dimensions' => '600x600mm',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Electrical Wire 2.5mm²',
                'sku' => 'WIRE-2.5MM-001',
                'code' => 'EL-003',
                'description' => 'Copper electrical wire, 2.5mm² cross-section, 90 meters per coil.',
                'category' => 'Electrical',
                'unit' => 'Coil',
                'price' => 2800.00,
                'cost' => 2100.00,
                'stock_quantity' => 80,
                'min_stock_level' => 15,
                'specifications' => [
                    'cross_section' => '2.5mm²',
                    'length' => '90 meters',
                    'material' => 'Copper',
                    'voltage_rating' => '450/750V',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],

            // Sanitary Ware
            [
                'name' => 'Wall Mounted Wash Basin',
                'sku' => 'WASH-BASIN-WM-001',
                'code' => 'SW-001',
                'description' => 'Ceramic wall mounted wash basin, modern design, easy to clean.',
                'category' => 'Sanitary Ware',
                'unit' => 'Piece',
                'price' => 2500.00,
                'cost' => 1800.00,
                'stock_quantity' => 40,
                'min_stock_level' => 10,
                'specifications' => [
                    'material' => 'Ceramic',
                    'mounting' => 'Wall Mounted',
                    'dimensions' => '600x450mm',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Water Closet (WC)',
                'sku' => 'WC-STD-001',
                'code' => 'SW-002',
                'description' => 'Standard water closet with cistern, floor mounted.',
                'category' => 'Sanitary Ware',
                'unit' => 'Set',
                'price' => 4500.00,
                'cost' => 3200.00,
                'stock_quantity' => 30,
                'min_stock_level' => 8,
                'specifications' => [
                    'type' => 'Floor Mounted',
                    'material' => 'Ceramic',
                    'flush_type' => 'Gravity',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],

            // HVAC Components
            [
                'name' => 'Split AC 1.5 Ton',
                'sku' => 'AC-1.5T-SPLIT-001',
                'code' => 'HVAC-001',
                'description' => 'Inverter split air conditioner, 1.5 ton capacity, energy star rated.',
                'category' => 'HVAC',
                'unit' => 'Unit',
                'price' => 35000.00,
                'cost' => 28000.00,
                'stock_quantity' => 15,
                'min_stock_level' => 3,
                'specifications' => [
                    'capacity' => '1.5 Ton',
                    'type' => 'Split AC',
                    'energy_rating' => '5 Star',
                    'cooling_area' => '150-180 sq ft',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Ceiling Fan 1200mm',
                'sku' => 'FAN-1200-CEIL-001',
                'code' => 'HVAC-002',
                'description' => 'Energy efficient ceiling fan, 1200mm sweep, remote controlled.',
                'category' => 'HVAC',
                'unit' => 'Piece',
                'price' => 2200.00,
                'cost' => 1600.00,
                'stock_quantity' => 60,
                'min_stock_level' => 12,
                'specifications' => [
                    'sweep' => '1200mm',
                    'speed' => '3 Speed',
                    'control' => 'Remote',
                    'wattage' => '75W',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],

            // Tiles and Flooring
            [
                'name' => 'Ceramic Floor Tile 600x600mm',
                'sku' => 'TILE-CER-600-001',
                'code' => 'TF-001',
                'description' => 'Premium ceramic floor tile, 600x600mm, anti-slip, suitable for indoor use.',
                'category' => 'Tiles & Flooring',
                'unit' => 'Box',
                'price' => 1800.00,
                'cost' => 1300.00,
                'stock_quantity' => 100,
                'min_stock_level' => 20,
                'specifications' => [
                    'size' => '600x600mm',
                    'material' => 'Ceramic',
                    'pieces_per_box' => '4',
                    'thickness' => '8mm',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Vitrified Tile 800x800mm',
                'sku' => 'TILE-VIT-800-001',
                'code' => 'TF-002',
                'description' => 'Polished vitrified tile, 800x800mm, high gloss finish.',
                'category' => 'Tiles & Flooring',
                'unit' => 'Box',
                'price' => 3200.00,
                'cost' => 2400.00,
                'stock_quantity' => 70,
                'min_stock_level' => 15,
                'specifications' => [
                    'size' => '800x800mm',
                    'material' => 'Vitrified',
                    'pieces_per_box' => '3',
                    'finish' => 'Polished',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],

            // Paints and Coatings
            [
                'name' => 'Interior Emulsion Paint 20L',
                'sku' => 'PAINT-EMUL-20L-001',
                'code' => 'PC-001',
                'description' => 'Premium interior emulsion paint, 20 liters, washable, available in multiple colors.',
                'category' => 'Paints & Coatings',
                'unit' => 'Can',
                'price' => 2800.00,
                'cost' => 2000.00,
                'stock_quantity' => 50,
                'min_stock_level' => 10,
                'specifications' => [
                    'volume' => '20 Liters',
                    'type' => 'Emulsion',
                    'coverage' => '140-160 sq ft per liter',
                    'drying_time' => '2-4 hours',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],

            // Hardware and Tools
            [
                'name' => 'Steel Door Handle Set',
                'sku' => 'HANDLE-STEEL-001',
                'code' => 'HT-001',
                'description' => 'Premium steel door handle set with lock, suitable for main doors.',
                'category' => 'Hardware & Tools',
                'unit' => 'Set',
                'price' => 1200.00,
                'cost' => 850.00,
                'stock_quantity' => 45,
                'min_stock_level' => 10,
                'specifications' => [
                    'material' => 'Stainless Steel',
                    'finish' => 'Brushed',
                    'lock_type' => 'Cylindrical',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Hinges 4 inch',
                'sku' => 'HINGE-4IN-001',
                'code' => 'HT-002',
                'description' => 'Heavy duty door hinges, 4 inch, brass plated.',
                'category' => 'Hardware & Tools',
                'unit' => 'Pair',
                'price' => 180.00,
                'cost' => 120.00,
                'stock_quantity' => 200,
                'min_stock_level' => 40,
                'specifications' => [
                    'size' => '4 inch',
                    'material' => 'Steel',
                    'finish' => 'Brass Plated',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],

            // Cement and Building Materials
            [
                'name' => 'Portland Cement 50kg',
                'sku' => 'CEMENT-PPC-50KG-001',
                'code' => 'CBM-001',
                'description' => 'Portland Pozzolana Cement, 50kg bag, IS certified.',
                'category' => 'Cement & Building Materials',
                'unit' => 'Bag',
                'price' => 380.00,
                'cost' => 320.00,
                'stock_quantity' => 500,
                'min_stock_level' => 100,
                'specifications' => [
                    'weight' => '50kg',
                    'type' => 'PPC',
                    'grade' => '43 Grade',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Steel Rod 12mm',
                'sku' => 'STEEL-ROD-12MM-001',
                'code' => 'CBM-002',
                'description' => 'TMT steel reinforcement rod, 12mm diameter, 12 meters length.',
                'category' => 'Cement & Building Materials',
                'unit' => 'Piece',
                'price' => 850.00,
                'cost' => 720.00,
                'stock_quantity' => 300,
                'min_stock_level' => 50,
                'specifications' => [
                    'diameter' => '12mm',
                    'length' => '12 meters',
                    'type' => 'TMT',
                    'grade' => 'Fe 500',
                ],
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Created ' . count($products) . ' products.');
    }
}
