@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/verification/verification.css'])


<div class="verification-page">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="vm-header">

        <div class="vm-header-left">

            <div class="vm-header-icon">
                🛡️
            </div>

            <div class="vm-header-text">

                <h2>
                    Verification & Status Monitoring
                </h2>

                <p>
                    Monitor cadet requirements, verification status,
                    and deployment eligibility.
                </p>

            </div>

        </div>

        <div class="vm-header-badge">

            <span class="vm-header-dot"></span>

            Monitoring Active

        </div>

    </div>


    <!-- =====================================================
         STATISTICS
    ====================================================== -->

    <div class="vm-stats">

        <div class="vm-card vm-total">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Total Verification
                    </div>

                    <div class="vm-card-number">
                        {{ $verificationTotal }}
                    </div>

                    <div class="vm-card-description">
                        Cadets under verification
                    </div>

                </div>

                <div class="vm-card-icon">
                    🛡️
                </div>

            </div>

        </div>


        <div class="vm-card vm-completed">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Completed
                    </div>

                    <div class="vm-card-number">
                        {{ $completed }}
                    </div>

                    <div class="vm-card-description">
                        All requirements approved
                    </div>

                </div>

                <div class="vm-card-icon">
                    ✓
                </div>

            </div>

        </div>


        <div class="vm-card vm-incomplete">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Incomplete
                    </div>

                    <div class="vm-card-number">
                        {{ $incomplete }}
                    </div>

                    <div class="vm-card-description">
                        Requirements still pending
                    </div>

                </div>

                <div class="vm-card-icon">
                    ⚠
                </div>

            </div>

        </div>


        <div class="vm-card vm-qualified">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Qualified
                    </div>

                    <div class="vm-card-number">
                        {{ $qualified }}
                    </div>

                    <div class="vm-card-description">
                        Eligible for deployment
                    </div>

                </div>

                <div class="vm-card-icon">
                    🚢
                </div>

            </div>

        </div>


        <div class="vm-card vm-not-qualified">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Not Qualified
                    </div>

                    <div class="vm-card-number">
                        {{ $notQualified }}
                    </div>

                    <div class="vm-card-description">
                        Not yet eligible
                    </div>

                </div>

                <div class="vm-card-icon">
                    !
                </div>

            </div>

        </div>

    </div>


<!-- =====================================================
     FILTER PANEL
====================================================== -->

<div class="vm-filter-panel">

    <div class="vm-filter-header">

        <div class="vm-filter-title">

            <div class="vm-filter-title-icon">
                ⚙
            </div>

            Filters

        </div>

        <a
            href="{{ route('admin.verification.index') }}"
            class="vm-clear"
        >
            Clear filters
        </a>

    </div>


    <form
        method="GET"
        action="{{ route('admin.verification.index') }}"
        id="verificationFilterForm"
    >

        <div class="vm-filters">


            <!-- =================================================
                 COURSE
            ================================================== -->

            <div class="vm-dropdown">

                <button
                    type="button"
                    class="vm-dropdown-button"
                    onclick="toggleDropdown('courseMenu', this)"
                >

                    <span class="vm-dropdown-label">

                        🎓

                        <span>
                            Courses
                        </span>

                        <span
                            id="courseCount"
                            class="vm-dropdown-count"
                        >
                            {{ count((array) request('course', [])) }}
                        </span>

                    </span>

                    <span class="vm-chevron">
                        ▼
                    </span>

                </button>


                <div
                    id="courseMenu"
                    class="vm-dropdown-menu"
                >

                    @foreach($courses as $course)

                        @php
                            $selectedCourses =
                                (array) request('course', []);
                        @endphp

                        <label class="vm-option">

                            <input
                                type="checkbox"
                                name="course[]"
                                value="{{ $course->course }}"
                                {{ in_array($course->course, $selectedCourses) ? 'checked' : '' }}
                                onchange="submitFilters()"
                            >

                            <span>
                                {{ $course->course }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>


            <!-- =================================================
                 BATCH
            ================================================== -->

            <div class="vm-dropdown">

                <button
                    type="button"
                    class="vm-dropdown-button"
                    onclick="toggleDropdown('batchMenu', this)"
                >

                    <span class="vm-dropdown-label">

                        📅

                        <span>
                            Batch
                        </span>

                        <span
                            id="batchCount"
                            class="vm-dropdown-count"
                        >
                            {{ count((array) request('batch', [])) }}
                        </span>

                    </span>

                    <span class="vm-chevron">
                        ▼
                    </span>

                </button>


                <div
                    id="batchMenu"
                    class="vm-dropdown-menu"
                >

                    @foreach($batches as $batch)

                        @php
                            $selectedBatches =
                                (array) request('batch', []);
                        @endphp

                        <label class="vm-option">

                            <input
                                type="checkbox"
                                name="batch[]"
                                value="{{ $batch->batch_year }}"
                                {{ in_array((string) $batch->batch_year, array_map('strval', $selectedBatches)) ? 'checked' : '' }}
                                onchange="submitFilters()"
                            >

                            <span>
                                {{ $batch->batch_year }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>


            <!-- =================================================
                 VERIFICATION
            ================================================== -->

            <div class="vm-dropdown">

                <button
                    type="button"
                    class="vm-dropdown-button"
                    onclick="toggleDropdown('statusMenu', this)"
                >

                    <span class="vm-dropdown-label">

                        🛡️

                        <span>
                            Verification
                        </span>

                        <span
                            id="statusCount"
                            class="vm-dropdown-count"
                        >
                            {{ count((array) request('verification', [])) }}
                        </span>

                    </span>

                    <span class="vm-chevron">
                        ▼
                    </span>

                </button>


                <div
                    id="statusMenu"
                    class="vm-dropdown-menu"
                >

                    @php
                        $selectedVerification =
                            (array) request('verification', []);
                    @endphp

                    <label class="vm-option">

                        <input
                            type="checkbox"
                            name="verification[]"
                            value="verified"
                            {{ in_array('verified', $selectedVerification) ? 'checked' : '' }}
                            onchange="submitFilters()"
                        >

                        <span>
                            Verified
                        </span>

                    </label>


                    <label class="vm-option">

                        <input
                            type="checkbox"
                            name="verification[]"
                            value="pending"
                            {{ in_array('pending', $selectedVerification) ? 'checked' : '' }}
                            onchange="submitFilters()"
                        >

                        <span>
                            Pending
                        </span>

                    </label>

                </div>

            </div>


            <!-- =================================================
                 BS STATUS
            ================================================== -->

            <div class="vm-dropdown">

                <button
                    type="button"
                    class="vm-dropdown-button"
                    onclick="toggleDropdown('bsMenu', this)"
                >

                    <span class="vm-dropdown-label">

                        🎓

                        <span>
                            BS Status
                        </span>

                        <span
                            id="bsCount"
                            class="vm-dropdown-count"
                        >
                            {{ count((array) request('bs_status', [])) }}
                        </span>

                    </span>

                    <span class="vm-chevron">
                        ▼
                    </span>

                </button>


                <div
                    id="bsMenu"
                    class="vm-dropdown-menu"
                >

                    @php
                        $selectedBS =
                            (array) request('bs_status', []);
                    @endphp

                    <label class="vm-option">

                        <input
                            type="checkbox"
                            name="bs_status[]"
                            value="qualified"
                            {{ in_array('qualified', $selectedBS) ? 'checked' : '' }}
                            onchange="submitFilters()"
                        >

                        <span>
                            Qualified
                        </span>

                    </label>


                    <label class="vm-option">

                        <input
                            type="checkbox"
                            name="bs_status[]"
                            value="not qualified"
                            {{ in_array('not qualified', $selectedBS) ? 'checked' : '' }}
                            onchange="submitFilters()"
                        >

                        <span>
                            Not Qualified
                        </span>

                    </label>

                </div>

            </div>


            <!-- =================================================
                 SEARCH
            ================================================== -->

            <div class="vm-search">

                <span class="vm-search-icon">
                    🔎
                </span>

                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name or TRB number..."
                    autocomplete="off"
                >

                @if(request('search'))

                    <a
                        href="{{ route('admin.verification.index', request()->except('search', 'page')) }}"
                        class="vm-search-clear show"
                    >
                        ×
                    </a>

                @endif

            </div>

        </div>

    </form>

</div>



    <!-- =====================================================
         TABLE
    ====================================================== -->

    <div class="vm-table-wrapper">

        <div class="vm-table-top">

            <div class="vm-table-title">

                <span>
                    👥
                </span>

                Cadet Verification Records

            </div>

            <div
                id="recordCount"
                class="vm-record-count"
            >
                {{ $cadets->total() }} records
            </div>

        </div>


        <div class="vm-scroll">

            <table>

                <thead>

                    <tr>

                        <th>TRB</th>

                        <th>Name</th>

                        <th>Course</th>

                        <th>Batch</th>

                        <th>Requirements</th>

                        <th>Verification</th>

                        <th>BS Status</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                @forelse($cadets as $cadet)

                    @php

                        $required =
                            $cadet->required_documents_count ?? 0;

                        $approved =
                            $cadet->approved_documents_count ?? 0;

                        $progress =
                            $required > 0
                                ? min(
                                    100,
                                    ($approved / $required) * 100
                                )
                                : 0;

                        $isVerified =
                            $required > 0 &&
                            $approved == $required;

                        $bsRequired =
                            $cadet->bs_required_count ?? 0;

                        $bsCompleted =
                            $cadet->bs_completed_count ?? 0;

                        $isBSQualified =
                            $bsRequired > 0 &&
                            $bsCompleted == $bsRequired;

                    @endphp


                    <tr>

                        <!-- TRB -->

                        <td>

                            <span class="vm-trb">
                                {{ $cadet->trb_control_number }}
                            </span>

                        </td>


                        <!-- NAME -->

                        <td>

                            <span class="vm-name">
                                {{ $cadet->full_name }}
                            </span>

                        </td>


                        <!-- COURSE -->

                        <td>
                            {{ $cadet->course }}
                        </td>


                        <!-- BATCH -->

                        <td>
                            {{ optional($cadet->batch)->batch_year ?? '—' }}
                        </td>


                        <!-- REQUIREMENTS -->

                        <td>

                            <div class="vm-requirement">

                                <div class="vm-progress-top">

                                    <span>
                                        Completion
                                    </span>

                                    <span class="vm-progress-number">

                                        {{ $approved }}
                                        /
                                        {{ $required }}

                                    </span>

                                </div>


                                <div class="vm-progress-track">

                                    <div
                                        class="vm-progress-fill"
                                        style="width:{{ $progress }}%"
                                    ></div>

                                </div>

                            </div>

                        </td>


                        <!-- VERIFICATION -->

                        <td>

                            @if($isVerified)

                                <span class="vm-status verified">

                                    <span class="vm-status-dot"></span>

                                    Verified

                                </span>

                            @else

                                <span class="vm-status pending">

                                    <span class="vm-status-dot"></span>

                                    Pending

                                </span>

                            @endif

                        </td>


                        <!-- BS STATUS -->

                        <td>

                            @if($isBSQualified)

                                <span class="vm-status qualified">

                                    <span class="vm-status-dot"></span>

                                    Qualified

                                </span>

                            @else

                                <span class="vm-status not-qualified">

                                    <span class="vm-status-dot"></span>

                                    Not Qualified

                                </span>

                            @endif

                        </td>


                        <!-- ACTION -->

                        <td>

                            <a
                                href="{{ route('admin.verification.show', $cadet->id) }}"
                                class="vm-view-btn"
                            >

                                👁

                                View

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="vm-empty"
                        >

                            <div class="vm-empty-icon">
                                📋
                            </div>

                            <strong>
                                No verification records found
                            </strong>

                            <span>
                                There are currently no cadets matching
                                the available records.
                            </span>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <!-- =====================================================
         PAGINATION
    ====================================================== -->

    @if($cadets->hasPages())

        <div class="vm-pagination">

            <div class="vm-pagination-info">

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


            <div class="vm-pagination-links">

                {{ $cadets->withQueryString()->links() }}

            </div>

        </div>

    @endif

</div>

<script>

/* =========================================================
   DROPDOWNS
========================================================= */

function toggleDropdown(id, button) {

    const menu =
        document.getElementById(id);

    const isOpen =
        menu.classList.contains('show');


    document
        .querySelectorAll('.vm-dropdown-menu')
        .forEach(item => {

            item.classList.remove('show');

        });


    document
        .querySelectorAll('.vm-dropdown-button')
        .forEach(item => {

            item.classList.remove('open');

        });


    if (!isOpen) {

        menu.classList.add('show');

        button.classList.add('open');

    }

}


/* =========================================================
   CLOSE DROPDOWNS
========================================================= */

document.addEventListener(
    'click',
    function (e) {

        if (!e.target.closest('.vm-dropdown')) {

            document
                .querySelectorAll('.vm-dropdown-menu')
                .forEach(menu => {

                    menu.classList.remove('show');

                });


            document
                .querySelectorAll('.vm-dropdown-button')
                .forEach(button => {

                    button.classList.remove('open');

                });

        }

    }
);


/* =========================================================
   SUBMIT FILTERS
========================================================= */

function submitFilters() {

    const form =
        document.getElementById(
            'verificationFilterForm'
        );


    /*
    |---------------------------------------------------------
    | Always return to page 1 when changing filters.
    |---------------------------------------------------------
    */

    const page =
        form.querySelector(
            'input[name="page"]'
        );

    if (page) {

        page.remove();

    }


    form.submit();

}


/* =========================================================
   SEARCH
========================================================= */

const searchInput =
    document.getElementById('search');


if (searchInput) {

    let searchTimer;


    searchInput.addEventListener(
        'input',
        function () {

            clearTimeout(
                searchTimer
            );


            searchTimer =
                setTimeout(
                    function () {

                        submitFilters();

                    },
                    500
                );

        }
    );

}

</script>

@endsection