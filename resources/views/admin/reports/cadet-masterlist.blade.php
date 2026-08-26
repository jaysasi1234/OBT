@extends('layouts.admin')

@section('header-title', 'Cadet Masterlist')

@section('content')

@vite(['resources/css/admin/reports/cadet-masterlist.css'])

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>


<div class="container">

    <div class="main">


        {{-- =====================================================
             PAGE HEADER
        ====================================================== --}}

        <div class="header">

            <div class="header-content">

                <h1>
                    📊 Report Dashboard
                </h1>

                <p>
                    Monitor cadets, deployment progress, compliance status,
                    and generate reports from one centralized dashboard.
                </p>

            </div>


            <a
                href="{{ route('admin.reports.index') }}"
                class="btn back-btn"
            >

                <i class="bi bi-arrow-left"></i>

                <span>
                    Back
                </span>

            </a>

        </div>


        {{-- =====================================================
             FILTER CARD
        ====================================================== --}}

        <form
            method="GET"
            action="{{ route('admin.reports.cadet') }}"
            id="filterForm"
        >

            <div class="box">

                <div class="filter-heading">

                    <div class="filter-heading-content">

                        <h2>
                            Filter Reports
                        </h2>

                        <p>
                            Narrow down the report using the filters below.
                        </p>

                    </div>


                    <a
                        href="{{ route('admin.reports.cadet') }}"
                        class="btn btn-blue"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                        Reset Filters

                    </a>

                </div>


                {{-- =================================================
                     FILTER GRID
                ================================================== --}}

                <div class="grid">


                    {{-- COURSE --}}

                    <div>

                        <label for="course">
                            Course
                        </label>

                        <select
                            name="course"
                            id="course"
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


                    {{-- BATCH --}}

                    <div>

                        <label for="batch">
                            Batch
                        </label>

                        <select
                            name="batch"
                            id="batch"
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


                    {{-- DEPLOYMENT STATUS --}}

                    <div>

                        <label for="deployment_status">
                            Deployment Status
                        </label>

                        <select
                            name="deployment_status"
                            id="deployment_status"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="Not Deployed"
                                {{ request('deployment_status') == 'Not Deployed' ? 'selected' : '' }}
                            >
                                Not Deployed
                            </option>

                            <option
                                value="Ongoing"
                                {{ request('deployment_status') == 'Ongoing' ? 'selected' : '' }}
                            >
                                In Deployment
                            </option>

                            <option
                                value="Completed"
                                {{ request('deployment_status') == 'Completed' ? 'selected' : '' }}
                            >
                                Completed
                            </option>

                        </select>

                    </div>


                    {{-- VERIFICATION STATUS --}}

                    <div>

                        <label for="verification_status">
                            Verification Status
                        </label>

                        <select
                            name="verification_status"
                            id="verification_status"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="Verified"
                                {{ request('verification_status') == 'Verified' ? 'selected' : '' }}
                            >
                                Verified
                            </option>

                            <option
                                value="Pending"
                                {{ request('verification_status') == 'Pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="Deficiency"
                                {{ request('verification_status') == 'Deficiency' ? 'selected' : '' }}
                            >
                                Deficiency
                            </option>

                        </select>

                    </div>

                </div>


                {{-- =================================================
                     SEARCH
                ================================================== --}}

                <div class="search-box">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M10 2a8 8 0 105.293 14.293l4.707 4.707 1.414-1.414-4.707-4.707A8 8 0 0010 2zm0 2a6 6 0 110 12 6 6 0 010-12z"
                        />

                    </svg>


                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by Cadet Name..."
                        autocomplete="off"
                    >

                </div>

            </div>

        </form>


        {{-- =====================================================
             REPORT TABLE
        ====================================================== --}}

        <div class="box">


            {{-- =================================================
                 REPORT HEADER
            ================================================== --}}

            <div class="report-heading">

                <div class="report-heading-content">

                    <h2>
                        Cadet Masterlist Report
                    </h2>

                    <p>
                        View cadet deployment, compliance status,
                        and complaints summary.
                    </p>

                </div>


                <div class="total-count">

                    Total Cadets:

                    <strong>
                        {{ $cadets->count() }}
                    </strong>

                </div>

            </div>


            {{-- =================================================
                 TABLE
            ================================================== --}}

            <div class="table-responsive">

                <table>

                    <thead>

                        <tr>

                            <th>
                                TRB No.
                            </th>

                            <th>
                                Cadet Name
                            </th>

                            <th>
                                Course
                            </th>

                            <th>
                                Batch
                            </th>

                            <th>
                                Deployment Progress
                            </th>

                            <th>
                                Boarding Status
                            </th>

                            <th>
                                Verification
                            </th>

                            <th>
                                Concerns
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($cadets as $cadet)


                        <tr>


                            {{-- =================================================
                                 TRB NUMBER
                            ================================================== --}}

                            <td>

                                <span class="trb-number">

                                    {{ $cadet->trb_control_number ?? '-' }}

                                </span>

                            </td>


                            {{-- =================================================
                                 CADET
                            ================================================== --}}

                            <td>

                                <div class="cadet-cell">


                                    <div class="cadet-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $cadet->full_name ?? 'C',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>


                                    <div class="cadet-details">

                                        <span class="cadet-name">

                                            {{ $cadet->full_name ?? '-' }}

                                        </span>

                                        <span class="cadet-id">

                                            Cadet ID:
                                            {{ $cadet->id }}

                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- =================================================
                                 COURSE
                            ================================================== --}}

                            <td>

                                <span class="course-badge">

                                    {{ $cadet->course ?? 'No Course' }}

                                </span>

                            </td>


                            {{-- =================================================
                                 BATCH
                            ================================================== --}}

                            <td>

                                <span class="batch-value">

                                    {{ optional($cadet->batch)->batch_year ?? 'No Batch' }}

                                </span>

                            </td>


                            {{-- =================================================
                                 DEPLOYMENT PROGRESS
                            ================================================== --}}

                            <td>

                                @php

                                    $deploymentPercentage =
                                        (int) ($cadet->deployment_percentage ?? 0);

                                    $deploymentPercentage =
                                        max(
                                            0,
                                            min(
                                                100,
                                                $deploymentPercentage
                                            )
                                        );

                                @endphp


                                <div class="progress-wrapper">


                                    <div class="progress-track">

                                        <div
                                            class="progress-bar"
                                            style="width: {{ $deploymentPercentage }}%;"
                                        ></div>

                                    </div>


                                    <div class="progress-info">

                                        {{ $deploymentPercentage }}%

                                    </div>

                                </div>

                            </td>


                            {{-- =================================================
                                 BOARDING STATUS
                            ================================================== --}}

                            <td>

                                @php

                                    $bs =
                                        $cadet->bs_status;

                                @endphp


                                @if($bs === 'Fully Compliant')

                                    <span class="badge badge-success">

                                        Qualified

                                    </span>


                                @elseif($bs === 'Needs Compliance')

                                    <span class="badge badge-danger">

                                        With Issue

                                    </span>


                                @elseif($bs === 'In Deployment')

                                    <span class="badge badge-info">

                                        In Deployment

                                    </span>


                                @elseif($bs === 'Not Ready')

                                    <span class="badge badge-warning">

                                        Not Ready

                                    </span>


                                @else

                                    <span class="badge badge-secondary">

                                        Pending Review

                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 VERIFICATION
                            ================================================== --}}

                            <td>

                                @php

                                    $verification =
                                        $cadet->verification_status;

                                @endphp


                                @if($verification === 'Verified')

                                    <span class="badge badge-success">

                                        Verified

                                    </span>


                                @elseif($verification === 'Pending')

                                    <span class="badge badge-warning">

                                        Pending

                                    </span>


                                @elseif($verification === 'Deficiency')

                                    <span class="badge badge-danger">

                                        Deficiency

                                    </span>


                                @else

                                    <span class="badge badge-secondary">

                                        Not Submitted

                                    </span>

                                @endif

                            </td>


                            {{-- =================================================
                                 COMPLAINTS / CONCERNS
                            ================================================== --}}

                            <td>

                                @php

                                    $complaintCount =
                                        $cadet->complaints
                                            ? $cadet->complaints->count()
                                            : 0;

                                @endphp


                                @if($complaintCount > 0)

                                    <span class="badge badge-danger">

                                        {{ $complaintCount }}

                                        Concern{{ $complaintCount > 1 ? 's' : '' }}

                                    </span>

                                @else

                                    <span class="badge badge-success">

                                        No Concern

                                    </span>

                                @endif

                            </td>


                        </tr>


                    @empty


                        {{-- =================================================
                             EMPTY STATE
                        ================================================== --}}

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <div class="empty-state-icon">
                                        📋
                                    </div>

                                    <h3>
                                        No Cadets Found
                                    </h3>

                                    <p>
                                        No records matched your selected filters.
                                    </p>

                                </div>

                            </td>

                        </tr>


                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 REPORT FOOTER
            ================================================== --}}

            <div class="report-footer">


                <a
                    href="{{ route(
                        'admin.reports.cadet.pdf',
                        request()->all()
                    ) }}"
                    class="btn btn-purple"
                >

                    <i class="bi bi-file-earmark-pdf"></i>

                    Generate Report

                </a>


                <div class="showing-count">

                    Showing

                    <strong>
                        {{ $cadets->count() }}
                    </strong>

                    record{{ $cadets->count() != 1 ? 's' : '' }}

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     LOADING / FILTER JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const form =
            document.getElementById("filterForm");


        if (!form) {
            return;
        }


        const selects =
            form.querySelectorAll("select");


        const search =
            form.querySelector(
                "input[name='search']"
            );


        /* =====================================================
           LOADING OVERLAY
        ===================================================== */

        function showLoading() {

            if (
                document.getElementById(
                    "loadingOverlay"
                )
            ) {
                return;
            }


            const overlay =
                document.createElement("div");


            overlay.id =
                "loadingOverlay";


            overlay.innerHTML = `

                <div class="loading-card">

                    <div class="spinner"></div>

                    <div class="loading-text">
                        Loading report...
                    </div>

                </div>

            `;


            document.body.appendChild(
                overlay
            );

        }


        /* =====================================================
           SELECT FILTERS
        ===================================================== */

        selects.forEach(
            function (select) {

                select.addEventListener(
                    "change",
                    function () {

                        showLoading();

                        form.submit();

                    }
                );

            }
        );


        /* =====================================================
           SEARCH DEBOUNCE
        ===================================================== */

        let debounce;


        if (search) {

            search.addEventListener(
                "input",
                function () {

                    clearTimeout(
                        debounce
                    );


                    debounce =
                        setTimeout(
                            function () {

                                showLoading();

                                form.submit();

                            },
                            500
                        );

                }
            );

        }


        /* =====================================================
           FORM SUBMIT PROTECTION
        ===================================================== */

        form.addEventListener(
            "submit",
            function () {

                showLoading();

            }
        );

    }
);

</script>

@endsection