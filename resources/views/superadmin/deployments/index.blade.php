@extends('layouts.superadmin')

@section('content')

<style>

/* =========================================================
   SUPER ADMIN DEPLOYMENT MONITORING
   ========================================================= */

.page-header{
    margin-bottom:20px;
}

.page-header h2{
    color:white;
    margin:0;
    font-size:26px;
    font-weight:700;
}

.page-header p{
    color:#cbd5e1;
    margin-top:6px;
}


/* =========================================================
   MAIN CARD
   ========================================================= */

.card-container{
    background:#1f1b6b;
    padding:20px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.20);
}


/* =========================================================
   STATISTICS
   ========================================================= */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
    margin-bottom:25px;
}

.stat-card{
    background:linear-gradient(135deg,#312e81,#1f1b6b);
    border-radius:15px;
    padding:20px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 20px rgba(0,0,0,.25);
    transition:.25s;
}

.stat-card:hover{
    transform:translateY(-4px);
}

.stat-info h5{
    margin:0;
    font-size:15px;
    color:#cbd5e1;
}

.stat-info h2{
    margin-top:8px;
    font-size:34px;
    margin-bottom:0;
}

.stat-icon{
    font-size:42px;
}


/* =========================================================
   FILTERS
   ========================================================= */

.filter-container{
    margin-bottom:20px;
}

.filter-grid{
    display:grid;
    grid-template-columns:
        minmax(220px,1.5fr)
        minmax(160px,1fr)
        minmax(160px,1fr)
        minmax(160px,1fr);
    gap:15px;
}

.filter-grid input,
.filter-grid select{
    width:100%;
    box-sizing:border-box;
    padding:11px 15px;
    border:none;
    border-radius:10px;
    background:#111827;
    color:white;
    outline:none;
}

.filter-grid input::placeholder{
    color:#94a3b8;
}

.filter-grid input:focus,
.filter-grid select:focus{
    box-shadow:0 0 0 2px rgba(99,102,241,.45);
}

.filter-grid select option{
    background:#111827;
    color:white;
}


/* =========================================================
   TABLE HEADER
   ========================================================= */

.table-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    margin-bottom:15px;
}

.table-title{
    color:white;
}

.table-title strong{
    display:block;
    font-size:17px;
}

.table-title span{
    display:block;
    margin-top:4px;
    color:#94a3b8;
    font-size:13px;
}

.table-hint{
    color:#94a3b8;
    font-size:12px;
    white-space:nowrap;
}


/* =========================================================
   TABLE
   ========================================================= */

.table-responsive{
    width:100%;
    overflow-x:auto;
    border-radius:12px;
    scrollbar-width:thin;
}

.table-custom{
    width:100%;
    min-width:1500px;
    border-collapse:collapse;
    background:#11183d;
}

.table-custom th{
    background:#4f46e5;
    color:white;
    padding:13px 12px;
    text-align:left;
    font-size:12px;
    font-weight:700;
    white-space:nowrap;
}

.table-custom td{
    padding:13px 12px;
    color:#e2e8f0;
    border-bottom:1px solid rgba(255,255,255,.08);
    font-size:13px;
    white-space:nowrap;
    vertical-align:middle;
}

.table-custom tbody tr{
    transition:.2s;
}

.table-custom tbody tr:hover{
    background:rgba(79,70,229,.12);
}

.table-custom td strong{
    color:white;
}


/* =========================================================
   BADGES
   ========================================================= */

.dm-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    padding:6px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
    white-space:nowrap;
}

.badge-green{
    background:#22c55e;
    color:white;
}

.badge-blue{
    background:#3b82f6;
    color:white;
}

.badge-gray{
    background:#6b7280;
    color:white;
}

.badge-orange{
    background:#f59e0b;
    color:white;
}


/* =========================================================
   PROGRESS
   ========================================================= */

.progress-wrapper{
    width:150px;
}

.progress-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:6px;
    font-size:11px;
    color:#94a3b8;
}

.progress-value{
    color:white;
    font-weight:700;
}

.progress{
    width:100%;
    height:9px;
    background:#374151;
    border-radius:20px;
    overflow:hidden;
}

.progress-bar{
    height:100%;
    border-radius:20px;
    background:linear-gradient(
        90deg,
        #6366f1,
        #8b5cf6
    );
    transition:width .3s ease;
}

.progress-bar.complete{
    background:linear-gradient(
        90deg,
        #16a34a,
        #22c55e
    );
}


/* =========================================================
   VIEW BUTTON
   ========================================================= */

.btn-view{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    background:#0ea5e9;
    color:white;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    border:none;
    cursor:pointer;
    font-size:12px;
    font-weight:600;
    transition:.2s;
}

.btn-view:hover{
    background:#0284c7;
    transform:translateY(-1px);
}


/* =========================================================
   EMPTY STATE
   ========================================================= */

.empty-state{
    padding:45px 20px !important;
    text-align:center;
    color:#94a3b8 !important;
}

.empty-icon{
    font-size:40px;
    margin-bottom:10px;
}

.empty-state strong{
    display:block;
    color:white;
    font-size:16px;
    margin-bottom:5px;
}

.empty-state span{
    font-size:13px;
}


/* =========================================================
   MODAL
   ========================================================= */

.custom-modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.75);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
    padding:20px;
}

.custom-modal-overlay.show{
    display:flex;
}

.custom-modal-box{
    width:100%;
    max-width:720px;
    max-height:90vh;
    overflow-y:auto;
    background:#1f1b6b;
    border-radius:18px;
    overflow-x:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.5);
    animation:modalPop .25s ease;
}

@keyframes modalPop{
    from{
        transform:scale(.9);
        opacity:0;
    }

    to{
        transform:scale(1);
        opacity:1;
    }
}

.custom-modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 20px;
    background:#312e81;
    color:white;
}

.custom-modal-header h3{
    margin:0;
    font-size:18px;
}

.custom-modal-body{
    padding:25px;
}

.close-btn{
    background:none;
    border:none;
    color:white;
    font-size:22px;
    cursor:pointer;
}


/* =========================================================
   PROFILE
   ========================================================= */

.profile-section{
    text-align:center;
    margin-bottom:25px;
}

.cadet-profile{
    width:120px;
    height:120px;
    display:block;
    margin:0 auto 15px;
    border-radius:50%;
    object-fit:cover;
    object-position:center;
    border:4px solid #4f46e5;
    background:#111827;
    box-shadow:
        0 0 0 6px rgba(79,70,229,.15),
        0 10px 25px rgba(0,0,0,.35);
}

.profile-section h4{
    margin:0;
    color:white;
    font-size:22px;
    font-weight:700;
}

.profile-section p{
    margin-top:5px;
    color:#cbd5e1;
    font-size:14px;
}


/* =========================================================
   MODAL DETAIL ROWS
   ========================================================= */

.detail-section{
    margin-top:20px;
}

.detail-section-title{
    color:#a5b4fc;
    font-size:13px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.5px;
    margin-bottom:5px;
}

.detail-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    padding:12px 0;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.detail-row strong{
    color:#cbd5e1;
    font-size:13px;
}

.detail-row span{
    color:white;
    text-align:right;
    font-size:13px;
}


/* =========================================================
   STATUS
   ========================================================= */

.status-completed{
    background:#22c55e;
    padding:6px 12px;
    border-radius:20px;
    color:white !important;
    font-weight:600;
}

.status-ongoing{
    background:#3b82f6;
    padding:6px 12px;
    border-radius:20px;
    color:white !important;
    font-weight:600;
}

.status-not-deployed{
    background:#6b7280;
    padding:6px 12px;
    border-radius:20px;
    color:white !important;
    font-weight:600;
}


/* =========================================================
   PAGINATION
   ========================================================= */

.pagination-wrapper{
    margin-top:20px;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media(max-width:992px){

    .filter-grid{
        grid-template-columns:
            repeat(2,minmax(180px,1fr));
    }

    .table-hint{
        display:none;
    }
}

@media(max-width:768px){

    .card-container{
        padding:15px;
    }

    .page-header h2{
        font-size:22px;
    }

    .filter-grid{
        grid-template-columns:1fr;
    }

    .stats-grid{
        grid-template-columns:1fr;
    }

    .table-responsive{
        overflow-x:auto;
    }

    .table-custom{
        min-width:1500px;
    }

    .custom-modal-box{
        max-height:95vh;
    }

    .custom-modal-body{
        padding:18px;
    }

    .detail-row{
        align-items:flex-start;
        flex-direction:column;
        gap:5px;
    }

    .detail-row span{
        text-align:left;
    }
}

</style>


<div class="page-header">

    <h2>
        🚢 Deployment Monitoring
    </h2>

    <p>
        Monitor cadet deployment information, vessel assignments,
        progress, and training status.
    </p>

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
                                {{ $percent }}%
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
    }
}


function closeModal(id)
{
    const modal =
        document.getElementById(id);

    if(modal){
        modal.style.display = "none";
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

    }
);

</script>

@endsection