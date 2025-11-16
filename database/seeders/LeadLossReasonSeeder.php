<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\LeadLossReason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class LeadLossReasonSeeder extends Seeder
{
    public function run(): void
    {
        $reasons = [
            ['name' => 'Chose Competitor', 'icon' => 'fa-handshake-slash', 'color' => '#dc2626'],
            ['name' => 'Budget Constraints', 'icon' => 'fa-wallet', 'color' => '#f97316'],
            ['name' => 'Travel Plans Postponed', 'icon' => 'fa-calendar-xmark', 'color' => '#2563eb'],
            ['name' => 'No Longer Interested', 'icon' => 'fa-face-meh', 'color' => '#6b7280'],
            ['name' => 'Unresponsive Lead', 'icon' => 'fa-user-clock', 'color' => '#9333ea'],
        ];

        foreach ($reasons as $index => $reason) {
            LeadLossReason::updateOrCreate(
                ['slug' => Str::slug($reason['name'])],
                [
                    'name' => $reason['name'],
                    'icon' => $reason['icon'],
                    'color' => $reason['color'],
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}

