@extends('layouts.admin')

@section('title', 'Visit Reports')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Visit Reports</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage visit reports for projects, customers, and contacts</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('visit-reports.analytics') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                <i class="fas fa-chart-line mr-2"></i>Analytics
            </a>
            <a href="{{ route('visit-reports.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>New Visit Report
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form method="GET" action="{{ route('visit-reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select name="project_id" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ ($filters['project_id'] ?? '') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
            <select name="customer_id" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">All Customers</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ ($filters['customer_id'] ?? '') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                @endforeach
            </select>
            <select name="contact_id" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">All Contacts</option>
                @foreach($contacts as $contact)
                    <option value="{{ $contact->id }}" {{ ($filters['contact_id'] ?? '') == $contact->id ? 'selected' : '' }}>{{ $contact->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <!-- Visit Reports Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Linked Entities</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Objective</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Report</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Created By</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($visitReports as $visitReport)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $visitReport->visit_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($visitReport->projects as $project)
                                        <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 hover:bg-blue-200">
                                            <i class="fas fa-project-diagram mr-1"></i>{{ Str::limit($project->name, 15) }}
                                        </a>
                                    @endforeach
                                    @foreach($visitReport->customers as $customer)
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <i class="fas fa-user mr-1"></i>{{ Str::limit($customer->name, 15) }}
                                        </span>
                                    @endforeach
                                    @foreach($visitReport->contacts as $contact)
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            <i class="fas fa-address-book mr-1"></i>{{ Str::limit($contact->name, 15) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ Str::limit($visitReport->objective, 50) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $visitReport->report ? Str::limit($visitReport->report, 50) : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $visitReport->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('visit-reports.show', $visitReport->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('visit-reports.edit', $visitReport->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('visit-reports.destroy', $visitReport->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this visit report?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No visit reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $visitReports->links() }}
        </div>
    </div>
</div>
@endsection
