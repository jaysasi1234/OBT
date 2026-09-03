@extends('layouts.superadmin')

@section('content')

<style>

/* ==========================================================================
   FONT AWESOME ICON FONT
   ========================================================================== */

@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

/* ==========================================================================
   SUPER ADMIN CADET MANAGEMENT
   DEPLOYMENT MONITORING STYLE
   UI / CSS ONLY
   ========================================================================== */

:root {
    --cadet-bg: #07152f;
    --cadet-bg-2: #0b1b43;

    --cadet-panel: #0d1940;
    --cadet-panel-2: #111f4d;
    --cadet-panel-3: #16265a;

    --cadet-primary: #2f5df5;
    --cadet-primary-dark: #2447bd;
    --cadet-primary-light: #4f7cff;

    --cadet-cyan: #0d8db5;

    --cadet-success: #159447;
    --cadet-success-light: #20b85a;

    --cadet-warning: #d98a08;
    --cadet-warning-light: #f5b72f;

    --cadet-danger: #c93636;
    --cadet-danger-light: #f05a5a;

    --cadet-text: #ffffff;
    --cadet-text-soft: #e2e8f0;
    --cadet-muted: #a9b8d8;
    --cadet-muted-2: #8293b9;

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
            circle at 8% 0%,
            rgba(47, 93, 245, 0.13),
            transparent 28%
        ),
        radial-gradient(
            circle at 92% 4%,
            rgba(13, 141, 181, 0.09),
            transparent 25%
        ),
        linear-gradient(
            145deg,
            #07152f 0%,
            #081738 45%,
            #06132f 100%
        );
}


/* ==========================================================================
   BACKGROUND GRID
   ========================================================================== */

.cadet-page::before {
    content: "";
    position: absolute;
    inset: 0;
    z-index: -1;
    pointer-events: none;

    opacity: 0.28;

    background:
        linear-gradient(
            90deg,
            rgba(79, 124, 255, 0.025) 1px,
            transparent 1px
        ),
        linear-gradient(
            rgba(79, 124, 255, 0.025) 1px,
            transparent 1px
        );

    background-size: 32px 32px;
}


/* ==========================================================================
   STICKY CONTROLS
   ========================================================================== */

.cadet-sticky-controls {
    position: sticky;
    top: 75px;
    z-index: 900;

    padding: 6px 0 22px;

    background:
        linear-gradient(
            to bottom,
            rgba(7, 21, 47, 0.98),
            rgba(7, 21, 47, 0.94),
            rgba(7, 21, 47, 0)
        );

    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}


/* ==========================================================================
   PAGE HEADER
   ========================================================================== */

.cadet-header {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    min-height: 136px;

    margin-bottom: 22px;
    padding: 28px 30px;

    overflow: hidden;

    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 19px;

    background:
        linear-gradient(
            135deg,
            #2f66e8 0%,
            #2554d8 48%,
            #214ac5 100%
        );

    box-shadow:
        0 20px 45px rgba(0, 0, 0, 0.28),
        inset 0 1px 0 rgba(255, 255, 255, 0.10);
}


/* Header decorative circles */

.cadet-header::before {
    content: "";

    position: absolute;

    width: 210px;
    height: 210px;

    right: -70px;
    top: -95px;

    border-radius: 50%;

    background:
        rgba(255, 255, 255, 0.08);

    pointer-events: none;
}

.cadet-header::after {
    content: "";

    position: absolute;

    width: 125px;
    height: 125px;

    right: 100px;
    bottom: -75px;

    border-radius: 50%;

    background:
        rgba(255, 255, 255, 0.055);

    pointer-events: none;
}


.cadet-header h1 {
    position: relative;
    z-index: 1;

    margin: 0;

    color: #ffffff;

    font-size: 30px;
    font-weight: 800;

    line-height: 1.2;

    letter-spacing: -0.7px;
}


/* Remove old dot and replace with clean heading */

.cadet-header h1::before {
    content: none;
}


.cadet-header p {
    position: relative;
    z-index: 1;

    margin: 8px 0 0;

    color: rgba(255, 255, 255, 0.78);

    font-size: 14px;
    font-weight: 500;

    line-height: 1.5;
}


/* ==========================================================================
   FILTER PANEL
   ========================================================================== */

.cadet-filters {
    position: relative;

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 14px;

    padding: 25px;

    margin-bottom: 22px;

    border: 1px solid var(--cadet-border);
    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            rgba(13, 25, 64, 0.98),
            rgba(17, 31, 77, 0.96)
        );

    box-shadow:
        0 18px 40px rgba(0, 0, 0, 0.24);
}


/* Filter heading */

.cadet-filters::before {
    content: "⚙ Filters";

    position: absolute;

    top: -13px;
    left: 22px;

    display: flex;
    align-items: center;

    height: 26px;

    padding: 0 12px;

    border: 1px solid rgba(79, 124, 255, 0.18);
    border-radius: 8px;

    background: #0d1940;

    color: #8fb1ff;

    font-size: 11px;
    font-weight: 800;

    letter-spacing: 0.4px;
}


/* ==========================================================================
   FILTER INPUTS
   ========================================================================== */

.cadet-filters input,
.cadet-filters select {
    width: 100%;
    min-width: 0;
    height: 57px;

    padding: 0 16px;

    box-sizing: border-box;

    border:
        1px solid
        rgba(255, 255, 255, 0.07);

    border-radius: 13px;

    outline: none;

    background:
        linear-gradient(
            135deg,
            #16265a,
            #111f4d
        );

    color: #f8fafc;

    font-size: 13px;
    font-weight: 600;

    transition:
        border-color var(--cadet-transition),
        background var(--cadet-transition),
        box-shadow var(--cadet-transition),
        transform var(--cadet-transition);
}


.cadet-filters input:hover,
.cadet-filters select:hover {
    border-color:
        rgba(79, 124, 255, 0.35);

    background:
        linear-gradient(
            135deg,
            #1a2d67,
            #152657
        );
}


.cadet-filters input:focus,
.cadet-filters select:focus {
    border-color:
        rgba(79, 124, 255, 0.85);

    background:
        linear-gradient(
            135deg,
            #192d68,
            #152657
        );

    box-shadow:
        0 0 0 3px
        rgba(47, 93, 245, 0.14),

        0 8px 20px
        rgba(0, 0, 0, 0.16);

    transform:
        translateY(-1px);
}


.cadet-filters input::placeholder {
    color: #8293b9;
}


.cadet-filters option {
    background: #0d1940;
    color: #ffffff;
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

    gap: 22px;

    margin-bottom: 0;
}


.cadet-stat {
    position: relative;

    min-width: 0;
    min-height: 155px;

    display: flex;
    flex-direction: column;
    justify-content: center;

    padding: 25px;

    overflow: hidden;

    border:
        1px solid
        rgba(255, 255, 255, 0.09);

    border-radius: 18px;

    color: #ffffff;

    font-size: 12px;
    font-weight: 800;

    letter-spacing: 0.7px;

    box-shadow:
        0 18px 40px rgba(0, 0, 0, 0.25);

    transition:
        transform var(--cadet-transition),
        box-shadow var(--cadet-transition),
        border-color var(--cadet-transition);
}


/* Decorative circle */

.cadet-stat::after {
    content: "";

    position: absolute;

    width: 125px;
    height: 125px;

    right: -42px;
    bottom: -52px;

    border-radius: 50%;

    background:
        rgba(255, 255, 255, 0.10);

    pointer-events: none;
}


.cadet-stat:hover {
    transform:
        translateY(-4px);

    box-shadow:
        0 24px 48px rgba(0, 0, 0, 0.32);

    border-color:
        rgba(255, 255, 255, 0.15);
}


.cadet-stat-value {
    display: block;

    margin-top: 10px;

    color: #ffffff;

    font-size: 34px;
    font-weight: 800;

    line-height: 1;

    letter-spacing: -1px;
}


/* Total */

.cadet-stat-blue {
    background:
        linear-gradient(
            135deg,
            #2f66e8 0%,
            #2252d6 55%,
            #1e4bc7 100%
        );
}


/* Verified */

.cadet-stat-green {
    background:
        linear-gradient(
            135deg,
            #19a34d 0%,
            #128d42 55%,
            #0d7c39 100%
        );
}


/* Pending */

.cadet-stat-yellow {
    background:
        linear-gradient(
            135deg,
            #e9a313 0%,
            #d88708 55%,
            #c57405 100%
        );

    color: #ffffff;
}


/* Deficiency */

.cadet-stat-red {
    background:
        linear-gradient(
            135deg,
            #dc4646 0%,
            #c93636 55%,
            #ad2929 100%
        );
}


/* ==========================================================================
   TABLE CONTAINER
   ========================================================================== */

.cadet-table-wrapper {
    position: relative;

    width: 100%;

    margin-top: 28px;

    padding: 0;

    overflow-x: auto;

    -webkit-overflow-scrolling: touch;

    border:
        1px solid
        rgba(255, 255, 255, 0.08);

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            rgba(13, 25, 64, 0.98),
            rgba(9, 21, 50, 0.98)
        );

    box-shadow:
        var(--cadet-shadow);

    scrollbar-width: thin;

    scrollbar-color:
        #334d78
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
        #334d78;
}


/* ==========================================================================
   TABLE
   ========================================================================== */

.cadet-table {
    width: 100%;

    min-width: 1200px;

    border-collapse: separate;
    border-spacing: 0;

    color: var(--cadet-text);
}


.cadet-table thead {
    background:
        linear-gradient(
            135deg,
            #244fca,
            #1f46b8
        );
}


.cadet-table th {
    position: sticky;
    top: 0;
    z-index: 2;

    padding:
        15px 20px;

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            #2d5ddd,
            #244fc7
        );

    font-size: 11px;
    font-weight: 800;

    text-align: left;

    text-transform: uppercase;

    letter-spacing: 0.75px;

    white-space: nowrap;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.10);
}


.cadet-table th:first-child {
    border-top-left-radius: 18px;
}


.cadet-table th:last-child {
    border-top-right-radius: 18px;
}


.cadet-table td {
    padding:
        16px 20px;

    color:
        #dbe4f3;

    font-size: 13px;
    font-weight: 500;

    white-space: nowrap;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.055);

    background:
        rgba(8, 20, 49, 0.55);

    transition:
        background var(--cadet-transition),
        color var(--cadet-transition);
}


.cadet-table tbody tr {
    background:
        transparent;

    transition:
        background var(--cadet-transition);
}


.cadet-table tbody tr:nth-child(even) td {
    background:
        rgba(15, 31, 70, 0.42);
}


.cadet-table tbody tr:hover td {
    background:
        rgba(47, 93, 245, 0.10);

    color:
        #ffffff;
}


.cadet-table tbody tr:last-child td {
    border-bottom: none;
}


/* ==========================================================================
   FIRST COLUMN / TRB
   ========================================================================== */

.cadet-table td:first-child {
    color:
        #8fb1ff;

    font-family:
        ui-monospace,
        SFMono-Regular,
        Menlo,
        Monaco,
        Consolas,
        monospace;

    font-size: 12px;
    font-weight: 800;
}


/* ==========================================================================
   NAME
   ========================================================================== */

.cadet-table td:nth-child(2) {
    color:
        #ffffff;

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
        70px 25px !important;

    color:
        #8293b9 !important;

    text-align: center !important;

    font-size: 13px !important;

    border-bottom: none !important;

    background:
        transparent !important;
}


/* ==========================================================================
   STATUS BADGES
   ========================================================================== */

.cadet-status {
    position: relative;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    min-height: 28px;

    padding:
        6px 12px;

    border:
        1px solid transparent;

    border-radius: 20px;

    font-size: 11px;
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
        0 0 8px currentColor;
}


/* ==========================================================================
   VERIFICATION STATUS
   ========================================================================== */

.cadet-status-verified {
    background:
        rgba(32, 184, 90, 0.13);

    border-color:
        rgba(32, 184, 90, 0.22);

    color:
        #4ade80;
}


.cadet-status-pending {
    background:
        rgba(245, 183, 47, 0.13);

    border-color:
        rgba(245, 183, 47, 0.22);

    color:
        #fbbf24;
}


.cadet-status-deficiency {
    background:
        rgba(240, 90, 90, 0.13);

    border-color:
        rgba(240, 90, 90, 0.22);

    color:
        #f87171;
}


/* ==========================================================================
   DEPLOYMENT STATUS
   ========================================================================== */

.cadet-status-not-deployed {
    background:
        rgba(148, 163, 184, 0.12);

    border-color:
        rgba(148, 163, 184, 0.18);

    color:
        #cbd5e1;
}


.cadet-status-ongoing {
    background:
        rgba(79, 124, 255, 0.13);

    border-color:
        rgba(79, 124, 255, 0.22);

    color:
        #72a0ff;
}


.cadet-status-completed {
    background:
        rgba(32, 184, 90, 0.12);

    border-color:
        rgba(32, 184, 90, 0.20);

    color:
        #4ade80;
}


/* ==========================================================================
   VIEW BUTTON
   ========================================================================== */

.cadet-view-btn {
    height: 36px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding:
        0 14px;

    border:
        1px solid
        rgba(255, 255, 255, 0.08);

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #2f66e8,
            #244fc7
        );

    color:
        #ffffff;

    font-size: 11px;
    font-weight: 800;

    cursor: pointer;

    box-shadow:
        0 7px 17px
        rgba(37, 82, 214, 0.24);

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
            #4f7cff,
            #2f5df5
        );

    transform:
        translateY(-2px);

    box-shadow:
        0 10px 24px
        rgba(47, 93, 245, 0.36);
}


.cadet-view-btn:active {
    transform:
        translateY(0);
}


.cadet-view-btn:focus-visible {
    outline: none;

    box-shadow:
        0 0 0 3px
        rgba(79, 124, 255, 0.20),

        0 9px 22px
        rgba(47, 93, 245, 0.30);
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

    padding: 22px;

    overflow: hidden;

    box-sizing: border-box;

    background:
        rgba(2, 6, 23, 0.86);

    backdrop-filter:
        blur(9px);

    -webkit-backdrop-filter:
        blur(9px);
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
        min(800px, 100%);

    max-width: 800px;

    max-height:
        calc(100dvh - 44px);

    overflow: hidden;

    border:
        1px solid
        rgba(255, 255, 255, 0.09);

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #0d1940,
            #091633
        );

    color:
        #ffffff;

    box-shadow:
        0 35px 90px
        rgba(0, 0, 0, 0.58);

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
        18px 22px;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.07);

    background:
        linear-gradient(
            135deg,
            #2d5ddd,
            #244fc7
        );

    overflow: hidden;
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
            #4f7cff,
            #72a0ff,
            #35c6e8
        );
}


.cadet-modal-title {
    display: flex;

    align-items: center;

    gap: 12px;

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
        rgba(255, 255, 255, 0.20);

    border-radius: 11px;

    background:
        rgba(255, 255, 255, 0.12);

    color:
        #ffffff;

    font-size: 18px;

    box-shadow:
        inset 0 0 20px
        rgba(255, 255, 255, 0.05);
}


.cadet-modal-title-text {
    min-width: 0;
}


.cadet-modal-title-text h2 {
    margin: 0;

    color:
        #ffffff;

    font-size: 18px;
    font-weight: 800;

    line-height: 1.25;
}


.cadet-modal-title-text p {
    margin:
        3px 0 0;

    color:
        rgba(255, 255, 255, 0.70);

    font-size: 10px;

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
        1px solid
        rgba(255, 255, 255, 0.13);

    border-radius: 10px;

    background:
        rgba(255, 255, 255, 0.09);

    color:
        #ffffff;

    font-size: 20px;

    line-height: 1;

    cursor: pointer;

    transition:
        var(--cadet-transition);
}


.cadet-modal-close:hover {
    border-color:
        rgba(255, 255, 255, 0.24);

    background:
        rgba(255, 255, 255, 0.17);

    color:
        #ffffff;

    transform:
        rotate(2deg);
}


/* ==========================================================================
   PROFILE SECTION
   ========================================================================== */

.cadet-profile-section {
    position: relative;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 22px;

    flex: 0 0 auto;

    padding:
        27px 25px;

    border-bottom:
        1px solid
        rgba(255, 255, 255, 0.06);

    background:
        linear-gradient(
            135deg,
            #101f4d,
            #0c193c
        );
}


.cadet-profile-section::before {
    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    right: -80px;
    top: -95px;

    border-radius: 50%;

    background:
        rgba(47, 93, 245, 0.07);

    pointer-events: none;
}


.cadet-modal-photo {
    width: 122px;
    height: 122px;

    flex-shrink: 0;

    object-fit: cover;

    border:
        2px solid
        rgba(79, 124, 255, 0.65);

    border-radius: 50%;

    background:
        #16265a;

    box-shadow:
        0 14px 32px
        rgba(0, 0, 0, 0.34),

        0 0 0 6px
        rgba(47, 93, 245, 0.07),

        0 0 25px
        rgba(47, 93, 245, 0.14);
}


.cadet-profile-info {
    min-width: 0;
}


.cadet-profile-name {
    margin:
        0 0 10px;

    color:
        #ffffff;

    font-size: 24px;
    font-weight: 800;

    line-height: 1.2;

    word-break: break-word;
}


.cadet-profile-trb {
    display: inline-flex;

    align-items: center;

    min-height: 28px;

    padding:
        6px 12px;

    border:
        1px solid
        rgba(79, 124, 255, 0.20);

    border-radius: 20px;

    background:
        rgba(47, 93, 245, 0.12);

    color:
        #9ab8ff;

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
   DETAILS SECTION
   ========================================================================== */

.cadet-details-section {
    flex: 1 1 auto;

    min-height: 0;

    padding:
        24px 25px;

    overflow-y: auto;

    scrollbar-width: thin;

    scrollbar-color:
        #334d78
        transparent;
}


.cadet-details-section::-webkit-scrollbar {
    width: 6px;
}


.cadet-details-section::-webkit-scrollbar-thumb {
    border-radius: 20px;

    background:
        #334d78;
}


.cadet-details-title {
    display: flex;

    align-items: center;

    gap: 8px;

    margin:
        0 0 15px;

    color:
        #ffffff;

    font-size: 14px;
    font-weight: 800;

    text-transform: none;
}


.cadet-details-title::before {
    content: "";

    width: 4px;
    height: 18px;

    flex-shrink: 0;

    border-radius: 10px;

    background:
        #4f7cff;

    box-shadow:
        0 0 12px
        rgba(79, 124, 255, 0.65);
}


.cadet-details-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 12px;
}


.cadet-detail-card {
    position: relative;

    min-width: 0;

    padding:
        16px 17px;

    border:
        1px solid
        rgba(255, 255, 255, 0.065);

    border-radius: 13px;

    background:
        linear-gradient(
            135deg,
            #111f4d,
            #0e1a40
        );

    transition:
        border-color var(--cadet-transition),
        background var(--cadet-transition),
        transform var(--cadet-transition),
        box-shadow var(--cadet-transition);
}


.cadet-detail-card:hover {
    border-color:
        rgba(79, 124, 255, 0.28);

    background:
        linear-gradient(
            135deg,
            #16265a,
            #12204b
        );

    transform:
        translateY(-2px);

    box-shadow:
        0 10px 22px
        rgba(0, 0, 0, 0.18);
}


.cadet-detail-label {
    display: block;

    margin-bottom: 6px;

    color:
        #8293b9;

    font-size: 9px;
    font-weight: 800;

    line-height: 1.3;

    text-transform: uppercase;

    letter-spacing: 0.75px;
}


.cadet-detail-value {
    display: block;

    color:
        #edf3ff;

    font-size: 13px;
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
        15px 22px;

    border-top:
        1px solid
        rgba(255, 255, 255, 0.07);

    background:
        #091633;
}


.cadet-modal-close-btn {
    min-height: 40px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding:
        0 18px;

    border:
        1px solid
        rgba(255, 255, 255, 0.08);

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #40506a,
            #334158
        );

    color:
        #ffffff;

    font-size: 11px;
    font-weight: 800;

    cursor: pointer;

    transition:
        var(--cadet-transition);
}


.cadet-modal-close-btn:hover {
    background:
        linear-gradient(
            135deg,
            #52627b,
            #40506a
        );

    transform:
        translateY(-1px);

    box-shadow:
        0 8px 18px
        rgba(0, 0, 0, 0.20);
}


.cadet-modal-close-btn:focus-visible,
.cadet-modal-close:focus-visible {
    outline: none;

    box-shadow:
        0 0 0 3px
        rgba(79, 124, 255, 0.20);
}

/* ==========================================================================
   CADet MANAGEMENT ICONS
   CSS-ONLY — NO HTML / JS CHANGES
   ========================================================================== */

/* --------------------------------------------------------------------------
   FILTER PANEL ICON
   -------------------------------------------------------------------------- */

.cadet-filters::before {
    content: "\f013  Filters";

    font-family:
        "Font Awesome 6 Free",
        sans-serif;

    font-weight: 900;

    display: flex;
    align-items: center;
    gap: 7px;
}


/* --------------------------------------------------------------------------
   VIEW BUTTON — EYE ICON
   -------------------------------------------------------------------------- */

.cadet-view-btn::before {
    content: "\f06e";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    font-size: 10px;

    line-height: 1;
}


/* --------------------------------------------------------------------------
   MODAL PROFILE ICON
   -------------------------------------------------------------------------- */

.cadet-modal-title-icon {
    font-size: 0;
}

.cadet-modal-title-icon::before {
    content: "\f2bd";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    font-size: 18px;

    line-height: 1;
}


/* --------------------------------------------------------------------------
   MODAL CLOSE ICON
   -------------------------------------------------------------------------- */

.cadet-modal-close {
    font-size: 0;
}

.cadet-modal-close::before {
    content: "\f00d";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    font-size: 16px;

    line-height: 1;
}


/* --------------------------------------------------------------------------
   MODAL FOOTER CLOSE BUTTON
   -------------------------------------------------------------------------- */

.cadet-modal-close-btn::before {
    content: "\f00d";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    font-size: 10px;

    line-height: 1;
}


/* ==========================================================================
   DETAIL CARD ICONS
   ========================================================================== */

/*
 * The existing HTML has no separate icon element inside each detail card.
 * These icons are therefore generated through the existing label element.
 */

.cadet-detail-label {
    display: flex;
    align-items: center;
    gap: 7px;
}


/* COURSE */

.cadet-detail-card:nth-child(1) .cadet-detail-label::before {
    content: "\f19d";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    color: #72a0ff;

    font-size: 10px;
}


/* BATCH */

.cadet-detail-card:nth-child(2) .cadet-detail-label::before {
    content: "\f073";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    color: #72a0ff;

    font-size: 10px;
}


/* RANK */

.cadet-detail-card:nth-child(3) .cadet-detail-label::before {
    content: "\f559";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    color: #72a0ff;

    font-size: 10px;
}


/* CONTACT */

.cadet-detail-card:nth-child(4) .cadet-detail-label::before {
    content: "\f095";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    color: #72a0ff;

    font-size: 10px;
}


/* BIRTH DATE */

.cadet-detail-card:nth-child(5) .cadet-detail-label::before {
    content: "\f1fd";

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    color: #72a0ff;

    font-size: 10px;
}


/* ==========================================================================
   STAT CARD ICON-LIKE ACCENT
   ========================================================================== */

.cadet-stat {
    position: relative;
}

.cadet-stat::before {
    position: absolute;

    top: 22px;
    right: 24px;

    display: flex;
    align-items: center;
    justify-content: center;

    width: 38px;
    height: 38px;

    border:
        1px solid
        rgba(255, 255, 255, 0.14);

    border-radius: 11px;

    background:
        rgba(255, 255, 255, 0.10);

    color:
        rgba(255, 255, 255, 0.92);

    font-family:
        "Font Awesome 6 Free";

    font-weight: 900;

    font-size: 15px;

    z-index: 2;
}


/* Total */

.cadet-stat-blue::before {
    content: "\f0c0";
}


/* Verified */

.cadet-stat-green::before {
    content: "\f058";
}


/* Pending */

.cadet-stat-yellow::before {
    content: "\f017";
}


/* Deficiency */

.cadet-stat-red::before {
    content: "\f071";
}


/* ==========================================================================
   STATUS BADGE ICONS
   ========================================================================== */

.cadet-status::before {
    content: "";

    width: 6px;
    height: 6px;

    flex-shrink: 0;

    border-radius: 50%;

    background:
        currentColor;

    box-shadow:
        0 0 8px currentColor;
}


/* ==========================================================================
   FILTER SELECT ARROW
   ========================================================================== */

.cadet-filters select {
    appearance: none;
    -webkit-appearance: none;

    padding-right: 42px;

    background-image:
        linear-gradient(45deg, transparent 50%, #8fb1ff 50%),
        linear-gradient(135deg, #8fb1ff 50%, transparent 50%),
        linear-gradient(
            135deg,
            #16265a,
            #111f4d
        );

    background-position:
        calc(100% - 18px) 24px,
        calc(100% - 13px) 24px,
        0 0;

    background-size:
        5px 5px,
        5px 5px,
        100% 100%;

    background-repeat:
        no-repeat;
}


/* ==========================================================================
   ICON HOVER EFFECTS
   ========================================================================== */

.cadet-view-btn:hover::before {
    transform:
        scale(1.08);
}

.cadet-modal-title-icon::before {
    transition:
        transform 0.2s ease;
}

.cadet-modal-title-icon:hover::before {
    transform:
        scale(1.08);
}

/* ==========================================================================
   CADET MANAGEMENT HEADER ICON
   ========================================================================== */

.cadet-header h1 {
    display: flex;
    align-items: center;
    gap: 12px;
}

.cadet-header h1::before {
    content: "\f508";

    font-family: "Font Awesome 6 Free";
    font-weight: 900;

    width: 42px;
    height: 42px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.18);

    color: #ffffff;

    font-size: 19px;

    box-shadow:
        0 6px 18px rgba(0, 0, 0, 0.14);
}


/* ==========================================================================
   REDUCED MOTION
   ========================================================================== */

@media (prefers-reduced-motion: reduce) {

    .cadet-modal-title-icon::before,
    .cadet-view-btn::before {
        transition: none;
    }

}

/* ==========================================================================
   LARGE TABLET
   ========================================================================== */

@media (max-width: 1200px) {

    .cadet-filters {
        grid-template-columns:
            repeat(3, minmax(0, 1fr));
    }

    .cadet-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }
}


/* ==========================================================================
   TABLET
   ========================================================================== */

@media (max-width: 992px) {

    .cadet-page {
        padding: 20px;
    }

    .cadet-sticky-controls {
        top: 75px;
    }

    .cadet-header {
        min-height: 125px;
        padding: 25px;
    }

    .cadet-header h1 {
        font-size: 27px;
    }

    .cadet-filters {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        padding: 22px;
    }

    .cadet-modal {
        width:
            min(800px, 100%);

        max-width: 800px;

        max-height:
            calc(100dvh - 32px);
    }
}


/* ==========================================================================
   MOBILE TABLET
   ========================================================================== */

@media (max-width: 768px) {

    .cadet-page {
        padding: 16px;
    }

    .cadet-header {
        align-items: flex-start;

        min-height: auto;

        padding: 23px 20px;

        border-radius: 17px;
    }

    .cadet-header h1 {
        font-size: 24px;
    }

    .cadet-header p {
        font-size: 12px;
    }

    .cadet-filters {
        grid-template-columns: 1fr;

        gap: 12px;

        padding: 20px;
    }

    .cadet-filters input,
    .cadet-filters select {
        height: 52px;
    }

    .cadet-stats {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 12px;
    }

    .cadet-stat {
        min-height: 130px;

        padding: 20px;
    }

    .cadet-stat-value {
        font-size: 29px;
    }

    .cadet-table-wrapper {
        margin-top: 22px;

        border-radius: 16px;
    }

    .cadet-table {
        min-width: 1100px;
    }

    .cadet-table th {
        padding:
            14px 17px;
    }

    .cadet-table td {
        padding:
            14px 17px;
    }

    .cadet-modal-overlay {
        padding: 12px;
    }

    .cadet-modal {
        width: 100%;
        max-width: 100%;

        max-height:
            calc(100dvh - 24px);

        border-radius: 17px;
    }

    .cadet-modal-header {
        padding:
            15px 16px;
    }

    .cadet-modal-title {
        gap: 10px;
    }

    .cadet-modal-title-icon {
        width: 40px;
        height: 40px;
    }

    .cadet-modal-title-text h2 {
        font-size: 17px;
    }

    .cadet-profile-section {
        padding:
            22px 18px;

        gap: 17px;
    }

    .cadet-modal-photo {
        width: 108px;
        height: 108px;
    }

    .cadet-profile-name {
        font-size: 20px;
    }

    .cadet-details-section {
        padding:
            20px 18px;
    }

    .cadet-details-grid {
        grid-template-columns: 1fr;
    }

    .cadet-modal-footer {
        padding:
            12px 16px;
    }
}


/* ==========================================================================
   MOBILE
   ========================================================================== */

@media (max-width: 600px) {

    .cadet-page {
        padding: 12px;
    }

    .cadet-sticky-controls {
        top: 65px;
    }

    .cadet-header {
        padding: 20px 17px;

        border-radius: 15px;
    }

    .cadet-header h1 {
        font-size: 21px;
    }

    .cadet-header p {
        font-size: 11px;
    }

    .cadet-filters {
        padding: 18px;
    }

    .cadet-stats {
        grid-template-columns: 1fr;

        gap: 12px;
    }

    .cadet-stat {
        min-height: 105px;

        padding: 19px;
    }

    .cadet-stat-value {
        font-size: 27px;
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
            22px 15px;
    }

    .cadet-modal-photo {
        width: 105px;
        height: 105px;
    }

    .cadet-profile-name {
        font-size: 19px;
    }

    .cadet-details-section {
        padding:
            17px 15px;
    }

    .cadet-detail-card {
        padding:
            14px;
    }

    .cadet-modal-footer {
        padding:
            10px 12px;
    }

    .cadet-modal-close-btn {
        width: 100%;
    }
}


/* ==========================================================================
   SMALL MOBILE
   ========================================================================== */

@media (max-width: 420px) {

    .cadet-header h1 {
        font-size: 19px;
    }

    .cadet-header p {
        font-size: 10px;
    }

    .cadet-filters {
        padding: 16px;
    }

    .cadet-stat {
        padding: 16px;
    }

    .cadet-stat-value {
        font-size: 24px;
    }

    .cadet-table {
        min-width: 1050px;
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
        #334d78
        transparent;
}


.cadet-page *::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}


.cadet-page *::-webkit-scrollbar-track {
    background:
        transparent;
}


.cadet-page *::-webkit-scrollbar-thumb {
    border-radius: 20px;

    background:
        #334d78;
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