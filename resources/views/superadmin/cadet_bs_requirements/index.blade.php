@extends('layouts.superadmin')

@section('header-title', 'Cadet BS Requirements')

@section('content')

<style>
/* =========================================================
   DARK NAVY / PURPLE-BLUE THEME
========================================================= */

.bs-page {
    --bs-bg: #07152f;
    --bs-bg-deep: #061126;

    --bs-card: #2d2a67;
    --bs-card-hover: #35327a;
    --bs-card-deep: #242252;

    --bs-border: #45438a;
    --bs-border-soft: #39376f;

    --bs-input: #081832;
    --bs-input-hover: #0b1d3d;

    --bs-text: #ffffff;
    --bs-text-light: #dbe5ff;
    --bs-text-muted: #aeb9d6;
    --bs-text-soft: #8f9bc0;

    --bs-blue: #4f8cff;
    --bs-blue-hover: #6a9eff;
    --bs-blue-dark: #315fc2;

    width: 100%;
    min-height: 100vh;
    padding: 28px;
    background: var(--bs-bg);
    color: var(--bs-text);
}

.bs-page *,
.bs-page *::before,
.bs-page *::after {
    box-sizing: border-box;
}

/* =========================================================
   HEADER
========================================================= */

.bs-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.bs-header-content h2 {
    display: flex;
    align-items: center;
    gap: 11px;
    margin: 0;
    color: var(--bs-text);
    font-size: 28px;
    font-weight: 800;
    line-height: 1.2;
}

.bs-header-content h2 i {
    color: var(--bs-blue);
    font-size: 25px;
}

.bs-header-content p {
    margin: 8px 0 0;
    color: var(--bs-text-muted);
    font-size: 14px;
    line-height: 1.5;
}

/* =========================================================
   STATISTICS
========================================================= */

.bs-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.bs-stat {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 0;
    min-height: 120px;
    padding: 20px;
    background: var(--bs-card);
    border: 1px solid var(--bs-border);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .20);
    transition:
        transform .2s ease,
        box-shadow .2s ease,
        border-color .2s ease;
}

.bs-stat:hover {
    transform: translateY(-3px);
    background: var(--bs-card-hover);
    border-color: #5754a3;
    box-shadow: 0 14px 35px rgba(0, 0, 0, .28);
}

.bs-stat-icon {
    flex: 0 0 58px;
    width: 58px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    color: #fff;
    font-size: 22px;
    box-shadow: 0 7px 18px rgba(0, 0, 0, .25);
}

/* Keep the different statistic identities,
   but make them fit the dark theme. */

.bs-stat-blue .bs-stat-icon {
    background: linear-gradient(135deg, #315fc2, #4f8cff);
}

.bs-stat-green .bs-stat-icon {
    background: linear-gradient(135deg, #15803d, #22c55e);
}

.bs-stat-orange .bs-stat-icon {
    background: linear-gradient(135deg, #b45309, #f59e0b);
}

.bs-stat-purple .bs-stat-icon {
    background: linear-gradient(135deg, #6d28d9, #8b5cf6);
}

.bs-stat-content {
    min-width: 0;
}

.bs-stat-label {
    margin: 0;
    color: var(--bs-text-muted);
    font-size: 13px;
    font-weight: 700;
    line-height: 1.4;
}

.bs-stat-value {
    margin: 6px 0 0;
    color: var(--bs-text);
    font-size: 30px;
    font-weight: 800;
    line-height: 1;
}

/* =========================================================
   FILTER CARD
========================================================= */

.bs-filter-card {
    margin-bottom: 20px;
    padding: 20px;
    background: var(--bs-bg-deep);
    border: 1px solid var(--bs-border);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .20);
}

.bs-filter-title {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 18px;
}

.bs-filter-title i {
    color: var(--bs-blue);
    font-size: 15px;
}

.bs-filter-title h3 {
    margin: 0;
    color: var(--bs-text);
    font-size: 17px;
    font-weight: 800;
}

.bs-filter-row {
    display: grid;
    grid-template-columns:
        minmax(220px, 1.4fr)
        minmax(180px, 1fr)
        minmax(180px, 1fr)
        auto;
    gap: 14px;
    align-items: end;
}

.bs-filter-group {
    min-width: 0;
}

.bs-filter-group label {
    display: block;
    margin-bottom: 7px;
    color: var(--bs-text-muted);
    font-size: 12px;
    font-weight: 700;
}

.bs-filter-control {
    width: 100%;
    height: 44px;
    padding: 0 13px;
    background: var(--bs-input);
    border: 1px solid var(--bs-border-soft);
    border-radius: 9px;
    color: var(--bs-text);
    font-size: 14px;
    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.bs-filter-control:hover {
    background: var(--bs-input-hover);
    border-color: var(--bs-border);
}

.bs-filter-control:focus {
    outline: none;
    background: var(--bs-input);
    border-color: var(--bs-blue);
    box-shadow: 0 0 0 3px rgba(79, 140, 255, .15);
}

.bs-filter-control::placeholder {
    color: #7180a5;
}

/* Select dropdown */

.bs-filter-control option {
    background: #081832;
    color: #ffffff;
}

.bs-filter-actions {
    display: flex;
    gap: 8px;
}

/* =========================================================
   BUTTONS
========================================================= */

.bs-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 44px;
    padding: 0 16px;
    border: 0;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition:
        background .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.bs-btn-primary {
    background: var(--bs-blue);
    color: #fff;
}

.bs-btn-primary:hover {
    background: var(--bs-blue-hover);
    color: #fff;
    transform: translateY(-1px);
}

.bs-btn-reset {
    background: #1b2850;
    border: 1px solid var(--bs-border);
    color: var(--bs-text-light);
}

.bs-btn-reset:hover {
    background: #273565;
    border-color: #5754a3;
    color: #fff;
    transform: translateY(-1px);
}

/* =========================================================
   TABLE CARD
========================================================= */

.bs-table-card {
    width: 100%;
    overflow: hidden;
    background: var(--bs-card);
    border: 1px solid var(--bs-border);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, .22);
}

.bs-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

/* Custom scrollbar */

.bs-table-wrapper::-webkit-scrollbar,
.bs-modal-body::-webkit-scrollbar,
.bs-modal-table-wrapper::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.bs-table-wrapper::-webkit-scrollbar-track,
.bs-modal-body::-webkit-scrollbar-track,
.bs-modal-table-wrapper::-webkit-scrollbar-track {
    background: #171945;
}

.bs-table-wrapper::-webkit-scrollbar-thumb,
.bs-modal-body::-webkit-scrollbar-thumb,
.bs-modal-table-wrapper::-webkit-scrollbar-thumb {
    background: #45438a;
    border-radius: 999px;
}

.bs-table-wrapper::-webkit-scrollbar-thumb:hover,
.bs-modal-body::-webkit-scrollbar-thumb:hover,
.bs-modal-table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #5a57a5;
}

.bs-table {
    width: 100%;
    min-width: 950px;
    border-collapse: collapse;
}

.bs-table thead {
    background: #191847;
    color: #fff;
}

.bs-table th {
    padding: 15px 14px;
    border-bottom: 1px solid var(--bs-border);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .45px;
    text-align: center;
    text-transform: uppercase;
    white-space: nowrap;
}

.bs-table th i {
    margin-right: 5px;
    color: #91b8ff;
}

.bs-table td {
    padding: 15px 14px;
    border-bottom: 1px solid var(--bs-border-soft);
    color: var(--bs-text-light);
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
}

.bs-table td strong {
    color: #ffffff;
    font-weight: 750;
}

.bs-table tbody tr {
    background: var(--bs-card);
    transition:
        background .2s ease,
        box-shadow .2s ease;
}

.bs-table tbody tr:hover {
    background: var(--bs-card-hover);
}

.bs-table tbody tr:last-child td {
    border-bottom: 0;
}

/* =========================================================
   EMPTY STATE
========================================================= */

.bs-empty {
    padding: 55px 20px !important;
    background: var(--bs-card) !important;
    color: var(--bs-text-muted) !important;
}

.bs-empty i {
    display: block;
    margin-bottom: 12px;
    color: #7379b5;
    font-size: 36px;
}

.bs-empty strong {
    display: block;
    margin-bottom: 4px;
    color: #ffffff;
    font-size: 15px;
}

.bs-empty span {
    color: var(--bs-text-soft);
    font-size: 13px;
}

/* =========================================================
   PROGRESS
========================================================= */

.bs-progress {
    width: 190px;
    margin: 0 auto;
}

.bs-progress-track {
    width: 100%;
    height: 9px;
    overflow: hidden;
    background: #171b43;
    border: 1px solid #38376f;
    border-radius: 999px;
}

.bs-progress-fill {
    height: 100%;
    min-width: 0;
    background: linear-gradient(90deg, #3e76e8, #6ea3ff);
    border-radius: 999px;
    transition: width .3s ease;
    box-shadow: 0 0 8px rgba(79, 140, 255, .35);
}

.bs-progress-text {
    display: block;
    margin-top: 7px;
    color: var(--bs-text-muted);
    font-size: 11px;
    font-weight: 700;
}

/* =========================================================
   BADGES
========================================================= */

.bs-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 6px 11px;
    border: 1px solid transparent;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    line-height: 1;
    white-space: nowrap;
}

.bs-badge-approved {
    background: rgba(34, 197, 94, .13);
    border-color: rgba(34, 197, 94, .25);
    color: #6ee7a0;
}

.bs-badge-pending {
    background: rgba(245, 158, 11, .13);
    border-color: rgba(245, 158, 11, .25);
    color: #fcd36d;
}

.bs-badge-rejected {
    background: rgba(239, 68, 68, .13);
    border-color: rgba(239, 68, 68, .25);
    color: #ff8f8f;
}

.bs-badge-info {
    background: rgba(79, 140, 255, .13);
    border-color: rgba(79, 140, 255, .28);
    color: #9fc1ff;
}

.bs-badge-legacy {
    background: rgba(34, 197, 94, .13);
    border-color: rgba(34, 197, 94, .25);
    color: #6ee7a0;
}

/* =========================================================
   VIEW BUTTON
========================================================= */

.bs-view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 38px;
    padding: 0 13px;
    border: 1px solid rgba(79, 140, 255, .35);
    border-radius: 8px;
    background: #315fc2;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition:
        background .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.bs-view-btn:hover {
    background: #4075df;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(49, 95, 194, .30);
}

/* =========================================================
   HIDDEN MODAL DATA
========================================================= */

.bs-hidden-data {
    display: none;
}

/* =========================================================
   MODAL BACKDROP
========================================================= */

.bs-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(2, 8, 23, .82);
    backdrop-filter: blur(6px);
}

.bs-modal.is-open {
    display: flex;
}

/* =========================================================
   MODAL CONTENT
========================================================= */

.bs-modal-content {
    width: min(1100px, 100%);
    max-height: 90vh;
    overflow: hidden;
    background: var(--bs-card);
    border: 1px solid var(--bs-border);
    border-radius: 15px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, .55);
    animation: bsModalIn .2s ease;
}

@keyframes bsModalIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* =========================================================
   MODAL HEADER
========================================================= */

.bs-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 17px 22px;
    background: #191847;
    border-bottom: 1px solid var(--bs-border);
    color: #fff;
}

.bs-modal-title {
    min-width: 0;
}

.bs-modal-title h3 {
    overflow: hidden;
    margin: 0;
    color: #fff;
    font-size: 20px;
    font-weight: 800;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.bs-modal-close {
    flex: 0 0 auto;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255,255,255,.10);
    border-radius: 9px;
    background: rgba(255,255,255,.06);
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    transition: .2s ease;
}

.bs-modal-close:hover {
    background: #dc2626;
    border-color: #ef4444;
}

/* =========================================================
   MODAL BODY
========================================================= */

.bs-modal-body {
    max-height: calc(90vh - 75px);
    overflow: auto;
    padding: 22px;
    background: var(--bs-card);
}

/* =========================================================
   MODAL SUMMARY
========================================================= */

.bs-summary {
    width: 100%;
}

.bs-summary-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--bs-border);
}

.bs-summary-name h4 {
    margin: 0 0 5px;
    color: #ffffff;
    font-size: 21px;
    font-weight: 800;
}

.bs-summary-name small {
    color: var(--bs-text-muted);
    font-size: 13px;
    font-weight: 600;
}

/* =========================================================
   ATTACHMENT
========================================================= */

.bs-attachment {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 250px;
    padding: 9px 11px;
    background: #171945;
    border: 1px solid var(--bs-border-soft);
    border-radius: 10px;
}

.bs-attachment-icon {
    flex: 0 0 40px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    background: rgba(239, 68, 68, .14);
    border: 1px solid rgba(239, 68, 68, .20);
    color: #ff8f8f;
    font-size: 18px;
}

.bs-attachment-info {
    min-width: 0;
    flex: 1;
    text-align: left;
}

.bs-attachment-name {
    display: block;
    overflow: hidden;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.bs-attachment-info small {
    color: var(--bs-text-soft);
    font-size: 11px;
}

.bs-attachment-actions {
    display: flex;
    gap: 6px;
}

.bs-file-btn {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #fff;
    text-decoration: none;
    transition: .2s ease;
}

.bs-file-view {
    background: #315fc2;
}

.bs-file-view:hover {
    background: #4075df;
    color: #fff;
}

.bs-file-download {
    background: #15803d;
}

.bs-file-download:hover {
    background: #16a34a;
    color: #fff;
}

.bs-no-file {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--bs-text-soft);
    font-size: 13px;
    font-weight: 700;
}

/* =========================================================
   MODAL TABLE
========================================================= */

.bs-modal-table-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid var(--bs-border);
    border-radius: 12px;
    background: #29265e;
}

.bs-modal-table {
    width: 100%;
    min-width: 850px;
    border-collapse: collapse;
}

.bs-modal-table th {
    padding: 12px;
    background: #191847;
    border-bottom: 1px solid var(--bs-border);
    color: var(--bs-text-muted);
    font-size: 11px;
    font-weight: 800;
    text-align: center;
    text-transform: uppercase;
    white-space: nowrap;
}

.bs-modal-table td {
    padding: 13px 12px;
    border-bottom: 1px solid var(--bs-border-soft);
    color: var(--bs-text-light);
    font-size: 13px;
    text-align: center;
    vertical-align: middle;
}

.bs-modal-table td strong {
    color: #ffffff;
}

.bs-modal-table tbody tr {
    background: #2d2a67;
    transition: background .2s ease;
}

.bs-modal-table tbody tr:hover {
    background: #35327a;
}

.bs-modal-table tbody tr:last-child td {
    border-bottom: 0;
}

.bs-remarks {
    max-width: 220px;
    margin: 0 auto;
    overflow-wrap: anywhere;
    color: var(--bs-text-muted);
}

/* =========================================================
   MODAL EMPTY
========================================================= */

.bs-modal-empty {
    padding: 45px 20px !important;
    background: #2d2a67 !important;
    color: var(--bs-text-muted) !important;
}

.bs-modal-empty i {
    display: block;
    margin-bottom: 10px;
    color: #7379b5;
    font-size: 32px;
}

.bs-modal-empty div {
    color: #ffffff;
}

.bs-legacy {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
    padding: 6px 11px;
    border-radius: 999px;
    background: rgba(34, 197, 94, .13);
    border: 1px solid rgba(34, 197, 94, .25);
    color: #6ee7a0;
    font-size: 11px;
    font-weight: 800;
}

/* =========================================================
   MOBILE / TABLET
========================================================= */

@media (max-width: 1100px) {

    .bs-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .bs-filter-row {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .bs-filter-actions {
        grid-column: 1 / -1;
    }
}

@media (max-width: 700px) {

    .bs-page {
        padding: 15px;
    }

    .bs-header-content h2 {
        font-size: 22px;
    }

    .bs-header-content p {
        font-size: 13px;
    }

    .bs-stats {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .bs-stat {
        min-height: 100px;
        padding: 17px;
    }

    .bs-stat-icon {
        flex-basis: 52px;
        width: 52px;
        height: 52px;
        font-size: 20px;
    }

    .bs-stat-value {
        font-size: 26px;
    }

    .bs-filter-card {
        padding: 16px;
    }

    .bs-filter-row {
        grid-template-columns: 1fr;
    }

    .bs-filter-actions {
        grid-column: auto;
        width: 100%;
    }

    .bs-filter-actions .bs-btn {
        width: 100%;
    }

    .bs-modal {
        padding: 10px;
    }

    .bs-modal-content {
        max-height: 95vh;
        border-radius: 13px;
    }

    .bs-modal-header {
        padding: 14px 16px;
    }

    .bs-modal-title h3 {
        font-size: 17px;
    }

    .bs-modal-body {
        max-height: calc(95vh - 68px);
        padding: 15px;
    }

    .bs-summary-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 12px;
    }

    .bs-attachment {
        width: 100%;
        min-width: 0;
    }

    .bs-progress {
        width: 150px;
    }
}

/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 450px) {

    .bs-page {
        padding: 12px;
    }

    .bs-header-content h2 {
        font-size: 20px;
    }

    .bs-stat {
        padding: 15px;
    }

    .bs-stat-icon {
        flex-basis: 48px;
        width: 48px;
        height: 48px;
        font-size: 18px;
    }

    .bs-stat-value {
        font-size: 24px;
    }

    .bs-table th,
    .bs-table td {
        padding: 12px 10px;
    }

    .bs-modal-body {
        padding: 12px;
    }
}
</style>


<div class="bs-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="bs-header">

        <div class="bs-header-content">

            <h2>
                <i class="fa-solid fa-graduation-cap"></i>
                Cadet BS Requirements
            </h2>

            <p>
                View BS completion requirements submitted by completed cadets.
            </p>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    @php

        $totalCadets = $cadets->count();

        $submittedRequirements = $cadets->sum(
            fn ($cadet) => $cadet->bsRequirements->count()
        );

        $pendingCadets = $cadets->filter(
            fn ($cadet) =>
                $cadet->bsRequirements->count() < $totalRequirements
        )->count();

        $completedCadets = $cadets->filter(
            fn ($cadet) =>
                $cadet->bsRequirements->count() >= $totalRequirements
        )->count();

    @endphp


    <div class="bs-stats">

        {{-- TOTAL --}}

        <div class="bs-stat bs-stat-blue">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Total Cadets
                </p>

                <h3 class="bs-stat-value">
                    {{ $totalCadets }}
                </h3>

            </div>

        </div>


        {{-- SUBMITTED --}}

        <div class="bs-stat bs-stat-green">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Requirements Submitted
                </p>

                <h3 class="bs-stat-value">
                    {{ $submittedRequirements }}
                </h3>

            </div>

        </div>


        {{-- PENDING --}}

        <div class="bs-stat bs-stat-orange">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Pending Cadets
                </p>

                <h3 class="bs-stat-value">
                    {{ $pendingCadets }}
                </h3>

            </div>

        </div>


        {{-- COMPLETED --}}

        <div class="bs-stat bs-stat-purple">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Completed
                </p>

                <h3 class="bs-stat-value">
                    {{ $completedCadets }}
                </h3>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <div class="bs-filter-card">

        <div class="bs-filter-title">

            <i class="fa-solid fa-filter"></i>

            <h3>
                Filter Cadets
            </h3>

        </div>


        <form
            method="GET"
            action="{{ route('superadmin.cadet-bs-requirements.index') }}"
            id="filterForm"
        >

            <div class="bs-filter-row">

                {{-- SEARCH --}}

                <div class="bs-filter-group">

                    <label for="bs-search">
                        Search Cadet
                    </label>

                    <input
                        id="bs-search"
                        type="text"
                        name="search"
                        class="bs-filter-control"
                        placeholder="Search name or TRB number..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >

                </div>


                {{-- COURSE --}}

                <div class="bs-filter-group">

                    <label for="bs-course">
                        Course
                    </label>

                    <select
                        id="bs-course"
                        name="course"
                        class="bs-filter-control"
                    >

                        <option value="">
                            All Courses
                        </option>

                        @foreach($courses as $course)

                            <option
                                value="{{ $course }}"
                                @selected(request('course') == $course)
                            >
                                {{ $course }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BATCH --}}

                <div class="bs-filter-group">

                    <label for="bs-batch">
                        Batch
                    </label>

                    <select
                        id="bs-batch"
                        name="batch"
                        class="bs-filter-control"
                    >

                        <option value="">
                            All Batches
                        </option>

                        @foreach($batches as $batch)

                            <option
                                value="{{ $batch->id }}"
                                @selected(request('batch') == $batch->id)
                            >
                                {{ $batch->batch_year }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- RESET --}}

                <div class="bs-filter-actions">

                    <a
                        href="{{ route('superadmin.cadet-bs-requirements.index') }}"
                        class="bs-btn bs-btn-reset"
                    >

                        <i class="fa-solid fa-rotate-right"></i>

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
         MAIN TABLE
    ====================================================== --}}

    <div class="bs-table-card">

        <div class="bs-table-wrapper">

            <table class="bs-table">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            <i class="fa-solid fa-id-card"></i>
                            TRB
                        </th>

                        <th>
                            <i class="fa-solid fa-user"></i>
                            Cadet
                        </th>

                        <th>
                            <i class="fa-solid fa-book"></i>
                            Course
                        </th>

                        <th>
                            <i class="fa-solid fa-layer-group"></i>
                            Batch
                        </th>

                        <th>
                            <i class="fa-solid fa-chart-line"></i>
                            Progress
                        </th>

                        <th>
                            <i class="fa-solid fa-eye"></i>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($cadets as $cadet)

                        @php

                            $submitted = $cadet->bsRequirements->count();

                            $percentage = $totalRequirements > 0
                                ? min(
                                    100,
                                    round(
                                        ($submitted / $totalRequirements) * 100
                                    )
                                )
                                : 0;

                        @endphp


                        <tr>

                            {{-- NUMBER --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- TRB --}}

                            <td>

                                <strong>
                                    {{ $cadet->trb_control_number }}
                                </strong>

                            </td>


                            {{-- NAME --}}

                            <td>
                                {{ $cadet->full_name }}
                            </td>


                            {{-- COURSE --}}

                            <td>
                                {{ $cadet->course ?: '—' }}
                            </td>


                            {{-- BATCH --}}

                            <td>
                                {{ optional($cadet->batch)->batch_year ?? 'No Batch' }}
                            </td>


                            {{-- PROGRESS --}}

                            <td>

                                <div class="bs-progress">

                                    <div class="bs-progress-track">

                                        <div
                                            class="bs-progress-fill"
                                            style="width: {{ $percentage }}%;"
                                        ></div>

                                    </div>

                                    <span class="bs-progress-text">

                                        {{ $submitted }}

                                        /

                                        {{ $totalRequirements }}

                                        Requirements

                                        ({{ $percentage }}%)

                                    </span>

                                </div>

                            </td>


                            {{-- ACTION --}}

                            <td>

                                <button
                                    type="button"
                                    class="bs-view-btn"
                                    onclick="openBsModal(
                                        {{ $cadet->id }},
                                        @js($cadet->full_name)
                                    )"
                                >

                                    <i class="fa-solid fa-eye"></i>

                                    View

                                </button>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="bs-empty"
                            >

                                <i class="fa-solid fa-folder-open"></i>

                                <strong>
                                    No completed cadets found.
                                </strong>

                                <span>
                                    Try changing your search or filters.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     HIDDEN CADET REQUIREMENT DATA
========================================================= --}}

@foreach($cadets as $cadet)

    <div
        id="bs-cadet-{{ $cadet->id }}"
        class="bs-hidden-data"
    >

        <div class="bs-summary">

            {{-- SUMMARY HEADER --}}

            <div class="bs-summary-header">

                <div class="bs-summary-name">

                    <h4>
                        {{ $cadet->full_name }}
                    </h4>

                    <small>
                        TRB:
                        {{ $cadet->trb_control_number }}
                    </small>

                </div>


                <span class="bs-badge bs-badge-info">

                    <i class="fa-solid fa-file-circle-check"></i>

                    {{ $cadet->bsRequirements->count() }}

                    /

                    {{ $totalRequirements }}

                    Submitted

                </span>

            </div>


            {{-- REQUIREMENT TABLE --}}

            <div class="bs-modal-table-wrapper">

                <table class="bs-modal-table">

                    <thead>

                        <tr>

                            <th>
                                Requirement
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Attachment
                            </th>

                            <th>
                                Remarks
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Access
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($cadet->bsRequirements as $submission)

                            @php

                                $status = strtolower(
                                    trim((string) $submission->status)
                                );

                            @endphp


                            <tr>

                                {{-- REQUIREMENT --}}

                                <td>

                                    <strong>
                                        {{ $submission->requirement->title ?? 'Unknown Requirement' }}
                                    </strong>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @switch($status)

                                        @case('approved')

                                            <span class="bs-badge bs-badge-approved">

                                                <i class="fa-solid fa-circle-check"></i>

                                                Approved

                                            </span>

                                            @break


                                        @case('rejected')

                                            <span class="bs-badge bs-badge-rejected">

                                                <i class="fa-solid fa-circle-xmark"></i>

                                                Rejected

                                            </span>

                                            @break


                                        @case('pending')

                                            <span class="bs-badge bs-badge-pending">

                                                <i class="fa-solid fa-clock"></i>

                                                Pending

                                            </span>

                                            @break


                                        @default

                                            <span class="bs-badge bs-badge-info">

                                                <i class="fa-solid fa-circle-question"></i>

                                                {{ $submission->status ?: 'Unknown' }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- ATTACHMENT --}}

                                <td>

                                    @if($submission->attachment)

                                        @php

                                            $fileUrl = asset(
                                                'storage/' . $submission->attachment
                                            );

                                        @endphp


                                        <div class="bs-attachment">

                                            <div class="bs-attachment-icon">

                                                <i class="fa-solid fa-file-pdf"></i>

                                            </div>


                                            <div class="bs-attachment-info">

                                                <span class="bs-attachment-name">
                                                    Uploaded Document
                                                </span>

                                                <small>
                                                    Available for viewing
                                                </small>

                                            </div>


                                            <div class="bs-attachment-actions">

                                                <a
                                                    href="{{ $fileUrl }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="bs-file-btn bs-file-view"
                                                    title="View document"
                                                >

                                                    <i class="fa-solid fa-eye"></i>

                                                </a>


                                                <a
                                                    href="{{ $fileUrl }}"
                                                    download
                                                    class="bs-file-btn bs-file-download"
                                                    title="Download document"
                                                >

                                                    <i class="fa-solid fa-download"></i>

                                                </a>

                                            </div>

                                        </div>

                                    @else

                                        <span class="bs-no-file">

                                            <i class="fa-regular fa-file-circle-xmark"></i>

                                            No Attachment

                                        </span>

                                    @endif

                                </td>


                                {{-- REMARKS --}}

                                <td>

                                    <div class="bs-remarks">

                                        {{ $submission->remarks ?: '—' }}

                                    </div>

                                </td>


                                {{-- DATE --}}

                                <td>

                                    @if($submission->submitted_at)

                                        {{ \Carbon\Carbon::parse(
                                            $submission->submitted_at
                                        )->format('M d, Y') }}

                                    @else

                                        —

                                    @endif

                                </td>


                                {{-- ACCESS --}}

                                <td>

                                    <span class="bs-badge bs-badge-info">

                                        <i class="fa-solid fa-eye"></i>

                                        View Only

                                    </span>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="bs-modal-empty"
                                >

                                    <i class="fa-regular fa-folder-open"></i>

                                    <div>
                                        No requirement submitted yet.
                                    </div>


                                    @if($cadet->bs_status === 'Legacy Qualified')

                                        <span class="bs-legacy">

                                            <i class="fa-solid fa-circle-check"></i>

                                            BS Qualified (Legacy)

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endforeach


{{-- =========================================================
     MODAL
========================================================= --}}

<div
    id="bsModal"
    class="bs-modal"
    aria-hidden="true"
>

    <div
        class="bs-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="bsModalTitle"
    >

        <div class="bs-modal-header">

            <div class="bs-modal-title">

                <h3 id="bsModalTitle">
                    Cadet Requirements
                </h3>

            </div>


            <button
                type="button"
                class="bs-modal-close"
                onclick="closeBsModal()"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        <div
            id="bsModalBody"
            class="bs-modal-body"
        ></div>

    </div>

</div>


<script>
/* =========================================================
   BS REQUIREMENTS MODAL
========================================================= */

(function () {

    'use strict';

    const modal = document.getElementById('bsModal');
    const modalBody = document.getElementById('bsModalBody');
    const modalTitle = document.getElementById('bsModalTitle');


    window.openBsModal = function (id, name) {

        const source = document.getElementById(
            'bs-cadet-' + id
        );


        if (!source) {

            console.error(
                'BS requirement data not found for cadet:',
                id
            );

            return;
        }


        modalTitle.textContent =
            name || 'Cadet Requirements';


        modalBody.innerHTML =
            source.innerHTML;


        modal.classList.add('is-open');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.style.overflow = 'hidden';

    };


    window.closeBsModal = function () {

        modal.classList.remove('is-open');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        modalBody.innerHTML = '';

        document.body.style.overflow = '';

    };


    /* Close when clicking backdrop */

    modal.addEventListener(
        'click',
        function (event) {

            if (event.target === modal) {

                closeBsModal();

            }

        }
    );


    /* Close with ESC */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal.classList.contains('is-open')
            ) {

                closeBsModal();

            }

        }
    );

})();


/* =========================================================
   AUTO FILTER
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById('filterForm');


        if (!form) {
            return;
        }


        const searchInput =
            form.querySelector(
                'input[name="search"]'
            );


        const selects =
            form.querySelectorAll(
                'select[name="course"], select[name="batch"]'
            );


        let searchTimer = null;


        /*
         * Search after user stops typing.
         */

        if (searchInput) {

            searchInput.addEventListener(
                'input',
                function () {

                    clearTimeout(searchTimer);


                    searchTimer = setTimeout(
                        function () {

                            form.submit();

                        },
                        500
                    );

                }
            );

        }


        /*
         * Submit immediately when
         * course/batch changes.
         */

        selects.forEach(
            function (select) {

                select.addEventListener(
                    'change',
                    function () {

                        form.submit();

                    }
                );

            }
        );

    }
);
</script>

@endsection