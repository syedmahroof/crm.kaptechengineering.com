@if($lead->product)
    <span class="small fw-medium">
        <i class="bi bi-box-seam me-1 text-primary"></i>{{ $lead->product->name }}
    </span>
@else
    <span class="text-muted">-</span>
@endif

