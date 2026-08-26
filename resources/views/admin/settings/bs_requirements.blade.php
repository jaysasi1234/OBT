@extends('layouts.admin')

@section('header-title', 'BS Requirements')

@section('content')

@vite(['resources/css/admin/settings/bs_requirements.css'])



<div class="page">

    <div class="page-header">

        <div>

        <h2>BS Requirement Management</h2>
        <p>Manage all post-deployment BS requirements.</p>

        </div>

        <div style="display:flex; gap:10px;">

            <button class="add-btn" onclick="openModal()">
                <i class="fas fa-plus"></i> Add Requirement
            </button>

            <a href="{{ route('admin.settings.index') }}" class="close-page-btn">
                <i class="fas fa-times"></i>
            </a>

        </div>

</div>


<div class="cards">

        <div class="card">
            <h3>Total Requirements</h3>
            <h1>{{ $requirements->count() }}</h1>
        </div>

        <div class="card">
            <h3>Active</h3>
            <h1>{{ $requirements->where('is_active',1)->count() }}</h1>
        </div>

        <div class="card">
            <h3>Required</h3>
            <h1>{{ $requirements->where('is_required',1)->count() }}</h1>
        </div>

        <div class="card">
            <h3>Optional</h3>
            <h1>{{ $requirements->where('is_required',0)->count() }}</h1>
        </div>

</div>

<div class="toolbar">

        <div class="search-box">
            <input type="text" placeholder="Search requirement...">
        </div>

</div>

<div class="table-wrapper">

<table>

<thead>

    <tr>

        <th>#</th>

        <th>Requirement</th>

        <th>Description</th>

        <th>Required</th>

        <th>Status</th>

        <th>Action</th>

    </tr>

</thead>

<tbody>

    @forelse($requirements as $requirement)

        <tr>

            <td>{{ $requirement->sort_order }}</td>

            <td>{{ $requirement->title }}</td>

            <td>{{ $requirement->description }}</td>

            <td>

                @if($requirement->is_required)

        <span class="badge required">
            Required
        </span>

@else

        <span class="badge optional">
            Optional
        </span>

@endif

            </td>

            <td>

                @if($requirement->is_active)

        <span class="badge active">
            Active
        </span>

@else

        <span class="badge inactive">
            Inactive
        </span>

@endif

</td>

            <td>

                <button
                    class="action-btn edit"

                    data-id="{{ $requirement->id }}"
                    data-title="{{ $requirement->title }}"
                    data-description="{{ $requirement->description }}"
                    data-order="{{ $requirement->sort_order }}"
                    data-required="{{ $requirement->is_required }}"
                    data-active="{{ $requirement->is_active }}"

                    onclick="openEditModal(this)">

                    Edit

                </button>

                <button
                    class="action-btn delete"
                    onclick="openDeleteModal({{ $requirement->id }}, '{{ $requirement->title }}')">

                    Delete

                </button>

            </td>

        </tr>

                @empty

                    <tr>

                        <td colspan="6" style="text-align:center;padding:40px;">
                            No BS requirements found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- ADD REQUIREMENT MODAL -->

<div id="addModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">
            <h2>Add BS Requirement</h2>

            <span class="close" onclick="closeModal()">&times;</span>
        </div>

       <form action="{{ route('admin.bs-requirements.store') }}" method="POST">

            @csrf

            <div class="form-group">

                <label>Requirement Name</label>

                <input
                    type="text"
                    name="title"
                    required>

            </div>

            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    rows="3"></textarea>

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label>Display Order</label>

                <input
                    type="text"
                    name="sort_order"
                    placeholder="">

                </div>

            </div>

            <div class="form-row">

                <label>

                    <input
                        type="checkbox"
                        name="is_required"
                        value="1"
                        checked>

                    Required

                </label>

                <label>

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked>

                    Active

                </label>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeModal()">

                    Cancel

                </button>

                <button
                    class="save-btn"
                    type="submit">

                    Save Requirement

                </button>

            </div>

        </form>

    </div>

</div>


<!-- EDIT REQUIREMENT MODAL -->

<div id="editModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">
            <h2>Edit BS Requirement</h2>

            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Requirement Name</label>

                <input
                    type="text"
                    name="title"
                    id="edit_title"
                    required>
            </div>

            <div class="form-group">

                <label>Description</label>

                <textarea
                    name="description"
                    id="edit_description"
                    rows="3"></textarea>

            </div>


                <div class="form-group">

                    <label>Display Order</label>

                    <input
                        type="text"
                        name="sort_order"
                        id="edit_order"
                        placeholder="">

                </div>



            <div class="form-row">

                <label>

                    <input
                        type="checkbox"
                        id="edit_required"
                        name="is_required"
                        value="1">

                    Required

                </label>

                <label>

                    <input
                        type="checkbox"
                        id="edit_active"
                        name="is_active"
                        value="1">

                    Active

                </label>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeEditModal()">

                    Cancel

                </button>

                <button
                    class="save-btn"
                    type="submit">

                    Update Requirement

                </button>

            </div>

        </form>

    </div>

</div>

<div id="deleteModal" class="modal">

    <div class="modal-content" style="max-width:500px;">

        <div class="modal-header">

            <h2 style="color:#dc2626;">
                Delete Requirement
            </h2>

            <span class="close"
                  onclick="closeDeleteModal()">&times;</span>

        </div>

        <p style="font-size:16px;margin:25px 0;">

            Are you sure you want to delete

            <strong id="deleteTitle"></strong> ?

            <br><br>

            This action cannot be undone.

        </p>

        <form id="deleteForm" method="POST">

            @csrf
            @method('DELETE')

            <div class="modal-footer">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeDeleteModal()">

                    Cancel

                </button>

                <button
                    class="delete save-btn"
                    type="submit">

                    Delete

                </button>

            </div>

        </form>

    </div>

</div>
<script>
function openModal() {
    document.getElementById('addModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('addModal').style.display = 'none';
}

function openEditModal(button) {

    document.getElementById("edit_title").value = button.dataset.title;
    document.getElementById("edit_description").value = button.dataset.description;
    document.getElementById("edit_order").value = button.dataset.order;

    document.getElementById("edit_required").checked =
        button.dataset.required == "1";

    document.getElementById("edit_active").checked =
        button.dataset.active == "1";

    document.getElementById("editForm").action =
        "/admin/bs-requirements/" + button.dataset.id;

    document.getElementById("editModal").style.display = "flex";
}

function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
}

window.onclick = function(e) {

    if (e.target == document.getElementById('addModal')) {
        closeModal();
    }

    if (e.target == document.getElementById('editModal')) {
        closeEditModal();
    }
}

function openDeleteModal(id,title){

    document.getElementById("deleteTitle").innerHTML=title;

    document.getElementById("deleteForm").action =
    "/admin/bs-requirements/" + id;

    document.getElementById("deleteModal")
    .style.display="flex";

}

function closeDeleteModal(){

    document.getElementById("deleteModal")
    .style.display="none";

}
</script>
@endsection