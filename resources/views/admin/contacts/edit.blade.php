@extends('layouts.admin')

@section('title', 'Edit Contact')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Contact</h1>
        <a href="{{ route('admin.contacts.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</label>
                <select name="priority" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="low" {{ old('priority', $contact->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $contact->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $contact->priority) == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ old('priority', $contact->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Type</label>
                <select name="contact_type" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a type...</option>
                    @foreach($contactTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('contact_type', $contact->contact_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                <select name="country_id" id="country_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a country...</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', $contact->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State/Province</label>
                <select name="state_id" id="state_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a state...</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ old('state_id', $contact->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">District/City</label>
                <select name="district_id" id="district_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a district...</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ old('district_id', $contact->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project</label>
                <select name="project_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a project...</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $contact->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin Notes</label>
            <textarea name="admin_notes" rows="4" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Load states when country changes
    $('#country_id').on('change', function() {
        const countryId = $(this).val();
        const stateSelect = $('#state_id');
        const districtSelect = $('#district_id');
        const currentStateId = '{{ old("state_id", $contact->state_id) }}';
        const currentDistrictId = '{{ old("district_id", $contact->district_id) }}';
        
        // Clear states and districts
        stateSelect.html('<option value="">Select a state...</option>');
        districtSelect.html('<option value="">Select a district...</option>');
        
        if (countryId) {
            $.ajax({
                url: '/api/states',
                method: 'GET',
                data: { country_id: countryId, active: 'true' },
                success: function(states) {
                    if (states && states.length > 0) {
                        states.forEach(function(state) {
                            const selected = state.id == currentStateId ? 'selected' : '';
                            stateSelect.append('<option value="' + state.id + '" ' + selected + '>' + state.name + '</option>');
                        });
                        
                        // If we have a current state, load districts
                        if (currentStateId) {
                            loadDistrictsForState(currentStateId, currentDistrictId);
                        }
                    }
                }
            });
        }
    });
    
    // Load districts when state changes
    $('#state_id').on('change', function() {
        const stateId = $(this).val();
        loadDistrictsForState(stateId);
    });
    
    function loadDistrictsForState(stateId, selectedDistrictId = null) {
        const districtSelect = $('#district_id');
        districtSelect.html('<option value="">Select a district...</option>');
        
        if (stateId) {
            $.ajax({
                url: '/api/districts',
                method: 'GET',
                data: { state_id: stateId, active: 'true' },
                success: function(districts) {
                    if (districts && districts.length > 0) {
                        districts.forEach(function(district) {
                            const selected = selectedDistrictId && district.id == selectedDistrictId ? 'selected' : '';
                            districtSelect.append('<option value="' + district.id + '" ' + selected + '>' + district.name + '</option>');
                        });
                    }
                }
            });
        }
    }
    
    // Trigger change on page load if country is selected
    @if($contact->country_id)
        $('#country_id').trigger('change');
    @endif
</script>
@endpush
@endsection

