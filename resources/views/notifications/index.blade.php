<x-app-layout>
    <x-slot name="title">Notifications</x-slot>
    <x-slot name="subtitle">Stay updated with all your important notifications</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-primary" style="font-size: 14px; padding: 8px 16px;">
                {{ $unreadCount }} Unread
            </span>
        </div>
        <div>
            @if($unreadCount > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-check-all me-1"></i>Mark All as Read
                </button>
            </form>
            @endif
            <form action="{{ route('notifications.deleteAllRead') }}" method="POST" class="d-inline ms-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete all read notifications?')">
                    <i class="bi bi-trash me-1"></i>Delete Read
                </button>
            </form>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="card">
        <div class="card-body p-0">
            @forelse($notifications as $notification)
            <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" 
                 style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: start; gap: 16px; transition: all 0.2s;"
                 onmouseover="this.style.background='#f8fafc'" 
                 onmouseout="this.style.background='{{ $notification->is_read ? 'white' : '#f8fafc' }}'">
                
                <!-- Icon -->
                <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--{{ $notification->color }})20; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi bi-{{ $notification->icon }}" style="font-size: 20px; color: var(--{{ $notification->color }});"></i>
                </div>

                <!-- Content -->
                <div style="flex: 1; min-width: 0;">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <h6 class="mb-0 fw-bold" style="color: #0f172a;">{{ $notification->title }}</h6>
                        <small class="text-muted" style="white-space: nowrap; margin-left: 16px;">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <p class="mb-2 text-muted" style="font-size: 14px;">{{ $notification->message }}</p>
                    
                    <div class="d-flex gap-2 align-items-center">
                        @if($notification->action_url)
                        <a href="{{ $notification->action_url }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                        @endif
                        
                        @if(!$notification->is_read)
                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-check"></i>
                            </button>
                        </form>
                        @endif
                        
                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this notification?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Unread Indicator -->
                @if(!$notification->is_read)
                <div style="width: 8px; height: 8px; border-radius: 50%; background: #6366f1; margin-top: 8px; flex-shrink: 0;"></div>
                @endif
            </div>
            @empty
            <div class="text-center py-5">
                <div style="opacity: 0.3;">
                    <i class="bi bi-bell-slash display-3 d-block mb-3"></i>
                    <p class="fw-bold">No notifications yet</p>
                    <small class="text-muted">You'll see notifications here when there's activity</small>
                </div>
            </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
        <div class="card-footer">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</x-app-layout>




