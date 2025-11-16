@extends('layouts.admin')

@section('title', 'Task Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Task Dashboard</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Overview of your tasks</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Total</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $initialStats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">To Do</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $initialStats['todo'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">In Progress</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $initialStats['in_progress'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Done</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $initialStats['done'] }}</p>
        </div>
    </div>

    <!-- Recent Tasks -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Tasks</h2>
        <div class="space-y-2">
            @forelse($recentTasks as $task)
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    <span class="text-gray-900 dark:text-white">{{ $task->title }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $task->updated_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No recent tasks</p>
            @endforelse
        </div>
    </div>

    <!-- Overdue Tasks -->
    @if($overdueTasks->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-red-200 dark:border-red-800 p-6">
            <h2 class="text-lg font-semibold text-red-900 dark:text-red-300 mb-4">Overdue Tasks</h2>
            <div class="space-y-2">
                @foreach($overdueTasks as $task)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-red-50 dark:bg-red-900/20">
                        <span class="text-gray-900 dark:text-white">{{ $task->title }}</span>
                        <span class="text-sm text-red-600 dark:text-red-400">Due: {{ $task->due_date->format('M d, Y') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

