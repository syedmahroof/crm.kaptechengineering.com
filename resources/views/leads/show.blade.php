<x-app-layout>
    <!-- Header Section with Status -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <h2 class="h4 mb-0 fw-bold">Lead Details</h2>
                    <span class="badge px-3 py-2" style="background-color: {{ $lead->status->color_code }}20; color: {{ $lead->status->color_code }}; border: 1px solid {{ $lead->status->color_code }}40;">
                        <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> {{ $lead->status->name }}
                    </span>
                </div>
                <p class="text-muted mb-0">Lead #{{ $lead->id }}</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changeStatusModal">
                    <i class="bi bi-arrow-repeat"></i> Change Status
                </button>
                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Content - Left Column -->
        <div class="col-lg-8">
            <!-- Contact Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-person-circle text-primary me-2"></i>Contact Information
                        </h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Full Name</label>
                                <p class="mb-0 fw-medium fs-6">{{ $lead->name }}</p>
                            </div>
                        </div>
                        @if($lead->company_name)
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Company Name</label>
                                <p class="mb-0 fw-medium fs-6">{{ $lead->company_name }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                @if($lead->email)
                                    <a href="mailto:{{ $lead->email }}" class="text-decoration-none">
                                        <p class="mb-0 text-primary fw-medium">{{ $lead->email }}</p>
                                    </a>
                                @else
                                    <p class="mb-0 text-muted">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">
                                    <i class="bi bi-telephone me-1"></i>Phone
                                </label>
                                @if($lead->phone)
                                    <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
                                        <p class="mb-0 text-primary fw-medium">{{ $lead->phone }}</p>
                                    </a>
                                @else
                                    <p class="mb-0 text-muted">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lead Details Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-info-circle text-info me-2"></i>Lead Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Assigned To</label>
                                @if($lead->assignedUser)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 50%; font-size: 0.875rem; font-weight: 600;">
                                            {{ strtoupper(substr($lead->assignedUser->name, 0, 1)) }}
                                        </div>
                                        <p class="mb-0 fw-medium">{{ $lead->assignedUser->name }}</p>
                                    </div>
                                @else
                                    <span class="badge bg-secondary">Unassigned</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Lead Type</label>
                                @if($lead->lead_type)
                                    <span class="badge bg-info text-white">{{ ucfirst($lead->lead_type) }}</span>
                                @else
                                    <p class="mb-0 text-muted">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Branch</label>
                                @if($lead->branch)
                                    <p class="mb-0 fw-medium">{{ $lead->branch->name }}</p>
                                @else
                                    <p class="mb-0 text-muted">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Source</label>
                                @if($lead->source)
                                    <p class="mb-0 fw-medium">{{ $lead->source }}</p>
                                @else
                                    <p class="mb-0 text-muted">-</p>
                                @endif
                            </div>
                        </div>
                        @if($lead->closing_date)
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Closing Date</label>
                                <p class="mb-0 fw-medium">{{ \Carbon\Carbon::parse($lead->closing_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Products</label>
                                @if(($lead->products ?? collect())->count() > 0)
                                    <div class="d-flex flex-column gap-3">
                                        @foreach($lead->products as $product)
                                            <div class="border rounded p-3 bg-light">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <i class="bi bi-box-seam text-primary"></i>
                                                    <span class="fw-semibold">{{ $product->name }}</span>
                                                    @if($product->pivot->quantity ?? null)
                                                        <span class="badge bg-primary ms-auto">Qty: {{ $product->pivot->quantity }}</span>
                                                    @endif
                                                </div>
                                                @if($product->pivot->description ?? null)
                                                    <p class="mb-0 text-muted small">{{ $product->pivot->description }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($lead->product)
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        <i class="bi bi-box-seam me-1"></i>{{ $lead->product->name }}
                                    </span>
                                @else
                                    <p class="mb-0 text-muted">-</p>
                                @endif
                            </div>
                        </div>
                        @if($lead->notes)
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Additional Notes</label>
                                <p class="mb-0 text-muted bg-light p-3 rounded border-start border-primary border-3">{{ $lead->notes }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Created At</label>
                                <p class="mb-0">
                                    <i class="bi bi-calendar3 me-1 text-muted"></i>
                                    {{ $lead->created_at->format('M d, Y') }}
                                    <small class="text-muted">at {{ $lead->created_at->format('H:i') }}</small>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted small text-uppercase fw-semibold mb-1 d-block">Last Updated</label>
                                <p class="mb-0">
                                    <i class="bi bi-clock-history me-1 text-muted"></i>
                                    {{ $lead->updated_at->format('M d, Y') }}
                                    <small class="text-muted">at {{ $lead->updated_at->format('H:i') }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Follow-ups Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-calendar-check text-success me-2"></i>Follow-ups
                            <span class="badge bg-light text-dark ms-2">{{ $lead->followups->count() }}</span>
                        </h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFollowupModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Follow-up
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    @forelse($lead->followups->sortByDesc('followup_date') as $followup)
                    <div class="followup-item mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-calendar-event text-primary"></i>
                                    <strong class="fw-semibold">{{ $followup->followup_date->format('M d, Y H:i') }}</strong>
                                    @php
                                        $typeMap = [
                                            'email' => ['bi-envelope-fill', '#3b82f6', 'Email'],
                                            'call' => ['bi-telephone-fill', '#10b981', 'Call'],
                                            'sms' => ['bi-chat-dots-fill', '#0ea5e9', 'SMS'],
                                            'meeting' => ['bi-people-fill', '#8b5cf6', 'Meeting'],
                                            'payment_reminder' => ['bi-cash-coin', '#f59e0b', 'Payment Reminder'],
                                            'other' => ['bi-bell-fill', '#64748b', 'Other'],
                                        ];
                                        [$icon, $color, $label] = $typeMap[$followup->type] ?? $typeMap['other'];
                                    @endphp
                                    <span class="badge px-2 py-1" style="background: {{ $color }}20; color: {{ $color }}; border: 1px solid {{ $color }}40;">
                                        <i class="bi {{ $icon }} me-1" style="font-size: 0.75rem;"></i>{{ $label }}
                                    </span>
                                    <span class="badge bg-{{ $followup->status == 'pending' ? 'warning' : ($followup->status == 'completed' ? 'success' : 'secondary') }} px-2 py-1">
                                        {{ ucfirst($followup->status) }}
                                    </span>
                                </div>
                                @if($followup->remarks)
                                <p class="mb-0 text-muted">{{ $followup->remarks }}</p>
                                @endif
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">
                                    <i class="bi bi-person me-1"></i>{{ $followup->user->name }}
                                </small>
                                <small class="text-muted">{{ $followup->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-4 text-muted mb-3"></i>
                        <p class="text-muted mb-0">No follow-ups scheduled</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow-sm border-0 mb-4" style="border-left: 4px solid {{ $lead->status->color_code }} !important;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-flag-fill me-2" style="color: {{ $lead->status->color_code }};"></i>Current Status
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <span class="badge px-4 py-3 fs-6" style="background-color: {{ $lead->status->color_code }}20; color: {{ $lead->status->color_code }}; border: 2px solid {{ $lead->status->color_code }};">
                            <i class="bi bi-circle-fill me-2" style="font-size: 0.75rem;"></i>{{ $lead->status->name }}
                        </span>
                    </div>
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#changeStatusModal">
                        <i class="bi bi-arrow-repeat me-1"></i> Change Status
                    </button>
                </div>
            </div>

            <!-- Notes Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-chat-left-text text-info me-2"></i>Notes
                            <span class="badge bg-light text-dark ms-2">{{ $lead->leadNotes->count() }}</span>
                        </h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                    @forelse($lead->leadNotes->sortByDesc('created_at') as $note)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle bg-info text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; border-radius: 50%; font-size: 0.75rem; font-weight: 600;">
                                    {{ strtoupper(substr($note->user->name, 0, 1)) }}
                                </div>
                                <small class="fw-semibold">{{ $note->user->name }}</small>
                            </div>
                            <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0 small">{{ $note->note }}</p>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-chat-left-quote display-4 text-muted mb-3"></i>
                        <p class="text-muted mb-0">No notes yet</p>
                        <button type="button" class="btn btn-sm btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                            <i class="bi bi-plus-circle me-1"></i> Add First Note
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Change Status Modal -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('leads.updateStatus', $lead) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-arrow-repeat text-primary me-2"></i>Change Lead Status
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="status_id" class="form-label fw-semibold mb-3">Select New Status</label>
                            <select class="form-select form-select-lg" id="status_id" name="status_id" required style="border: 2px solid #e5e7eb;">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $lead->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-3">
                                <small class="text-muted">Current status: 
                                    <span class="badge" style="background-color: {{ $lead->status->color_code }}20; color: {{ $lead->status->color_code }};">
                                        {{ $lead->status->name }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Note Modal -->
    <div class="modal fade" id="addNoteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('notes.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-chat-left-text text-info me-2"></i>Add Note
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="note" class="form-label fw-semibold">Note</label>
                            <textarea class="form-control" id="note" name="note" rows="5" placeholder="Enter your note here..." required style="border: 2px solid #e5e7eb;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Save Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Followup Modal -->
    <div class="modal fade" id="addFollowupModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('followups.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-semibold">
                            <i class="bi bi-calendar-check text-success me-2"></i>Schedule Follow-up
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="followup_date" class="form-label fw-semibold">Date & Time</label>
                            <input type="datetime-local" class="form-control" id="followup_date" name="followup_date" required style="border: 2px solid #e5e7eb;">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Type</label>
                            <select class="form-select" id="type" name="type" required style="border: 2px solid #e5e7eb;">
                                <option value="call">📞 Call</option>
                                <option value="sms">💬 SMS</option>
                                <option value="email">📧 Email</option>
                                <option value="meeting">👥 Meeting</option>
                                <option value="payment_reminder">💰 Payment Reminder</option>
                                <option value="other">🔔 Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="status" name="status" required style="border: 2px solid #e5e7eb;">
                                <option value="pending">⏳ Pending</option>
                                <option value="completed">✅ Completed</option>
                                <option value="cancelled">❌ Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label fw-semibold">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Add any remarks or notes..." style="border: 2px solid #e5e7eb;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .info-item {
            margin-bottom: 0.5rem;
        }
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
        }
        .avatar-circle {
            flex-shrink: 0;
        }
        .followup-item:last-child {
            border-bottom: none !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
            }
        }
    </style>
</x-app-layout>