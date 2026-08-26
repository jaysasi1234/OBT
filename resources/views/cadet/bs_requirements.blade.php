@extends('layouts.cadet')

@section('content')

<style>

/* =========================================================
   RESET / PAGE
========================================================= */

.bs-requirements-page{
    width:100%;
    max-width:1400px;
    margin:0 auto;
    padding:10px 0 30px;
    color:#fff;
}

.bs-requirements-page *,
.bs-requirements-page *::before,
.bs-requirements-page *::after{
    box-sizing:border-box;
}

/* =========================================================
   PAGE HEADER
========================================================= */

.bs-page-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:25px;

    margin-bottom:24px;
}

.bs-header-left{
    min-width:0;
}

.bs-header-title{
    display:flex;
    align-items:center;
    gap:12px;

    margin:0 0 7px;

    font-size:30px;
    font-weight:750;
    line-height:1.2;

    color:#fff;
}

.bs-title-icon{
    width:48px;
    height:48px;

    display:flex;
    align-items:center;
    justify-content:center;

    flex:0 0 48px;

    border-radius:14px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #4f46e5
        );

    box-shadow:
        0 10px 25px rgba(37,99,235,.28);

    font-size:23px;
}

.bs-header-description{
    margin:0;

    color:#94a3b8;

    font-size:14px;
    line-height:1.6;
}

/* =========================================================
   SUMMARY
========================================================= */

.bs-summary{
    position:relative;

    min-width:205px;
    padding:17px 22px;

    display:flex;
    align-items:center;
    gap:14px;

    overflow:hidden;

    border-radius:17px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    border:1px solid rgba(255,255,255,.14);

    box-shadow:
        0 14px 35px rgba(15,23,42,.35);
}

.bs-summary::after{
    content:"";

    position:absolute;

    width:100px;
    height:100px;

    right:-35px;
    top:-40px;

    border-radius:50%;

    background:rgba(255,255,255,.10);
}

.bs-summary-icon{
    width:43px;
    height:43px;

    flex:0 0 43px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:12px;

    background:rgba(255,255,255,.16);

    font-size:20px;
}

.bs-summary-content{
    position:relative;
    z-index:1;
}

.bs-summary-number{
    margin:0;

    font-size:29px;
    font-weight:800;
    line-height:1;
}

.bs-summary-label{
    display:block;

    margin-top:5px;

    color:rgba(255,255,255,.75);

    font-size:11px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.5px;
}

/* =========================================================
   MAIN CARD
========================================================= */

.bs-requirements-card{
    width:100%;

    overflow:hidden;

    border-radius:20px;

    background:
        linear-gradient(
            145deg,
            rgba(30,58,138,.72),
            rgba(15,23,60,.94)
        );

    border:1px solid rgba(255,255,255,.09);

    box-shadow:
        0 18px 45px rgba(0,0,0,.28);
}

/* =========================================================
   CARD TOP BAR
========================================================= */

.bs-card-top{
    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:15px;

    padding:20px 24px;

    border-bottom:
        1px solid rgba(255,255,255,.08);
}

.bs-card-heading{
    display:flex;
    align-items:center;
    gap:11px;
}

.bs-card-heading-icon{
    width:38px;
    height:38px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:10px;

    background:rgba(37,99,235,.18);

    border:1px solid rgba(59,130,246,.20);

    font-size:17px;
}

.bs-card-heading h3{
    margin:0;

    font-size:16px;
    font-weight:700;

    color:#fff;
}

.bs-card-heading p{
    margin:3px 0 0;

    color:#94a3b8;

    font-size:12px;
}

/* =========================================================
   TABLE WRAPPER
========================================================= */

.bs-table-wrapper{
    width:100%;

    overflow-x:auto;
    overflow-y:hidden;

    -webkit-overflow-scrolling:touch;

    scrollbar-width:thin;
}

/* =========================================================
   TABLE
========================================================= */

.bs-table{
    width:100%;
    min-width:850px;

    border-collapse:collapse;
}

.bs-table thead{
    background:rgba(30,58,138,.65);
}

.bs-table th{
    padding:14px 20px;

    color:#94a3b8;

    font-size:11px;
    font-weight:700;

    text-transform:uppercase;
    letter-spacing:.6px;

    text-align:left;

    white-space:nowrap;
}

.bs-table td{
    padding:17px 20px;

    color:#e2e8f0;

    font-size:13px;

    line-height:1.5;

    border-bottom:
        1px solid rgba(255,255,255,.055);

    vertical-align:middle;
}

.bs-table tbody tr{
    transition:
        background .2s ease;
}

.bs-table tbody tr:hover{
    background:rgba(59,130,246,.075);
}

.bs-table tbody tr:last-child td{
    border-bottom:none;
}

/* =========================================================
   NUMBER
========================================================= */

.bs-number{
    width:30px;
    height:30px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:9px;

    background:rgba(255,255,255,.07);

    color:#94a3b8;

    font-size:12px;
    font-weight:700;
}

/* =========================================================
   REQUIREMENT
========================================================= */

.bs-requirement{
    display:flex;
    align-items:center;
    gap:12px;

    min-width:220px;
}

.bs-requirement-icon{
    width:38px;
    height:38px;

    flex:0 0 38px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:10px;

    background:
        linear-gradient(
            135deg,
            rgba(37,99,235,.22),
            rgba(79,70,229,.16)
        );

    border:1px solid rgba(96,165,250,.12);

    font-size:16px;
}

.bs-requirement-name{
    color:#fff;

    font-size:13px;
    font-weight:650;

    line-height:1.45;

    word-break:break-word;
}

/* =========================================================
   FREQUENCY
========================================================= */

.bs-frequency{
    display:inline-flex;
    align-items:center;
    gap:6px;

    padding:7px 11px;

    border-radius:8px;

    background:rgba(255,255,255,.055);

    border:1px solid rgba(255,255,255,.06);

    color:#cbd5e1;

    font-size:11px;
    font-weight:600;

    white-space:nowrap;
}

.bs-frequency-dot{
    width:6px;
    height:6px;

    border-radius:50%;

    background:#60a5fa;
}

/* =========================================================
   STATUS
========================================================= */

.bs-status{
    display:inline-flex;
    align-items:center;
    gap:7px;

    padding:7px 12px;

    border-radius:9px;

    font-size:11px;
    font-weight:700;

    white-space:nowrap;

    border:1px solid transparent;
}

.bs-status-dot{
    width:6px;
    height:6px;

    border-radius:50%;
}

.bs-status.approved{
    color:#4ade80;

    background:rgba(34,197,94,.10);

    border-color:rgba(74,222,128,.15);
}

.bs-status.approved .bs-status-dot{
    background:#4ade80;
}

.bs-status.pending{
    color:#fbbf24;

    background:rgba(245,158,11,.10);

    border-color:rgba(251,191,36,.15);
}

.bs-status.pending .bs-status-dot{
    background:#fbbf24;
}

.bs-status.rejected{
    color:#f87171;

    background:rgba(239,68,68,.10);

    border-color:rgba(248,113,113,.15);
}

.bs-status.rejected .bs-status-dot{
    background:#f87171;
}

.bs-status.none{
    color:#94a3b8;

    background:rgba(100,116,139,.10);

    border-color:rgba(148,163,184,.10);
}

.bs-status.none .bs-status-dot{
    background:#64748b;
}

.bs-status.submitted{
    color:#60a5fa;
    background:rgba(59,130,246,.10);
    border-color:rgba(96,165,250,.15);
}

.bs-status.submitted .bs-status-dot{
    background:#60a5fa;
}
/* =========================================================
   ACTIONS
========================================================= */

.bs-action{
    display:inline-flex;

    align-items:center;
    justify-content:center;
    gap:7px;

    min-width:128px;

    padding:10px 14px;

    border:none;
    border-radius:9px;

    color:#fff;

    font-size:12px;
    font-weight:700;

    cursor:pointer;

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}

.bs-action:hover{
    transform:translateY(-2px);
}

.bs-action:focus-visible{
    outline:2px solid #60a5fa;
    outline-offset:2px;
}

.bs-upload{
    background:#2563eb;
}

.bs-upload:hover{
    background:#1d4ed8;

    box-shadow:
        0 8px 20px rgba(37,99,235,.25);
}

.bs-replace{
    background:#d97706;
}

.bs-replace:hover{
    background:#b45309;

    box-shadow:
        0 8px 20px rgba(245,158,11,.22);
}

.bs-reupload{
    background:#dc2626;
}

.bs-reupload:hover{
    background:#b91c1c;

    box-shadow:
        0 8px 20px rgba(220,38,38,.22);
}

.bs-completed{
    background:rgba(22,163,74,.18);

    color:#4ade80;

    border:1px solid rgba(74,222,128,.18);

    cursor:not-allowed;
}

.bs-completed:hover{
    transform:none;
}

/* =========================================================
   EMPTY / LOCKED STATE
========================================================= */

.bs-state-row td{
    border-bottom:none;
}

.bs-state{
    min-height:220px;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    padding:35px 20px;

    text-align:center;
}

.bs-state-icon{
    width:65px;
    height:65px;

    display:flex;
    align-items:center;
    justify-content:center;

    margin-bottom:15px;

    border-radius:18px;

    background:rgba(245,158,11,.10);

    border:1px solid rgba(245,158,11,.15);

    font-size:28px;
}

.bs-state h4{
    margin:0 0 7px;

    color:#fff;

    font-size:16px;
}

.bs-state p{
    max-width:450px;

    margin:0;

    color:#94a3b8;

    font-size:13px;
    line-height:1.6;
}

.bs-state.locked h4{
    color:#fbbf24;
}

/* =========================================================
   MODAL OVERLAY
========================================================= */

.bs-modal{
    display:none;

    position:fixed;

    inset:0;

    z-index:9999;

    padding:20px;

    align-items:center;
    justify-content:center;

    background:rgba(2,6,23,.78);

    backdrop-filter:blur(7px);

    overflow-y:auto;
}

.bs-modal.active{
    display:flex;
}

/* =========================================================
   MODAL
========================================================= */

.bs-modal-box{
    width:500px;
    max-width:100%;
    max-height:calc(100vh - 40px);

    overflow-y:auto;

    border-radius:20px;

    background:
        linear-gradient(
            145deg,
            #1e3a8a,
            #172554
        );

    border:1px solid rgba(255,255,255,.12);

    box-shadow:
        0 30px 80px rgba(0,0,0,.55);

    animation:
        bsModalShow .25s ease;
}

@keyframes bsModalShow{

    from{
        opacity:0;
        transform:translateY(15px) scale(.97);
    }

    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }

}

/* =========================================================
   MODAL HEADER
========================================================= */

.bs-modal-header{
    display:flex;
    align-items:center;
    justify-content:space-between;

    gap:15px;

    padding:20px 22px;

    border-bottom:
        1px solid rgba(255,255,255,.08);
}

.bs-modal-title{
    display:flex;
    align-items:center;
    gap:11px;
}

.bs-modal-icon{
    width:40px;
    height:40px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:11px;

    background:rgba(37,99,235,.20);

    font-size:18px;
}

.bs-modal-title h3{
    margin:0;

    font-size:17px;
    font-weight:700;
}

.bs-modal-title p{
    margin:3px 0 0;

    color:#94a3b8;

    font-size:11px;
}

.bs-close{
    width:36px;
    height:36px;

    display:flex;
    align-items:center;
    justify-content:center;

    flex:0 0 36px;

    border:none;
    border-radius:9px;

    background:rgba(255,255,255,.06);

    color:#94a3b8;

    font-size:24px;

    cursor:pointer;

    transition:.2s ease;
}

.bs-close:hover{
    background:rgba(239,68,68,.18);
    color:#f87171;
}

/* =========================================================
   MODAL BODY
========================================================= */

.bs-modal-body{
    padding:22px;
}

.bs-form-group{
    margin-bottom:18px;
}

.bs-form-label{
    display:block;

    margin-bottom:8px;

    color:#cbd5e1;

    font-size:12px;
    font-weight:700;
}

.bs-selected{
    width:100%;

    padding:12px 14px;

    border-radius:10px;

    background:rgba(255,255,255,.07);

    border:1px solid rgba(255,255,255,.08);

    color:#fff;

    font-size:13px;
    font-weight:600;

    line-height:1.5;

    word-break:break-word;
}

.bs-input,
.bs-textarea{
    width:100%;

    padding:12px 14px;

    border:1px solid rgba(255,255,255,.08);

    border-radius:10px;

    outline:none;

    background:#10204d;

    color:#fff;

    font-family:inherit;

    font-size:13px;

    transition:
        border .2s ease,
        box-shadow .2s ease;
}

.bs-input:focus,
.bs-textarea:focus{
    border-color:#3b82f6;

    box-shadow:
        0 0 0 3px rgba(59,130,246,.10);
}

.bs-textarea{
    min-height:105px;

    resize:vertical;
}

.bs-input[type="file"]{
    padding:9px;

    cursor:pointer;
}

.bs-input[type="file"]::file-selector-button{
    margin-right:10px;

    padding:8px 12px;

    border:none;

    border-radius:7px;

    background:#2563eb;

    color:#fff;

    font-size:11px;
    font-weight:700;

    cursor:pointer;
}

.bs-help{
    margin-top:7px;

    color:#64748b;

    font-size:11px;
    line-height:1.5;
}

/* =========================================================
   MODAL FOOTER
========================================================= */

.bs-modal-footer{
    display:flex;
    justify-content:flex-end;
    gap:10px;

    padding:17px 22px;

    border-top:
        1px solid rgba(255,255,255,.08);
}

.bs-cancel,
.bs-submit{
    min-height:40px;

    padding:10px 17px;

    border:none;
    border-radius:9px;

    color:#fff;

    font-size:12px;
    font-weight:700;

    cursor:pointer;

    transition:.2s ease;
}

.bs-cancel{
    background:#475569;
}

.bs-cancel:hover{
    background:#334155;
}

.bs-submit{
    background:#2563eb;
}

.bs-submit:hover{
    background:#1d4ed8;

    box-shadow:
        0 7px 18px rgba(37,99,235,.25);
}

.bs-submit:disabled{
    opacity:.65;
    cursor:not-allowed;
}

/* =========================================================
   TABLET
========================================================= */

@media(max-width:900px){

    .bs-page-header{
        align-items:stretch;
        flex-direction:column;
        gap:16px;
    }

    .bs-summary{
        width:100%;
        min-width:0;
    }

    .bs-requirements-card{
        border-radius:17px;
    }

}

/* =========================================================
   MOBILE
========================================================= */

@media(max-width:650px){

    .bs-requirements-page{
        padding:0 0 25px;
    }

    .bs-header-title{
        font-size:24px;
    }

    .bs-title-icon{
        width:42px;
        height:42px;
        flex-basis:42px;

        border-radius:12px;

        font-size:20px;
    }

    .bs-header-description{
        font-size:13px;
    }

    .bs-summary{
        padding:15px 17px;
    }

    .bs-summary-number{
        font-size:27px;
    }

    .bs-card-top{
        padding:16px;
    }

    .bs-card-heading h3{
        font-size:14px;
    }

    .bs-card-heading p{
        font-size:11px;
    }

    /*
     * Convert table to cards.
     */

    .bs-table-wrapper{
        overflow:visible;
    }

    .bs-table{
        min-width:0;
        width:100%;
        display:block;
    }

    .bs-table thead{
        display:none;
    }

    .bs-table tbody{
        display:block;
        padding:10px;
    }

    .bs-table tbody tr{
        display:block;

        width:100%;

        margin-bottom:12px;
        padding:13px;

        border-radius:14px;

        background:
            linear-gradient(
                145deg,
                rgba(34,53,111,.95),
                rgba(25,42,91,.95)
            );

        border:
            1px solid rgba(255,255,255,.07);

        box-shadow:
            0 7px 18px rgba(0,0,0,.18);
    }

    .bs-table tbody tr:hover{
        background:
            linear-gradient(
                145deg,
                rgba(38,59,121,.98),
                rgba(27,45,98,.98)
            );
    }

    .bs-table td{
        display:flex;

        align-items:center;
        justify-content:space-between;

        gap:15px;

        width:100%;

        padding:10px 0;

        border-bottom:
            1px solid rgba(255,255,255,.06);

        text-align:right;

        font-size:12px;
    }

    .bs-table td:last-child{
        border-bottom:none;
        padding-bottom:2px;
    }

    .bs-table td::before{
        flex:0 0 auto;

        color:#64748b;

        font-size:10px;
        font-weight:700;

        text-transform:uppercase;
        letter-spacing:.5px;

        text-align:left;
    }

    .bs-table td:nth-child(1)::before{
        content:"#";
    }

    .bs-table td:nth-child(2)::before{
        content:"Requirement";
    }

    .bs-table td:nth-child(3)::before{
        content:"Frequency";
    }

    .bs-table td:nth-child(4)::before{
        content:"Status";
    }

    .bs-table td:nth-child(5)::before{
        content:"Action";
    }

    /*
     * Requirement row.
     */

    .bs-table td:nth-child(2){
        display:block;
        text-align:left;
    }

    .bs-table td:nth-child(2)::before{
        display:block;
        margin-bottom:8px;
    }

    .bs-requirement{
        min-width:0;
    }

    .bs-requirement-name{
        font-size:13px;
    }

    /*
     * Action.
     */

    .bs-table td:nth-child(5){
        display:block;
        text-align:left;
    }

    .bs-table td:nth-child(5)::before{
        display:block;
        margin-bottom:8px;
    }

    .bs-action{
        width:100%;
        min-width:0;

        padding:11px 14px;
    }

    /*
     * State.
     */

    .bs-state{
        min-height:190px;
    }

    /*
     * Modal.
     */

    .bs-modal{
        padding:10px;

        align-items:flex-start;
    }

    .bs-modal-box{
        width:100%;

        max-height:calc(100vh - 20px);

        margin-top:10px;

        border-radius:16px;
    }

    .bs-modal-header{
        padding:16px;
    }

    .bs-modal-body{
        padding:17px;
    }

    .bs-modal-footer{
        padding:14px 17px;

        flex-direction:column-reverse;
    }

    .bs-cancel,
    .bs-submit{
        width:100%;
    }

}

/* =========================================================
   SMALL PHONES
========================================================= */

@media(max-width:380px){

    .bs-header-title{
        font-size:21px;
    }

    .bs-title-icon{
        width:38px;
        height:38px;
        flex-basis:38px;
    }

    .bs-card-top{
        padding:13px;
    }

    .bs-table tbody{
        padding:8px;
    }

    .bs-table tbody tr{
        padding:11px;
    }

    .bs-requirement-icon{
        width:34px;
        height:34px;
        flex-basis:34px;
    }

    .bs-requirement-name{
        font-size:12px;
    }

    .bs-status{
        font-size:10px;
        padding:6px 9px;
    }

    .bs-frequency{
        font-size:10px;
        padding:6px 8px;
    }

}

/* =========================================================
   ACCESSIBILITY
========================================================= */

@media(prefers-reduced-motion:reduce){

    .bs-table tbody tr,
    .bs-action,
    .bs-modal-box,
    .bs-close{
        transition:none;
        animation:none;
    }

}

/* =========================================================
   PREVENT HORIZONTAL OVERFLOW
========================================================= */

html,
body{
    max-width:100%;
    overflow-x:hidden;
}

</style>


<div class="container mt-4 bs-requirements-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="bs-page-header">

        <div class="bs-header-left">

            <h2 class="bs-header-title">

                <span class="bs-title-icon">
                    🎓
                </span>

                BS Requirements

            </h2>

            <p class="bs-header-description">
                Upload and manage the documents required for your BS completion.
            </p>

        </div>


        {{-- SUMMARY --}}

        <div class="bs-summary">

            <div class="bs-summary-icon">
                📋
            </div>

            <div class="bs-summary-content">

                <h3 class="bs-summary-number">
                    {{ count($requirements) }}
                </h3>

                <span class="bs-summary-label">
                    Total Requirements
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         REQUIREMENTS CARD
    ====================================================== --}}

    <div class="bs-requirements-card">


        {{-- CARD HEADER --}}

        <div class="bs-card-top">

            <div class="bs-card-heading">

                <div class="bs-card-heading-icon">
                    📑
                </div>

                <div>

                    <h3>
                        Completion Requirements
                    </h3>

                    <p>
                        Track and submit your required documents
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="bs-table-wrapper">

            <table class="bs-table">

                <thead>

                    <tr>

                        <th style="width:65px;">
                            #
                        </th>

                        <th>
                            Requirement
                        </th>

                        <th>
                            Frequency
                        </th>

                        <th>
                            Status
                        </th>

                        <th style="width:180px;">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>


                    {{-- =========================================
                         TRAINING NOT COMPLETED
                    ========================================== --}}

                    @if($notCompleted)

                        <tr class="bs-state-row">

                            <td colspan="5">

                                <div class="bs-state locked">

                                    <div class="bs-state-icon">
                                        🎓
                                    </div>

                                    <h4>
                                        BS Requirements Locked
                                    </h4>

                                    <p>
                                        BS completion requirements will become
                                        available after you complete your
                                        onboard training.
                                    </p>

                                </div>

                            </td>

                        </tr>


                    @else


                        {{-- =====================================
                             REQUIREMENTS
                        ====================================== --}}

                        @forelse($requirements as $requirement)

                            @php

                                $submission =
                                    $submissions[$requirement->id] ?? null;

                            @endphp


                            <tr>


                                {{-- NUMBER --}}

                                <td>

                                    <div class="bs-number">
                                        {{ $loop->iteration }}
                                    </div>

                                </td>


                                {{-- REQUIREMENT --}}

                                <td>

                                    <div class="bs-requirement">

                                        <div class="bs-requirement-icon">
                                            📄
                                        </div>

                                        <div class="bs-requirement-name">

                                            {{ $requirement->title }}

                                        </div>

                                    </div>

                                </td>


                                {{-- FREQUENCY --}}

                                <td>

                                    <span class="bs-frequency">

                                        <span class="bs-frequency-dot"></span>

                                        After Deployment

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($submission)

                                        @if($submission->status == 'Approved')

                                            <span class="bs-status approved">

                                                <span class="bs-status-dot"></span>

                                                Approved

                                            </span>


                                    @elseif($submission->status == 'Submitted')
                                        <span class="bs-status submitted">
                                            <span class="bs-status-dot"></span>
                                            Submitted
                                        </span>


                                        @elseif($submission->status == 'Rejected')

                                            <span class="bs-status rejected">

                                                <span class="bs-status-dot"></span>

                                                Rejected

                                            </span>


                                        @else

                                            <span class="bs-status none">

                                                <span class="bs-status-dot"></span>

                                                {{ $submission->status }}

                                            </span>

                                        @endif


                                    @else

                                        <span class="bs-status none">

                                            <span class="bs-status-dot"></span>

                                            Not Submitted

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}

                                <td>

                                    @if(!$submission)

                                        <button
                                            type="button"
                                            class="bs-action bs-upload"
                                            data-id="{{ $requirement->id }}"
                                            data-title="{{ $requirement->title }}"
                                            onclick="openUploadModal(this)">

                                            📤 Upload

                                        </button>


                                        @elseif($submission->status == 'Submitted')
                                            <button
                                                type="button"
                                                class="bs-action bs-replace"
                                                data-id="{{ $requirement->id }}"
                                                data-title="{{ $requirement->title }}"
                                                onclick="openUploadModal(this)">
                                                🔄 Replace File
                                            </button>


                                    @elseif($submission->status == 'Rejected')

                                        <button
                                            type="button"
                                            class="bs-action bs-reupload"
                                            data-id="{{ $requirement->id }}"
                                            data-title="{{ $requirement->title }}"
                                            onclick="openUploadModal(this)">

                                            🔁 Re-upload

                                        </button>


                                    @elseif($submission->status == 'Approved')

                                        <button
                                            type="button"
                                            class="bs-action bs-completed"
                                            disabled>

                                            ✓ Completed

                                        </button>

                                    @endif

                                </td>

                            </tr>


                        @empty


                            {{-- =================================
                                 EMPTY
                            ================================== --}}

                            <tr class="bs-state-row">

                                <td colspan="5">

                                    <div class="bs-state">

                                        <div class="bs-state-icon">
                                            📋
                                        </div>

                                        <h4>
                                            No Requirements Available
                                        </h4>

                                        <p>
                                            There are currently no BS completion
                                            requirements assigned to you.
                                        </p>

                                    </div>

                                </td>

                            </tr>


                        @endforelse


                    @endif


                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     UPLOAD MODAL
========================================================= --}}

<div
    id="uploadModal"
    class="bs-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="uploadModalTitle">

    <div class="bs-modal-box">


        {{-- MODAL HEADER --}}

        <div class="bs-modal-header">

            <div class="bs-modal-title">

                <div class="bs-modal-icon">
                    📤
                </div>

                <div>

                    <h3 id="uploadModalTitle">
                        Upload Requirement
                    </h3>

                    <p>
                        Submit your required document
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="bs-close"
                onclick="closeUploadModal()"
                aria-label="Close">

                &times;

            </button>

        </div>


        {{-- FORM --}}

        <form
            id="uploadForm"
            action="{{ route('cadet.bs.requirements.upload') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            <div class="bs-modal-body">


                {{-- REQUIREMENT ID --}}

                <input
                    type="hidden"
                    id="requirement_id"
                    name="requirement_id">


                {{-- REQUIREMENT --}}

                <div class="bs-form-group">

                    <label class="bs-form-label">
                        Requirement
                    </label>

                    <div
                        id="requirementTitle"
                        class="bs-selected">
                    </div>

                </div>


                {{-- FILE --}}

                <div class="bs-form-group">

                    <label
                        class="bs-form-label"
                        for="attachment">

                        Select File

                    </label>

                    <input
                        type="file"
                        id="attachment"
                        name="attachment"
                        class="bs-input"
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        required>

                    <div class="bs-help">

                        Maximum file size: 10 MB.
                        Accepted formats: PDF, JPG, PNG, DOC, DOCX.

                    </div>

                </div>


                {{-- REMARKS --}}

                <div class="bs-form-group">

                    <label
                        class="bs-form-label"
                        for="remarks">

                        Remarks
                        <span style="color:#64748b;font-weight:500;">
                            (Optional)
                        </span>

                    </label>

                    <textarea
                        id="remarks"
                        name="remarks"
                        class="bs-textarea"
                        rows="4"
                        placeholder="Add any additional information about your submission..."></textarea>

                </div>


            </div>


            {{-- MODAL FOOTER --}}

            <div class="bs-modal-footer">

                <button
                    type="button"
                    class="bs-cancel"
                    onclick="closeUploadModal()">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="bs-submit"
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

function openUploadModal(button){

    const modal =
        document.getElementById('uploadModal');

    const requirementId =
        document.getElementById('requirement_id');

    const requirementTitle =
        document.getElementById('requirementTitle');

    const attachment =
        document.getElementById('attachment');

    const remarks =
        document.getElementById('remarks');

    const submitButton =
        document.getElementById('uploadSubmitBtn');


    requirementId.value =
        button.dataset.id;

    requirementTitle.textContent =
        button.dataset.title;

    attachment.value = '';

    remarks.value = '';

    submitButton.disabled = false;

    submitButton.textContent =
        '📤 Upload Document';


    modal.classList.add('active');

    document.body.style.overflow =
        'hidden';


    setTimeout(function(){

        attachment.focus();

    },150);

}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closeUploadModal(){

    const modal =
        document.getElementById('uploadModal');

    modal.classList.remove('active');

    document.body.style.overflow =
        '';

}


/* =========================================================
   CLICK OUTSIDE
========================================================= */

document
    .getElementById('uploadModal')
    .addEventListener('click', function(event){

        if(event.target === this){

            closeUploadModal();

        }

    });


/* =========================================================
   ESCAPE KEY
========================================================= */

document.addEventListener(
    'keydown',
    function(event){

        if(event.key === 'Escape'){

            const modal =
                document.getElementById('uploadModal');

            if(modal.classList.contains('active')){

                closeUploadModal();

            }

        }

    }
);


/* =========================================================
   PREVENT DOUBLE SUBMISSION
========================================================= */

const uploadForm =
    document.getElementById('uploadForm');

if(uploadForm){

    uploadForm.addEventListener(
        'submit',
        function(){

            const submitButton =
                document.getElementById('uploadSubmitBtn');

            submitButton.disabled = true;

            submitButton.textContent =
                '⏳ Uploading...';

        }
    );

}

</script>

@endsection