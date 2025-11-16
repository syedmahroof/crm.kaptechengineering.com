@extends('layouts.admin')

@section('title', 'Edit Newsletter Subscription')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Newsletter Subscription</h1>
        <a href="{{ route('admin.newsletters.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.newsletters.update', $newsletter->id) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
            <input type="email" name="email" value="{{ old('email', $newsletter->email) }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $newsletter->first_name) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $newsletter->last_name) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Source</label>
            <input type="text" name="source" value="{{ old('source', $newsletter->source) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_subscribed" value="1" {{ old('is_subscribed', $newsletter->is_subscribed) ? 'checked' : '' }} class="h-4 w-4">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Subscribed</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.newsletters.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection

