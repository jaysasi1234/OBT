@extends('layouts.superadmin')

@section('content')

<style>

/* =========================================================
   PAGE
========================================================= */

.verification-page {
    width: 100%;
    min-width: 0;
}


/* =========================================================
   PAGE HEADER
========================================================= */

.page-header {
    margin-bottom: 20px;
}

.page-header h2 {
    margin: 0;

    color: #ffffff;

    font-size: 22px;
    font-weight: 600;
}


/* =========================================================
   STICKY CONTROLS
========================================================= */

.sticky-controls {

    /*
     * The topbar is 75px.
     *
     * Therefore the sticky section starts BELOW
     * the topbar instead of covering it.
     */
    position: sticky;

    top: 75px;

    /*
     * Lower than the topbar and sidebar.
     */
    z-index: 100;

    width: 100%;

    background: #0f172a;

    padding-bottom: 10px;
}


/* =========================================================
   STATISTICS
========================================================= */

.stats-grid {

    display: grid;

    grid-template-columns:
        repeat(5, minmax(0, 1fr));

    gap: 20px;

    width: 100%;

    margin:
        0
        0
        20px;
}


.stat-card {

    min-width: 0;

    background: #1f1b6b;

    border-radius: 15px;

    padding: 20px;

    color: #ffffff;

    box-shadow:
        0 8px 20px
        rgba(0,0,0,.25);

    transition:
        transform .25s ease;
}


.stat-card:hover {
    transform:
        translateY(-3px);
}


.stat-title {

    color: #cbd5e1;

    font-size: 14px;
    font-weight: 500;

    line-height: 1.4;

    margin-bottom: 10px;
}


.stat-value {

    color: #ffffff;

    font-size: 32px;
    font-weight: 700;

    line-height: 1;
}


.stat-card.total {
    border-left:
        5px solid
        #3b82f6;
}


.stat-card.complete {
    border-left:
        5px solid
        #22c55e;
}


.stat-card.incomplete {
    border-left:
        5px solid
        #ef4444;
}


.stat-card.qualified {
    border-left:
        5px solid
        #10b981;
}


.stat-card.not-qualified {
    border-left:
        5px solid
        #f97316;
}


/* =========================================================
   FILTER
========================================================= */

.filter-container {

    width: 100%;

    background: #1f1b6b;

    padding: 20px;

    border-radius: 15px;

    margin-bottom: 20px;

    box-shadow:
        0 8px 20px
        rgba(0,0,0,.25);
}


.filter-grid {

    display: grid;

    grid-template-columns:
        repeat(5, minmax(0, 1fr));

    gap: 15px;

    width: 100%;
}


.filter-grid input,
.filter-grid select {

    width: 100%;
    min-width: 0;

    height: 46px;

    padding:
        0
        15px;

    border-radius: 10px;

    border:
        1px solid
        rgba(255,255,255,.08);

    background: #111827;

    color: #ffffff;

    font-family: inherit;

    font-size: 14px;

    transition:
        border-color .25s ease,
        box-shadow .25s ease;
}


.filter-grid input::placeholder {
    color: #94a3b8;
}


.filter-grid input:focus,
.filter-grid select:focus {

    outline: none;

    border-color:
        #6366f1;

    box-shadow:
        0 0 0 3px
        rgba(99,102,241,.25);
}


.filter-grid select {
    cursor: pointer;
}


/* =========================================================
   TABLE CARD
========================================================= */

.card-box {

    width: 100%;
    min-width: 0;

    background: #1f1b6b;

    border-radius: 15px;

    padding: 20px;

    box-shadow:
        0 8px 20px
        rgba(0,0,0,.25);
}


/* =========================================================
   TABLE RESPONSIVE
========================================================= */

.table-responsive {

    width: 100%;

    min-width: 0;

    overflow-x: auto;

    overflow-y: visible;

    -webkit-overflow-scrolling: touch;

    scrollbar-width: thin;
}


.table-responsive::-webkit-scrollbar {
    height: 8px;
}


.table-responsive::-webkit-scrollbar-track {
    background:
        rgba(255,255,255,.05);

    border-radius: 10px;
}


.table-responsive::-webkit-scrollbar-thumb {
    background:
        rgba(255,255,255,.20);

    border-radius: 10px;
}


/* =========================================================
   TABLE
========================================================= */

.table-custom {

    width: 100%;

    min-width: 950px;

    border-collapse: collapse;

    table-layout: auto;
}


.table-custom th {

    background: #4f46e5;

    color: #ffffff;

    padding:
        14px;

    text-align: left;

    white-space: nowrap;

    font-size: 14px;

    font-weight: 700;
}


.table-custom td {

    padding:
        14px;

    color: #ffffff;

    border-bottom:
        1px solid
        rgba(255,255,255,.08);

    white-space: nowrap;

    font-size: 14px;
}


.table-custom tbody tr {
    transition:
        background .2s ease;
}


.table-custom tbody tr:hover {

    background:
        rgba(255,255,255,.04);
}


/* =========================================================
   VIEW BUTTON
========================================================= */

.btn-view {

    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 58px;

    background: #0ea5e9;

    color: #ffffff;

    border: none;

    text-decoration: none;

    padding:
        8px
        14px;

    border-radius: 8px;

    cursor: pointer;

    font-family: inherit;

    font-size: 14px;
    font-weight: 500;

    transition:
        background .2s ease,
        transform .2s ease;
}


.btn-view:hover {

    background:
        #0284c7;

    transform:
        translateY(-1px);
}


/* =========================================================
   STATUS
========================================================= */

.status {

    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding:
        6px
        12px;

    border-radius: 20px;

    font-size: 13px;

    font-weight: 600;

    white-space: nowrap;
}


.status.verified {

    background:
        #16a34a;

    color:
        #ffffff;
}


.status.danger {

    background:
        #dc2626;

    color:
        #ffffff;
}


/* =========================================================
   MODAL
========================================================= */

.custom-modal {

    display: none;

    position: fixed;

    inset: 0;

    width: 100%;
    height: 100%;

    background:
        rgba(0,0,0,.75);

    z-index: 5000;

    align-items: center;
    justify-content: center;

    padding: 20px;
}


.custom-modal.show {
    display: flex;
}


.custom-modal-content {

    width: 100%;

    max-width: 700px;

    max-height: 90vh;

    overflow-y: auto;

    background:
        #1f1b6b;

    color: #ffffff;

    border-radius: 15px;

    box-shadow:
        0 10px 30px
        rgba(0,0,0,.50);

    animation:
        modalPop .2s ease;
}


@keyframes modalPop {

    from {

        opacity: 0;

        transform:
            scale(.95);

    }

    to {

        opacity: 1;

        transform:
            scale(1);

    }

}


/* =========================================================
   MODAL HEADER
========================================================= */

.custom-modal-header {

    padding:
        15px
        20px;

    background:
        #4f46e5;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;
}


.custom-modal-header h3 {

    margin: 0;

    color: #ffffff;

    font-size: 18px;

    font-weight: 600;
}


.close-modal {

    display: flex;

    align-items: center;
    justify-content: center;

    width: 35px;
    height: 35px;

    color: #ffffff;

    cursor: pointer;

    font-size: 28px;

    line-height: 1;

    border-radius: 8px;

    transition:
        background .2s ease;
}


.close-modal:hover {

    background:
        rgba(255,255,255,.15);
}


/* =========================================================
   MODAL PHOTO
========================================================= */

.cadet-photo-section {

    width: 100%;

    display: flex;

    align-items: center;
    justify-content: center;

    text-align: center;

    padding:
        25px
        20px
        15px;
}


.cadet-photo-section img {

    display: block;

    width: 130px;
    height: 130px;

    max-width: 130px;
    max-height: 130px;

    border-radius: 50%;

    object-fit: cover;

    border:
        4px solid
        #4f46e5;

    background:
        #312e81;

    box-shadow:
        0 0 0 6px
        rgba(79,70,229,.15),

        0 8px 20px
        rgba(0,0,0,.35);
}


/* =========================================================
   MODAL BODY
========================================================= */

.custom-modal-body {

    padding: 20px;

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 15px;
}


.detail-item {

    min-width: 0;

    background:
        rgba(255,255,255,.05);

    padding: 12px;

    border-radius: 10px;
}


.detail-item strong {

    display: block;

    color: #cbd5e1;

    font-size: 13px;

    margin-bottom: 5px;
}


.detail-item div {

    color: #ffffff;

    font-weight: 500;

    overflow-wrap: anywhere;
}


/* =========================================================
   LARGE DESKTOP
========================================================= */

@media (max-width: 1250px) {

    .stats-grid {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }


    .filter-grid {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 992px) {

    .sticky-controls {

        /*
         * Mobile/tablet topbar height.
         */
        top: 75px;
    }


    .stats-grid {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }


    .filter-grid {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .page-header h2 {
        font-size: 20px;
    }


    .sticky-controls {
        top: 65px;
    }


    .stats-grid {
        grid-template-columns: 1fr;

        gap: 15px;
    }


    .filter-grid {
        grid-template-columns: 1fr;
    }


    .filter-container {
        padding: 15px;
    }


    .card-box {
        padding: 15px;
    }


    .custom-modal {
        padding: 15px;
    }


    .custom-modal-content {
        width: 100%;

        max-height: 95vh;
    }


    .custom-modal-body {
        grid-template-columns: 1fr;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 480px) {

    .stat-card {
        padding: 15px;
    }


    .stat-value {
        font-size: 26px;
    }


    .table-custom {
        min-width: 900px;
    }


    .cadet-photo-section img {

        width: 110px;
        height: 110px;

        max-width: 110px;
        max-height: 110px;
    }


    .custom-modal-header {
        padding:
            12px
            15px;
    }


    .custom-modal-header h3 {
        font-size: 16px;
    }

}

</style>


<div class="verification-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">

        <h2>
            Verification Monitoring
        </h2>

    </div>


    {{-- =====================================================
         STICKY CONTROLS
    ====================================================== --}}

    <div class="sticky-controls">


        {{-- =================================================
             STATISTICS
        ================================================== --}}

        <div class="stats-grid">


            {{-- TOTAL --}}

            <div class="stat-card total">

                <div class="stat-title">
                    Total Cadet Verification
                </div>

                <div class="stat-value">
                    {{ $verificationTotal }}
                </div>

            </div>


            {{-- COMPLETED --}}

            <div class="stat-card complete">

                <div class="stat-title">
                    Completed Requirements/Documents
                </div>

                <div class="stat-value">
                    {{ $completed }}
                </div>

            </div>


            {{-- INCOMPLETE --}}

            <div class="stat-card incomplete">

                <div class="stat-title">
                    Incomplete Requirements/Documents
                </div>

                <div class="stat-value">
                    {{ $incomplete }}
                </div>

            </div>


            {{-- QUALIFIED --}}

            <div class="stat-card qualified">

                <div class="stat-title">
                    Qualified
                </div>

                <div class="stat-value">
                    {{ $qualified }}
                </div>

            </div>


            {{-- NOT QUALIFIED --}}

            <div class="stat-card not-qualified">

                <div class="stat-title">
                    Not Qualified
                </div>

                <div class="stat-value">
                    {{ $notQualified }}
                </div>

            </div>


        </div>


        {{-- =================================================
             FILTERS
        ================================================== --}}

        <div class="filter-container">

            <form
                method="GET"
                id="filterForm"
            >

                <div class="filter-grid">


                    {{-- SEARCH --}}

                    <input
                        type="text"
                        name="search"
                        placeholder="Search Cadet Name"
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >


                    {{-- COURSE --}}

                    <select name="course">

                        <option value="">
                            All Courses
                        </option>


                        @foreach($courses as $course)

                            <option
                                value="{{ $course->course }}"
                                {{ request('course') == $course->course
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                {{ $course->course }}
                            </option>

                        @endforeach

                    </select>


                    {{-- BATCH --}}

                    <select name="batch">

                        <option value="">
                            All Batches
                        </option>


                        @foreach($batches as $batch)

                            <option
                                value="{{ $batch->id }}"
                                {{ request('batch') == $batch->id
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                {{ $batch->batch_year }}
                            </option>

                        @endforeach

                    </select>


                    {{-- VERIFICATION STATUS --}}

                    <select name="verification_status">

                        <option value="">
                            Verification Status
                        </option>


                        <option
                            value="Verified"
                            {{ request('verification_status') == 'Verified'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Verified
                        </option>


                        <option
                            value="Pending"
                            {{ request('verification_status') == 'Pending'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Pending
                        </option>

                    </select>


                    {{-- BS STATUS --}}

                    <select name="bs_status">

                        <option value="">
                            BS Status
                        </option>


                        <option
                            value="Qualified"
                            {{ request('bs_status') == 'Qualified'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Qualified
                        </option>


                        <option
                            value="Not Qualified"
                            {{ request('bs_status') == 'Not Qualified'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Not Qualified
                        </option>

                    </select>


                </div>

            </form>

        </div>


    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="card-box">

        <div class="table-responsive">

            <table class="table-custom">


                <thead>

                    <tr>

                        <th>TRB</th>

                        <th>Name</th>

                        <th>Course</th>

                        <th>Batch</th>

                        <th>Requirements</th>

                        <th>Verification Status</th>

                        <th>BS Status</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($cadets as $cadet)


                        @php


                            /*
                            |=================================================
                            | APPROVED DOCUMENTS
                            |=================================================
                            */

                            $approvedDocuments =
                                $cadet->documents
                                    ->where(
                                        'pivot.status',
                                        'Approved'
                                    )
                                    ->count();


                            /*
                            |=================================================
                            | TOTAL REQUIRED DOCUMENTS
                            |=================================================
                            */

                            $totalDocuments =
                                $cadet->required_documents_count
                                ?? 0;


                            /*
                            |=================================================
                            | PHOTO
                            |=================================================
                            */

                            $cadetName =
                                $cadet->full_name
                                ?? 'Unknown Cadet';


                            $photoUrl =
                                $cadet->photo

                                    ? asset(
                                        'storage/' .
                                        $cadet->photo
                                    )

                                    : 'https://ui-avatars.com/api/?name=' .
                                        urlencode(
                                            $cadetName
                                        ) .
                                        '&background=4f46e5' .
                                        '&color=fff' .
                                        '&size=300';


                            /*
                            |=================================================
                            | BATCH
                            |=================================================
                            */

                            $batchYear =
                                optional(
                                    $cadet->batch
                                )->batch_year
                                ?? 'No Batch';


                            /*
                            |=================================================
                            | VERIFICATION
                            |=================================================
                            */

                            $verificationStatus =
                                $cadet->verification_status
                                ?? 'Pending';


                            /*
                            |=================================================
                            | BS STATUS
                            |=================================================
                            */

                            $bsStatus =
                                $cadet->bs_status
                                ?? 'Not Qualified';

                        @endphp


                        <tr>


                            {{-- TRB --}}

                            <td>

                                {{
                                    $cadet->trb_control_number
                                    ?? '-'
                                }}

                            </td>


                            {{-- NAME --}}

                            <td>

                                {{ $cadetName }}

                            </td>


                            {{-- COURSE --}}

                            <td>

                                {{
                                    $cadet->course
                                    ?? '-'
                                }}

                            </td>


                            {{-- BATCH --}}

                            <td>

                                {{ $batchYear }}

                            </td>


                            {{-- REQUIREMENTS --}}

                            <td>

                                {{ $approvedDocuments }}
                                /
                                {{ $totalDocuments }}

                            </td>


                            {{-- VERIFICATION STATUS --}}

                            <td>

                                @if(
                                    $verificationStatus
                                    === 'Verified'
                                )

                                    <span
                                        class="
                                            status
                                            verified
                                        "
                                    >
                                        Verified
                                    </span>

                                @else

                                    <span
                                        class="
                                            status
                                            danger
                                        "
                                    >
                                        Pending
                                    </span>

                                @endif

                            </td>


                            {{-- BS STATUS --}}

                            <td>

                                @if(
                                    $bsStatus
                                    === 'Qualified'
                                )

                                    <span
                                        class="
                                            status
                                            verified
                                        "
                                    >
                                        Qualified
                                    </span>

                                @else

                                    <span
                                        class="
                                            status
                                            danger
                                        "
                                    >
                                        Not Qualified
                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}

                            <td>

                                <button
                                    type="button"

                                    class="
                                        btn-view
                                        viewVerificationBtn
                                    "

                                    data-name="{{ $cadetName }}"

                                    data-course="{{
                                        $cadet->course
                                        ?? 'N/A'
                                    }}"

                                    data-batch="{{ $batchYear }}"

                                    data-photo="{{ $photoUrl }}"

                                    data-verification="{{ $verificationStatus }}"

                                    data-bs="{{ $bsStatus }}"

                                    data-approved="{{ $approvedDocuments }}"

                                    data-total="{{ $totalDocuments }}"
                                >

                                    View

                                </button>

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="8"
                                style="
                                    text-align:center;
                                    padding:30px;
                                "
                            >

                                No verification records found.

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>

        </div>

    </div>


</div>


{{-- =========================================================
     VERIFICATION MODAL
========================================================= --}}

<div
    id="verificationModal"
    class="custom-modal"
    aria-hidden="true"
>


    <div class="custom-modal-content">


        {{-- HEADER --}}

        <div class="custom-modal-header">

            <h3>
                Cadet Verification Details
            </h3>


            <button
                type="button"
                class="close-modal"
                id="closeVerificationModal"
                aria-label="Close modal"
            >
                &times;
            </button>

        </div>


        {{-- PHOTO --}}

        <div class="cadet-photo-section">

            <img
                id="modal_photo"
                src=""
                alt="Cadet Photo"
            >

        </div>


        {{-- BODY --}}

        <div class="custom-modal-body">


            {{-- NAME --}}

            <div class="detail-item">

                <strong>
                    Name
                </strong>

                <div id="modal_name">
                    -
                </div>

            </div>


            {{-- COURSE --}}

            <div class="detail-item">

                <strong>
                    Course
                </strong>

                <div id="modal_course">
                    -
                </div>

            </div>


            {{-- BATCH --}}

            <div class="detail-item">

                <strong>
                    Batch
                </strong>

                <div id="modal_batch">
                    -
                </div>

            </div>


            {{-- REQUIREMENTS --}}

            <div class="detail-item">

                <strong>
                    Requirements
                </strong>

                <div id="modal_requirements">
                    -
                </div>

            </div>


            {{-- VERIFICATION --}}

            <div class="detail-item">

                <strong>
                    Verification Status
                </strong>

                <div id="modal_verification">
                    -
                </div>

            </div>


            {{-- BS --}}

            <div class="detail-item">

                <strong>
                    BS Status
                </strong>

                <div id="modal_bs">
                    -
                </div>

            </div>


        </div>

    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           MODAL ELEMENTS
        ===================================================== */

        const modal =
            document.getElementById(
                'verificationModal'
            );


        const closeBtn =
            document.getElementById(
                'closeVerificationModal'
            );


        const modalPhoto =
            document.getElementById(
                'modal_photo'
            );


        const modalName =
            document.getElementById(
                'modal_name'
            );


        const modalCourse =
            document.getElementById(
                'modal_course'
            );


        const modalBatch =
            document.getElementById(
                'modal_batch'
            );


        const modalRequirements =
            document.getElementById(
                'modal_requirements'
            );


        const modalVerification =
            document.getElementById(
                'modal_verification'
            );


        const modalBS =
            document.getElementById(
                'modal_bs'
            );


        /* =====================================================
           OPEN MODAL
        ===================================================== */

        document
            .querySelectorAll(
                '.viewVerificationBtn'
            )
            .forEach(
                function (button) {


                    button.addEventListener(
                        'click',
                        function () {


                            const name =
                                this.dataset.name
                                || 'Unknown Cadet';


                            const course =
                                this.dataset.course
                                || 'N/A';


                            const batch =
                                this.dataset.batch
                                || 'No Batch';


                            const approved =
                                this.dataset.approved
                                || '0';


                            const total =
                                this.dataset.total
                                || '0';


                            const verification =
                                this.dataset.verification
                                || 'Pending';


                            const bs =
                                this.dataset.bs
                                || 'Not Qualified';


                            const photo =
                                this.dataset.photo;


                            /* =========================
                               TEXT
                            ========================== */

                            modalName.textContent =
                                name;


                            modalCourse.textContent =
                                course;


                            modalBatch.textContent =
                                batch;


                            modalRequirements.textContent =
                                `${approved} / ${total}`;


                            /* =========================
                               VERIFICATION
                            ========================== */

                            if (
                                verification ===
                                'Verified'
                            ) {

                                modalVerification.innerHTML =
                                    `
                                    <span
                                        class="status verified"
                                    >
                                        Verified
                                    </span>
                                    `;

                            }
                            else {

                                modalVerification.innerHTML =
                                    `
                                    <span
                                        class="status danger"
                                    >
                                        Pending
                                    </span>
                                    `;

                            }


                            /* =========================
                               BS STATUS
                            ========================== */

                            if (
                                bs ===
                                'Qualified'
                            ) {

                                modalBS.innerHTML =
                                    `
                                    <span
                                        class="status verified"
                                    >
                                        Qualified
                                    </span>
                                    `;

                            }
                            else {

                                modalBS.innerHTML =
                                    `
                                    <span
                                        class="status danger"
                                    >
                                        Not Qualified
                                    </span>
                                    `;

                            }


                            /* =========================
                               PHOTO
                            ========================== */

                            modalPhoto.onerror =
                                function () {

                                    this.onerror =
                                        null;

                                    this.src =
                                        'https://ui-avatars.com/api/?name='
                                        +
                                        encodeURIComponent(
                                            name
                                        )
                                        +
                                        '&background=4f46e5'
                                        +
                                        '&color=fff'
                                        +
                                        '&size=300';

                                };


                            modalPhoto.src =
                                photo
                                || 'https://ui-avatars.com/api/?name='
                                +
                                encodeURIComponent(
                                    name
                                )
                                +
                                '&background=4f46e5'
                                +
                                '&color=fff'
                                +
                                '&size=300';


                            /* =========================
                               SHOW
                            ========================== */

                            modal.classList.add(
                                'show'
                            );


                            modal.setAttribute(
                                'aria-hidden',
                                'false'
                            );


                            document.body.style
                                .overflow = 'hidden';

                        }
                    );

                }
            );


        /* =====================================================
           CLOSE MODAL
        ===================================================== */

        function closeModal()
        {

            if (!modal) {
                return;
            }


            modal.classList.remove(
                'show'
            );


            modal.setAttribute(
                'aria-hidden',
                'true'
            );


            document.body.style
                .overflow = '';

        }


        /* =====================================================
           CLOSE BUTTON
        ===================================================== */

        if (closeBtn) {

            closeBtn.addEventListener(
                'click',
                closeModal
            );

        }


        /* =====================================================
           CLICK OUTSIDE
        ===================================================== */

        if (modal) {

            modal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target ===
                        modal
                    ) {

                        closeModal();

                    }

                }
            );

        }


        /* =====================================================
           ESCAPE
        ===================================================== */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key ===
                    'Escape'
                ) {

                    closeModal();

                }

            }
        );


        /* =====================================================
           FILTER FORM
        ===================================================== */

        const form =
            document.getElementById(
                'filterForm'
            );


        if (!form) {
            return;
        }


        /* =====================================================
           SELECT FILTERS
        ===================================================== */

        form
            .querySelectorAll(
                'select'
            )
            .forEach(
                function (select) {

                    select.addEventListener(
                        'change',
                        function () {

                            form.submit();

                        }
                    );

                }
            );


        /* =====================================================
           SEARCH
        ===================================================== */

        const searchInput =
            form.querySelector(
                'input[name="search"]'
            );


        if (!searchInput) {
            return;
        }


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

                            form.submit();

                        },
                        500
                    );

            }
        );

    }
);

</script>


@endsection