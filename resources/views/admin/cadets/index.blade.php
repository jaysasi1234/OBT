@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/cadets/cadets.css'])


<div class="cadet-management-page">

    {{-- =====================================================
         SUCCESS NOTIFICATION
    ====================================================== --}}

    @if(session('success'))

        <div id="success-notif" class="notif">

            <i class="fas fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

            <button
                type="button"
                onclick="closeSuccessNotification()"
                aria-label="Close notification"
            >
                ×
            </button>

        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERRORS
    ====================================================== --}}

    @if($errors->any())

        <div class="validation-alert">

            <i class="fas fa-circle-exclamation"></i>

            <div>

                <strong>
                    Please check the following:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="page-header">

        <div class="header-content">

            <h1>
                <i class="fas fa-user-graduate"></i>
                <span>Cadet Management</span>
            </h1>

            <p>
                Manage cadet profiles, verification status,
                deployment information and records.
            </p>

        </div>


        <div class="header-actions">

            <a
                href="{{ route('admin.cadets.create') }}"
                class="add-btn"
            >
                <i class="fas fa-plus"></i>
                <span>Add New Cadet</span>
            </a>

        </div>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="cards">

        <div class="stat-card blue">

            <div class="stat-content">

                <div class="stat-label">
                    TOTAL CADETS
                </div>

                <h2
                    class="stat-number"
                    id="totalCadetsCard"
                >
                    {{ $totalCadets }}
                </h2>

                <div class="stat-subtitle">
                    Registered cadet records
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>

        </div>


        <div class="stat-card green">

            <div class="stat-content">

                <div class="stat-label">
                    ACTIVE CADETS
                </div>

                <h2
                    class="stat-number"
                    id="activeCadetsCard"
                >
                    {{ $activeCadets }}
                </h2>

                <div class="stat-subtitle">
                    Currently active accounts
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>

        </div>


        <div class="stat-card orange">

            <div class="stat-content">

                <div class="stat-label">
                    CURRENTLY DEPLOYED
                </div>

                <h2
                    class="stat-number"
                    id="deployedCadetsCard"
                >
                    {{ $withDeployment }}
                </h2>

                <div class="stat-subtitle">
                    Cadets with deployment
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-ship"></i>
            </div>

        </div>


        <div class="stat-card red">

            <div class="stat-content">

                <div class="stat-label">
                    NO DEPLOYMENT
                </div>

                <h2
                    class="stat-number"
                    id="notDeployedCard"
                >
                    {{ $noDeployment }}
                </h2>

                <div class="stat-subtitle">
                    Awaiting deployment
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-location-dot"></i>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER PANEL
    ====================================================== --}}

    <div class="filter-panel">

        <div class="filter-header">

            <div class="filter-title">

                <div class="filter-title-icon">
                    <i class="fas fa-filter"></i>
                </div>

                <div>

                    <h3>
                        Filter & Search
                    </h3>

                    <span>
                        Narrow down cadet records
                    </span>

                </div>

            </div>


            <button
                type="button"
                id="clearFilters"
                class="clear-filters"
            >
                <i class="fas fa-rotate-left"></i>
                Clear
            </button>

        </div>


        <div class="filter-grid">

            {{-- =================================================
                 COURSE FILTER
            ================================================== --}}

            <div class="filter-control">

                <label for="courseFilter">
                    Course
                </label>

                <select id="courseFilter">

                    <option value="">
                        All Courses
                    </option>

                    @foreach($courses as $course)

                        <option
                            value="{{ $course->course }}"
                            {{ request('course') == $course->course ? 'selected' : '' }}
                        >
                            {{ strtoupper($course->course) }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- =================================================
                 BATCH FILTER
            ================================================== --}}

            <div class="filter-control">

                <label for="batchFilter">
                    Batch
                </label>

                <select id="batchFilter">

                    <option value="">
                        All Batches
                    </option>

                    @foreach($batches as $batch)

                        <option
                            value="{{ $batch->id }}"
                            {{ request('batch') == $batch->id ? 'selected' : '' }}
                        >
                            {{ $batch->batch_year }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- =================================================
                 DEPLOYMENT FILTER
            ================================================== --}}

            <div class="filter-control">

                <label for="deploymentFilter">
                    Deployment
                </label>

                <select id="deploymentFilter">

                    <option value="">
                        All Deployment Status
                    </option>

                    <option
                        value="not_deployed"
                        {{ request('deployment') === 'not_deployed' ? 'selected' : '' }}
                    >
                        Not Deployed
                    </option>

                    <option
                        value="ongoing"
                        {{ request('deployment') === 'ongoing' ? 'selected' : '' }}
                    >
                        Ongoing
                    </option>

                    <option
                        value="completed"
                        {{ request('deployment') === 'completed' ? 'selected' : '' }}
                    >
                        Completed
                    </option>

                </select>

            </div>


            {{-- =================================================
                 VERIFICATION FILTER
            ================================================== --}}

            <div class="filter-control">

                <label for="verificationFilter">
                    Verification
                </label>

                <select id="verificationFilter">

                    <option value="">
                        All Verification
                    </option>

                    <option
                        value="approved"
                        {{ request('verification') === 'approved' ? 'selected' : '' }}
                    >
                        Complete
                    </option>

                    <option
                        value="pending"
                        {{ request('verification') === 'pending' ? 'selected' : '' }}
                    >
                        Pending
                    </option>

                    <option
                        value="rejected"
                        {{ request('verification') === 'rejected' ? 'selected' : '' }}
                    >
                        Incomplete
                    </option>

                </select>

            </div>


            {{-- =================================================
                 SEARCH
            ================================================== --}}

            <div class="filter-control search-control">

                <label for="searchInput">
                    Search
                </label>

                <div class="search-box">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Name, TRB, course..."
                        autocomplete="off"
                        value="{{ request('search') }}"
                    >

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE PANEL
    ====================================================== --}}

    <div class="table-panel">

        <div class="table-header">

            <div class="table-title">

                <div class="table-title-icon">
                    <i class="fas fa-list"></i>
                </div>

                <div>

                    <h3>
                        Cadet Records
                    </h3>

                    <p>
                        Registered cadets in the system
                    </p>

                </div>

            </div>


            <div
                class="result-count"
                id="resultCount"
            >

                {{ $cadets->total() }}

                {{ $cadets->total() == 1 ? 'Record' : 'Records' }}

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-wrapper">

            <table id="cadetTable">

                <thead>

                    <tr>

                        <th>TRB</th>
                        <th>Cadet</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Rank</th>
                        <th>Verification</th>
                        <th>Deployment</th>
                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                @forelse($cadets as $cadet)

                    @php

                        /*
                         * =================================================
                         * VERIFICATION STATUS
                         * =================================================
                         */

                        $verificationRaw = strtolower(
                            trim($cadet->verification_status_label ?? '')
                        );

                        $verification = match ($verificationRaw) {

                            'verified',
                            'complete',
                            'completed',
                            'approved' => 'approved',

                            'deficiency',
                            'incomplete',
                            'rejected' => 'rejected',

                            'pending',
                            'for verification',
                            'for_verification' => 'pending',

                            default => 'pending',

                        };


                        /*
                         * =================================================
                         * DEPLOYMENT STATUS
                         * =================================================
                         */

                        $deployRaw = strtolower(
                            trim($cadet->deployment->status ?? '')
                        );

                        $deploy = match ($deployRaw) {

                            'ongoing' => 'ongoing',

                            'completed' => 'completed',

                            default => 'not_deployed',

                        };


                        /*
                         * =================================================
                         * BATCH
                         * =================================================
                         */

                        $batchYear =
                            optional($cadet->batch)->batch_year
                            ?? 'No Batch';


                        /*
                         * =================================================
                         * PHOTO
                         * =================================================
                         */

                        $photoUrl =
                            $cadet->photo
                            ? asset('storage/' . $cadet->photo)
                            : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';

                    @endphp


                    <tr
                        class="cadet-row"
                        data-cadet-id="{{ $cadet->id }}"
                    >

                        {{-- =================================================
                             TRB
                        ================================================== --}}

                        <td>

                            <span class="trb-code">

                                {{ $cadet->trb_control_number ?: 'N/A' }}

                            </span>

                        </td>


                        {{-- =================================================
                             CADET
                        ================================================== --}}

                        <td>

                            <div class="cadet-identity">

                                <img
                                    src="{{ $photoUrl }}"
                                    alt="{{ $cadet->full_name }}"
                                    class="table-avatar"
                                    onerror="this.onerror=null;this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png';"
                                >

                                <span class="cadet-name">

                                    {{ $cadet->full_name }}

                                </span>

                            </div>

                        </td>


                        {{-- =================================================
                             COURSE
                        ================================================== --}}

                        <td>

                            <span class="course-text">

                                {{ strtoupper($cadet->course) }}

                            </span>

                        </td>


                        {{-- =================================================
                             BATCH
                        ================================================== --}}

                        <td>

                            {{ $batchYear }}

                        </td>


                        {{-- =================================================
                             RANK
                        ================================================== --}}

                        <td>

                            {{ $cadet->rank ?: 'N/A' }}

                        </td>


                        {{-- =================================================
                             VERIFICATION
                        ================================================== --}}

                        <td>

                            <span
                                class="status {{ $verification }}"
                                data-status="{{ $verification }}"
                                data-verification="{{ $verification }}"
                            >

                                {{ ucfirst($verification) }}

                            </span>

                        </td>


                        {{-- =================================================
                             DEPLOYMENT
                        ================================================== --}}

                        <td>

                            <span
                                class="status {{ $deploy }}"
                                data-deploy="{{ $deploy }}"
                            >

                                {{ ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $deploy
                                    )
                                ) }}

                            </span>

                        </td>


                        {{-- =================================================
                             ACTIONS
                        ================================================== --}}

                        <td>

                            <div class="action-buttons">

                                {{-- VIEW --}}

                                <button
                                    type="button"
                                    class="btn btn-view"
                                    data-action="view"
                                    onclick="openCadetModal(
                                        @js($cadet->full_name),
                                        @js($cadet->trb_control_number),
                                        @js(strtoupper($cadet->course)),
                                        @js($batchYear),
                                        @js($cadet->rank),
                                        @js($deploy),
                                        @js($cadet->verification_status_label),
                                        @js($cadet->contact_number ?? 'N/A'),
                                        @js($cadet->date_of_birth ?? 'N/A'),
                                        @js($photoUrl),
                                        @js($cadet->id)
                                    )"
                                >

                                    <i class="fas fa-eye"></i>

                                    <span>
                                        View
                                    </span>

                                </button>


                                {{-- EDIT --}}

                                <button
                                    type="button"
                                    class="btn btn-edit"
                                    data-action="edit"
                                    onclick="openEditModal(
                                        @js($cadet->id),
                                        @js($cadet->full_name),
                                        @js($cadet->course),
                                        @js($cadet->batch_id),
                                        @js($batchYear === 'No Batch' ? '' : $batchYear),
                                        @js($cadet->date_of_birth),
                                        @js($cadet->place_of_birth),
                                        @js($cadet->rank),
                                        @js($cadet->address),
                                        @js($cadet->contact_number),
                                        @js($cadet->email),
                                        @js($cadet->trb_control_number),
                                        @js($photoUrl),
                                        @js($cadet->guardian_relationship),
                                        @js($cadet->parent_guardian_name),
                                        @js($cadet->parent_guardian_contact),
                                        @js($cadet->parent_guardian_email),
                                        @js($cadet->parent_guardian_address)
                                    )"
                                >

                                    <i class="fas fa-pen"></i>

                                    <span>
                                        Edit
                                    </span>

                                </button>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr class="empty-table-row">

                        <td
                            colspan="8"
                            class="empty-row"
                        >

                            <div class="empty-state">

                                <div class="empty-icon">
                                    <i class="fas fa-users-slash"></i>
                                </div>

                                <strong>
                                    No cadet records found
                                </strong>

                                <span>
                                    There are currently no cadets to display.
                                </span>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}

        @if($cadets->hasPages())

            <div class="pagination-wrapper">

                <div class="pagination-info">

                    Showing

                    <strong>
                        {{ $cadets->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $cadets->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $cadets->total() }}
                    </strong>

                    cadets

                </div>


                <div class="pagination-links">

                    {{ $cadets->withQueryString()->links() }}

                </div>

            </div>

        @endif

    </div>

</div>



{{-- =========================================================
     VIEW CADET MODAL
========================================================= --}}

<div
    id="cadetViewModal"
    class="cadet-modal"
    aria-hidden="true"
>

    <div
        class="edit-modal-content view-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modalName"
    >

        <div class="edit-modal-header">

            <div class="edit-modal-title">

                <div class="edit-modal-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>

                <div>

                    <h2>
                        Cadet Information
                    </h2>

                    <p>
                        View registered cadet information
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="modal-x"
                onclick="closeCadetModal()"
                aria-label="Close modal"
            >
                ×
            </button>

        </div>


        <div class="edit-modal-body view-modal-body">

            <div class="view-profile">

                <div class="view-photo-wrapper">

                    <img
                        id="modalPhoto"
                        src=""
                        class="view-photo"
                        alt="Cadet Photo"
                    >

                </div>


                <h2 id="modalName"></h2>


                <div
                    id="modalDeploy"
                    class="status"
                ></div>

            </div>


            <div class="view-information-grid">

                <div class="view-field">

                    <label>
                        TRB Control Number
                    </label>

                    <div
                        id="modalTrb"
                        class="view-value"
                    ></div>

                </div>


                <div class="view-field">

                    <label>
                        Course
                    </label>

                    <div
                        id="modalCourse"
                        class="view-value"
                    ></div>

                </div>


                <div class="view-field">

                    <label>
                        Batch
                    </label>

                    <div
                        id="modalBatch"
                        class="view-value"
                    ></div>

                </div>


                <div class="view-field">

                    <label>
                        Rank
                    </label>

                    <div
                        id="modalRank"
                        class="view-value"
                    ></div>

                </div>


                <div class="view-field">

                    <label>
                        Date of Birth
                    </label>

                    <div
                        id="modalBirth"
                        class="view-value"
                    ></div>

                </div>


                <div class="view-field">

                    <label>
                        Contact Number
                    </label>

                    <div
                        id="modalContact"
                        class="view-value"
                    ></div>

                </div>


                <div class="view-field view-field-full">

                    <label>
                        Verification
                    </label>

                    <div
                        id="modalVerification"
                        class="view-value"
                    ></div>

                </div>

            </div>

        </div>


        <div class="edit-modal-footer">

            <button
                type="button"
                class="modal-btn modal-btn-cancel"
                onclick="closeCadetModal()"
            >

                <i class="fas fa-xmark"></i>

                Close

            </button>


            <button
                type="button"
                id="viewEditButton"
                class="modal-btn modal-btn-update"
            >

                <i class="fas fa-pen"></i>

                Edit Cadet

            </button>

        </div>

    </div>

</div>



{{-- =========================================================
     EDIT CADET MODAL
========================================================= --}}

<div
    id="editCadetModal"
    class="cadet-modal"
    aria-hidden="true"
>

    <div
        class="edit-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="editModalTitle"
    >

        {{-- HEADER --}}

        <div class="edit-modal-header">

            <div class="edit-modal-title">

                <div class="edit-modal-icon">
                    <i class="fas fa-user-pen"></i>
                </div>

                <div>

                    <h2 id="editModalTitle">
                        Edit Cadet
                    </h2>

                    <p>
                        Update the cadet's information
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="modal-x"
                onclick="closeEditModal()"
                aria-label="Close modal"
            >
                ×
            </button>

        </div>


        {{-- FORM --}}

        <form
            id="editCadetForm"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            <div class="edit-modal-body">

                {{-- =================================================
                     TABS
                ================================================== --}}

                <div
                    class="edit-tabs"
                    role="tablist"
                >

                    <button
                        type="button"
                        class="edit-tab active"
                        id="editPersonalTab"
                        onclick="switchEditTab('personal')"
                        role="tab"
                    >

                        <i class="fas fa-user"></i>

                        <span>
                            Personal & Contact
                        </span>

                    </button>


                    <button
                        type="button"
                        class="edit-tab"
                        id="editGuardianTab"
                        onclick="switchEditTab('guardian')"
                        role="tab"
                    >

                        <i class="fas fa-people-roof"></i>

                        <span>
                            Parent / Guardian
                        </span>

                    </button>

                </div>


                {{-- =================================================
                     PERSONAL TAB
                ================================================== --}}

                <div
                    id="editPersonalContent"
                    class="edit-tab-content active"
                >

                    <div class="form-section">

                        <div class="form-section-header">

                            <div class="form-section-icon">
                                <i class="fas fa-id-card"></i>
                            </div>

                            <div>

                                <h3>
                                    Personal Information
                                </h3>

                                <p>
                                    Update the cadet's basic profile
                                </p>

                            </div>

                        </div>


                        <div class="form-section-body">

                            {{-- PHOTO + BASIC INFO --}}

                            <div class="edit-profile">

                                <div class="photo-area">

                                    <img
                                        id="editCadetPreview"
                                        class="edit-photo"
                                        src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                                        alt="Cadet Photo"
                                    >


                                    <div class="photo-actions">

                                        <button
                                            type="button"
                                            class="photo-btn photo-upload"
                                            onclick="document.getElementById('editPhotoInput').click()"
                                        >

                                            <i class="fas fa-camera"></i>

                                            Upload

                                        </button>


                                        <button
                                            type="button"
                                            class="photo-btn photo-remove"
                                            onclick="removeEditPhoto()"
                                        >

                                            <i class="fas fa-trash"></i>

                                            Remove

                                        </button>

                                    </div>


                                    <input
                                        type="file"
                                        id="editPhotoInput"
                                        name="photo"
                                        accept="image/*"
                                        hidden
                                    >


                                    <input
                                        type="hidden"
                                        id="remove_edit_photo"
                                        name="remove_photo"
                                        value="0"
                                    >

                                </div>


                                <div class="profile-fields">

                                    {{-- FULL NAME --}}

                                    <div class="form-group">

                                        <label class="form-label">

                                            Full Name

                                            <span class="required">
                                                *
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            id="edit_full_name"
                                            name="full_name"
                                            class="edit-input"
                                            required
                                            placeholder="Enter full name"
                                        >

                                    </div>


                                    {{-- TRB --}}

                                    <div class="form-group">

                                        <label class="form-label">

                                            TRB Control Number

                                            <span class="optional">
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            id="edit_trb_control_number"
                                            name="trb_control_number"
                                            class="edit-input"
                                            placeholder="Enter TRB control number"
                                        >

                                    </div>

                                </div>

                            </div>


                            {{-- COURSE / BATCH --}}

                            <div class="form-row">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_course"
                                    >

                                        Course

                                        <span class="required">
                                            *
                                        </span>

                                    </label>


                                    <select
                                        id="edit_course"
                                        name="course"
                                        class="edit-select"
                                        required
                                    >

                                        <option value="">
                                            Select Course
                                        </option>

                                        @foreach($courses as $course)

                                            <option
                                                value="{{ $course->course }}"
                                                data-course="{{ $course->course }}"
                                            >

                                                {{ strtoupper($course->course) }}

                                                @if(!empty($course->course_name))

                                                    — {{ $course->course_name }}

                                                @endif

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_batch_id"
                                    >
                                        Batch
                                    </label>


                                    <select
                                        id="edit_batch_id"
                                        name="batch_id"
                                        class="edit-select"
                                    >

                                        <option value="">
                                            Select Batch
                                        </option>

                                        @foreach($batches as $batch)

                                            <option
                                                value="{{ $batch->id }}"
                                                data-batch-year="{{ $batch->batch_year }}"
                                            >

                                                {{ $batch->batch_year }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>


                            {{-- DOB / PLACE --}}

                            <div class="form-row">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_date_of_birth"
                                    >
                                        Date of Birth
                                    </label>


                                    <input
                                        type="date"
                                        id="edit_date_of_birth"
                                        name="date_of_birth"
                                        class="edit-input"
                                    >

                                </div>


                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_place_of_birth"
                                    >
                                        Place of Birth
                                    </label>


                                    <input
                                        type="text"
                                        id="edit_place_of_birth"
                                        name="place_of_birth"
                                        class="edit-input"
                                        placeholder="Enter place of birth"
                                    >

                                </div>

                            </div>


                            {{-- RANK / CONTACT --}}

                            <div class="form-row">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_rank"
                                    >
                                        Rank
                                    </label>


                                    <select
                                        id="edit_rank"
                                        name="rank"
                                        class="edit-select"
                                    >

                                        <option value="Cadet">
                                            Cadet
                                        </option>

                                        <option value="Deck Cadet">
                                            Deck Cadet
                                        </option>

                                        <option value="Engine Cadet">
                                            Engine Cadet
                                        </option>

                                        <option value="Senior Cadet">
                                            Senior Cadet
                                        </option>

                                    </select>

                                </div>


                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_contact_number"
                                    >
                                        Contact Number
                                    </label>


                                    <input
                                        type="text"
                                        id="edit_contact_number"
                                        name="contact_number"
                                        class="edit-input"
                                        placeholder="Enter contact number"
                                    >

                                </div>

                            </div>


                            {{-- ADDRESS --}}

                            <div class="form-row single">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_address"
                                    >
                                        Address
                                    </label>


                                    <input
                                        type="text"
                                        id="edit_address"
                                        name="address"
                                        class="edit-input"
                                        placeholder="Enter complete address"
                                    >

                                </div>

                            </div>


                            {{-- EMAIL --}}

                            <div class="form-row single">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_email"
                                    >

                                        Email Address

                                        <span class="optional">
                                            (Optional)
                                        </span>

                                    </label>


                                    <input
                                        type="email"
                                        id="edit_email"
                                        name="email"
                                        class="edit-input"
                                        placeholder="Enter email address"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="edit-warning">

                        <i class="fas fa-triangle-exclamation"></i>

                        <div>

                            <strong>
                                Important:
                            </strong>

                            Make sure the TRB Control Number remains
                            unique for each cadet before updating.

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     GUARDIAN TAB
                ================================================== --}}

                <div
                    id="editGuardianContent"
                    class="edit-tab-content"
                >

                    <div class="form-section">

                        <div class="form-section-header">

                            <div class="form-section-icon">
                                <i class="fas fa-people-roof"></i>
                            </div>

                            <div>

                                <h3>
                                    Parent / Guardian Information
                                </h3>

                                <p>
                                    Update emergency contact information
                                </p>

                            </div>

                        </div>


                        <div class="form-section-body">

                            {{-- RELATIONSHIP --}}

                            <div class="form-row">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_guardian_relationship"
                                    >
                                        Relationship
                                    </label>


                                    <select
                                        id="edit_guardian_relationship"
                                        name="guardian_relationship"
                                        class="edit-select"
                                    >

                                        <option value="">
                                            Select Relationship
                                        </option>

                                        <option value="Father">
                                            Father
                                        </option>

                                        <option value="Mother">
                                            Mother
                                        </option>

                                        <option value="Guardian">
                                            Guardian
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- NAME --}}

                            <div class="form-row single">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_parent_guardian_name"
                                    >
                                        Parent / Guardian Full Name
                                    </label>


                                    <input
                                        type="text"
                                        id="edit_parent_guardian_name"
                                        name="parent_guardian_name"
                                        class="edit-input"
                                        placeholder="Enter parent / guardian full name"
                                    >

                                </div>

                            </div>


                            {{-- CONTACT / EMAIL --}}

                            <div class="form-row">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_parent_guardian_contact"
                                    >
                                        Contact Number
                                    </label>


                                    <input
                                        type="text"
                                        id="edit_parent_guardian_contact"
                                        name="parent_guardian_contact"
                                        class="edit-input"
                                        placeholder="Enter contact number"
                                    >

                                </div>


                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_parent_guardian_email"
                                    >

                                        Email Address

                                        <span class="optional">
                                            (Optional)
                                        </span>

                                    </label>


                                    <input
                                        type="email"
                                        id="edit_parent_guardian_email"
                                        name="parent_guardian_email"
                                        class="edit-input"
                                        placeholder="Enter email address"
                                    >

                                </div>

                            </div>


                            {{-- ADDRESS --}}

                            <div class="form-row single">

                                <div class="form-group">

                                    <label
                                        class="form-label"
                                        for="edit_parent_guardian_address"
                                    >
                                        Complete Address
                                    </label>


                                    <textarea
                                        id="edit_parent_guardian_address"
                                        name="parent_guardian_address"
                                        class="edit-textarea"
                                        placeholder="Enter complete parent / guardian address"
                                    ></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}

            <div class="edit-modal-footer">

                <button
                    type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closeEditModal()"
                >

                    <i class="fas fa-xmark"></i>

                    Cancel

                </button>


                <button
                    type="submit"
                    class="modal-btn modal-btn-update"
                >

                    <i class="fas fa-save"></i>

                    Update Cadet

                </button>

            </div>

        </form>

    </div>

</div>



<script>

(function () {

    'use strict';


    /* =====================================================
       CONSTANTS
    ===================================================== */

    const DEFAULT_PHOTO =
        'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const deploymentFilter =
        document.getElementById('deploymentFilter');

    const courseFilter =
        document.getElementById('courseFilter');

    const batchFilter =
        document.getElementById('batchFilter');

    const verificationFilter =
        document.getElementById('verificationFilter');

    const searchInput =
        document.getElementById('searchInput');

    const clearFilters =
        document.getElementById('clearFilters');

    const viewModal =
        document.getElementById('cadetViewModal');

    const editModal =
        document.getElementById('editCadetModal');

    const editForm =
        document.getElementById('editCadetForm');


    /* =====================================================
       NORMALIZATION
    ===================================================== */

    function normalize(value) {

        return String(value ?? '')
            .trim()
            .toLowerCase()
            .replace(/\s+/g, '_');

    }


    /* =====================================================
       NORMALIZE DATE
    ===================================================== */

    function normalizeDate(value) {

        if (!value) {
            return '';
        }

        const stringValue =
            String(value).trim();

        return stringValue.includes('T')
            ? stringValue.split('T')[0]
            : stringValue.substring(0, 10);

    }


    /* =====================================================
       SERVER-SIDE FILTERING
    ===================================================== */

    function applyFilters() {

        const params =
            new URLSearchParams();


        const course =
            courseFilter?.value?.trim() || '';


        const batch =
            batchFilter?.value?.trim() || '';


        const deployment =
            deploymentFilter?.value?.trim() || '';


        const verification =
            verificationFilter?.value?.trim() || '';


        const search =
            searchInput?.value?.trim() || '';


        if (course) {

            params.set(
                'course',
                course
            );

        }


        if (batch) {

            params.set(
                'batch',
                batch
            );

        }


        if (deployment) {

            params.set(
                'deployment',
                deployment
            );

        }


        if (verification) {

            params.set(
                'verification',
                verification
            );

        }


        if (search) {

            params.set(
                'search',
                search
            );

        }


        /*
         * Always remove the current page
         * when changing filters.
         *
         * Example:
         *
         * page=4 + batch=2026
         *
         * becomes:
         *
         * batch=2026
         *
         * so Laravel starts at page 1.
         */

        params.delete('page');


        const queryString =
            params.toString();


        const url =
            window.location.pathname +
            (
                queryString
                    ? '?' + queryString
                    : ''
            );


        window.location.href =
            url;

    }


    /* =====================================================
       FILTER EVENTS
    ===================================================== */

    deploymentFilter?.addEventListener(
        'change',
        applyFilters
    );


    courseFilter?.addEventListener(
        'change',
        applyFilters
    );


    batchFilter?.addEventListener(
        'change',
        applyFilters
    );


    verificationFilter?.addEventListener(
        'change',
        applyFilters
    );


    /* =====================================================
       SEARCH
    ===================================================== */

    let searchTimer = null;


    searchInput?.addEventListener(
        'input',
        function () {

            clearTimeout(
                searchTimer
            );


            searchTimer =
                setTimeout(
                    function () {

                        applyFilters();

                    },
                    500
                );

        }
    );


    searchInput?.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Enter'
            ) {

                event.preventDefault();


                clearTimeout(
                    searchTimer
                );


                applyFilters();

            }

        }
    );


    /* =====================================================
       CLEAR FILTERS
    ===================================================== */

    clearFilters?.addEventListener(
        'click',
        function () {

            window.location.href =
                window.location.pathname;

        }
    );


    /* =====================================================
       VIEW CADET MODAL
    ===================================================== */

    window.openCadetModal = function (
        name,
        trb,
        course,
        batch,
        rank,
        deploy,
        verification,
        contact,
        birth,
        photo,
        id
    ) {

        if (!viewModal) {
            return;
        }


        const modalPhoto =
            document.getElementById(
                'modalPhoto'
            );


        const modalName =
            document.getElementById(
                'modalName'
            );


        const modalTrb =
            document.getElementById(
                'modalTrb'
            );


        const modalCourse =
            document.getElementById(
                'modalCourse'
            );


        const modalBatch =
            document.getElementById(
                'modalBatch'
            );


        const modalRank =
            document.getElementById(
                'modalRank'
            );


        const modalBirth =
            document.getElementById(
                'modalBirth'
            );


        const modalContact =
            document.getElementById(
                'modalContact'
            );


        const modalVerification =
            document.getElementById(
                'modalVerification'
            );


        const deployBadge =
            document.getElementById(
                'modalDeploy'
            );


        /* =================================================
           PHOTO
        ================================================== */

        if (modalPhoto) {

            modalPhoto.src =
                photo || DEFAULT_PHOTO;


            modalPhoto.onerror =
                function () {

                    this.onerror = null;

                    this.src =
                        DEFAULT_PHOTO;

                };

        }


        /* =================================================
           BASIC INFORMATION
        ================================================== */

        if (modalName) {

            modalName.innerText =
                name || 'N/A';

        }


        if (modalTrb) {

            modalTrb.innerText =
                trb || 'N/A';

        }


        if (modalCourse) {

            modalCourse.innerText =
                course || 'N/A';

        }


        if (modalBatch) {

            modalBatch.innerText =
                batch || 'No Batch';

        }


        if (modalRank) {

            modalRank.innerText =
                rank || 'N/A';

        }


        if (modalBirth) {

            modalBirth.innerText =
                birth || 'N/A';

        }


        if (modalContact) {

            modalContact.innerText =
                contact || 'N/A';

        }


        /* =================================================
           VERIFICATION
        ================================================== */

        if (modalVerification) {

            const verificationValue =
                normalize(
                    verification
                ) || 'pending';


            modalVerification.innerText =
                verification ||
                'Pending';


            modalVerification.className =
                'view-value verification-value ' +
                verificationValue;

        }


        /* =================================================
           DEPLOYMENT
        ================================================== */

        if (deployBadge) {

            const deploymentStatus =
                normalize(
                    deploy
                ) || 'not_deployed';


            deployBadge.innerText =
                deploymentStatus === 'not_deployed'
                    ? 'Not Deployed'
                    : deploymentStatus
                        .replace(
                            /_/g,
                            ' '
                        )
                        .replace(
                            /\b\w/g,
                            function (letter) {

                                return letter.toUpperCase();

                            }
                        );


            deployBadge.className =
                'status ' +
                deploymentStatus;

        }


        /* =================================================
           EDIT BUTTON
        ================================================== */

        const viewEditButton =
            document.getElementById(
                'viewEditButton'
            );


        if (viewEditButton) {

            viewEditButton.onclick =
                function () {

                    closeCadetModal();

                    openEditModalById(id);

                };

        }


        /* =================================================
           OPEN MODAL
        ================================================== */

        viewModal.classList.add(
            'show'
        );


        viewModal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.classList.add(
            'modal-open'
        );

    };


    /* =====================================================
       CLOSE VIEW MODAL
    ===================================================== */

    window.closeCadetModal = function () {

        if (!viewModal) {
            return;
        }


        viewModal.classList.remove(
            'show'
        );


        viewModal.setAttribute(
            'aria-hidden',
            'true'
        );


        if (
            !editModal ||
            !editModal.classList.contains('show')
        ) {

            document.body.classList.remove(
                'modal-open'
            );

        }

    };


    /* =====================================================
       EDIT MODAL
    ===================================================== */

    window.openEditModal = function (
        id,
        fullName,
        course,
        batchId,
        batchYear,
        dateOfBirth,
        placeOfBirth,
        rank,
        address,
        contactNumber,
        email,
        trb,
        photo,
        guardianRelationship,
        guardianName,
        guardianContact,
        guardianEmail,
        guardianAddress
    ) {

        if (
            !editModal ||
            !editForm
        ) {

            return;

        }


        /* =================================================
           FORM ACTION
        ================================================== */

        editForm.action =
            "{{ url('/admin/cadets') }}/" +
            id;


        /* =================================================
           PERSONAL INFORMATION
        ================================================== */

        setInputValue(
            'edit_full_name',
            fullName
        );


        setCourseValue(
            course
        );


        setInputValue(
            'edit_batch_id',
            batchId
        );


        setInputValue(
            'edit_date_of_birth',
            normalizeDate(dateOfBirth)
        );


        setInputValue(
            'edit_place_of_birth',
            placeOfBirth
        );


        setInputValue(
            'edit_rank',
            rank || 'Cadet'
        );


        setInputValue(
            'edit_address',
            address
        );


        setInputValue(
            'edit_contact_number',
            contactNumber
        );


        setInputValue(
            'edit_email',
            email
        );


        /*
         * TRB IS OPTIONAL.
         *
         * Empty value becomes an empty input.
         */

        setInputValue(
            'edit_trb_control_number',
            trb
        );


        /* =================================================
           GUARDIAN INFORMATION
        ================================================== */

        setInputValue(
            'edit_guardian_relationship',
            guardianRelationship
        );


        setInputValue(
            'edit_parent_guardian_name',
            guardianName
        );


        setInputValue(
            'edit_parent_guardian_contact',
            guardianContact
        );


        setInputValue(
            'edit_parent_guardian_email',
            guardianEmail
        );


        setInputValue(
            'edit_parent_guardian_address',
            guardianAddress
        );


        /* =================================================
           PHOTO PREVIEW
        ================================================== */

        const preview =
            document.getElementById(
                'editCadetPreview'
            );


        if (preview) {

            preview.src =
                photo || DEFAULT_PHOTO;


            preview.onerror =
                function () {

                    this.onerror = null;

                    this.src =
                        DEFAULT_PHOTO;

                };

        }


        /* =================================================
           RESET PHOTO INPUT
        ================================================== */

        const photoInput =
            document.getElementById(
                'editPhotoInput'
            );


        if (photoInput) {

            photoInput.value =
                '';

        }


        const removePhotoInput =
            document.getElementById(
                'remove_edit_photo'
            );


        if (removePhotoInput) {

            removePhotoInput.value =
                '0';

        }


        /* =================================================
           RESET TAB
        ================================================== */

        switchEditTab(
            'personal'
        );


        /* =================================================
           OPEN MODAL
        ================================================== */

        editModal.classList.add(
            'show'
        );


        editModal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.classList.add(
            'modal-open'
        );

    };


    /* =====================================================
       SET INPUT VALUE
    ===================================================== */

    function setInputValue(
        id,
        value
    ) {

        const element =
            document.getElementById(
                id
            );


        if (element) {

            element.value =
                value ?? '';

        }

    }


    /* =====================================================
       COURSE MATCHING
    ===================================================== */

    function setCourseValue(
        course
    ) {

        const select =
            document.getElementById(
                'edit_course'
            );


        if (!select) {
            return;
        }


        const incoming =
            normalize(
                course
            );


        select.value =
            '';


        if (!incoming) {
            return;
        }


        const options =
            Array.from(
                select.options
            );


        const match =
            options.find(
                function (option) {

                    const optionValue =
                        normalize(
                            option.value
                        );


                    const optionCourse =
                        normalize(
                            option.dataset.course
                        );


                    return (
                        incoming === optionValue ||
                        incoming === optionCourse
                    );

                }
            );


        if (match) {

            match.selected =
                true;

        }

    }


    /* =====================================================
       FIND EDIT BUTTON
    ===================================================== */

    window.openEditModalById = function (
        id
    ) {

        const row =
            document.querySelector(
                `tr.cadet-row[data-cadet-id="${CSS.escape(String(id))}"]`
            );


        if (!row) {
            return;
        }


        const editButton =
            row.querySelector(
                '.btn-edit'
            );


        if (editButton) {

            editButton.click();

        }

    };


    /* =====================================================
       CLOSE EDIT MODAL
    ===================================================== */

    window.closeEditModal = function () {

        if (!editModal) {
            return;
        }


        editModal.classList.remove(
            'show'
        );


        editModal.setAttribute(
            'aria-hidden',
            'true'
        );


        if (
            !viewModal ||
            !viewModal.classList.contains('show')
        ) {

            document.body.classList.remove(
                'modal-open'
            );

        }

    };


    /* =====================================================
       EDIT TABS
    ===================================================== */

    window.switchEditTab = function (
        tab
    ) {

        const personalTab =
            document.getElementById(
                'editPersonalTab'
            );


        const guardianTab =
            document.getElementById(
                'editGuardianTab'
            );


        const personalContent =
            document.getElementById(
                'editPersonalContent'
            );


        const guardianContent =
            document.getElementById(
                'editGuardianContent'
            );


        if (
            !personalTab ||
            !guardianTab ||
            !personalContent ||
            !guardianContent
        ) {

            return;

        }


        const guardian =
            tab === 'guardian';


        personalTab.classList.toggle(
            'active',
            !guardian
        );


        guardianTab.classList.toggle(
            'active',
            guardian
        );


        personalContent.classList.toggle(
            'active',
            !guardian
        );


        guardianContent.classList.toggle(
            'active',
            guardian
        );

    };


    /* =====================================================
       PHOTO PREVIEW
    ===================================================== */

    const editPhotoInput =
        document.getElementById(
            'editPhotoInput'
        );


    if (editPhotoInput) {

        editPhotoInput.addEventListener(
            'change',
            function (event) {

                const file =
                    event.target.files?.[0];


                if (!file) {
                    return;
                }


                /* -----------------------------------------
                   FILE TYPE
                ----------------------------------------- */

                if (
                    !file.type.startsWith(
                        'image/'
                    )
                ) {

                    alert(
                        'Please select a valid image file.'
                    );


                    editPhotoInput.value =
                        '';


                    return;

                }


                /* -----------------------------------------
                   FILE SIZE
                ----------------------------------------- */

                const maxSize =
                    5 * 1024 * 1024;


                if (
                    file.size > maxSize
                ) {

                    alert(
                        'Please select an image smaller than 5 MB.'
                    );


                    editPhotoInput.value =
                        '';


                    return;

                }


                /* -----------------------------------------
                   RESET REMOVE FLAG
                ----------------------------------------- */

                const removePhotoInput =
                    document.getElementById(
                        'remove_edit_photo'
                    );


                if (removePhotoInput) {

                    removePhotoInput.value =
                        '0';

                }


                /* -----------------------------------------
                   PREVIEW
                ----------------------------------------- */

                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        const preview =
                            document.getElementById(
                                'editCadetPreview'
                            );


                        if (preview) {

                            preview.src =
                                event.target.result;

                        }

                    };


                reader.readAsDataURL(
                    file
                );

            }
        );

    }


    /* =====================================================
       REMOVE PHOTO
    ===================================================== */

    window.removeEditPhoto = function () {

        const input =
            document.getElementById(
                'editPhotoInput'
            );


        const preview =
            document.getElementById(
                'editCadetPreview'
            );


        const removePhotoInput =
            document.getElementById(
                'remove_edit_photo'
            );


        if (input) {

            input.value =
                '';

        }


        if (preview) {

            preview.src =
                DEFAULT_PHOTO;

        }


        if (removePhotoInput) {

            removePhotoInput.value =
                '1';

        }

    };


    /* =====================================================
       MODAL OUTSIDE CLICK
    ===================================================== */

    viewModal?.addEventListener(
        'click',
        function (event) {

            if (
                event.target === viewModal
            ) {

                closeCadetModal();

            }

        }
    );


    editModal?.addEventListener(
        'click',
        function (event) {

            if (
                event.target === editModal
            ) {

                closeEditModal();

            }

        }
    );


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key !== 'Escape'
            ) {

                return;

            }


            if (
                editModal?.classList.contains('show')
            ) {

                closeEditModal();

            }
            else if (
                viewModal?.classList.contains('show')
            ) {

                closeCadetModal();

            }

        }
    );


    /* =====================================================
       SUCCESS NOTIFICATION
    ===================================================== */

    window.closeSuccessNotification =
        function () {

            const notification =
                document.getElementById(
                    'success-notif'
                );


            if (!notification) {
                return;
            }


            notification.classList.add(
                'closing'
            );


            setTimeout(
                function () {

                    notification.remove();

                },
                350
            );

        };


    const successNotification =
        document.getElementById(
            'success-notif'
        );


    if (successNotification) {

        setTimeout(
            function () {

                closeSuccessNotification();

            },
            5000
        );

    }


    /* =====================================================
       IMPORTANT
    ===================================================== */

    /*
     * There is intentionally NO filterTable() call here.
     *
     * Filtering is handled by Laravel on the server.
     *
     * Example:
     *
     * /admin/cadets?batch=5
     *
     * Pagination:
     *
     * /admin/cadets?batch=5&page=2
     *
     * Because Laravel uses withQueryString(),
     * the selected filters remain active
     * when navigating between pages.
     */

})();

</script>

@endsection
