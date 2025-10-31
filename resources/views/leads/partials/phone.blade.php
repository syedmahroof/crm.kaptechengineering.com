@if($lead->phone)
    <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
        <i class="bi bi-telephone me-1"></i>{{ $lead->phone }}
    </a>
@else
    <span class="text-muted">-</span>
@endif

