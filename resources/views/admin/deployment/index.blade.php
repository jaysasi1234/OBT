@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/deployment/deployment.css'])

<div class="dm-page">

```
{{-- =====================================================
     PAGE HEADER
====================================================== --}}

<div class="dm-header">

    <div class="dm-header-content">

        <div class="dm-header-eyebrow">
            <span class="dm-header-eyebrow-dot"></span>
            ADMINISTRATION
        </div>

        <h1>
            Deployment Monitoring
        </h1>

        <p>
            Monitor cadet deployment information, vessel assignments,
            progress, and training status.
        </p>

    </div>

    <div class="dm-header-icon" aria-hidden="true">
        🚢
    </div>

</div>


{{-- =====================================================
     AJAX CONTENT
====================================================== --}}

<div id="deploymentPageContent">

    {{-- =================================================
         STATISTICS
    ================================================== --}}

    <div class="dm-stats" id="deploymentStats">

        <div class="dm-stat dm-stat-blue">

            <div class="dm-stat-top">

                <div class="dm-stat-label">
                    Total Deployed
                </div>

                <div class="dm-stat-icon">
                    🚢
                </div>

            </div>

            <div class="dm-stat-value">
                {{ $totalDeployed }}
            </div>

            <div class="dm-stat-description">
                Cadets with deployment records
            </div>

        </div>


        <div class="dm-stat dm-stat-cyan">

            <div class="dm-stat-top">

                <div class="dm-stat-label">
                    Ongoing
                </div>

                <div class="dm-stat-icon">
                    ⚓
                </div>

            </div>

            <div class="dm-stat-value">
                {{ $ongoing }}
            </div>

            <div class="dm-stat-description">
                Currently onboard training
            </div>

        </div>


        <div class="dm-stat dm-stat-green">

            <div class="dm-stat-top">

                <div class="dm-stat-label">
                    Completed
                </div>

                <div class="dm-stat-icon">
                    ✓
                </div>

            </div>

            <div class="dm-stat-value">
                {{ $completed }}
            </div>

            <div class="dm-stat-description">
                Successfully completed
            </div>

        </div>


        <div class="dm-stat dm-stat-gray">

            <div class="dm-stat-top">

                <div class="dm-stat-label">
                    Not Deployed
                </div>

                <div class="dm-stat-icon">
                    📋
                </div>

            </div>

            <div class="dm-stat-value">
                {{ $notDeployed }}
            </div>

            <div class="dm-stat-description">
                Awaiting deployment
            </div>

        </div>

    </div>


    {{-- =================================================
         TABLE CARD
    ================================================== --}}

    <div
        class="dm-table-card"
        id="deploymentResults"
    >

        <div class="dm-table-header">

            <div class="dm-table-title">

                <div class="dm-table-title-main">
                    <span class="dm-table-title-icon">▣</span>

                    <div>
                        <strong>
                            Cadet Deployment Records
                        </strong>

                        <span>
                            Review and manage deployment information
                        </span>
                    </div>
                </div>

            </div>

            <div class="dm-table-hint">
                <span>↔</span>
                Swipe or scroll to view all columns
            </div>

        </div>


        {{-- =================================================
             TABLE WRAPPER
        ================================================== --}}

        <div class="dm-table-scroll">

            <table class="dm-table">

                <thead>

                    <tr>

                        <th>TRB No.</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Vessel</th>
                        <th>Company</th>
                        <th>Deployment Type</th>
                        <th>Embarkation Place</th>
                        <th>Embarkation Date</th>
                        <th>Disembarkation Place</th>
                        <th>Disembarkation Date</th>
                        <th>Duration of Sea Service</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                @forelse($cadets as $cadet)

                    @php

                        $deployment = $cadet->deployment;

                        $status = strtolower(
                            trim(
                                optional($deployment)->status
                                ?? 'Not Deployed'
                            )
                        );

                        $percent = (int) (
                            optional($deployment)->percentage
                            ?? 0
                        );

                        $percent = max(
                            0,
                            min(100, $percent)
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | RAW DEPLOYMENT DATES
                        |--------------------------------------------------------------------------
                        */

                        $rawEmbarkationDate =
                            $deployment?->getRawOriginal(
                                'date_deployed'
                            );

                        $rawDisembarkationDate =
                            $deployment?->getRawOriginal(
                                'date_disembarked'
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | DURATION OF SEA SERVICE
                        |--------------------------------------------------------------------------
                        */

                        $durationOfSeaService = null;

                        if (
                            $rawEmbarkationDate &&
                            $rawDisembarkationDate
                        ) {

                            try {

                                $embarkDate =
                                    \Carbon\Carbon::createFromFormat(
                                        'Y-m-d',
                                        substr(
                                            (string) $rawEmbarkationDate,
                                            0,
                                            10
                                        )
                                    );

                                $disembarkDate =
                                    \Carbon\Carbon::createFromFormat(
                                        'Y-m-d',
                                        substr(
                                            (string) $rawDisembarkationDate,
                                            0,
                                            10
                                        )
                                    );


                                if (
                                    $disembarkDate->greaterThanOrEqualTo(
                                        $embarkDate
                                    )
                                ) {

                                    $difference =
                                        $embarkDate->diff(
                                            $disembarkDate
                                        );

                                    $months =
                                        (
                                            $difference->y * 12
                                        )
                                        +
                                        $difference->m;

                                    $days =
                                        $difference->d;

                                    $durationParts = [];


                                    if ($months > 0) {

                                        $durationParts[] =
                                            $months .
                                            ' ' .
                                            (
                                                $months === 1
                                                    ? 'Month'
                                                    : 'Months'
                                            );

                                    }


                                    if ($days > 0) {

                                        $durationParts[] =
                                            $days .
                                            ' ' .
                                            (
                                                $days === 1
                                                    ? 'Day'
                                                    : 'Days'
                                            );

                                    }


                                    $durationOfSeaService =
                                        !empty($durationParts)
                                            ? implode(
                                                ', ',
                                                $durationParts
                                            )
                                            : '0 Days';

                                }

                            } catch (\Throwable $e) {

                                $durationOfSeaService = null;

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | FORMATTED DATES
                        |--------------------------------------------------------------------------
                        */

                        $formattedEmbarkationDate = null;
                        $formattedDisembarkationDate = null;


                        if ($rawEmbarkationDate) {

                            try {

                                $formattedEmbarkationDate =
                                    \Carbon\Carbon::createFromFormat(
                                        'Y-m-d',
                                        substr(
                                            (string) $rawEmbarkationDate,
                                            0,
                                            10
                                        )
                                    )->format('M d, Y');

                            } catch (\Throwable $e) {

                                $formattedEmbarkationDate = null;

                            }

                        }


                        if ($rawDisembarkationDate) {

                            try {

                                $formattedDisembarkationDate =
                                    \Carbon\Carbon::createFromFormat(
                                        'Y-m-d',
                                        substr(
                                            (string) $rawDisembarkationDate,
                                            0,
                                            10
                                        )
                                    )->format('M d, Y');

                            } catch (\Throwable $e) {

                                $formattedDisembarkationDate = null;

                            }

                        }

                    @endphp


                    <tr>

                        {{-- TRB --}}

                        <td>

                            <strong class="dm-trb">
                                {{ $cadet->trb_control_number }}
                            </strong>

                        </td>


                        {{-- NAME --}}

                        <td>

                            <div class="dm-cadet-name">
                                {{ $cadet->full_name }}
                            </div>

                        </td>


                        {{-- COURSE --}}

                        <td>

                            <span class="dm-course">
                                {{ strtoupper($cadet->course) }}
                            </span>

                        </td>


                        {{-- BATCH --}}

                        <td>

                            <span class="dm-batch">
                                {{
                                    optional($cadet->batch)->batch_year
                                    ?? 'No Batch'
                                }}
                            </span>

                        </td>


                        {{-- VESSEL --}}

                        <td>

                            <span class="dm-cell-text">
                                {{ $deployment?->vessel_name ?? '—' }}
                            </span>

                        </td>


                        {{-- COMPANY --}}

                        <td>

                            <span class="dm-cell-text">
                                {{ $deployment?->company_name ?? '—' }}
                            </span>

                        </td>


                        {{-- DEPLOYMENT TYPE --}}

                        <td>

                            @if(
                                ($deployment?->deployment_type ?? '')
                                === 'International'
                            )

                                <span class="dm-badge dm-badge-blue">
                                    <span>🌍</span>
                                    International
                                </span>

                            @elseif(
                                ($deployment?->deployment_type ?? '')
                                === 'Domestic'
                            )

                                <span class="dm-badge dm-badge-green">
                                    <span>🇵🇭</span>
                                    Domestic
                                </span>

                            @else

                                <span class="dm-badge dm-badge-gray">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- EMBARKATION PLACE --}}

                        <td>

                            <span class="dm-cell-text">
                                {{
                                    $deployment?->embarkation_place
                                    ?? '—'
                                }}
                            </span>

                        </td>


                        {{-- EMBARKATION DATE --}}

                        <td
                            data-date="{{
                                $rawEmbarkationDate ?? ''
                            }}"
                        >

                            @if($formattedEmbarkationDate)

                                <span class="dm-date">
                                    {{ $formattedEmbarkationDate }}
                                </span>

                            @else

                                <span class="dm-empty-value">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- DISEMBARKATION PLACE --}}

                        <td>

                            <span class="dm-cell-text">
                                {{
                                    $deployment?->disembarkation_place
                                    ?? '—'
                                }}
                            </span>

                        </td>


                        {{-- DISEMBARKATION DATE --}}

                        <td>

                            @if($formattedDisembarkationDate)

                                <span class="dm-date">
                                    {{ $formattedDisembarkationDate }}
                                </span>

                            @else

                                <span class="dm-empty-value">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- DURATION --}}

                        <td>

                            @if($durationOfSeaService)

                                <strong class="dm-sea-duration">
                                    {{ $durationOfSeaService }}
                                </strong>

                            @else

                                <span class="dm-empty-value">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- PROGRESS --}}

                        <td>

                            <div class="dm-progress">

                                <div class="dm-progress-top">

                                    <span>
                                        Training
                                    </span>

                                    <span class="dm-progress-value">
                                        {{ $percent }}%
                                    </span>

                                </div>

                                <div class="dm-progress-track">

                                    <div
                                        class="dm-progress-fill {{
                                            $percent >= 100
                                                ? 'complete'
                                                : ''
                                        }}"
                                        style="width: {{ $percent }}%;"
                                    ></div>

                                </div>

                            </div>

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($status === 'ongoing')

                                <span class="dm-badge dm-badge-blue">
                                    <span>⚓</span>
                                    Ongoing
                                </span>

                            @elseif($status === 'completed')

                                <span class="dm-badge dm-badge-green">
                                    <span>✓</span>
                                    Completed
                                </span>

                            @else

                                <span class="dm-badge dm-badge-gray">
                                    <span>○</span>
                                    Not Deployed
                                </span>

                            @endif

                        </td>


                        {{-- ACTION --}}

                        <td>

                            <button
                                type="button"
                                class="dm-view-btn"
                                onclick="openDeploymentModal(@js($cadet))"
                            >
                                <span>👁</span>
                                View
                            </button>

                        </td>

                    </tr>


                @empty

                    <tr>

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
                                There are currently no cadets matching
                                the selected filters.
                            </span>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}

        @if($cadets->hasPages())

            <div class="dm-pagination-wrapper">

                <div class="dm-pagination-info">

                    Showing

                    <strong>
                        {{ $cadets->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $cadets->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $cadets->total() }}
                    </strong>

                    cadets

                </div>


                <div class="dm-pagination-links">

                    {{ $cadets->withQueryString()->links() }}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =====================================================
     FILTER PANEL
====================================================== --}}

<div class="dm-filter-panel">

    <div class="dm-filter-header">

        <div class="dm-filter-title">

            <div class="dm-filter-title-icon">
                ⚙
            </div>

            <div>
                <strong>Filters</strong>

                <span>
                    Refine deployment records
                </span>
            </div>

        </div>

        <button
            type="button"
            class="dm-clear-filters"
            onclick="clearDeploymentFilters()"
        >
            Clear filters
        </button>

    </div>


    <div class="dm-filter-grid">

        {{-- COURSE --}}

        <div class="dm-filter-dropdown">

            <button
                type="button"
                class="dm-filter-button"
                onclick="toggleDMFilter(this, 'courseMenu')"
            >

                <span>
                    Courses
                </span>

                <span class="dm-filter-arrow">
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
                            value="{{
                                strtolower(
                                    trim(
                                        $course->course
                                    )
                                )
                            }}"
                        >

                        <span>
                            {{ $course->course }}
                        </span>

                    </label>

                @endforeach

            </div>

        </div>


        {{-- BATCH --}}

        <div class="dm-filter-dropdown">

            <button
                type="button"
                class="dm-filter-button"
                onclick="toggleDMFilter(this, 'batchMenu')"
            >

                <span>
                    Batches
                </span>

                <span class="dm-filter-arrow">
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
                            value="{{
                                strtolower(
                                    trim(
                                        $batch->batch_year
                                    )
                                )
                            }}"

                        >

                        <span>
                            {{ $batch->batch_year }}
                        </span>

                    </label>

                @endforeach

            </div>

        </div>


        {{-- STATUS --}}

        <div class="dm-filter-dropdown">

            <button
                type="button"
                class="dm-filter-button"
                onclick="toggleDMFilter(this, 'statusMenu')"
            >

                <span>
                    Status
                </span>

                <span class="dm-filter-arrow">
                    ▼
                </span>

            </button>


            <div
                id="statusMenu"
                class="dm-dropdown-menu"
            >

                <label class="dm-check-option">

                    <input
                        type="checkbox"
                        value="ongoing"
                    >

                    <span>
                        Ongoing
                    </span>

                </label>


                <label class="dm-check-option">

                    <input
                        type="checkbox"
                        value="completed"
                    >

                    <span>
                        Completed
                    </span>

                </label>


                <label class="dm-check-option">

                    <input
                        type="checkbox"
                        value="not deployed"
                    >

                    <span>
                        Not Deployed
                    </span>

                </label>

            </div>

        </div>


        {{-- SEARCH --}}

        <div class="dm-filter-field">

            <span class="dm-search-icon">
                🔍
            </span>

            <input
                type="text"
                id="searchInput"
                class="dm-search"
                placeholder="Search cadet, TRB, vessel..."
                autocomplete="off"
            >

        </div>


        {{-- DATE FROM --}}

        <div class="dm-filter-field">

            <label class="dm-date-label">
                Deployment From
            </label>

            <input
                type="date"
                id="dateFrom"
                class="dm-date-input"
                title="Deployment date from"
            >

        </div>


        {{-- DATE TO --}}

        <div class="dm-filter-field">

            <label class="dm-date-label">
                Deployment To
            </label>

            <input
                type="date"
                id="dateTo"
                class="dm-date-input"
                title="Deployment date to"
            >

        </div>

    </div>

</div>
```

</div>

{{-- =========================================================
SUCCESS TOAST
========================================================= --}}

<div
    id="successToast"
    class="dm-toast"
    role="status"
    aria-live="polite"
>

```
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
```

</div>

{{-- =========================================================
DEPLOYMENT MODAL
========================================================= --}}

<div
    id="deploymentModal"
    class="dm-modal"
    aria-hidden="true"
>

```
<div
    class="dm-modal-card"
    role="dialog"
    aria-modal="true"
    aria-labelledby="deploymentModalTitle"
>

    <input
        type="hidden"
        id="modalId"
    >


    {{-- HEADER --}}

    <div class="dm-modal-header">

        <div class="dm-modal-title">

            <div class="dm-modal-title-icon">
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
            aria-label="Close modal"
        >
            ×
        </button>

    </div>


    {{-- BODY --}}

    <div class="dm-modal-body">

        {{-- PROFILE --}}

        <div class="dm-profile">

            <img
                id="modalPhoto"
                src="/images/default-avatar.png"
                alt="Cadet Photo"
                onerror="this.onerror=null;this.src='/images/default-avatar.png';"
            >

            <div>

                <div
                    id="modalName"
                    class="dm-profile-name"
                ></div>

                <div class="dm-profile-meta">

                    <span id="modalTRB"></span>

                    <span>•</span>

                    <span id="modalCourse"></span>

                </div>

            </div>

        </div>


        {{-- VESSEL INFORMATION --}}

        <div class="dm-section">

            <div class="dm-section-title">

                <div class="dm-section-number">
                    01
                </div>

                Vessel Information

            </div>


            <div class="dm-form-grid">

                <div class="dm-form-group">

                    <label class="dm-form-label">
                        Vessel Name
                    </label>

                    <input
                        type="text"
                        id="modalVessel"
                        class="dm-form-input"
                        placeholder="Enter vessel name"
                    >

                </div>


                <div class="dm-form-group">

                    <label class="dm-form-label">
                        Company Name
                    </label>

                    <input
                        type="text"
                        id="modalCompany"
                        class="dm-form-input"
                        placeholder="Enter company name"
                    >

                </div>


                <div class="dm-form-group full">

                    <label class="dm-form-label">
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

        </div>


        <div class="dm-divider"></div>


        {{-- EMBARKATION --}}

        <div class="dm-section">

            <div class="dm-section-title">

                <div class="dm-section-number">
                    02
                </div>

                Embarkation

            </div>


            <div class="dm-form-grid">

                <div class="dm-form-group">

                    <label class="dm-form-label">
                        Embarkation Place
                    </label>

                    <input
                        type="text"
                        id="modalEmbarkPlace"
                        class="dm-form-input"
                        placeholder="Enter embarkation place"
                    >

                </div>


                <div class="dm-form-group">

                    <label class="dm-form-label">
                        Embarkation Date
                    </label>

                    <input
                        type="date"
                        id="modalDeployed"
                        class="dm-form-input"
                    >

                </div>

            </div>

        </div>


        <div class="dm-divider"></div>


        {{-- DISEMBARKATION --}}

        <div class="dm-section">

            <div class="dm-section-title">

                <div class="dm-section-number">
                    03
                </div>

                Disembarkation

            </div>


            <div class="dm-form-grid">

                <div class="dm-form-group">

                    <label class="dm-form-label">
                        Disembarkation Place
                    </label>

                    <input
                        type="text"
                        id="modalDisembarkPlace"
                        class="dm-form-input"
                        placeholder="Enter disembarkation place"
                    >

                </div>


                <div class="dm-form-group">

                    <label class="dm-form-label">
                        Disembarkation Date
                    </label>

                    <input
                        type="date"
                        id="modalDisembarked"
                        class="dm-form-input"
                    >

                </div>

            </div>


            <div class="dm-form-group full">

                <label class="dm-form-label">
                    Duration of Sea Service
                </label>

                <div
                    id="modalSeaServiceDuration"
                    class="dm-sea-service-value"
                >
                    —
                </div>

            </div>

        </div>


        <div class="dm-divider"></div>


        {{-- STATUS --}}

        <div class="dm-section">

            <div class="dm-section-title">

                <div class="dm-section-number">
                    04
                </div>

                Training Status

            </div>


            <div class="dm-form-grid">

                <div class="dm-form-group full">

                    <label class="dm-form-label">
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


                <div class="dm-modal-progress-track">

                    <div
                        id="modalProgress"
                        class="dm-modal-progress-fill"
                        style="width:0%;"
                    ></div>

                </div>

            </div>

        </div>

    </div>


    {{-- FOOTER --}}

    <div class="dm-modal-footer">

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

    </div>

</div>
```

</div>

<script>
/* =========================================================
   DEPLOYMENT MONITORING
   AJAX FILTERING + PAGINATION + MODAL
========================================================= */

let deploymentRequest = null;
let deploymentSearchTimer = null;
let deploymentInitialized = false;


/* =========================================================
   DOM READY
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    initializeDeploymentFilters();
    initializeDeploymentPagination();
    initializeDeploymentDuration();
    initializeDeploymentKeyboard();
    initializeDeploymentDropdowns();
    initializeDeploymentDragScroll();

    restoreDeploymentFiltersFromURL();

    deploymentInitialized = true;

});


/* =========================================================
   FILTER INITIALIZATION
========================================================= */

function initializeDeploymentFilters() {

    document
        .querySelectorAll(
            ".dm-dropdown-menu input[type='checkbox']"
        )
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                "change",
                function () {

                    loadDeploymentResults(1);

                }
            );

        });


    const searchInput =
        document.getElementById("searchInput");


    if (searchInput) {

        searchInput.addEventListener(
            "input",
            function () {

                clearTimeout(
                    deploymentSearchTimer
                );


                deploymentSearchTimer =
                    setTimeout(function () {

                        loadDeploymentResults(1);

                    }, 400);

            }
        );

    }


    const dateFrom =
        document.getElementById("dateFrom");


    const dateTo =
        document.getElementById("dateTo");


    if (dateFrom) {

        dateFrom.addEventListener(
            "change",
            function () {

                loadDeploymentResults(1);

            }
        );

    }


    if (dateTo) {

        dateTo.addEventListener(
            "change",
            function () {

                loadDeploymentResults(1);

            }
        );

    }

}


/* =========================================================
   BUILD FILTER QUERY
========================================================= */

function getDeploymentFilterQuery() {

    const params =
        new URLSearchParams();


    /* COURSE */

    getDMCheckedValues("courseMenu")
        .forEach(function (course) {

            params.append(
                "course[]",
                course
            );

        });


    /* BATCH */

    getDMCheckedValues("batchMenu")
        .forEach(function (batch) {

            params.append(
                "batch[]",
                batch
            );

        });


    /* STATUS */

    getDMCheckedValues("statusMenu")
        .forEach(function (status) {

            params.append(
                "status[]",
                status
            );

        });


    /* SEARCH */

    const search =
        document.getElementById(
            "searchInput"
        )?.value?.trim() || "";


    if (search) {

        params.set(
            "search",
            search
        );

    }


    /* DATE FROM */

    const dateFrom =
        document.getElementById(
            "dateFrom"
        );


    if (dateFrom?.value) {

        params.set(
            "date_from",
            dateFrom.value
        );

    }


    /* DATE TO */

    const dateTo =
        document.getElementById(
            "dateTo"
        );


    if (dateTo?.value) {

        params.set(
            "date_to",
            dateTo.value
        );

    }


    return params;

}


/* =========================================================
   GET CHECKED VALUES
========================================================= */

function getDMCheckedValues(menuId) {

    return Array.from(
        document.querySelectorAll(
            "#" +
            menuId +
            " input[type='checkbox']:checked"
        )
    )
    .map(function (checkbox) {

        return String(
            checkbox.value || ""
        )
        .toLowerCase()
        .trim();

    });

}


/* =========================================================
   LOAD DEPLOYMENT RESULTS
========================================================= */

function loadDeploymentResults(
    page = 1,
    pushHistory = true
) {

    const results =
        document.getElementById(
            "deploymentResults"
        );


    const stats =
        document.getElementById(
            "deploymentStats"
        );


    if (!results) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Cancel previous request
    |--------------------------------------------------------------------------
    */

    if (deploymentRequest) {

        deploymentRequest.abort();

    }


    const controller =
        new AbortController();


    deploymentRequest =
        controller;


    /*
    |--------------------------------------------------------------------------
    | Build URL
    |--------------------------------------------------------------------------
    */

    const params =
        getDeploymentFilterQuery();


    params.set(
        "page",
        page
    );


    const url =
        window.location.pathname +
        "?" +
        params.toString();


    /*
    |--------------------------------------------------------------------------
    | Loading state
    |--------------------------------------------------------------------------
    */

    results.classList.add(
        "is-loading"
    );


    /*
    |--------------------------------------------------------------------------
    | AJAX REQUEST
    |--------------------------------------------------------------------------
    */

    fetch(
        url,
        {
            method: "GET",

            headers: {

                "X-Requested-With":
                    "XMLHttpRequest",

                "Accept":
                    "text/html"

            },

            signal:
                controller.signal

        }
    )

    .then(function (response) {

        if (!response.ok) {

            throw new Error(
                "Unable to load deployment records."
            );

        }


        return response.text();

    })

    .then(function (html) {

        const parser =
            new DOMParser();


        const documentHTML =
            parser.parseFromString(
                html,
                "text/html"
            );


        const newResults =
            documentHTML.getElementById(
                "deploymentResults"
            );


        const newStats =
            documentHTML.getElementById(
                "deploymentStats"
            );


        if (!newResults) {

            throw new Error(
                "Deployment results container was not found."
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Replace only table card contents
        |--------------------------------------------------------------------------
        */

        results.innerHTML =
            newResults.innerHTML;


        /*
        |--------------------------------------------------------------------------
        | Replace statistics
        |--------------------------------------------------------------------------
        */

        if (
            stats &&
            newStats
        ) {

            stats.innerHTML =
                newStats.innerHTML;

        }


        /*
        |--------------------------------------------------------------------------
        | Browser URL
        |--------------------------------------------------------------------------
        */

        if (pushHistory) {

            window.history.pushState(
                {
                    deploymentPage: true
                },
                "",
                url
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Reinitialize table-specific UI
        |--------------------------------------------------------------------------
        */

        initializeDeploymentDragScroll();

    })

    .catch(function (error) {

        if (
            error.name ===
            "AbortError"
        ) {

            return;

        }


        console.error(
            "Deployment AJAX error:",
            error
        );

    })

    .finally(function () {

        if (
            deploymentRequest ===
            controller
        ) {

            results.classList.remove(
                "is-loading"
            );


            deploymentRequest =
                null;

        }

    });

}


/* =========================================================
   PAGINATION
========================================================= */

function initializeDeploymentPagination() {

    const results =
        document.getElementById(
            "deploymentResults"
        );


    if (!results) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Event delegation
    |--------------------------------------------------------------------------
    |
    | This listener survives AJAX replacement because it belongs
    | to #deploymentResults itself.
    |--------------------------------------------------------------------------
    */

    if (
        results.dataset.paginationInitialized ===
        "true"
    ) {

        return;

    }


    results.dataset.paginationInitialized =
        "true";


    results.addEventListener(
        "click",
        function (event) {

            const link =
                event.target.closest(
                    ".dm-pagination-links a"
                );


            if (!link) {
                return;
            }


            event.preventDefault();


            const href =
                link.getAttribute(
                    "href"
                );


            if (!href) {
                return;
            }


            const url =
                new URL(
                    href,
                    window.location.origin
                );


            const page =
                url.searchParams.get(
                    "page"
                ) || 1;


            loadDeploymentResults(
                page
            );

        }
    );

}


/* =========================================================
   CLEAR FILTERS
========================================================= */

function clearDeploymentFilters() {

    document
        .querySelectorAll(
            ".dm-dropdown-menu input[type='checkbox']"
        )
        .forEach(function (checkbox) {

            checkbox.checked = false;

        });


    const searchInput =
        document.getElementById(
            "searchInput"
        );


    const dateFrom =
        document.getElementById(
            "dateFrom"
        );


    const dateTo =
        document.getElementById(
            "dateTo"
        );


    if (searchInput) {
        searchInput.value = "";
    }


    if (dateFrom) {
        dateFrom.value = "";
    }


    if (dateTo) {
        dateTo.value = "";
    }


    loadDeploymentResults(1);

}


/* =========================================================
   BROWSER BACK / FORWARD
========================================================= */

window.addEventListener(
    "popstate",
    function () {

        restoreDeploymentFiltersFromURL();


        const page =
            new URLSearchParams(
                window.location.search
            ).get("page") || 1;


        loadDeploymentResults(
            page,
            false
        );

    }
);


/* =========================================================
   RESTORE FILTERS FROM URL
========================================================= */

function restoreDeploymentFiltersFromURL() {

    const params =
        new URLSearchParams(
            window.location.search
        );


    /*
    |--------------------------------------------------------------------------
    | COURSE
    |--------------------------------------------------------------------------
    */

    const selectedCourses =
        params.getAll(
            "course[]"
        );


    document
        .querySelectorAll(
            "#courseMenu input[type='checkbox']"
        )
        .forEach(function (checkbox) {

            checkbox.checked =
                selectedCourses.includes(
                    checkbox.value
                );

        });


    /*
    |--------------------------------------------------------------------------
    | BATCH
    |--------------------------------------------------------------------------
    */

    const selectedBatches =
        params.getAll(
            "batch[]"
        );


    document
        .querySelectorAll(
            "#batchMenu input[type='checkbox']"
        )
        .forEach(function (checkbox) {

            checkbox.checked =
                selectedBatches.includes(
                    checkbox.value
                );

        });


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    const selectedStatuses =
        params.getAll(
            "status[]"
        );


    document
        .querySelectorAll(
            "#statusMenu input[type='checkbox']"
        )
        .forEach(function (checkbox) {

            checkbox.checked =
                selectedStatuses.includes(
                    checkbox.value
                );

        });


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    const searchInput =
        document.getElementById(
            "searchInput"
        );


    if (searchInput) {

        searchInput.value =
            params.get(
                "search"
            ) || "";

    }


    /*
    |--------------------------------------------------------------------------
    | DATE FROM
    |--------------------------------------------------------------------------
    */

    const dateFrom =
        document.getElementById(
            "dateFrom"
        );


    if (dateFrom) {

        dateFrom.value =
            params.get(
                "date_from"
            ) || "";

    }


    /*
    |--------------------------------------------------------------------------
    | DATE TO
    |--------------------------------------------------------------------------
    */

    const dateTo =
        document.getElementById(
            "dateTo"
        );


    if (dateTo) {

        dateTo.value =
            params.get(
                "date_to"
            ) || "";

    }

}


/* =========================================================
   DROPDOWN
========================================================= */

function toggleDMFilter(
    button,
    menuId
) {

    const dropdown =
        button.closest(
            ".dm-filter-dropdown"
        );


    if (!dropdown) {
        return;
    }


    const isOpen =
        dropdown.classList.contains(
            "open"
        );


    document
        .querySelectorAll(
            ".dm-filter-dropdown"
        )
        .forEach(function (item) {

            item.classList.remove(
                "open"
            );

        });


    if (!isOpen) {

        dropdown.classList.add(
            "open"
        );

    }

}


/* =========================================================
   CLOSE DROPDOWNS
========================================================= */

function initializeDeploymentDropdowns() {

    if (
        document.body.dataset.dmDropdownsInitialized ===
        "true"
    ) {

        return;

    }


    document.body.dataset.dmDropdownsInitialized =
        "true";


    document.addEventListener(
        "click",
        function (event) {

            if (
                !event.target.closest(
                    ".dm-filter-dropdown"
                )
            ) {

                document
                    .querySelectorAll(
                        ".dm-filter-dropdown"
                    )
                    .forEach(function (dropdown) {

                        dropdown.classList.remove(
                            "open"
                        );

                    });

            }

        }
    );

}


/* =========================================================
   DURATION EVENTS
========================================================= */

function initializeDeploymentDuration() {

    const modalDeployed =
        document.getElementById(
            "modalDeployed"
        );


    const modalDisembarked =
        document.getElementById(
            "modalDisembarked"
        );


    if (modalDeployed) {

        modalDeployed.addEventListener(
            "change",
            calculateSeaServiceDuration
        );

    }


    if (modalDisembarked) {

        modalDisembarked.addEventListener(
            "change",
            calculateSeaServiceDuration
        );

    }

}


/* =========================================================
   KEYBOARD
========================================================= */

function initializeDeploymentKeyboard() {

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key ===
                "Escape"
            ) {

                closeDeploymentModal();

            }

        }
    );

}


/* =========================================================
   OPEN MODAL
========================================================= */

function openDeploymentModal(cadet) {

    const modal =
        document.getElementById(
            "deploymentModal"
        );


    if (!modal) {
        return;
    }


    modal.classList.add(
        "show"
    );


    modal.setAttribute(
        "aria-hidden",
        "false"
    );


    document.body.classList.add(
        "dm-modal-open"
    );


    document.getElementById(
        "modalId"
    ).value =
        cadet.id;


    document.getElementById(
        "modalName"
    ).innerText =
        cadet.full_name ||
        "Unknown Cadet";


    document.getElementById(
        "modalTRB"
    ).innerText =
        "TRB: " +
        (
            cadet.trb_control_number ||
            "—"
        );


    document.getElementById(
        "modalCourse"
    ).innerText =
        cadet.course ||
        "—";


    const modalPhoto =
        document.getElementById(
            "modalPhoto"
        );


    if (modalPhoto) {

        modalPhoto.onerror =
            function () {

                this.onerror = null;

                this.src =
                    "/images/default-avatar.png";

            };


        modalPhoto.src =
            cadet.photo
                ? `/storage/${cadet.photo}`
                : "/images/default-avatar.png";

    }


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        "modalVessel"
    ).value = "";


    document.getElementById(
        "modalCompany"
    ).value = "";


    document.getElementById(
        "modalDeploymentType"
    ).value =
        "Domestic";


    document.getElementById(
        "modalEmbarkPlace"
    ).value = "";


    document.getElementById(
        "modalDeployed"
    ).value = "";


    document.getElementById(
        "modalDisembarkPlace"
    ).value = "";


    document.getElementById(
        "modalDisembarked"
    ).value = "";


    document.getElementById(
        "modalSeaServiceDuration"
    ).innerText = "—";


    document.getElementById(
        "modalStatus"
    ).value =
        "Not Deployed";


    updateModalProgress(0);


    /*
    |--------------------------------------------------------------------------
    | LOAD DEPLOYMENT
    |--------------------------------------------------------------------------
    */

    fetch(
        `/admin/deployment/${cadet.id}`,
        {
            headers: {

                "Accept":
                    "application/json"

            }
        }
    )

    .then(function (response) {

        if (!response.ok) {

            throw new Error(
                "Failed to load deployment data."
            );

        }


        return response.json();

    })

    .then(function (data) {

        const dep =
            data.deployment ||
            {};


        document.getElementById(
            "modalVessel"
        ).value =
            dep.vessel_name ??
            "";


        document.getElementById(
            "modalCompany"
        ).value =
            dep.company_name ??
            "";


        document.getElementById(
            "modalDeploymentType"
        ).value =
            dep.deployment_type ??
            "Domestic";


        document.getElementById(
            "modalEmbarkPlace"
        ).value =
            dep.embarkation_place ??
            "";


        document.getElementById(
            "modalDisembarkPlace"
        ).value =
            dep.disembarkation_place ??
            "";


        document.getElementById(
            "modalDeployed"
        ).value =
            dep.date_deployed
                ? String(
                    dep.date_deployed
                ).slice(0, 10)
                : "";


        document.getElementById(
            "modalDisembarked"
        ).value =
            dep.date_disembarked
                ? String(
                    dep.date_disembarked
                ).slice(0, 10)
                : "";


        calculateSeaServiceDuration();


        document.getElementById(
            "modalStatus"
        ).value =
            dep.status ??
            "Not Deployed";


        updateModalProgress(
            dep.percentage ??
            0
        );

    })

    .catch(function (error) {

        console.error(
            "Deployment loading error:",
            error
        );

    });

}


/* =========================================================
   CALCULATE SEA SERVICE DURATION
========================================================= */

function calculateSeaServiceDuration() {

    const embarkation =
        document.getElementById(
            "modalDeployed"
        )?.value ||
        "";


    const disembarkation =
        document.getElementById(
            "modalDisembarked"
        )?.value ||
        "";


    const output =
        document.getElementById(
            "modalSeaServiceDuration"
        );


    if (!output) {
        return;
    }


    if (
        !embarkation ||
        !disembarkation
    ) {

        output.innerText =
            "—";

        output.classList.remove(
            "invalid"
        );

        return;

    }


    const embarkParts =
        embarkation
            .split("-")
            .map(Number);


    const disembarkParts =
        disembarkation
            .split("-")
            .map(Number);


    if (
        embarkParts.length !== 3 ||
        disembarkParts.length !== 3
    ) {

        output.innerText =
            "—";

        return;

    }


    const start =
        new Date(
            embarkParts[0],
            embarkParts[1] - 1,
            embarkParts[2]
        );


    const end =
        new Date(
            disembarkParts[0],
            disembarkParts[1] - 1,
            disembarkParts[2]
        );


    if (end < start) {

        output.innerText =
            "Invalid date range";

        output.classList.add(
            "invalid"
        );

        return;

    }


    output.classList.remove(
        "invalid"
    );


    let months =
        (
            end.getFullYear() -
            start.getFullYear()
        ) * 12;


    months +=
        end.getMonth() -
        start.getMonth();


    let anchor =
        new Date(start);


    anchor.setMonth(
        anchor.getMonth() +
        months
    );


    if (anchor > end) {

        months--;


        anchor =
            new Date(start);


        anchor.setMonth(
            anchor.getMonth() +
            months
        );

    }


    const millisecondsPerDay =
        1000 *
        60 *
        60 *
        24;


    const days =
        Math.round(
            (
                end.getTime() -
                anchor.getTime()
            ) /
            millisecondsPerDay
        );


    const parts = [];


    if (months > 0) {

        parts.push(
            months +
            " " +
            (
                months === 1
                    ? "Month"
                    : "Months"
            )
        );

    }


    if (days > 0) {

        parts.push(
            days +
            " " +
            (
                days === 1
                    ? "Day"
                    : "Days"
            )
        );

    }


    output.innerText =
        parts.length
            ? parts.join(", ")
            : "0 Days";

}


/* =========================================================
   UPDATE MODAL PROGRESS
========================================================= */

function updateModalProgress(percent) {

    percent =
        Number(percent) ||
        0;


    percent =
        Math.max(
            0,
            Math.min(
                100,
                percent
            )
        );


    const progress =
        document.getElementById(
            "modalProgress"
        );


    const percentLabel =
        document.getElementById(
            "modalPercent"
        );


    if (!progress) {
        return;
    }


    progress.style.width =
        percent +
        "%";


    if (percentLabel) {

        percentLabel.innerText =
            percent +
            "%";

    }


    if (percent >= 100) {

        progress.classList.add(
            "complete"
        );

    } else {

        progress.classList.remove(
            "complete"
        );

    }

}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closeDeploymentModal() {

    const modal =
        document.getElementById(
            "deploymentModal"
        );


    if (!modal) {
        return;
    }


    modal.classList.remove(
        "show"
    );


    modal.setAttribute(
        "aria-hidden",
        "true"
    );


    document.body.classList.remove(
        "dm-modal-open"
    );

}


/* =========================================================
   CLICK OUTSIDE MODAL
========================================================= */

document.addEventListener(
    "click",
    function (event) {

        const modal =
            document.getElementById(
                "deploymentModal"
            );


        if (
            modal &&
            event.target === modal
        ) {

            closeDeploymentModal();

        }

    }
);


/* =========================================================
   SAVE DEPLOYMENT
========================================================= */

function saveDeploymentChanges() {

    const id =
        document.getElementById(
            "modalId"
        ).value;


    const button =
        document.getElementById(
            "saveDeploymentBtn"
        );


    if (!id) {

        alert(
            "Cadet ID is missing."
        );

        return;

    }


    button.classList.add(
        "loading"
    );


    button.innerText =
        "Saving...";


    button.disabled =
        true;


    const csrf =
        document.querySelector(
            'meta[name="csrf-token"]'
        );


    fetch(
        `/admin/deployment/${id}`,
        {
            method: "PUT",

            headers: {

                "Content-Type":
                    "application/json",

                "X-CSRF-TOKEN":
                    csrf
                        ? csrf.content
                        : "",

                "Accept":
                    "application/json"

            },

            body: JSON.stringify({

                vessel_name:
                    document.getElementById(
                        "modalVessel"
                    ).value,

                /*
                |--------------------------------------------------------------------------
                | Controller expects "company"
                |--------------------------------------------------------------------------
                */

                company:
                    document.getElementById(
                        "modalCompany"
                    ).value,

                deployment_type:
                    document.getElementById(
                        "modalDeploymentType"
                    ).value,

                embarkation_place:
                    document.getElementById(
                        "modalEmbarkPlace"
                    ).value,

                date_deployed:
                    document.getElementById(
                        "modalDeployed"
                    ).value,

                disembarkation_place:
                    document.getElementById(
                        "modalDisembarkPlace"
                    ).value,

                date_disembarked:
                    document.getElementById(
                        "modalDisembarked"
                    ).value,

                deployment_status:
                    document.getElementById(
                        "modalStatus"
                    ).value

            })

        }
    )

    .then(function (response) {

        return response.json()
            .then(function (data) {

                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        "Unable to update deployment."
                    );

                }


                return data;

            });

    })

    .then(function (data) {

        if (!data.success) {

            throw new Error(
                data.message ||
                "Update failed."
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Close modal
        |--------------------------------------------------------------------------
        */

        closeDeploymentModal();


        /*
        |--------------------------------------------------------------------------
        | Show toast
        |--------------------------------------------------------------------------
        */

        showDeploymentToast();


        /*
        |--------------------------------------------------------------------------
        | Refresh only AJAX results
        |--------------------------------------------------------------------------
        */

        const currentPage =
            new URLSearchParams(
                window.location.search
            ).get("page") || 1;


        loadDeploymentResults(
            currentPage,
            false
        );

    })

    .catch(function (error) {

        console.error(
            "Deployment update error:",
            error
        );


        alert(
            error.message ||
            "Unable to update deployment."
        );

    })

    .finally(function () {

        button.classList.remove(
            "loading"
        );


        button.innerText =
            "Save Changes";


        button.disabled =
            false;

    });

}


/* =========================================================
   SUCCESS TOAST
========================================================= */

function showDeploymentToast() {

    const toast =
        document.getElementById(
            "successToast"
        );


    if (!toast) {
        return;
    }


    toast.classList.add(
        "show"
    );


    setTimeout(function () {

        toast.classList.remove(
            "show"
        );

    }, 2600);

}


/* =========================================================
   DRAG TO SCROLL TABLE
========================================================= */

function initializeDeploymentDragScroll() {

    const tables =
        document.querySelectorAll(
            ".dm-table-scroll"
        );


    tables.forEach(function (table) {

        if (
            table.dataset.dragInitialized ===
            "true"
        ) {

            return;

        }


        table.dataset.dragInitialized =
            "true";


        let isDown = false;
        let startX = 0;
        let scrollLeft = 0;


        table.addEventListener(
            "mousedown",
            function (event) {

                if (
                    event.target.closest(
                        "button, input, select, a"
                    )
                ) {

                    return;

                }


                isDown = true;

                table.classList.add(
                    "is-dragging"
                );


                startX =
                    event.pageX -
                    table.offsetLeft;


                scrollLeft =
                    table.scrollLeft;

            }
        );


        table.addEventListener(
            "mouseleave",
            function () {

                isDown = false;

                table.classList.remove(
                    "is-dragging"
                );

            }
        );


        table.addEventListener(
            "mouseup",
            function () {

                isDown = false;

                table.classList.remove(
                    "is-dragging"
                );

            }
        );


        table.addEventListener(
            "mousemove",
            function (event) {

                if (!isDown) {
                    return;
                }


                event.preventDefault();


                const x =
                    event.pageX -
                    table.offsetLeft;


                const walk =
                    (
                        x -
                        startX
                    ) * 1.5;


                table.scrollLeft =
                    scrollLeft -
                    walk;

            }
        );

    });

}
</script>

@endsection
