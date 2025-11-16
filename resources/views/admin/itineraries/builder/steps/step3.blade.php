<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-semibold mb-2 text-gray-900 dark:text-white flex items-center">
            <i class="fas fa-file-check mr-2 text-blue-600"></i>Terms & Conditions
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
            Define the terms and conditions for this itinerary
        </p>
    </div>

    <div class="space-y-6">
        <!-- Terms & Conditions -->
        <div>
            <label for="terms_conditions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Terms & Conditions <span class="text-red-500">*</span>
            </label>
            <textarea
                id="terms_conditions"
                name="terms_conditions"
                rows="8"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('terms_conditions') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter terms and conditions..."
                required
            >{{ old('terms_conditions', $itinerary->terms_conditions) }}</textarea>
            @error('terms_conditions')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Cancellation Policy -->
        <div>
            <label for="cancellation_policy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Cancellation Policy <span class="text-red-500">*</span>
            </label>
            <textarea
                id="cancellation_policy"
                name="cancellation_policy"
                rows="8"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('cancellation_policy') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter cancellation policy..."
                required
            >{{ old('cancellation_policy', $itinerary->cancellation_policy) }}</textarea>
            @error('cancellation_policy')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

