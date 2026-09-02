@extends('layouts.superadmin')

@section('content')

<style>

/* ==========================================================================
   SUPER ADMIN CADET MANAGEMENT
   MATCHES ADMIN CADet MANAGEMENT UI
   CSS-ONLY ENHANCEMENT
   ========================================================================== */

:root {
    --cadet-bg: #07112f;
    --cadet-bg-deep: #050b20;

    --cadet-panel: #0f1b42;
    --cadet-panel-2: #121f4d;
    --cadet-panel-3: #17285d;

    --cadet-primary: #3b82f6;
    --cadet-primary-dark: #2563eb;

    --cadet-success: #22c55e;
    --cadet-warning: #f59e0b;
    --cadet-danger: #ef4444;
    --cadet-cyan: #06b6d4;

    --cadet-text: #f8fafc;
    --cadet-muted: #94a3b8;

    --cadet-border: rgba(255, 255, 255, 0.08);

    --cadet-shadow:
        0 20px 50px rgba(0, 0, 0, 0.30);

    --cadet-transition:
        0.22s cubic-bezier(0.4, 0, 0.2, 1);

    --cadet-radius: 18px;
}


/* ==========================================================================
   PAGE
   ========================================================================== */

.cadet-page {
    position: relative;

    width: 100%;
    min-width: 0;
    min-height: 100vh;
    min-height: 100dvh;

    padding: 28px;

    color: var(--cadet-text);

    background:
        radial-gradient(
            circle at 10% 5%,
            rgba(59, 130, 246, 0.12),
            transparent 30%
        ),
        radial-gradient(
            circle at 90% 10%,
            rgba(6, 182, 212, 0.07),
            transparent 25%
        );
}


/* ==========================================================================
   SUBTLE BACKGROUND GRID
   ========================================================================== */

.cadet-page::before {
    content: "";

    position: absolute;

    inset: 0;

    z-index: -1;

    pointer-events: none;

    opacity: 0.35;

    background:
        linear-gradient(
            90deg,
            rgba(59, 130, 246, 0.025) 1px,
            transparent 1px
        ),
        linear-gradient(
            rgba(59, 130, 246, 0.025) 1px,
            transparent 1px
        );

    background-size:
        32px 32px;
}


/* ==========================================================================
   STICKY CONTROLS
   ========================================================================== */

.cadet-sticky-controls {
    position: sticky;

    top: 75px;

    z-index: 900;

    padding: 6px 0 18px;

    background:
        linear-gradient(
            to bottom,
            rgba(7, 17, 47, 0.98),
            rgba(7, 17, 47, 0.92),
            rgba(7, 17, 47, 0)
        );

    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}


/* ==========================================================================
   HEADER
   ========================================================================== */

.cadet-header {
    position: relative;

    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 16px;

    padding: 22px 24px;

    border:
        1px solid var(--cadet-border);

    border-radius: var(--cadet-radius);

    background:
        linear-gradient(
            135deg,
            rgba(15, 27, 66, 0.98),
            rgba(18, 31, 77, 0.94)
        );

    box-shadow:
        0 14px 35px rgba(0, 0, 0, 0.22);

    overflow: hidden;
}

.cadet-header::after {
    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 2px;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #3b82f6,
            #06b6d4
        );

    opacity: 0.9;
}

.cadet-header h1 {
    margin: 0;

    font-size: 26px;

    font-weight: 800;

    line-height: 1.2;

    letter-spacing: -0.4px;
}

.cadet-header h1::before {
    content: "●";

    display: inline-block;

    margin-right: 10px;

    color: var(--cadet-primary);

    font-size: 13px;

    vertical-align: middle;

    text-shadow:
        0 0 12px rgba(59, 130, 246, 0.8);
}

.cadet-header p {
    margin: 7px 0 0;

    color: var(--cadet-muted);

    font-size: 12px;

    line-height: 1.5;
}


/* ==========================================================================
   FILTER PANEL
   ========================================================================== */

.cadet-filters {
    position: relative;

    display: grid;

    grid-template-columns:
        repeat(5, minmax(0, 1fr));

    gap: 10px;

    padding: 16px;

    margin-bottom: 14px;

    border:
        1px solid var(--cadet-border);

    border-radius: 16px;

    background:
        linear-gradient(
            135deg,
            rgba(15, 27, 66, 0.98),
            rgba(18, 31, 77, 0.96)
        );

    box-shadow:
        0 14px 35px rgba(0, 0, 0, 0.20);
}

.cadet-filters::before {
    content: "";

    position: absolute;

    left: 16px;
    right: 16px;
    top: 0;

    height: 1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(59, 130, 246, 0.5),
            transparent
        );
}


/* ==========================================================================
   FILTER INPUTS
   ========================================================================== */

.cadet-filters input,
.cadet-filters select {
    width: 100%;

    height: 42px;

    min-width: 0;

    padding:
        0 12px;

    border:
        1px solid rgba(255, 255, 255, 0.07);

    border-radius: 9px;

    outline: none;

    background:
        #17285d;

    color: #f8fafc;

    font-size: 12px;
    font-weight: 600;

    box-sizing: border-box;

    transition:
        border-color var(--cadet-transition),
        background var(--cadet-transition),
        box-shadow var(--cadet-transition),
        transform var(--cadet-transition);
}

.cadet-filters input:hover,
.cadet-filters select:hover {
    border-color:
        rgba(59, 130, 246, 0.30);

    background:
        #1a2d67;
}

.cadet-filters input:focus,
.cadet-filters select:focus {
    border-color:
        rgba(59, 130, 246, 0.85);

    background:
        #192d68;

    box-shadow:
        0 0 0 3px
        rgba(59, 130, 246, 0.13),
        0 7px 18px
        rgba(0, 0, 0, 0.15);

    transform: translateY(-1px);
}

.cadet-filters input::placeholder {
    color:
        #64748b;
}

.cadet-filters option {
    background:
        #0f1b42;

    color:
        #f8fafc;
}

.cadet-filters select {
    cursor: pointer;
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

    min-width: 0;

    min-height: 105px;

    display: flex;

    flex-direction: column;

    justify-content: center;

    padding: 18px 20px;

    border:
        1px solid rgba(255, 255, 255, 0.07);

    border-radius: 16px;

    overflow: hidden;

    text-align: left;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 0.7px;

    box-shadow:
        0 15px 35px rgba(0, 0, 0, 0.22);

    transition:
        transform var(--cadet-transition),
        box-shadow var(--cadet-transition),
        border-color var(--cadet-transition);
}

.cadet-stat::after {
    content: "";

    position: absolute;

    width: 85px;
    height: 85px;

    right: -25px;
    bottom: -30px;

    border-radius: 50%;

    background:
        rgba(255, 255, 255, 0.10);

    pointer-events: none;
}

.cadet-stat:hover {
    transform:
        translateY(-3px);

    box-shadow:
        0 20px 42px rgba(0, 0, 0, 0.30);

    border-color:
        rgba(255, 255, 255, 0.14);
}

.cadet-stat-value {
    display: block;

    margin-top: 7px;

    font-size: 28px;

    font-weight: 800;

    line-height: 1;

    letter-spacing: -0.7px;
}

.cadet-stat-blue {
    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );
}

.cadet-stat-green {
    background:
        linear-gradient(
            135deg,
            #16a34a,
            #15803d
        );
}

.cadet-stat-yellow {
    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #d97706
        );

    color: #fff;
}

.cadet-stat-red {
    background:
        linear-gradient(
            135deg,
            #dc2626,
            #b91c1c
        );
}


/* ==========================================================================
   TABLE CONTAINER
   ========================================================================== */

.cadet-table-wrapper {
    position: relative;

    width: 100%;

    margin-top: 16px;

    padding: 0;

    overflow-x: auto;

    -webkit-overflow-scrolling: touch;

    border:
        1px solid var(--cadet-border);

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            rgba(15, 27, 66, 0.98),
            rgba(10, 22, 52, 0.98)
        );

    box-shadow:
        var(--cadet-shadow);

    scrollbar-width: thin;

    scrollbar-color:
        #334155
        transparent;
}

.cadet-table-wrapper::-webkit-scrollbar {
    height: 7px;
}

.cadet-table-wrapper::-webkit-scrollbar-track {
    background:
        rgba(255, 255, 255, 0.025);
}

.cadet-table-wrapper::-webkit-scrollbar-thumb {
    border-radius: 20px;

    background:
        #334155;
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
        #121f4d;
}

.cadet-table th {
    padding:
        14px 16px;

    color:
        #94a3b8;

    font-size: 10px;

    font-weight: 800;

    text-align: left;

    text-transform: uppercase;

    letter-spacing: 0.7px;

    white-space: nowrap;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.07);
}

.cadet-table th:first-child {
    border-top-left-radius: 18px;
}

.cadet-table th:last-child {
    border-top-right-radius: 18px;
}

.cadet-table td {
    padding:
        14px 16px;

    color:
        #e2e8f0;

    font-size: 13px;

    font-weight: 500;

    white-space: nowrap;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.055);
}

.cadet-table tbody tr {
    background:
        transparent;

    transition:
        background var(--cadet-transition),
        transform var(--cadet-transition);
}

.cadet-table tbody tr:hover {
    background:
        rgba(59, 130, 246, 0.075);
}

.cadet-table tbody tr:last-child td {
    border-bottom: none;
}

.cadet-table tbody tr:hover td {
    color:
        #f8fafc;
}


/* ==========================================================================
   FIRST COLUMN / TRB
   ========================================================================== */

.cadet-table td:first-child {
    color:
        #93c5fd;

    font-family:
        ui-monospace,
        SFMono-Regular,
        Menlo,
        Monaco,
        Consolas,
        monospace;

    font-size: 12px;

    font-weight: 700;
}


/* ==========================================================================
   NAME COLUMN
   ========================================================================== */

.cadet-table td:nth-child(2) {
    color:
        #fff;

    font-weight: 700;
}


/* ==========================================================================
   COURSE
   ========================================================================== */

.cadet-table td:nth-child(3) {
    color:
        #cbd5e1;

    font-weight: 600;
}


/* ==========================================================================
   EMPTY STATE
   ========================================================================== */

.cadet-table-empty {
    padding:
        65px 25px !important;

    color:
        #64748b !important;

    text-align: center !important;

    font-size: 13px !important;

    border-bottom: none !important;
}


/* ==========================================================================
   STATUS BADGES
   ========================================================================== */

.cadet-status {
    position: relative;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    min-height: 27px;

    padding:
        6px 10px;

    border:
        1px solid transparent;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 800;

    line-height: 1;

    white-space: nowrap;

    letter-spacing: 0.2px;
}

.cadet-status::before {
    content: "";

    width: 6px;
    height: 6px;

    flex-shrink: 0;

    border-radius: 50%;

    background:
        currentColor;

    box-shadow:
        0 0 7px currentColor;
}


/* ==========================================================================
   VERIFICATION
   ========================================================================== */

.cadet-status-verified {
    background:
        rgba(34, 197, 94, 0.12);

    border-color:
        rgba(34, 197, 94, 0.18);

    color:
        #4ade80;
}

.cadet-status-pending {
    background:
        rgba(245, 158, 11, 0.13);

    border-color:
        rgba(245, 158, 11, 0.20);

    color:
        #fbbf24;
}

.cadet-status-deficiency {
    background:
        rgba(239, 68, 68, 0.13);

    border-color:
        rgba(239, 68, 68, 0.20);

    color:
        #f87171;
}


/* ==========================================================================
   DEPLOYMENT
   ========================================================================== */

.cadet-status-not-deployed {
    background:
        rgba(148, 163, 184, 0.12);

    border-color:
        rgba(148, 163, 184, 0.16);

    color:
        #cbd5e1;
}

.cadet-status-ongoing {
    background:
        rgba(59, 130, 246, 0.13);

    border-color:
        rgba(59, 130, 246, 0.20);

    color:
        #60a5fa;
}

.cadet-status-completed {
    background:
        rgba(34, 197, 94, 0.12);

    border-color:
        rgba(34, 197, 94, 0.18);

    color:
        #4ade80;
}


/* ==========================================================================
   VIEW BUTTON
   ========================================================================== */

.cadet-view-btn {
    height: 34px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    padding:
        0 12px;

    border:
        1px solid transparent;

    border-radius: 8px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    color:
        #fff;

    font-size: 11px;

    font-weight: 800;

    cursor: pointer;

    box-shadow:
        0 6px 15px
        rgba(37, 99, 235, 0.20);

    transition:
        transform var(--cadet-transition),
        background var(--cadet-transition),
        box-shadow var(--cadet-transition);
}

.cadet-view-btn::before {
    content: "\f06e";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    font-size: 10px;
}

.cadet-view-btn:hover {
    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );

    transform:
        translateY(-1px);

    box-shadow:
        0 9px 22px
        rgba(37, 99, 235, 0.34);
}

.cadet-view-btn:active {
    transform:
        translateY(0);
}

.cadet-view-btn:focus-visible {
    outline: none;

    box-shadow:
        0 0 0 3px
        rgba(59, 130, 246, 0.20),
        0 8px 20px
        rgba(37, 99, 235, 0.30);
}


/* ==========================================================================
   MODAL OVERLAY
   ========================================================================== */

.cadet-modal-overlay {
    position: fixed;

    inset: 0;

    z-index: 100000;

    display: none;

    align-items: center;
    justify-content: center;

    width: 100%;
    height: 100%;

    padding: 20px;

    overflow: hidden;

    background:
        rgba(2, 6, 23, 0.84);

    backdrop-filter:
        blur(8px);

    -webkit-backdrop-filter:
        blur(8px);

    box-sizing: border-box;
}

.cadet-modal-overlay.show {
    display: flex;

    animation:
        cadetModalFadeIn 0.2s ease;
}

@keyframes cadetModalFadeIn {
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
    position: relative;

    display: flex;

    flex-direction: column;

    width:
        min(920px, 100%);

    max-width: 920px;

    max-height:
        calc(100dvh - 40px);

    overflow: hidden;

    border:
        1px solid
        rgba(255, 255, 255, 0.09);

    border-radius: 18px;

    background:
        linear-gradient(
            145deg,
            #0f1b42,
            #0b1738
        );

    color:
        #fff;

    box-shadow:
        0 30px 80px
        rgba(0, 0, 0, 0.55);

    animation:
        cadetModalOpen 0.22s
        cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes cadetModalOpen {
    from {
        opacity: 0;

        transform:
            translateY(14px)
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
    position: relative;

    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    flex: 0 0 auto;

    min-height: 76px;

    padding:
        16px 22px;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.07);

    background:
        #121f4d;
}

.cadet-modal-header::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;

    width: 100%;
    height: 2px;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #3b82f6,
            #06b6d4
        );
}

.cadet-modal-title {
    display: flex;

    align-items: center;

    gap: 11px;

    min-width: 0;
}

.cadet-modal-title-icon {
    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border:
        1px solid
        rgba(96, 165, 250, 0.22);

    border-radius: 11px;

    background:
        rgba(59, 130, 246, 0.14);

    color:
        #60a5fa;

    font-size: 18px;

    box-shadow:
        inset 0 0 20px
        rgba(59, 130, 246, 0.07);
}

.cadet-modal-title-text {
    min-width: 0;
}

.cadet-modal-title-text h2 {
    margin: 0;

    color:
        #f8fafc;

    font-size: 18px;

    font-weight: 800;

    line-height: 1.25;
}

.cadet-modal-title-text p {
    margin: 3px 0 0;

    color:
        #64748b;

    font-size: 10px;

    line-height: 1.4;
}

.cadet-modal-close {
    width: 36px;
    height: 36px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border:
        1px solid
        rgba(255, 255, 255, 0.07);

    border-radius: 9px;

    background:
        rgba(255, 255, 255, 0.06);

    color:
        #94a3b8;

    font-size: 19px;

    line-height: 1;

    cursor: pointer;

    transition:
        var(--cadet-transition);
}

.cadet-modal-close:hover {
    border-color:
        rgba(239, 68, 68, 0.25);

    background:
        rgba(239, 68, 68, 0.15);

    color:
        #f87171;

    transform:
        rotate(2deg);
}


/* ==========================================================================
   PROFILE
   ========================================================================== */

.cadet-profile-section {
    display: flex;

    align-items: center;

    gap: 18px;

    flex: 0 0 auto;

    padding:
        20px 22px;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.06);

    background:
        rgba(11, 23, 56, 0.75);
}

.cadet-modal-photo {
    width: 105px;
    height: 105px;

    flex-shrink: 0;

    object-fit: cover;

    border:
        2px solid
        rgba(59, 130, 246, 0.55);

    border-radius: 15px;

    background:
        #17285d;

    box-shadow:
        0 12px 28px
        rgba(0, 0, 0, 0.30),
        0 0 0 5px
        rgba(59, 130, 246, 0.06);
}

.cadet-profile-info {
    min-width: 0;
}

.cadet-profile-name {
    margin:
        0 0 9px;

    color:
        #fff;

    font-size: 22px;

    font-weight: 800;

    line-height: 1.2;

    word-break: break-word;
}

.cadet-profile-trb {
    display: inline-flex;

    align-items: center;

    min-height: 27px;

    padding:
        6px 10px;

    border:
        1px solid
        rgba(59, 130, 246, 0.18);

    border-radius: 20px;

    background:
        rgba(59, 130, 246, 0.11);

    color:
        #93c5fd;

    font-family:
        ui-monospace,
        SFMono-Regular,
        Menlo,
        Monaco,
        Consolas,
        monospace;

    font-size: 11px;

    font-weight: 800;
}


/* ==========================================================================
   DETAILS
   ========================================================================== */

.cadet-details-section {
    flex: 1 1 auto;

    min-height: 0;

    padding:
        20px 22px;

    overflow-y: auto;

    scrollbar-width: thin;

    scrollbar-color:
        #334155 transparent;
}

.cadet-details-section::-webkit-scrollbar {
    width: 6px;
}

.cadet-details-section::-webkit-scrollbar-thumb {
    border-radius: 20px;

    background:
        #334155;
}

.cadet-details-title {
    display: flex;

    align-items: center;

    gap: 8px;

    margin:
        0 0 13px;

    color:
        #f8fafc;

    font-size: 13px;

    font-weight: 800;
}

.cadet-details-title::before {
    content: "";

    width: 3px;
    height: 16px;

    border-radius: 10px;

    background:
        #3b82f6;

    box-shadow:
        0 0 10px
        rgba(59, 130, 246, 0.6);
}

.cadet-details-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 10px;
}

.cadet-detail-card {
    position: relative;

    min-width: 0;

    padding:
        13px 14px;

    border:
        1px solid
        rgba(255, 255, 255, 0.06);

    border-radius: 11px;

    background:
        #121f4d;

    transition:
        var(--cadet-transition);
}

.cadet-detail-card:hover {
    border-color:
        rgba(59, 130, 246, 0.28);

    background:
        #17285d;

    transform:
        translateY(-1px);

    box-shadow:
        0 8px 18px
        rgba(0, 0, 0, 0.16);
}

.cadet-detail-label {
    display: block;

    margin-bottom: 5px;

    color:
        #64748b;

    font-size: 9px;

    font-weight: 800;

    line-height: 1.3;

    text-transform: uppercase;

    letter-spacing: 0.7px;
}

.cadet-detail-value {
    display: block;

    color:
        #e2e8f0;

    font-size: 12px;

    font-weight: 700;

    line-height: 1.4;

    word-break: break-word;
}


/* ==========================================================================
   MODAL FOOTER
   ========================================================================== */

.cadet-modal-footer {
    display: flex;

    align-items: center;
    justify-content: flex-end;

    gap: 10px;

    flex: 0 0 auto;

    min-width: 0;

    padding:
        14px 22px;

    border-top:
        1px solid
        rgba(255, 255, 255, 0.07);

    background:
        #0b1738;
}

.cadet-modal-close-btn {
    min-height: 40px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding:
        0 17px;

    border:
        1px solid
        rgba(255, 255, 255, 0.07);

    border-radius: 9px;

    background:
        #334155;

    color:
        #fff;

    font-size: 11px;

    font-weight: 800;

    cursor: pointer;

    transition:
        var(--cadet-transition);
}

.cadet-modal-close-btn:hover {
    background:
        #475569;

    transform:
        translateY(-1px);
}

.cadet-modal-close-btn:focus-visible,
.cadet-modal-close:focus-visible {
    outline: none;

    box-shadow:
        0 0 0 3px
        rgba(59, 130, 246, 0.18);
}


/* ==========================================================================
   TABLET
   ========================================================================== */

@media (max-width: 1200px) {

    .cadet-filters {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

}


@media (max-width: 1100px) {

    .cadet-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 992px) {

    .cadet-page {
        padding: 20px;
    }

    .cadet-sticky-controls {
        top: 75px;
    }

    .cadet-filters {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .cadet-modal {
        width:
            min(920px, 100%);

        max-height:
            calc(100dvh - 32px);
    }

}


@media (max-width: 768px) {

    .cadet-page {
        padding: 16px;
    }

    .cadet-header {
        align-items: flex-start;

        padding: 20px;
    }

    .cadet-header h1 {
        font-size: 23px;
    }

    .cadet-header p {
        font-size: 11px;
    }

    .cadet-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 10px;
    }

    .cadet-stat {
        min-height: 100px;

        padding: 16px;
    }

    .cadet-stat-value {
        font-size: 25px;
    }

    .cadet-filters {
        grid-template-columns: 1fr;

        padding: 14px;
    }

    .cadet-table-wrapper {
        margin-top: 14px;

        border-radius: 15px;
    }

    .cadet-table {
        min-width: 850px;
    }

    .cadet-modal-overlay {
        padding: 12px;
    }

    .cadet-modal {
        width: 100%;

        max-width: 100%;

        max-height:
            calc(100dvh - 24px);

        border-radius: 16px;
    }

    .cadet-modal-header {
        padding:
            14px 15px;
    }

    .cadet-modal-title {
        gap: 9px;
    }

    .cadet-modal-title-icon {
        width: 40px;
        height: 40px;
    }

    .cadet-modal-title-text h2 {
        font-size: 17px;
    }

    .cadet-profile-section {
        padding: 18px;

        gap: 15px;
    }

    .cadet-modal-photo {
        width: 95px;
        height: 95px;
    }

    .cadet-profile-name {
        font-size: 19px;
    }

    .cadet-details-section {
        padding:
            18px;
    }

    .cadet-details-grid {
        grid-template-columns: 1fr;
    }

    .cadet-modal-footer {
        padding:
            12px 15px;
    }

}


@media (max-width: 600px) {

    .cadet-page {
        padding: 12px;
    }

    .cadet-header {
        padding: 18px;

        border-radius: 15px;
    }

    .cadet-header h1 {
        font-size: 21px;
    }

    .cadet-header p {
        font-size: 10px;
    }

    .cadet-stats {
        grid-template-columns: 1fr;
    }

    .cadet-stat {
        min-height: 90px;
    }

    .cadet-stat-value {
        font-size: 24px;
    }

    .cadet-modal-overlay {
        padding: 8px;
    }

    .cadet-modal {
        height:
            calc(100dvh - 16px);

        max-height:
            calc(100dvh - 16px);

        border-radius: 15px;
    }

    .cadet-modal-header {
        min-height: 68px;

        padding:
            12px 13px;
    }

    .cadet-modal-title-text p {
        display: none;
    }

    .cadet-modal-close {
        width: 34px;
        height: 34px;
    }

    .cadet-profile-section {
        flex-direction: column;

        justify-content: center;

        text-align: center;

        padding:
            18px 15px;
    }

    .cadet-modal-photo {
        width: 100px;
        height: 100px;
    }

    .cadet-profile-name {
        font-size: 18px;
    }

    .cadet-details-section {
        padding:
            15px;
    }

    .cadet-detail-card {
        padding:
            12px;
    }

    .cadet-modal-footer {
        padding:
            10px 12px;
    }

    .cadet-modal-close-btn {
        width: 100%;
    }

}


@media (max-width: 420px) {

    .cadet-header h1 {
        font-size: 19px;
    }

    .cadet-header p {
        font-size: 10px;
    }

    .cadet-stat {
        padding: 14px;
    }

    .cadet-stat-value {
        font-size: 22px;
    }

    .cadet-table {
        min-width: 800px;
    }

    .cadet-modal-title-text h2 {
        font-size: 16px;
    }

}


/* ==========================================================================
   ACCESSIBILITY / REDUCED MOTION
   ========================================================================== */

@media (prefers-reduced-motion: reduce) {

    .cadet-stat,
    .cadet-view-btn,
    .cadet-detail-card,
    .cadet-modal-close,
    .cadet-modal-close-btn,
    .cadet-filters input,
    .cadet-filters select {
        transition: none !important;
    }

    .cadet-modal-overlay.show,
    .cadet-modal {
        animation: none !important;
    }

}


/* ==========================================================================
   CUSTOM SCROLLBAR
   ========================================================================== */

.cadet-page * {
    scrollbar-width: thin;
    scrollbar-color:
        #334155
        transparent;
}

.cadet-page *::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.cadet-page *::-webkit-scrollbar-track {
    background: transparent;
}

.cadet-page *::-webkit-scrollbar-thumb {
    border-radius: 20px;

    background:
        #334155;
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