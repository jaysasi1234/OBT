@extends('layouts.superadmin')

@section('header-title', 'Cadet BS Requirements')

@section('content')

<style>
/* =========================================================
   PAGE / THEME
========================================================= */

.bs-page {
    --bs-bg: #0b1a42;
    --bs-bg-deep: #0d1b3e;
    --bs-card: #101f49;
    --bs-card-light: #172955;
    --bs-card-hover: #1b2f63;

    --bs-blue: #3164e6;
    --bs-blue-light: #60a5fa;
    --bs-blue-hover: #4075df;

    --bs-green: #18a957;
    --bs-orange: #f59e0b;
    --bs-purple: #7c5ce6;
    --bs-red: #dc3f4d;

    --bs-border: rgba(96, 165, 250, .18);
    --bs-border-strong: rgba(96, 165, 250, .28);

    --bs-text: #ffffff;
    --bs-text-light: #dbeafe;
    --bs-text-muted: #9fb1d3;
    --bs-text-soft: #8297bd;

    width: 100%;
    min-width: 0;
    min-height: 100vh;
    padding: 20px;
    color: var(--bs-text);
}

.bs-page *,
.bs-page *::before,
.bs-page *::after {
    box-sizing: border-box;
}


/* =========================================================
   PAGE HEADER
========================================================= */

.bs-header {
    position: relative;
    overflow: hidden;

    margin-bottom: 20px;
    padding: 28px 34px;

    border: 1px solid rgba(96, 165, 250, .25);
    border-radius: 20px;

    background:
        linear-gradient(
            135deg,
            #3159c9 0%,
            #294aa8 55%,
            #243f91 100%
        );

    box-shadow: 0 12px 30px rgba(0, 0, 0, .22);
}

.bs-header::before {
    content: "";
    position: absolute;

    width: 210px;
    height: 210px;

    top: -125px;
    right: 80px;

    border-radius: 50%;

    background: rgba(255, 255, 255, .06);
}

.bs-header::after {
    content: "";
    position: absolute;

    width: 160px;
    height: 160px;

    right: -65px;
    bottom: -100px;

    border-radius: 50%;

    background: rgba(255, 255, 255, .05);
}

.bs-header-content {
    position: relative;
    z-index: 2;
}

.bs-header-content h2 {
    display: flex;
    align-items: center;
    gap: 11px;

    margin: 0;

    color: #ffffff;
    font-size: 27px;
    font-weight: 700;
    line-height: 1.2;
}

.bs-header-content h2 i {
    color: #dbeafe;
    font-size: 25px;
}

.bs-header-content p {
    margin: 8px 0 0;

    color: #dbeafe;
    font-size: 15px;
    line-height: 1.5;
}


/* =========================================================
   STATISTICS
========================================================= */

.bs-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 20px;

    margin-bottom: 20px;
}

.bs-stat {
    position: relative;
    overflow: hidden;

    display: flex;
    align-items: center;
    gap: 18px;

    min-width: 0;
    min-height: 145px;

    padding: 25px 28px;

    border: 1px solid rgba(255, 255, 255, .08);
    border-radius: 19px;

    color: #ffffff;

    box-shadow: 0 12px 30px rgba(0, 0, 0, .22);

    transition:
        transform .2s ease,
        box-shadow .2s ease;
}

.bs-stat::after {
    content: "";

    position: absolute;

    width: 115px;
    height: 115px;

    right: -35px;
    bottom: -60px;

    border-radius: 50%;

    background: rgba(255, 255, 255, .06);
}

.bs-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 35px rgba(0, 0, 0, .28);
}


/* STAT COLORS */

.bs-stat-blue {
    background: linear-gradient(
        135deg,
        #3164e6,
        #2852c4
    );
}

.bs-stat-green {
    background: linear-gradient(
        135deg,
        #18a957,
        #0d8f43
    );
}

.bs-stat-orange {
    background: linear-gradient(
        135deg,
        #e69a16,
        #c87905
    );
}

.bs-stat-purple {
    background: linear-gradient(
        135deg,
        #7c5ce6,
        #6241c4
    );
}


/* STAT ICON */

.bs-stat-icon {
    position: relative;
    z-index: 2;

    flex: 0 0 63px;

    width: 63px;
    height: 63px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 16px;

    background: rgba(255, 255, 255, .14);
    border: 1px solid rgba(255, 255, 255, .12);

    color: #ffffff;
    font-size: 24px;

    box-shadow: 0 8px 20px rgba(0, 0, 0, .16);
}

.bs-stat-content {
    position: relative;
    z-index: 2;

    min-width: 0;
}

.bs-stat-label {
    margin: 0;

    color: rgba(255, 255, 255, .82);

    font-size: 13px;
    font-weight: 700;

    line-height: 1.4;
    text-transform: uppercase;
    letter-spacing: .25px;
}

.bs-stat-value {
    margin: 7px 0 0;

    color: #ffffff;

    font-size: 38px;
    font-weight: 800;

    line-height: 1;
}


/* =========================================================
   FILTER CARD
========================================================= */

.bs-filter-card {
    margin-bottom: 20px;
    padding: 25px 28px 28px;

    border: 1px solid var(--bs-border);
    border-radius: 19px;

    background:
        linear-gradient(
            135deg,
            #101f49,
            #0d1b3e
        );

    box-shadow: 0 10px 28px rgba(0, 0, 0, .20);
}

.bs-filter-title {
    display: flex;
    align-items: center;
    gap: 9px;

    margin-bottom: 18px;
}

.bs-filter-title i {
    color: var(--bs-blue-light);
    font-size: 15px;
}

.bs-filter-title h3 {
    margin: 0;

    color: #ffffff;

    font-size: 16px;
    font-weight: 700;
}

.bs-filter-row {
    display: grid;

    grid-template-columns:
        1.35fr
        1fr
        1fr
        auto;

    gap: 15px;
    align-items: end;
}

.bs-filter-group {
    min-width: 0;
}

.bs-filter-group label {
    display: block;

    margin-bottom: 7px;

    color: var(--bs-text-muted);

    font-size: 12px;
    font-weight: 700;
}

.bs-filter-control {
    width: 100%;
    height: 48px;

    padding: 0 14px;

    border: 1px solid rgba(96, 165, 250, .18);
    border-radius: 11px;

    outline: none;

    background: #172955;
    color: #ffffff;

    font-size: 14px;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.bs-filter-control:hover {
    background: #1a2e5d;
    border-color: rgba(96, 165, 250, .28);
}

.bs-filter-control:focus {
    background: #172955;
    border-color: var(--bs-blue-light);

    box-shadow:
        0 0 0 3px rgba(96, 165, 250, .12);
}

.bs-filter-control::placeholder {
    color: #7185ab;
}

.bs-filter-control option {
    background: #172955;
    color: #ffffff;
}

.bs-filter-actions {
    display: flex;
    gap: 8px;
}


/* =========================================================
   BUTTONS
========================================================= */

.bs-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 48px;

    padding: 0 17px;

    border-radius: 10px;

    font-size: 13px;
    font-weight: 700;

    text-decoration: none;

    cursor: pointer;

    transition:
        background .2s ease,
        border-color .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.bs-btn-reset {
    background: #172955;
    border: 1px solid rgba(96, 165, 250, .18);

    color: #dbeafe;
}

.bs-btn-reset:hover {
    background: #223765;
    border-color: rgba(96, 165, 250, .35);

    color: #ffffff;

    transform: translateY(-1px);
}


/* =========================================================
   TABLE CARD
========================================================= */

.bs-table-card {
    width: 100%;
    overflow: hidden;

    border: 1px solid var(--bs-border);
    border-radius: 20px;

    background:
        linear-gradient(
            135deg,
            #101f49,
            #0d1b3e
        );

    box-shadow: 0 12px 30px rgba(0, 0, 0, .22);
}


/* =========================================================
   TABLE HEADER
========================================================= */

.bs-table-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    padding: 26px 28px 23px;

    border-bottom: 1px solid rgba(96, 165, 250, .14);
}

.bs-table-card-title {
    min-width: 0;
}

.bs-table-card-title h3 {
    display: flex;
    align-items: center;
    gap: 9px;

    margin: 0;

    color: #ffffff;

    font-size: 19px;
    font-weight: 700;
}

.bs-table-card-title h3 i {
    color: var(--bs-blue-light);
}

.bs-table-card-title p {
    margin: 6px 0 0;

    color: var(--bs-text-soft);

    font-size: 13px;
}

.bs-scroll-hint {
    flex: 0 0 auto;

    color: #8297bd;

    font-size: 12px;
    font-weight: 600;
}


/* =========================================================
   TABLE WRAPPER
========================================================= */

.bs-table-wrapper {
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
}

.bs-table-wrapper::-webkit-scrollbar,
.bs-modal-body::-webkit-scrollbar,
.bs-modal-table-wrapper::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.bs-table-wrapper::-webkit-scrollbar-track,
.bs-modal-body::-webkit-scrollbar-track,
.bs-modal-table-wrapper::-webkit-scrollbar-track {
    background: #0a1735;
}

.bs-table-wrapper::-webkit-scrollbar-thumb,
.bs-modal-body::-webkit-scrollbar-thumb,
.bs-modal-table-wrapper::-webkit-scrollbar-thumb {
    background: #31528f;
    border-radius: 999px;
}

.bs-table-wrapper::-webkit-scrollbar-thumb:hover,
.bs-modal-body::-webkit-scrollbar-thumb:hover,
.bs-modal-table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #4268ad;
}


/* =========================================================
   MAIN TABLE
========================================================= */

.bs-table {
    width: 100%;
    min-width: 1000px;

    border-collapse: collapse;
}

.bs-table thead {
    background:
        linear-gradient(
            135deg,
            #315fe0,
            #294fc2
        );
}

.bs-table th {
    padding: 15px 18px;

    border-bottom: 1px solid rgba(255, 255, 255, .08);

    color: #ffffff;

    font-size: 12px;
    font-weight: 800;

    letter-spacing: .45px;

    text-align: center;
    text-transform: uppercase;

    white-space: nowrap;
}

.bs-table th i {
    margin-right: 5px;

    color: #dbeafe;
}

.bs-table td {
    padding: 17px 18px;

    border-bottom: 1px solid rgba(96, 165, 250, .10);

    color: #dbeafe;

    font-size: 14px;

    text-align: center;
    vertical-align: middle;
}

.bs-table td strong {
    color: #ffffff;
    font-weight: 700;
}

.bs-table tbody tr {
    background: #1b2d62;

    transition:
        background .2s ease,
        box-shadow .2s ease;
}

.bs-table tbody tr:hover {
    background: #20366f;
}

.bs-table tbody tr:last-child td {
    border-bottom: 0;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.bs-empty {
    padding: 55px 20px !important;

    background: #1b2d62 !important;

    color: var(--bs-text-muted) !important;

    text-align: center !important;
}

.bs-empty i {
    display: block;

    margin-bottom: 12px;

    color: #6f86b7;

    font-size: 36px;
}

.bs-empty strong {
    display: block;

    margin-bottom: 5px;

    color: #ffffff;

    font-size: 15px;
}

.bs-empty span {
    color: var(--bs-text-soft);
    font-size: 13px;
}


/* =========================================================
   PROGRESS
========================================================= */

.bs-progress {
    width: 190px;
    margin: 0 auto;
}

.bs-progress-track {
    width: 100%;
    height: 9px;

    overflow: hidden;

    background: #0c1938;

    border: 1px solid rgba(96, 165, 250, .14);
    border-radius: 999px;
}

.bs-progress-fill {
    height: 100%;

    background:
        linear-gradient(
            90deg,
            #3e76e8,
            #6ea3ff
        );

    border-radius: 999px;

    box-shadow:
        0 0 8px rgba(79, 140, 255, .35);

    transition: width .3s ease;
}

.bs-progress-text {
    display: block;

    margin-top: 7px;

    color: #9fb1d3;

    font-size: 11px;
    font-weight: 700;
}


/* =========================================================
   BADGES
========================================================= */

.bs-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;

    padding: 7px 11px;

    border: 1px solid transparent;
    border-radius: 999px;

    font-size: 11px;
    font-weight: 800;

    line-height: 1;

    white-space: nowrap;
}

.bs-badge-approved {
    background: rgba(34, 197, 94, .13);
    border-color: rgba(34, 197, 94, .25);
    color: #6ee7a0;
}

.bs-badge-pending {
    background: rgba(245, 158, 11, .13);
    border-color: rgba(245, 158, 11, .25);
    color: #fcd36d;
}

.bs-badge-rejected {
    background: rgba(239, 68, 68, .13);
    border-color: rgba(239, 68, 68, .25);
    color: #ff8f8f;
}

.bs-badge-info {
    background: rgba(79, 140, 255, .13);
    border-color: rgba(79, 140, 255, .28);
    color: #9fc1ff;
}

.bs-badge-legacy {
    background: rgba(34, 197, 94, .13);
    border-color: rgba(34, 197, 94, .25);
    color: #6ee7a0;
}


/* =========================================================
   VIEW BUTTON
========================================================= */

.bs-view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-width: 72px;
    min-height: 38px;

    padding: 0 14px;

    border: 1px solid rgba(96, 165, 250, .25);
    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #3164e6,
            #2852c4
        );

    color: #ffffff;

    font-size: 13px;
    font-weight: 700;

    cursor: pointer;

    transition:
        background .2s ease,
        transform .2s ease,
        box-shadow .2s ease;
}

.bs-view-btn:hover {
    background:
        linear-gradient(
            135deg,
            #4075df,
            #315fc2
        );

    color: #ffffff;

    transform: translateY(-1px);

    box-shadow:
        0 6px 16px rgba(49, 95, 194, .30);
}


/* =========================================================
   HIDDEN MODAL DATA
========================================================= */

.bs-hidden-data {
    display: none;
}


/* =========================================================
   MODAL BACKDROP
========================================================= */

.bs-modal {
    position: fixed;
    inset: 0;

    z-index: 9999;

    display: none;
    align-items: center;
    justify-content: center;

    padding: 20px;

    background: rgba(3, 10, 28, .82);

    backdrop-filter: blur(6px);
}

.bs-modal.is-open {
    display: flex;
}


/* =========================================================
   MODAL CONTENT
========================================================= */

.bs-modal-content {
    width: min(1150px, 100%);
    max-height: 90vh;

    overflow: hidden;

    border: 1px solid rgba(96, 165, 250, .20);
    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #101f49,
            #0d1b3e
        );

    box-shadow:
        0 25px 70px rgba(0, 0, 0, .55);

    animation: bsModalIn .2s ease;
}

@keyframes bsModalIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}


/* =========================================================
   MODAL HEADER
========================================================= */

.bs-modal-header {
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

    border-bottom: 1px solid rgba(255, 255, 255, .08);

    color: #ffffff;
}

.bs-modal-title {
    min-width: 0;
}

.bs-modal-title h3 {
    overflow: hidden;

    display: flex;
    align-items: center;
    gap: 9px;

    margin: 0;

    color: #ffffff;

    font-size: 20px;
    font-weight: 800;

    text-overflow: ellipsis;
    white-space: nowrap;
}

.bs-modal-title h3 i {
    color: #dbeafe;
}

.bs-modal-close {
    flex: 0 0 auto;

    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 9px;

    background: rgba(255, 255, 255, .08);

    color: #ffffff;

    font-size: 24px;

    cursor: pointer;

    transition:
        background .2s ease,
        border-color .2s ease,
        transform .2s ease;
}

.bs-modal-close:hover {
    background: #dc2626;
    border-color: #ef4444;
    transform: rotate(2deg);
}


/* =========================================================
   MODAL BODY
========================================================= */

.bs-modal-body {
    max-height: calc(90vh - 75px);

    overflow: auto;

    padding: 24px;

    background:
        linear-gradient(
            135deg,
            #101f49,
            #0d1b3e
        );
}


/* =========================================================
   MODAL SUMMARY
========================================================= */

.bs-summary {
    width: 100%;
}

.bs-summary-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 20px;
    padding-bottom: 16px;

    border-bottom: 1px solid rgba(96, 165, 250, .14);
}

.bs-summary-name {
    min-width: 0;
}

.bs-summary-name h4 {
    overflow: hidden;

    margin: 0 0 5px;

    color: #ffffff;

    font-size: 21px;
    font-weight: 800;

    text-overflow: ellipsis;
    white-space: nowrap;
}

.bs-summary-name small {
    color: var(--bs-text-muted);

    font-size: 13px;
    font-weight: 600;
}


/* =========================================================
   ATTACHMENT
========================================================= */

.bs-attachment {
    display: flex;
    align-items: center;
    gap: 10px;

    min-width: 270px;

    padding: 9px 11px;

    background: #172955;

    border: 1px solid rgba(96, 165, 250, .15);
    border-radius: 10px;
}

.bs-attachment-icon {
    flex: 0 0 40px;

    width: 40px;
    height: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: rgba(239, 68, 68, .14);
    border: 1px solid rgba(239, 68, 68, .20);

    color: #ff8f8f;

    font-size: 18px;
}

.bs-attachment-info {
    min-width: 0;
    flex: 1;

    text-align: left;
}

.bs-attachment-name {
    display: block;

    overflow: hidden;

    color: #ffffff;

    font-size: 13px;
    font-weight: 700;

    text-overflow: ellipsis;
    white-space: nowrap;
}

.bs-attachment-info small {
    color: var(--bs-text-soft);
    font-size: 11px;
}

.bs-attachment-actions {
    display: flex;
    gap: 6px;
}

.bs-file-btn {
    width: 35px;
    height: 35px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    color: #ffffff;
    text-decoration: none;

    transition:
        transform .2s ease,
        background .2s ease;
}

.bs-file-btn:hover {
    color: #ffffff;
    transform: translateY(-1px);
}

.bs-file-view {
    background: #315fc2;
}

.bs-file-view:hover {
    background: #4075df;
}

.bs-file-download {
    background: #15803d;
}

.bs-file-download:hover {
    background: #16a34a;
}

.bs-no-file {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    color: var(--bs-text-soft);

    font-size: 13px;
    font-weight: 700;
}


/* =========================================================
   MODAL TABLE
========================================================= */

.bs-modal-table-wrapper {
    width: 100%;

    overflow-x: auto;

    border: 1px solid rgba(96, 165, 250, .16);
    border-radius: 12px;

    background: #1b2d62;
}

.bs-modal-table {
    width: 100%;
    min-width: 900px;

    border-collapse: collapse;
}

.bs-modal-table th {
    padding: 13px 12px;

    background:
        linear-gradient(
            135deg,
            #315fe0,
            #294fc2
        );

    border-bottom: 1px solid rgba(255, 255, 255, .08);

    color: #ffffff;

    font-size: 11px;
    font-weight: 800;

    text-align: center;
    text-transform: uppercase;

    white-space: nowrap;
}

.bs-modal-table td {
    padding: 14px 12px;

    border-bottom: 1px solid rgba(96, 165, 250, .10);

    color: var(--bs-text-light);

    font-size: 13px;

    text-align: center;
    vertical-align: middle;
}

.bs-modal-table td strong {
    color: #ffffff;
    font-weight: 700;
}

.bs-modal-table tbody tr {
    background: #1b2d62;

    transition: background .2s ease;
}

.bs-modal-table tbody tr:hover {
    background: #20366f;
}

.bs-modal-table tbody tr:last-child td {
    border-bottom: 0;
}

.bs-remarks {
    max-width: 220px;

    margin: 0 auto;

    overflow-wrap: anywhere;

    color: var(--bs-text-muted);

    line-height: 1.45;
}


/* =========================================================
   MODAL EMPTY
========================================================= */

.bs-modal-empty {
    padding: 45px 20px !important;

    background: #1b2d62 !important;

    color: var(--bs-text-muted) !important;

    text-align: center !important;
}

.bs-modal-empty i {
    display: block;

    margin-bottom: 10px;

    color: #6f86b7;

    font-size: 32px;
}

.bs-modal-empty div {
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
}

.bs-legacy {
    display: inline-flex;
    align-items: center;
    gap: 6px;

    margin-top: 10px;
    padding: 7px 11px;

    border-radius: 999px;

    background: rgba(34, 197, 94, .13);
    border: 1px solid rgba(34, 197, 94, .25);

    color: #6ee7a0;

    font-size: 11px;
    font-weight: 800;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1400px) {

    .bs-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .bs-filter-row {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .bs-filter-actions {
        grid-column: 1 / -1;
    }
}


@media (max-width: 992px) {

    .bs-page {
        padding: 18px;
    }

    .bs-header {
        padding: 25px 28px;
    }

    .bs-stat {
        min-height: 135px;
    }

    .bs-table-card-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 10px;
    }

    .bs-scroll-hint {
        width: 100%;
    }
}


@media (max-width: 768px) {

    .bs-page {
        padding: 15px;
    }

    .bs-header {
        padding: 22px;
        border-radius: 17px;
    }

    .bs-header-content h2 {
        font-size: 23px;
    }

    .bs-header-content p {
        font-size: 13px;
    }

    .bs-stats {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .bs-stat {
        min-height: 115px;
        padding: 20px;
    }

    .bs-stat-value {
        font-size: 32px;
    }

    .bs-filter-card {
        padding: 20px;
    }

    .bs-filter-row {
        grid-template-columns: 1fr;
    }

    .bs-filter-actions {
        grid-column: auto;
        width: 100%;
    }

    .bs-filter-actions .bs-btn {
        width: 100%;
    }

    .bs-table-card {
        border-radius: 17px;
    }

    .bs-table-card-header {
        padding: 22px 20px;
    }

    .bs-table-card-title h3 {
        font-size: 17px;
    }

    .bs-table-card-title p {
        font-size: 12px;
    }

    .bs-modal {
        padding: 10px;
    }

    .bs-modal-content {
        max-height: 95vh;
        border-radius: 15px;
    }

    .bs-modal-header {
        padding: 15px 17px;
    }

    .bs-modal-title h3 {
        font-size: 17px;
    }

    .bs-modal-body {
        max-height: calc(95vh - 68px);
        padding: 15px;
    }

    .bs-summary-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 12px;
    }

    .bs-summary-name h4 {
        font-size: 18px;
        white-space: normal;
    }

    .bs-attachment {
        width: 100%;
        min-width: 0;
    }

    .bs-progress {
        width: 160px;
    }
}


@media (max-width: 480px) {

    .bs-page {
        padding: 12px;
    }

    .bs-header {
        padding: 20px 18px;
    }

    .bs-header-content h2 {
        font-size: 20px;
    }

    .bs-header-content h2 i {
        font-size: 19px;
    }

    .bs-header-content p {
        font-size: 12px;
    }

    .bs-stat {
        min-height: 105px;
        padding: 17px;
    }

    .bs-stat-icon {
        flex-basis: 52px;

        width: 52px;
        height: 52px;

        font-size: 20px;
    }

    .bs-stat-label {
        font-size: 11px;
    }

    .bs-stat-value {
        font-size: 28px;
    }

    .bs-filter-card {
        padding: 17px;
    }

    .bs-table-card-header {
        padding: 20px 17px;
    }

    .bs-table th,
    .bs-table td {
        padding: 13px 11px;
    }

    .bs-modal-body {
        padding: 12px;
    }

    .bs-attachment {
        padding: 8px;
    }

    .bs-attachment-icon {
        flex-basis: 36px;

        width: 36px;
        height: 36px;
    }
}
</style>


<div class="bs-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="bs-header">

        <div class="bs-header-content">

            <h2>
                <i class="fa-solid fa-graduation-cap"></i>

                Cadet BS Requirements
            </h2>

            <p>
                View BS completion requirements submitted by completed cadets.
            </p>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    @php

        $totalCadets = $cadets->count();

        $submittedRequirements = $cadets->sum(
            fn ($cadet) => $cadet->bsRequirements->count()
        );

        $pendingCadets = $cadets->filter(
            fn ($cadet) =>
                $cadet->bsRequirements->count() < $totalRequirements
        )->count();

        $completedCadets = $cadets->filter(
            fn ($cadet) =>
                $cadet->bsRequirements->count() >= $totalRequirements
        )->count();

    @endphp


    <div class="bs-stats">

        {{-- TOTAL CADETS --}}

        <div class="bs-stat bs-stat-blue">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Total Cadets
                </p>

                <h3 class="bs-stat-value">
                    {{ $totalCadets }}
                </h3>

            </div>

        </div>


        {{-- SUBMITTED --}}

        <div class="bs-stat bs-stat-green">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Requirements Submitted
                </p>

                <h3 class="bs-stat-value">
                    {{ $submittedRequirements }}
                </h3>

            </div>

        </div>


        {{-- PENDING --}}

        <div class="bs-stat bs-stat-orange">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Pending Cadets
                </p>

                <h3 class="bs-stat-value">
                    {{ $pendingCadets }}
                </h3>

            </div>

        </div>


        {{-- COMPLETED --}}

        <div class="bs-stat bs-stat-purple">

            <div class="bs-stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="bs-stat-content">

                <p class="bs-stat-label">
                    Completed
                </p>

                <h3 class="bs-stat-value">
                    {{ $completedCadets }}
                </h3>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER CARD
    ====================================================== --}}

    <div class="bs-filter-card">

        <div class="bs-filter-title">

            <i class="fa-solid fa-filter"></i>

            <h3>
                Filter Cadets
            </h3>

        </div>


        <form
            method="GET"
            action="{{ route('superadmin.cadet-bs-requirements.index') }}"
            id="filterForm"
        >

            <div class="bs-filter-row">

                {{-- SEARCH --}}

                <div class="bs-filter-group">

                    <label for="bs-search">
                        Search Cadet
                    </label>

                    <input
                        id="bs-search"
                        type="text"
                        name="search"
                        class="bs-filter-control"
                        placeholder="Search name or TRB number..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >

                </div>


                {{-- COURSE --}}

                <div class="bs-filter-group">

                    <label for="bs-course">
                        Course
                    </label>

                    <select
                        id="bs-course"
                        name="course"
                        class="bs-filter-control"
                    >

                        <option value="">
                            All Courses
                        </option>

                        @foreach($courses as $course)

                            <option
                                value="{{ $course }}"
                                @selected(request('course') == $course)
                            >
                                {{ $course }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BATCH --}}

                <div class="bs-filter-group">

                    <label for="bs-batch">
                        Batch
                    </label>

                    <select
                        id="bs-batch"
                        name="batch"
                        class="bs-filter-control"
                    >

                        <option value="">
                            All Batches
                        </option>

                        @foreach($batches as $batch)

                            <option
                                value="{{ $batch->id }}"
                                @selected(request('batch') == $batch->id)
                            >
                                {{ $batch->batch_year }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- RESET --}}

                <div class="bs-filter-actions">

                    <a
                        href="{{ route('superadmin.cadet-bs-requirements.index') }}"
                        class="bs-btn bs-btn-reset"
                    >
                        <i class="fa-solid fa-rotate-right"></i>

                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
         MAIN TABLE
    ====================================================== --}}

    <div class="bs-table-card">

        {{-- TABLE HEADER --}}

        <div class="bs-table-card-header">

            <div class="bs-table-card-title">

                <h3>
                    <i class="fa-solid fa-graduation-cap"></i>

                    Cadet BS Requirement Records
                </h3>

                <p>
                    Review BS completion requirements and submission status.
                </p>

            </div>

            <div class="bs-scroll-hint">
                ↔ Scroll horizontally to view all columns
            </div>

        </div>


        {{-- TABLE --}}

        <div class="bs-table-wrapper">

            <table class="bs-table">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

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
                            <i class="fa-solid fa-chart-line"></i>
                            Progress
                        </th>

                        <th>
                            <i class="fa-solid fa-eye"></i>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($cadets as $cadet)

                        @php

                            $submitted =
                                $cadet->bsRequirements->count();

                            $percentage =
                                $totalRequirements > 0
                                    ? min(
                                        100,
                                        round(
                                            ($submitted / $totalRequirements) * 100
                                        )
                                    )
                                    : 0;

                        @endphp


                        <tr>

                            {{-- NUMBER --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- TRB --}}

                            <td>

                                <strong>
                                    {{ $cadet->trb_control_number }}
                                </strong>

                            </td>


                            {{-- NAME --}}

                            <td>
                                {{ $cadet->full_name }}
                            </td>


                            {{-- COURSE --}}

                            <td>
                                {{ $cadet->course ?: '—' }}
                            </td>


                            {{-- BATCH --}}

                            <td>
                                {{ optional($cadet->batch)->batch_year ?? 'No Batch' }}
                            </td>


                            {{-- PROGRESS --}}

                            <td>

                                <div class="bs-progress">

                                    <div class="bs-progress-track">

                                        <div
                                            class="bs-progress-fill"
                                            style="width: {{ $percentage }}%;"
                                        ></div>

                                    </div>

                                    <span class="bs-progress-text">

                                        {{ $submitted }}
                                        /
                                        {{ $totalRequirements }}
                                        Requirements

                                        ({{ $percentage }}%)

                                    </span>

                                </div>

                            </td>


                            {{-- ACTION --}}

                            <td>

                                <button
                                    type="button"
                                    class="bs-view-btn"
                                    onclick="openBsModal(
                                        {{ $cadet->id }},
                                        @js($cadet->full_name)
                                    )"
                                >

                                    <i class="fa-solid fa-eye"></i>

                                    View

                                </button>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="bs-empty"
                            >

                                <i class="fa-solid fa-folder-open"></i>

                                <strong>
                                    No completed cadets found.
                                </strong>

                                <span>
                                    Try changing your search or filters.
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
     HIDDEN CADET REQUIREMENT DATA
========================================================= --}}

@foreach($cadets as $cadet)

    <div
        id="bs-cadet-{{ $cadet->id }}"
        class="bs-hidden-data"
    >

        <div class="bs-summary">

            {{-- SUMMARY HEADER --}}

            <div class="bs-summary-header">

                <div class="bs-summary-name">

                    <h4>
                        {{ $cadet->full_name }}
                    </h4>

                    <small>
                        TRB:
                        {{ $cadet->trb_control_number }}
                    </small>

                </div>


                <span class="bs-badge bs-badge-info">

                    <i class="fa-solid fa-file-circle-check"></i>

                    {{ $cadet->bsRequirements->count() }}
                    /
                    {{ $totalRequirements }}
                    Submitted

                </span>

            </div>


            {{-- REQUIREMENT TABLE --}}

            <div class="bs-modal-table-wrapper">

                <table class="bs-modal-table">

                    <thead>

                        <tr>

                            <th>
                                Requirement
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Attachment
                            </th>

                            <th>
                                Remarks
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Access
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($cadet->bsRequirements as $submission)

                            @php

                                $status = strtolower(
                                    trim((string) $submission->status)
                                );

                            @endphp


                            <tr>

                                {{-- REQUIREMENT --}}

                                <td>

                                    <strong>
                                        {{ $submission->requirement->title ?? 'Unknown Requirement' }}
                                    </strong>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @switch($status)

                                        @case('approved')

                                            <span class="bs-badge bs-badge-approved">

                                                <i class="fa-solid fa-circle-check"></i>

                                                Approved

                                            </span>

                                            @break


                                        @case('rejected')

                                            <span class="bs-badge bs-badge-rejected">

                                                <i class="fa-solid fa-circle-xmark"></i>

                                                Rejected

                                            </span>

                                            @break


                                        @case('pending')

                                            <span class="bs-badge bs-badge-pending">

                                                <i class="fa-solid fa-clock"></i>

                                                Pending

                                            </span>

                                            @break


                                        @default

                                            <span class="bs-badge bs-badge-info">

                                                <i class="fa-solid fa-circle-question"></i>

                                                {{ $submission->status ?: 'Unknown' }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- ATTACHMENT --}}

                                <td>

                                    @if($submission->attachment)

                                        @php

                                            $fileUrl = asset(
                                                'storage/' . $submission->attachment
                                            );

                                        @endphp


                                        <div class="bs-attachment">

                                            <div class="bs-attachment-icon">

                                                <i class="fa-solid fa-file-pdf"></i>

                                            </div>


                                            <div class="bs-attachment-info">

                                                <span class="bs-attachment-name">
                                                    Uploaded Document
                                                </span>

                                                <small>
                                                    Available for viewing
                                                </small>

                                            </div>


                                            <div class="bs-attachment-actions">

                                                <a
                                                    href="{{ $fileUrl }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="bs-file-btn bs-file-view"
                                                    title="View document"
                                                >

                                                    <i class="fa-solid fa-eye"></i>

                                                </a>


                                                <a
                                                    href="{{ $fileUrl }}"
                                                    download
                                                    class="bs-file-btn bs-file-download"
                                                    title="Download document"
                                                >

                                                    <i class="fa-solid fa-download"></i>

                                                </a>

                                            </div>

                                        </div>

                                    @else

                                        <span class="bs-no-file">

                                            <i class="fa-regular fa-file-circle-xmark"></i>

                                            No Attachment

                                        </span>

                                    @endif

                                </td>


                                {{-- REMARKS --}}

                                <td>

                                    <div class="bs-remarks">

                                        {{ $submission->remarks ?: '—' }}

                                    </div>

                                </td>


                                {{-- DATE --}}

                                <td>

                                    @if($submission->submitted_at)

                                        {{ \Carbon\Carbon::parse(
                                            $submission->submitted_at
                                        )->format('M d, Y') }}

                                    @else

                                        —

                                    @endif

                                </td>


                                {{-- ACCESS --}}

                                <td>

                                    <span class="bs-badge bs-badge-info">

                                        <i class="fa-solid fa-eye"></i>

                                        View Only

                                    </span>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="bs-modal-empty"
                                >

                                    <i class="fa-regular fa-folder-open"></i>

                                    <div>
                                        No requirement submitted yet.
                                    </div>


                                    @if($cadet->bs_status === 'Legacy Qualified')

                                        <span class="bs-legacy">

                                            <i class="fa-solid fa-circle-check"></i>

                                            BS Qualified (Legacy)

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endforeach


{{-- =========================================================
     BS REQUIREMENT MODAL
========================================================= --}}

<div
    id="bsModal"
    class="bs-modal"
    aria-hidden="true"
>

    <div
        class="bs-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="bsModalTitle"
    >

        <div class="bs-modal-header">

            <div class="bs-modal-title">

                <h3 id="bsModalTitle">

                    <i class="fa-solid fa-graduation-cap"></i>

                    Cadet Requirements

                </h3>

            </div>


            <button
                type="button"
                class="bs-modal-close"
                onclick="closeBsModal()"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        <div
            id="bsModalBody"
            class="bs-modal-body"
        ></div>

    </div>

</div>


<script>
/* =========================================================
   BS REQUIREMENTS MODAL
========================================================= */

(function () {

    'use strict';

    const modal =
        document.getElementById('bsModal');

    const modalBody =
        document.getElementById('bsModalBody');

    const modalTitle =
        document.getElementById('bsModalTitle');


    /*
     * Open modal.
     */

    window.openBsModal = function (id, name) {

        const source =
            document.getElementById(
                'bs-cadet-' + id
            );


        if (!source) {

            console.error(
                'BS requirement data not found for cadet:',
                id
            );

            return;
        }


        modalTitle.innerHTML = `
            <i class="fa-solid fa-graduation-cap"></i>
            ${escapeHtml(name || 'Cadet Requirements')}
        `;


        modalBody.innerHTML =
            source.innerHTML;


        modal.classList.add('is-open');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.style.overflow = 'hidden';
    };


    /*
     * Close modal.
     */

    window.closeBsModal = function () {

        modal.classList.remove('is-open');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );


        modalBody.innerHTML = '';

        document.body.style.overflow = '';
    };


    /*
     * Close when clicking backdrop.
     */

    modal.addEventListener(
        'click',
        function (event) {

            if (event.target === modal) {

                closeBsModal();

            }

        }
    );


    /*
     * Close with ESC.
     */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal.classList.contains('is-open')
            ) {

                closeBsModal();

            }

        }
    );


    /*
     * Prevent HTML injection in modal title.
     */

    function escapeHtml(value) {

        const div =
            document.createElement('div');

        div.textContent = value;

        return div.innerHTML;
    }

})();


/* =========================================================
   AUTO FILTER
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'filterForm'
            );


        if (!form) {
            return;
        }


        const searchInput =
            form.querySelector(
                'input[name="search"]'
            );


        const selects =
            form.querySelectorAll(
                'select[name="course"], select[name="batch"]'
            );


        let searchTimer = null;


        /*
         * Search after user stops typing.
         */

        if (searchInput) {

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


        /*
         * Submit immediately when
         * course or batch changes.
         */

        selects.forEach(
            function (select) {

                select.addEventListener(
                    'change',
                    function () {

                        form.submit();

                    }
                );

            }
        );

    }
);
</script>

@endsection