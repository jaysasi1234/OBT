@extends('layouts.superadmin')

@section('content')

<style>

/* ==========================================================================
   CADET MANAGEMENT UI ENHANCEMENT
   CSS ONLY — EXISTING PHP / BLADE / JS REMAIN UNCHANGED
   ========================================================================== */

:root {
    --cadet-bg: #080f24;
    --cadet-bg-secondary: #0b1530;

    --cadet-panel: #101d3d;
    --cadet-panel-light: #162751;
    --cadet-panel-hover: #1a2d5c;

    --cadet-text: #ffffff;
    --cadet-muted: rgba(255, 255, 255, 0.68);

    --cadet-primary: #3b82f6;
    --cadet-primary-dark: #2563eb;
    --cadet-primary-light: #60a5fa;

    --cadet-success: #22c55e;
    --cadet-warning: #f59e0b;
    --cadet-danger: #ef4444;

    --cadet-border: rgba(255, 255, 255, 0.08);
    --cadet-border-light: rgba(255, 255, 255, 0.12);

    --cadet-radius: 14px;

    --cadet-shadow:
        0 15px 40px rgba(0, 0, 0, 0.25);

    --cadet-shadow-hover:
        0 20px 45px rgba(0, 0, 0, 0.34);
}


/* ==========================================================================
   PAGE
   ========================================================================== */

.cadet-page {
    width: 100%;
    min-height: 100vh;

    color: var(--cadet-text);

    background:
        radial-gradient(
            circle at 10% 0%,
            rgba(59, 130, 246, 0.08),
            transparent 30%
        ),
        radial-gradient(
            circle at 90% 10%,
            rgba(37, 99, 235, 0.06),
            transparent 28%
        );

    box-sizing: border-box;
}


/* ==========================================================================
   STICKY CONTROLS
   ========================================================================== */

.cadet-sticky-controls {
    position: sticky;

    top: 75px;

    z-index: 900;

    padding:
        12px
        0
        18px;

    background:
        linear-gradient(
            180deg,
            rgba(8, 15, 36, 0.98) 0%,
            rgba(8, 15, 36, 0.94) 75%,
            rgba(8, 15, 36, 0) 100%
        );

    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}


/* ==========================================================================
   HEADER
   ========================================================================== */

.cadet-header {
    position: relative;

    margin-bottom: 18px;

    padding-left: 4px;
}

.cadet-header::before {
    content: "";

    position: absolute;

    left: -4px;
    top: 3px;

    width: 4px;
    height: 46px;

    border-radius: 999px;

    background:
        linear-gradient(
            180deg,
            var(--cadet-primary-light),
            var(--cadet-primary)
        );

    box-shadow:
        0 0 18px rgba(59, 130, 246, 0.35);
}

.cadet-header h1 {
    margin: 0;

    font-size: 29px;

    font-weight: 800;

    line-height: 1.25;

    letter-spacing: -0.5px;

    color: #ffffff;
}

.cadet-header p {
    margin: 6px 0 0;

    color: var(--cadet-muted);

    font-size: 14px;

    line-height: 1.5;
}


/* ==========================================================================
   FILTERS
   ========================================================================== */

.cadet-filters {
    display: grid;

    grid-template-columns:
        repeat(5, minmax(0, 1fr));

    gap: 11px;

    padding: 16px;

    margin-bottom: 15px;

    background:
        linear-gradient(
            145deg,
            rgba(16, 29, 61, 0.98),
            rgba(13, 25, 54, 0.98)
        );

    border:
        1px solid var(--cadet-border);

    border-radius: var(--cadet-radius);

    box-shadow:
        var(--cadet-shadow);

    position: relative;

    overflow: hidden;
}

.cadet-filters::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;
    right: 0;

    height: 1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(96, 165, 250, 0.45),
            transparent
        );
}

.cadet-filters input,
.cadet-filters select {
    width: 100%;

    height: 44px;

    padding:
        0
        13px;

    border:
        1px solid rgba(255, 255, 255, 0.07);

    border-radius: 9px;

    background:
        rgba(22, 39, 81, 0.88);

    color: var(--cadet-text);

    outline: none;

    font-family: inherit;

    font-size: 13px;

    box-sizing: border-box;

    transition:
        border-color 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease,
        transform 0.2s ease;
}

.cadet-filters input:hover,
.cadet-filters select:hover {
    background:
        rgba(27, 47, 94, 0.95);

    border-color:
        rgba(255, 255, 255, 0.13);
}

.cadet-filters input:focus,
.cadet-filters select:focus {
    border-color:
        var(--cadet-primary);

    background:
        rgba(25, 45, 92, 0.98);

    box-shadow:
        0 0 0 3px rgba(59, 130, 246, 0.16),
        0 5px 15px rgba(0, 0, 0, 0.15);

    transform: translateY(-1px);
}

.cadet-filters input::placeholder {
    color:
        rgba(255, 255, 255, 0.48);
}

.cadet-filters select {
    cursor: pointer;
}

.cadet-filters option {
    background:
        var(--cadet-panel);

    color:
        var(--cadet-text);
}


/* ==========================================================================
   STATISTICS
   ========================================================================== */

.cadet-stats {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 12px;

    margin-bottom: 0;
}

.cadet-stat {
    position: relative;

    min-height: 88px;

    padding: 17px 18px;

    border:
        1px solid rgba(255, 255, 255, 0.08);

    border-radius:
        var(--cadet-radius);

    text-align: left;

    font-size: 13px;

    font-weight: 700;

    line-height: 1.5;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.22);

    overflow: hidden;

    transition:
        transform 0.22s ease,
        box-shadow 0.22s ease,
        border-color 0.22s ease;
}

.cadet-stat::before {
    content: "";

    position: absolute;

    top: -35px;
    right: -25px;

    width: 100px;
    height: 100px;

    border-radius: 50%;

    background:
        rgba(255, 255, 255, 0.10);
}

.cadet-stat::after {
    content: "";

    position: absolute;

    left: 0;
    right: 0;
    bottom: 0;

    height: 3px;

    background:
        rgba(255, 255, 255, 0.25);
}

.cadet-stat:hover {
    transform:
        translateY(-4px);

    box-shadow:
        var(--cadet-shadow-hover);

    border-color:
        rgba(255, 255, 255, 0.16);
}

.cadet-stat-value {
    display: block;

    margin-top: 7px;

    font-size: 27px;

    font-weight: 800;

    line-height: 1;

    letter-spacing: -0.5px;
}

.cadet-stat-blue {
    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );
}

.cadet-stat-green {
    background:
        linear-gradient(
            135deg,
            #22c55e,
            #16a34a
        );
}

.cadet-stat-yellow {
    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #d97706
        );

    color: #ffffff;
}

.cadet-stat-red {
    background:
        linear-gradient(
            135deg,
            #ef4444,
            #dc2626
        );
}


/* ==========================================================================
   TABLE CONTAINER
   ========================================================================== */

.cadet-table-wrapper {
    width: 100%;

    background:
        linear-gradient(
            145deg,
            rgba(16, 29, 61, 0.98),
            rgba(11, 22, 47, 0.98)
        );

    border:
        1px solid var(--cadet-border);

    border-radius:
        var(--cadet-radius);

    padding: 8px;

    overflow-x: auto;

    -webkit-overflow-scrolling: touch;

    box-shadow:
        var(--cadet-shadow);

    box-sizing: border-box;

    position: relative;
}

.cadet-table-wrapper::before {
    content: "";

    position: absolute;

    top: 0;
    left: 15%;
    right: 15%;

    height: 1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(96, 165, 250, 0.35),
            transparent
        );

    pointer-events: none;
}


/* ==========================================================================
   TABLE
   ========================================================================== */

.cadet-table {
    width: 100%;

    min-width: 900px;

    border-collapse: separate;

    border-spacing: 0;

    color:
        var(--cadet-text);
}

.cadet-table thead {
    background:
        linear-gradient(
            180deg,
            rgba(27, 47, 94, 0.98),
            rgba(22, 39, 81, 0.98)
        );
}

.cadet-table th {
    padding:
        14px
        13px;

    color:
        rgba(255, 255, 255, 0.92);

    font-size: 11px;

    font-weight: 800;

    text-align: left;

    text-transform: uppercase;

    letter-spacing: 0.55px;

    white-space: nowrap;

    border-bottom:
        1px solid var(--cadet-border-light);
}

.cadet-table th:first-child {
    border-top-left-radius: 8px;
}

.cadet-table th:last-child {
    border-top-right-radius: 8px;
}

.cadet-table td {
    padding:
        14px
        13px;

    color:
        rgba(255, 255, 255, 0.88);

    font-size: 13px;

    white-space: nowrap;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.055);

    transition:
        color 0.18s ease,
        background 0.18s ease;
}

.cadet-table tbody tr {
    transition:
        transform 0.18s ease,
        background 0.18s ease;
}

.cadet-table tbody tr:hover {
    background:
        rgba(59, 130, 246, 0.075);
}

.cadet-table tbody tr:hover td {
    color:
        #ffffff;

    background:
        rgba(59, 130, 246, 0.045);
}

.cadet-table tbody tr:last-child td {
    border-bottom: none;
}

.cadet-table-empty {
    text-align: center;

    padding:
        45px
        30px !important;

    color:
        var(--cadet-muted);

    font-size: 14px !important;
}


/* ==========================================================================
   STATUS BADGES
   ========================================================================== */

.cadet-status {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    padding:
        6px
        11px;

    border-radius:
        999px;

    font-size: 11px;

    font-weight: 800;

    line-height: 1;

    white-space: nowrap;

    border:
        1px solid rgba(255, 255, 255, 0.08);

    box-shadow:
        0 3px 10px rgba(0, 0, 0, 0.12);
}

.cadet-status::before {
    content: "";

    width: 6px;
    height: 6px;

    flex-shrink: 0;

    border-radius: 50%;

    background:
        currentColor;

    opacity: 0.9;
}


/* VERIFICATION */

.cadet-status-verified {
    background:
        rgba(34, 197, 94, 0.18);

    color:
        #4ade80;

    border-color:
        rgba(34, 197, 94, 0.25);
}

.cadet-status-pending {
    background:
        rgba(245, 158, 11, 0.18);

    color:
        #fbbf24;

    border-color:
        rgba(245, 158, 11, 0.25);
}

.cadet-status-deficiency {
    background:
        rgba(239, 68, 68, 0.18);

    color:
        #f87171;

    border-color:
        rgba(239, 68, 68, 0.25);
}


/* DEPLOYMENT */

.cadet-status-not-deployed {
    background:
        rgba(245, 158, 11, 0.18);

    color:
        #fbbf24;

    border-color:
        rgba(245, 158, 11, 0.25);
}

.cadet-status-ongoing {
    background:
        rgba(59, 130, 246, 0.18);

    color:
        #60a5fa;

    border-color:
        rgba(59, 130, 246, 0.25);
}

.cadet-status-completed {
    background:
        rgba(34, 197, 94, 0.18);

    color:
        #4ade80;

    border-color:
        rgba(34, 197, 94, 0.25);
}


/* ==========================================================================
   VIEW BUTTON
   ========================================================================== */

.cadet-view-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 65px;

    padding:
        8px
        13px;

    border:
        1px solid rgba(96, 165, 250, 0.2);

    border-radius: 8px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );

    color: #fff;

    font-family: inherit;

    font-size: 12px;

    font-weight: 700;

    cursor: pointer;

    box-shadow:
        0 5px 14px rgba(37, 99, 235, 0.22);

    transition:
        background 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.cadet-view-btn:hover {
    background:
        linear-gradient(
            135deg,
            #60a5fa,
            #2563eb
        );

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 18px rgba(37, 99, 235, 0.32);
}

.cadet-view-btn:active {
    transform:
        translateY(0);
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
        rgba(2, 6, 23, 0.82);

    backdrop-filter:
        blur(8px);

    -webkit-backdrop-filter:
        blur(8px);

    z-index: 9999;

    box-sizing: border-box;
}

.cadet-modal-overlay.show {
    display: flex;

    animation:
        cadetOverlayIn 0.2s ease;
}

@keyframes cadetOverlayIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}


/* ==========================================================================
   MODAL
   ========================================================================== */

.cadet-modal {
    width: 680px;

    max-width: 100%;

    max-height: 90vh;

    overflow-y: auto;

    background:
        linear-gradient(
            145deg,
            #111f42,
            #0d1935
        );

    color: #fff;

    border:
        1px solid rgba(255, 255, 255, 0.10);

    border-radius:
        20px;

    box-shadow:
        0 30px 90px rgba(0, 0, 0, 0.60),
        0 0 0 1px rgba(59, 130, 246, 0.04);

    animation:
        cadetModalOpen 0.22s ease;

    scrollbar-width: thin;

    scrollbar-color:
        rgba(96, 165, 250, 0.45)
        transparent;
}

.cadet-modal::-webkit-scrollbar {
    width: 7px;
}

.cadet-modal::-webkit-scrollbar-track {
    background: transparent;
}

.cadet-modal::-webkit-scrollbar-thumb {
    background:
        rgba(96, 165, 250, 0.4);

    border-radius:
        999px;
}

.cadet-modal::-webkit-scrollbar-thumb:hover {
    background:
        rgba(96, 165, 250, 0.65);
}

@keyframes cadetModalOpen {
    from {
        opacity: 0;

        transform:
            translateY(18px)
            scale(0.96);
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

    padding:
        19px
        22px;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.075);

    background:
        linear-gradient(
            135deg,
            rgba(22, 39, 81, 0.98),
            rgba(17, 32, 66, 0.98)
        );

    position: sticky;

    top: 0;

    z-index: 5;
}

.cadet-modal-title {
    display: flex;

    align-items: center;

    gap: 12px;

    min-width: 0;
}

.cadet-modal-title-icon {
    width: 44px;
    height: 44px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );

    font-size: 19px;

    box-shadow:
        0 7px 18px rgba(37, 99, 235, 0.25);
}

.cadet-modal-title-text {
    min-width: 0;
}

.cadet-modal-title-text h2 {
    margin: 0;

    font-size: 20px;

    font-weight: 800;

    line-height: 1.25;
}

.cadet-modal-title-text p {
    margin: 4px 0 0;

    color:
        rgba(255, 255, 255, 0.55);

    font-size: 11px;

    line-height: 1.4;
}

.cadet-modal-close {
    width: 38px;
    height: 38px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border:
        1px solid rgba(255, 255, 255, 0.08);

    border-radius: 10px;

    background:
        rgba(255, 255, 255, 0.07);

    color: #fff;

    font-size: 21px;

    line-height: 1;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease,
        border-color 0.2s ease;
}

.cadet-modal-close:hover {
    background:
        rgba(239, 68, 68, 0.9);

    border-color:
        rgba(239, 68, 68, 0.9);

    transform:
        rotate(3deg) scale(1.04);
}


/* ==========================================================================
   PROFILE SECTION
   ========================================================================== */

.cadet-profile-section {
    display: flex;

    align-items: center;

    gap: 20px;

    padding:
        25px;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.075);

    background:
        radial-gradient(
            circle at 0% 50%,
            rgba(59, 130, 246, 0.08),
            transparent 45%
        );
}

.cadet-modal-photo {
    width: 118px;
    height: 118px;

    flex-shrink: 0;

    object-fit: cover;

    border-radius: 18px;

    border:
        3px solid rgba(96, 165, 250, 0.9);

    background:
        var(--cadet-panel-light);

    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.35),
        0 0 0 5px rgba(59, 130, 246, 0.07);

    transition:
        transform 0.25s ease,
        box-shadow 0.25s ease;
}

.cadet-modal-photo:hover {
    transform:
        translateY(-2px);

    box-shadow:
        0 16px 35px rgba(0, 0, 0, 0.40),
        0 0 0 6px rgba(59, 130, 246, 0.10);
}

.cadet-profile-info {
    min-width: 0;
}

.cadet-profile-name {
    margin:
        0 0 9px;

    font-size: 24px;

    font-weight: 800;

    line-height: 1.25;

    word-break: break-word;
}

.cadet-profile-trb {
    display: inline-flex;

    align-items: center;

    padding:
        7px
        12px;

    border:
        1px solid rgba(96, 165, 250, 0.18);

    border-radius:
        999px;

    background:
        rgba(59, 130, 246, 0.13);

    color:
        #60a5fa;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 0.25px;
}


/* ==========================================================================
   DETAILS SECTION
   ========================================================================== */

.cadet-details-section {
    padding:
        24px;
}

.cadet-details-title {
    display: flex;

    align-items: center;

    gap: 9px;

    margin:
        0 0 15px;

    font-size: 14px;

    font-weight: 800;

    color:
        #ffffff;
}

.cadet-details-title::before {
    content: "";

    width: 4px;
    height: 18px;

    border-radius:
        999px;

    background:
        var(--cadet-primary);
}

.cadet-details-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 11px;
}

.cadet-detail-card {
    position: relative;

    min-width: 0;

    padding:
        15px;

    border-radius:
        12px;

    background:
        linear-gradient(
            145deg,
            rgba(22, 39, 81, 0.92),
            rgba(18, 34, 70, 0.92)
        );

    border:
        1px solid rgba(255, 255, 255, 0.06);

    transition:
        border-color 0.2s ease,
        transform 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease;
}

.cadet-detail-card::after {
    content: "";

    position: absolute;

    top: 12px;
    right: 12px;

    width: 5px;
    height: 5px;

    border-radius: 50%;

    background:
        rgba(96, 165, 250, 0.45);
}

.cadet-detail-card:hover {
    border-color:
        rgba(59, 130, 246, 0.38);

    background:
        linear-gradient(
            145deg,
            rgba(26, 48, 96, 0.96),
            rgba(20, 40, 82, 0.96)
        );

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.16);
}

.cadet-detail-label {
    display: block;

    margin-bottom: 6px;

    color:
        rgba(255, 255, 255, 0.48);

    font-size: 10px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: 0.65px;
}

.cadet-detail-value {
    display: block;

    color:
        #ffffff;

    font-size: 13px;

    font-weight: 650;

    line-height: 1.45;

    word-break: break-word;
}


/* ==========================================================================
   MODAL FOOTER
   ========================================================================== */

.cadet-modal-footer {
    display: flex;

    justify-content: flex-end;

    padding:
        14px
        24px;

    border-top:
        1px solid rgba(255, 255, 255, 0.075);

    background:
        rgba(5, 12, 28, 0.28);

    position: sticky;

    bottom: 0;

    z-index: 5;
}

.cadet-modal-close-btn {
    min-width: 90px;

    padding:
        9px
        18px;

    border:
        1px solid rgba(255, 255, 255, 0.08);

    border-radius: 9px;

    background:
        rgba(255, 255, 255, 0.07);

    color: #fff;

    font-family: inherit;

    font-size: 12px;

    font-weight: 700;

    cursor: pointer;

    transition:
        background 0.2s ease,
        transform 0.2s ease,
        border-color 0.2s ease;
}

.cadet-modal-close-btn:hover {
    background:
        rgba(239, 68, 68, 0.9);

    border-color:
        rgba(239, 68, 68, 0.9);

    transform:
        translateY(-1px);
}


/* ==========================================================================
   TABLE SCROLLBAR
   ========================================================================== */

.cadet-table-wrapper {
    scrollbar-width: thin;

    scrollbar-color:
        rgba(96, 165, 250, 0.35)
        transparent;
}

.cadet-table-wrapper::-webkit-scrollbar {
    height: 7px;
}

.cadet-table-wrapper::-webkit-scrollbar-track {
    background:
        rgba(255, 255, 255, 0.025);

    border-radius:
        999px;
}

.cadet-table-wrapper::-webkit-scrollbar-thumb {
    background:
        rgba(96, 165, 250, 0.35);

    border-radius:
        999px;
}

.cadet-table-wrapper::-webkit-scrollbar-thumb:hover {
    background:
        rgba(96, 165, 250, 0.55);
}


/* ==========================================================================
   FOCUS ACCESSIBILITY
   ========================================================================== */

.cadet-view-btn:focus-visible,
.cadet-modal-close:focus-visible,
.cadet-modal-close-btn:focus-visible,
.cadet-filters input:focus-visible,
.cadet-filters select:focus-visible {
    outline:
        2px solid #60a5fa;

    outline-offset:
        2px;
}


/* ==========================================================================
   RESPONSIVE — LARGE TABLET
   ========================================================================== */

@media (max-width: 1200px) {

    .cadet-filters {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

}


/* ==========================================================================
   RESPONSIVE — TABLET
   ========================================================================== */

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


/* ==========================================================================
   RESPONSIVE — MOBILE
   ========================================================================== */

@media (max-width: 768px) {

    .cadet-sticky-controls {
        top: 75px;

        padding:
            10px
            0
            12px;
    }

    .cadet-header {
        margin-bottom: 14px;
    }

    .cadet-header h1 {
        font-size: 24px;
    }

    .cadet-header p {
        font-size: 13px;
    }

    .cadet-filters {
        grid-template-columns: 1fr;

        gap: 9px;

        padding: 12px;
    }

    .cadet-stats {
        grid-template-columns: 1fr;

        gap: 9px;
    }

    .cadet-stat {
        min-height: 76px;

        padding:
            14px
            16px;
    }

    .cadet-stat-value {
        font-size: 24px;
    }

    .cadet-table-wrapper {
        padding: 7px;

        border-radius:
            12px;
    }

    .cadet-table {
        min-width: 850px;
    }

    .cadet-modal-overlay {
        align-items: center;

        padding:
            12px;
    }

    .cadet-modal {
        width: 100%;

        max-height:
            calc(100vh - 24px);

        border-radius:
            16px;
    }

    .cadet-modal-header {
        padding:
            15px;
    }

    .cadet-modal-title-icon {
        width: 40px;
        height: 40px;

        border-radius:
            11px;

        font-size: 17px;
    }

    .cadet-modal-title-text h2 {
        font-size: 17px;
    }

    .cadet-profile-section {
        flex-direction: column;

        text-align: center;

        padding:
            21px
            16px;
    }

    .cadet-modal-photo {
        width: 105px;
        height: 105px;
    }

    .cadet-profile-name {
        font-size: 20px;
    }

    .cadet-details-section {
        padding:
            18px
            15px;
    }

    .cadet-details-grid {
        grid-template-columns:
            1fr;
    }

    .cadet-modal-footer {
        padding:
            11px
            15px;
    }

    .cadet-modal-close-btn {
        width: 100%;
    }

}


/* ==========================================================================
   RESPONSIVE — SMALL MOBILE
   ========================================================================== */

@media (max-width: 480px) {

    .cadet-header {
        padding-left: 3px;
    }

    .cadet-header::before {
        height: 39px;
    }

    .cadet-header h1 {
        font-size: 21px;
    }

    .cadet-header p {
        font-size: 12px;
    }

    .cadet-filters {
        border-radius:
            12px;
    }

    .cadet-filters input,
    .cadet-filters select {
        height: 42px;
    }

    .cadet-stat {
        border-radius:
            12px;
    }

    .cadet-stat-value {
        font-size: 22px;
    }

    .cadet-modal-title {
        gap: 9px;
    }

    .cadet-modal-title-icon {
        width: 36px;
        height: 36px;

        font-size: 15px;
    }

    .cadet-modal-title-text h2 {
        font-size: 16px;
    }

    .cadet-modal-title-text p {
        display: none;
    }

    .cadet-modal-close {
        width: 34px;
        height: 34px;

        font-size: 18px;
    }

    .cadet-profile-name {
        font-size: 19px;
    }

    .cadet-details-title {
        font-size: 13px;
    }

}


/* ==========================================================================
   REDUCED MOTION
   ========================================================================== */

@media (prefers-reduced-motion: reduce) {

    .cadet-stat,
    .cadet-view-btn,
    .cadet-modal,
    .cadet-modal-photo,
    .cadet-detail-card,
    .cadet-modal-close,
    .cadet-modal-close-btn,
    .cadet-filters input,
    .cadet-filters select {
        transition: none !important;

        animation: none !important;
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