<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\Testimonial;
use App\Models\Country;

class HomePageDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some countries first
        $countries = [
            ['name' => 'Switzerland', 'code' => 'CH'],
            ['name' => 'Egypt', 'code' => 'EG'],
            ['name' => 'Maldives', 'code' => 'MV'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Singapore', 'code' => 'SG'],
            ['name' => 'India', 'code' => 'IN'],
        ];

        foreach ($countries as $countryData) {
            Country::firstOrCreate(
                ['code' => $countryData['code']],
                $countryData
            );
        }

        // Create international destinations
        $internationalDestinations = [
            [
                'name' => 'Switzerland',
                'type' => 'international',
                'country_id' => Country::where('code', 'CH')->first()->id,
                'description' => 'Beautiful alpine country with stunning mountains and lakes',
                'images' => ['assets/images/destination-01.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Egypt',
                'type' => 'international',
                'country_id' => Country::where('code', 'EG')->first()->id,
                'description' => 'Ancient civilization with pyramids and rich history',
                'images' => ['assets/images/destination-02.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Maldives',
                'type' => 'international',
                'country_id' => Country::where('code', 'MV')->first()->id,
                'description' => 'Tropical paradise with crystal clear waters',
                'images' => ['assets/images/destination-03.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Italy',
                'type' => 'international',
                'country_id' => Country::where('code', 'IT')->first()->id,
                'description' => 'Rich culture, art, and delicious cuisine',
                'images' => ['assets/images/destination-05.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Singapore',
                'type' => 'international',
                'country_id' => Country::where('code', 'SG')->first()->id,
                'description' => 'Modern city-state with diverse culture',
                'images' => ['assets/images/destination-06.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($internationalDestinations as $destinationData) {
            Destination::firstOrCreate(
                ['name' => $destinationData['name'], 'type' => $destinationData['type']],
                $destinationData
            );
        }

        // Create Indian destinations
        $indianDestinations = [
            [
                'name' => 'Hyderabad',
                'type' => 'indian',
                'country_id' => Country::where('code', 'IN')->first()->id,
                'state_province' => 'Telangana',
                'description' => 'City of pearls with rich history and culture',
                'images' => ['assets/images/indian-01.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Kerala',
                'type' => 'indian',
                'country_id' => Country::where('code', 'IN')->first()->id,
                'state_province' => 'Kerala',
                'description' => 'God\'s own country with backwaters and beaches',
                'images' => ['assets/images/indian-02.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Manali',
                'type' => 'indian',
                'country_id' => Country::where('code', 'IN')->first()->id,
                'state_province' => 'Himachal Pradesh',
                'description' => 'Hill station with beautiful mountains and adventure sports',
                'images' => ['assets/images/indian-03.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Rajasthan',
                'type' => 'indian',
                'country_id' => Country::where('code', 'IN')->first()->id,
                'state_province' => 'Rajasthan',
                'description' => 'Land of kings with palaces and deserts',
                'images' => ['assets/images/indian-04.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Kashmir',
                'type' => 'indian',
                'country_id' => Country::where('code', 'IN')->first()->id,
                'state_province' => 'Jammu and Kashmir',
                'description' => 'Paradise on earth with beautiful valleys',
                'images' => ['assets/images/indian-05.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Taj Mahal',
                'type' => 'indian',
                'country_id' => Country::where('code', 'IN')->first()->id,
                'state_province' => 'Uttar Pradesh',
                'description' => 'Iconic monument of love',
                'images' => ['assets/images/indian-06.jpg'],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($indianDestinations as $destinationData) {
            Destination::firstOrCreate(
                ['name' => $destinationData['name'], 'type' => $destinationData['type']],
                $destinationData
            );
        }

        // Create testimonials
        $testimonials = [
            [
                'name' => 'Ashwanth Kok',
                'location' => 'Calicut',
                'rating' => 5,
                'review' => 'Such an awesome experience of a one day staff trip. Golden Palace as always kept the promises and gave the best memorable experience with affordable price. Special thanks to beloved Joshi Sir and our team man Mr. Jawad.',
                'trip_type' => 'Staff Trip',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ejas Ahmend',
                'location' => 'Malappuram',
                'rating' => 5,
                'review' => 'Thanks, Golden Palace Travels and Tours for your Excellent service during our Delhi- Agra family trip. You made our complete trip very smooth and memorable. Great service from the team and best wishes for your future. Highly recommended. Once again thanks for being an author in writing our happiness.',
                'trip_type' => 'Family Trip',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Alvin Thomas',
                'location' => 'Cochin',
                'rating' => 5,
                'review' => 'Exceptional tour experience with Golden Palace Travels and Tours! Knowledgeable guides, well-organized itinerary, and seamless execution. They went above and beyond to make our trip memorable. Highly recommend for anyone seeking a top-notch travel adventure.',
                'trip_type' => 'Adventure Tour',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Vyshakh K',
                'location' => 'Trivandrum',
                'rating' => 4,
                'review' => 'I stayed here for a business trip and found the facilities excellent for both work and relaxation. The Royal Suite was a haven of peace after a busy day. Highly recommended for business travelers and vacationers alike.',
                'trip_type' => 'Business Trip',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Aisha M',
                'location' => 'Bangalore',
                'rating' => 5,
                'review' => 'This hotel provided the perfect balance of comfort and luxury. The Superior Balcony Room offered breathtaking views, and the attention to detail in service made it feel like a home away from home. Will definitely return!',
                'trip_type' => 'Leisure Trip',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::firstOrCreate(
                ['name' => $testimonialData['name'], 'location' => $testimonialData['location']],
                $testimonialData
            );
        }
    }
}
