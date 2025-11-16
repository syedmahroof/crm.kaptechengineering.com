<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'United States',
                'code' => 'USA',
                'iso_code' => 'US',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'phone_code' => '+1',
                'capital' => 'Washington, D.C.',
                'continent' => 'North America',
                'description' => 'The United States of America is a federal republic consisting of 50 states.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GBR',
                'iso_code' => 'GB',
                'currency_code' => 'GBP',
                'currency_symbol' => '£',
                'phone_code' => '+44',
                'capital' => 'London',
                'continent' => 'Europe',
                'description' => 'The United Kingdom is a sovereign country located off the northwestern coast of mainland Europe.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Canada',
                'code' => 'CAN',
                'iso_code' => 'CA',
                'currency_code' => 'CAD',
                'currency_symbol' => 'C$',
                'phone_code' => '+1',
                'capital' => 'Ottawa',
                'continent' => 'North America',
                'description' => 'Canada is a country in North America consisting of 10 provinces and 3 territories.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Australia',
                'code' => 'AUS',
                'iso_code' => 'AU',
                'currency_code' => 'AUD',
                'currency_symbol' => 'A$',
                'phone_code' => '+61',
                'capital' => 'Canberra',
                'continent' => 'Oceania',
                'description' => 'Australia is a sovereign country comprising the mainland of the Australian continent.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Germany',
                'code' => 'DEU',
                'iso_code' => 'DE',
                'currency_code' => 'EUR',
                'currency_symbol' => '€',
                'phone_code' => '+49',
                'capital' => 'Berlin',
                'continent' => 'Europe',
                'description' => 'Germany is a country in Central Europe with a population of over 83 million.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'France',
                'code' => 'FRA',
                'iso_code' => 'FR',
                'currency_code' => 'EUR',
                'currency_symbol' => '€',
                'phone_code' => '+33',
                'capital' => 'Paris',
                'continent' => 'Europe',
                'description' => 'France is a country primarily located in Western Europe.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Japan',
                'code' => 'JPN',
                'iso_code' => 'JP',
                'currency_code' => 'JPY',
                'currency_symbol' => '¥',
                'phone_code' => '+81',
                'capital' => 'Tokyo',
                'continent' => 'Asia',
                'description' => 'Japan is an island country in East Asia located in the northwest Pacific Ocean.',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'China',
                'code' => 'CHN',
                'iso_code' => 'CN',
                'currency_code' => 'CNY',
                'currency_symbol' => '¥',
                'phone_code' => '+86',
                'capital' => 'Beijing',
                'continent' => 'Asia',
                'description' => 'China is a country in East Asia and the world\'s most populous country.',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'India',
                'code' => 'IND',
                'iso_code' => 'IN',
                'currency_code' => 'INR',
                'currency_symbol' => '₹',
                'phone_code' => '+91',
                'capital' => 'New Delhi',
                'continent' => 'Asia',
                'description' => 'India is a country in South Asia and the second-most populous country in the world.',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Brazil',
                'code' => 'BRA',
                'iso_code' => 'BR',
                'currency_code' => 'BRL',
                'currency_symbol' => 'R$',
                'phone_code' => '+55',
                'capital' => 'Brasília',
                'continent' => 'South America',
                'description' => 'Brazil is the largest country in both South America and Latin America.',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($countries as $countryData) {
            Country::updateOrCreate(
                ['iso_code' => $countryData['iso_code']],
                $countryData
            );
        }
    }
}