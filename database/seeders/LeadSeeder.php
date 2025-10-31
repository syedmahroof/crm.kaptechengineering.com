<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Product;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all required IDs
        $userIds = User::pluck('id')->toArray();
        $statusIds = LeadStatus::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        $branchIds = Branch::pluck('id')->toArray();

        // Check if we have necessary data
        if (empty($statusIds)) {
            $this->command->error('No lead statuses found! Please run LeadStatusSeeder first.');

            return;
        }

        // Lead types
        $leadTypes = [
            'Hot Lead',
            'Warm Lead',
            'Cold Lead',
            'New Inquiry',
            'Referral',
            'Returning Customer',
            'Qualified',
            'Unqualified',
        ];

        // Lead sources
        $sources = [
            'Website',
            'Email Campaign',
            'Social Media',
            'Phone Call',
            'Walk-in',
            'Referral',
            'Trade Show',
            'Online Ad',
            'Partner',
            'Direct Marketing',
        ];

        // Lead notes templates
        $notesTemplates = [
            'Interested in our enterprise solutions.',
            'Looking for a demo of our products.',
            'Needs pricing information for bulk order.',
            'Wants to schedule a consultation call.',
            'Inquired about our service packages.',
            'Comparing with competitors.',
            'Budget approval pending.',
            'Ready to move forward with purchase.',
            'Needs more information about features.',
            'Requesting a custom quote.',
        ];

        $this->command->info('Creating 20 leads...');

        for ($i = 1; $i <= 20; $i++) {
            Lead::create([
                'name' => $faker->name(),
                'company_name' => $faker->optional()->company(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'status_id' => $faker->randomElement($statusIds),
                'assigned_to' => ! empty($userIds) ? $faker->randomElement([...$userIds, null]) : null,
                'product_id' => ! empty($productIds) ? $faker->randomElement([...$productIds, null]) : null,
                'branch_id' => ! empty($branchIds) ? $faker->randomElement($branchIds) : null,
                'source' => $faker->randomElement($sources),
                'lead_type' => $faker->randomElement($leadTypes),
                'notes' => $faker->randomElement([
                    $faker->randomElement($notesTemplates),
                    $faker->sentence(10),
                    null,
                ]),
                'closing_date' => $faker->optional()->dateTimeBetween('now', '+6 months'),
            ]);

            // Show progress every 10 leads
            if ($i % 10 == 0) {
                $this->command->info("Created {$i} leads...");
            }
        }

        $this->command->info('✓ Successfully created 20 leads with various types!');

        // Display summary
        $this->command->info("\nLead Summary:");
        $this->command->info('Total Leads: '.Lead::count());

        foreach ($leadTypes as $type) {
            $count = Lead::where('lead_type', $type)->count();
            if ($count > 0) {
                $this->command->info("  - {$type}: {$count}");
            }
        }
    }
}
