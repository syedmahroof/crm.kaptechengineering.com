<x-app-layout>
    <x-slot name="title">Add City</x-slot>
    <x-slot name="subtitle">Create a new city</x-slot>

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Cities
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('cities.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                            <select class="form-select @error('state_id') is-invalid @enderror" 
                                    id="state_id" name="state_id" required>
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id', request('state_id')) == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }} ({{ $state->country->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="district" class="form-label">District</label>
                            <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                   id="district" name="district" value="{{ old('district') }}" placeholder="District name">
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Create City
                            </button>
                            <a href="{{ route('cities.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

