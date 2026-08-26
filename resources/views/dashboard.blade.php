@extends('layouts.cadet')

@section('content')

<style>

/* =========================================================
   GLOBAL
========================================================= */

.dashboard-container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    color: #fff;
    overflow-x: hidden;
}

.dashboard-container *,
.dashboard-container *::before,
.dashboard-container *::after {
    box-sizing: border-box;
}


/* =========================================================
   PAGE HEADER
========================================================= */

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 28px;
}

.dashboard-title-area {
    min-width: 0;
}

.dashboard-title {
    margin: 0 0 8px;

    color: #fff;

    font-size: clamp(24px, 4vw, 32px);
    font-weight: 800;

    line-height: 1.25;

    overflow-wrap: anywhere;
}

.dashboard-subtitle {
    margin: 0;

    color: #94a3b8;

    font-size: 14px;

    line-height: 1.6;
}

.dashboard-date {
    flex: 0 0 auto;

    padding: 10px 15px;

    background: rgba(255, 255, 255, .05);

    border: 1px solid rgba(255, 255, 255, .08);

    border-radius: 10px;

    color: #cbd5e1;

    font-size: 12px;

    white-space: nowrap;
}


/* =========================================================
   QUICK STATUS
========================================================= */

.quick-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    margin-top: 12px;

    padding: 7px 12px;

    background: rgba(34, 197, 94, .10);

    border: 1px solid rgba(34, 197, 94, .20);

    border-radius: 30px;

    color: #86efac;

    font-size: 12px;
    font-weight: 600;
}

.quick-status-dot {
    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #22c55e;

    box-shadow: 0 0 10px rgba(34, 197, 94, .7);
}


/* =========================================================
   SUMMARY CARDS
========================================================= */

.cards {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 18px;

    margin-bottom: 22px;
}

.card {
    position: relative;

    min-height: 175px;

    padding: 22px;

    overflow: hidden;

    isolation: isolate;

    border-radius: 20px;

    color: #fff;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, .25);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}

.card:hover {
    transform: translateY(-4px);

    box-shadow:
        0 18px 38px rgba(0, 0, 0, .35);
}


/* Decorative circles */

.card::before,
.card::after {
    content: "";

    position: absolute;

    border-radius: 50%;

    pointer-events: none;

    z-index: -1;
}

.card::before {
    width: 150px;
    height: 150px;

    top: -65px;
    right: -50px;

    background: rgba(255,255,255,.12);
}

.card::after {
    width: 110px;
    height: 110px;

    bottom: -55px;
    left: -35px;

    background: rgba(255,255,255,.06);
}


/* Card icon */

.card-icon {
    display: flex;

    align-items: center;
    justify-content: center;

    width: 44px;
    height: 44px;

    margin-bottom: 15px;

    border-radius: 13px;

    background: rgba(255,255,255,.16);

    font-size: 21px;
}


/* Card label */

.card h4 {
    margin: 0 0 7px;

    color: rgba(255,255,255,.78);

    font-size: 12px;

    font-weight: 700;

    letter-spacing: .6px;

    text-transform: uppercase;
}


/* Card value */

.card p {
    margin: 0;

    color: #fff;

    font-size: 25px;

    font-weight: 800;

    line-height: 1.25;

    overflow-wrap: anywhere;
}


/* Card footer */

.card small {
    display: block;

    margin-top: 9px;

    color: rgba(255,255,255,.68);

    font-size: 11px;

    line-height: 1.5;
}


/* Card progress */

.card-progress {
    width: 100%;
    height: 5px;

    margin-top: 13px;

    overflow: hidden;

    background: rgba(255,255,255,.15);

    border-radius: 20px;
}

.card-progress-fill {
    height: 100%;

    background: rgba(255,255,255,.85);

    border-radius: inherit;

    transition: width .5s ease;
}


/* Card colors */

.card-blue {
    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1e40af
        );
}

.card-purple {
    background:
        linear-gradient(
            135deg,
            #9333ea,
            #581c87
        );
}

.card-green {
    background:
        linear-gradient(
            135deg,
            #22c55e,
            #166534
        );
}

.card-cyan {
    background:
        linear-gradient(
            135deg,
            #06b6d4,
            #155e75
        );
}


/* =========================================================
   MAIN GRID
========================================================= */

.dashboard-grid {
    display: grid;

    grid-template-columns:
        minmax(0, 1.7fr)
        minmax(300px, 1fr);

    gap: 20px;

    width: 100%;
}

.dashboard-left,
.dashboard-right {
    min-width: 0;

    display: flex;

    flex-direction: column;

    gap: 20px;
}


/* =========================================================
   DASHBOARD BOX
========================================================= */

.dashboard-box {
    width: 100%;

    padding: 22px;

    overflow: hidden;

    background: #13133a;

    border:
        1px solid rgba(255,255,255,.06);

    border-radius: 18px;

    box-shadow:
        0 6px 18px rgba(0,0,0,.20);
}

.dashboard-box-header {
    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 12px;

    margin-bottom: 18px;
}

.dashboard-box-header h3 {
    margin: 0;

    color: #fff;

    font-size: 17px;

    font-weight: 700;

    line-height: 1.4;
}

.dashboard-box-header span {
    color: #64748b;

    font-size: 11px;
}


/* =========================================================
   DOCUMENT PROGRESS
========================================================= */

.progress-summary {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 18px;
}

.progress-number {
    color: #fff;

    font-size: 32px;

    font-weight: 800;

    line-height: 1;
}

.progress-label {
    margin-top: 6px;

    color: #94a3b8;

    font-size: 12px;
}

.progress-percentage {
    color: #60a5fa;

    font-size: 15px;

    font-weight: 700;
}


/* Progress */

.progress-bar {
    width: 100%;

    height: 11px;

    overflow: hidden;

    background: #1e293b;

    border-radius: 50px;
}

.progress-fill {
    height: 100%;

    background:
        linear-gradient(
            90deg,
            #3b82f6,
            #8b5cf6
        );

    border-radius: inherit;

    transition: width .6s ease;
}


/* Progress footer */

.progress-footer {
    display: flex;

    justify-content: space-between;

    gap: 10px;

    margin-top: 10px;

    color: #94a3b8;

    font-size: 11px;
}


/* =========================================================
   DOCUMENT STATISTICS
========================================================= */

.document-stats {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0,1fr));

    gap: 10px;

    margin-top: 20px;
}

.document-stat {
    padding: 13px;

    background: #1b1b46;

    border-radius: 12px;
}

.document-stat-number {
    color: #fff;

    font-size: 20px;

    font-weight: 800;
}

.document-stat-label {
    margin-top: 4px;

    color: #94a3b8;

    font-size: 10px;
}


/* =========================================================
   TRAINING STATUS
========================================================= */

.training-status {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0,1fr));

    gap: 12px;

    position: relative;
}


/* Training step */

.training-step {
    position: relative;

    min-width: 0;

    padding: 16px 10px;

    text-align: center;

    background: #1b1b46;

    border:
        1px solid rgba(255,255,255,.06);

    border-radius: 14px;

    transition:
        background .25s ease,
        border-color .25s ease,
        transform .25s ease;
}

.training-step:hover {
    transform: translateY(-2px);
}


/* Training icon */

.training-step-icon {
    width: 38px;
    height: 38px;

    margin: 0 auto 10px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #334155;

    color: #cbd5e1;

    font-size: 14px;

    font-weight: 800;
}


/* Active step */

.training-step.active {
    background:
        rgba(37,99,235,.12);

    border-color:
        rgba(59,130,246,.35);
}

.training-step.active .training-step-icon {
    background: #2563eb;

    color: #fff;

    box-shadow:
        0 0 0 5px rgba(37,99,235,.10);
}


/* Completed step */

.training-step.completed {
    background:
        rgba(34,197,94,.10);

    border-color:
        rgba(34,197,94,.30);
}

.training-step.completed .training-step-icon {
    background: #16a34a;

    color: #fff;

    box-shadow:
        0 0 0 5px rgba(34,197,94,.10);
}


/* Step title */

.training-step-title {
    color: #e2e8f0;

    font-size: 12px;

    font-weight: 700;

    line-height: 1.4;
}


/* Step description */

.training-step-text {
    margin-top: 4px;

    color: #64748b;

    font-size: 10px;

    line-height: 1.4;
}


/* =========================================================
   CURRENT TRAINING STATUS
========================================================= */

.training-current-status {
    display: flex;

    align-items: center;

    gap: 12px;

    margin-top: 18px;

    padding: 14px 15px;

    background: #1b1b46;

    border:
        1px solid rgba(255,255,255,.05);

    border-radius: 13px;
}

.status-icon {
    flex: 0 0 auto;

    width: 38px;
    height: 38px;

    display: flex;

    align-items: center;
    justify-content: center;

    background:
        rgba(96,165,250,.12);

    border-radius: 10px;

    font-size: 18px;
}

.status-title {
    color: #e2e8f0;

    font-size: 12px;

    font-weight: 700;
}

.status-description {
    margin-top: 3px;

    color: #64748b;

    font-size: 10px;

    line-height: 1.5;
}


/* =========================================================
   BUTTON
========================================================= */

.dashboard-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    width: 100%;

    min-height: 42px;

    margin-top: 17px;

    padding: 11px 15px;

    color: #fff;

    text-align: center;

    text-decoration: none;

    font-size: 13px;

    font-weight: 600;

    border: none;

    border-radius: 10px;

    cursor: pointer;

    transition:
        transform .2s ease,
        background .2s ease;
}

.dashboard-btn:hover {
    transform: translateY(-1px);

    color: #fff;
}

.btn-blue {
    background: #2563eb;
}

.btn-blue:hover {
    background: #1d4ed8;
}

.btn-green {
    background: #16a34a;
}

.btn-green:hover {
    background: #15803d;
}


/* =========================================================
   COMPLAINT SUMMARY
========================================================= */

.complaint-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0,1fr));

    gap: 10px;
}

.complaint-card {
    padding: 15px;

    border-radius: 12px;
}

.complaint-card.open {
    background:
        rgba(239,68,68,.09);

    border:
        1px solid rgba(239,68,68,.12);
}

.complaint-card.resolved {
    background:
        rgba(34,197,94,.09);

    border:
        1px solid rgba(34,197,94,.12);
}

.complaint-number {
    font-size: 24px;

    font-weight: 800;
}

.complaint-card.open .complaint-number {
    color: #f87171;
}

.complaint-card.resolved .complaint-number {
    color: #4ade80;
}

.complaint-label {
    margin-top: 4px;

    color: #94a3b8;

    font-size: 11px;
}


/* =========================================================
   NOTIFICATIONS
========================================================= */

.notification-list {
    max-height: 330px;

    margin-top: 5px;

    padding-right: 3px;

    overflow-y: auto;

    overflow-x: hidden;
}

.notification-list::-webkit-scrollbar {
    width: 5px;
}

.notification-list::-webkit-scrollbar-thumb {
    background: #475569;

    border-radius: 20px;
}

.notification-link {
    display: block;

    color: inherit;

    text-decoration: none;
}

.notification-item {
    width: 100%;

    margin-bottom: 10px;

    padding: 13px;

    overflow: hidden;

    border-radius: 12px;

    transition:
        transform .2s ease,
        background .2s ease;
}

.notification-item:hover {
    transform: translateY(-1px);
}

.notification-unread {
    background: #28378e;

    border-left:
        3px solid #60a5fa;
}

.notification-read {
    background: #1e293b;
}

.notification-title {
    margin-bottom: 5px;

    color: #fff;

    font-size: 12px;

    font-weight: 700;

    line-height: 1.5;

    overflow-wrap: anywhere;
}

.notification-message {
    color: #d1d5db;

    font-size: 12px;

    line-height: 1.55;

    overflow-wrap: anywhere;
}

.notification-time {
    margin-top: 7px;

    color: #94a3b8;

    font-size: 10px;
}


/* =========================================================
   NOTIFICATION BADGE
========================================================= */

.notification-badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 20px;
    height: 20px;

    margin-left: 6px;

    padding: 2px 7px;

    color: #fff;

    background: #ef4444;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 700;

    vertical-align: middle;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {
    padding: 25px 10px;

    color: #64748b;

    text-align: center;

    font-size: 12px;

    line-height: 1.6;
}

.empty-icon {
    display: block;

    margin-bottom: 8px;

    font-size: 25px;
}


/* =========================================================
   GPS STATUS
========================================================= */

.gps-status {
    display: flex;

    align-items: center;

    gap: 10px;

    margin-top: 18px;

    padding: 12px 14px;

    background:
        rgba(37,99,235,.08);

    border:
        1px solid rgba(37,99,235,.15);

    border-radius: 11px;
}

.gps-icon {
    flex: 0 0 auto;

    width: 34px;
    height: 34px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background:
        rgba(37,99,235,.15);

    font-size: 16px;
}

.gps-content {
    min-width: 0;
}

.gps-title {
    color: #dbeafe;

    font-size: 11px;

    font-weight: 700;
}

.gps-text {
    margin-top: 2px;

    color: #64748b;

    font-size: 10px;

    line-height: 1.4;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1100px) {

    .cards {
        grid-template-columns:
            repeat(2, minmax(0,1fr));
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .dashboard-header {
        flex-direction: column;

        margin-bottom: 20px;
    }

    .dashboard-date {
        width: 100%;

        text-align: center;
    }

    .cards {
        grid-template-columns: 1fr;

        gap: 12px;

        margin-bottom: 15px;
    }

    .card {
        min-height: 145px;

        padding: 19px;

        border-radius: 17px;
    }

    .dashboard-box {
        padding: 17px;

        border-radius: 15px;
    }

    .training-status {
        grid-template-columns:
            repeat(3, minmax(0,1fr));

        gap: 8px;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 480px) {

    .dashboard-title {
        font-size: 22px;
    }

    .dashboard-subtitle {
        font-size: 12px;
    }

    .dashboard-box-header h3 {
        font-size: 16px;
    }

    .dashboard-box-header span {
        display: none;
    }

    .progress-number {
        font-size: 27px;
    }

    .training-status {
        gap: 7px;
    }

    .training-step {
        padding: 13px 6px;
    }

    .training-step-icon {
        width: 32px;
        height: 32px;

        font-size: 12px;
    }

    .training-step-title {
        font-size: 10px;
    }

    .training-step-text {
        font-size: 9px;
    }

    .training-current-status {
        align-items: flex-start;

        padding: 12px;
    }

    .document-stats {
        gap: 7px;
    }

    .document-stat {
        padding: 11px 8px;
    }

    .document-stat-number {
        font-size: 17px;
    }

    .complaint-grid {
        gap: 7px;
    }

}


/* =========================================================
   EXTRA SMALL
========================================================= */

@media (max-width: 360px) {

    .dashboard-container {
        width: 100%;
    }

    .card p {
        font-size: 21px;
    }

    .training-step-text {
        display: none;
    }

    .document-stat-label {
        font-size: 9px;
    }

    .status-description {
        font-size: 9px;
    }

}


/* =========================================================
   ACCESSIBILITY
========================================================= */

.dashboard-btn:focus-visible,
.notification-link:focus-visible {
    outline: 2px solid #60a5fa;

    outline-offset: 2px;
}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .card,
    .dashboard-btn,
    .notification-item,
    .training-step {
        transition: none;
    }

    .progress-fill,
    .card-progress-fill {
        transition: none;
    }

}

</style>


<div class="dashboard-container">


    {{-- =====================================================
         STATUS VARIABLES
    ====================================================== --}}

    @php

        /*
        |--------------------------------------------------------------------------
        | STEP 1 — ONBOARD REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $requirementsProgress =
            min(100, max(0, (float) ($progress ?? 0)));

        $requirementsCompleted =
            $requirementsProgress >= 100;


        /*
        |--------------------------------------------------------------------------
        | STEP 2 — DEPLOYMENT
        |--------------------------------------------------------------------------
        */

        $deploymentCompleted =
            ($deploymentStatus ?? '') === 'Completed';


        /*
        |--------------------------------------------------------------------------
        | STEP 3 — BS REQUIREMENTS
        |--------------------------------------------------------------------------
        |
        | The controller should provide $bsProgress.
        | Until then, this safely defaults to 0.
        |
        */

        $bsProgress =
            min(100, max(0, (float) ($bsProgress ?? 0)));

        $bsCompleted =
            $bsProgress >= 100;


        /*
        |--------------------------------------------------------------------------
        | OVERALL TRAINING COMPLETION
        |--------------------------------------------------------------------------
        */

        $overallTrainingCompleted =
            $requirementsCompleted &&
            $deploymentCompleted &&
            $bsCompleted;

    @endphp



    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="dashboard-header">

        <div class="dashboard-title-area">

            <h2 class="dashboard-title">
                Welcome, Cadet 👋
            </h2>

            <p class="dashboard-subtitle">
                Here's an overview of your onboard training progress
                and requirements.
            </p>


            <div class="quick-status">

                <span class="quick-status-dot"></span>

                @if($overallTrainingCompleted)

                    Training Completed

                @elseif($deploymentCompleted)

                    BS Requirements Stage

                @elseif($requirementsCompleted)

                    Ready for Deployment

                @else

                    Requirements Stage

                @endif

            </div>

        </div>


        <div class="dashboard-date">

            📅 {{ now()->format('F d, Y') }}

        </div>

    </div>



    {{-- =====================================================
         SUMMARY CARDS
    ====================================================== --}}

    <div class="cards">


        {{-- =================================================
             DEPLOYMENT STATUS
        ================================================== --}}

        <div class="card card-blue">

            <div class="card-icon">
                🚢
            </div>

            <h4>
                Deployment Status
            </h4>

            <p>

                @if(($deploymentStatus ?? '') === 'Not Deployed')

                    Not Deployed

                @elseif(($deploymentStatus ?? '') === 'Completed')

                    Completed

                @elseif(($deploymentStatus ?? '') === 'Ongoing')

                    Ongoing

                @else

                    {{ $deploymentStatus ?? 'Not Deployed' }}

                @endif

            </p>

            <small>
                Current training status
            </small>

            <div class="card-progress">

                <div
                    class="card-progress-fill"
                    style="width:
                        {{ min(
                            100,
                            max(0, (float) ($deploymentProgress ?? 0))
                        ) }}%;"
                ></div>

            </div>

        </div>



        {{-- =================================================
             TRAINING PROGRESS
        ================================================== --}}

        <div class="card card-purple">

            <div class="card-icon">
                📈
            </div>

            <h4>
                Training Progress
            </h4>

            <p>
                {{ $requirementsProgress }}%
            </p>

            <small>
                Onboard requirement completion
            </small>

            <div class="card-progress">

                <div
                    class="card-progress-fill"
                    style="width: {{ $requirementsProgress }}%;"
                ></div>

            </div>

        </div>



        {{-- =================================================
             DOCUMENTS
        ================================================== --}}

        <div class="card card-green">

            <div class="card-icon">
                📄
            </div>

            <h4>
                Documents Approved
            </h4>

            <p>
                {{ $approvedDocs ?? 0 }}/{{ $totalDocs ?? 0 }}
            </p>

            <small>
                Verified requirements
            </small>

            <div class="card-progress">

                <div
                    class="card-progress-fill"
                    style="width:
                        {{
                            ($totalDocs ?? 0) > 0
                                ? min(
                                    100,
                                    max(
                                        0,
                                        (($approvedDocs ?? 0) /
                                        $totalDocs) * 100
                                    )
                                )
                                : 0
                        }}%;"
                ></div>

            </div>

        </div>



        {{-- =================================================
             BS STATUS
        ================================================== --}}

        <div class="card card-cyan">

            <div class="card-icon">
                🎓
            </div>

            <h4>
                BS Status
            </h4>

            <p>

                @if($bsCompleted)

                    Qualified

                @elseif($deploymentCompleted)

                    Incomplete

                @else

                    Pending

                @endif

            </p>

            <small>
                {{ $bsProgress }}% BS requirements completed
            </small>

            <div class="card-progress">

                <div
                    class="card-progress-fill"
                    style="width: {{ $bsProgress }}%;"
                ></div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         MAIN DASHBOARD
    ====================================================== --}}

    <div class="dashboard-grid">


        {{-- =================================================
             LEFT COLUMN
        ================================================== --}}

        <div class="dashboard-left">


            {{-- =================================================
                 DOCUMENT PROGRESS
            ================================================== --}}

            <div class="dashboard-box">

                <div class="dashboard-box-header">

                    <h3>
                        📊 Document Progress
                    </h3>

                    <span>
                        Requirements
                    </span>

                </div>


                <div class="progress-summary">

                    <div>

                        <div class="progress-number">
                            {{ $requirementsProgress }}%
                        </div>

                        <div class="progress-label">
                            Requirements completed
                        </div>

                    </div>


                    <div class="progress-percentage">

                        {{ $approvedDocs ?? 0 }}/{{ $totalDocs ?? 0 }}

                    </div>

                </div>


                <div class="progress-bar">

                    <div
                        class="progress-fill"
                        style="width: {{ $requirementsProgress }}%;"
                    ></div>

                </div>


                <div class="progress-footer">

                    <span>
                        Approved documents
                    </span>

                    <span>
                        {{ $requirementsProgress }}%
                    </span>

                </div>


                {{-- DOCUMENT STATISTICS --}}

                <div class="document-stats">

                    <div class="document-stat">

                        <div class="document-stat-number">
                            {{ $approvedDocs ?? 0 }}
                        </div>

                        <div class="document-stat-label">
                            Approved
                        </div>

                    </div>


                    <div class="document-stat">

                        <div class="document-stat-number">

                            {{
                                max(
                                    0,
                                    ($totalDocs ?? 0) -
                                    ($approvedDocs ?? 0)
                                )
                            }}

                        </div>

                        <div class="document-stat-label">
                            Remaining
                        </div>

                    </div>


                    <div class="document-stat">

                        <div class="document-stat-number">
                            {{ $totalDocs ?? 0 }}
                        </div>

                        <div class="document-stat-label">
                            Total
                        </div>

                    </div>

                </div>


                <a
                    href="{{ route('cadet.requirements') }}"
                    class="dashboard-btn btn-blue"
                >
                    📄 View My Requirements
                </a>

            </div>



            {{-- =================================================
                 TRAINING STATUS
            ================================================== --}}

            <div class="dashboard-box">

                <div class="dashboard-box-header">

                    <h3>
                        🚢 Training Status
                    </h3>

                    <span>
                        Training journey
                    </span>

                </div>


                {{-- =================================================
                     THREE TRAINING STEPS
                ================================================== --}}

                <div class="training-status">


                    {{-- =================================================
                         STEP 1 — REQUIREMENTS
                    ================================================== --}}

                    <div
                        class="training-step
                        {{ $requirementsCompleted
                            ? 'completed'
                            : 'active' }}"
                    >

                        <div class="training-step-icon">

                            @if($requirementsCompleted)

                                ✓

                            @else

                                1

                            @endif

                        </div>


                        <div class="training-step-title">
                            Requirements
                        </div>


                        <div class="training-step-text">

                            @if($requirementsCompleted)

                                Completed

                            @else

                                Complete requirements

                            @endif

                        </div>

                    </div>



                    {{-- =================================================
                         STEP 2 — DEPLOYMENT
                    ================================================== --}}

                    <div
                        class="training-step
                        {{
                            $deploymentCompleted
                                ? 'completed'
                                : (
                                    $requirementsCompleted
                                        ? 'active'
                                        : ''
                                )
                        }}"
                    >

                        <div class="training-step-icon">

                            @if($deploymentCompleted)

                                ✓

                            @else

                                2

                            @endif

                        </div>


                        <div class="training-step-title">
                            Deployment
                        </div>


                        <div class="training-step-text">

                            @if($deploymentCompleted)

                                Completed

                            @elseif($requirementsCompleted)

                                Onboard training

                            @else

                                Locked

                            @endif

                        </div>

                    </div>



                    {{-- =================================================
                         STEP 3 — BS REQUIREMENTS
                    ================================================== --}}

                    <div
                        class="training-step
                        {{
                            $bsCompleted
                                ? 'completed'
                                : (
                                    $deploymentCompleted
                                        ? 'active'
                                        : ''
                                )
                        }}"
                    >

                        <div class="training-step-icon">

                            @if($bsCompleted)

                                ✓

                            @else

                                3

                            @endif

                        </div>


                        <div class="training-step-title">
                            BS Requirements
                        </div>


                        <div class="training-step-text">

                            @if($bsCompleted)

                                Completed

                            @elseif($deploymentCompleted)

                                Complete BS requirements

                            @else

                                Locked

                            @endif

                        </div>

                    </div>

                </div>



                {{-- =================================================
                     CURRENT TRAINING STATUS
                ================================================== --}}

                <div class="training-current-status">


                    @if(!$requirementsCompleted)

                        <div class="status-icon">
                            📄
                        </div>

                        <div>

                            <div class="status-title">
                                Complete your requirements
                            </div>

                            <div class="status-description">
                                Please complete and submit all required
                                onboard training documents before
                                proceeding to deployment.
                            </div>

                        </div>


                    @elseif(!$deploymentCompleted)

                        <div class="status-icon">
                            🚢
                        </div>

                        <div>

                            <div class="status-title">
                                Requirements completed
                            </div>

                            <div class="status-description">
                                Your requirements are complete.
                                Your next stage is onboard deployment
                                and training.
                            </div>

                        </div>


                    @elseif(!$bsCompleted)

                        <div class="status-icon">
                            🎓
                        </div>

                        <div>

                            <div class="status-title">
                                Complete your BS requirements
                            </div>

                            <div class="status-description">
                                Your deployment has been completed.
                                Please complete your remaining BS
                                requirements.
                            </div>

                        </div>


                    @else

                        <div class="status-icon">
                            🎉
                        </div>

                        <div>

                            <div class="status-title">
                                Training completed
                            </div>

                            <div class="status-description">
                                Congratulations! You have completed
                                your requirements, deployment, and
                                BS requirements.
                            </div>

                        </div>

                    @endif

                </div>



                {{-- =================================================
                     GPS STATUS
                ================================================== --}}

                @if(($deploymentStatus ?? '') === 'Ongoing')

                    <div class="gps-status">

                        <div class="gps-icon">
                            📍
                        </div>

                        <div class="gps-content">

                            <div class="gps-title">
                                Live Location Tracking Active
                            </div>

                            <div class="gps-text">
                                Your location is being monitored while
                                you are deployed for onboard training.
                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>



        {{-- =================================================
             RIGHT COLUMN
        ================================================== --}}

        <div class="dashboard-right">


            {{-- =================================================
                 CONCERN SUMMARY
            ================================================== --}}

            <div class="dashboard-box">

                <div class="dashboard-box-header">

                    <h3>
                        💬 Concern Summary
                    </h3>

                    <span>
                        Support
                    </span>

                </div>


                <div class="complaint-grid">


                    <div class="complaint-card open">

                        <div class="complaint-number">
                            {{ $openComplaints ?? 0 }}
                        </div>

                        <div class="complaint-label">
                            Open Concerns
                        </div>

                    </div>


                    <div class="complaint-card resolved">

                        <div class="complaint-number">
                            {{ $resolvedComplaints ?? 0 }}
                        </div>

                        <div class="complaint-label">
                            Resolved
                        </div>

                    </div>

                </div>


                <a
                    href="{{ route('cadet.complaints') }}"
                    class="dashboard-btn btn-blue"
                >
                    💬 View My Concerns
                </a>

            </div>



            {{-- =================================================
                 NOTIFICATIONS
            ================================================== --}}

            <div class="dashboard-box">

                <div class="dashboard-box-header">

                    <h3>

                        🔔 Notifications

                        @if(($unreadCount ?? 0) > 0)

                            <span class="notification-badge">
                                {{ $unreadCount }}
                            </span>

                        @endif

                    </h3>

                    <span>
                        Recent updates
                    </span>

                </div>


                <div class="notification-list">

                    @forelse($notifications ?? [] as $note)

                        <a
                            href="{{ route('notifications.open', $note->id) }}"
                            class="notification-link"
                        >

                            <div
                                class="
                                    notification-item
                                    {{
                                        $note->is_read
                                            ? 'notification-read'
                                            : 'notification-unread'
                                    }}
                                "
                            >

                                <div class="notification-title">
                                    {{ $note->title }}
                                </div>


                                <div class="notification-message">
                                    {{ $note->message }}
                                </div>


                                <div class="notification-time">

                                    {{ $note->created_at->diffForHumans() }}

                                </div>

                            </div>

                        </a>

                    @empty

                        <div class="empty-state">

                            <span class="empty-icon">
                                🔔
                            </span>

                            No notifications available.

                        </div>

                    @endforelse

                </div>


                {{-- MARK ALL AS READ --}}

                @if(($unreadCount ?? 0) > 0)

                    <form
                        method="POST"
                        action="{{ route('notifications.read') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="dashboard-btn btn-green"
                        >
                            ✓ Mark All as Read
                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>



<script>

/* =========================================================
   LIVE GPS TRACKING
========================================================= */

let watchId = null;


/**
 * Start live location tracking.
 */
function startTracking() {

    if (watchId !== null) {
        return;
    }


    if (!navigator.geolocation) {

        console.log(
            'Geolocation is not supported by this browser.'
        );

        return;
    }


    watchId = navigator.geolocation.watchPosition(

        function (position) {

            const latitude =
                position.coords.latitude;

            const longitude =
                position.coords.longitude;


            const csrfToken =
                document.querySelector(
                    'meta[name="csrf-token"]'
                );


            if (!csrfToken) {

                console.error(
                    'CSRF token not found.'
                );

                return;
            }


            fetch(
                "{{ route('cadet.update.location') }}",
                {

                    method: 'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken.content,

                        'Accept':
                            'application/json'

                    },

                    body: JSON.stringify({

                        latitude:
                            latitude,

                        longitude:
                            longitude

                    })

                }
            )

            .then(response => {

                if (!response.ok) {

                    throw new Error(
                        'Location update failed. HTTP status: '
                        + response.status
                    );

                }

                console.log(
                    'Location successfully updated.'
                );

            })

            .catch(error => {

                console.error(
                    'Location update failed:',
                    error
                );

            });

        },


        function (error) {

            console.log(
                'GPS Error:',
                error.message
            );

        },


        {

            enableHighAccuracy: true,

            maximumAge: 0,

            timeout: 10000

        }

    );


    console.log(
        'Live tracking started.'
    );

}



/* =========================================================
   CHECK LOCATION PERMISSION
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    async function () {

        /*
        |--------------------------------------------------------------------------
        | Only start GPS while deployment is Ongoing.
        |--------------------------------------------------------------------------
        */

        const deploymentStatus =
            @json($deploymentStatus ?? 'Not Deployed');


        if (deploymentStatus !== 'Ongoing') {

            console.log(
                'GPS tracking is disabled because deployment is not ongoing.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Browser does not support Permissions API.
        |--------------------------------------------------------------------------
        */

        if (!navigator.permissions) {

            console.log(
                'Permissions API is not supported.'
            );

            /*
            | Fall back to requesting location directly.
            */

            startTracking();

            return;
        }


        try {

            const permission =
                await navigator.permissions.query({

                    name: 'geolocation'

                });


            console.log(
                'Geolocation permission:',
                permission.state
            );


            /*
            |--------------------------------------------------------------------------
            | Permission already granted
            |--------------------------------------------------------------------------
            */

            if (
                permission.state ===
                'granted'
            ) {

                startTracking();

            }


            /*
            |--------------------------------------------------------------------------
            | Permission has not been decided
            |--------------------------------------------------------------------------
            */

            else if (
                permission.state ===
                'prompt'
            ) {

                console.log(
                    'Waiting for location permission.'
                );


                /*
                | Ask for location.
                | watchPosition itself triggers the browser
                | permission prompt.
                */

                startTracking();


                permission.onchange =
                    function () {

                        console.log(
                            'Permission changed:',
                            permission.state
                        );


                        if (
                            permission.state ===
                            'granted'
                        ) {

                            startTracking();

                        }

                    };

            }


            /*
            |--------------------------------------------------------------------------
            | Permission denied
            |--------------------------------------------------------------------------
            */

            else {

                console.log(
                    'Location permission was denied.'
                );

            }

        }

        catch (error) {

            console.error(
                'Unable to check geolocation permission:',
                error
            );

        }

    }
);

</script>

@endsection