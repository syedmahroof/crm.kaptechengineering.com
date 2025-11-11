<x-app-layout>
    <x-slot name="title">Countries</x-slot>
    <x-slot name="subtitle">Manage countries</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('countries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Country
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Phone Code</th>
                            <th>States</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($countries as $country)
                        <tr>
                            <td>{{ $country->name }}</td>
                            <td><span class="badge bg-secondary">{{ $country->code ?? 'N/A' }}</span></td>
                            <td>{{ $country->phone_code ?? 'N/A' }}</td>
                            <td><span class="badge bg-info">{{ $country->states_count }}</span></td>
                            <td>
                                @if($country->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('countries.show', $country) }}" class="btn btn-sm btn-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('countries.edit', $country) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('countries.destroy', $country) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary" title="Delete" onclick="return confirm('Are you sure? This will delete all associated states and cities.')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No countries found. <a href="{{ route('countries.create') }}">Create one</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($countries->hasPages())
        <div class="card-footer">
            {{ $countries->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

