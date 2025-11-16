@extends('layouts.admin')

@section('title', 'Lead Agent: ' . $agent->user->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $agent->user->name }}</h1>
        <a href="{{ route('lead-agents.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Total Leads</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_leads'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Converted</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['converted_leads'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Active Leads</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['active_leads'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Conversion Rate</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['conversion_rate'] }}%</p>
        </div>
    </div>

    <!-- Recent Leads -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Leads</h2>
        <div class="space-y-2">
            @forelse($recentLeads as $lead)
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $lead->name }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">{{ $lead->email }}</span>
                    </div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $lead->created_at->format('M d, Y') }}</span>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No leads assigned yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

