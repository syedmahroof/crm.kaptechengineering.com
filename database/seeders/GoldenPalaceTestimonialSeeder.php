<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class GoldenPalaceTestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Ashwanth Kok',
                'location' => 'Calicut, Kerala',
                'rating' => 5,
                'review' => 'Such an awesome experience of a one day staff trip. Golden Palace as always kept the promises and gave the best memorable experience with affordable price. Special thanks to beloved Joshi Sir and our team man Mr. Jawad.',
                'trip_type' => 'Staff Trip',
                'trip_date' => '2024-01-15',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ejas Ahmed',
                'location' => 'Malappuram, Kerala',
                'rating' => 5,
                'review' => 'Thanks, Golden Palace Travels and Tours for your Excellent service during our Delhi-Agra family trip. You made our complete trip very smooth and memorable. Great service from the team and best wishes for your future. Highly recommended. Once again thanks for being an author in writing our happiness.',
                'trip_type' => 'Family Trip',
                'trip_date' => '2024-02-10',
                'image' => 'assets/images/user-02.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Alvin Thomas',
                'location' => 'Kochi, Kerala',
                'rating' => 5,
                'review' => 'Golden Palace Tours provided exceptional service for our honeymoon trip to Switzerland. Every detail was perfectly planned, from accommodation to sightseeing. The team was professional and responsive throughout the journey. Highly recommended for international travel!',
                'trip_type' => 'Honeymoon',
                'trip_date' => '2024-01-25',
                'image' => 'assets/images/user-03.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Priya Menon',
                'location' => 'Thrissur, Kerala',
                'rating' => 5,
                'review' => 'Amazing experience with Golden Palace Tours! They organized our group trip to Dubai and everything was flawless. The tour guide was knowledgeable, hotels were excellent, and the itinerary was perfectly balanced. Will definitely book with them again.',
                'trip_type' => 'Group Tour',
                'trip_date' => '2024-02-05',
                'image' => 'assets/images/user-04.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Rajesh Kumar',
                'location' => 'Kozhikode, Kerala',
                'rating' => 5,
                'review' => 'Outstanding service for our pilgrimage tour to Kashi and Haridwar. Golden Palace Tours handled all the arrangements with great care and attention to detail. The spiritual journey was made comfortable and memorable. Thank you for the excellent service!',
                'trip_type' => 'Pilgrimage Tour',
                'trip_date' => '2024-01-20',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Sneha Nair',
                'location' => 'Kollam, Kerala',
                'rating' => 5,
                'review' => 'Golden Palace Tours made our Thailand family vacation absolutely perfect! From visa assistance to hotel bookings and local transportation, everything was handled professionally. The kids had a wonderful time and we parents could relax knowing everything was taken care of.',
                'trip_type' => 'Family Vacation',
                'trip_date' => '2024-02-15',
                'image' => 'assets/images/user-02.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Vikram Pillai',
                'location' => 'Kannur, Kerala',
                'rating' => 5,
                'review' => 'Excellent service for our business trip to Singapore. Golden Palace Tours provided seamless travel arrangements and even helped with meeting schedules. The team understands business travel needs and delivers accordingly. Highly professional!',
                'trip_type' => 'Business Travel',
                'trip_date' => '2024-01-30',
                'image' => 'assets/images/user-03.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Meera Suresh',
                'location' => 'Palakkad, Kerala',
                'rating' => 5,
                'review' => 'Golden Palace Tours organized our adventure trip to Nepal and it was absolutely fantastic! Trekking in the Himalayas was made safe and enjoyable with their expert guides. The accommodation and meals were top-notch. Adventure seekers should definitely choose Golden Palace!',
                'trip_type' => 'Adventure Travel',
                'trip_date' => '2024-02-20',
                'image' => 'assets/images/user-04.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Anoop Krishnan',
                'location' => 'Kochi, Kerala',
                'rating' => 5,
                'review' => 'Outstanding service for our European tour! Golden Palace Tours provided excellent value for money with premium accommodations and well-planned itineraries. The tour manager was knowledgeable and made our 15-day Europe trip memorable. Highly recommended!',
                'trip_type' => 'European Tour',
                'trip_date' => '2024-01-10',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Deepa Ravi',
                'location' => 'Thiruvananthapuram, Kerala',
                'rating' => 5,
                'review' => 'Golden Palace Tours made our Maldives honeymoon absolutely magical! From the moment we landed to our departure, everything was perfectly arranged. The resort was beautiful, activities were well-planned, and the service was exceptional. Thank you for making our special trip unforgettable!',
                'trip_type' => 'Honeymoon',
                'trip_date' => '2024-02-25',
                'image' => 'assets/images/user-02.jpg',
                'verified' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Suresh Namboothiri',
                'location' => 'Kochi, Kerala',
                'rating' => 5,
                'review' => 'Excellent service for our corporate retreat to Goa. Golden Palace Tours handled all arrangements for 50+ employees with precision. The team building activities, accommodation, and transportation were all perfectly organized. Great value for money and professional service!',
                'trip_type' => 'Corporate Retreat',
                'trip_date' => '2024-01-05',
                'image' => 'assets/images/user-03.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Lakshmi Devi',
                'location' => 'Alappuzha, Kerala',
                'rating' => 5,
                'review' => 'Golden Palace Tours provided exceptional service for our senior citizens group tour to Kashmir. They took special care of all our needs, provided comfortable transportation, and ensured everyone was safe and comfortable throughout the journey. Highly recommended for group tours!',
                'trip_type' => 'Senior Citizens Tour',
                'trip_date' => '2024-02-01',
                'image' => 'assets/images/user-04.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 12,
            ],
            [
                'name' => 'Arjun Menon',
                'location' => 'Kochi, Kerala',
                'rating' => 5,
                'review' => 'Amazing experience with Golden Palace Tours for our Japan trip! The cherry blossom season tour was perfectly timed and the itinerary was well-balanced. The tour guide was fluent in Japanese and made our cultural experience authentic. Will definitely travel with them again!',
                'trip_type' => 'Cultural Tour',
                'trip_date' => '2024-03-01',
                'image' => 'assets/images/user-01.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 13,
            ],
            [
                'name' => 'Radha Krishnan',
                'location' => 'Kottayam, Kerala',
                'rating' => 5,
                'review' => 'Golden Palace Tours organized our educational tour to Delhi and Agra for our school students. The safety measures were excellent, educational content was well-planned, and the students had a wonderful learning experience. The team was patient and professional with the children.',
                'trip_type' => 'Educational Tour',
                'trip_date' => '2024-01-18',
                'image' => 'assets/images/user-02.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 14,
            ],
            [
                'name' => 'Gopalakrishnan Nair',
                'location' => 'Kochi, Kerala',
                'rating' => 5,
                'review' => 'Outstanding service for our medical tourism trip to Thailand. Golden Palace Tours coordinated everything from medical appointments to recovery accommodation. They understood our specific needs and provided personalized service. Highly professional and caring team!',
                'trip_type' => 'Medical Tourism',
                'trip_date' => '2024-02-12',
                'image' => 'assets/images/user-03.jpg',
                'verified' => true,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 15,
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                [
                    'name' => $testimonial['name'],
                    'trip_date' => $testimonial['trip_date']
                ],
                $testimonial
            );
        }
    }
}






