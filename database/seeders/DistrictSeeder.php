<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $india = Country::where('iso_code', 'IN')->first();
        $uae = Country::where('iso_code', 'AE')->first();
        $qatar = Country::where('iso_code', 'QA')->first();
        $bahrain = Country::where('iso_code', 'BH')->first();

        if (!$india) {
            $this->command->warn('India country not found. Please run CountrySeeder first.');
            return;
        }

        // Get all states
        $states = State::where('country_id', $india->id)->get();
        
        if ($states->isEmpty()) {
            $this->command->warn('No states found. Please run StateSeeder first.');
            return;
        }

        // Districts data organized by state code
        $districtsByState = [
            // Maharashtra (MH)
            'MH' => [
                ['name' => 'Mumbai', 'code' => 'MUM'],
                ['name' => 'Pune', 'code' => 'PUN'],
                ['name' => 'Nagpur', 'code' => 'NAG'],
                ['name' => 'Nashik', 'code' => 'NAS'],
                ['name' => 'Aurangabad', 'code' => 'AUR'],
                ['name' => 'Thane', 'code' => 'THA'],
                ['name' => 'Solapur', 'code' => 'SOL'],
                ['name' => 'Kolhapur', 'code' => 'KOL'],
                ['name' => 'Sangli', 'code' => 'SAN'],
                ['name' => 'Satara', 'code' => 'SAT'],
            ],
            // Karnataka (KA)
            'KA' => [
                ['name' => 'Bangalore Urban', 'code' => 'BLR'],
                ['name' => 'Mysore', 'code' => 'MYS'],
                ['name' => 'Hubli', 'code' => 'HUB'],
                ['name' => 'Mangalore', 'code' => 'MGL'],
                ['name' => 'Belgaum', 'code' => 'BEL'],
                ['name' => 'Gulbarga', 'code' => 'GUL'],
                ['name' => 'Davangere', 'code' => 'DAV'],
                ['name' => 'Shimoga', 'code' => 'SHI'],
            ],
            // Tamil Nadu (TN)
            'TN' => [
                ['name' => 'Chennai', 'code' => 'CHE'],
                ['name' => 'Coimbatore', 'code' => 'COI'],
                ['name' => 'Madurai', 'code' => 'MAD'],
                ['name' => 'Tiruchirappalli', 'code' => 'TRI'],
                ['name' => 'Salem', 'code' => 'SAL'],
                ['name' => 'Tirunelveli', 'code' => 'TIR'],
                ['name' => 'Erode', 'code' => 'ERO'],
                ['name' => 'Vellore', 'code' => 'VEL'],
            ],
            // Gujarat (GJ)
            'GJ' => [
                ['name' => 'Ahmedabad', 'code' => 'AMD'],
                ['name' => 'Surat', 'code' => 'SUR'],
                ['name' => 'Vadodara', 'code' => 'VAD'],
                ['name' => 'Rajkot', 'code' => 'RAJ'],
                ['name' => 'Bhavnagar', 'code' => 'BHA'],
                ['name' => 'Jamnagar', 'code' => 'JAM'],
                ['name' => 'Gandhinagar', 'code' => 'GAN'],
            ],
            // Delhi (DL)
            'DL' => [
                ['name' => 'Central Delhi', 'code' => 'CD'],
                ['name' => 'North Delhi', 'code' => 'ND'],
                ['name' => 'South Delhi', 'code' => 'SD'],
                ['name' => 'East Delhi', 'code' => 'ED'],
                ['name' => 'West Delhi', 'code' => 'WD'],
                ['name' => 'New Delhi', 'code' => 'NDL'],
            ],
            // Uttar Pradesh (UP)
            'UP' => [
                ['name' => 'Lucknow', 'code' => 'LKO'],
                ['name' => 'Kanpur', 'code' => 'KAN'],
                ['name' => 'Agra', 'code' => 'AGR'],
                ['name' => 'Varanasi', 'code' => 'VAR'],
                ['name' => 'Allahabad', 'code' => 'ALL'],
                ['name' => 'Meerut', 'code' => 'MEE'],
                ['name' => 'Ghaziabad', 'code' => 'GHA'],
                ['name' => 'Noida', 'code' => 'NOI'],
            ],
            // West Bengal (WB)
            'WB' => [
                ['name' => 'Kolkata', 'code' => 'KOL'],
                ['name' => 'Howrah', 'code' => 'HOW'],
                ['name' => 'Hooghly', 'code' => 'HOO'],
                ['name' => 'North 24 Parganas', 'code' => 'N24'],
                ['name' => 'South 24 Parganas', 'code' => 'S24'],
                ['name' => 'Bardhaman', 'code' => 'BAR'],
            ],
            // Rajasthan (RJ)
            'RJ' => [
                ['name' => 'Jaipur', 'code' => 'JAI'],
                ['name' => 'Jodhpur', 'code' => 'JOD'],
                ['name' => 'Udaipur', 'code' => 'UDA'],
                ['name' => 'Kota', 'code' => 'KOT'],
                ['name' => 'Ajmer', 'code' => 'AJM'],
                ['name' => 'Bikaner', 'code' => 'BIK'],
            ],
            // Andhra Pradesh (AP)
            'AP' => [
                ['name' => 'Visakhapatnam', 'code' => 'VIS'],
                ['name' => 'Vijayawada', 'code' => 'VIJ'],
                ['name' => 'Guntur', 'code' => 'GUN'],
                ['name' => 'Nellore', 'code' => 'NEL'],
                ['name' => 'Kurnool', 'code' => 'KUR'],
            ],
            // Telangana (TG)
            'TG' => [
                ['name' => 'Hyderabad', 'code' => 'HYD'],
                ['name' => 'Warangal', 'code' => 'WAR'],
                ['name' => 'Nizamabad', 'code' => 'NIZ'],
                ['name' => 'Karimnagar', 'code' => 'KAR'],
            ],
            // Kerala (KL)
            'KL' => [
                ['name' => 'Thiruvananthapuram', 'code' => 'TVM'],
                ['name' => 'Kochi', 'code' => 'KOC'],
                ['name' => 'Kozhikode', 'code' => 'KOZ'],
                ['name' => 'Thrissur', 'code' => 'THR'],
                ['name' => 'Kannur', 'code' => 'KAN'],
            ],
            // Punjab (PB)
            'PB' => [
                ['name' => 'Ludhiana', 'code' => 'LUD'],
                ['name' => 'Amritsar', 'code' => 'AMR'],
                ['name' => 'Jalandhar', 'code' => 'JAL'],
                ['name' => 'Patiala', 'code' => 'PAT'],
            ],
            // Haryana (HR)
            'HR' => [
                ['name' => 'Gurgaon', 'code' => 'GUR'],
                ['name' => 'Faridabad', 'code' => 'FAR'],
                ['name' => 'Panipat', 'code' => 'PAN'],
                ['name' => 'Ambala', 'code' => 'AMB'],
            ],
            // Madhya Pradesh (MP)
            'MP' => [
                ['name' => 'Bhopal', 'code' => 'BHO'],
                ['name' => 'Indore', 'code' => 'IND'],
                ['name' => 'Gwalior', 'code' => 'GWA'],
                ['name' => 'Jabalpur', 'code' => 'JAB'],
            ],
            // Odisha (OD)
            'OD' => [
                ['name' => 'Bhubaneswar', 'code' => 'BHU'],
                ['name' => 'Cuttack', 'code' => 'CUT'],
                ['name' => 'Rourkela', 'code' => 'ROU'],
            ],
            // Bihar (BR)
            'BR' => [
                ['name' => 'Patna', 'code' => 'PAT'],
                ['name' => 'Gaya', 'code' => 'GAY'],
                ['name' => 'Muzaffarpur', 'code' => 'MUZ'],
            ],
            // Jharkhand (JH)
            'JH' => [
                ['name' => 'Ranchi', 'code' => 'RAN'],
                ['name' => 'Jamshedpur', 'code' => 'JAM'],
                ['name' => 'Dhanbad', 'code' => 'DHA'],
            ],
            // Assam (AS)
            'AS' => [
                ['name' => 'Guwahati', 'code' => 'GUW'],
                ['name' => 'Silchar', 'code' => 'SIL'],
                ['name' => 'Dibrugarh', 'code' => 'DIB'],
            ],
            // Himachal Pradesh (HP)
            'HP' => [
                ['name' => 'Shimla', 'code' => 'SHI'],
                ['name' => 'Kullu', 'code' => 'KUL'],
                ['name' => 'Mandi', 'code' => 'MAN'],
            ],
            // Uttarakhand (UT)
            'UT' => [
                ['name' => 'Dehradun', 'code' => 'DEH'],
                ['name' => 'Haridwar', 'code' => 'HAR'],
                ['name' => 'Nainital', 'code' => 'NAI'],
            ],
            // Chhattisgarh (CG)
            'CG' => [
                ['name' => 'Raipur', 'code' => 'RAI'],
                ['name' => 'Bilaspur', 'code' => 'BIL'],
                ['name' => 'Durg', 'code' => 'DUR'],
            ],
            // Goa (GA)
            'GA' => [
                ['name' => 'North Goa', 'code' => 'NG'],
                ['name' => 'South Goa', 'code' => 'SG'],
            ],
        ];

        $totalDistricts = 0;

        // Create districts for each state
        foreach ($states as $state) {
            $stateCode = $state->code;
            
            if (isset($districtsByState[$stateCode])) {
                foreach ($districtsByState[$stateCode] as $districtData) {
                    District::updateOrCreate(
                        [
                            'state_id' => $state->id,
                            'code' => $districtData['code'],
                        ],
                        [
                            'name' => $districtData['name'],
                            'code' => $districtData['code'],
                            'state_id' => $state->id,
                            'country_id' => $india->id,
                            'is_active' => true,
                        ]
                    );
                    $totalDistricts++;
                }
            } else {
                // For states without specific districts, create at least one default district
                $defaultDistrictName = $state->name . ' District';
                District::updateOrCreate(
                    [
                        'state_id' => $state->id,
                        'code' => $stateCode . '-01',
                    ],
                    [
                        'name' => $defaultDistrictName,
                        'code' => $stateCode . '-01',
                        'state_id' => $state->id,
                        'country_id' => $india->id,
                        'is_active' => true,
                    ]
                );
                $totalDistricts++;
            }
        }

        // Add districts for UAE if states exist
        if ($uae) {
            $uaeStates = State::where('country_id', $uae->id)->get();
            
            foreach ($uaeStates as $emirate) {
                // Create main city/district for each emirate
                $districtName = $emirate->name . ' City';
                District::updateOrCreate(
                    [
                        'state_id' => $emirate->id,
                        'code' => $emirate->code . '-CITY',
                    ],
                    [
                        'name' => $districtName,
                        'code' => $emirate->code . '-CITY',
                        'state_id' => $emirate->id,
                        'country_id' => $uae->id,
                        'is_active' => true,
                    ]
                );
                $totalDistricts++;
            }
        }

        // Add districts for Qatar if states exist
        if ($qatar) {
            $qatarStates = State::where('country_id', $qatar->id)->get();
            
            foreach ($qatarStates as $municipality) {
                // Create main city/district for each municipality
                $districtName = $municipality->name . ' Municipality';
                District::updateOrCreate(
                    [
                        'state_id' => $municipality->id,
                        'code' => $municipality->code . '-MUN',
                    ],
                    [
                        'name' => $districtName,
                        'code' => $municipality->code . '-MUN',
                        'state_id' => $municipality->id,
                        'country_id' => $qatar->id,
                        'is_active' => true,
                    ]
                );
                $totalDistricts++;
            }
        }

        // Add districts for Bahrain if states exist
        if ($bahrain) {
            $bahrainStates = State::where('country_id', $bahrain->id)->get();
            
            foreach ($bahrainStates as $governorate) {
                // Create main city/district for each governorate
                $districtName = $governorate->name . ' Governorate';
                District::updateOrCreate(
                    [
                        'state_id' => $governorate->id,
                        'code' => $governorate->code . '-GOV',
                    ],
                    [
                        'name' => $districtName,
                        'code' => $governorate->code . '-GOV',
                        'state_id' => $governorate->id,
                        'country_id' => $bahrain->id,
                        'is_active' => true,
                    ]
                );
                $totalDistricts++;
            }
        }

        $this->command->info("Created/Updated {$totalDistricts} districts.");
    }
}
