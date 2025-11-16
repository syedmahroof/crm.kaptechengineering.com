@extends('layouts.admin')

@section('title', 'Edit Flight Ticket')

@section('content')
<div class="flex flex-col gap-6 rounded-xl">
    <div class="border border-gray-300 dark:border-gray-700 rounded-xl p-6 bg-white dark:bg-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                <i class="fas fa-edit mr-2"></i>Edit Flight Ticket
            </h1>
            <a href="{{ route('flight-tickets.show', $flightTicket->id) }}" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
        
        <form action="{{ route('flight-tickets.update', $flightTicket->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Departure Airport -->
                <div class="space-y-1">
                    <label for="departure_airport" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Departure Airport <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="departure_airport"
                        name="departure_airport"
                        value="{{ old('departure_airport', $flightTicket->departure_airport) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('departure_airport') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., JFK, LAX"
                        required
                    >
                    @error('departure_airport')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Arrival Airport -->
                <div class="space-y-1">
                    <label for="arrival_airport" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Arrival Airport <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="arrival_airport"
                        name="arrival_airport"
                        value="{{ old('arrival_airport', $flightTicket->arrival_airport) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('arrival_airport') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., LHR, CDG"
                        required
                    >
                    @error('arrival_airport')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Departure Date -->
                <div class="space-y-1">
                    <label for="departure_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Departure Date <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="departure_date"
                        name="departure_date"
                        value="{{ old('departure_date', $flightTicket->departure_date->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('departure_date') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                    @error('departure_date')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Return Date -->
                <div class="space-y-1">
                    <label for="return_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Return Date (Optional)
                    </label>
                    <input
                        type="date"
                        id="return_date"
                        name="return_date"
                        value="{{ old('return_date', $flightTicket->return_date ? $flightTicket->return_date->format('Y-m-d') : '') }}"
                        min="{{ old('departure_date', $flightTicket->departure_date->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('return_date') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    @error('return_date')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Passenger Count -->
                <div class="space-y-1">
                    <label for="passenger_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Number of Passengers <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="passenger_count"
                        name="passenger_count"
                        value="{{ old('passenger_count', $flightTicket->passenger_count) }}"
                        min="1"
                        max="20"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('passenger_count') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                    @error('passenger_count')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class Type -->
                <div class="space-y-1">
                    <label for="class_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Class Type <span class="text-red-500">*</span>
                    </label>
                    <select id="class_type" name="class_type" required
                            class="w-full px-3 py-2 border rounded-md {{ $errors->has('class_type') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select class...</option>
                        @foreach($classTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('class_type', $flightTicket->class_type) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('class_type')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Airline Preference -->
                <div class="space-y-1">
                    <label for="airline_preference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Airline Preference
                    </label>
                    <input
                        type="text"
                        id="airline_preference"
                        name="airline_preference"
                        value="{{ old('airline_preference', $flightTicket->airline_preference) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('airline_preference') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., Emirates, Qatar Airways"
                    >
                    @error('airline_preference')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget Range -->
                <div class="space-y-1">
                    <label for="budget_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Budget Range <span class="text-red-500">*</span>
                    </label>
                    <select id="budget_range" name="budget_range" required
                            class="w-full px-3 py-2 border rounded-md {{ $errors->has('budget_range') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select budget range...</option>
                        @foreach($budgetRanges as $key => $label)
                        <option value="{{ $key }}" {{ old('budget_range', $flightTicket->budget_range) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('budget_range')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2 border rounded-md {{ $errors->has('status') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $flightTicket->status) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Booking Reference -->
                <div class="space-y-1">
                    <label for="booking_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Booking Reference
                    </label>
                    <input
                        type="text"
                        id="booking_reference"
                        name="booking_reference"
                        value="{{ old('booking_reference', $flightTicket->booking_reference) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('booking_reference') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., ABC123XYZ"
                    >
                    @error('booking_reference')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Cost -->
                <div class="space-y-1">
                    <label for="total_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Total Cost
                    </label>
                    <input
                        type="number"
                        id="total_cost"
                        name="total_cost"
                        value="{{ old('total_cost', $flightTicket->total_cost) }}"
                        step="0.01"
                        min="0"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('total_cost') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="0.00"
                    >
                    @error('total_cost')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency -->
                <div class="space-y-1">
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Currency
                    </label>
                    <input
                        type="text"
                        id="currency"
                        name="currency"
                        value="{{ old('currency', $flightTicket->currency ?? 'USD') }}"
                        maxlength="3"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('currency') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="USD"
                    >
                    @error('currency')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Special Requests -->
            <div class="space-y-1">
                <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Special Requests
                </label>
                <textarea
                    id="special_requests"
                    name="special_requests"
                    rows="4"
                    class="w-full px-3 py-2 border rounded-md {{ $errors->has('special_requests') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Any special requests or requirements..."
                >{{ old('special_requests', $flightTicket->special_requests) }}</textarea>
                @error('special_requests')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('flight-tickets.show', $flightTicket->id) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update Flight Ticket
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Update return date min when departure date changes
    document.getElementById('departure_date')?.addEventListener('change', function() {
        const returnDateInput = document.getElementById('return_date');
        if (returnDateInput && this.value) {
            returnDateInput.min = this.value;
            if (returnDateInput.value && returnDateInput.value < this.value) {
                returnDateInput.value = '';
            }
        }
    });
</script>
@endsection





