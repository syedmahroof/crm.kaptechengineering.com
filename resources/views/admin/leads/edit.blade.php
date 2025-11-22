@extends('layouts.admin')

@section('title', 'Edit Lead')

@section('content')
<div class="flex flex-col gap-6 rounded-xl">
    <div class="border border-gray-300 dark:border-gray-700 rounded-xl p-6 bg-white dark:bg-gray-800">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
            <i class="fas fa-edit mr-2"></i>Edit Lead: {{ $lead->name }}
        </h1>
        
        <form action="{{ route('leads.update', $lead->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Full Name -->
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $lead->name) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="John Doe"
                        required
                    >
                    @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $lead->email) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="john@example.com"
                    >
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="space-y-1">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                    <div class="phone-input-group flex items-stretch border {{ $errors->has('phone') || $errors->has('phone_code') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 bg-white dark:bg-gray-700">
                        <div class="flex-shrink-0 border-r border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                            <select name="phone_code" id="phone_code" class="h-full px-3 py-2 bg-transparent border-0 text-sm text-gray-700 dark:text-gray-300 focus:ring-0 focus:outline-none">
                                @php
                                    $defaultPhoneCode = old('phone_code', $lead->phone_code ?? '+91');
                                    if (!$defaultPhoneCode && $lead->country_id) {
                                        $country = $countries->firstWhere('id', $lead->country_id);
                                        $defaultPhoneCode = $country->phone_code ?? '+91';
                                    }
                                @endphp
                                @foreach($countries as $country)
                                    @if($country->phone_code ?? false)
                                        <option value="{{ $country->phone_code }}" {{ $defaultPhoneCode == $country->phone_code ? 'selected' : '' }} data-country-id="{{ $country->id }}" data-country-name="{{ $country->name }}">
                                            {{ $country->phone_code }} - {{ $country->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1 min-w-0">
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $lead->phone) }}"
                                class="w-full h-full px-3 py-2 border-0 bg-transparent dark:text-white focus:ring-0 focus:outline-none placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Enter phone number"
                            >
                        </div>
                    </div>
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @error('phone_code')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lead Source -->
                <div class="space-y-1">
                    <label for="lead_source_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Source</label>
                    <select id="lead_source_id" name="lead_source_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('lead_source_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a source...</option>
                        @foreach($sources as $source)
                            <option value="{{ $source->id }}" {{ old('lead_source_id', $lead->lead_source_id) == $source->id ? 'selected' : '' }}>
                                {{ $source->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lead_source_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div class="space-y-1">
                    <label for="lead_priority_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                    <select id="lead_priority_id" name="lead_priority_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('lead_priority_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a priority...</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ old('lead_priority_id', $lead->lead_priority_id) == $priority->id ? 'selected' : '' }}>
                                {{ $priority->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lead_priority_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assigned User -->
                @if($users && count($users) > 0)
                <div class="space-y-1">
                    <label for="assigned_user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assigned User</label>
                    <select id="assigned_user_id" name="assigned_user_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('assigned_user_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a user...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_user_id', $lead->assigned_user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_user_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Lead Status -->
                <div class="space-y-1">
                    <label for="lead_status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lead Status</label>
                    <select id="lead_status_id" name="lead_status_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('lead_status_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a status...</option>
                        @foreach($leadStatuses as $status)
                            <option value="{{ $status->id }}" {{ old('lead_status_id', $lead->lead_status_id) == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lead_status_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Business Type -->
                <div class="space-y-1">
                    <label for="business_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Business Type</label>
                    <select id="business_type_id" name="business_type_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('business_type_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a business type...</option>
                        @foreach($businessTypes as $businessType)
                            <option value="{{ $businessType->id }}" {{ old('business_type_id', $lead->business_type_id) == $businessType->id ? 'selected' : '' }}>
                                {{ $businessType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('business_type_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="space-y-1">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address', $lead->address) }}"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('address') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Address"
                    >
                    @error('address')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div class="space-y-1">
                    <label for="country_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                    <select id="country_id" name="country_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('country_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a country...</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id', $lead->country_id) == $country->id ? 'selected' : '' }} data-phone-code="{{ $country->phone_code ?? '' }}">
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="country" id="country" value="{{ old('country', $lead->country) }}">
                    @error('country_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State/Province -->
                <div class="space-y-1">
                    <label for="state_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State/Province</label>
                    <select id="state_id" name="state_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('state_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a state/province...</option>
                        @if($lead->country_id)
                            @foreach($states->where('country_id', $lead->country_id) as $state)
                                <option value="{{ $state->id }}" {{ old('state_id', $lead->state_id) == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <input type="hidden" name="state" id="state" value="{{ old('state', $lead->state) }}">
                    @error('state_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Branch -->
                <div class="space-y-1">
                    <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Branch</label>
                    <select id="branch_id" name="branch_id" class="w-full px-3 py-2 border rounded-md {{ $errors->has('branch_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a branch...</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id', $lead->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Linked Entities Section -->
                <div class="space-y-1 md:col-span-2 lg:col-span-3">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-link text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Link to Entities</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Projects -->
                        <div>
                            <label for="project_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-project-diagram mr-2 text-blue-500"></i>Projects
                            </label>
                            <select name="project_ids[]" id="project_ids" multiple
                                    class="w-full px-3 py-2 border rounded-md {{ $errors->has('project_ids') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ (old('project_ids') && in_array($project->id, old('project_ids'))) || (in_array($project->id, $lead->projects->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Search and select one or more projects.</p>
                            @error('project_ids')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customers -->
                        <div>
                            <label for="customer_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-users mr-2 text-green-500"></i>Customers
                            </label>
                            <select name="customer_ids[]" id="customer_ids" multiple
                                    class="w-full px-3 py-2 border rounded-md {{ $errors->has('customer_ids') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ (old('customer_ids') && in_array($customer->id, old('customer_ids'))) || (in_array($customer->id, $lead->customers->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Search and select one or more customers.</p>
                            @error('customer_ids')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contacts -->
                        <div>
                            <label for="contact_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-address-book mr-2 text-purple-500"></i>Contacts
                            </label>
                            <select name="contact_ids[]" id="contact_ids" multiple
                                    class="w-full px-3 py-2 border rounded-md {{ $errors->has('contact_ids') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}" {{ (old('contact_ids') && in_array($contact->id, old('contact_ids'))) || (in_array($contact->id, $lead->contacts->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $contact->name }} @if($contact->email)({{ $contact->email }})@endif</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Search and select one or more contacts.</p>
                            @error('contact_ids')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-1 md:col-span-2 lg:col-span-3">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="w-full px-3 py-2 border rounded-md {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Additional information about the lead"
                    >{{ old('description', $lead->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('leads.show', $lead->id) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Lead
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 0;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    .dark .select2-container--default .select2-selection--single {
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
    /* Phone code Select2 styling - grouped input */
    #phone_code + .select2-container {
        width: auto !important;
        min-width: 140px;
        max-width: 180px;
    }
    #phone_code + .select2-container .select2-selection--single {
        height: 100%;
        min-height: 42px;
        border: 0 !important;
        border-radius: 0;
        background-color: transparent !important;
        box-shadow: none !important;
    }
    #phone_code + .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 0.75rem;
        padding-right: 1.75rem;
        color: #111827;
        font-size: 0.875rem;
    }
    #phone_code + .select2-container .select2-selection--single .select2-selection__arrow {
        height: 42px;
        right: 8px;
    }
    #phone_code + .select2-container .select2-selection--single:focus,
    #phone_code + .select2-container .select2-selection--single:active {
        outline: none !important;
        border: 0 !important;
        box-shadow: none !important;
    }
    .dark #phone_code + .select2-container .select2-selection--single {
        background-color: transparent !important;
        border: 0 !important;
    }
    .dark #phone_code + .select2-container .select2-selection--single .select2-selection__rendered {
        color: #d1d5db;
    }
    /* Ensure the phone input group maintains proper height */
    .phone-input-group {
        min-height: 42px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for country
        $('#country_id').select2({
            placeholder: 'Select a country...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        // Initialize Select2 for state
        $('#state_id').select2({
            placeholder: 'Select a state/province...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        // Initialize Select2 for phone code (searchable)
        $('#phone_code').select2({
            placeholder: 'Select country code...',
            allowClear: false,
            width: '100%',
            minimumResultsForSearch: 0,
            dropdownAutoWidth: false,
            templateResult: function(data) {
                if (!data.id) {
                    return data.text;
                }
                const $result = $('<span>' + data.text + '</span>');
                return $result;
            },
            templateSelection: function(data) {
                // Show only phone code in the selected display
                if (data.id) {
                    return data.id;
                }
                return data.text;
            }
        });

        // Initialize Select2 for assigned user (searchable)
        $('#assigned_user_id').select2({
            placeholder: 'Select a user...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        // Initialize Select2 for projects (multi-select with searchable autocomplete)
        $('#project_ids').select2({
            placeholder: 'Search and select projects...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            closeOnSelect: false,
            minimumInputLength: 0,
            templateResult: function(data) {
                if (!data.id) { return data.text; }
                return $('<span><i class="fas fa-project-diagram mr-2 text-blue-500"></i>' + data.text + '</span>');
            },
            templateSelection: function(data) {
                return $('<span><i class="fas fa-project-diagram mr-2 text-blue-500"></i>' + data.text + '</span>');
            }
        });

        // Initialize Select2 for customers (multi-select with searchable autocomplete)
        $('#customer_ids').select2({
            placeholder: 'Search and select customers...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            closeOnSelect: false,
            minimumInputLength: 0,
            templateResult: function(data) {
                if (!data.id) { return data.text; }
                return $('<span><i class="fas fa-users mr-2 text-green-500"></i>' + data.text + '</span>');
            },
            templateSelection: function(data) {
                return $('<span><i class="fas fa-users mr-2 text-green-500"></i>' + data.text + '</span>');
            }
        });

        // Initialize Select2 for contacts (multi-select with searchable autocomplete)
        $('#contact_ids').select2({
            placeholder: 'Search and select contacts...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            closeOnSelect: false,
            minimumInputLength: 0,
            templateResult: function(data) {
                if (!data.id) { return data.text; }
                return $('<span><i class="fas fa-address-book mr-2 text-purple-500"></i>' + data.text + '</span>');
            },
            templateSelection: function(data) {
                return $('<span><i class="fas fa-address-book mr-2 text-purple-500"></i>' + data.text + '</span>');
            }
        });

        // Update country text field when country_id changes
        $('#country_id').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const selectedText = selectedOption.text();
            $('#country').val(selectedText);
            
            // Update phone code based on country selection
            const phoneCode = selectedOption.data('phone-code');
            if (phoneCode) {
                $('#phone_code').val(phoneCode).trigger('change');
            }
            
            // Load states for selected country
            loadStatesForCountry($(this).val());
        });

        // Update phone code when phone_code changes - update country if needed
        $('#phone_code').on('change', function() {
            const phoneCode = $(this).val();
            const selectedOption = $(this).find('option:selected');
            const countryId = selectedOption.data('country-id');
            
            if (countryId) {
                $('#country_id').val(countryId).trigger('change');
            } else {
                // Fallback: try to find by phone code
                const countryOption = $('#country_id option[data-phone-code="' + phoneCode + '"]');
                if (countryOption.length) {
                    $('#country_id').val(countryOption.val()).trigger('change');
                }
            }
        });

        // Update state text field when state_id changes
        $('#state_id').on('change', function() {
            const selectedText = $(this).find('option:selected').text().split(',')[0].trim();
            $('#state').val(selectedText);
        });
        
        // Function to load states based on country
        function loadStatesForCountry(countryId) {
            const stateSelect = $('#state_id');
            const currentStateId = {{ old('state_id', $lead->state_id) ?: 'null' }};
            
            if (!countryId) {
                stateSelect.empty().append('<option value="">Select a state/province...</option>').trigger('change');
                return;
            }
            
            // Show loading state
            stateSelect.prop('disabled', true).html('<option value="">Loading states...</option>').trigger('change');
            
            $.ajax({
                url: '/api/states',
                method: 'GET',
                data: { country_id: countryId },
                success: function(states) {
                    stateSelect.empty().append('<option value="">Select a state/province...</option>');
                    states.forEach(function(state) {
                        const selected = currentStateId == state.id ? 'selected' : '';
                        stateSelect.append(
                            '<option value="' + state.id + '" ' + selected + '>' + 
                            state.name + '</option>'
                        );
                    });
                    stateSelect.prop('disabled', false).trigger('change');
                },
                error: function() {
                    stateSelect.empty().append('<option value="">Error loading states. Please try again.</option>');
                    stateSelect.prop('disabled', false).trigger('change');
                }
            });
        }
    });
</script>
@endpush
@endsection
