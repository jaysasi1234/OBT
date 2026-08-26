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

            <button
                type="button"
                class="vm-clear"
                onclick="clearFilters()"
            >
                Clear filters
            </button>

        </div>


        <div class="vm-filters">


            <!-- COURSE -->

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
                            0
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
                                type="checkbox"
                                value="{{ strtolower(trim($course->course)) }}"
                                onchange="filter()"
                            >

                            <span>
                                {{ $course->course }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>


            <!-- BATCH -->

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
                            0
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
                                type="checkbox"
                                value="{{ strtolower($batch->batch_year) }}"
                                onchange="filter()"
                            >

                            <span>
                                {{ $batch->batch_year }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>


            <!-- VERIFICATION -->

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
                            0
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
                            type="checkbox"
                            value="verified"
                            onchange="filter()"
                        >

                        <span>
                            Verified
                        </span>

                    </label>


                    <label class="vm-option">

                        <input
                            type="checkbox"
                            value="pending"
                            onchange="filter()"
                        >

                        <span>
                            Pending
                        </span>

                    </label>

                </div>

            </div>


            <!-- BS STATUS -->

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
                            0
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
                            type="checkbox"
                            value="qualified"
                            onchange="filter()"
                        >

                        <span>
                            Qualified
                        </span>

                    </label>


                    <label class="vm-option">

                        <input
                            type="checkbox"
                            value="not qualified"
                            onchange="filter()"
                        >

                        <span>
                            Not Qualified
                        </span>

                    </label>

                </div>

            </div>


            <!-- SEARCH -->

            <div class="vm-search">

                <span class="vm-search-icon">
                    🔎
                </span>

                <input
                    type="text"
                    id="search"
                    placeholder="Search by name or TRB number..."
                    autocomplete="off"
                >

                <button
                    type="button"
                    id="searchClear"
                    class="vm-search-clear"
                    onclick="clearSearch()"
                >
                    ×
                </button>

            </div>

        </div>

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
                {{ count($cadets) }} records
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

</div>


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
   CHECKED VALUES
========================================================= */

function getChecked(id){

    return Array.from(

        document.querySelectorAll(
            `#${id} input:checked`
        )

    ).map(input =>

        input.value
            .toLowerCase()
            .trim()

    );

}


/* =========================================================
   FILTER
========================================================= */

function filter(){

    const courses =
        getChecked('courseMenu');

    const batches =
        getChecked('batchMenu');

    const statuses =
        getChecked('statusMenu');

    const bsStatuses =
        getChecked('bsMenu');

    const search =
        document
            .getElementById('search')
            .value
            .toLowerCase()
            .trim();


    let visible = 0;


    document
        .querySelectorAll('tbody tr')
        .forEach(row => {

            /*
             * Ignore empty-state row
             */

            if(row.querySelector('.vm-empty')){

                return;

            }


            const trb =
                row.children[0]
                    .innerText
                    .toLowerCase()
                    .trim();


            const name =
                row.children[1]
                    .innerText
                    .toLowerCase()
                    .trim();


            const course =
                row.children[2]
                    .innerText
                    .toLowerCase()
                    .trim();


            const batch =
                row.children[3]
                    .innerText
                    .toLowerCase()
                    .trim();


            const verification =
                row.children[5]
                    .innerText
                    .toLowerCase()
                    .trim();


            const bs =
                row.children[6]
                    .innerText
                    .toLowerCase()
                    .trim();


            const matchCourse =
                courses.length === 0 ||
                courses.includes(course);


            const matchBatch =
                batches.length === 0 ||
                batches.includes(batch);


            const matchVerification =
                statuses.length === 0 ||
                statuses.includes(verification);


            const matchBS =
                bsStatuses.length === 0 ||
                bsStatuses.includes(bs);


            const matchSearch =
                search === '' ||
                name.includes(search) ||
                trb.includes(search);


            const show =
                matchCourse &&
                matchBatch &&
                matchVerification &&
                matchBS &&
                matchSearch;


            row.style.display =
                show ? '' : 'none';


            if(show){

                visible++;

            }

        });


    updateFilterCounts();

    updateRecordCount(visible);

}


/* =========================================================
   FILTER COUNTS
========================================================= */

function updateFilterCounts(){

    updateCount(
        'courseMenu',
        'courseCount'
    );

    updateCount(
        'batchMenu',
        'batchCount'
    );

    updateCount(
        'statusMenu',
        'statusCount'
    );

    updateCount(
        'bsMenu',
        'bsCount'
    );

}


function updateCount(menuId, countId){

    const checked =
        document.querySelectorAll(
            `#${menuId} input:checked`
        );


    const count =
        document.getElementById(countId);


    const button =
        count.closest('.vm-dropdown')
            .querySelector(
                '.vm-dropdown-button'
            );


    if(checked.length > 0){

        count.innerText =
            checked.length;

        count.classList.add('show');

        button.classList.add('active');

    }else{

        count.classList.remove('show');

        button.classList.remove('active');

    }

}


/* =========================================================
   RECORD COUNT
========================================================= */

function updateRecordCount(count){

    const element =
        document.getElementById(
            'recordCount'
        );


    element.innerText =
        `${count} ${count === 1 ? 'record' : 'records'}`;

}


/* =========================================================
   SEARCH
========================================================= */

const searchInput =
    document.getElementById('search');


const searchClear =
    document.getElementById('searchClear');


searchInput.addEventListener(
    'input',
    function(){

        searchClear.classList.toggle(
            'show',
            this.value.length > 0
        );


        filter();

    }
);


/* =========================================================
   CLEAR SEARCH
========================================================= */

function clearSearch(){

    searchInput.value = '';

    searchClear.classList.remove(
        'show'
    );

    filter();

    searchInput.focus();

}


/* =========================================================
   CLEAR ALL FILTERS
========================================================= */

function clearFilters(){

    document
        .querySelectorAll(
            '.vm-dropdown-menu input[type="checkbox"]'
        )
        .forEach(input => {

            input.checked = false;

        });


    searchInput.value = '';

    searchClear.classList.remove(
        'show'
    );


    filter();

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