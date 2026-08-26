@extends('layouts.admin')

@section('header-title', 'Verification Report')

@section('content')

@vite(['resources/css/admin/reports/verification.css'])

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>


<div class="verification-page">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <div class="vm-header">

        <div class="vm-header-left">

            <div class="vm-header-icon">

                <i class="bi bi-patch-check-fill"></i>

            </div>

            <div class="vm-header-text">

                <h2>
                    Verification Status Report
                </h2>

                <p>
                    Monitor cadet verification progress, document compliance,
                    and boarding readiness.
                </p>

            </div>

        </div>


        <div style="display:flex;align-items:center;gap:10px;position:relative;z-index:3;">

            <div class="vm-header-badge">

                <span class="vm-header-dot"></span>

                Live Report

            </div>


            <a
                href="{{ route('admin.reports.index') }}"
                class="vm-back-btn"
            >

                <i class="bi bi-arrow-left"></i>

                Back

            </a>

        </div>

    </div>


    <!-- =====================================================
         STATISTICS
    ====================================================== -->

    <div class="vm-stats">

        <!-- TOTAL -->

        <div class="vm-card vm-total">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Total Cadets
                    </div>

                    <div class="vm-card-number">
                        {{ $cadets->count() }}
                    </div>

                    <div class="vm-card-description">
                        Registered cadets in report
                    </div>

                </div>

                <div class="vm-card-icon">

                    <i class="bi bi-people-fill"></i>

                </div>

            </div>

        </div>


        <!-- VERIFIED -->

        <div class="vm-card vm-completed">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Verified
                    </div>

                    <div class="vm-card-number">
                        {{ $verified }}
                    </div>

                    <div class="vm-card-description">
                        Fully verified cadets
                    </div>

                </div>

                <div class="vm-card-icon">

                    <i class="bi bi-patch-check-fill"></i>

                </div>

            </div>

        </div>


        <!-- PENDING -->

        <div class="vm-card vm-incomplete">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Pending
                    </div>

                    <div class="vm-card-number">
                        {{ $pending }}
                    </div>

                    <div class="vm-card-description">
                        Awaiting verification
                    </div>

                </div>

                <div class="vm-card-icon">

                    <i class="bi bi-hourglass-split"></i>

                </div>

            </div>

        </div>


        <!-- DEFICIENCY -->

        <div class="vm-card vm-qualified">

            <div class="vm-card-content">

                <div>

                    <div class="vm-card-label">
                        Deficiency
                    </div>

                    <div class="vm-card-number">
                        {{ $deficiency }}
                    </div>

                    <div class="vm-card-description">
                        Requires compliance
                    </div>

                </div>

                <div class="vm-card-icon">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         FILTER PANEL
    ====================================================== -->

    <div class="vm-filter-panel" id="verificationFilterPanel">

        <form
            method="GET"
            action="{{ route('admin.reports.verification') }}"
            id="verificationFilterForm"
        >

            <div class="vm-filter-header">

                <div class="vm-filter-title">

                    <span class="vm-filter-title-icon">

                        <i class="bi bi-funnel-fill"></i>

                    </span>

                    Filter Verification Report

                </div>


                <a
                    href="{{ route('admin.reports.verification') }}"
                    class="vm-clear"
                    id="clearFilters"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Clear Filters

                </a>

            </div>


            <div class="vm-filters">


                <!-- =================================================
                     COURSE
                ================================================== -->

                <div class="vm-filter-group">

                    <label class="vm-filter-label">
                        Course
                    </label>

                    <select
                        name="course"
                        id="filterCourse"
                        class="vm-select"
                    >

                        <option value="">
                            All Courses
                        </option>

                        @foreach($courses as $course)

                            <option
                                value="{{ $course->course }}"
                                {{ request('course') == $course->course ? 'selected' : '' }}
                            >

                                {{ $course->course }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- =================================================
                     BATCH
                ================================================== -->

                <div class="vm-filter-group">

                    <label class="vm-filter-label">
                        Batch
                    </label>

                    <select
                        name="batch"
                        id="filterBatch"
                        class="vm-select"
                    >

                        <option value="">
                            All Batches
                        </option>

                        @foreach($batches as $batch)

                            <option
                                value="{{ $batch->id }}"
                                {{ request('batch') == $batch->id ? 'selected' : '' }}
                            >

                                {{ $batch->batch_year }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- =================================================
                     STATUS
                ================================================== -->

                <div class="vm-filter-group">

                    <label class="vm-filter-label">
                        Verification Status
                    </label>

                    <select
                        name="status"
                        id="filterStatus"
                        class="vm-select"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="Verified"
                            {{ request('status') == 'Verified' ? 'selected' : '' }}
                        >
                            Verified
                        </option>

                        <option
                            value="Pending"
                            {{ request('status') == 'Pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="Deficiency"
                            {{ request('status') == 'Deficiency' ? 'selected' : '' }}
                        >
                            Deficiency
                        </option>

                    </select>

                </div>


                <!-- =================================================
                     SEARCH
                ================================================== -->

                <div class="vm-filter-group">

                    <label class="vm-filter-label">
                        Search Cadet
                    </label>

                    <div class="vm-search">

                        <i class="bi bi-search vm-search-icon"></i>

                        <input
                            type="text"
                            name="search"
                            id="filterSearch"
                            value="{{ request('search') }}"
                            placeholder="Search cadet name..."
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            class="vm-search-clear"
                            id="searchClear"
                            title="Clear search"
                        >

                            <i class="bi bi-x-lg"></i>

                        </button>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 AUTO FILTER STATUS
            ================================================== -->

            <div
                class="vm-filter-status"
                id="filterStatusMessage"
            >

                <span class="vm-filter-status-dot"></span>

                <span id="filterStatusText">
                    Filters update automatically
                </span>

            </div>

        </form>

    </div>


    <!-- =====================================================
         TABLE
    ====================================================== -->

    <div class="vm-table-wrapper">

        <!-- TABLE HEADER -->

        <div class="vm-table-top">

            <div>

                <div class="vm-table-title">

                    <i class="bi bi-table"></i>

                    Verification Status Report

                </div>

                <p class="vm-table-subtitle">

                    Review verification progress and document compliance.

                </p>

            </div>


            <div class="vm-record-count">

                {{ $cadets->count() }}

                Record{{ $cadets->count() != 1 ? 's' : '' }}

            </div>

        </div>


        <!-- TABLE SCROLL -->

        <div class="vm-scroll">

            <table class="vm-table">

                <thead>

                    <tr>

                        <th>
                            TRB No.
                        </th>

                        <th>
                            Full Name
                        </th>

                        <th>
                            Course
                        </th>

                        <th>
                            Batch
                        </th>

                        <th>
                            Verification Status
                        </th>

                        <th>
                            Missing Documents
                        </th>

                        <th>
                            Last Uploaded
                        </th>

                        <th>
                            BS Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($cadets as $cadet)

                        <tr>


                            <!-- =================================================
                                 TRB
                            ================================================== -->

                            <td>

                                <span class="vm-trb">

                                    {{ $cadet->trb_control_number }}

                                </span>

                            </td>


                            <!-- =================================================
                                 NAME
                            ================================================== -->

                            <td>

                                <div class="vm-cadet">

                                    <div class="vm-avatar">

                                        {{ strtoupper(substr($cadet->full_name ?? 'C', 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="vm-cadet-name">

                                            {{ $cadet->full_name }}

                                        </div>

                                        <div class="vm-cadet-id">

                                            Cadet ID #{{ $cadet->id }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            <!-- =================================================
                                 COURSE
                            ================================================== -->

                            <td>

                                <span class="vm-course">

                                    {{ $cadet->course ?? 'N/A' }}

                                </span>

                            </td>


                            <!-- =================================================
                                 BATCH
                            ================================================== -->

                            <td>

                                {{ optional($cadet->batch)->batch_year ?? 'N/A' }}

                            </td>


                            <!-- =================================================
                                 VERIFICATION STATUS
                            ================================================== -->

                            <td>

                                @if($cadet->verification_status === 'Verified')

                                    <span class="vm-status verified">

                                        <span class="vm-status-dot"></span>

                                        <i class="bi bi-check-circle-fill"></i>

                                        Verified

                                    </span>

                                @elseif($cadet->verification_status === 'Pending')

                                    <span class="vm-status pending">

                                        <span class="vm-status-dot"></span>

                                        <i class="bi bi-clock-fill"></i>

                                        Pending

                                    </span>

                                @else

                                    <span class="vm-status deficiency">

                                        <span class="vm-status-dot"></span>

                                        <i class="bi bi-exclamation-circle-fill"></i>

                                        Deficiency

                                    </span>

                                @endif

                            </td>


                            <!-- =================================================
                                 MISSING DOCUMENTS
                            ================================================== -->

                            <td>

                                @if($cadet->missing_documents)

                                    <span class="vm-missing">

                                        <i class="bi bi-exclamation-circle-fill"></i>

                                        {{ $cadet->missing_documents }}

                                    </span>

                                @else

                                    <span class="vm-complete">

                                        <i class="bi bi-check-circle-fill"></i>

                                        None

                                    </span>

                                @endif

                            </td>


                            <!-- =================================================
                                 LAST UPLOADED
                            ================================================== -->

                            <td>

                                {{ optional($cadet->updated_at)->format('M d, Y') ?? 'N/A' }}

                            </td>


                            <!-- =================================================
                                 BS STATUS
                            ================================================== -->

                            <td>

                                <span class="vm-bs-status">

                                    <i class="bi bi-file-earmark-check"></i>

                                    {{ $cadet->bs_status ?? 'N/A' }}

                                </span>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="vm-empty"
                            >

                                <div class="vm-empty-icon">

                                    <i class="bi bi-folder2-open"></i>

                                </div>

                                <strong>
                                    No Verification Records Found
                                </strong>

                                <span>
                                    No cadets matched the selected filters.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <!-- =====================================================
         REPORT ACTION CENTER
    ====================================================== -->

    <div class="vm-action-toolbar">

        <div class="vm-action-title">

            <div class="vm-action-icon">

                <i class="bi bi-file-earmark-bar-graph-fill"></i>

            </div>

            <div>

                <strong>
                    Report Actions
                </strong>

                <small>
                    Export or refresh the current verification report.
                </small>

            </div>

        </div>


        <div class="vm-action-buttons">

            <!-- PDF -->

            <a
                href="{{ route('admin.reports.verification.pdf', request()->all()) }}"
                class="vm-action-btn vm-pdf"
            >

                <i class="bi bi-file-earmark-pdf-fill"></i>

                Export PDF

            </a>


            <!-- REFRESH -->

            <button
                type="button"
                class="vm-action-btn vm-refresh"
                onclick="window.location.reload();"
            >

                <i class="bi bi-arrow-clockwise"></i>

                Refresh

            </button>

        </div>

    </div>

</div>


<!-- =========================================================
     AUTO FILTER JAVASCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function(){

    const form =
        document.getElementById('verificationFilterForm');

    const course =
        document.getElementById('filterCourse');

    const batch =
        document.getElementById('filterBatch');

    const status =
        document.getElementById('filterStatus');

    const search =
        document.getElementById('filterSearch');

    const searchClear =
        document.getElementById('searchClear');

    const clearFilters =
        document.getElementById('clearFilters');

    const panel =
        document.getElementById('verificationFilterPanel');

    const statusMessage =
        document.getElementById('filterStatusMessage');

    const statusText =
        document.getElementById('filterStatusText');


    let searchTimer = null;


    /* =====================================================
       UPDATE SEARCH CLEAR BUTTON
    ===================================================== */

    function updateSearchClear(){

        if(!search || !searchClear){

            return;

        }

        if(search.value.trim() !== ''){

            searchClear.classList.add('show');

        }else{

            searchClear.classList.remove('show');

        }

    }


    /* =====================================================
       SHOW FILTERING STATUS
    ===================================================== */

    function showFiltering(){

        if(statusMessage){

            statusMessage.classList.add('loading');

        }

        if(statusText){

            statusText.textContent =
                'Updating verification report...';

        }

        if(panel){

            panel.classList.add('vm-filtering');

        }

    }


    /* =====================================================
       SUBMIT FILTER
    ===================================================== */

    function submitFilters(){

        if(!form){

            return;

        }

        showFiltering();

        form.submit();

    }


    /* =====================================================
       SELECT AUTO FILTER
    ===================================================== */

    if(course){

        course.addEventListener('change', function(){

            submitFilters();

        });

    }


    if(batch){

        batch.addEventListener('change', function(){

            submitFilters();

        });

    }


    if(status){

        status.addEventListener('change', function(){

            submitFilters();

        });

    }


    /* =====================================================
       SEARCH AUTO FILTER
       Debounce prevents request on every keystroke
    ===================================================== */

    if(search){

        search.addEventListener('input', function(){

            updateSearchClear();


            clearTimeout(searchTimer);


            searchTimer = setTimeout(function(){

                submitFilters();

            }, 500);

        });

    }


    /* =====================================================
       CLEAR SEARCH ONLY
    ===================================================== */

    if(searchClear){

        searchClear.addEventListener('click', function(){

            search.value = '';

            updateSearchClear();

            submitFilters();

        });

    }


    /* =====================================================
       CLEAR ALL FILTERS
    ===================================================== */

    if(clearFilters){

        clearFilters.addEventListener('click', function(event){

            event.preventDefault();

            window.location.href =
                "{{ route('admin.reports.verification') }}";

        });

    }


    /* =====================================================
       INITIAL STATE
    ===================================================== */

    updateSearchClear();

});

</script>

@endsection