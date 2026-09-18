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

<div id="verificationResults">

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
                {{ $cadets->total() }}
                {{ $cadets->total() == 1 ? 'record' : 'records' }}
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

                            <td>
                                <span class="vm-trb">
                                    {{ $cadet->trb_control_number }}
                                </span>
                            </td>


                            <td>
                                <span class="vm-name">
                                    {{ $cadet->full_name }}
                                </span>
                            </td>


                            <td>
                                {{ $cadet->course }}
                            </td>


                            <td>
                                {{ optional($cadet->batch)->batch_year ?? '—' }}
                            </td>


                            <td>

                                <div class="vm-requirement">

                                    <div class="vm-progress-top">

                                        <span>
                                            Completion
                                        </span>

                                        <span class="vm-progress-number">
                                            {{ $approved }}/{{ $required }}
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


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}

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

(function () {

    'use strict';


    /* =========================================================
       ELEMENTS
    ========================================================== */

    const filterForm =
        document.getElementById(
            'verificationFilterForm'
        );

    const verificationResults =
        document.getElementById(
            'verificationResults'
        );

    const searchInput =
        document.getElementById(
            'search'
        );


    /* =========================================================
       REQUEST CONTROL
    ========================================================== */

    let filterRequest = null;

    let searchTimer = null;


    /* =========================================================
       DROPDOWNS
    ========================================================== */

    window.toggleDropdown = function (
        id,
        button
    ) {

        const menu =
            document.getElementById(id);

        if (!menu) {
            return;
        }


        const isOpen =
            menu.classList.contains('show');


        /*
         * Close every dropdown first.
         */

        document
            .querySelectorAll(
                '.vm-dropdown-menu'
            )
            .forEach(function (item) {

                item.classList.remove('show');

            });


        document
            .querySelectorAll(
                '.vm-dropdown-button'
            )
            .forEach(function (item) {

                item.classList.remove('open');

            });


        /*
         * Open selected dropdown.
         */

        if (!isOpen) {

            menu.classList.add('show');

            button.classList.add('open');

        }

    };


    /* =========================================================
       CLOSE DROPDOWNS WHEN CLICKING OUTSIDE
    ========================================================== */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !event.target.closest(
                    '.vm-dropdown'
                )
            ) {

                document
                    .querySelectorAll(
                        '.vm-dropdown-menu'
                    )
                    .forEach(function (menu) {

                        menu.classList.remove(
                            'show'
                        );

                    });


                document
                    .querySelectorAll(
                        '.vm-dropdown-button'
                    )
                    .forEach(function (button) {

                        button.classList.remove(
                            'open'
                        );

                    });

            }

        }
    );


    /* =========================================================
       GET FILTER PARAMETERS
    ========================================================== */

    function getFilterParams() {

        const params =
            new URLSearchParams();


        if (!filterForm) {
            return params;
        }


        /*
         * IMPORTANT:
         *
         * FormData automatically preserves
         * multiple values such as:
         *
         * course[]=BSMT
         * course[]=BSMARE
         */

        const formData =
            new FormData(filterForm);


        for (
            const [
                key,
                value
            ]
            of formData.entries()
        ) {

            const cleanValue =
                String(value).trim();


            /*
             * Ignore empty values.
             */

            if (
                cleanValue === ''
            ) {
                continue;
            }


            /*
             * Always start filtering
             * from page 1.
             */

            if (
                key === 'page'
            ) {
                continue;
            }


            params.append(
                key,
                cleanValue
            );

        }


        return params;

    }


    /* =========================================================
       BUILD URL
    ========================================================== */

    function buildFilterUrl() {

        const params =
            getFilterParams();


        const queryString =
            params.toString();


        return (
            window.location.pathname +
            (
                queryString
                    ? '?' + queryString
                    : ''
            )
        );

    }


    /* =========================================================
       UPDATE DROPDOWN COUNTS
    ========================================================== */

    function updateFilterCounts() {

        const courseCount =
            document.querySelectorAll(
                'input[name="course[]"]:checked'
            ).length;


        const batchCount =
            document.querySelectorAll(
                'input[name="batch[]"]:checked'
            ).length;


        const verificationCount =
            document.querySelectorAll(
                'input[name="verification[]"]:checked'
            ).length;


        const bsCount =
            document.querySelectorAll(
                'input[name="bs_status[]"]:checked'
            ).length;


        const courseCounter =
            document.getElementById(
                'courseCount'
            );

        const batchCounter =
            document.getElementById(
                'batchCount'
            );

        const verificationCounter =
            document.getElementById(
                'statusCount'
            );

        const bsCounter =
            document.getElementById(
                'bsCount'
            );


        if (courseCounter) {

            courseCounter.textContent =
                courseCount;

        }


        if (batchCounter) {

            batchCounter.textContent =
                batchCount;

        }


        if (verificationCounter) {

            verificationCounter.textContent =
                verificationCount;

        }


        if (bsCounter) {

            bsCounter.textContent =
                bsCount;

        }

    }


    /* =========================================================
       LOAD FILTERED RESULTS
       WITHOUT PAGE REFRESH
    ========================================================== */

    async function applyFilters() {

        if (
            !verificationResults
        ) {

            return;

        }


        const url =
            buildFilterUrl();


        /*
         * Cancel previous request.
         */

        if (filterRequest) {

            filterRequest.abort();

        }


        filterRequest =
            new AbortController();


        /*
         * Loading state.
         */

        verificationResults.classList.add(
            'is-loading'
        );


        try {

            const response =
                await fetch(
                    url,
                    {
                        method: 'GET',

                        headers: {

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'text/html'

                        },

                        signal:
                            filterRequest.signal

                    }
                );


            if (!response.ok) {

                throw new Error(
                    'Failed to load verification records.'
                );

            }


            const html =
                await response.text();


            /*
             * Convert returned HTML
             * into a temporary document.
             */

            const parser =
                new DOMParser();


            const documentHTML =
                parser.parseFromString(
                    html,
                    'text/html'
                );


            /*
             * Find AJAX container
             * inside Laravel response.
             */

            const newResults =
                documentHTML.getElementById(
                    'verificationResults'
                );


            if (!newResults) {

                throw new Error(
                    'Verification results container not found.'
                );

            }


            /*
             * Replace ONLY the results.
             *
             * The page itself does NOT reload.
             */

            verificationResults.innerHTML =
                newResults.innerHTML;


            /*
             * Update browser URL
             * without refreshing.
             */

            window.history.pushState(
                {
                    verificationFilters: true
                },
                '',
                url
            );


            /*
             * Refresh filter counters.
             */

            updateFilterCounts();


        }
        catch (error) {

            /*
             * Ignore cancelled requests.
             */

            if (
                error.name !==
                'AbortError'
            ) {

                console.error(
                    'Verification filter error:',
                    error
                );

            }

        }
        finally {

            verificationResults.classList.remove(
                'is-loading'
            );

            filterRequest = null;

        }

    }


    /* =========================================================
       FILTER CHECKBOX EVENTS
    ========================================================== */

    document.addEventListener(
        'change',
        function (event) {

            const checkbox =
                event.target.closest(
                    'input[type="checkbox"]'
                );


            if (!checkbox) {
                return;
            }


            /*
             * Only process Verification filters.
             */

            const isVerificationFilter =
                checkbox.name === 'course[]' ||
                checkbox.name === 'batch[]' ||
                checkbox.name === 'verification[]' ||
                checkbox.name === 'bs_status[]';


            if (!isVerificationFilter) {
                return;
            }


            updateFilterCounts();

            applyFilters();

        }
    );


    /* =========================================================
       SEARCH
    ========================================================== */

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(
                    searchTimer
                );


                searchTimer =
                    setTimeout(
                        function () {

                            applyFilters();

                        },
                        400
                    );

            }
        );


        /*
         * Search immediately on Enter.
         */

        searchInput.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Enter'
                ) {

                    event.preventDefault();


                    clearTimeout(
                        searchTimer
                    );


                    applyFilters();

                }

            }
        );

    }


    /* =========================================================
       PAGINATION
       WITHOUT PAGE REFRESH
    ========================================================== */

    verificationResults?.addEventListener(
        'click',
        function (event) {

            const link =
                event.target.closest(
                    '.vm-pagination-links a'
                );


            if (!link) {
                return;
            }


            event.preventDefault();


            loadPaginationPage(
                link.href
            );

        }
    );


    /* =========================================================
       LOAD PAGINATION PAGE
    ========================================================== */

    async function loadPaginationPage(
        pageUrl
    ) {

        if (
            !verificationResults
        ) {

            return;

        }


        /*
         * Cancel previous request.
         */

        if (filterRequest) {

            filterRequest.abort();

        }


        filterRequest =
            new AbortController();


        verificationResults.classList.add(
            'is-loading'
        );


        try {

            const response =
                await fetch(
                    pageUrl,
                    {
                        method: 'GET',

                        headers: {

                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'text/html'

                        },

                        signal:
                            filterRequest.signal

                    }
                );


            if (!response.ok) {

                throw new Error(
                    'Failed to load verification pagination.'
                );

            }


            const html =
                await response.text();


            const parser =
                new DOMParser();


            const documentHTML =
                parser.parseFromString(
                    html,
                    'text/html'
                );


            const newResults =
                documentHTML.getElementById(
                    'verificationResults'
                );


            if (!newResults) {

                throw new Error(
                    'Verification results container not found.'
                );

            }


            /*
             * Replace table + pagination.
             */

            verificationResults.innerHTML =
                newResults.innerHTML;


            /*
             * Update URL.
             */

            window.history.pushState(
                {
                    verificationFilters: true
                },
                '',
                pageUrl
            );


            /*
             * Keep the page position
             * around the table.
             */

            verificationResults.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });


        }
        catch (error) {

            if (
                error.name !==
                'AbortError'
            ) {

                console.error(
                    'Verification pagination error:',
                    error
                );

            }

        }
        finally {

            verificationResults.classList.remove(
                'is-loading'
            );

            filterRequest = null;

        }

    }


    /* =========================================================
       BROWSER BACK / FORWARD
    ========================================================== */

    window.addEventListener(
        'popstate',
        function () {

            /*
             * Reload the results using
             * the current URL.
             */

            loadPaginationPage(
                window.location.href
            );


            /*
             * Synchronize checkboxes
             * with URL.
             */

            const params =
                new URLSearchParams(
                    window.location.search
                );


            document
                .querySelectorAll(
                    'input[name="course[]"]'
                )
                .forEach(function (checkbox) {

                    checkbox.checked =
                        params
                            .getAll('course[]')
                            .includes(
                                checkbox.value
                            );

                });


            document
                .querySelectorAll(
                    'input[name="batch[]"]'
                )
                .forEach(function (checkbox) {

                    checkbox.checked =
                        params
                            .getAll('batch[]')
                            .includes(
                                checkbox.value
                            );

                });


            document
                .querySelectorAll(
                    'input[name="verification[]"]'
                )
                .forEach(function (checkbox) {

                    checkbox.checked =
                        params
                            .getAll('verification[]')
                            .includes(
                                checkbox.value
                            );

                });


            document
                .querySelectorAll(
                    'input[name="bs_status[]"]'
                )
                .forEach(function (checkbox) {

                    checkbox.checked =
                        params
                            .getAll('bs_status[]')
                            .includes(
                                checkbox.value
                            );

                });


            if (searchInput) {

                searchInput.value =
                    params.get('search') || '';

            }


            updateFilterCounts();

        }
    );


    /* =========================================================
       CLEAR FILTERS
    ========================================================== */

    const clearButton =
        document.querySelector(
            '.vm-clear'
        );


    if (clearButton) {

        clearButton.addEventListener(
            'click',
            function (event) {

                event.preventDefault();


                /*
                 * Uncheck all filters.
                 */

                document
                    .querySelectorAll(
                        'input[type="checkbox"]'
                    )
                    .forEach(function (checkbox) {

                        checkbox.checked = false;

                    });


                /*
                 * Clear search.
                 */

                if (searchInput) {

                    searchInput.value = '';

                }


                updateFilterCounts();


                /*
                 * Load first page
                 * through AJAX.
                 */

                const clearUrl =
                    clearButton.href;


                loadPaginationPage(
                    clearUrl
                );

            }
        );

    }


    /* =========================================================
       INITIALIZE COUNTERS
    ========================================================== */

    updateFilterCounts();

})();

</script>

@endsection