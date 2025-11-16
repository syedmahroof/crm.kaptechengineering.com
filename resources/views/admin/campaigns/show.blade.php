@extends('layouts.admin')

@section('title', $campaign->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $campaign->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('campaigns.index') }}" class="px-4 py-2 border rounded-lg">Back</a>
        </div>
    </div>

    <!-- Campaign Details -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Type</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ \App\Models\Campaign::TYPES[$campaign->type] ?? $campaign->type }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                @php
                    $statusColors = [
                        'draft' => 'bg-gray-100 text-gray-800',
                        'active' => 'bg-green-100 text-green-800',
                        'paused' => 'bg-yellow-100 text-yellow-800',
                        'completed' => 'bg-blue-100 text-blue-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                @endphp
                <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$campaign->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($campaign->status) }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Start Date</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->start_date ? $campaign->start_date->format('M d, Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">End Date</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->end_date ? $campaign->end_date->format('M d, Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Budget</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->budget ? '$' . number_format($campaign->budget, 2) : '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Leads</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->leads_count }}</p>
            </div>
        </div>
        @if($campaign->description)
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Description</p>
                <p class="text-gray-900 dark:text-white">{{ $campaign->description }}</p>
            </div>
        @endif
    </div>

    <!-- Campaign Contacts -->
    @if($campaign->contacts_count > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campaign Contacts ({{ $campaign->contacts_count }})</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($campaign->contacts as $contact)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">{{ $contact->name }}</td>
                                <td class="px-4 py-3">{{ $contact->email }}</td>
                                <td class="px-4 py-3">{{ $contact->phone }}</td>
                                <td class="px-4 py-3">
                                    @if($contact->is_winner)
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Winner</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Participant</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right">
                                    @if(!$contact->is_winner)
                                        <form action="{{ route('campaigns.contacts.select-winner', [$campaign->id, $contact->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400" title="Select as Winner">
                                                <i class="fas fa-trophy"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('campaigns.contacts.delete', [$campaign->id, $contact->id]) }}" method="POST" class="inline" data-confirm="Are you sure?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

