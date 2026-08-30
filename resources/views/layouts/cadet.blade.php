<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
])
    
    <title>Cadet Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Inter',sans-serif;
            background:#081120;
            min-height:100vh;
            overflow-x:hidden;
            color:white;
        }

        .cadet-wrapper{
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR */

        .sidebar{
            width:260px;
            background:linear-gradient(180deg,#07162d 0%, #0d2347 100%);
            position:fixed;
            top:0;
            left:0;
            height:100vh;
            z-index:900;
            transition:0.3s ease;
            overflow-y:auto;
        }

        .sidebar-close{
            display:none;
            position:absolute;
            top:15px;
            right:15px;
            width:40px;
            height:40px;
            border:none;
            border-radius:50%;
            background:rgba(255,255,255,.12);
            color:#fff;
            font-size:20px;
            cursor:pointer;
            transition:.3s;
            z-index:1001;
        }

        .sidebar-close:hover{
            background:#ef4444;
        }

        .sidebar-header{
            padding:25px 20px;
            border-bottom:1px solid rgba(255,255,255,0.08);
            display:flex;
            align-items:center;
            gap:15px;
        }

        .sidebar-logo{
            width:52px;
            height:52px;
            border-radius:50%;
            object-fit:cover;
            border:2px solid rgba(255,255,255,0.15);
        }

        .sidebar-title{
            color:white;
            font-size:15px;
            font-weight:700;
            line-height:1.4;
        }

        .sidebar-menu{
            padding:15px 0;
        }

        .menu-item{
            display:flex;
            align-items:center;
            gap:14px;
            padding:14px 22px;
            color:rgba(255,255,255,0.72);
            text-decoration:none;
            transition:0.25s ease;
            position:relative;
            font-size:15px;
            font-weight:500;
        }

        .menu-item svg{
            width:22px;
            height:22px;
            flex-shrink:0;
        }

        .menu-item:hover,
        .menu-item.active{
            background:rgba(59,130,246,0.16);
            color:white;
            border-left:4px solid #3b82f6;
        }

        .menu-divider{
            margin:15px 20px;
            border-top:1px solid rgba(255,255,255,0.08);
        }

        /* MAIN */

        .main-content{
            margin-left:260px;
            flex:1;
            min-height:100vh;
        }

        /* TOPBAR */

        .topbar{
            background:#0f1f3d;
            padding:18px 28px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            position:sticky;
            top:0;
            z-index:100;
            box-shadow:0 2px 10px rgba(0,0,0,0.2);
        }

        .top-left{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .page-title{
            font-size:24px;
            font-weight:700;
        }

        .top-right{
            display:flex;
            align-items:center;
            gap:16px;
        }

        /* MOBILE BUTTON */

.mobile-btn{
    display:none;
    width:44px;
    height:44px;
    background:#162b52;
    border:none;
    border-radius:10px;
    cursor:pointer;
    position:relative;
}

.mobile-btn span{
    position:absolute;
    left:10px;
    width:24px;
    height:3px;
    background:#fff;
    border-radius:3px;
    transition:.3s;
}

.mobile-btn span:nth-child(1){
    top:13px;
}

.mobile-btn span:nth-child(2){
    top:20px;
}

.mobile-btn span:nth-child(3){
    top:27px;
}

/* OPEN */

.mobile-btn.active span:nth-child(1){
    top:20px;
    transform:rotate(45deg);
}

.mobile-btn.active span:nth-child(2){
    opacity:0;
}

.mobile-btn.active span:nth-child(3){
    top:20px;
    transform:rotate(-45deg);
}


        /* ICONS */

        .icon-btn{
            width:44px;
            height:44px;
            border-radius:50%;
            background:#162b52;
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
            color:white;
            position:relative;
            transition:0.2s ease;
        }

        .icon-btn:hover{
            background:#1d3b72;
            transform:translateY(-2px);
        }

        .badge{
            position:absolute;
            top:-3px;
            right:-3px;
            background:red;
            width:18px;
            height:18px;
            border-radius:50%;
            font-size:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            font-weight:600;
        }

        /* =========================================================
   NOTIFICATION DROPDOWN
========================================================= */

.notification-area {
    position: relative;
}


.notification-btn {
    border: none;
    cursor: pointer;
    padding: 0;
}


.notification-dropdown {

    position: absolute;

    top: 56px;
    right: 0;

    width: 380px;
    max-width: calc(100vw - 24px);

    background: #10203e;

    border: 1px solid rgba(255,255,255,.08);

    border-radius: 16px;

    box-shadow:
        0 20px 50px rgba(0,0,0,.45);

    overflow: hidden;

    display: none;

    z-index: 2000;

    animation: notificationDropdownFade .2s ease;

}


.notification-dropdown.show {
    display: block;
}


@keyframes notificationDropdownFade {

    from {

        opacity: 0;

        transform: translateY(-8px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


/* HEADER */

.notification-dropdown-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 18px;

    border-bottom: 1px solid rgba(255,255,255,.08);

}


.notification-dropdown-header h3 {

    margin: 0;

    color: #fff;

    font-size: 17px;

    font-weight: 700;

}


.notification-dropdown-header span {

    display: block;

    margin-top: 4px;

    color: #94a3b8;

    font-size: 12px;

}


.notification-dropdown-header a {

    color: #60a5fa;

    text-decoration: none;

    font-size: 12px;

    font-weight: 600;

}


.notification-dropdown-header a:hover {

    color: #93c5fd;

}


/* LIST */

.notification-list {

    max-height: 420px;

    overflow-y: auto;

}


/* ITEM */

.notification-item {

    position: relative;

    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 15px 18px;

    border-bottom: 1px solid rgba(255,255,255,.05);

    cursor: pointer;

    transition: background .2s ease;

}


.notification-item:hover {

    background: rgba(59,130,246,.10);

}


.notification-item.unread {

    background: rgba(59,130,246,.07);

}


.notification-item.unread:hover {

    background: rgba(59,130,246,.13);

}


/* ICON */

.notification-item-icon {

    width: 38px;

    height: 38px;

    min-width: 38px;

    border-radius: 50%;

    background: rgba(59,130,246,.15);

    color: #60a5fa;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 14px;

}


/* CONTENT */

.notification-item-content {

    min-width: 0;

    flex: 1;

}


.notification-item-title {

    color: #fff;

    font-size: 13px;

    font-weight: 700;

    margin-bottom: 4px;

}


.notification-item-message {

    color: #cbd5e1;

    font-size: 12px;

    line-height: 1.5;

    word-break: break-word;

}


.notification-item-time {

    color: #64748b;

    font-size: 11px;

    margin-top: 6px;

}


/* UNREAD DOT */

.notification-unread-dot {

    width: 8px;

    height: 8px;

    min-width: 8px;

    border-radius: 50%;

    background: #3b82f6;

    margin-top: 7px;

}


/* EMPTY */

.notification-empty {

    padding: 45px 20px;

    text-align: center;

    color: #64748b;

}


.notification-empty i {

    font-size: 35px;

    margin-bottom: 12px;

}


.notification-empty p {

    margin: 0;

    font-size: 13px;

}


/* FOOTER */

.notification-dropdown-footer {

    border-top: 1px solid rgba(255,255,255,.08);

    padding: 12px;

    text-align: center;

}


.notification-dropdown-footer a {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    color: #60a5fa;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

}


.notification-dropdown-footer a:hover {

    color: #93c5fd;

}


/* SCROLLBAR */

.notification-list::-webkit-scrollbar {

    width: 5px;

}


.notification-list::-webkit-scrollbar-track {

    background: transparent;

}


.notification-list::-webkit-scrollbar-thumb {

    background: #334155;

    border-radius: 10px;

}


/* MOBILE */

@media (max-width: 480px) {

    .notification-dropdown {

        position: fixed;

        top: 62px;

        right: 8px;

        width: calc(100vw - 16px);

        max-width: none;

    }

}

        /* PROFILE */

        .profile-area{
            display:flex;
            align-items:center;
            gap:12px;
            cursor:pointer;
            position:relative;
        }

        .profile-avatar{
            width:45px;
            height:45px;
            border-radius:50%;
            background:linear-gradient(135deg,#3b82f6,#2563eb);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:18px;
            color:white;
        }

        .profile-info{
            display:flex;
            flex-direction:column;
        }

        .profile-name{
            font-size:15px;
            font-weight:700;
            color:#ffffff;
        }

        .profile-role{
            font-size:12px;
            color:#94a3b8;
        }

        /* DROPDOWN */

.dropdown{
    position:absolute;
    top:70px;
    right:0;
    width:260px;
    background:#10203e;
    border-radius:18px;
    overflow:hidden;
    display:none;
    box-shadow:0 15px 40px rgba(0,0,0,0.35);
    border:1px solid rgba(255,255,255,0.08);
    animation:dropdownFade .25s ease;
    z-index:999;
}

.dropdown.show{
    display:block;
}

@keyframes dropdownFade{
    from{
        opacity:0;
        transform:translateY(-10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.dropdown-profile-card {
    padding: 20px;
    text-align: center;

    background:
        linear-gradient(
            135deg,
            #1d3b72,
            #10203e
        );
}

.dropdown-profile-card img {
    width: 70px;
    height: 70px;

    border-radius: 50%;

    object-fit: cover;

    border: 3px solid rgba(255,255,255,.2);

    margin-bottom: 10px;
}

.dropdown-profile-card h4 {
    margin: 0;

    color: #fff;

    font-size: 16px;
}

.dropdown-profile-card p {
    margin-top: 5px;

    color: #94a3b8;

    font-size: 13px;
}

.dropdown-divider{
    height:1px;
    background:rgba(255,255,255,0.08);
}

.dropdown a,
.dropdown button{
    display:flex;
    align-items:center;
    gap:10px;
    width:100%;
    padding:14px 18px;
    border:none;
    background:none;
    color:white;
    text-decoration:none;
    font-size:14px;
    transition:.2s;
}

.dropdown a:hover,
.dropdown button:hover{
    background:#1b3566;
}

.logout-btn{
    color:#ff6b6b !important;
}

.topbar-profile-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    overflow: hidden;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.topbar-profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

        /* PAGE CONTENT */

        .page-content{
            padding:28px;
        }

/* =========================================================
   RESPONSIVE LAYOUT
========================================================= */

@media (max-width: 1024px) {

    /* SIDEBAR */

    .sidebar {
        width: 280px;
        transform: translateX(-100%);
        box-shadow: 15px 0 40px rgba(0,0,0,.35);
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .sidebar-close {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* MAIN */

    .main-content {
        width: 100%;
        margin-left: 0;
        min-width: 0;
    }

    /* MOBILE BUTTON */

    .mobile-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* PROFILE */

    .profile-info {
        display: none;
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 768px) {

    .topbar {
        width: 100%;
        padding: 12px 16px;
        gap: 10px;
    }

    .top-left {
        min-width: 0;
        flex: 1;
        gap: 10px;
    }

    .page-title {
        min-width: 0;

        font-size: 18px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .top-right {
        flex-shrink: 0;
        gap: 8px;
    }

    .icon-btn {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
    }

    .topbar-profile-avatar {
        width: 40px;
        height: 40px;
    }

    .page-content {
        width: 100%;
        padding: 16px;
        min-width: 0;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 480px) {

    .topbar {
        padding: 10px 12px;
    }

    .top-left {
        gap: 8px;
    }

    .mobile-btn {
        width: 40px;
        height: 40px;
        border-radius: 9px;
    }

    .mobile-btn span {
        left: 9px;
        width: 22px;
    }

    .page-title {
        font-size: 15px;
    }

    .top-right {
        gap: 6px;
    }

    .icon-btn {
        width: 38px;
        height: 38px;
    }

    .topbar-profile-avatar {
        width: 38px;
        height: 38px;
    }

    .page-content {
        padding: 8px;
    }

    .dropdown {
        position: fixed;

        top: 62px;
        right: 8px;

        width: min(280px, calc(100vw - 16px));
    }

}


/* =========================================================
   VERY SMALL PHONES
========================================================= */

@media (max-width: 360px) {

    .topbar {
        padding: 8px;
    }

    .mobile-btn {
        width: 36px;
        height: 36px;
    }

    .mobile-btn span {
        left: 8px;
        width: 20px;
    }

    .page-title {
        font-size: 13px;
    }

    .icon-btn {
        width: 36px;
        height: 36px;
    }

    .topbar-profile-avatar {
        width: 36px;
        height: 36px;
    }

    .page-content {
        padding: 5px;
    }

}
    </style>
</head>

<body>

<div class="cadet-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <button class="sidebar-close" onclick="closeSidebar()">
            ☰
        </button>

        <div class="sidebar-header">

            <img src="{{ asset('images/MMACI Logo.jpg') }}"
                 class="sidebar-logo">

            <div class="sidebar-title">
                Cadet Training<br>
                Management System
            </div>

        </div>

        <nav class="sidebar-menu">

            <a href="{{ route('dashboard') }}"
               class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M3 13H11V3H3V13Z"
                        stroke="currentColor" stroke-width="2"/>
                    <path d="M13 21H21V11H13V21Z"
                        stroke="currentColor" stroke-width="2"/>
                    <path d="M13 3H21V9H13V3Z"
                        stroke="currentColor" stroke-width="2"/>
                    <path d="M3 21H11V15H3V21Z"
                        stroke="currentColor" stroke-width="2"/>
                </svg>

                <span>Dashboard</span>
            </a>

            <a href="{{ route('cadet.deployment') }}"
               class="menu-item {{ request()->routeIs('cadet.deployment') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L19 7V17L12 22L5 17V7L12 2Z"
                        stroke="currentColor" stroke-width="2"/>
                    <path d="M12 22V12"
                        stroke="currentColor" stroke-width="2"/>
                    <path d="M19 7L12 12L5 7"
                        stroke="currentColor" stroke-width="2"/>
                </svg>

                <span>Deployment</span>
            </a>

            <a href="{{ route('cadet.requirements') }}"
               class="menu-item {{ request()->routeIs('cadet.requirements') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z"
                        stroke="currentColor" stroke-width="2"/>
                    <path d="M14 2V8H20"
                        stroke="currentColor" stroke-width="2"/>
                </svg>

                <span>Before OBTRequirements</span>
            </a>

            <a href="{{ route('cadet.onboard.requirements') }}"
            class="menu-item {{ request()->routeIs('cadet.onboard.requirements') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2"/>
                    <path d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"
                        stroke="currentColor"
                        stroke-width="2"/>
                </svg>

                <span>During OBT Requirements</span>
            </a>

            <a href="{{ route('cadet.bs.requirements') }}"
                 class="menu-item {{ request()->routeIs('cadet.bs.requirements') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 3L2 9L12 15L22 9L12 3Z"
                        stroke="currentColor"
                        stroke-width="2"/>

                    <path d="M5 11V16L12 20L19 16V11"
                        stroke="currentColor"
                        stroke-width="2"/>

                    <path d="M9 12L12 14L15 12"
                        stroke="currentColor"
                        stroke-width="2"/>
                </svg>

                <span>After OBT Requirements</span>

            </a>

            <a href="{{ route('cadet.complaints') }}"
               class="menu-item {{ request()->routeIs('cadet.complaints') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
                        stroke="currentColor" stroke-width="2"/>
                </svg>

                <span>Concern</span>
            </a>

            <a href="{{ route('chat.index') }}"
               class="menu-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
                        stroke="currentColor" stroke-width="2"/>
                </svg>

                <span>Chat</span>
            </a>

            <div class="menu-divider"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="menu-item"
                        style="width:100%;border:none;background:none;">

                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                            stroke="currentColor" stroke-width="2"/>
                        <path d="M16 17L21 12L16 7"
                            stroke="currentColor" stroke-width="2"/>
                        <path d="M21 12H9"
                            stroke="currentColor" stroke-width="2"/>
                    </svg>

                    <span>Logout</span>

                </button>
            </form>

        </nav>

    </aside>

    <!-- MAIN -->
    <main class="main-content">

        <!-- TOPBAR -->

        <header class="topbar">

            <div class="top-left">

            <button class="mobile-btn" id="menuBtn" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </button>

                <h1 class="page-title">
                    Cadet Dashboard
                </h1>

            </div>

            <div class="top-right">

                <!-- NOTIFICATION -->
<!-- NOTIFICATION -->
<div class="notification-area">

    <button
        type="button"
        class="icon-btn notification-btn"
        id="cadetNotificationBell"
        onclick="toggleNotificationDropdown(event)"
    >

        🔔

        <div
            class="badge"
            id="cadetNotificationBadge"
            style="{{ ($unreadNotificationsCount ?? 0) > 0 ? '' : 'display:none;' }}"
        >
            {{ $unreadNotificationsCount ?? 0 }}
        </div>

    </button>


    <!-- NOTIFICATION DROPDOWN -->
    <div
        class="notification-dropdown"
        id="cadetNotificationDropdown"
    >

        <div class="notification-dropdown-header">

            <div>
                <h3>Notifications</h3>

                <span id="notificationUnreadText">
                    {{ ($unreadNotificationsCount ?? 0) > 0
                        ? $unreadNotificationsCount . ' unread'
                        : 'No new notifications'
                    }}
                </span>
            </div>

            <a href="{{ route('cadet.notifications') }}">
                View All
            </a>

        </div>


        <div
            class="notification-list"
            id="cadetNotificationList"
        >

            @if(isset($notifications) && $notifications->count())

                @foreach($notifications as $notification)

                    <div
                        class="notification-item {{ empty($notification->read_at) ? 'unread' : '' }}"
                        data-notification-id="{{ $notification->id }}"
                        data-url="{{ $notification->data['url'] ?? '' }}"
                        onclick="handleNotificationClick(this)"
                    >

                        <div class="notification-item-icon">

                            @if(
                                isset($notification->data['status'])
                                && $notification->data['status'] === 'Approved'
                            )

                                <i class="fas fa-check"></i>

                            @elseif(
                                isset($notification->data['status'])
                                && $notification->data['status'] === 'Rejected'
                            )

                                <i class="fas fa-times"></i>

                            @else

                                <i class="fas fa-bell"></i>

                            @endif

                        </div>


                        <div class="notification-item-content">

                            <div class="notification-item-title">

                                {{ $notification->data['title']
                                    ?? 'Notification'
                                }}

                            </div>


                            <div class="notification-item-message">

                                {{ $notification->data['message']
                                    ?? $notification->data['body']
                                    ?? 'You have a new notification.'
                                }}

                            </div>


                            <div class="notification-item-time">

                                {{ $notification->created_at?->diffForHumans() }}

                            </div>

                        </div>


                        @if(empty($notification->read_at))

                            <span class="notification-unread-dot"></span>

                        @endif

                    </div>

                @endforeach

            @else

                <div
                    class="notification-empty"
                    id="notificationEmpty"
                >

                    <i class="far fa-bell-slash"></i>

                    <p>No notifications yet.</p>

                </div>

            @endif

        </div>


        <div class="notification-dropdown-footer">

            <a href="{{ route('cadet.notifications') }}">
                <i class="fas fa-list"></i>
                See all notifications
            </a>

        </div>

    </div>

</div>

                <!-- PROFILE -->
                <div class="profile-area" onclick="toggleDropdown()">
                                    <div class="topbar-profile-avatar">
                                            <img
                                                src="{{ Auth::user()->profile_picture
                                                    ? asset('storage/' . Auth::user()->profile_picture) . '?v=' . (Auth::user()->updated_at?->timestamp ?? time())
                                                    : asset('images/default-avatar.png') }}"
                                                alt="Profile Photo"
                                                onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';">
                                    </div>
                                        

                    <div class="profile-info">
                        <div class="profile-name">
                            {{ auth()->user()->name ?? 'Cadet' }}
                        </div>

                        <div class="profile-role">
                            Cadet
                        </div>
                    </div>

                    <div class="dropdown" id="dropdownMenu">

                                    <div class="dropdown-profile-card">
                                        <img
                                            src="{{ Auth::user()->profile_picture
                                                ? asset('storage/' . Auth::user()->profile_picture) . '?v=' . (Auth::user()->updated_at?->timestamp ?? time())
                                                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                            alt="Profile Photo">

                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p>Cadet</p>
                                    </div>

                        <div class="dropdown-divider"></div>

                        <a href="{{ route('cadet.profile') }}">
                            👤 My Profile
                        </a>

                        <a href="{{ route('cadet.notifications') }}">
                            🔔 Notifications
                        </a>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="logout-btn">
                                ⏻ Logout
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </header>

        <!-- PAGE CONTENT -->

        <div class="page-content">

            @yield('content')

        </div>

    </main>

</div>

@if(auth()->user()->cadet && auth()->user()->cadet->deployment)

<script>

function sendCadetLocation(){

    if(!navigator.geolocation){
        console.log("Geolocation not supported");
        return;
    }


    navigator.geolocation.getCurrentPosition(function(position){


        fetch("{{ route('cadet.update.location') }}",{

            method:"POST",

            headers:{

                "Content-Type":"application/json",

                "Accept":"application/json",

                "X-CSRF-TOKEN":document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')

            },


            body:JSON.stringify({

                latitude: position.coords.latitude,

                longitude: position.coords.longitude

            })


        })
        .then(response=>{

            console.log(
                "Location status:",
                response.status
            );

        })
        .catch(error=>{

            console.error(
                "Location Error:",
                error
            );

        });


    });


}


sendCadetLocation();


setInterval(
    sendCadetLocation,
    10000
);


</script>

@endif

<script>

function toggleSidebar(){

    const sidebar = document.getElementById('sidebar');
    const button = document.getElementById('menuBtn');

    sidebar.classList.toggle('open');
    button.classList.toggle('active');

}

function closeSidebar(){

    document.getElementById('sidebar')
            .classList.remove('open');

    document.getElementById('menuBtn')
            .classList.remove('active');
}

window.addEventListener('click', function(e){

    const sidebar = document.getElementById('sidebar');
    const button = document.getElementById('menuBtn');

    if(
        window.innerWidth <= 1024 &&
        sidebar.classList.contains('open') &&
        !sidebar.contains(e.target) &&
        !button.contains(e.target)
    ){
        sidebar.classList.remove('open');
        button.classList.remove('active');
    }

});

function toggleDropdown(){
    document.getElementById('dropdownMenu').classList.toggle('show');
}

window.onclick = function(e){

    if(!e.target.closest('.profile-area')){
        document.getElementById('dropdownMenu')
        .classList.remove('show');
    }

}

document.querySelectorAll('.menu-item').forEach(item=>{

    item.addEventListener('click',()=>{

        if(window.innerWidth<=1024){

            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('menuBtn').classList.remove('active');

        }

    });

});


document.querySelectorAll('.menu-item').forEach(item=>{

    item.addEventListener('click',()=>{

        if(window.innerWidth<=1024){

            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('menuBtn').classList.remove('active');

        }

    });

});
</script>

<script>

/* =========================================================
   NOTIFICATION DROPDOWN
========================================================= */

function toggleNotificationDropdown(event) {

    if (event) {
        event.stopPropagation();
    }

    const dropdown =
        document.getElementById(
            'cadetNotificationDropdown'
        );

    if (!dropdown) {
        return;
    }

    dropdown.classList.toggle('show');

}


/* =========================================================
   CLOSE NOTIFICATION DROPDOWN
========================================================= */

document.addEventListener('click', function (event) {

    const area =
        document.querySelector(
            '.notification-area'
        );

    const dropdown =
        document.getElementById(
            'cadetNotificationDropdown'
        );

    if (!area || !dropdown) {
        return;
    }

    if (!area.contains(event.target)) {

        dropdown.classList.remove('show');

    }

});


/* =========================================================
   ADD LIVE NOTIFICATION
========================================================= */

function addLiveNotification(notification) {

    const list =
        document.getElementById(
            'cadetNotificationList'
        );

    if (!list) {
        return;
    }


    /*
    |---------------------------------------------------------
    | Remove empty state
    |---------------------------------------------------------
    */

    const empty =
        document.getElementById(
            'notificationEmpty'
        );

    if (empty) {
        empty.remove();
    }


    /*
    |---------------------------------------------------------
    | Notification data
    |---------------------------------------------------------
    */

    const title =
        notification.title ||
        'Notification';


    const message =
        notification.message ||
        notification.body ||
        'You have a new notification.';


    const status = String(
        notification.status || ''
    ).toLowerCase();

    let icon = 'fa-bell';

    if (status === 'approved') {
        icon = 'fa-check';
    }
    else if (status === 'rejected') {
        icon = 'fa-times';
    }


    /*
    |---------------------------------------------------------
    | Create notification
    |---------------------------------------------------------
    */

    const item =
        document.createElement('div');

    item.className =
        'notification-item unread';

    item.dataset.notificationId =
        notification.id || '';

    item.dataset.url =
        notification.url || '';

    item.onclick = function () {
        handleNotificationClick(this);
    };


    item.innerHTML = `

        <div class="notification-item-icon">

            <i class="fas ${icon}"></i>

        </div>


        <div class="notification-item-content">

            <div class="notification-item-title">

                ${escapeNotificationHtml(title)}

            </div>


            <div class="notification-item-message">

                ${escapeNotificationHtml(message)}

            </div>


            <div class="notification-item-time">

                Just now

            </div>

        </div>


        <span class="notification-unread-dot"></span>

    `;


    /*
    |---------------------------------------------------------
    | Put newest notification first
    |---------------------------------------------------------
    */

    list.prepend(item);


    /*
    |---------------------------------------------------------
    | Update badge
    |---------------------------------------------------------
    */

    updateCadetNotificationBadge();


    /*
    |---------------------------------------------------------
    | Update unread text
    |---------------------------------------------------------
    */

    updateUnreadText();

}


/* =========================================================
   UPDATE BADGE
========================================================= */

function updateCadetNotificationBadge() {

    const badge =
        document.getElementById(
            'cadetNotificationBadge'
        );

    if (!badge) {
        return;
    }


    const current =
        parseInt(
            badge.textContent.trim()
        ) || 0;


    const newCount =
        current + 1;


    badge.textContent =
        newCount;


    badge.style.display =
        'flex';


    /*
    |---------------------------------------------------------
    | Animation
    |---------------------------------------------------------
    */

    if (badge.animate) {

        badge.animate(

            [
                {
                    transform: 'scale(1)'
                },

                {
                    transform: 'scale(1.35)'
                },

                {
                    transform: 'scale(1)'
                }

            ],

            {
                duration: 350
            }

        );

    }

}

function handleNotificationClick(element) {

    const notificationId =
        element.dataset.notificationId;

    const url =
        element.dataset.url;

    // Mark notification as read
    if (notificationId) {

        fetch(`/cadet/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
            }
        }).catch(error => {
            console.error(
                'Notification read error:',
                error
            );
        });
    }

    // Navigate to notification destination
    if (url) {
        window.location.href = url;
    }
}


/* =========================================================
   UPDATE UNREAD TEXT
========================================================= */

function updateUnreadText() {

    const badge =
        document.getElementById(
            'cadetNotificationBadge'
        );

    const text =
        document.getElementById(
            'notificationUnreadText'
        );

    if (!badge || !text) {
        return;
    }


    const count =
        parseInt(
            badge.textContent.trim()
        ) || 0;


    if (count > 0) {

        text.textContent =
            `${count} unread`;

    }

    else {

        text.textContent =
            'No new notifications';

    }

}


/* =========================================================
   ESCAPE NOTIFICATION HTML
========================================================= */

function escapeNotificationHtml(value) {

    if (
        value === null ||
        value === undefined
    ) {

        return '';

    }


    return String(value)

        .replace(/&/g, '&amp;')

        .replace(/</g, '&lt;')

        .replace(/>/g, '&gt;')

        .replace(/"/g, '&quot;')

        .replace(/'/g, '&#039;');

}


/* =========================================================
   LARAVEL ECHO
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        if (
            typeof window.Echo === 'undefined'
        ) {

            console.error(
                'Laravel Echo is not loaded.'
            );

            return;

        }


        const userId =
            document
                .querySelector(
                    'meta[name="user-id"]'
                )
                ?.getAttribute('content');


        if (!userId) {

            console.error(
                'Cadet user ID not found.'
            );

            return;

        }


        console.log(
            'Cadet notification listener started.'
        );


        console.log(
            'Listening for user:',
            userId
        );


        /*
        |---------------------------------------------------------
        | PRIVATE USER NOTIFICATION CHANNEL
        |---------------------------------------------------------
        */

        window.Echo
            .private(`App.Models.User.${userId}`)

            .notification(
                function (notification) {

                    console.log(
                        '🔔 New cadet notification:',
                        notification
                    );


                    /*
                    |-------------------------------------------------
                    | Add notification to dropdown
                    |-------------------------------------------------
                    */

                    addLiveNotification(
                        notification
                    );

                }
            );

    }
);

</script>
</body>
</html>