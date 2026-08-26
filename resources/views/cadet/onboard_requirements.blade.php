@extends('layouts.cadet')

@section('content')

<style>

/* =========================================================
   GLOBAL PAGE
========================================================= */

.requirements-page {
    width: 100%;
    max-width: 100%;
    color: #fff;
    box-sizing: border-box;
    overflow-x: hidden;
}

.requirements-page *,
.requirements-page *::before,
.requirements-page *::after {
    box-sizing: border-box;
}


/* =========================================================
   PAGE HEADER
========================================================= */

.page-header {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 25px;
    margin-bottom: 25px;
}

.page-title {
    min-width: 0;
}

.page-title h2 {
    margin: 0 0 8px;
    font-size: 30px;
    font-weight: 700;
    color: #fff;
    line-height: 1.25;
    overflow-wrap: anywhere;
}

.page-title p {
    margin: 0;
    color: #9ca3af;
    font-size: 15px;
    line-height: 1.5;
}


/* =========================================================
   SUMMARY CARD
========================================================= */

.summary-card {
    flex: 0 0 auto;

    min-width: 180px;
    min-height: 90px;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    padding: 15px 20px;

    border-radius: 16px;

    background: linear-gradient(
        135deg,
        #2563eb,
        #1d4ed8
    );

    color: #fff;

    box-shadow:
        0 10px 25px rgba(0, 0, 0, .30);
}

.summary-card h3 {
    margin: 0;
    font-size: 34px;
    line-height: 1;
    font-weight: 700;
}

.summary-card small {
    margin-top: 8px;
    font-size: 13px;
    opacity: .85;
    text-align: center;
}


/* =========================================================
   INFORMATION BANNER
========================================================= */

.info-banner {
    width: 100%;

    display: flex;
    align-items: flex-start;
    gap: 12px;

    margin-bottom: 20px;
    padding: 16px 18px;

    background: rgba(37, 99, 235, .12);
    border: 1px solid rgba(37, 99, 235, .25);
    border-radius: 12px;

    color: #dbeafe;

    overflow-wrap: anywhere;
}

.info-banner-icon {
    flex: 0 0 auto;
    font-size: 20px;
    line-height: 1;
}

.info-banner-text {
    min-width: 0;
    font-size: 14px;
    line-height: 1.6;
}

.info-banner-text strong {
    color: #fff;
}


/* =========================================================
   REQUIREMENTS CARD
========================================================= */

.requirements-card {
    width: 100%;
    max-width: 100%;

    background: #1b2550;

    border-radius: 20px;

    padding: 25px;

    border: 1px solid rgba(255, 255, 255, .08);

    box-shadow:
        0 10px 30px rgba(0, 0, 0, .35);

    overflow: hidden;
}


/* =========================================================
   TABLE HEADER
========================================================= */

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 15px;

    margin-bottom: 20px;
}

.table-header h3 {
    margin: 0;
    font-size: 19px;
    font-weight: 600;
    color: #fff;
}

.table-header span {
    font-size: 13px;
    color: #94a3b8;
}


/* =========================================================
   TABLE WRAPPER
========================================================= */

.table-wrapper {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;

    border-radius: 12px;

    -webkit-overflow-scrolling: touch;
}


/* =========================================================
   TABLE
========================================================= */

.requirements-table {
    width: 100%;
    min-width: 700px;

    border-collapse: collapse;
    table-layout: auto;
}

.requirements-table thead {
    background: #1e3a8a;
}

.requirements-table th {
    padding: 15px 16px;

    text-align: left;

    color: #fff;

    font-size: 13px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .3px;

    white-space: nowrap;
}

.requirements-table td {
    padding: 16px;

    color: #fff;

    font-size: 14px;

    border-bottom:
        1px solid rgba(255, 255, 255, .08);

    vertical-align: middle;

    overflow-wrap: anywhere;
}

.requirements-table tbody tr {
    transition: background .2s ease;
}

.requirements-table tbody tr:hover {
    background: rgba(255, 255, 255, .035);
}

.requirements-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   REQUIREMENT NAME
========================================================= */

.requirement-name {
    font-weight: 600;
    color: #fff;

    line-height: 1.4;

    overflow-wrap: anywhere;
}

.requirement-description {
    margin-top: 5px;

    font-size: 12px;
    line-height: 1.5;

    color: #94a3b8;

    overflow-wrap: anywhere;
}


/* =========================================================
   FREQUENCY
========================================================= */

.frequency {
    display: inline-flex;
    align-items: center;

    max-width: 100%;

    padding: 6px 10px;

    background: rgba(255, 255, 255, .07);

    border-radius: 7px;

    color: #cbd5e1;

    font-size: 12px;
    font-weight: 600;

    white-space: normal;
    overflow-wrap: anywhere;
}


/* =========================================================
   STATUS
========================================================= */

.status {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 7px 13px;

    border-radius: 30px;

    font-size: 12px;
    font-weight: 700;

    white-space: nowrap;

    max-width: 100%;
}

.status-dot {
    flex: 0 0 auto;

    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: currentColor;
}


/* Submitted */

.status.submitted {
    background: rgba(37, 99, 235, .18);
    color: #60a5fa;
    border: 1px solid rgba(96, 165, 250, .20);
}


/* Approved */

.status.approved {
    background: rgba(22, 163, 74, .18);
    color: #4ade80;
    border: 1px solid rgba(74, 222, 128, .20);
}


/* Rejected */

.status.rejected {
    background: rgba(220, 38, 38, .18);
    color: #f87171;
    border: 1px solid rgba(248, 113, 113, .20);
}


/* Not submitted */

.status.none {
    background: rgba(71, 85, 105, .25);
    color: #cbd5e1;
    border: 1px solid rgba(203, 213, 225, .10);
}


/* =========================================================
   ACTION BUTTON
========================================================= */

.action-btn {
    width: 100%;
    max-width: 150px;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    padding: 10px 16px;

    border: none;
    border-radius: 8px;

    color: #fff;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition:
        background .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.action-btn:hover {
    transform: translateY(-1px);
}


/* Upload */

.upload-btn {
    background: #2563eb;
}

.upload-btn:hover {
    background: #1d4ed8;
    box-shadow:
        0 5px 15px rgba(37, 99, 235, .25);
}


/* Replace */

.replace-btn {
    background: #f59e0b;
}

.replace-btn:hover {
    background: #d97706;
    box-shadow:
        0 5px 15px rgba(245, 158, 11, .20);
}


/* Re-upload */

.reject-btn {
    background: #dc2626;
}

.reject-btn:hover {
    background: #b91c1c;
    box-shadow:
        0 5px 15px rgba(220, 38, 38, .20);
}


/* Completed */

.completed-btn {
    background: #16a34a;
    cursor: default;
}

.completed-btn:hover {
    transform: none;
}


/* =========================================================
   EMPTY / NOT DEPLOYED
========================================================= */

.not-deployed-message {
    padding: 50px 20px;

    text-align: center;

    color: #fbbf24;

    font-size: 16px;
    line-height: 1.6;
}

.empty-message {
    padding: 40px 20px;

    text-align: center;

    color: #94a3b8;

    font-size: 14px;
    line-height: 1.6;
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

    background: rgba(0, 0, 0, .72);

    z-index: 9999;

    justify-content: center;
    align-items: center;

    padding: 20px;

    box-sizing: border-box;

    overflow-y: auto;
}

.custom-modal-content {
    width: 500px;
    max-width: 100%;

    max-height: calc(100vh - 40px);

    overflow-y: auto;

    background: #172554;

    border: 1px solid rgba(255, 255, 255, .08);

    border-radius: 16px;

    padding: 25px;

    color: #fff;

    box-shadow:
        0 25px 60px rgba(0, 0, 0, .45);

    animation: popup .2s ease;
}

@keyframes popup {

    from {
        transform: scale(.94);
        opacity: 0;
    }

    to {
        transform: scale(1);
        opacity: 1;
    }

}


/* =========================================================
   MODAL HEADER
========================================================= */

.custom-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 15px;

    padding-bottom: 18px;

    margin-bottom: 20px;

    border-bottom:
        1px solid rgba(255, 255, 255, .08);
}

.custom-modal-header h3 {
    margin: 0;

    font-size: 20px;
    font-weight: 700;

    overflow-wrap: anywhere;
}

.close-modal {
    flex: 0 0 auto;

    width: 35px;
    height: 35px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: none;
    background: transparent;

    border-radius: 8px;

    color: #94a3b8;

    font-size: 25px;

    cursor: pointer;

    transition: .2s ease;
}

.close-modal:hover {
    background: rgba(255, 255, 255, .08);
    color: #fff;
}


/* =========================================================
   FORM
========================================================= */

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;

    margin-bottom: 8px;

    color: #e2e8f0;

    font-size: 13px;
    font-weight: 600;
}

.requirement-selected {
    width: 100%;

    padding: 12px 14px;

    background: #22356f;

    border-radius: 8px;

    color: #fff;

    font-size: 14px;
    font-weight: 600;

    line-height: 1.5;

    overflow-wrap: anywhere;
}

.form-group input,
.form-group textarea {
    width: 100%;
    max-width: 100%;

    padding: 12px 14px;

    background: #22356f;

    border: 1px solid transparent;

    border-radius: 8px;

    color: #fff;

    font-size: 14px;

    outline: none;

    box-sizing: border-box;

    transition: border .2s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #3b82f6;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #94a3b8;
}

.form-help {
    margin-top: 7px;

    color: #94a3b8;

    font-size: 12px;

    line-height: 1.5;
}


/* =========================================================
   MODAL BUTTONS
========================================================= */

.modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;

    margin-top: 25px;
}

.cancel-btn,
.upload-submit-btn {
    min-height: 42px;

    padding: 10px 18px;

    border: none;
    border-radius: 8px;

    color: #fff;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition: .2s ease;
}

.cancel-btn {
    background: #475569;
}

.cancel-btn:hover {
    background: #334155;
}

.upload-submit-btn {
    background: #2563eb;
}

.upload-submit-btn:hover {
    background: #1d4ed8;
}

.upload-submit-btn:disabled {
    opacity: .7;
    cursor: not-allowed;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .requirements-page {
        width: 100%;
    }

    .page-header {
        flex-direction: column;
        align-items: stretch;
    }

    .summary-card {
        width: 100%;
        min-width: 0;
        min-height: 80px;
    }

    .requirements-card {
        padding: 18px;
    }

    .table-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 8px;
    }

    .action-btn {
        max-width: 140px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 700px) {

    .requirements-page {
        margin: 0 !important;
        padding: 0 !important;
    }


    /* HEADER */

    .page-header {
        gap: 15px;
        margin-bottom: 18px;
    }

    .page-title h2 {
        font-size: 24px;
        line-height: 1.3;
    }

    .page-title p {
        font-size: 13px;
    }


    /* SUMMARY */

    .summary-card {
        min-height: 75px;

        border-radius: 13px;
    }

    .summary-card h3 {
        font-size: 28px;
    }

    .summary-card small {
        margin-top: 5px;
        font-size: 12px;
    }


    /* INFO */

    .info-banner {
        padding: 14px;
        gap: 10px;

        border-radius: 10px;

        margin-bottom: 15px;
    }

    .info-banner-icon {
        font-size: 18px;
    }

    .info-banner-text {
        font-size: 13px;
    }


    /* CARD */

    .requirements-card {
        padding: 14px;

        border-radius: 14px;
    }

    .table-header {
        margin-bottom: 15px;
    }

    .table-header h3 {
        font-size: 17px;
    }

    .table-header span {
        font-size: 12px;
    }


    /* =====================================================
       MOBILE TABLE -> CARDS
    ===================================================== */

    .table-wrapper {
        overflow: visible;
    }

    .requirements-table {
        width: 100%;
        min-width: 0;

        display: block;
    }

    .requirements-table thead {
        display: none;
    }

    .requirements-table tbody {
        display: block;
        width: 100%;
    }

    .requirements-table tbody tr {
        display: block;

        width: 100%;

        margin-bottom: 14px;

        padding: 16px;

        background: #202f63;

        border: 1px solid rgba(255, 255, 255, .08);

        border-radius: 14px;

        box-shadow:
            0 5px 15px rgba(0, 0, 0, .18);
    }

    .requirements-table tbody tr:last-child {
        margin-bottom: 0;
    }

    .requirements-table tbody tr:hover {
        background: #26366e;
    }

    .requirements-table td {
        display: block;

        width: 100%;

        padding: 0;

        border: none;

        font-size: 13px;

        line-height: 1.5;
    }


    /* NUMBER */

    .requirements-table td:nth-child(1) {
        display: none;
    }


    /* REQUIREMENT */

    .requirements-table td:nth-child(2) {
        margin-bottom: 14px;
    }

    .requirements-table td:nth-child(2)::before {
        content: "Requirement";

        display: block;

        margin-bottom: 5px;

        color: #94a3b8;

        font-size: 11px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .requirement-name {
        font-size: 15px;
    }

    .requirement-description {
        font-size: 12px;
    }


    /* FREQUENCY */

    .requirements-table td:nth-child(3) {
        display: flex;

        justify-content: space-between;
        align-items: center;

        gap: 10px;

        margin-bottom: 12px;

        padding-bottom: 12px;

        border-bottom:
            1px solid rgba(255, 255, 255, .07);
    }

    .requirements-table td:nth-child(3)::before {
        content: "Frequency";

        color: #94a3b8;

        font-size: 11px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .frequency {
        text-align: right;
    }


    /* STATUS */

    .requirements-table td:nth-child(4) {
        display: flex;

        justify-content: space-between;
        align-items: center;

        gap: 10px;

        margin-bottom: 14px;

        padding-bottom: 12px;

        border-bottom:
            1px solid rgba(255, 255, 255, .07);
    }

    .requirements-table td:nth-child(4)::before {
        content: "Status";

        color: #94a3b8;

        font-size: 11px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .5px;
    }


    /* ACTION */

    .requirements-table td:nth-child(5) {
        display: block;

        width: 100%;
    }

    .requirements-table td:nth-child(5)::before {
        content: "Action";

        display: block;

        margin-bottom: 7px;

        color: #94a3b8;

        font-size: 11px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .action-btn {
        width: 100%;
        max-width: none;

        min-height: 42px;
    }


    /* NOT DEPLOYED */

    .not-deployed-message {
        padding: 30px 15px;

        font-size: 14px;
    }

    .empty-message {
        padding: 30px 15px;
    }

}


/* =========================================================
   SMALL PHONES
========================================================= */

@media (max-width: 480px) {

    .page-title h2 {
        font-size: 21px;
    }

    .page-title p {
        font-size: 12px;
    }

    .requirements-card {
        padding: 10px;

        border-radius: 12px;
    }

    .requirements-table tbody tr {
        padding: 14px;

        border-radius: 12px;
    }

    .requirement-name {
        font-size: 14px;
    }

    .requirement-description {
        font-size: 11px;
    }

    .status {
        padding: 6px 10px;
        font-size: 11px;
    }

    .frequency {
        font-size: 11px;
        padding: 5px 8px;
    }


    /* MODAL */

    .custom-modal {
        padding: 10px;

        align-items: flex-start;
    }

    .custom-modal-content {
        width: 100%;

        max-height: calc(100vh - 20px);

        margin-top: 10px;

        padding: 18px;

        border-radius: 13px;
    }

    .custom-modal-header {
        margin-bottom: 16px;
        padding-bottom: 14px;
    }

    .custom-modal-header h3 {
        font-size: 17px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 12px;
    }

    .form-group input,
    .form-group textarea {
        font-size: 13px;
        padding: 11px 12px;
    }

    .modal-buttons {
        flex-direction: column-reverse;

        gap: 8px;

        margin-top: 20px;
    }

    .cancel-btn,
    .upload-submit-btn {
        width: 100%;

        min-height: 44px;
    }

}


/* =========================================================
   VERY SMALL PHONES
========================================================= */

@media (max-width: 360px) {

    .page-title h2 {
        font-size: 19px;
    }

    .summary-card h3 {
        font-size: 25px;
    }

    .requirements-card {
        padding: 8px;
    }

    .requirements-table tbody tr {
        padding: 12px;
    }

    .info-banner {
        padding: 12px;
    }

}


/* =========================================================
   ACCESSIBILITY
========================================================= */

.action-btn:focus-visible,
.cancel-btn:focus-visible,
.upload-submit-btn:focus-visible,
.close-modal:focus-visible {
    outline: 2px solid #60a5fa;
    outline-offset: 2px;
}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .action-btn,
    .requirements-table tbody tr,
    .close-modal,
    .cancel-btn,
    .upload-submit-btn {
        transition: none;
    }

    .custom-modal-content {
        animation: none;
    }

}

</style>


<div class="container mt-4 requirements-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">

        <div class="page-title">

            <h2>
                📄 Onboard Requirements
            </h2>

            <p>
                Submit and manage the documents required for your onboard training.
            </p>

        </div>


        <div class="summary-card">

            <h3>
                {{ count($requirements) }}
            </h3>

            <small>
                Total Requirements
            </small>

        </div>

    </div>


    {{-- =====================================================
         INFORMATION
    ====================================================== --}}

    @if(!isset($notDeployed) || !$notDeployed)

        <div class="info-banner">

            <div class="info-banner-icon">
                ℹ️
            </div>

            <div class="info-banner-text">

                <strong>Submission Process:</strong>

                Upload your required document and wait for the administrator
                to verify it.

                Once approved, the requirement will be marked as completed.

            </div>

        </div>

    @endif


    {{-- =====================================================
         REQUIREMENTS CARD
    ====================================================== --}}

    <div class="requirements-card">

        <div class="table-header">

            <h3>
                Requirement Checklist
            </h3>

            <span>
                Keep your documents up to date
            </span>

        </div>


        <div class="table-wrapper">

            <table class="requirements-table">

                <thead>

                    <tr>

                        <th style="width: 60px;">
                            #
                        </th>

                        <th>
                            Requirement
                        </th>

                        <th>
                            Frequency
                        </th>

                        <th>
                            Status
                        </th>

                        <th style="width: 170px;">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    {{-- =================================================
                         NOT DEPLOYED
                    ================================================== --}}

                    @if(isset($notDeployed) && $notDeployed)

                        <tr>

                            <td colspan="5">

                                <div class="not-deployed-message">

                                    🚢

                                    <br>

                                    <strong>
                                        Requirements are not available yet.
                                    </strong>

                                    <br>

                                    <span>
                                        Your onboard requirements will become
                                        available once you are deployed.
                                    </span>

                                </div>

                            </td>

                        </tr>


                    @else

                        {{-- =================================================
                             REQUIREMENTS
                        ================================================== --}}

                        @forelse($requirements as $requirement)

                            @php

                                $submission =
                                    $submissions[$requirement->id] ?? null;

                                /*
                                |--------------------------------------------------------------------------
                                | Treat old Pending records as Submitted
                                |--------------------------------------------------------------------------
                                */

                                $status =
                                    $submission?->status === 'Pending'
                                        ? 'Submitted'
                                        : $submission?->status;

                            @endphp


                            <tr>

                                {{-- NUMBER --}}

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- REQUIREMENT --}}

                                <td>

                                    <div class="requirement-name">
                                        {{ $requirement->title }}
                                    </div>

                                    @if(!empty($requirement->description))

                                        <div class="requirement-description">
                                            {{ $requirement->description }}
                                        </div>

                                    @endif

                                </td>


                                {{-- FREQUENCY --}}

                                <td>

                                    @if(!empty($requirement->frequency))

                                        <span class="frequency">
                                            {{ $requirement->frequency }}
                                        </span>

                                    @else

                                        <span style="color:#94a3b8;">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if(!$submission)

                                        <span class="status none">

                                            <span class="status-dot"></span>

                                            Not Submitted

                                        </span>


                                    @elseif($status === 'Submitted')

                                        <span class="status submitted">

                                            <span class="status-dot"></span>

                                            Submitted

                                        </span>


                                    @elseif($status === 'Approved')

                                        <span class="status approved">

                                            <span class="status-dot"></span>

                                            Approved

                                        </span>


                                    @elseif($status === 'Rejected')

                                        <span class="status rejected">

                                            <span class="status-dot"></span>

                                            Rejected

                                        </span>


                                    @else

                                        <span class="status none">

                                            <span class="status-dot"></span>

                                            {{ $status }}

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}

                                <td>

                                    {{-- =====================================
                                         NO SUBMISSION
                                    ====================================== --}}

                                    @if(!$submission)

                                        <button
                                            type="button"
                                            class="action-btn upload-btn"
                                            data-id="{{ $requirement->id }}"
                                            data-title="{{ $requirement->title }}"
                                            onclick="openUploadModal(this)">

                                            📤 Upload

                                        </button>


                                    {{-- =====================================
                                         SUBMITTED
                                    ====================================== --}}

                                    @elseif($status === 'Submitted')

                                        <button
                                            type="button"
                                            class="action-btn replace-btn"
                                            data-id="{{ $requirement->id }}"
                                            data-title="{{ $requirement->title }}"
                                            onclick="openUploadModal(this)">

                                            🔄 Replace File

                                        </button>


                                    {{-- =====================================
                                         REJECTED
                                    ====================================== --}}

                                    @elseif($status === 'Rejected')

                                        <button
                                            type="button"
                                            class="action-btn reject-btn"
                                            data-id="{{ $requirement->id }}"
                                            data-title="{{ $requirement->title }}"
                                            onclick="openUploadModal(this)">

                                            🔁 Re-upload

                                        </button>


                                    {{-- =====================================
                                         APPROVED
                                    ====================================== --}}

                                    @elseif($status === 'Approved')

                                        <button
                                            type="button"
                                            class="action-btn completed-btn"
                                            disabled>

                                            ✓ Completed

                                        </button>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="5">

                                    <div class="empty-message">

                                        📋

                                        <br><br>

                                        No onboard requirements are currently available.

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    @endif

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     UPLOAD MODAL
========================================================= --}}

<div
    id="uploadModal"
    class="custom-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="uploadModalTitle">

    <div class="custom-modal-content">

        {{-- MODAL HEADER --}}

        <div class="custom-modal-header">

            <h3 id="uploadModalTitle">
                Upload Requirement
            </h3>

            <button
                type="button"
                class="close-modal"
                onclick="closeUploadModal()"
                aria-label="Close">

                &times;

            </button>

        </div>


        {{-- FORM --}}

        <form
            id="uploadForm"
            action="{{ route('cadet.onboard.requirements.upload') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            {{-- REQUIREMENT ID --}}

            <input
                type="hidden"
                id="requirement_id"
                name="requirement_id">


            {{-- REQUIREMENT --}}

            <div class="form-group">

                <label>
                    Requirement
                </label>

                <div
                    id="requirementTitle"
                    class="requirement-selected">
                </div>

            </div>


            {{-- FILE --}}

            <div class="form-group">

                <label for="attachment">
                    Document
                </label>

                <input
                    type="file"
                    id="attachment"
                    name="attachment"
                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                    required>

                <div class="form-help">
                    Maximum file size: 10 MB.
                    Accepted files: PDF, JPG, PNG, DOC, DOCX.
                </div>

            </div>


            {{-- REMARKS --}}

            <div class="form-group">

                <label for="remarks">
                    Remarks
                </label>

                <textarea
                    id="remarks"
                    name="remarks"
                    rows="4"
                    placeholder="Add any additional information about this submission..."></textarea>

            </div>


            {{-- BUTTONS --}}

            <div class="modal-buttons">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeUploadModal()">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="upload-submit-btn"
                    id="uploadSubmitBtn">

                    📤 Submit Requirement

                </button>

            </div>

        </form>

    </div>

</div>


<script>

/* =========================================================
   OPEN UPLOAD MODAL
========================================================= */

function openUploadModal(button) {

    const modal =
        document.getElementById('uploadModal');

    const requirementId =
        document.getElementById('requirement_id');

    const requirementTitle =
        document.getElementById('requirementTitle');

    const attachment =
        document.getElementById('attachment');

    const remarks =
        document.getElementById('remarks');

    const submitButton =
        document.getElementById('uploadSubmitBtn');


    /* Set requirement */

    requirementId.value =
        button.dataset.id;

    requirementTitle.textContent =
        button.dataset.title;


    /* Reset form fields */

    attachment.value = '';

    remarks.value = '';


    /* Reset submit button */

    submitButton.disabled = false;

    submitButton.textContent =
        '📤 Submit Requirement';


    /* Show modal */

    modal.style.display = 'flex';


    /* Prevent body scrolling */

    document.body.style.overflow = 'hidden';


    /* Focus file input */

    setTimeout(function () {

        attachment.focus();

    }, 100);

}


/* =========================================================
   CLOSE UPLOAD MODAL
========================================================= */

function closeUploadModal() {

    const modal =
        document.getElementById('uploadModal');

    modal.style.display = 'none';

    document.body.style.overflow = '';

}


/* =========================================================
   CLOSE WHEN CLICKING OUTSIDE MODAL
========================================================= */

window.addEventListener('click', function (event) {

    const modal =
        document.getElementById('uploadModal');

    if (event.target === modal) {

        closeUploadModal();

    }

});


/* =========================================================
   CLOSE WITH ESCAPE
========================================================= */

document.addEventListener('keydown', function (event) {

    if (event.key === 'Escape') {

        const modal =
            document.getElementById('uploadModal');

        if (modal.style.display === 'flex') {

            closeUploadModal();

        }

    }

});


/* =========================================================
   PREVENT DOUBLE SUBMISSION
========================================================= */

const uploadForm =
    document.getElementById('uploadForm');

if (uploadForm) {

    uploadForm.addEventListener(
        'submit',
        function () {

            const submitButton =
                document.getElementById('uploadSubmitBtn');

            submitButton.disabled = true;

            submitButton.textContent =
                '⏳ Submitting...';

        }
    );

}


/* =========================================================
   RESET BODY SCROLL IF PAGE IS RESTORED
========================================================= */

window.addEventListener('pageshow', function () {

    document.body.style.overflow = '';

});

</script>

@endsection