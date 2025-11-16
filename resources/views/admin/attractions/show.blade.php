@extends('layouts.admin')

@section('title', $attraction->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $attraction->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('attractions.edit', $attraction->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('attractions.index') }}" class="px-4 py-2 border rounded-lg">Back</a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Type</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $attraction->type ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Country</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $attraction->country->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Destination</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $attraction->destination->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                <span class="px-2 py-1 text-xs rounded-full {{ $attraction->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $attraction->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
        @if($attraction->description)
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Description</p>
                <p class="text-gray-900 dark:text-white">{{ $attraction->description }}</p>
            </div>
        @endif
    </div>
</div>
@endsection

