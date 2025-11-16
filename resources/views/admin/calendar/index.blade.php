@extends('layouts.admin')

@section('title', 'Calendar')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="space-y-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600 dark:text-blue-400"></i>Calendar
                    </h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        View your reminders, tasks, and scheduled events
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('reminders.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i>Add Reminder
                    </a>
                    <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex items-center">
                        <i class="fas fa-tasks mr-2"></i>Add Task
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="p-6">
                <!-- Calendar Navigation -->
                <div class="flex items-center justify-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ now()->format('F Y') }}
                    </h2>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2 mb-4">
                    <!-- Day Headers -->
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="text-center text-sm font-semibold text-gray-600 dark:text-gray-400 py-2">
                            {{ $day }}
                        </div>
                    @endforeach

                    <!-- Calendar Days -->
                    @php
                        $firstDay = now()->startOfMonth()->startOfWeek(\Carbon\Carbon::SUNDAY);
                        $lastDay = now()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);
                        $totalDays = $firstDay->diffInDays($lastDay) + 1;
                    @endphp

                    @for($i = 0; $i < $totalDays; $i++)
                        @php
                            $currentDay = $firstDay->copy()->addDays($i);
                            $isCurrentMonth = $currentDay->month === now()->month;
                            $isToday = $currentDay->isToday();
                            $dateKey = $currentDay->format('Y-m-d');
                            
                            // Use pre-grouped collections for O(1) lookup
                            $dayRemindersData = $remindersByDate[$dateKey] ?? ['items' => collect(), 'total' => 0];
                            $dayTasksData = $tasksByDate[$dateKey] ?? ['items' => collect(), 'total' => 0];
                            $dayFollowUpsData = $followUpsByDate[$dateKey] ?? ['items' => collect(), 'total' => 0];
                            
                            $dayReminders = $dayRemindersData['items'];
                            $dayTasks = $dayTasksData['items'];
                            $dayFollowUps = $dayFollowUpsData['items'];
                            $totalReminders = $dayRemindersData['total'];
                            $totalTasks = $dayTasksData['total'];
                            $totalFollowUps = $dayFollowUpsData['total'];
                        @endphp

                        <div class="min-h-[100px] p-2 border border-gray-200 dark:border-gray-700 rounded-lg {{ $isCurrentMonth ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900/50' }} {{ $isToday ? 'ring-2 ring-blue-500' : '' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium {{ $isCurrentMonth ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500' }} {{ $isToday ? 'text-blue-600 dark:text-blue-400 font-bold' : '' }}">
                                    {{ $currentDay->day }}
                                </span>
                                @if($totalReminders > 0 || $totalTasks > 0 || $totalFollowUps > 0)
                                    <span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-1.5 py-0.5 rounded">
                                        {{ $totalReminders + $totalTasks + $totalFollowUps }}
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-1">
                                <!-- Reminders -->
                                @foreach($dayReminders as $reminder)
                                    <div class="text-xs p-1.5 rounded bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 truncate">
                                        <i class="fas fa-bell text-orange-600 dark:text-orange-400 mr-1"></i>
                                        <span class="text-orange-700 dark:text-orange-300">{{ $reminder->title }}</span>
                                    </div>
                                @endforeach

                                <!-- Tasks -->
                                @foreach($dayTasks as $task)
                                    <div class="text-xs p-1.5 rounded bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 truncate">
                                        <i class="fas fa-tasks text-green-600 dark:text-green-400 mr-1"></i>
                                        <span class="text-green-700 dark:text-green-300">{{ $task->title }}</span>
                                    </div>
                                @endforeach

                                <!-- Follow-ups -->
                                @foreach($dayFollowUps as $followUp)
                                    <div class="text-xs p-1.5 rounded bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 truncate">
                                        <i class="fas fa-calendar-check text-purple-600 dark:text-purple-400 mr-1"></i>
                                        <span class="text-purple-700 dark:text-purple-300">{{ $followUp->title }}</span>
                                    </div>
                                @endforeach

                                @php
                                    // Calculate "more" count indicator
                                    $moreCount = max(0, ($totalReminders - 2) + ($totalTasks - 2) + ($totalFollowUps - 2));
                                @endphp
                                @if($moreCount > 0)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 text-center pt-1">
                                        +{{ $moreCount }} more
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

