@extends('layouts.admin')

@section('title', 'District/City: ' . $district->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">District/City Details</h1>
        <a href="{{ route('districts.index', ['country_id' => $district->country_id, 'state_id' => $district->state_id]) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $district->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Code</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $district->code ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Country</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $district->country->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">State/Province</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $district->state->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <span class="mt-1 inline-block px-3 py-1 text-sm rounded-full {{ $district->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                    {{ $district->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('districts.edit', $district->id) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-md hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>
</div>
@endsection

