@extends('layouts.superadmin')

@section('content')

<style>
/* =========================================================
   VERIFICATION MONITORING
   UI STYLE MATCHED TO DEPLOYMENT MONITORING
   ========================================================= */

.verification-page {
    width: 100%;
    min-width: 0;
    color: #ffffff;
}

/* =========================================================
   PAGE HEADER
   ========================================================= */

.page-header {
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
    padding: 28px 34px;
    border: 1px solid rgba(96, 165, 250, 0.25);
    border-radius: 20px;
    background:
        linear-gradient(
            135deg,
            #3159c9 0%,
            #294aa8 55%,
            #243f91 100%
        );
    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.22);
}

/* Decorative circles */

.page-header::before {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    right: -45px;
    top: -80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
}

.page-header::after {
    content: "";
    position: absolute;
    width: 110px;
    height: 110px;
    left: -45px;
    bottom: -65px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
}

.page-header-content {
    position: relative;
    z-index: 2;
}

.page-header h2 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
    color: #ffffff;
    font-size: 27px;
    font-weight: 700;
    letter-spacing: -0.4px;
}

.page-header-icon {
    font-size: 28px;
}

.page-header p {
    margin: 7px 0 0;
    color: #dbeafe;
    font-size: 15px;
    line-height: 1.5;
}

/* =========================================================
   STICKY CONTROLS
   ========================================================= */

.sticky-controls {
    position: sticky;
    top: 75px;
    z-index: 100;
    width: 100%;
    padding-bottom: 12px;
    background: #0b1a42;
}

/* =========================================================
   STATISTICS
   ========================================================= */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 20px;
    width: 100%;
    margin: 0 0 20px;
}

.stat-card {
    position: relative;
    min-width: 0;
    min-height: 150px;
    overflow: hidden;
    padding: 25px 28px;
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 19px;
    color: #ffffff;
    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.22);
    transition:
        transform 0.25s ease,
        box-shadow 0.25s ease;
}

/* Decorative circle */

.stat-card::after {
    content: "";
    position: absolute;
    width: 145px;
    height: 145px;
    right: -48px;
    top: -45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.07);
}

/* Smaller decorative circle */

.stat-card::before {
    content: "";
    position: absolute;
    width: 85px;
    height: 85px;
    left: -42px;
    bottom: -48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow:
        0 15px 30px rgba(0, 0, 0, 0.28);
}

.stat-card-content {
    position: relative;
    z-index: 2;
}

.stat-title {
    max-width: 80%;
    margin-bottom: 13px;
    color: rgba(255, 255, 255, 0.92);
    font-size: 13px;
    font-weight: 700;
    line-height: 1.4;
    text-transform: uppercase;
    letter-spacing: 0.2px;
}

.stat-value {
    color: #ffffff;
    font-size: 38px;
    font-weight: 800;
    line-height: 1;
}

/* Statistic icons */

.stat-icon {
    position: absolute;
    z-index: 3;
    top: 27px;
    right: 27px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 63px;
    height: 63px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.13);
    backdrop-filter: blur(4px);
    font-size: 28px;
}

/* Individual cards */

.stat-card.total {
    background:
        linear-gradient(
            135deg,
            #3164e6 0%,
            #2852c4 100%
        );
}

.stat-card.complete {
    background:
        linear-gradient(
            135deg,
            #18a957 0%,
            #0d8f43 100%
        );
}

.stat-card.incomplete {
    background:
        linear-gradient(
            135deg,
            #e34b55 0%,
            #c92e3d 100%
        );
}

.stat-card.qualified {
    background:
        linear-gradient(
            135deg,
            #08a7c5 0%,
            #0789ad 100%
        );
}

.stat-card.not-qualified {
    background:
        linear-gradient(
            135deg,
            #475569 0%,
            #344158 100%
        );
}

/* =========================================================
   FILTER CONTAINER
   ========================================================= */

.filter-container {
    width: 100%;
    margin-bottom: 20px;
    padding: 25px 28px 28px;
    border: 1px solid rgba(96, 165, 250, 0.16);
    border-radius: 19px;
    background:
        linear-gradient(
            145deg,
            #101f49 0%,
            #0d1b3e 100%
        );
    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.20);
}

.filter-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    color: #f8fafc;
    font-size: 16px;
    font-weight: 700;
}

.filter-title-icon {
    color: #cbd5e1;
    font-size: 16px;
}

.filter-grid {
    display: grid;
    grid-template-columns: 1.35fr repeat(4, 1fr);
    gap: 15px;
    width: 100%;
}

.filter-field {
    min-width: 0;
}

.filter-grid input,
.filter-grid select {
    width: 100%;
    min-width: 0;
    height: 48px;
    padding: 0 16px;
    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 11px;
    outline: none;
    background: #172955;
    color: #ffffff;
    font-family: inherit;
    font-size: 14px;
    transition:
        border-color 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease;
}

.filter-grid input:hover,
.filter-grid select:hover {
    border-color: rgba(96, 165, 250, 0.35);
    background: #1a2e5e;
}

.filter-grid input:focus,
.filter-grid select:focus {
    border-color: #4f7df3;
    background: #172955;
    box-shadow:
        0 0 0 3px rgba(79, 125, 243, 0.16);
}

.filter-grid input::placeholder {
    color: #9fb0cf;
}

.filter-grid select {
    cursor: pointer;
}

.filter-grid select option {
    background: #172955;
    color: #ffffff;
}

/* =========================================================
   TABLE CARD
   ========================================================= */

.card-box {
    width: 100%;
    min-width: 0;
    overflow: hidden;
    padding: 0;
    border: 1px solid rgba(96, 165, 250, 0.13);
    border-radius: 20px;
    background:
        linear-gradient(
            145deg,
            #101f49 0%,
            #0d1b3e 100%
        );
    box-shadow:
        0 10px 28px rgba(0, 0, 0, 0.22);
}

/* =========================================================
   TABLE HEADER AREA
   ========================================================= */

.table-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 28px 28px 25px;
}

.table-card-title h3 {
    margin: 0;
    color: #f8fafc;
    font-size: 19px;
    font-weight: 700;
}

.table-card-title p {
    margin: 7px 0 0;
    color: #8fa4ca;
    font-size: 14px;
}

.table-scroll-hint {
    flex-shrink: 0;
    color: #8297bd;
    font-size: 12px;
    white-space: nowrap;
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
    scrollbar-color: #3e61b8 rgba(255, 255, 255, 0.05);
}

.table-responsive::-webkit-scrollbar {
    height: 9px;
}

.table-responsive::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.04);
}

.table-responsive::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background: #3e61b8;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #5277d5;
}

/* =========================================================
   TABLE
   ========================================================= */

.table-custom {
    width: 100%;
    min-width: 1050px;
    border-collapse: collapse;
    table-layout: auto;
}

.table-custom thead th {
    padding: 15px 18px;
    border: none;
    background:
        linear-gradient(
            90deg,
            #315fe0 0%,
            #294fc2 100%
        );
    color: #ffffff;
    text-align: left;
    white-space: nowrap;
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.15px;
}

.table-custom tbody {
    background: #1b2d62;
}

.table-custom td {
    padding: 17px 18px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    color: #edf4ff;
    white-space: nowrap;
    font-size: 14px;
    font-weight: 500;
}

.table-custom tbody tr {
    transition:
        background 0.2s ease;
}

.table-custom tbody tr:hover {
    background: rgba(255, 255, 255, 0.045);
}

.table-custom tbody tr:last-child td {
    border-bottom: none;
}

/* =========================================================
   REQUIREMENT COUNT
   ========================================================= */

.requirement-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 60px;
    padding: 7px 12px;
    border: 1px solid rgba(96, 165, 250, 0.20);
    border-radius: 20px;
    background: rgba(96, 165, 250, 0.10);
    color: #dbeafe;
    font-size: 13px;
    font-weight: 700;
}

/* =========================================================
   STATUS BADGES
   ========================================================= */

.status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 90px;
    padding: 7px 13px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.status.verified {
    border: 1px solid rgba(52, 211, 153, 0.30);
    background: rgba(16, 185, 129, 0.13);
    color: #6ee7b7;
}

.status.danger {
    border: 1px solid rgba(248, 113, 113, 0.28);
    background: rgba(239, 68, 68, 0.13);
    color: #fca5a5;
}

/* =========================================================
   VIEW BUTTON
   ========================================================= */

.btn-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 68px;
    padding: 9px 16px;
    border: 1px solid rgba(125, 211, 252, 0.18);
    border-radius: 9px;
    outline: none;
    background:
        linear-gradient(
            135deg,
            #159ed5 0%,
            #087fb8 100%
        );
    color: #ffffff;
    text-decoration: none;
    cursor: pointer;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    box-shadow:
        0 5px 12px rgba(0, 0, 0, 0.15);
    transition:
        transform 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease;
}

.btn-view:hover {
    background:
        linear-gradient(
            135deg,
            #20abe2 0%,
            #0a8ac5 100%
        );
    transform: translateY(-1px);
    box-shadow:
        0 7px 15px rgba(0, 0, 0, 0.22);
}

/* =========================================================
   MODAL
   ========================================================= */

.custom-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 5000;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 20px;
    background: rgba(3, 10, 28, 0.82);
    backdrop-filter: blur(5px);
}

.custom-modal.show {
    display: flex;
}

.custom-modal-content {
    width: 100%;
    max-width: 720px;
    max-height: 90vh;
    overflow-y: auto;
    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 18px;
    background:
        linear-gradient(
            145deg,
            #142652 0%,
            #0e1c3f 100%
        );
    color: #ffffff;
    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.55);
    animation: modalPop 0.22s ease;
}

@keyframes modalPop {
    from {
        opacity: 0;
        transform: translateY(10px) scale(0.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* =========================================================
   MODAL HEADER
   ========================================================= */

.custom-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 18px 22px;
    background:
        linear-gradient(
            135deg,
            #315fe0 0%,
            #294bb1 100%
        );
}

.custom-modal-header h3 {
    margin: 0;
    color: #ffffff;
    font-size: 18px;
    font-weight: 700;
}

.close-modal {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    padding: 0;
    border: none;
    border-radius: 9px;
    background: rgba(255, 255, 255, 0.10);
    color: #ffffff;
    cursor: pointer;
    font-size: 26px;
    line-height: 1;
    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.close-modal:hover {
    background: rgba(255, 255, 255, 0.18);
    transform: rotate(3deg);
}

/* =========================================================
   MODAL PHOTO
   ========================================================= */

.cadet-photo-section {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 28px 20px 20px;
    text-align: center;
}

.cadet-photo-section img {
    display: block;
    width: 125px;
    height: 125px;
    max-width: 125px;
    max-height: 125px;
    border: 4px solid #4f72df;
    border-radius: 50%;
    outline: 6px solid rgba(79, 114, 223, 0.12);
    background: #263b78;
    object-fit: cover;
    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.35);
}

/* =========================================================
   MODAL BODY
   ========================================================= */

.custom-modal-body {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
    padding: 20px 22px 25px;
}

.detail-item {
    min-width: 0;
    padding: 15px;
    border: 1px solid rgba(96, 165, 250, 0.10);
    border-radius: 11px;
    background: rgba(255, 255, 255, 0.045);
}

.detail-item strong {
    display: block;
    margin-bottom: 7px;
    color: #94a9cc;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.detail-item div {
    overflow-wrap: anywhere;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
}

/* =========================================================
   EMPTY TABLE
   ========================================================= */

.empty-state {
    padding: 45px 20px !important;
    color: #91a4c5 !important;
    text-align: center !important;
}

/* =========================================================
   LARGE DESKTOP
   ========================================================= */

@media (max-width: 1400px) {
    .stats-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .filter-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 992px) {
    .sticky-controls {
        top: 75px;
    }

    .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .page-header {
        padding: 24px 26px;
    }

    .page-header h2 {
        font-size: 24px;
    }
}

/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 768px) {
    .sticky-controls {
        top: 65px;
    }

    .page-header {
        padding: 22px 20px;
        border-radius: 16px;
    }

    .page-header h2 {
        font-size: 21px;
    }

    .page-header p {
        font-size: 13px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .stat-card {
        min-height: 135px;
        padding: 22px;
    }

    .stat-value {
        font-size: 34px;
    }

    .stat-icon {
        top: 22px;
        right: 22px;
        width: 56px;
        height: 56px;
        font-size: 24px;
    }

    .filter-container {
        padding: 20px;
        border-radius: 16px;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .table-card-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 22px 20px;
    }

    .table-scroll-hint {
        white-space: normal;
    }

    .card-box {
        border-radius: 16px;
    }

    .custom-modal {
        padding: 12px;
    }

    .custom-modal-content {
        max-height: 94vh;
        border-radius: 15px;
    }

    .custom-modal-body {
        grid-template-columns: 1fr;
        padding: 18px;
    }
}

/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 480px) {
    .page-header {
        margin-bottom: 15px;
        padding: 20px 17px;
    }

    .page-header h2 {
        font-size: 19px;
    }

    .page-header p {
        font-size: 12px;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-title {
        font-size: 12px;
    }

    .stat-value {
        font-size: 30px;
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        font-size: 22px;
    }

    .filter-container {
        padding: 17px;
    }

    .filter-title {
        font-size: 15px;
    }

    .table-custom {
        min-width: 1050px;
    }

    .custom-modal-header {
        padding: 15px 17px;
    }

    .custom-modal-header h3 {
        font-size: 16px;
    }

    .cadet-photo-section img {
        width: 110px;
        height: 110px;
        max-width: 110px;
        max-height: 110px;
    }
}
</style>


<div class="verification-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">

        <div class="page-header-content">

            <h2>
                <span class="page-header-icon">📋</span>
                Verification Monitoring
            </h2>

            <p>
                Monitor cadet requirements, document verification,
                qualification status, and training readiness.
            </p>

        </div>

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

                <div class="stat-card-content">

                    <div class="stat-title">
                        Total Cadet Verification
                    </div>

                    <div class="stat-value">
                        {{ $verificationTotal }}
                    </div>

                </div>

                <div class="stat-icon">
                    📋
                </div>

            </div>


            {{-- COMPLETED --}}

            <div class="stat-card complete">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Completed Requirements
                    </div>

                    <div class="stat-value">
                        {{ $completed }}
                    </div>

                </div>

                <div class="stat-icon">
                    ✓
                </div>

            </div>


            {{-- INCOMPLETE --}}

            <div class="stat-card incomplete">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Incomplete Requirements
                    </div>

                    <div class="stat-value">
                        {{ $incomplete }}
                    </div>

                </div>

                <div class="stat-icon">
                    !
                </div>

            </div>


            {{-- QUALIFIED --}}

            <div class="stat-card qualified">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Qualified
                    </div>

                    <div class="stat-value">
                        {{ $qualified }}
                    </div>

                </div>

                <div class="stat-icon">
                    ✓
                </div>

            </div>


            {{-- NOT QUALIFIED --}}

            <div class="stat-card not-qualified">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Not Qualified
                    </div>

                    <div class="stat-value">
                        {{ $notQualified }}
                    </div>

                </div>

                <div class="stat-icon">
                    ⚠
                </div>

            </div>

        </div>


        {{-- =================================================
             FILTERS
        ================================================== --}}

        <div class="filter-container">

            <div class="filter-title">

                <span class="filter-title-icon">
                    ⚙
                </span>

                Filters

            </div>


            <form
                method="GET"
                id="filterForm"
            >

                <div class="filter-grid">

                    {{-- SEARCH --}}

                    <div class="filter-field">

                        <input
                            type="text"
                            name="search"
                            placeholder="Search Cadet Name"
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >

                    </div>


                    {{-- COURSE --}}

                    <div class="filter-field">

                        <select name="course">

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

                    <div class="filter-field">

                        <select name="batch">

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


                    {{-- VERIFICATION STATUS --}}

                    <div class="filter-field">

                        <select name="verification_status">

                            <option value="">
                                Verification Status
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

                        </select>

                    </div>


                    {{-- BS STATUS --}}

                    <div class="filter-field">

                        <select name="bs_status">

                            <option value="">
                                BS Status
                            </option>

                            <option
                                value="Qualified"
                                {{ request('bs_status') == 'Qualified' ? 'selected' : '' }}
                            >
                                Qualified
                            </option>

                            <option
                                value="Not Qualified"
                                {{ request('bs_status') == 'Not Qualified' ? 'selected' : '' }}
                            >
                                Not Qualified
                            </option>

                        </select>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         TABLE CARD
    ====================================================== --}}

    <div class="card-box">

        {{-- TABLE HEADER --}}

        <div class="table-card-header">

            <div class="table-card-title">

                <h3>
                    Cadet Verification Records
                </h3>

                <p>
                    Review requirements, verification, and qualification status
                </p>

            </div>

            <div class="table-scroll-hint">
                ↔ Scroll horizontally to view all columns
            </div>

        </div>


        {{-- TABLE --}}

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
                            |--------------------------------------------------------------------------
                            | APPROVED DOCUMENTS
                            |--------------------------------------------------------------------------
                            */

                            $approvedDocuments =
                                $cadet->documents
                                    ->where(
                                        'pivot.status',
                                        'Approved'
                                    )
                                    ->count();


                            /*
                            |--------------------------------------------------------------------------
                            | TOTAL REQUIRED DOCUMENTS
                            |--------------------------------------------------------------------------
                            */

                            $totalDocuments =
                                $cadet->required_documents_count
                                ?? 0;


                            /*
                            |--------------------------------------------------------------------------
                            | CADET NAME
                            |--------------------------------------------------------------------------
                            */

                            $cadetName =
                                $cadet->full_name
                                ?? 'Unknown Cadet';


                            /*
                            |--------------------------------------------------------------------------
                            | PHOTO
                            |--------------------------------------------------------------------------
                            */

                            $photoUrl =
                                $cadet->photo
                                    ? asset(
                                        'storage/' . $cadet->photo
                                    )
                                    : 'https://ui-avatars.com/api/?name=' .
                                        urlencode($cadetName) .
                                        '&background=315fe0' .
                                        '&color=fff' .
                                        '&size=300';


                            /*
                            |--------------------------------------------------------------------------
                            | BATCH
                            |--------------------------------------------------------------------------
                            */

                            $batchYear =
                                optional(
                                    $cadet->batch
                                )->batch_year
                                ?? 'No Batch';


                            /*
                            |--------------------------------------------------------------------------
                            | VERIFICATION STATUS
                            |--------------------------------------------------------------------------
                            */

                            $verificationStatus =
                                $cadet->verification_status
                                ?? 'Pending';


                            /*
                            |--------------------------------------------------------------------------
                            | BS STATUS
                            |--------------------------------------------------------------------------
                            */

                            $bsStatus =
                                $cadet->bs_status
                                ?? 'Not Qualified';

                        @endphp


                        <tr>

                            {{-- TRB --}}

                            <td>
                                {{ $cadet->trb_control_number ?? '-' }}
                            </td>


                            {{-- NAME --}}

                            <td>
                                {{ $cadetName }}
                            </td>


                            {{-- COURSE --}}

                            <td>
                                {{ $cadet->course ?? '-' }}
                            </td>


                            {{-- BATCH --}}

                            <td>
                                {{ $batchYear }}
                            </td>


                            {{-- REQUIREMENTS --}}

                            <td>

                                <span class="requirement-count">

                                    {{ $approvedDocuments }}
                                    /
                                    {{ $totalDocuments }}

                                </span>

                            </td>


                            {{-- VERIFICATION STATUS --}}

                            <td>

                                @if($verificationStatus === 'Verified')

                                    <span class="status verified">
                                        Verified
                                    </span>

                                @else

                                    <span class="status danger">
                                        Pending
                                    </span>

                                @endif

                            </td>


                            {{-- BS STATUS --}}

                            <td>

                                @if($bsStatus === 'Qualified')

                                    <span class="status verified">
                                        Qualified
                                    </span>

                                @else

                                    <span class="status danger">
                                        Not Qualified
                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}

                            <td>

                                <button
                                    type="button"
                                    class="btn-view viewVerificationBtn"
                                    data-name="{{ $cadetName }}"
                                    data-course="{{ $cadet->course ?? 'N/A' }}"
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
                                class="empty-state"
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


            {{-- BS STATUS --}}

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
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       MODAL ELEMENTS
    ===================================================== */

    const modal =
        document.getElementById('verificationModal');

    const closeBtn =
        document.getElementById('closeVerificationModal');

    const modalPhoto =
        document.getElementById('modal_photo');

    const modalName =
        document.getElementById('modal_name');

    const modalCourse =
        document.getElementById('modal_course');

    const modalBatch =
        document.getElementById('modal_batch');

    const modalRequirements =
        document.getElementById('modal_requirements');

    const modalVerification =
        document.getElementById('modal_verification');

    const modalBS =
        document.getElementById('modal_bs');


    /* =====================================================
       DEFAULT AVATAR
    ===================================================== */

    function getDefaultAvatar(name) {

        return (
            'https://ui-avatars.com/api/?name=' +
            encodeURIComponent(name) +
            '&background=315fe0' +
            '&color=fff' +
            '&size=300'
        );

    }


    /* =====================================================
       OPEN MODAL
    ===================================================== */

    document
        .querySelectorAll('.viewVerificationBtn')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const name =
                    this.dataset.name ||
                    'Unknown Cadet';

                const course =
                    this.dataset.course ||
                    'N/A';

                const batch =
                    this.dataset.batch ||
                    'No Batch';

                const approved =
                    this.dataset.approved ||
                    '0';

                const total =
                    this.dataset.total ||
                    '0';

                const verification =
                    this.dataset.verification ||
                    'Pending';

                const bs =
                    this.dataset.bs ||
                    'Not Qualified';

                const photo =
                    this.dataset.photo ||
                    getDefaultAvatar(name);


                /* =================================================
                   TEXT
                ================================================= */

                modalName.textContent = name;

                modalCourse.textContent = course;

                modalBatch.textContent = batch;

                modalRequirements.textContent =
                    `${approved} / ${total}`;


                /* =================================================
                   VERIFICATION STATUS
                ================================================= */

                if (verification === 'Verified') {

                    modalVerification.innerHTML = `
                        <span class="status verified">
                            Verified
                        </span>
                    `;

                } else {

                    modalVerification.innerHTML = `
                        <span class="status danger">
                            Pending
                        </span>
                    `;

                }


                /* =================================================
                   BS STATUS
                ================================================= */

                if (bs === 'Qualified') {

                    modalBS.innerHTML = `
                        <span class="status verified">
                            Qualified
                        </span>
                    `;

                } else {

                    modalBS.innerHTML = `
                        <span class="status danger">
                            Not Qualified
                        </span>
                    `;

                }


                /* =================================================
                   PHOTO
                ================================================= */

                modalPhoto.onerror = function () {

                    this.onerror = null;

                    this.src =
                        getDefaultAvatar(name);

                };

                modalPhoto.src = photo;


                /* =================================================
                   SHOW MODAL
                ================================================= */

                modal.classList.add('show');

                modal.setAttribute(
                    'aria-hidden',
                    'false'
                );

                document.body.style.overflow = 'hidden';

            });

        });


    /* =====================================================
       CLOSE MODAL
    ===================================================== */

    function closeModal() {

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';

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
       CLICK OUTSIDE MODAL
    ===================================================== */

    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (event.target === modal) {

                    closeModal();

                }

            }
        );

    }


    /* =====================================================
       ESCAPE KEY
    ===================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                closeModal();

            }

        }
    );


    /* =====================================================
       FILTER FORM
    ===================================================== */

    const form =
        document.getElementById('filterForm');

    if (!form) {
        return;
    }


    /* =====================================================
       SELECT FILTERS
    ===================================================== */

    form
        .querySelectorAll('select')
        .forEach(function (select) {

            select.addEventListener(
                'change',
                function () {

                    form.submit();

                }
            );

        });


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

            clearTimeout(searchTimer);

            searchTimer = setTimeout(
                function () {

                    form.submit();

                },
                500
            );

        }
    );

});
</script>

@endsection