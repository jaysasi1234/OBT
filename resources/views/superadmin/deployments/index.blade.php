@extends('layouts.superadmin')

@section('content')

<style>

/* =========================================================
   DEPLOYMENT MONITORING
   UI MATCHED TO THE PROVIDED ADMIN SCREENSHOT
   ========================================================= */

:root {
    --dm-bg: #07152f;
    --dm-bg-2: #0b1b43;
    --dm-panel: #0d1940;
    --dm-panel-2: #111f4d;
    --dm-panel-3: #16265a;

    --dm-blue: #2f5df5;
    --dm-blue-dark: #2447bd;
    --dm-blue-light: #4f7cff;

    --dm-cyan: #0d8db5;
    --dm-green: #159447;
    --dm-green-light: #20b85a;

    --dm-text: #ffffff;
    --dm-muted: #a9b8d8;
    --dm-muted-2: #8293b9;

    --dm-border: rgba(255,255,255,.08);
    --dm-border-blue: rgba(83,124,255,.28);

    --dm-shadow:
        0 18px 45px rgba(0,0,0,.25);

    --dm-shadow-soft:
        0 10px 30px rgba(0,0,0,.18);
}


/* =========================================================
   PAGE BACKGROUND
   ========================================================= */

body {
    background:
        radial-gradient(
            circle at 15% 0%,
            rgba(43, 91, 218, .16),
            transparent 30%
        ),
        radial-gradient(
            circle at 90% 15%,
            rgba(31, 80, 210, .12),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #07152f 0%,
            #0b1b43 48%,
            #10255a 100%
        ) !important;
}


/* =========================================================
   MAIN PAGE HEADER
   ========================================================= */

.page-header {

    position: relative;

    display: flex;
    align-items: center;
    justify-content: space-between;

    min-height: 136px;

    margin-bottom: 28px;

    padding: 28px 30px;

    border-radius: 19px;

    background:
        radial-gradient(
            circle at 85% 20%,
            rgba(95,140,255,.20),
            transparent 28%
        ),
        linear-gradient(
            135deg,
            #274cb5 0%,
            #1c398f 55%,
            #17327f 100%
        );

    border: 1px solid rgba(117,150,255,.22);

    box-shadow:
        0 18px 40px rgba(0,0,0,.25),
        inset 0 1px 0 rgba(255,255,255,.08);

    overflow: hidden;
}

.page-header::before {

    content: "";

    position: absolute;

    width: 190px;
    height: 190px;

    right: -65px;
    top: -90px;

    border-radius: 50%;

    background: rgba(255,255,255,.06);
}

.page-header::after {

    content: "";

    position: absolute;

    width: 150px;
    height: 150px;

    left: -80px;
    bottom: -105px;

    border-radius: 50%;

    background: rgba(255,255,255,.035);
}

.page-header h2 {

    position: relative;
    z-index: 2;

    margin: 0;

    color: #ffffff;

    font-size: 30px;
    line-height: 1.2;
    font-weight: 800;

    letter-spacing: -.6px;
}

.page-header p {

    position: relative;
    z-index: 2;

    margin: 10px 0 0;

    color: #c7d5f5;

    font-size: 15px;
    line-height: 1.5;
}


/* =========================================================
   MAIN CARD
   ========================================================= */

.card-container {

    position: relative;

    padding: 0;

    background: transparent;

    border-radius: 0;

    box-shadow: none;
}


/* =========================================================
   STATISTICS
   ========================================================= */

.stats-grid {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 22px;

    margin-bottom: 28px;
}

.stat-card {

    position: relative;

    min-height: 164px;

    padding: 25px;

    border-radius: 18px;

    color: #ffffff;

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    overflow: hidden;

    border: 1px solid rgba(255,255,255,.07);

    box-shadow:
        0 14px 32px rgba(0,0,0,.24),
        inset 0 1px 0 rgba(255,255,255,.08);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}

.stat-card::before {

    content: "";

    position: absolute;

    width: 180px;
    height: 180px;

    right: -75px;
    top: -90px;

    border-radius: 50%;

    background: rgba(255,255,255,.09);
}

.stat-card::after {

    content: "";

    position: absolute;

    width: 115px;
    height: 115px;

    left: -58px;
    bottom: -70px;

    border-radius: 50%;

    background: rgba(255,255,255,.055);
}

.stat-card:hover {

    transform: translateY(-4px);

    box-shadow:
        0 20px 40px rgba(0,0,0,.32),
        inset 0 1px 0 rgba(255,255,255,.10);
}


/* Individual statistic colors */

.stats-grid .stat-card:nth-child(1) {

    background:
        linear-gradient(
            135deg,
            #2f66e8 0%,
            #2252d6 55%,
            #1e4bc7 100%
        );
}

.stats-grid .stat-card:nth-child(2) {

    background:
        linear-gradient(
            135deg,
            #1497b7 0%,
            #087ea8 55%,
            #08739b 100%
        );
}

.stats-grid .stat-card:nth-child(3) {

    background:
        linear-gradient(
            135deg,
            #19a34d 0%,
            #128d42 55%,
            #0d7c39 100%
        );
}

.stats-grid .stat-card:nth-child(4) {

    background:
        linear-gradient(
            135deg,
            #40506a 0%,
            #334158 55%,
            #26354d 100%
        );
}

.stat-info {

    position: relative;

    z-index: 3;
}

.stat-info h5 {

    margin: 17px 0 0;

    color: rgba(255,255,255,.92);

    font-size: 14px;

    line-height: 1.3;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .3px;
}

.stat-info h2 {

    margin: 40px 0 0;

    color: #ffffff;

    font-size: 46px;

    line-height: .8;

    font-weight: 800;

    letter-spacing: -.8px;
}

.stat-icon {

    position: relative;

    z-index: 3;

    width: 56px;
    height: 56px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 16px;

    background: rgba(255,255,255,.14);

    border: 1px solid rgba(255,255,255,.10);

    font-size: 28px;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.08);
}


/* =========================================================
   FILTER CONTAINER
   ========================================================= */

.filter-container {

    position: relative;

    margin-bottom: 28px;

    padding: 25px;

    border-radius: 18px;

    background:
        linear-gradient(
            145deg,
            rgba(15,29,72,.98),
            rgba(8,20,50,.98)
        );

    border: 1px solid rgba(87,119,208,.20);

    box-shadow:
        0 14px 35px rgba(0,0,0,.20),
        inset 0 1px 0 rgba(255,255,255,.035);
}

.filter-container::before {

    content: "⚙  Filters";

    display: block;

    margin-bottom: 18px;

    color: #ffffff;

    font-size: 16px;

    font-weight: 800;
}


/* =========================================================
   FILTER GRID
   ========================================================= */

.filter-grid {

    display: grid;

    grid-template-columns:
        minmax(220px, 1.5fr)
        minmax(170px, 1fr)
        minmax(170px, 1fr)
        minmax(170px, 1fr);

    gap: 14px;
}

.filter-grid input,
.filter-grid select {

    width: 100%;

    min-height: 57px;

    box-sizing: border-box;

    padding: 0 17px;

    border: 1px solid rgba(91,119,197,.22);

    border-radius: 13px;

    background:
        linear-gradient(
            145deg,
            #18295e,
            #152451
        );

    color: #ffffff;

    outline: none;

    font-size: 15px;

    font-family: inherit;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.filter-grid input::placeholder {

    color: #a2b1d0;
}

.filter-grid select {

    appearance: auto;

    cursor: pointer;
}

.filter-grid input:hover,
.filter-grid select:hover {

    border-color: rgba(91,132,240,.42);

    background:
        linear-gradient(
            145deg,
            #1b2e67,
            #172856
        );
}

.filter-grid input:focus,
.filter-grid select:focus {

    border-color: #4b75f5;

    box-shadow:
        0 0 0 3px rgba(65,105,235,.16),
        0 8px 20px rgba(0,0,0,.14);
}

.filter-grid select option {

    background: #111d43;

    color: #ffffff;
}


/* =========================================================
   SEARCH INPUT
   ========================================================= */

.filter-grid input[name="name"] {

    padding-left: 46px;

    background-image:
        linear-gradient(
            transparent,
            transparent
        );

    position: relative;
}


/* =========================================================
   TABLE SECTION HEADER
   ========================================================= */

.table-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin: 0;

    padding: 24px 24px 21px;

    background:
        linear-gradient(
            145deg,
            #121e44,
            #101a3b
        );

    border-radius: 18px 18px 0 0;

    border: 1px solid rgba(255,255,255,.06);

    border-bottom: none;

    box-shadow:
        0 10px 25px rgba(0,0,0,.14);
}

.table-title {

    color: #ffffff;
}

.table-title strong {

    display: block;

    color: #ffffff;

    font-size: 17px;

    font-weight: 800;
}

.table-title span {

    display: block;

    margin-top: 6px;

    color: #91a4cc;

    font-size: 13px;
}

.table-hint {

    color: #7286ad;

    font-size: 12px;

    white-space: nowrap;
}


/* =========================================================
   TABLE WRAPPER
   ========================================================= */

.table-responsive {

    width: 100%;

    overflow-x: auto;

    border-radius: 0 0 18px 18px;

    background: #101c42;

    border: 1px solid rgba(255,255,255,.06);

    border-top: none;

    box-shadow:
        0 16px 35px rgba(0,0,0,.20);

    scrollbar-width: thin;

    scrollbar-color: #3a5bb3 #111d42;
}


/* =========================================================
   TABLE
   ========================================================= */

.table-custom {

    width: 100%;

    min-width: 1500px;

    border-collapse: separate;

    border-spacing: 0;

    background: #17275b;
}

.table-custom th {

    position: sticky;

    top: 0;

    z-index: 5;

    padding: 15px 20px;

    background:
        linear-gradient(
            135deg,
            #315ff0 0%,
            #294fc9 100%
        );

    color: #ffffff;

    text-align: left;

    font-size: 12px;

    font-weight: 800;

    letter-spacing: .25px;

    text-transform: uppercase;

    white-space: nowrap;

    border-right: 1px solid rgba(255,255,255,.045);
}

.table-custom th:first-child {

    border-top-left-radius: 0;
}

.table-custom th:last-child {

    border-right: none;
}

.table-custom td {

    padding: 16px 20px;

    color: #e5ecfb;

    background: #18285e;

    border-bottom: 1px solid rgba(255,255,255,.055);

    font-size: 13px;

    white-space: nowrap;

    vertical-align: middle;

    transition:
        background .18s ease;
}

.table-custom tbody tr {

    transition:
        transform .18s ease;
}

.table-custom tbody tr:hover td {

    background: #1c306d;

}

.table-custom tbody tr:last-child td {

    border-bottom: none;
}

.table-custom td strong {

    color: #ffffff;

    font-weight: 800;
}


/* Alternating table row */

.table-custom tbody tr:nth-child(even) td {

    background: #172655;
}

.table-custom tbody tr:nth-child(even):hover td {

    background: #1c306d;
}


/* =========================================================
   TABLE SCROLLBAR
   ========================================================= */

.table-responsive::-webkit-scrollbar {

    height: 11px;
}

.table-responsive::-webkit-scrollbar-track {

    background: #0c1839;

    border-radius: 20px;
}

.table-responsive::-webkit-scrollbar-thumb {

    background:
        linear-gradient(
            90deg,
            #294da9,
            #4167c7
        );

    border-radius: 20px;

    border: 2px solid #0c1839;
}

.table-responsive::-webkit-scrollbar-thumb:hover {

    background:
        linear-gradient(
            90deg,
            #3c61c4,
            #5276dc
        );
}


/* =========================================================
   BADGES
   ========================================================= */

.dm-badge {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    min-height: 28px;

    padding: 5px 12px;

    border-radius: 999px;

    font-size: 11px;

    font-weight: 800;

    white-space: nowrap;

    border: 1px solid transparent;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.08);
}

.badge-green {

    background:
        rgba(16,185,85,.14);

    color: #42dc7b;

    border-color:
        rgba(42,211,112,.28);
}

.badge-blue {

    background:
        rgba(50,117,245,.15);

    color: #75a3ff;

    border-color:
        rgba(80,133,255,.30);
}

.badge-gray {

    background:
        rgba(148,163,184,.13);

    color: #bdc8db;

    border-color:
        rgba(148,163,184,.22);
}

.badge-orange {

    background:
        rgba(245,158,11,.14);

    color: #ffc25a;

    border-color:
        rgba(245,158,11,.28);
}


/* =========================================================
   PROGRESS
   ========================================================= */

.progress-wrapper {

    width: 155px;
}

.progress-top {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 7px;

    font-size: 11px;

    color: #94a7cd;
}

.progress-value {

    color: #ffffff;

    font-weight: 800;
}

.progress {

    width: 100%;

    height: 8px;

    padding: 0;

    background: #27375f;

    border-radius: 999px;

    overflow: hidden;

    box-shadow:
        inset 0 1px 2px rgba(0,0,0,.22);
}

.progress-bar {

    height: 100%;

    border-radius: 999px;

    background:
        linear-gradient(
            90deg,
            #416cff,
            #6c8fff
        );

    box-shadow:
        0 0 10px rgba(71,110,255,.25);

    transition: width .35s ease;
}

.progress-bar.complete {

    background:
        linear-gradient(
            90deg,
            #18a957,
            #38d476
        );

    box-shadow:
        0 0 10px rgba(34,197,94,.22);
}


/* =========================================================
   VIEW BUTTON
   ========================================================= */

.btn-view {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    min-height: 36px;

    padding: 8px 14px;

    border: 1px solid rgba(111,164,255,.28);

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #1976e8,
            #2459cf
        );

    color: #ffffff;

    text-decoration: none;

    cursor: pointer;

    font-size: 12px;

    font-weight: 700;

    box-shadow:
        0 5px 14px rgba(26,82,207,.20);

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.btn-view:hover {

    background:
        linear-gradient(
            135deg,
            #2786f4,
            #2c66e0
        );

    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 8px 18px rgba(30,90,220,.30);
}

.btn-view:active {

    transform: translateY(0);
}


/* =========================================================
   EMPTY STATE
   ========================================================= */

.empty-state {

    padding: 65px 20px !important;

    text-align: center;

    color: #8498c0 !important;

    background: #172655 !important;
}

.empty-icon {

    display: flex;

    align-items: center;
    justify-content: center;

    width: 70px;
    height: 70px;

    margin: 0 auto 15px;

    border-radius: 20px;

    background: rgba(54,94,200,.14);

    border: 1px solid rgba(88,123,224,.18);

    font-size: 34px;
}

.empty-state strong {

    display: block;

    margin-bottom: 6px;

    color: #ffffff;

    font-size: 17px;

    font-weight: 800;
}

.empty-state span {

    font-size: 13px;

    color: #8da0c5;
}


/* =========================================================
   PAGINATION
   ========================================================= */

.pagination-wrapper {

    margin-top: 22px;

    padding: 0 4px;
}

.pagination-wrapper nav {

    display: flex;

    justify-content: center;
}

.pagination-wrapper svg {

    width: 18px;
    height: 18px;
}

.pagination-wrapper a,
.pagination-wrapper span {

    border-color: rgba(255,255,255,.08) !important;

    background: #121f47 !important;

    color: #aebdde !important;
}

.pagination-wrapper a:hover {

    background: #20346f !important;

    color: #ffffff !important;
}


/* =========================================================
   MODAL OVERLAY
   ========================================================= */

.custom-modal-overlay {

    position: fixed;

    inset: 0;

    display: none;

    justify-content: center;

    align-items: center;

    z-index: 9999;

    padding: 22px;

    background:
        rgba(2,8,24,.78);

    backdrop-filter: blur(7px);

    -webkit-backdrop-filter: blur(7px);
}

.custom-modal-overlay.show {

    display: flex;
}


/* =========================================================
   MODAL BOX
   ========================================================= */

.custom-modal-box {

    position: relative;

    width: 100%;

    max-width: 760px;

    max-height: 91vh;

    overflow-y: auto;

    overflow-x: hidden;

    background:
        linear-gradient(
            145deg,
            #101d47 0%,
            #0c1738 100%
        );

    border: 1px solid rgba(87,124,223,.25);

    border-radius: 20px;

    box-shadow:
        0 30px 80px rgba(0,0,0,.55),
        0 0 0 1px rgba(255,255,255,.025);

    animation:
        modalPop .25s cubic-bezier(.2,.8,.2,1);

    scrollbar-width: thin;

    scrollbar-color: #3a5bb3 #101a3c;
}

.custom-modal-box::-webkit-scrollbar {

    width: 8px;
}

.custom-modal-box::-webkit-scrollbar-track {

    background: #0c1735;
}

.custom-modal-box::-webkit-scrollbar-thumb {

    background: #3655a7;

    border-radius: 20px;
}

@keyframes modalPop {

    from {

        transform:
            translateY(15px)
            scale(.96);

        opacity: 0;
    }

    to {

        transform:
            translateY(0)
            scale(1);

        opacity: 1;
    }
}


/* =========================================================
   MODAL HEADER
   ========================================================= */

.custom-modal-header {

    position: sticky;

    top: 0;

    z-index: 10;

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    padding: 18px 22px;

    background:
        linear-gradient(
            135deg,
            #294db4,
            #203c91
        );

    color: #ffffff;

    border-bottom: 1px solid rgba(255,255,255,.08);

    box-shadow:
        0 8px 20px rgba(0,0,0,.16);
}

.custom-modal-header h3 {

    margin: 0;

    color: #ffffff;

    font-size: 18px;

    font-weight: 800;
}

.close-btn {

    width: 38px;
    height: 38px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border: 1px solid rgba(255,255,255,.12);

    border-radius: 10px;

    background: rgba(255,255,255,.09);

    color: #ffffff;

    font-size: 21px;

    line-height: 1;

    cursor: pointer;

    transition:
        background .2s ease,
        transform .2s ease;
}

.close-btn:hover {

    background: rgba(255,255,255,.17);

    transform: rotate(4deg);
}


/* =========================================================
   MODAL BODY
   ========================================================= */

.custom-modal-body {

    padding: 27px;
}


/* =========================================================
   PROFILE
   ========================================================= */

.profile-section {

    position: relative;

    text-align: center;

    margin-bottom: 30px;

    padding: 22px 15px 25px;

    border-radius: 17px;

    background:
        linear-gradient(
            145deg,
            rgba(30,49,105,.58),
            rgba(15,29,68,.40)
        );

    border: 1px solid rgba(93,126,218,.13);
}

.profile-section::before {

    content: "";

    position: absolute;

    width: 150px;
    height: 150px;

    top: -80px;
    left: 50%;

    transform: translateX(-50%);

    border-radius: 50%;

    background: rgba(68,103,213,.08);

    pointer-events: none;
}

.cadet-profile {

    position: relative;
    z-index: 2;

    width: 122px;
    height: 122px;

    display: block;

    margin: 0 auto 15px;

    border-radius: 50%;

    object-fit: cover;

    object-position: center;

    border: 4px solid #4168dd;

    background: #111b3e;

    box-shadow:
        0 0 0 6px rgba(65,104,221,.13),
        0 14px 30px rgba(0,0,0,.35);
}

.profile-section h4 {

    position: relative;
    z-index: 2;

    margin: 0;

    color: #ffffff;

    font-size: 23px;

    font-weight: 800;

    letter-spacing: -.2px;
}

.profile-section p {

    position: relative;
    z-index: 2;

    margin: 7px 0 0;

    color: #9fb2da;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: .4px;
}


/* =========================================================
   DETAIL SECTION
   ========================================================= */

.detail-section {

    margin-top: 22px;

    padding: 17px 20px;

    border-radius: 15px;

    background:
        linear-gradient(
            145deg,
            rgba(22,39,87,.82),
            rgba(13,26,61,.82)
        );

    border: 1px solid rgba(89,120,207,.12);
}

.detail-section-title {

    display: flex;

    align-items: center;

    gap: 9px;

    margin-bottom: 3px;

    color: #6e9aff;

    font-size: 12px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .8px;
}

.detail-section-title::before {

    content: "";

    width: 4px;
    height: 16px;

    border-radius: 5px;

    background:
        linear-gradient(
            180deg,
            #5d84ff,
            #3161db
        );
}


/* =========================================================
   DETAIL ROW
   ========================================================= */

.detail-row {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 25px;

    min-height: 49px;

    padding: 10px 0;

    border-bottom: 1px solid rgba(255,255,255,.055);
}

.detail-row:last-child {

    border-bottom: none;
}

.detail-row strong {

    color: #9aacd1;

    font-size: 13px;

    font-weight: 600;
}

.detail-row > span {

    color: #ffffff;

    text-align: right;

    font-size: 13px;

    font-weight: 600;
}


/* =========================================================
   MODAL STATUS
   ========================================================= */

.status-completed,
.status-ongoing,
.status-not-deployed {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 29px;

    padding: 5px 12px;

    border-radius: 999px;

    font-size: 11px;

    font-weight: 800;

    white-space: nowrap;
}

.status-completed {

    background: rgba(34,197,94,.13);

    border: 1px solid rgba(34,197,94,.25);

    color: #4be582 !important;
}

.status-ongoing {

    background: rgba(59,130,246,.13);

    border: 1px solid rgba(59,130,246,.25);

    color: #72a5ff !important;
}

.status-not-deployed {

    background: rgba(148,163,184,.12);

    border: 1px solid rgba(148,163,184,.20);

    color: #bac7dc !important;
}


/* =========================================================
   MODAL PROGRESS
   ========================================================= */

.detail-row .progress-wrapper {

    width: 190px;

    max-width: 100%;
}


/* =========================================================
   FOCUS ACCESSIBILITY
   ========================================================= */

.btn-view:focus-visible,
.close-btn:focus-visible,
.filter-grid input:focus-visible,
.filter-grid select:focus-visible {

    outline: 2px solid #6e95ff;

    outline-offset: 3px;
}


/* =========================================================
   RESPONSIVE — TABLET
   ========================================================= */

@media (max-width: 1200px) {

    .stats-grid {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

    }

    .filter-grid {

        grid-template-columns:
            repeat(2, minmax(180px, 1fr));

    }

}


/* =========================================================
   RESPONSIVE — 992px
   ========================================================= */

@media (max-width: 992px) {

    .page-header {

        min-height: auto;

        padding: 25px;

    }

    .page-header h2 {

        font-size: 26px;

    }

    .filter-grid {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

    }

    .table-hint {

        display: none;

    }

}


/* =========================================================
   RESPONSIVE — MOBILE
   ========================================================= */

@media (max-width: 768px) {

    .page-header {

        align-items: flex-start;

        padding: 23px 20px;

        border-radius: 16px;

    }

    .page-header h2 {

        font-size: 22px;

    }

    .page-header p {

        font-size: 13px;

    }

    .stats-grid {

        grid-template-columns: 1fr;

        gap: 15px;

    }

    .stat-card {

        min-height: 145px;

        padding: 21px;

    }

    .stat-info h5 {

        margin-top: 10px;

    }

    .stat-info h2 {

        margin-top: 35px;

        font-size: 40px;

    }

    .filter-container {

        padding: 19px;

        border-radius: 15px;

    }

    .filter-grid {

        grid-template-columns: 1fr;

        gap: 11px;

    }

    .filter-grid input,
    .filter-grid select {

        min-height: 53px;

    }

    .table-header {

        align-items: flex-start;

        padding: 20px 17px;

    }

    .table-title strong {

        font-size: 15px;

    }

    .table-title span {

        font-size: 12px;

    }

    .table-custom {

        min-width: 1500px;

    }

    .custom-modal-overlay {

        padding: 12px;

        align-items: center;

    }

    .custom-modal-box {

        max-height: 94vh;

        border-radius: 17px;

    }

    .custom-modal-header {

        padding: 15px 17px;

    }

    .custom-modal-header h3 {

        font-size: 16px;

    }

    .custom-modal-body {

        padding: 17px;

    }

    .profile-section {

        padding: 20px 12px;

    }

    .cadet-profile {

        width: 105px;
        height: 105px;

    }

    .profile-section h4 {

        font-size: 20px;

    }

    .detail-section {

        padding: 15px;

    }

    .detail-row {

        align-items: flex-start;

        flex-direction: column;

        gap: 5px;

        padding: 11px 0;

    }

    .detail-row > span {

        width: 100%;

        text-align: left;

    }

    .detail-row .progress-wrapper {

        width: 100%;

    }

}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 480px) {

    .page-header {

        margin-bottom: 18px;

        padding: 20px 17px;

    }

    .page-header h2 {

        font-size: 20px;

    }

    .page-header p {

        margin-top: 7px;

        font-size: 12px;

    }

    .stat-card {

        min-height: 135px;

        padding: 18px;

    }

    .stat-icon {

        width: 48px;
        height: 48px;

        font-size: 23px;

        border-radius: 13px;

    }

    .stat-info h5 {

        font-size: 12px;

    }

    .stat-info h2 {

        font-size: 36px;

    }

    .filter-container::before {

        font-size: 14px;

    }

    .custom-modal-overlay {

        padding: 7px;

    }

    .custom-modal-box {

        max-height: 96vh;

        border-radius: 15px;

    }

    .custom-modal-body {

        padding: 13px;

    }

}


/* =========================================================
   REDUCED MOTION
   ========================================================= */

@media (prefers-reduced-motion: reduce) {

    .stat-card,
    .btn-view,
    .close-btn,
    .filter-grid input,
    .filter-grid select,
    .progress-bar {

        transition: none !important;

    }

    .custom-modal-box {

        animation: none !important;

    }

}

</style>


<div class="page-header">

    <div>
        <h2>
            🚢 Deployment Monitoring
        </h2>

        <p>
            Monitor cadet deployment information,
            vessel assignments, progress, and training status.
        </p>
    </div>

</div>


<div class="card-container">


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-info">

                <h5>
                    Total Deployed
                </h5>

                <h2>
                    {{ $totalDeployed }}
                </h2>

            </div>

            <div class="stat-icon">
                🚢
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-info">

                <h5>
                    Ongoing
                </h5>

                <h2>
                    {{ $ongoing }}
                </h2>

            </div>

            <div class="stat-icon">
                ⚓
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-info">

                <h5>
                    Completed
                </h5>

                <h2>
                    {{ $completed }}
                </h2>

            </div>

            <div class="stat-icon">
                ✓
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-info">

                <h5>
                    Not Deployed
                </h5>

                <h2>
                    {{ $notDeployed }}
                </h2>

            </div>

            <div class="stat-icon">
                📋
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="filter-container">

        <form method="GET" id="filterForm">

            <div class="filter-grid">

                {{-- SEARCH --}}

                <input
                    type="text"
                    name="name"
                    placeholder="Search Cadet Name"
                    value="{{ request('name') }}"
                >


                {{-- COURSE --}}

                <select name="course">

                    <option value="">
                        All Courses
                    </option>

                    @foreach($courses as $course)

                        <option
                            value="{{ $course }}"
                            {{ request('course') == $course ? 'selected' : '' }}
                        >
                            {{ strtoupper($course) }}
                        </option>

                    @endforeach

                </select>


                {{-- BATCH --}}

                <select name="batch">

                    <option value="">
                        All Batches
                    </option>

                    @foreach($batches as $batch)

                        <option
                            value="{{ $batch->id }}"
                            {{ request('batch') == $batch->id ? 'selected' : '' }}
                        >
                            {{ $batch->batch_year }}
                        </option>

                    @endforeach

                </select>


                {{-- STATUS --}}

                <select name="status">

                    <option value="">
                        All Status
                    </option>

                    <option
                        value="Not Deployed"
                        {{ request('status') == 'Not Deployed' ? 'selected' : '' }}
                    >
                        Not Deployed
                    </option>

                    <option
                        value="Ongoing"
                        {{ request('status') == 'Ongoing' ? 'selected' : '' }}
                    >
                        Ongoing
                    </option>

                    <option
                        value="Completed"
                        {{ request('status') == 'Completed' ? 'selected' : '' }}
                    >
                        Completed
                    </option>

                </select>

            </div>

        </form>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="table-header">

        <div class="table-title">

            <strong>
                Cadet Deployment Records
            </strong>

            <span>
                Review deployment information and training progress
            </span>

        </div>

        <div class="table-hint">
            ↔ Scroll horizontally to view all columns
        </div>

    </div>


    <div class="table-responsive">

        <table class="table-custom">

            <thead>

                <tr>

                    <th>TRB No.</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Batch</th>
                    <th>Vessel</th>
                    <th>Company</th>
                    <th>Deployment Type</th>
                    <th>Embarkation Place</th>
                    <th>Embarkation Date</th>
                    <th>Disembarkation Place</th>
                    <th>Disembarkation Date</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                @forelse($deployments as $deployment)

                    @php

                        $percent =
                            (int) (
                                $deployment->percentage ?? 0
                            );

                        $percent =
                            max(
                                0,
                                min(
                                    100,
                                    $percent
                                )
                            );

                    @endphp


                    <tr>


                        {{-- TRB --}}

                        <td>

                            <strong>
                                {{ $deployment->cadet->trb_control_number ?? '—' }}
                            </strong>

                        </td>


                        {{-- NAME --}}

                        <td>
                            {{ $deployment->cadet->full_name ?? '—' }}
                        </td>


                        {{-- COURSE --}}

                        <td>
                            {{ strtoupper($deployment->cadet->course ?? '—') }}
                        </td>


                        {{-- BATCH --}}

                        <td>
                            {{ optional(optional($deployment->cadet)->batch)->batch_year ?? 'No Batch' }}
                        </td>


                        {{-- VESSEL --}}

                        <td>
                            {{ $deployment->vessel_name ?? '—' }}
                        </td>


                        {{-- COMPANY --}}

                        <td>
                            {{ $deployment->company_name ?? '—' }}
                        </td>


                        {{-- DEPLOYMENT TYPE --}}

                        <td>

                            @if(($deployment->deployment_type ?? '') === 'International')

                                <span class="dm-badge badge-blue">
                                    🌍 International
                                </span>

                            @elseif(($deployment->deployment_type ?? '') === 'Domestic')

                                <span class="dm-badge badge-green">
                                    🇵🇭 Domestic
                                </span>

                            @else

                                <span class="dm-badge badge-gray">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- EMBARKATION PLACE --}}

                        <td>
                            {{ $deployment->embarkation_place ?? '—' }}
                        </td>


                        {{-- EMBARKATION DATE --}}

                        <td>

                            @if($deployment->date_deployed)

                                {{ \Carbon\Carbon::parse(
                                    $deployment->date_deployed
                                )->format('M d, Y') }}

                            @else

                                —

                            @endif

                        </td>


                        {{-- DISEMBARKATION PLACE --}}

                        <td>
                            {{ $deployment->disembarkation_place ?? '—' }}
                        </td>


                        {{-- DISEMBARKATION DATE --}}

                        <td>

                            @if($deployment->date_disembarked)

                                {{ \Carbon\Carbon::parse(
                                    $deployment->date_disembarked
                                )->format('M d, Y') }}

                            @else

                                —

                            @endif

                        </td>


                        {{-- PROGRESS --}}

                        <td>

                            <div class="progress-wrapper">

                                <div class="progress-top">

                                    <span>
                                        Training
                                    </span>

                                    <span class="progress-value">
                                        {{ $percent }}%
                                    </span>

                                </div>

                                <div class="progress">

                                    <div
                                        class="progress-bar {{ $percent >= 100 ? 'complete' : '' }}"
                                        style="width: {{ $percent }}%;"
                                    ></div>

                                </div>

                            </div>

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($deployment->status === 'Completed')

                                <span class="dm-badge badge-green">
                                    ✓ Completed
                                </span>

                            @elseif($deployment->status === 'Ongoing')

                                <span class="dm-badge badge-blue">
                                    ⚓ Ongoing
                                </span>

                            @else

                                <span class="dm-badge badge-gray">
                                    ○ {{ $deployment->status ?? 'Not Deployed' }}
                                </span>

                            @endif

                        </td>


                        {{-- ACTION --}}

                        <td>

                            <button
                                type="button"
                                class="btn-view"
                                onclick="openModal('deploymentModal{{ $deployment->id }}')"
                            >
                                👁 View
                            </button>

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="14"
                            class="empty-state"
                        >

                            <div class="empty-icon">
                                🚢
                            </div>

                            <strong>
                                No deployment records found
                            </strong>

                            <span>
                                There are currently no cadets matching the selected filters.
                            </span>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}

    <div class="pagination-wrapper">

        {{ $deployments->links() }}

    </div>


    {{-- =====================================================
         DEPLOYMENT MODALS
    ====================================================== --}}

    @foreach($deployments as $deployment)

        <div
            class="custom-modal-overlay"
            id="deploymentModal{{ $deployment->id }}"
        >

            <div class="custom-modal-box">


                {{-- HEADER --}}

                <div class="custom-modal-header">

                    <h3>
                        🚢 Deployment Details
                    </h3>

                    <button
                        type="button"
                        class="close-btn"
                        onclick="closeModal('deploymentModal{{ $deployment->id }}')"
                    >
                        ✕
                    </button>

                </div>


                {{-- BODY --}}

                <div class="custom-modal-body">


                    {{-- PROFILE --}}

                    <div class="profile-section">

                        <img
                            src="{{ $deployment->cadet && $deployment->cadet->photo
                                ? asset('storage/'.$deployment->cadet->photo)
                                : 'https://ui-avatars.com/api/?name='.urlencode($deployment->cadet->full_name ?? 'Cadet').'&background=4f46e5&color=fff&size=200' }}"
                            class="cadet-profile"
                            alt="Cadet"
                        >

                        <h4>
                            {{ $deployment->cadet->full_name ?? 'Unknown Cadet' }}
                        </h4>

                        <p>
                            {{ strtoupper($deployment->cadet->course ?? 'N/A') }}
                        </p>

                    </div>


                    {{-- BASIC INFORMATION --}}

                    <div class="detail-section">

                        <div class="detail-section-title">
                            Cadet Information
                        </div>


                        <div class="detail-row">

                            <strong>
                                TRB Number
                            </strong>

                            <span>
                                {{ $deployment->cadet->trb_control_number ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Batch
                            </strong>

                            <span>
                                {{ optional(optional($deployment->cadet)->batch)->batch_year ?? 'No Batch' }}
                            </span>

                        </div>

                    </div>


                    {{-- VESSEL INFORMATION --}}

                    <div class="detail-section">

                        <div class="detail-section-title">
                            Vessel Information
                        </div>


                        <div class="detail-row">

                            <strong>
                                Vessel
                            </strong>

                            <span>
                                {{ $deployment->vessel_name ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Company
                            </strong>

                            <span>
                                {{ $deployment->company_name ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Deployment Type
                            </strong>

                            <span>

                                @if($deployment->deployment_type === 'International')

                                    <span class="dm-badge badge-blue">
                                        🌍 International
                                    </span>

                                @elseif($deployment->deployment_type === 'Domestic')

                                    <span class="dm-badge badge-green">
                                        🇵🇭 Domestic
                                    </span>

                                @else

                                    <span class="dm-badge badge-gray">
                                        —
                                    </span>

                                @endif

                            </span>

                        </div>

                    </div>


                    {{-- EMBARKATION --}}

                    <div class="detail-section">

                        <div class="detail-section-title">
                            Embarkation
                        </div>


                        <div class="detail-row">

                            <strong>
                                Embarkation Place
                            </strong>

                            <span>
                                {{ $deployment->embarkation_place ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Embarkation Date
                            </strong>

                            <span>

                                @if($deployment->date_deployed)

                                    {{ \Carbon\Carbon::parse(
                                        $deployment->date_deployed
                                    )->format('M d, Y') }}

                                @else

                                    —

                                @endif

                            </span>

                        </div>

                    </div>


                    {{-- DISEMBARKATION --}}

                    <div class="detail-section">

                        <div class="detail-section-title">
                            Disembarkation
                        </div>


                        <div class="detail-row">

                            <strong>
                                Disembarkation Place
                            </strong>

                            <span>
                                {{ $deployment->disembarkation_place ?? '—' }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Disembarkation Date
                            </strong>

                            <span>

                                @if($deployment->date_disembarked)

                                    {{ \Carbon\Carbon::parse(
                                        $deployment->date_disembarked
                                    )->format('M d, Y') }}

                                @else

                                    —

                                @endif

                            </span>

                        </div>

                    </div>


                    {{-- TRAINING STATUS --}}

                    <div class="detail-section">

                        <div class="detail-section-title">
                            Training Status
                        </div>


                        <div class="detail-row">

                            <strong>
                                Progress
                            </strong>

                            <span>

                                <div class="progress-wrapper">

                                    <div class="progress-top">

                                        <span>
                                            Training
                                        </span>

                                        <span class="progress-value">
                                            {{ $percent }}%
                                        </span>

                                    </div>

                                    <div class="progress">

                                        <div
                                            class="progress-bar {{ $percent >= 100 ? 'complete' : '' }}"
                                            style="width: {{ $percent }}%;"
                                        ></div>

                                    </div>

                                </div>

                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Status
                            </strong>

                            <span>

                                @if($deployment->status === 'Completed')

                                    <span class="status-completed">
                                        ✓ Completed
                                    </span>

                                @elseif($deployment->status === 'Ongoing')

                                    <span class="status-ongoing">
                                        ⚓ Ongoing
                                    </span>

                                @else

                                    <span class="status-not-deployed">
                                        ○ {{ $deployment->status ?? 'Not Deployed' }}
                                    </span>

                                @endif

                            </span>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    @endforeach


</div>


<script>

/* =========================================================
   MODAL
   ========================================================= */

function openModal(id)
{
    const modal =
        document.getElementById(id);

    if(modal){

        modal.style.display = "flex";

        document.body.style.overflow = "hidden";
    }
}


function closeModal(id)
{
    const modal =
        document.getElementById(id);

    if(modal){

        modal.style.display = "none";

        document.body.style.overflow = "";
    }
}


/* =========================================================
   CLOSE MODAL WHEN CLICKING OUTSIDE
   ========================================================= */

window.addEventListener(
    "click",
    function(event)
    {
        document
            .querySelectorAll(".custom-modal-overlay")
            .forEach(function(modal)
            {
                if(event.target === modal)
                {
                    modal.style.display = "none";

                    document.body.style.overflow = "";
                }
            });
    }
);


/* =========================================================
   FILTER FORM
   ========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function()
    {
        const form =
            document.getElementById("filterForm");

        if(!form){
            return;
        }


        /*
         * Automatically submit when
         * dropdown value changes.
         */

        form
            .querySelectorAll("select")
            .forEach(function(select)
            {
                select.addEventListener(
                    "change",
                    function()
                    {
                        form.submit();
                    }
                );
            });


        /*
         * Automatically search while typing.
         */

        const nameInput =
            form.querySelector(
                "input[name='name']"
            );

        let timer;


        if(nameInput)
        {
            nameInput.addEventListener(
                "input",
                function()
                {
                    clearTimeout(timer);

                    timer =
                        setTimeout(
                            function()
                            {
                                form.submit();
                            },
                            500
                        );
                }
            );
        }

    }
);


/* =========================================================
   ESCAPE KEY
   ========================================================= */

document.addEventListener(
    "keydown",
    function(event)
    {
        if(event.key !== "Escape"){
            return;
        }

        document
            .querySelectorAll(".custom-modal-overlay")
            .forEach(function(modal)
            {
                modal.style.display = "none";
            });

        document.body.style.overflow = "";
    }
);

</script>

@endsection