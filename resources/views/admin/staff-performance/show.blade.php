@extends('layouts.admin')

@section('title', 'Staff Performance: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <span class="text-blue-700 dark:text-blue-300 text-2xl font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                    @if($user->roles->count() > 0)
                        <div class="flex items-center space-x-2 mt-2">
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('staff-performance.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form method="GET" action="{{ route('staff-performance.show', $user->id) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

    <!-- Performance Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Leads</p>
                    <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-1">{{ number_format($performance['total_leads']) }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">{{ $performance['converted_leads'] }} converted</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-blue-700 dark:text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Conversion Rate</p>
                    <p class="text-3xl font-bold text-green-900 dark:text-green-100 mt-1">{{ number_format($performance['conversion_rate'], 1) }}%</p>
                </div>
                <div class="w-12 h-12 bg-green-200 dark:bg-green-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-percentage text-green-700 dark:text-green-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-5 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Projects</p>
                    <p class="text-3xl font-bold text-purple-900 dark:text-purple-100 mt-1">{{ number_format($performance['total_projects']) }}</p>
                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">{{ $performance['active_projects'] }} active</p>
                </div>
                <div class="w-12 h-12 bg-purple-200 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-project-diagram text-purple-700 dark:text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg p-5 border border-orange-200 dark:border-orange-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-600 dark:text-orange-400">Visit Reports</p>
                    <p class="text-3xl font-bold text-orange-900 dark:text-orange-100 mt-1">{{ number_format($performance['total_visit_reports']) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-200 dark:bg-orange-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-orange-700 dark:text-orange-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tasks</h3>
                <i class="fas fa-tasks text-gray-400 text-xl"></i>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $performance['total_tasks'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                    <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $performance['completed_tasks'] }}</span>
                </div>
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Completion Rate</span>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white">{{ $performance['task_completion_rate'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ min($performance['task_completion_rate'], 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Follow-ups</h3>
                <i class="fas fa-calendar-check text-gray-400 text-xl"></i>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $performance['total_follow_ups'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                    <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $performance['completed_follow_ups'] }}</span>
                </div>
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Completion Rate</span>
                        <span class="text-xs font-semibold text-gray-900 dark:text-white">{{ $performance['follow_up_completion_rate'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ min($performance['follow_up_completion_rate'], 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Performance Score</h3>
                <i class="fas fa-star text-yellow-400 text-xl"></i>
            </div>
            <div class="text-center">
                @php
                    $score = (
                        ($performance['conversion_rate'] * 0.3) +
                        ($performance['task_completion_rate'] * 0.25) +
                        ($performance['follow_up_completion_rate'] * 0.25) +
                        (min(($performance['total_visit_reports'] / 10) * 100, 100) * 0.2)
                    );
                    $score = min(100, max(0, round($score, 1)));
                @endphp
                <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">{{ $score }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">out of 100</div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full" style="width: {{ $score }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends -->
    @if(isset($performance['monthly_leads']) && $performance['monthly_leads']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-area text-blue-500 mr-2"></i>Monthly Leads Trend
        </h2>
        <div class="space-y-2">
            @foreach($performance['monthly_leads'] as $trend)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $trend['month'] }}</span>
                    <div class="flex items-center space-x-3 flex-1 mx-4">
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                            @php
                                $maxCount = $performance['monthly_leads']->max('count');
                                $width = $maxCount > 0 ? ($trend['count'] / $maxCount) * 100 : 0;
                            @endphp
                            <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white w-12 text-right">{{ $trend['count'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Leads by Status -->
    @if(isset($performance['leads_by_status']) && $performance['leads_by_status']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>Leads by Status
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($performance['leads_by_status'] as $item)
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $item->count }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $item->lead_status->name ?? 'Unknown' }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Leads -->
        @if(isset($detailedStats['recent_leads']) && $detailedStats['recent_leads']->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-list text-blue-500 mr-2"></i>Recent Leads
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @foreach($detailedStats['recent_leads'] as $lead)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <a href="{{ route('leads.show', $lead->id) }}" class="font-medium text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                {{ $lead->name }}
                            </a>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $lead->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400">
                            @if($lead->lead_status)
                                <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $lead->lead_status->name }}
                                </span>
                            @endif
                            @if($lead->lead_source)
                                <span><i class="fas fa-funnel-dollar mr-1"></i>{{ $lead->lead_source->name }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Projects -->
        @if(isset($detailedStats['recent_projects']) && $detailedStats['recent_projects']->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-project-diagram text-purple-500 mr-2"></i>Recent Projects
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @foreach($detailedStats['recent_projects'] as $project)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between mb-2">
                            <a href="{{ route('projects.show', $project->id) }}" class="font-medium text-purple-600 hover:text-purple-900 dark:text-purple-400">
                                {{ $project->name }}
                            </a>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $project->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400">
                            <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                            @if($project->visitReports->count() > 0)
                                <span><i class="fas fa-clipboard-list mr-1"></i>{{ $project->visitReports->count() }} visits</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Follow-ups -->
        @if(isset($detailedStats['upcoming_follow_ups']) && $detailedStats['upcoming_follow_ups']->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-calendar-check text-green-500 mr-2"></i>Upcoming Follow-ups (Next 7 Days)
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @foreach($detailedStats['upcoming_follow_ups'] as $followUp)
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $followUp->title }}</span>
                            <span class="text-xs text-green-600 dark:text-green-400">{{ $followUp->scheduled_at->format('M d, h:i A') }}</span>
                        </div>
                        @if($followUp->lead)
                            <a href="{{ route('leads.show', $followUp->lead->id) }}" class="text-xs text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                <i class="fas fa-link mr-1"></i>{{ $followUp->lead->name }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Pending Tasks -->
        @if(isset($detailedStats['pending_tasks']) && $detailedStats['pending_tasks']->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-tasks text-orange-500 mr-2"></i>Pending Tasks
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @foreach($detailedStats['pending_tasks'] as $task)
                    <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $task->title }}</span>
                            @if($task->due_date)
                                <span class="text-xs {{ $task->due_date->isPast() ? 'text-red-600 dark:text-red-400' : 'text-orange-600 dark:text-orange-400' }}">
                                    {{ $task->due_date->format('M d, Y') }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                            <span class="px-2 py-0.5 rounded bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                {{ ucfirst($task->status) }}
                            </span>
                            @if($task->priority)
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

