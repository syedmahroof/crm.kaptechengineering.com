<x-app-layout>
    <x-slot name="title">Lead Sources</x-slot>
    <x-slot name="subtitle">Manage lead sources</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-end mb-4">
        @can('create lead-sources')
        <a href="{{ route('lead-sources.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Lead Source
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
                        @forelse($leadSources as $leadSource)
                        <tr>
                            <td><strong>{{ $leadSource->name }}</strong></td>
                            <td>
                                @if($leadSource->color_code)
                                    <span class="badge" style="background-color: {{ $leadSource->color_code }}; color: white;">
                                        {{ $leadSource->color_code }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No color</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($leadSource->description, 50) ?? 'N/A' }}</td>
                            <td><span class="badge bg-info">{{ $leadSource->leads_count }}</span></td>
                            <td>
                                @if($leadSource->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('lead-sources.show', $leadSource) }}" class="btn btn-sm btn-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('lead-sources.edit', $leadSource) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('lead-sources.destroy', $leadSource) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No lead sources found. <a href="{{ route('lead-sources.create') }}">Create one</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($leadSources->hasPages())
        <div class="card-footer">
            {{ $leadSources->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

