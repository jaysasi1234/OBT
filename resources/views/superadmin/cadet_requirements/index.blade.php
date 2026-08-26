@extends('layouts.superadmin')

@section('header-title', 'Cadet Requirement Monitoring')
@section('content')

<style>
/* =========================================
   PAGE LAYOUT
========================================= */

.page {
    padding: 30px;
    background: #f8fafc;
    min-height: 100vh;
}


/* =========================================
   PAGE HEADER
========================================= */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h2 {
    margin: 0;
    font-size: 30px;
    font-weight: 800;
    color: #0f172a;
}

.page-header p {
    margin-top: 8px;
    color: #64748b;
    font-size: 15px;
}


/* =========================================
   SUMMARY CARDS
========================================= */

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.summary-card {
    background: #ffffff;
    padding: 22px;
    border-radius: 18px;

    display: flex;
    align-items: center;
    gap: 18px;

    box-shadow: 0 8px 20px rgba(0,0,0,0.06);

    transition: .25s ease;
}

.summary-card:hover {
    transform: translateY(-4px);
}


.summary-icon {
    width: 60px;
    height: 60px;

    border-radius: 16px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 25px;
}


.icon-blue {
    background: #dbeafe;
    color: #2563eb;
}

.icon-green {
    background: #dcfce7;
    color: #16a34a;
}

.icon-yellow {
    background: #fef3c7;
    color: #d97706;
}

.icon-red {
    background: #fee2e2;
    color: #dc2626;
}


.summary-card h3 {
    margin: 0;

    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
}


.summary-card span {
    color: #64748b;
    font-size: 14px;
}



/* =========================================
   FILTER TOOLBAR
========================================= */

.monitor-toolbar {
    background: #ffffff;

    padding: 20px;

    border-radius: 18px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 15px;

    flex-wrap: wrap;

    margin-bottom: 30px;

    box-shadow: 0 8px 20px rgba(0,0,0,.05);
}


.search-box {
    flex: 1;
}


.search-box input {

    width: 100%;

    padding: 13px 16px;

    border-radius: 12px;

    border: 1px solid #e2e8f0;

    outline: none;

    transition: .2s;
}


.search-box input:focus {

    border-color: #2563eb;

    box-shadow: 0 0 0 3px rgba(37,99,235,.15);
}


.filters {

    display: flex;

    gap: 10px;

    flex-wrap: wrap;
}


.filters select {

    min-width: 170px;

    padding: 12px 15px;

    border-radius: 12px;

    border: 1px solid #e2e8f0;

    outline: none;
}





.cadet-card:hover {

    transform: translateY(-5px);

    box-shadow:
    0 15px 35px rgba(0,0,0,.12);
}




.cadet-profile h4 {

    margin: 0;

    font-size: 20px;

    font-weight: 800;

    color: #0f172a;
}


.cadet-profile small {

    color: #64748b;

}



/* =========================================
   STATUS BADGE
========================================= */

.status-badge {

    display: inline-block;

    padding: 7px 15px;

    border-radius: 50px;

    font-size: 12px;

    font-weight: 700;
}


.status-ongoing {

    background: #dcfce7;

    color: #166534;
}


.status-completed {

    background: #dbeafe;

    color: #1d4ed8;
}



/* =========================================
   CADET INFORMATION
========================================= */



.cadet-info p {

    margin-bottom: 8px;

    color: #475569;

}



/* =========================================
   PROGRESS BAR
========================================= */


.progress-bar {

    height: 100%;

    background:
    linear-gradient(
        90deg,
        #2563eb,
        #22c55e
    );
}

.card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table thead{
    background:#0f172a;
    color:#fff;
}

.table th{
    padding:16px;
    text-transform:uppercase;
    font-size:14px;
    letter-spacing:.5px;
    text-align:center;
}

.table td{
    padding:16px;
    border-bottom:1px solid #ececec;
    vertical-align:middle;
    text-align:center;
}

.table tbody tr:hover{
    background:#f8fbff;
}

.progress-wrap{
    min-width:180px;
}

.progress-bar{
    width:100%;
    height:10px;
    background:#e5e7eb;
    border-radius:50px;
    overflow:hidden;
}

.progress-fill{
    height:100%;
    background:linear-gradient(90deg,#2563eb,#60a5fa);
}

.btn-primary{
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:10px;
    padding:10px 18px;
}

.btn-primary:hover{
    background:#1d4ed8;
}


/* =========================================
   RESPONSIVE
========================================= */

@media(max-width:768px) {

    .page {

        padding: 15px;

    }


    .page-header h2 {

        font-size: 24px;

    }


    .monitor-toolbar {

        flex-direction: column;

        align-items: stretch;

    }


    .filters {

        width: 100%;

    }


    .filters select {

        width: 100%;

    }


    .cadet-grid {

        grid-template-columns: 1fr;

    }

}

/* =========================================
   CHECKLIST MODAL
========================================= */


.modal {

    display: none;

    position: fixed;

    inset: 0;

    background: rgba(15,23,42,.65);

    justify-content: center;

    align-items: center;

    z-index: 9999;

    padding: 20px;

}

.modal-content {
    width: 950px;
    max-width: calc(100vw - 40px);

    height: auto;
    max-height: 90vh;

    overflow-y: auto;

    background: #ffffff;

    border-radius: 22px;

    padding: 30px;

    box-sizing: border-box;

    box-shadow: 0 25px 50px rgba(0,0,0,.2);
}

/* =========================================
   EMPTY REQUIREMENTS STATE
========================================= */

.empty-requirements {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    text-align: center;

    padding: 30px 20px;

    min-height: 0;
    height: auto;

    color: #475569;
}

.empty-requirements i {
    font-size: 32px;
    color: #2563eb;
    margin-bottom: 12px;
}

.empty-requirements h5 {
    margin: 0 0 6px 0;

    font-size: 18px;
    font-weight: 700;

    color: #0f172a;
}

.empty-requirements p {
    margin: 0;

    font-size: 14px;
    color: #64748b;
}
/* =========================================
   MODAL HEADER
========================================= */


.modal-header-custom {

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    padding-bottom:15px;

    border-bottom:1px solid #e2e8f0;

}


.modal-header-custom h3 {

    margin:0;

    font-size:24px;

    font-weight:800;

    color:#0f172a;

}



.close-btn {

    width:40px;

    height:40px;

    border:none;

    border-radius:50%;

    background:#f1f5f9;

    color:#475569;

    font-size:20px;

    cursor:pointer;

    transition:.2s;

}


.close-btn:hover {

    background:#fee2e2;

    color:#dc2626;

}





/* =========================================
   REQUIREMENT CARD
========================================= */


.requirement-card {

    background:#ffffff;

    border:1px solid #e2e8f0;

    border-radius:18px;

    padding:22px;

    margin-bottom:20px;

    transition:.2s;

}


.requirement-card:hover {

    box-shadow:
    0 10px 25px rgba(0,0,0,.08);

}




.req-header {

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}


.req-header h3 {

    margin:0;

    font-size:19px;

    font-weight:800;

}




/* STATUS BADGE */

.requirement-status {

    padding:7px 15px;

    border-radius:50px;

    font-size:12px;

    font-weight:700;

}

.status-approved {

    background:#dcfce7;

    color:#166534;

}

.status-submitted {

    background:#dbeafe;

    color:#1d4ed8;

}

.status-pending {

    background:#fef3c7;

    color:#92400e;

}

.status-rejected {

    background:#fee2e2;

    color:#b91c1c;

}
/* =========================================
   REQUIREMENT INFORMATION
========================================= */


.req-body {

    background:#f8fafc;

    padding:18px;

    border-radius:14px;

}

.req-body p {

    margin-bottom:10px;

    color:#475569;

}

.req-body strong {

    color:#0f172a;

}
/* =========================================
   ATTACHMENT AREA
========================================= */
.attachment-section {


    margin-top:20px;

    padding:18px;

    background:#f8fafc;

    border-radius:15px;

}

.attachment-title {

    font-weight:700;

    margin-bottom:12px;

}

.attachment-section button,

.attachment-section a {


    border-radius:10px;

    padding:9px 15px;

}
/* =========================================
   ADMIN ACTION
========================================= */
.req-footer {

    display:flex;

    gap:12px;

    margin-top:20px;

}

.req-footer button {


    flex:1;

    border-radius:12px;

    padding:12px;

    font-weight:700;

}
/* =========================================
   PREVIEW MODAL
========================================= */


.preview-container {


    width:100%;

    min-height:400px;

    background:#f8fafc;

    border-radius:15px;

    padding:15px;

}

/* =========================================
   FORCE TABLE TEXT VISIBILITY
========================================= */

.card .table tbody td {
    color: #0f172a !important;
    background: #ffffff;
}

.card .table tbody tr:hover td {
    color: #0f172a !important;
    background: #f8fbff;
}

.card .table tbody td small {
    color: #64748b !important;
}

.monitor-toolbar input,
.monitor-toolbar select {
    color: #0f172a !important;
    background: #ffffff !important;
}

.monitor-toolbar input::placeholder {
    color: #64748b !important;
}

.monitor-toolbar select option {
    color: #0f172a !important;
    background: #ffffff;
}
/* MOBILE */

@media(max-width:768px){


    .req-header {

        flex-direction:column;

        align-items:flex-start;

        gap:10px;

    }


    .req-footer {

        flex-direction:column;

    }


}
</style>

<div class="page">


    {{-- =========================================
         PAGE HEADER
    ========================================== --}}

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



    {{-- =========================================
         SUMMARY CARDS
    ========================================== --}}

    <div class="summary-grid">


        {{-- TOTAL CADETS --}}

        <div class="summary-card">

            <div class="summary-icon icon-blue">

                <i class="fas fa-users"></i>

            </div>


            <div>

                <h3>
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

                <h3>

                    {{
                        $cadets->sum(function ($cadet) {

                            return $cadet->onboardRequirements
                                ->where('status','Approved')
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

                <h3>

                    {{
                        $cadets->sum(function ($cadet) {

                            return $cadet->onboardRequirements
                                ->where('status','Pending')
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

                <h3>

                    {{
                        $cadets->sum(function ($cadet) {

                            return $cadet->onboardRequirements
                                ->where('status','Rejected')
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






    {{-- =========================================
         SEARCH AND FILTERS
    ========================================== --}}


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







    {{-- =========================================
         CADET CARDS
    ========================================== --}}


 <div class="card">

    <table class="table">

        <thead>
            <tr>
                <th>#</th>
                <th><i class="fa-solid fa-id-card"></i> TRB</th>
                <th><i class="fa-solid fa-user"></i> Cadet</th>
                <th><i class="fa-solid fa-book"></i> Course</th>
                <th><i class="fa-solid fa-layer-group"></i> Batch</th>
                <th><i class="fa-solid fa-ship"></i> Deployment</th>
                <th><i class="fa-solid fa-chart-line"></i> Progress</th>
                <th><i class="fa-solid fa-gear"></i> Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($cadets as $cadet)

            @php
                $totalRequirements = $cadet->onboardRequirements->count();

                $approvedRequirements = $cadet->onboardRequirements
                    ->where('status','Approved')
                    ->count();

                $percentage = $totalRequirements
                    ? ($approvedRequirements/$totalRequirements)*100
                    : 0;
            @endphp

            <tr
                data-name="{{ strtolower($cadet->full_name) }}"
                data-batch="{{ optional($cadet->batch)->batch_year }}"
                data-course="{{ strtolower($cadet->course) }}"
                data-deployment="{{ strtolower($cadet->deployment->status ?? '') }}"
            >

                <td>{{ $loop->iteration }}</td>

                <td>{{ $cadet->trb_control_number }}</td>

                <td>{{ $cadet->full_name }}</td>

                <td>{{ $cadet->course }}</td>

                <td>{{ optional($cadet->batch)->batch_year ?? '-' }}</td>

                <td>{{ $cadet->deployment->status ?? '-' }}</td>

                <td>

                    <div class="progress-wrap">

                        <div class="progress-bar">

                            <div
                                class="progress-fill"
                                style="width:{{ $percentage }}%">
                            </div>

                        </div>

                        <small>

                            {{ $approvedRequirements }}
                            /
                            {{ $totalRequirements }}

                            Requirements

                        </small>

                    </div>

                </td>

                <td class="text-center">
                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick='viewChecklist(
                            {{ $cadet->id }},
                            @json(route("superadmin.cadet-requirements.show", $cadet->id))
                        )'
                    >
                        <i class="fa fa-eye"></i>
                        View
                    </button>
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8" class="text-center">

                    No deployed cadets found.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

{{-- =========================================
     CHECKLIST MODAL
========================================= --}}


<div id="checklistModal" class="modal">


    <div class="modal-content">


        <div class="modal-header-custom">


            <h3>

                <i class="fas fa-file-alt text-primary me-2"></i>

                <span id="cadetName">
                    
                </span>

            </h3>



            <button

                class="close-btn"

                onclick="closeChecklist()"

            >

                ✕


            </button>



        </div>




        <div id="checklistBody">


        </div>



    </div>


</div>






{{-- =========================================
     ATTACHMENT PREVIEW MODAL
========================================= --}}



<div id="previewModal" class="modal">


    <div class="modal-content">


        <div class="modal-header-custom">


            <h3>

                <i class="fas fa-eye text-primary me-2"></i>

                Attachment Preview

            </h3>



            <button

                class="close-btn"

                onclick="closePreview()"

            >

                ✕

            </button>


        </div>





        <div class="preview-container">


            <div id="previewBody">


            </div>


        </div>




    </div>


</div>
<script>
function viewChecklist(id, url) {

    const modal = document.getElementById('checklistModal');
    const body = document.getElementById('checklistBody');
    const name = document.getElementById('cadetName');

    modal.style.display = 'flex';

    name.textContent = 'Loading...';

    body.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary"></div>

            <p class="mt-3 text-muted">
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

        console.log('HTTP Status:', response.status);

        const text = await response.text();

        console.log('Server Response:', text);

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

        console.log('Cadet data:', data);

        name.textContent = data.full_name || 'Cadet';

        const requirements =
            Array.isArray(data.onboard_requirements)
                ? data.onboard_requirements
                : [];

            if (requirements.length === 0) {

                body.innerHTML = `
                    <div class="empty-requirements">

                        <i class="fas fa-file-circle-xmark"></i>

                        <h5>No Requirements Found</h5>

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

            let statusClass = 'status-pending';

            switch (item.status) {

                case 'Approved':
                    statusClass = 'status-approved';
                    break;

                case 'Submitted':
                    statusClass = 'status-submitted';
                    break;

                case 'Rejected':
                    statusClass = 'status-rejected';
                    break;

                case 'Pending':
                    statusClass = 'status-pending';
                    break;
            }

            const requirementTitle =
                item.requirement?.title || '-';

            const frequency =
                item.requirement?.frequency || '-';

            const attachmentHtml = item.attachment

                ? `
                    <button
                        type="button"
                        class="btn btn-info btn-sm"
                        onclick="previewAttachment(
                            '/storage/${item.attachment}'
                        )">

                        <i class="fas fa-eye"></i>
                        Preview

                    </button>

                    <a
                        href="/storage/${item.attachment}"
                        download
                        class="btn btn-success btn-sm">

                        <i class="fas fa-download"></i>
                        Download

                    </a>
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
                            <i class="fas fa-file-alt text-primary me-2"></i>
                            ${requirementTitle}
                        </h3>

                        <span class="
                            requirement-status
                            ${statusClass}
                        ">
                            ${item.status || 'Pending'}
                        </span>

                    </div>

                    <div class="req-body">

                        <p>
                            <strong>Frequency:</strong>
                            ${frequency}
                        </p>

                        <p>
                            <strong>Submitted:</strong>
                            ${item.submitted_at || '-'}
                        </p>

                        <p>
                            <strong>Approved:</strong>
                            ${item.approved_at || '-'}
                        </p>

                        <p>
                            <strong>Remarks:</strong>
                            ${item.remarks || '-'}
                        </p>

                    </div>

                    <div class="attachment-section">

                        <div class="attachment-title">
                            <i class="fas fa-paperclip"></i>
                            Attachment
                        </div>

                        <div>
                            ${attachmentHtml}
                        </div>

                    </div>

                    <div class="req-footer">

                        <div style="
                            width:100%;
                            text-align:center;
                            padding:12px;
                            background:#f1f5f9;
                            color:#64748b;
                            border-radius:12px;
                            font-weight:600;
                        ">

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

        console.error('Checklist Error:', error);

        name.textContent = 'Unable to Load';

        body.innerHTML = `
            <div class="alert alert-danger">

                <i class="fas fa-exclamation-triangle"></i>

                <strong>
                    Failed to load cadet requirements.
                </strong>

                <p class="mb-0 mt-2">
                    ${error.message}
                </p>

            </div>
        `;
    });
}

function showNotification(
    message,
    type='success'
){


    const notification =
    document.getElementById(
        'notification'
    );



    if(!notification){

        return;

    }



    const title =
    notification.querySelector(
        '.notif-title'
    );



    const text =
    document.getElementById(
        'notifMessage'
    );



    const icon =
    notification.querySelector(
        '.notif-icon'
    );




    text.textContent = message;




    if(type === 'success'){


        title.textContent =
        'Success';


        icon.innerHTML =
        '✓';


    }


    else{


        title.textContent =
        'Error';


        icon.innerHTML =
        '✕';


    }



    notification.classList.add(
        'show'
    );



    setTimeout(()=>{


        notification.classList.remove(
            'show'
        );


    },3000);



}




function hideNotification(){


    document
    .getElementById(
        'notification'
    )
    .classList.remove(
        'show'
    );


}








/* =========================================
   MODAL CONTROL
========================================= */


function closeChecklist(){


    document
    .getElementById(
        'checklistModal'
    )
    .style.display='none';


}




function closePreview(){


    document
    .getElementById(
        'previewModal'
    )
    .style.display='none';



    document
    .getElementById(
        'previewBody'
    )
    .innerHTML='';



}


// Close Checklist Modal when clicking outside
document.getElementById('checklistModal').addEventListener('click', function (e) {

    if (e.target === this) {
        closeChecklist();
    }

});

// Close Preview Modal when clicking outside
document.getElementById('previewModal').addEventListener('click', function (e) {

    if (e.target === this) {
        closePreview();
    }

});


/* =========================================
   ATTACHMENT PREVIEW
========================================= */


function previewAttachment(url){


    const extension =
    url.split('.')
    .pop()
    .toLowerCase();



    let html = '';



    if(
        [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ]
        .includes(extension)
    ){


        html = `

            <img

                src="${url}"

                style="
                width:100%;
                border-radius:15px;
                "

            >

        `;


    }



    else if(extension === 'pdf'){


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



    else{


        html = `


            <div class="text-center">


                <p>

                    Preview not available.

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





    document
    .getElementById(
        'previewBody'
    )
    .innerHTML = html;



    document
    .getElementById(
        'previewModal'
    )
    .style.display='flex';


}









/* =========================================
   SEARCH + FILTER
========================================= */


function filterCadets(){

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
        .value;

    const deployment =
        document
        .getElementById('deploymentFilter')
        .value
        .toLowerCase();

    document
        .querySelectorAll('.table tbody tr')
        .forEach(row => {

            const matchSearch =
                (row.dataset.name || '')
                .includes(search);

            const matchBatch =
                !batch ||
                (row.dataset.batch || '') == batch;

            const matchCourse =
                !course ||
                (row.dataset.course || '') == course.toLowerCase();

            const matchDeployment =
                !deployment ||
                (row.dataset.deployment || '') == deployment;


            if(
                matchSearch &&
                matchBatch &&
                matchCourse &&
                matchDeployment
            ){

                // IMPORTANT:
                // Keep the <tr> as a table row
                row.style.display = '';

            }
            else{

                row.style.display = 'none';

            }

        });

}




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