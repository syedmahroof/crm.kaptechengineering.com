@extends('layouts.admin')

@section('title', 'Add New Builder')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 42px;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Add New Builder</h1>
        <a href="{{ route('admin.builders.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('admin.builders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <!-- Name -->
                <div class="col-span-1 md:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Builder Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Branch -->
                <div class="col-span-1 md:col-span-1">
                    <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Branch <span class="text-red-500">*</span>
                    </label>
                    <select name="branch_id" id="branch_id" required
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Person -->
                <div class="col-span-1 md:col-span-1">
                    <label for="contact_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Contact Person
                    </label>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}"
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('contact_person')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="col-span-1 md:col-span-1">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Phone
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-span-1 md:col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div class="col-span-1 md:col-span-1">
                    <label for="country_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Country
                    </label>
                    <select name="country_id" id="country_id" class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State -->
                <div class="col-span-1 md:col-span-1">
                    <label for="state_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        State
                    </label>
                    <select name="state_id" id="state_id" class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" {{ !old('country_id') ? 'disabled' : '' }}>
                        <option value="">Select State</option>
                        @if(old('state_id') && $states = \App\Models\State::where('country_id', old('country_id'))->get())
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('state_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- District -->
                <div class="col-span-1 md:col-span-1">
                    <label for="district_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        City
                    </label>
                    <select name="district_id" id="district_id" class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500" {{ !old('state_id') ? 'disabled' : '' }}>
                        <option value="">Select City</option>
                        @if(old('district_id') && $districts = \App\Models\District::where('state_id', old('state_id'))->get())
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('district_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="col-span-1 md:col-span-1">
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Location
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pincode -->
                <div class="col-span-1 md:col-span-1">
                    <label for="pincode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Pincode
                    </label>
                    <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}"
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    @error('pincode')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address (Full Width) -->
                <div class="col-span-1 md:col-span-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Full Address
                    </label>
                    <textarea name="address" id="address" rows="2"
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description (Full Width) -->
                <div class="col-span-1 md:col-span-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-span-1 md:col-span-4 flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        Active
                    </label>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.builders.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Builder
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#country_id, #state_id, #district_id').select2({
            theme: 'classic',
            width: '100%'
        });

        // Load states when country changes
        $('#country_id').on('change', function() {
            var countryId = $(this).val();
            var stateSelect = $('#state_id');
            var districtSelect = $('#district_id');

            if (!countryId) {
                stateSelect.empty().append('<option value="">Select State</option>').prop('disabled', true);
                districtSelect.empty().append('<option value="">Select City</option>').prop('disabled', true);
                return;
            }

            // Show loading
            stateSelect.empty().append('<option value="">Loading...</option>').prop('disabled', true);
            districtSelect.empty().append('<option value="">Select State First</option>').prop('disabled', true);

            // Fetch states
            $.get('/admin/countries/' + countryId + '/states', function(data) {
                var options = '<option value="">Select State</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                stateSelect.html(options).prop('disabled', false);
            });
        });

        // Load districts when state changes
        $('#state_id').on('change', function() {
            var stateId = $(this).val();
            var districtSelect = $('#district_id');

            if (!stateId) {
                districtSelect.empty().append('<option value="">Select City</option>').prop('disabled', true);
                return;
            }

            // Show loading
            districtSelect.empty().append('<option value="">Loading...</option>').prop('disabled', true);

            // Fetch districts
            $.get('/admin/states/' + stateId + '/districts', function(data) {
                var options = '<option value="">Select City</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                districtSelect.html(options).prop('disabled', false);
            });
        });

        // Handle form submission
        $('form').on('submit', function() {
            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Saving...');
        });
    });
</script>
@endpush
