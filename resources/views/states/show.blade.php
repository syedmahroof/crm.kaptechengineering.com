<x-app-layout>
    <x-slot name="title">{{ $state->name }}</x-slot>
    <x-slot name="subtitle">State Details</x-slot>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('states.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to States
        </a>
        <div>
            <a href="{{ route('states.edit', $state) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">State Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Name:</th>
                            <td>{{ $state->name }}</td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td><a href="{{ route('countries.show', $state->country) }}">{{ $state->country->name }}</a></td>
                        </tr>
                        <tr>
                            <th>State Code:</th>
                            <td><span class="badge bg-secondary">{{ $state->code ?? 'N/A' }}</span></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($state->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Total Cities:</th>
                            <td><span class="badge bg-info">{{ $state->cities->count() }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cities</h5>
                    <a href="{{ route('cities.create', ['state_id' => $state->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> Add City
                    </a>
                </div>
                <div class="card-body">
                    @if($state->cities->count() > 0)
                        <div class="list-group">
                            @foreach($state->cities as $city)
                            <a href="{{ route('cities.show', $city) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $city->name }}</strong>
                                        @if($city->district)
                                            <small class="text-muted ms-2">({{ $city->district }})</small>
                                        @endif
                                    </div>
                                    @if($city->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No cities found. <a href="{{ route('cities.create', ['state_id' => $state->id]) }}">Add one</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

