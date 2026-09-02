<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="user-id"
        content="{{ auth()->id() }}"
    >

    <title>Admin Panel</title>


    {{-- =====================================================
         GOOGLE FONT
    ====================================================== --}}

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    {{-- =====================================================
         FONT AWESOME
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css"
    >


    {{-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >


    {{-- =====================================================
         VITE
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>
/* =========================================================
   PREMIUM UI ENHANCEMENT
   SAFE OVERRIDE ONLY
   Does not modify Blade / routes / JavaScript
========================================================= */

/* =========================================================
   GLOBAL VISUAL POLISH
========================================================= */

html {
    scroll-behavior: smooth;
}

body {
    background:
        radial-gradient(
            circle at 10% 0%,
            rgba(37, 99, 235, 0.08),
            transparent 30%
        ),
        #0f172a;
}

/* =========================================================
   SIDEBAR ENHANCEMENT
========================================================= */

.sidebar {
    background:
        linear-gradient(
            180deg,
            #18233f 0%,
            #0b1838 45%,
            #061331 100%
        );

    border-right:
        1px solid
        rgba(255, 255, 255, 0.06);

    box-shadow:
        8px 0 35px rgba(0, 0, 0, 0.20);

    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
}

/* Subtle sidebar glow */
.sidebar::before {
    content: "";
    position: absolute;
    top: -100px;
    left: -100px;

    width: 260px;
    height: 260px;

    background:
        radial-gradient(
            circle,
            rgba(59, 130, 246, 0.18),
            transparent 70%
        );

    pointer-events: none;
}

/* =========================================================
   LOGO AREA
========================================================= */

.logo-section {
    position: relative;

    padding: 28px 18px 24px;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.07);
}

.logo-section img {
    width: 108px;
    height: 108px;

    border: 4px solid rgba(255, 255, 255, 0.10);

    box-shadow:
        0 12px 35px rgba(0, 0, 0, 0.35);

    transition:
        transform .3s ease,
        box-shadow .3s ease;
}

.logo-section img:hover {
    transform: scale(1.04);

    box-shadow:
        0 16px 40px rgba(37, 99, 235, 0.28);
}

.logo-section h2 {
    margin-top: 2px;

    font-size: 18px;
    font-weight: 700;
    letter-spacing: -0.02em;
}

.logo-section p {
    margin-top: 7px;

    color: #94a3b8;

    font-size: 12px;
    line-height: 1.5;
}

/* =========================================================
   SIDEBAR MENU
========================================================= */

.sidebar-menu {
    padding: 18px 14px 18px;
}

.sidebar a,
.menu-item {
    position: relative;

    border:
        1px solid
        transparent;

    transition:
        background .22s ease,
        border-color .22s ease,
        transform .22s ease,
        box-shadow .22s ease,
        color .22s ease;
}

.sidebar a:hover,
.menu-item:hover {
    background:
        rgba(255, 255, 255, 0.065);

    border-color:
        rgba(255, 255, 255, 0.055);

    transform: translateX(3px);

    box-shadow:
        0 5px 18px rgba(0, 0, 0, 0.10);
}

.sidebar a i,
.menu-item > i:first-child {
    transition:
        transform .22s ease,
        color .22s ease;
}

.sidebar a:hover i,
.menu-item:hover > i:first-child {
    transform: scale(1.08);
}

/* =========================================================
   ACTIVE MENU
========================================================= */

.sidebar a.active {
    background:
        linear-gradient(
            135deg,
            #3b82f6 0%,
            #2563eb 100%
        );

    border-color:
        rgba(147, 197, 253, 0.20);

    box-shadow:
        0 8px 25px rgba(37, 99, 235, 0.28),
        inset 0 1px 0 rgba(255, 255, 255, 0.10);
}

.sidebar a.active::before {
    content: "";

    position: absolute;

    left: -14px;
    top: 8px;
    bottom: 8px;

    width: 3px;

    border-radius: 0 5px 5px 0;

    background: #60a5fa;
}

/* =========================================================
   OBT PARENT MENU
========================================================= */

.menu-item.active-parent {
    background:
        linear-gradient(
            90deg,
            rgba(59, 130, 246, 0.15),
            rgba(59, 130, 246, 0.04)
        );

    border-color:
        rgba(59, 130, 246, 0.12);
}

.menu-item.active-parent > i:first-child {
    color: #60a5fa;
}

/* =========================================================
   SUBMENU
========================================================= */

.submenu {
    margin-top: 4px;

    border-left:
        2px solid
        rgba(96, 165, 250, 0.18);
}

.menu-sub-item {
    position: relative;
}

.menu-sub-item.active {
    background:
        linear-gradient(
            90deg,
            #2563eb,
            #1d4ed8
        ) !important;

    box-shadow:
        0 6px 18px rgba(37, 99, 235, 0.22);
}

.menu-sub-item.active::before {
    content: "";

    position: absolute;

    left: -14px;
    top: 8px;
    bottom: 8px;

    width: 2px;

    background: #60a5fa;

    border-radius: 4px;
}

/* =========================================================
   LOGOUT
========================================================= */

.logout-form {
    padding: 12px 14px 18px;
}

.logout-btn {
    position: relative;

    background:
        linear-gradient(
            135deg,
            #ef4444 0%,
            #dc2626 100%
        );

    border:
        1px solid
        rgba(255, 255, 255, 0.08);

    box-shadow:
        0 8px 20px rgba(220, 38, 38, 0.16);

    transition:
        transform .22s ease,
        box-shadow .22s ease,
        filter .22s ease;
}

.logout-btn:hover {
    transform: translateY(-2px);

    filter: brightness(1.04);

    box-shadow:
        0 12px 28px rgba(220, 38, 38, 0.28);
}

.logout-btn:active {
    transform: translateY(0);
}

/* =========================================================
   TOPBAR
========================================================= */

.topbar {
    height: 76px;

    background:
        rgba(15, 23, 42, 0.88);

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.06);

    box-shadow:
        0 8px 30px rgba(0, 0, 0, 0.16);

    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
}

.system-title {
    letter-spacing: -0.025em;

    text-shadow:
        0 2px 10px rgba(0, 0, 0, 0.25);
}

/* =========================================================
   MOBILE MENU BUTTON
========================================================= */

.menu-btn {
    width: 42px;
    height: 42px;

    display: none;

    align-items: center;
    justify-content: center;

    border-radius: 11px;

    background:
        rgba(255, 255, 255, 0.06);

    border:
        1px solid
        rgba(255, 255, 255, 0.07);

    transition:
        background .2s ease,
        transform .2s ease;
}

.menu-btn:hover {
    background:
        rgba(59, 130, 246, 0.18);

    transform: translateY(-1px);
}

.menu-btn:active {
    transform: scale(.96);
}

/* =========================================================
   TOPBAR ICONS
========================================================= */

.top-icon {
    width: 42px;
    height: 42px;

    border-radius: 12px;

    background:
        rgba(255, 255, 255, 0.045);

    border:
        1px solid
        rgba(255, 255, 255, 0.055);

    transition:
        background .22s ease,
        transform .22s ease,
        border-color .22s ease;
}

.top-icon:hover {
    background:
        rgba(59, 130, 246, 0.13);

    border-color:
        rgba(96, 165, 250, 0.18);

    transform: translateY(-2px);
}

.top-icon:active {
    transform: scale(.95);
}

/* =========================================================
   NOTIFICATION BADGE
========================================================= */

.badge {
    top: -3px;
    right: -3px;

    min-width: 20px;
    height: 20px;

    border:
        2px solid
        #111827;

    box-shadow:
        0 3px 10px rgba(239, 68, 68, 0.35);

    animation:
        notificationPulse 2.4s ease-in-out infinite;
}

@keyframes notificationPulse {
    0%,
    100% {
        box-shadow:
            0 3px 10px rgba(239, 68, 68, 0.30);
    }

    50% {
        box-shadow:
            0 3px 16px rgba(239, 68, 68, 0.55);
    }
}

/* =========================================================
   NOTIFICATION DROPDOWN
========================================================= */

.notif-dropdown {
    background:
        rgba(15, 23, 42, 0.97);

    border:
        1px solid
        rgba(255, 255, 255, 0.07);

    box-shadow:
        0 20px 50px rgba(0, 0, 0, 0.40);

    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);

    animation:
        dropdownIn .18s ease;
}

@keyframes dropdownIn {
    from {
        opacity: 0;
        transform: translateY(-7px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.notif-header {
    padding: 15px 16px;

    background:
        rgba(255, 255, 255, 0.025);
}

.notif-header span {
    font-size: 14px;
    font-weight: 700;
}

.notif-header a {
    padding: 5px 8px;

    border-radius: 7px;

    transition:
        background .2s ease,
        color .2s ease;
}

.notif-header a:hover {
    background:
        rgba(56, 189, 248, 0.10);
}

.notif-item {
    padding: 13px 14px;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.055);
}

.notif-item:last-child {
    border-bottom: none;
}

.notif-item:hover {
    background:
        rgba(255, 255, 255, 0.055);
}

.notif-icon {
    border:
        1px solid
        rgba(255, 255, 255, 0.06);

    box-shadow:
        0 4px 12px rgba(0, 0, 0, 0.15);
}

.notif-unread {
    background:
        linear-gradient(
            90deg,
            rgba(56, 189, 248, 0.10),
            rgba(56, 189, 248, 0.035)
        );

    border-left:
        3px solid
        rgba(56, 189, 248, 0.75);
}

/* =========================================================
   PROFILE
========================================================= */

.profile-btn {
    padding: 4px 6px 4px 4px;

    border-radius: 14px;

    transition:
        background .22s ease;
}

.profile-btn:hover {
    background:
        rgba(255, 255, 255, 0.055);
}

.profile-btn img {
    border:
        2px solid
        rgba(255, 255, 255, 0.85);

    box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.22);

    transition:
        border-color .2s ease,
        transform .2s ease;
}

.profile-btn:hover img {
    border-color: #60a5fa;
    transform: scale(1.03);
}

.arrow {
    color: #94a3b8;

    transition:
        transform .2s ease,
        color .2s ease;
}

.profile-btn:hover .arrow {
    color: #ffffff;
}

/* =========================================================
   PROFILE DROPDOWN
========================================================= */

.dropdown-menu {
    background:
        rgba(15, 23, 42, 0.98);

    border:
        1px solid
        rgba(255, 255, 255, 0.07);

    box-shadow:
        0 20px 45px rgba(0, 0, 0, 0.40);

    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);

    animation:
        dropdownIn .18s ease;
}

.dropdown-user {
    padding: 17px;

    background:
        linear-gradient(
            135deg,
            rgba(59, 130, 246, 0.12),
            rgba(59, 130, 246, 0.025)
        );

    font-size: 14px;
}

.dropdown-menu a {
    transition:
        background .2s ease,
        padding-left .2s ease;
}

.dropdown-menu a:hover {
    background:
        rgba(255, 255, 255, 0.055);

    padding-left: 19px;
}

.dropdown-menu a i {
    width: 20px;
    margin-right: 7px;
}

.dropdown-menu form button {
    transition:
        background .2s ease;
}

.dropdown-menu form button:hover {
    background: #b91c1c;
}

/* =========================================================
   CONTENT AREA
========================================================= */

.content {
    position: relative;

    min-height: calc(100vh - 76px);

    padding: 28px;

    background:
        radial-gradient(
            circle at 90% 10%,
            rgba(37, 99, 235, 0.055),
            transparent 25%
        );
}

/* =========================================================
   FOCUS ACCESSIBILITY
========================================================= */

a:focus-visible,
button:focus-visible,
input:focus-visible,
select:focus-visible,
textarea:focus-visible {
    outline:
        2px solid
        #60a5fa;

    outline-offset: 2px;
}

/* =========================================================
   SCROLLBARS
========================================================= */

* {
    scrollbar-width: thin;
    scrollbar-color:
        rgba(148, 163, 184, 0.35)
        transparent;
}

*::-webkit-scrollbar {
    width: 7px;
    height: 7px;
}

*::-webkit-scrollbar-track {
    background: transparent;
}

*::-webkit-scrollbar-thumb {
    background:
        rgba(148, 163, 184, 0.30);

    border-radius: 999px;
}

*::-webkit-scrollbar-thumb:hover {
    background:
        rgba(148, 163, 184, 0.48);
}

/* =========================================================
   MOBILE ENHANCEMENTS
========================================================= */

@media (max-width: 992px) {

    .sidebar {
        box-shadow:
            15px 0 45px rgba(0, 0, 0, 0.45);
    }

    .topbar {
        height: 70px;
    }

    .menu-btn {
        display: flex;
    }

    .content {
        min-height: calc(100vh - 70px);
        padding: 22px;
    }
}

@media (max-width: 600px) {

    .topbar {
        height: 64px;

        padding:
            0 12px;
    }

    .left-topbar {
        gap: 9px;
    }

    .system-title {
        max-width: 170px;

        font-size: 14px;
        font-weight: 700;
    }

    .user-box {
        gap: 7px;
    }

    .top-icon {
        width: 38px;
        height: 38px;

        font-size: 20px;
    }

    .profile-btn {
        padding: 2px;
    }

    .profile-btn img {
        width: 38px;
        height: 38px;
    }

    .profile-btn .arrow {
        display: none;
    }

    .content {
        min-height: calc(100vh - 64px);

        padding:
            15px 12px 24px;
    }

    .notif-dropdown {
        top: 69px;

        left: 10px;
        right: 10px;

        width: auto;

        border-radius: 15px;
    }

    .dropdown-menu {
        right: -5px;

        width: min(
            220px,
            calc(100vw - 24px)
        );
    }
}

/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;

        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;

        transition-duration: 0.01ms !important;
    }
}

    </style>

</head>


<body>


{{-- =========================================================
     SIDEBAR
========================================================= --}}

<aside
    class="sidebar"
    id="sidebar"
>


    {{-- CLOSE BUTTON --}}

    <button
        type="button"
        class="sidebar-close"
        onclick="closeSidebar()"
        aria-label="Close sidebar"
    >

        <i class="fas fa-times"></i>

    </button>


    {{-- LOGO --}}

    <div class="logo-section">

        <img
            src="{{ asset('images/MMACI Logo.jpg') }}"
            alt="MMACI Logo"
        >

        <h2>
            Dean Portal
        </h2>

        <p>
            On Board Training Management
        </p>

    </div>


    {{-- MENU --}}

    <nav class="sidebar-menu">


        {{-- DASHBOARD --}}

        <a
            href="{{ route('superadmin.dashboard') }}"
            class="{{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}"
        >

            <i class="bi bi-grid-1x2-fill"></i>

            <span>
                Dashboard
            </span>

        </a>


        {{-- CADETS --}}

        <a
            href="{{ route('superadmin.cadets.index') }}"
            class="{{ request()->routeIs('superadmin.cadets.*') ? 'active' : '' }}"
        >

            <i class="bi bi-mortarboard-fill"></i>

            <span>
                Cadets
            </span>

        </a>


        {{-- DEPLOYMENTS --}}

        <a
            href="{{ route('superadmin.deployments.index') }}"
            class="{{ request()->routeIs('superadmin.deployments.*') ? 'active' : '' }}"
        >

            <i class="bi bi-geo-alt-fill"></i>

            <span>
                Deployments
            </span>

        </a>


        {{-- OBT REQUIREMENTS --}}

        @php

            $obtMenuActive =
                request()->routeIs('superadmin.verification.*')
                ||
                request()->routeIs('superadmin.cadet-requirements.*')
                ||
                request()->routeIs('superadmin.cadet-bs-requirements.*')
                ||
                request()->routeIs('superadmin.shipped-so.*');

        @endphp


        <div class="menu-group">


            <div
                class="menu-item
                    {{ $obtMenuActive ? 'active-parent' : '' }}"
                onclick="toggleOBTMenu()"
            >

                <i class="fas fa-folder-open"></i>

                <span>
                    OBT Cadet Requirements
                </span>

                <i
                    class="
                        fas
                        fa-chevron-down
                        menu-arrow
                        {{ $obtMenuActive ? 'rotate' : '' }}
                    "
                    id="obtArrow"
                ></i>

            </div>


            <div
                id="obtMenu"
                class="submenu
                    {{ $obtMenuActive ? 'show' : '' }}"
            >


                {{-- VERIFICATION --}}

                <a
                    href="{{ route('superadmin.verification.index') }}"
                    class="
                        menu-sub-item
                        {{ request()->routeIs('superadmin.verification.*') ? 'active' : '' }}
                    "
                >

                    <i class="fas fa-user-check"></i>

                    <span>
                        Before OBT Requirements
                    </span>

                </a>


                {{-- ONBOARD REQUIREMENTS --}}

                <a
                    href="{{ route('superadmin.cadet-requirements.index') }}"
                    class="
                        menu-sub-item
                        {{ request()->routeIs('superadmin.cadet-requirements.*') ? 'active' : '' }}
                    "
                >

                    <i class="fas fa-ship"></i>

                    <span>
                        During OBT Requirements
                    </span>

                </a>


                {{-- BS REQUIREMENTS --}}

                <a
                    href="{{ route('superadmin.cadet-bs-requirements.index') }}"
                    class="
                        menu-sub-item
                        {{ request()->routeIs('superadmin.cadet-bs-requirements.*') ? 'active' : '' }}
                    "
                >

                    <i class="fas fa-graduation-cap"></i>

                    <span>
                        After OBT Requirements
                    </span>

                </a>


                {{-- SHIPPED ON ORDER --}}

                <a
                    href="{{ route('superadmin.shipped-so.index') }}"
                    class="
                        menu-sub-item
                        {{ request()->routeIs('superadmin.shipped-so.*') ? 'active' : '' }}
                    "
                >

                    <i class="fas fa-file-signature"></i>

                    <span>
                        Special Order
                    </span>

                </a>


            </div>

        </div>


        {{-- REMARKS --}}

        <a
            href="{{ route('superadmin.remarks.index') }}"
            class="{{ request()->routeIs('superadmin.remarks.*') ? 'active' : '' }}"
        >

            <i class="bi bi-chat-square-text-fill"></i>

            <span>
                Remarks
            </span>

        </a>


        {{-- COMPLAINTS --}}

        <a
            href="{{ route('superadmin.complaints.index') }}"
            class="{{ request()->routeIs('superadmin.complaints.*') ? 'active' : '' }}"
        >

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                Concerns
            </span>

        </a>


        {{-- CHAT --}}

        <a
            href="{{ route('chat.index') }}"
            class="{{ request()->routeIs('chat.*') ? 'active' : '' }}"
        >

            <i class="bi bi-chat-dots-fill"></i>

            <span>
                Chat
            </span>

        </a>


    </nav>


    {{-- LOGOUT --}}

    <form
        class="logout-form"
        method="POST"
        action="{{ route('superadmin.logout') }}"
    >

        @csrf

        <button
            type="submit"
            class="logout-btn"
        >

            <i class="fas fa-right-from-bracket"></i>

            Logout

        </button>

    </form>


</aside>


{{-- =========================================================
     MAIN
========================================================= --}}

<main
    class="main"
    id="main"
>


    {{-- =====================================================
         TOPBAR
    ====================================================== --}}

    <header class="topbar">


        <div class="left-topbar">


            {{-- MOBILE MENU --}}

            <button
                type="button"
                class="menu-btn"
                onclick="toggleSidebar()"
                aria-label="Open sidebar"
            >

                <i class="fas fa-bars"></i>

            </button>


            <div class="system-title">

                On Board Training Report System

            </div>


        </div>


        {{-- =================================================
             USER AREA
        ================================================== --}}

        <div class="user-box">


            {{-- =================================================
                 NOTIFICATIONS
            ================================================== --}}

            @php

                $user = auth()->user();

                $unreadCount = $user
                    ? $user->unreadNotifications()->count()
                    : 0;

                $notifications = $user
                    ? $user->notifications()
                        ->latest()
                        ->take(6)
                        ->get()
                    : collect();

            @endphp


            <div class="notification-wrapper">


                <button
                    type="button"
                    class="top-icon"
                    id="notifBtn"
                    aria-label="Notifications"
                >

                    <i class="fas fa-bell"></i>


                    @if($unreadCount > 0)

                        <span
                            class="badge"
                            id="notificationBadge"
                        >
                            {{ $unreadCount }}
                        </span>

                    @endif

                </button>


                {{-- DROPDOWN --}}

                <div
                    class="notif-dropdown"
                    id="notifDropdown"
                >


                    <div class="notif-header">

                        <span>
                            Notifications
                        </span>


                        <a
                            href="{{ route('superadmin.notifications') }}"
                        >
                            View All
                        </a>

                    </div>


                    <div class="notif-list">


                        @forelse($notifications as $notification)

                            <a
                                href="{{ route(
                                    'superadmin.notifications.show',
                                    ['id' => $notification->id]
                                ) }}"
                                class="
                                    notif-item
                                    {{ $notification->read_at
                                        ? ''
                                        : 'notif-unread'
                                    }}
                                "
                            >


                                <div class="notif-icon">

                                    {{
                                        $notification->data['icon']
                                        ?? '🔔'
                                    }}

                                </div>


                                <div>

                                    <div class="notif-text">

                                        {{
                                            $notification->data['message']
                                            ?? $notification->data['title']
                                            ?? 'Notification'
                                        }}

                                    </div>


                                    <div class="notif-time">

                                        {{
                                            $notification->created_at
                                                ->diffForHumans()
                                        }}

                                    </div>

                                </div>


                            </a>

                        @empty

                            <div
                                data-empty-notification
                                style="
                                    padding:20px;
                                    text-align:center;
                                    color:#94a3b8;
                                "
                            >

                                No notifications yet

                            </div>

                        @endforelse


                    </div>

                </div>

            </div>


            {{-- =================================================
                 PROFILE
            ================================================== --}}

            <div class="profile-dropdown">


                <button
                    type="button"
                    class="profile-btn"
                    id="profileBtn"
                >


                    <img
                        src="{{
                            auth()->user()->profile_picture
                                ? asset(
                                    'storage/' .
                                    auth()->user()->profile_picture
                                )
                                : 'https://ui-avatars.com/api/?name=' .
                                    urlencode(
                                        auth()->user()->name
                                    )
                        }}"
                        alt="Profile"
                    >


                    <span class="arrow">
                        ▼
                    </span>


                </button>


                <div
                    class="dropdown-menu"
                    id="profileDropdown"
                >


                    <div class="dropdown-user">

                        {{ auth()->user()->name }}

                    </div>


                    <hr>


                    <a
                        href="{{ route('superadmin.profile') }}"
                    >

                        <i class="fas fa-user"></i>

                        View Profile

                    </a>


                    <form
                        method="POST"
                        action="{{ route('superadmin.logout') }}"
                    >

                        @csrf

                        <button type="submit">

                            <i class="fas fa-right-from-bracket"></i>

                            Logout

                        </button>

                    </form>


                </div>


            </div>


        </div>

    </header>


    {{-- =====================================================
         CONTENT
    ====================================================== --}}

    <section class="content">

        @yield('content')

    </section>


</main>


<script>


/* =========================================================
   DOM READY
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           ELEMENTS
        ===================================================== */

        const sidebar =
            document.getElementById('sidebar');

        const profileBtn =
            document.getElementById('profileBtn');

        const profileDropdown =
            document.getElementById('profileDropdown');

        const notifBtn =
            document.getElementById('notifBtn');

        const notifDropdown =
            document.getElementById('notifDropdown');


        /* =====================================================
           PROFILE DROPDOWN
        ===================================================== */

        if (
            profileBtn &&
            profileDropdown
        ) {

            profileBtn.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    profileDropdown.classList.toggle(
                        'show'
                    );


                    if (notifDropdown) {

                        notifDropdown.classList.remove(
                            'show'
                        );

                    }

                }
            );

        }


        /* =====================================================
           NOTIFICATION DROPDOWN
        ===================================================== */

        if (
            notifBtn &&
            notifDropdown
        ) {

            notifBtn.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    notifDropdown.classList.toggle(
                        'show'
                    );


                    if (profileDropdown) {

                        profileDropdown.classList.remove(
                            'show'
                        );

                    }

                }
            );

        }


        /* =====================================================
           CLOSE DROPDOWNS
        ===================================================== */

        document.addEventListener(
            'click',
            function (event) {


                if (
                    profileDropdown &&
                    !event.target.closest(
                        '.profile-dropdown'
                    )
                ) {

                    profileDropdown.classList.remove(
                        'show'
                    );

                }


                if (
                    notifDropdown &&
                    !event.target.closest(
                        '.notification-wrapper'
                    )
                ) {

                    notifDropdown.classList.remove(
                        'show'
                    );

                }

            }
        );


        /* =====================================================
           CLOSE SIDEBAR ON MOBILE
        ===================================================== */

        document.addEventListener(
            'click',
            function (event) {


                if (
                    window.innerWidth <= 992 &&
                    sidebar &&
                    sidebar.classList.contains('show')
                ) {


                    const clickedInsideSidebar =
                        event.target.closest(
                            '.sidebar'
                        );


                    const clickedMenuButton =
                        event.target.closest(
                            '.menu-btn'
                        );


                    if (
                        !clickedInsideSidebar &&
                        !clickedMenuButton
                    ) {

                        sidebar.classList.remove(
                            'show'
                        );

                    }

                }

            }
        );

    }
);


/* =========================================================
   SIDEBAR
========================================================= */

function toggleSidebar()
{

    const sidebar =
        document.getElementById('sidebar');


    if (!sidebar) {
        return;
    }


    sidebar.classList.toggle(
        'show'
    );

}


function closeSidebar()
{

    const sidebar =
        document.getElementById('sidebar');


    if (!sidebar) {
        return;
    }


    sidebar.classList.remove(
        'show'
    );

}


/* =========================================================
   OBT MENU
========================================================= */

function toggleOBTMenu()
{

    const menu =
        document.getElementById('obtMenu');

    const arrow =
        document.getElementById('obtArrow');


    if (
        !menu ||
        !arrow
    ) {
        return;
    }


    menu.classList.toggle(
        'show'
    );


    arrow.classList.toggle(
        'rotate'
    );

}

</script>

<script>
/* =========================================================
   REAL-TIME CHAT NOTIFICATIONS
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const userIdMeta = document.querySelector(
        'meta[name="user-id"]'
    );

    if (!userIdMeta) {
        console.warn('User ID meta tag not found.');
        return;
    }

    const userId = userIdMeta.getAttribute('content');

    if (!userId) {
        console.warn('User ID is empty.');
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK ECHO
    |--------------------------------------------------------------------------
    */

    if (!window.Echo) {
        console.error(
            'Laravel Echo is not loaded.'
        );

        return;
    }


    console.log(
        'Listening for real-time messages on:',
        `chat.${userId}`
    );


    /*
    |--------------------------------------------------------------------------
    | LISTEN FOR MESSAGE SENT
    |--------------------------------------------------------------------------
    */

    window.Echo
        .private(`chat.${userId}`)
        .listen('.message.sent', function (event) {

            console.log(
                'REAL-TIME MESSAGE RECEIVED:',
                event
            );


            /*
            |--------------------------------------------------------------------------
            | UPDATE NOTIFICATION BADGE
            |--------------------------------------------------------------------------
            */

            updateNotificationBadge();


            /*
            |--------------------------------------------------------------------------
            | ADD NOTIFICATION TO DROPDOWN
            |--------------------------------------------------------------------------
            */

            addRealtimeNotification(event);

        });

});


/* =========================================================
   UPDATE NOTIFICATION BADGE
========================================================= */

function updateNotificationBadge()
{

    const notificationButton =
        document.getElementById('notifBtn');

    if (!notificationButton) {
        return;
    }


    let badge =
        document.getElementById('notificationBadge');


    /*
    |--------------------------------------------------------------------------
    | CREATE BADGE IF IT DOESN'T EXIST
    |--------------------------------------------------------------------------
    */

    if (!badge) {

        badge = document.createElement('span');

        badge.className = 'badge';

        badge.id = 'notificationBadge';

        badge.textContent = '1';

        notificationButton.appendChild(badge);

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | INCREMENT EXISTING BADGE
    |--------------------------------------------------------------------------
    */

    let count =
        parseInt(badge.textContent || '0', 10);

    count++;

    badge.textContent = count;

}


/* =========================================================
   ADD REAL-TIME NOTIFICATION TO DROPDOWN
========================================================= */

function addRealtimeNotification(event)
{

    const notificationList =
        document.querySelector('.notif-list');

    if (!notificationList) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE "NO NOTIFICATIONS YET"
    |--------------------------------------------------------------------------
    */

    const emptyMessage =
        notificationList.querySelector(
            '[data-empty-notification]'
        );

    if (emptyMessage) {
        emptyMessage.remove();
    }


    /*
    |--------------------------------------------------------------------------
    | GET MESSAGE
    |--------------------------------------------------------------------------
    */

    const message =
        event.message || 'New message';


    /*
    |--------------------------------------------------------------------------
    | CREATE NOTIFICATION ITEM
    |--------------------------------------------------------------------------
    */

    const item =
        document.createElement('div');

    item.className =
        'notif-item notif-unread';

    item.innerHTML = `

        <div class="notif-icon">
            💬
        </div>

        <div>

            <div class="notif-text">
                New message
            </div>

            <div class="notif-time">
                ${escapeHtml(message)}
            </div>

        </div>

    `;


    /*
    |--------------------------------------------------------------------------
    | INSERT AT TOP
    |--------------------------------------------------------------------------
    */

    notificationList.prepend(item);


    /*
    |--------------------------------------------------------------------------
    | LIMIT DROPDOWN TO 6 ITEMS
    |--------------------------------------------------------------------------
    */

    const items =
        notificationList.querySelectorAll(
            '.notif-item'
        );

    if (items.length > 6) {

        items[items.length - 1].remove();

    }

}


/* =========================================================
   HTML ESCAPE
========================================================= */

function escapeHtml(value)
{

    const div =
        document.createElement('div');

    div.textContent =
        value ?? '';

    return div.innerHTML;

}
</script>
</body>

</html>