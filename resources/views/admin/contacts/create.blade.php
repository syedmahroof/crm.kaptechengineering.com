@extends('layouts.admin')

@section('title', 'Create Contact')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Contact</h1>
        <a href="{{ route('admin.contacts.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.contacts.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company Name</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}"
                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                @error('company_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Branch</label>
                <select name="branch_id" id="branch_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a branch...</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
                @error('branch_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Type</label>
                <select name="contact_type" id="contact_type" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a type...</option>
                    @foreach($contactTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('contact_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('contact_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                <select name="country_id" id="country_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a country...</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', $india?->id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State/Province</label>
                <select name="state_id" id="state_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a state...</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                    @endforeach
                </select>
                @error('state_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">District/City</label>
                <select name="district_id" id="district_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a district...</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                    @endforeach
                </select>
                @error('district_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project</label>
                <select name="project_id" id="project_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a project...</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required
                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</label>
                <select name="priority" id="priority" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="low" {{ old('priority', 'medium') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>

            <div class="md:col-span-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                <textarea name="address" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message *</label>
            <textarea name="message" rows="4" required
                      class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('message') }}</textarea>
            @error('message')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Contact</button>
        </div>
    </form>
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for all select boxes (searchable)
        $('#branch_id').select2({
            placeholder: 'Select a branch...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        $('#contact_type').select2({
            placeholder: 'Select a type...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        $('#country_id').select2({
            placeholder: 'Select a country...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        $('#state_id').select2({
            placeholder: 'Select a state...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        $('#district_id').select2({
            placeholder: 'Select a district...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        $('#project_id').select2({
            placeholder: 'Select a project...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });

        $('#priority').select2({
            placeholder: 'Select a priority...',
            allowClear: false,
            width: '100%',
            theme: 'bootstrap-5',
            minimumResultsForSearch: Infinity // Hide search for small lists
        });
        
        // Load states when country changes
        $('#country_id').on('change', function() {
            const countryId = $(this).val();
            const stateSelect = $('#state_id');
            const districtSelect = $('#district_id');
            
            // Clear states and districts
            stateSelect.empty().append('<option value="">Select a state...</option>').trigger('change');
            districtSelect.empty().append('<option value="">Select a district...</option>').trigger('change');
            
            if (countryId) {
                $.ajax({
                    url: '/api/states',
                    method: 'GET',
                    data: { country_id: countryId, active: 'true' },
                    success: function(states) {
                        if (states && states.length > 0) {
                            states.forEach(function(state) {
                                stateSelect.append('<option value="' + state.id + '">' + state.name + '</option>');
                            });
                            stateSelect.trigger('change');
                        }
                    }
                });
            }
        });
        
        // Load districts when state changes
        $('#state_id').on('change', function() {
            const stateId = $(this).val();
            const districtSelect = $('#district_id');
            
            // Clear districts
            districtSelect.empty().append('<option value="">Select a district...</option>').trigger('change');
            
            if (stateId) {
                $.ajax({
                    url: '/api/districts',
                    method: 'GET',
                    data: { state_id: stateId, active: 'true' },
                    success: function(districts) {
                        if (districts && districts.length > 0) {
                            districts.forEach(function(district) {
                                districtSelect.append('<option value="' + district.id + '">' + district.name + '</option>');
                            });
                            districtSelect.trigger('change');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection

