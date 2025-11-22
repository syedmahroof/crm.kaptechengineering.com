@extends('layouts.admin')

@section('title', 'Edit Contact Type')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Contact Type</h1>
        <a href="{{ route('contact-types.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('contact-types.update', $type->id) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name', $type->name) }}" required 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $type->slug) }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('slug')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">URL-friendly identifier</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea name="description" rows="3" 
                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $type->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color</label>
                <input type="color" name="color" value="{{ old('color', $type->color ?? '#3B82F6') }}" 
                       class="w-full h-10 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Used for badges and icons</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Icon</label>
                <input type="text" name="icon" value="{{ old('icon', $type->icon ?? 'fa-address-book') }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="e.g., fa-building, fa-industry">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">FontAwesome icon class (without 'fas')</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $type->sort_order ?? 0) }}" min="0" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Display order (lower numbers first)</p>
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $type->is_active) ? 'checked' : '' }} 
                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('contact-types.index') }}" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                Cancel
            </a>
            <button type="submit" 
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Update
            </button>
        </div>
    </form>
</div>
@endsection

