<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Discover Amazing Destinations',
                'description' => 'Explore the world\'s most beautiful places with our curated travel experiences. From tropical paradises to cultural capitals, we have the perfect destination for your next adventure.',
                'image' => null, // You can add image URLs here later
                'link' => '/destinations',
                'button_text' => 'Explore Destinations',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Unforgettable Travel Experiences',
                'description' => 'Create memories that last a lifetime with our expertly crafted travel packages. We take care of every detail so you can focus on enjoying your journey.',
                'image' => null,
                'link' => '/about',
                'button_text' => 'Learn More',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Plan Your Perfect Trip',
                'description' => 'Let our travel experts help you plan the perfect getaway. From romantic honeymoons to family adventures, we create personalized experiences just for you.',
                'image' => null,
                'link' => '/contact',
                'button_text' => 'Get Started',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $bannerData) {
            Banner::create($bannerData);
        }

        $this->command->info('Created ' . count($banners) . ' sample banners.');
    }
}
