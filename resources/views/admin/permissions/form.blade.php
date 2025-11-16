@extends('layouts.admin')

@section('title', isset($permission) ? 'Edit Permission' : 'Create Permission')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ isset($permission) ? 'Edit Permission' : 'Create Permission' }}</h1>
        <a href="{{ route('permissions.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @if(isset($permission))
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
            <input type="text" name="name" value="{{ old('name', $permission->name ?? '') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            <p class="text-xs text-gray-500 mt-1">Use format like: view_users, edit_posts, etc.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Guard Name</label>
            <select name="guard_name" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="web" {{ old('guard_name', $permission->guard_name ?? 'web') == 'web' ? 'selected' : '' }}>Web</option>
                <option value="api" {{ old('guard_name', $permission->guard_name ?? 'web') == 'api' ? 'selected' : '' }}>API</option>
            </select>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('permissions.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">{{ isset($permission) ? 'Update' : 'Create' }}</button>
        </div>
    </form>
</div>
@endsection

