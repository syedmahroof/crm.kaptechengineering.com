@extends('layouts.admin')

@section('title', $state->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $state->name }}</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('states.edit', $state->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('states.index', ['country_id' => $state->country_id]) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">State/Province Name</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $state->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Code</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $state->code ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Country</label>
                <p class="mt-1 text-gray-900 dark:text-white">
                    <a href="{{ route('countries.show', $state->country_id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                        {{ $state->country->name ?? 'N/A' }}
                    </a>
                </p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <p class="mt-1">
                    <span class="px-2 py-1 text-xs rounded-full {{ $state->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ $state->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

