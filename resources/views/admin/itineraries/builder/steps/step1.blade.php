<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-semibold mb-2 text-gray-900 dark:text-white">Basic Information</h2>
        <p class="text-gray-600 dark:text-gray-400">
            Set up the foundational details for your itinerary
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Master Itinerary Checkbox -->
        <div class="space-y-1 md:col-span-2">
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="is_master"
                    name="is_master"
                    value="1"
                    {{ old('is_master', $itinerary->is_master) ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="is_master" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Mark as Master Itinerary
                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(Master itineraries can be used as templates and don't require a lead)</span>
                </label>
            </div>
            @error('is_master')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Lead Selection -->
        <div class="space-y-1" id="lead-selection-container">
            <label for="lead_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Lead Reference 
                <span class="text-red-500">*</span>
            </label>
            <select
                id="lead_id"
                name="lead_id"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('lead_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
                <option value="">Select a lead...</option>
                @foreach($leads as $lead)
                    <option value="{{ $lead->id }}" {{ old('lead_id', $itinerary->lead_id) == $lead->id ? 'selected' : '' }}>
                        {{ $lead->name }} ({{ $lead->email }})
                    </option>
                @endforeach
            </select>
            @error('lead_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Trip Name -->
        <div class="space-y-1">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Trip Name <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $itinerary->name) }}"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g., 7-Day Paris Adventure"
                required
            >
            @error('name')
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
                value="{{ old('tagline', $itinerary->tagline) }}"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('tagline') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="A short, catchy tagline"
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
                placeholder="Describe your itinerary..."
            >{{ old('description', $itinerary->description) }}</textarea>
            @error('description')
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
                value="{{ old('duration_days', $itinerary->duration_days ?? 7) }}"
                min="1"
                max="365"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('duration_days') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
            @error('duration_days')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Start Date -->
        <div class="space-y-1" id="start-date-container">
            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Start Date <span class="text-red-500" id="start_date_required">*</span>
            </label>
            <input
                type="date"
                id="start_date"
                name="start_date"
                value="{{ old('start_date', $itinerary->start_date?->format('Y-m-d')) }}"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('start_date') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                @if(!$itinerary->is_master) required @endif
            >
            @error('start_date')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- End Date -->
        <div class="space-y-1" id="end-date-container">
            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                End Date <span class="text-red-500" id="end_date_required">*</span>
            </label>
            <input
                type="date"
                id="end_date"
                name="end_date"
                value="{{ old('end_date', $itinerary->end_date?->format('Y-m-d')) }}"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('end_date') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                @if(!$itinerary->is_master) required @endif
            >
            @error('end_date')
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
                    <option value="{{ $country->id }}" {{ old('country_id', $itinerary->country_id) == $country->id ? 'selected' : '' }}>
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
            <label for="destination_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Destination <span class="text-red-500">*</span>
            </label>
            <select
                id="destination_id"
                name="destination_id"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('destination_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
                <option value="">Select a destination...</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}" 
                            data-country-id="{{ $destination->country_id }}"
                            {{ old('destination_id', $itinerary->destination_id) == $destination->id ? 'selected' : '' }}>
                        {{ $destination->name }}
                    </option>
                @endforeach
            </select>
            @error('destination_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Adult Count -->
        <div class="space-y-1">
            <label for="adult_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Adults
            </label>
            <input
                type="number"
                id="adult_count"
                name="adult_count"
                value="{{ old('adult_count', $itinerary->adult_count ?? '') }}"
                min="0"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('adult_count') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
            @error('adult_count')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Child Count -->
        <div class="space-y-1">
            <label for="child_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Children
            </label>
            <input
                type="number"
                id="child_count"
                name="child_count"
                value="{{ old('child_count', $itinerary->child_count ?? '') }}"
                min="0"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('child_count') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
            @error('child_count')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Infant Count -->
        <div class="space-y-1">
            <label for="infant_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Infants
            </label>
            <input
                type="number"
                id="infant_count"
                name="infant_count"
                value="{{ old('infant_count', $itinerary->infant_count ?? '') }}"
                min="0"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('infant_count') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
            @error('infant_count')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Hotel Category -->
        <div class="space-y-1">
            <label for="hotel_category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Hotel Category
            </label>
            <input
                type="text"
                id="hotel_category"
                name="hotel_category"
                value="{{ old('hotel_category', $itinerary->hotel_category ?? '') }}"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('hotel_category') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="e.g., 3 Star, 4 Star, 5 Star"
            >
            @error('hotel_category')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Cover Image -->
        <div class="space-y-1 md:col-span-2">
            <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Cover Image
            </label>
            @if($itinerary->cover_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $itinerary->cover_image) }}" alt="Cover" class="h-32 w-auto rounded-md">
                </div>
            @endif
            <input
                type="file"
                id="cover_image"
                name="cover_image"
                accept="image/*"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('cover_image') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
            @error('cover_image')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

