@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notifications</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">View all your notifications</p>
        </div>
        @if($unreadCount > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-check-double mr-2"></i>Mark All as Read
                </button>
            </form>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($notifications as $notification)
                    <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 {{ is_null($notification->read_at) ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-start space-x-3">
                                    @if(is_null($notification->read_at))
                                        <div class="mt-1.5 h-2 w-2 rounded-full bg-blue-600 flex-shrink-0"></div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="text-base font-medium text-gray-900 dark:text-white">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </h3>
                                        @if(isset($notification->data['message']))
                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $notification->data['message'] }}
                                            </p>
                                        @endif
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                @if(is_null($notification->read_at))
                                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 dark:text-gray-400">No notifications found.</p>
        </div>
    @endif
</div>
@endsection

