<x-app-layout>
    <x-slot name="title">{{ $city->name }}</x-slot>
    <x-slot name="subtitle">City Details</x-slot>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Cities
        </a>
        <div>
            <a href="{{ route('cities.edit', $city) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">City Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Name:</th>
                            <td>{{ $city->name }}</td>
                        </tr>
                        <tr>
                            <th>District:</th>
                            <td>{{ $city->district ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>State:</th>
                            <td><a href="{{ route('states.show', $city->state) }}">{{ $city->state->name }}</a></td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td><a href="{{ route('countries.show', $city->state->country) }}">{{ $city->state->country->name }}</a></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($city->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

