@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="space-y-6">
        <!-- Clean White Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Welcome back, <span class="text-blue-600 dark:text-blue-400">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Here's your business overview for today
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:block text-right bg-white dark:bg-gray-800 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                        <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wide">Last updated</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white" id="currentTime">
                            {{ now()->format('h:i A') }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ now()->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Clean White Stats Grid with Minimal Colors -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Leads Card -->
            <a href="{{ route('leads.index') }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-blue-200 dark:hover:border-blue-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 dark:text-blue-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded">View</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Leads</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['totalLeads']) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $stats['newLeads'] }} new today</p>
            </a>

            <!-- Total Projects Card -->
            <a href="{{ route('projects.index') }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-indigo-200 dark:hover:border-indigo-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-project-diagram text-indigo-600 dark:text-indigo-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 rounded">View</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Projects</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['totalProjects']) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $stats['activeProjects'] }} active</p>
            </a>

            <!-- Total Contacts Card -->
            <a href="{{ route('admin.contacts.index') }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-purple-200 dark:hover:border-purple-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-envelope text-purple-600 dark:text-purple-400 text-lg"></i>
                    </div>
                    @if($stats['urgentContacts'] > 0)
                    <span class="text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded">{{ $stats['urgentContacts'] }} urgent</span>
                    @else
                    <span class="text-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/20 px-2 py-1 rounded">View</span>
                    @endif
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Contacts</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['totalContacts']) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $stats['newContacts'] }} new today</p>
            </a>

            <!-- Visit Reports Card -->
            <a href="{{ route('visit-reports.index') }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-green-200 dark:hover:border-green-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded">View</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Visit Reports</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['totalVisitReports']) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $stats['recentVisitReports'] }} this week</p>
            </a>
        </div>

        <!-- Additional Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- New Leads Card -->
            <a href="{{ route('leads.index', ['status' => 'new']) }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-purple-200 dark:hover:border-purple-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-purple-600 dark:text-purple-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded">Today</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">New Leads</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['newLeads']) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Created today</p>
            </a>

            <!-- Convert This Week Card -->
            <a href="{{ route('leads.index', ['status' => 'convert_this_week']) }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-amber-200 dark:hover:border-amber-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-week text-amber-600 dark:text-amber-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 px-2 py-1 rounded">This Week</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Convert This Week</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['convertThisWeek'] ?? 0) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Leads to convert</p>
            </a>

            <!-- Converted Card -->
            <a href="{{ route('leads.index', ['status' => 'converted']) }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-green-200 dark:hover:border-green-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-double text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded">Total</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Converted</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['converted'] ?? 0) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Successfully converted</p>
            </a>

            <!-- Upcoming Meetings Card -->
            <a href="{{ route('visit-reports.index') }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-blue-200 dark:hover:border-blue-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-blue-600 dark:text-blue-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded">Next 7 Days</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Upcoming Meetings</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['upcomingMeetings'] ?? 0) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Scheduled meetings</p>
            </a>
        </div>

        <!-- Tasks Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Completed Tasks Card -->
            <a href="{{ route('tasks.index', ['status' => 'completed']) }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-green-200 dark:hover:border-green-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded">Today</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Completed Tasks</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['completedTasks']) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Completed today</p>
            </a>

            <!-- Pending Tasks Card -->
            <a href="{{ route('tasks.index') }}" class="stat-card bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:border-amber-200 dark:hover:border-amber-700 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-amber-600 dark:text-amber-400 text-lg"></i>
                    </div>
                    <span class="text-xs font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 px-2 py-1 rounded">!</span>
                </div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Pending Tasks</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">{{ number_format($stats['pendingTasks']) }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Needs attention</p>
            </a>
        </div>

        <!-- Clean White Quick Actions with Minimal Colors -->
        <div class="mb-6">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Quick Actions</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Common tasks and shortcuts</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="{{ route('leads.create') }}" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mb-3 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30 transition-colors">
                            <i class="fas fa-user-plus text-blue-600 dark:text-blue-400 text-lg"></i>
                        </div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">New Lead</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Add a new lead</p>
                    </div>
                </a>

                <a href="/calendar" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-600 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center mb-3 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30 transition-colors">
                            <i class="fas fa-calendar text-indigo-600 dark:text-indigo-400 text-lg"></i>
                        </div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">Calendar</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">View schedule</p>
                    </div>
                </a>

                <a href="{{ route('leads.analytics') }}" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-lg hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg flex items-center justify-center mb-3 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/30 transition-colors">
                            <i class="fas fa-chart-bar text-emerald-600 dark:text-emerald-400 text-lg"></i>
                        </div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">Analytics</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">View reports</p>
                    </div>
                </a>

                <a href="{{ route('tasks.create') }}" class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-lg hover:border-purple-300 dark:hover:border-purple-600 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-lg flex items-center justify-center mb-3 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/30 transition-colors">
                            <i class="fas fa-plus text-purple-600 dark:text-purple-400 text-lg"></i>
                        </div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">Add Task</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Create new task</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Clean White Content Grid with Minimal Colors -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-6">
            <!-- Clean White Reminders -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:border-orange-200 dark:hover:border-orange-700 transition-all duration-200">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-50 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-calendar text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Reminders</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Upcoming events</p>
                        </div>
                    </div>
                    <a href="/calendar" class="text-gray-600 hover:text-orange-600 dark:text-gray-400 dark:hover:text-orange-400 text-sm font-medium transition-colors">
                        View All →
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse($reminders as $reminder)
                        <div class="flex items-start space-x-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600 hover:bg-orange-50 dark:hover:bg-orange-900/10 transition-colors">
                            <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-calendar text-orange-600 dark:text-orange-400 text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $reminder['title'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $reminder['date'] ?? 'Today' }} @ {{ $reminder['time'] ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-calendar text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No reminders scheduled</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Clean White To Do List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:border-green-200 dark:hover:border-green-700 transition-all duration-200">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">To Do List</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Your tasks</p>
                        </div>
                    </div>
                    <a href="{{ route('tasks.create') }}" class="text-gray-600 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400 text-sm font-medium transition-colors">
                        <i class="fas fa-plus mr-1"></i>Add Task
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse($todos as $todo)
                        <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-300 border border-gray-100 dark:border-gray-700/30 task-item" data-task-id="{{ $todo['id'] }}">
                            <button type="button" class="task-complete-btn flex-shrink-0 w-6 h-6 rounded border-2 border-gray-300 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-500 transition-colors flex items-center justify-center bg-white dark:bg-gray-800" data-task-id="{{ $todo['id'] }}" data-completed="{{ $todo['completed'] ?? false ? 'true' : 'false' }}">
                                <i class="fas fa-check text-xs {{ $todo['completed'] ?? false ? 'text-green-600 dark:text-green-400' : 'text-transparent' }} transition-colors"></i>
                            </button>
                            <div class="flex-1 min-w-0 cursor-pointer" onclick="window.location.href='{{ route('tasks.show', $todo['id']) }}'">
                                <p class="text-sm font-medium {{ ($todo['completed'] ?? false) ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-white' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $todo['title'] }}
                                </p>
                                @if(!empty($todo['due_date']))
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 flex items-center">
                                        <i class="fas fa-clock mr-1.5 text-gray-400"></i>
                                        Due: {{ \Carbon\Carbon::parse($todo['due_date'])->format('M d, Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-check-circle text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No tasks yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Clean White Quote of the Day - Business Quotes -->
            <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 rounded-xl border-2 border-indigo-200 dark:border-indigo-800 p-6 shadow-lg hover:shadow-xl transition-all duration-200">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <i class="fas fa-quote-left text-white text-2xl"></i>
                    </div>
                    <div class="mb-2">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Quote of the Day</h3>
                        <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">Business Inspiration</p>
                    </div>
                    <blockquote class="space-y-4 mt-4">
                        <div class="relative">
                            <i class="fas fa-quote-left text-indigo-300 dark:text-indigo-600 text-3xl absolute -top-2 -left-2 opacity-50"></i>
                            <p class="text-lg italic text-gray-800 dark:text-gray-200 leading-relaxed px-6 py-2 relative z-10">"{{ $quoteOfTheDay['text'] }}"</p>
                        </div>
                        <footer class="flex items-center justify-center space-x-2 pt-2">
                            <div class="w-8 h-px bg-indigo-300 dark:bg-indigo-600"></div>
                            <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">— {{ $quoteOfTheDay['author'] }}</p>
                            <div class="w-8 h-px bg-indigo-300 dark:bg-indigo-600"></div>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>

        <!-- Clean White Bottom Section with Minimal Colors -->
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Clean White Leads Assigned to Me -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:border-blue-200 dark:hover:border-blue-700 transition-all duration-200">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Leads Assigned to Me</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Your assigned leads</p>
                        </div>
                    </div>
                    <a href="{{ route('leads.index') }}" class="text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 text-sm font-medium transition-colors">
                        View All →
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse($assignedLeads as $lead)
                        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors border border-gray-100 dark:border-gray-700/30">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-700 dark:text-blue-300 font-semibold text-sm">
                                        {{ strtoupper(substr($lead['name'], 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $lead['name'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="fas fa-building mr-1.5 text-gray-400"></i>
                                        {{ $lead['company'] ?? 'No company' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center rounded px-2 py-0.5 text-xs font-medium bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800">
                                    {{ $lead['status'] }}
                                </span>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 flex items-center justify-end">
                                    <i class="fas fa-clock mr-1"></i>{{ $lead['date'] ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-users text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No leads assigned to you</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Clean White Pending Tasks -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:border-red-200 dark:hover:border-red-700 transition-all duration-200">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Pending Tasks</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tasks needing attention</p>
                        </div>
                    </div>
                    <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 text-sm font-medium transition-colors">
                        View All →
                    </a>
                </div>
                <div class="space-y-2">
                    @forelse($pendingTasksList as $task)
                        <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors border border-gray-100 dark:border-gray-700/30 cursor-pointer" onclick="window.location.href='{{ route('tasks.show', $task['id']) }}'">
                            <div class="w-8 h-8 rounded flex items-center justify-center flex-shrink-0 mt-0.5 {{ $task['priority'] == 'high' ? 'bg-red-100 dark:bg-red-900/30' : ($task['priority'] == 'medium' ? 'bg-amber-100 dark:bg-amber-900/30' : 'bg-green-100 dark:bg-green-900/30') }}">
                                <i class="fas fa-exclamation-circle text-xs {{ $task['priority'] == 'high' ? 'text-red-600 dark:text-red-400' : ($task['priority'] == 'medium' ? 'text-amber-600 dark:text-amber-400' : 'text-green-600 dark:text-green-400') }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 dark:text-white truncate hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ $task['title'] }}</div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $task['priority'] == 'high' ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 border border-red-200 dark:border-red-800' : ($task['priority'] == 'medium' ? 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 border border-amber-200 dark:border-amber-800' : 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400 border border-green-200 dark:border-green-800') }}">
                                        {{ ucfirst($task['priority']) }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="fas fa-calendar-alt mr-1.5 text-gray-400"></i>{{ $task['due'] ?? 'No due date' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-exclamation-circle text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No pending tasks</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stat-card {
        animation: fadeIn 0.4s ease-out;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }
    
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Update time every minute
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour: 'numeric', 
            minute: 'numeric',
            hour12: true 
        });
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    // Update immediately and then every minute
    updateTime();
    setInterval(updateTime, 60000);

    // Task completion handler
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.task-complete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent triggering the parent click
                
                const taskId = this.getAttribute('data-task-id');
                const isCompleted = this.getAttribute('data-completed') === 'true';
                const taskItem = this.closest('.task-item');
                const checkIcon = this.querySelector('i');
                const titleElement = taskItem.querySelector('.flex-1 p');
                
                // Show loading state
                this.disabled = true;
                const originalBorder = this.style.borderColor;
                this.style.borderColor = '#9ca3af';
                
                fetch(`/api/tasks/${taskId}/complete`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update UI
                    const newCompleted = !isCompleted;
                    this.setAttribute('data-completed', newCompleted.toString());
                    
                    if (newCompleted) {
                        checkIcon.classList.remove('text-transparent');
                        checkIcon.classList.add('text-green-600', 'dark:text-green-400');
                        this.classList.add('border-green-500');
                        titleElement.classList.add('line-through', 'text-gray-400', 'dark:text-gray-500');
                        titleElement.classList.remove('text-gray-900', 'dark:text-white');
                    } else {
                        checkIcon.classList.add('text-transparent');
                        checkIcon.classList.remove('text-green-600', 'dark:text-green-400');
                        this.classList.remove('border-green-500');
                        titleElement.classList.remove('line-through', 'text-gray-400', 'dark:text-gray-500');
                        titleElement.classList.add('text-gray-900', 'dark:text-white');
                    }
                    
                    // Show notification
                    showNotification(data.message || 'Task updated successfully', 'success');
                    
                    // Update stats without full page reload
                    if (newCompleted) {
                        // Remove task from list after a delay
                        setTimeout(() => {
                            taskItem.style.opacity = '0';
                            taskItem.style.transform = 'translateX(-20px)';
                            setTimeout(() => {
                                taskItem.remove();
                                // Reload page to update stats
                                window.location.reload();
                            }, 300);
                        }, 2000);
                    } else {
                        // Reload page to update stats
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to update task. Please try again.', 'error');
                    this.disabled = false;
                    this.style.borderColor = originalBorder;
                });
            });
        });
    });

    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transition-all duration-300 ${
            type === 'success' 
                ? 'bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200' 
                : 'bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200'
        }`;
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        notification.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 3000);
    }
</script>
@endpush
@endsection

