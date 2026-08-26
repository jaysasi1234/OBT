@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/requirement.css'])



<div class="main">

@if(session('success'))

    <div class="alert-success" id="successAlert">
        {{ session('success') }}
    </div>

@endif


    <div class="card">

    <a href="{{ route('admin.settings.index') }}"
        class="close-page-btn"
        title="Back to Settings">
         ✕
    </a>

        <div class="card-header">
            <h2>Requirements Management</h2>

            <button class="add-btn" onclick="openAddModal()">
                + Add Requirement
            </button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Course</th>
                    <th>Required</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($documents as $req)
                <tr>
                    <td>{{ $req->name }}</td>
                    <td>{{ $req->description }}</td>
                    <td>{{ $req->course }}</td>
                    <td>
                        @if($req->is_required)
                            ✔
                        @else
                            —
                        @endif
                    </td>
                    <td>

                        <button class="edit-btn"
                            onclick="openEditModal(
                                '{{ $req->id }}',
                                '{{ $req->name }}',
                                '{{ $req->description }}',
                                '{{ $req->course }}',
                                '{{ $req->is_required }}'
                            )">
                            Edit
                        </button>

                        <form action="{{ route('admin.requirements.delete',$req->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="delete-btn">🗑</button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- ADD MODAL -->
<div class="modal" id="addModal">

    <div class="modal-content">

        <div class="modal-header">
            <h2>Add Requirement</h2>
            <span class="close" onclick="closeAddModal()">&times;</span>
        </div>

        <form action="{{ route('admin.requirements.store') }}" method="POST">
            @csrf

            <div class="modal-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Course</label>
                    <select name="course" class="form-control">
                        <option value="BSMT">BSMT</option>
                        <option value="BSMarE">BSMarE</option>
                        <option value="Both">Both</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Required</label>
                    <div class="radio-group">
                        <label><input type="radio" name="is_required" value="1" checked> Yes</label>
                        <label><input type="radio" name="is_required" value="0"> No</label>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
                <button class="save-btn">Save</button>
            </div>

        </form>

    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal" id="editModal">

    <div class="modal-content">

        <div class="modal-header">
            <h2>Edit Requirement</h2>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Course</label>
                    <select name="course" id="edit_course" class="form-control">
                        <option value="BSMT">BSMT</option>
                        <option value="BSMarE">BSMarE</option>
                        <option value="Both">Both</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Required</label>
                    <div class="radio-group">
                        <label><input type="radio" name="is_required" id="req_yes" value="1"> Yes</label>
                        <label><input type="radio" name="is_required" id="req_no" value="0"> No</label>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                <button class="save-btn">Update</button>
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

function openEditModal(id,name,description,course,required){

    document.getElementById('editModal').style.display='block';

    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_course').value = course;

    if(required == 1){
        document.getElementById('req_yes').checked = true;
    }else{
        document.getElementById('req_no').checked = true;
    }

    document.getElementById('editForm').action =
        "/admin/requirements-management/update/" + id;
}

function closeEditModal(){
    document.getElementById('editModal').style.display='none';
}

window.onclick = function(e){
    if(e.target == document.getElementById('addModal')){
        closeAddModal();
    }
    if(e.target == document.getElementById('editModal')){
        closeEditModal();
    }
}

// AUTO HIDE ALERT

setTimeout(() => {

    let alert = document.getElementById('successAlert');

    if(alert){

        alert.style.transition = "0.5s";
        alert.style.opacity = "0";

        setTimeout(() => {
            alert.remove();
        }, 500);

    }

}, 3000);

</script>

@endsection