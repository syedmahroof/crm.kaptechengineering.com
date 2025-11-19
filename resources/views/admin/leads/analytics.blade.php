@extends('layouts.admin')

@section('title', 'Lead Analytics')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Lead Analytics</h1>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <form method="GET" action="{{ route('leads.analytics') }}" class="flex gap-4 flex-wrap">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] }}" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] }}" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Leads</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Hot Leads</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ number_format($stats['hot_lead']) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-fire text-red-600 dark:text-red-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Cold Leads</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ number_format($stats['cold_lead']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-snowflake text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Converted</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ number_format($stats['converted']) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['conversion_rate'] }}% conversion rate</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">New Leads</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['new']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Lost Leads</p>
            <p class="text-2xl font-bold text-gray-600 dark:text-gray-400">{{ number_format($stats['lost']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Conversion Rate</p>
            <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $stats['conversion_rate'] }}%</p>
        </div>
    </div>

    <!-- Performance Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Avg Time to Conversion</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['time_to_conversion']['average_days'] ?? 0 }} days</p>
            @if(isset($stats['time_to_conversion']['median_days']))
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Median: {{ $stats['time_to_conversion']['median_days'] }} days</p>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Avg Response Time</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['response_time_metrics']['average_days'] ?? 0 }} days</p>
            @if(isset($stats['response_time_metrics']['total_contacted']))
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($stats['response_time_metrics']['total_contacted']) }} contacted</p>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Follow-up Completion</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['follow_up_metrics']['completion_rate'] ?? 0 }}%</p>
            @if(isset($stats['follow_up_metrics']['total']))
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($stats['follow_up_metrics']['total']) }} total follow-ups</p>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Response Rate</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['response_rate']['contact_rate'] ?? 0 }}%</p>
            @if(isset($stats['response_rate']['follow_up_rate']))
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['response_rate']['follow_up_rate'] }}% with follow-ups</p>
            @endif
        </div>
    </div>

    <!-- Conversion Funnel -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Conversion Funnel</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Leads</span>
                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['conversion_funnel']['total_leads']) }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Contacted</span>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $stats['conversion_funnel']['contact_rate'] }}%</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($stats['conversion_funnel']['contacted']) }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Hot Leads</span>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $stats['conversion_funnel']['hot_lead_rate'] }}%</span>
                    <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ number_format($stats['conversion_funnel']['hot_lead']) }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Converted</span>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $stats['conversion_funnel']['conversion_rate'] }}%</span>
                    <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ number_format($stats['conversion_funnel']['converted']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Trends Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Monthly Trends</h2>
            <canvas id="monthlyChart" height="100"></canvas>
        </div>

        <!-- Status Distribution Pie Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status Distribution</h2>
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Daily Trends Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daily Trends (Last 30 Days)</h2>
            <canvas id="dailyChart" height="100"></canvas>
        </div>

        <!-- Source Distribution Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Lead Sources</h2>
            <canvas id="sourceChart" height="100"></canvas>
        </div>
    </div>

    <!-- Charts Row 3 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Agents Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Performing Agents</h2>
            <canvas id="agentsChart" height="100"></canvas>
        </div>

        <!-- Priority Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Priority Distribution</h2>
            <canvas id="priorityChart"></canvas>
        </div>
    </div>

    <!-- Charts Row 4 - New Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Time to Conversion Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Time to Conversion Distribution</h2>
            <canvas id="timeToConversionChart" height="100"></canvas>
        </div>

        <!-- Follow-up Metrics -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Follow-up Types</h2>
            <canvas id="followUpChart"></canvas>
        </div>
    </div>

    <!-- Charts Row 5 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Geographic Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Countries</h2>
            <canvas id="countryChart" height="100"></canvas>
        </div>

        <!-- Lead Age Analysis -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Active Lead Age Distribution</h2>
            <canvas id="leadAgeChart" height="100"></canvas>
        </div>
    </div>

    <!-- Detailed Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Sources Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Lead Sources Performance</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Source</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Converted</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($stats['top_sources'] as $source)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $source['source_name'] }}</td>
                                <td class="px-4 py-2 text-right text-gray-900 dark:text-white">{{ $source['total'] }}</td>
                                <td class="px-4 py-2 text-right text-green-600 dark:text-green-400">{{ $source['converted'] }}</td>
                                <td class="px-4 py-2 text-right text-gray-600 dark:text-gray-400">{{ $source['conversion_rate'] }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Agents Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Performing Agents</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Agent</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total Leads</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Converted</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($stats['top_agents'] as $agent)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $agent['agent_name'] }}</td>
                                <td class="px-4 py-2 text-right text-gray-900 dark:text-white">{{ $agent['total'] }}</td>
                                <td class="px-4 py-2 text-right text-green-600 dark:text-green-400">{{ $agent['converted'] }}</td>
                                <td class="px-4 py-2 text-right text-gray-600 dark:text-gray-400">{{ $agent['conversion_rate'] }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Campaign Performance Table -->
    @if(count($stats['campaign_performance']) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campaign Performance</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Campaign</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total Leads</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Converted</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Conversion Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($stats['campaign_performance'] as $campaign)
                        <tr>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $campaign['campaign_name'] }}</td>
                            <td class="px-4 py-2 text-right text-gray-900 dark:text-white">{{ $campaign['total'] }}</td>
                            <td class="px-4 py-2 text-right text-green-600 dark:text-green-400">{{ $campaign['converted'] }}</td>
                            <td class="px-4 py-2 text-right text-gray-600 dark:text-gray-400">{{ $campaign['conversion_rate'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Lost Reason Analytics -->
    @if($stats['lost_reason_stats']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-lg p-5 border border-red-200 dark:border-red-800 mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Lost Reason Analytics</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Understand why leads are being lost to improve your conversion strategy</p>
                </div>
            </div>
        </div>

        @php
            $maxCount = $stats['lost_reason_stats']->pluck('count')->max();
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($stats['lost_reason_stats'] as $reasonItem)
                @php
                    $reasonCount = $reasonItem['count'] ?? 0;
                    $percentage = $maxCount > 0 ? round(($reasonCount / $maxCount) * 100, 1) : 0;
                    $reasonName = $reasonItem['reason'] ?? 'Unknown';
                    $reasonIcon = $reasonItem['icon'] ?? 'fa-exclamation-triangle';
                    $reasonColor = $reasonItem['color'] ?? '#ef4444';
                @endphp
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $reasonColor }}20;">
                                <i class="fas {{ $reasonIcon }} text-lg" style="color: {{ $reasonColor }}"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $reasonName }}</h4>
                                <p class="text-2xl font-bold mt-1" style="color: {{ $reasonColor }}">
                                    {{ number_format($reasonCount) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-300" 
                             style="background-color: {{ $reasonColor }}; width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Monthly Trends Line Chart
    const monthlyData = @json($stats['monthly_trends']);
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => {
                const [year, month] = item.month.split('-');
                return new Date(year, month - 1).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }),
            datasets: [{
                label: 'Leads',
                data: monthlyData.map(item => item.count),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Status Distribution Pie Chart
    const statusData = @json($stats['by_status']);
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1).replace('_', ' ')),
            datasets: [{
                data: statusData.map(item => item.total),
                backgroundColor: [
                    'rgb(59, 130, 246)',   // Blue
                    'rgb(239, 68, 68)',     // Red
                    'rgb(34, 197, 94)',     // Green
                    'rgb(168, 85, 247)',    // Purple
                    'rgb(249, 115, 22)',    // Orange
                    'rgb(107, 114, 128)'    // Gray
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Daily Trends Chart (Last 30 days)
    const dailyData = @json($stats['daily_trends']);
    const last30Days = dailyData.slice(-30);
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: last30Days.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            }),
            datasets: [{
                label: 'Leads',
                data: last30Days.map(item => item.count),
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Source Distribution Bar Chart
    const sourceData = @json($stats['by_source']);
    const sourceCtx = document.getElementById('sourceChart').getContext('2d');
    new Chart(sourceCtx, {
        type: 'bar',
        data: {
            labels: sourceData.map(item => item.lead_source?.name ?? 'Unknown'),
            datasets: [{
                label: 'Leads',
                data: sourceData.map(item => item.total),
                backgroundColor: 'rgba(168, 85, 247, 0.7)',
                borderColor: 'rgb(168, 85, 247)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Top Agents Chart
    const agentsData = @json($stats['top_agents']);
    const agentsCtx = document.getElementById('agentsChart').getContext('2d');
    new Chart(agentsCtx, {
        type: 'bar',
        data: {
            labels: agentsData.map(item => item.agent_name),
            datasets: [{
                label: 'Total Leads',
                data: agentsData.map(item => item.total),
                backgroundColor: 'rgba(34, 197, 94, 0.7)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }, {
                label: 'Converted',
                data: agentsData.map(item => item.converted),
                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Priority Distribution
    const priorityData = @json($stats['by_priority']);
    const priorityCtx = document.getElementById('priorityChart').getContext('2d');
    if (priorityData.length > 0) {
        new Chart(priorityCtx, {
            type: 'pie',
            data: {
                labels: priorityData.map(item => item.lead_priority?.name ?? 'Unknown'),
                datasets: [{
                    data: priorityData.map(item => item.total),
                    backgroundColor: [
                        'rgb(239, 68, 68)',     // Red
                        'rgb(249, 115, 22)',    // Orange
                        'rgb(234, 179, 8)',     // Yellow
                        'rgb(34, 197, 94)',     // Green
                        'rgb(59, 130, 246)'     // Blue
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Time to Conversion Distribution Chart
    const timeToConversionData = @json($stats['time_to_conversion']['distribution'] ?? []);
    if (Object.keys(timeToConversionData).length > 0) {
        const timeToConversionCtx = document.getElementById('timeToConversionChart').getContext('2d');
        new Chart(timeToConversionCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(timeToConversionData),
                datasets: [{
                    label: 'Leads',
                    data: Object.values(timeToConversionData),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    // Follow-up Types Chart
    const followUpData = @json($stats['follow_up_metrics']['by_type'] ?? []);
    if (Object.keys(followUpData).length > 0) {
        const followUpCtx = document.getElementById('followUpChart').getContext('2d');
        new Chart(followUpCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(followUpData).map(key => key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' ')),
                datasets: [{
                    data: Object.values(followUpData),
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(168, 85, 247)',
                        'rgb(249, 115, 22)',
                        'rgb(107, 114, 128)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Top Countries Chart
    const countryData = @json($stats['geographic_analytics']['by_country'] ?? []);
    if (countryData.length > 0) {
        const countryCtx = document.getElementById('countryChart').getContext('2d');
        new Chart(countryCtx, {
            type: 'bar',
            data: {
                labels: countryData.map(item => item.country),
                datasets: [{
                    label: 'Leads',
                    data: countryData.map(item => item.total),
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                indexAxis: 'y'
            }
        });
    }

    // Lead Age Distribution Chart
    const leadAgeData = @json($stats['lead_age_analysis']['age_distribution'] ?? []);
    if (Object.keys(leadAgeData).length > 0) {
        const leadAgeCtx = document.getElementById('leadAgeChart').getContext('2d');
        new Chart(leadAgeCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(leadAgeData),
                datasets: [{
                    label: 'Active Leads',
                    data: Object.values(leadAgeData),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection
