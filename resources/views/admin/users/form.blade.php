@extends('layouts.admin')

@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ isset($user) ? 'Edit User' : 'Create User' }}</h1>
        <a href="{{ route('users.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg mb-4">
            <p class="font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ isset($user) ? 'New Password' : 'Password' }} {{ !isset($user) ? '*' : '' }}</label>
                <input type="password" name="password" {{ !isset($user) ? 'required' : '' }} class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password {{ !isset($user) ? '*' : '' }}</label>
                <input type="password" name="password_confirmation" {{ !isset($user) ? 'required' : '' }} class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Roles</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($roles as $role)
                    <label class="flex items-center">
                        <input type="checkbox" name="roles[]" value="{{ $role }}" 
                            {{ (isset($user) && $user->hasRole($role)) || in_array($role, old('roles', [])) ? 'checked' : '' }}
                            class="h-4 w-4">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Branches</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($branches as $branch)
                    <label class="flex items-center">
                        <input type="checkbox" name="branches[]" value="{{ $branch->id }}" 
                            {{ (isset($userBranches) && in_array($branch->id, $userBranches)) || in_array($branch->id, old('branches', [])) ? 'checked' : '' }}
                            class="h-4 w-4 branch-checkbox">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $branch->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Primary Branch</label>
            <select name="primary_branch" id="primary_branch" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">Select Primary Branch (Optional)</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" 
                        {{ (isset($primaryBranch) && $primaryBranch == $branch->id) || old('primary_branch') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('users.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Update primary branch options based on selected branches
    document.querySelectorAll('.branch-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updatePrimaryBranchOptions();
        });
    });

    function updatePrimaryBranchOptions() {
        const selectedBranches = Array.from(document.querySelectorAll('.branch-checkbox:checked')).map(cb => cb.value);
        const primaryBranchSelect = document.getElementById('primary_branch');
        const currentValue = primaryBranchSelect.value;
        
        Array.from(primaryBranchSelect.options).forEach(option => {
            if (option.value === '') return;
            option.style.display = selectedBranches.includes(option.value) ? 'block' : 'none';
            if (!selectedBranches.includes(option.value) && option.value === currentValue) {
                primaryBranchSelect.value = '';
            }
        });
        
        // If no branches are selected, disable primary branch select
        if (selectedBranches.length === 0) {
            primaryBranchSelect.disabled = true;
        } else {
            primaryBranchSelect.disabled = false;
        }
    }

    // Initialize on page load
    updatePrimaryBranchOptions();
</script>
@endpush
@endsection

