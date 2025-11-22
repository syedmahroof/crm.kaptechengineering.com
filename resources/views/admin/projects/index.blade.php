@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<div class="space-y-6">
    <!-- Header with Stats -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Projects</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage and track all your projects</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('visit-reports.analytics') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                <i class="fas fa-chart-line mr-2"></i>Reports Analytics
            </a>
            <a href="{{ route('projects.export') . '?' . http_build_query(request()->all()) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i>Export
            </a>
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>New Project
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Projects -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Projects</p>
                    <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-2">{{ $totalProjects }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-project-diagram text-blue-700 dark:text-blue-300 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Projects by Status -->
        @php
            $statusCounts = \App\Models\Project::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            $statusLabels = [
                'planning' => 'Planning',
                'in_progress' => 'In Progress',
                'on_hold' => 'On Hold',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ];
        @endphp
        
        @foreach(['in_progress', 'completed', 'planning'] as $status)
            @if(isset($statusCounts[$status]))
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-xl p-6 border border-indigo-200 dark:border-indigo-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ $statusLabels[$status] ?? ucfirst($status) }}</p>
                        <p class="text-3xl font-bold text-indigo-900 dark:text-indigo-100 mt-2">{{ $statusCounts[$status] }}</p>
                    </div>
                    <div class="w-14 h-14 bg-indigo-200 dark:bg-indigo-800 rounded-lg flex items-center justify-center">
                        <i class="fas fa-{{ $status == 'in_progress' ? 'spinner' : ($status == 'completed' ? 'check-circle' : 'calendar') }} text-indigo-700 dark:text-indigo-300 text-2xl"></i>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <!-- Projects by Type -->
    @if(!empty($projectTypeCounts))
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-chart-pie mr-2 text-gray-400"></i>Projects by Type
            </h3>
            <a href="{{ route('project-types.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                <i class="fas fa-cog mr-1"></i>Manage Types
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach($projectTypeCounts as $typeName => $data)
                @php
                    $count = $data['count'];
                    $type = $data['type'];
                    $color = $type->color ?? '#6b7280';
                @endphp
                <a href="{{ route('projects.index', ['project_type' => $typeName]) }}" 
                   class="block text-center p-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-200 hover:scale-105">
                    <div class="flex items-center justify-center mb-2">
                        @if($type->icon)
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $color }}20;">
                            <i class="fas {{ $type->icon }} text-lg" style="color: {{ $color }}"></i>
                        </div>
                        @else
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $color }}20;">
                            <i class="fas fa-project-diagram text-lg" style="color: {{ $color }}"></i>
                        </div>
                        @endif
                    </div>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $count }}</p>
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($typeName, 20) }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ filtersOpen: false }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-filter mr-2 text-gray-400"></i>Filters
                @if(request()->hasAny(['search', 'status', 'project_type', 'user_id']))
                <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                    {{ collect([request('search'), request('status'), request('project_type'), request('user_id')])->filter()->count() }}
                </span>
                @endif
            </h3>
            <button @click="filtersOpen = !filtersOpen" 
                    class="px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-chevron-down mr-1 transition-transform duration-200" :class="{ 'rotate-180': filtersOpen }"></i>
                <span x-text="filtersOpen ? 'Hide' : 'Show'">Show</span>
            </button>
        </div>
        <form method="GET" action="{{ route('projects.index') }}" x-show="filtersOpen" x-collapse>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                           placeholder="Search projects..." 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Statuses</option>
                <option value="planning" {{ ($filters['status'] ?? '') == 'planning' ? 'selected' : '' }}>Planning</option>
                <option value="in_progress" {{ ($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="on_hold" {{ ($filters['status'] ?? '') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                <option value="completed" {{ ($filters['status'] ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Type</label>
                    <select name="project_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        @foreach($projectTypes as $key => $label)
                            <option value="{{ $key }}" {{ ($filters['project_type'] ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Owner</label>
                    <select name="user_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
                </div>
            </div>
            
            <!-- Location Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-globe mr-1"></i>Country (via Contacts)
                    </label>
                    <select name="country_id" id="project_country_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ ($filters['country_id'] ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-map mr-1"></i>State (via Contacts)
                    </label>
                    <select name="state_id" id="project_state_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All States</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ ($filters['state_id'] ?? '') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-location-dot mr-1"></i>District (via Contacts)
                    </label>
                    <select name="district_id" id="project_district_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Districts</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ ($filters['district_id'] ?? '') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
        </form>
        @if(request()->hasAny(['search', 'status', 'project_type', 'user_id', 'country_id', 'state_id', 'district_id']))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                <i class="fas fa-times mr-1"></i>Clear all filters
            </a>
        </div>
        @endif
    </div>

    <!-- Projects Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Project Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Contacts</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Visits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Dates</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $project->name }}</div>
                                @if($project->description)
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($project->description, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($project->project_type)
                                    <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $project->project_type }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-2">
                                        <span class="text-blue-700 dark:text-blue-300 text-xs font-semibold">
                                            {{ strtoupper(substr($project->user->name ?? 'N', 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="text-gray-700 dark:text-gray-300">{{ $project->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'planning' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'in_progress' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'on_hold' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $statusColor = $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full font-medium {{ $statusColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-users text-gray-400 mr-2"></i>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $project->contacts_count ?? 0 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-list text-gray-400 mr-2"></i>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $project->visit_reports_count ?? 0 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                @if($project->start_date || $project->end_date)
                                    <div class="space-y-1">
                                @if($project->start_date)
                                            <div class="flex items-center text-xs">
                                                <i class="fas fa-play-circle text-green-500 mr-1"></i>
                                                <span>{{ $project->start_date->format('M d, Y') }}</span>
                                            </div>
                                @endif
                                @if($project->end_date)
                                            <div class="flex items-center text-xs">
                                                <i class="fas fa-stop-circle text-red-500 mr-1"></i>
                                                <span>{{ $project->end_date->format('M d, Y') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('projects.show', $project->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this project?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-project-diagram text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                    <p class="text-lg font-medium">No projects found</p>
                                    <p class="text-sm mt-1">Create your first project to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }} projects
                    </div>
                    <div>
            {{ $projects->links() }}
                    </div>
                </div>
        </div>
    @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Load states when country changes
    $('#project_country_id').on('change', function() {
        const countryId = $(this).val();
        const stateSelect = $('#project_state_id');
        const districtSelect = $('#project_district_id');
        
        // Reset states and districts
        stateSelect.html('<option value="">All States</option>');
        districtSelect.html('<option value="">All Districts</option>');
        
        if (countryId) {
            $.ajax({
                url: '/api/states',
                method: 'GET',
                data: { country_id: countryId },
                success: function(data) {
                    data.forEach(function(state) {
                        stateSelect.append(`<option value="${state.id}">${state.name}</option>`);
                    });
                }
            });
        }
    });
    
    // Load districts when state changes
    $('#project_state_id').on('change', function() {
        const stateId = $(this).val();
        const districtSelect = $('#project_district_id');
        
        // Reset districts
        districtSelect.html('<option value="">All Districts</option>');
        
        if (stateId) {
            $.ajax({
                url: '/api/districts',
                method: 'GET',
                data: { state_id: stateId },
                success: function(data) {
                    data.forEach(function(district) {
                        districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
                    });
                }
            });
        }
    });
});
</script>
@endpush
@endsection
