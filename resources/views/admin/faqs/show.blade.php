@extends('layouts.admin')

@section('title', 'FAQ: ' . Str::limit($faq->question, 50))

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">FAQ Details</h1>
        <a href="{{ route('admin.faqs.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        <div>
            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Question</label>
            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $faq->question }}</p>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Answer</label>
            <p class="mt-1 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $faq->answer }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $faq->category }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <p class="mt-1">
                    <span class="px-2 py-1 text-xs rounded-full {{ $faq->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Sort Order</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $faq->sort_order }}</p>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit FAQ
            </a>
        </div>
    </div>
</div>
@endsection

