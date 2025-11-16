@extends('layouts.admin')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ isset($role) ? 'Edit Role' : 'Create Role' }}</h1>
        <a href="{{ route('roles.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @if(isset($role))
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
            @php
                $protectedRoles = ['super-admin', 'team-lead', 'manager', 'agent'];
                $isProtected = isset($role) && in_array($role->name, $protectedRoles);
            @endphp
            <input 
                type="text" 
                name="name" 
                value="{{ old('name', $role->name ?? '') }}" 
                required 
                {{ $isProtected ? 'readonly' : '' }}
                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white {{ $isProtected ? 'bg-gray-100 dark:bg-gray-800 cursor-not-allowed' : '' }}"
            >
            @if($isProtected)
                <p class="mt-1 text-xs text-gray-500">This role name cannot be changed</p>
            @endif
        </div>

        <div>
            <div class="flex items-center justify-between mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                <button type="button" onclick="toggleAllPermissions()" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                    <i class="fas fa-check-double mr-1"></i>Select All / Deselect All
                </button>
            </div>
            
            <div class="max-h-96 overflow-y-auto p-4 border rounded-lg dark:bg-gray-700 space-y-4">
                @foreach($groupedPermissions ?? [] as $category => $categoryPermissions)
                    <div class="permission-group border-b border-gray-300 dark:border-gray-600 pb-3 last:border-b-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">
                                <i class="fas fa-folder mr-2 text-blue-500"></i>{{ $category }}
                            </h3>
                            <button type="button" 
                                    onclick="toggleGroupPermissions('{{ $category }}')" 
                                    class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                <i class="fas fa-check-square mr-1"></i>Select All
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 ml-4">
                            @foreach($categoryPermissions as $permission)
                                <label class="flex items-center group-checkbox" data-group="{{ $category }}">
                                    <input type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->name }}" 
                                           data-group="{{ $category }}"
                                           {{ (isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded permission-checkbox">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                @if(empty($groupedPermissions))
                    <!-- Fallback if grouping fails -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($permissions as $permission)
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                    {{ (isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}
                                    class="h-4 w-4 permission-checkbox">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('roles.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">{{ isset($role) ? 'Update' : 'Create' }}</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function toggleAllPermissions() {
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
        });
        
        // Update group select all buttons
        updateGroupSelectAllButtons();
    }
    
    function toggleGroupPermissions(groupName) {
        const groupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${groupName}"]`);
        const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
        
        groupCheckboxes.forEach(cb => {
            cb.checked = !allChecked;
        });
        
        // Update group select all button
        updateGroupSelectAllButton(groupName);
    }
    
    function updateGroupSelectAllButton(groupName) {
        const groupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${groupName}"]`);
        const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
        const button = document.querySelector(`button[onclick="toggleGroupPermissions('${groupName}')"]`);
        
        if (button) {
            if (allChecked) {
                button.innerHTML = '<i class="fas fa-square mr-1"></i>Deselect All';
                button.classList.remove('text-blue-600', 'dark:text-blue-400');
                button.classList.add('text-red-600', 'dark:text-red-400');
            } else {
                button.innerHTML = '<i class="fas fa-check-square mr-1"></i>Select All';
                button.classList.remove('text-red-600', 'dark:text-red-400');
                button.classList.add('text-blue-600', 'dark:text-blue-400');
            }
        }
    }
    
    function updateGroupSelectAllButtons() {
        const groups = document.querySelectorAll('.permission-group');
        groups.forEach(group => {
            const groupName = group.querySelector('.permission-checkbox')?.getAttribute('data-group');
            if (groupName) {
                updateGroupSelectAllButton(groupName);
            }
        });
    }
    
    // Initialize group buttons on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateGroupSelectAllButtons();
        
        // Update group buttons when individual checkboxes are clicked
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const groupName = this.getAttribute('data-group');
                if (groupName) {
                    updateGroupSelectAllButton(groupName);
                }
            });
        });
    });
</script>
@endpush
@endsection

