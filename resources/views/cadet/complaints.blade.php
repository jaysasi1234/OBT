@extends('layouts.cadet')

@section('content')

<style>

/* PAGE WRAPPER */
.page{
    padding:30px;
    color:white;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    gap:20px;
}

.page-title h2{
    margin:0;
    font-size:32px;
    font-weight:700;
}

.page-title p{
    margin:5px 0 0;
    color:#bfc5ff;
}

@media(max-width:768px){

    .page-header{
        flex-direction:column;
        align-items:flex-start;
    }

}

/* ALERTS */
.alert {
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 10px;
    font-size: 14px;
}

.alert.success { background: #16a34a; }
.alert.error { background: #dc2626; }

/* BUTTON */
.btn{
    background:linear-gradient(
        135deg,
        #4f46e5,
        #6366f1
    );
    border:none;
    color:white;
    padding:12px 22px;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(99,102,241,.35);
}

/* TABLE WRAPPER */
.table-box{
    background:rgba(255,255,255,.05);
    backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,.08);
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
}

/* TABLE */
table{
    width:100%;
    table-layout:fixed;
    border-collapse:collapse;
    color:white;
}

th, td {
    padding: 12px;
    text-align: left;
    color: white;
    font-size: 14px;
}

thead{
    background:#141a45;
}

thead th{
    color:#dce3ff;
    font-weight:600;
    letter-spacing:.5px;
}

tr {
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

tbody tr{
    transition:.3s;
}

tbody tr:hover{
    background:rgba(255,255,255,.05);
}

/* VIEW BUTTON */
.view-btn{
    background:linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );
    border:none;
    padding:8px 15px;
    border-radius:10px;
    font-weight:600;
    transition:.3s;
}

.view-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(59,130,246,.3);
}

/* =====================================
   SUBMIT COMPLAINT MODAL
===================================== */

.modal{

display:none;
position:fixed;
inset:0;

background:rgba(0,0,0,.75);

backdrop-filter:blur(8px);

justify-content:center;
align-items:center;

padding:25px;

z-index:9999;

}

.submit-modal{

width:100%;
max-width:700px;

background:#171f4d;

border-radius:22px;

overflow:hidden;

border:1px solid rgba(255,255,255,.08);

box-shadow:
0 25px 60px rgba(0,0,0,.45);

animation:showModal .25s ease;

}

.submit-header{

padding:25px 30px;

display:flex;

justify-content:space-between;

align-items:center;

background:linear-gradient(
135deg,
#273b90,
#1c275d
);

}

.submit-header h2{

margin:0;

font-size:28px;

}

.submit-header p{

margin-top:5px;

color:#bfc5ff;

font-size:14px;

}

.submit-close{

background:none;

border:none;

font-size:34px;

color:white;

cursor:pointer;

}

.submit-body{

padding:30px;

display:flex;

flex-direction:column;

gap:25px;

}

.form-group{

display:flex;

flex-direction:column;

gap:10px;

}

.form-group label{

font-size:15px;

font-weight:600;

color:#dbe4ff;

}

.form-group select,

.form-group textarea{

background:#0e1438;

border:1px solid rgba(255,255,255,.08);

border-radius:14px;

padding:15px;

color:white;

font-size:15px;

transition:.3s;

resize:none;

}

.form-group select:focus,

.form-group textarea:focus{

outline:none;

border-color:#4f7cff;

box-shadow:
0 0 0 3px rgba(79,124,255,.2);

}

.submit-footer{

display:flex;

justify-content:flex-end;

gap:15px;

padding:25px 30px;

background:#131a45;

}

.cancel-btn{

padding:12px 28px;

border:none;

border-radius:12px;

background:#4b5563;

color:white;

cursor:pointer;

transition:.3s;

}

.cancel-btn:hover{

background:#374151;

}

.submit-btn{

padding:12px 28px;

border:none;

border-radius:12px;

background:linear-gradient(
135deg,
#2563eb,
#4f46e5
);

color:white;

font-weight:600;

cursor:pointer;

transition:.3s;

}

.submit-btn:hover{

transform:translateY(-2px);

box-shadow:
0 15px 30px rgba(79,70,229,.35);

}

@media(max-width:768px){

.submit-modal{

max-width:100%;

}

.submit-header{

padding:20px;

}

.submit-body{

padding:20px;

}

.submit-footer{

flex-direction:column;

}

.submit-footer button{

width:100%;

}

}

/* RESPONSIVE */
@media (max-width: 768px) {

    .page {
        padding: 15px;
    }

    .page h2 {
        font-size: 20px;
    }

    th, td {
        font-size: 13px;
        padding: 10px;
    }

    .btn {
        width: 100%;
    }

}

.status-badge{
    padding:6px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

.status-pending{
    background:rgba(245,158,11,.15);
    color:#f59e0b;
}

.status-review{
    background:rgba(59,130,246,.15);
    color:#3b82f6;
}

.status-resolved{
    background:rgba(34,197,94,.15);
    color:#22c55e;
}

/* =========================
   COMPLAINT VIEW MODAL
========================= */

.complaint-modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.75);
    z-index:9999;
    justify-content:center;
    align-items:center;
    padding:20px;
    backdrop-filter:blur(6px);
}

.complaint-container{
    width:100%;
    max-width:1100px;
    max-height:90vh;
    overflow-y:auto;

    background:#161c4f;
    border-radius:24px;
    border:1px solid rgba(255,255,255,.08);

    box-shadow:
    0 20px 50px rgba(0,0,0,.45);
}

@keyframes showModal{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.complaint-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 25px;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.complaint-header h2{
    margin:0;
    font-size:24px;
}

.complaint-header button{
    background:none;
    border:none;
    color:white;
    font-size:30px;
    cursor:pointer;
}

.complaint-body{
    display:grid;
    grid-template-columns:2fr 1fr;
}

.complaint-left{
    padding:25px;
    border-right:1px solid rgba(255,255,255,.1);
}

.complaint-right{
    padding:25px;
}

.detail-item{
    margin-bottom:20px;
}

.detail-item span{
    display:block;
    font-size:13px;
    color:#bfc5ff;
    margin-bottom:5px;
}

.detail-item h4{
    margin:0;
    font-size:18px;
}

.description-box,
.remarks-box{
    background:rgba(255,255,255,.08);
    padding:18px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,.1);
}

.description-box p,
.remarks-box p{
    margin:0;
    color:#d9dcff;
}

.status-card{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    border-radius:15px;
    padding:20px;
}

.status-card h3{
    text-align:center;
    margin-bottom:30px;
}

.timeline{
    list-style:none;
    padding:0;
    margin:0;
}

.timeline li{
    position:relative;
    padding-left:40px;
    margin-bottom:35px;
    font-size:16px;
}

.timeline li span{
    position:absolute;
    left:0;
    top:3px;
    width:18px;
    height:18px;
    border-radius:50%;
    border:2px solid #9ca3af;
}

.timeline li.completed span{
    background:#22c55e;
    border-color:#22c55e;
}

.timeline li.active span{
    background:#f59e0b;
    border-color:#f59e0b;
}

.complaint-footer{
    padding:20px;
    display:flex;
    justify-content:center;
    gap:15px;
    border-top:1px solid rgba(255,255,255,.1);
}

.edit-btn{
    background:#4f46e5;
    color:white;
    border:none;
    padding:12px 35px;
    border-radius:10px;
    cursor:pointer;
}

.close-btn2{
    background:#dc2626;
    color:white;
    border:none;
    padding:12px 35px;
    border-radius:10px;
    cursor:pointer;
}

@media(max-width:900px){

    .complaint-body{
        grid-template-columns:1fr;
    }

    .complaint-left{
        border-right:none;
        border-bottom:1px solid rgba(255,255,255,.1);
    }

}

/* =========================
   MOBILE RESPONSIVE FIX
========================= */

@media (max-width: 768px){

    .page{
        padding:15px;
    }

    .page h2{
        font-size:22px;
    }

    /* FULL WIDTH BUTTON */
    .btn{
        width:100%;
        margin-bottom:15px;
    }

    /* TABLE TO CARD */
    .table-box{
        padding:10px;
        background:transparent;
    }

    table,
    thead,
    tbody,
    th,
    td,
    tr{
        display:block;
        width:100%;
    }

    thead{
        display:none;
    }

    tbody tr{
        background:#1f2150;
        border-radius:15px;
        margin-bottom:15px;
        padding:15px;
        border:none;
    }

    td{
        border:none;
        padding:8px 0;
        text-align:right;
        position:relative;
        padding-left:50%;
        font-size:14px;
    }

    td::before{
        position:absolute;
        left:0;
        top:8px;
        font-weight:600;
        color:#bfc5ff;
        text-align:left;
    }

    td:nth-child(1)::before{
        content:"ID";
    }

    td:nth-child(2)::before{
        content:"Subject";
    }

    td:nth-child(3)::before{
        content:"Date";
    }

    td:nth-child(4)::before{
        content:"Status";
    }

    td:nth-child(5)::before{
        content:"Action";
    }

    .view-btn{
        width:100%;
        margin-top:5px;
    }

    /* MODAL */
    .modal-box{
        max-width:100%;
        padding:15px;
    }

    .complaint-container{
        width:100%;
        max-height:90vh;
        overflow-y:auto;
    }

    .complaint-header{
        padding:15px;
    }

    .complaint-header h2{
        font-size:18px;
    }

    .complaint-left,
    .complaint-right{
        padding:15px;
    }

    .detail-item h4{
        font-size:15px;
        word-break:break-word;
    }

    .description-box,
    .remarks-box{
        padding:12px;
    }

    .complaint-footer{
        flex-direction:column;
    }

    .edit-btn,
    .close-btn2{
        width:100%;
    }

    .timeline li{
        font-size:14px;
    }
}

.description-box p,
.remarks-box p{
    word-break:break-word;
    white-space:pre-wrap;
}


.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.stat-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);
    backdrop-filter:blur(20px);
    border-radius:20px;
    padding:20px;
}

.stat-card h3{
    margin:0;
    font-size:32px;
    color:#fff;
}

.stat-card p{
    margin-top:5px;
    color:#bfc5ff;
}

@keyframes showModal{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.complaint-container{
    animation:showModal .3s ease;
}
</style>

<div class="page-header">

    <div class="page-title">
        <h2>Concern Management</h2>
        <p>Submit concerns and track their status.</p>
    </div>

    <button class="btn" onclick="openModal()">
        + Submit Concern
    </button>

</div>

<div class="stats-grid">

    <div class="stat-card">
        <h3>{{ $complaints->count() }}</h3>
        <p>Total Concerns</p>
    </div>

    <div class="stat-card">
        <h3>{{ $complaints->where('status','Pending')->count() }}</h3>
        <p>Pending</p>
    </div>

    <div class="stat-card">
        <h3>{{ $complaints->where('status','Under Review')->count() }}</h3>
        <p>Under Review</p>
    </div>

    <div class="stat-card">
        <h3>{{ $complaints->where('status','Resolved')->count() }}</h3>
        <p>Resolved</p>
    </div>

</div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div id="success-message" class="alert success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION --}}
    @if ($errors->any())
        <div class="alert error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-box">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($complaints as $c)
                <tr>
                    <td>CMP-{{ str_pad($c->id,3,'0',STR_PAD_LEFT) }}</td>
                    <td>{{ $c->subject }}</td>
                    <td>{{ $c->created_at->format('M d, Y') }}</td>
<td>

@if($c->status == 'Resolved')

    <span class="status-badge status-resolved">
        {{ $c->status }}
    </span>

@elseif($c->status == 'Under Review')

    <span class="status-badge status-review">
        {{ $c->status }}
    </span>

@else

    <span class="status-badge status-pending">
        {{ $c->status }}
    </span>

@endif

</td>
                        <td data-label="Action">
                        <button class="view-btn"
                            onclick="openComplaintModal(
                                'CMP-{{ str_pad($c->id,3,'0',STR_PAD_LEFT) }}',
                                '{{ $c->subject }}',
                                '{{ $c->user->name ?? 'Cadet' }}',
                                '{{ $c->created_at->format('M d, Y') }}',
                                `{{ $c->description }}`,
                                '{{ $c->status }}',
                                `{{ $c->remarks ?? 'No remarks yet.' }}`
                            )">
                        View
                    </button>
                    </td>
                </tr>

                @endforeach
            </tbody>

        </table>

    </div>

                               <!-- VIEW COMPLAINT MODAL -->
<div id="complaintModal" class="complaint-modal">

    <div class="complaint-container">

        <div class="complaint-header">
            <h2>Concern Details</h2>
            <button onclick="closeComplaintModal()">&times;</button>
        </div>

        <div class="complaint-body">

            <div class="complaint-left">

                <div class="detail-item">
                    <span>ID</span>
                    <h4 id="cmp_id"></h4>
                </div>

                <div class="detail-item">
                    <span>Concern Type</span>
                    <h4 id="cmp_subject"></h4>
                </div>

                <div class="detail-item">
                    <span>Filed By</span>
                    <h4 id="cmp_user"></h4>
                </div>

                <div class="detail-item">
                    <span>Date Filed</span>
                    <h4 id="cmp_date"></h4>
                </div>

                <div class="detail-item">
                    <span>Description</span>

                    <div class="description-box">
                        <p id="cmp_description"></p>
                    </div>
                </div>

                <div class="detail-item">
                    <span>Admin Remarks</span>

                    <div class="remarks-box">
                        <p id="cmp_remarks"></p>
                    </div>
                </div>

            </div>

            <div class="complaint-right">

                <div class="status-card">

                    <h3>Status Progress</h3>

                    <ul class="timeline">

                        <li class="completed">
                            <span></span>
                            Concern Filed
                        </li>

                        <li id="reviewStep">
                            <span></span>
                            Under Review
                        </li>

                        <li id="resolvedStep">
                            <span></span>
                            Resolved
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <div class="complaint-footer">

            <button class="edit-btn">
                Edit Concern
            </button>

            <button class="close-btn2"
                    onclick="closeComplaintModal()">
                Close
            </button>

        </div>

    </div>

</div>


<!-- SUBMIT COMPLAINT MODAL -->
<div id="modal" class="modal">

<div class="submit-modal">

<div class="submit-header">

<div>
<h2>Submit Concern</h2>
<p>
Report issues encountered during your onboard training.
</p>
</div>

<button
type="button"
class="submit-close"
onclick="closeModal()">
&times;
</button>

</div>

<form
method="POST"
action="{{ route('cadet.complaints.store') }}">

@csrf

<div class="submit-body">

<div class="form-group">

<label>
Concern Type
</label>

<select
name="subject"
required>

<option value="">
Select Concern Type
</option>

@foreach($complaintTypes as $type)

<option value="{{ $type->complaint_type }}">
{{ $type->complaint_type }}
</option>

@endforeach

</select>

</div>

<div class="form-group">

<label>
Concern Description
</label>

<textarea
name="description"
rows="7"
placeholder="Explain your concern in detail..."
required></textarea>

</div>

</div>

<div class="submit-footer">

<button
type="button"
class="cancel-btn"
onclick="closeModal()">

Cancel

</button>

<button
type="submit"
class="submit-btn">

<i class="bi bi-send-fill"></i>

Submit Concern

</button>

</div>

</form>

</div>

</div>


<script>

function openComplaintModal(
    id,
    subject,
    user,
    date,
    description,
    status,
    remarks
){

    document.getElementById('cmp_id').innerText=id;
    document.getElementById('cmp_subject').innerText=subject;
    document.getElementById('cmp_user').innerText=user;
    document.getElementById('cmp_date').innerText=date;
    document.getElementById('cmp_description').innerText=description;
    document.getElementById('cmp_remarks').innerText=remarks;

    document.getElementById('reviewStep').classList.remove('active','completed');
    document.getElementById('resolvedStep').classList.remove('active','completed');

    if(status === 'Pending'){
        document.getElementById('reviewStep').classList.add('active');
    }

    if(status === 'Under Review'){
        document.getElementById('reviewStep').classList.add('completed');
    }

    if(status === 'Resolved'){
        document.getElementById('reviewStep').classList.add('completed');
        document.getElementById('resolvedStep').classList.add('completed');
    }

    document.getElementById('complaintModal').style.display='flex';
}



function closeComplaintModal(){
    document.getElementById('complaintModal').style.display='none';
}

window.onclick=function(e){
    const modal=document.getElementById('complaintModal');

    if(e.target===modal){
        closeComplaintModal();
    }
}

function openModal() {
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}



// auto hide success
setTimeout(() => {
    const msg = document.getElementById('success-message');
    if (msg) {
        msg.style.opacity = "0";
        setTimeout(() => msg.remove(), 500);
    }
}, 5000);
</script>

@endsection