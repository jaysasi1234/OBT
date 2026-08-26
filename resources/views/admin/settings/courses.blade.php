@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/course.css'])


<div class="main">

    <div class="wrapper">

    <a href="{{ route('admin.settings.index') }}" class="page-close">
    ×
</a>

        <div class="page-title">
            Settings
        </div>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="top-bar">

            <div>
                <h2>Course Management</h2>
                <p>Manage cadet courses</p>
            </div>

            <button class="add-btn" onclick="openModal()">
                + Add Course
            </button>

        </div>

        <!-- TABLE -->

        <table>

            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($courses as $course)

                    <tr>

                        <td>{{ $course->course_code }}</td>

                        <td>{{ $course->course_name }}</td>

                        <td>

                            <button class="action-btn"
                                onclick="editCourse(
                                    '{{ $course->id }}',
                                    '{{ $course->course_code }}',
                                    '{{ $course->course_name }}'
                                )">
                                ✏ Edit
                            </button>

                            <form action="{{ route('admin.course.delete', $course->id) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button class="action-btn delete-btn">
                                    🗑
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3">
                            No courses found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- MODAL -->

<div class="modal" id="courseModal">

    <div class="modal-content">

        <div class="modal-header">

            <h2 id="modalTitle">Add Course</h2>

            <span class="close" onclick="closeModal()">
                ×
            </span>

        </div>

        <form method="POST" id="courseForm">

            @csrf

            <div id="methodField"></div>

            <div class="modal-body">

                <div class="form-group">

                    <label>Course Code *</label>

                    <input type="text"
                           name="course_code"
                           id="course_code"
                           required>

                </div>

                <div class="form-group">

                    <label>Course Name *</label>

                    <input type="text"
                           name="course_name"
                           id="course_name"
                           required>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="cancel-btn"
                        onclick="closeModal()">
                    Cancel
                </button>

                <button type="submit"
                        class="save-btn"
                        id="saveBtn">
                    Add Course
                </button>

            </div>

        </form>

    </div>

</div>

<script>

const modal = document.getElementById('courseModal');

const form = document.getElementById('courseForm');

function openModal(){

    modal.style.display = 'flex';

    document.getElementById('modalTitle').innerText = 'Add Course';

    document.getElementById('saveBtn').innerText = 'Add Course';

    form.action = "{{ route('admin.course.store') }}";

    document.getElementById('methodField').innerHTML = '';

    document.getElementById('course_code').value = '';

    document.getElementById('course_name').value = '';
}

function closeModal(){
    modal.style.display = 'none';
}

function editCourse(id, code, name){

    modal.style.display = 'flex';

    document.getElementById('modalTitle').innerText = 'Edit Course';

    document.getElementById('saveBtn').innerText = 'Update Course';

    form.action = '/admin/course-management/update/' + id;

    document.getElementById('methodField').innerHTML =
        '@method("PUT")';

    document.getElementById('course_code').value = code;

    document.getElementById('course_name').value = name;
}

window.onclick = function(e){

    if(e.target == modal){
        closeModal();
    }

}

</script>

@endsection