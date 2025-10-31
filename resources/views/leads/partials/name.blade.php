<div class="d-flex align-items-center gap-2">
    <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px;">
        {{ strtoupper(substr($lead->name, 0, 2)) }}
    </div>
    <a href="{{ route('leads.show', $lead) }}" class="text-decoration-none fw-semibold text-dark">
        {{ $lead->name }}
    </a>
</div>

