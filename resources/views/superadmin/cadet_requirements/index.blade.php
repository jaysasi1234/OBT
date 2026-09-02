@extends('layouts.superadmin')

@section('header-title', 'Cadet Requirement Monitoring')

@section('content')

<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .page {
        width: 100%;
        min-height: 100vh;
        padding: 30px;
        background: #07152f;
        color: #ffffff;
    }

    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .page-header h2 {
        margin: 0;
        color: #ffffff;
        font-size: 30px;
        font-weight: 800;
    }

    .page-header h2 i {
        color: #60a5fa;
    }

    .page-header p {
        margin: 8px 0 0;
        color: #b8c7e6;
        font-size: 15px;
    }

    /* =========================================================
       SUMMARY CARDS
    ========================================================= */

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 22px;
        background: #2d2a67;
        border: 1px solid rgba(129, 140, 248, 0.18);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
    }

    .summary-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        border-radius: 16px;
        font-size: 25px;
    }

    .icon-blue {
        background: rgba(59, 130, 246, 0.18);
        color: #60a5fa;
    }

    .icon-green {
        background: rgba(34, 197, 94, 0.18);
        color: #4ade80;
    }

    .icon-yellow {
        background: rgba(234, 179, 8, 0.18);
        color: #facc15;
    }

    .icon-red {
        background: rgba(239, 68, 68, 0.18);
        color: #f87171;
    }

    .summary-card h3 {
        margin: 0;
        color: #ffffff;
        font-size: 28px;
        font-weight: 800;
    }

    .summary-card span {
        color: #b8c7e6;
        font-size: 14px;
    }

    /* =========================================================
       FILTER TOOLBAR
    ========================================================= */

    .monitor-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
        padding: 20px;
        background: #2d2a67;
        border: 1px solid rgba(129, 140, 248, 0.18);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .search-box {
        flex: 1;
        min-width: 220px;
    }

    .search-box input {
        width: 100%;
        padding: 13px 16px;
        background: #07152f;
        border: 1px solid rgba(129, 140, 248, 0.25);
        border-radius: 12px;
        outline: none;
        color: #ffffff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .search-box input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.20);
    }

    .search-box input::placeholder {
        color: #94a3c7;
    }

    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filters select {
        min-width: 170px;
        padding: 12px 15px;
        background: #07152f;
        border: 1px solid rgba(129, 140, 248, 0.25);
        border-radius: 12px;
        outline: none;
        color: #ffffff;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filters select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.20);
    }

    .filters select option {
        background: #0d2042;
        color: #ffffff;
    }

    /* =========================================================
       TABLE
    ========================================================= */

    .card {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        background: #2d2a67;
        border: 1px solid rgba(129, 140, 248, 0.18);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.30);
    }

    .table {
        width: 100%;
        min-width: 1000px;
        margin: 0;
        background: #2d2a67;
        border-collapse: collapse;
    }

    .table thead {
        background: #4f46e5;
        color: #ffffff;
    }

    .table th {
        padding: 16px;
        text-align: center;
        white-space: nowrap;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .table td {
        padding: 16px;
        background: #2d2a67;
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        color: #f8fafc;
    }

    .table tbody tr {
        transition: background 0.2s ease;
    }

    .table tbody tr:hover td {
        background: rgba(99, 102, 241, 0.12);
        color: #ffffff;
    }

    .table small {
        color: #b8c7e6 !important;
    }

    /* =========================================================
       PROGRESS
    ========================================================= */

    .progress-wrap {
        min-width: 180px;
    }

    .progress-bar {
        width: 100%;
        height: 10px;
        overflow: hidden;
        background: #18264a;
        border: 1px solid rgba(129, 140, 248, 0.15);
        border-radius: 50px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        border-radius: 50px;
        transition: width 0.3s ease;
    }

    /* =========================================================
       BUTTONS
    ========================================================= */

    .btn-primary {
        padding: 10px 18px;
        background: #4f46e5;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        color: #ffffff;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background: #6366f1;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-primary i {
        margin-right: 5px;
    }

    /* =========================================================
       EMPTY TABLE STATE
    ========================================================= */

    .table tbody tr td[colspan] {
        padding: 40px 20px;
        background: #2d2a67;
        color: #b8c7e6 !important;
        font-size: 15px;
    }

    /* =========================================================
       MODALS
    ========================================================= */

    .modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(3, 10, 28, 0.82);
    }

    .modal-content {
        width: 950px;
        max-width: calc(100vw - 40px);
        max-height: 90vh;
        overflow-y: auto;
        padding: 30px;
        box-sizing: border-box;
        background: #2d2a67;
        border: 1px solid rgba(129, 140, 248, 0.25);
        border-radius: 22px;
        color: #ffffff;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.50);
    }

    /* =========================================================
       MODAL HEADER
    ========================================================= */

    .modal-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.20);
    }

    .modal-header-custom h3 {
        margin: 0;
        color: #ffffff;
        font-size: 24px;
        font-weight: 800;
    }

    .modal-header-custom h3 i {
        color: #60a5fa;
    }

    /* =========================================================
       CLOSE BUTTON
    ========================================================= */

    .close-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #18264a;
        border: 1px solid rgba(148, 163, 184, 0.15);
        border-radius: 50%;
        color: #dbeafe;
        font-size: 20px;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .close-btn:hover {
        background: #dc2626;
        color: #ffffff;
    }

    /* =========================================================
       EMPTY REQUIREMENTS
    ========================================================= */

    .empty-requirements {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 0;
        height: auto;
        padding: 30px 20px;
        background: #2d2a67;
        border-radius: 15px;
        text-align: center;
        color: #b8c7e6;
    }

    .empty-requirements i {
        margin-bottom: 12px;
        color: #60a5fa;
        font-size: 40px;
    }

    .empty-requirements h5 {
        margin: 0 0 6px;
        color: #ffffff;
        font-size: 18px;
        font-weight: 700;
    }

    .empty-requirements p {
        margin: 0;
        color: #b8c7e6;
        font-size: 14px;
    }

    /* =========================================================
       REQUIREMENT CARD
    ========================================================= */

    .requirement-card {
        margin-bottom: 20px;
        padding: 22px;
        background: #242257;
        border: 1px solid rgba(129, 140, 248, 0.18);
        border-radius: 18px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .requirement-card:hover {
        border-color: rgba(129, 140, 248, 0.30);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    }

    /* =========================================================
       REQUIREMENT HEADER
    ========================================================= */

    .req-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 20px;
    }

    .req-header h3 {
        margin: 0;
        color: #ffffff;
        font-size: 19px;
        font-weight: 800;
    }

    .req-header h3 i {
        color: #60a5fa;
    }

    /* =========================================================
       REQUIREMENT STATUS
    ========================================================= */

    .requirement-status {
        padding: 7px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-approved {
        background: rgba(34, 197, 94, 0.18);
        border: 1px solid rgba(74, 222, 128, 0.20);
        color: #4ade80;
    }

    .status-submitted {
        background: rgba(59, 130, 246, 0.18);
        border: 1px solid rgba(96, 165, 250, 0.20);
        color: #60a5fa;
    }

    .status-pending {
        background: rgba(234, 179, 8, 0.18);
        border: 1px solid rgba(250, 204, 21, 0.20);
        color: #facc15;
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.18);
        border: 1px solid rgba(248, 113, 113, 0.20);
        color: #f87171;
    }

    /* =========================================================
       REQUIREMENT INFORMATION
    ========================================================= */

    .req-body {
        padding: 18px;
        background: #07152f;
        border: 1px solid rgba(129, 140, 248, 0.12);
        border-radius: 14px;
    }

    .req-body p {
        margin: 0 0 10px;
        color: #b8c7e6;
    }

    .req-body p:last-child {
        margin-bottom: 0;
    }

    .req-body strong {
        color: #ffffff;
    }

    /* =========================================================
       ATTACHMENT
    ========================================================= */

    .attachment-section {
        margin-top: 20px;
        padding: 18px;
        background: #07152f;
        border: 1px solid rgba(129, 140, 248, 0.12);
        border-radius: 15px;
    }

    .attachment-title {
        margin-bottom: 12px;
        color: #ffffff;
        font-weight: 700;
    }

    .attachment-section button,
    .attachment-section a {
        padding: 9px 15px;
        border-radius: 10px;
    }

    /* =========================================================
       VIEW ONLY FOOTER
    ========================================================= */

    .req-footer {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .req-footer button {
        flex: 1;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
    }

    .view-only {
        width: 100%;
        padding: 12px;
        background: #18264a;
        border: 1px solid rgba(129, 140, 248, 0.15);
        border-radius: 12px;
        color: #b8c7e6;
        font-weight: 600;
        text-align: center;
    }

    /* =========================================================
       PREVIEW
    ========================================================= */

    .preview-container {
        width: 100%;
        min-height: 400px;
        padding: 15px;
        box-sizing: border-box;
        background: #07152f;
        border: 1px solid rgba(129, 140, 248, 0.12);
        border-radius: 15px;
    }

    .preview-image {
        display: block;
        width: 100%;
        border-radius: 15px;
    }

    .preview-frame {
        width: 100%;
        height: 650px;
        border: none;
        border-radius: 15px;
    }

    /* =========================================================
       BOOTSTRAP OVERRIDES
    ========================================================= */

    .text-primary {
        color: #60a5fa !important;
    }

    .text-muted {
        color: #b8c7e6 !important;
    }

    .alert-danger {
        background: rgba(220, 38, 38, 0.15);
        border: 1px solid rgba(248, 113, 113, 0.25);
        color: #fca5a5;
    }

    /* =========================================================
       RESPONSIVE - TABLET
    ========================================================= */

    @media (max-width: 992px) {
        .page {
            padding: 20px;
        }

        .summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* =========================================================
       RESPONSIVE - MOBILE
    ========================================================= */

    @media (max-width: 768px) {
        .page {
            padding: 15px;
        }

        .page-header h2 {
            font-size: 24px;
        }

        .monitor-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .filters {
            width: 100%;
            flex-direction: column;
        }

        .filters select {
            width: 100%;
        }

        .summary-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .card {
            overflow-x: auto;
        }

        .modal {
            padding: 15px;
        }

        .modal-content {
            max-width: calc(100vw - 30px);
            max-height: 95vh;
            padding: 20px;
        }

        .req-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .req-footer {
            flex-direction: column;
        }
    }

    /* =========================================================
       RESPONSIVE - SMALL MOBILE
    ========================================================= */

    @media (max-width: 480px) {
        .page {
            padding: 12px;
        }

        .page-header h2 {
            font-size: 21px;
        }

        .page-header p {
            font-size: 13px;
        }

        .summary-card {
            padding: 18px;
        }

        .summary-icon {
            width: 50px;
            height: 50px;
            font-size: 21px;
        }

        .summary-card h3 {
            font-size: 24px;
        }

        .modal-content {
            padding: 15px;
        }

        .modal-header-custom h3 {
            font-size: 18px;
        }
    }
</style>


<div class="page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">
        <div>
            <h2>
                <i class="fas fa-user-check me-2"></i>
                Cadet Requirement Monitoring
            </h2>

            <p>
                Monitor deployed cadets and their onboard requirement progress.
            </p>
        </div>
    </div>


    {{-- =====================================================
         SUMMARY CARDS
    ====================================================== --}}

    <div class="summary-grid">

        {{-- TOTAL DEPLOYED CADETS --}}
        <div class="summary-card">
            <div class="summary-icon icon-blue">
                <i class="fas fa-users"></i>
            </div>

            <div>
                <h3>{{ $cadets->count() }}</h3>
                <span>Deployed Cadets</span>
            </div>
        </div>


        {{-- APPROVED REQUIREMENTS --}}
        <div class="summary-card">
            <div class="summary-icon icon-green">
                <i class="fas fa-check-circle"></i>
            </div>

            <div>
                <h3>
                    {{
                        $cadets->sum(function ($cadet) {
                            return $cadet->onboardRequirements
                                ->where('status', 'Approved')
                                ->count();
                        })
                    }}
                </h3>

                <span>Approved Requirements</span>
            </div>
        </div>


        {{-- PENDING REQUIREMENTS --}}
        <div class="summary-card">
            <div class="summary-icon icon-yellow">
                <i class="fas fa-clock"></i>
            </div>

            <div>
                <h3>
                    {{
                        $cadets->sum(function ($cadet) {
                            return $cadet->onboardRequirements
                                ->where('status', 'Pending')
                                ->count();
                        })
                    }}
                </h3>

                <span>Pending Review</span>
            </div>
        </div>


        {{-- REJECTED REQUIREMENTS --}}
        <div class="summary-card">
            <div class="summary-icon icon-red">
                <i class="fas fa-times-circle"></i>
            </div>

            <div>
                <h3>
                    {{
                        $cadets->sum(function ($cadet) {
                            return $cadet->onboardRequirements
                                ->where('status', 'Rejected')
                                ->count();
                        })
                    }}
                </h3>

                <span>Rejected Documents</span>
            </div>
        </div>

    </div>


    {{-- =====================================================
         SEARCH AND FILTERS
    ====================================================== --}}

    <div class="monitor-toolbar">

        <div class="search-box">
            <input
                type="text"
                id="searchCadet"
                placeholder="Search cadet name..."
                autocomplete="off"
            >
        </div>

        <div class="filters">

            {{-- BATCH FILTER --}}
            <select id="batchFilter">
                <option value="">All Batch</option>

                @foreach ($batches as $batch)
                    <option value="{{ $batch->batch_year }}">
                        {{ $batch->batch_year }}
                    </option>
                @endforeach
            </select>


            {{-- COURSE FILTER --}}
            <select id="courseFilter">
                <option value="">All Course</option>

                @foreach ($courses as $course)
                    <option value="{{ $course->course }}">
                        {{ $course->course }}
                    </option>
                @endforeach
            </select>


            {{-- DEPLOYMENT FILTER --}}
            <select id="deploymentFilter">
                <option value="">All Deployment</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
            </select>

        </div>

    </div>


    {{-- =====================================================
         CADET TABLE
    ====================================================== --}}

    <div class="card">

        <table class="table">

            <thead>
                <tr>
                    <th>#</th>

                    <th>
                        <i class="fa-solid fa-id-card"></i>
                        TRB
                    </th>

                    <th>
                        <i class="fa-solid fa-user"></i>
                        Cadet
                    </th>

                    <th>
                        <i class="fa-solid fa-book"></i>
                        Course
                    </th>

                    <th>
                        <i class="fa-solid fa-layer-group"></i>
                        Batch
                    </th>

                    <th>
                        <i class="fa-solid fa-ship"></i>
                        Deployment
                    </th>

                    <th>
                        <i class="fa-solid fa-chart-line"></i>
                        Progress
                    </th>

                    <th>
                        <i class="fa-solid fa-gear"></i>
                        Action
                    </th>
                </tr>
            </thead>


            <tbody>

                @forelse ($cadets as $cadet)

                    @php
                        $totalRequirements =
                            $cadet->onboardRequirements->count();

                        $approvedRequirements =
                            $cadet->onboardRequirements
                                ->where('status', 'Approved')
                                ->count();

                        $percentage = $totalRequirements > 0
                            ? ($approvedRequirements / $totalRequirements) * 100
                            : 0;
                    @endphp

                    <tr
                        data-name="{{ strtolower($cadet->full_name) }}"
                        data-batch="{{ optional($cadet->batch)->batch_year }}"
                        data-course="{{ strtolower($cadet->course) }}"
                        data-deployment="{{ strtolower($cadet->deployment->status ?? '') }}"
                    >

                        {{-- NUMBER --}}
                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- TRB --}}
                        <td>
                            {{ $cadet->trb_control_number }}
                        </td>


                        {{-- CADET --}}
                        <td>
                            {{ $cadet->full_name }}
                        </td>


                        {{-- COURSE --}}
                        <td>
                            {{ $cadet->course }}
                        </td>


                        {{-- BATCH --}}
                        <td>
                            {{ optional($cadet->batch)->batch_year ?? '-' }}
                        </td>


                        {{-- DEPLOYMENT STATUS --}}
                        <td>
                            {{ $cadet->deployment->status ?? '-' }}
                        </td>


                        {{-- REQUIREMENT PROGRESS --}}
                        <td>
                            <div class="progress-wrap">

                                <div class="progress-bar">
                                    <div
                                        class="progress-fill"
                                        style="width: {{ $percentage }}%;"
                                    ></div>
                                </div>

                                <small>
                                    {{ $approvedRequirements }}
                                    /
                                    {{ $totalRequirements }}
                                    Requirements
                                </small>

                            </div>
                        </td>


                        {{-- ACTION --}}
                        <td class="text-center">

                            <button
                                type="button"
                                class="btn btn-primary"
                                onclick='viewChecklist(
                                    {{ $cadet->id }},
                                    @json(route("superadmin.cadet-requirements.show", $cadet->id))
                                )'
                            >
                                <i class="fa fa-eye"></i>
                                View
                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8">
                            <i class="fas fa-users-slash me-2"></i>
                            No deployed cadets found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
         CHECKLIST MODAL
    ====================================================== --}}

    <div id="checklistModal" class="modal">

        <div class="modal-content">

            <div class="modal-header-custom">

                <h3>
                    <i class="fas fa-file-alt me-2"></i>
                    <span id="cadetName"></span>
                </h3>

                <button
                    type="button"
                    class="close-btn"
                    onclick="closeChecklist()"
                    aria-label="Close"
                >
                    ✕
                </button>

            </div>

            <div id="checklistBody"></div>

        </div>

    </div>


    {{-- =====================================================
         ATTACHMENT PREVIEW MODAL
    ====================================================== --}}

    <div id="previewModal" class="modal">

        <div class="modal-content">

            <div class="modal-header-custom">

                <h3>
                    <i class="fas fa-eye me-2"></i>
                    Attachment Preview
                </h3>

                <button
                    type="button"
                    class="close-btn"
                    onclick="closePreview()"
                    aria-label="Close"
                >
                    ✕
                </button>

            </div>

            <div class="preview-container">
                <div id="previewBody"></div>
            </div>

        </div>

    </div>

</div>


<script>
    /* =========================================================
       VIEW CHECKLIST
    ========================================================= */

    function viewChecklist(id, url) {
        const modal = document.getElementById('checklistModal');
        const body = document.getElementById('checklistBody');
        const name = document.getElementById('cadetName');

        modal.style.display = 'flex';
        name.textContent = 'Loading...';

        body.innerHTML = `
            <div class="text-center py-5">
                <div
                    class="spinner-border"
                    style="color: #60a5fa;"
                ></div>

                <p class="mt-3 text-muted">
                    Loading requirements...
                </p>
            </div>
        `;

        console.log('Loading cadet:', id);
        console.log('URL:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async response => {
            console.log('HTTP Status:', response.status);

            const text = await response.text();

            console.log('Server Response:', text);

            if (!response.ok) {
                throw new Error(
                    `Server returned ${response.status}`
                );
            }

            try {
                return JSON.parse(text);
            } catch (error) {
                throw new Error(
                    'Server did not return valid JSON.'
                );
            }
        })
        .then(data => {
            console.log('Cadet data:', data);

            name.textContent = data.full_name || 'Cadet';

            const requirements = Array.isArray(
                data.onboard_requirements
            )
                ? data.onboard_requirements
                : [];

            if (requirements.length === 0) {
                body.innerHTML = `
                    <div class="empty-requirements">

                        <i class="fas fa-file-circle-xmark"></i>

                        <h5>
                            No Requirements Found
                        </h5>

                        <p>
                            This cadet currently has no onboard
                            requirements assigned.
                        </p>

                    </div>
                `;

                return;
            }

            let html = '';

            requirements.forEach(item => {

                /* -------------------------------------------------
                   STATUS CLASS
                ------------------------------------------------- */

                let statusClass = 'status-pending';

                switch (item.status) {

                    case 'Approved':
                        statusClass = 'status-approved';
                        break;

                    case 'Submitted':
                        statusClass = 'status-submitted';
                        break;

                    case 'Rejected':
                        statusClass = 'status-rejected';
                        break;

                    case 'Pending':
                        statusClass = 'status-pending';
                        break;
                }


                /* -------------------------------------------------
                   REQUIREMENT DATA
                ------------------------------------------------- */

                const requirementTitle =
                    item.requirement?.title || '-';

                const frequency =
                    item.requirement?.frequency || '-';


                /* -------------------------------------------------
                   ATTACHMENT
                ------------------------------------------------- */

                const attachmentHtml = item.attachment
                    ? `
                        <button
                            type="button"
                            class="btn btn-info btn-sm"
                            onclick="previewAttachment(
                                '/storage/${item.attachment}'
                            )"
                        >
                            <i class="fas fa-eye"></i>
                            Preview
                        </button>

                        <a
                            href="/storage/${item.attachment}"
                            download
                            class="btn btn-success btn-sm"
                        >
                            <i class="fas fa-download"></i>
                            Download
                        </a>
                    `
                    : `
                        <span class="text-muted">
                            No uploaded file
                        </span>
                    `;


                /* -------------------------------------------------
                   REQUIREMENT CARD
                ------------------------------------------------- */

                html += `
                    <div class="requirement-card">

                        <div class="req-header">

                            <h3>
                                <i class="fas fa-file-alt me-2"></i>
                                ${requirementTitle}
                            </h3>

                            <span class="
                                requirement-status
                                ${statusClass}
                            ">
                                ${item.status || 'Pending'}
                            </span>

                        </div>


                        <div class="req-body">

                            <p>
                                <strong>Frequency:</strong>
                                ${frequency}
                            </p>

                            <p>
                                <strong>Submitted:</strong>
                                ${item.submitted_at || '-'}
                            </p>

                            <p>
                                <strong>Approved:</strong>
                                ${item.approved_at || '-'}
                            </p>

                            <p>
                                <strong>Remarks:</strong>
                                ${item.remarks || '-'}
                            </p>

                        </div>


                        <div class="attachment-section">

                            <div class="attachment-title">
                                <i class="fas fa-paperclip"></i>
                                Attachment
                            </div>

                            <div>
                                ${attachmentHtml}
                            </div>

                        </div>


                        <div class="req-footer">

                            <div class="view-only">
                                <i class="fas fa-eye"></i>
                                View Only
                            </div>

                        </div>

                    </div>
                `;
            });

            body.innerHTML = html;
        })
        .catch(error => {

            console.error('Checklist Error:', error);

            name.textContent = 'Unable to Load';

            body.innerHTML = `
                <div class="alert alert-danger">

                    <i class="fas fa-exclamation-triangle"></i>

                    <strong>
                        Failed to load cadet requirements.
                    </strong>

                    <p class="mb-0 mt-2">
                        ${error.message}
                    </p>

                </div>
            `;
        });
    }


    /* =========================================================
       CLOSE CHECKLIST MODAL
    ========================================================= */

    function closeChecklist() {
        document.getElementById('checklistModal').style.display = 'none';
    }


    /* =========================================================
       CLOSE PREVIEW MODAL
    ========================================================= */

    function closePreview() {
        document.getElementById('previewModal').style.display = 'none';
        document.getElementById('previewBody').innerHTML = '';
    }


    /* =========================================================
       CLICK OUTSIDE MODAL
    ========================================================= */

    document
        .getElementById('checklistModal')
        .addEventListener('click', function (event) {

            if (event.target === this) {
                closeChecklist();
            }

        });


    document
        .getElementById('previewModal')
        .addEventListener('click', function (event) {

            if (event.target === this) {
                closePreview();
            }

        });


    /* =========================================================
       ESCAPE KEY
    ========================================================= */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeChecklist();
            closePreview();
        }

    });


    /* =========================================================
       ATTACHMENT PREVIEW
    ========================================================= */

    function previewAttachment(url) {

        const extension = url
            .split('.')
            .pop()
            .toLowerCase();

        let html = '';


        /* -----------------------------------------------------
           IMAGE PREVIEW
        ----------------------------------------------------- */

        if ([
            'jpg',
            'jpeg',
            'png',
            'webp'
        ].includes(extension)) {

            html = `
                <img
                    src="${url}"
                    class="preview-image"
                    alt="Attachment Preview"
                >
            `;
        }


        /* -----------------------------------------------------
           PDF PREVIEW
        ----------------------------------------------------- */

        else if (extension === 'pdf') {

            html = `
                <iframe
                    src="${url}"
                    class="preview-frame"
                    title="PDF Attachment Preview"
                ></iframe>
            `;
        }


        /* -----------------------------------------------------
           OTHER FILE TYPES
        ----------------------------------------------------- */

        else {

            html = `
                <div
                    class="text-center"
                    style="color: #b8c7e6;"
                >

                    <p>
                        Preview not available.
                    </p>

                    <a
                        href="${url}"
                        download
                        class="btn btn-success"
                    >
                        Download File
                    </a>

                </div>
            `;
        }


        document.getElementById('previewBody').innerHTML = html;

        document.getElementById('previewModal').style.display = 'flex';
    }


    /* =========================================================
       FILTER CADETS
    ========================================================= */

    function filterCadets() {

        const search = document
            .getElementById('searchCadet')
            .value
            .toLowerCase()
            .trim();

        const batch = document
            .getElementById('batchFilter')
            .value;

        const course = document
            .getElementById('courseFilter')
            .value
            .toLowerCase();

        const deployment = document
            .getElementById('deploymentFilter')
            .value
            .toLowerCase();


        document
            .querySelectorAll('.table tbody tr')
            .forEach(row => {

                const rowName =
                    row.dataset.name || '';

                const rowBatch =
                    row.dataset.batch || '';

                const rowCourse =
                    row.dataset.course || '';

                const rowDeployment =
                    row.dataset.deployment || '';


                const matchesSearch =
                    rowName.includes(search);

                const matchesBatch =
                    !batch ||
                    rowBatch === batch;

                const matchesCourse =
                    !course ||
                    rowCourse === course;

                const matchesDeployment =
                    !deployment ||
                    rowDeployment === deployment;


                const shouldShow =
                    matchesSearch &&
                    matchesBatch &&
                    matchesCourse &&
                    matchesDeployment;


                row.style.display =
                    shouldShow ? '' : 'none';
            });
    }


    /* =========================================================
       FILTER EVENTS
    ========================================================= */

    document
        .getElementById('searchCadet')
        ?.addEventListener('input', filterCadets);

    document
        .getElementById('batchFilter')
        ?.addEventListener('change', filterCadets);

    document
        .getElementById('courseFilter')
        ?.addEventListener('change', filterCadets);

    document
        .getElementById('deploymentFilter')
        ?.addEventListener('change', filterCadets);
</script>

@endsection