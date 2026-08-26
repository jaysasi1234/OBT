@extends('layouts.superadmin')

@section('content')

<style>

/* ==========================================================================
   VARIABLES
   ========================================================================== */

:root {
    --cadet-bg: #0b0b2d;
    --cadet-panel: #111c44;
    --cadet-panel-light: #16265a;

    --cadet-text: #ffffff;
    --cadet-muted: rgba(255, 255, 255, 0.7);

    --cadet-primary: #3b82f6;
    --cadet-primary-dark: #2563eb;

    --cadet-success: #22c55e;
    --cadet-warning: #f59e0b;
    --cadet-danger: #ef4444;

    --cadet-border: rgba(255, 255, 255, 0.08);

    --cadet-radius: 12px;
}


/* ==========================================================================
   PAGE
   ========================================================================== */

.cadet-page {
    width: 100%;
    color: var(--cadet-text);
}


/* ==========================================================================
   STICKY CONTROLS
   ========================================================================== */

.cadet-sticky-controls {
    position: sticky;
    top: 75px;
    z-index: 900;

    background: var(--cadet-bg);

    padding: 5px 0 15px;
}


/* ==========================================================================
   HEADER
   ========================================================================== */

.cadet-header {
    margin-bottom: 15px;
}

.cadet-header h1 {
    margin: 0;

    font-size: 28px;
    font-weight: 700;

    line-height: 1.3;
}

.cadet-header p {
    margin: 5px 0 0;

    color: var(--cadet-muted);

    font-size: 14px;
}


/* ==========================================================================
   FILTERS
   ========================================================================== */

.cadet-filters {
    display: grid;

    grid-template-columns:
        repeat(5, minmax(0, 1fr));

    gap: 10px;

    background: var(--cadet-panel);

    padding: 15px;

    border-radius: var(--cadet-radius);

    margin-bottom: 15px;

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.20);
}

.cadet-filters input,
.cadet-filters select {
    width: 100%;
    height: 42px;

    padding: 0 12px;

    border: 1px solid transparent;

    border-radius: 8px;

    background: var(--cadet-panel-light);

    color: var(--cadet-text);

    outline: none;

    font-size: 13px;

    box-sizing: border-box;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.cadet-filters input::placeholder {
    color: rgba(255, 255, 255, 0.55);
}

.cadet-filters input:focus,
.cadet-filters select:focus {
    border-color: var(--cadet-primary);

    box-shadow:
        0 0 0 3px rgba(59, 130, 246, 0.18);
}

.cadet-filters select {
    cursor: pointer;
}

.cadet-filters option {
    background: var(--cadet-panel);

    color: var(--cadet-text);
}


/* ==========================================================================
   STATISTICS
   ========================================================================== */

.cadet-stats {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 10px;

    margin-bottom: 0;
}

.cadet-stat {
    padding: 18px;

    border-radius: var(--cadet-radius);

    text-align: center;

    font-size: 14px;

    font-weight: 700;

    line-height: 1.6;

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.18);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.cadet-stat:hover {
    transform: translateY(-3px);

    box-shadow:
        0 12px 25px rgba(0, 0, 0, 0.25);
}

.cadet-stat-value {
    display: block;

    margin-top: 3px;

    font-size: 24px;

    line-height: 1;
}

.cadet-stat-blue {
    background: var(--cadet-primary);
}

.cadet-stat-green {
    background: var(--cadet-success);
}

.cadet-stat-yellow {
    background: var(--cadet-warning);

    color: #000;
}

.cadet-stat-red {
    background: var(--cadet-danger);
}


/* ==========================================================================
   TABLE
   ========================================================================== */

.cadet-table-wrapper {
    width: 100%;

    background: var(--cadet-panel);

    border-radius: var(--cadet-radius);

    padding: 15px;

    overflow-x: auto;

    -webkit-overflow-scrolling: touch;

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.20);

    box-sizing: border-box;
}

.cadet-table {
    width: 100%;

    min-width: 900px;

    border-collapse: collapse;

    color: var(--cadet-text);
}

.cadet-table thead {
    background: var(--cadet-panel-light);
}

.cadet-table th {
    padding: 13px 12px;

    color: #fff;

    font-size: 13px;

    font-weight: 700;

    text-align: left;

    white-space: nowrap;

    border-bottom:
        1px solid var(--cadet-border);
}

.cadet-table td {
    padding: 13px 12px;

    font-size: 13px;

    white-space: nowrap;

    border-bottom:
        1px solid var(--cadet-border);
}

.cadet-table tbody tr {
    transition:
        background 0.2s ease;
}

.cadet-table tbody tr:hover {
    background:
        rgba(59, 130, 246, 0.12);
}

.cadet-table-empty {
    text-align: center;

    padding: 30px !important;

    color: var(--cadet-muted);
}


/* ==========================================================================
   STATUS BADGES
   ========================================================================== */

.cadet-status {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;

    line-height: 1;

    white-space: nowrap;
}


/* VERIFICATION */

.cadet-status-verified {
    background: var(--cadet-success);
    color: #fff;
}

.cadet-status-pending {
    background: var(--cadet-warning);
    color: #000;
}

.cadet-status-deficiency {
    background: var(--cadet-danger);
    color: #fff;
}


/* DEPLOYMENT */

.cadet-status-not-deployed {
    background: var(--cadet-warning);
    color: #000;
}

.cadet-status-ongoing {
    background: var(--cadet-primary);
    color: #fff;
}

.cadet-status-completed {
    background: var(--cadet-success);
    color: #fff;
}


/* ==========================================================================
   VIEW BUTTON
   ========================================================================== */

.cadet-view-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 7px 12px;

    border: none;

    border-radius: 7px;

    background: var(--cadet-primary);

    color: #fff;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.cadet-view-btn:hover {
    background: var(--cadet-primary-dark);

    transform: translateY(-1px);
}


/* ==========================================================================
   MODAL OVERLAY
   ========================================================================== */

.cadet-modal-overlay {
    position: fixed;

    inset: 0;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background:
        rgba(0, 0, 0, 0.78);

    backdrop-filter: blur(5px);

    z-index: 9999;
}

.cadet-modal-overlay.show {
    display: flex;
}


/* ==========================================================================
   MODAL
   ========================================================================== */

.cadet-modal {
    width: 680px;

    max-width: 100%;

    max-height: 90vh;

    overflow-y: auto;

    background: var(--cadet-panel);

    color: #fff;

    border:
        1px solid rgba(255,255,255,0.08);

    border-radius: 18px;

    box-shadow:
        0 25px 70px rgba(0,0,0,0.55);

    animation:
        cadetModalOpen 0.2s ease;
}

@keyframes cadetModalOpen {

    from {
        opacity: 0;

        transform:
            translateY(15px)
            scale(0.97);
    }

    to {
        opacity: 1;

        transform:
            translateY(0)
            scale(1);
    }
}


/* ==========================================================================
   MODAL HEADER
   ========================================================================== */

.cadet-modal-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    padding: 20px 24px;

    border-bottom:
        1px solid rgba(255,255,255,0.08);

    background: var(--cadet-panel-light);
}

.cadet-modal-title {
    display: flex;

    align-items: center;

    gap: 12px;
}

.cadet-modal-title-icon {
    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    background: var(--cadet-primary);

    font-size: 20px;
}

.cadet-modal-title-text h2 {
    margin: 0;

    font-size: 20px;

    font-weight: 700;
}

.cadet-modal-title-text p {
    margin: 3px 0 0;

    color:
        rgba(255,255,255,0.6);

    font-size: 12px;
}

.cadet-modal-close {
    width: 36px;
    height: 36px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border: none;

    border-radius: 10px;

    background:
        rgba(255,255,255,0.08);

    color: #fff;

    font-size: 20px;

    cursor: pointer;

    transition: 0.2s;
}

.cadet-modal-close:hover {
    background: var(--cadet-danger);
}


/* ==========================================================================
   PROFILE SECTION
   ========================================================================== */

.cadet-profile-section {
    display: flex;

    align-items: center;

    gap: 20px;

    padding: 24px;

    border-bottom:
        1px solid rgba(255,255,255,0.08);
}

.cadet-modal-photo {
    width: 120px;
    height: 120px;

    flex-shrink: 0;

    object-fit: cover;

    border-radius: 16px;

    border:
        3px solid var(--cadet-primary);

    background:
        var(--cadet-panel-light);

    box-shadow:
        0 8px 25px rgba(0,0,0,0.3);
}

.cadet-profile-info {
    min-width: 0;
}

.cadet-profile-name {
    margin: 0 0 8px;

    font-size: 23px;

    font-weight: 700;

    word-break: break-word;
}

.cadet-profile-trb {
    display: inline-flex;

    align-items: center;

    padding: 6px 11px;

    border-radius: 20px;

    background:
        rgba(59,130,246,0.18);

    color: #60a5fa;

    font-size: 12px;

    font-weight: 700;
}


/* ==========================================================================
   DETAILS SECTION
   ========================================================================== */

.cadet-details-section {
    padding: 24px;
}

.cadet-details-title {
    margin: 0 0 15px;

    font-size: 15px;

    font-weight: 700;

    color: #fff;
}

.cadet-details-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 12px;
}

.cadet-detail-card {
    padding: 14px;

    border-radius: 12px;

    background:
        var(--cadet-panel-light);

    border:
        1px solid rgba(255,255,255,0.06);

    transition: 0.2s;
}

.cadet-detail-card:hover {
    border-color:
        rgba(59,130,246,0.4);

    background:
        #192d68;
}

.cadet-detail-label {
    display: block;

    margin-bottom: 5px;

    color:
        rgba(255,255,255,0.55);

    font-size: 11px;

    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: 0.5px;
}

.cadet-detail-value {
    display: block;

    color: #fff;

    font-size: 14px;

    font-weight: 600;

    word-break: break-word;
}


/* ==========================================================================
   MODAL FOOTER
   ========================================================================== */

.cadet-modal-footer {
    display: flex;

    justify-content: flex-end;

    padding: 15px 24px;

    border-top:
        1px solid rgba(255,255,255,0.08);

    background:
        rgba(0,0,0,0.12);
}

.cadet-modal-close-btn {
    padding: 9px 18px;

    border: none;

    border-radius: 8px;

    background:
        var(--cadet-panel-light);

    color: #fff;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.2s;
}

.cadet-modal-close-btn:hover {
    background: var(--cadet-danger);
}


/* ==========================================================================
   RESPONSIVE
   ========================================================================== */

@media (max-width: 1200px) {

    .cadet-filters {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

}


@media (max-width: 992px) {

    .cadet-sticky-controls {
        top: 75px;
    }

    .cadet-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .cadet-filters {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 768px) {

    .cadet-header h1 {
        font-size: 24px;
    }

    .cadet-sticky-controls {
        top: 75px;

        padding-bottom: 10px;
    }

    .cadet-stats {
        grid-template-columns: 1fr;
    }

    .cadet-filters {
        grid-template-columns: 1fr;

        padding: 12px;
    }

    .cadet-table-wrapper {
        padding: 10px;
    }

    .cadet-table {
        min-width: 850px;
    }

    .cadet-modal-overlay {
        padding: 15px;
    }

    .cadet-modal {
        max-height: 95vh;

        border-radius: 14px;
    }

    .cadet-modal-header {
        padding: 16px;
    }

    .cadet-profile-section {
        flex-direction: column;

        text-align: center;

        padding: 20px;
    }

    .cadet-modal-photo {
        width: 110px;
        height: 110px;
    }

    .cadet-profile-name {
        font-size: 20px;
    }

    .cadet-details-section {
        padding: 18px;
    }

    .cadet-details-grid {
        grid-template-columns: 1fr;
    }

    .cadet-modal-footer {
        padding: 12px 18px;
    }

    .cadet-modal-close-btn {
        width: 100%;
    }

}


@media (max-width: 480px) {

    .cadet-header h1 {
        font-size: 21px;
    }

    .cadet-header p {
        font-size: 12px;
    }

    .cadet-stat {
        padding: 15px;
    }

    .cadet-stat-value {
        font-size: 22px;
    }

    .cadet-modal-title-text h2 {
        font-size: 17px;
    }

    .cadet-modal-title-text p {
        display: none;
    }

    .cadet-profile-name {
        font-size: 19px;
    }

}

</style>


<div class="cadet-page">

    {{-- ======================================================================
         STICKY HEADER + FILTERS + STATISTICS
         ====================================================================== --}}

    <div class="cadet-sticky-controls">


        {{-- PAGE HEADER --}}

        <div class="cadet-header">

            <h1>
                Cadet Management
            </h1>

            <p>
                Monitor and manage cadet records efficiently
            </p>

        </div>


        {{-- FILTERS --}}

        <div class="cadet-filters">


            {{-- COURSE --}}

            <select id="courseFilter">

                <option value="">
                    All Courses
                </option>

                @foreach($courses as $course)

                    <option value="{{ strtolower($course->course) }}">
                        {{ $course->course }}
                    </option>

                @endforeach

            </select>


            {{-- BATCH --}}

            <select id="batchFilter">

                <option value="">
                    All Batches
                </option>

                @foreach($batches as $batch)

                    <option value="{{ strtolower($batch->batch_year) }}">
                        {{ $batch->batch_year }}
                    </option>

                @endforeach

            </select>


            {{-- DEPLOYMENT --}}

            <select id="deploymentFilter">

                <option value="">
                    Deployment
                </option>

                <option value="not_deployed">
                    Not Deployed
                </option>

                <option value="ongoing">
                    Ongoing
                </option>

                <option value="completed">
                    Completed
                </option>

            </select>


            {{-- VERIFICATION --}}

            <select id="verificationFilter">

                <option value="">
                    Verification
                </option>

                <option value="verified">
                    Verified
                </option>

                <option value="pending">
                    Pending
                </option>

                <option value="deficiency">
                    Deficiency
                </option>

            </select>


            {{-- SEARCH --}}

            <input
                type="text"
                id="searchInput"
                placeholder="Search cadet..."
                autocomplete="off"
            >

        </div>


        {{-- ==================================================================
             STATISTICS
             ================================================================== --}}

        <div class="cadet-stats">

            <div class="cadet-stat cadet-stat-blue">

                Total

                <span
                    class="cadet-stat-value"
                    id="totalCadetsCount"
                >
                    {{ $totalCadets }}
                </span>

            </div>


            <div class="cadet-stat cadet-stat-green">

                Verified

                <span
                    class="cadet-stat-value"
                    id="verifiedCadetsCount"
                >
                    {{ $verifiedCadets }}
                </span>

            </div>


            <div class="cadet-stat cadet-stat-yellow">

                Pending

                <span
                    class="cadet-stat-value"
                    id="pendingCadetsCount"
                >
                    {{ $pendingCadets }}
                </span>

            </div>


            <div class="cadet-stat cadet-stat-red">

                Deficiency

                <span
                    class="cadet-stat-value"
                    id="deficiencyCadetsCount"
                >
                    {{ $deficiencyCadets }}
                </span>

            </div>

        </div>

    </div>


    {{-- ======================================================================
         TABLE
         ====================================================================== --}}

    <div class="cadet-table-wrapper">

        <table class="cadet-table">

            <thead>

                <tr>

                    <th>TRB</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Batch</th>
                    <th>Rank</th>
                    <th>Verification</th>
                    <th>Deployment</th>
                    <th>Action</th>

                </tr>

            </thead>


            <tbody id="cadetTableBody">

                @forelse($cadets as $cadet)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | NORMALIZE DEPLOYMENT STATUS
                        |--------------------------------------------------------------------------
                        */

                        $rawDeploymentStatus =
                            strtolower(
                                trim(
                                    $cadet->deployment->status
                                    ?? ''
                                )
                            );

                        if (
                            $rawDeploymentStatus === '' ||
                            $rawDeploymentStatus === 'not started' ||
                            $rawDeploymentStatus === 'not_deployed' ||
                            $rawDeploymentStatus === 'not-deployed'
                        ) {

                            $deploymentStatus = 'not_deployed';

                        } elseif (
                            $rawDeploymentStatus === 'ongoing'
                        ) {

                            $deploymentStatus = 'ongoing';

                        } elseif (
                            $rawDeploymentStatus === 'completed'
                        ) {

                            $deploymentStatus = 'completed';

                        } else {

                            $deploymentStatus = 'not_deployed';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | VERIFICATION STATUS
                        |--------------------------------------------------------------------------
                        */

                        $verificationStatus =
                            strtolower(
                                trim(
                                    $cadet->verification_status
                                    ?? 'pending'
                                )
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | VERIFICATION LABEL
                        |--------------------------------------------------------------------------
                        */

                        $verificationLabel = match ($verificationStatus) {
                            'verified' => 'Verified',
                            'pending' => 'Pending',
                            'deficiency' => 'Deficiency',
                            default => ucfirst($verificationStatus),
                        };


                        /*
                        |--------------------------------------------------------------------------
                        | BATCH
                        |--------------------------------------------------------------------------
                        */

                        $batchYear =
                            optional($cadet->batch)->batch_year
                            ?? 'No Batch';


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
                                : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';


                        /*
                        |--------------------------------------------------------------------------
                        | DEPLOYMENT LABEL
                        |--------------------------------------------------------------------------
                        */

                        $deploymentLabel = match ($deploymentStatus) {

                            'not_deployed' => 'Not Deployed',

                            'ongoing' => 'Ongoing',

                            'completed' => 'Completed',

                            default => 'Not Deployed',

                        };

                    @endphp


                    <tr
                        data-course="{{ strtolower($cadet->course ?? '') }}"
                        data-batch="{{ strtolower($batchYear) }}"
                        data-deployment="{{ $deploymentStatus }}"
                        data-verification="{{ $verificationStatus }}"
                    >


                        {{-- TRB --}}

                        <td>
                            {{ $cadet->trb_control_number ?? '-' }}
                        </td>


                        {{-- NAME --}}

                        <td>
                            {{ $cadet->full_name ?? '-' }}
                        </td>


                        {{-- COURSE --}}

                        <td>
                            {{ strtoupper($cadet->course ?? '-') }}
                        </td>


                        {{-- BATCH --}}

                        <td>
                            {{ $batchYear }}
                        </td>


                        {{-- RANK --}}

                        <td>
                            {{ $cadet->rank ?? '-' }}
                        </td>


                        {{-- VERIFICATION --}}

                        <td>

                            <span
                                class="
                                    cadet-status
                                    cadet-status-{{ $verificationStatus }}
                                "
                                data-status="{{ $verificationStatus }}"
                            >
                                {{ $verificationLabel }}
                            </span>

                        </td>


                        {{-- DEPLOYMENT --}}

                        <td>

                            <span
                                class="
                                    cadet-status
                                    cadet-status-{{ str_replace('_', '-', $deploymentStatus) }}
                                "
                                data-deployment="{{ $deploymentStatus }}"
                            >
                                {{ $deploymentLabel }}
                            </span>

                        </td>


                        {{-- ACTION --}}

                        <td>

                            <button
                                type="button"
                                class="cadet-view-btn cadet-view-profile"

                                data-name="{{ $cadet->full_name ?? '-' }}"
                                data-trb="{{ $cadet->trb_control_number ?? '-' }}"
                                data-course="{{ $cadet->course ?? '-' }}"
                                data-batch="{{ $batchYear }}"
                                data-rank="{{ $cadet->rank ?? '-' }}"
                                data-contact="{{ $cadet->contact_number ?? '-' }}"
                                data-birth="{{ $cadet->date_of_birth ?? 'N/A' }}"
                                data-photo="{{ $photoUrl }}"
                            >
                                View
                            </button>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="cadet-table-empty"
                        >
                            No cadets found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- ========================================================================
     CADET PROFILE MODAL
     ======================================================================== --}}

<div
    class="cadet-modal-overlay"
    id="cadetModal"
    aria-hidden="true"
>

    <div
        class="cadet-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cadetModalTitle"
    >


        {{-- MODAL HEADER --}}

        <div class="cadet-modal-header">

            <div class="cadet-modal-title">

                <div class="cadet-modal-title-icon">
                    👤
                </div>

                <div class="cadet-modal-title-text">

                    <h2 id="cadetModalTitle">
                        Cadet Profile
                    </h2>

                    <p>
                        Cadet information and personal details
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="cadet-modal-close"
                id="closeCadetModal"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        {{-- PROFILE --}}

        <div class="cadet-profile-section">

            <img
                id="modalPhoto"
                class="cadet-modal-photo"
                src=""
                alt="Cadet Photo"
            >


            <div class="cadet-profile-info">

                <h3
                    class="cadet-profile-name"
                    id="modalName"
                >
                    -
                </h3>


                <span class="cadet-profile-trb">

                    TRB:
                    &nbsp;

                    <span id="modalTrb">
                        -
                    </span>

                </span>

            </div>

        </div>


        {{-- DETAILS --}}

        <div class="cadet-details-section">

            <h3 class="cadet-details-title">
                Cadet Information
            </h3>


            <div class="cadet-details-grid">


                {{-- COURSE --}}

                <div class="cadet-detail-card">

                    <span class="cadet-detail-label">
                        Course
                    </span>

                    <span
                        class="cadet-detail-value"
                        id="modalCourse"
                    >
                        -
                    </span>

                </div>


                {{-- BATCH --}}

                <div class="cadet-detail-card">

                    <span class="cadet-detail-label">
                        Batch
                    </span>

                    <span
                        class="cadet-detail-value"
                        id="modalBatch"
                    >
                        -
                    </span>

                </div>


                {{-- RANK --}}

                <div class="cadet-detail-card">

                    <span class="cadet-detail-label">
                        Rank
                    </span>

                    <span
                        class="cadet-detail-value"
                        id="modalRank"
                    >
                        -
                    </span>

                </div>


                {{-- CONTACT --}}

                <div class="cadet-detail-card">

                    <span class="cadet-detail-label">
                        Contact Number
                    </span>

                    <span
                        class="cadet-detail-value"
                        id="modalContact"
                    >
                        -
                    </span>

                </div>


                {{-- BIRTH DATE --}}

                <div class="cadet-detail-card">

                    <span class="cadet-detail-label">
                        Birth Date
                    </span>

                    <span
                        class="cadet-detail-value"
                        id="modalBirth"
                    >
                        -
                    </span>

                </div>


            </div>

        </div>


        {{-- FOOTER --}}

        <div class="cadet-modal-footer">

            <button
                type="button"
                class="cadet-modal-close-btn"
                id="closeCadetModalFooter"
            >
                Close
            </button>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /* ======================================================================
       ELEMENTS
       ====================================================================== */

    const modal =
        document.getElementById('cadetModal');

    const closeModalButton =
        document.getElementById('closeCadetModal');

    const closeModalFooter =
        document.getElementById('closeCadetModalFooter');

    const modalPhoto =
        document.getElementById('modalPhoto');

    const modalName =
        document.getElementById('modalName');

    const modalTrb =
        document.getElementById('modalTrb');

    const modalCourse =
        document.getElementById('modalCourse');

    const modalBatch =
        document.getElementById('modalBatch');

    const modalRank =
        document.getElementById('modalRank');

    const modalContact =
        document.getElementById('modalContact');

    const modalBirth =
        document.getElementById('modalBirth');


    /* ======================================================================
       FILTER ELEMENTS
       ====================================================================== */

    const courseFilter =
        document.getElementById('courseFilter');

    const batchFilter =
        document.getElementById('batchFilter');

    const deploymentFilter =
        document.getElementById('deploymentFilter');

    const verificationFilter =
        document.getElementById('verificationFilter');

    const searchInput =
        document.getElementById('searchInput');

    const tableBody =
        document.getElementById('cadetTableBody');

    const tableRows =
        tableBody
            ? tableBody.querySelectorAll('tr')
            : [];


    /* ======================================================================
       DEFAULT PHOTO
       ====================================================================== */

    const defaultPhoto =
        'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';


    /* ======================================================================
       OPEN PROFILE MODAL
       ====================================================================== */

    document
        .querySelectorAll('.cadet-view-profile')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    /* ------------------------------------------------------
                       GET DATA
                       ------------------------------------------------------ */

                    modalName.textContent =
                        this.dataset.name || '-';

                    modalTrb.textContent =
                        this.dataset.trb || '-';

                    modalCourse.textContent =
                        this.dataset.course || '-';

                    modalBatch.textContent =
                        this.dataset.batch || '-';

                    modalRank.textContent =
                        this.dataset.rank || '-';

                    modalContact.textContent =
                        this.dataset.contact || '-';

                    modalBirth.textContent =
                        this.dataset.birth || '-';


                    /* ------------------------------------------------------
                       PHOTO
                       ------------------------------------------------------ */

                    const photo =
                        this.dataset.photo || defaultPhoto;

                    modalPhoto.onerror =
                        function () {

                            this.onerror = null;

                            this.src =
                                defaultPhoto;

                        };

                    modalPhoto.src =
                        photo;


                    /* ------------------------------------------------------
                       SHOW MODAL
                       ------------------------------------------------------ */

                    modal.classList.add('show');

                    modal.setAttribute(
                        'aria-hidden',
                        'false'
                    );

                    document.body.style.overflow =
                        'hidden';

                }
            );

        });


    /* ======================================================================
       CLOSE MODAL
       ====================================================================== */

    function closeCadetModal() {

        modal.classList.remove('show');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow =
            '';

    }


    /* ======================================================================
       CLOSE BUTTON
       ====================================================================== */

    closeModalButton.addEventListener(
        'click',
        closeCadetModal
    );


    /* ======================================================================
       FOOTER CLOSE BUTTON
       ====================================================================== */

    closeModalFooter.addEventListener(
        'click',
        closeCadetModal
    );


    /* ======================================================================
       CLICK OUTSIDE MODAL
       ====================================================================== */

    modal.addEventListener(
        'click',
        function (event) {

            if (
                event.target === modal
            ) {

                closeCadetModal();

            }

        }
    );


    /* ======================================================================
       ESCAPE KEY
       ====================================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal.classList.contains('show')
            ) {

                closeCadetModal();

            }

        }
    );


    /* ======================================================================
       FILTER TABLE
       ====================================================================== */

    function filterTable() {

        const course =
            courseFilter.value
                .trim()
                .toLowerCase();

        const batch =
            batchFilter.value
                .trim()
                .toLowerCase();

        const deployment =
            deploymentFilter.value
                .trim()
                .toLowerCase();

        const verification =
            verificationFilter.value
                .trim()
                .toLowerCase();

        const search =
            searchInput.value
                .trim()
                .toLowerCase();


        /* ==============================================================
           COUNTERS
           ============================================================== */

        let total = 0;

        let verified = 0;

        let pending = 0;

        let deficiency = 0;


        /* ==============================================================
           LOOP THROUGH ROWS
           ============================================================== */

        tableRows.forEach(function (row) {

            /* ----------------------------------------------------------
               SKIP EMPTY ROW
               ---------------------------------------------------------- */

            if (
                row.classList.contains('cadet-table-empty')
            ) {
                return;
            }


            if (
                row.querySelector('.cadet-table-empty')
            ) {
                return;
            }


            /* ----------------------------------------------------------
               GET ROW DATA
               ---------------------------------------------------------- */

            const rowCourse =
                (
                    row.dataset.course || ''
                ).toLowerCase();

            const rowBatch =
                (
                    row.dataset.batch || ''
                ).toLowerCase();

            const rowDeployment =
                (
                    row.dataset.deployment || ''
                ).toLowerCase();

            const rowVerification =
                (
                    row.dataset.verification || ''
                ).toLowerCase();

            const rowText =
                (
                    row.textContent || ''
                )
                .trim()
                .toLowerCase();


            /* ----------------------------------------------------------
               MATCH COURSE
               ---------------------------------------------------------- */

            const matchesCourse =
                !course ||
                rowCourse.includes(course);


            /* ----------------------------------------------------------
               MATCH BATCH
               ---------------------------------------------------------- */

            const matchesBatch =
                !batch ||
                rowBatch.includes(batch);


            /* ----------------------------------------------------------
               MATCH DEPLOYMENT
               ---------------------------------------------------------- */

            const matchesDeployment =
                !deployment ||
                rowDeployment === deployment;


            /* ----------------------------------------------------------
               MATCH VERIFICATION
               ---------------------------------------------------------- */

            const matchesVerification =
                !verification ||
                rowVerification === verification;


            /* ----------------------------------------------------------
               MATCH SEARCH
               ---------------------------------------------------------- */

            const matchesSearch =
                !search ||
                rowText.includes(search);


            /* ----------------------------------------------------------
               FINAL MATCH
               ---------------------------------------------------------- */

            const matches =
                matchesCourse &&
                matchesBatch &&
                matchesDeployment &&
                matchesVerification &&
                matchesSearch;


            /* ----------------------------------------------------------
               SHOW / HIDE
               ---------------------------------------------------------- */

            row.style.display =
                matches
                    ? ''
                    : 'none';


            /* ----------------------------------------------------------
               UPDATE COUNTERS
               ---------------------------------------------------------- */

            if (matches) {

                total++;


                if (
                    rowVerification === 'verified'
                ) {

                    verified++;

                }


                if (
                    rowVerification === 'pending'
                ) {

                    pending++;

                }


                if (
                    rowVerification === 'deficiency'
                ) {

                    deficiency++;

                }

            }

        });


        /* ==============================================================
           UPDATE STATISTICS
           ============================================================== */

        const totalElement =
            document.getElementById(
                'totalCadetsCount'
            );

        const verifiedElement =
            document.getElementById(
                'verifiedCadetsCount'
            );

        const pendingElement =
            document.getElementById(
                'pendingCadetsCount'
            );

        const deficiencyElement =
            document.getElementById(
                'deficiencyCadetsCount'
            );


        if (totalElement) {

            totalElement.textContent =
                total;

        }


        if (verifiedElement) {

            verifiedElement.textContent =
                verified;

        }


        if (pendingElement) {

            pendingElement.textContent =
                pending;

        }


        if (deficiencyElement) {

            deficiencyElement.textContent =
                deficiency;

        }

    }


    /* ======================================================================
       FILTER EVENT LISTENERS
       ====================================================================== */

    courseFilter.addEventListener(
        'change',
        filterTable
    );

    batchFilter.addEventListener(
        'change',
        filterTable
    );

    deploymentFilter.addEventListener(
        'change',
        filterTable
    );

    verificationFilter.addEventListener(
        'change',
        filterTable
    );

    searchInput.addEventListener(
        'input',
        filterTable
    );


    /* ======================================================================
       INITIAL FILTER
       ====================================================================== */

    filterTable();

});

</script>

@endsection