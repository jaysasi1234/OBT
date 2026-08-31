<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="user-id"
        content="{{ auth()->id() }}"
    >

    <title>
        @yield(
            'title',
            'On Board Training Report System - Admin'
        )
    </title>


    {{-- =========================================================
         ICONS
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >


    {{-- =========================================================
         FONT
    ========================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- =========================================================
         VITE
    ========================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        /* =========================================================
           ADMIN VARIABLES
        ========================================================== */

        :root {

            --admin-sidebar-width: 270px;

            --admin-header-height: 76px;

            --admin-bg: #f1f5f9;

            --admin-sidebar-bg-1: #071525;

            --admin-sidebar-bg-2: #0a192f;

            --admin-sidebar-bg-3: #0d2039;

            --admin-header-bg:
                rgba(7, 21, 37, .97);

            --admin-blue:
                #3b82f6;

            --admin-blue-dark:
                #2563eb;

            --admin-blue-light:
                #60a5fa;

            --admin-white:
                #ffffff;

            --admin-text:
                #0f172a;

            --admin-text-light:
                #cbd5e1;

            --admin-text-muted:
                #94a3b8;

            --admin-border:
                rgba(255,255,255,.07);

            --admin-transition:
                .25s cubic-bezier(.4,0,.2,1);

            --admin-shadow:
                0 20px 50px rgba(0,0,0,.25);

        }


        /* =========================================================
           RESET
        ========================================================== */

        .admin-shell,
        .admin-shell *,
        .admin-shell *::before,
        .admin-shell *::after {

            box-sizing: border-box;

        }


        .admin-shell {

            position: relative;

            width: 100%;

            min-height: 100vh;

            font-family:
                'Inter',
                -apple-system,
                BlinkMacSystemFont,
                'Segoe UI',
                sans-serif;

        }


        .admin-shell button,
        .admin-shell input,
        .admin-shell select,
        .admin-shell textarea {

            font-family: inherit;

        }


        .admin-shell button {

            cursor: pointer;

        }


        .admin-shell a {

            text-decoration: none;

        }


        /* =========================================================
           SIDEBAR
        ========================================================== */

        .admin-sidebar {

            position: fixed;

            top: 0;

            left: 0;

            width:
                var(--admin-sidebar-width);

            height: 100vh;

            z-index: 3000;

            display: flex;

            flex-direction: column;

            background:
                linear-gradient(
                    180deg,
                    var(--admin-sidebar-bg-1) 0%,
                    var(--admin-sidebar-bg-2) 48%,
                    var(--admin-sidebar-bg-3) 100%
                );

            border-right:
                1px solid var(--admin-border);

            box-shadow:
                12px 0 40px rgba(0,0,0,.12);

            overflow-y: auto;

            overflow-x: hidden;

            transition:
                transform var(--admin-transition);

            overscroll-behavior:
                contain;

            scrollbar-gutter:
                stable;

        }


        .admin-sidebar::-webkit-scrollbar {

            width: 5px;

        }


        .admin-sidebar::-webkit-scrollbar-track {

            background: transparent;

        }


        .admin-sidebar::-webkit-scrollbar-thumb {

            background:
                rgba(148,163,184,.25);

            border-radius: 20px;

        }


        .admin-sidebar::-webkit-scrollbar-thumb:hover {

            background:
                rgba(148,163,184,.4);

        }


        /* =========================================================
           SIDEBAR HEADER
        ========================================================== */

        .admin-sidebar-header {

            position: sticky;

            top: 0;

            z-index: 20;

            min-height: 92px;

            display: flex;

            align-items: center;

            gap: 13px;

            padding: 17px 18px;

            background:
                linear-gradient(
                    180deg,
                    #071525 0%,
                    #0a192f 100%
                );

            border-bottom:
                1px solid var(--admin-border);

            box-shadow:
                0 8px 20px rgba(0,0,0,.08);

        }


        .admin-sidebar-logo {

            width: 54px;

            height: 54px;

            flex-shrink: 0;

            object-fit: cover;

            border-radius: 50%;

            border:
                2px solid rgba(255,255,255,.15);

            box-shadow:
                0 6px 18px rgba(0,0,0,.3);

            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;

        }


        .admin-sidebar-logo:hover {

            transform:
                scale(1.04);

            border-color:
                rgba(96,165,250,.45);

            box-shadow:
                0 8px 24px rgba(0,0,0,.4);

        }


        .admin-sidebar-text {

            min-width: 0;

        }


        .admin-sidebar-text h2 {

            margin: 0;

            color: #ffffff;

            font-size: 16px;

            line-height: 1.25;

            font-weight: 800;

            white-space: nowrap;

        }


        .admin-sidebar-text p {

            margin: 4px 0 0;

            color: #94a3b8;

            font-size: 10px;

            line-height: 1.4;

        }


        /* =========================================================
           CLOSE BUTTON
        ========================================================== */

        .admin-sidebar-close {

            display: none;

            position: absolute;

            top: 17px;

            right: 15px;

            width: 38px;

            height: 38px;

            align-items: center;

            justify-content: center;

            border:
                1px solid rgba(255,255,255,.1);

            border-radius: 10px;

            background:
                rgba(255,255,255,.08);

            color: white;

            font-size: 16px;

            z-index: 50;

            transition:
                var(--admin-transition);

        }


        .admin-sidebar-close:hover {

            background:
                #ef4444;

            border-color:
                #ef4444;

            transform:
                rotate(90deg);

        }


        /* =========================================================
           SIDEBAR MENU
        ========================================================== */

        .admin-sidebar-menu {

            padding:
                14px 11px 25px;

        }


        .admin-menu-section {

            padding:
                15px 13px 8px;

            color:
                rgba(148,163,184,.6);

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.2px;

            text-transform: uppercase;

        }


        .admin-menu-item {

            position: relative;

            display: flex;

            align-items: center;

            gap: 12px;

            width: 100%;

            min-height: 46px;

            padding:
                11px 13px;

            margin-bottom: 3px;

            border:
                1px solid transparent;

            border-radius: 10px;

            background: transparent;

            color:
                rgba(226,232,240,.72);

            font-size: 13px;

            font-weight: 600;

            text-align: left;

            transition:
                var(--admin-transition);

            user-select: none;

            -webkit-tap-highlight-color:
                transparent;

        }


        .admin-menu-item i {

            width: 20px;

            height: 20px;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            color:
                rgba(148,163,184,.85);

            transition:
                var(--admin-transition);

        }


        .admin-menu-item span {

            min-width: 0;

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;

        }


        .admin-menu-item:hover {

            color: #ffffff;

            background:
                rgba(59,130,246,.09);

            border-color:
                rgba(59,130,246,.12);

        }


        .admin-menu-item:not(.active):hover {

            transform:
                translateX(2px);

        }


        .admin-menu-item:hover i {

            color:
                var(--admin-blue-light);

        }


        .admin-menu-item.active {

            color: #ffffff;

            background:
                linear-gradient(
                    90deg,
                    rgba(37,99,235,.25),
                    rgba(37,99,235,.08)
                );

            border-color:
                rgba(59,130,246,.18);

            box-shadow:
                inset 3px 0 0 var(--admin-blue);

        }


        .admin-menu-item.active i {

            color:
                var(--admin-blue-light);

        }


        .admin-menu-item.active::after {

            content: "";

            position: absolute;

            right: 8px;

            top: 50%;

            width: 4px;

            height: 4px;

            border-radius: 50%;

            background:
                var(--admin-blue-light);

            transform:
                translateY(-50%);

            box-shadow:
                0 0 10px rgba(96,165,250,.7);

        }


        /* =========================================================
           MENU GROUP
        ========================================================== */

        .admin-menu-group {

            margin-bottom: 3px;

        }


        .admin-menu-arrow {

            margin-left: auto;

            width: auto !important;

            height: auto !important;

            font-size: 10px;

            color:
                #64748b !important;

            transition:
                transform var(--admin-transition);

        }


        .admin-menu-arrow.rotate {

            transform:
                rotate(180deg);

        }


        /* =========================================================
           SUBMENU
        ========================================================== */

        .admin-submenu {

            display: none;

            margin:
                2px 0 7px 12px;

            padding-left: 8px;

            border-left:
                1px solid rgba(148,163,184,.12);

        }


        .admin-submenu.show {

            display: block;

            animation:
                adminSubmenuOpen .2s ease;

        }


        @keyframes adminSubmenuOpen {

            from {

                opacity: 0;

                transform:
                    translateY(-4px);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0);

            }

        }


        .admin-submenu-item {

            position: relative;

            display: flex;

            align-items: center;

            gap: 10px;

            min-height: 40px;

            padding:
                9px 12px;

            margin-bottom: 2px;

            border-radius: 8px;

            color:
                rgba(203,213,225,.65);

            font-size: 12px;

            font-weight: 500;

            transition:
                var(--admin-transition);

            user-select: none;

        }


        .admin-submenu-item i {

            width: 16px;

            color:
                #64748b;

        }


        .admin-submenu-item:hover {

            color: white;

            background:
                rgba(59,130,246,.08);

            transform:
                translateX(2px);

        }


        .admin-submenu-item.active {

            color: white;

            background:
                rgba(59,130,246,.15);

        }


        .admin-submenu-item.active i {

            color:
                var(--admin-blue-light);

        }


        .admin-submenu-item.active::before {

            content: "";

            position: absolute;

            left: -9px;

            top: 50%;

            width: 3px;

            height: 20px;

            border-radius: 10px;

            background:
                var(--admin-blue);

            transform:
                translateY(-50%);

        }


        /* =========================================================
           DIVIDER
        ========================================================== */

        .admin-sidebar-divider {

            height: 1px;

            margin:
                14px 8px;

            background:
                rgba(255,255,255,.08);

        }


        /* =========================================================
           MAIN
        ========================================================== */

        .admin-main {

            width:
                calc(100% - var(--admin-sidebar-width));

            min-height: 100vh;

            margin-left:
                var(--admin-sidebar-width);

            padding-top:
                var(--admin-header-height);

            position: relative;

            transition:
                margin-left var(--admin-transition),
                width var(--admin-transition);

        }


        /* =========================================================
           HEADER
        ========================================================== */

        .admin-header {

            position: fixed;

            top: 0;

            right: 0;

            width:
                calc(100% - var(--admin-sidebar-width));

            height:
                var(--admin-header-height);

            z-index: 2500;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding:
                0 25px;

            background:
                var(--admin-header-bg);

            border-bottom:
                1px solid var(--admin-border);

            box-shadow:
                0 8px 30px rgba(0,0,0,.12);

            backdrop-filter:
                blur(14px);

            -webkit-backdrop-filter:
                blur(14px);

            transition:
                width var(--admin-transition);

        }


        .admin-header::after {

            content: "";

            position: absolute;

            left: 0;

            right: 0;

            bottom: -1px;

            height: 1px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(59,130,246,.25),
                    transparent
                );

            pointer-events: none;

        }


        .admin-header-left {

            display: flex;

            align-items: center;

            gap: 15px;

            min-width: 0;

        }


        .admin-header-title {

            margin: 0;

            color: #ffffff;

            font-size: 18px;

            font-weight: 700;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

        }


        /* =========================================================
           MOBILE BUTTON
        ========================================================== */

        .admin-mobile-btn {

            display: none;

            width: 42px;

            height: 42px;

            flex-shrink: 0;

            align-items: center;

            justify-content: center;

            border:
                1px solid rgba(255,255,255,.1);

            border-radius: 10px;

            background:
                rgba(255,255,255,.06);

            color: white;

            font-size: 18px;

            transition:
                var(--admin-transition);

        }


        .admin-mobile-btn:hover {

            background:
                rgba(59,130,246,.2);

        }


        .admin-mobile-btn:active {

            transform:
                scale(.94);

        }


        /* =========================================================
           HEADER RIGHT
        ========================================================== */

        .admin-header-right {

            display: flex;

            align-items: center;

            gap: 14px;

            flex-shrink: 0;

            margin-left: auto;

        }


        /* =========================================================
           NOTIFICATIONS
        ========================================================== */

        .admin-notification-wrapper {

            position: relative;

        }


        .admin-notification-button {

            position: relative;

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius: 11px;

            background:
                rgba(255,255,255,.06);

            color:
                #cbd5e1;

            transition:
                var(--admin-transition);

            -webkit-tap-highlight-color:
                transparent;

        }


        .admin-notification-button:hover {

            color: white;

            background:
                rgba(59,130,246,.15);

            border-color:
                rgba(59,130,246,.25);

        }


        .admin-notification-button:active {

            transform:
                scale(.94);

        }


        .admin-notification-button svg {

            width: 20px;

            height: 20px;

        }


        .admin-notification-badge {

            position: absolute;

            top: -5px;

            right: -5px;

            min-width: 18px;

            height: 18px;

            padding:
                0 5px;

            display: flex;

            align-items: center;

            justify-content: center;

            border:
                2px solid #071525;

            border-radius: 20px;

            background:
                #ef4444;

            color: white;

            font-size: 9px;

            font-weight: 800;

            line-height: 1;

            white-space: nowrap;

        }


        .admin-notification-menu {

            position: absolute;

            top: 52px;

            right: 0;

            width: 360px;

            max-height: 470px;

            overflow-y: auto;

            overscroll-behavior: contain;

            scrollbar-gutter: stable;

            background:
                #0f1d31;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius: 14px;

            box-shadow:
                var(--admin-shadow);

            display: none;

            animation:
                adminDropdownOpen .18s ease;

        }


        .admin-notification-menu.show {

            display: block;

        }


        .admin-notification-menu::-webkit-scrollbar {

            width: 5px;

        }


        .admin-notification-menu::-webkit-scrollbar-thumb {

            background:
                #334155;

            border-radius: 20px;

        }


        .admin-notification-header {

            position: sticky;

            top: 0;

            z-index: 2;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                16px 18px;

            background:
                #0f1d31;

            border-bottom:
                1px solid rgba(255,255,255,.07);

            color: white;

            font-size: 14px;

            font-weight: 700;

        }


        .admin-notification-item {

            position: relative;

            display: flex;

            gap: 12px;

            padding:
                14px 17px;

            border-bottom:
                1px solid rgba(255,255,255,.05);

            transition:
                var(--admin-transition);

        }


        .admin-notification-item:hover {

            background:
                rgba(255,255,255,.04);

        }


        .admin-notification-item.unread {

            background:
                rgba(59,130,246,.08);

        }


        .admin-notification-item.unread::before {

            content: "";

            position: absolute;

            left: 0;

            top: 12px;

            bottom: 12px;

            width: 3px;

            border-radius:
                0 4px 4px 0;

            background:
                var(--admin-blue);

        }


        .admin-notif-icon {

            width: 38px;

            height: 38px;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            background:
                rgba(59,130,246,.12);

            color:
                #60a5fa;

            font-size: 16px;

        }


        .admin-notif-content {

            flex: 1;

            min-width: 0;

        }


        .admin-notif-text {

            color:
                #e2e8f0;

            font-size: 12px;

            line-height: 1.5;

        }


        .admin-notif-time {

            margin-top: 5px;

            color:
                #64748b;

            font-size: 10px;

        }


        .admin-view-all {

            display: block;

            padding: 13px;

            text-align: center;

            background:
                rgba(255,255,255,.03);

            color:
                #60a5fa;

            font-size: 12px;

            font-weight: 700;

        }


        .admin-view-all:hover {

            background:
                rgba(59,130,246,.1);

        }


        /* =========================================================
           REALTIME NOTIFICATION ANIMATION
        ========================================================== */

        .admin-notification-item.realtime-new {

            animation:
                realtimeNotificationIn .35s ease;

        }


        @keyframes realtimeNotificationIn {

            from {

                opacity: 0;

                transform:
                    translateY(-8px);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0);

            }

        }


        .admin-notification-button.realtime-pulse {

            animation:
                notificationPulse .55s ease;

        }


        @keyframes notificationPulse {

            0% {

                transform: scale(1);

            }

            35% {

                transform: scale(1.12);

            }

            70% {

                transform: scale(.96);

            }

            100% {

                transform: scale(1);

            }

        }


        /* =========================================================
           PROFILE
        ========================================================== */

        .admin-profile-dropdown {

            position: relative;

        }


        .admin-profile-area {

            display: flex;

            align-items: center;

            gap: 9px;

            padding: 4px;

            cursor: pointer;

            border-radius: 12px;

            transition:
                var(--admin-transition);

            user-select: none;

        }


        .admin-profile-area:hover {

            background:
                rgba(255,255,255,.05);

        }


        .admin-profile-avatar {

            width: 40px;

            height: 40px;

            overflow: hidden;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

            border:
                2px solid rgba(255,255,255,.12);

            border-radius: 50%;

            background:
                #1e3a5f;

            transition:
                border-color .25s ease,
                box-shadow .25s ease,
                transform .25s ease;

        }


        .admin-profile-area:hover
        .admin-profile-avatar {

            border-color:
                rgba(96,165,250,.4);

            box-shadow:
                0 0 0 3px rgba(59,130,246,.08);

        }


        .admin-profile-area:active
        .admin-profile-avatar {

            transform:
                scale(.96);

        }


        .admin-profile-avatar img {

            width: 100%;

            height: 100%;

            object-fit: cover;

        }


        .admin-profile-avatar.big {

            width: 46px;

            height: 46px;

        }


        .admin-profile-summary {

            display: flex;

            flex-direction: column;

            gap: 2px;

        }


        .admin-profile-name {

            color: white;

            font-size: 12px;

            font-weight: 700;

        }


        .admin-profile-role {

            color: #64748b;

            font-size: 10px;

        }


        .admin-profile-arrow {

            color: #64748b;

            font-size: 9px;

            transition:
                transform var(--admin-transition);

        }


        .admin-profile-menu {

            position: absolute;

            top: 56px;

            right: 0;

            width: 270px;

            overflow: hidden;

            background:
                #0f1d31;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius: 14px;

            box-shadow:
                var(--admin-shadow);

            display: none;

            animation:
                adminDropdownOpen .18s ease;

        }


        .admin-profile-menu.show {

            display: block;

        }


        .admin-profile-card {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 17px;

            background:
                linear-gradient(
                    135deg,
                    rgba(59,130,246,.12),
                    rgba(255,255,255,.02)
                );

            border-bottom:
                1px solid rgba(255,255,255,.07);

        }


        .admin-profile-card .admin-profile-name {

            font-size: 13px;

        }


        .admin-profile-menu a {

            display: flex;

            align-items: center;

            gap: 10px;

            padding:
                13px 17px;

            color:
                #cbd5e1;

            font-size: 12px;

            font-weight: 500;

            transition:
                var(--admin-transition);

        }


        .admin-profile-menu a:hover {

            color: white;

            background:
                rgba(255,255,255,.05);

        }


        .admin-logout-btn {

            width: 100%;

            padding:
                13px 17px;

            border: 0;

            border-top:
                1px solid rgba(255,255,255,.06);

            background: transparent;

            color:
                #fca5a5;

            font-size: 12px;

            font-weight: 600;

            text-align: left;

            transition:
                var(--admin-transition);

        }


        .admin-logout-btn:hover {

            background:
                rgba(239,68,68,.1);

            color:
                #fecaca;

        }


        /* =========================================================
           PAGE CONTENT
        ========================================================== */

        .admin-page-content {

            position: relative;

            width: 100%;

            min-height:
                calc(
                    100vh -
                    var(--admin-header-height)
                );

            padding: 24px;

            min-width: 0;

        }


        /* =========================================================
           SIDEBAR OVERLAY
        ========================================================== */

        .admin-sidebar-overlay {

            display: none;

            position: fixed;

            inset: 0;

            z-index: 2900;

            background:
                rgba(2,6,23,.68);

            backdrop-filter:
                blur(2px);

            -webkit-backdrop-filter:
                blur(2px);

            opacity: 0;

            pointer-events: none;

            transition:
                opacity .25s ease;

        }


        .admin-sidebar-overlay.show {

            display: block;

            opacity: 1;

            pointer-events: auto;

        }


        /* =========================================================
           ACCESSIBILITY
        ========================================================== */

        .admin-shell :where(
            a,
            button,
            input,
            select,
            textarea
        ):focus-visible {

            outline:
                2px solid var(--admin-blue-light);

            outline-offset:
                2px;

        }


        .admin-shell :where(
            a,
            button
        ) {

            -webkit-tap-highlight-color:
                transparent;

        }


        /* =========================================================
           RESPONSIVE 1200
        ========================================================== */

        @media(max-width:1200px) {

            :root {

                --admin-sidebar-width:
                    250px;

            }


            .admin-header {

                padding:
                    0 20px;

            }


            .admin-page-content {

                padding:
                    20px;

            }

        }


        /* =========================================================
           RESPONSIVE 1024
        ========================================================== */

        @media(max-width:1024px) {

            .admin-sidebar {

                width:
                    min(
                        var(--admin-sidebar-width),
                        86vw
                    );

                transform:
                    translateX(-100%);

                box-shadow:
                    18px 0 50px rgba(0,0,0,.35);

            }


            .admin-sidebar.open {

                transform:
                    translateX(0);

                box-shadow:
                    18px 0 60px rgba(0,0,0,.45);

            }


            .admin-sidebar-close {

                display: flex;

            }


            .admin-main {

                width: 100%;

                margin-left: 0;

                min-width: 0;

            }


            .admin-header {

                width: 100%;

            }


            .admin-mobile-btn {

                display: flex;

            }


            .admin-header-left {

                flex: 1;

                min-width: 0;

            }

        }


        /* =========================================================
           TABLET 768
        ========================================================== */

        @media(max-width:768px) {

            :root {

                --admin-header-height:
                    68px;

            }


            .admin-header {

                height:
                    var(--admin-header-height);

                padding:
                    0 14px;

                gap:
                    10px;

            }


            .admin-header-title {

                font-size:
                    16px;

            }


            .admin-header-right {

                gap:
                    7px;

            }


            .admin-notification-button {

                width:
                    38px;

                height:
                    38px;

            }


            .admin-profile-summary,
            .admin-profile-area .admin-profile-arrow {

                display:
                    none;

            }


            .admin-profile-avatar {

                width:
                    38px;

                height:
                    38px;

            }


            .admin-notification-menu {

                position: fixed;

                top:
                    62px;

                left:
                    10px;

                right:
                    10px;

                width:
                    auto;

                max-height:
                    70vh;

            }


            .admin-profile-menu {

                position: fixed;

                top:
                    62px;

                right:
                    10px;

                width:
                    240px;

            }


            .admin-page-content {

                padding:
                    15px;

                width:
                    100%;

                min-width:
                    0;

            }


            .admin-sidebar-header {

                min-height:
                    82px;

                padding:
                    14px 15px;

            }


            .admin-sidebar-logo {

                width:
                    48px;

                height:
                    48px;

            }


            .admin-sidebar-text h2 {

                font-size:
                    15px;

            }


            .admin-menu-item {

                min-height:
                    48px;

            }


            .admin-submenu-item {

                min-height:
                    42px;

            }

        }


        /* =========================================================
           SMALL PHONES
        ========================================================== */

        @media(max-width:480px) {

            .admin-header {

                padding-left:
                    max(
                        10px,
                        env(safe-area-inset-left)
                    );

                padding-right:
                    max(
                        10px,
                        env(safe-area-inset-right)
                    );

            }


            .admin-header-title {

                display:
                    none;

            }


            .admin-mobile-btn {

                width:
                    40px;

                height:
                    40px;

            }


            .admin-page-content {

                padding-left:
                    max(
                        10px,
                        env(safe-area-inset-left)
                    );

                padding-right:
                    max(
                        10px,
                        env(safe-area-inset-right)
                    );

                padding-top:
                    10px;

                padding-bottom:
                    10px;

            }


            .admin-sidebar {

                width:
                    min(
                        300px,
                        88vw
                    );

            }


            .admin-sidebar-close {

                width:
                    40px;

                height:
                    40px;

            }


            .admin-notification-button {

                width:
                    40px;

                height:
                    40px;

            }


            .admin-notification-menu {

                top:
                    58px;

                left:
                    8px;

                right:
                    8px;

            }


            .admin-profile-menu {

                top:
                    58px;

                right:
                    8px;

                width:
                    calc(
                        100vw - 16px
                    );

                max-width:
                    260px;

            }

        }


        /* =========================================================
           360
        ========================================================== */

        @media(max-width:360px) {

            .admin-sidebar {

                width:
                    92vw;

            }


            .admin-header-right {

                gap:
                    4px;

            }


            .admin-profile-menu {

                left:
                    8px;

                right:
                    8px;

                width:
                    auto;

                max-width:
                    none;

            }

        }


        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media(prefers-reduced-motion: reduce) {

            .admin-shell *,

            .admin-shell *::before,

            .admin-shell *::after {

                scroll-behavior:
                    auto !important;

                animation-duration:
                    .01ms !important;

                animation-iteration-count:
                    1 !important;

                transition-duration:
                    .01ms !important;

            }

        }


        /* =========================================================
           PRINT
        ========================================================== */

        @media print {

            .admin-sidebar,
            .admin-header,
            .admin-sidebar-overlay {

                display:
                    none !important;

            }


            .admin-main {

                width:
                    100% !important;

                margin-left:
                    0 !important;

                padding-top:
                    0 !important;

            }


            .admin-page-content {

                padding:
                    0 !important;

                min-height:
                    auto !important;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


<div class="admin-shell">


    {{-- =========================================================
         SIDEBAR OVERLAY
    ========================================================== --}}

    <div
        class="admin-sidebar-overlay"
        id="adminSidebarOverlay"
    ></div>


    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    <aside
        class="admin-sidebar"
        id="adminSidebar"
    >

        <button
            type="button"
            class="admin-sidebar-close"
            onclick="closeAdminSidebar()"
            aria-label="Close sidebar"
        >
            <i class="fas fa-xmark"></i>
        </button>


        {{-- BRAND --}}

        <div class="admin-sidebar-header">

            <img
                src="{{ asset('images/MMACI Logo.jpg') }}"
                alt="MMACI Logo"
                class="admin-sidebar-logo"
            >

            <div class="admin-sidebar-text">

                <h2>
                    OBT Supervisor
                </h2>

                <p>
                    On Board Training Report System
                </p>

            </div>

        </div>


        {{-- NAVIGATION --}}

        <nav class="admin-sidebar-menu">


            <div class="admin-menu-section">
                Main
            </div>


            {{-- Dashboard --}}

            <a
                href="{{ route('admin.dashboard') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}
                "
            >

                <i class="fas fa-chart-pie"></i>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- Cadets --}}

            <a
                href="{{ route('admin.cadets.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.cadets.*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-users"></i>

                <span>
                    Cadets
                </span>

            </a>


            {{-- Deployment --}}

            <a
                href="{{ route('admin.deployment.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.deployment.*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-ship"></i>

                <span>
                    Deployment
                </span>

            </a>


            <div class="admin-menu-section">
                Training Management
            </div>


            {{-- OBT Requirements --}}

            <div class="admin-menu-group">

                <button
                    type="button"
                    class="admin-menu-item"
                    onclick="toggleAdminOBTMenu()"
                >

                    <i class="fas fa-folder-open"></i>

                    <span>
                        OBT Cadet Requirements
                    </span>

                    <i
                        class="
                            fas
                            fa-chevron-down
                            admin-menu-arrow
                            {{
                                request()->routeIs('admin.verification.*')
                                || request()->routeIs('admin.cadet.requirements.*')
                                || request()->routeIs('admin.cadet.bs.*')
                                || request()->routeIs('admin.shipped-so.*')
                                ? 'rotate'
                                : ''
                            }}
                        "
                        id="adminObtArrow"
                    ></i>

                </button>


                <div
                    class="
                        admin-submenu
                        {{
                            request()->routeIs('admin.verification.*')
                            || request()->routeIs('admin.cadet.requirements.*')
                            || request()->routeIs('admin.cadet.bs.*')
                            || request()->routeIs('admin.shipped-so.*')
                            ? 'show'
                            : ''
                        }}
                    "
                    id="adminObtMenu"
                >

                    <a
                        href="{{ route('admin.verification.index') }}"
                        class="
                            admin-submenu-item
                            {{ request()->routeIs('admin.verification.*') ? 'active' : '' }}
                        "
                    >

                        <i class="fas fa-user-check"></i>

                        <span>
                            Before OBT Requirements
                        </span>

                    </a>


                    <a
                        href="{{ route('admin.cadet.requirements.index') }}"
                        class="
                            admin-submenu-item
                            {{ request()->routeIs('admin.cadet.requirements.*') ? 'active' : '' }}
                        "
                    >

                        <i class="fas fa-file-circle-check"></i>

                        <span>
                            During OBT Requirements
                        </span>

                    </a>


                    <a
                        href="{{ route('admin.cadet.bs.index') }}"
                        class="
                            admin-submenu-item
                            {{ request()->routeIs('admin.cadet.bs.*') ? 'active' : '' }}
                        "
                    >

                        <i class="fas fa-graduation-cap"></i>

                        <span>
                            After OBT Requirements
                        </span>

                    </a>


                    <a
                        href="{{ route('admin.shipped-so.index') }}"
                        class="
                            admin-submenu-item
                            {{ request()->routeIs('admin.shipped-so.*') ? 'active' : '' }}
                        "
                    >

                        <i class="fas fa-file-signature"></i>

                        <span>
                            Special Order
                        </span>

                    </a>

                </div>

            </div>


            {{-- Concerns --}}

            <a
                href="{{ route('admin.complaints.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}
            "
            >

                <i class="fas fa-comments"></i>

                <span>
                    Concerns
                </span>

            </a>


            {{-- Chat --}}

            <a
                href="{{ route('chat.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('chat.*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-message"></i>

                <span>
                    Chat
                </span>

            </a>


            <div class="admin-menu-section">
                Administration
            </div>


            {{-- Reporting --}}

            <a
                href="{{ route('admin.reports.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-chart-column"></i>

                <span>
                    Reporting
                </span>

            </a>


            {{-- Users --}}

            <a
                href="{{ route('admin.users.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.users.*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-user-shield"></i>

                <span>
                    User Accounts
                </span>

            </a>


            {{-- Locations --}}

            <a
                href="{{ route('admin.admin.locations') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.admin.locations*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-location-dot"></i>

                <span>
                    Locations
                </span>

            </a>


            {{-- Remarks --}}

            <a
                href="{{ route('admin.remarks.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.remarks.*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-note-sticky"></i>

                <span>
                    Remarks
                </span>

            </a>


            {{-- Settings --}}

            <a
                href="{{ route('admin.settings.index') }}"
                class="
                    admin-menu-item
                    {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}
                "
            >

                <i class="fas fa-gear"></i>

                <span>
                    Settings
                </span>

            </a>


            <div class="admin-sidebar-divider"></div>


            {{-- Logout --}}

            <form
                method="POST"
                action="{{ route('admin.logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="admin-menu-item"
                >

                    <i class="fas fa-right-from-bracket"></i>

                    <span>
                        Logout
                    </span>

                </button>

            </form>


        </nav>

    </aside>


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <main class="admin-main">


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <header class="admin-header">


            <div class="admin-header-left">

                <button
                    type="button"
                    class="admin-mobile-btn"
                    onclick="toggleAdminSidebar()"
                    aria-label="Open sidebar"
                >

                    <i class="fas fa-bars"></i>

                </button>


                <h1 class="admin-header-title">

                    @yield(
                        'header-title',
                        'Dashboard'
                    )

                </h1>

            </div>


            <div class="admin-header-right">


                {{-- =================================================
                     NOTIFICATIONS
                ================================================== --}}

                <div class="admin-notification-wrapper">


                    <button
                        type="button"
                        class="admin-notification-button"
                        id="adminNotificationButton"
                        onclick="toggleAdminNotificationMenu(event)"
                        aria-label="Notifications"
                        aria-expanded="false"
                    >

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                        >

                            <path
                                d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M13.73 21a2 2 0 0 1-3.46 0"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                        </svg>


                        <span
                            class="admin-notification-badge"
                            id="adminNotificationBadge"
                            style="{{ ($unreadCount ?? 0) > 0 ? '' : 'display:none;' }}"
                        >
                            {{ $unreadCount ?? 0 }}
                        </span>

                    </button>


                    <div
                        class="admin-notification-menu"
                        id="adminNotificationMenu"
                    >


                        <div class="admin-notification-header">

                            <span>
                                Notifications
                            </span>


                            <span
                                id="adminNotificationUnreadText"
                                style="
                                    color:#60a5fa;
                                    font-size:10px;
                                    {{ ($unreadCount ?? 0) > 0 ? '' : 'display:none;' }}
                                "
                            >

                                {{ $unreadCount ?? 0 }} unread

                            </span>

                        </div>


                        <div id="adminNotificationList">


                            @forelse(
                                $notifications ?? [] as $notification
                            )

                                <a
                                    href="{{ route('notifications.open', $notification->id) }}"
                                    class="admin-notification-link"
                                    data-notification-id="{{ $notification->id }}"
                                    style="text-decoration:none;"
                                >

                                    <div
                                        class="
                                            admin-notification-item
                                            {{ is_null($notification->read_at) ? 'unread' : '' }}
                                        "
                                    >

                                        <div class="admin-notif-icon">

                                            @php
                                                $icon = $notification->data['icon'] ?? 'fa-bell';
                                            @endphp

                                            @if(str_starts_with($icon, 'fa-'))

                                                <i class="fas {{ $icon }}"></i>

                                            @else

                                                {{ $icon }}

                                            @endif

                                        </div>


                                        <div class="admin-notif-content">

                                            <div class="admin-notif-text">

                                                {{ $notification->data['message'] ?? 'Notification' }}

                                            </div>


                                            <div class="admin-notif-time">

                                                {{ $notification->created_at->diffForHumans() }}

                                            </div>

                                        </div>

                                    </div>

                                </a>

                            @empty

                                <div
                                    class="admin-notification-item"
                                    id="adminNoNotifications"
                                >

                                    <div class="admin-notif-icon">

                                        <i class="fas fa-bell-slash"></i>

                                    </div>


                                    <div class="admin-notif-content">

                                        <div class="admin-notif-text">

                                            No notifications found.

                                        </div>


                                        <div class="admin-notif-time">

                                            You're all caught up.

                                        </div>

                                    </div>

                                </div>

                            @endforelse


                        </div>


                        <a
                            href="{{ route('admin.notifications') }}"
                            class="admin-view-all"
                        >

                            View All Notifications

                            <i
                                class="fas fa-arrow-right"
                                style="margin-left:5px;"
                            ></i>

                        </a>


                    </div>

                </div>


                {{-- =================================================
                     PROFILE
                ================================================== --}}

                <div class="admin-profile-dropdown">


                    <div
                        class="admin-profile-area"
                        onclick="toggleAdminProfileMenu(event)"
                    >

                        <div class="admin-profile-avatar">

                            <img
                                src="{{
                                    Auth::user()->profile_picture
                                    ? Storage::url(Auth::user()->profile_picture)
                                    : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff'
                                }}"
                                alt="Profile"
                                onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=fff';"
                            >

                        </div>


                        <div class="admin-profile-summary">

                            <span class="admin-profile-name">

                                {{ Auth::user()->name }}

                            </span>


                            <span class="admin-profile-role">

                                Administrator

                            </span>

                        </div>


                        <i
                            class="
                                fas
                                fa-chevron-down
                                admin-profile-arrow
                            "
                        ></i>

                    </div>


                    <div
                        class="admin-profile-menu"
                        id="adminProfileMenu"
                    >


                        <div class="admin-profile-card">


                            <div class="admin-profile-avatar big">

                                <img
                                    src="{{
                                        Auth::user()->profile_picture
                                        ? Storage::url(Auth::user()->profile_picture)
                                        : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2563eb&color=fff'
                                    }}"
                                    alt="Profile"
                                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563eb&color=fff';"
                                >

                            </div>


                            <div>

                                <div class="admin-profile-name">

                                    {{ Auth::user()->name }}

                                </div>


                                <div class="admin-profile-role">

                                    Administrator

                                </div>

                            </div>


                        </div>


                        <a
                            href="{{ route('admin.profile') }}"
                        >

                            <i class="fas fa-user"></i>

                            <span>
                                View Profile
                            </span>

                        </a>


                        <a
                            href="{{ route('admin.settings.index') }}"
                        >

                            <i class="fas fa-gear"></i>

                            <span>
                                System Settings
                            </span>

                        </a>


                        <form
                            method="POST"
                            action="{{ route('admin.logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="admin-logout-btn"
                            >

                                <i
                                    class="fas fa-right-from-bracket"
                                    style="margin-right:8px;"
                                ></i>

                                Log Out

                            </button>

                        </form>


                    </div>

                </div>


            </div>

        </header>


        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}

        <div class="admin-page-content">

            @yield('content')

        </div>


    </main>


</div>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =========================================================
       ELEMENTS
    ========================================================== */

    const sidebar =
        document.getElementById('adminSidebar');

    const overlay =
        document.getElementById('adminSidebarOverlay');

    const profileMenu =
        document.getElementById('adminProfileMenu');

    const notificationMenu =
        document.getElementById('adminNotificationMenu');

    const notificationButton =
        document.getElementById('adminNotificationButton');

    const notificationBadge =
        document.getElementById('adminNotificationBadge');

    const notificationUnreadText =
        document.getElementById('adminNotificationUnreadText');

    const notificationList =
        document.getElementById('adminNotificationList');

    const obtMenu =
        document.getElementById('adminObtMenu');

    const obtArrow =
        document.getElementById('adminObtArrow');


    /* =========================================================
       CURRENT USER
    ========================================================== */

    const userIdMeta =
        document.querySelector('meta[name="user-id"]');

    const userId =
        userIdMeta
            ? userIdMeta.getAttribute('content')
            : null;


    /* =========================================================
       LOCAL UNREAD COUNT
    ========================================================== */

    let adminUnreadCount =
        Number(
            notificationBadge
                ? notificationBadge.textContent.trim()
                : 0
        ) || 0;


    /* =========================================================
       UPDATE NOTIFICATION BADGE
    ========================================================== */

    function updateNotificationBadge(count) {

        adminUnreadCount =
            Math.max(0, Number(count) || 0);


        if (!notificationBadge) {

            return;

        }


        if (adminUnreadCount > 0) {

            notificationBadge.textContent =
                adminUnreadCount;

            notificationBadge.style.display =
                'flex';

        } else {

            notificationBadge.textContent =
                '0';

            notificationBadge.style.display =
                'none';

        }


        if (notificationUnreadText) {

            if (adminUnreadCount > 0) {

                notificationUnreadText.textContent =
                    adminUnreadCount + ' unread';

                notificationUnreadText.style.display =
                    '';

            } else {

                notificationUnreadText.textContent =
                    '';

                notificationUnreadText.style.display =
                    'none';

            }

        }

    }


    /* =========================================================
       REALTIME NOTIFICATION HTML
    ========================================================== */

    function createRealtimeNotification(notification) {

        if (!notificationList) {

            return;

        }


        const emptyState =
            document.getElementById(
                'adminNoNotifications'
            );


        if (emptyState) {

            emptyState.remove();

        }


        const url =
            notification.url ||
            notification.data?.url ||
            '#';


        const message =
            notification.message ||
            notification.data?.message ||
            'New notification';


        const icon =
            notification.icon ||
            notification.data?.icon ||
            'fa-bell';


        const id =
            notification.id ||
            notification.data?.id ||
            ('realtime-' + Date.now());


        const createdAt =
            notification.created_at ||
            notification.data?.created_at ||
            new Date().toISOString();


        const item =
            document.createElement('a');


        item.href =
            url;

        item.className =
            'admin-notification-link';

        item.dataset.notificationId =
            id;

        item.style.textDecoration =
            'none';


        const wrapper =
            document.createElement('div');

        wrapper.className =
            'admin-notification-item unread realtime-new';


        const iconContainer =
            document.createElement('div');

        iconContainer.className =
            'admin-notif-icon';


        if (
            typeof icon === 'string' &&
            icon.startsWith('fa-')
        ) {

            const iconElement =
                document.createElement('i');

            iconElement.className =
                'fas ' + icon;

            iconContainer.appendChild(
                iconElement
            );

        } else {

            iconContainer.textContent =
                icon;

        }


        const content =
            document.createElement('div');

        content.className =
            'admin-notif-content';


        const text =
            document.createElement('div');

        text.className =
            'admin-notif-text';

        text.textContent =
            message;


        const time =
            document.createElement('div');

        time.className =
            'admin-notif-time';

        time.textContent =
            'Just now';


        content.appendChild(text);

        content.appendChild(time);


        wrapper.appendChild(
            iconContainer
        );

        wrapper.appendChild(
            content
        );


        item.appendChild(
            wrapper
        );


        /*
         * Put the newest notification at the top.
         */

        notificationList.prepend(item);


        /*
         * Prevent the notification dropdown from
         * becoming excessively large.
         */

        const items =
            notificationList.querySelectorAll(
                '.admin-notification-link'
            );


        if (items.length > 20) {

            items[items.length - 1].remove();

        }


        updateNotificationBadge(
            adminUnreadCount + 1
        );


        /*
         * Animate bell.
         */

        if (notificationButton) {

            notificationButton.classList.remove(
                'realtime-pulse'
            );


            void notificationButton.offsetWidth;


            notificationButton.classList.add(
                'realtime-pulse'
            );


            setTimeout(function () {

                notificationButton.classList.remove(
                    'realtime-pulse'
                );

            }, 700);

        }

    }


    /* =========================================================
       REALTIME NOTIFICATION LISTENER
       
       IMPORTANT:
       Laravel's default notification channel is:

       App.Models.User.{userId}

       This is the ONLY notification listener in this layout.
       Do not duplicate this listener in child Blade pages.
    ========================================================== */

    function initializeRealtimeNotifications() {

        if (!userId) {

            console.warn(
                '[Admin Notifications] No authenticated user ID found.'
            );

            return;

        }


        if (
            typeof window.Echo === 'undefined'
        ) {

            console.warn(
                '[Admin Notifications] Laravel Echo is not available.'
            );

            return;

        }


        try {

            const channelName =
                'App.Models.User.' + userId;


            console.log(
                '[Admin Notifications] Subscribing to:',
                channelName
            );


            window.Echo
                .private(channelName)
                .notification(function (notification) {

                    console.log(
                        '[Admin Notifications] Realtime notification received:',
                        notification
                    );


                    createRealtimeNotification(
                        notification
                    );

                });


            console.log(
                '[Admin Notifications] Realtime listener initialized.'
            );

        } catch (error) {

            console.error(
                '[Admin Notifications] Failed to initialize realtime notifications:',
                error
            );

        }

    }


    /*
     * Wait a little for app.js / Echo initialization.
     *
     * This avoids racing against Vite's Echo setup.
     */

    if (typeof window.Echo !== 'undefined') {

        initializeRealtimeNotifications();

    } else {

        let echoAttempts =
            0;

        const echoTimer =
            setInterval(function () {

                echoAttempts++;


                if (
                    typeof window.Echo !== 'undefined'
                ) {

                    clearInterval(
                        echoTimer
                    );

                    initializeRealtimeNotifications();

                }


                if (echoAttempts >= 20) {

                    clearInterval(
                        echoTimer
                    );

                    console.warn(
                        '[Admin Notifications] Echo initialization timeout.'
                    );

                }

            }, 250);

    }


    /* =========================================================
       SIDEBAR
    ========================================================== */

    window.toggleAdminSidebar = function () {

        if (!sidebar || !overlay) {

            return;

        }


        sidebar.classList.toggle('open');

        overlay.classList.toggle('show');

    };


    window.closeAdminSidebar = function () {

        if (!sidebar || !overlay) {

            return;

        }


        sidebar.classList.remove('open');

        overlay.classList.remove('show');

    };


    if (overlay) {

        overlay.addEventListener(
            'click',
            function () {

                closeAdminSidebar();

            }
        );

    }


    /* =========================================================
       PROFILE
    ========================================================== */

    window.toggleAdminProfileMenu = function (event) {

        if (event) {

            event.stopPropagation();

        }


        if (!profileMenu) {

            return;

        }


        profileMenu.classList.toggle('show');


        if (notificationMenu) {

            notificationMenu.classList.remove('show');

        }


        if (notificationButton) {

            notificationButton.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    };


    /* =========================================================
       NOTIFICATIONS
    ========================================================== */

    window.toggleAdminNotificationMenu = function (event) {

        if (event) {

            event.stopPropagation();

        }


        if (!notificationMenu) {

            return;

        }


        const isShowing =
            notificationMenu.classList.toggle('show');


        if (notificationButton) {

            notificationButton.setAttribute(
                'aria-expanded',
                isShowing
                    ? 'true'
                    : 'false'
            );

        }


        if (profileMenu) {

            profileMenu.classList.remove('show');

        }

    };


    /* =========================================================
       OBT MENU
    ========================================================== */

    window.toggleAdminOBTMenu = function () {

        if (!obtMenu || !obtArrow) {

            return;

        }


        obtMenu.classList.toggle('show');

        obtArrow.classList.toggle('rotate');

    };


    /* =========================================================
       CLOSE ALL DROPDOWNS
    ========================================================== */

    function closeAdminDropdowns() {

        if (profileMenu) {

            profileMenu.classList.remove('show');

        }


        if (notificationMenu) {

            notificationMenu.classList.remove('show');

        }


        if (notificationButton) {

            notificationButton.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    }


    /* =========================================================
       DOCUMENT CLICK
    ========================================================== */

    document.addEventListener(
        'click',
        function (event) {


            if (
                profileMenu &&
                !event.target.closest(
                    '.admin-profile-dropdown'
                )
            ) {

                profileMenu.classList.remove(
                    'show'
                );

            }


            if (
                notificationMenu &&
                !event.target.closest(
                    '.admin-notification-wrapper'
                )
            ) {

                notificationMenu.classList.remove(
                    'show'
                );


                if (notificationButton) {

                    notificationButton.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }

            }

        }
    );


    /* =========================================================
       ESCAPE
    ========================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {

                return;

            }


            closeAdminSidebar();

            closeAdminDropdowns();

        }
    );


    /* =========================================================
       MOBILE SIDEBAR LINKS
    ========================================================== */

    document
        .querySelectorAll(
            '.admin-sidebar a'
        )
        .forEach(function (link) {

            link.addEventListener(
                'click',
                function () {

                    if (
                        window.innerWidth <= 1024
                    ) {

                        closeAdminSidebar();

                    }

                }
            );

        });


    /* =========================================================
       RESIZE
    ========================================================== */

    window.addEventListener(
        'resize',
        function () {

            if (
                window.innerWidth > 1024
            ) {

                closeAdminSidebar();

            }

        }
    );


});

</script>


@stack('scripts')


</body>

</html>