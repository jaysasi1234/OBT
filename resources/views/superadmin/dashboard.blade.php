@extends('layouts.superadmin')

@section('content')

<style>

/* =========================================================
   SUPER ADMIN DASHBOARD
   MODERN ENTERPRISE UI
   UI / CSS ONLY
========================================================= */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

/* =========================================================
   ROOT
========================================================= */

:root {
    --dash-bg: #07152f;
    --dash-bg-2: #0b1b43;

    --panel: rgba(16, 29, 66, 0.90);
    --panel-2: #101d42;

    --text: #f8fafc;
    --text-soft: #cbd5e1;
    --text-muted: #94a3b8;

    --blue: #3b82f6;
    --blue-dark: #2563eb;
    --cyan: #06b6d4;
    --green: #10b981;
    --orange: #f59e0b;
    --red: #ef4444;

    --border: rgba(255,255,255,.08);

    --radius-xl: 24px;
    --radius-lg: 20px;
    --radius-md: 16px;
    --radius-sm: 12px;

    --shadow:
        0 18px 45px rgba(0,0,0,.25);

    --shadow-hover:
        0 25px 55px rgba(0,0,0,.35);
}

/* =========================================================
   GLOBAL
========================================================= */

.dashboard-container {

    width: 100%;
    max-width: 1600px;

    margin: 0 auto;

    padding: 5px 0 30px;

    font-family: 'Inter', sans-serif;

    color: var(--text);

    box-sizing: border-box;
}

.dashboard-container *,
.dashboard-container *::before,
.dashboard-container *::after {

    box-sizing: border-box;
}

/* =========================================================
   HERO
========================================================= */

.hero {

    position: relative;

    overflow: hidden;

    padding: 34px 36px;

    border-radius: var(--radius-xl);

    background:
        radial-gradient(
            circle at 85% 15%,
            rgba(56,189,248,.25),
            transparent 30%
        ),
        radial-gradient(
            circle at 10% 90%,
            rgba(37,99,235,.25),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #0f2f78 0%,
            #174ea6 48%,
            #075985 100%
        );

    border:
        1px solid rgba(147,197,253,.16);

    box-shadow:
        0 22px 55px rgba(0,0,0,.30);

    margin-bottom: 26px;

    isolation: isolate;
}

.hero::before {

    content: '';

    position: absolute;

    width: 450px;
    height: 450px;

    background:
        rgba(255,255,255,.055);

    border-radius: 50%;

    top: -260px;
    right: -110px;

    pointer-events: none;
}

.hero::after {

    content: '';

    position: absolute;

    width: 280px;
    height: 280px;

    background:
        rgba(255,255,255,.035);

    border-radius: 50%;

    bottom: -180px;
    left: -90px;

    pointer-events: none;
}

.hero-content {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 35px;

    position: relative;

    z-index: 2;
}

.hero-content > div:first-child {

    flex: 1;

    min-width: 0;
}

/* =========================================================
   HERO TEXT
========================================================= */

.hero h2 {

    margin: 0;

    color: #ffffff;

    font-size: clamp(25px, 2.3vw, 35px);

    line-height: 1.2;

    font-weight: 800;

    letter-spacing: -.8px;
}

.hero p {

    margin: 9px 0 0;

    color: #dbeafe;

    font-size: 14px;

    line-height: 1.6;
}

/* =========================================================
   HERO BUTTONS
========================================================= */

.hero-buttons {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

    margin-top: 22px;
}

.hero-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    min-height: 42px;

    padding: 10px 16px;

    border-radius: 11px;

    text-decoration: none;

    color: #ffffff;

    background:
        rgba(255,255,255,.11);

    border:
        1px solid rgba(255,255,255,.17);

    backdrop-filter: blur(8px);

    font-size: 13px;

    font-weight: 600;

    transition:
        transform .25s ease,
        background .25s ease,
        color .25s ease,
        box-shadow .25s ease;
}

.hero-btn i {

    font-size: 14px;
}

.hero-btn:hover {

    transform: translateY(-2px);

    background: #ffffff;

    color: #1d4ed8;

    border-color: #ffffff;

    box-shadow:
        0 10px 25px rgba(0,0,0,.18);
}

/* =========================================================
   HERO RIGHT
========================================================= */

.hero-right {

    min-width: 245px;

    padding: 20px 22px;

    text-align: right;

    border-radius: 17px;

    background:
        rgba(4,15,38,.20);

    border:
        1px solid rgba(255,255,255,.10);

    backdrop-filter: blur(10px);
}

.hero-right h4 {

    margin: 0;

    color: #bfdbfe;

    font-size: 12px;

    font-weight: 600;

    letter-spacing: .4px;
}

.hero-right h1 {

    margin: 8px 0 0;

    color: #ffffff;

    font-size: 42px;

    line-height: 1;

    font-weight: 900;

    letter-spacing: -1px;
}

.hero-right p {

    margin-top: 8px;

    color: #dbeafe;

    font-size: 12px;
}

/* =========================================================
   KPI CARDS
========================================================= */

.cards {

    display: grid;

    grid-template-columns:
        repeat(5, minmax(0,1fr));

    gap: 16px;

    margin-bottom: 26px;
}

.card {

    position: relative;

    overflow: hidden;

    min-height: 165px;

    padding: 20px;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    color: #ffffff;

    text-decoration: none;

    border-radius: var(--radius-lg);

    border:
        1px solid rgba(255,255,255,.09);

    box-shadow:
        0 12px 30px rgba(0,0,0,.20);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.card::before {

    content: '';

    position: absolute;

    width: 150px;
    height: 150px;

    right: -45px;
    top: -65px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.075);
}

.card::after {

    content: '';

    position: absolute;

    width: 90px;
    height: 90px;

    left: -30px;
    bottom: -55px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.035);
}

.card:hover {

    transform: translateY(-5px);

    box-shadow:
        var(--shadow-hover);

    border-color:
        rgba(255,255,255,.18);
}

.card > * {

    position: relative;

    z-index: 2;
}

/* =========================================================
   CARD TOP
========================================================= */

.card-top {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 12px;
}

.card-title {

    margin-bottom: 8px;

    color:
        rgba(255,255,255,.86);

    font-size: 12px;

    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: .55px;
}

.card-number {

    font-size: 35px;

    line-height: 1;

    font-weight: 800;

    letter-spacing: -1px;
}

/* =========================================================
   CARD ICON
========================================================= */

.card-icon {

    width: 48px;
    height: 48px;

    flex: 0 0 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    background:
        rgba(255,255,255,.12);

    border:
        1px solid rgba(255,255,255,.12);

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.08);
}

.card-icon i {

    font-size: 19px;
}

/* =========================================================
   CARD FOOTER
========================================================= */

.card-footer {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 10px;

    padding-top: 15px;

    border-top:
        1px solid rgba(255,255,255,.10);

    color:
        rgba(255,255,255,.82);

    font-size: 11px;

    font-weight: 600;
}

.card-footer span:last-child {

    color: #ffffff;

    font-weight: 700;
}

/* =========================================================
   CARD COLORS
========================================================= */

.card.blue {

    background:
        linear-gradient(
            145deg,
            #2563eb,
            #1d4ed8
        );
}

.card.green {

    background:
        linear-gradient(
            145deg,
            #10b981,
            #047857
        );
}

.card.orange {

    background:
        linear-gradient(
            145deg,
            #f59e0b,
            #d97706
        );
}

.card.red {

    background:
        linear-gradient(
            145deg,
            #ef4444,
            #dc2626
        );
}

.card.cyan {

    background:
        linear-gradient(
            145deg,
            #0891b2,
            #0e7490
        );
}

/* =========================================================
   MAIN CHART GRID
========================================================= */

.grid {

    display: grid;

    grid-template-columns:
        minmax(0,2.1fr)
        minmax(320px,1fr);

    gap: 18px;

    align-items: stretch;

    margin-bottom: 18px;
}

/* =========================================================
   BOX
========================================================= */

.box {

    position: relative;

    min-width: 0;

    padding: 22px;

    display: flex;

    flex-direction: column;

    height: 100%;

    border-radius: var(--radius-lg);

    background:
        linear-gradient(
            145deg,
            rgba(17,32,72,.94),
            rgba(11,24,57,.94)
        );

    border:
        1px solid var(--border);

    box-shadow:
        var(--shadow);

    backdrop-filter:
        blur(14px);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}

.box:hover {

    transform: translateY(-2px);

    box-shadow:
        var(--shadow-hover);

    border-color:
        rgba(59,130,246,.18);
}

/* =========================================================
   CHART HEADER
========================================================= */

.chart-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    margin-bottom: 18px;
}

.chart-header h3 {

    margin: 0;

    color: #ffffff;

    font-size: 17px;

    font-weight: 700;

    letter-spacing: -.2px;
}

.chart-header small {

    display: block;

    margin-top: 5px;

    color: var(--text-muted);

    font-size: 11px;
}

/* =========================================================
   BADGES
========================================================= */

.badge-chart {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    min-height: 28px;

    padding: 5px 10px;

    border-radius: 999px;

    color: #93c5fd;

    background:
        rgba(59,130,246,.14);

    border:
        1px solid rgba(59,130,246,.20);

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .5px;
}

.badge-chart.green {

    color: #6ee7b7;

    background:
        rgba(16,185,129,.12);

    border-color:
        rgba(16,185,129,.20);
}

/* =========================================================
   CHART CONTAINER
========================================================= */

.chart-container {

    position: relative;

    width: 100%;

    height: 310px;

    min-height: 310px;

    flex: 1;
}

.chart-container canvas {

    display: block;

    width: 100% !important;

    height: 100% !important;
}

/* =========================================================
   ANALYTICS
========================================================= */

.analytics-box {

    margin-bottom: 18px;
}

.analytics-grid {

    display: grid;

    grid-template-columns:
        minmax(0,2fr)
        minmax(320px,1fr);

    gap: 18px;

    align-items: start;
}

/* =========================================================
   SECTION TITLE
========================================================= */

.section-title {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    margin-bottom: 18px;
}

.section-title h3 {

    margin: 0;

    color: #ffffff;

    font-size: 17px;

    font-weight: 700;
}

.section-title h3 i,
.analytics-box > h3 i {

    margin-right: 8px;

    color: #60a5fa;
}

.section-title span {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 58px;

    padding: 7px 11px;

    border-radius: 10px;

    color: #93c5fd;

    background:
        rgba(59,130,246,.10);

    border:
        1px solid rgba(59,130,246,.15);

    font-size: 18px;

    font-weight: 800;
}

/* =========================================================
   ANALYTICS TITLES
========================================================= */

.analytics-box > h3 {

    margin: 0 0 18px;

    color: #ffffff;

    font-size: 17px;

    font-weight: 700;
}

/* =========================================================
   OVERALL PROGRESS
========================================================= */

.overall-progress {

    height: 12px;

    margin-bottom: 24px;

    padding: 2px;

    overflow: hidden;

    border-radius: 999px;

    background:
        #17264d;

    box-shadow:
        inset 0 1px 3px rgba(0,0,0,.25);
}

.overall-fill {

    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #38bdf8,
            #06b6d4
        );

    box-shadow:
        0 0 14px rgba(56,189,248,.25);

    transition:
        width .6s ease;
}

/* =========================================================
   COURSE PROGRESS
========================================================= */

.course-progress {

    margin-bottom: 20px;
}

.course-progress:last-child {

    margin-bottom: 0;
}

.course-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    margin-bottom: 8px;

    color: #dbeafe;

    font-size: 12px;
}

.course-header strong {

    color: #ffffff;

    font-size: 12px;
}

.progress {

    width: 100%;

    height: 8px;

    overflow: hidden;

    border-radius: 999px;

    background:
        #1c2a52;
}

.progress-bar {

    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #38bdf8
        );

    box-shadow:
        0 0 12px rgba(37,99,235,.18);

    transition:
        width .6s ease;

    color: transparent;

    font-size: 0;
}

/* =========================================================
   MINI CARDS
========================================================= */

.stats-row {

    display: grid;

    grid-template-columns:
        repeat(3,minmax(0,1fr));

    gap: 12px;

    margin-top: 4px;
}

.mini-card {

    position: relative;

    overflow: hidden;

    padding: 20px 15px;

    text-align: center;

    border-radius: 15px;

    border:
        1px solid rgba(255,255,255,.08);

    box-shadow:
        0 10px 25px rgba(0,0,0,.16);
}

.mini-card::after {

    content: '';

    position: absolute;

    width: 80px;
    height: 80px;

    top: -45px;
    right: -30px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.06);
}

.mini-card h1 {

    position: relative;

    z-index: 2;

    margin: 0 0 5px;

    font-size: 31px;

    line-height: 1;

    font-weight: 800;
}

.mini-card small {

    position: relative;

    z-index: 2;

    color:
        rgba(255,255,255,.82);

    font-size: 11px;

    font-weight: 600;
}

/* =========================================================
   REQUIREMENTS
========================================================= */

.requirements-list {

    display: flex;

    flex-direction: column;

    gap: 10px;

    max-height: 370px;

    overflow-y: auto;

    padding-right: 3px;
}

.requirements-list::-webkit-scrollbar {

    width: 5px;
}

.requirements-list::-webkit-scrollbar-track {

    background: transparent;
}

.requirements-list::-webkit-scrollbar-thumb {

    border-radius: 20px;

    background: #33466f;
}

.requirement-card {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    padding: 13px 14px;

    margin: 0;

    border-radius: 13px;

    background:
        rgba(24,35,77,.72);

    border:
        1px solid rgba(255,255,255,.05);

    transition:
        transform .2s ease,
        background .2s ease,
        border-color .2s ease;
}

.requirement-card:hover {

    transform: translateX(3px);

    background:
        rgba(33,48,95,.85);

    border-color:
        rgba(59,130,246,.15);
}

.requirement-card strong {

    display: block;

    margin-bottom: 4px;

    color: #f8fafc;

    font-size: 12px;

    font-weight: 700;
}

.requirement-card small {

    color: #94a3b8;

    font-size: 10px;
}

.badge-warning {

    flex-shrink: 0;

    padding: 5px 9px;

    border-radius: 999px;

    color: #fef3c7;

    background:
        rgba(245,158,11,.12);

    border:
        1px solid rgba(245,158,11,.18);

    font-size: 9px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .4px;
}

/* =========================================================
   SUMMARY
========================================================= */

.summary-row {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    padding: 13px 0;

    color: #cbd5e1;

    border-bottom:
        1px solid rgba(255,255,255,.06);

    font-size: 12px;
}

.summary-row:first-child {

    padding-top: 3px;
}

.summary-row:last-child {

    border-bottom: none;

    padding-bottom: 2px;
}

.summary-row strong {

    min-width: 35px;

    text-align: right;

    color: #ffffff;

    font-size: 13px;

    font-weight: 700;
}

/* =========================================================
   EMPTY STATE
========================================================= */

.empty-box {

    padding: 35px 20px;

    text-align: center;

    color: #94a3b8;

    font-size: 12px;

    border-radius: 14px;

    background:
        rgba(255,255,255,.025);

    border:
        1px dashed rgba(148,163,184,.12);
}

/* =========================================================
   FOOTER
========================================================= */

.dashboard-footer {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 5px;

    margin-top: 20px;

    padding-top: 16px;

    color: #64748b;

    border-top:
        1px solid rgba(255,255,255,.05);

    font-size: 10px;

    letter-spacing: .2px;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1400px) {

    .cards {

        grid-template-columns:
            repeat(3,minmax(0,1fr));
    }
}

@media (max-width: 1150px) {

    .grid,
    .analytics-grid {

        grid-template-columns: 1fr;
    }

    .hero-content {

        align-items: stretch;
    }

    .hero-right {

        min-width: 210px;
    }
}

@media (max-width: 900px) {

    .cards {

        grid-template-columns:
            repeat(2,minmax(0,1fr));
    }

    .hero-content {

        flex-direction: column;
    }

    .hero-right {

        width: 100%;

        box-sizing: border-box;

        text-align: left;
    }

    .stats-row {

        grid-template-columns:
            repeat(3,minmax(0,1fr));
    }
}

@media (max-width: 650px) {

    .dashboard-container {

        padding: 0 0 25px;
    }

    .hero {

        padding: 25px 20px;

        border-radius: 18px;
    }

    .hero h2 {

        font-size: 25px;
    }

    .hero-buttons {

        display: grid;

        grid-template-columns: 1fr;

        width: 100%;
    }

    .hero-btn {

        width: 100%;
    }

    .hero-right {

        padding: 18px;
    }

    .hero-right h1 {

        font-size: 35px;
    }

    .cards {

        grid-template-columns: 1fr;
    }

    .box {

        padding: 18px;

        border-radius: 16px;
    }

    .chart-header {

        align-items: flex-start;

        flex-direction: column;
    }

    .badge-chart {

        align-self: flex-start;
    }

    .chart-container {

        height: 275px;

        min-height: 275px;
    }

    .stats-row {

        grid-template-columns: 1fr;
    }

    .mini-card {

        padding: 18px;
    }

    .requirement-card {

        align-items: flex-start;
    }
}

@media (max-width: 420px) {

    .hero {

        padding: 22px 17px;
    }

    .hero h2 {

        font-size: 22px;
    }

    .hero p {

        font-size: 12px;
    }

    .card {

        min-height: 150px;
    }

    .card-number {

        font-size: 32px;
    }

    .chart-container {

        height: 250px;

        min-height: 250px;
    }

    .section-title {

        align-items: flex-start;

        flex-direction: column;
    }
}

/* =========================================================
   ACCESSIBILITY
========================================================= */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {

        transition-duration: .01ms !important;

        animation-duration: .01ms !important;

        animation-iteration-count: 1 !important;
    }
}

</style>


<div class="dashboard-container">


<!-- =========================================================
     HERO
========================================================= -->

<div class="hero">

    <div class="hero-content">

        <div>

            @php

                $hour = now()->hour;

                if ($hour < 12) {

                    $greeting = 'Good Morning';

                    $icon = '☀️';

                } elseif ($hour < 18) {

                    $greeting = 'Good Afternoon';

                    $icon = '🌤️';

                } else {

                    $greeting = 'Good Evening';

                    $icon = '🌙';

                }

            @endphp


            <h2>
                {{ $icon }}
                {{ $greeting }},
                {{ Auth::user()->name }}
            </h2>


            <p>
                Onboard Training Report System Dashboard
            </p>


            <div class="hero-buttons">

                <a
                    href="{{ route('superadmin.cadets.index') }}"
                    class="hero-btn"
                >
                    <i class="fas fa-user-graduate"></i>

                    <span>
                        Manage Cadets
                    </span>
                </a>


                <a
                    href="{{ route('superadmin.deployments.index') }}"
                    class="hero-btn"
                >
                    <i class="fas fa-ship"></i>

                    <span>
                        Deployments
                    </span>
                </a>


                <a
                    href="{{ route('superadmin.complaints.index') }}"
                    class="hero-btn"
                >
                    <i class="fas fa-file-circle-exclamation"></i>

                    <span>
                        Complaints
                    </span>
                </a>

            </div>

        </div>


        <div class="hero-right">

            <h4>
                {{ now()->format('l, F d, Y') }}
            </h4>


            <h1>
                {{ $deploymentPercentage }}%
            </h1>


            <p>
                Overall Deployment Rate
            </p>

        </div>

    </div>

</div>


<!-- =========================================================
     KPI CARDS
========================================================= -->

<div class="cards">


    <!-- TOTAL CADETS -->

    <a
        href="{{ route('superadmin.cadets.index') }}"
        class="card blue"
    >

        <div class="card-top">

            <div>

                <div class="card-title">
                    Total Cadets
                </div>

                <div class="card-number">
                    {{ $totalCadets }}
                </div>

            </div>


            <div class="card-icon">

                <i class="fas fa-user-graduate"></i>

            </div>

        </div>


        <div class="card-footer">

            <span>
                Total Registered
            </span>

            <span>
                100%
            </span>

        </div>

    </a>


    <!-- ONGOING -->

    <a
        href="{{ route('superadmin.deployments.index') }}"
        class="card green"
    >

        <div class="card-top">

            <div>

                <div class="card-title">
                    Ongoing Deployment
                </div>

                <div class="card-number">
                    {{ $totalDeployed }}
                </div>

            </div>


            <div class="card-icon">

                <i class="fas fa-ship"></i>

            </div>

        </div>


        <div class="card-footer">

            <span>
                Currently Onboard
            </span>

            <span>
                Active
            </span>

        </div>

    </a>


    <!-- COMPLETED -->

    <a
        href="#"
        class="card cyan"
    >

        <div class="card-top">

            <div>

                <div class="card-title">
                    Completed
                </div>

                <div class="card-number">
                    {{ $totalCompleted }}
                </div>

            </div>


            <div class="card-icon">

                <i class="fas fa-check"></i>

            </div>

        </div>


        <div class="card-footer">

            <span>
                Finished OBT
            </span>

            <span>
                Done
            </span>

        </div>

    </a>


    <!-- PENDING -->

    <a
        href="#"
        class="card orange"
    >

        <div class="card-top">

            <div>

                <div class="card-title">
                    Pending Verification
                </div>

                <div class="card-number">
                    {{ $pendingVerification }}
                </div>

            </div>


            <div class="card-icon">

                <i class="fas fa-file"></i>

            </div>

        </div>


        <div class="card-footer">

            <span>
                Awaiting Review
            </span>

            <span>
                Pending
            </span>

        </div>

    </a>


    <!-- COMPLAINTS -->

    <a
        href="#"
        class="card red"
    >

        <div class="card-top">

            <div>

                <div class="card-title">
                    Complaints
                </div>

                <div class="card-number">
                    {{ $withComplaints }}
                </div>

            </div>


            <div class="card-icon">

                <i class="fas fa-exclamation-triangle"></i>

            </div>

        </div>


        <div class="card-footer">

            <span>
                Open Reports
            </span>

            <span>
                Attention
            </span>

        </div>

    </a>

</div>


<!-- =========================================================
     MAIN CHARTS
========================================================= -->

<div class="grid">


    <!-- =====================================================
         DEPLOYMENT ANALYTICS
    ====================================================== -->

    <div class="box">

        <div class="chart-header">

            <div>

                <h3>
                    <i class="fas fa-chart-column"></i>
                    Deployment Analytics
                </h3>

                <small>
                    Current cadet deployment status
                </small>

            </div>


            <span class="badge-chart">
                Live
            </span>

        </div>


        <div class="chart-container">

            <canvas id="barChart"></canvas>

        </div>

    </div>


    <!-- =====================================================
         VERIFICATION
    ====================================================== -->

    <div class="box">

        <div class="chart-header">

            <div>

                <h3>
                    <i class="fas fa-circle-check"></i>
                    Verification Overview
                </h3>

                <small>
                    Document verification status
                </small>

            </div>


            <span class="badge-chart green">
                Updated
            </span>

        </div>


        <div class="chart-container">

            <canvas id="pieChart"></canvas>

        </div>

    </div>

</div>


<!-- =========================================================
     BATCH DEPLOYMENT GRAPH
========================================================= -->

<div class="box analytics-box">

    <div class="chart-header">

        <div>

            <h3>
                <i class="fas fa-chart-line"></i>
                Batch Deployment Graphical Summary
            </h3>

            <small>
                Deployment comparison by batch
            </small>

        </div>


        <span class="badge-chart">
            Batch Statistics
        </span>

    </div>


    <div class="chart-container">

        <canvas id="batchLineChart"></canvas>

    </div>

</div>


<!-- =========================================================
     ANALYTICS
========================================================= -->

<div class="analytics-grid">


    <!-- =====================================================
         LEFT
    ====================================================== -->

    <div>


        <!-- DEPLOYMENT PROGRESS -->

        <div class="box analytics-box">

            <div class="section-title">

                <h3>
                    <i class="fas fa-chart-line"></i>
                    Deployment Progress
                </h3>


                <span>
                    {{ $deploymentPercentage }}%
                </span>

            </div>


            <div class="overall-progress">

                <div
                    class="overall-fill"
                    style="width: {{ $deploymentPercentage }}%;"
                ></div>

            </div>


            @forelse($courseDeployment as $course)

                <div class="course-progress">

                    <div class="course-header">

                        <span>
                            {{ $course['course'] }}
                        </span>


                        <strong>
                            {{ $course['deployed'] }}
                            /
                            {{ $course['total'] }}
                        </strong>

                    </div>


                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: {{ $course['percentage'] }}%;"
                        >
                            {{ $course['percentage'] }}%
                        </div>

                    </div>

                </div>

            @empty

                <div class="empty-box">

                    No course deployment data available.

                </div>

            @endforelse

        </div>


        <!-- COMPLAINT ANALYTICS -->

        <div class="box analytics-box">

            <h3>
                <i class="fas fa-clipboard-list"></i>
                Concern Analytics
            </h3>


            <div class="stats-row">


                <div class="mini-card red">

                    <h1>
                        {{ $withComplaints }}
                    </h1>

                    <small>
                        Open
                    </small>

                </div>


                <div class="mini-card green">

                    <h1>
                        {{ $resolvedComplaints }}
                    </h1>

                    <small>
                        Resolved
                    </small>

                </div>


                <div class="mini-card blue">

                    <h1>
                        {{ $withComplaints + $resolvedComplaints }}
                    </h1>

                    <small>
                        Total
                    </small>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         RIGHT
    ====================================================== -->

    <div>


        <!-- INCOMPLETE REQUIREMENTS -->

        <div class="box analytics-box">

            <h3>
                <i class="fas fa-triangle-exclamation"></i>
                Incomplete Requirements
            </h3>


            <div class="requirements-list">

                @forelse($incompleteRequirements as $cadet)

                    <div class="requirement-card">

                        <div>

                            <strong>
                                {{ $cadet->full_name }}
                            </strong>

                            <small>
                                {{ $cadet->course }}
                            </small>

                        </div>


                        <span class="badge-warning">
                            Pending
                        </span>

                    </div>

                @empty

                    <div class="empty-box">

                        🎉 No incomplete requirements

                    </div>

                @endforelse

            </div>

        </div>


        <!-- SYSTEM SUMMARY -->

        <div class="box analytics-box">

            <h3>
                <i class="fas fa-anchor"></i>
                System Summary
            </h3>


            <div class="summary-row">

                <span>
                    Total Cadets
                </span>

                <strong>
                    {{ $totalCadets }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Ongoing
                </span>

                <strong>
                    {{ $totalDeployed }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Completed
                </span>

                <strong>
                    {{ $totalCompleted }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Not Deployed
                </span>

                <strong>
                    {{ $notDeployed }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Pending Verification
                </span>

                <strong>
                    {{ $pendingVerification }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Verified
                </span>

                <strong>
                    {{ $verified }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Deficiency
                </span>

                <strong>
                    {{ $deficiency }}
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    BS Qualified
                </span>

                <strong>
                    {{ $bsCompleted }}
                </strong>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     FOOTER
========================================================= -->

<div class="dashboard-footer">

    Last Updated:

    {{ now()->format('M d, Y h:i A') }}

</div>


</div>


<!-- =========================================================
     CHART.JS
========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- =========================================================
     DASHBOARD CHARTS
========================================================= -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           CHECK CHART.JS
        ====================================================== */

        if (typeof Chart === 'undefined') {

            console.error(
                'Chart.js failed to load.'
            );

            return;
        }


        /* =====================================================
           DEPLOYMENT ANALYTICS
        ====================================================== */

        const barCanvas =
            document.getElementById(
                'barChart'
            );


        if (barCanvas) {

            const barCtx =
                barCanvas.getContext('2d');


            const barGradient1 =
                barCtx.createLinearGradient(
                    0,
                    0,
                    0,
                    320
                );

            barGradient1.addColorStop(
                0,
                '#ef4444'
            );

            barGradient1.addColorStop(
                1,
                '#dc2626'
            );


            const barGradient2 =
                barCtx.createLinearGradient(
                    0,
                    0,
                    0,
                    320
                );

            barGradient2.addColorStop(
                0,
                '#3b82f6'
            );

            barGradient2.addColorStop(
                1,
                '#1d4ed8'
            );


            const barGradient3 =
                barCtx.createLinearGradient(
                    0,
                    0,
                    0,
                    320
                );

            barGradient3.addColorStop(
                0,
                '#10b981'
            );

            barGradient3.addColorStop(
                1,
                '#059669'
            );


            new Chart(
                barCtx,
                {

                    type: 'bar',


                    data: {

                        labels: [

                            'Not Deployed',

                            'Ongoing',

                            'Completed'

                        ],


                        datasets: [{

                            label: 'Cadets',


                            data: [

                                {{ $notDeployed }},

                                {{ $totalDeployed }},

                                {{ $totalCompleted }}

                            ],


                            backgroundColor: [

                                barGradient1,

                                barGradient2,

                                barGradient3

                            ],


                            borderRadius: 14,


                            borderSkipped: false,


                            barThickness: 55

                        }]
                    },


                    options: {

                        responsive: true,


                        maintainAspectRatio: false,


                        animation: {

                            duration: 1500,

                            easing: 'easeOutQuart'

                        },


                        plugins: {

                            legend: {

                                display: false

                            },


                            tooltip: {

                                backgroundColor:
                                    '#111827',

                                titleColor:
                                    '#ffffff',

                                bodyColor:
                                    '#ffffff',

                                padding: 14,

                                cornerRadius: 10

                            }

                        },


                        scales: {

                            y: {

                                beginAtZero: true,


                                ticks: {

                                    color:
                                        '#cbd5e1',

                                    precision: 0

                                },


                                grid: {

                                    color:
                                        'rgba(255,255,255,.05)'

                                }

                            },


                            x: {

                                ticks: {

                                    color:
                                        '#ffffff',

                                    font: {

                                        size: 13,

                                        weight: '600'

                                    }

                                },


                                grid: {

                                    display: false

                                }

                            }

                        }

                    }

                }
            );

        }


        /* =====================================================
           VERIFICATION OVERVIEW
        ====================================================== */

        const pieCanvas =
            document.getElementById(
                'pieChart'
            );


        if (pieCanvas) {

            const pieCtx =
                pieCanvas.getContext('2d');


            const verifiedGradient =
                pieCtx.createLinearGradient(
                    0,
                    0,
                    0,
                    320
                );


            verifiedGradient.addColorStop(
                0,
                '#22c55e'
            );


            verifiedGradient.addColorStop(
                1,
                '#16a34a'
            );


            const pendingGradient =
                pieCtx.createLinearGradient(
                    0,
                    0,
                    0,
                    320
                );


            pendingGradient.addColorStop(
                0,
                '#f59e0b'
            );


            pendingGradient.addColorStop(
                1,
                '#d97706'
            );


            const deficiencyGradient =
                pieCtx.createLinearGradient(
                    0,
                    0,
                    0,
                    320
                );


            deficiencyGradient.addColorStop(
                0,
                '#ef4444'
            );


            deficiencyGradient.addColorStop(
                1,
                '#dc2626'
            );


            new Chart(
                pieCtx,
                {

                    type: 'doughnut',


                    data: {

                        labels: [

                            'Verified',

                            'Pending',

                            'Deficiency'

                        ],


                        datasets: [{

                            data: [

                                {{ $verified }},

                                {{ $pendingVerification }},

                                {{ $deficiency }}

                            ],


                            backgroundColor: [

                                verifiedGradient,

                                pendingGradient,

                                deficiencyGradient

                            ],


                            borderWidth: 5,


                            borderColor:
                                '#101B48',


                            hoverOffset: 15,


                            cutout: '70%'

                        }]

                    },


                    options: {

                        responsive: true,


                        maintainAspectRatio: false,


                        animation: {

                            animateRotate: true,

                            animateScale: true,

                            duration: 1500

                        },


                        plugins: {

                            legend: {

                                position: 'bottom',


                                labels: {

                                    color:
                                        '#ffffff',

                                    padding: 20,

                                    boxWidth: 15,

                                    boxHeight: 15,


                                    font: {

                                        size: 13,

                                        weight: '600'

                                    }

                                }

                            },


                            tooltip: {

                                backgroundColor:
                                    '#111827',

                                titleColor:
                                    '#ffffff',

                                bodyColor:
                                    '#ffffff',

                                padding: 14,

                                cornerRadius: 10

                            }

                        }

                    }

                }
            );

        }


        /* =====================================================
           BATCH DEPLOYMENT GRAPH
        ====================================================== */

        const batchCanvas =
            document.getElementById(
                'batchLineChart'
            );


        if (batchCanvas) {

            const batchCtx =
                batchCanvas.getContext(
                    '2d'
                );


            const batchLabels =
                @json($batchLabels);


            const batchTotals =
                @json($batchTotals);


            const batchDeployed =
                @json($batchDeployed);


            const batchPercentages =
                @json($batchPercentages);


            new Chart(
                batchCtx,
                {

                    data: {

                        labels:
                            batchLabels,


                        datasets: [

                            {

                                type: 'bar',

                                label:
                                    'Total Cadets',

                                data:
                                    batchTotals,

                                backgroundColor:
                                    '#64748b',

                                borderRadius: 8

                            },


                            {

                                type: 'bar',

                                label:
                                    'Deployed',

                                data:
                                    batchDeployed,

                                backgroundColor:
                                    '#3b82f6',

                                borderRadius: 8

                            },


                            {

                                type: 'line',

                                label:
                                    'Deployment %',

                                data:
                                    batchPercentages,

                                borderColor:
                                    '#10b981',

                                backgroundColor:
                                    '#10b981',

                                tension: 0.35,

                                fill: false,

                                yAxisID:
                                    'y1',

                                pointRadius: 6,

                                pointHoverRadius: 8

                            }

                        ]

                    },


                    options: {

                        responsive: true,


                        maintainAspectRatio: false,


                        interaction: {

                            mode: 'index',

                            intersect: false

                        },


                        animation: {

                            duration: 1500

                        },


                        plugins: {

                            legend: {

                                labels: {

                                    color:
                                        '#ffffff',

                                    font: {

                                        weight:
                                            '600'

                                    }

                                }

                            },


                            tooltip: {

                                backgroundColor:
                                    '#111827',

                                titleColor:
                                    '#ffffff',

                                bodyColor:
                                    '#ffffff',

                                padding: 14,

                                cornerRadius: 10

                            }

                        },


                        scales: {

                            x: {

                                ticks: {

                                    color:
                                        '#ffffff',

                                    font: {

                                        weight:
                                            '600'

                                    }

                                },


                                grid: {

                                    color:
                                        'rgba(255,255,255,.05)'

                                }

                            },


                            y: {

                                beginAtZero: true,


                                ticks: {

                                    color:
                                        '#ffffff',

                                    precision: 0

                                },


                                grid: {

                                    color:
                                        'rgba(255,255,255,.05)'

                                },


                                title: {

                                    display: true,

                                    text:
                                        'Cadets',

                                    color:
                                        '#ffffff'

                                }

                            },


                            y1: {

                                position: 'right',


                                beginAtZero: true,


                                max: 100,


                                ticks: {

                                    color:
                                        '#10b981',


                                    callback:
                                        function(value) {

                                            return value + '%';

                                        }

                                },


                                grid: {

                                    drawOnChartArea:
                                        false

                                },


                                title: {

                                    display: true,

                                    text:
                                        'Deployment %',

                                    color:
                                        '#10b981'

                                }

                            }

                        }

                    }

                }
            );

        }

    }

);

</script>

@endsection