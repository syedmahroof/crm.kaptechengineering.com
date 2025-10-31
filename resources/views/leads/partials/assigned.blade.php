@if($lead->assignedUser)
    <div class="d-flex align-items-center gap-2">
        <div style="width: 24px; height: 24px; border-radius: 6px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); display: flex; align-items-center; justify-content: center; color: white; font-size: 10px; font-weight: 700;">
            {{ strtoupper(substr($lead->assignedUser->name, 0, 2)) }}
        </div>
        <span class="small fw-medium">{{ $lead->assignedUser->name }}</span>
    </div>
@else
    <span class="badge bg-light text-muted">
        <i class="bi bi-person-x me-1"></i>Unassigned
    </span>
@endif

