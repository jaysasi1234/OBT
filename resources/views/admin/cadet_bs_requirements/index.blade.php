@extends('layouts.admin')

@section('header-title','Cadet BS Requirements')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')

@vite(['resources/css/admin/cadet_bs_requirements/cadet_bs_requirements.css'])

<div class="page">

    <div class="page-header">

        <div>
            <h2>
                <i class="fa-solid fa-graduation-cap"></i>
                Cadet BS Requirements
            </h2>

            <p>
                Review BS completion requirements submitted by cadets.
            </p>
        </div>

    </div>


    {{-- =====================================================
         FILTERS
    ====================================================== --}}

    <div class="filter-card">

        <div class="filter-title">

            <i class="fa-solid fa-filter"></i>

            <h3>Filter Cadets</h3>

        </div>

        <form
            method="GET"
            action="{{ route('admin.cadet.bs.index') }}"
            id="filterForm"
        >

            <div class="filter-row">

                {{-- Search --}}
                <div class="filter-group">

                    <label>
                        Search Cadet
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="filter-control"
                        placeholder="Search Name or TRB Number..."
                        value="{{ request('search') }}"
                    >

                </div>


                {{-- Course --}}
                <div class="filter-group">

                    <label>
                        Course
                    </label>

                    <select
                        name="course"
                        class="filter-control"
                    >

                        <option value="">
                            All Courses
                        </option>

                        @foreach($courses as $course)

                            <option
                                value="{{ $course }}"
                                {{ request('course') == $course ? 'selected' : '' }}
                            >
                                {{ $course }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Batch --}}
                <div class="filter-group">

                    <label>
                        Batch
                    </label>

                    <select
                        name="batch"
                        class="filter-control"
                    >

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

                </div>


                {{-- Reset --}}
                <div class="filter-actions">

                    <a
                        href="{{ route('admin.cadet.bs.index') }}"
                        class="btn btn-reset"
                    >
                        <i class="fa-solid fa-rotate-right"></i>
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- =====================================================
         AJAX RESULTS START HERE
    ====================================================== --}}

    <div id="bsRequirementsResults">

        <div class="stats-grid">

    <div class="stat-card blue">
        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>

        <div>
            <h4>Total Cadets</h4>
            <h2>{{ $totalCadets }}</h2>
        </div>
    </div>


    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fa-solid fa-file-circle-check"></i>
        </div>

        <div>
            <h4>Requirements Submitted</h4>
            <h2>{{ $requirementsSubmitted }}</h2>
        </div>
    </div>


    <div class="stat-card orange">
        <div class="stat-icon">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>

        <div>
            <h4>Pending Cadets</h4>
            <h2>{{ $pendingCadets }}</h2>
        </div>
    </div>


    <div class="stat-card purple">
        <div class="stat-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <div>
            <h4>Completed</h4>
            <h2>{{ $completedCadets }}</h2>
        </div>
    </div>

</div>

    <div class="card">

        <table class="table">

        <thead>

            <tr>

                <th>#</th>

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
                <i class="fa-solid fa-gear"></i>
                Action
                </th>

            </tr>

        </thead>

            <tbody>

                @forelse($cadets as $cadet)

                <tr>

                    <td>
                        {{ $cadets->firstItem() + $loop->index }}
                    </td>

                    <td>{{ $cadet->trb_control_number }}</td>

                    <td>{{ $cadet->full_name }}</td>

                    <td>{{ $cadet->course }}</td>

                    <td>{{ optional($cadet->batch)->batch_year ?? 'No Batch' }}</td>

<td>

    <div class="progress-wrap">

        <div class="progress-bar">

            <div class="progress-fill"

                style="width:
                {{ $totalRequirements
                    ? ($cadet->bsRequirements->count()/$totalRequirements)*100
                    : 0 }}%;">

            </div>

        </div>

        <small>

            {{ $cadet->bsRequirements->count() }}
            /
            {{ $totalRequirements }}

            Requirements

        </small>

    </div>

</td>

                    <td>

                        <button
                            class="btn btn-primary"
                            onclick="openModal(
                                {{ $cadet->id }},
                                @js($cadet->full_name)
                            )">

                            <i class="fa fa-eye"></i>
                            View

                        </button>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center">
                        No completed cadets found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>
    @if($cadets->hasPages())

        <div class="pagination-wrapper">
            {{ $cadets->withQueryString()->links() }}
        </div>

    @endif


{{-- Hidden Modal Contents --}}
@foreach($cadets as $cadet)

<div id="cadet-{{ $cadet->id }}" style="display:none;">

    <div class="requirement-summary">

        <div class="summary-header">

            <div>

                <h4>{{ $cadet->full_name }}</h4>

                <small>
                    TRB: {{ $cadet->trb_control_number }}
                </small>

            </div>

            <div>

                <span class="badge info">

                    {{ $cadet->bsRequirements->count() }}
                    /
                    {{ $totalRequirements }}
                    Submitted

                </span>

            </div>

        </div>

        <table class="table">

            <thead>

                <tr>
                    <th>Requirement</th>
                    <th>Status</th>
                    <th>Attachment</th>
                    <th>Remarks</th>
                    <th>Date</th>
                    <th width="220">Action</th>
                </tr>

            </thead>

            <tbody>

            @forelse($cadet->bsRequirements as $submission)

                <tr id="submission-{{ $submission->id }}">

                    <td>
                        {{ $submission->requirement->title ?? 'Unknown Requirement' }}
                    </td>

                    <td>

                            @if($submission->status == 'Approved')

                                <span
                                    id="status-{{ $submission->id }}"
                                    class="badge success"
                                >
                                    Approved
                                </span>

                            @elseif($submission->status == 'Rejected')

                                <span
                                    id="status-{{ $submission->id }}"
                                    class="badge danger"
                                >
                                    Rejected
                                </span>

                            @elseif($submission->status == 'Submitted')

                                <span
                                    id="status-{{ $submission->id }}"
                                    class="badge warning"
                                >
                                    Pending Review
                                </span>

                            @else

                                <span
                                    id="status-{{ $submission->id }}"
                                    class="badge warning"
                                >
                                    Pending
                                </span>

                            @endif

                    </td>

<td id="buttons-{{ $submission->id }}">
    @if($submission->attachment)

        @php
            $fileUrl = Storage::disk('public')->url($submission->attachment);
        @endphp

        <div class="attachment-card">

            <div class="attachment-icon">
                <i class="fa-solid fa-file-pdf"></i>
            </div>

            <div class="attachment-info">
                <span class="attachment-name">
                    Uploaded Document
                </span>

                <small>Ready for review</small>
            </div>

            <div class="attachment-actions">

                <a href="{{ $fileUrl }}"
                   target="_blank"
                   rel="noopener"
                   class="btn-view">
                    <i class="fa-solid fa-eye"></i>
                </a>

                <a href="{{ $fileUrl }}"
                   download
                   class="btn-download">
                    <i class="fa-solid fa-download"></i>
                </a>

            </div>

        </div>

    @else

        <div class="no-file">
            <i class="fa-regular fa-file-circle-xmark"></i>
            <span>No Attachment</span>
        </div>

    @endif
</td>

                    <td>

                        {{ $submission->remarks ?? '-' }}

                    </td>

                    <td>

                        @if(!empty($submission->submitted_at))

                            {{ date('M d, Y', strtotime($submission->submitted_at)) }}

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        @if(in_array($submission->status, ['Pending', 'Submitted']) && $submission->attachment)

                            <div class="action-buttons">

                                {{-- APPROVE --}}
                                    <form class="statusForm"data-id="{{ $submission->id }}"action="{{ route('admin.cadet.bs.update',$submission->id) }}"method="POST">

                                    @csrf
                                    @method('PUT')

                                    <input type="hidden"
                                        name="status"
                                        value="Approved">

                                    <input type="hidden"
                                        name="remarks"
                                        value="{{ $submission->remarks }}">

                                    <button type="submit"
                                            class="btn btn-success btn-action">

                                        <i class="fa fa-check"></i>
                                        Approve

                                    </button>

                                </form>

                                {{-- REJECT --}}
                                <form class="statusForm"data-id="{{ $submission->id }}"action="{{ route('admin.cadet.bs.update', $submission->id) }}"method="POST">

                                    @csrf
                                    @method('PUT')

                                    <input type="hidden"
                                        name="status"
                                        value="Rejected">

                                    <input type="hidden"
                                        name="remarks"
                                        value="{{ $submission->remarks }}">

                                    <button type="submit"
                                            class="btn btn-danger btn-action">

                                        <i class="fa fa-times"></i>
                                        Reject

                                    </button>

                                </form>

                            </div>

                        @else

                            <span class="text-muted">
                                Already {{ $submission->status }}
                            </span>

                        @endif

                        </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center">

                        @if($cadet->bsRequirements->count() == 0)

<tr>
    <td colspan="6" class="text-center">

        <p class="mb-3">
            No requirement submitted yet.
        </p>

        @if($cadet->bs_status != 'Legacy Qualified')

            <form action="{{ route('admin.cadet.bs.legacy', $cadet->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <button class="btn btn-success">
                    🎓 Approve Legacy 
                </button>

            </form>

        @else

            <span class="badge success">
                BS Qualified (Legacy)
            </span>

        @endif

    </td>
</tr>

@endif

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endforeach

{{-- MODAL --}}
<div id="bsModal"
     class="custom-modal">

    <div class="custom-modal-content"
         style="max-width:1100px;">

        <div class="custom-modal-header">
            <h3 id="cadetName"></h3>

            <span
                class="close-modal"
                onclick="closeModal()">

                &times;

            </span>

        </div>
        <div id="modalBody">
        </div>
    </div>


</div>
<script>
function openModal(id, name) {

    const source =
        document.getElementById("cadet-" + id);

    if (!source) {
        console.error(
            "Cadet modal content not found:",
            id
        );

        return;
    }

    document.getElementById("bsModal")
        .style.display = "flex";

    document.getElementById("cadetName")
        .textContent = name;

    document.getElementById("modalBody")
        .innerHTML = source.innerHTML;
}

function closeModal(){


    document.getElementById("bsModal")
        .style.display="none";

}

window.onclick=function(event){


    let modal=document.getElementById("bsModal");


    if(event.target === modal){

        closeModal();

    }
}

// AJAX Approve / Reject
document.addEventListener("submit", function(e){

    if(!e.target.classList.contains("statusForm")) return;

    e.preventDefault();

    const form = e.target;

    fetch(form.action,{
        method:"POST",
        headers:{
            "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content,
            "Accept":"application/json"
        },
        body:new FormData(form)
    })
    .then(async response => {

        console.log("Status:", response.status);

        const data = await response.json();

        console.log(data);

        updateSubmission(data.id,data.status);

    })
    .catch(error=>{
        console.error(error);
    });

});

function updateSubmission(id, status){

    const modal = document.getElementById("modalBody");

    const badge = modal.querySelector("#status-"+id);

    if(!badge) return;

    badge.textContent = status;

    badge.className = "badge";

    if(status === "Approved"){
        badge.classList.add("success");
    }else{
        badge.classList.add("danger");
    }

    const row = modal.querySelector("#submission-"+id);

    if(row){
        const lastCell = row.lastElementChild;
        lastCell.innerHTML =
            "<span class='text-muted'>Already "+status+"</span>";
    }
}

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("filterForm");

    if (!form) {
        return;
    }

    const search = form.querySelector('input[name="search"]');

    const selects = form.querySelectorAll(
        'select.filter-control'
    );

    let searchTimer = null;


    // =====================================================
    // BUILD FILTER URL
    // =====================================================

    function buildFilterUrl() {

        const params = new URLSearchParams(
            new FormData(form)
        );

        // Remove empty values
        [...params.entries()].forEach(
            ([key, value]) => {

                if (!value.trim()) {
                    params.delete(key);
                }

            }
        );

        const queryString = params.toString();

        return queryString
            ? `${form.action || window.location.pathname}?${queryString}`
            : form.action || window.location.pathname;
    }


    // =====================================================
    // LOAD RESULTS
    // =====================================================

    async function loadResults(url, pushState = true) {

        const results = document.getElementById(
            "bsRequirementsResults"
        );

        if (!results) {
            return;
        }

        results.classList.add("is-loading");


        try {

            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "text/html"
                }
            });


            if (!response.ok) {
                throw new Error(
                    `HTTP ${response.status}`
                );
            }


            const html = await response.text();


            const parser = new DOMParser();

            const documentHTML =
                parser.parseFromString(
                    html,
                    "text/html"
                );


            const newResults =
                documentHTML.getElementById(
                    "bsRequirementsResults"
                );


            if (!newResults) {
                throw new Error(
                    "BS requirements results container was not found."
                );
            }


            results.replaceWith(newResults);


            // -------------------------------------------------
            // UPDATE FILTER VALUES
            // -------------------------------------------------

            syncFiltersFromUrl(
                new URL(url, window.location.origin)
            );


            // -------------------------------------------------
            // UPDATE BROWSER URL
            // -------------------------------------------------

            if (pushState) {

                window.history.pushState(
                    {},
                    "",
                    url
                );
            }


            // -------------------------------------------------
            // RE-BIND PAGINATION
            // -------------------------------------------------

            bindPagination();


        } catch (error) {

            console.error(
                "BS Requirements AJAX Error:",
                error
            );

        } finally {

            const currentResults =
                document.getElementById(
                    "bsRequirementsResults"
                );

            if (currentResults) {

                currentResults.classList.remove(
                    "is-loading"
                );
            }
        }
    }


    // =====================================================
    // SYNC FILTERS
    // =====================================================

    function syncFiltersFromUrl(url) {

        const searchInput =
            document.querySelector(
                'input[name="search"]'
            );

        const courseSelect =
            document.querySelector(
                'select[name="course"]'
            );

        const batchSelect =
            document.querySelector(
                'select[name="batch"]'
            );


        if (searchInput) {

            searchInput.value =
                url.searchParams.get("search") || "";
        }


        if (courseSelect) {

            courseSelect.value =
                url.searchParams.get("course") || "";
        }


        if (batchSelect) {

            batchSelect.value =
                url.searchParams.get("batch") || "";
        }
    }


    // =====================================================
    // PAGINATION
    // =====================================================

    function bindPagination() {

        const paginationLinks =
            document.querySelectorAll(
                "#bsRequirementsResults .pagination-wrapper a"
            );


        paginationLinks.forEach(link => {

            link.addEventListener(
                "click",
                function (e) {

                    e.preventDefault();

                    loadResults(
                        link.href,
                        true
                    );
                }
            );

        });
    }


    // =====================================================
    // SEARCH
    // =====================================================

    if (search) {

        search.addEventListener(
            "input",
            function () {

                clearTimeout(searchTimer);


                searchTimer = setTimeout(
                    function () {

                        loadResults(
                            buildFilterUrl(),
                            true
                        );

                    },
                    400
                );
            }
        );
    }


    // =====================================================
    // COURSE + BATCH FILTER
    // =====================================================

    selects.forEach(select => {

        select.addEventListener(
            "change",
            function () {

                loadResults(
                    buildFilterUrl(),
                    true
                );

            }
        );

    });


    // =====================================================
    // ENTER KEY
    // =====================================================

    if (search) {

        search.addEventListener(
            "keydown",
            function (e) {

                if (e.key === "Enter") {

                    e.preventDefault();

                    clearTimeout(searchTimer);

                    loadResults(
                        buildFilterUrl(),
                        true
                    );
                }

            }
        );
    }


    // =====================================================
    // BROWSER BACK / FORWARD
    // =====================================================

    window.addEventListener(
        "popstate",
        function () {

            loadResults(
                window.location.href,
                false
            );

        }
    );


    // =====================================================
    // INITIAL PAGINATION BINDING
    // =====================================================

    bindPagination();

});
@endsection