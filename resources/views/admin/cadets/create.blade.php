@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/cadets/create.css'])


<div class="cadet-create-page">

    <div class="create-container">

        <div class="create-card">


            <!-- =====================================================
                 HEADER
            ====================================================== -->

            <div class="create-header">

                <div class="header-left">

                    <div class="header-icon">
                        👤
                    </div>

                    <div class="header-title">

                        <h1>
                            Add New Cadet
                        </h1>

                        <p>
                            Enter the cadet's personal, academic, and guardian information
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="close-button"
                    id="closeModal"
                    aria-label="Close">

                    ✖

                </button>

            </div>


            <!-- =====================================================
                 VALIDATION ERRORS
            ====================================================== -->

            @if ($errors->any())

                <div class="error-box">

                    <div class="error-title">

                        <span>⚠</span>

                        <span>
                            Please fix the following errors
                        </span>

                    </div>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- =====================================================
                 FORM
            ====================================================== -->

            <div class="form-container">

                <form
                    method="POST"
                    action="{{ route('admin.cadets.store') }}"
                    enctype="multipart/form-data">

                    @csrf


                    <!-- =================================================
                         TABS
                    ================================================== -->

                    <div class="tabs-wrapper">

                        <div
                            class="tab active"
                            onclick="switchTab(0)">

                            Personal & Contact Information

                        </div>

                        <div
                            class="tab"
                            onclick="switchTab(1)">

                            Parent / Guardian Information

                        </div>

                    </div>


                    <!-- =================================================
                         TAB 1
                    ================================================== -->

                    <div class="tab-content active">


                        <div class="personal-layout">


                            <!-- =================================================
                                 BASIC INFORMATION
                            ================================================== -->

                            <div class="form-section">


                                <div class="section-heading">
                                    Basic Information
                                </div>


                                <!-- TRB -->

                                <div class="form-group">

                                    <label>
                                        TRB Control Number
                                    </label>

                                    <input
                                        type="text"
                                        name="trb_control_number"
                                        value="{{ old('trb_control_number') }}"
                                        placeholder="Enter TRB control number">

                                </div>


                                <!-- PHOTO -->

                                <div class="photo-section">

                                    <div class="photo-preview">

                                        <img
                                            id="previewImg"
                                            src="https://via.placeholder.com/70"
                                            alt="Cadet Photo Preview">

                                    </div>


                                    <div class="photo-content">

                                        <div class="photo-title">
                                            Cadet Photo
                                        </div>

                                        <div class="photo-description">
                                            Upload a clear profile photo for the cadet.
                                        </div>


                                        <input
                                            type="file"
                                            name="photo"
                                            accept="image/*">


                                        <button
                                            type="button"
                                            class="remove-photo"
                                            id="removePhoto">

                                            Remove Photo

                                        </button>

                                    </div>

                                </div>


                                <!-- FULL NAME -->

                                <div class="form-group">

                                    <label>
                                        Full Name
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="full_name"
                                        value="{{ old('full_name') }}"
                                        placeholder="Enter full name"
                                        required>

                                </div>


                                <!-- COURSE / BATCH -->

                                <div class="form-row">

                                    <div class="form-group">

                                        <label>
                                            Course
                                            <span class="required">*</span>
                                        </label>

                                        <select
                                            name="course"
                                            required>

                                            <option value="">
                                                -- Select Course --
                                            </option>

                                            @foreach($courses as $course)

                                                <option
                                                    value="{{ $course->course_code }}"
                                                    {{ old('course') == $course->course_code ? 'selected' : '' }}>

                                                    {{ $course->course_name }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>


                                    <div class="form-group">

                                        <label>
                                            Batch
                                            <span class="required">*</span>
                                        </label>

                                        <select
                                            name="batch_id"
                                            required>

                                            <option value="">
                                                -- Select Batch --
                                            </option>

                                            @foreach($batches as $batch)

                                                <option
                                                    value="{{ $batch->id }}"
                                                    {{ old('batch_id') == $batch->id ? 'selected' : '' }}>

                                                    {{ $batch->batch_year }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>


                            <!-- =================================================
                                 PERSONAL DETAILS
                            ================================================== -->

                            <div class="form-section">


                                <div class="section-heading">
                                    Personal Details
                                </div>


                                <!-- DOB / PLACE -->

                                <div class="form-row">

                                    <div class="form-group">

                                        <label>
                                            Date of Birth
                                        </label>

                                        <input
                                            type="date"
                                            name="date_of_birth"
                                            value="{{ old('date_of_birth') }}">

                                    </div>


                                    <div class="form-group">

                                        <label>
                                            Place of Birth
                                            <span class="required">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            name="place_of_birth"
                                            value="{{ old('place_of_birth') }}"
                                            placeholder="Enter place of birth"
                                            required>

                                    </div>

                                </div>


                                <!-- RANK -->

                                <div class="form-group">

                                    <label>
                                        Rank
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        name="rank"
                                        required>

                                        <option value="">
                                            Select Rank
                                        </option>

                                        <option
                                            value="Cadet"
                                            {{ old('rank') == 'Cadet' ? 'selected' : '' }}>

                                            Cadet

                                        </option>

                                        <option
                                            value="Deck Cadet"
                                            {{ old('rank') == 'Deck Cadet' ? 'selected' : '' }}>

                                            Deck Cadet

                                        </option>

                                        <option
                                            value="Engine Cadet"
                                            {{ old('rank') == 'Engine Cadet' ? 'selected' : '' }}>

                                            Engine Cadet

                                        </option>

                                        <option
                                            value="Senior Cadet"
                                            {{ old('rank') == 'Senior Cadet' ? 'selected' : '' }}>

                                            Senior Cadet

                                        </option>

                                    </select>

                                </div>


                                <!-- ADDRESS -->

                                <div class="form-group">

                                    <label>
                                        Address
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="address"
                                        value="{{ old('address') }}"
                                        placeholder="Enter complete address"
                                        required>

                                </div>


                                <!-- CONTACT -->

                                <div class="form-group">

                                    <label>
                                        Contact Number
                                    </label>

                                    <input
                                        type="text"
                                        name="contact_number"
                                        value="{{ old('contact_number') }}"
                                        placeholder="Enter contact number (optional)">

                                </div>


                                <!-- EMAIL -->

                                <div class="form-group">

                                    <label>
                                        Email
                                        <span style="color:#64748b;">
                                            (Optional)
                                        </span>
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="Enter email address">

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         TAB 2
                    ================================================== -->

                    <div class="tab-content">


                        <div class="guardian-card">


                            <div class="section-heading">
                                Parent / Guardian Details
                            </div>


                            <!-- RELATIONSHIP -->

                            <div class="form-group">

                                <label>
                                    Relationship
                                </label>

                                <select name="relationship">

                                    <option
                                        value="Father"
                                        {{ old('relationship') == 'Father' ? 'selected' : '' }}>

                                        Father

                                    </option>

                                    <option
                                        value="Mother"
                                        {{ old('relationship') == 'Mother' ? 'selected' : '' }}>

                                        Mother

                                    </option>

                                    <option
                                        value="Guardian"
                                        {{ old('relationship') == 'Guardian' ? 'selected' : '' }}>

                                        Guardian

                                    </option>

                                </select>

                            </div>


                            <!-- NAME -->

                            <div class="form-group">

                                <label>
                                    Full Name
                                </label>

                                <div class="form-row">

                                    <input
                                        type="text"
                                        name="parent_first"
                                        value="{{ old('parent_first') }}"
                                        placeholder="First Name">

                                    <input
                                        type="text"
                                        name="parent_middle"
                                        value="{{ old('parent_middle') }}"
                                        placeholder="Middle Name">

                                    <input
                                        type="text"
                                        name="parent_last"
                                        value="{{ old('parent_last') }}"
                                        placeholder="Last Name">

                                </div>

                            </div>


                            <!-- CONTACT -->

                            <div class="form-group">

                                <label>
                                    Contact Number
                                </label>

                                <input
                                    type="text"
                                    name="parent_contact"
                                    value="{{ old('parent_contact') }}"
                                    placeholder="Enter guardian contact number">

                            </div>


                            <!-- EMAIL -->

                            <div class="form-group">

                                <label>
                                    Email
                                    <span style="color:#64748b;">
                                        (Optional)
                                    </span>
                                </label>

                                <input
                                    type="email"
                                    name="parent_email"
                                    value="{{ old('parent_email') }}"
                                    placeholder="Enter guardian email">

                            </div>


                            <!-- ADDRESS -->

                            <div class="form-group">

                                <label>
                                    Complete Address
                                </label>

                                <textarea
                                    name="parent_address"
                                    placeholder="Enter complete parent / guardian address">{{ old('parent_address') }}</textarea>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         WARNING
                    ================================================== -->

                    <div class="warning">

                        <span>
                            ⚠
                        </span>

                        <span>
                            Please check all cadet and guardian information carefully before submitting.
                            Make sure the TRB control number, course, batch, and personal information are correct.
                        </span>

                    </div>


                    <!-- =================================================
                         FOOTER ACTIONS
                    ================================================== -->

                    <div class="form-footer">

                        <a
                            href="{{ route('admin.cadets.index') }}"
                            class="btn btn-secondary">

                            ← Cancel

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            ✓ Add Cadet

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<script>

/* =========================================================
   TAB SWITCHING
   FUNCTIONALITY PRESERVED
========================================================= */

function switchTab(index) {

    document
        .querySelectorAll('.cadet-create-page .tab')
        .forEach((tab, i) => {

            tab.classList.toggle(
                'active',
                i === index
            );

        });


    document
        .querySelectorAll('.cadet-create-page .tab-content')
        .forEach((content, i) => {

            content.classList.toggle(
                'active',
                i === index
            );

        });

}


/* =========================================================
   PHOTO PREVIEW
   FUNCTIONALITY PRESERVED
========================================================= */

const photoInput =
    document.querySelector(
        '.cadet-create-page input[name="photo"]'
    );


if (photoInput) {

    photoInput.addEventListener(
        'change',
        function (e) {

            if (
                e.target.files &&
                e.target.files[0]
            ) {

                let reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        document
                            .getElementById('previewImg')
                            .src =
                            event.target.result;

                    };


                reader.readAsDataURL(
                    e.target.files[0]
                );

            }

        }
    );

}


/* =========================================================
   CLOSE BUTTON
   FUNCTIONALITY PRESERVED
========================================================= */

const closeModal =
    document.getElementById('closeModal');


if (closeModal) {

    closeModal.addEventListener(
        'click',
        function () {

            window.location.href =
                "{{ route('admin.cadets.index') }}";

        }
    );

}


/* =========================================================
   REMOVE PHOTO
   FUNCTIONALITY PRESERVED
========================================================= */

const removePhoto =
    document.getElementById('removePhoto');


if (removePhoto) {

    removePhoto.addEventListener(
        'click',
        function () {

            document.querySelector(
                '.cadet-create-page input[name="photo"]'
            ).value = "";


            document.getElementById(
                'previewImg'
            ).src =
                "https://via.placeholder.com/70";

        }
    );

}

</script>

@endsection