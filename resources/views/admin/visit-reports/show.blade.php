@extends('layouts.admin')

@section('title', 'Visit Report Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Visit Report Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('visit-reports.edit', $visitReport->id) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-md hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('visit-reports.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Project</label>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                    <a href="{{ route('projects.show', $visitReport->project_id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                        {{ $visitReport->project->name }}
                    </a>
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Visit Date</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $visitReport->visit_date->format('M d, Y') }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Objective of Visiting</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $visitReport->objective }}</p>
            </div>
            @if($visitReport->report)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Daily/Visiting Time Report Update</label>
                <p class="mt-1 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $visitReport->report }}</p>
            </div>
            @endif
            @if($visitReport->next_meeting_date)
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Next Meeting Date</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $visitReport->next_meeting_date->format('M d, Y') }}</p>
            </div>
            @endif
            @if($visitReport->next_call_date)
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Next Call Date</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $visitReport->next_call_date->format('M d, Y') }}</p>
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created By</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $visitReport->user->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $visitReport->created_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

