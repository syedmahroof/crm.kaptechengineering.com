<x-app-layout>
    <x-slot name="title">States</x-slot>
    <x-slot name="subtitle">Manage states</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-between mb-4">
        <form method="GET" action="{{ route('states.index') }}" class="d-flex gap-2">
            <select name="country_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Countries</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('states.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add State
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Code</th>
                            <th>Cities</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($states as $state)
                        <tr>
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->country->name }}</td>
                            <td><span class="badge bg-secondary">{{ $state->code ?? 'N/A' }}</span></td>
                            <td><span class="badge bg-info">{{ $state->cities_count }}</span></td>
                            <td>
                                @if($state->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('states.show', $state) }}" class="btn btn-sm btn-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('states.edit', $state) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('states.destroy', $state) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary" title="Delete" onclick="return confirm('Are you sure? This will delete all associated cities.')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No states found. <a href="{{ route('states.create') }}">Create one</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($states->hasPages())
        <div class="card-footer">
            {{ $states->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

