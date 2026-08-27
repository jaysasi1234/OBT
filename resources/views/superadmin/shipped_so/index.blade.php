@extends('layouts.superadmin')

@section('header-title', 'Special Order')

@section('content')

<style>
/* =========================================================
   SPECIAL ORDER PAGE
   DARK NAVY + PURPLE-BLUE THEME
========================================================= */

.shipped-page {
    width: 100%;
    min-height: 100vh;
    padding: 28px;
    background: #07152f;
    color: #ffffff;
}

.shipped-page *,
.shipped-page *::before,
.shipped-page *::after {
    box-sizing: border-box;
}

/* =========================================================
   PAGE HEADER
========================================================= */

.shipped-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 24px;
    padding: 22px 25px;
    background: #2d2a67;
    border: 1px solid #403d80;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.20);
}

.shipped-header-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 50px;
    border-radius: 14px;
    background: rgba(92, 104, 214, 0.20);
    color: #9ca9ff;
    font-size: 21px;
}

.shipped-header-content {
    min-width: 0;
}

.shipped-header h2 {
    margin: 0;
    color: #ffffff;
    font-size: 25px;
    font-weight: 800;
    line-height: 1.2;
}

.shipped-header p {
    margin: 5px 0 0;
    color: #b9b9d6;
    font-size: 13px;
    font-weight: 500;
}

/* =========================================================
   STATISTICS
========================================================= */

.shipped-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.shipped-stat {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    min-width: 0;
    padding: 21px;
    overflow: hidden;

    background: #2d2a67;
    border: 1px solid #403d80;
    border-top: 4px solid #6573e8;
    border-radius: 17px;

    box-shadow: 0 7px 22px rgba(0, 0, 0, 0.20);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.shipped-stat::after {
    content: "";
    position: absolute;
    width: 90px;
    height: 90px;
    right: -35px;
    bottom: -40px;
    border-radius: 50%;
    background: rgba(120, 130, 255, 0.08);
    pointer-events: none;
}

.shipped-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 13px 30px rgba(0, 0, 0, 0.28);
}

.shipped-stat-content {
    min-width: 0;
    position: relative;
    z-index: 1;
}

.shipped-stat-value {
    margin: 0;
    color: #ffffff;
    font-size: 30px;
    font-weight: 800;
    line-height: 1;
}

.shipped-stat-label {
    margin: 8px 0 0;
    color: #b9b9d6;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.15px;
}

.shipped-stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 56px;
    position: relative;
    z-index: 1;

    border-radius: 15px;
    color: #ffffff;
    font-size: 22px;

    box-shadow: 0 7px 15px rgba(0, 0, 0, 0.20);
}

/* BLUE */

.shipped-stat-blue {
    border-top-color: #6573e8;
}

.shipped-stat-blue .shipped-stat-icon {
    background: linear-gradient(135deg, #5865d8, #414cb5);
}

/* GRAY */

.shipped-stat-gray {
    border-top-color: #7782a8;
}

.shipped-stat-gray .shipped-stat-icon {
    background: linear-gradient(135deg, #697492, #4d5876);
}

/* ORANGE */

.shipped-stat-orange {
    border-top-color: #f59e0b;
}

.shipped-stat-orange .shipped-stat-icon {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

/* GREEN */

.shipped-stat-green {
    border-top-color: #22c55e;
}

.shipped-stat-green .shipped-stat-icon {
    background: linear-gradient(135deg, #22c55e, #15803d);
}

/* =========================================================
   FILTER CARD
========================================================= */

.shipped-filter-card {
    margin-bottom: 24px;
    padding: 20px;

    background: #07152f;
    border: 1px solid #383b73;
    border-radius: 17px;

    box-shadow: 0 7px 22px rgba(0, 0, 0, 0.20);
}

.shipped-filter-header {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 15px;

    color: #ffffff;
    font-size: 14px;
    font-weight: 800;
}

.shipped-filter-header i {
    color: #8995ff;
    font-size: 14px;
}

.shipped-filter-grid {
    display: grid;
    grid-template-columns:
        minmax(180px, 1fr)
        minmax(180px, 1fr)
        minmax(240px, 1.5fr);

    gap: 14px;
}

/* =========================================================
   FILTER CONTROLS
========================================================= */

.shipped-filter-control {
    width: 100%;
    height: 44px;
    padding: 0 13px;

    border: 1px solid #393d76;
    border-radius: 10px;

    outline: none;

    background: #0b1d3a;
    color: #ffffff;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}

.shipped-filter-control:hover {
    border-color: #55599a;
    background: #0d2142;
}

.shipped-filter-control:focus {
    border-color: #6875e8;
    background: #0d2142;
    box-shadow: 0 0 0 3px rgba(104, 117, 232, 0.15);
}

.shipped-filter-control::placeholder {
    color: #777da8;
    font-weight: 500;
}

/* SELECT OPTION */

.shipped-filter-control option {
    background: #0b1d3a;
    color: #ffffff;
}

/* =========================================================
   SEARCH
========================================================= */

.shipped-search {
    position: relative;
}

.shipped-search i {
    position: absolute;
    top: 50%;
    left: 14px;
    z-index: 1;

    color: #777da8;
    font-size: 13px;

    transform: translateY(-50%);
    pointer-events: none;
}

.shipped-search input {
    padding-left: 39px;
}

/* =========================================================
   TABLE CARD
========================================================= */

.shipped-table-card {
    width: 100%;
    overflow: hidden;

    background: #2d2a67;
    border: 1px solid #403d80;
    border-radius: 18px;

    box-shadow: 0 9px 27px rgba(0, 0, 0, 0.25);
}

/* =========================================================
   TABLE TOP
========================================================= */

.shipped-table-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    padding: 17px 20px;

    border-bottom: 1px solid #403d80;
    background: #2d2a67;
}

.shipped-table-title {
    display: flex;
    align-items: center;
    gap: 10px;

    color: #ffffff;
    font-size: 14px;
    font-weight: 800;
}

.shipped-table-title i {
    color: #9ca9ff;
}

.shipped-table-count {
    padding: 5px 10px;

    border: 1px solid #474582;
    border-radius: 999px;

    background: #242354;
    color: #aeb7ff;

    font-size: 11px;
    font-weight: 800;
}

/* =========================================================
   TABLE WRAPPER
========================================================= */

.shipped-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.shipped-table-wrapper::-webkit-scrollbar {
    height: 7px;
}

.shipped-table-wrapper::-webkit-scrollbar-track {
    background: #171b3e;
}

.shipped-table-wrapper::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background: #4c4b88;
}

/* =========================================================
   TABLE
========================================================= */

.shipped-table {
    width: 100%;
    min-width: 1000px;
    border-collapse: collapse;
}

/* =========================================================
   TABLE HEADER
========================================================= */

.shipped-table thead {
    background: linear-gradient(
        135deg,
        #232052,
        #373477
    );
}

.shipped-table th {
    padding: 15px 14px;

    color: #ffffff;
    border: 0;

    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.45px;

    text-align: center;
    text-transform: uppercase;
    white-space: nowrap;
}

.shipped-table th:first-child {
    text-align: left;
    padding-left: 20px;
}

/* =========================================================
   TABLE BODY
========================================================= */

.shipped-table td {
    padding: 15px 14px;

    border-bottom: 1px solid #403d80;

    color: #d8d9ed;

    font-size: 13px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}

.shipped-table td:first-child {
    padding-left: 20px;
    text-align: left;
}

.shipped-table tbody tr {
    background: #2d2a67;
    transition: background 0.2s ease;
}

.shipped-table tbody tr:hover {
    background: #353276;
}

.shipped-table tbody tr:last-child td {
    border-bottom: 0;
}

.shipped-cadet-name {
    color: #ffffff;
    font-size: 13px;
    font-weight: 800;
}

.shipped-date {
    color: #c5c8df;
    font-weight: 600;
}

.shipped-muted {
    color: #8589aa;
    font-weight: 600;
}

/* =========================================================
   SO NUMBER
========================================================= */

.shipped-table td strong {
    color: #ffffff;
}

/* =========================================================
   STATUS BADGES
========================================================= */

.shipped-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;

    min-width: 125px;
    padding: 7px 12px;

    border-radius: 999px;

    color: #ffffff;

    font-size: 10px;
    font-weight: 800;
    line-height: 1;
    white-space: nowrap;

    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.18);
}

.shipped-status i {
    font-size: 10px;
}

.shipped-status-pending {
    background: #59627d;
}

.shipped-status-deliberation {
    background: #d97706;
}

.shipped-status-endorsement {
    background: #4f63d8;
}

.shipped-status-shipped {
    background: #7c3aed;
}

.shipped-status-completed {
    background: #16a34a;
}

/* =========================================================
   VIEW BUTTON
========================================================= */

.shipped-view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 36px;
    padding: 0 14px;

    border: 1px solid #5962c5;
    border-radius: 9px;

    background: #4b54c6;
    color: #ffffff;

    font-family: inherit;
    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);

    transition:
        background 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.shipped-view-btn:hover {
    background: #5b65dc;
    color: #ffffff;

    transform: translateY(-1px);

    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
}

.shipped-view-btn:active {
    transform: translateY(0);
}

/* =========================================================
   EMPTY STATE
========================================================= */

.shipped-empty {
    padding: 55px 20px !important;

    color: #aeb1cc !important;

    white-space: normal !important;
    text-align: center !important;

    background: #2d2a67 !important;
}

.shipped-empty-icon {
    width: 62px;
    height: 62px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin: 0 auto 13px;

    border: 1px solid #45437e;
    border-radius: 16px;

    background: #242354;
    color: #858bd0;

    font-size: 26px;
}

.shipped-empty strong {
    display: block;

    margin-bottom: 5px;

    color: #ffffff;

    font-size: 14px;
    font-weight: 800;
}

.shipped-empty span {
    color: #999dbd;
    font-size: 12px;
    font-weight: 500;
}

/* =========================================================
   MODAL
========================================================= */

.shipped-modal {
    position: fixed;
    inset: 0;

    z-index: 99999;

    display: none;
    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(3, 9, 25, 0.82);

    backdrop-filter: blur(5px);
}

.shipped-modal.is-open {
    display: flex;
}

.shipped-modal-content {
    width: min(720px, 100%);
    max-height: 90vh;

    overflow: hidden;

    background: #2d2a67;

    border: 1px solid #484681;
    border-radius: 18px;

    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.50);

    animation: shippedModalIn 0.22s ease;
}

@keyframes shippedModalIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* =========================================================
   MODAL HEADER
========================================================= */

.shipped-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    padding: 18px 22px;

    background: linear-gradient(
        135deg,
        #252253,
        #373477
    );

    color: #ffffff;

    border-bottom: 1px solid #45437f;
}

.shipped-modal-header-left {
    display: flex;
    align-items: center;
    gap: 11px;
    min-width: 0;
}

.shipped-modal-header-icon {
    width: 39px;
    height: 39px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 39px;

    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 10px;

    background: rgba(255, 255, 255, 0.10);
    color: #aeb8ff;

    font-size: 16px;
}

.shipped-modal-header h3 {
    min-width: 0;

    margin: 0;

    color: #ffffff;

    font-size: 18px;
    font-weight: 800;
}

.shipped-modal-header p {
    margin: 3px 0 0;

    color: rgba(255, 255, 255, 0.65);

    font-size: 11px;
    font-weight: 500;
}

.shipped-modal-close {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex: 0 0 38px;

    border: 0;
    border-radius: 50%;

    background: rgba(255, 255, 255, 0.10);
    color: #ffffff;

    font-size: 23px;
    line-height: 1;

    cursor: pointer;

    transition: background 0.2s ease;
}

.shipped-modal-close:hover {
    background: rgba(255, 255, 255, 0.20);
}

/* =========================================================
   MODAL BODY
========================================================= */

.shipped-modal-body {
    max-height: calc(90vh - 135px);

    overflow-y: auto;

    padding: 22px;

    background: #2d2a67;
}

.shipped-modal-body::-webkit-scrollbar {
    width: 7px;
}

.shipped-modal-body::-webkit-scrollbar-track {
    background: #211f4e;
}

.shipped-modal-body::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background: #4b4a87;
}

/* =========================================================
   DETAILS
========================================================= */

.shipped-details {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 14px;
}

.shipped-detail {
    min-width: 0;

    padding: 15px;

    background: #242354;

    border: 1px solid #414078;
    border-radius: 12px;
}

.shipped-detail-full {
    grid-column: 1 / -1;
}

.shipped-detail-label {
    display: flex;
    align-items: center;
    gap: 6px;

    margin-bottom: 7px;

    color: #969abc;

    font-size: 10px;
    font-weight: 800;

    letter-spacing: 0.55px;
    text-transform: uppercase;
}

.shipped-detail-label i {
    color: #8995ff;
    font-size: 10px;
}

.shipped-detail-value {
    display: block;

    color: #ffffff;

    font-size: 14px;
    font-weight: 700;

    line-height: 1.5;

    overflow-wrap: anywhere;
}

.shipped-detail-value.loading {
    color: #9297b7;
    font-weight: 600;
}

.shipped-detail-value.error {
    color: #f87171;
}

/* =========================================================
   MODAL FOOTER
========================================================= */

.shipped-modal-footer {
    display: flex;
    justify-content: flex-end;

    padding: 15px 22px;

    border-top: 1px solid #414078;

    background: #242354;
}

.shipped-close-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 40px;
    padding: 0 17px;

    border: 1px solid #555979;
    border-radius: 9px;

    background: #59627d;
    color: #ffffff;

    font-family: inherit;
    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.shipped-close-btn:hover {
    background: #69748f;
    transform: translateY(-1px);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .shipped-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .shipped-filter-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .shipped-search {
        grid-column: 1 / -1;
    }
}

@media (max-width: 700px) {

    .shipped-page {
        padding: 15px;
    }

    .shipped-header {
        margin-bottom: 18px;
        padding: 17px;
        border-radius: 14px;
    }

    .shipped-header-icon {
        width: 43px;
        height: 43px;
        flex-basis: 43px;

        border-radius: 11px;
        font-size: 18px;
    }

    .shipped-header h2 {
        font-size: 20px;
    }

    .shipped-header p {
        font-size: 11px;
    }

    .shipped-stats {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .shipped-stat {
        padding: 17px;
    }

    .shipped-stat-value {
        font-size: 26px;
    }

    .shipped-stat-icon {
        width: 50px;
        height: 50px;
        flex-basis: 50px;
        font-size: 20px;
    }

    .shipped-filter-card {
        padding: 15px;
        border-radius: 14px;
    }

    .shipped-filter-grid {
        grid-template-columns: 1fr;
    }

    .shipped-search {
        grid-column: auto;
    }

    .shipped-table-top {
        padding: 15px;
    }

    .shipped-table-card {
        border-radius: 14px;
    }

    .shipped-modal {
        padding: 10px;
    }

    .shipped-modal-content {
        max-height: 95vh;
        border-radius: 14px;
    }

    .shipped-modal-header {
        padding: 14px 15px;
    }

    .shipped-modal-header h3 {
        font-size: 15px;
    }

    .shipped-modal-header p {
        display: none;
    }

    .shipped-modal-body {
        max-height: calc(95vh - 125px);
        padding: 15px;
    }

    .shipped-details {
        grid-template-columns: 1fr;
    }

    .shipped-detail-full {
        grid-column: auto;
    }

    .shipped-modal-footer {
        padding: 13px 15px;
    }

    .shipped-close-btn {
        width: 100%;
    }
}

@media (max-width: 420px) {

    .shipped-page {
        padding: 10px;
    }

    .shipped-header {
        padding: 14px;
    }

    .shipped-header-icon {
        width: 40px;
        height: 40px;
        flex-basis: 40px;
    }

    .shipped-header h2 {
        font-size: 18px;
    }

    .shipped-stat {
        padding: 15px;
    }

    .shipped-stat-value {
        font-size: 24px;
    }

    .shipped-stat-icon {
        width: 46px;
        height: 46px;
        flex-basis: 46px;
    }

    .shipped-filter-control {
        height: 42px;
    }
}
</style>


<div class="shipped-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="shipped-header">

        <div class="shipped-header-icon">
            <i class="fas fa-ship"></i>
        </div>

        <div class="shipped-header-content">

            <h2>
                Special Order
            </h2>

            <p>
                Monitor cadet special order requests and CHED shipping status.
            </p>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="shipped-stats">

        {{-- TOTAL --}}
        <div class="shipped-stat shipped-stat-blue">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $total }}
                </h3>

                <p class="shipped-stat-label">
                    Total Records
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-ship"></i>
            </div>

        </div>


        {{-- PENDING --}}
        <div class="shipped-stat shipped-stat-gray">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $pending }}
                </h3>

                <p class="shipped-stat-label">
                    Pending
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-clock"></i>
            </div>

        </div>


        {{-- ENDORSEMENT --}}
        <div class="shipped-stat shipped-stat-orange">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $endorsement }}
                </h3>

                <p class="shipped-stat-label">
                    For Endorsement
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-paper-plane"></i>
            </div>

        </div>


        {{-- COMPLETED --}}
        <div class="shipped-stat shipped-stat-green">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $completed }}
                </h3>

                <p class="shipped-stat-label">
                    Completed
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-circle-check"></i>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="shipped-filter-card">

        <div class="shipped-filter-header">

            <i class="fas fa-filter"></i>

            <span>
                Filter Records
            </span>

        </div>


        <form
            id="shippedFilterForm"
            method="GET"
            action="{{ route('superadmin.shipped-so.index') }}"
        >

            <div class="shipped-filter-grid">

                {{-- COURSE --}}
                <select
                    name="course"
                    id="shippedCourseFilter"
                    class="shipped-filter-control"
                    aria-label="Filter by course"
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


                {{-- BATCH --}}
                <select
                    name="batch"
                    id="shippedBatchFilter"
                    class="shipped-filter-control"
                    aria-label="Filter by batch"
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


                {{-- SEARCH --}}
                <div class="shipped-search">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        name="search"
                        id="shippedSearch"
                        class="shipped-filter-control"
                        placeholder="Search cadet..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                        aria-label="Search cadet"
                    >

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="shipped-table-card">

        <div class="shipped-table-top">

            <div class="shipped-table-title">

                <i class="fas fa-list-check"></i>

                <span>
                    Special Order Records
                </span>

            </div>

            <div class="shipped-table-count">
                {{ $orders->count() }} Records
            </div>

        </div>


        <div class="shipped-table-wrapper">

            <table class="shipped-table">

                <thead>

                    <tr>

                        <th>
                            Cadet
                        </th>

                        <th>
                            Deliberation Date
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            OBT Endorsement
                        </th>

                        <th>
                            CHED SO Number
                        </th>

                        <th>
                            Date Issued
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($orders as $order)

                        @php

                            $status = $order->status ?: 'Pending';

                            $statusClass = match ($status) {

                                'For Deliberation'
                                    => 'shipped-status-deliberation',

                                'For Endorsement'
                                    => 'shipped-status-endorsement',

                                'Shipped'
                                    => 'shipped-status-shipped',

                                'Completed'
                                    => 'shipped-status-completed',

                                default
                                    => 'shipped-status-pending',

                            };

                            $statusIcon = match ($status) {

                                'For Deliberation'
                                    => 'fa-hourglass-half',

                                'For Endorsement'
                                    => 'fa-paper-plane',

                                'Shipped'
                                    => 'fa-ship',

                                'Completed'
                                    => 'fa-circle-check',

                                default
                                    => 'fa-clock',

                            };

                        @endphp


                        <tr>

                            {{-- CADET --}}
                            <td>

                                <span class="shipped-cadet-name">

                                    {{ $order->cadet->full_name ?? '-' }}

                                </span>

                            </td>


                            {{-- DELIBERATION DATE --}}
                            <td>

                                @if($order->deliberation_date)

                                    <span class="shipped-date">

                                        {{ \Carbon\Carbon::parse(
                                            $order->deliberation_date
                                        )->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span
                                    class="shipped-status {{ $statusClass }}"
                                >

                                    <i class="fas {{ $statusIcon }}"></i>

                                    {{ $status }}

                                </span>

                            </td>


                            {{-- ENDORSEMENT --}}
                            <td>

                                @if($order->obt_endorsement_date)

                                    <span class="shipped-date">

                                        {{ \Carbon\Carbon::parse(
                                            $order->obt_endorsement_date
                                        )->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- SO NUMBER --}}
                            <td>

                                @if($order->so_number)

                                    <strong>
                                        {{ $order->so_number }}
                                    </strong>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- SO DATE --}}
                            <td>

                                @if($order->so_date_issued)

                                    <span class="shipped-date">

                                        {{ \Carbon\Carbon::parse(
                                            $order->so_date_issued
                                        )->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}
                            <td>

                                <button
                                    type="button"
                                    class="shipped-view-btn"
                                    onclick="openShippedModal({{ $order->id }})"
                                >

                                    <i class="fas fa-eye"></i>

                                    View

                                </button>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="shipped-empty"
                            >

                                <div class="shipped-empty-icon">

                                    <i class="fas fa-box-open"></i>

                                </div>

                                <strong>
                                    No Special Order records found.
                                </strong>

                                <span>
                                    Try changing your filters or search term.
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
     VIEW MODAL
========================================================= --}}

<div
    id="shippedViewModal"
    class="shipped-modal"
    aria-hidden="true"
>

    <div
        class="shipped-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="shippedModalTitle"
    >

        {{-- MODAL HEADER --}}
        <div class="shipped-modal-header">

            <div class="shipped-modal-header-left">

                <div class="shipped-modal-header-icon">

                    <i class="fas fa-ship"></i>

                </div>

                <div>

                    <h3 id="shippedModalTitle">
                        Special Order Details
                    </h3>

                    <p>
                        Complete order information
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="shipped-modal-close"
                onclick="closeShippedModal()"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        {{-- MODAL BODY --}}
        <div class="shipped-modal-body">

            <div class="shipped-details">

                {{-- CADET --}}
                <div class="shipped-detail shipped-detail-full">

                    <span class="shipped-detail-label">

                        <i class="fas fa-user"></i>

                        Cadet

                    </span>

                    <span
                        id="shippedCadet"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- DELIBERATION DATE --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-calendar"></i>

                        Deliberation Date

                    </span>

                    <span
                        id="shippedDeliberationDate"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- STATUS --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-circle-info"></i>

                        Status

                    </span>

                    <span
                        id="shippedStatus"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- ENDORSEMENT DATE --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-paper-plane"></i>

                        OBT Endorsement Date

                    </span>

                    <span
                        id="shippedEndorsementDate"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- SO NUMBER --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-file-invoice"></i>

                        CHED SO Number

                    </span>

                    <span
                        id="shippedSONumber"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- DATE ISSUED --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-calendar-check"></i>

                        Date Issued

                    </span>

                    <span
                        id="shippedSODate"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- REMARKS --}}
                <div class="shipped-detail shipped-detail-full">

                    <span class="shipped-detail-label">

                        <i class="fas fa-comment"></i>

                        Remarks

                    </span>

                    <span
                        id="shippedRemarks"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>

            </div>

        </div>


        {{-- MODAL FOOTER --}}
        <div class="shipped-modal-footer">

            <button
                type="button"
                class="shipped-close-btn"
                onclick="closeShippedModal()"
            >

                <i class="fas fa-xmark"></i>

                Close

            </button>

        </div>

    </div>

</div>


<script>
(function () {

    'use strict';


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const filterForm =
        document.getElementById('shippedFilterForm');

    const courseFilter =
        document.getElementById('shippedCourseFilter');

    const batchFilter =
        document.getElementById('shippedBatchFilter');

    const searchInput =
        document.getElementById('shippedSearch');

    const modal =
        document.getElementById('shippedViewModal');


    /* =====================================================
       FILTERS
    ===================================================== */

    if (courseFilter && filterForm) {

        courseFilter.addEventListener(
            'change',
            function () {

                filterForm.submit();

            }
        );

    }


    if (batchFilter && filterForm) {

        batchFilter.addEventListener(
            'change',
            function () {

                filterForm.submit();

            }
        );

    }


    let searchTimer = null;


    if (searchInput && filterForm) {

        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(searchTimer);

                searchTimer = setTimeout(
                    function () {

                        filterForm.submit();

                    },
                    500
                );

            }
        );

    }


    /* =====================================================
       GLOBAL ESCAPE
    ===================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal &&
                modal.classList.contains('is-open')
            ) {

                closeShippedModal();

            }

        }
    );


    /* =====================================================
       BACKDROP CLICK
    ===================================================== */

    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (event.target === modal) {

                    closeShippedModal();

                }

            }
        );

    }


    /* =====================================================
       OPEN MODAL
    ===================================================== */

    window.openShippedModal = function (id) {

        if (!modal) {
            return;
        }


        /* -------------------------------------------------
           RESET VALUES
        ------------------------------------------------- */

        setShippedValue(
            'shippedCadet',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedDeliberationDate',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedStatus',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedEndorsementDate',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedSONumber',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedSODate',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedRemarks',
            'Loading...',
            'loading'
        );


        /* -------------------------------------------------
           OPEN MODAL
        ------------------------------------------------- */

        modal.classList.add('is-open');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';


        /* -------------------------------------------------
           DETAIL URL
        ------------------------------------------------- */

        const detailUrl =
            `/super-admin/shipped-so/${id}`;


        /* -------------------------------------------------
           FETCH RECORD
        ------------------------------------------------- */

        fetch(
            detailUrl,
            {
                method: 'GET',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                credentials: 'same-origin'
            }
        )

        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    `Request failed with status ${response.status}`
                );

            }

            return response.json();

        })

        .then(function (data) {

            setShippedValue(
                'shippedCadet',
                data.cadet?.full_name || '—'
            );

            setShippedValue(
                'shippedDeliberationDate',
                formatShippedDate(
                    data.deliberation_date
                )
            );

            setShippedValue(
                'shippedStatus',
                data.status || 'Pending'
            );

            setShippedValue(
                'shippedEndorsementDate',
                formatShippedDate(
                    data.obt_endorsement_date
                )
            );

            setShippedValue(
                'shippedSONumber',
                data.so_number || '—'
            );

            setShippedValue(
                'shippedSODate',
                formatShippedDate(
                    data.so_date_issued
                )
            );

            setShippedValue(
                'shippedRemarks',
                data.remarks || '—'
            );

        })

        .catch(function (error) {

            console.error(
                'Special Order error:',
                error
            );


            setShippedValue(
                'shippedCadet',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedDeliberationDate',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedStatus',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedEndorsementDate',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedSONumber',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedSODate',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedRemarks',
                'Unable to load this record.',
                'error'
            );

        });

    };


    /* =====================================================
       CLOSE MODAL
    ===================================================== */

    window.closeShippedModal = function () {

        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';

    };


    /* =====================================================
       SET VALUE
    ===================================================== */

    function setShippedValue(
        elementId,
        value,
        state = ''
    ) {

        const element =
            document.getElementById(elementId);

        if (!element) {
            return;
        }

        element.textContent =
            value || '—';

        element.classList.remove(
            'loading',
            'error'
        );

        if (state) {
            element.classList.add(state);
        }

    }


    /* =====================================================
       FORMAT DATE
    ===================================================== */

    function formatShippedDate(date) {

        if (!date) {
            return '—';
        }

        const parsedDate =
            new Date(date);

        if (
            Number.isNaN(
                parsedDate.getTime()
            )
        ) {

            return '—';

        }

        return parsedDate.toLocaleDateString(
            'en-US',
            {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            }
        );

    }

})();
</script>

@endsection