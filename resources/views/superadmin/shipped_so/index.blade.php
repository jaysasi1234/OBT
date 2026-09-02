@extends('layouts.superadmin')

@section('header-title', 'Special Order')

@section('content')

<style>
/* =========================================================
   SPECIAL ORDER PAGE
   MODERN NAVY / BLUE GRADIENT THEME
========================================================= */

.shipped-page {
    --so-bg: #07152f;
    --so-bg-deep: #091936;
    --so-card: #101f49;
    --so-card-light: #142755;
    --so-card-hover: #172d60;

    --so-border: rgba(96, 165, 250, 0.20);
    --so-border-soft: rgba(96, 165, 250, 0.12);

    --so-blue: #4f8cff;
    --so-blue-light: #78a9ff;

    --so-text: #ffffff;
    --so-text-light: #dbe7ff;
    --so-text-muted: #9fb0d1;
    --so-text-soft: #7f91b7;

    width: 100%;
    min-height: 100vh;
    padding: 28px;
    background: var(--so-bg);
    color: var(--so-text);
}

.shipped-page *,
.shipped-page *::before,
.shipped-page *::after {
    box-sizing: border-box;
}

/* =========================================================
   PAGE HEADER
========================================================= */

.shipped-header {
    position: relative;
    display: flex;
    align-items: center;
    gap: 18px;
    margin-bottom: 24px;
    padding: 28px 34px;
    overflow: hidden;

    background: linear-gradient(
        135deg,
        #2458c9 0%,
        #244db4 45%,
        #1e3f99 100%
    );

    border: 1px solid rgba(96, 165, 250, 0.28);
    border-radius: 20px;

    box-shadow:
        0 12px 35px rgba(0, 0, 0, 0.25);
}

.shipped-header::before,
.shipped-header::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.shipped-header::before {
    width: 190px;
    height: 190px;
    top: -105px;
    right: 70px;
    background: rgba(255, 255, 255, 0.06);
}

.shipped-header::after {
    width: 130px;
    height: 130px;
    right: -40px;
    bottom: -75px;
    background: rgba(255, 255, 255, 0.07);
}

.shipped-header-icon {
    position: relative;
    z-index: 1;

    width: 56px;
    height: 56px;
    flex: 0 0 56px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 15px;

    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;

    font-size: 23px;

    box-shadow:
        0 8px 18px rgba(0, 0, 0, 0.18);
}

.shipped-header-content {
    position: relative;
    z-index: 1;
    min-width: 0;
}

.shipped-header h2 {
    margin: 0;

    color: #ffffff;
    font-size: 27px;
    font-weight: 700;
    line-height: 1.2;
}

.shipped-header p {
    margin: 7px 0 0;

    color: #dbeafe;
    font-size: 13px;
    font-weight: 500;
    line-height: 1.5;
}

/* =========================================================
   STATISTICS
========================================================= */

.shipped-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.shipped-stat {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    min-width: 0;
    min-height: 122px;

    padding: 22px;

    overflow: hidden;

    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 18px;

    box-shadow:
        0 9px 28px rgba(0, 0, 0, 0.22);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        border-color 0.2s ease;
}

.shipped-stat::before {
    content: "";

    position: absolute;

    width: 125px;
    height: 125px;

    right: -45px;
    bottom: -70px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.08);

    pointer-events: none;
}

.shipped-stat::after {
    content: "";

    position: absolute;

    width: 65px;
    height: 65px;

    left: -35px;
    top: -35px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.04);

    pointer-events: none;
}

.shipped-stat:hover {
    transform: translateY(-3px);

    border-color: rgba(147, 197, 253, 0.30);

    box-shadow:
        0 15px 35px rgba(0, 0, 0, 0.28);
}

.shipped-stat-content {
    position: relative;
    z-index: 2;
    min-width: 0;
}

.shipped-stat-value {
    margin: 0;

    color: #ffffff;
    font-size: 30px;
    font-weight: 800;
    line-height: 1;
}

.shipped-stat-label {
    margin: 8px 0 0;

    color: rgba(255, 255, 255, 0.75);

    font-size: 12px;
    font-weight: 700;
    line-height: 1.4;
}

.shipped-stat-icon {
    position: relative;
    z-index: 2;

    width: 57px;
    height: 57px;
    flex: 0 0 57px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    color: #ffffff;
    font-size: 22px;

    box-shadow:
        0 8px 18px rgba(0, 0, 0, 0.20);
}

/* TOTAL */

.shipped-stat-blue {
    background: linear-gradient(
        135deg,
        #3164e6,
        #2852c4
    );
}

.shipped-stat-blue .shipped-stat-icon {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

/* PENDING */

.shipped-stat-gray {
    background: linear-gradient(
        135deg,
        #34466f,
        #283858
    );
}

.shipped-stat-gray .shipped-stat-icon {
    background: rgba(255, 255, 255, 0.13);
    border: 1px solid rgba(255, 255, 255, 0.14);
}

/* ENDORSEMENT */

.shipped-stat-orange {
    background: linear-gradient(
        135deg,
        #e08a12,
        #b86608
    );
}

.shipped-stat-orange .shipped-stat-icon {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

/* COMPLETED */

.shipped-stat-green {
    background: linear-gradient(
        135deg,
        #18a957,
        #0d8f43
    );
}

.shipped-stat-green .shipped-stat-icon {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

/* =========================================================
   FILTER CARD
========================================================= */

.shipped-filter-card {
    margin-bottom: 24px;
    padding: 24px 25px;

    background: linear-gradient(
        135deg,
        #101f49,
        #0d1b3e
    );

    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 19px;

    box-shadow:
        0 9px 28px rgba(0, 0, 0, 0.22);
}

.shipped-filter-header {
    display: flex;
    align-items: center;
    gap: 9px;

    margin-bottom: 17px;

    color: #ffffff;

    font-size: 15px;
    font-weight: 800;
}

.shipped-filter-header i {
    color: #72a7ff;
    font-size: 14px;
}

.shipped-filter-grid {
    display: grid;

    grid-template-columns:
        minmax(180px, 1fr)
        minmax(180px, 1fr)
        minmax(240px, 1.5fr);

    gap: 14px;
}

/* =========================================================
   FILTER CONTROLS
========================================================= */

.shipped-filter-control {
    width: 100%;
    height: 48px;

    padding: 0 14px;

    border: 1px solid rgba(96, 165, 250, 0.16);
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

.shipped-filter-control:hover {
    background: #1a2f60;
    border-color: rgba(96, 165, 250, 0.30);
}

.shipped-filter-control:focus {
    background: #1a2f60;
    border-color: #5c96ff;

    box-shadow:
        0 0 0 3px rgba(79, 140, 255, 0.15);
}

.shipped-filter-control::placeholder {
    color: #7d90b8;
    font-weight: 500;
}

.shipped-filter-control option {
    background: #101f49;
    color: #ffffff;
}

/* =========================================================
   SEARCH
========================================================= */

.shipped-search {
    position: relative;
}

.shipped-search i {
    position: absolute;

    top: 50%;
    left: 15px;
    z-index: 2;

    color: #7d90b8;

    font-size: 13px;

    transform: translateY(-50%);

    pointer-events: none;
}

.shipped-search input {
    padding-left: 40px;
}

/* =========================================================
   TABLE CARD
========================================================= */

.shipped-table-card {
    width: 100%;
    overflow: hidden;

    background: linear-gradient(
        135deg,
        #101f49,
        #0d1b3e
    );

    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 20px;

    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.25);
}

/* =========================================================
   TABLE TOP
========================================================= */

.shipped-table-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;

    padding: 20px 23px;

    border-bottom: 1px solid rgba(96, 165, 250, 0.14);

    background: rgba(15, 31, 70, 0.65);
}

.shipped-table-heading {
    min-width: 0;
}

.shipped-table-title {
    display: flex;
    align-items: center;
    gap: 10px;

    color: #ffffff;

    font-size: 15px;
    font-weight: 800;
}

.shipped-table-title i {
    color: #75a8ff;
}

.shipped-table-subtitle {
    margin: 5px 0 0;

    color: #8fa4ca;

    font-size: 12px;
    font-weight: 500;
}

.shipped-table-meta {
    display: flex;
    align-items: center;
    gap: 9px;
    flex: 0 0 auto;
}

.shipped-table-count {
    padding: 6px 11px;

    border: 1px solid rgba(96, 165, 250, 0.20);
    border-radius: 999px;

    background: rgba(79, 140, 255, 0.10);

    color: #9fc1ff;

    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.shipped-scroll-hint {
    display: flex;
    align-items: center;
    gap: 6px;

    color: #7185ad;

    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.shipped-scroll-hint i {
    color: #6d8ec8;
}

/* =========================================================
   TABLE WRAPPER
========================================================= */

.shipped-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.shipped-table-wrapper::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.shipped-table-wrapper::-webkit-scrollbar-track {
    background: #091631;
}

.shipped-table-wrapper::-webkit-scrollbar-thumb {
    background: #304a7e;
    border-radius: 999px;
}

.shipped-table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #4567a5;
}

/* =========================================================
   TABLE
========================================================= */

.shipped-table {
    width: 100%;
    min-width: 1050px;
    border-collapse: collapse;
}

/* =========================================================
   TABLE HEADER
========================================================= */

.shipped-table thead {
    background: linear-gradient(
        135deg,
        #315fe0,
        #294fc2
    );
}

.shipped-table th {
    padding: 15px 14px;

    border: 0;

    color: #ffffff;

    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.5px;

    text-align: center;
    text-transform: uppercase;

    white-space: nowrap;
}

.shipped-table th:first-child {
    padding-left: 20px;
    text-align: left;
}

.shipped-table th i {
    margin-right: 5px;
    color: #bcd5ff;
}

/* =========================================================
   TABLE BODY
========================================================= */

.shipped-table td {
    padding: 16px 14px;

    border-bottom: 1px solid rgba(96, 165, 250, 0.11);

    color: #d4e0f7;

    font-size: 13px;

    text-align: center;
    vertical-align: middle;

    white-space: nowrap;
}

.shipped-table td:first-child {
    padding-left: 20px;
    text-align: left;
}

.shipped-table tbody tr {
    background: #101f49;

    transition:
        background 0.2s ease;
}

.shipped-table tbody tr:hover {
    background: #15295a;
}

.shipped-table tbody tr:last-child td {
    border-bottom: 0;
}

.shipped-cadet-name {
    color: #ffffff;

    font-size: 13px;
    font-weight: 800;
}

.shipped-date {
    color: #c9d8f2;
    font-weight: 600;
}

.shipped-muted {
    color: #7285aa;
    font-weight: 600;
}

.shipped-table td strong {
    color: #ffffff;
    font-weight: 750;
}

/* =========================================================
   STATUS BADGES
========================================================= */

.shipped-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;

    min-width: 130px;

    padding: 7px 12px;

    border: 1px solid transparent;
    border-radius: 999px;

    color: #ffffff;

    font-size: 10px;
    font-weight: 800;
    line-height: 1;

    white-space: nowrap;
}

.shipped-status i {
    font-size: 9px;
}

/* PENDING */

.shipped-status-pending {
    background: rgba(100, 116, 139, 0.20);
    border-color: rgba(148, 163, 184, 0.20);
    color: #cbd5e1;
}

/* DELIBERATION */

.shipped-status-deliberation {
    background: rgba(245, 158, 11, 0.14);
    border-color: rgba(245, 158, 11, 0.25);
    color: #fcd36d;
}

/* ENDORSEMENT */

.shipped-status-endorsement {
    background: rgba(79, 140, 255, 0.14);
    border-color: rgba(79, 140, 255, 0.28);
    color: #9fc1ff;
}

/* SHIPPED */

.shipped-status-shipped {
    background: rgba(139, 92, 246, 0.15);
    border-color: rgba(139, 92, 246, 0.28);
    color: #c4a7ff;
}

/* COMPLETED */

.shipped-status-completed {
    background: rgba(34, 197, 94, 0.14);
    border-color: rgba(34, 197, 94, 0.25);
    color: #72e7a1;
}

/* =========================================================
   VIEW BUTTON
========================================================= */

.shipped-view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-width: 72px;
    min-height: 38px;

    padding: 0 14px;

    border: 1px solid rgba(96, 165, 250, 0.35);
    border-radius: 9px;

    background: linear-gradient(
        135deg,
        #3d7cf2,
        #315fcf
    );

    color: #ffffff;

    font-family: inherit;
    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    box-shadow:
        0 5px 14px rgba(37, 86, 190, 0.22);

    transition:
        background 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.shipped-view-btn:hover {
    background: linear-gradient(
        135deg,
        #4d8aff,
        #3a6fdf
    );

    color: #ffffff;

    transform: translateY(-1px);

    box-shadow:
        0 8px 18px rgba(37, 86, 190, 0.30);
}

.shipped-view-btn:active {
    transform: translateY(0);
}

/* =========================================================
   EMPTY STATE
========================================================= */

.shipped-empty {
    padding: 60px 20px !important;

    color: #a8b7d2 !important;

    white-space: normal !important;
    text-align: center !important;

    background: #101f49 !important;
}

.shipped-empty-icon {
    width: 64px;
    height: 64px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin: 0 auto 14px;

    border: 1px solid rgba(96, 165, 250, 0.16);
    border-radius: 16px;

    background: #162853;

    color: #6e91cf;

    font-size: 27px;
}

.shipped-empty strong {
    display: block;

    margin-bottom: 5px;

    color: #ffffff;

    font-size: 14px;
    font-weight: 800;
}

.shipped-empty span {
    color: #8498bb;

    font-size: 12px;
    font-weight: 500;
}

/* =========================================================
   MODAL
========================================================= */

.shipped-modal {
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

.shipped-modal.is-open {
    display: flex;
}

.shipped-modal-content {
    width: min(760px, 100%);
    max-height: 90vh;

    overflow: hidden;

    background: linear-gradient(
        135deg,
        #101f49,
        #0d1b3e
    );

    border: 1px solid rgba(96, 165, 250, 0.24);
    border-radius: 19px;

    box-shadow:
        0 28px 75px rgba(0, 0, 0, 0.55);

    animation: shippedModalIn 0.22s ease;
}

@keyframes shippedModalIn {
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

.shipped-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;

    padding: 18px 22px;

    background: linear-gradient(
        135deg,
        #315fe0,
        #294fc2
    );

    color: #ffffff;

    border-bottom: 1px solid rgba(147, 197, 253, 0.20);
}

.shipped-modal-header-left {
    display: flex;
    align-items: center;
    gap: 11px;

    min-width: 0;
}

.shipped-modal-header-icon {
    width: 41px;
    height: 41px;
    flex: 0 0 41px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 11px;

    background: rgba(255, 255, 255, 0.12);

    color: #ffffff;

    font-size: 17px;
}

.shipped-modal-header h3 {
    min-width: 0;

    margin: 0;

    color: #ffffff;

    font-size: 18px;
    font-weight: 800;
}

.shipped-modal-header p {
    margin: 3px 0 0;

    color: rgba(255, 255, 255, 0.72);

    font-size: 11px;
    font-weight: 500;
}

.shipped-modal-close {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 10px;

    background: rgba(255, 255, 255, 0.10);

    color: #ffffff;

    font-size: 22px;
    line-height: 1;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.shipped-modal-close:hover {
    background: rgba(255, 255, 255, 0.20);
    transform: translateY(-1px);
}

/* =========================================================
   MODAL BODY
========================================================= */

.shipped-modal-body {
    max-height: calc(90vh - 135px);

    overflow-y: auto;

    padding: 23px;

    background: #101f49;
}

.shipped-modal-body::-webkit-scrollbar {
    width: 8px;
}

.shipped-modal-body::-webkit-scrollbar-track {
    background: #091631;
}

.shipped-modal-body::-webkit-scrollbar-thumb {
    background: #304a7e;
    border-radius: 999px;
}

.shipped-modal-body::-webkit-scrollbar-thumb:hover {
    background: #4567a5;
}

/* =========================================================
   DETAILS
========================================================= */

.shipped-details {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 14px;
}

.shipped-detail {
    min-width: 0;

    padding: 16px;

    background: #172955;

    border: 1px solid rgba(96, 165, 250, 0.14);
    border-radius: 12px;

    transition:
        border-color 0.2s ease,
        background 0.2s ease;
}

.shipped-detail:hover {
    background: #1a2e5d;
    border-color: rgba(96, 165, 250, 0.22);
}

.shipped-detail-full {
    grid-column: 1 / -1;
}

.shipped-detail-label {
    display: flex;
    align-items: center;
    gap: 7px;

    margin-bottom: 8px;

    color: #8fa4ca;

    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.6px;

    text-transform: uppercase;
}

.shipped-detail-label i {
    color: #6fa2ff;
    font-size: 10px;
}

.shipped-detail-value {
    display: block;

    color: #ffffff;

    font-size: 14px;
    font-weight: 700;
    line-height: 1.5;

    overflow-wrap: anywhere;
}

.shipped-detail-value.loading {
    color: #8195ba;
    font-weight: 600;
}

.shipped-detail-value.error {
    color: #f87171;
}

/* =========================================================
   MODAL FOOTER
========================================================= */

.shipped-modal-footer {
    display: flex;
    justify-content: flex-end;

    padding: 15px 22px;

    border-top: 1px solid rgba(96, 165, 250, 0.14);

    background: #0d1b3e;
}

.shipped-close-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-height: 40px;

    padding: 0 17px;

    border: 1px solid rgba(148, 163, 184, 0.20);
    border-radius: 9px;

    background: #273858;

    color: #ffffff;

    font-family: inherit;
    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.shipped-close-btn:hover {
    background: #34476b;
    transform: translateY(-1px);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .shipped-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .shipped-filter-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .shipped-search {
        grid-column: 1 / -1;
    }
}

@media (max-width: 800px) {

    .shipped-table-meta {
        flex-direction: column;
        align-items: flex-end;
    }

    .shipped-scroll-hint {
        display: none;
    }
}

@media (max-width: 700px) {

    .shipped-page {
        padding: 15px;
    }

    .shipped-header {
        margin-bottom: 18px;
        padding: 19px;

        border-radius: 16px;
    }

    .shipped-header-icon {
        width: 47px;
        height: 47px;
        flex-basis: 47px;

        border-radius: 13px;

        font-size: 20px;
    }

    .shipped-header h2 {
        font-size: 21px;
    }

    .shipped-header p {
        font-size: 11px;
    }

    .shipped-stats {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .shipped-stat {
        min-height: 105px;
        padding: 18px;
    }

    .shipped-stat-value {
        font-size: 27px;
    }

    .shipped-stat-icon {
        width: 52px;
        height: 52px;
        flex-basis: 52px;

        font-size: 20px;
    }

    .shipped-filter-card {
        padding: 17px;
        border-radius: 16px;
    }

    .shipped-filter-grid {
        grid-template-columns: 1fr;
    }

    .shipped-search {
        grid-column: auto;
    }

    .shipped-table-top {
        align-items: flex-start;
        flex-direction: column;

        padding: 17px;
    }

    .shipped-table-meta {
        width: 100%;

        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .shipped-table-card {
        border-radius: 16px;
    }

    .shipped-modal {
        padding: 10px;
    }

    .shipped-modal-content {
        max-height: 95vh;
        border-radius: 15px;
    }

    .shipped-modal-header {
        padding: 15px 16px;
    }

    .shipped-modal-header h3 {
        font-size: 16px;
    }

    .shipped-modal-header p {
        display: none;
    }

    .shipped-modal-body {
        max-height: calc(95vh - 125px);
        padding: 15px;
    }

    .shipped-details {
        grid-template-columns: 1fr;
    }

    .shipped-detail-full {
        grid-column: auto;
    }

    .shipped-modal-footer {
        padding: 13px 15px;
    }

    .shipped-close-btn {
        width: 100%;
    }
}

@media (max-width: 420px) {

    .shipped-page {
        padding: 10px;
    }

    .shipped-header {
        padding: 15px;
    }

    .shipped-header-icon {
        width: 42px;
        height: 42px;
        flex-basis: 42px;
    }

    .shipped-header h2 {
        font-size: 19px;
    }

    .shipped-stat {
        padding: 16px;
    }

    .shipped-stat-value {
        font-size: 25px;
    }

    .shipped-stat-icon {
        width: 48px;
        height: 48px;
        flex-basis: 48px;
    }

    .shipped-filter-control {
        height: 45px;
    }

    .shipped-modal-body {
        padding: 12px;
    }
}
</style>


<div class="shipped-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="shipped-header">

        <div class="shipped-header-icon">
            <i class="fas fa-ship"></i>
        </div>

        <div class="shipped-header-content">

            <h2>
                Special Order
            </h2>

            <p>
                Monitor cadet special order requests and CHED shipping status.
            </p>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="shipped-stats">

        {{-- TOTAL --}}
        <div class="shipped-stat shipped-stat-blue">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $total }}
                </h3>

                <p class="shipped-stat-label">
                    Total Records
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-ship"></i>
            </div>

        </div>


        {{-- PENDING --}}
        <div class="shipped-stat shipped-stat-gray">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $pending }}
                </h3>

                <p class="shipped-stat-label">
                    Pending
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-clock"></i>
            </div>

        </div>


        {{-- ENDORSEMENT --}}
        <div class="shipped-stat shipped-stat-orange">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $endorsement }}
                </h3>

                <p class="shipped-stat-label">
                    For Endorsement
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-paper-plane"></i>
            </div>

        </div>


        {{-- COMPLETED --}}
        <div class="shipped-stat shipped-stat-green">

            <div class="shipped-stat-content">

                <h3 class="shipped-stat-value">
                    {{ $completed }}
                </h3>

                <p class="shipped-stat-label">
                    Completed
                </p>

            </div>

            <div class="shipped-stat-icon">
                <i class="fas fa-circle-check"></i>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="shipped-filter-card">

        <div class="shipped-filter-header">

            <i class="fas fa-filter"></i>

            <span>
                Filter Records
            </span>

        </div>


        <form
            id="shippedFilterForm"
            method="GET"
            action="{{ route('superadmin.shipped-so.index') }}"
        >

            <div class="shipped-filter-grid">

                {{-- COURSE --}}
                <select
                    name="course"
                    id="shippedCourseFilter"
                    class="shipped-filter-control"
                    aria-label="Filter by course"
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


                {{-- BATCH --}}
                <select
                    name="batch"
                    id="shippedBatchFilter"
                    class="shipped-filter-control"
                    aria-label="Filter by batch"
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


                {{-- SEARCH --}}
                <div class="shipped-search">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        name="search"
                        id="shippedSearch"
                        class="shipped-filter-control"
                        placeholder="Search cadet..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                        aria-label="Search cadet"
                    >

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="shipped-table-card">

        <div class="shipped-table-top">

            <div class="shipped-table-heading">

                <div class="shipped-table-title">

                    <i class="fas fa-list-check"></i>

                    <span>
                        Special Order Records
                    </span>

                </div>

                <p class="shipped-table-subtitle">
                    Review special order requests, endorsement progress, and CHED issuance details.
                </p>

            </div>


            <div class="shipped-table-meta">

                <div class="shipped-scroll-hint">
                    <i class="fas fa-arrows-left-right"></i>
                    Scroll horizontally
                </div>

                <div class="shipped-table-count">
                    {{ $orders->count() }} Records
                </div>

            </div>

        </div>


        <div class="shipped-table-wrapper">

            <table class="shipped-table">

                <thead>

                    <tr>

                        <th>
                            <i class="fas fa-user"></i>
                            Cadet
                        </th>

                        <th>
                            <i class="fas fa-calendar"></i>
                            Deliberation Date
                        </th>

                        <th>
                            <i class="fas fa-circle-info"></i>
                            Status
                        </th>

                        <th>
                            <i class="fas fa-paper-plane"></i>
                            OBT Endorsement
                        </th>

                        <th>
                            <i class="fas fa-file-invoice"></i>
                            CHED SO Number
                        </th>

                        <th>
                            <i class="fas fa-calendar-check"></i>
                            Date Issued
                        </th>

                        <th>
                            <i class="fas fa-eye"></i>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($orders as $order)

                        @php

                            $status = $order->status ?: 'Pending';

                            $statusClass = match ($status) {

                                'For Deliberation'
                                    => 'shipped-status-deliberation',

                                'For Endorsement'
                                    => 'shipped-status-endorsement',

                                'Shipped'
                                    => 'shipped-status-shipped',

                                'Completed'
                                    => 'shipped-status-completed',

                                default
                                    => 'shipped-status-pending',

                            };

                            $statusIcon = match ($status) {

                                'For Deliberation'
                                    => 'fa-hourglass-half',

                                'For Endorsement'
                                    => 'fa-paper-plane',

                                'Shipped'
                                    => 'fa-ship',

                                'Completed'
                                    => 'fa-circle-check',

                                default
                                    => 'fa-clock',

                            };

                        @endphp


                        <tr>

                            {{-- CADET --}}
                            <td>

                                <span class="shipped-cadet-name">
                                    {{ $order->cadet->full_name ?? '-' }}
                                </span>

                            </td>


                            {{-- DELIBERATION DATE --}}
                            <td>

                                @if($order->deliberation_date)

                                    <span class="shipped-date">

                                        {{ \Carbon\Carbon::parse(
                                            $order->deliberation_date
                                        )->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span
                                    class="shipped-status {{ $statusClass }}"
                                >

                                    <i class="fas {{ $statusIcon }}"></i>

                                    {{ $status }}

                                </span>

                            </td>


                            {{-- ENDORSEMENT --}}
                            <td>

                                @if($order->obt_endorsement_date)

                                    <span class="shipped-date">

                                        {{ \Carbon\Carbon::parse(
                                            $order->obt_endorsement_date
                                        )->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- SO NUMBER --}}
                            <td>

                                @if($order->so_number)

                                    <strong>
                                        {{ $order->so_number }}
                                    </strong>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- SO DATE --}}
                            <td>

                                @if($order->so_date_issued)

                                    <span class="shipped-date">

                                        {{ \Carbon\Carbon::parse(
                                            $order->so_date_issued
                                        )->format('M d, Y') }}

                                    </span>

                                @else

                                    <span class="shipped-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}
                            <td>

                                <button
                                    type="button"
                                    class="shipped-view-btn"
                                    onclick="openShippedModal({{ $order->id }})"
                                >

                                    <i class="fas fa-eye"></i>

                                    View

                                </button>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="shipped-empty"
                            >

                                <div class="shipped-empty-icon">

                                    <i class="fas fa-box-open"></i>

                                </div>

                                <strong>
                                    No Special Order records found.
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
    id="shippedViewModal"
    class="shipped-modal"
    aria-hidden="true"
>

    <div
        class="shipped-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="shippedModalTitle"
    >

        {{-- MODAL HEADER --}}
        <div class="shipped-modal-header">

            <div class="shipped-modal-header-left">

                <div class="shipped-modal-header-icon">
                    <i class="fas fa-ship"></i>
                </div>

                <div>

                    <h3 id="shippedModalTitle">
                        Special Order Details
                    </h3>

                    <p>
                        Complete order information
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="shipped-modal-close"
                onclick="closeShippedModal()"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        {{-- MODAL BODY --}}
        <div class="shipped-modal-body">

            <div class="shipped-details">

                {{-- CADET --}}
                <div class="shipped-detail shipped-detail-full">

                    <span class="shipped-detail-label">

                        <i class="fas fa-user"></i>

                        Cadet

                    </span>

                    <span
                        id="shippedCadet"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- DELIBERATION DATE --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-calendar"></i>

                        Deliberation Date

                    </span>

                    <span
                        id="shippedDeliberationDate"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- STATUS --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-circle-info"></i>

                        Status

                    </span>

                    <span
                        id="shippedStatus"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- ENDORSEMENT DATE --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-paper-plane"></i>

                        OBT Endorsement Date

                    </span>

                    <span
                        id="shippedEndorsementDate"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- SO NUMBER --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-file-invoice"></i>

                        CHED SO Number

                    </span>

                    <span
                        id="shippedSONumber"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- DATE ISSUED --}}
                <div class="shipped-detail">

                    <span class="shipped-detail-label">

                        <i class="fas fa-calendar-check"></i>

                        Date Issued

                    </span>

                    <span
                        id="shippedSODate"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>


                {{-- REMARKS --}}
                <div class="shipped-detail shipped-detail-full">

                    <span class="shipped-detail-label">

                        <i class="fas fa-comment"></i>

                        Remarks

                    </span>

                    <span
                        id="shippedRemarks"
                        class="shipped-detail-value"
                    >
                        —
                    </span>

                </div>

            </div>

        </div>


        {{-- MODAL FOOTER --}}
        <div class="shipped-modal-footer">

            <button
                type="button"
                class="shipped-close-btn"
                onclick="closeShippedModal()"
            >

                <i class="fas fa-xmark"></i>

                Close

            </button>

        </div>

    </div>

</div>


<script>
(function () {

    'use strict';

    /* =====================================================
       ELEMENTS
    ===================================================== */

    const filterForm =
        document.getElementById('shippedFilterForm');

    const courseFilter =
        document.getElementById('shippedCourseFilter');

    const batchFilter =
        document.getElementById('shippedBatchFilter');

    const searchInput =
        document.getElementById('shippedSearch');

    const modal =
        document.getElementById('shippedViewModal');


    /* =====================================================
       PRESERVE BODY OVERFLOW
    ===================================================== */

    let previousBodyOverflow = '';


    /* =====================================================
       FILTERS
    ===================================================== */

    if (courseFilter && filterForm) {

        courseFilter.addEventListener(
            'change',
            function () {
                filterForm.submit();
            }
        );

    }


    if (batchFilter && filterForm) {

        batchFilter.addEventListener(
            'change',
            function () {
                filterForm.submit();
            }
        );

    }


    let searchTimer = null;

    if (searchInput && filterForm) {

        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(searchTimer);

                searchTimer = setTimeout(
                    function () {
                        filterForm.submit();
                    },
                    500
                );

            }
        );

    }


    /* =====================================================
       GLOBAL ESCAPE
    ===================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal &&
                modal.classList.contains('is-open')
            ) {

                closeShippedModal();

            }

        }
    );


    /* =====================================================
       BACKDROP CLICK
    ===================================================== */

    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (event.target === modal) {
                    closeShippedModal();
                }

            }
        );

    }


    /* =====================================================
       OPEN MODAL
    ===================================================== */

    window.openShippedModal = function (id) {

        if (!modal) {
            return;
        }


        /* -------------------------------------------------
           RESET VALUES
        ------------------------------------------------- */

        setShippedValue(
            'shippedCadet',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedDeliberationDate',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedStatus',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedEndorsementDate',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedSONumber',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedSODate',
            'Loading...',
            'loading'
        );

        setShippedValue(
            'shippedRemarks',
            'Loading...',
            'loading'
        );


        /* -------------------------------------------------
           OPEN MODAL
        ------------------------------------------------- */

        previousBodyOverflow =
            document.body.style.overflow;

        modal.classList.add('is-open');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';


        /* -------------------------------------------------
           DETAIL URL
        ------------------------------------------------- */

        const detailUrl =
            `/super-admin/shipped-so/${id}`;


        /* -------------------------------------------------
           FETCH RECORD
        ------------------------------------------------- */

        fetch(
            detailUrl,
            {
                method: 'GET',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                credentials: 'same-origin'
            }
        )

        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    `Request failed with status ${response.status}`
                );

            }

            return response.json();

        })

        .then(function (data) {

            setShippedValue(
                'shippedCadet',
                data.cadet?.full_name || '—'
            );

            setShippedValue(
                'shippedDeliberationDate',
                formatShippedDate(
                    data.deliberation_date
                )
            );

            setShippedValue(
                'shippedStatus',
                data.status || 'Pending'
            );

            setShippedValue(
                'shippedEndorsementDate',
                formatShippedDate(
                    data.obt_endorsement_date
                )
            );

            setShippedValue(
                'shippedSONumber',
                data.so_number || '—'
            );

            setShippedValue(
                'shippedSODate',
                formatShippedDate(
                    data.so_date_issued
                )
            );

            setShippedValue(
                'shippedRemarks',
                data.remarks || '—'
            );

        })

        .catch(function (error) {

            console.error(
                'Special Order error:',
                error
            );


            setShippedValue(
                'shippedCadet',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedDeliberationDate',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedStatus',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedEndorsementDate',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedSONumber',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedSODate',
                'Unable to load',
                'error'
            );

            setShippedValue(
                'shippedRemarks',
                'Unable to load this record.',
                'error'
            );

        });

    };


    /* =====================================================
       CLOSE MODAL
    ===================================================== */

    window.closeShippedModal = function () {

        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow =
            previousBodyOverflow || '';

    };


    /* =====================================================
       SET VALUE
    ===================================================== */

    function setShippedValue(
        elementId,
        value,
        state = ''
    ) {

        const element =
            document.getElementById(elementId);

        if (!element) {
            return;
        }

        element.textContent =
            value || '—';

        element.classList.remove(
            'loading',
            'error'
        );

        if (state) {
            element.classList.add(state);
        }

    }


    /* =====================================================
       FORMAT DATE
    ===================================================== */

    function formatShippedDate(date) {

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
            return '—';
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

})();
</script>

@endsection