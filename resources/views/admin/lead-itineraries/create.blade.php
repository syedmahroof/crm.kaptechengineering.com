@extends('layouts.admin')

@section('title', 'Create Itinerary for Lead')

@section('content')
<div class="flex flex-col gap-6 rounded-xl">
    <div class="border border-gray-300 dark:border-gray-700 rounded-xl p-6 bg-white dark:bg-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                <i class="fas fa-map-marked-alt mr-2"></i>Create New Itinerary
                @if($lead)
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">for {{ $lead->name }}</span>
                @endif
            </h1>
            @if($lead)
                <a href="{{ route('leads.show', $lead->id) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Lead
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('lead-itineraries.store') }}" method="POST" class="space-y-6">
            @csrf
            
            @if($lead)
                <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Lead Selection (if not pre-selected) -->
                @if(!$lead)
                <div class="space-y-1 md:col-span-2">
                    <label for="lead_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Lead <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="lead_id"
                        name="lead_id"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('lead_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                        <option value="">Select a lead...</option>
                        @foreach(\App\Models\Lead::orderBy('name')->get() as $leadOption)
                            <option value="{{ $leadOption->id }}" {{ old('lead_id') == $leadOption->id ? 'selected' : '' }}>
                                {{ $leadOption->name }} ({{ $leadOption->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('lead_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Itinerary Name -->
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Itinerary Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., 7-Day Paris Adventure"
                        required
                    >
                    @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration Days -->
                <div class="space-y-1">
                    <label for="duration_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Duration (Days) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="duration_days"
                        name="duration_days"
                        value="{{ old('duration_days', 7) }}"
                        min="1"
                        max="365"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('duration_days') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                    @error('duration_days')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div class="space-y-1">
                    <label for="country_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Country <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="country_id"
                        name="country_id"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('country_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                        <option value="">Select a country...</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination -->
                <div class="space-y-1">
                    <label for="destination_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Destination(s)
                    </label>
                    <select
                        id="destination_ids"
                        name="destination_ids[]"
                        multiple
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('destination_ids') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ in_array($destination->id, old('destination_ids', [])) ? 'selected' : '' }}>
                                {{ $destination->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Search and select multiple destinations</p>
                    @error('destination_ids')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tagline -->
                <div class="space-y-1 md:col-span-2">
                    <label for="tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tagline
                    </label>
                    <input
                        type="text"
                        id="tagline"
                        name="tagline"
                        value="{{ old('tagline') }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('tagline') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="A short, catchy tagline for your itinerary"
                    >
                    @error('tagline')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="space-y-1 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Brief description of the itinerary..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            <strong>Note:</strong> You'll be redirected to the itinerary builder after creating this itinerary, where you can add detailed day plans, activities, and more information.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                @if($lead)
                    <a href="{{ route('leads.show', $lead->id) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                @else
                    <a href="{{ route('leads.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                @endif
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i>Create & Continue Building
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        padding: 0;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3b82f6;
        border: 1px solid #2563eb;
        color: #fff;
        padding: 2px 8px;
        margin: 2px;
        border-radius: 0.25rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-right: 5px;
    }
    .dark .select2-container--default .select2-selection--multiple {
        background-color: #374151;
        border-color: #4b5563;
        color: #fff;
    }
    .dark .select2-container--default .select2-results__option {
        background-color: #374151;
        color: #fff;
    }
    .dark .select2-container--default .select2-results__option--highlighted {
        background-color: #4b5563;
    }
    .dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #374151;
        border-color: #4b5563;
        color: #fff;
    }
    .select2-dropdown {
        border-color: #d1d5db;
    }
    .dark .select2-dropdown {
        background-color: #374151;
        border-color: #4b5563;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for destinations
        $('#destination_ids').select2({
            placeholder: 'Search and select destinations...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            closeOnSelect: false
        });
    });
</script>
@endpush
@endsection

