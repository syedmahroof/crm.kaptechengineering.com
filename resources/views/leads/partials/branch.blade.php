@if($lead->branch)
    <span class="small fw-medium">
        <i class="bi bi-building me-1 text-success"></i>{{ $lead->branch->name }}
    </span>
@else
    <span class="text-muted">-</span>
@endif

