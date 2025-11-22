@extends('layouts.admin')

@section('title', 'Contact Details')

@section('content')
@php
    $contactTypes = \App\Models\Contact::getContactTypes();
    $priorityColors = [
        'low' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'high' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
        'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
    ];
    $priorityColor = $priorityColors[$contact->priority] ?? 'bg-gray-100 text-gray-800';
@endphp

<div class="space-y-6">
    <!-- Enhanced Header with Stats -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-xl p-8 border border-gray-200 dark:border-gray-700 text-white">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border-2 border-white/30">
                        <span class="text-3xl font-bold">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $contact->name }}</h1>
                        <div class="flex items-center space-x-3 flex-wrap">
                            @if($contact->contact_type)
                                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                                    <i class="fas fa-tag mr-1"></i>{{ $contactTypes[$contact->contact_type] ?? $contact->contact_type }}
                                </span>
                            @endif
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="fas fa-flag mr-1"></i>{{ ucfirst($contact->priority ?? 'N/A') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg hover:bg-white/30 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this contact?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-500/80 backdrop-blur-sm border border-red-400/30 rounded-lg hover:bg-red-500 transition-colors">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
                <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 text-sm font-medium text-white bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg hover:bg-white/30 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                    <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-medium mt-1 block">
                        {{ Str::limit($contact->email, 25) }}
                    </a>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Phone</p>
                    @if($contact->phone)
                        <div class="flex items-center space-x-3">
                            <a href="tel:{{ $contact->phone }}" class="text-green-600 hover:text-green-900 dark:text-green-400 font-medium">
                                {{ $contact->phone }}
                            </a>
                            <a href="tel:{{ $contact->phone }}" 
                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 transition-colors shadow-sm" 
                               title="Click to call">
                                <i class="fas fa-phone mr-2"></i>Call Now
                            </a>
                        </div>
                    @else
                        <p class="text-gray-400">-</p>
                    @endif
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center ml-4">
                    <i class="fas fa-phone text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</p>
                    <p class="text-gray-900 dark:text-white font-medium mt-1">
                        @if($contact->country)
                            {{ $contact->country->name }}
                            @if($contact->state), {{ $contact->state->name }}@endif
                            @if($contact->district), {{ $contact->district->name }}@endif
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</p>
                    <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $contact->created_at->format('M d, Y') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $contact->created_at->diffForHumans() }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar text-indigo-600 dark:text-indigo-400"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Contact Details</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                            </label>
                            <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-medium break-all">
                                {{ $contact->email }}
                            </a>
                        </div>
                        
                        @if($contact->phone)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-phone mr-2 text-gray-400"></i>Phone Number
                            </label>
                            <div class="flex items-center space-x-3">
                                <a href="tel:{{ $contact->phone }}" class="text-green-600 hover:text-green-900 dark:text-green-400 font-medium">
                                    {{ $contact->phone }}
                                </a>
                                <a href="tel:{{ $contact->phone }}" 
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 transition-colors" 
                                   title="Click to call">
                                    <i class="fas fa-phone mr-1"></i>Call
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($contact->project)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-project-diagram mr-2 text-gray-400"></i>Assigned Project
                            </label>
                            <a href="{{ route('projects.show', $contact->project->id) }}" class="inline-block px-3 py-1.5 text-sm font-medium rounded-lg bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 hover:bg-purple-200 dark:hover:bg-purple-800 transition-colors">
                                <i class="fas fa-external-link-alt mr-1"></i>{{ $contact->project->name }}
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        @if($contact->country || $contact->state || $contact->district)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>Location
                            </label>
                            <div class="space-y-1">
                                @if($contact->country)
                                    <p class="text-gray-900 dark:text-white font-medium">
                                        <i class="fas fa-globe text-gray-400 mr-1"></i>{{ $contact->country->name }}
                                    </p>
                                @endif
                                @if($contact->state)
                                    <p class="text-gray-700 dark:text-gray-300 ml-4">
                                        <i class="fas fa-map text-gray-400 mr-1"></i>{{ $contact->state->name }}
                                    </p>
                                @endif
                                @if($contact->district)
                                    <p class="text-gray-600 dark:text-gray-400 ml-8">
                                        <i class="fas fa-location-dot text-gray-400 mr-1"></i>{{ $contact->district->name }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>Timeline
                            </label>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Created</p>
                                    <p class="text-gray-900 dark:text-white font-medium">{{ $contact->created_at->format('F d, Y') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $contact->created_at->diffForHumans() }}</p>
                                </div>
                                @if($contact->replied_at)
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Replied</p>
                                    <p class="text-gray-900 dark:text-white font-medium">{{ $contact->replied_at->format('F d, Y') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        by {{ $contact->repliedBy->name ?? 'N/A' }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-comment text-green-600 dark:text-green-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Message</h2>
                </div>
                <div class="space-y-4">
                    @if($contact->subject)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Subject</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">{{ $contact->subject }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Content</label>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-gray-900 dark:text-white whitespace-pre-wrap border border-gray-200 dark:border-gray-600">
                            {{ $contact->message }}
                        </div>
                    </div>
                </div>
            </div>

            @if($contact->admin_notes)
            <!-- Admin Notes -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sticky-note text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Admin Notes</h2>
                </div>
                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg text-gray-900 dark:text-white whitespace-pre-wrap border border-yellow-200 dark:border-yellow-800">
                    {{ $contact->admin_notes }}
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Related Projects -->
            @if($relatedProjects->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-project-diagram text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Related Projects</h3>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Projects where this contact appears as a team member</p>
                <div class="space-y-3">
                    @foreach($relatedProjects as $project)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <a href="{{ route('projects.show', $project->id) }}" class="block">
                                <p class="text-sm font-medium text-gray-900 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400">{{ $project->name }}</p>
                                @if($project->project_type)
                                    <span class="text-xs px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ \App\Models\Project::getProjectTypes()[$project->project_type] ?? $project->project_type }}
                                    </span>
                                @endif
                            </a>
                            @php
                                $projectContact = $projectContacts->where('project_id', $project->id)->first();
                            @endphp
                            @if($projectContact)
                                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-user-tag mr-1"></i>Role: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $projectContact->role_label }}</span>
                                        </span>
                                        @if($projectContact->is_primary)
                                            <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                                Primary
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                </div>
                <div class="space-y-2">
                    <a href="mailto:{{ $contact->email }}" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Send Email
                    </a>
                    @if($contact->phone)
                    <a href="tel:{{ $contact->phone }}" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-phone mr-2"></i>Call Now
                    </a>
                    @endif
                    <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Contact
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
