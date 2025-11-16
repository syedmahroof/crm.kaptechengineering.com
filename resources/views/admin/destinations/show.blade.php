@extends('layouts.admin')

@section('title', $destination->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $destination->name }}</h1>
        <a href="{{ route('admin.destinations.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @if($destination->images && is_array($destination->images) && count($destination->images) > 0)
            <div>
                <img src="{{ asset('storage/' . $destination->images[0]) }}" alt="{{ $destination->name }}" class="w-full h-64 object-cover rounded-lg">
            </div>
        @endif

        <div>
            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
            <p class="mt-1 text-gray-900 dark:text-white">{{ $destination->description }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Country</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $destination->country->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <p class="mt-1">
                    <span class="px-2 py-1 text-xs rounded-full {{ $destination->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $destination->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($destination->is_featured)
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 ml-2">Featured</span>
                    @endif
                </p>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit Destination
            </a>
        </div>
    </div>
</div>
@endsection

