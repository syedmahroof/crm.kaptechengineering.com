@if($lead->source)
    @php
        $icons = [
            'Website' => 'globe',
            'Social Media' => 'share',
            'Email Campaign' => 'envelope',
            'Phone Call' => 'telephone',
            'Referral' => 'person-check',
        ];
        $icon = $icons[$lead->source] ?? 'inbox';
    @endphp
    <span class="badge bg-light text-dark border">
        <i class="bi bi-{{ $icon }} me-1"></i>{{ $lead->source }}
    </span>
@else
    <span class="text-muted">-</span>
@endif

