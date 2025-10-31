<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'name' => 'Professional Workstation',
                'category_id' => 1,
                'brand_id' => 1,
                'price' => 2499.99,
                'description' => 'High-end workstation for professionals with advanced graphics and processing power',
                'status' => 'active',
            ],
            [
                'name' => 'Wireless Presentation System',
                'category_id' => 1,
                'brand_id' => 4,
                'price' => 899.99,
                'description' => 'Wireless presentation system for conference rooms',
                'status' => 'active',
            ],
            [
                'name' => '4K Conference Camera',
                'category_id' => 1,
                'brand_id' => 1,
                'price' => 699.99,
                'description' => '4K video conferencing camera with AI features',
                'status' => 'active',
            ],
            
            // Software
            [
                'name' => 'CRM Software Pro',
                'category_id' => 2,
                'brand_id' => 2,
                'price' => 1499.99,
                'description' => 'Professional CRM software with advanced analytics',
                'status' => 'active',
            ],
            [
                'name' => 'Project Management Suite',
                'category_id' => 2,
                'brand_id' => 5,
                'price' => 799.99,
                'description' => 'Complete project management solution for teams',
                'status' => 'active',
            ],
            [
                'name' => 'Data Analytics Platform',
                'category_id' => 2,
                'brand_id' => 2,
                'price' => 2999.99,
                'description' => 'Enterprise data analytics and business intelligence platform',
                'status' => 'active',
            ],
            [
                'name' => 'Email Marketing Pro',
                'category_id' => 2,
                'brand_id' => 5,
                'price' => 399.99,
                'description' => 'Professional email marketing automation software',
                'status' => 'active',
            ],
            
            // Services
            [
                'name' => 'IT Support Package',
                'category_id' => 3,
                'brand_id' => 3,
                'price' => 299.99,
                'description' => 'Monthly IT support and maintenance package',
                'status' => 'active',
            ],
            [
                'name' => 'Digital Marketing Service',
                'category_id' => 3,
                'brand_id' => 3,
                'price' => 1999.99,
                'description' => 'Comprehensive digital marketing campaign management',
                'status' => 'active',
            ],
            [
                'name' => 'Cloud Migration Service',
                'category_id' => 3,
                'brand_id' => 4,
                'price' => 4999.99,
                'description' => 'Complete cloud migration and optimization service',
                'status' => 'active',
            ],
            
            // Hardware
            [
                'name' => 'Enterprise Server Rack',
                'category_id' => 4,
                'brand_id' => 4,
                'price' => 8999.99,
                'description' => 'High-performance enterprise server rack solution',
                'status' => 'active',
            ],
            [
                'name' => 'Network Switch 48-Port',
                'category_id' => 4,
                'brand_id' => 1,
                'price' => 1299.99,
                'description' => 'Enterprise-grade 48-port gigabit network switch',
                'status' => 'active',
            ],
            [
                'name' => 'Wireless Access Point',
                'category_id' => 4,
                'brand_id' => 4,
                'price' => 399.99,
                'description' => 'High-speed dual-band wireless access point',
                'status' => 'active',
            ],
            [
                'name' => 'UPS Battery Backup',
                'category_id' => 4,
                'brand_id' => 1,
                'price' => 599.99,
                'description' => 'Uninterruptible power supply for critical systems',
                'status' => 'active',
            ],
            
            // Consulting
            [
                'name' => 'Business Strategy Session',
                'category_id' => 5,
                'brand_id' => 3,
                'price' => 2500.00,
                'description' => 'Full-day business strategy consulting session',
                'status' => 'active',
            ],
            [
                'name' => 'Digital Transformation Package',
                'category_id' => 5,
                'brand_id' => 5,
                'price' => 15000.00,
                'description' => 'Complete digital transformation consulting and implementation',
                'status' => 'active',
            ],
            [
                'name' => 'Security Audit Service',
                'category_id' => 5,
                'brand_id' => 4,
                'price' => 3500.00,
                'description' => 'Comprehensive IT security audit and recommendations',
                'status' => 'active',
            ],
            [
                'name' => 'Training Workshop Package',
                'category_id' => 5,
                'brand_id' => 3,
                'price' => 1500.00,
                'description' => 'Custom training workshop for your team',
                'status' => 'active',
            ],
            
            // Additional Products
            [
                'name' => 'Mobile Device Management',
                'category_id' => 2,
                'brand_id' => 5,
                'price' => 599.99,
                'description' => 'Enterprise mobile device management solution',
                'status' => 'active',
            ],
            [
                'name' => 'Video Conferencing License',
                'category_id' => 2,
                'brand_id' => 2,
                'price' => 199.99,
                'description' => 'Professional video conferencing software license',
                'status' => 'active',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Additional products created successfully!');
        $this->command->info('Total: ' . count($products) . ' products added');
    }
}

