@extends('layouts.admin')

@section('title', 'Visit Report Details')

@section('content')
<div class="space-y-6">
    <!-- Enhanced Header -->
    <div class="bg-white dark:bg-white rounded-xl p-8 border border-gray-200 dark:border-gray-700 shadow-lg">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-100 rounded-xl flex items-center justify-center border-2 border-indigo-200 dark:border-indigo-200">
                        <i class="fas fa-clipboard-list text-3xl text-indigo-600 dark:text-indigo-600"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold mb-2 text-gray-900 dark:text-gray-900">Visit Report Details</h1>
                        <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-600">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            <span class="text-lg">{{ $visitReport->visit_date->format('F d, Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xl font-semibold text-gray-900 dark:text-gray-900 mb-2">
                        <i class="fas fa-bullseye mr-2 text-indigo-600 dark:text-indigo-600"></i>{{ $visitReport->objective }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('visit-reports.edit', $visitReport->id) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-100 dark:text-gray-700 dark:border-gray-300 dark:hover:bg-gray-200 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('visit-reports.destroy', $visitReport->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this visit report?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-500 rounded-lg hover:bg-red-700 dark:bg-red-600 dark:border-red-500 dark:hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
                <a href="{{ route('visit-reports.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-100 dark:text-gray-700 dark:border-gray-300 dark:hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Linked Entities Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-link text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Linked Entities</h2>
                </div>
                
                <div class="space-y-4">
                    @if($visitReport->projects->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-project-diagram mr-2 text-blue-500"></i>Projects
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($visitReport->projects as $project)
                                    <a href="{{ route('projects.show', $project->id) }}" 
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors shadow-sm">
                                        <i class="fas fa-project-diagram mr-2"></i>{{ $project->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($visitReport->customers->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-user mr-2 text-green-500"></i>Customers
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($visitReport->customers as $customer)
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 shadow-sm">
                                        <i class="fas fa-user mr-2"></i>{{ $customer->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($visitReport->contacts->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-address-book mr-2 text-purple-500"></i>Contacts
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($visitReport->contacts as $contact)
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 shadow-sm">
                                        <i class="fas fa-address-book mr-2"></i>{{ $contact->name }}
                                        @if($contact->email)
                                            <span class="ml-2 text-xs opacity-75">({{ $contact->email }})</span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($visitReport->projects->count() == 0 && $visitReport->customers->count() == 0 && $visitReport->contacts->count() == 0)
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                            <p class="text-gray-400 dark:text-gray-500">No entities linked to this visit report</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Visit Report Content -->
            @if($visitReport->report)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Report Details</h2>
                </div>
                <div class="prose dark:prose-invert max-w-none">
                    <div class="p-4 bg-white dark:bg-white rounded-lg border border-gray-200 dark:border-gray-600">
                        <p class="text-gray-900 dark:text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $visitReport->report }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Visit Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Visit Information</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 bg-white dark:bg-white rounded-lg border border-gray-200 dark:border-gray-600">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-500 mb-1">
                            <i class="fas fa-calendar mr-1"></i>Visit Date
                        </label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-900">{{ $visitReport->visit_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $visitReport->visit_date->diffForHumans() }}</p>
                    </div>

                    <div class="p-4 bg-white dark:bg-white rounded-lg border border-gray-200 dark:border-gray-600">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-500 mb-1">
                            <i class="fas fa-bullseye mr-1"></i>Objective
                        </label>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-900">{{ $visitReport->objective }}</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Actions Card -->
            @if($visitReport->next_meeting_date || $visitReport->next_call_date)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Upcoming Actions</h3>
                </div>
                
                <div class="space-y-4">
                    @if($visitReport->next_meeting_date)
                        <div class="p-4 bg-white dark:bg-white rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-handshake text-green-600 dark:text-green-600"></i>
                                    <label class="text-xs font-medium text-gray-700 dark:text-gray-700">Next Meeting</label>
                                </div>
                                @if($visitReport->next_meeting_date->isPast())
                                    <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-100 dark:text-red-800 rounded-full">Overdue</span>
                                @elseif($visitReport->next_meeting_date->isToday())
                                    <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-100 dark:text-yellow-800 rounded-full">Today</span>
                                @elseif($visitReport->next_meeting_date->isFuture() && $visitReport->next_meeting_date->diffInDays(now()) <= 7)
                                    <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-100 dark:text-blue-800 rounded-full">Upcoming</span>
                                @endif
                            </div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-900">{{ $visitReport->next_meeting_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-600 mt-1">{{ $visitReport->next_meeting_date->diffForHumans() }}</p>
                        </div>
                    @endif

                    @if($visitReport->next_call_date)
                        <div class="p-4 bg-white dark:bg-white rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-blue-600 dark:text-blue-600"></i>
                                    <label class="text-xs font-medium text-gray-700 dark:text-gray-700">Next Call</label>
                                </div>
                                @if($visitReport->next_call_date->isPast())
                                    <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-100 dark:text-red-800 rounded-full">Overdue</span>
                                @elseif($visitReport->next_call_date->isToday())
                                    <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-100 dark:text-yellow-800 rounded-full">Today</span>
                                @elseif($visitReport->next_call_date->isFuture() && $visitReport->next_call_date->diffInDays(now()) <= 7)
                                    <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-100 dark:text-blue-800 rounded-full">Upcoming</span>
                                @endif
                            </div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-900">{{ $visitReport->next_call_date->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-600 mt-1">{{ $visitReport->next_call_date->diffForHumans() }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Metadata Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-circle text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Metadata</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-user mr-2"></i>Created By
                        </span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visitReport->user->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-clock mr-2"></i>Created At
                        </span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visitReport->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-edit mr-2"></i>Last Updated
                        </span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visitReport->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('visit-reports.edit', $visitReport->id) }}" 
                       class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Report
                    </a>
                    <a href="{{ route('visit-reports.index') }}" 
                       class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 transition-colors">
                        <i class="fas fa-list mr-2"></i>View All Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
