<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get countries
        $india = Country::where('iso_code', 'IN')->first();
        $uae = Country::where('iso_code', 'AE')->first();
        $qatar = Country::where('iso_code', 'QA')->first();
        $bahrain = Country::where('iso_code', 'BH')->first();

        // Create UAE, Qatar, and Bahrain if they don't exist
        if (!$uae) {
            $uae = Country::create([
                'name' => 'United Arab Emirates',
                'code' => 'ARE',
                'iso_code' => 'AE',
                'currency_code' => 'AED',
                'currency_symbol' => 'د.إ',
                'phone_code' => '+971',
                'capital' => 'Abu Dhabi',
                'continent' => 'Asia',
                'description' => 'The United Arab Emirates is a country in Western Asia.',
                'is_active' => true,
                'sort_order' => 100,
            ]);
        }

        if (!$qatar) {
            $qatar = Country::create([
                'name' => 'Qatar',
                'code' => 'QAT',
                'iso_code' => 'QA',
                'currency_code' => 'QAR',
                'currency_symbol' => 'ر.ق',
                'phone_code' => '+974',
                'capital' => 'Doha',
                'continent' => 'Asia',
                'description' => 'Qatar is a country in Western Asia.',
                'is_active' => true,
                'sort_order' => 101,
            ]);
        }

        if (!$bahrain) {
            $bahrain = Country::create([
                'name' => 'Bahrain',
                'code' => 'BHR',
                'iso_code' => 'BH',
                'currency_code' => 'BHD',
                'currency_symbol' => '.د.ب',
                'phone_code' => '+973',
                'capital' => 'Manama',
                'continent' => 'Asia',
                'description' => 'Bahrain is a country in Western Asia.',
                'is_active' => true,
                'sort_order' => 102,
            ]);
        }

        // India States (28 states + 8 union territories)
        if ($india) {
            $indiaStates = [
                ['name' => 'Andhra Pradesh', 'code' => 'AP'],
                ['name' => 'Arunachal Pradesh', 'code' => 'AR'],
                ['name' => 'Assam', 'code' => 'AS'],
                ['name' => 'Bihar', 'code' => 'BR'],
                ['name' => 'Chhattisgarh', 'code' => 'CG'],
                ['name' => 'Goa', 'code' => 'GA'],
                ['name' => 'Gujarat', 'code' => 'GJ'],
                ['name' => 'Haryana', 'code' => 'HR'],
                ['name' => 'Himachal Pradesh', 'code' => 'HP'],
                ['name' => 'Jharkhand', 'code' => 'JH'],
                ['name' => 'Karnataka', 'code' => 'KA'],
                ['name' => 'Kerala', 'code' => 'KL'],
                ['name' => 'Madhya Pradesh', 'code' => 'MP'],
                ['name' => 'Maharashtra', 'code' => 'MH'],
                ['name' => 'Manipur', 'code' => 'MN'],
                ['name' => 'Meghalaya', 'code' => 'ML'],
                ['name' => 'Mizoram', 'code' => 'MZ'],
                ['name' => 'Nagaland', 'code' => 'NL'],
                ['name' => 'Odisha', 'code' => 'OD'],
                ['name' => 'Punjab', 'code' => 'PB'],
                ['name' => 'Rajasthan', 'code' => 'RJ'],
                ['name' => 'Sikkim', 'code' => 'SK'],
                ['name' => 'Tamil Nadu', 'code' => 'TN'],
                ['name' => 'Telangana', 'code' => 'TG'],
                ['name' => 'Tripura', 'code' => 'TR'],
                ['name' => 'Uttar Pradesh', 'code' => 'UP'],
                ['name' => 'Uttarakhand', 'code' => 'UT'],
                ['name' => 'West Bengal', 'code' => 'WB'],
                ['name' => 'Andaman and Nicobar Islands', 'code' => 'AN'],
                ['name' => 'Chandigarh', 'code' => 'CH'],
                ['name' => 'Dadra and Nagar Haveli and Daman and Diu', 'code' => 'DH'],
                ['name' => 'Delhi', 'code' => 'DL'],
                ['name' => 'Jammu and Kashmir', 'code' => 'JK'],
                ['name' => 'Ladakh', 'code' => 'LA'],
                ['name' => 'Lakshadweep', 'code' => 'LD'],
                ['name' => 'Puducherry', 'code' => 'PY'],
            ];

            foreach ($indiaStates as $stateData) {
                State::updateOrCreate(
                    [
                        'country_id' => $india->id,
                        'code' => $stateData['code'],
                    ],
                    [
                        'name' => $stateData['name'],
                        'code' => $stateData['code'],
                        'country_id' => $india->id,
                        'is_active' => true,
                    ]
                );
            }
        }

        // UAE Emirates (7 emirates)
        if ($uae) {
            $uaeEmirates = [
                ['name' => 'Abu Dhabi', 'code' => 'AZ'],
                ['name' => 'Dubai', 'code' => 'DU'],
                ['name' => 'Sharjah', 'code' => 'SJ'],
                ['name' => 'Ajman', 'code' => 'AJ'],
                ['name' => 'Umm Al Quwain', 'code' => 'UQ'],
                ['name' => 'Ras Al Khaimah', 'code' => 'RK'],
                ['name' => 'Fujairah', 'code' => 'FU'],
            ];

            foreach ($uaeEmirates as $emirateData) {
                State::updateOrCreate(
                    [
                        'country_id' => $uae->id,
                        'code' => $emirateData['code'],
                    ],
                    [
                        'name' => $emirateData['name'],
                        'code' => $emirateData['code'],
                        'country_id' => $uae->id,
                        'is_active' => true,
                    ]
                );
            }
        }

        // Qatar Municipalities (8 municipalities)
        if ($qatar) {
            $qatarMunicipalities = [
                ['name' => 'Ad Dawhah', 'code' => 'DQ'],
                ['name' => 'Al Rayyan', 'code' => 'RY'],
                ['name' => 'Al Wakrah', 'code' => 'WK'],
                ['name' => 'Al Khor', 'code' => 'KH'],
                ['name' => 'Ash Shamal', 'code' => 'SM'],
                ['name' => 'Az Za\'ayin', 'code' => 'ZA'],
                ['name' => 'Umm Salal', 'code' => 'SL'],
                ['name' => 'Al Daayen', 'code' => 'AY'],
            ];

            foreach ($qatarMunicipalities as $municipalityData) {
                State::updateOrCreate(
                    [
                        'country_id' => $qatar->id,
                        'code' => $municipalityData['code'],
                    ],
                    [
                        'name' => $municipalityData['name'],
                        'code' => $municipalityData['code'],
                        'country_id' => $qatar->id,
                        'is_active' => true,
                    ]
                );
            }
        }

        // Bahrain Governorates (4 governorates)
        if ($bahrain) {
            $bahrainGovernorates = [
                ['name' => 'Capital', 'code' => 'CA'],
                ['name' => 'Muharraq', 'code' => 'MU'],
                ['name' => 'Northern', 'code' => 'NO'],
                ['name' => 'Southern', 'code' => 'SO'],
            ];

            foreach ($bahrainGovernorates as $governorateData) {
                State::updateOrCreate(
                    [
                        'country_id' => $bahrain->id,
                        'code' => $governorateData['code'],
                    ],
                    [
                        'name' => $governorateData['name'],
                        'code' => $governorateData['code'],
                        'country_id' => $bahrain->id,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}

