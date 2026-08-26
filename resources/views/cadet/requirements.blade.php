@extends('layouts.cadet')

@section('content')

<style>

/* =========================================================
   REQUIREMENTS PAGE
========================================================= */

.requirements-page {
    width: 100%;
    padding: 10px 0 35px;
    color: #fff;
}

/* =========================================================
   HEADER
========================================================= */

.requirements-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 25px;
    margin-bottom: 28px;
}

.header-content {
    min-width: 0;
}

.header-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 6px 11px;
    margin-bottom: 12px;

    border-radius: 30px;

    background: rgba(59, 130, 246, .12);
    border: 1px solid rgba(96, 165, 250, .20);

    color: #93c5fd;

    font-size: 12px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .5px;
}

.header-title {
    margin: 0 0 8px;

    font-size: 30px;
    line-height: 1.2;
    font-weight: 800;

    color: #fff;
    letter-spacing: -.5px;
}

.header-description {
    max-width: 700px;

    margin: 0;

    color: #94a3b8;

    font-size: 14px;
    line-height: 1.7;
}

/* =========================================================
   HEADER SUMMARY
========================================================= */

.header-summary {
    min-width: 220px;

    padding: 18px 22px;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1e40af
        );

    border: 1px solid rgba(255,255,255,.12);

    box-shadow:
        0 15px 35px rgba(0,0,0,.30);

    text-align: center;
}

.header-summary-label {
    display: block;

    margin-bottom: 5px;

    color: rgba(255,255,255,.75);

    font-size: 12px;
    font-weight: 600;

    text-transform: uppercase;
    letter-spacing: .5px;
}

.header-summary-number {
    display: block;

    font-size: 34px;
    line-height: 1;

    font-weight: 800;

    color: #fff;
}

.header-summary-text {
    display: block;

    margin-top: 7px;

    color: rgba(255,255,255,.85);

    font-size: 12px;
}

/* =========================================================
   STATISTICS
========================================================= */

.stats-grid {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 18px;

    margin-bottom: 25px;
}

.stat-card {
    position: relative;

    min-height: 145px;

    padding: 22px;

    overflow: hidden;

    border-radius: 20px;

    color: #fff;

    border: 1px solid rgba(255,255,255,.10);

    box-shadow:
        0 12px 30px rgba(0,0,0,.25);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}

.stat-card:hover {
    transform: translateY(-4px);

    box-shadow:
        0 18px 38px rgba(0,0,0,.35);
}

/* Decorative circles */

.stat-card::before {
    content: "";

    position: absolute;

    width: 120px;
    height: 120px;

    right: -45px;
    top: -45px;

    border-radius: 50%;

    background: rgba(255,255,255,.10);
}

.stat-card::after {
    content: "";

    position: absolute;

    width: 75px;
    height: 75px;

    left: -30px;
    bottom: -35px;

    border-radius: 50%;

    background: rgba(255,255,255,.07);
}

/* Colors */

.stat-blue {
    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1e3a8a
        );
}

.stat-green {
    background:
        linear-gradient(
            135deg,
            #22c55e,
            #166534
        );
}

.stat-orange {
    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #b45309
        );
}

.stat-red {
    background:
        linear-gradient(
            135deg,
            #ef4444,
            #991b1b
        );
}

.stat-top {
    position: relative;
    z-index: 2;

    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 18px;
}

.stat-icon {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    background: rgba(255,255,255,.16);

    font-size: 20px;
}

.stat-label {
    position: relative;
    z-index: 2;

    display: block;

    margin-bottom: 5px;

    color: rgba(255,255,255,.80);

    font-size: 12px;
    font-weight: 600;

    text-transform: uppercase;
    letter-spacing: .4px;
}

.stat-number {
    position: relative;
    z-index: 2;

    font-size: 32px;
    line-height: 1;

    font-weight: 800;
}

.stat-percent {
    position: relative;
    z-index: 2;

    margin-top: 7px;

    color: rgba(255,255,255,.72);

    font-size: 11px;
}

/* =========================================================
   PROGRESS OVERVIEW
========================================================= */

.progress-card {
    margin-bottom: 25px;

    padding: 20px 22px;

    background: rgba(255,255,255,.045);

    border: 1px solid rgba(255,255,255,.08);

    border-radius: 18px;

    box-shadow:
        0 10px 25px rgba(0,0,0,.18);
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 15px;

    margin-bottom: 12px;
}

.progress-title {
    margin: 0;

    font-size: 14px;
    font-weight: 700;

    color: #fff;
}

.progress-value {
    font-size: 14px;
    font-weight: 700;

    color: #60a5fa;
}

.progress-track {
    width: 100%;
    height: 9px;

    overflow: hidden;

    border-radius: 30px;

    background: rgba(255,255,255,.08);
}

.progress-fill {
    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #60a5fa
        );

    transition: width .5s ease;
}

/* =========================================================
   MAIN REQUIREMENTS BOX
========================================================= */

.requirements-box {
    background:
        rgba(255,255,255,.045);

    border:
        1px solid rgba(255,255,255,.08);

    border-radius: 22px;

    padding: 22px;

    box-shadow:
        0 15px 35px rgba(0,0,0,.22);

    backdrop-filter: blur(12px);
}

/* =========================================================
   TABLE HEADER
========================================================= */

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 20px;

    margin-bottom: 18px;
}

.table-title-area h3 {
    margin: 0 0 5px;

    font-size: 18px;
    font-weight: 700;

    color: #fff;
}

.table-title-area p {
    margin: 0;

    color: #94a3b8;

    font-size: 12px;
}

.table-count {
    display: inline-flex;
    align-items: center;

    padding: 7px 11px;

    border-radius: 8px;

    background: rgba(59,130,246,.10);

    border: 1px solid rgba(96,165,250,.15);

    color: #93c5fd;

    font-size: 12px;
    font-weight: 600;

    white-space: nowrap;
}

/* =========================================================
   TABLE WRAPPER
========================================================= */

.table-wrapper {
    width: 100%;

    overflow-x: auto;

    border-radius: 14px;

    scrollbar-width: thin;
    scrollbar-color: #334155 transparent;
}

/* =========================================================
   TABLE
========================================================= */

.requirements-table {
    width: 100%;

    border-collapse: separate;
    border-spacing: 0;

    color: #fff;
}

.requirements-table thead {
    background: #1e3a8a;
}

.requirements-table th {
    padding: 15px;

    text-align: left;

    color: #dbeafe;

    font-size: 11px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .6px;

    white-space: nowrap;

    border-bottom:
        1px solid rgba(255,255,255,.08);
}

.requirements-table th:first-child {
    border-radius: 10px 0 0 10px;
}

.requirements-table th:last-child {
    border-radius: 0 10px 10px 0;
}

.requirements-table td {
    padding: 17px 15px;

    color: #e2e8f0;

    font-size: 13px;

    vertical-align: middle;

    border-bottom:
        1px solid rgba(255,255,255,.06);
}

.requirements-table tbody tr {
    transition:
        background .2s ease;
}

.requirements-table tbody tr:hover {
    background:
        rgba(59,130,246,.055);
}

.requirements-table tbody tr:last-child td {
    border-bottom: none;
}

/* =========================================================
   REQUIREMENT NAME
========================================================= */

.requirement-name {
    display: flex;
    align-items: center;

    gap: 11px;

    min-width: 200px;
}

.requirement-icon {
    width: 36px;
    height: 36px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background:
        rgba(37,99,235,.13);

    border:
        1px solid rgba(96,165,250,.15);

    font-size: 16px;
}

.requirement-text {
    min-width: 0;
}

.requirement-text strong {
    display: block;

    color: #f8fafc;

    font-size: 13px;
    font-weight: 700;

    line-height: 1.4;
}

.requirement-text small {
    display: block;

    margin-top: 3px;

    color: #64748b;

    font-size: 11px;
}

/* =========================================================
   STATUS
========================================================= */

.status {
    display: inline-flex;

    align-items: center;
    gap: 7px;

    padding: 7px 11px;

    border-radius: 30px;

    font-size: 11px;
    font-weight: 700;

    white-space: nowrap;
}

.status-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;
}

.status.approved {
    background: rgba(34,197,94,.13);
    border: 1px solid rgba(74,222,128,.16);
    color: #4ade80;
}

.status.pending {
    background: rgba(245,158,11,.13);
    border: 1px solid rgba(251,191,36,.16);
    color: #fbbf24;
}

.status.submitted {
    background: rgba(37,99,235,.13);
    border: 1px solid rgba(96,165,250,.16);
    color: #60a5fa;
}

.status.rejected {
    background: rgba(239,68,68,.13);
    border: 1px solid rgba(248,113,113,.16);
    color: #f87171;
}

.status.none {
    background: rgba(100,116,139,.13);
    border: 1px solid rgba(148,163,184,.12);
    color: #94a3b8;
}

/* =========================================================
   REMARKS
========================================================= */

.remarks-text {
    max-width: 280px;

    color: #94a3b8;

    font-size: 12px;
    line-height: 1.5;
}

.remarks-empty {
    color: #64748b;

    font-style: italic;
}

/* =========================================================
   ACTIONS
========================================================= */

.actions-wrapper {
    display: flex;
    flex-wrap: wrap;

    gap: 8px;
}

.action-btn,
.btn-view {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    min-width: 105px;

    padding: 9px 13px;

    border-radius: 9px;

    border: none;

    font-size: 11px;
    font-weight: 700;

    cursor: pointer;

    text-decoration: none;

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.action-btn:hover,
.btn-view:hover {
    transform: translateY(-2px);
}

.upload-btn {
    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    color: #fff;

    box-shadow:
        0 5px 15px rgba(37,99,235,.18);
}

.upload-btn:hover {
    box-shadow:
        0 8px 20px rgba(37,99,235,.28);
}

.replace-btn {
    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #d97706
        );

    color: #fff;
}

.reject-btn {
    background:
        linear-gradient(
            135deg,
            #ef4444,
            #b91c1c
        );

    color: #fff;
}

.completed-btn {
    background:
        rgba(34,197,94,.14);

    border:
        1px solid rgba(74,222,128,.18);

    color: #4ade80;

    cursor: default;
}

.completed-btn:hover {
    transform: none;
}

.btn-view {
    background:
        rgba(6,182,212,.13);

    border:
        1px solid rgba(34,211,238,.18);

    color: #67e8f9;
}

.btn-view:hover {
    background:
        rgba(6,182,212,.20);
}

/* =========================================================
   NOTE
========================================================= */

.note {
    display: flex;
    align-items: flex-start;

    gap: 10px;

    margin-top: 20px;

    padding: 13px 15px;

    border-radius: 11px;

    background:
        rgba(245,158,11,.07);

    border:
        1px solid rgba(245,158,11,.12);

    color: #cbd5e1;

    font-size: 12px;
    line-height: 1.6;
}

.note-icon {
    flex-shrink: 0;

    color: #fbbf24;
}

/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {
    padding: 45px 20px;

    text-align: center;

    color: #94a3b8;
}

.empty-icon {
    width: 60px;
    height: 60px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin: 0 auto 15px;

    border-radius: 18px;

    background: rgba(255,255,255,.05);

    font-size: 26px;
}

.empty-state strong {
    display: block;

    margin-bottom: 5px;

    color: #e2e8f0;

    font-size: 15px;
}

.empty-state span {
    font-size: 12px;
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

    padding: 20px;

    box-sizing: border-box;

    justify-content: center;
    align-items: center;

    background:
        rgba(2,6,23,.78);

    backdrop-filter: blur(7px);

    z-index: 99999;
}

.custom-modal-content {
    width: 500px;
    max-width: 100%;

    max-height: 90vh;

    overflow-y: auto;

    padding: 25px;

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #1e3a8a,
            #172554
        );

    border:
        1px solid rgba(255,255,255,.12);

    color: #fff;

    box-shadow:
        0 30px 70px rgba(0,0,0,.55);

    animation:
        modalShow .25s ease;
}

@keyframes modalShow {

    from {
        opacity: 0;
        transform: translateY(-15px) scale(.97);
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

    justify-content: space-between;
    align-items: flex-start;

    gap: 15px;

    padding-bottom: 18px;

    margin-bottom: 22px;

    border-bottom:
        1px solid rgba(255,255,255,.10);
}

.modal-title {
    display: flex;
    align-items: center;

    gap: 12px;
}

.modal-icon {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background:
        rgba(59,130,246,.20);

    font-size: 20px;
}

.custom-modal-header h3 {
    margin: 0 0 4px;

    font-size: 19px;
    font-weight: 700;
}

.modal-subtitle {
    color: #94a3b8;

    font-size: 11px;
}

.close-modal {
    width: 34px;
    height: 34px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background:
        rgba(255,255,255,.07);

    color: #94a3b8;

    font-size: 22px;

    cursor: pointer;

    transition: .2s ease;
}

.close-modal:hover {
    background: #dc2626;
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

    color: #cbd5e1;

    font-size: 12px;
    font-weight: 700;
}

.document-selected {
    padding: 12px 14px;

    border-radius: 10px;

    background:
        rgba(255,255,255,.07);

    border:
        1px solid rgba(255,255,255,.07);

    color: #fff;

    font-size: 13px;
    font-weight: 600;
}

.form-group input[type="file"] {
    width: 100%;

    padding: 10px;

    box-sizing: border-box;

    border-radius: 10px;

    background:
        rgba(255,255,255,.07);

    border:
        1px dashed rgba(255,255,255,.25);

    color: #cbd5e1;

    font-size: 12px;

    cursor: pointer;
}

.form-group input[type="file"]::file-selector-button {
    margin-right: 10px;

    padding: 8px 12px;

    border: none;

    border-radius: 7px;

    background: #2563eb;

    color: #fff;

    font-size: 11px;
    font-weight: 600;

    cursor: pointer;
}

.form-help {
    display: block;

    margin-top: 7px;

    color: #64748b;

    font-size: 10px;
}

.form-error {
    margin-top: 7px;

    color: #f87171;

    font-size: 11px;
}

/* =========================================================
   MODAL BUTTONS
========================================================= */

.modal-buttons {
    display: flex;

    justify-content: flex-end;

    gap: 10px;

    margin-top: 24px;
}

.cancel-btn,
.upload-submit-btn {
    min-width: 105px;

    padding: 11px 16px;

    border: none;

    border-radius: 9px;

    font-size: 12px;
    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;
}

.cancel-btn {
    background:
        rgba(255,255,255,.10);

    color: #cbd5e1;
}

.cancel-btn:hover {
    background:
        rgba(255,255,255,.16);
}

.upload-submit-btn {
    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    color: #fff;

    box-shadow:
        0 7px 18px rgba(37,99,235,.20);
}

.upload-submit-btn:hover {
    transform: translateY(-1px);

    box-shadow:
        0 10px 24px rgba(37,99,235,.30);
}

.upload-submit-btn:disabled {
    opacity: .65;

    cursor: not-allowed;

    transform: none;
}

/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1100px) {

    .stats-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .requirements-table {
        min-width: 850px;
    }

}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .requirements-page {
        padding: 5px 0 25px;
    }

    .requirements-header {
        flex-direction: column;

        align-items: stretch;

        gap: 18px;

        margin-bottom: 20px;
    }

    .header-title {
        font-size: 24px;
    }

    .header-description {
        font-size: 13px;
    }

    .header-summary {
        width: 100%;

        min-width: 0;

        box-sizing: border-box;
    }

    .stats-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 12px;

        margin-bottom: 18px;
    }

    .stat-card {
        min-height: 125px;

        padding: 16px;

        border-radius: 16px;
    }

    .stat-top {
        margin-bottom: 13px;
    }

    .stat-icon {
        width: 36px;
        height: 36px;

        border-radius: 10px;

        font-size: 17px;
    }

    .stat-number {
        font-size: 26px;
    }

    .progress-card {
        padding: 16px;

        margin-bottom: 18px;
    }

    .requirements-box {
        padding: 14px;

        border-radius: 17px;
    }

    .table-header {
        flex-direction: column;

        align-items: flex-start;

        gap: 10px;
    }

    .table-count {
        width: 100%;

        justify-content: center;

        box-sizing: border-box;
    }

    /*
     * Mobile card table
     */

    .table-wrapper {
        overflow: visible;
    }

    .requirements-table,
    .requirements-table tbody {
        display: block;

        width: 100%;

        min-width: 0;
    }

    .requirements-table thead {
        display: none;
    }

    .requirements-table tbody tr {
        display: block;

        margin-bottom: 14px;

        padding: 8px 0;

        border:
            1px solid rgba(255,255,255,.07);

        border-radius: 15px;

        background:
            rgba(255,255,255,.025);
    }

    .requirements-table tbody tr:hover {
        background:
            rgba(255,255,255,.04);
    }

    .requirements-table td {
        display: flex;

        align-items: flex-start;

        justify-content: space-between;

        gap: 15px;

        padding: 11px 13px;

        border-bottom:
            1px solid rgba(255,255,255,.05);

        text-align: right;
    }

    .requirements-table td:last-child {
        border-bottom: none;
    }

    .requirements-table td::before {
        flex-shrink: 0;

        color: #64748b;

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .5px;

        text-align: left;
    }

    .requirements-table td:nth-child(1)::before {
        content: "Requirement";
    }

    .requirements-table td:nth-child(2)::before {
        content: "Status";
    }

    .requirements-table td:nth-child(3)::before {
        content: "Remarks";
    }

    .requirements-table td:nth-child(4)::before {
        content: "Action";
    }

    .requirement-name {
        justify-content: flex-end;

        min-width: 0;

        text-align: right;
    }

    .requirement-icon {
        display: none;
    }

    .requirement-text {
        max-width: 65%;
    }

    .requirement-text strong {
        font-size: 12px;
    }

    .remarks-text {
        max-width: 65%;
    }

    .actions-wrapper {
        justify-content: flex-end;

        max-width: 70%;
    }

    .action-btn,
    .btn-view {
        min-width: 100px;

        padding: 9px 11px;
    }

    .note {
        font-size: 11px;
    }

    .custom-modal {
        padding: 12px;

        align-items: center;
    }

    .custom-modal-content {
        width: 100%;

        max-height: 92vh;

        padding: 20px;

        border-radius: 17px;
    }

}

/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 480px) {

    .header-title {
        font-size: 21px;
    }

    .header-badge {
        font-size: 10px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stat-card {
        min-height: 110px;
    }

    .stat-number {
        font-size: 25px;
    }

    .requirements-box {
        padding: 10px;
    }

    .requirements-table td {
        padding: 10px;
    }

    .status {
        font-size: 10px;

        padding: 6px 9px;
    }

    .actions-wrapper {
        flex-direction: column;

        align-items: stretch;

        width: 100%;

        max-width: 70%;
    }

    .action-btn,
    .btn-view {
        width: 100%;

        box-sizing: border-box;
    }

    .modal-buttons {
        flex-direction: column-reverse;
    }

    .cancel-btn,
    .upload-submit-btn {
        width: 100%;
    }

}

/* =========================================================
   VERY SMALL DEVICES
========================================================= */

@media (max-width: 360px) {

    .header-title {
        font-size: 19px;
    }

    .header-description {
        font-size: 12px;
    }

    .stat-card {
        padding: 14px;
    }

    .requirements-box {
        padding: 8px;
    }

    .requirements-table td {
        gap: 8px;
    }

    .requirement-text {
        max-width: 60%;
    }

}

</style>


<div class="requirements-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="requirements-header">

        <div class="header-content">

            <div class="header-badge">
                📋 Training Documents
            </div>

            <h2 class="header-title">
                Requirements Monitoring
            </h2>

            <p class="header-description">
                Track your required documents, monitor verification status,
                and submit missing requirements for your onboard training.
            </p>

        </div>


        <div class="header-summary">

            <span class="header-summary-label">
                Total Requirements
            </span>

            <span class="header-summary-number">
                {{ $total }}
            </span>

            <span class="header-summary-text">
                Documents being monitored
            </span>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    @php

        $completionPercentage = $total > 0
            ? round(($approved / $total) * 100)
            : 0;

    @endphp


    <div class="stats-grid">

        {{-- TOTAL --}}

        <div class="stat-card stat-blue">

            <div class="stat-top">

                <div class="stat-icon">
                    📄
                </div>

            </div>

            <span class="stat-label">
                Total Requirements
            </span>

            <div class="stat-number">
                {{ $total }}
            </div>

            <div class="stat-percent">
                All required documents
            </div>

        </div>


        {{-- APPROVED --}}

        <div class="stat-card stat-green">

            <div class="stat-top">

                <div class="stat-icon">
                    ✓
                </div>

            </div>

            <span class="stat-label">
                Approved
            </span>

            <div class="stat-number">
                {{ $approved }}
            </div>

            <div class="stat-percent">
                {{ $total > 0 ? round(($approved / $total) * 100) : 0 }}%
                completed
            </div>

        </div>


        {{-- PENDING --}}

        <div class="stat-card stat-orange">

            <div class="stat-top">

                <div class="stat-icon">
                    ⏳
                </div>

            </div>

            <span class="stat-label">
                Pending
            </span>

            <div class="stat-number">
                {{ $pending }}
            </div>

            <div class="stat-percent">
                Awaiting verification
            </div>

        </div>


        {{-- REJECTED --}}

        <div class="stat-card stat-red">

            <div class="stat-top">

                <div class="stat-icon">
                    !
                </div>

            </div>

            <span class="stat-label">
                Rejected
            </span>

            <div class="stat-number">
                {{ $rejected }}
            </div>

            <div class="stat-percent">
                Requires re-upload
            </div>

        </div>

    </div>


    {{-- =====================================================
         PROGRESS
    ====================================================== --}}

    <div class="progress-card">

        <div class="progress-header">

            <h3 class="progress-title">
                Overall Completion
            </h3>

            <span class="progress-value">
                {{ $completionPercentage }}%
            </span>

        </div>

        <div class="progress-track">

            <div
                class="progress-fill"
                style="width: {{ $completionPercentage }}%;">
            </div>

        </div>

    </div>


    {{-- =====================================================
         REQUIREMENTS BOX
    ====================================================== --}}

    <div class="requirements-box">


        {{-- TABLE HEADER --}}

        <div class="table-header">

            <div class="table-title-area">

                <h3>
                    Document Checklist
                </h3>

                <p>
                    Review the status of each required document.
                </p>

            </div>

            <div class="table-count">

                {{ $total }} Requirements

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-wrapper">

            <table class="requirements-table">

                <thead>

                    <tr>

                        <th>
                            Requirement
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Remarks
                        </th>

                        <th style="width:220px;">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($documents as $doc)

                    @php

                        $submission =
                            $cadetDocs[$doc->id] ?? null;

                    @endphp


                    <tr>

                        {{-- REQUIREMENT --}}

                        <td>

                            <div class="requirement-name">

                                <div class="requirement-icon">
                                    📄
                                </div>

                                <div class="requirement-text">

                                    <strong>
                                        {{ $doc->name }}
                                    </strong>

                                    <small>
                                        Required document
                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($submission)

                                @if($submission->status == 'Approved')

                                    <span class="status approved">

                                        <span class="status-dot"></span>

                                        Approved

                                    </span>


                                @elseif($submission->status == 'Submitted')

                                    <span class="status submitted">

                                        <span class="status-dot"></span>

                                        Submitted

                                    </span>


                                @elseif($submission->status == 'Pending')

                                    <span class="status pending">

                                        <span class="status-dot"></span>

                                        Pending

                                    </span>


                                @elseif($submission->status == 'Rejected')

                                    <span class="status rejected">

                                        <span class="status-dot"></span>

                                        Rejected

                                    </span>


                                @else

                                    <span class="status none">

                                        <span class="status-dot"></span>

                                        {{ $submission->status }}

                                    </span>

                                @endif

                            @else

                                <span class="status none">

                                    <span class="status-dot"></span>

                                    Not Submitted

                                </span>

                            @endif

                        </td>


                        {{-- REMARKS --}}

                        <td>

                            @if($submission && $submission->remarks)

                                <div class="remarks-text">

                                    {{ $submission->remarks }}

                                </div>

                            @else

                                <div class="remarks-text remarks-empty">

                                    No remarks yet

                                </div>

                            @endif

                        </td>


                        {{-- ACTION --}}

                        <td>

                            <div class="actions-wrapper">

                                {{-- VIEW FILE --}}

                                @if($submission && $submission->file_path)

                                    <a
                                        href="{{ asset('storage/'.$submission->file_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn-view">

                                        👁 View

                                    </a>

                                @endif


                                {{-- NO SUBMISSION --}}

                                @if(!$submission)

                                    <button
                                        type="button"
                                        class="action-btn upload-btn"
                                        data-id="{{ $doc->id }}"
                                        data-title="{{ $doc->name }}"
                                        onclick="openUploadModal(this)">

                                        📤 Upload

                                    </button>


                                {{-- REJECTED --}}

                                @elseif($submission->status == 'Rejected')

                                    <button
                                        type="button"
                                        class="action-btn reject-btn"
                                        data-id="{{ $doc->id }}"
                                        data-title="{{ $doc->name }}"
                                        onclick="openUploadModal(this)">

                                        🔄 Re-upload

                                    </button>


                                {{-- PENDING --}}

                                @elseif($submission->status == 'Pending')

                                    <button
                                        type="button"
                                        class="action-btn replace-btn"
                                        data-id="{{ $doc->id }}"
                                        data-title="{{ $doc->name }}"
                                        onclick="openUploadModal(this)">

                                        🔄 Replace

                                    </button>


                                {{-- SUBMITTED --}}

                                @elseif($submission->status == 'Submitted')

                                    <button
                                        type="button"
                                        class="action-btn replace-btn"
                                        data-id="{{ $doc->id }}"
                                        data-title="{{ $doc->name }}"
                                        onclick="openUploadModal(this)">

                                        🔄 Replace

                                    </button>


                                {{-- APPROVED --}}

                                @elseif($submission->status == 'Approved')

                                    <button
                                        type="button"
                                        class="action-btn completed-btn"
                                        disabled>

                                        ✓ Completed

                                    </button>

                                @endif

                            </div>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="4">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    📋
                                </div>

                                <strong>
                                    No requirements available
                                </strong>

                                <span>
                                    There are currently no documents assigned to you.
                                </span>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             NOTE
        ================================================== --}}

        <div class="note">

            <span class="note-icon">
                ●
            </span>

            <span>
                Upload and complete all required documents to proceed
                with your deployment. Documents marked as rejected should
                be reviewed and re-uploaded.
            </span>

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

            <div class="modal-title">

                <div class="modal-icon">
                    📄
                </div>

                <div>

                    <h3 id="uploadModalTitle">
                        Upload Requirement
                    </h3>

                    <div class="modal-subtitle">
                        Submit your required document
                    </div>

                </div>

            </div>


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
            action="{{ route('cadet.requirements.upload') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            {{-- DOCUMENT ID --}}

            <input
                type="hidden"
                name="document_id"
                id="document_id">


            {{-- SELECTED DOCUMENT --}}

            <div class="form-group">

                <label>
                    Requirement
                </label>

                <div
                    id="document_title"
                    class="document-selected">
                </div>

            </div>


            {{-- FILE --}}

            <div class="form-group">

                <label for="requirementFile">
                    Select Document File
                </label>

                <input
                    type="file"
                    id="requirementFile"
                    name="file"
                    accept=".pdf,.jpg,.jpeg,.png"
                    required>

                <small class="form-help">
                    Accepted formats: PDF, JPG, JPEG, PNG.
                    Maximum file size: 10 MB.
                </small>

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

                    📤 Upload Document

                </button>

            </div>

        </form>

    </div>

</div>


<script>

/* =========================================================
   OPEN MODAL
========================================================= */

function openUploadModal(button) {

    const modal =
        document.getElementById('uploadModal');

    const documentId =
        document.getElementById('document_id');

    const documentTitle =
        document.getElementById('document_title');

    const fileInput =
        document.getElementById('requirementFile');

    const submitButton =
        document.getElementById('uploadSubmitBtn');


    documentId.value =
        button.dataset.id;


    documentTitle.textContent =
        button.dataset.title;


    fileInput.value = '';


    submitButton.disabled = false;

    submitButton.innerHTML =
        '📤 Upload Document';


    modal.style.display = 'flex';


    document.body.style.overflow = 'hidden';


    setTimeout(function () {

        fileInput.focus();

    }, 150);

}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closeUploadModal() {

    const modal =
        document.getElementById('uploadModal');

    modal.style.display = 'none';

    document.body.style.overflow = '';

}


/* =========================================================
   CLOSE WHEN CLICKING OUTSIDE
========================================================= */

document.addEventListener('click', function(event) {

    const modal =
        document.getElementById('uploadModal');

    if (event.target === modal) {

        closeUploadModal();

    }

});


/* =========================================================
   CLOSE WITH ESCAPE
========================================================= */

document.addEventListener('keydown', function(event) {

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

document.getElementById('uploadForm')
    .addEventListener('submit', function() {

        const submitButton =
            document.getElementById('uploadSubmitBtn');


        submitButton.disabled = true;


        submitButton.innerHTML =
            '⏳ Uploading...';

    });

</script>

@endsection