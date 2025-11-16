@extends('layouts.admin')

@section('title', 'Branch Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Branch Details</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('settings.branches.edit', $branch->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('settings.branches.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Branch Name</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Branch Code</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->code }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->description ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <p class="mt-1">
                    <span class="px-2 py-1 text-xs rounded-full {{ $branch->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ $branch->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contact Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->address ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->phone ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->email ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Timezone</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->timezone }}</p>
            </div>
        </div>
    </div>

    <!-- Manager Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Manager Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Manager Name</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->manager_name ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Manager Phone</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->manager_phone ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Manager Email</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $branch->manager_email ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Working Hours -->
    @if($branch->working_hours)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Working Hours</h2>
        <div class="space-y-2">
            @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            @endphp
            @foreach($days as $index => $day)
                @php
                    $dayHours = $branch->working_hours[$index] ?? null;
                @endphp
                @if($dayHours && isset($dayHours['is_open']) && $dayHours['is_open'])
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-700 dark:text-gray-300">{{ $day }}</span>
                        <span class="text-gray-900 dark:text-white">
                            {{ $dayHours['open_time'] ?? 'N/A' }} - {{ $dayHours['close_time'] ?? 'N/A' }}
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $branch->users->count() }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Leads</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $branch->leads->count() }}</p>
                </div>
                <i class="fas fa-clipboard-list text-3xl text-green-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $branch->customers->count() }}</p>
                </div>
                <i class="fas fa-user-friends text-3xl text-purple-500"></i>
            </div>
        </div>
    </div>
</div>
@endsection





