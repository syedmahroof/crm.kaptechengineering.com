@extends('layouts.admin')

@section('title', 'Edit Customer')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-user-edit mr-3 text-indigo-600 dark:text-indigo-400"></i>Edit Customer
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Update customer information</p>
        </div>
        <a href="{{ route('customers.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Personal Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Personal Information</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Basic customer details</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-gray-400"></i>First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $customer->first_name) }}" required
                           class="w-full px-4 py-2.5 border rounded-lg {{ $errors->has('first_name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' }} dark:bg-gray-700 dark:text-white transition-colors"
                           placeholder="Enter first name">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-gray-400"></i>Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $customer->last_name) }}" required
                           class="w-full px-4 py-2.5 border rounded-lg {{ $errors->has('last_name') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' }} dark:bg-gray-700 dark:text-white transition-colors"
                           placeholder="Enter last name">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required
                           class="w-full px-4 py-2.5 border rounded-lg {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' }} dark:bg-gray-700 dark:text-white transition-colors"
                           placeholder="customer@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-phone mr-2 text-gray-400"></i>Phone Number
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           placeholder="+1 234 567 8900">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Company Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Company Information</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Business and professional details</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-building mr-2 text-gray-400"></i>Company Name
                    </label>
                    <input type="text" name="company" id="company" value="{{ old('company', $customer->company) }}"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           placeholder="Company name">
                    @error('company')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="job_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-briefcase mr-2 text-gray-400"></i>Job Title
                    </label>
                    <input type="text" name="job_title" id="job_title" value="{{ old('job_title', $customer->job_title) }}"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           placeholder="e.g., CEO, Manager, Director">
                    @error('job_title')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Address Information Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Address Information</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Location and contact details</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>Street Address
                    </label>
                    <textarea name="address" id="address" rows="2"
                              class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                              placeholder="Enter street address">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-globe mr-2 text-gray-400"></i>Country
                        </label>
                        <select name="country" id="country" class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="{{ old('country', $customer->country) }}">{{ old('country', $customer->country) ?: 'Select country...' }}</option>
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-map mr-2 text-gray-400"></i>State/Province
                        </label>
                        <select name="state" id="state" class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="{{ old('state', $customer->state) }}">{{ old('state', $customer->state) ?: 'Select state...' }}</option>
                        </select>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-city mr-2 text-gray-400"></i>City/District
                        </label>
                        <select name="city" id="city" class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="{{ old('city', $customer->city) }}">{{ old('city', $customer->city) ?: 'Select city...' }}</option>
                        </select>
                        @error('city')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-mail-bulk mr-2 text-gray-400"></i>Postal Code
                    </label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $customer->postal_code) }}"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           placeholder="ZIP/Postal code">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Notes Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-sticky-note text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Additional Notes</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Any additional information about the customer</p>
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-comment-alt mr-2 text-gray-400"></i>Notes
                </label>
                <textarea name="notes" id="notes" rows="4"
                          class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                          placeholder="Enter any additional notes or comments about this customer...">{{ old('notes', $customer->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('customers.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 transition-colors">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <i class="fas fa-save mr-2"></i>Update Customer
            </button>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 12px;
    }
    .dark .select2-container--bootstrap-5 .select2-selection {
        background-color: #374151;
        border-color: #4b5563;
        color: white;
    }
    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    .dark .select2-container--bootstrap-5 .select2-dropdown {
        background-color: #374151;
        border-color: #4b5563;
    }
    .select2-container--bootstrap-5 .select2-results__option {
        padding: 8px 12px;
    }
    .dark .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: #4b5563;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    const currentCountry = '{{ old("country", $customer->country) }}';
    const currentState = '{{ old("state", $customer->state) }}';
    const currentCity = '{{ old("city", $customer->city) }}';

    // Initialize Select2 for Country
    $('#country').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Search and select a country...',
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
            url: '/api/countries',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    active: 'true'
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.name,
                            text: item.name,
                            countryId: item.id
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Set initial value for country if exists
    if (currentCountry) {
        const option = new Option(currentCountry, currentCountry, true, true);
        $('#country').append(option).trigger('change');
    }

    // Initialize Select2 for State
    $('#state').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Search and select a state...',
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
            url: '/api/states',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                const countryName = $('#country').val();
                return {
                    search: params.term,
                    active: 'true'
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.name,
                            text: item.name,
                            stateId: item.id
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Set initial value for state if exists
    if (currentState) {
        const option = new Option(currentState, currentState, true, true);
        $('#state').append(option).trigger('change');
    }

    // Initialize Select2 for City/District
    $('#city').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Search and select a city/district...',
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
            url: '/api/districts',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    active: 'true'
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.name,
                            text: item.name,
                            districtId: item.id
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Set initial value for city if exists
    if (currentCity) {
        const option = new Option(currentCity, currentCity, true, true);
        $('#city').append(option).trigger('change');
    }

    // Filter states by country when country changes
    $('#country').on('change', function() {
        const countryName = $(this).val();
        $('#state').val(null).trigger('change');
        $('#city').val(null).trigger('change');
    });

    // Filter districts by state when state changes
    $('#state').on('change', function() {
        $('#city').val(null).trigger('change');
    });
});
</script>
@endpush
@endsection
