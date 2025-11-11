<x-app-layout>
    <x-slot name="title">Add Lead Type</x-slot>
    <x-slot name="subtitle">Create a new lead type</x-slot>

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('lead-types.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Lead Types
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('lead-types.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="color_code" class="form-label">Color Code</label>
                            <div class="input-group">
                                <span class="input-group-text">#</span>
                                <input type="text" class="form-control @error('color_code') is-invalid @enderror" 
                                       id="color_code" name="color_code" value="{{ old('color_code') }}" 
                                       placeholder="FF5733" maxlength="6" pattern="[0-9A-Fa-f]{6}">
                                <input type="color" class="form-control form-control-color" 
                                       id="color_picker" style="width: 50px; cursor: pointer;"
                                       onchange="document.getElementById('color_code').value = this.value.substring(1).toUpperCase()">
                            </div>
                            <small class="form-text text-muted">Enter a hex color code (e.g., FF5733) or use the color picker</small>
                            @error('color_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
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
                                <i class="bi bi-save me-2"></i>Create Lead Type
                            </button>
                            <a href="{{ route('lead-types.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

