@extends('frontend.layouts.master')

@section('content')
<div class="profile-container">
    <div class="container">
        <div class="profile-wrapper">
            <!-- Sidebar -->
            @include('frontend.profile.sidebar')

            <!-- Content -->
            <div class="profile-content">
                <div class="content-header">
                    <h3>{{ trans_db('frontend.Notifications') }}</h3>
                    <p>{{ trans_db('frontend.Stay updated with your latest activities') }}</p>
                </div>

                @if($notifications->count() > 0)
                    <div class="notifications-list">
                        @foreach($notifications as $notification)
                            <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                                <div class="notification-icon">
                                    <i class="fa-solid fa-bell"></i>
                                </div>
                                <div class="notification-content">
                                    @if(isset($notification->data['type']) && $notification->data['type'] == 'broadcast')
                                        <h6 class="mb-1 font-weight-bold">{{ $notification->data['title'] }}</h6>
                                        <p class="mb-1 text-muted small">{{ $notification->data['content'] }}</p>
                                        @if(isset($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-link p-0">{{ trans_db('frontend.View Details') }}</a>
                                        @endif
                                    @else
                                        <p class="mb-1">{{ $notification->data['message'] ?? $notification->data['title'] ?? 'No message' }}</p>
                                    @endif
                                    <span class="text-muted small">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                @if(!$notification->read_at)
                                    <div class="notification-action">
                                        <span class="badge badge-primary">{{ trans_db('frontend.New') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <i class="fa-solid fa-bell-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ trans_db('frontend.No notifications yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('frontend.profile.partials.styles')
<style>
    /* Notification Specific Styles */
    .notification-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s;
    }
    .notification-item:last-child { border-bottom: none; }
    .notification-item:hover { background-color: #FDFCF5; }
    .notification-item.unread { background-color: #F1F8E9; }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        background-color: #E8F5E9;
        color: #1E5631;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    html[dir="rtl"] .notification-icon { margin-right: 0; margin-left: 1rem; }
    
    .notification-content { flex: 1; }
    .notification-action { margin-left: 1rem; }
    html[dir="rtl"] .notification-action { margin-left: 0; margin-right: 1rem; }
    
    .badge-primary { background-color: #1E5631; color: white; padding: 0.25em 0.6em; border-radius: 10rem; font-size: 75%; }
</style>
@endsection
