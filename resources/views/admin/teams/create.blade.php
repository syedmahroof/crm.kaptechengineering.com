@extends('layouts.admin')

@section('title', 'Create Team')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        padding: 4px;
    }
    .dark .select2-container--default .select2-selection--multiple {
        background-color: #374151;
        border-color: #4b5563;
        color: #fff;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3b82f6;
        border: 1px solid #2563eb;
        color: #fff;
        padding: 4px 8px 4px 20px;
        margin: 2px;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        position: relative;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        display: inline-block;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff !important;
        cursor: pointer !important;
        font-weight: bold;
        margin-right: 0 !important;
        margin-left: 0 !important;
        padding: 0 4px 0 4px !important;
        border: none !important;
        background: transparent !important;
        float: left !important;
        font-size: 18px !important;
        line-height: 1.2 !important;
        opacity: 0.9;
        transition: all 0.2s;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        opacity: 1 !important;
        color: #fff !important;
        background: rgba(255, 255, 255, 0.2) !important;
        border-radius: 50% !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .select2-dropdown {
        border-color: #d1d5db;
        border-radius: 0.375rem;
    }
    .dark .select2-dropdown {
        background-color: #374151;
        border-color: #4b5563;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        padding: 6px;
    }
    .dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #374151;
        border-color: #4b5563;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="flex flex-col gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
            <i class="fas fa-users mr-2"></i>Create New Team
        </h1>
        
        <form action="{{ route('teams.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Team Name -->
                <div class="space-y-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Team Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-3 py-2 border rounded-md {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                           placeholder="Sales Team" required>
                    @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-1">
                    <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status
                    </label>
                    <select id="is_active" name="is_active"
                            class="w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="1" {{ old('is_active', true) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !old('is_active', true) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="space-y-1 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                              placeholder="Team description...">{{ old('description') }}</textarea>
                </div>

                <!-- Team Leads (Multiple) -->
                <div class="space-y-1 md:col-span-2">
                    <label for="team_lead_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Team Leads <span class="text-gray-500 text-xs font-normal">(Can select multiple)</span>
                    </label>
                    <select id="team_lead_ids" name="team_lead_ids[]" multiple
                            class="w-full px-3 py-2 border rounded-md {{ $errors->has('team_lead_ids') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($teamLeads as $lead)
                            <option value="{{ $lead->id }}" {{ in_array($lead->id, old('team_lead_ids', [])) ? 'selected' : '' }}>
                                {{ $lead->name }} - {{ $lead->email }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                        <i class="fas fa-info-circle mr-1"></i>Select users with team-lead role to be team leads
                    </p>
                    @error('team_lead_ids')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @error('team_lead_ids.*')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Team Members -->
                <div class="space-y-1 md:col-span-2">
                    <label for="user_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Team Members <span class="text-gray-500 text-xs font-normal">(Can select multiple)</span>
                    </label>
                    <select id="user_ids" name="user_ids[]" multiple
                            class="w-full px-3 py-2 border rounded-md {{ $errors->has('user_ids') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }}>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                        <i class="fas fa-info-circle mr-1"></i>Select users to be part of this team
                    </p>
                    @error('user_ids')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @error('user_ids.*')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('teams.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Create Team
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#team_lead_ids').select2({
            placeholder: 'Select team leads...',
            allowClear: true,
            width: '100%',
            closeOnSelect: false,
            tags: false
        });

        $('#user_ids').select2({
            placeholder: 'Select team members...',
            allowClear: true,
            width: '100%',
            closeOnSelect: false,
            tags: false
        });
    });
</script>
@endpush

