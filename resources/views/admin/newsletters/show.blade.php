@extends('layouts.admin')

@section('title', 'Newsletter: ' . $newsletter->email)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Newsletter Subscription</h1>
        <a href="{{ route('admin.newsletters.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $newsletter->email }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <p class="mt-1">
                    <span class="px-2 py-1 text-xs rounded-full {{ $newsletter->is_subscribed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $newsletter->is_subscribed ? 'Subscribed' : 'Unsubscribed' }}
                    </span>
                </p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">First Name</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $newsletter->first_name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Name</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $newsletter->last_name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Source</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $newsletter->source ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Subscribed At</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $newsletter->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.newsletters.edit', $newsletter->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit Subscription
            </a>
        </div>
    </div>
</div>
@endsection

