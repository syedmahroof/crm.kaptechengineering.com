<x-app-layout>
    <x-slot name="title">Lead Types</x-slot>
    <x-slot name="subtitle">Manage lead types</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-end mb-4">
        @can('create lead-types')
        <a href="{{ route('lead-types.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Lead Type
        </a>
        @endcan
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Description</th>
                            <th>Leads</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leadTypes as $leadType)
                        <tr>
                            <td><strong>{{ $leadType->name }}</strong></td>
                            <td>
                                @if($leadType->color_code)
                                    <span class="badge" style="background-color: {{ $leadType->color_code }}; color: white;">
                                        {{ $leadType->color_code }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No color</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($leadType->description, 50) ?? 'N/A' }}</td>
                            <td><span class="badge bg-info">{{ $leadType->leads_count }}</span></td>
                            <td>
                                @if($leadType->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('lead-types.show', $leadType) }}" class="btn btn-sm btn-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @can('edit lead-types')
                                    <a href="{{ route('lead-types.edit', $leadType) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('delete lead-types')
                                    <form action="{{ route('lead-types.destroy', $leadType) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No lead types found. <a href="{{ route('lead-types.create') }}">Create one</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($leadTypes->hasPages())
        <div class="card-footer">
            {{ $leadTypes->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

