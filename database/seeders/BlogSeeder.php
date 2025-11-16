<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create blog categories if they don't exist
        $categories = [
            [
                'name' => 'Travel Tips',
                'slug' => 'travel-tips',
                'description' => 'Essential tips and advice for travelers',
                'color' => '#3B82F6',
                'icon' => 'compass',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Destination Guides',
                'slug' => 'destination-guides',
                'description' => 'Comprehensive guides to amazing destinations',
                'color' => '#10B981',
                'icon' => 'map',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Adventure Travel',
                'slug' => 'adventure-travel',
                'description' => 'Thrilling adventures and outdoor activities',
                'color' => '#F59E0B',
                'icon' => 'mountain',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Food & Culture',
                'slug' => 'food-culture',
                'description' => 'Local cuisine and cultural experiences',
                'color' => '#EF4444',
                'icon' => 'utensils',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $categoryData) {
            BlogCategory::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Get a user to be the author
        $author = User::first();
        if (!$author) {
            $author = User::create([
                'name' => 'Travel Writer',
                'email' => 'writer@lansoa.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Create blog posts
        $blogPosts = [
            [
                'title' => '10 Essential Travel Tips for First-Time Travelers',
                'excerpt' => 'Discover the most important tips every first-time traveler should know before embarking on their journey.',
                'content' => '<p>Traveling for the first time can be both exciting and overwhelming. Here are 10 essential tips to help you make the most of your first adventure:</p><h3>1. Plan Ahead</h3><p>Research your destination thoroughly. Know the local customs, weather, and important landmarks.</p><h3>2. Pack Light</h3><p>You\'ll be surprised how little you actually need. Pack versatile clothing and essential items only.</p><h3>3. Keep Important Documents Safe</h3><p>Make copies of your passport, visa, and other important documents. Keep them in separate locations.</p><h3>4. Learn Basic Local Phrases</h3><p>Even a few words in the local language can go a long way in making connections.</p><h3>5. Stay Connected</h3><p>Inform your bank about your travel plans and consider getting a local SIM card or international plan.</p><h3>6. Budget Wisely</h3><p>Set a daily budget and stick to it. Always have some emergency cash.</p><h3>7. Stay Safe</h3><p>Be aware of your surroundings and trust your instincts. Keep emergency contacts handy.</p><h3>8. Try Local Food</h3><p>One of the best ways to experience a culture is through its cuisine.</p><h3>9. Be Flexible</h3><p>Things don\'t always go as planned. Embrace the unexpected and go with the flow.</p><h3>10. Document Your Journey</h3><p>Take photos, keep a journal, and create memories that will last a lifetime.</p>',
                'status' => 'published',
                'is_featured' => true,
                'author_id' => $author->id,
                'category_id' => BlogCategory::where('slug', 'travel-tips')->first()->id,
                'published_at' => now()->subDays(1),
                'read_time' => 5,
                'views' => 150,
                'meta_data' => ['tags' => ['travel', 'tips', 'first-time', 'planning', 'safety']],
            ],
            [
                'title' => 'Exploring the Hidden Gems of Southeast Asia',
                'excerpt' => 'Uncover the lesser-known destinations in Southeast Asia that offer authentic experiences away from the tourist crowds.',
                'content' => '<p>Southeast Asia is a treasure trove of hidden gems waiting to be discovered. While popular destinations like Bali and Bangkok are amazing, there are countless lesser-known places that offer equally incredible experiences.</p><h3>Kampot, Cambodia</h3><p>This charming riverside town is perfect for those seeking a slower pace of life. Known for its pepper plantations and French colonial architecture, Kampot offers a glimpse into Cambodia\'s past.</p><h3>Koh Rong Sanloem, Cambodia</h3><p>This pristine island offers crystal-clear waters and untouched beaches. It\'s the perfect escape from the crowds of Koh Rong.</p><h3>Luang Prabang, Laos</h3><p>A UNESCO World Heritage city that combines traditional Lao architecture with French colonial influences. The morning alms ceremony is a must-see.</p><h3>Hoi An, Vietnam</h3><p>This ancient town is famous for its well-preserved architecture and lantern-lit streets. It\'s also a great place for custom tailoring.</p><h3>El Nido, Philippines</h3><p>Known for its stunning limestone cliffs and crystal-clear lagoons, El Nido is a paradise for nature lovers and adventure seekers.</p>',
                'status' => 'published',
                'is_featured' => false,
                'author_id' => $author->id,
                'category_id' => BlogCategory::where('slug', 'destination-guides')->first()->id,
                'published_at' => now()->subDays(2),
                'read_time' => 7,
                'views' => 89,
                'meta_data' => ['tags' => ['southeast-asia', 'hidden-gems', 'destinations', 'travel', 'adventure']],
            ],
            [
                'title' => 'The Ultimate Guide to Solo Travel Safety',
                'excerpt' => 'Everything you need to know about staying safe while traveling solo, from planning to emergency situations.',
                'content' => '<p>Solo travel can be one of the most rewarding experiences, but safety should always be your top priority. Here\'s your comprehensive guide to staying safe while exploring the world alone.</p><h3>Before You Go</h3><p>Research your destination thoroughly. Check travel advisories, learn about local customs, and identify safe areas to stay.</p><h3>Accommodation Safety</h3><p>Choose accommodations in safe neighborhoods. Read reviews from other solo travelers and consider staying in hostels or hotels with good security.</p><h3>Communication</h3><p>Keep someone back home informed of your itinerary. Share your location regularly and establish check-in times.</p><h3>Money and Documents</h3><p>Never carry all your money and documents in one place. Use a money belt and keep copies of important documents in separate locations.</p><h3>Trust Your Instincts</h3><p>If something doesn\'t feel right, trust your gut. It\'s better to be overly cautious than to put yourself in a dangerous situation.</p><h3>Emergency Preparedness</h3><p>Know the local emergency numbers and have a plan for different scenarios. Keep emergency contacts easily accessible.</p>',
                'status' => 'published',
                'is_featured' => false,
                'author_id' => $author->id,
                'category_id' => BlogCategory::where('slug', 'travel-tips')->first()->id,
                'published_at' => now()->subDays(3),
                'read_time' => 6,
                'views' => 67,
                'meta_data' => ['tags' => ['solo-travel', 'safety', 'travel-tips', 'security', 'planning']],
            ],
            [
                'title' => 'Adventure Activities in New Zealand',
                'excerpt' => 'From bungee jumping to glacier hiking, discover the most thrilling adventure activities New Zealand has to offer.',
                'content' => '<p>New Zealand is the adventure capital of the world, offering adrenaline-pumping activities for thrill-seekers of all levels.</p><h3>Bungee Jumping</h3><p>Experience the birthplace of commercial bungee jumping at the Kawarau Gorge Suspension Bridge in Queenstown.</p><h3>Skydiving</h3><p>Jump from 15,000 feet and enjoy breathtaking views of New Zealand\'s stunning landscapes.</p><h3>Glacier Hiking</h3><p>Explore the ancient ice formations of Franz Josef and Fox Glaciers with experienced guides.</p><h3>White Water Rafting</h3><p>Navigate through thrilling rapids on the Shotover River or Kaituna River.</p><h3>Hiking and Trekking</h3><p>From day hikes to multi-day treks, New Zealand offers some of the world\'s most beautiful hiking trails.</p><h3>Jet Boating</h3><p>Experience high-speed boat rides through narrow canyons and shallow rivers.</p>',
                'status' => 'published',
                'is_featured' => false,
                'author_id' => $author->id,
                'category_id' => BlogCategory::where('slug', 'adventure-travel')->first()->id,
                'published_at' => now()->subDays(4),
                'read_time' => 5,
                'views' => 45,
                'meta_data' => ['tags' => ['new-zealand', 'adventure', 'activities', 'bungee-jumping', 'outdoor']],
            ],
            [
                'title' => 'Street Food Adventures in Bangkok',
                'excerpt' => 'Discover the vibrant street food scene in Bangkok and learn about the must-try dishes that define Thai cuisine.',
                'content' => '<p>Bangkok\'s street food scene is legendary, offering an incredible variety of flavors and experiences. Here\'s your guide to the best street food adventures in the city.</p><h3>Pad Thai</h3><p>No visit to Bangkok is complete without trying authentic pad thai from a street vendor. Look for busy stalls with locals.</p><h3>Som Tam (Papaya Salad)</h3><p>This spicy and tangy salad is a perfect introduction to Thai flavors. Ask for your preferred spice level.</p><h3>Mango Sticky Rice</h3><p>A sweet treat that combines ripe mango with coconut sticky rice. Perfect for dessert or a sweet snack.</p><h3>Grilled Seafood</h3><p>Fresh seafood grilled to perfection with Thai herbs and spices. Try the grilled prawns and fish.</p><h3>Thai Iced Tea</h3><p>Cool down with this sweet and creamy beverage that\'s a perfect complement to spicy food.</p><h3>Where to Find the Best Street Food</h3><p>Visit markets like Chatuchak Weekend Market, Or Tor Kor Market, and the street food stalls around Khao San Road.</p>',
                'status' => 'published',
                'is_featured' => false,
                'author_id' => $author->id,
                'category_id' => BlogCategory::where('slug', 'food-culture')->first()->id,
                'published_at' => now()->subDays(5),
                'read_time' => 4,
                'views' => 78,
                'meta_data' => ['tags' => ['bangkok', 'street-food', 'thai-cuisine', 'food', 'culture']],
            ],
        ];

        foreach ($blogPosts as $postData) {
            Blog::updateOrCreate(
                ['title' => $postData['title']],
                $postData
            );
        }
    }
}
