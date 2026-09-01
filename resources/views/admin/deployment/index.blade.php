@extends('layouts.admin')

@section('content')

    @vite(['resources/css/admin/deployment/deployment.css'])

    @php
        /*
        |--------------------------------------------------------------------------
        | Deployment Monitoring Helpers
        |--------------------------------------------------------------------------
        */

        $formatDate = function ($date) {
            if (!$date) {
                return '—';
            }

            try {
                return \Carbon\Carbon::parse($date)->format('M d, Y');
            } catch (\Throwable $e) {
                return '—';
            }
        };

        /*
        |--------------------------------------------------------------------------
        | SEA SERVICE DURATION
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Duration is ONLY calculated when BOTH dates exist.
        |
        | Ongoing deployment:
        | Embarkation = Feb 01, 2026
        | Disembarkation = NULL
        | Result = —
        |
        | Completed deployment:
        | Embarkation = Feb 01, 2026
        | Disembarkation = Mar 04, 2026
        | Result = 1 Month, 3 Days
        |
        */

        $calculateDuration = function ($startDate, $endDate = null) {

            /*
             * Do NOT calculate ongoing duration.
             *
             * Sea service duration is only finalized
             * after the cadet has a disembarkation date.
             */
            if (!$startDate || !$endDate) {
                return null;
            }

            try {

                $start = \Carbon\Carbon::parse($startDate)->startOfDay();
                $end = \Carbon\Carbon::parse($endDate)->startOfDay();

                /*
                 * Invalid date range.
                 */
                if ($end->lt($start)) {
                    return null;
                }

                /*
                 * Calculate complete calendar months.
                 */
                $months = $start->diffInMonths($end);

                /*
                 * Build the date after the calculated months.
                 */
                $monthDate = $start->copy()->addMonthsNoOverflow($months);

                /*
                 * Protect against over-counting.
                 */
                if ($monthDate->gt($end)) {

                    $months--;

                    $monthDate = $start
                        ->copy()
                        ->addMonthsNoOverflow(
                            max(0, $months)
                        );
                }

                /*
                 * Calculate remaining days.
                 */
                $days = $monthDate->diffInDays($end);

                $parts = [];

                if ($months > 0) {

                    $parts[] =
                        $months . ' ' .
                        ($months === 1
                            ? 'Month'
                            : 'Months');

                }

                if ($days > 0) {

                    $parts[] =
                        $days . ' ' .
                        ($days === 1
                            ? 'Day'
                            : 'Days');

                }

                /*
                 * Same embarkation and disembarkation date.
                 */
                return $parts
                    ? implode(', ', $parts)
                    : '0 Days';

            } catch (\Throwable $e) {

                return null;
            }
        };
    @endphp


    {{-- =========================================================
         PAGE
    ========================================================== --}}

    <div class="dm-page">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <header class="dm-header">

            <div class="dm-header-content">

                <h1>
                    Deployment Monitoring
                </h1>

                <p>
                    Monitor cadet deployment information, vessel assignments,
                    progress, and training status.
                </p>

            </div>

            <div
                class="dm-header-icon"
                aria-hidden="true"
            >
                🚢
            </div>

        </header>


        {{-- =====================================================
             STATISTICS
        ====================================================== --}}

        <section
            class="dm-stats"
            aria-label="Deployment statistics"
        >

            <article class="dm-stat dm-stat-blue">

                <div class="dm-stat-top">

                    <span class="dm-stat-label">
                        Total Deployed
                    </span>

                    <span
                        class="dm-stat-icon"
                        aria-hidden="true"
                    >
                        🚢
                    </span>

                </div>

                <strong class="dm-stat-value">
                    {{ $totalDeployed }}
                </strong>

                <span class="dm-stat-description">
                    Cadets with deployment records
                </span>

            </article>


            <article class="dm-stat dm-stat-cyan">

                <div class="dm-stat-top">

                    <span class="dm-stat-label">
                        Ongoing
                    </span>

                    <span
                        class="dm-stat-icon"
                        aria-hidden="true"
                    >
                        ⚓
                    </span>

                </div>

                <strong class="dm-stat-value">
                    {{ $ongoing }}
                </strong>

                <span class="dm-stat-description">
                    Currently onboard training
                </span>

            </article>


            <article class="dm-stat dm-stat-green">

                <div class="dm-stat-top">

                    <span class="dm-stat-label">
                        Completed
                    </span>

                    <span
                        class="dm-stat-icon"
                        aria-hidden="true"
                    >
                        ✓
                    </span>

                </div>

                <strong class="dm-stat-value">
                    {{ $completed }}
                </strong>

                <span class="dm-stat-description">
                    Successfully completed
                </span>

            </article>


            <article class="dm-stat dm-stat-gray">

                <div class="dm-stat-top">

                    <span class="dm-stat-label">
                        Not Deployed
                    </span>

                    <span
                        class="dm-stat-icon"
                        aria-hidden="true"
                    >
                        📋
                    </span>

                </div>

                <strong class="dm-stat-value">
                    {{ $notDeployed }}
                </strong>

                <span class="dm-stat-description">
                    Awaiting deployment
                </span>

            </article>

        </section>


        {{-- =====================================================
             FILTERS
        ====================================================== --}}

        <section
            class="dm-filter-panel"
            aria-label="Deployment filters"
        >

            <div class="dm-filter-header">

                <div class="dm-filter-title">

                    <span
                        class="dm-filter-title-icon"
                        aria-hidden="true"
                    >
                        ⚙
                    </span>

                    <span>
                        Filters
                    </span>

                </div>

            </div>


            <div class="dm-filter-grid">


                {{-- COURSE FILTER --}}

                <div class="dm-filter-dropdown">

                    <button
                        type="button"
                        class="dm-filter-button"
                        onclick="toggleDMFilter(this)"
                        aria-expanded="false"
                    >

                        <span>
                            Courses
                        </span>

                        <span
                            class="dm-filter-arrow"
                            aria-hidden="true"
                        >
                            ▼
                        </span>

                    </button>

                    <div
                        id="courseMenu"
                        class="dm-dropdown-menu"
                    >

                        @foreach($courses as $course)

                            <label class="dm-check-option">

                                <input
                                    type="checkbox"
                                    value="{{ strtolower(trim($course->course)) }}"
                                    data-filter="course"
                                >

                                <span>
                                    {{ $course->course }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                </div>


                {{-- BATCH FILTER --}}

                <div class="dm-filter-dropdown">

                    <button
                        type="button"
                        class="dm-filter-button"
                        onclick="toggleDMFilter(this)"
                        aria-expanded="false"
                    >

                        <span>
                            Batches
                        </span>

                        <span
                            class="dm-filter-arrow"
                            aria-hidden="true"
                        >
                            ▼
                        </span>

                    </button>

                    <div
                        id="batchMenu"
                        class="dm-dropdown-menu"
                    >

                        @foreach($batches as $batch)

                            <label class="dm-check-option">

                                <input
                                    type="checkbox"
                                    value="{{ strtolower(trim($batch->batch_year)) }}"
                                    data-filter="batch"
                                >

                                <span>
                                    {{ $batch->batch_year }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                </div>


                {{-- STATUS FILTER --}}

                <div class="dm-filter-dropdown">

                    <button
                        type="button"
                        class="dm-filter-button"
                        onclick="toggleDMFilter(this)"
                        aria-expanded="false"
                    >

                        <span>
                            Status
                        </span>

                        <span
                            class="dm-filter-arrow"
                            aria-hidden="true"
                        >
                            ▼
                        </span>

                    </button>

                    <div
                        id="statusMenu"
                        class="dm-dropdown-menu"
                    >

                        @foreach([
                            'ongoing' => 'Ongoing',
                            'completed' => 'Completed',
                            'not deployed' => 'Not Deployed'
                        ] as $value => $label)

                            <label class="dm-check-option">

                                <input
                                    type="checkbox"
                                    value="{{ $value }}"
                                    data-filter="status"
                                >

                                <span>
                                    {{ $label }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                </div>


                {{-- SEARCH --}}

                <div class="dm-filter-field">

                    <span
                        class="dm-search-icon"
                        aria-hidden="true"
                    >
                        🔍
                    </span>

                    <input
                        type="search"
                        id="searchInput"
                        class="dm-search"
                        placeholder="Search cadet, TRB, vessel..."
                        autocomplete="off"
                    >

                </div>


                {{-- DATE FROM --}}

                <div class="dm-filter-field">

                    <input
                        type="date"
                        id="dateFrom"
                        class="dm-date-input"
                        title="Deployment date from"
                    >

                </div>


                {{-- DATE TO --}}

                <div class="dm-filter-field">

                    <input
                        type="date"
                        id="dateTo"
                        class="dm-date-input"
                        title="Deployment date to"
                    >

                </div>

            </div>

        </section>


        {{-- =====================================================
             TABLE
        ====================================================== --}}

        <section class="dm-table-card">

            <div class="dm-table-header">

                <div class="dm-table-title">

                    <strong>
                        Cadet Deployment Records
                    </strong>

                    <span>
                        Review and manage deployment information
                    </span>

                </div>

                <div class="dm-table-hint">
                    ↔ Scroll horizontally to view all columns
                </div>

            </div>


            <div class="dm-table-scroll">

                <table class="dm-table">

                    <thead>

                        <tr>

                            <th scope="col">
                                TRB No.
                            </th>

                            <th scope="col">
                                Name
                            </th>

                            <th scope="col">
                                Course
                            </th>

                            <th scope="col">
                                Batch
                            </th>

                            <th scope="col">
                                Vessel
                            </th>

                            <th scope="col">
                                Company
                            </th>

                            <th scope="col">
                                Deployment Type
                            </th>

                            <th scope="col">
                                Embarkation Place
                            </th>

                            <th scope="col">
                                Embarkation Date
                            </th>

                            <th scope="col">
                                Disembarkation Place
                            </th>

                            <th scope="col">
                                Disembarkation Date
                            </th>

                            <th scope="col">
                                Duration of Sea Service
                            </th>

                            <th scope="col">
                                Progress
                            </th>

                            <th scope="col">
                                Status
                            </th>

                            <th scope="col">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="deploymentTableBody">

                        @forelse($cadets as $cadet)

                            @php

                                $deployment = $cadet->deployment;

                                $status = strtolower(
                                    trim(
                                        $deployment?->status ?? 'Not Deployed'
                                    )
                                );

                                $percentage = max(
                                    0,
                                    min(
                                        100,
                                        (int) ($deployment?->percentage ?? 0)
                                    )
                                );

                                $course = strtolower(
                                    trim($cadet->course ?? '')
                                );

                                $batch = strtolower(
                                    trim(
                                        $cadet->batch?->batch_year ?? ''
                                    )
                                );

                                /*
                                 * IMPORTANT:
                                 *
                                 * Duration is ONLY calculated when
                                 * date_deployed AND date_disembarked
                                 * are both available.
                                 */
                                $duration = $calculateDuration(
                                    $deployment?->date_deployed,
                                    $deployment?->date_disembarked
                                );

                            @endphp


                            <tr
                                data-course="{{ $course }}"
                                data-batch="{{ $batch }}"
                                data-status="{{ $status }}"
                                data-deployment-date="{{ $deployment?->date_deployed ?? '' }}"
                            >


                                {{-- TRB --}}

                                <td>

                                    <strong>
                                        {{ $cadet->trb_control_number ?: '—' }}
                                    </strong>

                                </td>


                                {{-- NAME --}}

                                <td>
                                    {{ $cadet->full_name ?: '—' }}
                                </td>


                                {{-- COURSE --}}

                                <td>
                                    {{ strtoupper($cadet->course ?? '—') }}
                                </td>


                                {{-- BATCH --}}

                                <td>
                                    {{ $cadet->batch?->batch_year ?? 'No Batch' }}
                                </td>


                                {{-- VESSEL --}}

                                <td>
                                    {{ $deployment?->vessel_name ?: '—' }}
                                </td>


                                {{-- COMPANY --}}

                                <td>
                                    {{ $deployment?->company_name ?: '—' }}
                                </td>


                                {{-- DEPLOYMENT TYPE --}}

                                <td>

                                    @switch($deployment?->deployment_type)

                                        @case('International')

                                            <span class="dm-badge dm-badge-blue">
                                                🌍 International
                                            </span>

                                            @break

                                        @case('Domestic')

                                            <span class="dm-badge dm-badge-green">
                                                🇵🇭 Domestic
                                            </span>

                                            @break

                                        @default

                                            <span class="dm-badge dm-badge-gray">
                                                —
                                            </span>

                                    @endswitch

                                </td>


                                {{-- EMBARKATION PLACE --}}

                                <td>
                                    {{ $deployment?->embarkation_place ?: '—' }}
                                </td>


                                {{-- EMBARKATION DATE --}}

                                <td
                                    data-date="{{ $deployment?->date_deployed ?? '' }}"
                                >

                                    {{ $formatDate($deployment?->date_deployed) }}

                                </td>


                                {{-- DISEMBARKATION PLACE --}}

                                <td>
                                    {{ $deployment?->disembarkation_place ?: '—' }}
                                </td>


                                {{-- DISEMBARKATION DATE --}}

                                <td>

                                    {{ $formatDate($deployment?->date_disembarked) }}

                                </td>


                                {{-- SEA SERVICE DURATION --}}

                                <td>

                                    @if(
                                        $deployment?->date_deployed &&
                                        $deployment?->date_disembarked &&
                                        $duration
                                    )

                                        <span class="dm-duration-text">
                                            {{ $duration }}
                                        </span>

                                    @else

                                        <span class="dm-duration-text">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- PROGRESS --}}

                                <td>

                                    <div class="dm-progress">

                                        <div class="dm-progress-top">

                                            <span>
                                                Training Progress
                                            </span>

                                            <span class="dm-progress-value">
                                                {{ $percentage }}%
                                            </span>

                                        </div>

                                        <div
                                            class="dm-progress-track"
                                            role="progressbar"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            aria-valuenow="{{ $percentage }}"
                                        >

                                            <div
                                                class="dm-progress-fill {{ $percentage >= 100 ? 'complete' : '' }}"
                                                style="width: {{ $percentage }}%;"
                                            ></div>

                                        </div>

                                    </div>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @switch($status)

                                        @case('ongoing')

                                            <span class="dm-badge dm-badge-blue">
                                                ⚓ Ongoing
                                            </span>

                                            @break

                                        @case('completed')

                                            <span class="dm-badge dm-badge-green">
                                                ✓ Completed
                                            </span>

                                            @break

                                        @default

                                            <span class="dm-badge dm-badge-gray">
                                                ○ Not Deployed
                                            </span>

                                    @endswitch

                                </td>


                                {{-- ACTION --}}

                                <td>

                                    <button
                                        type="button"
                                        class="dm-view-btn"
                                        onclick="openDeploymentModal(@js($cadet))"
                                        aria-label="View deployment for {{ $cadet->full_name }}"
                                    >
                                        👁 View
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr class="dm-empty-row">

                                <td
                                    colspan="15"
                                    class="dm-empty"
                                >

                                    <div class="dm-empty-icon">
                                        🚢
                                    </div>

                                    <strong>
                                        No deployment records found
                                    </strong>

                                    <span>
                                        There are currently no cadets matching the available records.
                                    </span>

                                </td>

                            </tr>

                        @endforelse


                        {{-- FILTERED EMPTY STATE --}}

                        <tr
                            id="filteredEmptyRow"
                            class="dm-empty-row"
                            style="display:none;"
                        >

                            <td
                                colspan="15"
                                class="dm-empty"
                            >

                                <div class="dm-empty-icon">
                                    🔍
                                </div>

                                <strong>
                                    No matching records
                                </strong>

                                <span>
                                    Try changing your filters or search term.
                                </span>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </section>

    </div>


    {{-- =========================================================
         SUCCESS TOAST
    ========================================================== --}}

    <div
        id="successToast"
        class="dm-toast"
        role="status"
        aria-live="polite"
    >

        <div class="dm-toast-icon">
            ✓
        </div>

        <div class="dm-toast-content">

            <strong>
                Deployment Updated
            </strong>

            <span>
                Deployment information was successfully saved.
            </span>

        </div>

    </div>


    {{-- =========================================================
         DEPLOYMENT MODAL
    ========================================================== --}}

    <div
        id="deploymentModal"
        class="dm-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deploymentModalTitle"
    >

        <div class="dm-modal-card">

            <input
                type="hidden"
                id="modalId"
            >


            {{-- MODAL HEADER --}}

            <header class="dm-modal-header">

                <div class="dm-modal-title">

                    <div
                        class="dm-modal-title-icon"
                        aria-hidden="true"
                    >
                        🚢
                    </div>

                    <div>

                        <strong id="deploymentModalTitle">
                            Update Deployment
                        </strong>

                        <span>
                            Manage cadet deployment information
                        </span>

                    </div>

                </div>


                <button
                    type="button"
                    class="dm-modal-close"
                    onclick="closeDeploymentModal()"
                    aria-label="Close deployment modal"
                >
                    ×
                </button>

            </header>


            {{-- MODAL BODY --}}

            <div class="dm-modal-body">


                {{-- PROFILE --}}

                <div class="dm-profile">

                    <img
                        id="modalPhoto"
                        src="{{ asset('images/default.png') }}"
                        alt="Cadet Photo"
                        onerror="this.src='{{ asset('images/default.png') }}'"
                    >

                    <div>

                        <div
                            id="modalName"
                            class="dm-profile-name"
                        >
                            —
                        </div>

                        <div class="dm-profile-meta">

                            <span id="modalTRB">
                                TRB: —
                            </span>

                            <span aria-hidden="true">
                                •
                            </span>

                            <span id="modalCourse">
                                —
                            </span>

                        </div>

                    </div>

                </div>


                {{-- SECTION 01 --}}

                <section class="dm-section">

                    <div class="dm-section-title">

                        <span class="dm-section-number">
                            01
                        </span>

                        <span>
                            Vessel Information
                        </span>

                    </div>


                    <div class="dm-form-grid">

                        <div class="dm-form-group">

                            <label
                                for="modalVessel"
                                class="dm-form-label"
                            >
                                Vessel Name
                            </label>

                            <input
                                type="text"
                                id="modalVessel"
                                class="dm-form-input"
                                placeholder="Enter vessel name"
                                autocomplete="off"
                            >

                        </div>


                        <div class="dm-form-group">

                            <label
                                for="modalCompany"
                                class="dm-form-label"
                            >
                                Company Name
                            </label>

                            <input
                                type="text"
                                id="modalCompany"
                                class="dm-form-input"
                                placeholder="Enter company name"
                                autocomplete="off"
                            >

                        </div>


                        <div class="dm-form-group full">

                            <label
                                for="modalDeploymentType"
                                class="dm-form-label"
                            >
                                Deployment Type
                            </label>

                            <select
                                id="modalDeploymentType"
                                class="dm-form-select"
                            >

                                <option value="Domestic">
                                    Domestic
                                </option>

                                <option value="International">
                                    International
                                </option>

                            </select>

                        </div>

                    </div>

                </section>


                <div class="dm-divider"></div>


                {{-- SECTION 02 --}}

                <section class="dm-section">

                    <div class="dm-section-title">

                        <span class="dm-section-number">
                            02
                        </span>

                        <span>
                            Embarkation
                        </span>

                    </div>


                    <div class="dm-form-grid">

                        <div class="dm-form-group">

                            <label
                                for="modalEmbarkPlace"
                                class="dm-form-label"
                            >
                                Embarkation Place
                            </label>

                            <input
                                type="text"
                                id="modalEmbarkPlace"
                                class="dm-form-input"
                                placeholder="Enter embarkation place"
                                autocomplete="off"
                            >

                        </div>


                        <div class="dm-form-group">

                            <label
                                for="modalDeployed"
                                class="dm-form-label"
                            >
                                Embarkation Date
                            </label>

                            <input
                                type="date"
                                id="modalDeployed"
                                class="dm-form-input"
                            >

                        </div>

                    </div>

                </section>


                <div class="dm-divider"></div>


                {{-- SECTION 03 --}}

                <section class="dm-section">

                    <div class="dm-section-title">

                        <span class="dm-section-number">
                            03
                        </span>

                        <span>
                            Disembarkation
                        </span>

                    </div>


                    <div class="dm-form-grid">

                        <div class="dm-form-group">

                            <label
                                for="modalDisembarkPlace"
                                class="dm-form-label"
                            >
                                Disembarkation Place
                            </label>

                            <input
                                type="text"
                                id="modalDisembarkPlace"
                                class="dm-form-input"
                                placeholder="Enter disembarkation place"
                                autocomplete="off"
                            >

                        </div>


                        <div class="dm-form-group">

                            <label
                                for="modalDisembarked"
                                class="dm-form-label"
                            >
                                Disembarkation Date
                            </label>

                            <input
                                type="date"
                                id="modalDisembarked"
                                class="dm-form-input"
                            >

                        </div>

                    </div>


                    {{-- SEA SERVICE DURATION --}}

                    <div class="dm-duration-card">

                        <div
                            class="dm-duration-icon"
                            aria-hidden="true"
                        >
                            ⚓
                        </div>

                        <div class="dm-duration-content">

                            <span class="dm-duration-label">
                                Duration of Sea Service
                            </span>

                            <strong id="modalDuration">
                                —
                            </strong>

                            <small id="modalDurationStatus">
                                Duration will be calculated after disembarkation
                            </small>

                        </div>

                    </div>

                </section>


                <div class="dm-divider"></div>


                {{-- SECTION 04 --}}

                <section class="dm-section">

                    <div class="dm-section-title">

                        <span class="dm-section-number">
                            04
                        </span>

                        <span>
                            Training Status
                        </span>

                    </div>


                    <div class="dm-form-grid">

                        <div class="dm-form-group full">

                            <label
                                for="modalStatus"
                                class="dm-form-label"
                            >
                                Deployment Status
                            </label>

                            <select
                                id="modalStatus"
                                class="dm-form-select"
                            >

                                <option value="Not Deployed">
                                    Not Deployed
                                </option>

                                <option value="Ongoing">
                                    Ongoing
                                </option>

                                <option value="Completed">
                                    Completed
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- PROGRESS --}}

                    <div class="dm-modal-progress">

                        <div class="dm-modal-progress-top">

                            <span>
                                Training Progress
                            </span>

                            <span
                                id="modalPercent"
                                class="dm-modal-progress-percent"
                            >
                                0%
                            </span>

                        </div>

                        <div
                            class="dm-modal-progress-track"
                            role="progressbar"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-valuenow="0"
                        >

                            <div
                                id="modalProgress"
                                class="dm-modal-progress-fill"
                                style="width:0%;"
                            ></div>

                        </div>

                    </div>

                </section>

            </div>


            {{-- MODAL FOOTER --}}

            <footer class="dm-modal-footer">

                <button
                    type="button"
                    class="dm-cancel-btn"
                    onclick="closeDeploymentModal()"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="saveDeploymentBtn"
                    class="dm-save-btn"
                    onclick="saveDeploymentChanges()"
                >
                    Save Changes
                </button>

            </footer>

        </div>

    </div>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>
        (() => {

            'use strict';


            /* =====================================================
               CONFIG
            ====================================================== */

            const CONFIG = {

                deploymentUrl: '/admin/deployment',

                defaultPhoto:
                    @json(asset('images/default.png')),

                reloadDelay: 1800,

                toastDuration: 1800

            };


            /* =====================================================
               DOM
            ====================================================== */

            const elements = {

                modal:
                    document.getElementById('deploymentModal'),

                modalId:
                    document.getElementById('modalId'),

                modalPhoto:
                    document.getElementById('modalPhoto'),

                modalName:
                    document.getElementById('modalName'),

                modalTRB:
                    document.getElementById('modalTRB'),

                modalCourse:
                    document.getElementById('modalCourse'),

                modalVessel:
                    document.getElementById('modalVessel'),

                modalCompany:
                    document.getElementById('modalCompany'),

                modalDeploymentType:
                    document.getElementById('modalDeploymentType'),

                modalEmbarkPlace:
                    document.getElementById('modalEmbarkPlace'),

                modalDeployed:
                    document.getElementById('modalDeployed'),

                modalDisembarkPlace:
                    document.getElementById('modalDisembarkPlace'),

                modalDisembarked:
                    document.getElementById('modalDisembarked'),

                modalDuration:
                    document.getElementById('modalDuration'),

                modalDurationStatus:
                    document.getElementById('modalDurationStatus'),

                modalStatus:
                    document.getElementById('modalStatus'),

                modalPercent:
                    document.getElementById('modalPercent'),

                modalProgress:
                    document.getElementById('modalProgress'),

                saveButton:
                    document.getElementById('saveDeploymentBtn'),

                searchInput:
                    document.getElementById('searchInput'),

                dateFrom:
                    document.getElementById('dateFrom'),

                dateTo:
                    document.getElementById('dateTo'),

                tableBody:
                    document.getElementById('deploymentTableBody'),

                filteredEmptyRow:
                    document.getElementById('filteredEmptyRow'),

                successToast:
                    document.getElementById('successToast')

            };


            /* =====================================================
               CSRF
            ====================================================== */

            const csrfToken =
                document.querySelector(
                    'meta[name="csrf-token"]'
                )?.getAttribute('content') || '';


            /* =====================================================
               INITIALIZE
            ====================================================== */

            document.addEventListener(
                'DOMContentLoaded',
                initialize
            );


            function initialize() {

                setupFilters();

                setupModalEvents();

                setupDropdownEvents();

                setupDragToScroll();

                filterDeploymentTable();

            }


            /* =====================================================
               FILTERS
            ====================================================== */

            function setupFilters() {

                document
                    .querySelectorAll(
                        '.dm-dropdown-menu input[type="checkbox"]'
                    )
                    .forEach(input => {

                        input.addEventListener(
                            'change',
                            filterDeploymentTable
                        );

                    });


                elements.searchInput?.addEventListener(
                    'input',
                    filterDeploymentTable
                );


                elements.dateFrom?.addEventListener(
                    'change',
                    filterDeploymentTable
                );


                elements.dateTo?.addEventListener(
                    'change',
                    filterDeploymentTable
                );

            }


            function getCheckedValues(filterType) {

                return Array.from(
                    document.querySelectorAll(
                        `.dm-dropdown-menu input[data-filter="${filterType}"]:checked`
                    )
                )
                .map(input =>
                    input.value
                        .toLowerCase()
                        .trim()
                );

            }


            function filterDeploymentTable() {

                const courses =
                    getCheckedValues('course');

                const batches =
                    getCheckedValues('batch');

                const statuses =
                    getCheckedValues('status');

                const search =
                    elements.searchInput?.value
                        ?.toLowerCase()
                        .trim() || '';

                const from =
                    elements.dateFrom?.value || '';

                const to =
                    elements.dateTo?.value || '';


                const rows =
                    Array.from(
                        elements.tableBody?.querySelectorAll(
                            'tr[data-course]'
                        ) || []
                    );


                let visibleRows = 0;


                rows.forEach(row => {

                    const course =
                        row.dataset.course || '';

                    const batch =
                        row.dataset.batch || '';

                    const status =
                        row.dataset.status || '';

                    const deploymentDate =
                        row.dataset.deploymentDate || '';

                    const rowText =
                        row.innerText
                            .toLowerCase();


                    const matchesCourse =
                        !courses.length ||
                        courses.includes(course);


                    const matchesBatch =
                        !batches.length ||
                        batches.includes(batch);


                    const matchesStatus =
                        !statuses.length ||
                        statuses.some(selectedStatus =>
                            status.includes(selectedStatus)
                        );


                    const matchesSearch =
                        !search ||
                        rowText.includes(search);


                    const matchesDate =
                        matchesDateRange(
                            deploymentDate,
                            from,
                            to
                        );


                    const visible =
                        matchesCourse &&
                        matchesBatch &&
                        matchesStatus &&
                        matchesSearch &&
                        matchesDate;


                    row.style.display =
                        visible
                            ? ''
                            : 'none';


                    if (visible) {
                        visibleRows++;
                    }

                });


                updateFilteredEmptyState(
                    rows.length,
                    visibleRows
                );

            }


            function matchesDateRange(
                deploymentDate,
                from,
                to
            ) {

                if (!from && !to) {
                    return true;
                }

                if (!deploymentDate) {
                    return false;
                }

                const current =
                    normalizeDate(deploymentDate);

                const minimum =
                    from
                        ? normalizeDate(from)
                        : null;

                const maximum =
                    to
                        ? normalizeDate(to)
                        : null;


                if (
                    minimum &&
                    current < minimum
                ) {
                    return false;
                }


                if (
                    maximum &&
                    current > maximum
                ) {
                    return false;
                }


                return true;

            }


            function normalizeDate(value) {

                if (!value) {
                    return null;
                }


                /*
                 * Only use YYYY-MM-DD.
                 *
                 * This prevents browser timezone
                 * conversion from changing the date.
                 */
                const clean =
                    String(value)
                        .substring(0, 10);


                const parts =
                    clean.split('-');


                if (parts.length !== 3) {
                    return null;
                }


                const year =
                    Number(parts[0]);

                const month =
                    Number(parts[1]);

                const day =
                    Number(parts[2]);


                if (
                    !year ||
                    !month ||
                    !day
                ) {
                    return null;
                }


                return new Date(
                    year,
                    month - 1,
                    day
                ).getTime();

            }


            function updateFilteredEmptyState(
                totalRows,
                visibleRows
            ) {

                if (!elements.filteredEmptyRow) {
                    return;
                }


                const show =
                    totalRows > 0 &&
                    visibleRows === 0;


                elements.filteredEmptyRow.style.display =
                    show
                        ? ''
                        : 'none';

            }


            /* =====================================================
               DROPDOWNS
            ====================================================== */

            window.toggleDMFilter =
                function(button) {

                    const dropdown =
                        button.closest(
                            '.dm-filter-dropdown'
                        );


                    if (!dropdown) {
                        return;
                    }


                    const isOpen =
                        dropdown.classList.contains('open');


                    closeAllDropdowns();


                    if (!isOpen) {

                        dropdown.classList.add(
                            'open'
                        );


                        button.setAttribute(
                            'aria-expanded',
                            'true'
                        );

                    }

                };


            function closeAllDropdowns() {

                document
                    .querySelectorAll(
                        '.dm-filter-dropdown'
                    )
                    .forEach(dropdown => {

                        dropdown.classList.remove(
                            'open'
                        );


                        dropdown
                            .querySelector(
                                '.dm-filter-button'
                            )
                            ?.setAttribute(
                                'aria-expanded',
                                'false'
                            );

                    });

            }


            function setupDropdownEvents() {

                document.addEventListener(
                    'click',
                    event => {

                        if (
                            !event.target.closest(
                                '.dm-filter-dropdown'
                            )
                        ) {

                            closeAllDropdowns();

                        }

                    }
                );

            }


            /* =====================================================
               SEA SERVICE DURATION
            ====================================================== */

            function calculateSeaServiceDuration(
                embarkationDate,
                disembarkationDate = null
            ) {

                /*
                 * IMPORTANT:
                 *
                 * Never calculate duration using today.
                 *
                 * Sea Service Duration is only available
                 * after the cadet has disembarked.
                 */
                if (
                    !embarkationDate ||
                    !disembarkationDate
                ) {

                    return {

                        text: '—',

                        status:
                            'Duration will be calculated after disembarkation'

                    };

                }


                const start =
                    parseDate(embarkationDate);


                const end =
                    parseDate(disembarkationDate);


                if (!start || !end) {

                    return {

                        text: '—',

                        status:
                            'Invalid deployment dates'

                    };

                }


                if (end < start) {

                    return {

                        text: '—',

                        status:
                            'Disembarkation date cannot be before embarkation date'

                    };

                }


                let months =
                    calculateFullMonths(
                        start,
                        end
                    );


                let monthDate =
                    addMonthsSafely(
                        start,
                        months
                    );


                if (monthDate > end) {

                    months--;

                    monthDate =
                        addMonthsSafely(
                            start,
                            Math.max(
                                0,
                                months
                            )
                        );

                }


                const days =
                    Math.floor(
                        (
                            end.getTime() -
                            monthDate.getTime()
                        ) /
                        86400000
                    );


                const parts = [];


                if (months > 0) {

                    parts.push(
                        `${months} ${
                            months === 1
                                ? 'Month'
                                : 'Months'
                        }`
                    );

                }


                if (days > 0) {

                    parts.push(
                        `${days} ${
                            days === 1
                                ? 'Day'
                                : 'Days'
                        }`
                    );

                }


                return {

                    text:
                        parts.length
                            ? parts.join(', ')
                            : '0 Days',

                    status:
                        'Completed sea service'

                };

            }


            function parseDate(value) {

                if (!value) {
                    return null;
                }


                const clean =
                    String(value)
                        .substring(0, 10);


                const parts =
                    clean.split('-');


                if (parts.length !== 3) {
                    return null;
                }


                const year =
                    Number(parts[0]);

                const month =
                    Number(parts[1]);

                const day =
                    Number(parts[2]);


                if (
                    !year ||
                    !month ||
                    !day
                ) {
                    return null;
                }


                /*
                 * Local date.
                 *
                 * Avoid:
                 * new Date('2026-02-01')
                 *
                 * because that can be interpreted as UTC
                 * and shift the displayed date.
                 */
                const date =
                    new Date(
                        year,
                        month - 1,
                        day
                    );


                if (
                    Number.isNaN(
                        date.getTime()
                    )
                ) {
                    return null;
                }


                return date;

            }


            function calculateFullMonths(
                start,
                end
            ) {

                let months =
                    (
                        end.getFullYear() -
                        start.getFullYear()
                    ) * 12 +
                    (
                        end.getMonth() -
                        start.getMonth()
                    );


                const candidate =
                    addMonthsSafely(
                        start,
                        months
                    );


                if (candidate > end) {
                    months--;
                }


                return Math.max(
                    0,
                    months
                );

            }


            function addMonthsSafely(
                date,
                months
            ) {

                const result =
                    new Date(date);


                const originalDay =
                    result.getDate();


                result.setDate(1);


                result.setMonth(
                    result.getMonth() +
                    months
                );


                const lastDay =
                    new Date(
                        result.getFullYear(),
                        result.getMonth() + 1,
                        0
                    ).getDate();


                result.setDate(
                    Math.min(
                        originalDay,
                        lastDay
                    )
                );


                return result;

            }


            /* =====================================================
               UPDATE MODAL DURATION
            ====================================================== */

            function updateModalDuration() {

                const embarkation =
                    elements.modalDeployed?.value || '';


                const disembarkation =
                    elements.modalDisembarked?.value || '';


                /*
                 * No disembarkation date =
                 * no completed sea-service duration.
                 */
                const result =
                    calculateSeaServiceDuration(
                        embarkation,
                        disembarkation || null
                    );


                if (elements.modalDuration) {

                    elements.modalDuration.textContent =
                        result.text;

                }


                if (elements.modalDurationStatus) {

                    elements.modalDurationStatus.textContent =
                        result.status;

                }

            }


            /* =====================================================
               MODAL EVENTS
            ====================================================== */

            function setupModalEvents() {

                /*
                 * Update duration immediately when either
                 * date changes.
                 */
                elements.modalDeployed?.addEventListener(
                    'change',
                    updateModalDuration
                );


                elements.modalDisembarked?.addEventListener(
                    'change',
                    updateModalDuration
                );


                document.addEventListener(
                    'keydown',
                    event => {

                        if (
                            event.key === 'Escape' &&
                            elements.modal?.classList.contains('show')
                        ) {

                            closeDeploymentModal();

                        }

                    }
                );


                elements.modal?.addEventListener(
                    'click',
                    event => {

                        if (
                            event.target === elements.modal
                        ) {

                            closeDeploymentModal();

                        }

                    }
                );

            }


            /* =====================================================
               OPEN MODAL
            ====================================================== */

            window.openDeploymentModal =
                async function(cadet) {

                    if (!cadet?.id) {

                        showError(
                            'Cadet ID is missing.'
                        );

                        return;

                    }


                    resetModal();


                    elements.modalId.value =
                        cadet.id;


                    elements.modalName.textContent =
                        cadet.full_name ||
                        'Unknown Cadet';


                    elements.modalTRB.textContent =
                        `TRB: ${
                            cadet.trb_control_number ||
                            '—'
                        }`;


                    elements.modalCourse.textContent =
                        cadet.course ||
                        '—';


                    setCadetPhoto(
                        cadet.photo
                    );


                    openModal();


                    try {

                        await loadDeployment(
                            cadet.id
                        );

                    } catch (error) {

                        console.error(
                            'Deployment loading error:',
                            error
                        );


                        showError(
                            error.message ||
                            'Unable to load deployment information.'
                        );

                    }

                };


            /* =====================================================
               RESET MODAL
            ====================================================== */

            function resetModal() {

                setValue(
                    elements.modalVessel,
                    ''
                );


                setValue(
                    elements.modalCompany,
                    ''
                );


                setValue(
                    elements.modalDeploymentType,
                    'Domestic'
                );


                setValue(
                    elements.modalEmbarkPlace,
                    ''
                );


                setValue(
                    elements.modalDeployed,
                    ''
                );


                setValue(
                    elements.modalDisembarkPlace,
                    ''
                );


                setValue(
                    elements.modalDisembarked,
                    ''
                );


                setValue(
                    elements.modalStatus,
                    'Not Deployed'
                );


                updateModalProgress(0);

                updateModalDuration();

            }


            function setValue(
                element,
                value
            ) {

                if (element) {
                    element.value = value;
                }

            }


            /* =====================================================
               PHOTO
            ====================================================== */

            function setCadetPhoto(photo) {

                if (
                    !photo ||
                    typeof photo !== 'string'
                ) {

                    elements.modalPhoto.src =
                        CONFIG.defaultPhoto;

                    return;

                }


                const normalized =
                    photo.replace(
                        /^\/+/,
                        ''
                    );


                const photoUrl =
                    normalized.startsWith(
                        'storage/'
                    )
                        ? `/${normalized}`
                        : `/storage/${normalized}`;


                elements.modalPhoto.src =
                    photoUrl;

            }


            /* =====================================================
               LOAD DEPLOYMENT
            ====================================================== */

            async function loadDeployment(
                cadetId
            ) {

                const response =
                    await fetch(
                        `${CONFIG.deploymentUrl}/${cadetId}`,
                        {
                            method: 'GET',

                            headers: {
                                Accept:
                                    'application/json'
                            },

                            credentials:
                                'same-origin'
                        }
                    );


                const data =
                    await parseResponse(
                        response
                    );


                const deployment =
                    data.deployment || {};


                populateDeployment(
                    deployment
                );

            }


            /* =====================================================
               POPULATE DEPLOYMENT
            ====================================================== */

            function populateDeployment(
                deployment
            ) {

                setValue(
                    elements.modalVessel,
                    deployment.vessel_name || ''
                );


                setValue(
                    elements.modalCompany,
                    deployment.company_name || ''
                );


                setValue(
                    elements.modalDeploymentType,
                    deployment.deployment_type ||
                    'Domestic'
                );


                setValue(
                    elements.modalEmbarkPlace,
                    deployment.embarkation_place || ''
                );


                /*
                 * IMPORTANT DATE FIX
                 *
                 * Only take the first 10 characters.
                 *
                 * Database:
                 * 2026-02-01
                 *
                 * becomes:
                 * 2026-02-01
                 *
                 * No timezone conversion.
                 */
                setValue(
                    elements.modalDeployed,
                    formatInputDate(
                        deployment.date_deployed
                    )
                );


                setValue(
                    elements.modalDisembarkPlace,
                    deployment.disembarkation_place || ''
                );


                setValue(
                    elements.modalDisembarked,
                    formatInputDate(
                        deployment.date_disembarked
                    )
                );


                setValue(
                    elements.modalStatus,
                    deployment.status ||
                    'Not Deployed'
                );


                /*
                 * Duration is recalculated from
                 * the two actual input dates.
                 */
                updateModalDuration();


                updateModalProgress(
                    deployment.percentage || 0
                );

            }


            /* =====================================================
               INPUT DATE
            ====================================================== */

            function formatInputDate(value) {

                if (!value) {
                    return '';
                }


                /*
                 * If Laravel returns:
                 *
                 * 2026-02-01
                 * 2026-02-01 00:00:00
                 * 2026-02-01T00:00:00.000000Z
                 *
                 * only use:
                 *
                 * 2026-02-01
                 */
                const clean =
                    String(value)
                        .substring(0, 10);


                /*
                 * Make sure it really is
                 * YYYY-MM-DD.
                 */
                if (
                    !/^\d{4}-\d{2}-\d{2}$/.test(
                        clean
                    )
                ) {

                    return '';

                }


                return clean;

            }


            /* =====================================================
               PROGRESS
            ====================================================== */

            function updateModalProgress(
                percentage
            ) {

                let value =
                    Number(percentage);


                if (
                    Number.isNaN(value)
                ) {
                    value = 0;
                }


                value =
                    Math.max(
                        0,
                        Math.min(
                            100,
                            value
                        )
                    );


                const rounded =
                    Math.round(value);


                if (elements.modalProgress) {

                    elements.modalProgress.style.width =
                        `${rounded}%`;


                    elements.modalProgress.style.background =
                        rounded >= 100
                            ? 'linear-gradient(90deg, #16a34a, #22c55e)'
                            : 'linear-gradient(90deg, #6366f1, #8b5cf6)';

                }


                if (elements.modalPercent) {

                    elements.modalPercent.textContent =
                        `${rounded}%`;

                }


                const progressTrack =
                    elements.modalProgress
                        ?.parentElement;


                progressTrack?.setAttribute(
                    'aria-valuenow',
                    String(rounded)
                );

            }


            /* =====================================================
               OPEN / CLOSE MODAL
            ====================================================== */

            function openModal() {

                elements.modal?.classList.add(
                    'show'
                );


                document.body.classList.add(
                    'dm-modal-open'
                );


                requestAnimationFrame(() => {

                    elements.modalVessel?.focus();

                });

            }


            window.closeDeploymentModal =
                function() {

                    elements.modal?.classList.remove(
                        'show'
                    );


                    document.body.classList.remove(
                        'dm-modal-open'
                    );

                };


            /* =====================================================
               SAVE DEPLOYMENT
            ====================================================== */

            window.saveDeploymentChanges =
                async function() {

                    const id =
                        elements.modalId?.value;


                    if (!id) {

                        showError(
                            'Cadet ID is missing.'
                        );

                        return;

                    }


                    if (
                        !validateDeploymentDates()
                    ) {

                        return;

                    }


                    if (
                        elements.saveButton
                            ?.classList.contains('loading')
                    ) {

                        return;

                    }


                    setSavingState(true);


                    try {

                        const payload =
                            buildDeploymentPayload();


                        const response =
                            await fetch(
                                `${CONFIG.deploymentUrl}/${id}`,
                                {
                                    method: 'PUT',

                                    headers: {

                                        'Content-Type':
                                            'application/json',

                                        'X-CSRF-TOKEN':
                                            csrfToken,

                                        Accept:
                                            'application/json'

                                    },

                                    credentials:
                                        'same-origin',

                                    body:
                                        JSON.stringify(
                                            payload
                                        )

                                }
                            );


                        const data =
                            await parseResponse(
                                response
                            );


                        if (
                            !data.success
                        ) {

                            throw new Error(
                                data.message ||
                                'Unable to update deployment.'
                            );

                        }


                        closeDeploymentModal();

                        showDeploymentToast();


                        setTimeout(
                            () => {

                                window.location.reload();

                            },
                            CONFIG.reloadDelay
                        );


                    } catch (error) {

                        console.error(
                            'Deployment update error:',
                            error
                        );


                        showError(
                            error.message ||
                            'Unable to update deployment.'
                        );


                    } finally {

                        setSavingState(false);

                    }

                };


            /* =====================================================
               BUILD PAYLOAD
            ====================================================== */

            function buildDeploymentPayload() {

                return {

                    vessel_name:
                        elements.modalVessel?.value
                            ?.trim() || '',

                    company:
                        elements.modalCompany?.value
                            ?.trim() || '',

                    deployment_type:
                        elements.modalDeploymentType?.value ||
                        'Domestic',

                    embarkation_place:
                        elements.modalEmbarkPlace?.value
                            ?.trim() || '',

                    date_deployed:
                        elements.modalDeployed?.value ||
                        '',

                    disembarkation_place:
                        elements.modalDisembarkPlace?.value
                            ?.trim() || '',

                    date_disembarked:
                        elements.modalDisembarked?.value ||
                        '',

                    deployment_status:
                        elements.modalStatus?.value ||
                        'Not Deployed'

                };

            }


            /* =====================================================
               DATE VALIDATION
            ====================================================== */

            function validateDeploymentDates() {

                const embarkation =
                    elements.modalDeployed?.value;


                const disembarkation =
                    elements.modalDisembarked?.value;


                /*
                 * Both dates are optional.
                 *
                 * Duration will remain —
                 * if disembarkation is empty.
                 */
                if (
                    !embarkation ||
                    !disembarkation
                ) {

                    return true;

                }


                const start =
                    normalizeDate(
                        embarkation
                    );


                const end =
                    normalizeDate(
                        disembarkation
                    );


                if (
                    start === null ||
                    end === null
                ) {

                    showError(
                        'Please enter valid deployment dates.'
                    );

                    return false;

                }


                if (end < start) {

                    showError(
                        'Disembarkation date cannot be earlier than embarkation date.'
                    );

                    return false;

                }


                return true;

            }


            /* =====================================================
               RESPONSE
            ====================================================== */

            async function parseResponse(
                response
            ) {

                let data = null;


                try {

                    data =
                        await response.json();

                } catch (error) {

                    throw new Error(
                        `Server returned an invalid response (${response.status}).`
                    );

                }


                if (!response.ok) {

                    throw new Error(
                        data?.message ||
                        `Request failed with status ${response.status}.`
                    );

                }


                return data;

            }


            /* =====================================================
               SAVE STATE
            ====================================================== */

            function setSavingState(
                saving
            ) {

                if (
                    !elements.saveButton
                ) {
                    return;
                }


                elements.saveButton.disabled =
                    saving;


                elements.saveButton.classList.toggle(
                    'loading',
                    saving
                );


                elements.saveButton.textContent =
                    saving
                        ? 'Saving...'
                        : 'Save Changes';

            }


            /* =====================================================
               TOAST
            ====================================================== */

            function showDeploymentToast() {

                if (
                    !elements.successToast
                ) {
                    return;
                }


                elements.successToast.classList.add(
                    'show'
                );


                setTimeout(
                    () => {

                        elements.successToast.classList.remove(
                            'show'
                        );

                    },
                    CONFIG.toastDuration
                );

            }


            /* =====================================================
               ERROR
            ====================================================== */

            function showError(
                message
            ) {

                window.alert(
                    message
                );

            }


            /* =====================================================
               DRAG TO SCROLL
            ====================================================== */

            function setupDragToScroll() {

                const container =
                    document.querySelector(
                        '.dm-table-scroll'
                    );


                if (!container) {
                    return;
                }


                let dragging = false;

                let startX = 0;

                let initialScroll = 0;


                container.addEventListener(
                    'mousedown',
                    event => {

                        if (
                            event.target.closest(
                                'button, input, select, a'
                            )
                        ) {
                            return;
                        }


                        dragging = true;


                        startX =
                            event.pageX -
                            container.offsetLeft;


                        initialScroll =
                            container.scrollLeft;


                        container.classList.add(
                            'is-dragging'
                        );

                    }
                );


                container.addEventListener(
                    'mousemove',
                    event => {

                        if (!dragging) {
                            return;
                        }


                        event.preventDefault();


                        const currentX =
                            event.pageX -
                            container.offsetLeft;


                        const distance =
                            (
                                currentX -
                                startX
                            ) * 1.5;


                        container.scrollLeft =
                            initialScroll -
                            distance;

                    }
                );


                const stopDragging = () => {

                    dragging = false;


                    container.classList.remove(
                        'is-dragging'
                    );

                };


                container.addEventListener(
                    'mouseup',
                    stopDragging
                );


                container.addEventListener(
                    'mouseleave',
                    stopDragging
                );


                container.addEventListener(
                    'dragstart',
                    event => {

                        event.preventDefault();

                    }
                );

            }

        })();
    </script>

@endsection