<?php

namespace App\Actions\Calendar;

use App\Models\Reminder;
use App\Models\Task;
use App\Models\LeadFollowUp;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class GetCalendarDataAction
{
    private const MAX_ITEMS_PER_TYPE = 200; // Reduced limit for better performance
    private const ITEMS_PER_DAY = 2;

    public function execute(User $user): array
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfMonth = $now->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        // Get and group reminders for current month only
        $remindersByDate = $this->getRemindersByDate($user, $startOfMonth, $endOfMonth);

        // Get and group tasks for current month only
        $tasksByDate = $this->getTasksByDate($user, $startOfMonth, $endOfMonth);

        // Get and group follow-ups for current month only
        $followUpsByDate = $this->getFollowUpsByDate($user, $startOfMonth, $endOfMonth);

        return [
            'remindersByDate' => $remindersByDate,
            'tasksByDate' => $tasksByDate,
            'followUpsByDate' => $followUpsByDate,
        ];
    }

    private function getRemindersByDate(User $user, CarbonInterface $startOfMonth, CarbonInterface $endOfMonth): Collection
    {
        $reminders = Reminder::where('user_id', $user->id)
            ->where('is_completed', false)
            ->whereBetween('reminder_at', [$startOfMonth, $endOfMonth])
            ->select('id', 'title', 'reminder_at', 'lead_id', 'user_id', 'is_completed')
            ->orderBy('reminder_at')
            ->limit(self::MAX_ITEMS_PER_TYPE)
            ->get();

        return $this->groupByDate($reminders, 'reminder_at');
    }


    private function getTasksByDate(User $user, CarbonInterface $startOfMonth, CarbonInterface $endOfMonth): Collection
    {
        $tasks = Task::where('assigned_to', $user->id)
            ->where('status', '!=', Task::STATUS_DONE)
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [$startOfMonth, $endOfMonth])
            ->select('id', 'title', 'due_date', 'priority', 'status', 'assigned_to')
            ->orderBy('due_date')
            ->limit(self::MAX_ITEMS_PER_TYPE)
            ->get();

        return $this->groupByDate($tasks, 'due_date');
    }


    private function getFollowUpsByDate(User $user, CarbonInterface $startOfMonth, CarbonInterface $endOfMonth): Collection
    {
        $followUps = LeadFollowUp::where('status', LeadFollowUp::STATUS_SCHEDULED)
            ->whereBetween('scheduled_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhere('created_by', $user->id);
            })
            ->select('id', 'title', 'scheduled_at', 'type', 'status', 'lead_id', 'created_by', 'assigned_to')
            ->orderBy('scheduled_at')
            ->limit(self::MAX_ITEMS_PER_TYPE)
            ->get();

        return $this->groupByDate($followUps, 'scheduled_at');
    }


    private function groupByDate(Collection $items, string $dateField): Collection
    {
        return $items->groupBy(function ($item) use ($dateField) {
            $date = $item->{$dateField};
            return $date instanceof CarbonInterface ? $date->format('Y-m-d') : Carbon::parse($date)->format('Y-m-d');
        })->map(function (Collection $group) {
            return [
                'items' => $group->take(self::ITEMS_PER_DAY)->values(),
                'total' => $group->count(),
            ];
        });
    }
}

