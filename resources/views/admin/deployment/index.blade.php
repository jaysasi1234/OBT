@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/deployment/deployment.css'])



<div class="dm-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="dm-header">

        <div class="dm-header-content">

            <h1>Deployment Monitoring</h1>

            <p>
                Monitor cadet deployment information, vessel assignments,
                progress, and training status.
            </p>

        </div>

        <div class="dm-header-icon">
            🚢
        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="dm-stats">

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


    {{-- =====================================================
         FILTER PANEL
    ====================================================== --}}

    <div class="dm-filter-panel">

        <div class="dm-filter-header">

            <div class="dm-filter-title">

                <div class="dm-filter-title-icon">
                    ⚙
                </div>

                Filters

            </div>

        </div>


        <div class="dm-filter-grid">

            {{-- COURSE --}}

            <div class="dm-filter-dropdown">

                <button
                    type="button"
                    class="dm-filter-button"
                    onclick="toggleDMFilter(this, 'courseMenu')"
                >

                    <span>Courses</span>

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
                                value="{{ strtolower(trim($course->course)) }}"
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

                    <span>Batches</span>

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
                                value="{{ strtolower($batch->batch_year) }}"
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

                    <span>Status</span>

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
                        <span>Ongoing</span>
                    </label>

                    <label class="dm-check-option">
                        <input
                            type="checkbox"
                            value="completed"
                        >
                        <span>Completed</span>
                    </label>

                    <label class="dm-check-option">
                        <input
                            type="checkbox"
                            value="not deployed"
                        >
                        <span>Not Deployed</span>
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

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="dm-table-card">

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

                        {{-- ADDED --}}
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

                        $status =
                            strtolower(
                                trim(
                                    optional($deployment)->status
                                    ?? 'Not Deployed'
                                )
                            );

                        $percent =
                            (int) (
                                optional($deployment)->percentage
                                ?? 0
                            );

                        $percent =
                            max(
                                0,
                                min(
                                    100,
                                    $percent
                                )
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | DURATION OF SEA SERVICE
                        |--------------------------------------------------------------------------
                        */

                        $durationOfSeaService = null;

                        $rawEmbarkationDate =
                            $deployment?->getRawOriginal('date_deployed');

                        $rawDisembarkationDate =
                            $deployment?->getRawOriginal('date_disembarked');


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
                                        ($difference->y * 12)
                                        + $difference->m;


                                    $days =
                                        $difference->d;


                                    $durationParts = [];


                                    if ($months > 0) {

                                        $durationParts[] =
                                            $months . ' ' .
                                            (
                                                $months === 1
                                                    ? 'Month'
                                                    : 'Months'
                                            );

                                    }


                                    if ($days > 0) {

                                        $durationParts[] =
                                            $days . ' ' .
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

                    @endphp


                    <tr>

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
                            {{ strtoupper($cadet->course) }}
                        </td>


                        {{-- BATCH --}}

                        <td>
                            {{ optional($cadet->batch)->batch_year ?? 'No Batch' }}
                        </td>


                        {{-- VESSEL --}}

                        <td>
                            {{ $deployment->vessel_name ?? '—' }}
                        </td>


                        {{-- COMPANY --}}

                        <td>
                            {{ $deployment->company_name ?? '—' }}
                        </td>


                        {{-- DEPLOYMENT TYPE --}}

                        <td>

                            @if(($deployment->deployment_type ?? '') === 'International')

                                <span class="dm-badge dm-badge-blue">
                                    🌍 International
                                </span>

                            @elseif(($deployment->deployment_type ?? '') === 'Domestic')

                                <span class="dm-badge dm-badge-green">
                                    🇵🇭 Domestic
                                </span>

                            @else

                                <span class="dm-badge dm-badge-gray">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- EMBARKATION PLACE --}}

                        <td>
                            {{ $deployment->embarkation_place ?? '—' }}
                        </td>


                        {{-- EMBARKATION DATE --}}

                        <td
                            data-date="{{ $deployment?->getRawOriginal('date_deployed') ?? '' }}"
                        >

                            @php

                                $rawEmbarkationDate =
                                    $deployment?->getRawOriginal(
                                        'date_deployed'
                                    );

                            @endphp

                            @if($rawEmbarkationDate)

                                {{ date(
                                    'M d, Y',
                                    strtotime(
                                        substr(
                                            $rawEmbarkationDate,
                                            0,
                                            10
                                        )
                                    )
                                ) }}

                            @else

                                —

                            @endif

                        </td>


                        {{-- DISEMBARKATION PLACE --}}

                        <td>
                            {{ $deployment->disembarkation_place ?? '—' }}
                        </td>


                        {{-- DISEMBARKATION DATE --}}

                        <td>

                            @php

                                $rawDisembarkationDate =
                                    $deployment?->getRawOriginal(
                                        'date_disembarked'
                                    );

                            @endphp

                            @if($rawDisembarkationDate)

                                {{ date(
                                    'M d, Y',
                                    strtotime(
                                        substr(
                                            $rawDisembarkationDate,
                                            0,
                                            10
                                        )
                                    )
                                ) }}

                            @else

                                —

                            @endif

                        </td>


                        {{-- =================================================
                             DURATION OF SEA SERVICE
                        ================================================== --}}

                        <td>

                            @if($durationOfSeaService)

                                <strong class="dm-sea-duration">
                                    {{ $durationOfSeaService }}
                                </strong>

                            @else

                                —

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
                                        {{ $percent }}%
                                    </span>

                                </div>

                                <div class="dm-progress-track">

                                    <div
                                        class="dm-progress-fill {{ $percent >= 100 ? 'complete' : '' }}"
                                        style="width: {{ $percent }}%;"
                                    ></div>

                                </div>

                            </div>

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($status === 'ongoing')

                                <span class="dm-badge dm-badge-blue">
                                    ⚓ Ongoing
                                </span>

                            @elseif($status === 'completed')

                                <span class="dm-badge dm-badge-green">
                                    ✓ Completed
                                </span>

                            @else

                                <span class="dm-badge dm-badge-gray">
                                    ○ Not Deployed
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
                                👁 View
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
                                There are currently no cadets matching the available records.
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
     SUCCESS TOAST
========================================================= --}}

<div
    id="successToast"
    class="dm-toast"
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
========================================================= --}}

<div
    id="deploymentModal"
    class="dm-modal"
>

    <div class="dm-modal-card">

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

                    <strong>
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
                    src=""
                    alt="Cadet Photo"
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


                {{-- =================================================
                     DURATION OF SEA SERVICE
                ================================================== --}}

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

</div>


<script>
/* =========================================================
   DEPLOYMENT MONITORING JAVASCRIPT
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       FILTER CHECKBOXES
    ===================================================== */

    document
        .querySelectorAll(".dm-dropdown-menu input[type='checkbox']")
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                "change",
                filterDeploymentTable
            );

        });


    /* =====================================================
       SEARCH
    ===================================================== */

    const searchInput =
        document.getElementById("searchInput");

    if (searchInput) {

        searchInput.addEventListener(
            "input",
            filterDeploymentTable
        );

    }


    /* =====================================================
       DATE FILTERS
    ===================================================== */

    const dateFrom =
        document.getElementById("dateFrom");

    const dateTo =
        document.getElementById("dateTo");


    if (dateFrom) {

        dateFrom.addEventListener(
            "change",
            filterDeploymentTable
        );

    }


    if (dateTo) {

        dateTo.addEventListener(
            "change",
            filterDeploymentTable
        );

    }


    /* =====================================================
       DURATION OF SEA SERVICE
    ===================================================== */

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


    /* =====================================================
       ESCAPE KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Escape") {

                closeDeploymentModal();

            }

        }
    );


    /* =====================================================
       CLOSE DROPDOWNS
    ===================================================== */

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


    /* =====================================================
       INITIAL FILTER
    ===================================================== */

    filterDeploymentTable();

});


/* =========================================================
   DROPDOWN
========================================================= */

function toggleDMFilter(button, menuId) {

    const dropdown =
        button.closest(".dm-filter-dropdown");

    const isOpen =
        dropdown.classList.contains("open");


    document
        .querySelectorAll(".dm-filter-dropdown")
        .forEach(function (item) {

            item.classList.remove("open");

        });


    if (!isOpen) {

        dropdown.classList.add("open");

    }

}


/* =========================================================
   GET CHECKED VALUES
========================================================= */

function getDMCheckedValues(menuId) {

    return Array.from(
        document.querySelectorAll(
            "#" + menuId + " input:checked"
        )
    ).map(function (checkbox) {

        return checkbox.value
            .toLowerCase()
            .trim();

    });

}


/* =========================================================
   FILTER TABLE
========================================================= */

function filterDeploymentTable() {

    const courses =
        getDMCheckedValues("courseMenu");

    const batches =
        getDMCheckedValues("batchMenu");

    const statuses =
        getDMCheckedValues("statusMenu");


    const search =
        (
            document.getElementById(
                "searchInput"
            )?.value || ""
        )
        .toLowerCase()
        .trim();


    const from =
        document.getElementById(
            "dateFrom"
        )?.value || "";


    const to =
        document.getElementById(
            "dateTo"
        )?.value || "";


    const rows =
        document.querySelectorAll(
            ".dm-table tbody tr"
        );


    rows.forEach(function (row) {

        if (
            row.querySelector(
                ".dm-empty"
            )
        ) {
            return;
        }


        const cells = row.children;


        const course =
            (
                cells[2]?.innerText || ""
            )
            .toLowerCase()
            .trim();


        const batch =
            (
                cells[3]?.innerText || ""
            )
            .toLowerCase()
            .trim();


        const status =
            (
                cells[13]?.innerText || ""
            )
            .toLowerCase()
            .trim();


        const date =
            cells[8]
            ?.dataset
            ?.date || "";


        const rowText =
            row.innerText
                .toLowerCase();


        /* COURSE */

        const matchCourse =
            courses.length === 0 ||
            courses.includes(course);


        /* BATCH */

        const matchBatch =
            batches.length === 0 ||
            batches.includes(batch);


        /* STATUS */

        const matchStatus =
            statuses.length === 0 ||
            statuses.some(function (item) {

                return status.includes(item);

            });


        /* SEARCH */

        const matchSearch =
            !search ||
            rowText.includes(search);


        /* DATE */

        let matchDate = true;


        if (date) {

            const deploymentDate =
                new Date(date);


            if (from) {

                const fromDate =
                    new Date(from);

                if (
                    deploymentDate < fromDate
                ) {

                    matchDate = false;

                }

            }


            if (to) {

                const toDate =
                    new Date(to);

                /*
                 * Include the complete
                 * selected date.
                 */

                toDate.setHours(
                    23,
                    59,
                    59,
                    999
                );


                if (
                    deploymentDate > toDate
                ) {

                    matchDate = false;

                }

            }

        }


        const visible =
            matchCourse &&
            matchBatch &&
            matchStatus &&
            matchSearch &&
            matchDate;


        row.style.display =
            visible
                ? ""
                : "none";

    });

}


/* =========================================================
   OPEN MODAL
========================================================= */

function openDeploymentModal(cadet) {

    const modal =
        document.getElementById(
            "deploymentModal"
        );


    modal.classList.add("show");


    document.getElementById(
        "modalId"
    ).value = cadet.id;


    document.getElementById(
        "modalName"
    ).innerText =
        cadet.full_name || "Unknown Cadet";


    document.getElementById(
        "modalTRB"
    ).innerText =
        "TRB: " +
        (cadet.trb_control_number || "—");


    document.getElementById(
        "modalCourse"
    ).innerText =
        cadet.course || "—";


    document.getElementById(
        "modalPhoto"
    ).src =
        cadet.photo
            ? `/storage/${cadet.photo}`
            : "/images/default.png";


    /* RESET */

    document.getElementById(
        "modalVessel"
    ).value = "";


    document.getElementById(
        "modalCompany"
    ).value = "";


    document.getElementById(
        "modalDeploymentType"
    ).value = "Domestic";


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


    /*
    |--------------------------------------------------------------------------
    | RESET SEA SERVICE DURATION
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        "modalSeaServiceDuration"
    ).innerText = "—";


    document.getElementById(
        "modalStatus"
    ).value = "Not Deployed";


    updateModalProgress(0);


    /* LOAD DEPLOYMENT */

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
            data.deployment || {};


        document.getElementById(
            "modalVessel"
        ).value =
            dep.vessel_name ?? "";


        document.getElementById(
            "modalCompany"
        ).value =
            dep.company_name ?? "";


        document.getElementById(
            "modalDeploymentType"
        ).value =
            dep.deployment_type ??
            "Domestic";


        document.getElementById(
            "modalEmbarkPlace"
        ).value =
            dep.embarkation_place ?? "";


        document.getElementById(
            "modalDisembarkPlace"
        ).value =
            dep.disembarkation_place ?? "";


        document.getElementById(
            "modalDeployed"
        ).value =
            dep.date_deployed
                ? String(dep.date_deployed).slice(0, 10)
                : "";


        document.getElementById(
            "modalDisembarked"
        ).value =
            dep.date_disembarked
                ? String(dep.date_disembarked).slice(0, 10)
                : "";


        /*
        |--------------------------------------------------------------------------
        | CALCULATE SEA SERVICE AFTER DATES ARE LOADED
        |--------------------------------------------------------------------------
        */

        calculateSeaServiceDuration();


        document.getElementById(
            "modalStatus"
        ).value =
            dep.status ??
            "Not Deployed";


        updateModalProgress(
            dep.percentage ?? 0
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
        )?.value || "";


    const disembarkation =
        document.getElementById(
            "modalDisembarked"
        )?.value || "";


    const output =
        document.getElementById(
            "modalSeaServiceDuration"
        );


    if (!output) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Only display duration when both dates exist.
    |--------------------------------------------------------------------------
    */

    if (
        !embarkation ||
        !disembarkation
    ) {

        output.innerText = "—";

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Parse YYYY-MM-DD manually.
    |
    | This prevents timezone shifting.
    |--------------------------------------------------------------------------
    */

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

        output.innerText = "—";

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

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Calculate complete calendar months first.
    |--------------------------------------------------------------------------
    */

    let months =
        (
            end.getFullYear() -
            start.getFullYear()
        ) * 12;


    months +=
        end.getMonth() -
        start.getMonth();


    /*
    |--------------------------------------------------------------------------
    | Find the date after adding the calculated months.
    |--------------------------------------------------------------------------
    */

    let anchor =
        new Date(start);


    anchor.setMonth(
        anchor.getMonth() + months
    );


    /*
    |--------------------------------------------------------------------------
    | If anchor is after the end date,
    | subtract one month.
    |--------------------------------------------------------------------------
    */

    if (anchor > end) {

        months--;

        anchor =
            new Date(start);

        anchor.setMonth(
            anchor.getMonth() + months
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Calculate remaining days.
    |--------------------------------------------------------------------------
    */

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
        Number(percent) || 0;


    percent =
        Math.max(
            0,
            Math.min(
                100,
                percent
            )
        );


    document.getElementById(
        "modalProgress"
    ).style.width =
        percent + "%";


    document.getElementById(
        "modalPercent"
    ).innerText =
        percent + "%";


    const progress =
        document.getElementById(
            "modalProgress"
        );


    if (percent >= 100) {

        progress.style.background =
            "linear-gradient(90deg,#16a34a,#22c55e)";

    } else {

        progress.style.background =
            "linear-gradient(90deg,#6366f1,#8b5cf6)";

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


    modal.classList.remove(
        "show"
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

        if (data.success) {

            closeDeploymentModal();

            showDeploymentToast();


            setTimeout(
                function () {

                    location.reload();

                },
                2200
            );

        } else {

            throw new Error(
                data.message ||
                "Update failed."
            );

        }

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


    toast.classList.add(
        "show"
    );


    setTimeout(
        function () {

            toast.classList.remove(
                "show"
            );

        },
        2200
    );

}


/* =========================================================
   DRAG TO SCROLL TABLE
========================================================= */

(function () {

    const table =
        document.querySelector(
            ".dm-table-scroll"
        );


    if (!table) {
        return;
    }


    let isDown = false;

    let startX = 0;

    let scrollLeft = 0;


    table.addEventListener(
        "mousedown",
        function (event) {

            isDown = true;

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

        }
    );


    table.addEventListener(
        "mouseup",
        function () {

            isDown = false;

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
                (x - startX) * 1.5;


            table.scrollLeft =
                scrollLeft - walk;

        }
    );

})();
</script>

@endsection