<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FAQ;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // Booking & Reservations
            [
                'question' => 'How do I book a trip with Lansoa?',
                'answer' => 'Booking with Lansoa is simple! You can browse our destinations online, select your preferred package, and book directly through our website. You can also contact our travel experts via phone, email, or live chat for personalized assistance.',
                'category' => 'Booking & Reservations',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Can I modify or cancel my booking?',
                'answer' => 'Yes, you can modify or cancel your booking depending on the terms and conditions of your specific package. Most bookings can be modified up to 30 days before departure. Cancellation policies vary by package type and destination. Please contact our customer service team for specific details about your booking.',
                'category' => 'Booking & Reservations',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), PayPal, bank transfers, and in some cases, cryptocurrency. Payment plans are available for select packages. All transactions are secure and encrypted.',
                'category' => 'Booking & Reservations',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Travel Documents & Visas
            [
                'question' => 'Do I need a visa for international travel?',
                'answer' => 'Visa requirements vary by destination and your nationality. Our travel experts will provide detailed visa information for your specific trip. We also offer visa assistance services to help you obtain the necessary travel documents.',
                'category' => 'Travel Documents & Visas',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'question' => 'What documents do I need to travel?',
                'answer' => 'Generally, you\'ll need a valid passport (with at least 6 months validity), visa (if required), travel insurance, and any specific health certificates. We provide a comprehensive travel checklist for each destination to ensure you have all necessary documents.',
                'category' => 'Travel Documents & Visas',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'question' => 'How long does it take to get a visa?',
                'answer' => 'Visa processing times vary by country and visa type. Standard processing typically takes 5-15 business days, while express processing can take 1-3 business days. We recommend applying for visas at least 4-6 weeks before your departure date.',
                'category' => 'Travel Documents & Visas',
                'is_active' => true,
                'sort_order' => 6,
            ],

            // Travel Insurance
            [
                'question' => 'Is travel insurance included in my package?',
                'answer' => 'Basic travel insurance is included in most of our packages, but we strongly recommend upgrading to comprehensive coverage for international trips. Our insurance covers medical emergencies, trip cancellation, lost luggage, and other travel-related incidents.',
                'category' => 'Travel Insurance',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'question' => 'What does travel insurance cover?',
                'answer' => 'Our comprehensive travel insurance covers medical emergencies, trip cancellation/interruption, lost or delayed baggage, flight delays, emergency evacuation, and 24/7 emergency assistance. Coverage limits and exclusions vary by plan, so please review your policy details.',
                'category' => 'Travel Insurance',
                'is_active' => true,
                'sort_order' => 8,
            ],

            // Accommodation & Transportation
            [
                'question' => 'What type of accommodation do you provide?',
                'answer' => 'We offer a wide range of accommodations from budget-friendly hostels to luxury resorts and boutique hotels. All accommodations are carefully selected for their quality, location, and value. You can choose your preferred accommodation level when booking.',
                'category' => 'Accommodation & Transportation',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'question' => 'Are flights included in the package?',
                'answer' => 'Flight inclusion depends on your chosen package. Some packages include international flights, while others focus on ground arrangements. We can arrange flights for any package and often secure better rates than booking separately.',
                'category' => 'Accommodation & Transportation',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'question' => 'What about local transportation?',
                'answer' => 'Local transportation is included in most packages, including airport transfers, inter-city travel, and local tours. We use comfortable, reliable vehicles with experienced drivers. Private transportation options are available for an additional fee.',
                'category' => 'Accommodation & Transportation',
                'is_active' => true,
                'sort_order' => 11,
            ],

            // Health & Safety
            [
                'question' => 'What health precautions should I take?',
                'answer' => 'We provide detailed health information for each destination, including required vaccinations, health advisories, and safety tips. We recommend consulting with a travel medicine specialist 4-6 weeks before departure for personalized health advice.',
                'category' => 'Health & Safety',
                'is_active' => true,
                'sort_order' => 12,
            ],
            [
                'question' => 'Is it safe to travel to your destinations?',
                'answer' => 'Safety is our top priority. We continuously monitor travel advisories and only operate in safe destinations. We provide 24/7 emergency support and have local contacts in all our destinations. All our guides are trained in safety protocols.',
                'category' => 'Health & Safety',
                'is_active' => true,
                'sort_order' => 13,
            ],

            // Group Travel
            [
                'question' => 'Do you offer group discounts?',
                'answer' => 'Yes! We offer special rates for groups of 10 or more people. Group discounts vary by destination and package type. We also provide dedicated group coordinators and can customize itineraries for group preferences.',
                'category' => 'Group Travel',
                'is_active' => true,
                'sort_order' => 14,
            ],
            [
                'question' => 'Can I customize a group itinerary?',
                'answer' => 'Absolutely! We specialize in creating custom group itineraries tailored to your group\'s interests, budget, and schedule. Our travel experts will work with you to design the perfect group experience.',
                'category' => 'Group Travel',
                'is_active' => true,
                'sort_order' => 15,
            ],

            // Customer Support
            [
                'question' => 'What support do you provide during my trip?',
                'answer' => 'We provide 24/7 customer support throughout your journey. Our local representatives are available in all destinations, and our emergency hotline is always accessible. We also provide detailed travel documents and contact information before departure.',
                'category' => 'Customer Support',
                'is_active' => true,
                'sort_order' => 16,
            ],
            [
                'question' => 'How can I contact customer service?',
                'answer' => 'You can reach our customer service team via phone (+1-555-123-4567), email (support@lansoa.com), live chat on our website, or through our mobile app. We respond to all inquiries within 24 hours.',
                'category' => 'Customer Support',
                'is_active' => true,
                'sort_order' => 17,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
