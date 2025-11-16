@extends('layouts.admin')

@section('title', 'Edit Hotel')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Hotel</h1>
        <a href="{{ route('hotels.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
            <input type="text" name="name" value="{{ old('name', $hotel->name) }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('description', $hotel->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                <select name="country_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', $hotel->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Destination</label>
                <select name="destination_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select Destination</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}" {{ old('destination_id', $hotel->destination_id) == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                <input type="text" name="type" value="{{ old('type', $hotel->type) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Star Rating</label>
                <select name="star_rating" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select Rating</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('star_rating', $hotel->star_rating) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
            <input type="text" name="address" value="{{ old('address', $hotel->address) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Images</label>
            <input type="file" name="images[]" multiple accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            @if($hotel->images)
                <p class="text-sm text-gray-500 mt-2">Current images will be replaced</p>
            @endif
        </div>

        <div class="flex items-center space-x-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hotel->is_active) ? 'checked' : '' }} class="h-4 w-4">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $hotel->is_featured) ? 'checked' : '' }} class="h-4 w-4">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Featured</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('hotels.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection

