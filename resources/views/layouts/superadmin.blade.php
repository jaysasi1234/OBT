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

        /* =====================================================
           GLOBAL RESET
        ===================================================== */

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            width: 100%;
            min-height: 100%;
        }

        body {
            width: 100%;
            min-height: 100vh;

            font-family: 'Inter', sans-serif;

            background: #0f172a;
            color: #ffffff;

            overflow-x: hidden;
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar {
            position: fixed;

            top: 0;
            left: 0;

            width: 260px;
            height: 100vh;

            background:
                linear-gradient(
                    180deg,
                    #181f35 0%,
                    #05144d 100%
                );

            z-index: 3000;

            display: flex;
            flex-direction: column;

            overflow-x: hidden;
            overflow-y: auto;

            scrollbar-width: thin;

            scrollbar-color:
                rgba(255,255,255,.25)
                transparent;

            transition:
                left .3s ease,
                transform .3s ease;
        }


        .sidebar::-webkit-scrollbar {
            width: 7px;
        }


        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }


        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.25);
            border-radius: 10px;
        }


        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,.4);
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .logo-section {
            width: 100%;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            text-align: center;

            padding: 25px 15px;

            flex-shrink: 0;
        }


        .logo-section img {
            display: block;

            width: 120px;
            height: 120px;

            object-fit: cover;

            border-radius: 50%;

            margin-bottom: 15px;
        }


        .logo-section h2 {
            color: #ffffff;

            font-size: 17px;
            font-weight: 600;

            line-height: 1.3;
        }


        .logo-section p {
            margin-top: 8px;

            color: #ffffff;

            font-size: 16px;
            font-weight: 500;

            line-height: 1.45;
        }


        /* =====================================================
           SIDEBAR MENU
        ===================================================== */

        .sidebar-menu {
            width: 100%;

            padding: 10px 15px 15px;
        }


        .sidebar a {
            display: flex;

            align-items: center;

            gap: 14px;

            width: 100%;

            color: #e2e8f0;

            text-decoration: none;

            padding: 14px 16px;

            margin-bottom: 8px;

            border-radius: 12px;

            font-size: 14px;
            font-weight: 500;

            transition:
                background .25s ease,
                transform .25s ease,
                color .25s ease;
        }


        .sidebar a i {
            width: 22px;
            min-width: 22px;

            font-size: 18px;

            text-align: center;
        }


        .sidebar a:hover {
            background: rgba(255,255,255,.08);

            transform: translateX(4px);
        }


        .sidebar a.active {
            background:
                linear-gradient(
                    90deg,
                    #3b82f6,
                    #2563eb
                );

            color: #ffffff;

            box-shadow:
                0 8px 20px
                rgba(37,99,235,.30);

            transform: none;
        }


        /* =====================================================
           MENU GROUP
        ===================================================== */

        .menu-group {
            width: 100%;
            margin-bottom: 8px;
        }


        .menu-item {
            width: 100%;

            display: flex;

            align-items: center;

            gap: 14px;

            padding: 14px 16px;

            margin-bottom: 4px;

            border-radius: 12px;

            color: #e2e8f0;

            cursor: pointer;

            font-size: 14px;
            font-weight: 500;

            transition:
                background .25s ease,
                transform .25s ease;
        }


        .menu-item:hover {
            background: rgba(255,255,255,.08);

            transform: translateX(4px);
        }


        .menu-item.active-parent {
            background: rgba(59,130,246,.15);

            color: #ffffff;
        }


        .menu-item > i:first-child {
            width: 22px;
            min-width: 22px;

            font-size: 18px;
        }


        .menu-item span {
            flex: 1;
            min-width: 0;
        }


        .menu-arrow {
            width: auto !important;
            min-width: auto !important;

            font-size: 12px !important;

            opacity: .8;

            transition:
                transform .25s ease;
        }


        .menu-arrow.rotate {
            transform: rotate(180deg);
        }


        /* =====================================================
           SUBMENU
        ===================================================== */

        .submenu {
            display: none;

            margin: 2px 0 8px 12px;

            padding-left: 12px;

            border-left:
                2px solid
                rgba(255,255,255,.12);
        }


        .submenu.show {
            display: block;
        }


        .menu-sub-item {
            display: flex !important;

            align-items: center;

            gap: 12px;

            padding: 11px 13px !important;

            margin-bottom: 4px !important;

            border-radius: 10px !important;

            color: #cbd5e1 !important;

            font-size: 13px !important;

            font-weight: 500 !important;

            transform: none !important;
        }


        .menu-sub-item i {
            width: 20px !important;
            min-width: 20px !important;

            font-size: 15px !important;

            text-align: center;
        }


        .menu-sub-item:hover {
            background:
                rgba(255,255,255,.08) !important;

            color: #ffffff !important;

            transform:
                translateX(4px) !important;
        }


        .menu-sub-item.active {
            background:
                linear-gradient(
                    90deg,
                    #3b82f6,
                    #2563eb
                ) !important;

            color: #ffffff !important;

            box-shadow:
                0 6px 15px
                rgba(37,99,235,.25);

            transform: none !important;
        }


        /* =====================================================
           LOGOUT
        ===================================================== */

        .logout-form {
            width: 100%;

            padding: 10px 15px 20px;

            margin-top: auto;

            flex-shrink: 0;
        }


        .logout-btn {
            width: 100%;

            border: none;

            background:
                linear-gradient(
                    135deg,
                    #ef4444,
                    #dc2626
                );

            color: #ffffff;

            padding: 14px;

            border-radius: 12px;

            cursor: pointer;

            font-family: inherit;

            font-size: 14px;
            font-weight: 600;

            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }


        .logout-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 10px 20px
                rgba(220,38,38,.30);
        }


        /* =====================================================
           SIDEBAR CLOSE
        ===================================================== */

        .sidebar-close {
            display: none;

            position: absolute;

            top: 18px;
            right: 18px;

            width: 40px;
            height: 40px;

            border: none;

            border-radius: 50%;

            background:
                rgba(255,255,255,.12);

            color: #ffffff;

            cursor: pointer;

            font-size: 18px;

            align-items: center;
            justify-content: center;

            z-index: 10;
        }


        .sidebar-close:hover {
            background: #ef4444;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .main {
            margin-left: 260px;

            width: calc(100% - 260px);

            min-height: 100vh;

            position: relative;

            z-index: auto;

            overflow-x: clip;

            transition:
                margin-left .3s ease,
                width .3s ease;
        }


        /* =====================================================
           TOPBAR
        ===================================================== */

        .topbar {
            height: 75px;

            width: 100%;

            background: #111827;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 25px;

            box-shadow:
                0 2px 15px
                rgba(0,0,0,.30);

            position: sticky;

            top: 0;

            z-index: 2000;
        }


        .left-topbar {
            display: flex;

            align-items: center;

            gap: 15px;

            min-width: 0;
        }


        .system-title {
            color: #ffffff;

            font-size: 22px;
            font-weight: 700;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        .menu-btn {
            display: none;

            border: none;

            background: transparent;

            color: #ffffff;

            font-size: 28px;

            cursor: pointer;
        }


        /* =====================================================
           USER AREA
        ===================================================== */

        .user-box {
            display: flex;

            align-items: center;

            gap: 15px;

            flex-shrink: 0;
        }


        .top-icon {
            position: relative;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            width: 40px;
            height: 40px;

            border: none;

            background: transparent;

            color: #ffffff;

            text-decoration: none;

            font-size: 26px;

            cursor: pointer;

            transition:
                transform .25s ease;
        }


        .top-icon:hover {
            transform: translateY(-2px);
        }


        /* =====================================================
           NOTIFICATION BADGE
        ===================================================== */

        .badge {
            position: absolute;

            top: -4px;
            right: -5px;

            min-width: 19px;
            height: 19px;

            padding: 0 5px;

            border-radius: 999px;

            background: #ef4444;

            color: #ffffff;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 11px;
            font-weight: 700;

            line-height: 1;
        }


        /* =====================================================
           NOTIFICATION DROPDOWN
        ===================================================== */

        .notification-wrapper {
            position: relative;
        }


        .notif-dropdown {
            position: absolute;

            top: 55px;
            right: 0;

            width: 340px;

            max-width:
                calc(100vw - 30px);

            background: #1e293b;

            border-radius: 14px;

            box-shadow:
                0 10px 30px
                rgba(0,0,0,.40);

            display: none;

            overflow: hidden;

            z-index: 4000;
        }


        .notif-dropdown.show {
            display: block;
        }


        .notif-header {
            padding: 12px 15px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            border-bottom:
                1px solid
                #334155;

            font-weight: 600;
        }


        .notif-header a {
            color: #38bdf8;

            text-decoration: none;

            font-size: 12px;
        }


        .notif-list {
            max-height: 320px;

            overflow-y: auto;
        }


        .notif-item {
            display: flex;

            gap: 10px;

            padding: 12px;

            border-bottom:
                1px solid
                #334155;

            color: #ffffff;

            text-decoration: none;

            transition:
                background .2s ease;
        }


        .notif-item:hover {
            background: #334155;
        }


        .notif-icon {
            width: 36px;
            height: 36px;

            min-width: 36px;

            background: #0f172a;

            border-radius: 10px;

            display: flex;

            align-items: center;
            justify-content: center;
        }


        .notif-text {
            font-size: 13px;
            font-weight: 600;

            line-height: 1.4;
        }


        .notif-time {
            margin-top: 3px;

            font-size: 11px;

            color: #94a3b8;
        }


        .notif-unread {
            background:
                rgba(56,189,248,.10);
        }


        /* =====================================================
           PROFILE
        ===================================================== */

        .profile-dropdown {
            position: relative;
        }


        .profile-btn {
            display: flex;

            align-items: center;

            gap: 8px;

            background: transparent;

            border: none;

            color: #ffffff;

            cursor: pointer;
        }


        .profile-btn img {
            width: 45px;
            height: 45px;

            border-radius: 50%;

            object-fit: cover;

            border:
                2px solid
                #ffffff;
        }


        .arrow {
            font-size: 12px;
        }


        .dropdown-menu {
            position: absolute;

            top: 58px;
            right: 0;

            width: 220px;

            background: #1e293b;

            border-radius: 12px;

            overflow: hidden;

            display: none;

            box-shadow:
                0 10px 25px
                rgba(0,0,0,.40);

            z-index: 4000;
        }


        .dropdown-menu.show {
            display: block;
        }


        .dropdown-user {
            padding: 15px;

            color: #ffffff;

            font-weight: 600;
        }


        .dropdown-menu hr {
            border: none;

            border-top:
                1px solid
                #334155;
        }


        .dropdown-menu a {
            display: block;

            width: 100%;

            padding: 12px 15px;

            color: #ffffff;

            text-decoration: none;
        }


        .dropdown-menu a:hover {
            background: #334155;
        }


        .dropdown-menu form button {
            width: 100%;

            border: none;

            background: #dc2626;

            color: #ffffff;

            padding: 12px;

            cursor: pointer;

            font-family: inherit;
        }


        .dropdown-menu form button:hover {
            background: #b91c1c;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .content {
            width: 100%;

            min-width: 0;

            padding: 25px;

            overflow: visible;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 992px) {

            .sidebar {
                left: -260px;

                box-shadow:
                    10px 0 30px
                    rgba(0,0,0,.35);
            }


            .sidebar.show {
                left: 0;
            }


            .sidebar-close {
                display: flex;
            }


            .main {
                margin-left: 0;

                width: 100%;
            }


            .menu-btn {
                display: block;
            }


            .system-title {
                font-size: 18px;
            }


            .content {
                padding: 20px;
            }

        }


        @media (max-width: 600px) {

            .topbar {
                height: 65px;

                padding: 0 15px;
            }


            .system-title {
                font-size: 16px;
            }


            .user-box {
                gap: 10px;
            }


            .top-icon {
                font-size: 22px;
            }


            .profile-btn img {
                width: 40px;
                height: 40px;
            }


            .content {
                padding: 15px;
            }


            .notif-dropdown {
                position: fixed;

                top: 70px;

                left: 15px;
                right: 15px;

                width: auto;

                max-width: none;
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