@extends('layouts.admin')

@section('title', 'Create Testimonial')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Testimonial</h1>
        <a href="{{ route('admin.testimonials.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location *</label>
                <input type="text" name="location" value="{{ old('location') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating *</label>
                <select name="rating" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trip Type *</label>
                <select name="trip_type" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    @foreach($tripTypes as $type)
                        <option value="{{ $type }}" {{ old('trip_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trip Date *</label>
            <input type="date" name="trip_date" value="{{ old('trip_date') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Review *</label>
            <textarea name="review" rows="5" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('review') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="verified" value="1" {{ old('verified') ? 'checked' : '' }} class="h-4 w-4">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Verified</span>
                </label>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Featured</span>
                </label>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
        </div>
    </form>
</div>
@endsection

