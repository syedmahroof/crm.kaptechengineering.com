@extends('layouts.admin')

@section('title', 'Reports Analytics')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-50 via-indigo-50 to-blue-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reports Analytics</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Comprehensive insights into project visits and reports</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('visit-reports.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form method="GET" action="{{ route('visit-reports.analytics') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Overall Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Visits</p>
                    <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-1">{{ number_format($stats['total_visits']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-blue-700 dark:text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Total Projects</p>
                    <p class="text-3xl font-bold text-green-900 dark:text-green-100 mt-1">{{ number_format($stats['total_projects']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-200 dark:bg-green-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-project-diagram text-green-700 dark:text-green-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-5 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Total Users</p>
                    <p class="text-3xl font-bold text-purple-900 dark:text-purple-100 mt-1">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-200 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-700 dark:text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg p-5 border border-orange-200 dark:border-orange-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-600 dark:text-orange-400">Avg Visits/Project</p>
                    <p class="text-3xl font-bold text-orange-900 dark:text-orange-100 mt-1">{{ number_format($stats['avg_visits_per_project'], 1) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-200 dark:bg-orange-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-orange-700 dark:text-orange-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Projects -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>Top Projects by Visits
            </h2>
            <div class="space-y-3">
                @forelse($stats['visits_by_project'] as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $item->project->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->project->project_type ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $item->visit_count }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">visits</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>

        <!-- Top Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-user-chart text-blue-500 mr-2"></i>Top Users by Visits
            </h2>
            <div class="space-y-3">
                @forelse($stats['visits_by_user'] as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $item->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $item->visit_count }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">visits</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Visits by Project Type -->
    @if($stats['visits_by_project_type']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>Visits by Project Type
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($stats['visits_by_project_type'] as $item)
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">{{ $item['type'] }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $item['count'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Monthly Trends -->
    @if($stats['monthly_trends']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-area text-green-500 mr-2"></i>Monthly Trends
        </h2>
        <div class="space-y-2">
            @foreach($stats['monthly_trends'] as $trend)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $trend['month'] }}</span>
                    <div class="flex items-center space-x-3 flex-1 mx-4">
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                            <div class="bg-green-500 h-4 rounded-full" style="width: {{ ($trend['count'] / $stats['monthly_trends']->max('count')) * 100 }}%"></div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white w-12 text-right">{{ $trend['count'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Meetings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-calendar-check text-green-500 mr-2"></i>Upcoming Meetings (Next 30 Days)
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($stats['upcoming_meetings'] as $meeting)
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $meeting->project->name ?? 'N/A' }}</p>
                            <span class="text-xs text-green-600 dark:text-green-400">{{ $meeting->next_meeting_date->format('M d, Y') }}</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">by {{ $meeting->user->name ?? 'N/A' }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No upcoming meetings</p>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Calls -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-phone text-blue-500 mr-2"></i>Upcoming Calls (Next 30 Days)
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($stats['upcoming_calls'] as $call)
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $call->project->name ?? 'N/A' }}</p>
                            <span class="text-xs text-blue-600 dark:text-blue-400">{{ $call->next_call_date->format('M d, Y') }}</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">by {{ $call->user->name ?? 'N/A' }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No upcoming calls</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Visits -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-history text-purple-500 mr-2"></i>Recent Visits
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Objective</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">User</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($stats['recent_visits'] as $visit)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $visit->visit_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                @if($visit->project)
                                    <a href="{{ route('projects.show', $visit->project->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                        {{ $visit->project->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ Str::limit($visit->objective, 50) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $visit->user->name ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No recent visits</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

