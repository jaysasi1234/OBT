@extends('layouts.superadmin')

@section('header-title', 'Shipped On Order')

@section('content')

<style>
/* =========================================================
   PAGE
========================================================= */

.shipped-page {
    width: 100%;
    min-height: 100vh;
    padding: 24px;
    background: #f4f7fc;
    color: #0f172a;
}

.shipped-page *,
.shipped-page *::before,
.shipped-page *::after {
    box-sizing: border-box;
}


/* =========================================================
   HEADER
========================================================= */

.shipped-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    padding: 20px 24px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(15, 23, 42, .06);
}

.shipped-header-icon {
    width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 46px;
    border-radius: 12px;
    background: #dbeafe;
    color: #0B3D91;
    font-size: 20px;
}

.shipped-header h2 {
    margin: 0;
    color: #0B3D91;
    font-size: 26px;
    font-weight: 800;
    line-height: 1.2;
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
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    min-width: 0;
    padding: 20px;
    background: linear-gradient(135deg, #fff, #f8fbff);
    border: 1px solid #e5e7eb;
    border-top: 4px solid #2563eb;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .07);
    transition: transform .2s ease, box-shadow .2s ease;
}

.shipped-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(15, 23, 42, .11);
}

.shipped-stat-content {
    min-width: 0;
}

.shipped-stat-value {
    margin: 0;
    color: #0B3D91;
    font-size: 30px;
    font-weight: 800;
    line-height: 1;
}

.shipped-stat-label {
    margin: 7px 0 0;
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
}

.shipped-stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 56px;
    border-radius: 14px;
    color: #fff;
    font-size: 23px;
}

.shipped-stat-blue {
    border-top-color: #2563eb;
}

.shipped-stat-blue .shipped-stat-icon {
    background: #2563eb;
}

.shipped-stat-gray {
    border-top-color: #6b7280;
}

.shipped-stat-gray .shipped-stat-icon {
    background: #6b7280;
}

.shipped-stat-orange {
    border-top-color: #f59e0b;
}

.shipped-stat-orange .shipped-stat-icon {
    background: #f59e0b;
}

.shipped-stat-green {
    border-top-color: #16a34a;
}

.shipped-stat-green .shipped-stat-icon {
    background: #16a34a;
}


/* =========================================================
   FILTER CARD
========================================================= */

.shipped-filter-card {
    margin-bottom: 24px;
    padding: 20px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .07);
}

.shipped-filter-grid {
    display: grid;
    grid-template-columns: minmax(180px, 1fr)
                           minmax(180px, 1fr)
                           minmax(240px, 1.5fr);
    gap: 15px;
}

.shipped-filter-control {
    width: 100%;
    height: 44px;
    padding: 0 13px;
    border: 1px solid #d9e2ec;
    border-radius: 10px;
    background: #fff;
    color: #1e293b;
    font-size: 14px;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.shipped-filter-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
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
    color: #94a3b8;
    font-size: 14px;
    transform: translateY(-50%);
    pointer-events: none;
}

.shipped-search input {
    padding-left: 40px;
}


/* =========================================================
   TABLE CARD
========================================================= */

.shipped-table-card {
    width: 100%;
    overflow: hidden;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, .08);
}

.shipped-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.shipped-table {
    width: 100%;
    min-width: 950px;
    border-collapse: collapse;
}


/* =========================================================
   TABLE HEADER
========================================================= */

.shipped-table thead {
    background: linear-gradient(
        135deg,
        #0B3D91,
        #1353bf
    );
}

.shipped-table th {
    padding: 15px 14px;
    color: #fff;
    border: 0;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .45px;
    text-align: center;
    text-transform: uppercase;
    white-space: nowrap;
}


/* =========================================================
   TABLE BODY
========================================================= */

.shipped-table td {
    padding: 15px 14px;
    border-bottom: 1px solid #eef2f7;
    color: #334155;
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}

.shipped-table tbody tr {
    transition: background .2s ease;
}

.shipped-table tbody tr:hover {
    background: #f8fbff;
}

.shipped-table tbody tr:last-child td {
    border-bottom: 0;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.shipped-empty {
    padding: 45px 20px !important;
    color: #64748b !important;
    white-space: normal !important;
}

.shipped-empty i {
    display: block;
    margin-bottom: 10px;
    color: #94a3b8;
    font-size: 34px;
}

.shipped-empty strong {
    display: block;
    margin-bottom: 4px;
    color: #334155;
    font-size: 15px;
}


/* =========================================================
   STATUS BADGES
========================================================= */

.shipped-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-width: 120px;
    padding: 7px 12px;
    border-radius: 999px;
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    line-height: 1;
    white-space: nowrap;
}

.shipped-status-pending {
    background: #6b7280;
}

.shipped-status-deliberation {
    background: #f59e0b;
}

.shipped-status-endorsement {
    background: #2563eb;
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
    min-height: 38px;
    padding: 0 14px;
    border: 0;
    border-radius: 9px;
    background: #0B3D91;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s ease;
}

.shipped-view-btn:hover {
    background: #072b67;
    color: #fff;
    transform: translateY(-1px);
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
    background: rgba(15, 23, 42, .65);
    backdrop-filter: blur(4px);
}

.shipped-modal.is-open {
    display: flex;
}

.shipped-modal-content {
    width: min(720px, 100%);
    max-height: 90vh;
    overflow: hidden;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, .30);
    animation: shippedModalIn .2s ease;
}

@keyframes shippedModalIn {

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

.shipped-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 18px 22px;
    background: linear-gradient(
        135deg,
        #0B3D91,
        #1353bf
    );
    color: #fff;
}

.shipped-modal-header h3 {
    min-width: 0;
    margin: 0;
    font-size: 19px;
    font-weight: 800;
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
    background: rgba(255,255,255,.12);
    color: #fff;
    font-size: 25px;
    line-height: 1;
    cursor: pointer;
    transition: .2s ease;
}

.shipped-modal-close:hover {
    background: rgba(255,255,255,.25);
}


/* =========================================================
   MODAL BODY
========================================================= */

.shipped-modal-body {
    max-height: calc(90vh - 135px);
    overflow-y: auto;
    padding: 22px;
}

.shipped-details {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.shipped-detail {
    min-width: 0;
    padding: 14px;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
}

.shipped-detail-full {
    grid-column: 1 / -1;
}

.shipped-detail-label {
    display: block;
    margin-bottom: 6px;
    color: #64748b;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .55px;
    text-transform: uppercase;
}

.shipped-detail-value {
    display: block;
    color: #1e293b;
    font-size: 14px;
    font-weight: 700;
    line-height: 1.5;
    overflow-wrap: anywhere;
}


/* =========================================================
   MODAL FOOTER
========================================================= */

.shipped-modal-footer {
    display: flex;
    justify-content: flex-end;
    padding: 16px 22px;
    border-top: 1px solid #e5e7eb;
}

.shipped-close-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    padding: 0 17px;
    border: 0;
    border-radius: 9px;
    background: #64748b;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s ease;
}

.shipped-close-btn:hover {
    background: #475569;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .shipped-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .shipped-filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
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
    }

    .shipped-header h2 {
        font-size: 21px;
    }

    .shipped-header-icon {
        width: 42px;
        height: 42px;
        flex-basis: 42px;
        font-size: 18px;
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
    }

    .shipped-filter-grid {
        grid-template-columns: 1fr;
    }

    .shipped-search {
        grid-column: auto;
    }

    .shipped-modal {
        padding: 10px;
    }

    .shipped-modal-content {
        max-height: 95vh;
        border-radius: 14px;
    }

    .shipped-modal-header {
        padding: 15px 17px;
    }

    .shipped-modal-header h3 {
        font-size: 16px;
    }

    .shipped-modal-body {
        max-height: calc(95vh - 130px);
        padding: 15px;
    }

    .shipped-details {
        grid-template-columns: 1fr;
    }

    .shipped-detail-full {
        grid-column: auto;
    }

    .shipped-modal-footer {
        padding: 14px 15px;
    }

    .shipped-close-btn {
        width: 100%;
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

        <h2>
            Special Order
        </h2>

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

        <div class="shipped-table-wrapper">

            <table class="shipped-table">

                <thead>

                    <tr>

                        <th>Cadet</th>

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

                                <strong>
                                    {{ $order->cadet->full_name ?? '-' }}
                                </strong>

                            </td>


                            {{-- DELIBERATION DATE --}}
                            <td>

                                @if($order->deliberation_date)

                                    {{ \Carbon\Carbon::parse(
                                        $order->deliberation_date
                                    )->format('M d, Y') }}

                                @else

                                    —

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

                                    {{ \Carbon\Carbon::parse(
                                        $order->obt_endorsement_date
                                    )->format('M d, Y') }}

                                @else

                                    —

                                @endif

                            </td>


                            {{-- SO NUMBER --}}
                            <td>
                                {{ $order->so_number ?: '—' }}
                            </td>


                            {{-- SO DATE --}}
                            <td>

                                @if($order->so_date_issued)

                                    {{ \Carbon\Carbon::parse(
                                        $order->so_date_issued
                                    )->format('M d, Y') }}

                                @else

                                    —

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

                                <i class="fas fa-box-open"></i>

                                <strong>
                                    No Shipped On Order records found.
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

            <h3 id="shippedModalTitle">

                <i class="fas fa-ship"></i>

                Special Order Details

            </h3>


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

    const filterForm = document.getElementById(
        'shippedFilterForm'
    );

    const courseFilter = document.getElementById(
        'shippedCourseFilter'
    );

    const batchFilter = document.getElementById(
        'shippedBatchFilter'
    );

    const searchInput = document.getElementById(
        'shippedSearch'
    );

    const modal = document.getElementById(
        'shippedViewModal'
    );


    /* =====================================================
       FILTERS
    ===================================================== */

    if (courseFilter) {

        courseFilter.addEventListener(
            'change',
            function () {

                filterForm.submit();

            }
        );

    }


    if (batchFilter) {

        batchFilter.addEventListener(
            'change',
            function () {

                filterForm.submit();

            }
        );

    }


    let searchTimer = null;

    if (searchInput) {

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
       PUBLIC FUNCTIONS
    ===================================================== */

    window.openShippedModal = function (id) {

        if (!modal) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Reset values
        |--------------------------------------------------------------------------
        */

        setShippedValue(
            'shippedCadet',
            'Loading...'
        );

        setShippedValue(
            'shippedDeliberationDate',
            'Loading...'
        );

        setShippedValue(
            'shippedStatus',
            'Loading...'
        );

        setShippedValue(
            'shippedEndorsementDate',
            'Loading...'
        );

        setShippedValue(
            'shippedSONumber',
            'Loading...'
        );

        setShippedValue(
            'shippedSODate',
            'Loading...'
        );

        setShippedValue(
            'shippedRemarks',
            'Loading...'
        );


        /*
        |--------------------------------------------------------------------------
        | Open modal
        |--------------------------------------------------------------------------
        */

        modal.classList.add('is-open');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';


        /*
        |--------------------------------------------------------------------------
        | Detail URL
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Keep your existing detail endpoint here.
        |
        */

        const detailUrl =
            `/super-admin/shipped-so/${id}`;


        /*
        |--------------------------------------------------------------------------
        | Fetch record
        |--------------------------------------------------------------------------
        */

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
                'Shipped On Order error:',
                error
            );


            setShippedValue(
                'shippedCadet',
                'Unable to load'
            );

            setShippedValue(
                'shippedDeliberationDate',
                'Unable to load'
            );

            setShippedValue(
                'shippedStatus',
                'Unable to load'
            );

            setShippedValue(
                'shippedEndorsementDate',
                'Unable to load'
            );

            setShippedValue(
                'shippedSONumber',
                'Unable to load'
            );

            setShippedValue(
                'shippedSODate',
                'Unable to load'
            );

            setShippedValue(
                'shippedRemarks',
                'Unable to load this record.'
            );

        });

    };


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
       HELPERS
    ===================================================== */

    function setShippedValue(
        elementId,
        value
    ) {

        const element =
            document.getElementById(elementId);

        if (!element) {
            return;
        }

        element.textContent =
            value || '—';

    }


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