@extends('layouts.admin')

@section('title', 'Enquiry: ' . $enquiry->title)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Enquiry Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-md hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('enquiries.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Title</label>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $enquiry->title }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                @php
                    $statusColors = [
                        'new' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                        'in_progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        'quoted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                    ];
                    $statusColor = $statusColors[$enquiry->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="mt-1 inline-block px-3 py-1 text-sm rounded-full {{ $statusColor }}">
                    {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                </span>
            </div>
            @if($enquiry->description)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $enquiry->description }}</p>
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Project</label>
                <p class="mt-1">
                    @if($enquiry->project)
                        <a href="{{ route('projects.show', $enquiry->project->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                {{ $enquiry->project->name }}
                            </span>
                        </a>
                    @else
                        <span class="text-gray-400">No project assigned</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created By</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $enquiry->creator->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Country</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $enquiry->country->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">State/Province</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $enquiry->state->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">District/City</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $enquiry->district->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created Date</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $enquiry->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Enquiry Contacts -->
    @if($enquiry->contacts->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Enquiry Contacts ({{ $enquiry->contacts->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($enquiry->contacts as $contact)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $contact->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contact->email }}</p>
                            @if($contact->phone)
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contact->phone }}</p>
                            @endif
                        </div>
                    </div>
                    @if($contact->pivot->contact_type)
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ \App\Models\Contact::getContactTypes()[$contact->pivot->contact_type] ?? $contact->pivot->contact_type }}
                            </span>
                        </div>
                    @endif
                    @if($contact->pivot->notes)
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <strong>Notes:</strong> {{ $contact->pivot->notes }}
                        </div>
                    @endif
                    @if($contact->contact_type)
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ \App\Models\Contact::getContactTypes()[$contact->contact_type] ?? $contact->contact_type }}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

