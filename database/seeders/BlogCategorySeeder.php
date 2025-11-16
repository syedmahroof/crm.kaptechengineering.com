<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Travel Tips',
                'slug' => 'travel-tips',
                'description' => 'Essential tips and advice for travelers',
                'color' => '#3B82F6',
                'icon' => 'map-pin',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Destinations',
                'slug' => 'destinations',
                'description' => 'Explore amazing destinations around the world',
                'color' => '#10B981',
                'icon' => 'globe',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Travel Guides',
                'slug' => 'travel-guides',
                'description' => 'Comprehensive travel guides and itineraries',
                'color' => '#F59E0B',
                'icon' => 'book-open',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Accommodation',
                'slug' => 'accommodation',
                'description' => 'Hotel reviews and accommodation recommendations',
                'color' => '#EF4444',
                'icon' => 'home',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Food & Dining',
                'slug' => 'food-dining',
                'description' => 'Local cuisine and dining experiences',
                'color' => '#8B5CF6',
                'icon' => 'utensils',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Adventure',
                'slug' => 'adventure',
                'description' => 'Adventure travel and outdoor activities',
                'color' => '#EC4899',
                'icon' => 'mountain',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Culture',
                'slug' => 'culture',
                'description' => 'Cultural experiences and local traditions',
                'color' => '#14B8A6',
                'icon' => 'users',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'News & Updates',
                'slug' => 'news-updates',
                'description' => 'Latest travel news and industry updates',
                'color' => '#F97316',
                'icon' => 'newspaper',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
    }
}
