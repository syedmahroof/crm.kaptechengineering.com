<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategoryBrandSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Software', 'description' => 'Software products and licenses'],
            ['name' => 'Services', 'description' => 'Professional services'],
            ['name' => 'Hardware', 'description' => 'Computer hardware and accessories'],
            ['name' => 'Consulting', 'description' => 'Business consulting services'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create Brands
        $brands = [
            ['name' => 'TechCorp', 'description' => 'Leading technology brand'],
            ['name' => 'InnovateSoft', 'description' => 'Innovative software solutions'],
            ['name' => 'ProServices', 'description' => 'Professional service provider'],
            ['name' => 'GlobalTech', 'description' => 'Global technology company'],
            ['name' => 'SmartSolutions', 'description' => 'Smart business solutions'],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        // Create Branches
        $branches = [
            [
                'name' => 'Main Office',
                'location' => 'New York, NY',
                'contact_person' => 'John Doe',
                'phone' => '+1-555-0100',
                'email' => 'newyork@example.com',
            ],
            [
                'name' => 'West Coast Branch',
                'location' => 'Los Angeles, CA',
                'contact_person' => 'Jane Smith',
                'phone' => '+1-555-0200',
                'email' => 'losangeles@example.com',
            ],
            [
                'name' => 'Central Branch',
                'location' => 'Chicago, IL',
                'contact_person' => 'Mike Johnson',
                'phone' => '+1-555-0300',
                'email' => 'chicago@example.com',
            ],
        ];

        foreach ($branches as $branchData) {
            Branch::create($branchData);
        }

        // Create Sample Products
        $products = [
            [
                'name' => 'Enterprise Software License',
                'category_id' => 2,
                'brand_id' => 2,
                'price' => 999.99,
                'description' => 'Annual enterprise software license',
                'status' => 'active',
            ],
            [
                'name' => 'Cloud Storage Pro',
                'category_id' => 2,
                'brand_id' => 4,
                'price' => 49.99,
                'description' => 'Professional cloud storage solution',
                'status' => 'active',
            ],
            [
                'name' => 'Business Laptop',
                'category_id' => 1,
                'brand_id' => 1,
                'price' => 1299.99,
                'description' => 'High-performance business laptop',
                'status' => 'active',
            ],
            [
                'name' => 'Consulting Package',
                'category_id' => 5,
                'brand_id' => 3,
                'price' => 5000.00,
                'description' => 'Premium consulting package',
                'status' => 'active',
            ],
            [
                'name' => 'Network Security Suite',
                'category_id' => 2,
                'brand_id' => 5,
                'price' => 799.99,
                'description' => 'Comprehensive network security solution',
                'status' => 'active',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Categories, brands, branches, and products created successfully!');
    }
}
