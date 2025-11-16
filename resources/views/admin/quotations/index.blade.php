@extends('layouts.admin')

@section('title', 'Quotations')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Quotations</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage and track all quotations</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('quotations.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>New Quotation
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ filtersOpen: false }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-filter mr-2 text-gray-400"></i>Filters
                @if(request()->hasAny(['search', 'status', 'project_id']))
                <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                    {{ collect([request('search'), request('status'), request('project_id')])->filter()->count() }}
                </span>
                @endif
            </h3>
            <button @click="filtersOpen = !filtersOpen" 
                    class="px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-chevron-down mr-1 transition-transform duration-200" :class="{ 'rotate-180': filtersOpen }"></i>
                <span x-text="filtersOpen ? 'Hide' : 'Show'">Show</span>
            </button>
        </div>
        <form method="GET" action="{{ route('quotations.index') }}" x-show="filtersOpen" x-collapse>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                           placeholder="Search quotations..." 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        <option value="draft" {{ ($filters['status'] ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ ($filters['status'] ?? '') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="accepted" {{ ($filters['status'] ?? '') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ ($filters['status'] ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="expired" {{ ($filters['status'] ?? '') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="converted" {{ ($filters['status'] ?? '') == 'converted' ? 'selected' : '' }}>Converted</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project</label>
                    <select name="project_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Projects</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ ($filters['project_id'] ?? '') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
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
        @if(request()->hasAny(['search', 'status', 'project_id']))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('quotations.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                <i class="fas fa-times mr-1"></i>Clear all filters
            </a>
        </div>
        @endif
    </div>

    <!-- Quotations Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Quotation #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Customer/Lead</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Valid Until</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse($quotations as $quotation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $quotation->quotation_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $quotation->quotation_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($quotation->customer)
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $quotation->customer->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Customer</div>
                                @elseif($quotation->lead)
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $quotation->lead->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Lead</div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($quotation->project)
                                    <a href="{{ route('projects.show', $quotation->project->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                        {{ $quotation->project->name }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $quotation->currency ?? 'USD' }} {{ number_format($quotation->total_amount, 2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        'expired' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'converted' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                    ];
                                    $statusColor = $statusColors[$quotation->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full font-medium {{ $statusColor }}">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                @if($quotation->valid_until)
                                    {{ $quotation->valid_until->format('M d, Y') }}
                                    @if($quotation->valid_until->isPast() && $quotation->status !== 'expired')
                                        <div class="text-xs text-red-600 dark:text-red-400 mt-1">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Expired
                                        </div>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('quotations.show', $quotation->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('quotations.edit', $quotation->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this quotation?">
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
                                    <i class="fas fa-file-invoice text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                    <p class="text-lg font-medium">No quotations found</p>
                                    <p class="text-sm mt-1">Create your first quotation to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($quotations->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing {{ $quotations->firstItem() }} to {{ $quotations->lastItem() }} of {{ $quotations->total() }} quotations
                    </div>
                    <div>
                        {{ $quotations->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

