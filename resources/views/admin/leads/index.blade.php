@extends('layouts.admin')

@section('title', 'Leads Management')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .lead-card {
        transition: all 0.2s ease;
    }
    .lead-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="flex flex-col gap-6 rounded-xl">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 rounded-xl p-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Leads Management</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage and track your leads effectively</p>
            </div>
            <div class="flex items-center space-x-3 flex-wrap">
                <a href="{{ route('leads.export') . '?' . http_build_query(request()->all()) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-file-excel mr-2"></i>Export
                </a>
                <a href="{{ route('leads.analytics') }}" 
                   class="px-4 py-2 text-sm font-medium text-purple-600 bg-white border border-purple-200 rounded-lg hover:bg-purple-50 dark:bg-gray-800 dark:text-purple-400 dark:border-purple-400">
                    <i class="fas fa-chart-line mr-2"></i>Analytics
                </a>
                @can('create leads')
                <a href="{{ route('leads.create') }}" 
                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 hover:border-blue-700 dark:bg-blue-500 dark:border-blue-500 dark:hover:bg-blue-400">
                    <i class="fas fa-plus mr-2"></i>New Lead
                </a>
                @endcan
                
                <!-- Quick Actions Dropdown -->
                <div class="relative ml-2" x-data="{ open: false }">
                    <button @click="open = !open" 
                            @click.away="open = false"
                            class="relative inline-flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-ellipsis-v text-sm"></i>
                        <span class="sr-only">More options</span>
                    </button>
                    <div x-show="open" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-64 rounded-xl shadow-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 z-50 overflow-hidden"
                         style="display: none;">
                        <div class="py-2">
                            <div class="px-4 py-2.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 mb-1">
                                Quick Add
                            </div>
                            @can('create lead sources')
                            <a href="{{ route('lead-sources.create') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 dark:hover:text-blue-400 transition-colors">
                                <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-funnel-dollar text-blue-600 dark:text-blue-400 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium">Add Lead Source</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Create a new source</div>
                                </div>
                            </a>
                            @endcan
                            @can('create lead priorities')
                            <a href="{{ route('lead-priorities.create') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-700 dark:hover:text-yellow-400 transition-colors">
                                <div class="w-9 h-9 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-star text-yellow-600 dark:text-yellow-400 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium">Add Lead Priority</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Create priority level</div>
                                </div>
                            </a>
                            @endcan
                            @can('create lead types')
                            <a href="{{ route('lead-types.create') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-purple-700 dark:hover:text-purple-400 transition-colors">
                                <div class="w-9 h-9 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-tags text-purple-600 dark:text-purple-400 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium">Add Lead Type</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Create new type</div>
                                </div>
                            </a>
                            @endcan
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                        <div class="py-2">
                            <div class="px-4 py-2.5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700 mb-1">
                                Manage
                            </div>
                            @can('view lead sources')
                            <a href="{{ route('lead-sources.index') }}" 
                               class="flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-funnel-dollar w-5 text-gray-400 mr-3"></i>
                                <span class="font-medium">Lead Sources</span>
                            </a>
                            @endcan
                            @can('view lead priorities')
                            <a href="{{ route('lead-priorities.index') }}" 
                               class="flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-star w-5 text-gray-400 mr-3"></i>
                                <span class="font-medium">Lead Priorities</span>
                            </a>
                            @endcan
                            @can('view lead types')
                            <a href="{{ route('lead-types.index') }}" 
                               class="flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-tags w-5 text-gray-400 mr-3"></i>
                                <span class="font-medium">Lead Types</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-6">
        <a href="{{ route('leads.index', array_filter(array_diff_key(request()->query(), ['status' => '']))) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ !request('status') ? 'bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 border-2 border-blue-200 dark:border-blue-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-blue-600 dark:text-blue-400">Total Leads</h3>
                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['total'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'new'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'new' ? 'bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 border-2 border-blue-200 dark:border-blue-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <i class="fas fa-tag text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-blue-600 dark:text-blue-400">New</h3>
                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['new'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'itinerary_sent'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'itinerary_sent' ? 'bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/20 border-2 border-green-200 dark:border-green-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/30">
                    <i class="fas fa-envelope text-green-600 dark:text-green-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-green-600 dark:text-green-400">Itinerary Sent</h3>
                    <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $stats['itinerary_sent'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'hot_lead'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'hot_lead' ? 'bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/20 border-2 border-red-200 dark:border-red-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 dark:bg-red-900/30">
                    <i class="fas fa-fire text-red-600 dark:text-red-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-red-600 dark:text-red-400">Hot Lead</h3>
                    <p class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $stats['hot_lead'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'convert_this_week'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'convert_this_week' ? 'bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/20 border-2 border-amber-200 dark:border-amber-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                    <i class="fas fa-calendar-week text-amber-600 dark:text-amber-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-amber-600 dark:text-amber-400">Convert This Week</h3>
                    <p class="text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $stats['convert_this_week'] ?? 0 }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'cold_lead'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'cold_lead' ? 'bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/30 dark:to-gray-700/20 border-2 border-gray-300 dark:border-gray-700 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-gray-100 dark:bg-gray-700/50">
                    <i class="fas fa-snowflake text-gray-600 dark:text-gray-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400">Cold Lead</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['cold_lead'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'converted'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'converted' ? 'bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/20 border-2 border-emerald-200 dark:border-emerald-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                    <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Converted</h3>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ $stats['converted'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'lost'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'lost' ? 'bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/20 border-2 border-red-200 dark:border-red-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 dark:bg-red-900/30">
                    <i class="fas fa-times-circle text-red-600 dark:text-red-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-red-600 dark:text-red-400">Lost</h3>
                    <p class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $stats['lost'] }}</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ filtersOpen: false }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-filter mr-2 text-gray-400"></i>Filters
                @if(request()->hasAny(['search', 'status', 'lead_source_id', 'lead_priority_id', 'assigned_user_id']))
                <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                    {{ collect([request('status'), request('search'), request('lead_source_id'), request('lead_priority_id'), request('assigned_user_id')])->filter()->count() }}
                </span>
                @endif
            </h3>
            <button @click="filtersOpen = !filtersOpen" 
                    class="px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-chevron-down mr-1 transition-transform duration-200" :class="{ 'rotate-180': filtersOpen }"></i>
                <span x-text="filtersOpen ? 'Hide' : 'Show'">Show</span>
            </button>
        </div>
        <form method="GET" action="{{ route('leads.index') }}" x-show="filtersOpen" x-collapse>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search leads..." 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="itinerary_sent" {{ request('status') == 'itinerary_sent' ? 'selected' : '' }}>Itinerary Sent</option>
                        <option value="hot_lead" {{ request('status') == 'hot_lead' ? 'selected' : '' }}>Hot Lead</option>
                        <option value="convert_this_week" {{ request('status') == 'convert_this_week' ? 'selected' : '' }}>Convert This Week</option>
                        <option value="cold_lead" {{ request('status') == 'cold_lead' ? 'selected' : '' }}>Cold Lead</option>
                        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                        <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Source</label>
                    <select name="lead_source_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Sources</option>
                        @foreach($leadSources ?? [] as $source)
                            <option value="{{ $source->id }}" {{ request('lead_source_id') == $source->id ? 'selected' : '' }}>{{ $source->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                    <select name="lead_priority_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Priorities</option>
                        @foreach($leadPriorities ?? [] as $priority)
                            <option value="{{ $priority->id }}" {{ request('lead_priority_id') == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if(auth()->user()->hasRole('super-admin'))
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assigned User</label>
                    <select name="assigned_user_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Users</option>
                        @foreach($users ?? [] as $user)
                            <option value="{{ $user['id'] }}" {{ request('assigned_user_id') == $user['id'] ? 'selected' : '' }}>{{ $user['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            
            <!-- Sort Options -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-sort mr-1"></i>Sort By
                    </label>
                    <select name="sort_by" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                        <option value="converted_at" {{ request('sort_by') == 'converted_at' ? 'selected' : '' }}>Converted Date</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-arrow-up mr-1"></i>Order
                    </label>
                    <select name="sort_order" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
        @if(request()->hasAny(['search', 'status', 'lead_source_id', 'lead_priority_id', 'assigned_user_id', 'sort_by', 'sort_order']))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('leads.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                <i class="fas fa-times mr-1"></i>Clear all filters and sorting
            </a>
        </div>
        @endif
    </div>

    <!-- Leads Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between flex-wrap gap-4 mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-users mr-2 text-gray-400"></i>Leads
                    <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded-full">
                        {{ $leads->total() }}
                    </span>
                </h3>
            </div>
            
            <!-- Quick Sort -->
            <form method="GET" action="{{ route('leads.index') }}" class="flex items-center space-x-3">
                @foreach(request()->except(['sort_by', 'sort_order']) as $key => $value)
                    @if(is_array($value))
                        @foreach($value as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                        <i class="fas fa-sort mr-2 text-gray-400"></i>Sort:
                    </label>
                    <select name="sort_by" 
                            onchange="this.form.submit()"
                            class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                        <option value="converted_at" {{ request('sort_by') == 'converted_at' ? 'selected' : '' }}>Converted Date</option>
                    </select>
                    <select name="sort_order" 
                            onchange="this.form.submit()"
                            class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                @if(request('sort_by') && request('sort_by') != 'created_at')
                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Sorted by {{ ucwords(str_replace('_', ' ', request('sort_by'))) }} 
                    ({{ request('sort_order', 'desc') == 'desc' ? 'Descending' : 'Ascending' }})
                </span>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lead</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Agent</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('leads.show', $lead->id) }}" class="flex items-center group">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-lg flex-shrink-0">
                                        {{ strtoupper(substr($lead->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $lead->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lead #{{ $lead->id }}</div>
                                        @if($lead->lead_source)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                            <i class="fas fa-tag mr-1"></i>{{ $lead->lead_source->name }}
                                        </div>
                                        @endif
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>{{ $lead->email }}
                                </div>
                                @if($lead->phone)
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                                    <i class="fas fa-phone mr-2 text-gray-400"></i>{{ $lead->phone }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($lead->assigned_user)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($lead->assigned_user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $lead->assigned_user->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $lead->assigned_user->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 dark:text-gray-500 italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'new' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'itinerary_sent' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'hot_lead' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        'convert_this_week' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                        'cold_lead' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
                                        'converted' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                        'lost' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                    $status = $lead->lead_status ? $lead->lead_status->slug : ($lead->status ?? 'new');
                                    $statusClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300';
                                    $statusLabel = $lead->lead_status ? $lead->lead_status->name : ucwords(str_replace('_', ' ', $status));
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $priority = $lead->lead_priority ?? $lead->priority ?? null;
                                    if ($priority) {
                                        // Determine icon based on level (lower level = higher priority)
                                        $iconMap = [
                                            1 => 'fas fa-angle-double-up', // Urgent - Double up arrow
                                            2 => 'fas fa-angle-up',        // High - Single up arrow
                                            3 => 'fas fa-minus',           // Medium - Horizontal line
                                            4 => 'fas fa-angle-down',      // Low - Down arrow
                                        ];
                                        $icon = $iconMap[$priority->level] ?? 'fas fa-minus';
                                    }
                                @endphp
                                @if($priority)
                                    <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs leading-5 font-semibold rounded-full" 
                                          style="background-color: {{ ($priority->color ?? '#999') }}20; color: {{ $priority->color ?? '#999' }}; border: 1px solid {{ ($priority->color ?? '#999') }}40">
                                        <i class="{{ $icon }}"></i>
                                        {{ $priority->name }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs leading-5 font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded-full">
                                        <i class="fas fa-minus"></i>
                                        No Priority
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('leads.show', $lead->id) }}" 
                                       class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 transition-colors"
                                       title="View Lead">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    @can('edit leads')
                                    <a href="{{ route('leads.edit', $lead->id) }}" 
                                       class="px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400 transition-colors"
                                       title="Edit Lead">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    @endcan
                                    @can('delete leads')
                                    <button onclick="confirmDelete({{ $lead->id }}, '{{ addslashes($lead->name) }}')" 
                                            class="px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 transition-colors"
                                            title="Delete Lead">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-5xl text-gray-300 dark:text-gray-600 mb-4 opacity-50"></i>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No leads found</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Try adjusting your filters or create a new lead</p>
                                    @can('create leads')
                                    <a href="{{ route('leads.create') }}" class="mt-4 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-plus mr-2"></i>Create Lead
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leads->lastPage() > 1)
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing <span class="font-semibold">{{ $leads->firstItem() }}</span> to <span class="font-semibold">{{ $leads->lastItem() }}</span> of <span class="font-semibold">{{ $leads->total() }}</span> leads
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($leads->previousPageUrl())
                        <a href="{{ $leads->previousPageUrl() }}" 
                           class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <i class="fas fa-chevron-left mr-1"></i>Previous
                        </a>
                        @endif
                        <span class="px-3 py-2 text-sm text-gray-600 dark:text-gray-400">
                            Page {{ $leads->currentPage() }} of {{ $leads->lastPage() }}
                        </span>
                        @if($leads->nextPageUrl())
                        <a href="{{ $leads->nextPageUrl() }}" 
                           class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            Next<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50" x-data="{ open: false, leadId: null, leadName: '' }" x-show="open" @click.away="open = false">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Lead</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-4">
            Are you sure you want to delete <span x-text="leadName" class="font-semibold"></span>? This action cannot be undone.
        </p>
        <form :action="`/leads/${leadId}`" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" @click="open = false" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(leadId, leadName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        if (form) {
            form.action = `/leads/${leadId}`;
        }
        const nameElement = modal?.querySelector('[x-text="leadName"]');
        if (nameElement) {
            nameElement.textContent = leadName;
        }
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        }
    });
</script>
@endpush
@endsection

