@extends('layouts.admin')

@section('title', 'Create Destination')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Destination</h1>
        <a href="{{ route('admin.destinations.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white {{ $errors->has('name') ? 'border-red-500' : '' }}">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description *</label>
            <textarea name="description" rows="5" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white {{ $errors->has('description') ? 'border-red-500' : '' }}">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country *</label>
                <select name="country_id" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white {{ $errors->has('country_id') ? 'border-red-500' : '' }}">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white {{ $errors->has('image') ? 'border-red-500' : '' }}">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Latitude</label>
                <input 
                    type="number" 
                    step="any" 
                    name="latitude" 
                    id="latitude"
                    value="{{ old('latitude') }}" 
                    min="-90" 
                    max="90" 
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white {{ $errors->has('latitude') ? 'border-red-500' : '' }}"
                    placeholder="e.g., 28.6139"
                >
                @error('latitude')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Must be between -90 and 90 degrees</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Longitude</label>
                <input 
                    type="number" 
                    step="any" 
                    name="longitude" 
                    id="longitude"
                    value="{{ old('longitude') }}" 
                    min="-180" 
                    max="180" 
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white {{ $errors->has('longitude') ? 'border-red-500' : '' }}"
                    placeholder="e.g., 77.2090"
                >
                @error('longitude')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Must be between -180 and 180 degrees</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Best Time to Visit</label>
                <input type="text" name="best_time_to_visit" value="{{ old('best_time_to_visit') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency Code</label>
                <input type="text" name="currency_code" value="{{ old('currency_code') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Language</label>
                <input type="text" name="language" value="{{ old('language') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Timezone</label>
                <input type="text" name="timezone" value="{{ old('timezone') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="h-4 w-4">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
                </label>
            </div>
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Featured</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.destinations.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');

    // Client-side validation for latitude and longitude
    function validateCoordinates() {
        let isValid = true;

        // Validate latitude
        if (latitudeInput.value !== '') {
            const lat = parseFloat(latitudeInput.value);
            if (isNaN(lat) || lat < -90 || lat > 90) {
                latitudeInput.setCustomValidity('Latitude must be between -90 and 90 degrees.');
                latitudeInput.classList.add('border-red-500');
                isValid = false;
            } else {
                latitudeInput.setCustomValidity('');
                latitudeInput.classList.remove('border-red-500');
            }
        } else {
            latitudeInput.setCustomValidity('');
            latitudeInput.classList.remove('border-red-500');
        }

        // Validate longitude
        if (longitudeInput.value !== '') {
            const lng = parseFloat(longitudeInput.value);
            if (isNaN(lng) || lng < -180 || lng > 180) {
                longitudeInput.setCustomValidity('Longitude must be between -180 and 180 degrees.');
                longitudeInput.classList.add('border-red-500');
                isValid = false;
            } else {
                longitudeInput.setCustomValidity('');
                longitudeInput.classList.remove('border-red-500');
            }
        } else {
            longitudeInput.setCustomValidity('');
            longitudeInput.classList.remove('border-red-500');
        }

        return isValid;
    }

    // Add event listeners
    latitudeInput.addEventListener('input', validateCoordinates);
    latitudeInput.addEventListener('blur', validateCoordinates);
    longitudeInput.addEventListener('input', validateCoordinates);
    longitudeInput.addEventListener('blur', validateCoordinates);

    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateCoordinates()) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endpush
@endsection

