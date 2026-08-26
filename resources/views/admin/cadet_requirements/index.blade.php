@extends('layouts.admin')

@section('header-title', 'Cadet Requirements')

@section('content')

@vite(['resources/css/admin/cadet_requirements/cadet_requirements.css'])


<div class="page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">

        <div>

            <h2>
                <i class="fas fa-user-check text-primary me-2"></i>
                Cadet Requirement Monitoring
            </h2>

            <p>
                Monitor deployed cadets and their onboard requirement progress.
            </p>

        </div>

    </div>


    {{-- =====================================================
         SUMMARY CARDS
    ====================================================== --}}

    <div class="summary-grid">

        {{-- TOTAL CADETS --}}

        <div class="summary-card">

            <div class="summary-icon icon-blue">
                <i class="fas fa-users"></i>
            </div>

            <div>

                <h3 id="totalCadetsCount">
                    {{ $cadets->count() }}
                </h3>

                <span>
                    Deployed Cadets
                </span>

            </div>

        </div>


        {{-- APPROVED --}}

        <div class="summary-card">

            <div class="summary-icon icon-green">
                <i class="fas fa-check-circle"></i>
            </div>

            <div>

                <h3 id="approvedRequirementsCount">

                    {{
                        $cadets->sum(function ($cadet) {

                            return $cadet->onboardRequirements
                                ->where('status', 'Approved')
                                ->count();

                        })
                    }}

                </h3>

                <span>
                    Approved Requirements
                </span>

            </div>

        </div>


        {{-- PENDING --}}

        <div class="summary-card">

            <div class="summary-icon icon-yellow">
                <i class="fas fa-clock"></i>
            </div>

            <div>

                <h3 id="pendingRequirementsCount">

                    {{
                        $cadets->sum(function ($cadet) {

                            return $cadet->onboardRequirements
                                ->where('status', 'Pending')
                                ->count();

                        })
                    }}

                </h3>

                <span>
                    Pending Review
                </span>

            </div>

        </div>


        {{-- REJECTED --}}

        <div class="summary-card">

            <div class="summary-icon icon-red">
                <i class="fas fa-times-circle"></i>
            </div>

            <div>

                <h3 id="rejectedRequirementsCount">

                    {{
                        $cadets->sum(function ($cadet) {

                            return $cadet->onboardRequirements
                                ->where('status', 'Rejected')
                                ->count();

                        })
                    }}

                </h3>

                <span>
                    Rejected Documents
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SEARCH + FILTERS
    ====================================================== --}}

    <div class="monitor-toolbar">

        <div class="search-box">

            <input
                type="text"
                id="searchCadet"
                placeholder="Search cadet name..."
            >

        </div>


        <div class="filters">

            <select id="batchFilter">

                <option value="">
                    All Batch
                </option>

                @foreach($batches as $batch)

                    <option value="{{ $batch->batch_year }}">
                        {{ $batch->batch_year }}
                    </option>

                @endforeach

            </select>


            <select id="courseFilter">

                <option value="">
                    All Course
                </option>

                @foreach($courses as $course)

                    <option value="{{ $course->course }}">
                        {{ $course->course }}
                    </option>

                @endforeach

            </select>


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


    {{-- =====================================================
         CADET TABLE
    ====================================================== --}}

    <div class="card">

        <div class="table-responsive">

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
                            <i class="fa-solid fa-ship"></i>
                            Deployment
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

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | TOTAL MASTER REQUIREMENTS
                        |--------------------------------------------------------------------------
                        |
                        | This is the important change.
                        |
                        | Instead of:
                        |
                        | $cadet->onboardRequirements->count()
                        |
                        | we count ALL active onboard requirements.
                        |
                        | Example:
                        | 23 active requirements = 23 total.
                        |
                        */

                        $totalRequirements =
                            \App\Models\OnboardRequirement::where(
                                'is_active',
                                true
                            )->count();


                        /*
                        |--------------------------------------------------------------------------
                        | SUBMITTED REQUIREMENTS
                        |--------------------------------------------------------------------------
                        |
                        | A requirement counts as submitted when:
                        |
                        | - It has an uploaded attachment
                        | - OR its status is Submitted
                        | - OR it has already been Approved
                        |
                        | Rejected is NOT counted because it needs
                        | to be submitted again.
                        |
                        */

                        $submittedRequirements =
                            $cadet->onboardRequirements
                                ->filter(function ($requirement) {

                                    return
                                        !empty($requirement->attachment)
                                        ||
                                        in_array(
                                            $requirement->status,
                                            [
                                                'Submitted',
                                                'Approved'
                                            ]
                                        );

                                })
                                ->count();


                        /*
                        |--------------------------------------------------------------------------
                        | PROGRESS PERCENTAGE
                        |--------------------------------------------------------------------------
                        */

                        $percentage =
                            $totalRequirements > 0
                                ? (
                                    $submittedRequirements
                                    / $totalRequirements
                                ) * 100
                                : 0;

                    @endphp


                    <tr

                        data-cadet-id="{{ $cadet->id }}"

                        data-name="{{ strtolower($cadet->full_name) }}"

                        data-batch="{{ optional($cadet->batch)->batch_year }}"

                        data-course="{{ strtolower($cadet->course) }}"

                        data-deployment="{{ strtolower($cadet->deployment->status ?? '') }}"

                    >

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            {{ $cadet->trb_control_number }}
                        </td>


                        <td>
                            {{ $cadet->full_name }}
                        </td>


                        <td>
                            {{ $cadet->course }}
                        </td>


                        <td>
                            {{ optional($cadet->batch)->batch_year ?? '-' }}
                        </td>


                        <td>
                            {{ $cadet->deployment->status ?? '-' }}
                        </td>


                        {{-- =================================================
                             SUBMITTED REQUIREMENT PROGRESS
                        ================================================== --}}

                        <td>

                            <div
                                class="progress-wrap"

                                data-submitted="{{ $submittedRequirements }}"

                                data-total="{{ $totalRequirements }}"
                            >

                                <div class="progress-bar">

                                    <div
                                        class="progress-fill"

                                        style="width: {{ $percentage }}%"
                                    ></div>

                                </div>


                                <small class="progress-text">

                                    {{ $submittedRequirements }}
                                    /
                                    {{ $totalRequirements }}

                                </small>

                            </div>

                        </td>


                        {{-- =================================================
                             ACTION
                        ================================================== --}}

                        <td>

                            <button
                                type="button"

                                class="btn btn-primary"

                                onclick="viewChecklist({{ $cadet->id }})"
                            >

                                <i class="fa fa-eye"></i>

                                View

                            </button>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center"
                        >

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
    class="modal"
>

    <div class="modal-content">

        <div class="modal-header-custom">

            <h3>

                <i class="fas fa-file-alt text-primary me-2"></i>

                <span id="cadetName"></span>

            </h3>


            <button
                type="button"
                class="close-btn"
                onclick="closeChecklist()"
            >
                ✕
            </button>

        </div>

        <div class="legacy-approval-bar">

            <div class="legacy-approval-info">
                <i class="fas fa-history"></i>

                <div>
                    <strong>Legacy Cadet</strong>

                    <span>
                        Use this only if this cadet's requirements were completed
                        before the system was implemented.
                    </span>
                </div>
            </div>

            <button
                type="button"
                class="legacy-approve-btn"
                onclick="approveAllLegacyRequirements()"
            >
                <i class="fas fa-check-double"></i>
                Approve All as Legacy
            </button>

        </div>


        <div id="checklistBody"></div>

    </div>

</div>


{{-- =========================================================
     ATTACHMENT PREVIEW MODAL
========================================================= --}}

<div
    id="previewModal"
    class="modal"
>

    <div class="modal-content">

        <div class="modal-header-custom">

            <h3>

                <i class="fas fa-eye text-primary me-2"></i>

                Attachment Preview

            </h3>


            <button
                type="button"
                class="close-btn"
                onclick="closePreview()"
            >
                ✕
            </button>

        </div>


        <div class="preview-container">

            <div id="previewBody"></div>

        </div>

    </div>

</div>


{{-- =========================================================
     NOTIFICATION
========================================================= --}}

<div
    id="notification"
    class="professional-notification success"
>

    <div class="notif-icon">
        ✓
    </div>


    <div class="notif-content">

        <h4 class="notif-title">
            Success
        </h4>

        <p id="notifMessage">
            Requirement updated successfully.
        </p>

    </div>


    <button
        type="button"
        class="notif-close"
        onclick="hideNotification()"
    >
        ×
    </button>

</div>


{{-- =========================================================
     CONFIRMATION MODAL
========================================================= --}}

<div
    id="confirmModal"
    class="confirm-modal"
>

    <div class="confirm-box">

        <div class="confirm-icon">

            <i class="fas fa-question"></i>

        </div>


        <h3 id="confirmTitle">
            Confirm Action
        </h3>


        <p id="confirmMessage">
            Are you sure you want to continue?
        </p>


        <div class="confirm-actions">

            <button
                type="button"
                class="confirm-cancel"
                onclick="closeConfirm()"
            >
                Cancel
            </button>


            <button
                type="button"
                id="confirmSubmit"
                class="confirm-submit"
            >
                Confirm
            </button>

        </div>

    </div>

</div>


<script>

/* =========================================================
   GLOBAL VARIABLES
========================================================= */

let pendingStatusId = null;
let pendingStatus = null;
let notificationTimer = null;


/* =========================================================
   VIEW CHECKLIST
========================================================= */

function viewChecklist(id) {

    const modal =
        document.getElementById('checklistModal');

    const body =
        document.getElementById('checklistBody');

    modal.dataset.cadetId = id;

    modal.style.display = 'flex';

    body.innerHTML = `

        <div class="text-center py-5">

            <div class="spinner-border text-primary"></div>

            <p class="mt-3 text-muted">
                Loading requirements...
            </p>

        </div>

    `;


    fetch(`/admin/cadet-requirements/${id}`)

        .then(response => {

            if (!response.ok) {

                throw new Error(
                    'Unable to load checklist'
                );

            }

            return response.json();

        })


        .then(data => {

            document
                .getElementById('cadetName')
                .textContent = data.full_name;


            let html = '';


            if (
                !data.onboard_requirements ||
                data.onboard_requirements.length === 0
            ) {

                html = `

                    <div class="alert alert-info text-center">

                        No requirements available.

                    </div>

                `;

            }


                if (data.onboard_requirements) {

                const submittedRequirements =
                    data.onboard_requirements.filter(item => {

                        return (
                            item.attachment &&
                            String(item.attachment).trim() !== ''
                        );

                    });


                    if (submittedRequirements.length === 0) {

                        html = `

                            <div class="alert alert-info text-center">

                                <i class="fas fa-info-circle me-2"></i>

                                This cadet has not submitted any requirements yet.

                            </div>

                        `;

                    }


                    submittedRequirements.forEach(item => {

                    let statusClass = 'status-pending';


                    if (item.status === 'Approved') {

                        statusClass =
                            'status-approved';

                    }

                    else if (item.status === 'Submitted') {

                        statusClass =
                            'status-submitted';

                    }

                    else if (item.status === 'Rejected') {

                        statusClass =
                            'status-rejected';

                    }


                    html += `

                        <div
                            class="requirement-card"

                            data-id="${item.id}"

                            data-status="${item.status}"
                        >

                            <div class="req-header">

                                <h3>

                                    <i
                                        class="fas fa-file-alt text-primary me-2"
                                    ></i>

                                    ${escapeHtml(
                                        item.requirement?.title ?? '-'
                                    )}

                                </h3>


                                <span
                                    class="
                                        requirement-status
                                        ${statusClass}
                                    "
                                >

                                    ${escapeHtml(
                                        item.status ?? 'Pending'
                                    )}

                                </span>

                            </div>


                            <div class="req-body">

                                <p>

                                    <strong>
                                        Frequency:
                                    </strong>

                                    ${escapeHtml(
                                        item.requirement?.frequency ?? '-'
                                    )}

                                </p>


                                <p>

                                    <strong>
                                        Submitted:
                                    </strong>

                                    ${escapeHtml(
                                        item.submitted_at ?? '-'
                                    )}

                                </p>


                                <p>

                                    <strong>
                                        Approved:
                                    </strong>

                                    <span class="approved-date">

                                        ${escapeHtml(
                                            item.approved_at ?? '-'
                                        )}

                                    </span>

                                </p>


                                <p>

                                    <strong>
                                        Remarks:
                                    </strong>

                                    ${escapeHtml(
                                        item.remarks ?? '-'
                                    )}

                                </p>

                            </div>


                            <div class="attachment-section">

                                <div class="attachment-title">

                                    <i class="fas fa-paperclip"></i>

                                    Attachment

                                </div>


                                ${
                                    item.attachment
                                    ?
                                    `

                                    <button
                                        type="button"

                                        class="btn btn-info btn-sm"

                                        onclick="previewAttachment(
                                            '/storage/${item.attachment}'
                                        )"
                                    >

                                        <i class="fas fa-eye"></i>

                                        Preview

                                    </button>


                                    <a
                                        href="/storage/${item.attachment}"

                                        download

                                        class="btn btn-success btn-sm"
                                    >

                                        <i class="fas fa-download"></i>

                                        Download

                                    </a>

                                    `
                                    :
                                    `

                                    <span class="text-muted">

                                        No uploaded file

                                    </span>

                                    `
                                }

                            </div>


<div class="req-footer">

    ${
        item.status === 'Approved'

        ?

        `
        <div
            style="
                width:100%;
                text-align:center;
                padding:12px;
                background:#f0fdf4;
                color:#166534;
                border-radius:12px;
                font-weight:700;
            "
        >

            <i class="fas fa-check-circle"></i>

            Requirement Approved

        </div>
        `

        :

        item.status === 'Rejected'

        ?

        `
        <div
            style="
                width:100%;
                text-align:center;
                padding:12px;
                background:#fef2f2;
                color:#b91c1c;
                border-radius:12px;
                font-weight:700;
            "
        >

            <i class="fas fa-times-circle"></i>

            Requirement Rejected

        </div>
        `

        :

        `
        <button
            type="button"

            class="btn btn-success"

            onclick="
                updateStatus(
                    ${item.id},
                    'Approved'
                )
            "
        >

            <i class="fas fa-check"></i>

            Approve

        </button>


        <button
            type="button"

            class="btn btn-danger"

            onclick="
                updateStatus(
                    ${item.id},
                    'Rejected'
                )
            "
        >

            <i class="fas fa-times"></i>

            Reject

        </button>
        `
    }

</div>

                        </div>

                    `;

                });

            }


            body.innerHTML = html;

        })


        .catch(error => {

            console.error(error);


            body.innerHTML = `

                <div class="alert alert-danger">

                    Failed loading requirements.

                </div>

            `;

        });

}


/* =========================================================
   ESCAPE HTML
========================================================= */

function escapeHtml(value) {

    if (
        value === null ||
        value === undefined
    ) {

        return '';

    }

    return String(value)

        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}


/* =========================================================
   UPDATE STATUS
========================================================= */

function updateStatus(id, status) {

    pendingStatusId = id;

    pendingStatus = status;


    const title =
        document.getElementById('confirmTitle');

    const message =
        document.getElementById('confirmMessage');

    const submit =
        document.getElementById('confirmSubmit');

    const icon =
        document.querySelector('.confirm-icon');


    if (status === 'Approved') {

        title.textContent =
            'Confirm Approval';

        message.textContent =
            'Are you sure you want to approve this requirement? This will mark the submitted document as officially approved.';

        submit.textContent =
            'Approve Requirement';

        submit.className =
            'confirm-submit';

        icon.innerHTML =
            '<i class="fas fa-check"></i>';

    }


    else {

        title.textContent =
            'Confirm Rejection';

        message.textContent =
            'Are you sure you want to reject this requirement?';

        submit.textContent =
            'Reject Requirement';

        submit.className =
            'confirm-submit reject';

        icon.innerHTML =
            '<i class="fas fa-times"></i>';

    }


    document
        .getElementById('confirmModal')
        .classList.add('show');


    submit.onclick = function () {

        processStatusUpdate(
            pendingStatusId,
            pendingStatus
        );

    };

}


/* =========================================================
   PROCESS STATUS UPDATE
========================================================= */

function processStatusUpdate(id, status) {

    const card =
        document.querySelector(
            `.requirement-card[data-id="${id}"]`
        );


    if (!card) {

        showNotification(
            'Update Failed',
            'Requirement card could not be found.',
            'error'
        );

        return;

    }


    const oldStatus =
        card.dataset.status || 'Pending';


    closeConfirm();


    const footer =
        card.querySelector('.req-footer');


    if (footer) {

        footer
            .querySelectorAll('button')
            .forEach(button => {

                button.disabled = true;

                button.style.opacity = '0.6';

            });

    }


    const csrfTokenElement =
        document.querySelector(
            'meta[name="csrf-token"]'
        );


    if (!csrfTokenElement) {

        showNotification(
            'Update Failed',
            'CSRF token is missing.',
            'error'
        );

        return;

    }


    fetch(`/admin/cadet-requirements/${id}`, {

        method: 'PUT',

        headers: {

            'Content-Type':
                'application/json',

            'Accept':
                'application/json',

            'X-CSRF-TOKEN':
                csrfTokenElement.content

        },

        body: JSON.stringify({

            status: status

        })

    })


        .then(response => {

            if (!response.ok) {

                throw new Error(
                    'Failed to update status'
                );

            }

            return response.json();

        })


        .then(data => {

            if (!data.success) {

                throw new Error(
                    'Unable to update requirement'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE SUBMITTED PROGRESS
            |--------------------------------------------------------------------------
            */

            updateCadetProgress(
                status,
                oldStatus
            );


            updateRequirementCard(
                card,
                status,
                data
            );


            if (status === 'Approved') {

                showNotification(
                    'Requirement Approved',
                    'The requirement has been approved successfully.',
                    'success'
                );

            }

            else {

                showNotification(
                    'Requirement Rejected',
                    'The requirement has been rejected successfully.',
                    'error'
                );

            }

        })


        .catch(error => {

            console.error(error);


            showNotification(
                'Update Failed',
                'Something went wrong while updating the requirement.',
                'error'
            );


            if (footer) {

                footer
                    .querySelectorAll('button')
                    .forEach(button => {

                        button.disabled = false;

                        button.style.opacity = '1';

                    });

            }

        });

}


/* =========================================================
   UPDATE REQUIREMENT CARD
========================================================= */

function updateRequirementCard(
    card,
    status,
    data
) {

    card.dataset.status = status;


    const badge =
        card.querySelector(
            '.requirement-status'
        );


    if (badge) {

        badge.textContent = status;


        if (status === 'Approved') {

            badge.className =
                'requirement-status status-approved';

        }

        else if (status === 'Rejected') {

            badge.className =
                'requirement-status status-rejected';

        }

        else if (status === 'Submitted') {

            badge.className =
                'requirement-status status-submitted';

        }

        else {

            badge.className =
                'requirement-status status-pending';

        }

    }


    const approvedDate =
        card.querySelector(
            '.approved-date'
        );


    if (
        approvedDate &&
        status === 'Approved'
    ) {

        approvedDate.textContent =
            data.approved_at ??
            new Date().toLocaleString();

    }


    const footer =
        card.querySelector('.req-footer');


    if (footer) {

        footer.innerHTML = `

            <div
                style="
                    width:100%;
                    text-align:center;
                    padding:12px;
                    background:${
                        status === 'Approved'
                            ? '#f0fdf4'
                            : '#fef2f2'
                    };
                    color:${
                        status === 'Approved'
                            ? '#166534'
                            : '#b91c1c'
                    };
                    border-radius:12px;
                    font-weight:700;
                "
            >

                <i
                    class="
                        fas
                        ${
                            status === 'Approved'
                                ? 'fa-check-circle'
                                : 'fa-times-circle'
                        }
                    "
                ></i>

                Requirement
                ${
                    status === 'Approved'
                        ? 'Approved'
                        : 'Rejected'
                }

            </div>

        `;

    }

}


/* =========================================================
   UPDATE CADET SUBMITTED PROGRESS
========================================================= */

function updateCadetProgress(
    newStatus,
    oldStatus
) {

    const modal =
        document.getElementById(
            'checklistModal'
        );


    const cadetId =
        modal.dataset.cadetId;


    if (!cadetId) {

        console.warn(
            'Cadet ID not found.'
        );

        return;

    }


    const row =
        document.querySelector(
            `tr[data-cadet-id="${cadetId}"]`
        );


    if (!row) {

        console.warn(
            'Cadet table row not found.'
        );

        return;

    }


    const progressWrap =
        row.querySelector(
            '.progress-wrap'
        );


    if (!progressWrap) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | CURRENT SUBMITTED COUNT
    |--------------------------------------------------------------------------
    */

    let submitted =
        parseInt(
            progressWrap.dataset.submitted || 0
        );


    const total =
        parseInt(
            progressWrap.dataset.total || 0
        );


    /*
    |--------------------------------------------------------------------------
    | OLD STATUS
    |--------------------------------------------------------------------------
    |
    | Submitted / Approved = already submitted
    |
    */

    const oldWasSubmitted =
        [
            'Submitted',
            'Approved'
        ].includes(oldStatus);


    /*
    |--------------------------------------------------------------------------
    | NEW STATUS
    |--------------------------------------------------------------------------
    */

    const newIsSubmitted =
        [
            'Submitted',
            'Approved'
        ].includes(newStatus);


    /*
    |--------------------------------------------------------------------------
    | UPDATE COUNT
    |--------------------------------------------------------------------------
    */

    if (
        !oldWasSubmitted &&
        newIsSubmitted
    ) {

        submitted++;

    }


    else if (
        oldWasSubmitted &&
        !newIsSubmitted
    ) {

        submitted--;

    }


    /*
    |--------------------------------------------------------------------------
    | KEEP VALUE SAFE
    |--------------------------------------------------------------------------
    */

    submitted =
        Math.max(
            0,
            Math.min(
                submitted,
                total
            )
        );


    /*
    |--------------------------------------------------------------------------
    | PERCENTAGE
    |--------------------------------------------------------------------------
    */

    const percentage =
        total > 0
            ? (submitted / total) * 100
            : 0;


    /*
    |--------------------------------------------------------------------------
    | SAVE COUNT
    |--------------------------------------------------------------------------
    */

    progressWrap.dataset.submitted =
        submitted;


    /*
    |--------------------------------------------------------------------------
    | UPDATE BAR
    |--------------------------------------------------------------------------
    */

    const progressFill =
        progressWrap.querySelector(
            '.progress-fill'
        );


    if (progressFill) {

        progressFill.style.width =
            `${percentage}%`;

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE TEXT
    |--------------------------------------------------------------------------
    */

    const progressText =
        progressWrap.querySelector(
            '.progress-text'
        );


    if (progressText) {

        progressText.textContent =
            `${submitted} / ${total}`;

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SUMMARY
    |--------------------------------------------------------------------------
    */

    updateSummaryCounts(
        newStatus,
        oldStatus
    );

}


/* =========================================================
   UPDATE SUMMARY COUNTS
========================================================= */

function updateSummaryCounts(
    newStatus,
    oldStatus
) {

    const approvedElement =
        document.getElementById(
            'approvedRequirementsCount'
        );


    const pendingElement =
        document.getElementById(
            'pendingRequirementsCount'
        );


    const rejectedElement =
        document.getElementById(
            'rejectedRequirementsCount'
        );


    let approved =
        parseInt(
            approvedElement?.textContent || 0
        );


    let pending =
        parseInt(
            pendingElement?.textContent || 0
        );


    let rejected =
        parseInt(
            rejectedElement?.textContent || 0
        );


    /*
    |--------------------------------------------------------------------------
    | REMOVE OLD STATUS
    |--------------------------------------------------------------------------
    */

    if (oldStatus === 'Approved') {

        approved--;

    }

    else if (oldStatus === 'Pending') {

        pending--;

    }

    else if (oldStatus === 'Rejected') {

        rejected--;

    }


    /*
    |--------------------------------------------------------------------------
    | ADD NEW STATUS
    |--------------------------------------------------------------------------
    */

    if (newStatus === 'Approved') {

        approved++;

    }

    else if (newStatus === 'Pending') {

        pending++;

    }

    else if (newStatus === 'Rejected') {

        rejected++;

    }


    approved =
        Math.max(0, approved);

    pending =
        Math.max(0, pending);

    rejected =
        Math.max(0, rejected);


    if (approvedElement) {

        approvedElement.textContent =
            approved;

    }


    if (pendingElement) {

        pendingElement.textContent =
            pending;

    }


    if (rejectedElement) {

        rejectedElement.textContent =
            rejected;

    }

}


/* =========================================================
   CLOSE CONFIRMATION
========================================================= */

function closeConfirm() {

    document
        .getElementById('confirmModal')
        .classList.remove('show');


    pendingStatusId = null;

    pendingStatus = null;

}


/* =========================================================
   NOTIFICATION
========================================================= */

function showNotification(
    title,
    message,
    type = 'success'
) {

    const notification =
        document.getElementById(
            'notification'
        );


    const titleElement =
        notification.querySelector(
            '.notif-title'
        );


    const textElement =
        document.getElementById(
            'notifMessage'
        );


    const icon =
        notification.querySelector(
            '.notif-icon'
        );


    titleElement.textContent =
        title;

    textElement.textContent =
        message;


    notification.classList.remove(
        'success',
        'error',
        'warning',
        'info'
    );


    notification.classList.add(
        type
    );


    if (type === 'success') {

        icon.innerHTML =
            '<i class="fas fa-check"></i>';

    }

    else if (type === 'error') {

        icon.innerHTML =
            '<i class="fas fa-times"></i>';

    }

    else if (type === 'warning') {

        icon.innerHTML =
            '<i class="fas fa-exclamation"></i>';

    }

    else {

        icon.innerHTML =
            '<i class="fas fa-info"></i>';

    }


    notification.classList.add(
        'show'
    );


    if (notificationTimer) {

        clearTimeout(
            notificationTimer
        );

    }


    notificationTimer =
        setTimeout(
            () => {

                hideNotification();

            },
            4000
        );

}


/* =========================================================
   HIDE NOTIFICATION
========================================================= */

function hideNotification() {

    const notification =
        document.getElementById(
            'notification'
        );


    if (!notification) {

        return;

    }


    notification.classList.remove(
        'show'
    );

}


/* =========================================================
   CLOSE CHECKLIST
========================================================= */

function closeChecklist() {

    document
        .getElementById(
            'checklistModal'
        )
        .style.display = 'none';

}


/* =========================================================
   CLOSE PREVIEW
========================================================= */

function closePreview() {

    document
        .getElementById(
            'previewModal'
        )
        .style.display = 'none';


    document
        .getElementById(
            'previewBody'
        )
        .innerHTML = '';

}


/* =========================================================
   CLICK OUTSIDE CHECKLIST
========================================================= */

document
    .getElementById('checklistModal')
    ?.addEventListener(
        'click',
        function(e) {

            if (e.target === this) {

                closeChecklist();

            }

        }
    );


/* =========================================================
   CLICK OUTSIDE PREVIEW
========================================================= */

document
    .getElementById('previewModal')
    ?.addEventListener(
        'click',
        function(e) {

            if (e.target === this) {

                closePreview();

            }

        }
    );


/* =========================================================
   ATTACHMENT PREVIEW
========================================================= */

function previewAttachment(url) {

    const extension =
        url
            .split('.')
            .pop()
            .toLowerCase()
            .split('?')[0];


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

                style="
                    width:100%;
                    max-height:700px;
                    object-fit:contain;
                    border-radius:15px;
                "

            >

        `;

    }


    else if (
        extension === 'pdf'
    ) {

        html = `

            <iframe

                src="${url}"

                width="100%"

                height="650"

                style="
                    border:none;
                    border-radius:15px;
                "

            ></iframe>

        `;

    }


    else {

        html = `

            <div class="text-center py-5">

                <i
                    class="fas fa-file"
                    style="
                        font-size:60px;
                        color:#64748b;
                        margin-bottom:20px;
                    "
                ></i>

                <p>
                    Preview is not available for this file type.
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
        .getElementById(
            'previewBody'
        )
        .innerHTML = html;


    document
        .getElementById(
            'previewModal'
        )
        .style.display = 'flex';

}


/* =========================================================
   SEARCH + FILTER
========================================================= */

function filterCadets() {

    const search =
        document
            .getElementById('searchCadet')
            .value
            .toLowerCase()
            .trim();


    const batch =
        document
            .getElementById('batchFilter')
            .value;


    const course =
        document
            .getElementById('courseFilter')
            .value
            .toLowerCase();


    const deployment =
        document
            .getElementById('deploymentFilter')
            .value
            .toLowerCase();


    document
        .querySelectorAll(
            '.table tbody tr[data-cadet-id]'
        )
        .forEach(row => {

            const rowName =
                row.dataset.name || '';


            const rowBatch =
                row.dataset.batch || '';


            const rowCourse =
                row.dataset.course || '';


            const rowDeployment =
                row.dataset.deployment || '';


            const matchSearch =
                rowName.includes(search);


            const matchBatch =
                !batch ||
                rowBatch === batch;


            const matchCourse =
                !course ||
                rowCourse === course;


            const matchDeployment =
                !deployment ||
                rowDeployment === deployment;


            if (
                matchSearch &&
                matchBatch &&
                matchCourse &&
                matchDeployment
            ) {

                row.style.display = '';

            }

            else {

                row.style.display = 'none';

            }

        });

}


/* =========================================================
   SEARCH LISTENER
========================================================= */

document
    .getElementById('searchCadet')
    ?.addEventListener(
        'input',
        filterCadets
    );


/* =========================================================
   BATCH LISTENER
========================================================= */

document
    .getElementById('batchFilter')
    ?.addEventListener(
        'change',
        filterCadets
    );


/* =========================================================
   COURSE LISTENER
========================================================= */

document
    .getElementById('courseFilter')
    ?.addEventListener(
        'change',
        filterCadets
    );


/* =========================================================
   DEPLOYMENT LISTENER
========================================================= */

document
    .getElementById('deploymentFilter')
    ?.addEventListener(
        'change',
        filterCadets
    );


/* =========================================================
   ESC KEY
========================================================= */

document.addEventListener(
    'keydown',
    function(e) {

        if (e.key !== 'Escape') {

            return;

        }


        const checklistModal =
            document.getElementById(
                'checklistModal'
            );


        const previewModal =
            document.getElementById(
                'previewModal'
            );


        const confirmModal =
            document.getElementById(
                'confirmModal'
            );


        if (
            checklistModal &&
            checklistModal.style.display === 'flex'
        ) {

            closeChecklist();

        }


        if (
            previewModal &&
            previewModal.style.display === 'flex'
        ) {

            closePreview();

        }


        if (
            confirmModal &&
            confirmModal.classList.contains('show')
        ) {

            closeConfirm();

        }

    }
);

/* =========================================================
   APPROVE ALL REQUIREMENTS AS LEGACY
========================================================= */

function approveAllLegacyRequirements() {

    const modal =
        document.getElementById('checklistModal');

    if (!modal) {

        return;

    }


    const cadetId =
        modal.dataset.cadetId;


    if (!cadetId) {

        showNotification(
            'Approval Failed',
            'Cadet ID could not be determined.',
            'error'
        );

        return;

    }


    const confirmed =
        confirm(

            'Approve ALL requirements for this cadet as LEGACY?\n\n' +

            'This will mark the cadet\'s requirements as officially approved ' +

            'without requiring document uploads.\n\n' +

            'Only use this for old/legacy cadets whose requirements were ' +

            'already completed before this system was implemented.'

        );


    if (!confirmed) {

        return;

    }


    const csrfTokenElement =
        document.querySelector(
            'meta[name="csrf-token"]'
        );


    if (!csrfTokenElement) {

        showNotification(
            'Approval Failed',
            'CSRF token is missing.',
            'error'
        );

        return;

    }


    const button =
        document.querySelector(
            '.legacy-approve-btn'
        );


    if (button) {

        button.disabled = true;

        button.innerHTML = `

            <i class="fas fa-spinner fa-spin"></i>

            Approving...

        `;

    }


    fetch(
        `/admin/cadet-requirements/${cadetId}/approve-legacy`,
        {

            method: 'POST',

            headers: {

                'Content-Type':
                    'application/json',

                'Accept':
                    'application/json',

                'X-CSRF-TOKEN':
                    csrfTokenElement.content

            },

            body: JSON.stringify({

                legacy: true

            })

        }
    )


.then(async response => {

    const contentType =
        response.headers.get('content-type') || '';

    let data;

    if (contentType.includes('application/json')) {

        data = await response.json();

    } else {

        const text = await response.text();

        console.error(
            'Non-JSON Laravel response:',
            text
        );

        throw new Error(
            `Server returned HTTP ${response.status}. Check the Laravel error/log.`
        );

    }

    if (!response.ok) {

        console.error(
            'Legacy approval HTTP error:',
            response.status,
            data
        );

        throw new Error(
            data.message ||
            data.error ||
            `Legacy approval failed with HTTP ${response.status}.`
        );

    }

    return data;

})


    .then(data => {

        if (!data.success) {

            throw new Error(
                data.message ||
                'Unable to approve legacy requirements.'
            );

        }


        /*
        |---------------------------------------------------------
        | Update all requirement cards in the modal
        |---------------------------------------------------------
        */

        document
            .querySelectorAll(
                '#checklistBody .requirement-card'
            )
            .forEach(card => {

                card.dataset.status =
                    'Approved';


                const badge =
                    card.querySelector(
                        '.requirement-status'
                    );


                if (badge) {

                    badge.textContent =
                        'Approved';

                    badge.className =
                        'requirement-status status-approved';

                }


                const approvedDate =
                    card.querySelector(
                        '.approved-date'
                    );


                if (approvedDate) {

                    approvedDate.textContent =
                        data.approved_at ??
                        new Date().toLocaleString();

                }


                const footer =
                    card.querySelector(
                        '.req-footer'
                    );


                if (footer) {

                    footer.innerHTML = `

                        <div
                            style="
                                width:100%;
                                text-align:center;
                                padding:12px;
                                background:#f0fdf4;
                                color:#166534;
                                border-radius:12px;
                                font-weight:700;
                            "
                        >

                            <i class="fas fa-check-circle"></i>

                            Requirement Approved as Legacy

                        </div>

                    `;

                }

            });


        /*
        |---------------------------------------------------------
        | Update table progress
        |---------------------------------------------------------
        */

        updateLegacyCadetProgress(
            cadetId
        );


        /*
        |---------------------------------------------------------
        | Refresh summary counts
        |---------------------------------------------------------
        */

        refreshCadetRequirementSummary();


        showNotification(
            'Legacy Approval Complete',
            data.message ||
            'All requirements have been approved as legacy documents.',
            'success'
        );


        if (button) {

            button.disabled = true;

            button.innerHTML = `

                <i class="fas fa-check-circle"></i>

                All Requirements Approved

            `;

        }

    })


    .catch(error => {

        console.error(
            'Legacy approval error:',
            error
        );


        showNotification(
            'Approval Failed',
            error.message ||
            'Something went wrong while approving the legacy requirements.',
            'error'
        );


        if (button) {

            button.disabled = false;

            button.innerHTML = `

                <i class="fas fa-check-double"></i>

                Approve All as Legacy

            `;

        }

    });

}

/* =========================================================
   UPDATE CADET PROGRESS AFTER LEGACY APPROVAL
========================================================= */

function updateLegacyCadetProgress(cadetId) {

    const row =
        document.querySelector(
            `tr[data-cadet-id="${cadetId}"]`
        );


    if (!row) {

        return;

    }


    const progressWrap =
        row.querySelector(
            '.progress-wrap'
        );


    if (!progressWrap) {

        return;

    }


    const total =
        parseInt(
            progressWrap.dataset.total || 0
        );


    /*
    |---------------------------------------------------------
    | Legacy approval means every requirement is approved.
    |---------------------------------------------------------
    */

    const submitted =
        total;


    progressWrap.dataset.submitted =
        submitted;


    const percentage =
        total > 0
            ? 100
            : 0;


    const progressFill =
        progressWrap.querySelector(
            '.progress-fill'
        );


    if (progressFill) {

        progressFill.style.width =
            `${percentage}%`;

    }


    const progressText =
        progressWrap.querySelector(
            '.progress-text'
        );


    if (progressText) {

        progressText.textContent =
            `${submitted} / ${total}`;

    }

}

/* =========================================================
   REFRESH SUMMARY COUNTS
========================================================= */

function refreshCadetRequirementSummary() {

    fetch('/admin/cadet-requirements/summary', {

        method: 'GET',

        headers: {

            'Accept':
                'application/json'

        }

    })

    .then(response => {

        if (!response.ok) {

            throw new Error(
                'Unable to refresh summary.'
            );

        }

        return response.json();

    })

    .then(data => {

        if (
            data.approved !== undefined
        ) {

            const element =
                document.getElementById(
                    'approvedRequirementsCount'
                );

            if (element) {

                element.textContent =
                    data.approved;

            }

        }


        if (
            data.pending !== undefined
        ) {

            const element =
                document.getElementById(
                    'pendingRequirementsCount'
                );

            if (element) {

                element.textContent =
                    data.pending;

            }

        }


        if (
            data.rejected !== undefined
        ) {

            const element =
                document.getElementById(
                    'rejectedRequirementsCount'
                );

            if (element) {

                element.textContent =
                    data.rejected;

            }

        }

    })

    .catch(error => {

        console.warn(
            'Summary refresh failed:',
            error
        );

    });

}

</script>

@endsection