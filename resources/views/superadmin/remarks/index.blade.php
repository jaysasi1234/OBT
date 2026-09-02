@extends('layouts.superadmin')

@section('header-title', 'Cadet Monthly Remarks')

@section('content')

<style>
/* =========================================================
   CADET MONTHLY REMARKS
   MODERN SUPER ADMIN THEME
========================================================= */

.remarks-page {
    --remarks-bg: #07152f;
    --remarks-bg-deep: #061126;
    --remarks-card: #101f49;
    --remarks-card-hover: #142657;
    --remarks-card-soft: #172955;
    --remarks-border: rgba(96, 165, 250, 0.20);
    --remarks-border-soft: rgba(148, 163, 184, 0.14);

    --remarks-blue: #4f8cff;
    --remarks-blue-light: #8db7ff;
    --remarks-green: #22c55e;
    --remarks-orange: #f59e0b;
    --remarks-purple: #8b5cf6;

    --remarks-text: #ffffff;
    --remarks-text-light: #dbe7ff;
    --remarks-text-muted: #9fb0d0;
    --remarks-text-soft: #7f90b5;

    width: 100%;
    min-height: 100vh;
    padding: 28px;
    background: var(--remarks-bg);
    color: var(--remarks-text);
}

.remarks-page *,
.remarks-page *::before,
.remarks-page *::after {
    box-sizing: border-box;
}

/* =========================================================
   PAGE HEADER
========================================================= */

.remarks-header {
    position: relative;
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 24px;
    padding: 28px 32px;
    overflow: hidden;
    background:
        linear-gradient(
            135deg,
            #1b4fc4 0%,
            #214aa8 45%,
            #263d8d 100%
        );
    border: 1px solid rgba(96, 165, 250, 0.28);
    border-radius: 20px;
    box-shadow: 0 14px 35px rgba(0, 0, 0, 0.28);
}

.remarks-header::before,
.remarks-header::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.remarks-header::before {
    width: 190px;
    height: 190px;
    right: -65px;
    top: -105px;
    background: rgba(255, 255, 255, 0.08);
}

.remarks-header::after {
    width: 130px;
    height: 130px;
    right: 90px;
    bottom: -85px;
    background: rgba(255, 255, 255, 0.05);
}

.remarks-header-icon {
    position: relative;
    z-index: 1;

    width: 58px;
    height: 58px;
    flex: 0 0 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 15px;

    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;

    font-size: 23px;

    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
}

.remarks-header-content {
    position: relative;
    z-index: 1;
    min-width: 0;
}

.remarks-header h2 {
    margin: 0;
    color: #ffffff;
    font-size: 27px;
    font-weight: 800;
    line-height: 1.2;
}

.remarks-header p {
    margin: 7px 0 0;
    color: #dbeafe;
    font-size: 13px;
    font-weight: 500;
    line-height: 1.5;
}

/* =========================================================
   STATISTICS
========================================================= */

.remarks-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.remarks-stat {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    min-width: 0;
    min-height: 120px;

    padding: 21px;

    overflow: hidden;

    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 17px;

    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.22);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.remarks-stat::before {
    content: "";

    position: absolute;
    width: 115px;
    height: 115px;

    right: -55px;
    bottom: -60px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.07);
    pointer-events: none;
}

.remarks-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 34px rgba(0, 0, 0, 0.30);
}

.remarks-stat-content {
    position: relative;
    z-index: 1;
    min-width: 0;
}

.remarks-stat-value {
    margin: 0;
    color: #ffffff;
    font-size: 31px;
    font-weight: 800;
    line-height: 1;
}

.remarks-stat-label {
    margin: 8px 0 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 12px;
    font-weight: 700;
}

.remarks-stat-icon {
    position: relative;
    z-index: 1;

    width: 58px;
    height: 58px;
    flex: 0 0 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    color: #ffffff;
    font-size: 22px;

    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.20);
}

/* TOTAL */

.remarks-stat-blue {
    background: linear-gradient(
        135deg,
        #3164e6,
        #2852c4
    );
}

.remarks-stat-blue .remarks-stat-icon {
    background: rgba(255, 255, 255, 0.14);
}

/* PENDING */

.remarks-stat-orange {
    background: linear-gradient(
        135deg,
        #d97706,
        #b45309
    );
}

.remarks-stat-orange .remarks-stat-icon {
    background: rgba(255, 255, 255, 0.14);
}

/* REMARKS */

.remarks-stat-purple {
    background: linear-gradient(
        135deg,
        #7c3aed,
        #5b21b6
    );
}

.remarks-stat-purple .remarks-stat-icon {
    background: rgba(255, 255, 255, 0.14);
}

/* ACTIVE */

.remarks-stat-green {
    background: linear-gradient(
        135deg,
        #18a957,
        #0d8f43
    );
}

.remarks-stat-green .remarks-stat-icon {
    background: rgba(255, 255, 255, 0.14);
}

/* =========================================================
   FILTER CARD
========================================================= */

.remarks-filter-card {
    margin-bottom: 24px;
    padding: 24px;

    background:
        linear-gradient(
            135deg,
            #101f49,
            #0d1b3e
        );

    border: 1px solid var(--remarks-border);
    border-radius: 19px;

    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.22);
}

.remarks-filter-header {
    display: flex;
    align-items: center;
    gap: 9px;

    margin-bottom: 17px;

    color: #ffffff;
    font-size: 15px;
    font-weight: 800;
}

.remarks-filter-header i {
    color: var(--remarks-blue-light);
    font-size: 14px;
}

.remarks-filter-grid {
    display: grid;

    grid-template-columns:
        minmax(190px, 1fr)
        minmax(190px, 1fr)
        minmax(260px, 1.4fr);

    gap: 14px;
}

/* =========================================================
   FILTER CONTROL
========================================================= */

.remarks-filter-group {
    min-width: 0;
}

.remarks-filter-label {
    display: block;

    margin: 0 0 7px 2px;

    color: var(--remarks-text-muted);
    font-size: 11px;
    font-weight: 700;
}

.remarks-filter-control {
    width: 100%;
    height: 48px;

    padding: 0 14px;

    border: 1px solid rgba(96, 165, 250, 0.15);
    border-radius: 10px;

    outline: none;

    background: #172955;
    color: #ffffff;

    font-family: inherit;
    font-size: 13px;
    font-weight: 600;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}

.remarks-filter-control:hover {
    background: #1a2e5d;
    border-color: rgba(96, 165, 250, 0.30);
}

.remarks-filter-control:focus {
    background: #1a2e5d;
    border-color: var(--remarks-blue);

    box-shadow:
        0 0 0 3px rgba(79, 140, 255, 0.15);
}

.remarks-filter-control::placeholder {
    color: #7184aa;
    font-weight: 500;
}

.remarks-filter-control option {
    background: #172955;
    color: #ffffff;
}

/* =========================================================
   SEARCH
========================================================= */

.remarks-search {
    position: relative;
}

.remarks-search i {
    position: absolute;

    top: 50%;
    left: 15px;
    z-index: 2;

    color: #7184aa;
    font-size: 13px;

    transform: translateY(-50%);
    pointer-events: none;
}

.remarks-search input {
    padding-left: 40px;
}

/* =========================================================
   TABLE CARD
========================================================= */

.remarks-table-card {
    width: 100%;
    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            #101f49,
            #0d1b3e
        );

    border: 1px solid var(--remarks-border);
    border-radius: 20px;

    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.24);
}

/* =========================================================
   TABLE TOP
========================================================= */

.remarks-table-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    padding: 20px 23px;

    border-bottom: 1px solid var(--remarks-border);
}

.remarks-table-heading {
    min-width: 0;
}

.remarks-table-title {
    display: flex;
    align-items: center;
    gap: 9px;

    color: #ffffff;
    font-size: 15px;
    font-weight: 800;
}

.remarks-table-title i {
    color: var(--remarks-blue-light);
}

.remarks-table-subtitle {
    margin: 5px 0 0;

    color: var(--remarks-text-muted);
    font-size: 12px;
    line-height: 1.5;
}

.remarks-table-meta {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 7px 11px;

    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 999px;

    background: rgba(79, 140, 255, 0.08);

    color: #a9c7ff;

    font-size: 11px;
    font-weight: 800;

    white-space: nowrap;
}

/* =========================================================
   TABLE WRAPPER
========================================================= */

.remarks-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.remarks-table-wrapper::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.remarks-table-wrapper::-webkit-scrollbar-track {
    background: #091633;
}

.remarks-table-wrapper::-webkit-scrollbar-thumb {
    background: #344b7c;
    border-radius: 999px;
}

.remarks-table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #48649b;
}

/* =========================================================
   TABLE
========================================================= */

.remarks-table {
    width: 100%;
    min-width: 1000px;

    border-collapse: collapse;
}

/* =========================================================
   TABLE HEADER
========================================================= */

.remarks-table thead {
    background:
        linear-gradient(
            135deg,
            #315fe0,
            #294fc2
        );
}

.remarks-table th {
    padding: 15px 14px;

    border: 0;

    color: #ffffff;

    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.45px;

    text-align: center;
    text-transform: uppercase;

    white-space: nowrap;
}

.remarks-table th:first-child {
    padding-left: 20px;
}

/* =========================================================
   TABLE BODY
========================================================= */

.remarks-table td {
    padding: 15px 14px;

    border-bottom: 1px solid var(--remarks-border-soft);

    color: var(--remarks-text-light);

    font-size: 13px;

    text-align: center;
    vertical-align: middle;
}

.remarks-table tbody tr {
    background: #101f49;

    transition:
        background 0.2s ease,
        box-shadow 0.2s ease;
}

.remarks-table tbody tr:hover {
    background: #142657;
}

.remarks-table tbody tr:last-child td {
    border-bottom: 0;
}

/* =========================================================
   TABLE TEXT
========================================================= */

.remarks-cadet-name {
    color: #ffffff;
    font-size: 13px;
    font-weight: 800;
}

.remarks-course {
    color: #d2def6;
    font-weight: 600;
}

.remarks-batch {
    color: #b8c7e4;
    font-weight: 600;
}

.remarks-muted {
    color: var(--remarks-text-soft);
    font-weight: 600;
}

/* =========================================================
   REMARKS TEXTAREA
========================================================= */

.remarks-textarea {
    width: 100%;
    min-width: 250px;
    min-height: 60px;

    padding: 10px 12px;

    border: 1px solid rgba(96, 165, 250, 0.12);
    border-radius: 9px;

    background: #0b1938;
    color: #dbe7ff;

    font-family: inherit;
    font-size: 12px;
    font-weight: 500;

    line-height: 1.5;

    resize: none;
    outline: none;

    overflow-y: auto;
}

.remarks-textarea::-webkit-scrollbar {
    width: 5px;
}

.remarks-textarea::-webkit-scrollbar-thumb {
    background: #344b7c;
    border-radius: 999px;
}

/* =========================================================
   MONTH / YEAR BADGES
========================================================= */

.remarks-period {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    padding: 6px 10px;

    border: 1px solid rgba(139, 92, 246, 0.22);
    border-radius: 999px;

    background: rgba(139, 92, 246, 0.10);

    color: #c4b5fd;

    font-size: 11px;
    font-weight: 800;
}

/* =========================================================
   VIEW BUTTON
========================================================= */

.remarks-view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-width: 72px;
    min-height: 38px;

    padding: 0 13px;

    border: 1px solid rgba(96, 165, 250, 0.28);
    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );

    color: #ffffff;

    font-family: inherit;
    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    box-shadow: 0 5px 14px rgba(37, 99, 235, 0.20);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}

.remarks-view-btn:hover {
    background:
        linear-gradient(
            135deg,
            #4f91ff,
            #3174ed
        );

    color: #ffffff;

    transform: translateY(-1px);

    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.30);
}

.remarks-view-btn:active {
    transform: translateY(0);
}

/* =========================================================
   EMPTY STATE
========================================================= */

.remarks-empty {
    padding: 60px 20px !important;

    background: #101f49 !important;

    color: var(--remarks-text-muted) !important;

    text-align: center !important;
}

.remarks-empty-icon {
    width: 64px;
    height: 64px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin: 0 auto 14px;

    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 16px;

    background: #172955;

    color: #6e89bb;

    font-size: 27px;
}

.remarks-empty strong {
    display: block;

    margin-bottom: 5px;

    color: #ffffff;

    font-size: 14px;
    font-weight: 800;
}

.remarks-empty span {
    color: var(--remarks-text-soft);

    font-size: 12px;
}

/* =========================================================
   MODAL
========================================================= */

.remarks-modal {
    position: fixed;
    inset: 0;

    z-index: 99999;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(2, 8, 23, 0.82);

    backdrop-filter: blur(7px);
}

.remarks-modal.is-open {
    display: flex;
}

/* =========================================================
   MODAL CONTENT
========================================================= */

.remarks-modal-content {
    width: min(720px, 100%);
    max-height: 90vh;

    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            #101f49,
            #0c1938
        );

    border: 1px solid rgba(96, 165, 250, 0.22);
    border-radius: 18px;

    box-shadow:
        0 25px 75px rgba(0, 0, 0, 0.55);

    animation: remarksModalIn 0.22s ease;
}

@keyframes remarksModalIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* =========================================================
   MODAL HEADER
========================================================= */

.remarks-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    padding: 18px 22px;

    background:
        linear-gradient(
            135deg,
            #315fe0,
            #294fc2
        );

    border-bottom: 1px solid rgba(96, 165, 250, 0.22);
}

.remarks-modal-header-left {
    display: flex;
    align-items: center;
    gap: 11px;

    min-width: 0;
}

.remarks-modal-header-icon {
    width: 41px;
    height: 41px;
    flex: 0 0 41px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 11px;

    background: rgba(255, 255, 255, 0.11);

    color: #ffffff;

    font-size: 17px;
}

.remarks-modal-heading {
    min-width: 0;
}

.remarks-modal-heading h3 {
    margin: 0;

    color: #ffffff;

    font-size: 18px;
    font-weight: 800;
}

.remarks-modal-heading p {
    margin: 3px 0 0;

    color: rgba(255, 255, 255, 0.72);

    font-size: 11px;
    font-weight: 500;
}

.remarks-modal-close {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 50%;

    background: rgba(255, 255, 255, 0.10);

    color: #ffffff;

    font-size: 22px;
    line-height: 1;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.remarks-modal-close:hover {
    background: rgba(255, 255, 255, 0.20);
    transform: rotate(3deg);
}

/* =========================================================
   MODAL BODY
========================================================= */

.remarks-modal-body {
    max-height: calc(90vh - 135px);

    overflow-y: auto;

    padding: 23px;
}

.remarks-modal-body::-webkit-scrollbar {
    width: 7px;
}

.remarks-modal-body::-webkit-scrollbar-track {
    background: #091633;
}

.remarks-modal-body::-webkit-scrollbar-thumb {
    background: #344b7c;
    border-radius: 999px;
}

/* =========================================================
   VIEW DETAILS
========================================================= */

.remarks-details {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 15px;
}

.remarks-detail {
    min-width: 0;

    padding: 16px;

    background: #172955;

    border: 1px solid rgba(96, 165, 250, 0.14);
    border-radius: 12px;
}

.remarks-detail-full {
    grid-column: 1 / -1;
}

.remarks-detail-label {
    display: flex;
    align-items: center;
    gap: 7px;

    margin-bottom: 8px;

    color: #91a4c9;

    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.55px;

    text-transform: uppercase;
}

.remarks-detail-label i {
    color: var(--remarks-blue-light);
    font-size: 10px;
}

.remarks-detail-value {
    display: block;

    width: 100%;

    min-height: 45px;

    padding: 11px 12px;

    border: 1px solid rgba(96, 165, 250, 0.10);
    border-radius: 9px;

    background: #0d1c3c;

    color: #ffffff;

    font-size: 13px;
    font-weight: 700;

    line-height: 1.5;

    overflow-wrap: anywhere;
}

.remarks-detail-value.textarea-value {
    min-height: 150px;

    white-space: pre-wrap;

    overflow-y: auto;
}

.remarks-detail-value.textarea-value::-webkit-scrollbar {
    width: 6px;
}

.remarks-detail-value.textarea-value::-webkit-scrollbar-thumb {
    background: #344b7c;
    border-radius: 999px;
}

/* =========================================================
   MODAL FOOTER
========================================================= */

.remarks-modal-footer {
    display: flex;
    justify-content: flex-end;

    padding: 15px 22px;

    border-top: 1px solid rgba(96, 165, 250, 0.13);

    background: #0d1b3e;
}

.remarks-close-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 40px;

    padding: 0 18px;

    border: 1px solid rgba(148, 163, 184, 0.20);
    border-radius: 9px;

    background: #27385f;

    color: #ffffff;

    font-family: inherit;
    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.remarks-close-btn:hover {
    background: #344a78;
    transform: translateY(-1px);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .remarks-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .remarks-filter-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .remarks-search {
        grid-column: 1 / -1;
    }
}

@media (max-width: 700px) {

    .remarks-page {
        padding: 15px;
    }

    .remarks-header {
        padding: 19px;
        margin-bottom: 18px;
        border-radius: 15px;
    }

    .remarks-header-icon {
        width: 46px;
        height: 46px;
        flex-basis: 46px;

        border-radius: 12px;
        font-size: 19px;
    }

    .remarks-header h2 {
        font-size: 21px;
    }

    .remarks-header p {
        font-size: 11px;
    }

    .remarks-stats {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .remarks-stat {
        min-height: 100px;
        padding: 17px;
    }

    .remarks-stat-value {
        font-size: 27px;
    }

    .remarks-stat-icon {
        width: 51px;
        height: 51px;
        flex-basis: 51px;

        font-size: 20px;
    }

    .remarks-filter-card {
        padding: 16px;
        border-radius: 15px;
    }

    .remarks-filter-grid {
        grid-template-columns: 1fr;
    }

    .remarks-search {
        grid-column: auto;
    }

    .remarks-table-top {
        align-items: flex-start;
        flex-direction: column;

        padding: 16px;
    }

    .remarks-table-meta {
        align-self: flex-start;
    }

    .remarks-table-card {
        border-radius: 15px;
    }

    .remarks-modal {
        padding: 10px;
    }

    .remarks-modal-content {
        max-height: 95vh;
        border-radius: 14px;
    }

    .remarks-modal-header {
        padding: 14px 15px;
    }

    .remarks-modal-heading h3 {
        font-size: 15px;
    }

    .remarks-modal-heading p {
        display: none;
    }

    .remarks-modal-body {
        max-height: calc(95vh - 125px);
        padding: 15px;
    }

    .remarks-details {
        grid-template-columns: 1fr;
    }

    .remarks-detail-full {
        grid-column: auto;
    }

    .remarks-modal-footer {
        padding: 13px 15px;
    }

    .remarks-close-btn {
        width: 100%;
    }
}

@media (max-width: 420px) {

    .remarks-page {
        padding: 10px;
    }

    .remarks-header {
        padding: 15px;
    }

    .remarks-header-icon {
        width: 41px;
        height: 41px;
        flex-basis: 41px;
    }

    .remarks-header h2 {
        font-size: 19px;
    }

    .remarks-stat {
        padding: 15px;
    }

    .remarks-stat-value {
        font-size: 25px;
    }

    .remarks-stat-icon {
        width: 47px;
        height: 47px;
        flex-basis: 47px;
    }

    .remarks-filter-control {
        height: 44px;
    }
}
</style>


<div class="remarks-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="remarks-header">

        <div class="remarks-header-icon">
            <i class="fas fa-comment-dots"></i>
        </div>

        <div class="remarks-header-content">

            <h2>
                Cadet Monthly Remarks
            </h2>

            <p>
                Review and monitor monthly remarks recorded for cadets.
            </p>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    @php
        $totalCadets = $cadets->count();

        $withRemarks = $cadets->filter(function ($cadet) {
            return !empty(trim((string) $cadet->remarks));
        })->count();

        $withoutRemarks = $totalCadets - $withRemarks;

        $currentMonthRemarks = $cadets->filter(function ($cadet) {
            return strtolower((string) $cadet->remarks_month) === strtolower(now()->format('F'))
                && (string) $cadet->remarks_year === now()->format('Y');
        })->count();
    @endphp


    <div class="remarks-stats">

        {{-- TOTAL --}}

        <div class="remarks-stat remarks-stat-blue">

            <div class="remarks-stat-content">

                <h3 class="remarks-stat-value">
                    {{ $totalCadets }}
                </h3>

                <p class="remarks-stat-label">
                    Total Cadets
                </p>

            </div>

            <div class="remarks-stat-icon">
                <i class="fas fa-users"></i>
            </div>

        </div>


        {{-- WITH REMARKS --}}

        <div class="remarks-stat remarks-stat-green">

            <div class="remarks-stat-content">

                <h3 class="remarks-stat-value">
                    {{ $withRemarks }}
                </h3>

                <p class="remarks-stat-label">
                    With Remarks
                </p>

            </div>

            <div class="remarks-stat-icon">
                <i class="fas fa-comment-check"></i>
            </div>

        </div>


        {{-- WITHOUT REMARKS --}}

        <div class="remarks-stat remarks-stat-orange">

            <div class="remarks-stat-content">

                <h3 class="remarks-stat-value">
                    {{ $withoutRemarks }}
                </h3>

                <p class="remarks-stat-label">
                    Without Remarks
                </p>

            </div>

            <div class="remarks-stat-icon">
                <i class="fas fa-clock"></i>
            </div>

        </div>


        {{-- CURRENT MONTH --}}

        <div class="remarks-stat remarks-stat-purple">

            <div class="remarks-stat-content">

                <h3 class="remarks-stat-value">
                    {{ $currentMonthRemarks }}
                </h3>

                <p class="remarks-stat-label">
                    This Month
                </p>

            </div>

            <div class="remarks-stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="remarks-filter-card">

        <div class="remarks-filter-header">

            <i class="fas fa-filter"></i>

            <span>
                Filter Remarks
            </span>

        </div>


        <div class="remarks-filter-grid">

            {{-- MONTH --}}

            <div class="remarks-filter-group">

                <label
                    for="monthFilter"
                    class="remarks-filter-label"
                >
                    Month
                </label>

                <select
                    id="monthFilter"
                    class="remarks-filter-control"
                    onchange="filterTable()"
                >

                    <option value="">
                        All Months
                    </option>

                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>

                </select>

            </div>


            {{-- YEAR --}}

            <div class="remarks-filter-group">

                <label
                    for="yearFilter"
                    class="remarks-filter-label"
                >
                    Year
                </label>

                <select
                    id="yearFilter"
                    class="remarks-filter-control"
                    onchange="filterTable()"
                >

                    <option value="">
                        All Years
                    </option>

                </select>

            </div>


            {{-- SEARCH --}}

            <div class="remarks-filter-group">

                <label
                    for="searchInput"
                    class="remarks-filter-label"
                >
                    Search
                </label>

                <div class="remarks-search">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        id="searchInput"
                        class="remarks-filter-control"
                        placeholder="Search cadet, course, or batch..."
                        autocomplete="off"
                        onkeyup="searchTable()"
                    >

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="remarks-table-card">

        <div class="remarks-table-top">

            <div class="remarks-table-heading">

                <div class="remarks-table-title">

                    <i class="fas fa-list-check"></i>

                    <span>
                        Monthly Remarks Records
                    </span>

                </div>

                <p class="remarks-table-subtitle">
                    Review monthly remarks and the latest recorded information for each cadet.
                </p>

            </div>

            <div class="remarks-table-meta">

                <i class="fas fa-database"></i>

                <span>
                    {{ $cadets->count() }} Records
                </span>

            </div>

        </div>


        <div class="remarks-table-wrapper">

            <table class="remarks-table">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Full Name</th>

                        <th>Course</th>

                        <th>Batch</th>

                        <th>Remarks</th>

                        <th>Action</th>

                        <th style="display:none;">
                            Month
                        </th>

                        <th style="display:none;">
                            Year
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($cadets as $cadet)

                        <tr>

                            {{-- NUMBER --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- NAME --}}

                            <td>

                                <span class="remarks-cadet-name">
                                    {{ $cadet->full_name ?? '-' }}
                                </span>

                            </td>


                            {{-- COURSE --}}

                            <td>

                                <span class="remarks-course">
                                    {{ $cadet->course ?? '-' }}
                                </span>

                            </td>


                            {{-- BATCH --}}

                            <td>

                                <span class="remarks-batch">
                                    {{ optional($cadet->batch)->batch_year ?? 'No Batch' }}
                                </span>

                            </td>


                            {{-- REMARKS --}}

                            <td>

                                <textarea
                                    class="remarks-textarea"
                                    readonly
                                >{{ $cadet->remarks ?? 'No remarks yet' }}</textarea>

                            </td>


                            {{-- ACTION --}}

                            <td>

                                <button
                                    type="button"
                                    class="remarks-view-btn"

                                    data-id="{{ $cadet->id }}"
                                    data-name="{{ $cadet->full_name }}"
                                    data-month="{{ $cadet->remarks_month }}"
                                    data-year="{{ $cadet->remarks_year }}"
                                    data-remarks="{{ $cadet->remarks }}"
                                    data-date="{{ $cadet->updated_at }}"

                                    onclick="openEditFromButton(this)"
                                >

                                    <i class="fas fa-eye"></i>

                                    View

                                </button>

                            </td>


                            {{-- HIDDEN MONTH --}}

                            <td style="display:none;">
                                {{ $cadet->remarks_month ?? '' }}
                            </td>


                            {{-- HIDDEN YEAR --}}

                            <td style="display:none;">
                                {{ $cadet->remarks_year ?? '' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="remarks-empty"
                            >

                                <div class="remarks-empty-icon">

                                    <i class="fas fa-comment-slash"></i>

                                </div>

                                <strong>
                                    No Monthly Remarks Found
                                </strong>

                                <span>
                                    Try changing your filters or search term.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     VIEW MODAL
========================================================= --}}

<div
    id="editModal"
    class="remarks-modal"
    aria-hidden="true"
>

    <div
        class="remarks-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="remarksModalTitle"
    >

        {{-- MODAL HEADER --}}

        <div class="remarks-modal-header">

            <div class="remarks-modal-header-left">

                <div class="remarks-modal-header-icon">

                    <i class="fas fa-comment-dots"></i>

                </div>

                <div class="remarks-modal-heading">

                    <h3 id="remarksModalTitle">
                        Cadet Remarks Details
                    </h3>

                    <p>
                        Complete monthly remarks information
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="remarks-modal-close"
                onclick="closeModal()"
                aria-label="Close modal"
            >
                &times;
            </button>

        </div>


        {{-- MODAL BODY --}}

        <div class="remarks-modal-body">

            <div class="remarks-details">

                {{-- CADET NAME --}}

                <div class="remarks-detail remarks-detail-full">

                    <span class="remarks-detail-label">

                        <i class="fas fa-user"></i>

                        Cadet Name

                    </span>

                    <span
                        id="cadetName"
                        class="remarks-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- MONTH --}}

                <div class="remarks-detail">

                    <span class="remarks-detail-label">

                        <i class="fas fa-calendar"></i>

                        Month

                    </span>

                    <span
                        id="month"
                        class="remarks-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- YEAR --}}

                <div class="remarks-detail">

                    <span class="remarks-detail-label">

                        <i class="fas fa-calendar-days"></i>

                        Year

                    </span>

                    <span
                        id="year"
                        class="remarks-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- REMARKS --}}

                <div class="remarks-detail remarks-detail-full">

                    <span class="remarks-detail-label">

                        <i class="fas fa-comment"></i>

                        Remarks

                    </span>

                    <span
                        id="remarks"
                        class="remarks-detail-value textarea-value"
                    >
                        —
                    </span>

                </div>


                {{-- LAST UPDATED --}}

                <div class="remarks-detail remarks-detail-full">

                    <span class="remarks-detail-label">

                        <i class="fas fa-clock-rotate-left"></i>

                        Last Updated

                    </span>

                    <span
                        id="dateAdded"
                        class="remarks-detail-value"
                    >
                        —
                    </span>

                </div>

            </div>

        </div>


        {{-- MODAL FOOTER --}}

        <div class="remarks-modal-footer">

            <button
                type="button"
                class="remarks-close-btn"
                onclick="closeModal()"
            >

                <i class="fas fa-xmark"></i>

                Close

            </button>

        </div>

    </div>

</div>


<script>
/* =========================================================
   CADET MONTHLY REMARKS
   FILTER / SEARCH / MODAL
========================================================= */

(function () {

    'use strict';

    const modal = document.getElementById('editModal');

    const searchInput =
        document.getElementById('searchInput');

    const monthFilter =
        document.getElementById('monthFilter');

    const yearFilter =
        document.getElementById('yearFilter');


    /* =====================================================
       SEARCH
    ===================================================== */

    window.searchTable = function () {

        const filter =
            searchInput
                ? searchInput.value.toLowerCase().trim()
                : '';

        const rows =
            document.querySelectorAll(
                '.remarks-table tbody tr'
            );

        rows.forEach(function (row) {

            if (!row.children[1]) {
                return;
            }

            const name =
                row.children[1].innerText.toLowerCase();

            const course =
                row.children[2].innerText.toLowerCase();

            const batch =
                row.children[3].innerText.toLowerCase();

            const match =
                name.includes(filter) ||
                course.includes(filter) ||
                batch.includes(filter);

            row.style.display =
                match ? '' : 'none';

        });

    };


    /* =====================================================
       MONTH / YEAR FILTER
    ===================================================== */

    window.filterTable = function () {

        const month =
            monthFilter
                ? monthFilter.value.toLowerCase().trim()
                : '';

        const year =
            yearFilter
                ? yearFilter.value.toLowerCase().trim()
                : '';

        const rows =
            document.querySelectorAll(
                '.remarks-table tbody tr'
            );

        rows.forEach(function (row) {

            if (!row.children[6] || !row.children[7]) {
                return;
            }

            const rowMonth =
                row.children[6]
                    .innerText
                    .toLowerCase()
                    .trim();

            const rowYear =
                row.children[7]
                    .innerText
                    .toLowerCase()
                    .trim();

            const matchMonth =
                month === '' ||
                rowMonth === month;

            const matchYear =
                year === '' ||
                rowYear === year;

            row.style.display =
                matchMonth && matchYear
                    ? ''
                    : 'none';

        });

    };


    /* =====================================================
       LOAD YEARS
    ===================================================== */

    function loadYears() {

        if (!yearFilter) {
            return;
        }

        const currentYear =
            new Date().getFullYear();

        const startYear = 2020;
        const endYear = currentYear + 20;

        let options =
            '<option value="">All Years</option>';

        for (
            let year = endYear;
            year >= startYear;
            year--
        ) {

            options +=
                `<option value="${year}">${year}</option>`;

        }

        yearFilter.innerHTML = options;

    }


    /* =====================================================
       OPEN MODAL
    ===================================================== */

    window.openEditFromButton = function (btn) {

        if (!modal || !btn) {
            return;
        }

        const name =
            btn.dataset.name || '—';

        const month =
            btn.dataset.month || '—';

        const year =
            btn.dataset.year || '—';

        const remarks =
            btn.dataset.remarks ||
            'No remarks available';

        const dateAdded =
            btn.dataset.date || '—';


        document.getElementById('cadetName').textContent =
            name;

        document.getElementById('month').textContent =
            month;

        document.getElementById('year').textContent =
            year;

        document.getElementById('remarks').textContent =
            remarks;

        document.getElementById('dateAdded').textContent =
            formatDate(dateAdded);


        modal.classList.add('is-open');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';

    };


    /* =====================================================
       CLOSE MODAL
    ===================================================== */

    window.closeModal = function () {

        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';

    };


    /* =====================================================
       BACKDROP CLICK
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

            if (
                event.key === 'Escape' &&
                modal &&
                modal.classList.contains('is-open')
            ) {

                closeModal();

            }

        }
    );


    /* =====================================================
       DATE FORMAT
    ===================================================== */

    function formatDate(date) {

        if (!date) {
            return '—';
        }

        const parsedDate =
            new Date(date);

        if (
            Number.isNaN(
                parsedDate.getTime()
            )
        ) {
            return date;
        }

        return parsedDate.toLocaleDateString(
            'en-US',
            {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            }
        );

    }


    /* =====================================================
       INITIALIZE
    ===================================================== */

    loadYears();

})();
</script>

@endsection