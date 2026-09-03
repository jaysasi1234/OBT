@extends('layouts.superadmin')

@section('header-title', 'Cadet Management')

@section('content')

<style>
/* =========================================================
   CADET MANAGEMENT
   Deployment Monitoring-inspired UI
   ========================================================= */

:root {
    --cm-bg: #07152f;
    --cm-bg-2: #0b1b43;

    --cm-panel: #0d1940;
    --cm-panel-2: #111f4d;
    --cm-panel-3: #16265a;

    --cm-blue: #2f5df5;
    --cm-blue-dark: #2447bd;
    --cm-blue-light: #4f7cff;

    --cm-cyan: #0d8db5;
    --cm-green: #159447;
    --cm-green-light: #20b85a;

    --cm-orange: #d97706;
    --cm-red: #dc3545;

    --cm-text: #ffffff;
    --cm-muted: #a9b8d8;
    --cm-muted-2: #8293b9;

    --cm-border: rgba(255, 255, 255, 0.08);

    --cm-shadow:
        0 18px 45px rgba(0, 0, 0, 0.28);

    --cm-shadow-soft:
        0 10px 30px rgba(0, 0, 0, 0.20);
}


/* =========================================================
   PAGE
   ========================================================= */

.cadet-page {
    width: 100%;
    min-width: 0;
    min-height: 100vh;
    min-height: 100dvh;

    padding: 28px;

    color: var(--cm-text);

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(47, 93, 245, 0.13),
            transparent 28%
        ),
        radial-gradient(
            circle at 90% 15%,
            rgba(13, 141, 181, 0.10),
            transparent 25%
        ),
        linear-gradient(
            135deg,
            var(--cm-bg),
            var(--cm-bg-2)
        );
}


/* =========================================================
   PAGE HEADER
   ========================================================= */

.cadet-page .page-header {
    position: relative;

    display: flex;
    align-items: center;

    min-height: 136px;

    margin-bottom: 28px;
    padding: 28px 30px;

    overflow: hidden;

    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 19px;

    background:
        linear-gradient(
            135deg,
            #2f5df5 0%,
            #2447bd 55%,
            #1d3da8 100%
        );

    box-shadow: var(--cm-shadow);
}


/* Header decorative circles */

.cadet-page .page-header::before {
    content: "";

    position: absolute;

    width: 230px;
    height: 230px;

    top: -125px;
    right: -65px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.07);
}


.cadet-page .page-header::after {
    content: "";

    position: absolute;

    width: 150px;
    height: 150px;

    bottom: -100px;
    right: 190px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.05);
}


.cadet-page .page-header-content {
    position: relative;
    z-index: 2;
}


.cadet-page .page-header h2 {
    margin: 0;

    color: #ffffff;

    font-size: 30px;
    font-weight: 800;
    line-height: 1.2;
}


.cadet-page .page-header p {
    margin: 8px 0 0;

    color: rgba(255, 255, 255, 0.78);

    font-size: 15px;
    line-height: 1.5;
}


/* =========================================================
   STATISTICS
   ========================================================= */

.cadet-page .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));

    gap: 22px;

    margin-bottom: 28px;
}


.cadet-page .stat-card {
    position: relative;

    min-height: 164px;

    padding: 25px;

    overflow: hidden;

    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 18px;

    box-shadow: var(--cm-shadow-soft);

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}


.cadet-page .stat-card:hover {
    transform: translateY(-3px);

    box-shadow:
        0 20px 40px rgba(0, 0, 0, 0.28);
}


/* Stat card backgrounds */

.cadet-page .stat-card:nth-child(1) {
    background:
        linear-gradient(
            135deg,
            #2f66e8,
            #2252d6,
            #1e4bc7
        );
}


.cadet-page .stat-card:nth-child(2) {
    background:
        linear-gradient(
            135deg,
            #1497b7,
            #087ea8,
            #08739b
        );
}


.cadet-page .stat-card:nth-child(3) {
    background:
        linear-gradient(
            135deg,
            #19a34d,
            #128d42,
            #0d7c39
        );
}


.cadet-page .stat-card:nth-child(4) {
    background:
        linear-gradient(
            135deg,
            #40506a,
            #334158,
            #26354d
        );
}


/* Decorative circle */

.cadet-page .stat-card::after {
    content: "";

    position: absolute;

    width: 125px;
    height: 125px;

    right: -45px;
    bottom: -60px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.07);
}


.cadet-page .stat-card::before {
    content: "";

    position: absolute;

    width: 70px;
    height: 70px;

    right: 30px;
    top: -35px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.05);
}


.cadet-page .stat-card-content {
    position: relative;
    z-index: 2;
}


.cadet-page .stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 56px;
    height: 56px;

    border-radius: 16px;

    background: rgba(255, 255, 255, 0.14);

    color: #ffffff;

    font-size: 22px;
}


.cadet-page .stat-info h5 {
    margin: 17px 0 0;

    color: rgba(255, 255, 255, 0.80);

    font-size: 14px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 0.04em;
}


.cadet-page .stat-info h2 {
    margin: 6px 0 0;

    color: #ffffff;

    font-size: 46px;
    font-weight: 800;

    line-height: 1;
}


/* =========================================================
   FILTER PANEL
   ========================================================= */

.cadet-page .filter-container {
    position: relative;

    margin-bottom: 28px;
    padding: 25px;

    overflow: hidden;

    border: 1px solid var(--cm-border);
    border-radius: 18px;

    background:
        linear-gradient(
            145deg,
            var(--cm-panel-2),
            var(--cm-panel)
        );

    box-shadow: var(--cm-shadow-soft);
}


.cadet-page .filter-container::before {
    content: "⚙ Filters";

    display: block;

    margin-bottom: 18px;

    color: #ffffff;

    font-size: 14px;
    font-weight: 800;

    letter-spacing: 0.02em;
}


.cadet-page .filter-grid {
    display: grid;

    grid-template-columns:
        repeat(5, minmax(0, 1fr));

    gap: 14px;
}


.cadet-page .filter-group {
    min-width: 0;
}


.cadet-page .filter-label {
    display: block;

    margin-bottom: 7px;

    color: var(--cm-muted);

    font-size: 11px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 0.05em;
}


.cadet-page .filter-control {
    width: 100%;
    min-height: 57px;

    padding: 0 15px;

    border: 1px solid rgba(255, 255, 255, 0.09);
    border-radius: 13px;

    outline: none;

    background:
        linear-gradient(
            145deg,
            #142653,
            #0e1c42
        );

    color: #ffffff;

    font-family: inherit;
    font-size: 13px;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}


.cadet-page .filter-control:hover {
    border-color: rgba(79, 124, 255, 0.35);
}


.cadet-page .filter-control:focus {
    border-color: var(--cm-blue-light);

    box-shadow:
        0 0 0 3px rgba(79, 124, 255, 0.12),
        0 0 20px rgba(47, 93, 245, 0.12);
}


.cadet-page .filter-control::placeholder {
    color: var(--cm-muted-2);
}


.cadet-page select.filter-control {
    cursor: pointer;
}


.cadet-page select.filter-control option {
    background: #0d1940;
    color: #ffffff;
}


/* =========================================================
   TABLE HEADER
   ========================================================= */

.cadet-page .table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    padding: 24px 24px 21px;

    border-top:
        1px solid rgba(255, 255, 255, 0.08);

    border-left:
        1px solid rgba(255, 255, 255, 0.08);

    border-right:
        1px solid rgba(255, 255, 255, 0.08);

    border-radius: 18px 18px 0 0;

    background:
        linear-gradient(
            145deg,
            #111f4d,
            #0d1940
        );

    box-shadow:
        0 8px 20px rgba(0, 0, 0, 0.16);
}


.cadet-page .table-title {
    min-width: 0;
}


.cadet-page .table-title strong {
    display: block;

    color: #ffffff;

    font-size: 17px;
    font-weight: 800;
}


.cadet-page .table-title span {
    display: block;

    margin-top: 4px;

    color: var(--cm-muted);

    font-size: 13px;
}


.cadet-page .table-hint {
    color: var(--cm-muted-2);

    font-size: 12px;

    white-space: nowrap;
}


/* =========================================================
   TABLE
   ========================================================= */

.cadet-page .table-responsive {
    width: 100%;

    overflow-x: auto;
    overflow-y: hidden;

    border-radius: 0 0 18px 18px;

    background: #0b1738;

    box-shadow: var(--cm-shadow);

    scrollbar-width: thin;
    scrollbar-color: #30477e #0a1533;
}


.cadet-page .table-responsive::-webkit-scrollbar {
    height: 8px;
}


.cadet-page .table-responsive::-webkit-scrollbar-track {
    background: #0a1533;
}


.cadet-page .table-responsive::-webkit-scrollbar-thumb {
    border-radius: 20px;

    background: #30477e;
}


.cadet-page .cadet-table {
    width: 100%;
    min-width: 1250px;

    border-collapse: separate;
    border-spacing: 0;

    background: #0b1738;
}


.cadet-page .cadet-table th {
    position: sticky;
    top: 0;
    z-index: 5;

    padding: 15px 20px;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.08);

    background:
        linear-gradient(
            135deg,
            #2f5df5,
            #2447bd
        );

    color: #ffffff;

    font-size: 12px;
    font-weight: 800;

    text-align: left;
    text-transform: uppercase;

    white-space: nowrap;
}


.cadet-page .cadet-table td {
    padding: 16px 20px;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.055);

    background: #0d1a3d;

    color: #edf3ff;

    font-size: 13px;

    white-space: nowrap;

    vertical-align: middle;
}


.cadet-page .cadet-table tbody tr:nth-child(even) td {
    background: #101f47;
}


.cadet-page .cadet-table tbody tr {
    transition: background 0.18s ease;
}


.cadet-page .cadet-table tbody tr:hover td {
    background: #16265a;
}


.cadet-page .cadet-table td:first-child {
    font-weight: 700;
}


/* =========================================================
   CADET PROFILE CELL
   ========================================================= */

.cadet-page .cadet-name-cell {
    display: flex;
    align-items: center;

    gap: 12px;
}


.cadet-page .cadet-mini-photo {
    flex: 0 0 auto;

    width: 42px;
    height: 42px;

    overflow: hidden;

    border: 2px solid rgba(255, 255, 255, 0.10);
    border-radius: 50%;

    background: #17285d;
}


.cadet-page .cadet-mini-photo img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}


.cadet-page .cadet-name-info strong {
    display: block;

    color: #ffffff;

    font-size: 13px;
    font-weight: 700;
}


.cadet-page .cadet-name-info span {
    display: block;

    margin-top: 3px;

    color: var(--cm-muted-2);

    font-size: 11px;
}


/* =========================================================
   STATUS BADGES
   ========================================================= */

.cadet-page .dm-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 28px;

    padding: 5px 12px;

    border-radius: 999px;

    font-size: 11px;
    font-weight: 800;

    line-height: 1;

    white-space: nowrap;
}


.cadet-page .badge-green {
    border: 1px solid rgba(32, 184, 90, 0.20);

    background: rgba(32, 184, 90, 0.14);

    color: #5ee58c;
}


.cadet-page .badge-blue {
    border: 1px solid rgba(79, 124, 255, 0.20);

    background: rgba(79, 124, 255, 0.14);

    color: #9ab2ff;
}


.cadet-page .badge-gray {
    border: 1px solid rgba(148, 163, 184, 0.18);

    background: rgba(148, 163, 184, 0.12);

    color: #c4cede;
}


.cadet-page .badge-orange {
    border: 1px solid rgba(245, 158, 11, 0.20);

    background: rgba(245, 158, 11, 0.14);

    color: #ffc45e;
}


.cadet-page .badge-red {
    border: 1px solid rgba(239, 68, 68, 0.20);

    background: rgba(239, 68, 68, 0.14);

    color: #ff8585;
}


/* =========================================================
   VIEW BUTTON
   ========================================================= */

.cadet-page .btn-view {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    min-height: 36px;

    padding: 8px 14px;

    border: 0;
    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            var(--cm-blue-light),
            var(--cm-blue-dark)
        );

    color: #ffffff;

    font-size: 12px;
    font-weight: 800;

    text-decoration: none;

    cursor: pointer;

    box-shadow:
        0 7px 18px rgba(36, 71, 189, 0.20);

    transition:
        transform 0.18s ease,
        box-shadow 0.18s ease;
}


.cadet-page .btn-view:hover {
    transform: translateY(-1px);

    color: #ffffff;

    box-shadow:
        0 10px 22px rgba(36, 71, 189, 0.30);
}


.cadet-page .btn-view:active {
    transform: translateY(0);
}


/* =========================================================
   EMPTY STATE
   ========================================================= */

.cadet-page .empty-state {
    padding: 65px 20px;

    color: var(--cm-muted);

    text-align: center;
}


.cadet-page .empty-state-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 70px;
    height: 70px;

    margin: 0 auto 16px;

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #17285d,
            #101d45
        );

    color: var(--cm-muted);

    font-size: 27px;
}


.cadet-page .empty-state h4 {
    margin: 0;

    color: #ffffff;

    font-size: 17px;
}


.cadet-page .empty-state p {
    margin: 7px 0 0;

    color: var(--cm-muted);

    font-size: 13px;
}


/* =========================================================
   PAGINATION
   ========================================================= */

.cadet-page .pagination {
    display: flex;
    align-items: center;

    gap: 6px;

    margin-top: 20px;
}


.cadet-page .pagination .page-link {
    border: 1px solid rgba(255, 255, 255, 0.08);

    border-radius: 9px;

    background: #111f4d;

    color: #b8c6e1;

    font-size: 12px;
}


.cadet-page .pagination .page-item.active .page-link {
    border-color: var(--cm-blue);

    background: var(--cm-blue);

    color: #ffffff;
}


.cadet-page .pagination .page-link:hover {
    border-color: var(--cm-blue-light);

    background: #17285d;

    color: #ffffff;
}


/* =========================================================
   MODAL OVERLAY
   ========================================================= */

.cadet-page .custom-modal-overlay {
    position: fixed;
    inset: 0;

    z-index: 9999;

    display: none;
    align-items: center;
    justify-content: center;

    padding: 22px;

    background:
        rgba(2, 8, 24, 0.80);

    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}


.cadet-page .custom-modal-overlay.show {
    display: flex;
}


/* =========================================================
   MODAL BOX
   ========================================================= */

.cadet-page .custom-modal-box {
    width: 100%;
    max-width: 760px;

    max-height: 91vh;
    max-height: 91dvh;

    overflow-y: auto;

    border: 1px solid rgba(255, 255, 255, 0.09);
    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            #111f4d,
            #0b1738
        );

    box-shadow:
        0 30px 90px rgba(0, 0, 0, 0.50);

    animation:
        modalPop 0.22s ease-out;
}


@keyframes modalPop {
    from {
        opacity: 0;
        transform: scale(0.96) translateY(10px);
    }

    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}


/* =========================================================
   MODAL HEADER
   ========================================================= */

.cadet-page .custom-modal-header {
    position: sticky;
    top: 0;

    z-index: 10;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    padding: 18px 22px;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.08);

    background:
        linear-gradient(
            135deg,
            #2f5df5,
            #2447bd
        );
}


.cadet-page .custom-modal-header h3 {
    margin: 0;

    color: #ffffff;

    font-size: 18px;
    font-weight: 800;
}


.cadet-page .modal-close {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 38px;
    height: 38px;

    flex: 0 0 auto;

    border: 0;
    border-radius: 10px;

    background: rgba(255, 255, 255, 0.12);

    color: #ffffff;

    font-size: 18px;

    cursor: pointer;

    transition:
        background 0.18s ease,
        transform 0.18s ease;
}


.cadet-page .modal-close:hover {
    background: rgba(255, 255, 255, 0.20);

    transform: rotate(3deg);
}


/* =========================================================
   MODAL BODY
   ========================================================= */

.cadet-page .custom-modal-body {
    padding: 27px;
}


/* =========================================================
   PROFILE SECTION
   ========================================================= */

.cadet-page .profile-section {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 20px;

    padding: 24px;

    overflow: hidden;

    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 17px;

    background:
        linear-gradient(
            145deg,
            #16265a,
            #0f1d43
        );
}


.cadet-page .profile-section::after {
    content: "";

    position: absolute;

    width: 160px;
    height: 160px;

    right: -70px;
    top: -80px;

    border-radius: 50%;

    background: rgba(47, 93, 245, 0.08);
}


.cadet-page .cadet-profile {
    position: relative;
    z-index: 2;

    width: 122px;
    height: 122px;

    flex: 0 0 auto;

    overflow: hidden;

    border: 4px solid rgba(79, 124, 255, 0.65);
    border-radius: 50%;

    background: #0b1738;

    box-shadow:
        0 0 0 6px rgba(79, 124, 255, 0.08),
        0 12px 30px rgba(0, 0, 0, 0.25);
}


.cadet-page .cadet-profile img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}


.cadet-page .profile-info {
    position: relative;
    z-index: 2;

    min-width: 0;
}


.cadet-page .profile-info h3 {
    margin: 0;

    color: #ffffff;

    font-size: 21px;
    font-weight: 800;
}


.cadet-page .profile-info p {
    margin: 6px 0 0;

    color: var(--cm-muted);

    font-size: 13px;
}


.cadet-page .profile-info .trb-number {
    display: inline-flex;

    margin-top: 11px;

    padding: 6px 11px;

    border: 1px solid rgba(79, 124, 255, 0.16);
    border-radius: 999px;

    background: rgba(79, 124, 255, 0.10);

    color: #a9bcff;

    font-size: 11px;
    font-weight: 800;
}


/* =========================================================
   DETAIL SECTION
   ========================================================= */

.cadet-page .detail-section {
    margin-top: 22px;

    padding: 17px 20px;

    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 15px;

    background:
        linear-gradient(
            145deg,
            #111f4d,
            #0e1a3e
        );
}


.cadet-page .detail-section-title {
    position: relative;

    margin-bottom: 7px;
    padding-left: 12px;

    color: #6f92ff;

    font-size: 12px;
    font-weight: 800;

    text-transform: uppercase;
    letter-spacing: 0.06em;
}


.cadet-page .detail-section-title::before {
    content: "";

    position: absolute;

    top: 1px;
    left: 0;

    width: 3px;
    height: 14px;

    border-radius: 5px;

    background: var(--cm-blue-light);
}


.cadet-page .detail-row {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    min-height: 49px;

    padding: 10px 0;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.055);
}


.cadet-page .detail-row:last-child {
    border-bottom: 0;
}


.cadet-page .detail-label {
    color: var(--cm-muted);

    font-size: 12px;
    font-weight: 600;
}


.cadet-page .detail-value {
    color: #ffffff;

    font-size: 13px;
    font-weight: 700;

    text-align: right;
}


/* =========================================================
   MODAL STATUS
   ========================================================= */

.cadet-page .modal-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 28px;

    padding: 5px 12px;

    border-radius: 999px;

    font-size: 11px;
    font-weight: 800;
}


.cadet-page .modal-status.completed {
    background: rgba(32, 184, 90, 0.14);
    color: #5ee58c;
}


.cadet-page .modal-status.ongoing {
    background: rgba(79, 124, 255, 0.14);
    color: #9ab2ff;
}


.cadet-page .modal-status.not-deployed {
    background: rgba(148, 163, 184, 0.12);
    color: #c4cede;
}


/* =========================================================
   MODAL FOOTER
   ========================================================= */

.cadet-page .modal-footer {
    display: flex;
    justify-content: flex-end;

    margin-top: 22px;
}


.cadet-page .modal-footer-btn {
    min-height: 40px;

    padding: 9px 18px;

    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;

    background:
        linear-gradient(
            145deg,
            #26385f,
            #1a2a4e
        );

    color: #ffffff;

    font-size: 12px;
    font-weight: 800;

    cursor: pointer;

    transition:
        background 0.18s ease,
        transform 0.18s ease;
}


.cadet-page .modal-footer-btn:hover {
    transform: translateY(-1px);

    background:
        linear-gradient(
            145deg,
            #30456f,
            #203354
        );
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1200px) {

    .cadet-page .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .cadet-page .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}


@media (max-width: 992px) {

    .cadet-page {
        padding: 22px;
    }

    .cadet-page .table-hint {
        display: none;
    }
}


@media (max-width: 768px) {

    .cadet-page {
        padding: 18px;
    }

    .cadet-page .page-header {
        min-height: auto;

        padding: 24px;
    }

    .cadet-page .page-header h2 {
        font-size: 25px;
    }

    .cadet-page .page-header p {
        font-size: 13px;
    }

    .cadet-page .filter-grid {
        grid-template-columns: 1fr;
    }

    .cadet-page .stats-grid {
        grid-template-columns: 1fr;
    }

    .cadet-page .stat-card {
        min-height: 145px;
    }

    .cadet-page .stat-info h2 {
        font-size: 40px;
    }

    .cadet-page .table-header {
        padding: 20px;
    }

    .cadet-page .custom-modal-overlay {
        padding: 12px;
    }

    .cadet-page .custom-modal-box {
        max-height: 94vh;
        max-height: 94dvh;

        border-radius: 17px;
    }

    .cadet-page .custom-modal-body {
        padding: 20px;
    }

    .cadet-page .profile-section {
        flex-direction: column;

        text-align: center;
    }

    .cadet-page .detail-row {
        align-items: flex-start;
        flex-direction: column;

        gap: 5px;
    }

    .cadet-page .detail-value {
        text-align: left;
    }
}


@media (max-width: 480px) {

    .cadet-page {
        padding: 12px;
    }

    .cadet-page .page-header {
        margin-bottom: 18px;
        padding: 21px 18px;

        border-radius: 15px;
    }

    .cadet-page .page-header h2 {
        font-size: 22px;
    }

    .cadet-page .page-header p {
        font-size: 12px;
    }

    .cadet-page .filter-container {
        padding: 18px;

        border-radius: 15px;
    }

    .cadet-page .filter-control {
        min-height: 52px;
    }

    .cadet-page .stat-card {
        padding: 20px;

        border-radius: 15px;
    }

    .cadet-page .stat-icon {
        width: 50px;
        height: 50px;

        border-radius: 14px;
    }

    .cadet-page .stat-info h5 {
        font-size: 12px;
    }

    .cadet-page .stat-info h2 {
        font-size: 36px;
    }

    .cadet-page .table-header {
        padding: 18px;
    }

    .cadet-page .table-title strong {
        font-size: 15px;
    }

    .cadet-page .table-title span {
        font-size: 11px;
    }

    .cadet-page .custom-modal-overlay {
        padding: 8px;
    }

    .cadet-page .custom-modal-box {
        max-height: 96vh;
        max-height: 96dvh;

        border-radius: 15px;
    }

    .cadet-page .custom-modal-header {
        padding: 15px 17px;
    }

    .cadet-page .custom-modal-header h3 {
        font-size: 16px;
    }

    .cadet-page .custom-modal-body {
        padding: 15px;
    }

    .cadet-page .profile-section {
        padding: 20px 15px;
    }

    .cadet-page .cadet-profile {
        width: 105px;
        height: 105px;
    }

    .cadet-page .profile-info h3 {
        font-size: 18px;
    }

    .cadet-page .detail-section {
        padding: 15px;
    }

    .cadet-page .modal-footer-btn {
        width: 100%;
    }

    .cadet-page .modal-footer {
        display: block;
    }
}


/* =========================================================
   REDUCED MOTION
   ========================================================= */

@media (prefers-reduced-motion: reduce) {

    .cadet-page *,
    .cadet-page *::before,
    .cadet-page *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;

        scroll-behavior: auto !important;

        transition-duration: 0.01ms !important;
    }
}
</style>


<div class="cadet-page">

    {{-- =====================================================
         PAGE HEADER
         ===================================================== --}}

    <div class="page-header">

        <div class="page-header-content">

            <h2>Cadet Management</h2>

            <p>
                Manage, monitor, and review registered cadet records.
            </p>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
         ===================================================== --}}

    <div class="stats-grid">

        {{-- Total --}}

        <div class="stat-card">

            <div class="stat-card-content">

                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>

                <div class="stat-info">

                    <h5>Total Cadets</h5>

                    <h2 id="totalCount">
                        {{ $totalCadets }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- Verified --}}

        <div class="stat-card">

            <div class="stat-card-content">

                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>

                <div class="stat-info">

                    <h5>Verified</h5>

                    <h2 id="verifiedCount">
                        {{ $verifiedCadets }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- Pending --}}

        <div class="stat-card">

            <div class="stat-card-content">

                <div class="stat-icon">
                    <i class="fas fa-user-clock"></i>
                </div>

                <div class="stat-info">

                    <h5>Pending</h5>

                    <h2 id="pendingCount">
                        {{ $pendingCadets }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- Deficiency --}}

        <div class="stat-card">

            <div class="stat-card-content">

                <div class="stat-icon">
                    <i class="fas fa-user-xmark"></i>
                </div>

                <div class="stat-info">

                    <h5>Deficiency</h5>

                    <h2 id="deficiencyCount">
                        {{ $deficiencyCadets }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
         ===================================================== --}}

    <div class="filter-container">

        <div class="filter-grid">

            {{-- Course --}}

            <div class="filter-group">

                <label
                    for="courseFilter"
                    class="filter-label"
                >
                    Course
                </label>

                <select
                    id="courseFilter"
                    class="filter-control"
                >

                    <option value="">
                        All Courses
                    </option>

                    @foreach ($courses as $course)

                        <option value="{{ $course->course_code }}">
                            {{ $course->course_code }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Batch --}}

            <div class="filter-group">

                <label
                    for="batchFilter"
                    class="filter-label"
                >
                    Batch
                </label>

                <select
                    id="batchFilter"
                    class="filter-control"
                >

                    <option value="">
                        All Batches
                    </option>

                    @foreach ($batches as $batch)

                        <option value="{{ $batch->batch_year }}">
                            {{ $batch->batch_year }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Deployment --}}

            <div class="filter-group">

                <label
                    for="deploymentFilter"
                    class="filter-label"
                >
                    Deployment
                </label>

                <select
                    id="deploymentFilter"
                    class="filter-control"
                >

                    <option value="">
                        All Deployment Status
                    </option>

                    <option value="not deployed">
                        Not Deployed
                    </option>

                    <option value="ongoing">
                        Ongoing
                    </option>

                    <option value="completed">
                        Completed
                    </option>

                </select>

            </div>


            {{-- Verification --}}

            <div class="filter-group">

                <label
                    for="verificationFilter"
                    class="filter-label"
                >
                    Verification
                </label>

                <select
                    id="verificationFilter"
                    class="filter-control"
                >

                    <option value="">
                        All Verification Status
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

            </div>


            {{-- Search --}}

            <div class="filter-group">

                <label
                    for="searchFilter"
                    class="filter-label"
                >
                    Search
                </label>

                <input
                    type="text"
                    id="searchFilter"
                    class="filter-control"
                    placeholder="Search cadet..."
                    autocomplete="off"
                >

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE HEADER
         ===================================================== --}}

    <div class="table-header">

        <div class="table-title">

            <strong>
                Cadet Records
            </strong>

            <span>
                View and monitor registered cadet information.
            </span>

        </div>

        <div class="table-hint">
            Scroll horizontally to view all columns
        </div>

    </div>


    {{-- =====================================================
         TABLE
         ===================================================== --}}

    <div class="table-responsive">

        <table class="cadet-table">

            <thead>

                <tr>

                    <th>TRB No.</th>

                    <th>Cadet</th>

                    <th>Course</th>

                    <th>Batch</th>

                    <th>Rank</th>

                    <th>Verification</th>

                    <th>Deployment</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody id="cadetTableBody">

                @forelse ($cadets as $cadet)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | Deployment Status
                        |--------------------------------------------------------------------------
                        */

                        $deploymentStatus =
                            optional($cadet->deployment)->status;

                        $deploymentStatus =
                            $deploymentStatus
                                ? strtolower(trim($deploymentStatus))
                                : 'not deployed';


                        /*
                        |--------------------------------------------------------------------------
                        | Verification Status
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
                        | Batch
                        |--------------------------------------------------------------------------
                        */

                        $batchYear =
                            optional($cadet->batch)->batch_year;


                        /*
                        |--------------------------------------------------------------------------
                        | Photo
                        |--------------------------------------------------------------------------
                        */

                        $photoUrl = $cadet->photo
                            ? asset('storage/' . $cadet->photo)
                            : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';

                    @endphp


                    <tr
                        class="cadet-row"

                        data-course="{{ strtolower(
                            optional($cadet->course)->course_code
                            ?? $cadet->course
                            ?? ''
                        ) }}"

                        data-batch="{{ strtolower(
                            $batchYear ?? ''
                        ) }}"

                        data-deployment="{{ strtolower(
                            $deploymentStatus
                        ) }}"

                        data-verification="{{ strtolower(
                            $verificationStatus
                        ) }}"
                    >

                        {{-- TRB --}}

                        <td>
                            {{ $cadet->trb_no ?? '—' }}
                        </td>


                        {{-- Cadet --}}

                        <td>

                            <div class="cadet-name-cell">

                                <div class="cadet-mini-photo">

                                    <img
                                        src="{{ $photoUrl }}"
                                        alt="{{ $cadet->name }}"
                                        loading="lazy"
                                        onerror="
                                            this.onerror=null;
                                            this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
                                        "
                                    >

                                </div>

                                <div class="cadet-name-info">

                                    <strong>
                                        {{ $cadet->name }}
                                    </strong>

                                    <span>
                                        {{ $cadet->email ?? 'No email available' }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- Course --}}

                        <td>

                            {{ optional($cadet->course)->course_code
                                ?? $cadet->course
                                ?? '—'
                            }}

                        </td>


                        {{-- Batch --}}

                        <td>
                            {{ $batchYear ?? '—' }}
                        </td>


                        {{-- Rank --}}

                        <td>
                            {{ $cadet->rank ?? '—' }}
                        </td>


                        {{-- Verification --}}

                        <td>

                            @if ($verificationStatus === 'verified')

                                <span class="dm-badge badge-green">
                                    Verified
                                </span>

                            @elseif ($verificationStatus === 'deficiency')

                                <span class="dm-badge badge-orange">
                                    Deficiency
                                </span>

                            @else

                                <span class="dm-badge badge-blue">
                                    Pending
                                </span>

                            @endif

                        </td>


                        {{-- Deployment --}}

                        <td>

                            @if ($deploymentStatus === 'completed')

                                <span class="dm-badge badge-green">
                                    Completed
                                </span>

                            @elseif ($deploymentStatus === 'ongoing')

                                <span class="dm-badge badge-blue">
                                    Ongoing
                                </span>

                            @else

                                <span class="dm-badge badge-gray">
                                    Not Deployed
                                </span>

                            @endif

                        </td>


                        {{-- Action --}}

                        <td>

                            <button
                                type="button"
                                class="btn-view cadet-view-profile"

                                data-name="{{ $cadet->name }}"
                                data-trb="{{ $cadet->trb_no ?? '—' }}"

                                data-course="{{ optional($cadet->course)->course_code
                                    ?? $cadet->course
                                    ?? '—'
                                }}"

                                data-batch="{{ $batchYear ?? '—' }}"

                                data-rank="{{ $cadet->rank ?? '—' }}"

                                data-contact="{{ $cadet->contact ?? '—' }}"

                                data-birth="{{ $cadet->birth_date
                                    ?? $cadet->date_of_birth
                                    ?? '—'
                                }}"

                                data-email="{{ $cadet->email ?? '—' }}"

                                data-verification="{{ $verificationStatus }}"

                                data-deployment="{{ $deploymentStatus }}"

                                data-photo="{{ $photoUrl }}"
                            >

                                <i class="fas fa-eye"></i>

                                View

                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8">

                            <div class="empty-state">

                                <div class="empty-state-icon">

                                    <i class="fas fa-users-slash"></i>

                                </div>

                                <h4>
                                    No Cadets Found
                                </h4>

                                <p>
                                    There are currently no cadet records available.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
         PAGINATION
         ===================================================== --}}

    @if (method_exists($cadets, 'links'))

        <div>
            {{ $cadets->links() }}
        </div>

    @endif


</div>


{{-- =========================================================
     CADET PROFILE MODAL
     ========================================================= --}}

<div
    id="cadetProfileModal"
    class="custom-modal-overlay"
    aria-hidden="true"
>

    <div
        class="custom-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cadetModalTitle"
    >

        {{-- Modal Header --}}

        <div class="custom-modal-header">

            <h3 id="cadetModalTitle">
                Cadet Profile
            </h3>

            <button
                type="button"
                class="modal-close"
                id="closeCadetModal"
                aria-label="Close"
            >
                <i class="fas fa-times"></i>
            </button>

        </div>


        {{-- Modal Body --}}

        <div class="custom-modal-body">

            {{-- Profile --}}

            <div class="profile-section">

                <div class="cadet-profile">

                    <img
                        id="modalCadetPhoto"
                        src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                        alt="Cadet Profile"
                    >

                </div>


                <div class="profile-info">

                    <h3 id="modalCadetName">
                        —
                    </h3>

                    <p id="modalCadetCourse">
                        —
                    </p>

                    <span
                        class="trb-number"
                        id="modalCadetTrb"
                    >
                        TRB: —
                    </span>

                </div>

            </div>


            {{-- Personal Information --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    Personal Information
                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Full Name
                    </span>

                    <span
                        class="detail-value"
                        id="detailName"
                    >
                        —
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        TRB Number
                    </span>

                    <span
                        class="detail-value"
                        id="detailTrb"
                    >
                        —
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Email
                    </span>

                    <span
                        class="detail-value"
                        id="detailEmail"
                    >
                        —
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Contact
                    </span>

                    <span
                        class="detail-value"
                        id="detailContact"
                    >
                        —
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Birth Date
                    </span>

                    <span
                        class="detail-value"
                        id="detailBirth"
                    >
                        —
                    </span>

                </div>

            </div>


            {{-- Academic Information --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    Academic Information
                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Course
                    </span>

                    <span
                        class="detail-value"
                        id="detailCourse"
                    >
                        —
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Batch
                    </span>

                    <span
                        class="detail-value"
                        id="detailBatch"
                    >
                        —
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Rank
                    </span>

                    <span
                        class="detail-value"
                        id="detailRank"
                    >
                        —
                    </span>

                </div>

            </div>


            {{-- Status Information --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    Status Information
                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Verification
                    </span>

                    <span
                        class="detail-value"
                        id="detailVerification"
                    >
                        —
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Deployment
                    </span>

                    <span
                        class="detail-value"
                        id="detailDeployment"
                    >
                        —
                    </span>

                </div>

            </div>


            {{-- Footer --}}

            <div class="modal-footer">

                <button
                    type="button"
                    class="modal-footer-btn"
                    id="closeCadetModalFooter"
                >
                    Close
                </button>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       ELEMENTS
       ===================================================== */

    const modal =
        document.getElementById('cadetProfileModal');

    const closeModalButton =
        document.getElementById('closeCadetModal');

    const closeModalFooter =
        document.getElementById('closeCadetModalFooter');

    const viewButtons =
        document.querySelectorAll('.cadet-view-profile');

    const rows =
        document.querySelectorAll('.cadet-row');


    const courseFilter =
        document.getElementById('courseFilter');

    const batchFilter =
        document.getElementById('batchFilter');

    const deploymentFilter =
        document.getElementById('deploymentFilter');

    const verificationFilter =
        document.getElementById('verificationFilter');

    const searchFilter =
        document.getElementById('searchFilter');


    const totalCount =
        document.getElementById('totalCount');

    const verifiedCount =
        document.getElementById('verifiedCount');

    const pendingCount =
        document.getElementById('pendingCount');

    const deficiencyCount =
        document.getElementById('deficiencyCount');


    /* =====================================================
       DEFAULT PHOTO
       ===================================================== */

    const defaultPhoto =
        'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';


    /* =====================================================
       HELPER
       ===================================================== */

    function safeValue(value) {

        if (
            value === undefined ||
            value === null ||
            value === '' ||
            value === 'null' ||
            value === 'undefined'
        ) {
            return '—';
        }

        return value;
    }


    /* =====================================================
       OPEN MODAL
       ===================================================== */

    function openModal(button) {

        if (!modal || !button) {
            return;
        }


        const name =
            safeValue(button.dataset.name);

        const trb =
            safeValue(button.dataset.trb);

        const course =
            safeValue(button.dataset.course);

        const batch =
            safeValue(button.dataset.batch);

        const rank =
            safeValue(button.dataset.rank);

        const contact =
            safeValue(button.dataset.contact);

        const birth =
            safeValue(button.dataset.birth);

        const email =
            safeValue(button.dataset.email);

        const verification =
            safeValue(button.dataset.verification);

        const deployment =
            safeValue(button.dataset.deployment);

        const photo =
            safeValue(button.dataset.photo);


        /* -------------------------------------------------
           Profile
           ------------------------------------------------- */

        document.getElementById(
            'modalCadetName'
        ).textContent = name;


        document.getElementById(
            'modalCadetCourse'
        ).textContent = course;


        document.getElementById(
            'modalCadetTrb'
        ).textContent = 'TRB: ' + trb;


        const modalPhoto =
            document.getElementById('modalCadetPhoto');


        modalPhoto.src =
            photo !== '—'
                ? photo
                : defaultPhoto;


        modalPhoto.onerror = function () {

            this.onerror = null;

            this.src = defaultPhoto;

        };


        /* -------------------------------------------------
           Personal Information
           ------------------------------------------------- */

        document.getElementById(
            'detailName'
        ).textContent = name;


        document.getElementById(
            'detailTrb'
        ).textContent = trb;


        document.getElementById(
            'detailEmail'
        ).textContent = email;


        document.getElementById(
            'detailContact'
        ).textContent = contact;


        document.getElementById(
            'detailBirth'
        ).textContent = birth;


        /* -------------------------------------------------
           Academic Information
           ------------------------------------------------- */

        document.getElementById(
            'detailCourse'
        ).textContent = course;


        document.getElementById(
            'detailBatch'
        ).textContent = batch;


        document.getElementById(
            'detailRank'
        ).textContent = rank;


        /* -------------------------------------------------
           Verification
           ------------------------------------------------- */

        const verificationElement =
            document.getElementById(
                'detailVerification'
            );


        verificationElement.innerHTML = '';


        const verificationBadge =
            document.createElement('span');


        verificationBadge.classList.add(
            'modal-status'
        );


        if (verification === 'verified') {

            verificationBadge.classList.add(
                'completed'
            );

            verificationBadge.textContent =
                'Verified';

        } else if (
            verification === 'deficiency'
        ) {

            verificationBadge.classList.add(
                'ongoing'
            );

            verificationBadge.textContent =
                'Deficiency';

        } else {

            verificationBadge.classList.add(
                'not-deployed'
            );

            verificationBadge.textContent =
                'Pending';

        }


        verificationElement.appendChild(
            verificationBadge
        );


        /* -------------------------------------------------
           Deployment
           ------------------------------------------------- */

        const deploymentElement =
            document.getElementById(
                'detailDeployment'
            );


        deploymentElement.innerHTML = '';


        const deploymentBadge =
            document.createElement('span');


        deploymentBadge.classList.add(
            'modal-status'
        );


        if (deployment === 'completed') {

            deploymentBadge.classList.add(
                'completed'
            );

            deploymentBadge.textContent =
                'Completed';

        } else if (
            deployment === 'ongoing'
        ) {

            deploymentBadge.classList.add(
                'ongoing'
            );

            deploymentBadge.textContent =
                'Ongoing';

        } else {

            deploymentBadge.classList.add(
                'not-deployed'
            );

            deploymentBadge.textContent =
                'Not Deployed';

        }


        deploymentElement.appendChild(
            deploymentBadge
        );


        /* -------------------------------------------------
           Show
           ------------------------------------------------- */

        modal.classList.add('show');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow =
            'hidden';

    }


    /* =====================================================
       CLOSE MODAL
       ===================================================== */

    function closeModal() {

        if (!modal) {
            return;
        }


        modal.classList.remove('show');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';

    }


    /* =====================================================
       VIEW BUTTON EVENTS
       ===================================================== */

    viewButtons.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                openModal(this);

            }
        );

    });


    /* =====================================================
       CLOSE BUTTON EVENTS
       ===================================================== */

    if (closeModalButton) {

        closeModalButton.addEventListener(
            'click',
            closeModal
        );

    }


    if (closeModalFooter) {

        closeModalFooter.addEventListener(
            'click',
            closeModal
        );

    }


    /* =====================================================
       CLOSE WHEN CLICKING BACKDROP
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
                modal.classList.contains('show')
            ) {

                closeModal();

            }

        }
    );


    /* =====================================================
       TABLE FILTER
       ===================================================== */

    function filterTable() {

        const selectedCourse =
            (courseFilter?.value || '')
                .toLowerCase()
                .trim();


        const selectedBatch =
            (batchFilter?.value || '')
                .toLowerCase()
                .trim();


        const selectedDeployment =
            (deploymentFilter?.value || '')
                .toLowerCase()
                .trim();


        const selectedVerification =
            (verificationFilter?.value || '')
                .toLowerCase()
                .trim();


        const searchTerm =
            (searchFilter?.value || '')
                .toLowerCase()
                .trim();


        let visibleTotal = 0;
        let visibleVerified = 0;
        let visiblePending = 0;
        let visibleDeficiency = 0;


        rows.forEach(function (row) {

            const rowCourse =
                (row.dataset.course || '')
                    .toLowerCase();


            const rowBatch =
                (row.dataset.batch || '')
                    .toLowerCase();


            const rowDeployment =
                (row.dataset.deployment || '')
                    .toLowerCase();


            const rowVerification =
                (row.dataset.verification || '')
                    .toLowerCase();


            const rowText =
                row.textContent
                    .toLowerCase();


            const matchesCourse =
                !selectedCourse ||
                rowCourse === selectedCourse;


            const matchesBatch =
                !selectedBatch ||
                rowBatch === selectedBatch;


            const matchesDeployment =
                !selectedDeployment ||
                rowDeployment === selectedDeployment;


            const matchesVerification =
                !selectedVerification ||
                rowVerification === selectedVerification;


            const matchesSearch =
                !searchTerm ||
                rowText.includes(searchTerm);


            const shouldShow =
                matchesCourse &&
                matchesBatch &&
                matchesDeployment &&
                matchesVerification &&
                matchesSearch;


            row.style.display =
                shouldShow
                    ? ''
                    : 'none';


            if (shouldShow) {

                visibleTotal++;


                if (
                    rowVerification ===
                    'verified'
                ) {

                    visibleVerified++;

                }


                if (
                    rowVerification ===
                    'pending'
                ) {

                    visiblePending++;

                }


                if (
                    rowVerification ===
                    'deficiency'
                ) {

                    visibleDeficiency++;

                }

            }

        });


        if (totalCount) {

            totalCount.textContent =
                visibleTotal;

        }


        if (verifiedCount) {

            verifiedCount.textContent =
                visibleVerified;

        }


        if (pendingCount) {

            pendingCount.textContent =
                visiblePending;

        }


        if (deficiencyCount) {

            deficiencyCount.textContent =
                visibleDeficiency;

        }

    }


    /* =====================================================
       FILTER EVENTS
       ===================================================== */

    [
        courseFilter,
        batchFilter,
        deploymentFilter,
        verificationFilter
    ].forEach(function (element) {

        if (!element) {
            return;
        }

        element.addEventListener(
            'change',
            filterTable
        );

    });


    if (searchFilter) {

        searchFilter.addEventListener(
            'input',
            filterTable
        );

    }


    /* =====================================================
       INITIAL FILTER
       ===================================================== */

    filterTable();

});
</script>

@endsection