<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\LeadStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'status_id' => LeadStatus::inRandomOrder()->first()?->id ?? null,
            'assigned_to' => User::inRandomOrder()->first()?->id ?? null,
            'product_id' => Product::inRandomOrder()->first()?->id ?? null,
            'branch_id' => Branch::inRandomOrder()->first()?->id ?? null,
            'source' => fake()->randomElement(['Website', 'Email Campaign', 'Social Media', 'Phone Call', 'Walk-in', 'Referral']),
            'lead_type' => fake()->randomElement(['Hot Lead', 'Warm Lead', 'Cold Lead', 'Qualified', 'Unqualified']),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
