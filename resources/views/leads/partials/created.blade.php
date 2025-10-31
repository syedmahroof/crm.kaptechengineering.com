<div class="d-flex align-items-center gap-1 text-muted small">
    <i class="bi bi-calendar3"></i>
    <span>{{ $lead->created_at->format('M d, Y') }}</span>
</div>
<small class="text-muted d-block" style="font-size: 10px;">
    {{ $lead->created_at->diffForHumans() }}
</small>

