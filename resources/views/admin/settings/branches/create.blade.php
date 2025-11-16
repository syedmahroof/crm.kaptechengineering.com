@extends('layouts.admin')

@section('title', 'Create Branch')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Branch</h1>
        <a href="{{ route('settings.branches.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('settings.branches.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Branch Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Branch Code *</label>
                    <input type="text" name="code" value="{{ old('code') }}" required maxlength="10" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" placeholder="e.g., BR001">
                    @error('code')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Contact Information -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Contact Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                    <textarea name="address" rows="2" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Timezone *</label>
                    <select name="timezone" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="UTC" {{ old('timezone', 'UTC') === 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="America/New_York" {{ old('timezone') === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                        <option value="America/Chicago" {{ old('timezone') === 'America/Chicago' ? 'selected' : '' }}>America/Chicago (CST)</option>
                        <option value="America/Denver" {{ old('timezone') === 'America/Denver' ? 'selected' : '' }}>America/Denver (MST)</option>
                        <option value="America/Los_Angeles" {{ old('timezone') === 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles (PST)</option>
                        <option value="Europe/London" {{ old('timezone') === 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                        <option value="Europe/Paris" {{ old('timezone') === 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (CET)</option>
                        <option value="Asia/Dubai" {{ old('timezone') === 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai (GST)</option>
                        <option value="Asia/Kolkata" {{ old('timezone') === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                        <option value="Asia/Singapore" {{ old('timezone') === 'Asia/Singapore' ? 'selected' : '' }}>Asia/Singapore (SGT)</option>
                        <option value="Asia/Tokyo" {{ old('timezone') === 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo (JST)</option>
                        <option value="Australia/Sydney" {{ old('timezone') === 'Australia/Sydney' ? 'selected' : '' }}>Australia/Sydney (AEDT)</option>
                    </select>
                    @error('timezone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Manager Information -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Manager Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Manager Name</label>
                    <input type="text" name="manager_name" value="{{ old('manager_name') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('manager_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Manager Phone</label>
                    <input type="text" name="manager_phone" value="{{ old('manager_phone') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('manager_phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Manager Email</label>
                    <input type="email" name="manager_email" value="{{ old('manager_email') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                    @error('manager_email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Working Hours -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Working Hours</h2>
            <div class="space-y-3">
                @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                @endphp
                @foreach($days as $index => $day)
                    <div class="flex items-center gap-4">
                        <div class="flex items-center w-32">
                            <input type="checkbox" name="working_hours[{{ $index }}][is_open]" value="1" {{ old("working_hours.{$index}.is_open", true) ? 'checked' : '' }} class="h-4 w-4 day-checkbox" data-day="{{ $index }}">
                            <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $day }}</label>
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-2">
                            <input type="time" name="working_hours[{{ $index }}][open_time]" value="{{ old("working_hours.{$index}.open_time", '09:00') }}" class="day-time-input px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" data-day="{{ $index }}" data-type="open">
                            <input type="time" name="working_hours[{{ $index }}][close_time]" value="{{ old("working_hours.{$index}.close_time", '17:00') }}" class="day-time-input px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" data-day="{{ $index }}" data-type="close">
                        </div>
                    </div>
                @endforeach
            </div>
            @error('working_hours.*')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('settings.branches.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Branch</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.day-checkbox');
        
        checkboxes.forEach(checkbox => {
            const day = checkbox.dataset.day;
            const timeInputs = document.querySelectorAll(`.day-time-input[data-day="${day}"]`);
            
            checkbox.addEventListener('change', function() {
                timeInputs.forEach(input => {
                    input.disabled = !this.checked;
                    if (!this.checked) {
                        input.value = '';
                    }
                });
            });
            
            // Set initial state
            timeInputs.forEach(input => {
                input.disabled = !checkbox.checked;
            });
        });
    });
</script>
@endpush
@endsection





