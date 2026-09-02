@extends('layouts.superadmin')

@section('header-title', 'Cadet Requirement Monitoring')

@section('content')

<style>

/* =========================================================
   CADET REQUIREMENT MONITORING
   UI STYLE MATCHED TO VERIFICATION MONITORING
   ========================================================= */

.requirement-page {
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
    font-size: 27px;
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
    grid-template-columns: repeat(4, minmax(0, 1fr));
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
    font-size: 27px;
}

/* Individual statistics */

.stat-card.total {
    background:
        linear-gradient(
            135deg,
            #3164e6 0%,
            #2852c4 100%
        );
}

.stat-card.approved {
    background:
        linear-gradient(
            135deg,
            #18a957 0%,
            #0d8f43 100%
        );
}

.stat-card.pending {
    background:
        linear-gradient(
            135deg,
            #e6a51c 0%,
            #c98508 100%
        );
}

.stat-card.rejected {
    background:
        linear-gradient(
            135deg,
            #e34b55 0%,
            #c92e3d 100%
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
    grid-template-columns: 1.5fr 1fr 1fr;
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
    min-width: 1100px;
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
   TRB / TEXT
   ========================================================= */

.trb-number {
    color: #dbeafe;
    font-weight: 700;
}

.cadet-name {
    color: #ffffff;
    font-weight: 700;
}

.secondary-text {
    color: #a9bad8;
}

/* =========================================================
   DEPLOYMENT BADGES
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

.status.ongoing {
    border: 1px solid rgba(52, 211, 153, 0.30);
    background: rgba(16, 185, 129, 0.13);
    color: #6ee7b7;
}

.status.completed {
    border: 1px solid rgba(96, 165, 250, 0.28);
    background: rgba(59, 130, 246, 0.13);
    color: #93c5fd;
}

.status.unknown {
    border: 1px solid rgba(148, 163, 184, 0.25);
    background: rgba(148, 163, 184, 0.10);
    color: #cbd5e1;
}

/* =========================================================
   PROGRESS
   ========================================================= */

.progress-container {
    width: 190px;
}

.progress-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 7px;
}

.progress-count {
    color: #dbeafe;
    font-size: 12px;
    font-weight: 700;
}

.progress-percentage {
    color: #93c5fd;
    font-size: 12px;
    font-weight: 800;
}

.progress-bar {
    width: 100%;
    height: 9px;
    overflow: hidden;
    border-radius: 50px;
    background: #142653;
    border: 1px solid rgba(96, 165, 250, 0.12);
}

.progress-fill {
    height: 100%;
    border-radius: 50px;
    background:
        linear-gradient(
            90deg,
            #3b82f6 0%,
            #60a5fa 100%
        );
    transition: width 0.35s ease;
}

/* =========================================================
   REQUIREMENT SUMMARY BADGE
   ========================================================= */

.requirement-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 65px;
    padding: 7px 12px;
    border: 1px solid rgba(96, 165, 250, 0.20);
    border-radius: 20px;
    background: rgba(96, 165, 250, 0.10);
    color: #dbeafe;
    font-size: 13px;
    font-weight: 700;
}

/* =========================================================
   VIEW BUTTON
   ========================================================= */

.btn-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 75px;
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
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow:
        0 7px 15px rgba(0, 0, 0, 0.22);
}

/* =========================================================
   MODAL BACKDROP
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

/* =========================================================
   CHECKLIST MODAL
   ========================================================= */

.checklist-modal-content {
    width: 100%;
    max-width: 950px;
    max-height: 90vh;
    overflow-y: auto;
    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 20px;
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

.preview-modal-content {
    width: 100%;
    max-width: 950px;
    max-height: 92vh;
    overflow-y: auto;
    border: 1px solid rgba(96, 165, 250, 0.18);
    border-radius: 20px;
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
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0;
    color: #ffffff;
    font-size: 19px;
    font-weight: 700;
}

.custom-modal-header h3 i {
    color: #dbeafe;
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
   MODAL BODY
   ========================================================= */

.checklist-body {
    padding: 22px;
}

.preview-body {
    padding: 22px;
}

/* =========================================================
   REQUIREMENT CARD
   ========================================================= */

.requirement-card {
    margin-bottom: 18px;
    padding: 20px;
    border: 1px solid rgba(96, 165, 250, 0.13);
    border-radius: 17px;
    background:
        linear-gradient(
            145deg,
            #1b2d62 0%,
            #172755 100%
        );
    box-shadow:
        0 7px 18px rgba(0, 0, 0, 0.15);
    transition:
        transform 0.2s ease,
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.requirement-card:hover {
    transform: translateY(-2px);
    border-color: rgba(96, 165, 250, 0.25);
    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.22);
}

.requirement-card:last-child {
    margin-bottom: 0;
}

/* =========================================================
   REQUIREMENT HEADER
   ========================================================= */

.req-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 17px;
}

.req-header h3 {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    color: #ffffff;
    font-size: 18px;
    font-weight: 800;
}

.req-header h3 i {
    color: #60a5fa;
}

/* =========================================================
   REQUIREMENT STATUS
   ========================================================= */

.requirement-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 88px;
    padding: 7px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.status-approved {
    border: 1px solid rgba(52, 211, 153, 0.30);
    background: rgba(16, 185, 129, 0.13);
    color: #6ee7b7;
}

.status-submitted {
    border: 1px solid rgba(96, 165, 250, 0.28);
    background: rgba(59, 130, 246, 0.13);
    color: #93c5fd;
}

.status-pending {
    border: 1px solid rgba(250, 204, 21, 0.28);
    background: rgba(234, 179, 8, 0.13);
    color: #fde68a;
}

.status-rejected {
    border: 1px solid rgba(248, 113, 113, 0.28);
    background: rgba(239, 68, 68, 0.13);
    color: #fca5a5;
}

/* =========================================================
   REQUIREMENT INFORMATION
   ========================================================= */

.req-body {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    padding: 16px;
    border: 1px solid rgba(96, 165, 250, 0.10);
    border-radius: 13px;
    background: #0f2047;
}

.req-body p {
    min-width: 0;
    margin: 0;
    padding: 12px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.035);
    color: #a9bad8;
    font-size: 13px;
    line-height: 1.5;
}

.req-body strong {
    display: block;
    margin-bottom: 5px;
    color: #8fa4ca;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.req-body p:last-child {
    grid-column: 1 / -1;
}

/* =========================================================
   ATTACHMENT AREA
   ========================================================= */

.attachment-section {
    margin-top: 16px;
    padding: 16px;
    border: 1px solid rgba(96, 165, 250, 0.10);
    border-radius: 13px;
    background: #0f2047;
}

.attachment-title {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
}

.attachment-title i {
    color: #60a5fa;
}

.attachment-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
}

.attachment-actions button,
.attachment-actions a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 38px;
    padding: 8px 14px;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700;
}

/* =========================================================
   VIEW ONLY FOOTER
   ========================================================= */

.req-footer {
    margin-top: 16px;
}

.view-only {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 11px;
    border: 1px solid rgba(96, 165, 250, 0.10);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.045);
    color: #8fa4ca;
    font-size: 12px;
    font-weight: 700;
}

/* =========================================================
   EMPTY REQUIREMENTS
   ========================================================= */

.empty-requirements {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 280px;
    padding: 40px 20px;
    border: 1px solid rgba(96, 165, 250, 0.10);
    border-radius: 15px;
    background:
        linear-gradient(
            145deg,
            #172955 0%,
            #122347 100%
        );
    color: #8fa4ca;
    text-align: center;
}

.empty-requirements i {
    margin-bottom: 15px;
    color: #60a5fa;
    font-size: 44px;
}

.empty-requirements h5 {
    margin: 0 0 7px;
    color: #ffffff;
    font-size: 18px;
    font-weight: 700;
}

.empty-requirements p {
    max-width: 450px;
    margin: 0;
    color: #8fa4ca;
    font-size: 13px;
    line-height: 1.6;
}

/* =========================================================
   PREVIEW CONTAINER
   ========================================================= */

.preview-container {
    width: 100%;
    min-height: 420px;
    padding: 15px;
    border: 1px solid rgba(96, 165, 250, 0.10);
    border-radius: 14px;
    background: #0a1735;
}

.preview-container img {
    display: block;
    width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 10px;
}

.preview-container iframe {
    display: block;
    width: 100%;
    height: 650px;
    border: none;
    border-radius: 10px;
    background: #ffffff;
}

/* =========================================================
   LOADING
   ========================================================= */

.loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 250px;
    text-align: center;
}

.loading-state p {
    margin-top: 15px;
    color: #8fa4ca;
    font-size: 13px;
}

/* =========================================================
   ERROR
   ========================================================= */

.alert-danger {
    padding: 18px;
    border: 1px solid rgba(248, 113, 113, 0.25);
    border-radius: 12px;
    background: rgba(220, 38, 38, 0.12);
    color: #fca5a5;
}

.alert-danger strong {
    color: #fecaca;
}

/* =========================================================
   EMPTY TABLE
   ========================================================= */

.empty-state {
    padding: 50px 20px !important;
    color: #91a4c5 !important;
    text-align: center !important;
}

.empty-state i {
    margin-right: 7px;
    color: #60a5fa;
}

/* =========================================================
   LARGE DESKTOP
   ========================================================= */

@media (max-width: 1400px) {

    .stats-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
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

    .page-header {
        padding: 24px 26px;
    }

    .page-header h2 {
        font-size: 24px;
    }

    .checklist-modal-content,
    .preview-modal-content {
        max-width: calc(100vw - 40px);
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

    .checklist-modal-content,
    .preview-modal-content {
        max-width: calc(100vw - 24px);
        max-height: 94vh;
        border-radius: 15px;
    }

    .custom-modal-header {
        padding: 15px 17px;
    }

    .custom-modal-header h3 {
        font-size: 16px;
    }

    .checklist-body,
    .preview-body {
        padding: 15px;
    }

    .req-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .req-body {
        grid-template-columns: 1fr;
    }

    .req-body p:last-child {
        grid-column: auto;
    }

    .requirement-card {
        padding: 16px;
    }

    .attachment-actions {
        flex-direction: column;
    }

    .attachment-actions button,
    .attachment-actions a {
        width: 100%;
    }

    .preview-container {
        min-height: 300px;
        padding: 10px;
    }

    .preview-container iframe {
        height: 500px;
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
        min-width: 1100px;
    }

    .custom-modal-header {
        padding: 14px 15px;
    }

    .custom-modal-header h3 {
        font-size: 15px;
    }

    .close-modal {
        width: 33px;
        height: 33px;
        font-size: 22px;
    }

    .requirement-card {
        padding: 14px;
    }

    .req-header h3 {
        font-size: 16px;
    }

    .req-body {
        padding: 12px;
    }

    .preview-container iframe {
        height: 400px;
    }
}

</style>


<div class="requirement-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">

        <div class="page-header-content">

            <h2>
                <span class="page-header-icon">📋</span>

                Cadet Requirement Monitoring
            </h2>

            <p>
                Monitor deployed cadets and their onboard requirement progress.
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

            {{-- TOTAL CADETS --}}

            <div class="stat-card total">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Deployed Cadets
                    </div>

                    <div class="stat-value">
                        {{ $cadets->count() }}
                    </div>

                </div>

                <div class="stat-icon">
                    👥
                </div>

            </div>


            {{-- APPROVED --}}

            <div class="stat-card approved">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Approved Requirements
                    </div>

                    <div class="stat-value">

                        {{
                            $cadets->sum(function ($cadet) {
                                return $cadet->onboardRequirements
                                    ->where('status', 'Approved')
                                    ->count();
                            })
                        }}

                    </div>

                </div>

                <div class="stat-icon">
                    ✓
                </div>

            </div>


            {{-- PENDING --}}

            <div class="stat-card pending">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Pending Review
                    </div>

                    <div class="stat-value">

                        {{
                            $cadets->sum(function ($cadet) {
                                return $cadet->onboardRequirements
                                    ->where('status', 'Pending')
                                    ->count();
                            })
                        }}

                    </div>

                </div>

                <div class="stat-icon">
                    ⏳
                </div>

            </div>


            {{-- REJECTED --}}

            <div class="stat-card rejected">

                <div class="stat-card-content">

                    <div class="stat-title">
                        Rejected Documents
                    </div>

                    <div class="stat-value">

                        {{
                            $cadets->sum(function ($cadet) {
                                return $cadet->onboardRequirements
                                    ->where('status', 'Rejected')
                                    ->count();
                            })
                        }}

                    </div>

                </div>

                <div class="stat-icon">
                    !
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


            <div class="filter-grid">

                {{-- SEARCH --}}

                <div class="filter-field">

                    <input
                        type="text"
                        id="searchCadet"
                        placeholder="Search Cadet Name"
                        autocomplete="off"
                    >

                </div>


                {{-- BATCH --}}

                <div class="filter-field">

                    <select id="batchFilter">

                        <option value="">
                            All Batches
                        </option>

                        @foreach($batches as $batch)

                            <option value="{{ $batch->batch_year }}">
                                {{ $batch->batch_year }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- COURSE --}}

                <div class="filter-field">

                    <select id="courseFilter">

                        <option value="">
                            All Courses
                        </option>

                        @foreach($courses as $course)

                            <option value="{{ $course->course }}">
                                {{ $course->course }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- DEPLOYMENT --}}

                <div class="filter-field">

                    <select id="deploymentFilter">

                        <option value="">
                            All Deployment
                        </option>

                        <option value="Ongoing">
                            Ongoing
                        </option>

                        <option value="Completed">
                            Completed
                        </option>

                    </select>

                </div>

            </div>

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
                    Cadet Requirement Records
                </h3>

                <p>
                    Review onboard requirements, deployment status, and progress
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

                        <th>
                            #
                        </th>

                        <th>
                            TRB
                        </th>

                        <th>
                            Cadet
                        </th>

                        <th>
                            Course
                        </th>

                        <th>
                            Batch
                        </th>

                        <th>
                            Deployment
                        </th>

                        <th>
                            Progress
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($cadets as $cadet)

                    @php

                        $totalRequirements =
                            $cadet->onboardRequirements->count();

                        $approvedRequirements =
                            $cadet->onboardRequirements
                                ->where('status', 'Approved')
                                ->count();

                        $percentage =
                            $totalRequirements
                                ? ($approvedRequirements / $totalRequirements) * 100
                                : 0;

                        $deploymentStatus =
                            $cadet->deployment->status ?? null;

                    @endphp


                    <tr

                        data-name="{{ strtolower($cadet->full_name) }}"

                        data-batch="{{ optional($cadet->batch)->batch_year }}"

                        data-course="{{ strtolower($cadet->course) }}"

                        data-deployment="{{ strtolower($deploymentStatus ?? '') }}"

                    >

                        {{-- NUMBER --}}

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- TRB --}}

                        <td>

                            <span class="trb-number">
                                {{ $cadet->trb_control_number ?? '-' }}
                            </span>

                        </td>


                        {{-- NAME --}}

                        <td>

                            <span class="cadet-name">
                                {{ $cadet->full_name }}
                            </span>

                        </td>


                        {{-- COURSE --}}

                        <td>
                            {{ $cadet->course ?? '-' }}
                        </td>


                        {{-- BATCH --}}

                        <td>

                            <span class="secondary-text">

                                {{
                                    optional($cadet->batch)->batch_year
                                    ?? '-'
                                }}

                            </span>

                        </td>


                        {{-- DEPLOYMENT --}}

                        <td>

                            @if($deploymentStatus === 'Ongoing')

                                <span class="status ongoing">
                                    Ongoing
                                </span>

                            @elseif($deploymentStatus === 'Completed')

                                <span class="status completed">
                                    Completed
                                </span>

                            @else

                                <span class="status unknown">
                                    -
                                </span>

                            @endif

                        </td>


                        {{-- PROGRESS --}}

                        <td>

                            <div class="progress-container">

                                <div class="progress-info">

                                    <span class="progress-count">

                                        {{ $approvedRequirements }}
                                        /
                                        {{ $totalRequirements }}

                                    </span>

                                    <span class="progress-percentage">

                                        {{ number_format($percentage, 0) }}%

                                    </span>

                                </div>


                                <div class="progress-bar">

                                    <div
                                        class="progress-fill"
                                        style="width: {{ $percentage }}%;"
                                    ></div>

                                </div>

                            </div>

                        </td>


                        {{-- ACTION --}}

                        <td>

                            <button
                                type="button"
                                class="btn-view"
                                onclick='viewChecklist(
                                    {{ $cadet->id }},
                                    @json(route("superadmin.cadet-requirements.show", $cadet->id))
                                )'
                            >

                                <i class="fa fa-eye me-1"></i>

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

                            <i class="fas fa-users-slash"></i>

                            No deployed cadets found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     CHECKLIST MODAL
========================================================= --}}

<div
    id="checklistModal"
    class="custom-modal"
    aria-hidden="true"
>

    <div class="checklist-modal-content">

        {{-- HEADER --}}

        <div class="custom-modal-header">

            <h3>

                <i class="fas fa-file-alt"></i>

                <span id="cadetName">
                    Cadet Requirements
                </span>

            </h3>

            <button
                type="button"
                class="close-modal"
                onclick="closeChecklist()"
                aria-label="Close modal"
            >
                &times;
            </button>

        </div>


        {{-- BODY --}}

        <div
            id="checklistBody"
            class="checklist-body"
        ></div>

    </div>

</div>


{{-- =========================================================
     ATTACHMENT PREVIEW MODAL
========================================================= --}}

<div
    id="previewModal"
    class="custom-modal"
    aria-hidden="true"
>

    <div class="preview-modal-content">

        {{-- HEADER --}}

        <div class="custom-modal-header">

            <h3>

                <i class="fas fa-eye"></i>

                Attachment Preview

            </h3>

            <button
                type="button"
                class="close-modal"
                onclick="closePreview()"
                aria-label="Close preview"
            >
                &times;
            </button>

        </div>


        {{-- BODY --}}

        <div class="preview-body">

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

    const modal =
        document.getElementById('checklistModal');

    const body =
        document.getElementById('checklistBody');

    const name =
        document.getElementById('cadetName');


    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.style.overflow = 'hidden';


    name.textContent = 'Loading...';


    body.innerHTML = `

        <div class="loading-state">

            <div
                class="spinner-border"
                style="color:#60a5fa;"
            ></div>

            <p>
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

        console.log(
            'HTTP Status:',
            response.status
        );


        const text =
            await response.text();


        console.log(
            'Server Response:',
            text
        );


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

        console.log(
            'Cadet data:',
            data
        );


        name.textContent =
            data.full_name || 'Cadet';


        const requirements =
            Array.isArray(
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

            let statusClass =
                'status-pending';


            switch (item.status) {

                case 'Approved':

                    statusClass =
                        'status-approved';

                    break;


                case 'Submitted':

                    statusClass =
                        'status-submitted';

                    break;


                case 'Rejected':

                    statusClass =
                        'status-rejected';

                    break;


                case 'Pending':

                    statusClass =
                        'status-pending';

                    break;

            }


            const requirementTitle =
                item.requirement?.title || '-';


            const frequency =
                item.requirement?.frequency || '-';


            const attachmentUrl =
                item.attachment
                    ? `/storage/${item.attachment}`
                    : null;


            const attachmentHtml = item.attachment

                ? `

                    <div class="attachment-actions">

                        <button
                            type="button"
                            class="btn btn-info btn-sm"
                            onclick="previewAttachment(
                                '${attachmentUrl}'
                            )"
                        >

                            <i class="fas fa-eye"></i>

                            Preview

                        </button>


                        <a
                            href="${attachmentUrl}"
                            download
                            class="btn btn-success btn-sm"
                        >

                            <i class="fas fa-download"></i>

                            Download

                        </a>

                    </div>

                `

                : `

                    <span class="text-muted">
                        No uploaded file
                    </span>

                `;


            html += `

                <div class="requirement-card">

                    <div class="req-header">

                        <h3>

                            <i class="fas fa-file-alt"></i>

                            ${escapeHtml(requirementTitle)}

                        </h3>


                        <span class="
                            requirement-status
                            ${statusClass}
                        ">

                            ${escapeHtml(item.status || 'Pending')}

                        </span>

                    </div>


                    <div class="req-body">

                        <p>

                            <strong>
                                Frequency
                            </strong>

                            ${escapeHtml(frequency)}

                        </p>


                        <p>

                            <strong>
                                Submitted
                            </strong>

                            ${escapeHtml(
                                item.submitted_at || '-'
                            )}

                        </p>


                        <p>

                            <strong>
                                Approved
                            </strong>

                            ${escapeHtml(
                                item.approved_at || '-'
                            )}

                        </p>


                        <p>

                            <strong>
                                Remarks
                            </strong>

                            ${escapeHtml(
                                item.remarks || '-'
                            )}

                        </p>

                    </div>


                    <div class="attachment-section">

                        <div class="attachment-title">

                            <i class="fas fa-paperclip"></i>

                            Attachment

                        </div>


                        ${attachmentHtml}

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

        console.error(
            'Checklist Error:',
            error
        );


        name.textContent =
            'Unable to Load';


        body.innerHTML = `

            <div class="alert-danger">

                <i class="
                    fas
                    fa-exclamation-triangle
                "></i>

                <strong>
                    Failed to load cadet requirements.
                </strong>

                <p style="margin:8px 0 0;">
                    ${escapeHtml(error.message)}
                </p>

            </div>

        `;

    });

}


/* =========================================================
   ESCAPE HTML
   ========================================================= */

function escapeHtml(value) {

    const div =
        document.createElement('div');

    div.textContent =
        value ?? '';

    return div.innerHTML;

}


/* =========================================================
   CLOSE CHECKLIST
   ========================================================= */

function closeChecklist() {

    const modal =
        document.getElementById('checklistModal');


    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );


    document.body.style.overflow = '';

}


/* =========================================================
   CLOSE PREVIEW
   ========================================================= */

function closePreview() {

    const modal =
        document.getElementById('previewModal');

    const body =
        document.getElementById('previewBody');


    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );


    body.innerHTML = '';


    document.body.style.overflow = '';

}


/* =========================================================
   CLICK OUTSIDE MODALS
   ========================================================= */

document
    .getElementById('checklistModal')
    ?.addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closeChecklist();

            }

        }
    );


document
    .getElementById('previewModal')
    ?.addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closePreview();

            }

        }
    );


/* =========================================================
   ESCAPE KEY
   ========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        if (event.key !== 'Escape') {
            return;
        }


        const previewModal =
            document.getElementById('previewModal');

        const checklistModal =
            document.getElementById('checklistModal');


        if (
            previewModal &&
            previewModal.classList.contains('show')
        ) {

            closePreview();

            return;

        }


        if (
            checklistModal &&
            checklistModal.classList.contains('show')
        ) {

            closeChecklist();

        }

    }
);


/* =========================================================
   ATTACHMENT PREVIEW
   ========================================================= */

function previewAttachment(url) {

    const extension =
        url
            .split('?')[0]
            .split('.')
            .pop()
            .toLowerCase();


    let html = '';


    if (

        [
            'jpg',
            'jpeg',
            'png',
            'webp',
            'gif'
        ].includes(extension)

    ) {

        html = `

            <img
                src="${url}"
                alt="Attachment Preview"
                onerror="
                    this.style.display='none';
                    this.nextElementSibling.style.display='block';
                "
            >

            <div
                style="
                    display:none;
                    text-align:center;
                    padding:50px 20px;
                    color:#8fa4ca;
                "
            >

                <i
                    class="fas fa-image"
                    style="
                        font-size:42px;
                        color:#60a5fa;
                        margin-bottom:15px;
                    "
                ></i>

                <p>
                    Unable to preview this image.
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


    else if (extension === 'pdf') {

        html = `

            <iframe
                src="${url}"
                title="PDF Attachment Preview"
            ></iframe>

        `;

    }


    else {

        html = `

            <div
                style="
                    display:flex;
                    flex-direction:column;
                    align-items:center;
                    justify-content:center;
                    min-height:300px;
                    text-align:center;
                    color:#8fa4ca;
                "
            >

                <i
                    class="fas fa-file"
                    style="
                        margin-bottom:15px;
                        color:#60a5fa;
                        font-size:48px;
                    "
                ></i>

                <h4
                    style="
                        margin:0 0 8px;
                        color:#ffffff;
                    "
                >
                    Preview Not Available
                </h4>

                <p>
                    This file type cannot be previewed in the browser.
                </p>

                <a
                    href="${url}"
                    download
                    class="btn btn-success"
                >

                    <i class="fas fa-download"></i>

                    Download File

                </a>

            </div>

        `;

    }


    document
        .getElementById('previewBody')
        .innerHTML = html;


    document
        .getElementById('previewModal')
        .classList.add('show');


    document
        .getElementById('previewModal')
        .setAttribute(
            'aria-hidden',
            'false'
        );


    document.body.style.overflow = 'hidden';

}


/* =========================================================
   SEARCH + FILTER
   ========================================================= */

function filterCadets() {

    const search =
        document
            .getElementById('searchCadet')
            ?.value
            .toLowerCase()
            .trim() || '';


    const batch =
        document
            .getElementById('batchFilter')
            ?.value || '';


    const course =
        document
            .getElementById('courseFilter')
            ?.value
            .toLowerCase() || '';


    const deployment =
        document
            .getElementById('deploymentFilter')
            ?.value
            .toLowerCase() || '';


    document
        .querySelectorAll('.table-custom tbody tr')
        .forEach(row => {

            const matchSearch =
                (row.dataset.name || '')
                    .includes(search);


            const matchBatch =
                !batch ||
                (row.dataset.batch || '') === batch;


            const matchCourse =
                !course ||
                (row.dataset.course || '') === course;


            const matchDeployment =
                !deployment ||
                (row.dataset.deployment || '') === deployment;


            row.style.display =
                (
                    matchSearch &&
                    matchBatch &&
                    matchCourse &&
                    matchDeployment
                )
                    ? ''
                    : 'none';

        });

}


/* =========================================================
   FILTER EVENTS
   ========================================================= */

document
    .getElementById('searchCadet')
    ?.addEventListener(
        'input',
        filterCadets
    );


document
    .getElementById('batchFilter')
    ?.addEventListener(
        'change',
        filterCadets
    );


document
    .getElementById('courseFilter')
    ?.addEventListener(
        'change',
        filterCadets
    );


document
    .getElementById('deploymentFilter')
    ?.addEventListener(
        'change',
        filterCadets
    );

</script>

@endsection