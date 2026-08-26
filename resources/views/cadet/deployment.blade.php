@extends('layouts.cadet')

@section('content')

<style>

/* =========================================================
   DEPLOYMENT PAGE
========================================================= */

.deployment-page{
    min-height:100vh;
    padding:30px;
    background:
        linear-gradient(
            135deg,
            #081120 0%,
            #0f1f3d 50%,
            #142850 100%
        );
    color:#fff;
}

/* =========================================================
   HEADER
========================================================= */

.page-title{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:25px;
}

.page-title h2{
    font-size:32px;
    font-weight:700;
    margin:0;
}

.page-line{
    flex:1;
    height:2px;
    background:rgba(255,255,255,0.2);
}

/* =========================================================
   STATISTICS GRID
========================================================= */

.stats-grid{

    display:grid;

    grid-template-columns:
        repeat(auto-fit,minmax(230px,1fr));

    gap:22px;

    margin-bottom:30px;
}

/* =========================================================
   STAT CARD
========================================================= */

.stat-card{

    position:relative;

    overflow:hidden;

    padding:25px;

    min-height:160px;

    border-radius:24px;

    color:white;

    display:flex;

    flex-direction:column;

    justify-content:center;

    border:1px solid rgba(255,255,255,.15);

    box-shadow:
        0 15px 35px rgba(0,0,0,.35);

    transition:.35s ease;
}

.stat-card:hover{

    transform:
        translateY(-8px)
        scale(1.02);

    box-shadow:
        0 25px 50px rgba(0,0,0,.45);
}

/* =========================================================
   FLOATING CIRCLES
========================================================= */

.stat-card::before{

    content:"";

    position:absolute;

    width:140px;
    height:140px;

    right:-40px;
    top:-40px;

    border-radius:50%;

    background:
        rgba(255,255,255,.15);
}

.stat-card::after{

    content:"";

    position:absolute;

    width:90px;
    height:90px;

    left:-30px;
    bottom:-30px;

    border-radius:50%;

    background:
        rgba(255,255,255,.08);
}

/* =========================================================
   ICON
========================================================= */

.stat-icon{

    width:45px;
    height:45px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:15px;

    background:
        rgba(255,255,255,.18);

    font-size:22px;

    margin-bottom:15px;
}

/* =========================================================
   STAT TEXT
========================================================= */

.stat-card h4{

    color:
        rgba(255,255,255,.8);

    font-size:14px;

    font-weight:600;

    margin-bottom:8px;
}

.stat-card p{

    color:white;

    font-size:30px;

    font-weight:800;

    margin:0;

    line-height:1.2;

    word-break:break-word;
}

/* =========================================================
   STAT COLORS
========================================================= */

.deploy-status{

    background:
        linear-gradient(
            135deg,
            #22c55e,
            #166534
        );
}

.deploy-progress{

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1e40af
        );
}

.deploy-vessel{
    background:
        linear-gradient(
            135deg,
            #0ea5e9,
            #075985
        );
}

.deploy-company{

    background:
        linear-gradient(
            135deg,
            #8b5cf6,
            #581c87
        );
}

/* =========================================================
   MAIN DEPLOYMENT CARD
========================================================= */

.deploy-card{

    background:
        rgba(255,255,255,.05);

    backdrop-filter:
        blur(18px);

    border:
        1px solid rgba(255,255,255,.1);

    border-radius:20px;

    overflow:hidden;

    box-shadow:
        0 10px 30px rgba(0,0,0,.35);
}

/* =========================================================
   CARD HEADER
========================================================= */

.deploy-header{

    padding:25px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    font-size:24px;

    font-weight:800;

    display:flex;

    align-items:center;

    gap:12px;
}

.deploy-header-icon{
    font-size:26px;
}

/* =========================================================
   BODY
========================================================= */

.deploy-body{
    padding:0;
}

/* =========================================================
   INFORMATION ROW
========================================================= */

.info-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:20px;

    padding:22px;

    border-bottom:
        1px solid rgba(255,255,255,0.08);

    font-size:17px;

    flex-wrap:wrap;
}

.info-row:last-child{
    border-bottom:none;
}

.info-label{

    color:
        rgba(255,255,255,.65);

    font-weight:600;

    display:flex;

    align-items:center;

    gap:10px;
}

.info-value{

    color:#fff;

    font-weight:700;

    text-align:right;

    word-break:break-word;
}

/* =========================================================
   STATUS BADGE
========================================================= */

.status-badge{

    padding:10px 20px;

    border-radius:30px;

    background:
        rgba(34,197,94,0.15);

    border:
        1px solid rgba(34,197,94,0.4);

    color:#4ade80;

    font-weight:600;

    display:flex;

    align-items:center;

    gap:10px;
}

.status-dot{

    width:10px;
    height:10px;

    border-radius:50%;

    background:#4ade80;

    box-shadow:
        0 0 10px rgba(74,222,128,.8);
}

/* =========================================================
   DEPLOYMENT TYPE BADGE
========================================================= */

.type-badge{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:8px 15px;

    border-radius:20px;

    background:
        rgba(59,130,246,.15);

    border:
        1px solid rgba(59,130,246,.35);

    color:#60a5fa;

    font-size:14px;

    font-weight:700;
}

/* =========================================================
   PROGRESS
========================================================= */

.progress-wrapper{

    display:flex;

    align-items:center;

    gap:12px;

    width:100%;

    max-width:430px;
}

.progress-container{

    width:100%;

    height:16px;

    background:#1e293b;

    border-radius:50px;

    overflow:hidden;
}

.progress-bar{

    height:100%;

    background:
        linear-gradient(
            90deg,
            #3b82f6,
            #60a5fa
        );

    border-radius:50px;

    transition:.5s ease;
}

.percent-text{

    min-width:50px;

    font-weight:800;

    color:#60a5fa;

    text-align:right;
}

/* =========================================================
   LOCATION
========================================================= */

.location-value{

    display:flex;

    align-items:center;

    gap:8px;

    color:#fff;

    font-weight:700;

    text-align:right;
}

/* =========================================================
   DATE
========================================================= */

.date-value{

    color:#fff;

    font-weight:700;
}

/* =========================================================
   SECTION DIVIDER
========================================================= */

.deployment-section-title{

    padding:18px 22px;

    background:
        rgba(255,255,255,.035);

    border-bottom:
        1px solid rgba(255,255,255,.08);

    color:#60a5fa;

    font-size:14px;

    font-weight:800;

    text-transform:uppercase;

    letter-spacing:.6px;
}

/* =========================================================
   NOTE
========================================================= */

.note-box{

    margin:25px;

    padding:20px;

    border-radius:15px;

    background:
        rgba(59,130,246,0.08);

    border-left:
        5px solid #3b82f6;

    display:flex;

    gap:15px;
}

.note-dot{

    width:14px;
    height:14px;

    flex-shrink:0;

    background:#3b82f6;

    border-radius:50%;

    margin-top:6px;

    box-shadow:
        0 0 12px rgba(59,130,246,.7);
}

.note-text{

    color:white;

    font-size:18px;

    line-height:1.5;
}

/* =========================================================
   NO DEPLOYMENT
========================================================= */

.no-deployment{

    padding:50px 25px;

    text-align:center;
}

.no-deployment-icon{

    font-size:55px;

    margin-bottom:15px;
}

.no-deployment h3{

    margin:0 0 10px;

    font-size:22px;
}

.no-deployment p{

    margin:0;

    color:
        rgba(255,255,255,.6);

    font-size:15px;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width:768px){

    .deployment-page{
        padding:15px;
    }

    .page-title{

        flex-direction:column;

        align-items:flex-start;

        gap:10px;
    }

    .page-title h2{
        font-size:24px;
    }

    .page-line{
        width:100%;
    }

    .deploy-header{

        font-size:20px;

        padding:18px;
    }

    .info-row{

        flex-direction:column;

        align-items:flex-start;

        gap:12px;

        padding:18px;

        font-size:15px;
    }

    .info-value{

        text-align:left;

        width:100%;
    }

    .location-value{

        text-align:left;
    }

    .progress-wrapper{

        width:100%;

        max-width:none;

        flex-direction:column;

        align-items:flex-start;
    }

    .progress-container{

        max-width:100%;
    }

    .percent-text{

        text-align:left;
    }

    .status-badge{

        width:100%;

        justify-content:center;

        box-sizing:border-box;
    }

    .type-badge{

        width:auto;
    }

    .note-box{

        margin:15px;

        padding:15px;
    }

    .note-text{

        font-size:15px;
    }

    .stat-card{

        padding:18px;
    }
}

@media (max-width:480px){

    .page-title h2{
        font-size:20px;
    }

    .deploy-header{
        font-size:18px;
    }

    .stat-card p{
        font-size:20px;
    }

    .status-badge{
        font-size:14px;
    }

    .note-text{
        font-size:14px;
    }

    .info-row{
        padding:16px;
    }
}

</style>


<div class="deployment-page">

    {{-- =========================================================
         PAGE TITLE
    ========================================================== --}}

    <div class="page-title">

        <h2>
            Deployment Status
        </h2>

        <div class="page-line"></div>

    </div>


    {{-- =========================================================
         TOP STATISTICS
    ========================================================== --}}

    <div class="stats-grid">


        {{-- STATUS --}}

        <div class="stat-card deploy-status">

            <div class="stat-icon">
                🚢
            </div>

            <h4>
                Deployment Status
            </h4>

            <p>
                {{ $deployment->status ?? 'Not Deployed' }}
            </p>

        </div>


        {{-- PROGRESS --}}

        <div class="stat-card deploy-progress">

            <div class="stat-icon">
                📊
            </div>

            <h4>
                Training Progress
            </h4>

            <p>
                {{ $deployment->percentage ?? $cadet->deployment_percentage ?? 0 }}%
            </p>

        </div>


{{-- VESSEL --}}

<div class="stat-card deploy-company">

    <div class="stat-icon">
        🚢
    </div>

    <h4>
        Vessel
    </h4>

    <p>
        {{ $deployment->vessel_name ?? 'N/A' }}
    </p>

</div>


{{-- COMPANY --}}

<div class="stat-card deploy-company">

    <div class="stat-icon">
        🏢
    </div>

    <h4>
        Company
    </h4>

    <p>
        {{ $deployment->company_name ?? 'N/A' }}
    </p>

</div>


    </div>


    {{-- =========================================================
         MAIN DEPLOYMENT CARD
    ========================================================== --}}

    <div class="deploy-card">


        {{-- HEADER --}}

        <div class="deploy-header">

            <span class="deploy-header-icon">
                🚢
            </span>

            <span>
                Deployment Information
            </span>

        </div>


        <div class="deploy-body">


            {{-- =====================================================
                 DEPLOYMENT STATUS
            ====================================================== --}}

            <div class="deployment-section-title">
                Current Deployment
            </div>


            {{-- STATUS --}}

            <div class="info-row">

                <span class="info-label">
                    🚦 Deployment Status
                </span>

                @php
                    $status = strtolower(
                        trim(
                            $deployment->status ?? 'Not Deployed'
                        )
                    );
                @endphp


                <div
                    class="status-badge"
                    style="
                        @if($status === 'completed')
                            background:rgba(34,197,94,.15);
                            border-color:rgba(34,197,94,.4);
                            color:#4ade80;
                        @elseif($status === 'ongoing')
                            background:rgba(59,130,246,.15);
                            border-color:rgba(59,130,246,.4);
                            color:#60a5fa;
                        @elseif($status === 'not started' || $status === 'not deployed')
                            background:rgba(245,158,11,.15);
                            border-color:rgba(245,158,11,.4);
                            color:#fbbf24;
                        @else
                            background:rgba(255,255,255,.08);
                            border-color:rgba(255,255,255,.15);
                            color:#fff;
                        @endif
                    "
                >

                    <div
                        class="status-dot"
                        style="
                            @if($status === 'completed')
                                background:#4ade80;
                            @elseif($status === 'ongoing')
                                background:#60a5fa;
                            @elseif($status === 'not started' || $status === 'not deployed')
                                background:#fbbf24;
                            @else
                                background:#fff;
                            @endif
                        "
                    ></div>

                    <span id="statusText">
                        {{ $deployment->status ?? 'Not Deployed' }}
                    </span>

                </div>

            </div>


{{-- VESSEL --}}

<div class="info-row">

    <span class="info-label">
        🚢 Vessel
    </span>

    <span class="info-value">
        {{ $deployment->vessel_name ?? 'N/A' }}
    </span>

</div>


{{-- COMPANY --}}

<div class="info-row">

    <span class="info-label">
        🏢 Company
    </span>

    <span class="info-value">
        {{ $deployment->company_name ?? 'N/A' }}
    </span>

</div>


            {{-- =====================================================
                 DEPLOYMENT TYPE
            ====================================================== --}}

            <div class="info-row">

                <span class="info-label">
                    🌎 Deployment Type
                </span>

                <span class="type-badge">

                    @if(($deployment->deployment_type ?? '') === 'International')

                        🌐

                    @else

                        🇵🇭

                    @endif

                    {{ $deployment->deployment_type ?? 'N/A' }}

                </span>

            </div>


            {{-- =====================================================
                 EMBARKATION PLACE
            ====================================================== --}}

            <div class="info-row">

                <span class="info-label">
                    ⚓ Embarkation Place
                </span>

                <span class="location-value">

                    📍

                    {{ $deployment->embarkation_place ?? 'N/A' }}

                </span>

            </div>


            {{-- =====================================================
                 EMBARKATION DATE
            ====================================================== --}}

            <div class="info-row">

                <span class="info-label">
                    📅 Embarkation Date
                </span>

                <span class="date-value">

                    @if($deployment && $deployment->date_deployed)

                        {{ \Carbon\Carbon::parse(
                            $deployment->date_deployed
                        )->format('M d, Y') }}

                    @else

                        N/A

                    @endif

                </span>

            </div>


            {{-- =====================================================
                 DISEMBARKATION PLACE
            ====================================================== --}}

            <div class="info-row">

                <span class="info-label">
                    ⚓ Disembarkation Place
                </span>

                <span class="location-value">

                    📍

                    {{ $deployment->disembarkation_place ?? 'N/A' }}

                </span>

            </div>


            {{-- =====================================================
                 DISEMBARKATION DATE
            ====================================================== --}}

            <div class="info-row">

                <span class="info-label">
                    📅 Disembarkation Date
                </span>

                <span class="date-value">

                    @if($deployment && $deployment->date_disembarked)

                        {{ \Carbon\Carbon::parse(
                            $deployment->date_disembarked
                        )->format('M d, Y') }}

                    @else

                        N/A

                    @endif

                </span>

            </div>


            {{-- =====================================================
                 PROGRESS
            ====================================================== --}}

            <div class="info-row">

                <span class="info-label">
                    📊 Training Progress
                </span>

                @php

                    $progress = (int) (
                        $deployment->percentage
                        ?? $cadet->deployment_percentage
                        ?? 0
                    );

                    $progress = max(
                        0,
                        min(100, $progress)
                    );

                @endphp


                <div class="progress-wrapper">

                    <div class="progress-container">

                        <div
                            class="progress-bar"
                            style="width: {{ $progress }}%;"
                        ></div>

                    </div>

                    <span
                        id="percentText"
                        class="percent-text"
                    >
                        {{ $progress }}%
                    </span>

                </div>

            </div>


            {{-- =====================================================
                 LEGACY DATE DEPLOYED
            ====================================================== --}}

            @if(
                isset($deployment->date_deployed)
                && $deployment->date_deployed
            )

                <div class="info-row">

                    <span class="info-label">
                        🚢 Date Deployed
                    </span>

                    <span class="date-value">

                        {{ \Carbon\Carbon::parse(
                            $deployment->date_deployed
                        )->format('M d, Y') }}

                    </span>

                </div>

            @endif


            {{-- =====================================================
                 NOTE
            ====================================================== --}}

            <div class="note-box">

                <div class="note-dot"></div>

                <div class="note-text">

                    You are currently undergoing onboard training.
                    Please ensure to complete all required tasks and
                    maintain open communication regarding your progress.

                </div>

            </div>


        </div>

    </div>

</div>

@endsection