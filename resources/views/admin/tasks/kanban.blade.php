@extends('layouts.admin')

@section('title', 'Task Kanban Board')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Task Kanban Board</h1>
        <a href="{{ route('tasks.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-list mr-2"></i>List View
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        @foreach($statuses as $statusKey => $statusLabel)
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">{{ $statusLabel }}</h3>
                <div class="space-y-2 min-h-32">
                    @if(isset($initialTasks[$statusKey]))
                        @foreach($initialTasks[$statusKey] as $task)
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-600">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $task->title }}</p>
                                @if($task->assignee)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $task->assignee->name }}</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-400 text-center py-8">No tasks</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

