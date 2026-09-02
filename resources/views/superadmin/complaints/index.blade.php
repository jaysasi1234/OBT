@extends('layouts.superadmin')

@section('header-title', 'Concern Monitoring')

@section('content')

<style>
    /* =========================================================
       CONCERN MONITORING PAGE
    ========================================================= */

    .concern-page {
        width: 100%;
        min-width: 0;
        padding: 0;
        color: #f8fafc;
    }


    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .concern-header {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        margin-bottom: 22px;
        padding: 28px 32px;

        background:
            linear-gradient(
                135deg,
                #315fe0 0%,
                #294fc2 48%,
                #243f9f 100%
            );

        border: 1px solid rgba(147, 197, 253, 0.25);
        border-radius: 20px;

        box-shadow:
            0 12px 30px rgba(15, 23, 42, 0.35),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }

    .concern-header::before {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        right: -70px;
        top: -95px;

        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .concern-header::after {
        content: "";
        position: absolute;
        width: 130px;
        height: 130px;
        right: 90px;
        bottom: -85px;

        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
    }

    .concern-header-content {
        position: relative;
        z-index: 2;
    }

    .concern-header-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        color: #ffffff;
        font-size: 27px;
        font-weight: 750;
        line-height: 1.2;
    }

    .concern-header-title i {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 42px;
        height: 42px;

        border-radius: 12px;
        background: rgba(255, 255, 255, 0.13);

        font-size: 18px;
    }

    .concern-header-subtitle {
        margin: 8px 0 0 54px;
        color: rgba(239, 246, 255, 0.88);
        font-size: 14px;
        line-height: 1.5;
    }


    /* =========================================================
       STAT CARDS
    ========================================================= */

    .concern-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .concern-stat-card {
        position: relative;
        overflow: hidden;

        min-height: 125px;
        padding: 21px 22px;

        background: linear-gradient(
            145deg,
            #142752 0%,
            #101f43 100%
        );

        border: 1px solid rgba(96, 165, 250, 0.14);
        border-radius: 17px;

        box-shadow: 0 8px 22px rgba(2, 6, 23, 0.22);

        transition:
            transform 0.2s ease,
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    .concern-stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(96, 165, 250, 0.28);
        box-shadow: 0 12px 28px rgba(2, 6, 23, 0.3);
    }

    .concern-stat-card::after {
        content: "";
        position: absolute;
        width: 100px;
        height: 100px;
        right: -45px;
        top: -45px;

        border-radius: 50%;
        background: rgba(59, 130, 246, 0.07);
    }

    .concern-stat-card.open-card {
        background: linear-gradient(
            145deg,
            #4c1d35 0%,
            #321a34 100%
        );

        border-color: rgba(248, 113, 113, 0.18);
    }

    .concern-stat-card.open-card::after {
        background: rgba(239, 68, 68, 0.09);
    }

    .concern-stat-card.resolved-card {
        background: linear-gradient(
            145deg,
            #123c39 0%,
            #102e35 100%
        );

        border-color: rgba(74, 222, 128, 0.16);
    }

    .concern-stat-card.resolved-card::after {
        background: rgba(34, 197, 94, 0.09);
    }

    .concern-stat-label {
        position: relative;
        z-index: 2;

        margin: 0 0 10px;

        color: #b9c8e8;
        font-size: 13px;
        font-weight: 600;
    }

    .concern-stat-value {
        position: relative;
        z-index: 2;

        margin: 0;

        color: #ffffff;
        font-size: 30px;
        font-weight: 750;
        line-height: 1;
    }

    .concern-stat-icon {
        position: absolute;
        z-index: 2;

        right: 20px;
        bottom: 18px;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 40px;
        height: 40px;

        border-radius: 12px;
        background: rgba(96, 165, 250, 0.10);
        color: #93c5fd;
    }

    .open-card .concern-stat-icon {
        background: rgba(248, 113, 113, 0.10);
        color: #fca5a5;
    }

    .resolved-card .concern-stat-icon {
        background: rgba(74, 222, 128, 0.10);
        color: #86efac;
    }


    /* =========================================================
       TABLE CARD
    ========================================================= */

    .concern-table-card {
        overflow: hidden;

        background: linear-gradient(
            145deg,
            #101f49 0%,
            #0d1b3e 100%
        );

        border: 1px solid rgba(96, 165, 250, 0.14);
        border-radius: 20px;

        box-shadow: 0 12px 30px rgba(2, 6, 23, 0.25);
    }


    /* =========================================================
       TABLE CARD HEADER
    ========================================================= */

    .concern-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        padding: 22px 24px;

        border-bottom: 1px solid rgba(148, 163, 184, 0.10);
    }

    .concern-table-title {
        margin: 0;
        color: #f8fafc;
        font-size: 17px;
        font-weight: 700;
    }

    .concern-table-subtitle {
        margin: 5px 0 0;
        color: #8fa4c9;
        font-size: 12px;
    }

    .concern-record-count {
        flex-shrink: 0;

        padding: 7px 12px;

        border: 1px solid rgba(96, 165, 250, 0.20);
        border-radius: 999px;

        background: rgba(59, 130, 246, 0.10);

        color: #93c5fd;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }


    /* =========================================================
       FILTERS
    ========================================================= */

    .concern-filter-area {
        padding: 20px 24px;

        border-bottom: 1px solid rgba(148, 163, 184, 0.10);
    }

    .concern-filter-form {
        width: 100%;
    }

    .concern-filters {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) 190px auto;
        gap: 11px;
        align-items: center;
    }

    .concern-input-wrapper {
        position: relative;
    }

    .concern-input-wrapper i {
        position: absolute;
        left: 15px;
        top: 50%;

        transform: translateY(-50%);

        color: #7f95bd;
        font-size: 14px;

        pointer-events: none;
    }

    .concern-filters input,
    .concern-filters select {
        width: 100%;
        height: 46px;

        padding: 0 14px;

        border: 1px solid rgba(96, 165, 250, 0.15);
        border-radius: 10px;

        background: #172955;
        color: #e5edff;

        outline: none;

        font-size: 13px;

        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }

    .concern-filters input {
        padding-left: 42px;
    }

    .concern-filters input::placeholder {
        color: #7185a9;
    }

    .concern-filters input:focus,
    .concern-filters select:focus {
        border-color: rgba(96, 165, 250, 0.55);
        background: #1a2f5e;

        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
    }

    .concern-filters select {
        cursor: pointer;
    }

    .concern-search-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        height: 46px;
        padding: 0 18px;

        border: 1px solid rgba(147, 197, 253, 0.22);
        border-radius: 10px;

        background: linear-gradient(
            135deg,
            #3b82f6,
            #315bd6
        );

        color: #ffffff;
        font-size: 13px;
        font-weight: 700;

        cursor: pointer;

        box-shadow: 0 5px 14px rgba(37, 99, 235, 0.20);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            filter 0.2s ease;
    }

    .concern-search-btn:hover {
        transform: translateY(-1px);
        filter: brightness(1.07);
        box-shadow: 0 7px 18px rgba(37, 99, 235, 0.28);
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .concern-table-wrapper {
        width: 100%;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: #31558f transparent;
    }

    .concern-table-wrapper::-webkit-scrollbar {
        height: 7px;
    }

    .concern-table-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .concern-table-wrapper::-webkit-scrollbar-thumb {
        background: #31558f;
        border-radius: 10px;
    }

    .concern-table {
        width: 100%;
        min-width: 900px;

        border-collapse: collapse;
        border-spacing: 0;
    }

    .concern-table thead {
        background: linear-gradient(
            135deg,
            #315fe0,
            #294fc2
        );
    }

    .concern-table th {
        padding: 14px 15px;

        color: #eaf2ff;
        text-align: left;

        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.04em;
        text-transform: uppercase;

        white-space: nowrap;
    }

    .concern-table td {
        padding: 14px 15px;

        color: #dce7fb;
        font-size: 13px;

        border-bottom: 1px solid rgba(148, 163, 184, 0.08);

        vertical-align: middle;
    }

    .concern-table tbody tr {
        background: rgba(13, 29, 65, 0.55);

        transition: background 0.2s ease;
    }

    .concern-table tbody tr:hover {
        background: rgba(31, 54, 101, 0.70);
    }

    .concern-table tbody tr:last-child td {
        border-bottom: none;
    }


    /* =========================================================
       CADET / TEXT CELLS
    ========================================================= */

    .cadet-name {
        color: #f8fafc;
        font-weight: 650;
    }

    .trb-number {
        color: #9eb4dc;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .course-text {
        color: #b8c8e5;
        white-space: nowrap;
    }

    .concern-subject {
        max-width: 220px;

        color: #dce7fb;
        font-weight: 500;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .date-filed {
        color: #9fb2d3;
        white-space: nowrap;
    }


    /* =========================================================
       STATUS BADGES
    ========================================================= */

    .concern-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 10px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 750;
        line-height: 1;
        white-space: nowrap;
    }

    .concern-status::before {
        content: "";

        width: 6px;
        height: 6px;

        border-radius: 50%;
        background: currentColor;
    }

    .concern-status.open {
        background: rgba(239, 68, 68, 0.13);
        color: #fca5a5;

        border: 1px solid rgba(248, 113, 113, 0.15);
    }

    .concern-status.resolved {
        background: rgba(34, 197, 94, 0.13);
        color: #86efac;

        border: 1px solid rgba(74, 222, 128, 0.15);
    }


    /* =========================================================
       VIEW BUTTON
    ========================================================= */

    .concern-view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        min-width: 72px;
        height: 34px;
        padding: 0 12px;

        border: 1px solid rgba(125, 211, 252, 0.18);
        border-radius: 9px;

        background: linear-gradient(
            135deg,
            #0ea5e9,
            #2563eb
        );

        color: #ffffff;

        font-size: 12px;
        font-weight: 700;

        cursor: pointer;

        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.14);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            filter 0.2s ease;
    }

    .concern-view-btn:hover {
        transform: translateY(-1px);
        filter: brightness(1.07);
        box-shadow: 0 6px 16px rgba(14, 165, 233, 0.23);
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .concern-empty {
        padding: 45px 20px !important;

        text-align: center !important;
        color: #7185a9 !important;
    }

    .concern-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 48px;
        height: 48px;

        margin: 0 auto 12px;

        border-radius: 14px;

        background: rgba(59, 130, 246, 0.08);
        color: #6f8fc8;

        font-size: 18px;
    }

    .concern-empty-title {
        margin: 0;
        color: #b9c8e8;
        font-size: 14px;
        font-weight: 650;
    }

    .concern-empty-text {
        margin: 5px 0 0;
        color: #6f82a6;
        font-size: 12px;
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .concern-pagination {
        padding: 18px 24px;
        border-top: 1px solid rgba(148, 163, 184, 0.08);
    }

    .concern-pagination nav {
        display: flex;
        justify-content: center;
    }


    /* =========================================================
       CUSTOM MODAL
    ========================================================= */

    .custom-modal-overlay {
        position: fixed;
        inset: 0;

        display: none;
        align-items: center;
        justify-content: center;

        width: 100%;
        height: 100%;

        padding: 20px;

        background: rgba(2, 6, 23, 0.76);

        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);

        z-index: 9999;
    }

    .custom-modal-box {
        width: 100%;
        max-width: 580px;
        max-height: 90vh;

        overflow: hidden;
        overflow-y: auto;

        background: linear-gradient(
            145deg,
            #142752 0%,
            #0f1f43 100%
        );

        border: 1px solid rgba(96, 165, 250, 0.18);
        border-radius: 18px;

        color: #ffffff;

        box-shadow:
            0 25px 60px rgba(0, 0, 0, 0.40),
            0 0 0 1px rgba(255, 255, 255, 0.02);

        animation: concernModalPop 0.2s ease;
    }

    @keyframes concernModalPop {
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
        position: relative;
        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        padding: 20px 22px;

        background: linear-gradient(
            135deg,
            #315fe0,
            #294fc2
        );

        border-bottom: 1px solid rgba(147, 197, 253, 0.18);
    }

    .custom-modal-header::after {
        content: "";

        position: absolute;
        width: 130px;
        height: 130px;

        right: -55px;
        top: -70px;

        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .modal-title-area {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        gap: 11px;
    }

    .modal-title-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 38px;
        height: 38px;

        border-radius: 11px;

        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }

    .custom-modal-header h3 {
        margin: 0;

        color: #ffffff;
        font-size: 17px;
        font-weight: 700;
    }

    .modal-title-subtitle {
        margin: 3px 0 0;

        color: rgba(239, 246, 255, 0.76);
        font-size: 11px;
    }

    .close-btn {
        position: relative;
        z-index: 3;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 34px;
        height: 34px;

        padding: 0;

        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 9px;

        background: rgba(255, 255, 255, 0.09);
        color: #ffffff;

        font-size: 15px;

        cursor: pointer;

        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }

    .close-btn:hover {
        background: rgba(255, 255, 255, 0.17);
        transform: rotate(3deg);
    }


    /* =========================================================
       MODAL BODY
    ========================================================= */

    .custom-modal-body {
        padding: 22px;
    }

    .modal-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 13px;
    }

    .modal-detail {
        padding: 14px;

        border: 1px solid rgba(96, 165, 250, 0.10);
        border-radius: 12px;

        background: rgba(23, 41, 85, 0.62);
    }

    .modal-detail.full-width {
        grid-column: 1 / -1;
    }

    .modal-detail-label {
        display: block;

        margin-bottom: 6px;

        color: #7890b8;
        font-size: 10px;
        font-weight: 750;

        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .modal-detail-value {
        color: #edf4ff;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.45;
        word-break: break-word;
    }

    .modal-detail-value.status-value {
        display: inline-flex;
    }

    .modal-description {
        min-height: 125px;
        padding: 14px;

        border: 1px solid rgba(96, 165, 250, 0.10);
        border-radius: 12px;

        background: #0d1b3e;

        color: #c9d7ef;
        font-size: 13px;
        line-height: 1.65;

        white-space: pre-wrap;
        word-break: break-word;
    }

    .modal-description-label {
        margin-bottom: 8px;

        color: #7890b8;
        font-size: 10px;
        font-weight: 750;

        letter-spacing: 0.06em;
        text-transform: uppercase;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1000px) {

        .concern-stats {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .concern-filters {
            grid-template-columns: 1fr 1fr;
        }

        .concern-search-btn {
            width: 100%;
        }
    }


    @media (max-width: 768px) {

        .concern-header {
            padding: 22px;
            border-radius: 16px;
        }

        .concern-header-title {
            font-size: 22px;
        }

        .concern-header-title i {
            width: 38px;
            height: 38px;
        }

        .concern-header-subtitle {
            margin-left: 50px;
        }

        .concern-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .concern-stat-card {
            min-height: 105px;
        }

        .concern-table-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .concern-record-count {
            align-self: flex-start;
        }

        .concern-filter-area {
            padding: 17px;
        }

        .concern-filters {
            grid-template-columns: 1fr;
        }

        .concern-table {
            min-width: 850px;
        }

        .concern-pagination {
            padding: 15px;
            overflow-x: auto;
        }

        .custom-modal-overlay {
            padding: 12px;
        }

        .custom-modal-box {
            max-height: 92vh;
            border-radius: 15px;
        }

        .custom-modal-header {
            padding: 17px;
        }

        .custom-modal-body {
            padding: 17px;
        }

        .modal-detail-grid {
            grid-template-columns: 1fr;
        }

        .modal-detail.full-width {
            grid-column: auto;
        }
    }


    @media (max-width: 480px) {

        .concern-header {
            padding: 19px;
        }

        .concern-header-title {
            font-size: 19px;
        }

        .concern-header-subtitle {
            margin-left: 0;
            margin-top: 9px;
        }

        .concern-header-title i {
            width: 35px;
            height: 35px;
        }

        .concern-stat-card {
            padding: 18px;
        }

        .concern-stat-value {
            font-size: 26px;
        }

        .custom-modal-header h3 {
            font-size: 15px;
        }

        .modal-title-subtitle {
            display: none;
        }
    }
</style>


<div class="concern-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}
    <div class="concern-header">

        <div class="concern-header-content">

            <h2 class="concern-header-title">
                <i class="fa-solid fa-comments"></i>
                Concern Monitoring
            </h2>

            <p class="concern-header-subtitle">
                View and monitor all concern records submitted by cadets.
            </p>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}
    <div class="concern-stats">

        <div class="concern-stat-card">

            <p class="concern-stat-label">
                Total Concerns
            </p>

            <h2 class="concern-stat-value">
                {{ $totalComplaints }}
            </h2>

            <div class="concern-stat-icon">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>

        </div>


        <div class="concern-stat-card open-card">

            <p class="concern-stat-label">
                Open
            </p>

            <h2 class="concern-stat-value">
                {{ $openComplaints }}
            </h2>

            <div class="concern-stat-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>

        </div>


        <div class="concern-stat-card resolved-card">

            <p class="concern-stat-label">
                Resolved
            </p>

            <h2 class="concern-stat-value">
                {{ $resolvedComplaints }}
            </h2>

            <div class="concern-stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE CARD
    ====================================================== --}}
    <div class="concern-table-card">

        {{-- TABLE HEADER --}}
        <div class="concern-table-header">

            <div>
                <h3 class="concern-table-title">
                    Concern Records
                </h3>

                <p class="concern-table-subtitle">
                    Review submitted concerns, status, and filing dates.
                </p>
            </div>

            <div class="concern-record-count">
                {{ $complaints->total() }} Records
            </div>

        </div>


        {{-- =================================================
             FILTER AREA
        ================================================== --}}
        <div class="concern-filter-area">

            <form method="GET" class="concern-filter-form">

                <div class="concern-filters">

                    {{-- SEARCH --}}
                    <div class="concern-input-wrapper">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="text"
                            name="search"
                            placeholder="Search concern or cadet..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- STATUS --}}
                    <select name="status">

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="open"
                            {{ request('status') == 'open' ? 'selected' : '' }}
                        >
                            Open
                        </option>

                        <option
                            value="resolved"
                            {{ request('status') == 'resolved' ? 'selected' : '' }}
                        >
                            Resolved
                        </option>

                    </select>


                    {{-- SEARCH BUTTON --}}
                    <button
                        type="submit"
                        class="concern-search-btn"
                    >
                        <i class="fa-solid fa-filter"></i>
                        Search
                    </button>

                </div>

            </form>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}
        <div class="concern-table-wrapper">

            <table class="concern-table">

                <thead>

                    <tr>
                        <th>TBR No.</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Concern Type</th>
                        <th>Status</th>
                        <th>Date Filed</th>
                        <th>Action</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($complaints as $complaint)

                        <tr>

                            {{-- TBR NUMBER --}}
                            <td>
                                <span class="trb-number">
                                    {{ $complaint->cadet->trb_control_number ?? 'N/A' }}
                                </span>
                            </td>


                            {{-- NAME --}}
                            <td>
                                <span class="cadet-name">
                                    {{ $complaint->cadet->full_name ?? 'N/A' }}
                                </span>
                            </td>


                            {{-- COURSE --}}
                            <td>
                                <span class="course-text">
                                    {{ $complaint->cadet->course ?? 'N/A' }}
                                </span>
                            </td>


                            {{-- CONCERN TYPE --}}
                            <td>

                                <div
                                    class="concern-subject"
                                    title="{{ $complaint->subject }}"
                                >
                                    {{ $complaint->subject }}
                                </div>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span class="concern-status {{ $complaint->status }}">

                                    {{ ucfirst($complaint->status) }}

                                </span>

                            </td>


                            {{-- DATE --}}
                            <td>

                                <span class="date-filed">
                                    {{ $complaint->created_at->format('M d, Y') }}
                                </span>

                            </td>


                            {{-- ACTION --}}
                            <td>

                                <button
                                    type="button"
                                    class="concern-view-btn"
                                    onclick="openModal('modal{{ $complaint->id }}')"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                    View
                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="concern-empty"
                            >

                                <div class="concern-empty-icon">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>

                                <p class="concern-empty-title">
                                    No concerns found
                                </p>

                                <p class="concern-empty-text">
                                    There are no concern records matching your current filters.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}
        @if($complaints->hasPages())

            <div class="concern-pagination">
                {{ $complaints->links() }}
            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     CUSTOM MODALS
     NO BOOTSTRAP REQUIRED
========================================================= --}}

@foreach($complaints as $complaint)

    <div
        id="modal{{ $complaint->id }}"
        class="custom-modal-overlay"
        aria-hidden="true"
    >

        <div
            class="custom-modal-box"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modalTitle{{ $complaint->id }}"
        >

            {{-- MODAL HEADER --}}
            <div class="custom-modal-header">

                <div class="modal-title-area">

                    <div class="modal-title-icon">
                        <i class="fa-solid fa-comment-dots"></i>
                    </div>

                    <div>

                        <h3 id="modalTitle{{ $complaint->id }}">
                            Concern Details
                        </h3>

                        <p class="modal-title-subtitle">
                            Submitted concern information
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="close-btn"
                    aria-label="Close"
                    onclick="closeModal('modal{{ $complaint->id }}')"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>


            {{-- MODAL BODY --}}
            <div class="custom-modal-body">

                <div class="modal-detail-grid">

                    {{-- CADET --}}
                    <div class="modal-detail">

                        <span class="modal-detail-label">
                            Cadet
                        </span>

                        <div class="modal-detail-value">
                            {{ $complaint->cadet->full_name ?? 'N/A' }}
                        </div>

                    </div>


                    {{-- CONCERN TYPE --}}
                    <div class="modal-detail">

                        <span class="modal-detail-label">
                            Concern Type
                        </span>

                        <div class="modal-detail-value">
                            {{ $complaint->subject }}
                        </div>

                    </div>


                    {{-- STATUS --}}
                    <div class="modal-detail">

                        <span class="modal-detail-label">
                            Status
                        </span>

                        <div class="modal-detail-value status-value">

                            <span class="concern-status {{ $complaint->status }}">
                                {{ ucfirst($complaint->status) }}
                            </span>

                        </div>

                    </div>


                    {{-- DATE FILED --}}
                    <div class="modal-detail">

                        <span class="modal-detail-label">
                            Date Filed
                        </span>

                        <div class="modal-detail-value">
                            {{ $complaint->created_at->format('F d, Y h:i A') }}
                        </div>

                    </div>


                    {{-- DESCRIPTION --}}
                    <div class="modal-detail full-width">

                        <div class="modal-description-label">
                            Description
                        </div>

                        <div class="modal-description">
                            {{ $complaint->message ?? 'No description available.' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endforeach


<script>
    /* =========================================================
       CONCERN MODAL FUNCTIONS
    ========================================================= */

    function openModal(id) {

        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');

        document.body.style.overflow = 'hidden';
    }


    function closeModal(id) {

        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');

        document.body.style.overflow = '';
    }


    /* =========================================================
       CLOSE WHEN CLICKING OUTSIDE MODAL
    ========================================================= */

    window.addEventListener('click', function (event) {

        document
            .querySelectorAll('.custom-modal-overlay')
            .forEach(function (modal) {

                if (event.target === modal) {

                    modal.style.display = 'none';
                    modal.setAttribute('aria-hidden', 'true');

                    document.body.style.overflow = '';
                }

            });

    });


    /* =========================================================
       ESC KEY TO CLOSE MODAL
    ========================================================= */

    window.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        document
            .querySelectorAll('.custom-modal-overlay')
            .forEach(function (modal) {

                if (modal.style.display === 'flex') {

                    modal.style.display = 'none';
                    modal.setAttribute('aria-hidden', 'true');

                }

            });

        document.body.style.overflow = '';

    });


    /* =========================================================
       OPEN SELECTED COMPLAINT FROM URL / SERVER
    ========================================================= */

    window.addEventListener('load', function () {

        const params = new URLSearchParams(window.location.search);
        const complaint = params.get('complaint');

        if (!complaint) {
            return;
        }

        const modal = document.getElementById(
            'modal' + complaint
        );

        if (modal) {
            openModal('modal' + complaint);
        }

    });
</script>


@if($selectedComplaint)

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            openModal(
                'modal{{ $selectedComplaint }}'
            );

        });
    </script>

@endif

@endsection