@extends('layouts.admin')

@section('title', 'Tasks')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .task-card {
        transition: all 0.2s ease;
    }
    .task-card:hover {
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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Tasks Management</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage and track your tasks effectively</p>
            </div>
            <div class="flex items-center space-x-3 flex-wrap">
                <a href="{{ route('tasks.kanban') }}" 
                   class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-200 rounded-lg hover:bg-indigo-50 dark:bg-gray-800 dark:text-indigo-400 dark:border-indigo-400">
                    <i class="fas fa-columns mr-2"></i>Kanban View
                </a>
                <a href="{{ route('tasks.dashboard') }}" 
                   class="px-4 py-2 text-sm font-medium text-purple-600 bg-white border border-purple-200 rounded-lg hover:bg-purple-50 dark:bg-gray-800 dark:text-purple-400 dark:border-purple-400">
                    <i class="fas fa-chart-pie mr-2"></i>Dashboard
                </a>
                <a href="{{ route('tasks.create') }}" 
                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 hover:border-blue-700 dark:bg-blue-500 dark:border-blue-500 dark:hover:bg-blue-400">
                    <i class="fas fa-plus mr-2"></i>New Task
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    @php
        $allTasks = \App\Models\Task::whereNull('parent_task_id')->public();
        $taskStats = [
            'total' => (clone $allTasks)->count(),
            'todo' => (clone $allTasks)->where('status', 'todo')->count(),
            'in_progress' => (clone $allTasks)->where('status', 'in_progress')->count(),
            'hold' => (clone $allTasks)->where('status', 'hold')->count(),
            'review' => (clone $allTasks)->where('status', 'review')->count(),
            'done' => (clone $allTasks)->where('status', 'done')->count(),
        ];
    @endphp
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-6">
        <a href="{{ route('tasks.index', array_filter(array_diff_key(request()->query(), ['status' => '']))) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ !request('status') ? 'bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 border-2 border-blue-200 dark:border-blue-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <i class="fas fa-tasks text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-blue-600 dark:text-blue-400">Total Tasks</h3>
                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $taskStats['total'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'todo'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'todo' ? 'bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/30 dark:to-gray-700/20 border-2 border-gray-300 dark:border-gray-700 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-gray-100 dark:bg-gray-700/50">
                    <i class="far fa-circle text-gray-600 dark:text-gray-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-gray-600 dark:text-gray-400">To Do</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $taskStats['todo'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'in_progress'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'in_progress' ? 'bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 border-2 border-blue-200 dark:border-blue-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <i class="fas fa-spinner text-blue-600 dark:text-blue-400 text-lg animate-spin"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-blue-600 dark:text-blue-400">In Progress</h3>
                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $taskStats['in_progress'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'hold'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'hold' ? 'bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/30 dark:to-yellow-800/20 border-2 border-yellow-200 dark:border-yellow-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                    <i class="fas fa-pause-circle text-yellow-600 dark:text-yellow-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-yellow-600 dark:text-yellow-400">On Hold</h3>
                    <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">{{ $taskStats['hold'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'review'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'review' ? 'bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/20 border-2 border-purple-200 dark:border-purple-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                    <i class="fas fa-eye text-purple-600 dark:text-purple-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-purple-600 dark:text-purple-400">In Review</h3>
                    <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ $taskStats['review'] }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('tasks.index', array_merge(request()->query(), ['status' => 'done'])) }}" 
           class="stat-card p-5 rounded-xl cursor-pointer {{ request('status') == 'done' ? 'bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/20 border-2 border-green-200 dark:border-green-800 shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md' }}">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/30">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xs font-medium text-green-600 dark:text-green-400">Done</h3>
                    <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $taskStats['done'] }}</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ filtersOpen: false }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-filter mr-2 text-gray-400"></i>Filters
            </h3>
            <button @click="filtersOpen = !filtersOpen" 
                    class="px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-chevron-down mr-1 transition-transform duration-200" :class="{ 'rotate-180': filtersOpen }"></i>
                <span x-text="filtersOpen ? 'Hide' : 'Show'">Show</span>
            </button>
        </div>
        <form method="GET" action="{{ route('tasks.index') }}" x-show="filtersOpen" x-collapse>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search tasks..." 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                    <select name="priority" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Priorities</option>
                        @foreach($priorities as $key => $label)
                            <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assigned To</label>
                    <select name="assigned_to" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Sort Options -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-sort mr-1"></i>Sort By
                    </label>
                    <select name="sort_by" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="position" {{ request('sort_by', 'position') == 'position' ? 'selected' : '' }}>Position</option>
                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                        <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Priority</option>
                        <option value="due_date" {{ request('sort_by') == 'due_date' ? 'selected' : '' }}>Due Date</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                        <option value="completed_at" {{ request('sort_by') == 'completed_at' ? 'selected' : '' }}>Completed Date</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-arrow-up mr-1"></i>Order
                    </label>
                    <select name="sort_order" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="asc" {{ request('sort_order', 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                        <i class="fas fa-sort-amount-down mr-2"></i>Apply Sort
                    </button>
                </div>
            </div>
        </form>
        @if(request()->hasAny(['search', 'status', 'priority', 'assigned_to', 'project', 'category', 'sort_by', 'sort_order']))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('tasks.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                <i class="fas fa-times mr-1"></i>Clear all filters and sorting
            </a>
        </div>
        @endif
    </div>

    <!-- Tasks Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden" x-data="{ viewMode: 'table' }">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between flex-wrap gap-4 mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-list mr-2 text-gray-400"></i>Tasks
                    <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded-full">
                        {{ count($initialTasks) }}
                    </span>
                </h3>
                <div class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                    <button @click="viewMode = 'table'" 
                            :class="viewMode === 'table' ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-300'"
                            class="px-3 py-1.5 text-sm font-medium rounded-md transition-all">
                        <i class="fas fa-table mr-1"></i>Table
                    </button>
                    <button @click="viewMode = 'cards'" 
                            :class="viewMode === 'cards' ? 'bg-white dark:bg-gray-600 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-300'"
                            class="px-3 py-1.5 text-sm font-medium rounded-md transition-all">
                        <i class="fas fa-th-large mr-1"></i>Cards
                    </button>
                </div>
            </div>
            
            <!-- Quick Sort -->
            <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center space-x-3">
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
                        <option value="position" {{ request('sort_by', 'position') == 'position' ? 'selected' : '' }}>Position</option>
                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                        <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Priority</option>
                        <option value="due_date" {{ request('sort_by') == 'due_date' ? 'selected' : '' }}>Due Date</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                        <option value="completed_at" {{ request('sort_by') == 'completed_at' ? 'selected' : '' }}>Completed Date</option>
                    </select>
                    <select name="sort_order" 
                            onchange="this.form.submit()"
                            class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="asc" {{ request('sort_order', 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                @if(request('sort_by') && request('sort_by') != 'position')
                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Sorted by {{ ucwords(str_replace('_', ' ', request('sort_by'))) }} 
                    ({{ request('sort_order', 'asc') == 'asc' ? 'Ascending' : 'Descending' }})
                </span>
                @endif
            </form>
        </div>

        <!-- Table View -->
        <div x-show="viewMode === 'table'">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Task</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assigned To</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($initialTasks as $task)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('tasks.show', $task->id) }}" 
                                       class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 flex items-center group">
                                        @if($task->status === 'done')
                                            <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                                        @elseif($task->status === 'in_progress')
                                            <i class="fas fa-spinner text-blue-500 mr-3 text-lg animate-spin"></i>
                                        @elseif($task->status === 'review')
                                            <i class="fas fa-eye text-purple-500 mr-3 text-lg"></i>
                                        @elseif($task->status === 'hold')
                                            <i class="fas fa-pause-circle text-yellow-500 mr-3 text-lg"></i>
                                        @else
                                            <i class="far fa-circle text-gray-400 mr-3 text-lg"></i>
                                        @endif
                                        <div class="flex-1">
                                            <span class="{{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">
                                                {{ Str::limit($task->title ?? 'N/A', 60) }}
                                            </span>
                                            @if($task->project || $task->category)
                                            <div class="mt-1 flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400">
                                                @if($task->project)
                                                <span class="flex items-center"><i class="fas fa-folder mr-1"></i>{{ $task->project }}</span>
                                                @endif
                                                @if($task->category)
                                                <span class="flex items-center"><i class="fas fa-tag mr-1"></i>{{ $task->category }}</span>
                                                @endif
                                                @if($task->subtasks && $task->subtasks->count() > 0)
                                                <span class="flex items-center text-blue-600 dark:text-blue-400">
                                                    <i class="fas fa-tasks mr-1"></i>{{ $task->subtasks->count() }} subtask{{ $task->subtasks->count() > 1 ? 's' : '' }}
                                                </span>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </a>
                                </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'todo' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'hold' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'review' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                        'done' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    ];
                                    $statusColor = $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                    {{ $statuses[$task->status] ?? $task->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $priorityColors = [
                                        'low' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'high' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                                        'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                    $priorityColor = $priorityColors[$task->priority] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $priorityColor }}">
                                    <i class="fas fa-flag mr-1 text-xs"></i>
                                    {{ $priorities[$task->priority] ?? $task->priority }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($task->assignee)
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-2">
                                        <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">
                                            {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $task->assignee->name }}</span>
                                    @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Unassigned</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($task->due_date)
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($task->due_date);
                                        $isOverdue = $dueDate->isPast() && $task->status !== 'done';
                                        $isDueSoon = $dueDate->isFuture() && $dueDate->diffInDays(now()) <= 3;
                                    @endphp
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                        <span class="text-sm {{ $isOverdue ? 'text-red-600 dark:text-red-400 font-semibold' : ($isDueSoon ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-900 dark:text-white') }}">
                                            {{ $dueDate->format('M d, Y') }}
                                        </span>
                                        @if($isOverdue)
                                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Overdue</span>
                                        @elseif($isDueSoon)
                                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Due Soon</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">No due date</span>
                                @endif
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" 
                                           class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 transition-colors"
                                           title="View Task">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        <a href="{{ route('tasks.edit', $task->id) }}" 
                                           class="px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400 transition-colors"
                                           title="Edit Task">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-tasks text-5xl text-gray-300 dark:text-gray-600 mb-4 opacity-50"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No tasks found</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Try adjusting your filters or create a new task</p>
                                        <a href="{{ route('tasks.create') }}" class="mt-4 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                            <i class="fas fa-plus mr-2"></i>Create Task
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card View -->
        <div x-show="viewMode === 'cards'" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($initialTasks as $task)
                    @php
                        $statusColors = [
                            'todo' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600',
                            'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                            'hold' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
                            'review' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 border-purple-200 dark:border-purple-800',
                            'done' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 border-green-200 dark:border-green-800',
                        ];
                        $statusColor = $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800';
                        $priorityColors = [
                            'low' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                            'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                            'high' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                            'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                        ];
                        $priorityColor = $priorityColors[$task->priority] ?? 'bg-gray-100 text-gray-800';
                        $dueDate = $task->due_date ? \Carbon\Carbon::parse($task->due_date) : null;
                        $isOverdue = $dueDate && $dueDate->isPast() && $task->status !== 'done';
                        $isDueSoon = $dueDate && $dueDate->isFuture() && $dueDate->diffInDays(now()) <= 3;
                    @endphp
                    <div class="task-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:border-blue-300 dark:hover:border-blue-700">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('tasks.show', $task->id) }}" 
                                   class="block group">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors {{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">
                                        {{ Str::limit($task->title ?? 'N/A', 40) }}
                                    </h3>
                                </a>
                                @if($task->description)
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
                                    {{ Str::limit($task->description, 100) }}
                                </p>
                                @endif
                            </div>
                            @if($task->status === 'done')
                                <i class="fas fa-check-circle text-green-500 text-xl ml-2"></i>
                            @elseif($task->status === 'in_progress')
                                <i class="fas fa-spinner text-blue-500 text-xl ml-2 animate-spin"></i>
                            @elseif($task->status === 'review')
                                <i class="fas fa-eye text-purple-500 text-xl ml-2"></i>
                            @elseif($task->status === 'hold')
                                <i class="fas fa-pause-circle text-yellow-500 text-xl ml-2"></i>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                {{ $statuses[$task->status] ?? $task->status }}
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $priorityColor }}">
                                <i class="fas fa-flag mr-1 text-xs"></i>
                                {{ $priorities[$task->priority] ?? $task->priority }}
                            </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            @if($task->assignee)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-2">
                                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">
                                        {{ strtoupper(substr($task->assignee->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span>{{ $task->assignee->name }}</span>
                            </div>
                            @endif
                            @if($task->project || $task->category)
                            <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400">
                                @if($task->project)
                                <span><i class="fas fa-folder mr-1"></i>{{ $task->project }}</span>
                                @endif
                                @if($task->category)
                                <span><i class="fas fa-tag mr-1"></i>{{ $task->category }}</span>
                                @endif
                            </div>
                            @endif
                            @if($dueDate)
                            <div class="flex items-center text-sm {{ $isOverdue ? 'text-red-600 dark:text-red-400 font-semibold' : ($isDueSoon ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400') }}">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>{{ $dueDate->format('M d, Y') }}</span>
                                @if($isOverdue)
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Overdue</span>
                                @elseif($isDueSoon)
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Due Soon</span>
                                @endif
                            </div>
                            @endif
                            @if($task->completion_percentage !== null)
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Progress</span>
                                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $task->completion_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-blue-600 h-1.5 rounded-full transition-all" style="width: {{ $task->completion_percentage }}%"></div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('tasks.show', $task->id) }}" 
                                   class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <a href="{{ route('tasks.edit', $task->id) }}" 
                                   class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                            </div>
                            @if($task->tags && count($task->tags) > 0)
                            <div class="flex items-center space-x-1">
                                @foreach(array_slice($task->tags, 0, 2) as $tag)
                                <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 rounded">
                                    {{ $tag }}
                                </span>
                                @endforeach
                                @if(count($task->tags) > 2)
                                <span class="text-xs text-gray-500 dark:text-gray-400">+{{ count($task->tags) - 2 }}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-16">
                            <i class="fas fa-tasks text-5xl text-gray-300 dark:text-gray-600 mb-4 opacity-50"></i>
                            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">No tasks found</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Try adjusting your filters or create a new task</p>
                            <a href="{{ route('tasks.create') }}" class="mt-4 inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Create Task
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        @if(isset($pagination) && $pagination['last_page'] > 1)
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing <span class="font-semibold">{{ $pagination['from'] }}</span> to <span class="font-semibold">{{ $pagination['to'] }}</span> of <span class="font-semibold">{{ $pagination['total'] }}</span> tasks
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($pagination['current_page'] > 1)
                        <a href="{{ route('tasks.index', array_merge(request()->query(), ['page' => $pagination['current_page'] - 1])) }}" 
                           class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <i class="fas fa-chevron-left mr-1"></i>Previous
                        </a>
                        @endif
                        @if($pagination['current_page'] < $pagination['last_page'])
                        <a href="{{ route('tasks.index', array_merge(request()->query(), ['page' => $pagination['current_page'] + 1])) }}" 
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
@endsection

