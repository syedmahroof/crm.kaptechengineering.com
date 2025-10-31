@if($lead->email)
    <a href="mailto:{{ $lead->email }}" class="text-decoration-none">
        <i class="bi bi-envelope me-1"></i>{{ $lead->email }}
    </a>
@else
    <span class="text-muted">-</span>
@endif

