@extends('layouts.admin')

@section('title', 'Reminders')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reminders</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your reminders</p>
        </div>
        <a href="{{ route('reminders.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>New Reminder
        </a>
    </div>

    @if($upcoming->count() > 0 || $later->count() > 0)
        <!-- Upcoming Reminders (This Week) -->
        @if($upcoming->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Upcoming This Week</h2>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($upcoming as $reminder)
                        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $reminder->title }}</h3>
                                        @if($reminder->priority)
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $reminder->priority === 'high' ? 'bg-red-100 text-red-800' : ($reminder->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($reminder->priority) }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($reminder->description)
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $reminder->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span><i class="fas fa-clock mr-1"></i>{{ $reminder->reminder_at->format('M d, Y h:i A') }}</span>
                                        @if($reminder->lead)
                                            <span><i class="fas fa-user mr-1"></i>Lead: {{ $reminder->lead->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('reminders.edit', $reminder) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('reminders.complete', $reminder) }}" method="POST" class="inline" data-confirm="Mark this reminder as completed?">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this reminder?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Later Reminders -->
        @if($later->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Later</h2>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($later as $reminder)
                        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $reminder->title }}</h3>
                                        @if($reminder->priority)
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $reminder->priority === 'high' ? 'bg-red-100 text-red-800' : ($reminder->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($reminder->priority) }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($reminder->description)
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $reminder->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span><i class="fas fa-clock mr-1"></i>{{ $reminder->reminder_at->format('M d, Y h:i A') }}</span>
                                        @if($reminder->lead)
                                            <span><i class="fas fa-user mr-1"></i>Lead: {{ $reminder->lead->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('reminders.edit', $reminder) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('reminders.complete', $reminder) }}" method="POST" class="inline" data-confirm="Mark this reminder as completed?">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this reminder?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="fas fa-bell text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 dark:text-gray-400">No reminders scheduled. Create one to get started!</p>
        </div>
    @endif
</div>
@endsection

