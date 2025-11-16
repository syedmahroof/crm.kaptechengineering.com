<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'location' => 'New York, USA',
                'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'Lansoa made our European adventure absolutely perfect! The tour package was well-organized, our guide was knowledgeable and friendly, and every detail was taken care of. We visited 8 countries in 2 weeks and everything went smoothly. Highly recommended!',
                'trip_type' => 'European Tour',
                'trip_date' => '2024-01-15',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Michael Chen',
                'location' => 'Tokyo, Japan',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'Got my visa processed in just 2 days! The team was incredibly helpful and professional throughout the process. They guided me through every step and made what seemed complicated very simple. Will definitely use their services again.',
                'trip_type' => 'Business Travel',
                'trip_date' => '2024-01-20',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Emma Rodriguez',
                'location' => 'Barcelona, Spain',
                'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'The flight booking was seamless and the prices were unbeatable. We saved over $500 compared to other sites. The customer service team was responsive and helped us with seat selection and meal preferences. Will definitely use Lansoa again!',
                'trip_type' => 'Family Vacation',
                'trip_date' => '2024-01-25',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'David Thompson',
                'location' => 'London, UK',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'Amazing experience with Lansoa! The hotel they booked for us in Bali was absolutely stunning. The travel insurance they provided gave us peace of mind, and when we had a minor issue, their 24/7 support was there immediately. Top-notch service!',
                'trip_type' => 'Honeymoon',
                'date' => '2024-02-01',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Lisa Wang',
                'location' => 'Sydney, Australia',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'The car rental service was excellent! We got a great deal on a luxury SUV for our road trip through the Swiss Alps. The car was in perfect condition and the pickup/drop-off process was smooth. The GPS navigation they provided was very helpful.',
                'trip_type' => 'Adventure Travel',
                'date' => '2024-02-05',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'James Wilson',
                'location' => 'Toronto, Canada',
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'Lansoa organized our group trip to Thailand perfectly! We were 15 people and they handled all the logistics flawlessly. From airport transfers to group activities, everything was coordinated beautifully. The local guide they provided was fantastic.',
                'trip_type' => 'Group Travel',
                'date' => '2024-02-10',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'location' => 'Madrid, Spain',
                'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'The travel insurance saved us when our flight was delayed by 6 hours. Lansoa\'s support team helped us rebook our connecting flight and arranged accommodation. Their comprehensive coverage and quick response made a stressful situation manageable.',
                'trip_type' => 'Business Travel',
                'date' => '2024-02-15',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Ahmed Hassan',
                'location' => 'Dubai, UAE',
                'image' => 'https://images.unsplash.com/photo-1507591064344-4c6ce005b128?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'Excellent visa processing service! They helped me get a multiple-entry visa for the US in record time. The documentation assistance was thorough and the status updates were regular. Highly professional and efficient service.',
                'trip_type' => 'Business Travel',
                'date' => '2024-02-20',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Sophie Martin',
                'location' => 'Paris, France',
                'image' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'The luxury tour package to Japan was worth every penny! The ryokan they booked was traditional and beautiful, the food experiences were authentic, and the cultural activities were well-planned. Lansoa truly understands luxury travel.',
                'trip_type' => 'Luxury Travel',
                'date' => '2024-02-25',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Robert Kim',
                'location' => 'Seoul, South Korea',
                'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'Outstanding service for our family trip to Italy! They arranged everything from flights to hotels to local tours. The kids loved the activities they planned, and we adults enjoyed the wine tastings. Perfect balance of family-friendly and adult experiences.',
                'trip_type' => 'Family Vacation',
                'date' => '2024-03-01',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Jennifer Lee',
                'location' => 'Vancouver, Canada',
                'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'The adventure travel package to New Zealand was incredible! From bungee jumping to glacier hiking, every activity was perfectly organized. The safety measures were top-notch and the guides were experienced. An unforgettable experience!',
                'trip_type' => 'Adventure Travel',
                'date' => '2024-03-05',
                'verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Carlos Mendez',
                'location' => 'Mexico City, Mexico',
                'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=150&h=150&fit=crop&crop=face',
                'rating' => 5,
                'review' => 'Lansoa made our destination wedding in Greece absolutely magical! They coordinated everything from venue booking to guest accommodations. The wedding planner they provided was professional and made our special day stress-free. Highly recommended!',
                'trip_type' => 'Destination Wedding',
                'date' => '2024-03-10',
                'verified' => true,
                'is_active' => true,
            ]
        ];

        foreach ($testimonials as $testimonial) {
            // Fix date field name
            if (isset($testimonial['date'])) {
                $testimonial['trip_date'] = $testimonial['date'];
                unset($testimonial['date']);
            }
            
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name'], 'trip_date' => $testimonial['trip_date']],
                $testimonial
            );
        }
    }
}
