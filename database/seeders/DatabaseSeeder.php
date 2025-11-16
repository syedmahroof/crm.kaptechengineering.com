<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core system seeders
            RoleAndPermissionSeeder::class,
            BranchSeeder::class,
            // Country data
            CountrySeeder::class,
            StateSeeder::class,
            DistrictSeeder::class,
            // Contacts
            ContactSeeder::class,
            // Projects
            ProjectSeeder::class,
            // Products
            ProductSeeder::class,
            // Visit Reports
            VisitReportSeeder::class,
            // Frontend content
            BannerSeeder::class,
            // Blog content
            BlogSeeder::class,
            // Application seeders
            LeadSourceSeeder::class,
            LeadPrioritySeeder::class,
            LeadLossReasonSeeder::class,
            TestLeadSeeder::class,
            // Task management
            TaskSeeder::class,
            // LeadAgentSeeder should run after users are created
        ]);
    }
}
