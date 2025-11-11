<x-app-layout>
    <x-slot name="title">Edit Lead</x-slot>
    <x-slot name="subtitle">Update lead information</x-slot>

    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Leads
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form action="{{ route('leads.update', $lead) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $lead->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $lead->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $lead->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                       id="company_name" name="company_name" value="{{ old('company_name', $lead->company_name) }}">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status_id" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status_id') is-invalid @enderror" 
                                        id="status_id" name="status_id" required>
                                    <option value="">Select Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id', $lead->status_id) == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="assigned_to" class="form-label">Assign To</label>
                                <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                        id="assigned_to" name="assigned_to">
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Products</label>
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width: 40%">Product</th>
                                                <th style="width: 15%">Qty</th>
                                                <th>Description</th>
                                                <th style="width: 60px"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="productRows">
                                            @php($idx = 0)
                                            @forelse($lead->products as $p)
                                            <tr>
                                                <td>
                                                    <select class="form-select" name="products[{{ $idx }}][product_id]">
                                                        <option value="">Select</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ $p->id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $idx }}][quantity]" class="form-control" value="{{ $p->pivot->quantity ?? 1 }}" min="1">
                                                </td>
                                                <td>
                                                    <input type="text" name="products[{{ $idx }}][description]" class="form-control" value="{{ $p->pivot->description }}" placeholder="Notes for this product (optional)">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-danger btn-sm removeRow" {{ $loop->first ? 'disabled' : '' }}>
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php($idx++)
                                            @empty
                                            <tr>
                                                <td>
                                                    <select class="form-select" name="products[0][product_id]">
                                                        <option value="">Select</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[0][quantity]" class="form-control" value="1" min="1">
                                                </td>
                                                <td>
                                                    <input type="text" name="products[0][description]" class="form-control" placeholder="Notes for this product (optional)">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-danger btn-sm removeRow" disabled>
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" id="addProductRow" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>Add Product
                                </button>
                            </div>

                            <div class="col-md-6">
                                <label for="branch_ids" class="form-label">Branches (select one or more)</label>
                                <select class="form-select @error('branch_ids') is-invalid @enderror" 
                                        id="branch_ids" name="branch_ids[]" multiple>
                                    @php($selected = old('branch_ids', $lead->branches->pluck('id')->toArray()))
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ in_array($branch->id, $selected) ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">You can assign this lead to multiple branches. Choose a primary branch below.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="branch_id" class="form-label">Primary Branch</label>
                                <select class="form-select @error('branch_id') is-invalid @enderror" 
                                        id="branch_id" name="branch_id">
                                    <option value="">Select Primary Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id', $lead->branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="country_id" class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-select select2 @error('country_id') is-invalid @enderror" 
                                        id="country_id" name="country_id" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id', $lead->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                                <select class="form-select select2 @error('state_id') is-invalid @enderror" 
                                        id="state_id" name="state_id" required>
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id', $lead->state_id) == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city_id" class="form-label">City</label>
                                <select class="form-select select2 @error('city_id') is-invalid @enderror" 
                                        id="city_id" name="city_id">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $lead->city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="source" class="form-label">
                                    <i class="bi bi-funnel-fill me-1"></i>Source
                                </label>
                                <select class="form-select @error('source') is-invalid @enderror" 
                                        id="source" name="source">
                                    <option value="">Select Source</option>
                                    <option value="Website" {{ old('source', $lead->source) == 'Website' ? 'selected' : '' }}>Website</option>
                                    <option value="Email Campaign" {{ old('source', $lead->source) == 'Email Campaign' ? 'selected' : '' }}>Email Campaign</option>
                                    <option value="Social Media" {{ old('source', $lead->source) == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                    <option value="Phone Call" {{ old('source', $lead->source) == 'Phone Call' ? 'selected' : '' }}>Phone Call</option>
                                    <option value="Walk-in" {{ old('source', $lead->source) == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                    <option value="Referral" {{ old('source', $lead->source) == 'Referral' ? 'selected' : '' }}>Referral</option>
                                    <option value="Trade Show" {{ old('source', $lead->source) == 'Trade Show' ? 'selected' : '' }}>Trade Show</option>
                                    <option value="Online Ad" {{ old('source', $lead->source) == 'Online Ad' ? 'selected' : '' }}>Online Ad</option>
                                    <option value="Partner" {{ old('source', $lead->source) == 'Partner' ? 'selected' : '' }}>Partner</option>
                                    <option value="Direct Marketing" {{ old('source', $lead->source) == 'Direct Marketing' ? 'selected' : '' }}>Direct Marketing</option>
                                </select>
                                @error('source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lead_type" class="form-label">
                                    <i class="bi bi-tag-fill me-1"></i>Lead Type
                                </label>
                                <select class="form-select @error('lead_type') is-invalid @enderror" 
                                        id="lead_type" name="lead_type">
                                    <option value="">Select Lead Type</option>
                                    <option value="Hot Lead" {{ old('lead_type', $lead->lead_type) == 'Hot Lead' ? 'selected' : '' }}>🔥 Hot Lead</option>
                                    <option value="Warm Lead" {{ old('lead_type', $lead->lead_type) == 'Warm Lead' ? 'selected' : '' }}>☀️ Warm Lead</option>
                                    <option value="Cold Lead" {{ old('lead_type', $lead->lead_type) == 'Cold Lead' ? 'selected' : '' }}>❄️ Cold Lead</option>
                                    <option value="New Inquiry" {{ old('lead_type', $lead->lead_type) == 'New Inquiry' ? 'selected' : '' }}>⭐ New Inquiry</option>
                                    <option value="Referral" {{ old('lead_type', $lead->lead_type) == 'Referral' ? 'selected' : '' }}>👥 Referral</option>
                                    <option value="Returning Customer" {{ old('lead_type', $lead->lead_type) == 'Returning Customer' ? 'selected' : '' }}>🔄 Returning Customer</option>
                                    <option value="Qualified" {{ old('lead_type', $lead->lead_type) == 'Qualified' ? 'selected' : '' }}>✅ Qualified</option>
                                    <option value="Unqualified" {{ old('lead_type', $lead->lead_type) == 'Unqualified' ? 'selected' : '' }}>❌ Unqualified</option>
                                </select>
                                @error('lead_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="closing_date" class="form-label">Expected Closing Date</label>
                                <input type="date" class="form-control @error('closing_date') is-invalid @enderror" 
                                       id="closing_date" name="closing_date" value="{{ old('closing_date', optional($lead->closing_date)->format('Y-m-d')) }}">
                                @error('closing_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="4">{{ old('notes', $lead->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Update Lead
                                </button>
                                <a href="{{ route('leads.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                    @push('styles')
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                    <style>
                        .select2-container--default .select2-selection--single {
                            height: 42px;
                            border: 2px solid #e2e8f0;
                            border-radius: 10px;
                        }
                        .select2-container--default .select2-selection--single .select2-selection__rendered {
                            line-height: 42px;
                            padding-left: 16px;
                        }
                        .select2-container--default .select2-selection--single .select2-selection__arrow {
                            height: 40px;
                        }
                        .select2-container--default .select2-results__option--highlighted[aria-selected] {
                            background-color: #6366f1;
                        }
                    </style>
                    @endpush
                    @push('scripts')
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                    <script>
                        (function(){
                            // Initialize Select2 for searchable selects
                            $('.select2').select2({
                                width: '100%',
                                placeholder: function() {
                                    return $(this).data('placeholder') || 'Select an option';
                                }
                            });

                            // If state is changed but cities are not loaded, load them
                            const currentStateId = $('#state_id').val();
                            if (currentStateId && $('#city_id option').length <= 1) {
                                fetch(`/api/cities?state_id=${currentStateId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const citySelect = $('#city_id');
                                        const currentCityId = '{{ old("city_id", $lead->city_id) }}';
                                        citySelect.empty().append('<option value="">Select City</option>');
                                        data.forEach(function(city) {
                                            const option = new Option(city.name, city.id);
                                            if (city.id == currentCityId) {
                                                option.selected = true;
                                            }
                                            citySelect.append(option);
                                        });
                                        citySelect.trigger('change');
                                    });
                            }

                            // Handle country change
                            $('#country_id').on('change', function() {
                                const countryId = $(this).val();
                                const stateSelect = $('#state_id');
                                const citySelect = $('#city_id');
                                
                                // Clear and disable state and city
                                stateSelect.empty().append('<option value="">Select State</option>').val('').trigger('change');
                                citySelect.empty().append('<option value="">Select City</option>').val('').trigger('change');
                                
                                if (countryId) {
                                    // Fetch states for selected country
                                    fetch(`/api/states?country_id=${countryId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            stateSelect.empty().append('<option value="">Select State</option>');
                                            data.forEach(function(state) {
                                                stateSelect.append(new Option(state.name, state.id));
                                            });
                                            stateSelect.trigger('change');
                                        })
                                        .catch(() => {
                                            console.error('Error loading states');
                                        });
                                }
                            });

                            // Handle state change
                            $('#state_id').on('change', function() {
                                const stateId = $(this).val();
                                const citySelect = $('#city_id');
                                
                                // Clear city
                                citySelect.empty().append('<option value="">Select City</option>').val('').trigger('change');
                                
                                if (stateId) {
                                    // Fetch cities for selected state
                                    fetch(`/api/cities?state_id=${stateId}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            citySelect.empty().append('<option value="">Select City</option>');
                                            data.forEach(function(city) {
                                                citySelect.append(new Option(city.name, city.id));
                                            });
                                        })
                                        .catch(() => {
                                            console.error('Error loading cities');
                                        });
                                }
                            });

                            // Product rows functionality
                            let rowIndex = {{ max(1, ($lead->products->count() ?? 0)) }};
                            document.getElementById('addProductRow').addEventListener('click', function(){
                                const tbody = document.getElementById('productRows');
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>
                                        <select class=\"form-select\" name=\"products[${rowIndex}][product_id]\">
                                            <option value=\"\">Select</option>
                                            @foreach($products as $product)
                                                <option value=\"{{ $product->id }}\">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type=\"number\" name=\"products[${rowIndex}][quantity]\" class=\"form-control\" value=\"1\" min=\"1\">
                                    </td>
                                    <td>
                                        <input type=\"text\" name=\"products[${rowIndex}][description]\" class=\"form-control\" placeholder=\"Notes for this product (optional)\">
                                    </td>
                                    <td>
                                        <button type=\"button\" class=\"btn btn-outline-danger btn-sm removeRow\">\n                                            <i class=\"bi bi-x\"></i>\n                                        </button>
                                    </td>
                                `;
                                tbody.appendChild(tr);
                                rowIndex++;
                            });

                            document.getElementById('productRows').addEventListener('click', function(e){
                                if (e.target.closest('.removeRow')) {
                                    const btn = e.target.closest('.removeRow');
                                    const row = btn.closest('tr');
                                    row.parentNode.removeChild(row);
                                }
                            });
                        })();
                    </script>
                    @endpush
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

