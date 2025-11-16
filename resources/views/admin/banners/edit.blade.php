@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Banner</h1>
        <a href="{{ route('admin.banners.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
            <input type="text" name="title" value="{{ old('title', $banner->title) }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('description', $banner->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image</label>
                @if($banner->image_url)
                    <img src="{{ $banner->image_url }}" alt="Current image" class="w-full h-32 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mobile Image</label>
                @if($banner->mobile_image_url)
                    <img src="{{ $banner->mobile_image_url }}" alt="Current mobile image" class="w-full h-32 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="mobile_image" accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Desktop Image</label>
                @if($banner->desktop_image_url)
                    <img src="{{ $banner->desktop_image_url }}" alt="Current desktop image" class="w-full h-32 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="desktop_image" accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Link URL</label>
                <input type="url" name="link" value="{{ old('link', $banner->link) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Button Text</label>
                <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image Position</label>
                <select name="image_position" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="center" {{ old('image_position', $banner->image_position) == 'center' ? 'selected' : '' }}>Center</option>
                    <option value="top" {{ old('image_position', $banner->image_position) == 'top' ? 'selected' : '' }}>Top</option>
                    <option value="bottom" {{ old('image_position', $banner->image_position) == 'bottom' ? 'selected' : '' }}>Bottom</option>
                    <option value="left" {{ old('image_position', $banner->image_position) == 'left' ? 'selected' : '' }}>Left</option>
                    <option value="right" {{ old('image_position', $banner->image_position) == 'right' ? 'selected' : '' }}>Right</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Overlay Opacity</label>
                <input type="number" name="overlay_opacity" value="{{ old('overlay_opacity', $banner->overlay_opacity ?? 40) }}" min="0" max="100" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="h-4 w-4">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection

