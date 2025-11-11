<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class CountryStateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create India
        $india = Country::firstOrCreate(
            ['code' => 'IN'],
            [
                'name' => 'India',
                'code' => 'IN',
                'phone_code' => '+91',
                'is_active' => true,
            ]
        );

        // Indian States and their major cities/districts
        $indianStates = [
            'Andhra Pradesh' => [
                'code' => 'AP',
                'cities' => ['Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool', 'Rajahmundry', 'Tirupati', 'Kakinada', 'Kadapa', 'Anantapur'],
            ],
            'Arunachal Pradesh' => [
                'code' => 'AR',
                'cities' => ['Itanagar', 'Naharlagun', 'Tawang', 'Pasighat', 'Ziro', 'Bomdila', 'Tezu', 'Roing', 'Daporijo', 'Along'],
            ],
            'Assam' => [
                'code' => 'AS',
                'cities' => ['Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon', 'Tinsukia', 'Tezpur', 'Bongaigaon', 'Dhubri', 'Sivasagar'],
            ],
            'Bihar' => [
                'code' => 'BR',
                'cities' => ['Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Purnia', 'Darbhanga', 'Arrah', 'Bihar Sharif', 'Katihar', 'Chhapra'],
            ],
            'Chhattisgarh' => [
                'code' => 'CG',
                'cities' => ['Raipur', 'Bhilai', 'Bilaspur', 'Korba', 'Durg', 'Rajgarh', 'Raigarh', 'Jagdalpur', 'Ambikapur', 'Dhamtari'],
            ],
            'Goa' => [
                'code' => 'GA',
                'cities' => ['Panaji', 'Vasco da Gama', 'Margao', 'Mapusa', 'Ponda', 'Bicholim', 'Curchorem', 'Valpoi', 'Canacona', 'Sanguem'],
            ],
            'Gujarat' => [
                'code' => 'GJ',
                'cities' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Gandhinagar', 'Anand', 'Bharuch', 'Junagadh'],
            ],
            'Haryana' => [
                'code' => 'HR',
                'cities' => ['Faridabad', 'Gurgaon', 'Panipat', 'Ambala', 'Yamunanagar', 'Rohtak', 'Hisar', 'Karnal', 'Sonipat', 'Panchkula'],
            ],
            'Himachal Pradesh' => [
                'code' => 'HP',
                'cities' => ['Shimla', 'Mandi', 'Solan', 'Dharamshala', 'Bilaspur', 'Kullu', 'Chamba', 'Una', 'Hamirpur', 'Nahan'],
            ],
            'Jharkhand' => [
                'code' => 'JH',
                'cities' => ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Hazaribagh', 'Deoghar', 'Giridih', 'Dumka', 'Phusro', 'Adityapur'],
            ],
            'Karnataka' => [
                'code' => 'KA',
                'cities' => ['Bangalore', 'Mysore', 'Hubli', 'Mangalore', 'Belgaum', 'Gulbarga', 'Davangere', 'Bellary', 'Bijapur', 'Shimoga'],
            ],
            'Kerala' => [
                'code' => 'KL',
                'cities' => ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Alappuzha', 'Kannur', 'Kottayam', 'Palakkad', 'Malappuram'],
            ],
            'Madhya Pradesh' => [
                'code' => 'MP',
                'cities' => ['Bhopal', 'Indore', 'Gwalior', 'Jabalpur', 'Ujjain', 'Raipur', 'Sagar', 'Ratlam', 'Satna', 'Rewa'],
            ],
            'Maharashtra' => [
                'code' => 'MH',
                'cities' => ['Mumbai', 'Pune', 'Nagpur', 'Aurangabad', 'Nashik', 'Solapur', 'Thane', 'Kalyan', 'Vasai', 'Navi Mumbai'],
            ],
            'Manipur' => [
                'code' => 'MN',
                'cities' => ['Imphal', 'Thoubal', 'Bishnupur', 'Churachandpur', 'Ukhrul', 'Kakching', 'Senapati', 'Tamenglong', 'Jiribam', 'Kangpokpi'],
            ],
            'Meghalaya' => [
                'code' => 'ML',
                'cities' => ['Shillong', 'Tura', 'Jowai', 'Nongpoh', 'Baghmara', 'Williamnagar', 'Resubelpara', 'Mairang', 'Mawkyrwat', 'Amlarem'],
            ],
            'Mizoram' => [
                'code' => 'MZ',
                'cities' => ['Aizawl', 'Lunglei', 'Saiha', 'Champhai', 'Kolasib', 'Serchhip', 'Lawngtlai', 'Mamit', 'Khawzawl', 'Hnahthial'],
            ],
            'Nagaland' => [
                'code' => 'NL',
                'cities' => ['Kohima', 'Dimapur', 'Mokokchung', 'Tuensang', 'Wokha', 'Mon', 'Zunheboto', 'Phek', 'Kiphire', 'Longleng'],
            ],
            'Odisha' => [
                'code' => 'OD',
                'cities' => ['Bhubaneswar', 'Cuttack', 'Rourkela', 'Berhampur', 'Sambalpur', 'Puri', 'Baleshwar', 'Bhadrak', 'Baripada', 'Jharsuguda'],
            ],
            'Punjab' => [
                'code' => 'PB',
                'cities' => ['Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Pathankot', 'Hoshiarpur', 'Mohali', 'Moga', 'Firozpur'],
            ],
            'Rajasthan' => [
                'code' => 'RJ',
                'cities' => ['Jaipur', 'Jodhpur', 'Kota', 'Bikaner', 'Ajmer', 'Udaipur', 'Bhilwara', 'Alwar', 'Bharatpur', 'Sikar'],
            ],
            'Sikkim' => [
                'code' => 'SK',
                'cities' => ['Gangtok', 'Namchi', 'Mangan', 'Gyalshing', 'Singtam', 'Rangpo', 'Jorethang', 'Ravangla', 'Pelling', 'Lachen'],
            ],
            'Tamil Nadu' => [
                'code' => 'TN',
                'cities' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli', 'Erode', 'Vellore', 'Thoothukudi', 'Dindigul'],
            ],
            'Telangana' => [
                'code' => 'TG',
                'cities' => ['Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Ramagundam', 'Khammam', 'Mahbubnagar', 'Nalgonda', 'Adilabad', 'Siddipet'],
            ],
            'Tripura' => [
                'code' => 'TR',
                'cities' => ['Agartala', 'Udaipur', 'Dharmanagar', 'Kailasahar', 'Belonia', 'Khowai', 'Ambassa', 'Sabroom', 'Kumarghat', 'Teliamura'],
            ],
            'Uttar Pradesh' => [
                'code' => 'UP',
                'cities' => ['Lucknow', 'Kanpur', 'Agra', 'Meerut', 'Varanasi', 'Allahabad', 'Ghaziabad', 'Bareilly', 'Aligarh', 'Moradabad'],
            ],
            'Uttarakhand' => [
                'code' => 'UK',
                'cities' => ['Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rudrapur', 'Kashipur', 'Rishikesh', 'Nainital', 'Almora', 'Pithoragarh'],
            ],
            'West Bengal' => [
                'code' => 'WB',
                'cities' => ['Kolkata', 'Howrah', 'Durgapur', 'Asansol', 'Siliguri', 'Bardhaman', 'Malda', 'Baharampur', 'Kharagpur', 'Cooch Behar'],
            ],
        ];

        foreach ($indianStates as $stateName => $stateData) {
            $state = State::firstOrCreate(
                [
                    'country_id' => $india->id,
                    'name' => $stateName,
                ],
                [
                    'code' => $stateData['code'],
                    'is_active' => true,
                ]
            );

            // Create cities for each state
            foreach ($stateData['cities'] as $cityName) {
                City::firstOrCreate(
                    [
                        'state_id' => $state->id,
                        'name' => $cityName,
                    ],
                    [
                        'district' => $cityName, // Using city name as district for now
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command->info('Indian states and cities seeded successfully!');
    }
}
