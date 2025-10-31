<x-app-layout>
    <x-slot name="title">Follow-ups</x-slot>
    <x-slot name="subtitle">Track and manage all scheduled follow-ups</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('calendar.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-calendar3 me-2"></i>View Calendar
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Lead</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($followups as $followup)
                        <tr>
                            <td>
                                <a href="{{ route('leads.show', $followup->lead) }}">
                                    {{ $followup->lead->name }}
                                </a>
                            </td>
                            <td>{{ $followup->followup_date->format('M d, Y H:i') }}</td>
                            <td>
                                @php
                                    $map = [
                                        'email' => ['bi-envelope-fill', '#3b82f6', 'Email'],
                                        'call' => ['bi-telephone-fill', '#10b981', 'Call'],
                                        'sms' => ['bi-chat-dots-fill', '#0ea5e9', 'SMS'],
                                        'meeting' => ['bi-people-fill', '#8b5cf6', 'Meeting'],
                                        'payment_reminder' => ['bi-cash-coin', '#f59e0b', 'Payment Reminder'],
                                        'other' => ['bi-bell-fill', '#64748b', 'Other'],
                                    ];
                                    [$icon, $color, $label] = $map[$followup->type] ?? $map['other'];
                                @endphp
                                <span class="badge" style="background: {{ $color }}20; color: {{ $color }};">
                                    <i class="bi {{ $icon }} me-1"></i>{{ $label }}
                                </span>
                            </td>
                            <td>{{ $followup->user->name }}</td>
                            <td>
                                @if($followup->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($followup->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($followup->remarks, 50) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No follow-ups scheduled.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($followups->hasPages())
        <div class="card-footer">
            {{ $followups->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

