<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            $this->command->warn('No users found. Please run UserSeeder first.');

            return;
        }

        $notifications = [
            [
                'type' => 'lead_assigned',
                'title' => 'New Lead Assigned',
                'message' => 'A new lead "John Smith" has been assigned to you.',
                'action_url' => '/leads',
                'icon' => 'person-plus',
                'color' => 'primary',
                'is_read' => false,
            ],
            [
                'type' => 'followup_due',
                'title' => 'Follow-up Reminder',
                'message' => 'You have a follow-up scheduled for "Sarah Johnson" today at 2:00 PM.',
                'action_url' => '/followups',
                'icon' => 'calendar-check',
                'color' => 'warning',
                'is_read' => false,
            ],
            [
                'type' => 'lead_status_changed',
                'title' => 'Lead Status Updated',
                'message' => 'Lead "Michael Brown" status changed from "Contacted" to "Qualified".',
                'action_url' => '/leads',
                'icon' => 'arrow-repeat',
                'color' => 'info',
                'is_read' => true,
            ],
            [
                'type' => 'lead_created',
                'title' => 'New Lead Created',
                'message' => 'A new lead "Emma Wilson" has been created in the system.',
                'action_url' => '/leads',
                'icon' => 'plus-circle',
                'color' => 'success',
                'is_read' => true,
            ],
            [
                'type' => 'note_added',
                'title' => 'New Note Added',
                'message' => 'A new note has been added to lead "David Lee" by John Doe.',
                'action_url' => '/leads',
                'icon' => 'chat-left-text',
                'color' => 'info',
                'is_read' => true,
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create(array_merge([
                'user_id' => $user->id,
            ], $notification));
        }

        $this->command->info('Notifications seeded successfully!');
    }
}



