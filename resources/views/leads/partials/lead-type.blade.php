@php
    $gradients = [
        'Hot Lead' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
        'Warm Lead' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
        'Cold Lead' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)',
        'Qualified' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
        'Unqualified' => 'linear-gradient(135deg, #6b7280 0%, #4b5563 100%)',
    ];
    
    $icons = [
        'Hot Lead' => 'fire',
        'Warm Lead' => 'sun-fill',
        'Cold Lead' => 'snow',
        'Qualified' => 'check-circle-fill',
        'Unqualified' => 'x-circle-fill',
    ];
    
    $gradient = $gradients[$lead->lead_type] ?? 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)';
    $icon = $icons[$lead->lead_type] ?? 'star-fill';
@endphp

<span class="badge bg-gradient" style="background: {{ $gradient }}; color: white; padding: 6px 12px; font-weight: 600; border-radius: 8px;">
    <i class="bi bi-{{ $icon }} me-1"></i>{{ $lead->lead_type }}
</span>

