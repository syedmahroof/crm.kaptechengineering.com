<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get India for default location
        $india = Country::where('iso_code', 'IN')->first();
        
        if (!$india) {
            $this->command->warn('India country not found. Please run CountrySeeder first.');
            return;
        }
        
        $states = State::where('country_id', $india->id)->get();
        $districts = $states->isNotEmpty() 
            ? District::whereIn('state_id', $states->pluck('id'))->get()
            : collect();

        // Contact types with sample data
        $contactTypes = [
            'plumbing_contractors' => [
                ['name' => 'Rajesh Plumbing Services', 'email' => 'rajesh.plumbing@example.com', 'phone' => '+91 9876543210'],
                ['name' => 'Kumar Plumbing Works', 'email' => 'kumar.plumbing@example.com', 'phone' => '+91 9876543211'],
                ['name' => 'Modern Plumbing Solutions', 'email' => 'modern.plumbing@example.com', 'phone' => '+91 9876543212'],
            ],
            'electrical_contractors' => [
                ['name' => 'Sharma Electrical Services', 'email' => 'sharma.electrical@example.com', 'phone' => '+91 9876543220'],
                ['name' => 'Power Tech Electrical', 'email' => 'powertech@example.com', 'phone' => '+91 9876543221'],
                ['name' => 'Bright Electric Works', 'email' => 'bright.electric@example.com', 'phone' => '+91 9876543222'],
            ],
            'hvac_contractors' => [
                ['name' => 'Cool Air HVAC Systems', 'email' => 'coolair@example.com', 'phone' => '+91 9876543230'],
                ['name' => 'Climate Control Solutions', 'email' => 'climate.control@example.com', 'phone' => '+91 9876543231'],
            ],
            'architects' => [
                ['name' => 'Design Studio Architects', 'email' => 'design.studio@example.com', 'phone' => '+91 9876543240'],
                ['name' => 'Modern Architecture Group', 'email' => 'modern.arch@example.com', 'phone' => '+91 9876543241'],
            ],
            'mep_consultants' => [
                ['name' => 'MEP Engineering Consultants', 'email' => 'mep.consultants@example.com', 'phone' => '+91 9876543250'],
                ['name' => 'Technical MEP Solutions', 'email' => 'technical.mep@example.com', 'phone' => '+91 9876543251'],
            ],
            'builders_developers' => [
                ['name' => 'Prime Builders & Developers', 'email' => 'prime.builders@example.com', 'phone' => '+91 9876543260'],
                ['name' => 'Elite Construction Group', 'email' => 'elite.construction@example.com', 'phone' => '+91 9876543261'],
            ],
            'fire_fighting_contractors' => [
                ['name' => 'Fire Safety Solutions', 'email' => 'firesafety@example.com', 'phone' => '+91 9876543270'],
                ['name' => 'Secure Fire Systems', 'email' => 'secure.fire@example.com', 'phone' => '+91 9876543271'],
            ],
            'civil_eng_contractors' => [
                ['name' => 'Civil Engineering Works', 'email' => 'civil.works@example.com', 'phone' => '+91 9876543280'],
                ['name' => 'Infrastructure Builders', 'email' => 'infrastructure@example.com', 'phone' => '+91 9876543281'],
            ],
            'interior_designers' => [
                ['name' => 'Interior Design Studio', 'email' => 'interior.studio@example.com', 'phone' => '+91 9876543290'],
                ['name' => 'Modern Interiors', 'email' => 'modern.interiors@example.com', 'phone' => '+91 9876543291'],
            ],
            'swimming_pool_stp' => [
                ['name' => 'Pool & STP Solutions', 'email' => 'pool.stp@example.com', 'phone' => '+91 9876543300'],
            ],
            'biomedicals' => [
                ['name' => 'Biomedical Equipment Services', 'email' => 'biomedical@example.com', 'phone' => '+91 9876543310'],
            ],
            'hospitals' => [
                ['name' => 'City General Hospital', 'email' => 'city.hospital@example.com', 'phone' => '+91 9876543320'],
                ['name' => 'Metro Healthcare', 'email' => 'metro.health@example.com', 'phone' => '+91 9876543321'],
            ],
            'shop_retail' => [
                ['name' => 'Retail Solutions Group', 'email' => 'retail.solutions@example.com', 'phone' => '+91 9876543330'],
            ],
        ];

        $priorities = ['low', 'medium', 'high', 'urgent'];

        foreach ($contactTypes as $contactType => $contacts) {
            foreach ($contacts as $contactData) {
                $selectedState = $states->isNotEmpty() ? $states->random() : null;
                $selectedDistrict = null;
                
                if ($selectedState && $districts->isNotEmpty()) {
                    $selectedDistrict = $districts->where('state_id', $selectedState->id)->first();
                    if (!$selectedDistrict) {
                        $selectedDistrict = $districts->random();
                    }
                }

                Contact::create([
                    'name' => $contactData['name'],
                    'email' => $contactData['email'],
                    'phone' => $contactData['phone'],
                    'contact_type' => $contactType,
                    'country_id' => $india->id,
                    'state_id' => $selectedState?->id,
                    'district_id' => $selectedDistrict?->id,
                    'subject' => 'Inquiry about ' . Str::title(str_replace('_', ' ', $contactType)) . ' Services',
                    'message' => 'We are interested in your services and would like to know more about your offerings and pricing.',
                    'priority' => $priorities[array_rand($priorities)],
                ]);
            }
        }

        // Add additional specific contact types mentioned by user
        $additionalContacts = [
            [
                'name' => 'Procurement Manager - ABC Corp',
                'email' => 'procurement.abc@example.com',
                'phone' => '+91 9876543400',
                'contact_type' => 'project',
                'subject' => 'Procurement Inquiry',
                'message' => 'Looking for procurement services for our upcoming project.',
            ],
            [
                'name' => 'Project Manager - XYZ Construction',
                'email' => 'pm.xyz@example.com',
                'phone' => '+91 9876543401',
                'contact_type' => 'project',
                'subject' => 'Project Management Services',
                'message' => 'Need project management consultation for our construction project.',
            ],
            [
                'name' => 'Site Engineer - Metro Builders',
                'email' => 'engineer.metro@example.com',
                'phone' => '+91 9876543402',
                'contact_type' => 'project',
                'subject' => 'Site Engineering Services',
                'message' => 'Require site engineering services for ongoing construction.',
            ],
            [
                'name' => 'Carpenter Services',
                'email' => 'carpenter.services@example.com',
                'phone' => '+91 9876543403',
                'contact_type' => 'civil_eng_contractors',
                'subject' => 'Carpentry Work',
                'message' => 'Professional carpentry services for residential and commercial projects.',
            ],
            [
                'name' => 'Painting Contractors',
                'email' => 'painting.contractors@example.com',
                'phone' => '+91 9876543404',
                'contact_type' => 'interior_designers',
                'subject' => 'Painting Services',
                'message' => 'Expert painting services for interior and exterior projects.',
            ],
        ];

        foreach ($additionalContacts as $contactData) {
            $selectedState = $states->isNotEmpty() ? $states->random() : null;
            $selectedDistrict = null;
            
            if ($selectedState && $districts->isNotEmpty()) {
                $selectedDistrict = $districts->where('state_id', $selectedState->id)->first();
                if (!$selectedDistrict) {
                    $selectedDistrict = $districts->random();
                }
            }

            Contact::create([
                'name' => $contactData['name'],
                'email' => $contactData['email'],
                'phone' => $contactData['phone'],
                'contact_type' => $contactData['contact_type'],
                'country_id' => $india->id,
                'state_id' => $selectedState?->id,
                'district_id' => $selectedDistrict?->id,
                'subject' => $contactData['subject'],
                'message' => $contactData['message'],
                'priority' => $priorities[array_rand($priorities)],
            ]);
        }

        $this->command->info('Created ' . Contact::count() . ' contacts with various types.');
    }
}
