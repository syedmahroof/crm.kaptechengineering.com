@extends('layouts.admin')

@section('title', 'Edit Enquiry')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Enquiry</h1>
        <a href="{{ route('enquiries.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('enquiries.update', $enquiry->id) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title', $enquiry->title) }}" required
                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('description', $enquiry->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project</label>
                <select name="project_id" id="project_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a project...</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $enquiry->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="new" {{ old('status', $enquiry->status) == 'new' ? 'selected' : '' }}>New</option>
                    <option value="in_progress" {{ old('status', $enquiry->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="quoted" {{ old('status', $enquiry->status) == 'quoted' ? 'selected' : '' }}>Quoted</option>
                    <option value="accepted" {{ old('status', $enquiry->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ old('status', $enquiry->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="completed" {{ old('status', $enquiry->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                <select name="country_id" id="country_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select a country...</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', $enquiry->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
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
                        <option value="{{ $state->id }}" {{ old('state_id', $enquiry->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
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
                        <option value="{{ $district->id }}" {{ old('district_id', $enquiry->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                    @endforeach
                </select>
                @error('district_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Contacts Section -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Contacts *</h3>
                <button type="button" onclick="addContactRow()" class="px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-1"></i>Add Contact
                </button>
            </div>
            <div id="contacts-container" class="space-y-4">
                <!-- Contact rows will be populated from existing enquiry contacts -->
            </div>
            @error('contact_ids')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('enquiries.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Enquiry</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let contactRowIndex = 0;
    const contactTypes = @json(\App\Models\Contact::getContactTypes());
    const existingContacts = @json($enquiry->contacts->map(function($contact) {
        return [
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'contact_type' => $contact->contact_type,
            'pivot_type' => $contact->pivot->contact_type,
            'pivot_notes' => $contact->pivot->notes,
        ];
    }));
    const allContacts = @json($contacts->map(function($contact) {
        return [
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'contact_type' => $contact->contact_type,
        ];
    }));
    
    // Initialize Select2 for country dropdown (searchable)
    $(document).ready(function() {
        $('#country_id').select2({
            placeholder: 'Select a country...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });
        
        // Add existing contacts as rows
        existingContacts.forEach(function(contact) {
            addContactRow(contact);
        });
        
        // If no existing contacts, add one empty row
        if (existingContacts.length === 0) {
            addContactRow();
        }
    });
    
    function addContactRow(existingContact = null) {
        const container = document.getElementById('contacts-container');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-1 md:grid-cols-4 gap-4 items-end border border-gray-200 dark:border-gray-700 rounded-lg p-4 contact-row';
        row.setAttribute('data-index', contactRowIndex);
        
        const selectedContactId = existingContact ? existingContact.id : '';
        const selectedContactType = existingContact ? (existingContact.pivot_type || existingContact.contact_type) : '';
        const selectedNotes = existingContact ? existingContact.pivot_notes : '';
        
        row.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact *</label>
                <select name="contact_ids[]" class="contact-select w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                    <option value="">Select a contact...</option>
                    ${allContacts.map(function(contact) {
                        const selected = contact.id == selectedContactId ? 'selected' : '';
                        const displayText = contact.name + 
                            (contact.contact_type ? ' - ' + (contactTypes[contact.contact_type] || '') : '') +
                            (contact.phone ? ' (' + contact.phone + ')' : '');
                        return `<option value="${contact.id}" data-type="${contact.contact_type}" ${selected}>${displayText}</option>`;
                    }).join('')}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Type</label>
                <select name="contact_types[]" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    <option value="">Select type...</option>
                    ${Object.entries(contactTypes).map(([key, label]) => 
                        `<option value="${key}" ${key == selectedContactType ? 'selected' : ''}>${label}</option>`
                    ).join('')}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                <input type="text" name="contact_notes[]" value="${selectedNotes || ''}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" placeholder="Optional notes">
            </div>
            <div>
                <button type="button" onclick="removeContactRow(this)" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        `;
        
        container.appendChild(row);
        
        // Initialize Select2 for the new contact select
        $(row).find('.contact-select').select2({
            placeholder: 'Select a contact...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5'
        });
        
        // Auto-fill contact type when contact is selected
        $(row).find('.contact-select').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const contactType = selectedOption.data('type');
            if (contactType) {
                $(row).find('select[name="contact_types[]"]').val(contactType).trigger('change');
            }
        });
        
        contactRowIndex++;
    }
    
    function removeContactRow(button) {
        const row = button.closest('.contact-row');
        row.remove();
    }
    
    // Load states when country changes
    $('#country_id').on('change', function() {
        const countryId = $(this).val();
        const stateSelect = $('#state_id');
        const districtSelect = $('#district_id');
        const currentStateId = '{{ old("state_id", $enquiry->state_id) }}';
        const currentDistrictId = '{{ old("district_id", $enquiry->district_id) }}';
        
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
    @if($enquiry->country_id)
        $('#country_id').trigger('change');
    @endif
</script>
@endpush
@endsection

