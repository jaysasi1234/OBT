@extends('layouts.superadmin')

@section('content')

<div class="page-header">
    <h2>Concern Monitoring</h2>
    <p>View all concern records.</p>
</div>

<div class="stats-grid">

    <div class="stat-card">
        <h4>Total Concerns</h4>
        <h2>{{ $totalComplaints }}</h2>
    </div>

    <div class="stat-card open">
        <h4>Open</h4>
        <h2>{{ $openComplaints }}</h2>
    </div>

    <div class="stat-card resolved">
        <h4>Resolved</h4>
        <h2>{{ $resolvedComplaints }}</h2>
    </div>

</div>

<div class="table-card">

    <form method="GET">
        <div class="filters">

            <input type="text" name="search" placeholder="Search Complaint..." value="{{ request('search') }}">

            <select name="status">
                <option value="">All Status</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>

            <button type="submit">Search</button>

        </div>
    </form>

    <div class="table-responsive">

        <table>

            <thead>
                <tr>
                    <th>TBR No.</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Concern Type</th>
                    <th>Status</th>
                    <th>Date Filed</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($complaints as $complaint)

                <tr>
                    <td>{{ $complaint->cadet->trb_control_number ?? 'N/A' }}</td>

                    <td>
                        {{ $complaint->cadet->full_name ?? 'N/A' }}
                    </td>

                    <td>{{ $complaint->cadet->course ?? 'N/A' }}</td>

                    <td>
                        {{ $complaint->subject }}
                    </td>

                    <td>
                        <span class="status-badge {{ $complaint->status }}">
                            {{ ucfirst($complaint->status) }}
                        </span>
                    </td>

                    <td>
                        {{ $complaint->created_at->format('M d, Y') }}
                    </td>

                    <td>
                        <button type="button"
                                class="btn-view"
                                onclick="openModal('modal{{ $complaint->id }}')">
                            View
                        </button>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6">No concerns found.</td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-3">
        {{ $complaints->links() }}
    </div>

</div>

<!-- =========================
     CUSTOM MODALS (NO BOOTSTRAP)
========================= -->

@foreach($complaints as $complaint)

<div id="modal{{ $complaint->id }}" class="custom-modal-overlay">

    <div class="custom-modal-box">

        <div class="custom-modal-header">
            <h3>Concern Details</h3>

            <button class="close-btn"
                    onclick="closeModal('modal{{ $complaint->id }}')">
                ✖
            </button>
        </div>

        <div class="custom-modal-body">

            <p><strong>Cadet:</strong> {{ $complaint->cadet->full_name ?? 'N/A' }}</p>

            <p><strong>Concern Type:</strong> {{ $complaint->subject }}</p>

            <p><strong>Status:</strong> {{ ucfirst($complaint->status) }}</p>

            <p><strong>Date Filed:</strong> {{ $complaint->created_at->format('F d, Y h:i A') }}</p>

            <div class="description-box">
                {{ $complaint->message ?? 'No description available.' }}
            </div>

        </div>

    </div>

</div>

@endforeach

<style>

.page-header{
    color:white;
    margin-bottom:20px;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.stat-card{
    background:#1f1b6b;
    color:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,.25);
}

.open{ background:#dc2626; }
.resolved{ background:#16a34a; }

.table-card{
    background:#1f1b6b;
    padding:20px;
    border-radius:15px;
}

.filters{
    display:flex;
    gap:10px;
    margin-bottom:15px;
    flex-wrap:wrap;
}

.filters input,
.filters select{
    padding:10px;
    border:none;
    border-radius:8px;
    min-width:180px;
}

.filters button{
    background:#2563eb;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
}

.table-responsive{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#4f46e5;
}

th,td{
    padding:12px;
    color:white;
    text-align:left;
}

tr{
    border-bottom:1px solid rgba(255,255,255,.08);
}

.btn-view{
    background:#0ea5e9;
    border:none;
    color:white;
    padding:8px 14px;
    border-radius:8px;
    cursor:pointer;
}

/* =========================
   CUSTOM MODAL
========================= */

.custom-modal-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.6);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:2000;
}

.custom-modal-box{
    width:500px;
    max-width:90%;
    background:#1e1b6b;
    color:white;
    border-radius:12px;
    padding:20px;
    animation:pop .2s ease;
}

@keyframes pop{
    from{ transform:scale(.8); opacity:0; }
    to{ transform:scale(1); opacity:1; }
}

.custom-modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid rgba(255,255,255,.2);
    padding-bottom:10px;
}

.close-btn{
    background:red;
    border:none;
    color:white;
    padding:5px 10px;
    border-radius:5px;
    cursor:pointer;
}

.custom-modal-body p{
    margin:10px 0;
}

.description-box{
    margin-top:10px;
    background:#312e81;
    padding:10px;
    border-radius:8px;
}

.status-badge{
    padding:6px 12px;
    border-radius:20px;
}

.status-badge.open{ background:#dc2626; }
.status-badge.resolved{ background:#16a34a; }

@media(max-width:768px){

    .stats-grid{
        grid-template-columns:1fr;
    }

    .filters{
        flex-direction:column;
    }

    .filters input,
    .filters select,
    .filters button{
        width:100%;
    }

}

</style>

<script>

function openModal(id){
    document.getElementById(id).style.display = "flex";
}

function closeModal(id){
    document.getElementById(id).style.display = "none";
}

// click outside to close
window.onclick = function(event){
    document.querySelectorAll('.custom-modal-overlay').forEach(modal => {
        if(event.target === modal){
            modal.style.display = "none";
        }
    });
}

window.onload = function () {

    const params = new URLSearchParams(window.location.search);

    const complaint = params.get('complaint');

    if (complaint) {

        const modal = document.getElementById('modal' + complaint);

        if (modal) {
            modal.style.display = 'flex';
        }

    }

};

</script>

@if($selectedComplaint)

<script>

document.addEventListener('DOMContentLoaded', function () {

    openModal('modal{{ $selectedComplaint }}');

});

</script>

@endif

@endsection