@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/complaint.css'])


<div class="main-box">

        <a href="{{ route('admin.settings.index') }}"
        class="close-page-btn"
        title="Back to Settings">
            ✕
        </a>

        <div class="top">

            <div>
                <h2>Complaint Type Management</h2>
                <p style="color:#cbd5e1;margin-top:5px;">
                    Manage complaint categories available to cadets.
                </p>
            </div>

            <button class="add-btn" onclick="openAddModal()">
                + Add Complaint
            </button>

        </div>

@if(session('success'))
<div style="background:#16a34a;padding:10px;border-radius:8px;margin-bottom:15px;">
    {{ session('success') }}
</div>
@endif

<table>
    <thead>
        <tr>
            <th>Complaint Type</th>
            <th>Description</th>
            <th style="width:190px;">Actions</th>
        </tr>
    </thead>

    <tbody>

    @foreach($complaints as $complaint)

    <tr>
        <td>{{ $complaint->complaint_type }}</td>

        <td>{{ $complaint->description }}</td>

        <td>
    <div class="action-group">

        <button
            type="button"
            class="action-btn edit-btn"
            onclick="editComplaint(
                '{{ $complaint->id }}',
                '{{ $complaint->complaint_type }}',
                `{{ $complaint->description }}`
            )">
            Edit
        </button>

        <form
            action="{{ route('admin.complaint.types.delete', $complaint->id) }}"
            method="POST">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="action-btn delete-btn"
                onclick="return confirm('Delete this complaint type?')">
                Delete
            </button>

        </form>

    </div>
</td>
    </tr>

    @endforeach

    </tbody>
</table>

</div>

<!-- ADD MODAL -->
<div class="modal" id="addModal">

<div class="modal-content">

<form method="POST"
action="{{ route('admin.complaint.types.store') }}">

@csrf

<div class="modal-header">
    <h2>Add Complaint</h2>

    <span onclick="closeAddModal()" style="cursor:pointer;font-size:22px;">
        ×
    </span>
</div>

<div class="modal-body">

<label>Complaint Type *</label>

<input
    type="text"
    name="complaint_type"
    placeholder="Enter complaint type"
    required>

<label>Description *</label>

<textarea
    name="description"
    placeholder="Select description"
    required></textarea>

</div>

<div class="modal-footer">

<button type="button"
class="cancel-btn"
onclick="closeAddModal()">
    Cancel
</button>

<button class="save-btn">
    Add Complaint Type
</button>

</div>

</form>

</div>
</div>

<!-- EDIT MODAL -->
<div class="modal" id="editModal">

<div class="modal-content">

<form method="POST" id="editForm">

@csrf
@method('PUT')

<div class="modal-header">
    <h2>Edit Complaint</h2>

    <span onclick="closeEditModal()" style="cursor:pointer;font-size:22px;">
        ×
    </span>
</div>

<div class="modal-body">

<label>Complaint Type *</label>

<input
    type="text"
    name="complaint_type"
    id="editComplaintType"
    required>

<label>Description *</label>

<textarea
    name="description"
    id="editDescription"
    required></textarea>

</div>

<div class="modal-footer">

<button type="button"
class="cancel-btn"
onclick="closeEditModal()">
    Cancel
</button>

<button class="save-btn">
    Save Changes
</button>

</div>

</form>

</div>
</div>

<script>

function openAddModal(){
    document.getElementById('addModal').style.display='block';
}

function closeAddModal(){
    document.getElementById('addModal').style.display='none';
}

function closeEditModal(){
    document.getElementById('editModal').style.display='none';
}

function editComplaint(id, type, description){

    document.getElementById('editComplaintType').value = type;
    document.getElementById('editDescription').value = description;

    document.getElementById('editForm').action =
        "/admin/complaint-types/update/" + id;

    document.getElementById('editModal').style.display='block';
}

window.onclick = function(event){

    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');

    if(event.target == addModal){
        addModal.style.display='none';
    }

    if(event.target == editModal){
        editModal.style.display='none';
    }
}
</script>

@endsection