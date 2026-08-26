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
        name="theme-color"
        content="#061426"
    >

    <title>
        On-board Training Report System - Merchant Marine Academy of Caraga Inc.
    </title>


    {{-- =========================================================
         FONT
    ========================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- =========================================================
         FONT AWESOME
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/css/all.min.css"
    >


    <style>

        /* =========================================================
   GLOBAL PAGE RESET
   Removes the default white browser margin
========================================================= */

html,
body {
    margin: 0;
    padding: 0;
    width: 100%;
    min-height: 100%;
    background: #020b16;
}

body {
    overflow-x: hidden;
}

        /* =========================================================
           LANDING PAGE
           ---------------------------------------------------------
           Everything is scoped to .landing-page.
           This prevents the styles from leaking into other pages.
        ========================================================== */

        .landing-page {

            --lp-navy-950: #020b16;
            --lp-navy-900: #061426;
            --lp-navy-850: #081a2f;
            --lp-navy-800: #0a213a;
            --lp-navy-700: #103452;

            --lp-blue: #3b82f6;
            --lp-blue-light: #60a5fa;
            --lp-blue-soft: #bfdbfe;

            --lp-cyan: #38bdf8;
            --lp-white: #ffffff;
            --lp-text: #e2e8f0;
            --lp-muted: #94a3b8;

            --lp-border:
                rgba(255,255,255,.10);

            --lp-glass:
                rgba(6,20,38,.72);

            --lp-shadow:
                0 25px 70px rgba(0,0,0,.35);

            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 0;

            position: relative;

            overflow-x: hidden;

            font-family:
                'Inter',
                -apple-system,
                BlinkMacSystemFont,
                'Segoe UI',
                sans-serif;

            color: var(--lp-white);

            background:
                var(--lp-navy-950);

        }


        /* =========================================================
           RESET — SCOPED
        ========================================================== */

        .landing-page *,
        .landing-page *::before,
        .landing-page *::after {

            box-sizing: border-box;

        }


        .landing-page button,
        .landing-page a {

            -webkit-tap-highlight-color:
                transparent;

        }


        .landing-page button {

            font-family:
                inherit;

        }


        .landing-page a {

            text-decoration:
                none;

        }


        /* =========================================================
           BACKGROUND SLIDESHOW
        ========================================================== */

        .landing-page .lp-background {

            position: absolute;

            inset: 0;

            overflow: hidden;

            z-index: 0;

        }


        .landing-page .lp-slide {

            position: absolute;

            inset: 0;

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

            opacity: 0;

            transform: scale(1.04);

            animation:
                lpSlideshow 24s infinite;

        }


        .landing-page .lp-slide::after {

            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    180deg,
                    rgba(2,11,22,.70) 0%,
                    rgba(2,11,22,.58) 35%,
                    rgba(2,11,22,.78) 72%,
                    rgba(2,11,22,.98) 100%
                );

        }


        .landing-page .lp-slide-1 {

            background-image:
                url('{{ asset("images/Background1.jpg") }}');

            animation-delay:
                0s;

        }


        .landing-page .lp-slide-2 {

            background-image:
                url('{{ asset("images/Background2.jpg") }}');

            animation-delay:
                6s;

        }


        .landing-page .lp-slide-3 {

            background-image:
                url('{{ asset("images/Background3.jpg") }}');

            animation-delay:
                12s;

        }


        .landing-page .lp-slide-4 {

            background-image:
                url('{{ asset("images/Background4.jpg") }}');

            animation-delay:
                18s;

        }


        @keyframes lpSlideshow {

            0% {

                opacity:
                    0;

                transform:
                    scale(1.04);

            }

            5% {

                opacity:
                    1;

            }

            25% {

                opacity:
                    1;

            }

            30% {

                opacity:
                    0;

                transform:
                    scale(1.09);

            }

            100% {

                opacity:
                    0;

                transform:
                    scale(1.09);

            }

        }


        /* =========================================================
           BACKGROUND LIGHT
        ========================================================== */

        .landing-page .lp-atmosphere {

            position: absolute;

            inset: 0;

            z-index: 0;

            pointer-events: none;

            background:

                radial-gradient(
                    circle at 15% 25%,
                    rgba(59,130,246,.18),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 85% 30%,
                    rgba(56,189,248,.12),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 50% 80%,
                    rgba(37,99,235,.14),
                    transparent 35%
                );

        }


        .landing-page .lp-grid {

            position: absolute;

            inset: 0;

            z-index: 0;

            opacity: .16;

            pointer-events: none;

            background-image:

                linear-gradient(
                    rgba(255,255,255,.035) 1px,
                    transparent 1px
                ),

                linear-gradient(
                    90deg,
                    rgba(255,255,255,.035) 1px,
                    transparent 1px
                );

            background-size:
                55px 55px;

            mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent 85%
                );

            -webkit-mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent 85%
                );

        }


        /* =========================================================
           HEADER
        ========================================================== */

        .landing-page .lp-header {

            position: sticky;

            top: 0;

            z-index: 1000;

            background:
                rgba(3,14,27,.78);

            border-bottom:
                1px solid rgba(255,255,255,.08);

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);

        }


        .landing-page .lp-header-inner {

            width:
                min(1240px, calc(100% - 40px));

            min-height:
                82px;

            margin:
                0 auto;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                25px;

        }


        /* =========================================================
           BRAND
        ========================================================== */

        .landing-page .lp-brand {

            display:
                flex;

            align-items:
                center;

            gap:
                13px;

            min-width:
                0;

        }


        .landing-page .lp-logo {

            width:
                56px;

            height:
                56px;

            flex-shrink:
                0;

            object-fit:
                cover;

            border-radius:
                50%;

            border:
                2px solid rgba(255,255,255,.18);

            box-shadow:
                0 8px 25px rgba(0,0,0,.3);

        }


        .landing-page .lp-brand-text {

            min-width:
                0;

        }


        .landing-page .lp-brand-name {

            display:
                block;

            color:
                #ffffff;

            font-size:
                14px;

            font-weight:
                800;

            line-height:
                1.25;

        }


        .landing-page .lp-brand-system {

            display:
                block;

            margin-top:
                3px;

            color:
                #93c5fd;

            font-size:
                10px;

            font-weight:
                500;

            letter-spacing:
                .5px;

        }


        /* =========================================================
           HEADER STATUS
        ========================================================== */

        .landing-page .lp-header-right {

            display:
                flex;

            align-items:
                center;

            gap:
                15px;

            flex-shrink:
                0;

        }


        .landing-page .lp-system-status {

            display:
                flex;

            align-items:
                center;

            gap:
                8px;

            padding:
                8px 12px;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius:
                999px;

            background:
                rgba(255,255,255,.05);

            color:
                #cbd5e1;

            font-size:
                10px;

            font-weight:
                600;

        }


        .landing-page .lp-status-dot {

            width:
                7px;

            height:
                7px;

            border-radius:
                50%;

            background:
                #22c55e;

            box-shadow:
                0 0 12px rgba(34,197,94,.8);

        }


        .landing-page .lp-login-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                9px;

            min-height:
                44px;

            padding:
                0 19px;

            border:
                1px solid rgba(147,197,253,.35);

            border-radius:
                11px;

            background:
                linear-gradient(
                    135deg,
                    #1d4ed8,
                    #2563eb
                );

            color:
                #ffffff;

            font-size:
                12px;

            font-weight:
                700;

            cursor:
                pointer;

            box-shadow:
                0 8px 25px rgba(37,99,235,.22);

            transition:
                .25s ease;

        }


        .landing-page .lp-login-btn:hover {

            transform:
                translateY(-2px);

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            box-shadow:
                0 12px 32px rgba(37,99,235,.35);

        }


        .landing-page .lp-login-btn:active {

            transform:
                translateY(0) scale(.98);

        }


        /* =========================================================
           HERO
        ========================================================== */

        .landing-page .lp-hero {

            position:
                relative;

            z-index:
                2;

            width:
                min(1120px, calc(100% - 40px));

            min-height:
                650px;

            margin:
                0 auto;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                75px 0 65px;

            text-align:
                center;

        }


        .landing-page .lp-hero-content {

            max-width:
                900px;

        }


        .landing-page .lp-eyebrow {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                9px;

            padding:
                8px 14px;

            margin-bottom:
                22px;

            border:
                1px solid rgba(147,197,253,.20);

            border-radius:
                999px;

            background:
                rgba(15,52,82,.58);

            color:
                #bfdbfe;

            font-size:
                10px;

            font-weight:
                700;

            letter-spacing:
                1.4px;

            text-transform:
                uppercase;

            backdrop-filter:
                blur(10px);

        }


        .landing-page .lp-eyebrow i {

            color:
                #60a5fa;

        }


        .landing-page .lp-title {

            margin:
                0;

            color:
                #ffffff;

            font-size:
                clamp(
                    42px,
                    6vw,
                    72px
                );

            font-weight:
                800;

            line-height:
                1.04;

            letter-spacing:
                -2.5px;

            text-shadow:
                0 12px 45px rgba(0,0,0,.35);

        }


        .landing-page .lp-title-accent {

            display:
                block;

            background:
                linear-gradient(
                    90deg,
                    #ffffff 0%,
                    #bfdbfe 45%,
                    #60a5fa 100%
                );

            -webkit-background-clip:
                text;

            background-clip:
                text;

            -webkit-text-fill-color:
                transparent;

        }


        .landing-page .lp-subtitle {

            max-width:
                720px;

            margin:
                24px auto 0;

            color:
                #cbd5e1;

            font-size:
                16px;

            line-height:
                1.8;

        }


        .landing-page .lp-actions {

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            flex-wrap:
                wrap;

            gap:
                12px;

            margin-top:
                32px;

        }


        .landing-page .lp-primary-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                10px;

            min-height:
                50px;

            padding:
                0 25px;

            border:
                0;

            border-radius:
                12px;

            background:
                linear-gradient(
                    135deg,
                    #dbeafe,
                    #93c5fd
                );

            color:
                #071525;

            font-size:
                13px;

            font-weight:
                800;

            cursor:
                pointer;

            box-shadow:
                0 12px 35px rgba(96,165,250,.25);

            transition:
                .25s ease;

        }


        .landing-page .lp-primary-btn:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 18px 45px rgba(96,165,250,.35);

        }


        .landing-page .lp-secondary-btn {

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                9px;

            min-height:
                50px;

            padding:
                0 22px;

            border:
                1px solid rgba(255,255,255,.15);

            border-radius:
                12px;

            background:
                rgba(255,255,255,.06);

            color:
                #e2e8f0;

            font-size:
                13px;

            font-weight:
                700;

            backdrop-filter:
                blur(10px);

            transition:
                .25s ease;

        }


        .landing-page .lp-secondary-btn:hover {

            background:
                rgba(255,255,255,.10);

            border-color:
                rgba(255,255,255,.25);

            transform:
                translateY(-2px);

        }


        /* =========================================================
           HERO STATS
        ========================================================== */

        .landing-page .lp-stats {

            display:
                flex;

            justify-content:
                center;

            flex-wrap:
                wrap;

            gap:
                12px;

            margin-top:
                48px;

        }


        .landing-page .lp-stat {

            min-width:
                150px;

            padding:
                15px 20px;

            border:
                1px solid rgba(255,255,255,.09);

            border-radius:
                14px;

            background:
                rgba(3,14,27,.48);

            backdrop-filter:
                blur(12px);

        }


        .landing-page .lp-stat strong {

            display:
                block;

            color:
                #ffffff;

            font-size:
                18px;

            font-weight:
                800;

        }


        .landing-page .lp-stat span {

            display:
                block;

            margin-top:
                3px;

            color:
                #94a3b8;

            font-size:
                9px;

            font-weight:
                600;

            letter-spacing:
                .7px;

            text-transform:
                uppercase;

        }


        /* =========================================================
           SECTION
        ========================================================== */

        .landing-page .lp-section {

            position:
                relative;

            z-index:
                3;

            width:
                min(1180px, calc(100% - 40px));

            margin:
                0 auto;

            padding:
                30px 0 80px;

        }


        .landing-page .lp-section-heading {

            max-width:
                680px;

            margin:
                0 auto 35px;

            text-align:
                center;

        }


        .landing-page .lp-section-label {

            color:
                #60a5fa;

            font-size:
                10px;

            font-weight:
                800;

            letter-spacing:
                1.8px;

            text-transform:
                uppercase;

        }


        .landing-page .lp-section-title {

            margin:
                8px 0 10px;

            color:
                #ffffff;

            font-size:
                clamp(
                    25px,
                    4vw,
                    34px
                );

            font-weight:
                800;

        }


        .landing-page .lp-section-description {

            color:
                #94a3b8;

            font-size:
                13px;

            line-height:
                1.7;

        }


        /* =========================================================
           FEATURES
        ========================================================== */

        .landing-page .lp-feature-grid {

            display:
                grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap:
                16px;

        }


        .landing-page .lp-feature-card {

            position:
                relative;

            min-height:
                260px;

            padding:
                25px;

            overflow:
                hidden;

            border:
                1px solid rgba(255,255,255,.09);

            border-radius:
                20px;

            background:
                linear-gradient(
                    145deg,
                    rgba(15,40,66,.88),
                    rgba(5,18,32,.86)
                );

            box-shadow:
                0 18px 50px rgba(0,0,0,.22);

            backdrop-filter:
                blur(14px);

            transition:
                transform .3s ease,
                border-color .3s ease,
                box-shadow .3s ease;

        }


        .landing-page .lp-feature-card::before {

            content:
                "";

            position:
                absolute;

            width:
                150px;

            height:
                150px;

            top:
                -75px;

            right:
                -75px;

            border-radius:
                50%;

            background:
                rgba(59,130,246,.10);

        }


        .landing-page .lp-feature-card:hover {

            transform:
                translateY(-7px);

            border-color:
                rgba(96,165,250,.25);

            box-shadow:
                0 25px 60px rgba(0,0,0,.32);

        }


        .landing-page .lp-feature-icon {

            width:
                56px;

            height:
                56px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            margin-bottom:
                20px;

            border:
                1px solid rgba(147,197,253,.16);

            border-radius:
                15px;

            background:
                linear-gradient(
                    135deg,
                    rgba(219,234,254,.14),
                    rgba(59,130,246,.12)
                );

            color:
                #93c5fd;

            font-size:
                21px;

        }


        .landing-page .lp-feature-title {

            margin:
                0 0 10px;

            color:
                #ffffff;

            font-size:
                15px;

            font-weight:
                750;

            line-height:
                1.4;

        }


        .landing-page .lp-feature-description {

            margin:
                0;

            color:
                #94a3b8;

            font-size:
                11px;

            line-height:
                1.75;

        }


        .landing-page .lp-feature-number {

            position:
                absolute;

            right:
                20px;

            bottom:
                16px;

            color:
                rgba(147,197,253,.10);

            font-size:
                42px;

            font-weight:
                800;

        }


        /* =========================================================
           PROCESS SECTION
        ========================================================== */

        .landing-page .lp-process {

            display:
                grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap:
                18px;

            margin-top:
                25px;

        }


        .landing-page .lp-process-card {

            display:
                flex;

            align-items:
                flex-start;

            gap:
                14px;

            padding:
                20px;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius:
                16px;

            background:
                rgba(5,18,32,.58);

        }


        .landing-page .lp-process-number {

            width:
                38px;

            height:
                38px;

            flex-shrink:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                11px;

            background:
                rgba(59,130,246,.13);

            color:
                #60a5fa;

            font-size:
                13px;

            font-weight:
                800;

        }


        .landing-page .lp-process-title {

            margin:
                0 0 5px;

            color:
                #ffffff;

            font-size:
                13px;

            font-weight:
                700;

        }


        .landing-page .lp-process-text {

            margin:
                0;

            color:
                #94a3b8;

            font-size:
                10px;

            line-height:
                1.6;

        }


        /* =========================================================
           FOOTER
        ========================================================== */

        .landing-page .lp-footer {

            position:
                relative;

            z-index:
                4;

            border-top:
                1px solid rgba(255,255,255,.08);

            background:
                rgba(2,11,22,.94);

        }


        .landing-page .lp-footer-inner {

            width:
                min(1180px, calc(100% - 40px));

            margin:
                0 auto;

            padding:
                32px 0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                25px;

        }


        .landing-page .lp-footer-brand {

            display:
                flex;

            align-items:
                center;

            gap:
                12px;

        }


        .landing-page .lp-footer-logo {

            width:
                42px;

            height:
                42px;

            border-radius:
                50%;

            object-fit:
                cover;

            border:
                1px solid rgba(255,255,255,.14);

        }


        .landing-page .lp-footer-title {

            color:
                #ffffff;

            font-size:
                12px;

            font-weight:
                700;

        }


        .landing-page .lp-footer-subtitle {

            margin-top:
                3px;

            color:
                #64748b;

            font-size:
                9px;

        }


        .landing-page .lp-footer-location {

            margin:
                0;

            color:
                #94a3b8;

            font-size:
                10px;

            line-height:
                1.6;

            text-align:
                right;

        }


        .landing-page .lp-socials {

            display:
                flex;

            align-items:
                center;

            gap:
                8px;

        }


        .landing-page .lp-social {

            width:
                38px;

            height:
                38px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius:
                10px;

            background:
                rgba(255,255,255,.04);

            color:
                #94a3b8;

            transition:
                .25s ease;

        }


        .landing-page .lp-social:hover {

            color:
                #ffffff;

            border-color:
                rgba(96,165,250,.3);

            background:
                rgba(59,130,246,.13);

            transform:
                translateY(-2px);

        }


        .landing-page .lp-copyright {

            padding:
                14px 20px;

            border-top:
                1px solid rgba(255,255,255,.05);

            color:
                #475569;

            font-size:
                9px;

            text-align:
                center;

        }


        /* =========================================================
           LOGIN MODAL
        ========================================================== */

        .landing-page .lp-login-overlay {

            position:
                fixed;

            inset:
                0;

            z-index:
                99999;

            display:
                none;

            align-items:
                center;

            justify-content:
                center;

            padding:
                20px;

            background:
                rgba(2,6,23,.78);

            backdrop-filter:
                blur(14px);

            -webkit-backdrop-filter:
                blur(14px);

        }


        .landing-page .lp-login-overlay.show {

            display:
                flex;

        }


        .landing-page .lp-login-box {

            position:
                relative;

            width:
                min(460px, 100%);

            max-height:
                calc(100vh - 40px);

            overflow:
                auto;

            padding:
                32px;

            border:
                1px solid rgba(255,255,255,.12);

            border-radius:
                24px;

            background:
                linear-gradient(
                    145deg,
                    #0d2039,
                    #061426
                );

            box-shadow:
                0 35px 100px rgba(0,0,0,.55);

            animation:
                lpModalIn .25s ease;

        }


        @keyframes lpModalIn {

            from {

                opacity:
                    0;

                transform:
                    translateY(12px)
                    scale(.97);

            }

            to {

                opacity:
                    1;

                transform:
                    translateY(0)
                    scale(1);

            }

        }


        .landing-page .lp-modal-close {

            position:
                absolute;

            top:
                15px;

            right:
                15px;

            width:
                36px;

            height:
                36px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius:
                10px;

            background:
                rgba(255,255,255,.06);

            color:
                #cbd5e1;

            font-size:
                16px;

            cursor:
                pointer;

            transition:
                .2s ease;

        }


        .landing-page .lp-modal-close:hover {

            background:
                rgba(239,68,68,.15);

            border-color:
                rgba(248,113,113,.3);

            color:
                #ffffff;

        }


        .landing-page .lp-modal-header {

            text-align:
                center;

            padding:
                5px 20px 24px;

        }


        .landing-page .lp-modal-logo {

            width:
                76px;

            height:
                76px;

            object-fit:
                cover;

            border-radius:
                50%;

            border:
                2px solid rgba(147,197,253,.25);

            box-shadow:
                0 12px 30px rgba(0,0,0,.3);

        }


        .landing-page .lp-modal-header h2 {

            margin:
                16px 0 6px;

            color:
                #ffffff;

            font-size:
                24px;

            font-weight:
                800;

        }


        .landing-page .lp-modal-header p {

            margin:
                0;

            color:
                #94a3b8;

            font-size:
                11px;

            line-height:
                1.6;

        }


        /* =========================================================
           LOGIN OPTIONS
        ========================================================== */

        .landing-page .lp-login-options {

            display:
                flex;

            flex-direction:
                column;

            gap:
                10px;

        }


        .landing-page .lp-login-card {

            position:
                relative;

            display:
                flex;

            align-items:
                center;

            gap:
                14px;

            padding:
                15px;

            border:
                1px solid rgba(255,255,255,.08);

            border-radius:
                15px;

            background:
                rgba(255,255,255,.045);

            color:
                #ffffff;

            transition:
                .25s ease;

        }


        .landing-page .lp-login-card:hover {

            transform:
                translateX(4px);

            border-color:
                rgba(96,165,250,.28);

            background:
                rgba(59,130,246,.09);

            box-shadow:
                0 12px 30px rgba(0,0,0,.2);

        }


        .landing-page .lp-login-icon {

            width:
                48px;

            height:
                48px;

            flex-shrink:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border-radius:
                13px;

            font-size:
                19px;

        }


        .landing-page .lp-login-icon-blue {

            background:
                rgba(59,130,246,.15);

            color:
                #60a5fa;

        }


        .landing-page .lp-login-icon-gold {

            background:
                rgba(245,158,11,.13);

            color:
                #fbbf24;

        }


        .landing-page .lp-login-icon-green {

            background:
                rgba(34,197,94,.13);

            color:
                #4ade80;

        }


        .landing-page .lp-login-info {

            flex:
                1;

            min-width:
                0;

        }


        .landing-page .lp-login-info h3 {

            margin:
                0 0 3px;

            color:
                #ffffff;

            font-size:
                13px;

            font-weight:
                750;

        }


        .landing-page .lp-login-info p {

            margin:
                0;

            color:
                #64748b;

            font-size:
                9px;

            line-height:
                1.5;

        }


        .landing-page .lp-login-arrow {

            color:
                #60a5fa;

            font-size:
                15px;

            transition:
                .2s ease;

        }


        .landing-page .lp-login-card:hover
        .lp-login-arrow {

            transform:
                translateX(4px);

        }


        .landing-page .lp-modal-footer {

            margin-top:
                22px;

            padding-top:
                17px;

            border-top:
                1px solid rgba(255,255,255,.07);

            color:
                #64748b;

            font-size:
                9px;

            line-height:
                1.6;

            text-align:
                center;

        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media(max-width:900px) {

            .landing-page .lp-feature-grid {

                grid-template-columns:
                    repeat(2, 1fr);

            }


            .landing-page .lp-process {

                grid-template-columns:
                    1fr;

            }


            .landing-page .lp-hero {

                min-height:
                    590px;

            }

        }


        @media(max-width:700px) {

            .landing-page .lp-header-inner {

                width:
                    min(
                        100% - 24px,
                        1240px
                    );

                min-height:
                    70px;

            }


            .landing-page .lp-logo {

                width:
                    46px;

                height:
                    46px;

            }


            .landing-page .lp-brand-name {

                font-size:
                    12px;

            }


            .landing-page .lp-brand-system {

                font-size:
                    8px;

            }


            .landing-page .lp-system-status {

                display:
                    none;

            }


            .landing-page .lp-login-btn {

                min-height:
                    40px;

                padding:
                    0 14px;

                font-size:
                    11px;

            }


            .landing-page .lp-hero {

                width:
                    calc(100% - 28px);

                min-height:
                    560px;

                padding:
                    60px 0 50px;

            }


            .landing-page .lp-title {

                letter-spacing:
                    -1.5px;

            }


            .landing-page .lp-subtitle {

                font-size:
                    13px;

                line-height:
                    1.7;

            }


            .landing-page .lp-stats {

                margin-top:
                    35px;

            }


            .landing-page .lp-stat {

                min-width:
                    120px;

                padding:
                    12px 15px;

            }


            .landing-page .lp-section {

                width:
                    calc(100% - 28px);

                padding-bottom:
                    55px;

            }


            .landing-page .lp-feature-grid {

                grid-template-columns:
                    1fr;

            }


            .landing-page .lp-feature-card {

                min-height:
                    auto;

            }


            .landing-page .lp-footer-inner {

                width:
                    calc(100% - 28px);

                flex-direction:
                    column;

                align-items:
                    flex-start;

            }


            .landing-page .lp-footer-location {

                text-align:
                    left;

            }

        }


        @media(max-width:480px) {

            .landing-page .lp-brand-system {

                display:
                    none;

            }


            .landing-page .lp-actions {

                flex-direction:
                    column;

                width:
                    100%;

            }


            .landing-page .lp-primary-btn,
            .landing-page .lp-secondary-btn {

                width:
                    100%;

            }


            .landing-page .lp-stats {

                display:
                    grid;

                grid-template-columns:
                    repeat(2, 1fr);

            }


            .landing-page .lp-stat {

                min-width:
                    0;

            }


            .landing-page .lp-login-box {

                padding:
                    25px 18px;

                border-radius:
                    20px;

            }


            .landing-page .lp-modal-header h2 {

                font-size:
                    21px;

            }


            .landing-page .lp-modal-header p {

                font-size:
                    10px;

            }

        }


        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media(prefers-reduced-motion: reduce) {

            .landing-page .lp-slide {

                animation:
                    none;

            }


            .landing-page .lp-slide-1 {

                opacity:
                    1;

            }


            .landing-page *,
            .landing-page *::before,
            .landing-page *::after {

                transition-duration:
                    .01ms !important;

            }

        }


    </style>

</head>


<body>


<div class="landing-page">


    {{-- =========================================================
         BACKGROUND
    ========================================================== --}}

    <div class="lp-background">

        <div class="lp-slide lp-slide-1"></div>

        <div class="lp-slide lp-slide-2"></div>

        <div class="lp-slide lp-slide-3"></div>

        <div class="lp-slide lp-slide-4"></div>

    </div>


    <div class="lp-atmosphere"></div>

    <div class="lp-grid"></div>


    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <header class="lp-header">

        <div class="lp-header-inner">


            <div class="lp-brand">

                <img
                    src="{{ asset('images/MMACI Logo.jpg') }}"
                    alt="Merchant Marine Academy of Caraga Inc. Logo"
                    class="lp-logo"
                >


                <div class="lp-brand-text">

                    <span class="lp-brand-name">
                        Merchant Marine Academy
                        <br>
                        of Caraga Inc.
                    </span>

                    <span class="lp-brand-system">
                        ON BOARD TRAINING REPORT SYSTEM
                    </span>

                </div>

            </div>


            <div class="lp-header-right">


                <button
                    type="button"
                    class="lp-login-btn"
                    onclick="lpOpenLogin()"
                >

                    <i class="fas fa-right-to-bracket"></i>

                    Login

                </button>


            </div>


        </div>

    </header>


    {{-- =========================================================
         HERO
    ========================================================== --}}

    <main>


        <section class="lp-hero">


            <div class="lp-hero-content">


                <div class="lp-eyebrow">

                    <i class="fas fa-compass"></i>

                    Digital Maritime Training Management

                </div>


                <h1 class="lp-title">

                    On Board Training

                    <span class="lp-title-accent">
                        Report System
                    </span>

                </h1>


                <p class="lp-subtitle">

                    A centralized digital platform for monitoring cadet
                    training progress, managing reports, evaluating
                    performance, and organizing essential onboard
                    training records.

                </p>


                <div class="lp-actions">


                    <button
                        type="button"
                        class="lp-primary-btn"
                        onclick="lpOpenLogin()"
                    >

                        Get Started

                        <i class="fas fa-arrow-right"></i>

                    </button>


                    <a
                        href="#features"
                        class="lp-secondary-btn"
                    >

                        <i class="fas fa-layer-group"></i>

                        Explore System

                    </a>


                </div>


                {{-- HERO STATS --}}

                <div class="lp-stats">


                    <div class="lp-stat">

                        <strong>
                            24/7
                        </strong>

                        <span>
                            Digital Access
                        </span>

                    </div>


                    <div class="lp-stat">

                        <strong>
                            Real-Time
                        </strong>

                        <span>
                            Progress Monitoring
                        </span>

                    </div>


                    <div class="lp-stat">

                        <strong>
                            Centralized
                        </strong>

                        <span>
                            Training Records
                        </span>

                    </div>


                    <div class="lp-stat">

                        <strong>
                            Secure
                        </strong>

                        <span>
                            Role-Based Access
                        </span>

                    </div>


                </div>


            </div>


        </section>


        {{-- =========================================================
             FEATURES
        ========================================================== --}}

        <section
            class="lp-section"
            id="features"
        >


            <div class="lp-section-heading">

                <span class="lp-section-label">
                    System Capabilities
                </span>

                <h2 class="lp-section-title">
                    Everything for Efficient OBT Management
                </h2>

                <p class="lp-section-description">

                    Designed to simplify the management of onboard
                    training activities while giving authorized users
                    a clear view of cadet progress and documentation.

                </p>

            </div>


            <div class="lp-feature-grid">


                {{-- FEATURE 1 --}}

                <article class="lp-feature-card">


                    <div class="lp-feature-icon">

                        <i class="fas fa-chart-line"></i>

                    </div>


                    <h3 class="lp-feature-title">
                        Training Progress Monitoring
                    </h3>


                    <p class="lp-feature-description">

                        Monitor cadet training progress, completed
                        activities, and overall onboard development
                        through a centralized system.

                    </p>


                    <span class="lp-feature-number">
                        01
                    </span>


                </article>


                {{-- FEATURE 2 --}}

                <article class="lp-feature-card">


                    <div class="lp-feature-icon">

                        <i class="fas fa-file-circle-check"></i>

                    </div>


                    <h3 class="lp-feature-title">
                        Report Submission
                    </h3>


                    <p class="lp-feature-description">

                        Submit, organize, and manage onboard training
                        reports digitally without relying on scattered
                        paper documents.

                    </p>


                    <span class="lp-feature-number">
                        02
                    </span>


                </article>


                {{-- FEATURE 3 --}}

                <article class="lp-feature-card">


                    <div class="lp-feature-icon">

                        <i class="fas fa-user-check"></i>

                    </div>


                    <h3 class="lp-feature-title">
                        Performance Evaluation
                    </h3>


                    <p class="lp-feature-description">

                        Support structured evaluation of cadet
                        performance using supervisor feedback and
                        training records.

                    </p>


                    <span class="lp-feature-number">
                        03
                    </span>


                </article>


                {{-- FEATURE 4 --}}

                <article class="lp-feature-card">


                    <div class="lp-feature-icon">

                        <i class="fas fa-folder-open"></i>

                    </div>


                    <h3 class="lp-feature-title">
                        Document Management
                    </h3>


                    <p class="lp-feature-description">

                        Keep important training documents organized
                        and accessible through a centralized digital
                        record system.

                    </p>


                    <span class="lp-feature-number">
                        04
                    </span>


                </article>


            </div>


        </section>


        {{-- =========================================================
             WORKFLOW
        ========================================================== --}}

        <section class="lp-section">


            <div class="lp-section-heading">

                <span class="lp-section-label">
                    Training Workflow
                </span>

                <h2 class="lp-section-title">
                    A More Connected Training Process
                </h2>

                <p class="lp-section-description">

                    The system brings important OBT activities together
                    so authorized users can monitor and manage the
                    training lifecycle more efficiently.

                </p>

            </div>


            <div class="lp-process">


                <div class="lp-process-card">


                    <div class="lp-process-number">
                        01
                    </div>


                    <div>

                        <h3 class="lp-process-title">
                            Record
                        </h3>

                        <p class="lp-process-text">

                            Maintain cadet profiles, deployment
                            information, and training requirements.

                        </p>

                    </div>


                </div>


                <div class="lp-process-card">


                    <div class="lp-process-number">
                        02
                    </div>


                    <div>

                        <h3 class="lp-process-title">
                            Monitor
                        </h3>

                        <p class="lp-process-text">

                            Track submitted reports, requirements,
                            verification status, and progress.

                        </p>

                    </div>


                </div>


                <div class="lp-process-card">


                    <div class="lp-process-number">
                        03
                    </div>


                    <div>

                        <h3 class="lp-process-title">
                            Evaluate
                        </h3>

                        <p class="lp-process-text">

                            Review training activities and use system
                            records to support performance evaluation.

                        </p>

                    </div>


                </div>


            </div>


        </section>


    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <footer class="lp-footer">


        <div class="lp-footer-inner">


            <div class="lp-footer-brand">


                <img
                    src="{{ asset('images/MMACI Logo.jpg') }}"
                    alt="MMACI Logo"
                    class="lp-footer-logo"
                >


                <div>

                    <div class="lp-footer-title">
                        Merchant Marine Academy of Caraga Inc.
                    </div>

                    <div class="lp-footer-subtitle">
                        On Board Training Report System
                    </div>

                </div>


            </div>


            <p class="lp-footer-location">

                <i class="fas fa-location-dot"></i>

                Barangay Ong-Yiu, North Montilla Blvd.,
                Butuan City, Agusan del Norte, Philippines

            </p>


            <div class="lp-socials">


                <a
                    href="#"
                    class="lp-social"
                    aria-label="Facebook"
                >

                    <i class="fab fa-facebook-f"></i>

                </a>


                <a
                    href="#"
                    class="lp-social"
                    aria-label="Twitter"
                >

                    <i class="fab fa-x-twitter"></i>

                </a>


                <a
                    href="#"
                    class="lp-social"
                    aria-label="Instagram"
                >

                    <i class="fab fa-instagram"></i>

                </a>


            </div>


        </div>


        <div class="lp-copyright">

            © {{ date('Y') }}
            Merchant Marine Academy of Caraga Inc.
            All rights reserved.

        </div>


    </footer>


    {{-- =========================================================
         LOGIN ROLE SELECTION MODAL
    ========================================================== --}}

    <div
        id="loginModal"
        class="lp-login-overlay"
        role="dialog"
        aria-modal="true"
        aria-labelledby="lpLoginTitle"
    >


        <div class="lp-login-box">


            <button
                type="button"
                class="lp-modal-close"
                onclick="lpCloseLogin()"
                aria-label="Close login"
            >

                <i class="fas fa-xmark"></i>

            </button>


            {{-- MODAL HEADER --}}

            <div class="lp-modal-header">


                <img
                    src="{{ asset('images/MMACI Logo.jpg') }}"
                    alt="MMACI Logo"
                    class="lp-modal-logo"
                >


                <h2 id="lpLoginTitle">
                    Welcome to OBT Portal
                </h2>


                <p>
                    Select your account type to access the system.
                </p>


            </div>


            {{-- LOGIN OPTIONS --}}

            <div class="lp-login-options">


                {{-- OBT SUPERVISOR --}}

                <a
                    href="{{ route('admin.login') }}"
                    class="lp-login-card"
                >


                    <div
                        class="lp-login-icon lp-login-icon-blue"
                    >

                        <i class="fas fa-anchor"></i>

                    </div>


                    <div class="lp-login-info">

                        <h3>
                            OBT Supervisor
                        </h3>

                    </div>


                    <div class="lp-login-arrow">

                        <i class="fas fa-chevron-right"></i>

                    </div>


                </a>


                {{-- DEAN --}}

                <a
                    href="{{ route('superadmin.login') }}"
                    class="lp-login-card"
                >


                    <div
                        class="lp-login-icon lp-login-icon-gold"
                    >

                        <i class="fas fa-graduation-cap"></i>

                    </div>


                    <div class="lp-login-info">

                        <h3>
                            Dean
                        </h3>

                    </div>


                    <div class="lp-login-arrow">

                        <i class="fas fa-chevron-right"></i>

                    </div>


                </a>


                {{-- CADET --}}

                <a
                    href="{{ route('login') }}"
                    class="lp-login-card"
                >


                    <div
                        class="lp-login-icon lp-login-icon-green"
                    >

                        <i class="fas fa-user-graduate"></i>

                    </div>


                    <div class="lp-login-info">

                        <h3>
                            Cadet
                        </h3>

                    </div>


                    <div class="lp-login-arrow">

                        <i class="fas fa-chevron-right"></i>

                    </div>


                </a>


            </div>


            <div class="lp-modal-footer">

                Merchant Marine Academy of Caraga Inc.
                <br>
                On Board Training Report System

            </div>


        </div>


    </div>


</div>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>

(function () {

    'use strict';


    const modal =
        document.getElementById('loginModal');


    let lastFocusedElement = null;


    /* =========================================================
       OPEN LOGIN
    ========================================================== */

    window.lpOpenLogin = function () {

        if (!modal) {

            return;

        }


        lastFocusedElement =
            document.activeElement;


        modal.classList.add('show');


        document.body.style.overflow =
            'hidden';


        const closeButton =
            modal.querySelector('.lp-modal-close');


        if (closeButton) {

            setTimeout(function () {

                closeButton.focus();

            }, 50);

        }

    };


    /* =========================================================
       CLOSE LOGIN
    ========================================================== */

    window.lpCloseLogin = function () {

        if (!modal) {

            return;

        }


        modal.classList.remove('show');


        document.body.style.overflow =
            '';


        if (
            lastFocusedElement &&
            typeof lastFocusedElement.focus === 'function'
        ) {

            lastFocusedElement.focus();

        }

    };


    /* =========================================================
       CLICK OUTSIDE MODAL
    ========================================================== */

    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === modal
                ) {

                    lpCloseLogin();

                }

            }
        );

    }


    /* =========================================================
       ESCAPE KEY
    ========================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal &&
                modal.classList.contains('show')
            ) {

                lpCloseLogin();

            }

        }
    );


    /* =========================================================
       MODAL TAB CONTROL
       Keeps keyboard focus inside the modal.
    ========================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key !== 'Tab' ||
                !modal ||
                !modal.classList.contains('show')
            ) {

                return;

            }


            const focusable =
                modal.querySelectorAll(
                    'a[href], button:not([disabled])'
                );


            if (!focusable.length) {

                return;

            }


            const first =
                focusable[0];

            const last =
                focusable[focusable.length - 1];


            if (
                event.shiftKey &&
                document.activeElement === first
            ) {

                event.preventDefault();

                last.focus();

            }

            else if (
                !event.shiftKey &&
                document.activeElement === last
            ) {

                event.preventDefault();

                first.focus();

            }

        }
    );


})();

</script>


</body>

</html>