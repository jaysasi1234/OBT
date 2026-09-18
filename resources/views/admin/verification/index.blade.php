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

<form
    method="GET"
    action="{{ route('admin.verification.index') }}"
    id="verificationFilterForm"
    class="vm-filter-panel"
>

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
                        {{ request('course') ? 1 : 0 }}
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

                    <label class="vm-option">

                        <input
                            type="radio"
                            name="course"
                            value="{{ $course->course }}"
                            onchange="submitVerificationFilters()"
                            {{ request('course') == $course->course ? 'checked' : '' }}
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
                        {{ request('batch') ? 1 : 0 }}
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

                    <label class="vm-option">

                        <input
                            type="radio"
                            name="batch"
                            value="{{ $batch->batch_year }}"
                            onchange="submitVerificationFilters()"
                            {{ request('batch') == $batch->batch_year ? 'checked' : '' }}
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
                        {{ request('verification_status') ? 1 : 0 }}
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

                <label class="vm-option">

                    <input
                        type="radio"
                        name="verification_status"
                        value="Verified"
                        onchange="submitVerificationFilters()"
                        {{ request('verification_status') == 'Verified' ? 'checked' : '' }}
                    >

                    <span>
                        Verified
                    </span>

                </label>


                <label class="vm-option">

                    <input
                        type="radio"
                        name="verification_status"
                        value="Pending"
                        onchange="submitVerificationFilters()"
                        {{ request('verification_status') == 'Pending' ? 'checked' : '' }}
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
                        {{ request('bs_status') ? 1 : 0 }}
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

                <label class="vm-option">

                    <input
                        type="radio"
                        name="bs_status"
                        value="Qualified"
                        onchange="submitVerificationFilters()"
                        {{ request('bs_status') == 'Qualified' ? 'checked' : '' }}
                    >

                    <span>
                        Qualified
                    </span>

                </label>


                <label class="vm-option">

                    <input
                        type="radio"
                        name="bs_status"
                        value="Not Qualified"
                        onchange="submitVerificationFilters()"
                        {{ request('bs_status') == 'Not Qualified' ? 'checked' : '' }}
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


            <button
                type="submit"
                class="vm-search-clear"
                id="searchClear"
            >
                ×
            </button>

        </div>

    </div>

</form>



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
    {{ $cadets->total() }}
    {{ $cadets->total() === 1 ? 'record' : 'records' }}
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
    href="{{ route('admin.verification.show', [
        'id' => $cadet->id,
        'course' => request('course'),
        'batch' => request('batch'),
        'verification_status' => request('verification_status'),
        'bs_status' => request('bs_status'),
        'search' => request('search'),
        'page' => request('page'),
    ]) }}"
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


        <!-- =================================================
             PAGINATION
        ================================================== -->

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

                    records

                </div>


                <div class="vm-pagination-links">

                    {{ $cadets->onEachSide(1)->links() }}

                </div>

            </div>

        @endif


    </div>

</div>{{ count($cadets) }} records

<script>

/* =========================================================
   DROPDOWNS
========================================================= */

function toggleDropdown(id, button){

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


    if(!isOpen){

        menu.classList.add('show');

        button.classList.add('open');

    }

}


/* =========================================================
   CLOSE DROPDOWNS
========================================================= */

document.addEventListener(
    'click',
    function(e){

        if(!e.target.closest('.vm-dropdown')){

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

function submitVerificationFilters(){

    const form =
        document.getElementById(
            'verificationFilterForm'
        );


    /*
     * Always return to page 1 when changing filters.
     */

    let pageInput =
        form.querySelector(
            'input[name="page"]'
        );


    if(pageInput){

        pageInput.remove();

    }


    form.submit();

}


/* =========================================================
   SEARCH
========================================================= */

const searchInput =
    document.getElementById('search');


if(searchInput){

    let searchTimer;


    searchInput.addEventListener(
        'input',
        function(){

            clearTimeout(searchTimer);


            searchTimer =
                setTimeout(function(){

                    const form =
                        document.getElementById(
                            'verificationFilterForm'
                        );


                    /*
                     * Do not keep an old pagination page
                     * when searching.
                     */

                    let pageInput =
                        form.querySelector(
                            'input[name="page"]'
                        );


                    if(pageInput){

                        pageInput.remove();

                    }


                    form.submit();

                }, 500);

        }
    );

}


/* =========================================================
   INITIALIZE FILTER COUNTS
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function(){

        updateFilterCount(
            'courseCount',
            '{{ request('course') }}'
        );


        updateFilterCount(
            'batchCount',
            '{{ request('batch') }}'
        );


        updateFilterCount(
            'statusCount',
            '{{ request('verification_status') }}'
        );


        updateFilterCount(
            'bsCount',
            '{{ request('bs_status') }}'
        );

    }
);


/* =========================================================
   FILTER COUNT
========================================================= */

function updateFilterCount(
    elementId,
    value
){

    const element =
        document.getElementById(elementId);


    if(!element){

        return;

    }


    const button =
        element.closest('.vm-dropdown')
            ?.querySelector(
                '.vm-dropdown-button'
            );


    if(value){

        element.innerText = '1';

        element.classList.add('show');

        if(button){

            button.classList.add('active');

        }

    }else{

        element.innerText = '0';

        element.classList.remove('show');

        if(button){

            button.classList.remove('active');

        }

    }

}

/* =========================================================
   INITIALIZE
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function(){

        updateFilterCounts();


        const rows =
            document.querySelectorAll(
                'tbody tr'
            );


        let count = 0;


        rows.forEach(row => {

            if(!row.querySelector('.vm-empty')){

                count++;

            }

        });


        updateRecordCount(count);

    }
);

</script>

@endsection