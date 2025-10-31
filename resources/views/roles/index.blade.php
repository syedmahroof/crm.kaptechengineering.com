<x-app-layout>
    <x-slot name="title">Roles & Permissions</x-slot>
    <x-slot name="subtitle">Manage user roles and access permissions</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Role
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td><span class="badge bg-info">{{ $role->permissions_count }} permissions</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($role->name != 'Super Admin')
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No roles found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($roles->hasPages())
        <div class="card-footer">
            {{ $roles->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

