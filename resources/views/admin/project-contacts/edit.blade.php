@extends('layouts.admin')

@section('title', 'Edit Project Contact')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Project Contact</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update details for {{ $projectContact->name }} ({{ $project->name }})</p>
        </div>
        <a href="{{ route('projects.show', $project->id) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back to Project
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('project-contacts.update', $projectContact->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $projectContact->name) }}" required
                           class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ role: '{{ old('role', $projectContact->role) }}' }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <select name="role" x-model="role"
                            class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                        <option value="">Select role...</option>
                        @foreach($roles as $roleValue => $roleLabel)
                            <option value="{{ $roleValue }}" {{ old('role', $projectContact->role) === $roleValue ? 'selected' : '' }}>{{ $roleLabel }}</option>
                        @endforeach
                        <option value="other" {{ !array_key_exists($projectContact->role, $roles) ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <div x-show="role === 'other'" x-cloak class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom Role</label>
                        <input type="text" name="role_custom" value="{{ old('role_custom', !array_key_exists($projectContact->role, $roles) ? ucfirst(str_replace('_', ' ', $projectContact->role)) : '') }}"
                               class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('role_custom') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white"
                               placeholder="Enter custom role (e.g., Supervisor)">
                        @error('role_custom')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $projectContact->phone) }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                           placeholder="Contact number">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ old('email', $projectContact->email) }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white"
                           placeholder="Email address">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                    <textarea name="notes" rows="4"
                              class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                              placeholder="Availability, responsibilities, etc.">{{ old('notes', $projectContact->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="is_primary" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ old('is_primary', $projectContact->is_primary) ? 'checked' : '' }}>
                        <span class="ml-2">Mark as primary contact</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    <i class="fas fa-save mr-2"></i>Update Contact
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
