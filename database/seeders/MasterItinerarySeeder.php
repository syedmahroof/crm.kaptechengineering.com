<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Itinerary;
use App\Models\ItineraryDay;
use App\Models\ItineraryItem;
use App\Models\Country;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Support\Str;

class MasterItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        // Bali, Indonesia
        $this->createBaliItinerary($user);
        
        // Maldives
        $this->createMaldivesItinerary($user);
        
        // Phuket, Thailand (Crab might be a typo or area name)
        $this->createPhuketItinerary($user);
        
        // Azerbaijan
        $this->createAzerbaijanItinerary($user);
        
        // Georgia
        $this->createGeorgiaItinerary($user);

        $this->command->info('Master itineraries created successfully!');
    }

    private function createBaliItinerary($user)
    {
        $indonesia = Country::firstOrCreate([
            'name' => 'Indonesia',
            'code' => 'IDN',
            'iso_code' => 'ID',
            'phone_code' => '+62',
            'currency_code' => 'IDR',
            'currency_symbol' => 'Rp',
            'capital' => 'Jakarta',
            'continent' => 'Asia',
            'is_active' => true,
        ]);

        $bali = Destination::firstOrCreate([
            'name' => 'Bali',
            'slug' => 'bali',
            'country_id' => $indonesia->id,
            'type' => 'island',
            'is_active' => true,
        ]);

        $itinerary = Itinerary::updateOrCreate(
            ['slug' => 'bali-4-nights-5-days'],
            [
                'name' => 'Bali 4 Nights / 5 Days - Tropical Paradise',
                'tagline' => 'Experience the enchanting island of gods with stunning beaches, ancient temples, and vibrant culture',
                'description' => 'Discover the magical island of Bali, known for its stunning beaches, lush rice terraces, ancient temples, and rich cultural heritage. From the vibrant nightlife of Seminyak to the spiritual tranquility of Ubud, and the pristine beaches of Nusa Dua, Bali offers a perfect blend of relaxation and adventure. Explore ancient temples, enjoy traditional Balinese dance performances, indulge in world-class spa treatments, and savor authentic Indonesian cuisine.',
                'duration_days' => 5,
                'country_id' => $indonesia->id,
                'destination_id' => $bali->id,
                'status' => 'published',
                'user_id' => $user->id,
                'is_master' => true,
                'slug' => 'bali-4-nights-5-days',
                'terms_conditions' => 'Terms and conditions apply. Valid passport required. Travel insurance recommended.',
                'cancellation_policy' => 'Cancellation policy: 50% refund if cancelled 14 days before travel, 25% refund if cancelled 7 days before travel. No refund for cancellations within 7 days.',
                'inclusions' => [
                    '04 Nights Hotel Stay in Bali',
                    'Daily Breakfast at Hotel',
                    'Airport Transfers (Private)',
                    'Ubud Full Day Tour with Rice Terraces & Monkey Forest',
                    'Tanah Lot Temple Sunset Tour',
                    'Water Sports Activities (Parasailing, Jet Ski, Banana Boat)',
                    'Traditional Balinese Dance Performance',
                    'Spa & Wellness Session',
                    'All Entrance Fees',
                ],
                'exclusions' => [
                    'International & Domestic Airfare',
                    'Visa Charges',
                    'Meals other than specified',
                    'Personal Expenses (tips, laundry, shopping, etc.)',
                    'Travel Insurance',
                    'Optional Tours & Activities',
                    'Anything not mentioned in Inclusions',
                ],
                'meta_title' => 'Bali 4 Nights 5 Days Tour Package - Best Bali Itinerary',
                'meta_description' => 'Explore Bali with our comprehensive 4 nights 5 days itinerary. Includes Ubud, temples, beaches, water sports, and cultural experiences.',
                'meta_keywords' => ['Bali', 'Indonesia', 'Ubud', 'Tanah Lot', 'Nusa Dua', 'Bali Temples', 'Bali Beaches'],
            ]
        );

        $this->createBaliDays($itinerary);
    }

    private function createBaliDays($itinerary)
    {
        // Day 1: Arrival in Bali
        $day1 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 1],
            [
                'title' => 'Arrival in Bali - Transfer to Hotel',
                'description' => 'Welcome to the Island of Gods! Arrive at Ngurah Rai International Airport and transfer to your hotel. Rest and relax or explore the nearby area.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day1, [
            ['title' => 'Airport Pickup', 'description' => 'Private transfer from Ngurah Rai Airport to hotel', 'location' => 'Ngurah Rai Airport', 'start_time' => '14:00', 'end_time' => '15:30', 'type' => 'transport'],
            ['title' => 'Hotel Check-in', 'description' => 'Check-in and relax at your hotel', 'location' => 'Bali Hotel', 'start_time' => '15:30', 'end_time' => '16:00', 'type' => 'accommodation'],
            ['title' => 'Evening at Leisure', 'description' => 'Explore Seminyak Beach or enjoy hotel facilities', 'location' => 'Seminyak', 'start_time' => '18:00', 'end_time' => '20:00', 'type' => 'activity'],
        ]);

        // Day 2: Ubud Full Day Tour
        $day2 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 2],
            [
                'title' => 'Ubud Full Day Tour - Rice Terraces & Monkey Forest',
                'description' => 'Explore the cultural heart of Bali with visits to Tegalalang Rice Terraces, Ubud Monkey Forest, and traditional villages.',
                'meals' => ['breakfast', 'lunch'],
            ]
        );

        $this->createDayItems($day2, [
            ['title' => 'Breakfast at Hotel', 'description' => 'Enjoy breakfast at your hotel', 'location' => 'Bali Hotel', 'start_time' => '07:00', 'end_time' => '08:00', 'type' => 'meal'],
            ['title' => 'Tegalalang Rice Terraces', 'description' => 'Visit the famous terraced rice paddies', 'location' => 'Tegalalang', 'start_time' => '09:00', 'end_time' => '11:00', 'type' => 'activity'],
            ['title' => 'Ubud Monkey Forest', 'description' => 'Explore the Sacred Monkey Forest Sanctuary', 'location' => 'Ubud', 'start_time' => '11:30', 'end_time' => '13:00', 'type' => 'activity'],
            ['title' => 'Lunch at Ubud Restaurant', 'description' => 'Traditional Balinese lunch', 'location' => 'Ubud', 'start_time' => '13:00', 'end_time' => '14:00', 'type' => 'meal'],
            ['title' => 'Ubud Art Market', 'description' => 'Shop for traditional Balinese crafts and souvenirs', 'location' => 'Ubud', 'start_time' => '14:30', 'end_time' => '16:00', 'type' => 'activity'],
            ['title' => 'Return to Hotel', 'description' => 'Transfer back to hotel', 'location' => 'Bali Hotel', 'start_time' => '16:30', 'end_time' => '18:00', 'type' => 'transport'],
        ]);

        // Day 3: Water Sports & Beach Activities
        $day3 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 3],
            [
                'title' => 'Water Sports & Nusa Dua Beach',
                'description' => 'Enjoy thrilling water sports activities and relax on the pristine beaches of Nusa Dua.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day3, [
            ['title' => 'Breakfast at Hotel', 'description' => 'Enjoy breakfast', 'location' => 'Bali Hotel', 'start_time' => '07:00', 'end_time' => '08:00', 'type' => 'meal'],
            ['title' => 'Water Sports Activities', 'description' => 'Parasailing, Jet Ski, Banana Boat, and more', 'location' => 'Nusa Dua Beach', 'start_time' => '09:00', 'end_time' => '12:00', 'type' => 'activity'],
            ['title' => 'Beach Relaxation', 'description' => 'Relax on the pristine Nusa Dua Beach', 'location' => 'Nusa Dua', 'start_time' => '12:00', 'end_time' => '15:00', 'type' => 'activity'],
            ['title' => 'Spa & Wellness Session', 'description' => 'Traditional Balinese massage and spa treatment', 'location' => 'Spa Center', 'start_time' => '16:00', 'end_time' => '18:00', 'type' => 'activity'],
        ]);

        // Day 4: Tanah Lot Temple & Cultural Experience
        $day4 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 4],
            [
                'title' => 'Tanah Lot Temple Sunset Tour & Cultural Show',
                'description' => 'Visit the iconic Tanah Lot Temple and enjoy traditional Balinese dance performance.',
                'meals' => ['breakfast', 'dinner'],
            ]
        );

        $this->createDayItems($day4, [
            ['title' => 'Breakfast at Hotel', 'description' => 'Enjoy breakfast', 'location' => 'Bali Hotel', 'start_time' => '07:00', 'end_time' => '08:00', 'type' => 'meal'],
            ['title' => 'Tanah Lot Temple Visit', 'description' => 'Visit the iconic sea temple at sunset', 'location' => 'Tanah Lot', 'start_time' => '16:00', 'end_time' => '18:30', 'type' => 'activity'],
            ['title' => 'Traditional Balinese Dance Performance', 'description' => 'Watch Kecak Fire Dance or Legong Dance', 'location' => 'Cultural Center', 'start_time' => '19:00', 'end_time' => '20:30', 'type' => 'activity'],
            ['title' => 'Dinner', 'description' => 'Traditional Balinese dinner', 'location' => 'Restaurant', 'start_time' => '20:30', 'end_time' => '22:00', 'type' => 'meal'],
        ]);

        // Day 5: Departure
        $day5 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 5],
            [
                'title' => 'Departure from Bali',
                'description' => 'Check-out from hotel and transfer to airport for departure.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day5, [
            ['title' => 'Breakfast at Hotel', 'description' => 'Enjoy breakfast', 'location' => 'Bali Hotel', 'start_time' => '07:00', 'end_time' => '08:00', 'type' => 'meal'],
            ['title' => 'Hotel Check-out', 'description' => 'Check-out from hotel', 'location' => 'Bali Hotel', 'start_time' => '11:00', 'end_time' => '12:00', 'type' => 'accommodation'],
            ['title' => 'Airport Transfer', 'description' => 'Private transfer to Ngurah Rai Airport', 'location' => 'Ngurah Rai Airport', 'start_time' => '12:00', 'end_time' => '13:00', 'type' => 'transport'],
        ]);
    }

    private function createMaldivesItinerary($user)
    {
        $maldives = Country::firstOrCreate([
            'name' => 'Maldives',
            'code' => 'MDV',
            'iso_code' => 'MV',
            'phone_code' => '+960',
            'currency_code' => 'MVR',
            'currency_symbol' => 'Rf',
            'capital' => 'Malé',
            'continent' => 'Asia',
            'is_active' => true,
        ]);

        $male = Destination::firstOrCreate([
            'name' => 'Malé',
            'slug' => 'male',
            'country_id' => $maldives->id,
            'type' => 'city',
            'is_active' => true,
        ]);

        $itinerary = Itinerary::updateOrCreate(
            ['slug' => 'maldives-3-nights-4-days'],
            [
                'name' => 'Maldives 3 Nights / 4 Days - Paradise Island',
                'tagline' => 'Experience ultimate luxury in the crystal-clear waters of the Maldives',
                'description' => 'Escape to the ultimate tropical paradise in the Maldives. With its pristine white-sand beaches, crystal-clear turquoise waters, and luxurious overwater villas, the Maldives offers an unparalleled island getaway. Indulge in world-class snorkeling and diving, enjoy romantic sunset cruises, relax with spa treatments, and savor gourmet dining experiences. Perfect for honeymooners, couples, and anyone seeking the ultimate beach vacation.',
                'duration_days' => 4,
                'country_id' => $maldives->id,
                'destination_id' => $male->id,
                'status' => 'published',
                'user_id' => $user->id,
                'is_master' => true,
                'slug' => 'maldives-3-nights-4-days',
                'terms_conditions' => 'Terms and conditions apply. Valid passport required. Resort transfers by speedboat or seaplane may incur additional charges.',
                'cancellation_policy' => 'Cancellation policy: 50% refund if cancelled 21 days before travel, 25% refund if cancelled 14 days before travel. No refund for cancellations within 14 days.',
                'inclusions' => [
                    '03 Nights Stay in Water Villa or Beach Villa',
                    'Daily Breakfast',
                    'Airport Transfers (Speedboat)',
                    'Snorkeling Equipment',
                    'Sunset Cruise',
                    'Island Hopping Tour',
                    'Welcome Drink & Fresh Fruits',
                    'All Resort Facilities Access',
                ],
                'exclusions' => [
                    'International Airfare',
                    'Seaplane Transfer (if applicable)',
                    'Meals other than breakfast',
                    'Water Sports Activities',
                    'Spa Treatments',
                    'Personal Expenses',
                    'Travel Insurance',
                    'Anything not mentioned in Inclusions',
                ],
                'meta_title' => 'Maldives 3 Nights 4 Days Package - Luxury Island Resort',
                'meta_description' => 'Experience the Maldives with our 3 nights 4 days luxury package. Includes water villa, snorkeling, sunset cruise, and island hopping.',
                'meta_keywords' => ['Maldives', 'Water Villa', 'Snorkeling', 'Island Resort', 'Tropical Paradise', 'Honeymoon'],
            ]
        );

        $this->createMaldivesDays($itinerary);
    }

    private function createMaldivesDays($itinerary)
    {
        // Day 1: Arrival
        $day1 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 1],
            [
                'title' => 'Arrival in Maldives - Transfer to Resort',
                'description' => 'Arrive at Velana International Airport and transfer to your resort by speedboat. Check-in to your water villa and enjoy the resort facilities.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day1, [
            ['title' => 'Airport Arrival', 'description' => 'Arrive at Velana International Airport', 'location' => 'Velana Airport', 'start_time' => '12:00', 'end_time' => '13:00', 'type' => 'transport'],
            ['title' => 'Speedboat Transfer', 'description' => 'Transfer to resort by speedboat', 'location' => 'Resort', 'start_time' => '13:30', 'end_time' => '14:30', 'type' => 'transport'],
            ['title' => 'Resort Check-in', 'description' => 'Check-in to water villa', 'location' => 'Resort', 'start_time' => '14:30', 'end_time' => '15:00', 'type' => 'accommodation'],
            ['title' => 'Resort Exploration', 'description' => 'Explore the resort facilities and relax', 'location' => 'Resort', 'start_time' => '15:00', 'end_time' => '18:00', 'type' => 'activity'],
        ]);

        // Day 2: Snorkeling & Water Activities
        $day2 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 2],
            [
                'title' => 'Snorkeling & Water Activities',
                'description' => 'Enjoy snorkeling in the crystal-clear waters and explore the vibrant marine life.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day2, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast at resort', 'location' => 'Resort', 'start_time' => '08:00', 'end_time' => '09:30', 'type' => 'meal'],
            ['title' => 'Snorkeling Session', 'description' => 'Snorkeling with equipment provided', 'location' => 'House Reef', 'start_time' => '10:00', 'end_time' => '12:00', 'type' => 'activity'],
            ['title' => 'Beach Relaxation', 'description' => 'Relax on the private beach', 'location' => 'Beach', 'start_time' => '12:00', 'end_time' => '15:00', 'type' => 'activity'],
            ['title' => 'Sunset Cruise', 'description' => 'Evening sunset cruise with refreshments', 'location' => 'Ocean', 'start_time' => '17:00', 'end_time' => '19:00', 'type' => 'activity'],
        ]);

        // Day 3: Island Hopping
        $day3 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 3],
            [
                'title' => 'Island Hopping Tour',
                'description' => 'Visit nearby islands and experience local Maldivian culture.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day3, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Resort', 'start_time' => '08:00', 'end_time' => '09:30', 'type' => 'meal'],
            ['title' => 'Island Hopping Tour', 'description' => 'Visit local islands and experience Maldivian culture', 'location' => 'Local Islands', 'start_time' => '10:00', 'end_time' => '15:00', 'type' => 'activity'],
            ['title' => 'Resort Activities', 'description' => 'Enjoy resort facilities - spa, gym, or water sports', 'location' => 'Resort', 'start_time' => '15:30', 'end_time' => '18:00', 'type' => 'activity'],
        ]);

        // Day 4: Departure
        $day4 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 4],
            [
                'title' => 'Departure from Maldives',
                'description' => 'Check-out and transfer to airport for departure.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day4, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Resort', 'start_time' => '08:00', 'end_time' => '09:30', 'type' => 'meal'],
            ['title' => 'Resort Check-out', 'description' => 'Check-out from resort', 'location' => 'Resort', 'start_time' => '11:00', 'end_time' => '12:00', 'type' => 'accommodation'],
            ['title' => 'Airport Transfer', 'description' => 'Transfer to Velana Airport', 'location' => 'Velana Airport', 'start_time' => '12:30', 'end_time' => '13:30', 'type' => 'transport'],
        ]);
    }

    private function createPhuketItinerary($user)
    {
        $thailand = Country::where('iso_code', 'TH')->first();
        if (!$thailand) {
            $thailand = Country::create([
                'name' => 'Thailand',
                'code' => 'THA',
                'iso_code' => 'TH',
                'phone_code' => '+66',
                'currency_code' => 'THB',
                'currency_symbol' => '฿',
                'capital' => 'Bangkok',
                'continent' => 'Asia',
                'is_active' => true,
            ]);
        }

        $phuket = Destination::firstOrCreate([
            'name' => 'Phuket',
            'slug' => 'phuket',
            'country_id' => $thailand->id,
            'type' => 'city',
            'is_active' => true,
        ]);

        $itinerary = Itinerary::updateOrCreate(
            ['slug' => 'phuket-3-nights-4-days'],
            [
                'name' => 'Phuket 3 Nights / 4 Days - Beach Paradise',
                'tagline' => 'Discover the pearl of the Andaman Sea with stunning beaches and vibrant nightlife',
                'description' => 'Experience the tropical paradise of Phuket, Thailand\'s largest island. Known for its stunning beaches, vibrant nightlife, and rich cultural heritage, Phuket offers something for everyone. Relax on pristine beaches, explore hidden coves, visit ancient temples, enjoy thrilling water sports, and indulge in world-class dining. From the bustling Patong Beach to the tranquil Phi Phi Islands, Phuket is the perfect destination for beach lovers and adventure seekers.',
                'duration_days' => 4,
                'country_id' => $thailand->id,
                'destination_id' => $phuket->id,
                'status' => 'published',
                'user_id' => $user->id,
                'is_master' => true,
                'slug' => 'phuket-3-nights-4-days',
                'terms_conditions' => 'Terms and conditions apply. Valid passport required. Travel insurance recommended.',
                'cancellation_policy' => 'Cancellation policy: 50% refund if cancelled 10 days before travel, 25% refund if cancelled 5 days before travel.',
                'inclusions' => [
                    '03 Nights Hotel Stay in Phuket',
                    'Daily Breakfast',
                    'Airport Transfers (Private)',
                    'Phi Phi Islands Day Tour with Lunch',
                    'Phuket City & Temple Tour',
                    'Big Buddha & Viewpoint Visit',
                    'Beach Activities',
                    'All Entrance Fees',
                ],
                'exclusions' => [
                    'International & Domestic Airfare',
                    'Visa Charges',
                    'Meals other than specified',
                    'Personal Expenses',
                    'Travel Insurance',
                    'Optional Tours',
                    'Anything not mentioned in Inclusions',
                ],
                'meta_title' => 'Phuket 3 Nights 4 Days Package - Best Phuket Itinerary',
                'meta_description' => 'Explore Phuket with our 3 nights 4 days itinerary. Includes Phi Phi Islands, beaches, temples, and city tours.',
                'meta_keywords' => ['Phuket', 'Thailand', 'Phi Phi Islands', 'Patong Beach', 'Big Buddha', 'Phuket Temples'],
            ]
        );

        $this->createPhuketDays($itinerary);
    }

    private function createPhuketDays($itinerary)
    {
        // Day 1: Arrival
        $day1 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 1],
            [
                'title' => 'Arrival in Phuket',
                'description' => 'Arrive at Phuket International Airport and transfer to hotel. Evening at leisure.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day1, [
            ['title' => 'Airport Arrival', 'description' => 'Arrive at Phuket Airport', 'location' => 'Phuket Airport', 'start_time' => '12:00', 'end_time' => '13:00', 'type' => 'transport'],
            ['title' => 'Hotel Transfer', 'description' => 'Private transfer to hotel', 'location' => 'Phuket Hotel', 'start_time' => '13:00', 'end_time' => '14:00', 'type' => 'transport'],
            ['title' => 'Hotel Check-in', 'description' => 'Check-in and relax', 'location' => 'Phuket Hotel', 'start_time' => '14:00', 'end_time' => '15:00', 'type' => 'accommodation'],
            ['title' => 'Beach Time', 'description' => 'Relax at Patong Beach or hotel pool', 'location' => 'Patong Beach', 'start_time' => '15:30', 'end_time' => '18:00', 'type' => 'activity'],
        ]);

        // Day 2: Phi Phi Islands
        $day2 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 2],
            [
                'title' => 'Phi Phi Islands Day Tour',
                'description' => 'Full-day tour to the stunning Phi Phi Islands with snorkeling and lunch.',
                'meals' => ['breakfast', 'lunch'],
            ]
        );

        $this->createDayItems($day2, [
            ['title' => 'Breakfast', 'description' => 'Early breakfast at hotel', 'location' => 'Phuket Hotel', 'start_time' => '07:00', 'end_time' => '08:00', 'type' => 'meal'],
            ['title' => 'Phi Phi Islands Tour', 'description' => 'Speedboat tour to Phi Phi Islands with snorkeling, Maya Bay, and Monkey Beach', 'location' => 'Phi Phi Islands', 'start_time' => '08:30', 'end_time' => '17:00', 'type' => 'activity'],
            ['title' => 'Lunch on Phi Phi', 'description' => 'Lunch included on Phi Phi Don', 'location' => 'Phi Phi Don', 'start_time' => '13:00', 'end_time' => '14:00', 'type' => 'meal'],
        ]);

        // Day 3: City & Temple Tour
        $day3 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 3],
            [
                'title' => 'Phuket City & Big Buddha Tour',
                'description' => 'Explore Phuket Old Town, visit Big Buddha, and enjoy panoramic views.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day3, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Phuket Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Big Buddha', 'description' => 'Visit the iconic Big Buddha statue', 'location' => 'Big Buddha', 'start_time' => '09:30', 'end_time' => '11:00', 'type' => 'activity'],
            ['title' => 'Karon Viewpoint', 'description' => 'Panoramic views of three beaches', 'location' => 'Karon Viewpoint', 'start_time' => '11:30', 'end_time' => '12:30', 'type' => 'activity'],
            ['title' => 'Phuket Old Town', 'description' => 'Explore Sino-Portuguese architecture', 'location' => 'Phuket Old Town', 'start_time' => '14:00', 'end_time' => '16:00', 'type' => 'activity'],
            ['title' => 'Wat Chalong Temple', 'description' => 'Visit the most important temple in Phuket', 'location' => 'Wat Chalong', 'start_time' => '16:30', 'end_time' => '17:30', 'type' => 'activity'],
        ]);

        // Day 4: Departure
        $day4 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 4],
            [
                'title' => 'Departure from Phuket',
                'description' => 'Check-out and transfer to airport.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day4, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Phuket Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Hotel Check-out', 'description' => 'Check-out from hotel', 'location' => 'Phuket Hotel', 'start_time' => '11:00', 'end_time' => '12:00', 'type' => 'accommodation'],
            ['title' => 'Airport Transfer', 'description' => 'Transfer to Phuket Airport', 'location' => 'Phuket Airport', 'start_time' => '12:00', 'end_time' => '13:00', 'type' => 'transport'],
        ]);
    }

    private function createAzerbaijanItinerary($user)
    {
        $azerbaijan = Country::firstOrCreate([
            'name' => 'Azerbaijan',
            'code' => 'AZE',
            'iso_code' => 'AZ',
            'phone_code' => '+994',
            'currency_code' => 'AZN',
            'currency_symbol' => '₼',
            'capital' => 'Baku',
            'continent' => 'Asia',
            'is_active' => true,
        ]);

        $baku = Destination::firstOrCreate([
            'name' => 'Baku',
            'slug' => 'baku',
            'country_id' => $azerbaijan->id,
            'type' => 'city',
            'is_active' => true,
        ]);

        $itinerary = Itinerary::updateOrCreate(
            ['slug' => 'azerbaijan-4-nights-5-days'],
            [
                'name' => 'Azerbaijan 4 Nights / 5 Days - Land of Fire',
                'tagline' => 'Discover the fascinating blend of ancient history and modern architecture in the Land of Fire',
                'description' => 'Explore Azerbaijan, a country where ancient history meets modern innovation. From the stunning architecture of Baku\'s Old City to the natural wonder of Yanar Dag (Fire Mountain), Azerbaijan offers a unique travel experience. Discover ancient petroglyphs, visit historic mosques and palaces, explore the Caspian Sea coastline, and experience the rich culture and cuisine of this fascinating country.',
                'duration_days' => 5,
                'country_id' => $azerbaijan->id,
                'destination_id' => $baku->id,
                'status' => 'published',
                'user_id' => $user->id,
                'is_master' => true,
                'slug' => 'azerbaijan-4-nights-5-days',
                'terms_conditions' => 'Terms and conditions apply. Valid passport required. Visa may be required for some nationalities.',
                'cancellation_policy' => 'Cancellation policy: 50% refund if cancelled 14 days before travel, 25% refund if cancelled 7 days before travel.',
                'inclusions' => [
                    '04 Nights Hotel Stay in Baku',
                    'Daily Breakfast',
                    'Airport Transfers (Private)',
                    'Baku City Tour',
                    'Old City & Maiden Tower Visit',
                    'Yanar Dag (Fire Mountain) Tour',
                    'Gobustan Petroglyphs Tour',
                    'Ateshgah Fire Temple Visit',
                    'All Entrance Fees',
                ],
                'exclusions' => [
                    'International Airfare',
                    'Visa Charges',
                    'Meals other than specified',
                    'Personal Expenses',
                    'Travel Insurance',
                    'Optional Tours',
                    'Anything not mentioned in Inclusions',
                ],
                'meta_title' => 'Azerbaijan 4 Nights 5 Days Tour - Baku & Fire Mountain',
                'meta_description' => 'Explore Azerbaijan with our 4 nights 5 days itinerary. Includes Baku Old City, Fire Mountain, Gobustan, and cultural tours.',
                'meta_keywords' => ['Azerbaijan', 'Baku', 'Fire Mountain', 'Yanar Dag', 'Gobustan', 'Old City', 'Maiden Tower'],
            ]
        );

        $this->createAzerbaijanDays($itinerary);
    }

    private function createAzerbaijanDays($itinerary)
    {
        // Day 1: Arrival
        $day1 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 1],
            [
                'title' => 'Arrival in Baku',
                'description' => 'Arrive at Heydar Aliyev International Airport and transfer to hotel. Evening at leisure.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day1, [
            ['title' => 'Airport Arrival', 'description' => 'Arrive at Baku Airport', 'location' => 'Heydar Aliyev Airport', 'start_time' => '14:00', 'end_time' => '15:00', 'type' => 'transport'],
            ['title' => 'Hotel Transfer', 'description' => 'Transfer to hotel', 'location' => 'Baku Hotel', 'start_time' => '15:00', 'end_time' => '16:00', 'type' => 'transport'],
            ['title' => 'Hotel Check-in', 'description' => 'Check-in and relax', 'location' => 'Baku Hotel', 'start_time' => '16:00', 'end_time' => '17:00', 'type' => 'accommodation'],
        ]);

        // Day 2: Baku City Tour
        $day2 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 2],
            [
                'title' => 'Baku City Tour - Old City & Maiden Tower',
                'description' => 'Explore the historic Old City of Baku, a UNESCO World Heritage Site, and visit the iconic Maiden Tower.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day2, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Baku Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Old City Tour', 'description' => 'Explore Icherisheher (Old City) with ancient walls', 'location' => 'Old City', 'start_time' => '09:30', 'end_time' => '12:00', 'type' => 'activity'],
            ['title' => 'Maiden Tower', 'description' => 'Visit the iconic Maiden Tower', 'location' => 'Maiden Tower', 'start_time' => '12:00', 'end_time' => '13:00', 'type' => 'activity'],
            ['title' => 'Shirvanshahs Palace', 'description' => 'Visit the historic palace complex', 'location' => 'Old City', 'start_time' => '14:00', 'end_time' => '16:00', 'type' => 'activity'],
            ['title' => 'Flame Towers', 'description' => 'View the modern Flame Towers', 'location' => 'Flame Towers', 'start_time' => '16:30', 'end_time' => '17:30', 'type' => 'activity'],
        ]);

        // Day 3: Fire Mountain & Fire Temple
        $day3 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 3],
            [
                'title' => 'Yanar Dag & Ateshgah Fire Temple',
                'description' => 'Visit the natural fire phenomenon at Yanar Dag and the ancient Zoroastrian fire temple.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day3, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Baku Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Yanar Dag', 'description' => 'Visit the Fire Mountain - natural gas fires', 'location' => 'Yanar Dag', 'start_time' => '09:30', 'end_time' => '11:30', 'type' => 'activity'],
            ['title' => 'Ateshgah Fire Temple', 'description' => 'Visit the ancient Zoroastrian fire temple', 'location' => 'Ateshgah', 'start_time' => '12:00', 'end_time' => '13:30', 'type' => 'activity'],
            ['title' => 'Caspian Sea Promenade', 'description' => 'Walk along the Caspian Sea waterfront', 'location' => 'Baku Boulevard', 'start_time' => '16:00', 'end_time' => '18:00', 'type' => 'activity'],
        ]);

        // Day 4: Gobustan
        $day4 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 4],
            [
                'title' => 'Gobustan Petroglyphs & Mud Volcanoes',
                'description' => 'Visit the UNESCO World Heritage Site of Gobustan with ancient rock art and mud volcanoes.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day4, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Baku Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Gobustan Petroglyphs', 'description' => 'Explore ancient rock carvings (UNESCO site)', 'location' => 'Gobustan', 'start_time' => '09:30', 'end_time' => '12:00', 'type' => 'activity'],
            ['title' => 'Mud Volcanoes', 'description' => 'Visit the unique mud volcanoes', 'location' => 'Gobustan', 'start_time' => '12:30', 'end_time' => '14:00', 'type' => 'activity'],
            ['title' => 'Return to Baku', 'description' => 'Return to hotel', 'location' => 'Baku Hotel', 'start_time' => '15:00', 'end_time' => '16:00', 'type' => 'transport'],
        ]);

        // Day 5: Departure
        $day5 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 5],
            [
                'title' => 'Departure from Baku',
                'description' => 'Check-out and transfer to airport.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day5, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Baku Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Hotel Check-out', 'description' => 'Check-out from hotel', 'location' => 'Baku Hotel', 'start_time' => '11:00', 'end_time' => '12:00', 'type' => 'accommodation'],
            ['title' => 'Airport Transfer', 'description' => 'Transfer to airport', 'location' => 'Heydar Aliyev Airport', 'start_time' => '12:00', 'end_time' => '13:00', 'type' => 'transport'],
        ]);
    }

    private function createGeorgiaItinerary($user)
    {
        $georgia = Country::firstOrCreate([
            'name' => 'Georgia',
            'code' => 'GEO',
            'iso_code' => 'GE',
            'phone_code' => '+995',
            'currency_code' => 'GEL',
            'currency_symbol' => '₾',
            'capital' => 'Tbilisi',
            'continent' => 'Asia',
            'is_active' => true,
        ]);

        $tbilisi = Destination::firstOrCreate([
            'name' => 'Tbilisi',
            'slug' => 'tbilisi',
            'country_id' => $georgia->id,
            'type' => 'city',
            'is_active' => true,
        ]);

        $itinerary = Itinerary::updateOrCreate(
            ['slug' => 'georgia-4-nights-5-days'],
            [
                'name' => 'Georgia 4 Nights / 5 Days - Caucasus Gem',
                'tagline' => 'Discover the ancient culture, stunning landscapes, and legendary hospitality of Georgia',
                'description' => 'Explore Georgia, a country at the crossroads of Europe and Asia, known for its ancient history, stunning mountain landscapes, and world-famous wine culture. From the charming capital of Tbilisi with its historic Old Town and sulfur baths, to the ancient cave city of Uplistsikhe, and the wine region of Kakheti, Georgia offers a unique blend of culture, history, and natural beauty. Experience traditional Georgian hospitality, taste authentic cuisine, and discover why this country is called the "cradle of wine".',
                'duration_days' => 5,
                'country_id' => $georgia->id,
                'destination_id' => $tbilisi->id,
                'status' => 'published',
                'user_id' => $user->id,
                'is_master' => true,
                'slug' => 'georgia-4-nights-5-days',
                'terms_conditions' => 'Terms and conditions apply. Valid passport required. Visa-free for many nationalities.',
                'cancellation_policy' => 'Cancellation policy: 50% refund if cancelled 14 days before travel, 25% refund if cancelled 7 days before travel.',
                'inclusions' => [
                    '04 Nights Hotel Stay in Tbilisi',
                    'Daily Breakfast',
                    'Airport Transfers (Private)',
                    'Tbilisi City Tour',
                    'Old Town & Narikala Fortress',
                    'Kakheti Wine Region Tour',
                    'Uplistsikhe Cave City Visit',
                    'Traditional Georgian Dinner',
                    'All Entrance Fees',
                ],
                'exclusions' => [
                    'International Airfare',
                    'Visa Charges',
                    'Meals other than specified',
                    'Personal Expenses',
                    'Travel Insurance',
                    'Optional Tours',
                    'Anything not mentioned in Inclusions',
                ],
                'meta_title' => 'Georgia 4 Nights 5 Days Tour - Tbilisi & Wine Region',
                'meta_description' => 'Explore Georgia with our 4 nights 5 days itinerary. Includes Tbilisi, Kakheti wine region, Uplistsikhe, and cultural experiences.',
                'meta_keywords' => ['Georgia', 'Tbilisi', 'Kakheti', 'Wine', 'Uplistsikhe', 'Caucasus', 'Georgian Culture'],
            ]
        );

        $this->createGeorgiaDays($itinerary);
    }

    private function createGeorgiaDays($itinerary)
    {
        // Day 1: Arrival
        $day1 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 1],
            [
                'title' => 'Arrival in Tbilisi',
                'description' => 'Arrive at Tbilisi International Airport and transfer to hotel. Evening at leisure.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day1, [
            ['title' => 'Airport Arrival', 'description' => 'Arrive at Tbilisi Airport', 'location' => 'Tbilisi Airport', 'start_time' => '14:00', 'end_time' => '15:00', 'type' => 'transport'],
            ['title' => 'Hotel Transfer', 'description' => 'Transfer to hotel', 'location' => 'Tbilisi Hotel', 'start_time' => '15:00', 'end_time' => '16:00', 'type' => 'transport'],
            ['title' => 'Hotel Check-in', 'description' => 'Check-in and relax', 'location' => 'Tbilisi Hotel', 'start_time' => '16:00', 'end_time' => '17:00', 'type' => 'accommodation'],
        ]);

        // Day 2: Tbilisi City Tour
        $day2 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 2],
            [
                'title' => 'Tbilisi City Tour - Old Town & Narikala',
                'description' => 'Explore the historic Old Town of Tbilisi, visit Narikala Fortress, and enjoy the sulfur baths district.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day2, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Tbilisi Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Old Town Tour', 'description' => 'Explore the historic Old Town with narrow streets', 'location' => 'Old Tbilisi', 'start_time' => '09:30', 'end_time' => '12:00', 'type' => 'activity'],
            ['title' => 'Narikala Fortress', 'description' => 'Visit the ancient fortress overlooking the city', 'location' => 'Narikala', 'start_time' => '12:30', 'end_time' => '14:00', 'type' => 'activity'],
            ['title' => 'Peace Bridge', 'description' => 'Walk across the modern Peace Bridge', 'location' => 'Peace Bridge', 'start_time' => '14:30', 'end_time' => '15:30', 'type' => 'activity'],
            ['title' => 'Sulfur Baths District', 'description' => 'Explore the historic Abanotubani district', 'location' => 'Abanotubani', 'start_time' => '16:00', 'end_time' => '17:00', 'type' => 'activity'],
        ]);

        // Day 3: Kakheti Wine Region
        $day3 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 3],
            [
                'title' => 'Kakheti Wine Region Tour',
                'description' => 'Full-day tour to the famous Kakheti wine region, visit wineries, and taste Georgian wines.',
                'meals' => ['breakfast', 'lunch'],
            ]
        );

        $this->createDayItems($day3, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Tbilisi Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Drive to Kakheti', 'description' => 'Scenic drive to the wine region', 'location' => 'Kakheti', 'start_time' => '09:00', 'end_time' => '11:00', 'type' => 'transport'],
            ['title' => 'Winery Visit', 'description' => 'Tour and wine tasting at traditional winery', 'location' => 'Winery', 'start_time' => '11:00', 'end_time' => '13:00', 'type' => 'activity'],
            ['title' => 'Lunch', 'description' => 'Traditional Georgian lunch', 'location' => 'Kakheti', 'start_time' => '13:00', 'end_time' => '14:30', 'type' => 'meal'],
            ['title' => 'Bodbe Monastery', 'description' => 'Visit the historic monastery', 'location' => 'Bodbe', 'start_time' => '15:00', 'end_time' => '16:30', 'type' => 'activity'],
            ['title' => 'Return to Tbilisi', 'description' => 'Return to hotel', 'location' => 'Tbilisi Hotel', 'start_time' => '17:00', 'end_time' => '19:00', 'type' => 'transport'],
        ]);

        // Day 4: Uplistsikhe Cave City
        $day4 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 4],
            [
                'title' => 'Uplistsikhe Cave City & Mtskheta',
                'description' => 'Visit the ancient cave city of Uplistsikhe and the historic town of Mtskheta.',
                'meals' => ['breakfast', 'dinner'],
            ]
        );

        $this->createDayItems($day4, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Tbilisi Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Uplistsikhe Cave City', 'description' => 'Explore the ancient rock-hewn cave city', 'location' => 'Uplistsikhe', 'start_time' => '09:30', 'end_time' => '12:00', 'type' => 'activity'],
            ['title' => 'Mtskheta Tour', 'description' => 'Visit the ancient capital and Svetitskhoveli Cathedral', 'location' => 'Mtskheta', 'start_time' => '13:00', 'end_time' => '15:30', 'type' => 'activity'],
            ['title' => 'Return to Tbilisi', 'description' => 'Return to hotel', 'location' => 'Tbilisi Hotel', 'start_time' => '16:00', 'end_time' => '17:00', 'type' => 'transport'],
            ['title' => 'Traditional Georgian Dinner', 'description' => 'Enjoy traditional Georgian dinner with folk show', 'location' => 'Restaurant', 'start_time' => '19:00', 'end_time' => '21:30', 'type' => 'meal'],
        ]);

        // Day 5: Departure
        $day5 = ItineraryDay::updateOrCreate(
            ['itinerary_id' => $itinerary->id, 'day_number' => 5],
            [
                'title' => 'Departure from Tbilisi',
                'description' => 'Check-out and transfer to airport.',
                'meals' => ['breakfast'],
            ]
        );

        $this->createDayItems($day5, [
            ['title' => 'Breakfast', 'description' => 'Enjoy breakfast', 'location' => 'Tbilisi Hotel', 'start_time' => '08:00', 'end_time' => '09:00', 'type' => 'meal'],
            ['title' => 'Hotel Check-out', 'description' => 'Check-out from hotel', 'location' => 'Tbilisi Hotel', 'start_time' => '11:00', 'end_time' => '12:00', 'type' => 'accommodation'],
            ['title' => 'Airport Transfer', 'description' => 'Transfer to airport', 'location' => 'Tbilisi Airport', 'start_time' => '12:00', 'end_time' => '13:00', 'type' => 'transport'],
        ]);
    }

    private function createDayItems($day, $items)
    {
        // Delete existing items for this day
        ItineraryItem::where('itinerary_day_id', $day->id)->delete();

        foreach ($items as $index => $item) {
            ItineraryItem::create([
                'itinerary_day_id' => $day->id,
                'title' => $item['title'],
                'description' => $item['description'] ?? null,
                'location' => $item['location'] ?? null,
                'start_time' => $item['start_time'] ?? null,
                'end_time' => $item['end_time'] ?? null,
                'duration_minutes' => $item['duration_minutes'] ?? null,
                'type' => $item['type'] ?? 'activity',
                'sort_order' => $index + 1,
            ]);
        }
    }
}

