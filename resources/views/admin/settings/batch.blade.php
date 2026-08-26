@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/batch.css'])


<div class="main">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <button class="close-card" onclick="goBackToSettings()">
            &times;
        </button>

        <div class="top-title">
            Settings
        </div>

        <div class="header">

            <h2>Batch Management</h2>

            <button class="add-btn" onclick="openAddModal()">
                + Add Batch
            </button>

        </div>

        <table>

            <thead>
                <tr>
                    <th>Batch Year</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($batches as $batch)

                <tr>

                    <td>
                        Batch {{ $batch->batch_year }}
                    </td>

                    {{-- ✅ FIXED COURSE DISPLAY --}}
 <td>

    @if($batch->courses && $batch->courses->count())

        @foreach($batch->courses as $course)

            {{ $course->course_name }}<br>

        @endforeach

    @else

        No Courses Assigned

    @endif

</td>

                    <td>

                        <button class="edit-btn"
                            onclick='openEditModal(
                                    {{ $batch->id }},
                                    "{{ $batch->batch_year }}",
                                    @json($batch->courses->pluck("id"))
                                )'>
                            ✏ Edit
                        </button>

                        <form action="{{ route('admin.batch.delete',$batch->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="delete-btn">
                                🗑
                            </button>
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
            <h2>Add Batch</h2>
            <span class="close" onclick="closeAddModal()">&times;</span>
        </div>

        <form action="{{ route('admin.batch.store') }}" method="POST">

            @csrf

            <div class="modal-body">

                <div class="form-group">
                    <label>Batch Year *</label>

                    <input type="text"
                           name="batch_year"
                           class="form-control"
                           placeholder="Enter batch year">
                </div>

                <div class="form-group">

                    <label>Courses *</label>

                    <div class="course-box">

                        @foreach($courses as $course)

                            <label>
                                <input type="checkbox"
                                name="courses[]"
                                value="{{ $course->id }}">

                                {{ $course->course_name }}
                            </label>

                        @endforeach

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="cancel-btn"
                        onclick="closeAddModal()">
                    Cancel
                </button>

                <button class="save-btn">
                    Add Batch
                </button>

            </div>

        </form>

    </div>

</div>

<!-- EDIT MODAL -->

<div class="modal" id="editModal">

    <div class="modal-content">

        <div class="modal-header">
            <h2>Edit Batch</h2>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>

        <form id="editForm" method="POST">

            @csrf
            @method('PUT')

            <div class="modal-body">

                <div class="form-group">

                    <label>Batch Year *</label>

                    <input type="text"
                           name="batch_year"
                           id="edit_batch_year"
                           class="form-control">

                </div>

                <div class="form-group">

                    <label>Courses *</label>

                    <div class="course-box">

            @foreach($courses as $course)

                <label>
                    <input type="checkbox"
                        name="courses[]"
                        value="{{ $course->id }}"
                        class="edit-course">

                    {{ $course->course_name }}
                </label>

            @endforeach

                    </div>

                </div>

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

    const addModal = document.getElementById('addModal');

    addModal.style.display = 'flex';

}

function closeAddModal(){
    document.getElementById('addModal').style.display='none';
}

function openEditModal(id, year, courses){

    const editModal = document.getElementById('editModal');

    editModal.style.display = 'flex';

    document.getElementById('edit_batch_year').value = year;

    /*
    =========================================================
    RESET ALL COURSE CHECKBOXES
    =========================================================
    */

    document.querySelectorAll('.edit-course').forEach(function(checkbox){

        checkbox.checked = false;

    });


    /*
    =========================================================
    SELECT ASSIGNED COURSES
    =========================================================
    */

    if(Array.isArray(courses)){

        courses.forEach(function(courseId){

            document.querySelectorAll('.edit-course').forEach(function(checkbox){

                if(
                    parseInt(checkbox.value, 10) ===
                    parseInt(courseId, 10)
                ){

                    checkbox.checked = true;

                }

            });

        });

    }


    /*
    =========================================================
    UPDATE FORM ACTION
    =========================================================
    */

    document.getElementById('editForm').action =
        "/admin/batch-management/update/" + id;

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

</script>

<script>
function goBackToSettings() {
    window.location.href = "{{ route('admin.settings.index') }}";
}
</script>

@endsection