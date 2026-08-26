@extends('layouts.superadmin')

@section('content')

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    rel="stylesheet"
>

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {
    --notification-bg: #0b0b2d;
    --notification-card: #111827;
    --notification-item: #111827;
    --notification-item-hover: #1e293b;
    --notification-unread: #172554;

    --notification-primary: #3b82f6;
    --notification-primary-dark: #2563eb;

    --notification-success: #22c55e;
    --notification-danger: #ef4444;
    --notification-danger-dark: #b91c1c;

    --notification-text: #ffffff;
    --notification-muted: #94a3b8;
    --notification-secondary: #cbd5e1;

    --notification-border: rgba(255, 255, 255, 0.06);

    --notification-radius: 18px;
}


/* =========================================================
   PAGE
========================================================= */

.notifications-container {
    width: 100%;
    padding: 25px;

    box-sizing: border-box;
}


/* =========================================================
   HEADER
========================================================= */

.notifications-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 20px;
}

.notifications-title {
    display: flex;

    align-items: center;

    margin: 0;

    color: var(--notification-text);

    font-size: 24px;
    font-weight: 700;
}


/* =========================================================
   UNREAD COUNTER
========================================================= */

.notification-count {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 28px;
    height: 24px;

    margin-left: 9px;
    padding: 0 8px;

    border-radius: 20px;

    background: var(--notification-danger);

    color: white;

    font-size: 12px;
    font-weight: 700;
}


/* =========================================================
   MARK ALL BUTTON
========================================================= */

.mark-all-form {
    margin: 0;
}

.mark-all-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 10px 16px;

    border: none;
    border-radius: 10px;

    background:
        linear-gradient(
            135deg,
            var(--notification-primary),
            var(--notification-primary-dark)
        );

    color: white;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.mark-all-btn:hover {
    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(59, 130, 246, 0.3);
}


/* =========================================================
   NOTIFICATION CARD
========================================================= */

.notifications-card {
    width: 100%;

    overflow: hidden;

    background: var(--notification-card);

    border:
        1px solid var(--notification-border);

    border-radius: var(--notification-radius);

    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.35);
}


/* =========================================================
   NOTIFICATION ITEM
========================================================= */

.notification-item {
    position: relative;

    display: flex;

    align-items: center;

    gap: 16px;

    padding: 18px 22px;

    background: var(--notification-item);

    border-bottom:
        1px solid var(--notification-border);

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background: var(--notification-item-hover);
}


/* UNREAD */

.notification-item.unread {
    background: var(--notification-unread);

    border-left:
        4px solid var(--notification-primary);
}

.notification-item.unread:hover {
    background: #1e3a8a;
}


/* =========================================================
   NOTIFICATION LINK
========================================================= */

.notification-link {
    display: flex;

    align-items: center;

    gap: 16px;

    flex: 1;

    min-width: 0;

    color: var(--notification-text);

    text-decoration: none;
}

.notification-link:focus-visible {
    outline:
        2px solid var(--notification-primary);

    outline-offset: 4px;

    border-radius: 8px;
}


/* =========================================================
   NOTIFICATION ICON
========================================================= */

.notification-icon {
    width: 52px;
    height: 52px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 14px;

    background:
        linear-gradient(
            135deg,
            var(--notification-primary),
            var(--notification-primary-dark)
        );

    color: white;

    font-size: 21px;

    box-shadow:
        0 6px 15px rgba(37, 99, 235, 0.25);
}


/* =========================================================
   NOTIFICATION CONTENT
========================================================= */

.notification-content {
    flex: 1;

    min-width: 0;
}

.notification-title {
    overflow: hidden;

    color: var(--notification-text);

    font-size: 15px;
    font-weight: 700;

    text-overflow: ellipsis;
    white-space: nowrap;
}

.notification-message {
    margin-top: 5px;

    overflow: hidden;

    color: var(--notification-secondary);

    font-size: 13px;
    line-height: 1.5;

    text-overflow: ellipsis;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.notification-time {
    display: flex;

    align-items: center;

    gap: 5px;

    margin-top: 7px;

    color: var(--notification-muted);

    font-size: 11px;
}

.notification-time i {
    font-size: 11px;
}


/* =========================================================
   ACTIONS
========================================================= */

.notification-actions {
    display: flex;

    align-items: center;

    gap: 10px;

    flex-shrink: 0;
}


/* =========================================================
   UNREAD DOT
========================================================= */

.unread-dot {
    width: 10px;
    height: 10px;

    flex-shrink: 0;

    border-radius: 50%;

    background: var(--notification-success);

    box-shadow:
        0 0 0 4px rgba(34, 197, 94, 0.12);
}


/* =========================================================
   DELETE BUTTON
========================================================= */

.delete-notification-btn {
    width: 36px;
    height: 36px;

    display: flex;

    align-items: center;
    justify-content: center;

    border: none;
    border-radius: 9px;

    background:
        rgba(239, 68, 68, 0.12);

    color: #f87171;

    font-size: 15px;

    cursor: pointer;

    transition:
        background 0.2s ease,
        color 0.2s ease,
        transform 0.2s ease;
}

.delete-notification-btn:hover {
    background: var(--notification-danger);

    color: white;

    transform: translateY(-1px);
}

.delete-notification-btn:focus-visible {
    outline:
        2px solid #f87171;

    outline-offset: 2px;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.notifications-empty {
    display: flex;

    align-items: center;
    justify-content: center;

    flex-direction: column;

    min-height: 300px;

    padding: 60px 20px;

    text-align: center;

    color: var(--notification-muted);
}

.notifications-empty-icon {
    width: 80px;
    height: 80px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-bottom: 18px;

    border-radius: 50%;

    background:
        rgba(59, 130, 246, 0.1);

    color: #60a5fa;

    font-size: 38px;
}

.notifications-empty h4 {
    margin: 0 0 8px;

    color: white;

    font-size: 18px;
    font-weight: 700;
}

.notifications-empty p {
    max-width: 450px;

    margin: 0;

    color: var(--notification-muted);

    font-size: 13px;

    line-height: 1.6;
}


/* =========================================================
   PAGINATION
========================================================= */

.notifications-pagination {
    margin-top: 20px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .notifications-container {
        padding: 15px;
    }

    .notifications-header {
        align-items: stretch;

        flex-direction: column;
    }

    .notifications-title {
        font-size: 21px;
    }

    .mark-all-btn {
        width: 100%;
    }

    .notification-item {
        align-items: flex-start;

        padding: 16px;

        gap: 12px;
    }

    .notification-link {
        align-items: flex-start;

        gap: 12px;
    }

    .notification-icon {
        width: 46px;
        height: 46px;

        border-radius: 12px;

        font-size: 18px;
    }

    .notification-actions {
        align-self: center;
    }

}


@media (max-width: 480px) {

    .notifications-container {
        padding: 10px;
    }

    .notification-item {
        flex-wrap: wrap;
    }

    .notification-link {
        width: 100%;
    }

    .notification-actions {
        width: 100%;

        justify-content: flex-end;
    }

    .notification-title {
        font-size: 14px;
    }

    .notification-message {
        font-size: 12px;
    }

    .notifications-empty {
        min-height: 250px;

        padding: 40px 15px;
    }

}

</style>


{{-- =========================================================
     NOTIFICATIONS PAGE
========================================================= --}}

<div class="notifications-container">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="notifications-header">

        <h3 class="notifications-title">

            Notifications

            <span class="notification-count">
                {{ auth()->user()->unreadNotifications()->count() }}
            </span>

        </h3>


        <form
            action="{{ route('superadmin.notifications.markAllRead') }}"
            method="POST"
            class="mark-all-form"
        >

            @csrf

            <button
                type="submit"
                class="mark-all-btn"
            >

                <i class="bi bi-check2-all"></i>

                Mark All Read

            </button>

        </form>

    </div>


    {{-- =====================================================
         NOTIFICATIONS
    ====================================================== --}}

    <div class="notifications-card">

        @forelse($notifications as $notification)

            @php

                $title =
                    strtolower(
                        $notification->data['title'] ?? ''
                    );

            @endphp


            <div
                class="notification-item
                {{ !$notification->read_at ? 'unread' : '' }}"
            >


                {{-- NOTIFICATION LINK --}}

                <a
                    href="{{ route(
                        'superadmin.notifications.show',
                        $notification->id
                    ) }}"
                    class="notification-link"
                >


                    {{-- ICON --}}

                    <div class="notification-icon">

                        @if(str_contains($title, 'complaint'))

                            <i class="bi bi-exclamation-triangle-fill"></i>

                        @elseif(str_contains($title, 'verification'))

                            <i class="bi bi-patch-check-fill"></i>

                        @elseif(str_contains($title, 'deployment'))

                            <i class="bi bi-ship"></i>

                        @elseif(str_contains($title, 'report'))

                            <i class="bi bi-file-earmark-bar-graph-fill"></i>

                        @else

                            <i class="bi bi-bell-fill"></i>

                        @endif

                    </div>


                    {{-- CONTENT --}}

                    <div class="notification-content">

                        <div class="notification-title">

                            {{ $notification->data['title'] ?? 'Notification' }}

                        </div>


                        <div class="notification-message">

                            {{ $notification->data['message'] ?? '' }}

                        </div>


                        <div class="notification-time">

                            <i class="bi bi-clock"></i>

                            {{ $notification->created_at->diffForHumans() }}

                        </div>

                    </div>

                </a>


                {{-- ACTIONS --}}

                <div class="notification-actions">


                    @if(!$notification->read_at)

                        <span
                            class="unread-dot"
                            title="Unread"
                        ></span>

                    @endif


                    <form
                        action="{{ route(
                            'superadmin.notifications.delete',
                            $notification->id
                        ) }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="delete-notification-btn"
                            title="Delete notification"
                        >

                            <i class="bi bi-trash"></i>

                        </button>

                    </form>

                </div>

            </div>

        @empty


            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <div class="notifications-empty">

                <div class="notifications-empty-icon">

                    <i class="bi bi-bell-slash"></i>

                </div>


                <h4>
                    No Notifications
                </h4>


                <p>
                    New complaints, reports, deployments,
                    and system alerts will appear here.
                </p>

            </div>

        @endforelse

    </div>


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}

    @if($notifications->hasPages())

        <div class="notifications-pagination">

            {{ $notifications->links() }}

        </div>

    @endif

</div>

@endsection