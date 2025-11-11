<x-app-layout>
    <x-slot name="title">Cities</x-slot>
    <x-slot name="subtitle">Manage cities</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-between mb-4">
        <form method="GET" action="{{ route('cities.index') }}" class="d-flex gap-2">
            <select name="country_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Countries</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
            <select name="state_id" class="form-select" onchange="this.form.submit()">
                <option value="">All States</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('cities.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add City
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>District</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                        <tr>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->district ?? 'N/A' }}</td>
                            <td><a href="{{ route('states.show', $city->state) }}">{{ $city->state->name }}</a></td>
                            <td>{{ $city->state->country->name }}</td>
                            <td>
                                @if($city->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('cities.show', $city) }}" class="btn btn-sm btn-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('cities.edit', $city) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('cities.destroy', $city) }}" method="POST" class="d-inline">
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
                                No cities found. <a href="{{ route('cities.create') }}">Create one</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($cities->hasPages())
        <div class="card-footer">
            {{ $cities->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

