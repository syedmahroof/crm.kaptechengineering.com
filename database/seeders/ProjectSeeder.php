<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $projectTypes = array_keys(Project::getProjectTypes());
        $statuses = ['planning', 'in_progress', 'on_hold', 'completed', 'cancelled'];

        $projects = [
            [
                'name' => 'Residential Complex - Green Valley',
                'description' => 'A modern residential complex with 200 units, featuring eco-friendly design and amenities.',
                'status' => 'in_progress',
                'project_type' => 'residential',
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->addMonths(12),
            ],
            [
                'name' => 'Commercial Office Tower - Business Hub',
                'description' => 'A 20-story commercial office building in the heart of the business district.',
                'status' => 'in_progress',
                'project_type' => 'commercial',
                'start_date' => Carbon::now()->subMonths(4),
                'end_date' => Carbon::now()->addMonths(8),
            ],
            [
                'name' => 'City Hospital - Medical Center',
                'description' => 'A state-of-the-art hospital with 500 beds and advanced medical facilities.',
                'status' => 'planning',
                'project_type' => 'hospital',
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(24),
            ],
            [
                'name' => 'Luxury Hotel - Grand Plaza',
                'description' => 'A 5-star luxury hotel with 300 rooms, restaurants, and conference facilities.',
                'status' => 'in_progress',
                'project_type' => 'hotel',
                'start_date' => Carbon::now()->subMonths(8),
                'end_date' => Carbon::now()->addMonths(6),
            ],
            [
                'name' => 'Industrial Warehouse Complex',
                'description' => 'Large-scale warehouse facility for logistics and distribution.',
                'status' => 'completed',
                'project_type' => 'industrial',
                'start_date' => Carbon::now()->subMonths(18),
                'end_date' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Highway Infrastructure Project',
                'description' => 'Construction of a 50km highway connecting two major cities.',
                'status' => 'in_progress',
                'project_type' => 'infrastructure',
                'start_date' => Carbon::now()->subMonths(12),
                'end_date' => Carbon::now()->addMonths(18),
            ],
            [
                'name' => 'University Campus Expansion',
                'description' => 'Expansion of university campus with new academic buildings and facilities.',
                'status' => 'planning',
                'project_type' => 'educational',
                'start_date' => Carbon::now()->addMonths(2),
                'end_date' => Carbon::now()->addMonths(30),
            ],
            [
                'name' => 'Shopping Mall - Retail Center',
                'description' => 'A modern shopping mall with 200 retail outlets and entertainment facilities.',
                'status' => 'in_progress',
                'project_type' => 'retail',
                'start_date' => Carbon::now()->subMonths(10),
                'end_date' => Carbon::now()->addMonths(8),
            ],
            [
                'name' => 'Mixed-Use Development - City Center',
                'description' => 'A mixed-use development combining residential, commercial, and retail spaces.',
                'status' => 'planning',
                'project_type' => 'mixed_use',
                'start_date' => Carbon::now()->addMonths(3),
                'end_date' => Carbon::now()->addMonths(36),
            ],
            [
                'name' => 'Corporate Office Park',
                'description' => 'A modern office park with multiple office buildings and shared amenities.',
                'status' => 'in_progress',
                'project_type' => 'office',
                'start_date' => Carbon::now()->subMonths(5),
                'end_date' => Carbon::now()->addMonths(10),
            ],
            [
                'name' => 'Residential Township - Sunrise Heights',
                'description' => 'A planned residential township with 500 homes, schools, and community centers.',
                'status' => 'planning',
                'project_type' => 'residential',
                'start_date' => Carbon::now()->addMonths(6),
                'end_date' => Carbon::now()->addMonths(42),
            ],
            [
                'name' => 'Manufacturing Plant - Auto Parts',
                'description' => 'A new manufacturing facility for automotive parts production.',
                'status' => 'in_progress',
                'project_type' => 'industrial',
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addMonths(12),
            ],
            [
                'name' => 'Retail Chain Store - Multiple Locations',
                'description' => 'Construction of 10 retail stores across different cities.',
                'status' => 'in_progress',
                'project_type' => 'retail',
                'start_date' => Carbon::now()->subMonths(2),
                'end_date' => Carbon::now()->addMonths(6),
            ],
            [
                'name' => 'Residential Apartment Complex - Sky Towers',
                'description' => 'Twin tower residential complex with 300 luxury apartments.',
                'status' => 'completed',
                'project_type' => 'residential',
                'start_date' => Carbon::now()->subMonths(24),
                'end_date' => Carbon::now()->subMonths(3),
            ],
            [
                'name' => 'Commercial Complex - Tech Park',
                'description' => 'A technology park with office spaces for IT companies.',
                'status' => 'in_progress',
                'project_type' => 'commercial',
                'start_date' => Carbon::now()->subMonths(7),
                'end_date' => Carbon::now()->addMonths(9),
            ],
            [
                'name' => 'Hospital Expansion - Wing B',
                'description' => 'Expansion of existing hospital with new wing for specialized care.',
                'status' => 'planning',
                'project_type' => 'hospital',
                'start_date' => Carbon::now()->addMonths(4),
                'end_date' => Carbon::now()->addMonths(20),
            ],
            [
                'name' => 'Resort Hotel - Beachfront',
                'description' => 'A luxury beachfront resort with 150 rooms and spa facilities.',
                'status' => 'in_progress',
                'project_type' => 'hotel',
                'start_date' => Carbon::now()->subMonths(9),
                'end_date' => Carbon::now()->addMonths(9),
            ],
            [
                'name' => 'School Building - Primary Section',
                'description' => 'New building for primary school with 20 classrooms and playground.',
                'status' => 'completed',
                'project_type' => 'educational',
                'start_date' => Carbon::now()->subMonths(15),
                'end_date' => Carbon::now()->subMonths(1),
            ],
            [
                'name' => 'Bridge Construction - River Crossing',
                'description' => 'Construction of a major bridge over the river connecting two districts.',
                'status' => 'in_progress',
                'project_type' => 'infrastructure',
                'start_date' => Carbon::now()->subMonths(11),
                'end_date' => Carbon::now()->addMonths(13),
            ],
            [
                'name' => 'Warehouse Facility - Cold Storage',
                'description' => 'Cold storage warehouse for food and pharmaceutical products.',
                'status' => 'planning',
                'project_type' => 'industrial',
                'start_date' => Carbon::now()->addMonths(2),
                'end_date' => Carbon::now()->addMonths(14),
            ],
        ];

        foreach ($projects as $projectData) {
            $projectData['user_id'] = $users->random()->id;
            Project::create($projectData);
        }

        $this->command->info('Created ' . count($projects) . ' projects.');
    }
}
