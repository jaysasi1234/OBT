@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/complaints/complaints.css'])

<div class="main">
    @if(session('success'))
    <div id="successNotif" class="success-notif">
        {{ session('success') }}
    </div>
@endif

<!-- HEADER -->
<div class="header">
    <h2>Concern Monitoring</h2>
    <button class="btn add-btn" onclick="openAddModal()">
    + Add Concern
</button>
</div>

<!-- CARDS -->
<div class="cards">

    <div class="card card-blue">
        <div class="card-info">
            <h2>{{ $complaints->count() }}</h2>
            <p>Total Concerns</p>
        </div>

        <div class="card-icon">
            📋
        </div>
    </div>

    <div class="card card-red">
        <div class="card-info">
            <h2>{{ $open }}</h2>
            <p>Open Concerns</p>
        </div>

        <div class="card-icon">
            ⚠️
        </div>
    </div>

    <div class="card card-green">
        <div class="card-info">
            <h2>{{ $resolved }}</h2>
            <p>Resolved Cases</p>
        </div>

        <div class="card-icon">
            ✅
        </div>
    </div>

    <div class="card card-yellow">
        <div class="card-info">
            <h2>{{ $cadetsWithComplaint }}</h2>
            <p>Cadets with Concerns</p>
        </div>

        <div class="card-icon">
            👨‍🎓
        </div>
    </div>

</div>

<!-- FILTERS -->
<div class="filters">

<!-- COURSE -->
<div class="dropdown">
    <button onclick="toggle('courseMenu')">Courses ▼</button>
    <div id="courseMenu" class="dropdown-content">
        @forelse($courses as $course)
            <label>
                <input type="checkbox" value="{{ strtolower($course) }}">
                {{ $course }}
            </label>
        @empty
            <label>No courses found</label>
        @endforelse
    </div>
</div>

<!-- BATCH -->
<div class="dropdown">
    <button onclick="toggle('batchMenu')">Batches ▼</button>
    <div id="batchMenu" class="dropdown-content">
        @forelse($batches as $batch)
            <label>
                <input type="checkbox" value="{{ strtolower($batch) }}">
                Batch {{ $batch }}
            </label>
        @empty
            <label>No batches found</label>
        @endforelse
    </div>
</div>

<!-- STATUS -->
<div class="dropdown">
    <button onclick="toggle('statusMenu')">Status ▼</button>
    <div id="statusMenu" class="dropdown-content">
        <label><input type="checkbox" value="open"> Open</label>
        <label><input type="checkbox" value="resolved"> Resolved</label>
    </div>
</div>

<!-- SEARCH -->
<input type="text" id="searchInput" placeholder="Search Cadet Name...">

</div>

<!-- TABLE -->
<div class="table-box">

<table>
<thead>
<tr>
    <th>#</th>
    <th>TBR No.</th>
    <th>Name</th>
    <th>Course</th>
    <th>Batch</th>
    <th>Concern</th>
    <th>Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@forelse($complaints as $complaint)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $complaint->cadet->trb_control_number ?? 'N/A' }}</td>
<td>{{ $complaint->cadet->full_name ?? 'N/A' }}</td>
<td>{{ $complaint->cadet->course ?? 'N/A' }}</td>
<td>{{ $complaint->cadet->batch->batch_year ?? 'N/A' }}</td>
<td>{{ $complaint->subject }}</td>
<td>{{ $complaint->created_at->format('M d, Y') }}</td>

<td>
@if($complaint->status == 'Resolved')
    <span class="status resolved">Resolved</span>
@else
    <span class="status open">Open</span>
@endif
</td>

<!-- VIEW BUTTON -->
<td>
<button 
class="btn btn-view"
onclick='openModal(@json($complaint))'>
    View
</button>
</td>

</tr>
@empty
<tr>
<td colspan="9">No concerns found</td>
</tr>
@endforelse
</tbody>

</table>



</div>

<!-- MODAL -->
<div id="viewModal" class="modal">

<div class="modal-content">

    <!-- TOP -->
    <div class="modal-header">
        <h2>View concern</h2>
        <span class="close" onclick="closeModal()">×</span>
    </div>

    <!-- BODY -->
    <div class="modal-body">

        <!-- LEFT -->
        <div class="modal-left">

            <h3>Cadet info</h3>

            <div class="cadet-image">
    <img id="cadetPhoto" src="https://via.placeholder.com/170">
</div>

            <div class="cadet-details">
                <h2 id="m_name"></h2>

                <p>TBR No.: <span id="m_trb"></span></p>
                <p>Course: <span id="m_course"></span></p>
                <p>Batch: <span id="m_batch"></span></p>

                <p style="margin-top:15px;">Deployment Status:</p>
                <strong>Ongoing</strong>
            </div>

        </div>

        <!-- CENTER -->
        <div class="modal-center">

            <h3>Concern details</h3>

            <div class="detail-box">
                <p>Type: <span id="m_subject"></span></p>

                <p>
                    Status:
                    <span id="m_status_badge" class="status resolved"></span>
                </p>

                <p>Date Filed: <span id="m_date"></span></p>
                <p>Date Resolved: <span id="m_resolved"></span></p>
            </div>

            <div class="evidence-box">

                <div class="evidence-top">
                    <h3>Attach evidence</h3>

                    <span id="m_status_badge2"
                    class="status resolved"></span>
                </div>

                <div class="evidence-preview">
                        <img
                            id="evidencePreview"
                            onclick="openImageViewer()"
                            style="
                            width:100%;
                            height:100%;
                            object-fit:cover;
                            display:none;
                            cursor:pointer;
                        ">
                </div>

                <div class="file-box">
                    <div>
                        <div>

                            <a
                                id="evidenceLink"
                                href="#"
                                target="_blank"
                                style="display:none;">
                            </a>

                        </div>

                        <br>
                    </div>

<button
    id="viewEvidenceBtn"
    class="btn btn-view">
    View
</button>
                </div>

            </div>

        </div>

<!-- RIGHT -->
<div class="modal-right">

    <h3>Action & Resolution</h3>

    <div class="detail-box">

        <p><strong>Action Taken:</strong></p>

        <textarea id="m_description" readonly></textarea>

    </div>



</div>

    </div>

    <!-- FOOTER -->
    <div class="modal-footer">

<button class="btn reopen-btn"
onclick="openReopenModal()">
    Reopen Complaint
</button>

        <button class="btn close-btn"
        onclick="closeModal()">
            Close
        </button>

    </div>

</div>

<!-- REOPEN MODAL -->
<div id="reopenModal" class="modal">

<div class="modal-content">

    <!-- HEADER -->
    <div class="modal-header">
        <h2>Reopen Concern</h2>

        <span class="close"
        onclick="closeReopenModal()">
            ×
        </span>
    </div>

    <!-- BODY -->
    <div class="modal-body">

        <!-- LEFT -->
        <div class="modal-left">

            <h3>Cadet info</h3>

            <div class="cadet-image">
                <img id="r_photo" src="https://via.placeholder.com/170">
            </div>

            <div class="cadet-details">

                <h2 id="r_name"></h2>

                <p>TBR No.: <span id="r_trb"></span></p>
                <p>Course: <span id="r_course"></span></p>
                <p>Batch: <span id="r_batch"></span></p>

                <p style="margin-top:15px;">
                    Deployment Status:
                </p>

                <strong>Ongoing</strong>

            </div>

        </div>

        <!-- CENTER -->
        <div class="modal-center">

            <h3>Concern details</h3>

            <div class="detail-box">

                <p>Type: <span id="r_subject"></span></p>

                <p>
                    Status:
                    <span id="r_status_badge" class="status"></span>
                </p>

                <p>Date Filed: <span id="r_date"></span></p>

            </div>

            <div class="evidence-box">

                <div class="evidence-top">

                    <h3>Attach evidence</h3>

                <span id="r_status_badge2" class="status"></span>

                </div>

                <div class="evidence-preview"></div>

                <div class="file-box">

                    <div>
                        <a id="reopenEvidenceLink"
                        href="#"
                        target="_blank"
                        style="display:none">
                            View Uploaded File
                        </a>
                        <br>

                    </div>

                    <button class="btn btn-view">
                        View
                    </button>

                </div>

            </div>

        </div>

<!-- RIGHT -->
<div class="modal-right">

<form id="resolveForm"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

            <h3>Action Taken</h3>

        <textarea
        name="action_taken"
        class="remark-input"
        style="height:150px"
        required></textarea>

            <div style="margin-top:15px;">

    <!-- REMARKS -->
    <div style="margin-top:15px;">

        <label>Remarks (Optional)</label>

        <input
        type="text"
        name="remarks"
        class="remark-input">

    </div>

    <!-- FILE -->
    <div style="margin-top:10px;">

        <label>Upload Supporting file: (Optional)</label>

        <div class="upload-box">

            <input
                type="file"
                name="support_file">

        </div>

    </div>

            </div>

<div class="action-buttons">

    <button
        type="submit"
        name="status"
        value="Resolved"
        class="resolve-btn">
        ✔ Mark as Resolved
    </button>

    <button
        type="submit"
        name="status"
        value="Open"
        class="open-btn">
        ◌ Set as Open
    </button>

</div>

</form>
</div>
</div> 

<div class="modal-footer">
    <button
        type="button"
        class="btn close-btn"
        onclick="closeReopenModal()">
        Cancel
    </button>
</div>

</div>
</div>
</div>

<!-- ADD COMPLAINT MODAL -->
<div id="addComplaintModal" class="add-modal">

    <div class="add-modal-content">

        <!-- HEADER -->
        <div class="add-modal-header">
            <h2>Add Concern</h2>

            <span class="add-close"
                  onclick="closeAddModal()">
                ×
            </span>
        </div>

        <!-- FORM -->
        <form action="{{ route('admin.complaints.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="add-modal-body">

                <!-- CADET -->
                <div class="form-group">
                    <label>Cadet Name:</label>

                    <select name="cadet_id" required>

                        <option value="">Select Cadet...</option>

                        @foreach($cadets ?? [] as $cadet)
                            <option value="{{ $cadet->id }}">
                                {{ $cadet->full_name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- TYPE -->
                <div class="form-group">
                    <label>Concern Type:</label>

                    <select name="subject" required>
                        <option value="">Select</option>

                        <option value="Behavior">Behavior</option>
                        <option value="Uniform">Uniform</option>
                        <option value="Attendance">Attendance</option>
                        <option value="Harassment">Harassment</option>
                        <option value="Safety">Safety</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label>Description:</label>

                    <textarea name="description"
                              placeholder="Enter Details here..."
                              required></textarea>
                </div>

                <!-- FILE -->
                <div class="form-group">
                    <label>
                        File Attachment
                        <span style="opacity:.7;">(Optional)</span>
                    </label>

                    <input type="file" name="support_file">
                </div>

            </div>

            <!-- FOOTER -->
            <div class="add-modal-footer">

                <button type="button"
                        class="modal-btn cancel-btn"
                        onclick="closeAddModal()">
                    Cancel
                </button>

                <button type="submit"
                        class="modal-btn submit-btn">
                    Submit Concern
                </button>

            </div>

        </form>

    </div>

</div>

<!-- IMAGE PREVIEW MODAL -->
<div id="imageViewerModal" class="modal">

    <div style="
        position:relative;
        max-width:90%;
        max-height:90%;
    ">

        <span
            onclick="closeImageViewer()"
            style="
                position:absolute;
                top:-40px;
                right:0;
                font-size:40px;
                color:white;
                cursor:pointer;
            ">
            &times;
        </span>

        <img
            id="imageViewer"
            src=""
            style="
                max-width:100%;
                max-height:85vh;
                border-radius:15px;
                display:block;
            ">

    </div>

</div>

<script>

// DROPDOWN TOGGLE (FIXED)
function toggle(id) {
    document.querySelectorAll(".dropdown-content").forEach(el => {
        if (el.id !== id) el.style.display = "none";
    });

    let el = document.getElementById(id);
    el.style.display = (el.style.display === "block") ? "none" : "block";
}

// CLOSE ON OUTSIDE CLICK
document.addEventListener("click", function(e) {
    if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown-content").forEach(el => {
            el.style.display = "none";
        });
    }
});

// FILTERING
document.getElementById("searchInput")
.addEventListener("keyup", filterTable);

document.querySelectorAll(".dropdown-content input")
.forEach(i => i.addEventListener("change",filterTable));

function getChecked(id) {
    let arr = [];
    document.querySelectorAll(`#${id} input:checked`)
    .forEach(c => arr.push(c.value.toLowerCase()));
    return arr;
}

function filterTable() {

    let search = document.getElementById("searchInput").value.toLowerCase();
    let course = getChecked("courseMenu");
    let batch = getChecked("batchMenu");
    let status = getChecked("statusMenu");

    document.querySelectorAll("tbody tr").forEach(row => {

        let name = row.children[2].innerText.toLowerCase();
        let c = row.children[3].innerText.toLowerCase();
        let b = row.children[4].innerText.toLowerCase();
        let s = row.children[7].innerText.toLowerCase();

        let ok =
            (course.length === 0 || course.includes(c)) &&
            (batch.length === 0 || batch.some(x => b.includes(x))) &&
            (status.length === 0 || status.some(x => s.includes(x))) &&
            name.includes(search);

        row.style.display = ok ? "" : "none";
    });
}

function openModal(complaint)
{

    let id = complaint.id;

    let cadet = complaint.cadet;


    let name = cadet?.full_name ?? "N/A";
    let trb = cadet?.trb_control_number ?? "N/A";
    let course = cadet?.course ?? "N/A";
    let batch = cadet?.batch?.batch_year ?? "N/A";

    let subject = complaint.subject;
    let status = complaint.status;

    let date = new Date(complaint.created_at)
        .toLocaleDateString(
            'en-US',
            {
                month:'long',
                day:'numeric',
                year:'numeric'
            }
        );


    let resolvedDate =
        complaint.resolved_at
        ?
        new Date(complaint.resolved_at)
        .toLocaleDateString()
        :
        "Not resolved yet";


    let description =
        complaint.description ?? "";


    let photo =
        cadet?.photo
        ?
        "/storage/" + cadet.photo
        :
        "https://via.placeholder.com/170";


    let file =
        complaint.support_file
        ?
        "/storage/" + complaint.support_file
        :
        null;



    /*
    FORM ACTION
    */

    let url =
    "{{ route('admin.complaints.update', ':id') }}";

    url = url.replace(':id',id);

    document.getElementById(
        "resolveForm"
    ).action=url;



    /*
    CADET INFO
    */

    document.getElementById("m_name").innerText=name;
    document.getElementById("m_trb").innerText=trb;
    document.getElementById("m_course").innerText=course;
    document.getElementById("m_batch").innerText=batch;



    /*
    DETAILS
    */

    document.getElementById("m_subject").innerText=subject;
    document.getElementById("m_date").innerText=date;
    document.getElementById("m_resolved").innerText=resolvedDate;

    document.getElementById(
        "m_description"
    ).value=description;



    /*
    PHOTO FIX
    */

    document.getElementById(
        "cadetPhoto"
    ).src=photo;


    document.getElementById(
        "r_photo"
    ).src=photo;



    /*
    STATUS
    */

    let badge1 =
    document.getElementById(
        "m_status_badge"
    );


    let badge2 =
    document.getElementById(
        "m_status_badge2"
    );


    badge1.innerText=status;
    badge2.innerText=status;


    window.currentComplaintStatus=status;


    if(status.toLowerCase()=="resolved")
    {

        badge1.className="status resolved";
        badge2.className="status resolved";

    }
    else
    {

        badge1.className="status open";
        badge2.className="status open";

    }



    /*
    FILE PREVIEW
    */


    let preview =
    document.getElementById(
        "evidencePreview"
    );


    let viewBtn =
    document.getElementById(
        "viewEvidenceBtn"
    );



    if(file)
    {

        viewBtn.style.display="inline-flex";


        viewBtn.onclick=function(){

            document.getElementById(
                "imageViewer"
            ).src=file;


            openImageViewer();

        };


        document.getElementById(
            "evidenceLink"
        ).href=file;


        document.getElementById(
            "evidenceLink"
        ).style.display="inline";


        if(
            file.match(
            /\.(jpg|jpeg|png|gif|webp)$/i
            )
        )
        {

            preview.src=file;
            preview.style.display="block";

        }
        else
        {

            preview.style.display="none";

        }


    }
    else
    {

        viewBtn.style.display="none";

        preview.removeAttribute("src");

        preview.style.display="none";

        document.getElementById(
            "evidenceLink"
        ).style.display="none";

    }



    document.getElementById(
        "viewModal"
    ).style.display="flex";

}

function closeModal(){
    document.getElementById("viewModal").style.display = "none";
}

window.onclick = function(e){

    let viewModal = document.getElementById("viewModal");
    let reopenModal = document.getElementById("reopenModal");
    let imageModal = document.getElementById("imageViewerModal");

    if(e.target === viewModal){
        closeModal();
    }

    if(e.target === reopenModal){
        closeReopenModal();
    }

    if(e.target === imageModal){
        closeImageViewer();
    }

}

function openReopenModal(){

    document.getElementById("r_name").innerText =
        document.getElementById("m_name").innerText;

    document.getElementById("r_trb").innerText =
        document.getElementById("m_trb").innerText;

    document.getElementById("r_course").innerText =
        document.getElementById("m_course").innerText;

    document.getElementById("r_batch").innerText =
        document.getElementById("m_batch").innerText;

    document.getElementById("r_subject").innerText =
        document.getElementById("m_subject").innerText;

    document.getElementById("r_date").innerText =
        document.getElementById("m_date").innerText;

    // Status
    let badge1 = document.getElementById("r_status_badge");
    let badge2 = document.getElementById("r_status_badge2");

    badge1.innerText = window.currentComplaintStatus;
    badge2.innerText = window.currentComplaintStatus;

    if(window.currentComplaintStatus.toLowerCase() === "resolved"){
        badge1.className = "status resolved";
        badge2.className = "status resolved";
    }else{
        badge1.className = "status open";
        badge2.className = "status open";
    }

    document.getElementById("reopenModal").style.display = "flex";
}

function closeReopenModal(){
    document.getElementById("reopenModal").style.display = "none";
}

function openImageViewer(){

    document.getElementById("imageViewerModal").style.display = "flex";

}

function closeImageViewer(){

    document.getElementById("imageViewerModal").style.display = "none";

}
</script>

<script>
function openAddModal(){
    document.getElementById("addComplaintModal").style.display = "flex";
}

function closeAddModal(){
    document.getElementById("addComplaintModal").style.display = "none";
}

window.addEventListener("click", function(e){

    let addModal = document.getElementById("addComplaintModal");

    if(e.target === addModal){
        closeAddModal();
    }
});
</script>

<script>
setTimeout(() => {

    let notif = document.getElementById('successNotif');

    if(notif){

        notif.style.transition = "0.5s";
        notif.style.opacity = "0";

        setTimeout(() => {
            notif.remove();
        }, 500);
    }

}, 3000);

@if(isset($selectedComplaint) && $selectedComplaint)

document.addEventListener("DOMContentLoaded", function(){

    let row = document.querySelector(
        'button[onclick*="{{ $selectedComplaint }}"]'
    );

    if(row){
        row.click();
    }

});

@endif
</script>

@endsection