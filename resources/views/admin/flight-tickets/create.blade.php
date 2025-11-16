@extends('layouts.admin')

@section('title', 'Create Flight Ticket')

@section('content')
<div class="flex flex-col gap-6 rounded-xl">
    <div class="border border-gray-300 dark:border-gray-700 rounded-xl p-6 bg-white dark:bg-gray-800">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                <i class="fas fa-plane mr-2"></i>Create Flight Ticket
            </h1>
            @if($lead)
            <a href="{{ route('leads.show', $lead->id) }}" 
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Back to Lead
            </a>
            @endif
        </div>

        @if($lead)
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <p class="text-sm text-blue-800 dark:text-blue-300">
                <strong>Lead:</strong> {{ $lead->name }} ({{ $lead->email }})
            </p>
        </div>
        @endif
        
        <form action="{{ route('flight-tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            @if($lead)
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            @else
            <div class="space-y-1">
                <label for="lead_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Lead <span class="text-red-500">*</span>
                </label>
                <select id="lead_id" name="lead_id" required
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('lead_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select a lead...</option>
                </select>
                @error('lead_id')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endif

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
                        value="{{ old('departure_airport') }}"
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
                        value="{{ old('arrival_airport') }}"
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
                        value="{{ old('departure_date') }}"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
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
                        value="{{ old('return_date') }}"
                        min="{{ old('departure_date', date('Y-m-d')) }}"
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
                        value="{{ old('passenger_count', 1) }}"
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
                        <option value="{{ $key }}" {{ old('class_type') == $key ? 'selected' : '' }}>
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
                        value="{{ old('airline_preference') }}"
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
                        <option value="{{ $key }}" {{ old('budget_range', 'mid_range') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('budget_range')
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
                >{{ old('special_requests') }}</textarea>
                @error('special_requests')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Attachments Section -->
            <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-paperclip mr-2"></i>Attachments (Optional)
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                        You can upload multiple files. Max file size: 10MB per file. Supported: PDF, DOC, DOCX, Images, ZIP, RAR
                    </p>
                    
                    <div id="attachmentsContainer" class="space-y-3">
                        <!-- Attachment items will be added here dynamically -->
                    </div>
                    
                    <button type="button" onclick="addAttachmentField()" 
                            class="mt-3 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800">
                        <i class="fas fa-plus mr-2"></i>Add File
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                @if($lead)
                <a href="{{ route('leads.show', $lead->id) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    Cancel
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Create Flight Ticket
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let attachmentIndex = 0;

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

    function addAttachmentField() {
        const container = document.getElementById('attachmentsContainer');
        const index = attachmentIndex++;
        
        const attachmentDiv = document.createElement('div');
        attachmentDiv.className = 'flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600';
        attachmentDiv.id = `attachment-${index}`;
        
        attachmentDiv.innerHTML = `
            <div class="flex-1 space-y-2">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">File</label>
                    <input type="file" 
                           name="attachments[]" 
                           class="w-full px-3 py-2 text-sm border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.zip,.rar">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Description (Optional)</label>
                    <input type="text" 
                           name="attachment_descriptions[]" 
                           placeholder="e.g., Passport copy, Ticket confirmation"
                           class="w-full px-3 py-2 text-sm border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <button type="button" 
                    onclick="removeAttachmentField(${index})" 
                    class="mt-6 px-2 py-1 text-red-600 hover:text-red-800 dark:text-red-400">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        container.appendChild(attachmentDiv);
    }

    function removeAttachmentField(index) {
        const attachmentDiv = document.getElementById(`attachment-${index}`);
        if (attachmentDiv) {
            attachmentDiv.remove();
        }
    }
</script>
@endsection





