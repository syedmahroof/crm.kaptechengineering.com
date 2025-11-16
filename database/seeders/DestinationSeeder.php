<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            // Paris, France
            [
                'name' => 'Paris',
                'description' => 'The City of Light, known for its iconic landmarks, world-class museums, and romantic atmosphere.',
                'type' => 'city',
                'country_code' => 'FR',
                'state_province' => 'Île-de-France',
                'latitude' => 48.8566,
                'longitude' => 2.3522,
                'timezone' => 'Europe/Paris',
                'currency_code' => 'EUR',
                'language' => 'French',
                'climate_data' => [
                    'average_temp_summer' => 20,
                    'average_temp_winter' => 5,
                    'best_time_to_visit' => 'April to October'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            // Tokyo, Japan
            [
                'name' => 'Tokyo',
                'description' => 'A vibrant metropolis blending traditional culture with cutting-edge technology and innovation.',
                'type' => 'city',
                'country_code' => 'JP',
                'state_province' => 'Tokyo',
                'latitude' => 35.6762,
                'longitude' => 139.6503,
                'timezone' => 'Asia/Tokyo',
                'currency_code' => 'JPY',
                'language' => 'Japanese',
                'climate_data' => [
                    'average_temp_summer' => 26,
                    'average_temp_winter' => 5,
                    'best_time_to_visit' => 'March to May, September to November'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            // New York City, USA
            [
                'name' => 'New York City',
                'description' => 'The Big Apple, a bustling metropolis known for its iconic skyline, Broadway shows, and diverse culture.',
                'type' => 'city',
                'country_code' => 'US',
                'state_province' => 'New York',
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'timezone' => 'America/New_York',
                'currency_code' => 'USD',
                'language' => 'English',
                'climate_data' => [
                    'average_temp_summer' => 24,
                    'average_temp_winter' => 1,
                    'best_time_to_visit' => 'April to June, September to November'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            // London, UK
            [
                'name' => 'London',
                'description' => 'A historic city with royal palaces, world-class museums, and a rich cultural heritage.',
                'type' => 'city',
                'country_code' => 'GB',
                'state_province' => 'England',
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'timezone' => 'Europe/London',
                'currency_code' => 'GBP',
                'language' => 'English',
                'climate_data' => [
                    'average_temp_summer' => 18,
                    'average_temp_winter' => 4,
                    'best_time_to_visit' => 'May to September'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
            ],
            // Rome, Italy
            [
                'name' => 'Rome',
                'description' => 'The Eternal City, home to ancient ruins, Renaissance art, and the Vatican City.',
                'type' => 'city',
                'country_code' => 'IT',
                'state_province' => 'Lazio',
                'latitude' => 41.9028,
                'longitude' => 12.4964,
                'timezone' => 'Europe/Rome',
                'currency_code' => 'EUR',
                'language' => 'Italian',
                'climate_data' => [
                    'average_temp_summer' => 26,
                    'average_temp_winter' => 8,
                    'best_time_to_visit' => 'April to June, September to October'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 5,
            ],
            // Sydney, Australia
            [
                'name' => 'Sydney',
                'description' => 'A stunning harbor city with iconic landmarks, beautiful beaches, and a vibrant cultural scene.',
                'type' => 'city',
                'country_code' => 'AU',
                'state_province' => 'New South Wales',
                'latitude' => -33.8688,
                'longitude' => 151.2093,
                'timezone' => 'Australia/Sydney',
                'currency_code' => 'AUD',
                'language' => 'English',
                'climate_data' => [
                    'average_temp_summer' => 23,
                    'average_temp_winter' => 12,
                    'best_time_to_visit' => 'September to November, March to May'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 6,
            ],
            // Dubai, UAE
            [
                'name' => 'Dubai',
                'description' => 'A modern metropolis in the desert, known for luxury shopping, ultramodern architecture, and vibrant nightlife.',
                'type' => 'city',
                'country_code' => 'AE',
                'state_province' => 'Dubai',
                'latitude' => 25.2048,
                'longitude' => 55.2708,
                'timezone' => 'Asia/Dubai',
                'currency_code' => 'AED',
                'language' => 'Arabic',
                'climate_data' => [
                    'average_temp_summer' => 35,
                    'average_temp_winter' => 20,
                    'best_time_to_visit' => 'November to March'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 7,
            ],
            // Barcelona, Spain
            [
                'name' => 'Barcelona',
                'description' => 'A vibrant city known for its unique architecture, beautiful beaches, and rich cultural heritage.',
                'type' => 'city',
                'country_code' => 'ES',
                'state_province' => 'Catalonia',
                'latitude' => 41.3851,
                'longitude' => 2.1734,
                'timezone' => 'Europe/Madrid',
                'currency_code' => 'EUR',
                'language' => 'Spanish',
                'climate_data' => [
                    'average_temp_summer' => 24,
                    'average_temp_winter' => 10,
                    'best_time_to_visit' => 'May to June, September to October'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 8,
            ],
            // Bangkok, Thailand
            [
                'name' => 'Bangkok',
                'description' => 'A bustling capital city known for ornate shrines, vibrant street life, and delicious street food.',
                'type' => 'city',
                'country_code' => 'TH',
                'state_province' => 'Bangkok',
                'latitude' => 13.7563,
                'longitude' => 100.5018,
                'timezone' => 'Asia/Bangkok',
                'currency_code' => 'THB',
                'language' => 'Thai',
                'climate_data' => [
                    'average_temp_summer' => 30,
                    'average_temp_winter' => 26,
                    'best_time_to_visit' => 'November to March'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 9,
            ],
            // Santorini, Greece
            [
                'name' => 'Santorini',
                'description' => 'A stunning Greek island known for its white-washed buildings, blue domes, and spectacular sunsets.',
                'type' => 'island',
                'country_code' => 'GR',
                'state_province' => 'South Aegean',
                'latitude' => 36.3932,
                'longitude' => 25.4615,
                'timezone' => 'Europe/Athens',
                'currency_code' => 'EUR',
                'language' => 'Greek',
                'climate_data' => [
                    'average_temp_summer' => 26,
                    'average_temp_winter' => 12,
                    'best_time_to_visit' => 'April to October'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($destinations as $destinationData) {
            $country = Country::where('iso_code', $destinationData['country_code'])->first();
            
            if ($country) {
                // Remove country_code from the data as it's not a column in destinations table
                $destinationDataWithoutCountryCode = $destinationData;
                unset($destinationDataWithoutCountryCode['country_code']);
                
                $destination = Destination::updateOrCreate(
                    [
                        'name' => $destinationData['name'],
                        'country_id' => $country->id,
                    ],
                    array_merge($destinationDataWithoutCountryCode, [
                        'country_id' => $country->id,
                    ])
                );
            }
        }
    }
}


