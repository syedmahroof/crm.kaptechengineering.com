<x-app-layout>
    <x-slot name="title">{{ $country->name }}</x-slot>
    <x-slot name="subtitle">Country Details</x-slot>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('countries.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Countries
        </a>
        <div>
            <a href="{{ route('countries.edit', $country) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Country Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Name:</th>
                            <td>{{ $country->name }}</td>
                        </tr>
                        <tr>
                            <th>ISO Code:</th>
                            <td><span class="badge bg-secondary">{{ $country->code ?? 'N/A' }}</span></td>
                        </tr>
                        <tr>
                            <th>Phone Code:</th>
                            <td>{{ $country->phone_code ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($country->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Total States:</th>
                            <td><span class="badge bg-info">{{ $country->states->count() }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">States</h5>
                    <a href="{{ route('states.create', ['country_id' => $country->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> Add State
                    </a>
                </div>
                <div class="card-body">
                    @if($country->states->count() > 0)
                        <div class="list-group">
                            @foreach($country->states as $state)
                            <a href="{{ route('states.show', $state) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $state->name }}</strong>
                                        @if($state->code)
                                            <span class="badge bg-secondary ms-2">{{ $state->code }}</span>
                                        @endif
                                    </div>
                                    <span class="badge bg-info">{{ $state->cities->count() }} cities</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No states found. <a href="{{ route('states.create', ['country_id' => $country->id]) }}">Add one</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

