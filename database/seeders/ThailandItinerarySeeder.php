<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Itinerary;
use App\Models\ItineraryDay;
use App\Models\ItineraryItem;
use App\Models\Country;
use App\Models\Destination;
use App\Models\User;

class ThailandItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create Thailand country
        $thailand = Country::firstOrCreate([
            'name' => 'Thailand',
            'code' => 'THA',
            'iso_code' => 'TH',
            'phone_code' => '+66',
            'is_active' => true,
        ]);

        // Get or create destinations
        $phuket = Destination::firstOrCreate([
            'name' => 'Phuket',
            'slug' => 'phuket',
            'country_id' => $thailand->id,
        ]);

        $bangkok = Destination::firstOrCreate([
            'name' => 'Bangkok',
            'slug' => 'bangkok',
            'country_id' => $thailand->id,
        ]);

        // Get first user or create one
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Create the Thailand itinerary
        $itinerary = Itinerary::create([
            'name' => 'Thailand 4 Nights / 5 Days Itinerary',
            'tagline' => 'Explore the vibrant culture and stunning beaches of Thailand',
            'description' => 'Thailand is a vibrant destination known for its rich culture, stunning beaches, and bustling cities. From the lively streets of Bangkok, with its majestic temples and vibrant markets, to the serene beaches and tropical islands of Pattaya, Thailand offers a perfect blend of tradition and modernity. Explore the world-famous floating markets, visit the iconic Sriracha Tiger Park, and indulge in thrilling activities like the Coral Island tour. With its unique mix of natural beauty, cultural landmarks, and unforgettable experiences, Thailand promises a truly memorable vacation.',
            'duration_days' => 5,
            'country_id' => $thailand->id,
            'status' => 'published',
            'user_id' => $user->id,
            'is_master' => true,
            'terms_conditions' => 'Terms and conditions apply. Please read carefully before booking.',
            'cancellation_policy' => 'Cancellation policy: 50% refund if cancelled 7 days before travel, 25% refund if cancelled 3 days before travel.',
            'inclusions' => [
                '04 Nights Hotel Stay (2N Phuket + 2N Bangkok)',
                'Daily Breakfast at Hotels (4)',
                'Phuket City Tour (Private)',
                'Phi Phi Island Tour by Speed Boat (SIC) with Lunch + Snorkeling + National Park Fee',
                'Airport Transfers – Private (HKT & DMK)',
                'Chao Phraya Meridian Dinner Cruise (Cruise SIC + Private Transfers)',
                'Safari World & Marine Park with Lunch (Private)',
                'Bangkok Temple Tour – Marble Buddha & Golden Buddha (Private)',
                'Thailand Arrival Card'
            ],
            'exclusions' => [
                'Airfare & Visa charges',
                'Meals other than specified',
                'Entrance Ticket for Tiger Park & photo with tiger (direct payment by guest)',
                'Any personal expenses (tips, laundry, telephone, mini-bar, etc.)',
                'Travel Insurance',
                'Anything not mentioned in Inclusions'
            ],
            'meta_title' => 'Thailand 4 Nights 5 Days Itinerary - Phuket & Bangkok Tour',
            'meta_description' => 'Experience the best of Thailand with our 4 nights 5 days itinerary covering Phuket and Bangkok. Includes city tours, island hopping, temple visits and more.',
            'meta_keywords' => ['Thailand', 'Phuket', 'Bangkok', 'Island Tour', 'Temple Tour', 'Safari World', 'Phi Phi Island'],
        ]);

        // Attach destinations with day numbers
        $itinerary->destinations()->attach([
            $phuket->id => ['day_number' => 1],
            $bangkok->id => ['day_number' => 3],
        ]);

        // Create Day 1: Arrival in Phuket – City Tour
        $day1 = ItineraryDay::create([
            'itinerary_id' => $itinerary->id,
            'day_number' => 1,
            'title' => 'Arrival in Phuket – City Tour',
            'description' => 'Arrival at Phuket International Airport and city tour including Karon View Point, Tiger Park, Wat Chalong Temple, Phuket Old Town, and Gems Gallery.',
        ]);

        $day1Items = [
            [
                'title' => 'Arrival at Phuket International Airport',
                'description' => 'Welcome to Phuket! Meet and greet at the airport.',
                'location' => 'Phuket International Airport',
                'start_time' => '09:00',
                'end_time' => '10:00',
                'duration_minutes' => 60,
                'type' => 'transport',
            ],
            [
                'title' => 'Private transfer to hotel with 6 Hours Phuket City Tour',
                'description' => 'Enroute city tour including Karon View Point, Tiger Park Phuket, Wat Chalong Temple, Phuket Old Town, and Gems Gallery Phuket.',
                'location' => 'Phuket City',
                'start_time' => '10:00',
                'end_time' => '16:00',
                'duration_minutes' => 360,
                'type' => 'activity',
            ],
            [
                'title' => 'Check-in at Phuket Hotel',
                'description' => 'Check-in and rest at your hotel.',
                'location' => 'Phuket Hotel',
                'start_time' => '16:00',
                'end_time' => '18:00',
                'duration_minutes' => 120,
                'type' => 'accommodation',
            ],
        ];

        foreach ($day1Items as $item) {
            ItineraryItem::create([
                'itinerary_day_id' => $day1->id,
                'title' => $item['title'],
                'description' => $item['description'],
                'location' => $item['location'],
                'start_time' => $item['start_time'],
                'end_time' => $item['end_time'],
                'duration_minutes' => $item['duration_minutes'],
                'type' => $item['type'],
            ]);
        }

        // Create Day 2: Phi Phi Island Tour
        $day2 = ItineraryDay::create([
            'itinerary_id' => $itinerary->id,
            'day_number' => 2,
            'title' => 'Phi Phi Island Tour',
            'description' => 'Full-day Phi Phi Island Tour by Speed Boat with lunch, snorkeling equipment, and national park fee included.',
        ]);

        $day2Items = [
            [
                'title' => 'Breakfast at hotel',
                'description' => 'Enjoy breakfast at your hotel.',
                'location' => 'Phuket Hotel',
                'start_time' => '07:00',
                'end_time' => '08:00',
                'duration_minutes' => 60,
                'type' => 'meal',
            ],
            [
                'title' => 'Full-day Phi Phi Island Tour by Speed Boat',
                'description' => 'Experience the beauty of Phi Phi Islands with lunch included, national park fee, and snorkeling equipment.',
                'location' => 'Phi Phi Islands',
                'start_time' => '08:00',
                'end_time' => '17:00',
                'duration_minutes' => 540,
                'type' => 'activity',
            ],
        ];

        foreach ($day2Items as $item) {
            ItineraryItem::create([
                'itinerary_day_id' => $day2->id,
                'title' => $item['title'],
                'description' => $item['description'],
                'location' => $item['location'],
                'start_time' => $item['start_time'],
                'end_time' => $item['end_time'],
                'duration_minutes' => $item['duration_minutes'],
                'type' => $item['type'],
            ]);
        }

        // Create Day 3: Phuket to Bangkok – Dinner Cruise
        $day3 = ItineraryDay::create([
            'itinerary_id' => $itinerary->id,
            'day_number' => 3,
            'title' => 'Phuket to Bangkok – Dinner Cruise',
            'description' => 'Transfer to Bangkok and enjoy an evening Chao Phraya River Dinner Cruise.',
        ]);

        $day3Items = [
            [
                'title' => 'Breakfast at hotel',
                'description' => 'Enjoy breakfast at your hotel.',
                'location' => 'Phuket Hotel',
                'start_time' => '07:00',
                'end_time' => '08:00',
                'duration_minutes' => 60,
                'type' => 'meal',
            ],
            [
                'title' => 'Check-out and transfer to Phuket Airport',
                'description' => 'Private transfer to Phuket Airport for flight to Bangkok.',
                'location' => 'Phuket Airport',
                'start_time' => '08:00',
                'end_time' => '09:00',
                'duration_minutes' => 60,
                'type' => 'transport',
            ],
            [
                'title' => 'Flight to Bangkok',
                'description' => 'Domestic flight from Phuket to Bangkok.',
                'location' => 'Bangkok Airport',
                'start_time' => '10:00',
                'end_time' => '12:00',
                'duration_minutes' => 120,
                'type' => 'transport',
            ],
            [
                'title' => 'Check-in at Bangkok hotel',
                'description' => 'Private transfer to Bangkok hotel for check-in.',
                'location' => 'Bangkok Hotel',
                'start_time' => '12:00',
                'end_time' => '14:00',
                'duration_minutes' => 120,
                'type' => 'accommodation',
            ],
            [
                'title' => 'Chao Phraya River Dinner Cruise',
                'description' => 'Evening Chao Phraya River Dinner Cruise (Meridian) with private transfers.',
                'location' => 'Chao Phraya River',
                'start_time' => '18:00',
                'end_time' => '21:00',
                'duration_minutes' => 180,
                'type' => 'activity',
            ],
        ];

        foreach ($day3Items as $item) {
            ItineraryItem::create([
                'itinerary_day_id' => $day3->id,
                'title' => $item['title'],
                'description' => $item['description'],
                'location' => $item['location'],
                'start_time' => $item['start_time'],
                'end_time' => $item['end_time'],
                'duration_minutes' => $item['duration_minutes'],
                'type' => $item['type'],
            ]);
        }

        // Create Day 4: Safari World & Marine Park
        $day4 = ItineraryDay::create([
            'itinerary_id' => $itinerary->id,
            'day_number' => 4,
            'title' => 'Safari World & Marine Park',
            'description' => 'Full-day visit to Safari World & Marine Park with lunch included. Experience thrilling safari rides and fascinating animal shows.',
        ]);

        $day4Items = [
            [
                'title' => 'Breakfast at hotel',
                'description' => 'Enjoy breakfast at your hotel.',
                'location' => 'Bangkok Hotel',
                'start_time' => '07:00',
                'end_time' => '08:00',
                'duration_minutes' => 60,
                'type' => 'meal',
            ],
            [
                'title' => 'Safari World & Marine Park',
                'description' => 'Full-day visit to Safari World & Marine Park with lunch included. Enjoy thrilling drive-through safari ride and fascinating animal shows including Dolphin Show, Sea Lion Show, Elephant Show, Orangutan Show, Cowboy Stunt Show, and Bird Show.',
                'location' => 'Safari World & Marine Park',
                'start_time' => '08:00',
                'end_time' => '17:00',
                'duration_minutes' => 540,
                'type' => 'activity',
            ],
        ];

        foreach ($day4Items as $item) {
            ItineraryItem::create([
                'itinerary_day_id' => $day4->id,
                'title' => $item['title'],
                'description' => $item['description'],
                'location' => $item['location'],
                'start_time' => $item['start_time'],
                'end_time' => $item['end_time'],
                'duration_minutes' => $item['duration_minutes'],
                'type' => $item['type'],
            ]);
        }

        // Create Day 5: Bangkok City & Temple Tour – Departure
        $day5 = ItineraryDay::create([
            'itinerary_id' => $itinerary->id,
            'day_number' => 5,
            'title' => 'Bangkok City & Temple Tour – Departure',
            'description' => 'Half-day Bangkok Temple Tour including Marble Buddha and Golden Buddha, followed by departure.',
        ]);

        $day5Items = [
            [
                'title' => 'Breakfast at hotel',
                'description' => 'Enjoy breakfast at your hotel.',
                'location' => 'Bangkok Hotel',
                'start_time' => '07:00',
                'end_time' => '08:00',
                'duration_minutes' => 60,
                'type' => 'meal',
            ],
            [
                'title' => 'Check-out from hotel',
                'description' => 'Check-out from your hotel.',
                'location' => 'Bangkok Hotel',
                'start_time' => '08:00',
                'end_time' => '09:00',
                'duration_minutes' => 60,
                'type' => 'accommodation',
            ],
            [
                'title' => 'Bangkok Temple Tour',
                'description' => 'Half-day Bangkok Temple Tour (Private) including Marble Buddha and Golden Buddha.',
                'location' => 'Bangkok Temples',
                'start_time' => '09:00',
                'end_time' => '12:00',
                'duration_minutes' => 180,
                'type' => 'activity',
            ],
            [
                'title' => 'Transfer to DMK Airport for departure',
                'description' => 'Private transfer to DMK Airport for departure.',
                'location' => 'DMK Airport',
                'start_time' => '12:00',
                'end_time' => '13:00',
                'duration_minutes' => 60,
                'type' => 'transport',
            ],
        ];

        foreach ($day5Items as $item) {
            ItineraryItem::create([
                'itinerary_day_id' => $day5->id,
                'title' => $item['title'],
                'description' => $item['description'],
                'location' => $item['location'],
                'start_time' => $item['start_time'],
                'end_time' => $item['end_time'],
                'duration_minutes' => $item['duration_minutes'],
                'type' => $item['type'],
            ]);
        }

        $this->command->info('Thailand itinerary created successfully!');
    }
}
