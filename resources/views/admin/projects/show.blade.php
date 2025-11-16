@extends('layouts.admin')

@section('title', 'Project: ' . $project->name)

@section('content')
@php
    $statusColors = [
        'planning' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'in_progress' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'on_hold' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
    ];
    $statusColor = $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800';
    $projectTypes = \App\Models\Project::getProjectTypes();
@endphp

<div class="space-y-6">
    <!-- Project Header -->
    <div class="bg-gradient-to-r from-indigo-50 via-blue-50 to-purple-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-project-diagram text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $project->name }}</h1>
                        @if($project->project_type)
                            <span class="inline-block mt-1 px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                <i class="fas fa-tag mr-1"></i>{{ $projectTypes[$project->project_type] ?? $project->project_type }}
                            </span>
                        @endif
                    </div>
                </div>
                @if($project->description)
                    <p class="text-gray-600 dark:text-gray-300 mt-2 max-w-3xl">{{ $project->description }}</p>
                @endif
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('projects.edit', $project->id) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-200 rounded-lg hover:bg-indigo-50 dark:bg-gray-700 dark:text-indigo-400 dark:border-indigo-800">
                    <i class="fas fa-edit mr-2"></i>Edit Project
                </a>
                <a href="{{ route('projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Status</p>
                    <p class="mt-1">
                        <span class="inline-block px-3 py-1 text-sm font-medium rounded-full {{ $statusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info-circle text-blue-700 dark:text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Team Contacts</p>
                    <p class="text-3xl font-bold text-green-900 dark:text-green-100 mt-1">
                        {{ $project->projectContacts->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-200 dark:bg-green-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-700 dark:text-green-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-5 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Visit Reports</p>
                    <p class="text-3xl font-bold text-purple-900 dark:text-purple-100 mt-1">
                        {{ $project->visitReports->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-200 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-purple-700 dark:text-purple-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg p-5 border border-orange-200 dark:border-orange-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-600 dark:text-orange-400">General Contacts</p>
                    <p class="text-3xl font-bold text-orange-900 dark:text-orange-100 mt-1">
                        {{ $project->contacts->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-200 dark:bg-orange-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-address-book text-orange-700 dark:text-orange-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-2 mb-6">
                    <i class="fas fa-info-circle text-indigo-600 dark:text-indigo-400"></i>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Project Information</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                <i class="fas fa-user mr-2 text-gray-400"></i>Project Owner
                            </label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->user->name ?? 'N/A' }}</p>
                        </div>
                        
                        @if($project->start_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Start Date
                            </label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->start_date->format('F d, Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $project->start_date->diffForHumans() }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        @if($project->end_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                <i class="fas fa-calendar-check mr-2 text-gray-400"></i>End Date
                            </label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->end_date->format('F d, Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $project->end_date->diffForHumans() }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>Created
                            </label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $project->created_at->format('F d, Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $project->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visit Reports Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-clipboard-list text-purple-600 dark:text-purple-400"></i>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Visit Reports</h2>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('visit-reports.create', ['project_id' => $project->id]) }}" class="px-3 py-1.5 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                            <i class="fas fa-plus mr-1"></i>New
                        </a>
                        <a href="{{ route('visit-reports.index', ['project_id' => $project->id]) }}" class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <i class="fas fa-history mr-1"></i>History
                        </a>
                    </div>
                </div>

                <!-- Quick Add Visit Report Form -->
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600" x-data="{ showForm: false }">
                    <button @click="showForm = !showForm" class="w-full flex items-center justify-between text-left text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <span><i class="fas fa-plus-circle mr-2"></i>Quick Add Visit Report</span>
                        <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': showForm }"></i>
                    </button>
                    <div x-show="showForm" x-collapse class="mt-4">
                        <form id="quickAddVisitReportForm" action="{{ route('visit-reports.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="redirect_to" value="{{ route('projects.show', $project->id) }}">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="visit_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date *</label>
                                    <input type="date" name="visit_date" id="visit_date" value="{{ date('Y-m-d') }}" required
                                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label for="objective" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Objective of Visiting *</label>
                                    <input type="text" name="objective" id="objective" required
                                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                           placeholder="Enter objective">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="report" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Daily/Visiting Time Report Update</label>
                                    <textarea name="report" id="report" rows="4"
                                              class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                              placeholder="Enter report details"></textarea>
                                </div>
                                <div>
                                    <label for="next_meeting_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Next Meeting Date</label>
                                    <input type="date" name="next_meeting_date" id="next_meeting_date"
                                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label for="next_call_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Next Call Date</label>
                                    <input type="date" name="next_call_date" id="next_call_date"
                                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end space-x-3">
                                <button type="button" @click="showForm = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700">
                                    <i class="fas fa-save mr-2"></i>Save Visit Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Visit Reports History -->
                @if($project->visitReports->count() > 0)
                <div class="space-y-3">
                    @foreach($project->visitReports->sortByDesc('visit_date')->take(5) as $visitReport)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $visitReport->visit_date->format('M d, Y') }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            by {{ $visitReport->user->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $visitReport->objective }}</p>
                                    @if($visitReport->report)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($visitReport->report, 100) }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <a href="{{ route('visit-reports.show', $visitReport->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('visit-reports.edit', $visitReport->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($project->visitReports->count() > 5)
                        <div class="text-center pt-2">
                            <a href="{{ route('visit-reports.index', ['project_id' => $project->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                View all {{ $project->visitReports->count() }} visit reports <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
                @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-clipboard-list text-4xl mb-4"></i>
                    <p>No visit reports yet. Create your first visit report above.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Next Actions -->
            @if($latestVisitReport && ($latestVisitReport->next_meeting_date || $latestVisitReport->next_call_date))
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <i class="fas fa-calendar-check text-green-600 dark:text-green-400"></i>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Next Actions</h3>
                </div>
                <div class="space-y-4">
                    @if($latestVisitReport->next_meeting_date)
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-handshake text-green-600 dark:text-green-400"></i>
                            <div>
                                <p class="text-xs font-medium text-green-600 dark:text-green-400">Next Meeting</p>
                                <p class="text-sm font-semibold text-green-900 dark:text-green-100">{{ $latestVisitReport->next_meeting_date->format('M d, Y') }}</p>
                                <p class="text-xs text-green-700 dark:text-green-300 mt-1">{{ $latestVisitReport->next_meeting_date->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($latestVisitReport->next_call_date)
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-phone text-blue-600 dark:text-blue-400"></i>
                            <div>
                                <p class="text-xs font-medium text-blue-600 dark:text-blue-400">Next Call</p>
                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">{{ $latestVisitReport->next_call_date->format('M d, Y') }}</p>
                                <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">{{ $latestVisitReport->next_call_date->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Project Team Contacts -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-users text-green-600 dark:text-green-400"></i>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Team Contacts</h3>
                    </div>
                </div>

                <!-- Quick Add Project Contact -->
                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600" x-data="{ open: {{ $errors->any() ? 'true' : 'false' }}, role: '{{ old('role') }}' }">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-left text-xs font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <span><i class="fas fa-user-plus mr-2"></i>Quick Add</span>
                        <i class="fas fa-chevron-down transition-transform text-xs" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="mt-3">
                        <form action="{{ route('project-contacts.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="mt-1 block w-full px-2 py-1.5 text-sm border rounded-md {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-800 dark:text-white">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Role</label>
                                @php
                                    $projectContactRoles = \App\Models\ProjectContact::getRoles();
                                @endphp
                                <select name="role" x-model="role"
                                        class="mt-1 block w-full px-2 py-1.5 text-sm border rounded-md {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-800 dark:text-white">
                                    <option value="">Select role...</option>
                                    @foreach($projectContactRoles as $roleValue => $roleLabel)
                                        <option value="{{ $roleValue }}" {{ old('role') === $roleValue ? 'selected' : '' }}>{{ $roleLabel }}</option>
                                    @endforeach
                                    <option value="other" {{ old('role') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div x-show="role === 'other'" x-cloak>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Custom Role</label>
                                <input type="text" name="role_custom" value="{{ old('role_custom') }}"
                                       class="mt-1 block w-full px-2 py-1.5 text-sm border rounded-md {{ $errors->has('role_custom') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-800 dark:text-white"
                                       placeholder="Enter role name">
                                @error('role_custom')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="mt-1 block w-full px-2 py-1.5 text-sm border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="mt-1 block w-full px-2 py-1.5 text-sm border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                <textarea name="notes" rows="2"
                                          class="mt-1 block w-full px-2 py-1.5 text-sm border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                                          placeholder="Additional details">{{ old('notes') }}</textarea>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="is_primary" name="is_primary" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ old('is_primary') ? 'checked' : '' }}>
                                <label for="is_primary" class="text-xs text-gray-700 dark:text-gray-300">Primary contact</label>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="open = false" class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200">
                                    Cancel
                                </button>
                                <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                    <i class="fas fa-save mr-1"></i>Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Project Contacts Listing -->
                @if($project->projectContacts->count() > 0)
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    @foreach($project->projectContacts as $projectContact)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $projectContact->name }}</p>
                                        @if($projectContact->is_primary)
                                            <span class="px-1.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Primary</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $projectContact->role_label }}</p>
                                    <div class="flex flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-400">
                                        @if($projectContact->phone)
                                            <span><i class="fas fa-phone mr-1"></i>{{ $projectContact->phone }}</span>
                                        @endif
                                        @if($projectContact->email)
                                            <span><i class="fas fa-envelope mr-1"></i>{{ Str::limit($projectContact->email, 20) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex space-x-1 ml-2">
                                    <a href="{{ route('project-contacts.edit', $projectContact->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('project-contacts.destroy', $projectContact->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to remove this contact?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-address-book text-3xl mb-2"></i>
                    <p class="text-sm">No team contacts yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
