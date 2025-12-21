@extends('layouts.admin')

@section('title', 'Create Project')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Project</h1>
        <a href="{{ route('projects.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Details Section -->
                <div class="md:col-span-4 border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Owner Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="owner_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                                   class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @error('owner_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="owner_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                            <input type="text" name="owner_phone" id="owner_phone" value="{{ old('owner_phone') }}"
                                   class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @error('owner_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="owner_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email') }}"
                                   class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            @error('owner_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>





                <div class="md:col-span-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                    <textarea name="address" id="address" rows="2"
                              class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="state_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                    <select name="state_id" id="state_id"
                            class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
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
                    <label for="district_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                    <select name="district_id" id="district_id"
                            class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Select a city...</option>
                    </select>
                    @error('district_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pincode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pincode</label>
                    <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('pincode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expected_maturity_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expected Maturity</label>
                    <input type="date" name="expected_maturity_date" id="expected_maturity_date" value="{{ old('expected_maturity_date') }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('expected_maturity_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="preferred_material" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preferred Material</label>
                    <textarea name="preferred_material" id="preferred_material" rows="2"
                              class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('preferred_material') }}</textarea>
                    @error('preferred_material')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="branch_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Branch</label>
                    <select name="branch_id" id="branch_id"
                            class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assignee</label>
                    <select name="user_id" id="user_id"
                            class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('user_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                        <option value="">Select an assignee...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="project_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Type</label>
                    <select name="project_type" id="project_type"
                            class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Select a type...</option>
                        @foreach($projectTypes as $type)
                            <option value="{{ $type->name }}" {{ old('project_type') == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" id="status"
                            class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="planning" {{ old('status', 'planning') == 'planning' ? 'selected' : '' }}>Planning</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Team Contacts Section -->
                <div class="md:col-span-4 border-t border-gray-200 dark:border-gray-700 pt-6 mt-2" x-data="{
                    contacts: {{ old('contacts') ? json_encode(old('contacts')) : '[]' }},
                    addContact() {
                        this.contacts.push({ name: '', role: '', phone: '', email: '' });
                    },
                    removeContact(index) {
                        this.contacts.splice(index, 1);
                    }
                }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Team Contacts</h3>
                        <button type="button" @click="addContact()" class="px-3 py-1 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                            + Add Contact
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(contact, index) in contacts" :key="index">
                            <div class="flex flex-col md:flex-row gap-4 items-end bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                                    <input type="text" :name="'contacts[' + index + '][name]'" x-model="contact.name" required placeholder="Name"
                                           class="block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                                    <select :name="'contacts[' + index + '][role]'" x-model="contact.role"
                                            class="block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        <option value="">Select Role...</option>
                                        @foreach(\App\Models\ProjectContact::getRoles() as $key => $label)
                                            @if($key !== 'owner')
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                                    <input type="text" :name="'contacts[' + index + '][phone]'" x-model="contact.phone" placeholder="Phone"
                                           class="block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                    <input type="email" :name="'contacts[' + index + '][email]'" x-model="contact.email" placeholder="Email"
                                           class="block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <button type="button" @click="removeContact(index)" class="p-2 text-red-500 hover:text-red-700 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div x-show="contacts.length === 0" class="text-gray-500 text-sm italic py-2">
                            No team contacts added yet.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Load districts when state changes
    $('#state_id').on('change', function() {
        const stateId = $(this).val();
        loadDistrictsForState(stateId);
    });
    
    function loadDistrictsForState(stateId, selectedDistrictId = null) {
        const districtSelect = $('#district_id');
        districtSelect.html('<option value="">Select a city...</option>');
        
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

    // Trigger change if state is already selected (e.g. old input)
    @if(old('state_id'))
        $('#state_id').trigger('change');
        // Note: With old input, we might need to verify if trigger handles the old district selection correctly.
        // The simple trigger above runs loadDistrictsForState without 2nd arg.
        // To handle old district correctly we'd need to pass it.
        // Let's refine:
        loadDistrictsForState('{{ old('state_id') }}', '{{ old('district_id') }}');
    @endif
</script>
@endpush

