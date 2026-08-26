@extends('layouts.admin')

@section('header-title', 'Complaint Report')

@section('content')

@vite(['resources/css/admin/reports/complaint.css'])

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<div class="complaint-page">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="cr-header">

        <div class="cr-header-left">

            <div class="cr-header-icon">

                <i class="bi bi-chat-left-text-fill"></i>

            </div>

            <div class="cr-header-text">

                <h2>
                    Complaint Report
                </h2>

                <p>
                    Monitor cadet concerns, complaint status, and resolution progress.
                </p>

            </div>

        </div>


        <div class="cr-header-actions">

            <div class="cr-live-badge">

                <span class="cr-live-dot"></span>

                Live Report

            </div>


            <button
                type="button"
                class="cr-back-btn"
                onclick="window.location.href='{{ route('admin.reports.index') }}'">

                <i class="bi bi-arrow-left"></i>

                Back

            </button>

        </div>

    </div>


    <!-- =====================================================
         STATISTICS
    ====================================================== -->

    <div class="cr-stats">

        <!-- TOTAL -->

        <div class="cr-stat-card cr-total">

            <div class="cr-stat-content">

                <div>

                    <div class="cr-stat-label">
                        Total Concerns
                    </div>

                    <div class="cr-stat-number">
                        {{ $complaints->count() }}
                    </div>

                    <div class="cr-stat-description">
                        Complaints in current report
                    </div>

                </div>


                <div class="cr-stat-icon">

                    <i class="bi bi-chat-left-text-fill"></i>

                </div>

            </div>

        </div>


        <!-- OPEN -->

        <div class="cr-stat-card cr-open">

            <div class="cr-stat-content">

                <div>

                    <div class="cr-stat-label">
                        Open
                    </div>

                    <div class="cr-stat-number">
                        {{ $complaints->where('status', '!=', 'Resolved')->count() }}
                    </div>

                    <div class="cr-stat-description">
                        Concerns requiring action
                    </div>

                </div>


                <div class="cr-stat-icon">

                    <i class="bi bi-exclamation-circle-fill"></i>

                </div>

            </div>

        </div>


        <!-- RESOLVED -->

        <div class="cr-stat-card cr-resolved">

            <div class="cr-stat-content">

                <div>

                    <div class="cr-stat-label">
                        Resolved
                    </div>

                    <div class="cr-stat-number">
                        {{ $complaints->where('status', 'Resolved')->count() }}
                    </div>

                    <div class="cr-stat-description">
                        Successfully resolved concerns
                    </div>

                </div>


                <div class="cr-stat-icon">

                    <i class="bi bi-check-circle-fill"></i>

                </div>

            </div>

        </div>


        <!-- RESOLUTION RATE -->

        <div class="cr-stat-card cr-rate">

            <div class="cr-stat-content">

                <div>

                    <div class="cr-stat-label">
                        Resolution Rate
                    </div>

                    <div class="cr-stat-number">

                        @php

                            $totalComplaints = $complaints->count();

                            $resolvedComplaints =
                                $complaints->where('status', 'Resolved')->count();

                            $resolutionRate =
                                $totalComplaints > 0
                                    ? round(($resolvedComplaints / $totalComplaints) * 100)
                                    : 0;

                        @endphp

                        {{ $resolutionRate }}%

                    </div>

                    <div class="cr-stat-description">
                        Current resolution performance
                    </div>

                </div>


                <div class="cr-stat-icon">

                    <i class="bi bi-graph-up-arrow"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         FILTER PANEL
    ====================================================== -->

    <div class="cr-filter-panel">

        <div class="cr-filter-header">

            <div class="cr-filter-title">

                <div class="cr-filter-title-icon">

                    <i class="bi bi-funnel-fill"></i>

                </div>

                Complaint Filters

            </div>


            <button
                type="button"
                class="cr-clear"
                id="clearFilters">

                <i class="bi bi-arrow-counterclockwise"></i>

                Clear Filters

            </button>

        </div>


        <form
            method="GET"
            action="{{ route('admin.reports.complaint') }}"
            id="filterForm">

            <div class="cr-filters">

                <!-- =================================================
                     COURSE
                ================================================== -->

                <div class="cr-filter-group">

                    <label>

                        <i class="bi bi-mortarboard-fill"></i>

                        Course

                    </label>

                    <select
                        name="course"
                        id="courseFilter">

                        <option value="">
                            All Courses
                        </option>

                        @foreach($courses as $course)

                            <option
                                value="{{ $course->course }}"
                                {{ request('course') == $course->course ? 'selected' : '' }}>

                                {{ $course->course }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- =================================================
                     BATCH
                ================================================== -->

                <div class="cr-filter-group">

                    <label>

                        <i class="bi bi-collection-fill"></i>

                        Batch

                    </label>

                    <select
                        name="batch"
                        id="batchFilter">

                        <option value="">
                            All Batches
                        </option>

                        @foreach($batches as $batch)

                            <option
                                value="{{ $batch->id }}"
                                {{ request('batch') == $batch->id ? 'selected' : '' }}>

                                {{ $batch->batch_year }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- =================================================
                     STATUS
                ================================================== -->

                <div class="cr-filter-group">

                    <label>

                        <i class="bi bi-activity"></i>

                        Status

                    </label>

                    <select
                        name="status"
                        id="statusFilter">

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="Open"
                            {{ request('status') == 'Open' ? 'selected' : '' }}>

                            Open

                        </option>

                        <option
                            value="Resolved"
                            {{ request('status') == 'Resolved' ? 'selected' : '' }}>

                            Resolved

                        </option>

                    </select>

                </div>


                <!-- =================================================
                     SEARCH
                ================================================== -->

                <div class="cr-filter-group cr-search-group">

                    <label>

                        <i class="bi bi-search"></i>

                        Search Cadet

                    </label>

                    <div class="cr-search">

                        <i class="bi bi-search cr-search-icon"></i>

                        <input
                            type="text"
                            name="search"
                            id="searchFilter"
                            value="{{ request('search') }}"
                            placeholder="Search cadet name...">

                        <button
                            type="button"
                            id="clearSearch"
                            class="cr-search-clear">

                            <i class="bi bi-x-lg"></i>

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>


    <!-- =====================================================
         REPORT TABLE
    ====================================================== -->

    <div class="cr-table-wrapper">

        <!-- TABLE TOP -->

        <div class="cr-table-top">

            <div class="cr-table-title">

                <div class="cr-table-title-icon">

                    <i class="bi bi-file-earmark-text-fill"></i>

                </div>

                <span>
                    Concern Summary Report
                </span>

            </div>


            <div class="cr-record-count">

                {{ $complaints->count() }}

                Record{{ $complaints->count() != 1 ? 's' : '' }}

            </div>

        </div>


        <!-- TABLE SCROLL -->

        <div class="cr-scroll">

            <table class="cr-table">

                <thead>

                    <tr>

                        <th>TBR No.</th>

                        <th>Full Name</th>

                        <th>Course</th>

                        <th>Batch</th>

                        <th>Concern Type</th>

                        <th>Date Filed</th>

                        <th>Status</th>

                        <th>Date Resolved</th>

                        <th>Resolution Time</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($complaints as $complaint)

                        @php

                            $dateFiled =
                                $complaint->created_at;

                            $dateResolved =
                                $complaint->resolved_at;

                            $resolutionTime = '-';

                            if($dateFiled && $dateResolved){

                                $resolutionTime =
                                    $dateFiled->diffInDays($dateResolved)
                                    . ' Days';

                            }

                        @endphp


                        <tr>

                            <!-- TBR -->

                            <td>

                                <span class="cr-trb">

                                    TBR-{{ $complaint->id }}

                                </span>

                            </td>


                            <!-- NAME -->

                            <td>

                                <div class="cr-name-cell">

                                    <div class="cr-avatar">

                                        {{
                                            strtoupper(
                                                substr(
                                                    $complaint->cadet->full_name ?? 'N',
                                                    0,
                                                    1
                                                )
                                            )
                                        }}

                                    </div>

                                    <div>

                                        <div class="cr-name">

                                            {{
                                                $complaint->cadet->full_name
                                                ?? 'N/A'
                                            }}

                                        </div>

                                        <small>

                                            Cadet ID #{{ $complaint->cadet->id ?? 'N/A' }}

                                        </small>

                                    </div>

                                </div>

                            </td>


                            <!-- COURSE -->

                            <td>

                                <span class="cr-course">

                                    {{
                                        $complaint->cadet->course
                                        ?? 'N/A'
                                    }}

                                </span>

                            </td>


                            <!-- BATCH -->

                            <td>

                                {{
                                    optional(
                                        $complaint->cadet->batch
                                    )->batch_year
                                    ?? 'N/A'
                                }}

                            </td>


                            <!-- CONCERN -->

                            <td>

                                <span class="cr-concern">

                                    {{
                                        $complaint->subject
                                        ?? 'N/A'
                                    }}

                                </span>

                            </td>


                            <!-- DATE FILED -->

                            <td>

                                <span class="cr-date">

                                    {{
                                        $complaint->created_at
                                            ? $complaint->created_at->format('M d, Y')
                                            : 'N/A'
                                    }}

                                </span>

                            </td>


                            <!-- STATUS -->

                            <td>

                                @if($complaint->status === 'Resolved')

                                    <span class="cr-status resolved">

                                        <span class="cr-status-dot"></span>

                                        Resolved

                                    </span>

                                @else

                                    <span class="cr-status open">

                                        <span class="cr-status-dot"></span>

                                        Open

                                    </span>

                                @endif

                            </td>


                            <!-- DATE RESOLVED -->

                            <td>

                                {{
                                    $dateResolved
                                        ? $dateResolved->format('M d, Y')
                                        : '-'
                                }}

                            </td>


                            <!-- RESOLUTION -->

                            <td>

                                @if($dateResolved)

                                    <span class="cr-resolution">

                                        <i class="bi bi-clock-history"></i>

                                        {{ $resolutionTime }}

                                    </span>

                                @else

                                    <span class="cr-not-resolved">

                                        Pending

                                    </span>

                                @endif

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="cr-empty">

                                <div class="cr-empty-icon">

                                    <i class="bi bi-chat-square-text"></i>

                                </div>

                                <strong>
                                    No Complaint Records Found
                                </strong>

                                <span>
                                    No concerns matched the selected filters.
                                </span>

                            </td>

                        </tr>

                    @endforelse


                    <!-- =================================================
                         TOTAL
                    ================================================== -->

                    @if($complaints->count() > 0)

                        <tr class="cr-total-row">

                            <td colspan="8">

                                Total Concerns

                            </td>

                            <td>

                                {{ $complaints->count() }}

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>


    <!-- =====================================================
         ACTION BAR
    ====================================================== -->

    <div class="cr-action-toolbar">

        <div class="cr-toolbar-title">

            <div class="cr-toolbar-icon">

                <i class="bi bi-file-earmark-bar-graph-fill"></i>

            </div>

            <div>

                <h4>
                    Report Actions
                </h4>

                <small>
                    Export or print the current complaint report.
                </small>

            </div>

        </div>


        <div class="cr-toolbar-buttons">

            <!-- PDF -->

            <a
                href="{{ route('admin.reports.complaint.pdf', request()->all()) }}"
                class="cr-action-btn pdf">

                <i class="bi bi-file-earmark-pdf-fill"></i>

                Export PDF

            </a>


            <!-- PRINT -->

            <button
                type="button"
                class="cr-action-btn print"
                onclick="window.print()">

                <i class="bi bi-printer-fill"></i>

                Print

            </button>


            <!-- REFRESH -->

            <button
                type="button"
                class="cr-action-btn refresh"
                onclick="window.location.reload()">

                <i class="bi bi-arrow-clockwise"></i>

                Refresh

            </button>

        </div>

    </div>

</div>


<!-- =========================================================
     AUTO FILTER SCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function(){

    const filterForm =
        document.getElementById('filterForm');

    const courseFilter =
        document.getElementById('courseFilter');

    const batchFilter =
        document.getElementById('batchFilter');

    const statusFilter =
        document.getElementById('statusFilter');

    const searchFilter =
        document.getElementById('searchFilter');

    const clearFilters =
        document.getElementById('clearFilters');

    const clearSearch =
        document.getElementById('clearSearch');


    /*
    =========================================================
    AUTO SUBMIT
    =========================================================
    */

    function submitFilters(){

        if(!filterForm){
            return;
        }

        filterForm.submit();

    }


    /*
    =========================================================
    DROPDOWN AUTO FILTER
    =========================================================
    */

    if(courseFilter){

        courseFilter.addEventListener(
            'change',
            submitFilters
        );

    }


    if(batchFilter){

        batchFilter.addEventListener(
            'change',
            submitFilters
        );

    }


    if(statusFilter){

        statusFilter.addEventListener(
            'change',
            submitFilters
        );

    }


    /*
    =========================================================
    SEARCH DEBOUNCE
    =========================================================
    */

    let searchTimer = null;


    if(searchFilter){

        searchFilter.addEventListener(
            'input',
            function(){

                clearTimeout(searchTimer);

                const value =
                    this.value.trim();


                /*
                Show / hide X button
                */

                if(clearSearch){

                    if(value.length > 0){

                        clearSearch.classList.add('show');

                    }else{

                        clearSearch.classList.remove('show');

                    }

                }


                /*
                Wait 500ms after typing
                */

                searchTimer = setTimeout(
                    function(){

                        submitFilters();

                    },
                    500
                );

            }
        );


        /*
        Enter = immediately filter
        */

        searchFilter.addEventListener(
            'keydown',
            function(event){

                if(event.key === 'Enter'){

                    event.preventDefault();

                    clearTimeout(searchTimer);

                    submitFilters();

                }

            }
        );

    }


    /*
    =========================================================
    CLEAR SEARCH
    =========================================================
    */

    if(clearSearch){

        clearSearch.addEventListener(
            'click',
            function(){

                if(searchFilter){

                    searchFilter.value = '';

                }

                clearTimeout(searchTimer);

                submitFilters();

            }
        );

    }


    /*
    =========================================================
    CLEAR ALL FILTERS
    =========================================================
    */

    if(clearFilters){

        clearFilters.addEventListener(
            'click',
            function(){

                window.location.href =
                    "{{ route('admin.reports.complaint') }}";

            }
        );

    }


    /*
    =========================================================
    RESTORE SEARCH CLEAR BUTTON
    =========================================================
    */

    if(
        searchFilter &&
        clearSearch &&
        searchFilter.value.trim() !== ''
    ){

        clearSearch.classList.add('show');

    }

});

</script>

@endsection