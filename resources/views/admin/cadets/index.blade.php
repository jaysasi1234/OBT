@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/cadets/cadets.css'])

<div class="cadet-management-page">

    {{-- =========================================================
         SUCCESS NOTIFICATION
    ========================================================== --}}
    @if(session('success'))
        <div id="success-notif" class="notif success-notif">

            <i class="fas fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

            <button
                type="button"
                onclick="closeSuccessNotif()"
                aria-label="Close notification"
            >
                <i class="fas fa-xmark"></i>
            </button>

        </div>
    @endif


    {{-- =========================================================
         VALIDATION ERRORS
    ========================================================== --}}
    @if($errors->any())
        <div class="validation-alert">

            <i class="fas fa-circle-exclamation"></i>

            <div>
                <strong>Please check the following:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    @endif


    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
    <div class="page-header">

        <div class="header-content">

            <h1>
                <i class="fas fa-user-graduate"></i>
                Cadet Management
            </h1>

            <p>
                Manage cadet records, deployment and verification status.
            </p>

        </div>

        <div class="header-actions">

            <a
                href="{{ route('admin.cadets.create') }}"
                class="add-btn"
            >
                <i class="fas fa-user-plus"></i>
                <span>Add New Cadet</span>
            </a>

        </div>

    </div>


    {{-- =========================================================
         STATISTICS
    ========================================================== --}}
    <div class="cards">

        {{-- TOTAL --}}
        <div class="stat-card blue">

            <div class="stat-content">

                <div class="stat-label">
                    TOTAL CADETS
                </div>

                <div class="stat-number">
                    {{ number_format($totalCadets) }}
                </div>

                <div class="stat-subtitle">
                    All registered cadets
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>

        </div>


        {{-- ACTIVE --}}
        <div class="stat-card green">

            <div class="stat-content">

                <div class="stat-label">
                    ACTIVE CADETS
                </div>

                <div class="stat-number">
                    {{ number_format($activeCadets) }}
                </div>

                <div class="stat-subtitle">
                    Currently active accounts
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>

        </div>


        {{-- DEPLOYED --}}
        <div class="stat-card orange">

            <div class="stat-content">

                <div class="stat-label">
                    CURRENTLY DEPLOYED
                </div>

                <div class="stat-number">
                    {{ number_format($withDeployment) }}
                </div>

                <div class="stat-subtitle">
                    Cadets with deployment
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-ship"></i>
            </div>

        </div>


        {{-- NO DEPLOYMENT --}}
        <div class="stat-card red">

            <div class="stat-content">

                <div class="stat-label">
                    NO DEPLOYMENT
                </div>

                <div class="stat-number">
                    {{ number_format($noDeployment) }}
                </div>

                <div class="stat-subtitle">
                    Available for deployment
                </div>

            </div>

            <div class="stat-icon">
                <i class="fas fa-user-clock"></i>
            </div>

        </div>

    </div>


    {{-- =========================================================
         FILTER PANEL
    ========================================================== --}}
    <form
        method="GET"
        action="{{ route('admin.cadets.index') }}"
        class="filter-panel"
        id="cadetFilterForm"
    >

        <div class="filter-header">

            <div class="filter-title">

                <div class="filter-title-icon">
                    <i class="fas fa-filter"></i>
                </div>

                <div>
                    <h3>Filter Cadets</h3>

                    <span>
                        Search and filter cadet records
                    </span>
                </div>

            </div>


            @if(request()->hasAny([
                'search',
                'course',
                'batch',
                'deployment',
                'verification'
            ]))

                <a
                    href="{{ route('admin.cadets.index') }}"
                    class="clear-filters"
                >
                    <i class="fas fa-rotate-left"></i>
                    Clear Filters
                </a>

            @endif

        </div>


        <div class="filter-grid">

            {{-- SEARCH --}}
            <div class="filter-control search-control">

                <label for="searchInput">
                    Search
                </label>

                <div class="search-box">

                    <i class="fas fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Name, TRB, course, rank..."
                        autocomplete="off"
                    >

                </div>

            </div>


            {{-- COURSE --}}
            <div class="filter-control">

                <label for="courseFilter">
                    Course
                </label>

                <select
                    id="courseFilter"
                    name="course"
                >

                    <option value="">
                        All Courses
                    </option>

                    @foreach($courses as $course)

                        @php
                            $courseValue = is_object($course)
                                ? ($course->course_name ?? $course->course ?? '')
                                : $course;
                        @endphp

                        @if($courseValue !== '')

                            <option
                                value="{{ $courseValue }}"
                                @selected(request('course') == $courseValue)
                            >
                                {{ $courseValue }}
                            </option>

                        @endif

                    @endforeach

                </select>

            </div>


            {{-- BATCH --}}
            <div class="filter-control">

                <label for="batchFilter">
                    Batch
                </label>

                <select
                    id="batchFilter"
                    name="batch"
                >

                    <option value="">
                        All Batches
                    </option>

                    @foreach($batches as $batch)

                        <option
                            value="{{ $batch->id }}"
                            @selected(request('batch') == $batch->id)
                        >
                            {{ $batch->batch_year }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- DEPLOYMENT --}}
            <div class="filter-control">

                <label for="deploymentFilter">
                    Deployment
                </label>

                <select
                    id="deploymentFilter"
                    name="deployment"
                >

                    <option value="">
                        All Deployment
                    </option>

                    <option
                        value="ongoing"
                        @selected(request('deployment') === 'ongoing')
                    >
                        Ongoing
                    </option>

                    <option
                        value="completed"
                        @selected(request('deployment') === 'completed')
                    >
                        Completed
                    </option>

                    <option
                        value="not_deployed"
                        @selected(request('deployment') === 'not_deployed')
                    >
                        Not Deployed
                    </option>

                </select>

            </div>


            {{-- VERIFICATION --}}
            <div class="filter-control">

                <label for="verificationFilter">
                    Verification
                </label>

                <select
                    id="verificationFilter"
                    name="verification"
                >

                    <option value="">
                        All Verification
                    </option>

                    <option
                        value="approved"
                        @selected(request('verification') === 'approved')
                    >
                        Approved
                    </option>

                    <option
                        value="pending"
                        @selected(request('verification') === 'pending')
                    >
                        Pending
                    </option>

                    <option
                        value="rejected"
                        @selected(request('verification') === 'rejected')
                    >
                        Rejected
                    </option>

                </select>

            </div>

        </div>

    </form>


    {{-- =========================================================
         TABLE PANEL
    ========================================================== --}}
    <div class="table-panel">

        {{-- TABLE HEADER --}}
        <div class="table-header">

            <div class="table-title">

                <div class="table-title-icon">
                    <i class="fas fa-users"></i>
                </div>

                <div>

                    <h3>
                        Cadet Records
                    </h3>

                    <p>
                        Showing
                        {{ $cadets->firstItem() ?? 0 }}
                        -
                        {{ $cadets->lastItem() ?? 0 }}
                        of
                        {{ number_format($cadets->total()) }}
                        records
                    </p>

                </div>

            </div>


            <div class="result-count">

                {{ number_format($cadets->total()) }}
                Results

            </div>

        </div>


        {{-- TABLE --}}
        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>TRB</th>

                        <th>Cadet</th>

                        <th>Course</th>

                        <th>Batch</th>

                        <th>Rank</th>

                        <th>Verification</th>

                        <th>Deployment</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($cadets as $cadet)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | VERIFICATION
                            |--------------------------------------------------------------------------
                            */

                            $verificationRaw = strtolower(
                                trim(
                                    $cadet->verification_status_label
                                    ?? $cadet->verification_status
                                    ?? ''
                                )
                            );

                            if (
                                in_array(
                                    $verificationRaw,
                                    [
                                        'approved',
                                        'verified',
                                        'accepted',
                                        'complete',
                                        'completed'
                                    ],
                                    true
                                )
                            ) {

                                $verificationStatus = 'approved';
                                $verificationText = 'Approved';

                            } elseif (
                                in_array(
                                    $verificationRaw,
                                    [
                                        'rejected',
                                        'declined',
                                        'denied'
                                    ],
                                    true
                                )
                            ) {

                                $verificationStatus = 'rejected';
                                $verificationText = 'Rejected';

                            } else {

                                $verificationStatus = 'pending';
                                $verificationText = 'Pending';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | DEPLOYMENT
                            |--------------------------------------------------------------------------
                            */

                            $deploymentRaw = strtolower(
                                trim(
                                    optional($cadet->deployment)->status ?? ''
                                )
                            );

                            if ($deploymentRaw === 'ongoing') {

                                $deploymentStatus = 'ongoing';
                                $deploymentText = 'Ongoing';

                            } elseif ($deploymentRaw === 'completed') {

                                $deploymentStatus = 'completed';
                                $deploymentText = 'Completed';

                            } else {

                                $deploymentStatus = 'not_deployed';
                                $deploymentText = 'Not Deployed';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | BATCH
                            |--------------------------------------------------------------------------
                            */

                            $batchYear =
                                optional($cadet->batch)->batch_year
                                ?? '—';


                            /*
                            |--------------------------------------------------------------------------
                            | PHOTO
                            |--------------------------------------------------------------------------
                            */

                            $photoUrl = $cadet->photo
                                ? asset(
                                    'storage/' .
                                    ltrim($cadet->photo, '/')
                                )
                                : asset(
                                    'images/default-avatar.png'
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | NAME
                            |--------------------------------------------------------------------------
                            */

                            $fullName =
                                $cadet->full_name
                                ?: 'Unnamed Cadet';

                        @endphp


                        <tr>

                            {{-- TRB --}}
                            <td>

                                <span class="trb-code">

                                    {{ $cadet->trb_control_number ?: '—' }}

                                </span>

                            </td>


                            {{-- CADET --}}
                            <td>

                                <div class="cadet-identity">

                                    <img
                                        src="{{ $photoUrl }}"
                                        alt="{{ $fullName }}"
                                        class="table-avatar"
                                        loading="lazy"
                                        decoding="async"
                                    >

                                    <div class="cadet-name">

                                        {{ $fullName }}

                                    </div>

                                </div>

                            </td>


                            {{-- COURSE --}}
                            <td>

                                <span class="course-text">

                                    {{ $cadet->course ?: '—' }}

                                </span>

                            </td>


                            {{-- BATCH --}}
                            <td>

                                {{ $batchYear }}

                            </td>


                            {{-- RANK --}}
                            <td>

                                {{ $cadet->rank ?: '—' }}

                            </td>


                            {{-- VERIFICATION --}}
                            <td>

                                <span
                                    class="status {{ $verificationStatus }}"
                                >

                                    {{ $verificationText }}

                                </span>

                            </td>


                            {{-- DEPLOYMENT --}}
                            <td>

                                <span
                                    class="status {{ $deploymentStatus }}"
                                >

                                    {{ $deploymentText }}

                                </span>

                            </td>


                            {{-- ACTION --}}
                            <td>

                                <div class="action-buttons">

                                    {{-- VIEW --}}
                                    <button
                                        type="button"
                                        class="btn btn-view"
                                        onclick="openCadetModal(this)"
                                        title="View Cadet"
                                        data-id="{{ $cadet->id }}"
                                        data-name="{{ $fullName }}"
                                        data-trb="{{ $cadet->trb_control_number ?? '' }}"
                                        data-course="{{ $cadet->course ?? '' }}"
                                        data-batch="{{ $batchYear }}"
                                        data-rank="{{ $cadet->rank ?? '' }}"
                                        data-verification="{{ $verificationText }}"
                                        data-deployment="{{ $deploymentText }}"
                                        data-dob="{{ $cadet->date_of_birth ?? '' }}"
                                        data-place="{{ $cadet->place_of_birth ?? '' }}"
                                        data-address="{{ $cadet->address ?? '' }}"
                                        data-contact="{{ $cadet->contact_number ?? '' }}"
                                        data-email="{{ $cadet->email ?? '' }}"
                                        data-photo="{{ $photoUrl }}"
                                    >

                                        <i class="fas fa-eye"></i>
                                        <span>View</span>

                                    </button>


                                    {{-- EDIT --}}
                                    <button
                                        type="button"
                                        class="btn btn-edit"
                                        onclick="openEditModal(this)"
                                        title="Edit Cadet"
                                        data-id="{{ $cadet->id }}"
                                        data-name="{{ $fullName }}"
                                        data-course="{{ $cadet->course ?? '' }}"
                                        data-batch-id="{{ $cadet->batch_id ?? '' }}"
                                        data-dob="{{ $cadet->date_of_birth ?? '' }}"
                                        data-place="{{ $cadet->place_of_birth ?? '' }}"
                                        data-rank="{{ $cadet->rank ?? '' }}"
                                        data-address="{{ $cadet->address ?? '' }}"
                                        data-contact="{{ $cadet->contact_number ?? '' }}"
                                        data-email="{{ $cadet->email ?? '' }}"
                                        data-trb="{{ $cadet->trb_control_number ?? '' }}"
                                        data-photo="{{ $photoUrl }}"
                                        data-guardian-relationship="{{ $cadet->guardian_relationship ?? '' }}"
                                        data-guardian-name="{{ $cadet->parent_guardian_name ?? '' }}"
                                        data-guardian-contact="{{ $cadet->parent_guardian_contact ?? '' }}"
                                        data-guardian-email="{{ $cadet->parent_guardian_email ?? '' }}"
                                        data-guardian-address="{{ $cadet->parent_guardian_address ?? '' }}"
                                    >

                                        <i class="fas fa-pen-to-square"></i>
                                        <span>Edit</span>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="empty-row"
                            >

                                <div class="empty-state">

                                    <div class="empty-icon">

                                        <i class="fas fa-user-slash"></i>

                                    </div>

                                    <strong>
                                        No Cadets Found
                                    </strong>

                                    <span>
                                        No cadet records match your current filters.
                                    </span>

                                    @if(request()->hasAny([
                                        'search',
                                        'course',
                                        'batch',
                                        'deployment',
                                        'verification'
                                    ]))

                                        <a
                                            href="{{ route('admin.cadets.index') }}"
                                            class="clear-filters"
                                            style="margin-top:10px;"
                                        >
                                            <i class="fas fa-rotate-left"></i>
                                            Clear Filters
                                        </a>

                                    @endif

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

            <div class="pagination-container">

                <div class="pagination-summary">

                    Showing
                    <strong>{{ $cadets->firstItem() }}</strong>
                    -
                    <strong>{{ $cadets->lastItem() }}</strong>
                    of
                    <strong>{{ number_format($cadets->total()) }}</strong>

                </div>

                <div class="pagination-links">

                    {{ $cadets->links() }}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     VIEW MODAL
========================================================= --}}

<div
    id="cadetModal"
    class="cadet-modal"
    aria-hidden="true"
>

    <div
        class="view-modal-content"
        role="dialog"
        aria-modal="true"
    >

        {{-- HEADER --}}
        <div class="edit-modal-header">

            <div class="edit-modal-title">

                <div class="edit-modal-icon">
                    <i class="fas fa-user"></i>
                </div>

                <div>

                    <h2>
                        Cadet Information
                    </h2>

                    <p>
                        View cadet record
                    </p>

                </div>

            </div>

            <button
                type="button"
                class="modal-x"
                onclick="closeCadetModal()"
                aria-label="Close"
            >
                <i class="fas fa-xmark"></i>
            </button>

        </div>


        {{-- BODY --}}
        <div class="edit-modal-body view-modal-body">

            <div class="view-profile">

                <div class="view-photo-wrapper">

                    <img
                        id="viewPhoto"
                        src="{{ asset('images/default-avatar.png') }}"
                        alt="Cadet"
                        class="view-photo"
                    >

                </div>

                <h2 id="viewName">
                    —
                </h2>

                <div id="viewTrb" class="trb-code">
                    —
                </div>

            </div>


            <div class="view-information-grid">

                <div class="view-field">

                    <label>
                        Course
                    </label>

                    <div
                        class="view-value"
                        id="viewCourse"
                    >
                        —
                    </div>

                </div>


                <div class="view-field">

                    <label>
                        Batch
                    </label>

                    <div
                        class="view-value"
                        id="viewBatch"
                    >
                        —
                    </div>

                </div>


                <div class="view-field">

                    <label>
                        Rank
                    </label>

                    <div
                        class="view-value"
                        id="viewRank"
                    >
                        —
                    </div>

                </div>


                <div class="view-field">

                    <label>
                        Verification
                    </label>

                    <div
                        class="view-value verification-value"
                        id="viewVerification"
                    >
                        —
                    </div>

                </div>


                <div class="view-field">

                    <label>
                        Deployment
                    </label>

                    <div
                        class="view-value"
                        id="viewDeployment"
                    >
                        —
                    </div>

                </div>


                <div class="view-field">

                    <label>
                        Date of Birth
                    </label>

                    <div
                        class="view-value"
                        id="viewDob"
                    >
                        —
                    </div>

                </div>


                <div class="view-field">

                    <label>
                        Place of Birth
                    </label>

                    <div
                        class="view-value"
                        id="viewPlace"
                    >
                        —
                    </div>

                </div>


                <div class="view-field">

                    <label>
                        Contact Number
                    </label>

                    <div
                        class="view-value"
                        id="viewContact"
                    >
                        —
                    </div>

                </div>


                <div class="view-field view-field-full">

                    <label>
                        Email
                    </label>

                    <div
                        class="view-value"
                        id="viewEmail"
                    >
                        —
                    </div>

                </div>


                <div class="view-field view-field-full">

                    <label>
                        Address
                    </label>

                    <div
                        class="view-value"
                        id="viewAddress"
                    >
                        —
                    </div>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="edit-modal-footer">

            <button
                type="button"
                class="modal-btn modal-btn-cancel"
                onclick="closeCadetModal()"
            >
                Close
            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     EDIT MODAL
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
    >

        {{-- HEADER --}}
        <div class="edit-modal-header">

            <div class="edit-modal-title">

                <div class="edit-modal-icon">
                    <i class="fas fa-user-pen"></i>
                </div>

                <div>

                    <h2>
                        Edit Cadet
                    </h2>

                    <p>
                        Update cadet information
                    </p>

                </div>

            </div>

            <button
                type="button"
                class="modal-x"
                onclick="closeEditModal()"
                aria-label="Close"
            >
                <i class="fas fa-xmark"></i>
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


            {{-- BODY --}}
            <div class="edit-modal-body">

                {{-- PHOTO + BASIC --}}
                <div class="edit-profile">

                    <div class="photo-area">

                        <img
                            id="editPhotoPreview"
                            src="{{ asset('images/default-avatar.png') }}"
                            alt="Cadet Photo"
                            class="edit-photo"
                        >

                        <div class="photo-actions">

                            <label class="photo-btn photo-upload">

                                <i class="fas fa-camera"></i>
                                Change

                                <input
                                    type="file"
                                    name="photo"
                                    id="editPhotoInput"
                                    accept="image/jpeg,image/png,image/jpg"
                                    hidden
                                >

                            </label>

                            <button
                                type="button"
                                class="photo-btn photo-remove"
                                id="removePhotoBtn"
                            >
                                <i class="fas fa-trash"></i>
                                Remove
                            </button>

                        </div>

                    </div>


                    <div class="profile-fields">

                        <div class="form-row">

                            <div class="form-group">

                                <label class="form-label">
                                    TRB Control Number
                                    <span class="optional">
                                        (Optional)
                                    </span>
                                </label>

                                <input
                                    type="text"
                                    name="trb_control_number"
                                    id="editTrb"
                                    class="edit-input"
                                    maxlength="255"
                                    placeholder="Enter TRB control number"
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Full Name
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="full_name"
                                    id="editName"
                                    class="edit-input"
                                    required
                                >

                            </div>

                        </div>


                        <div class="form-row">

                            <div class="form-group">

                                <label class="form-label">
                                    Course
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="course"
                                    id="editCourse"
                                    class="edit-input"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Batch
                                </label>

                                <select
                                    name="batch_id"
                                    id="editBatch"
                                    class="edit-select"
                                >

                                    <option value="">
                                        Select Batch
                                    </option>

                                    @foreach($batches as $batch)

                                        <option
                                            value="{{ $batch->id }}"
                                        >
                                            {{ $batch->batch_year }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- TABS --}}
                <div class="edit-tabs">

                    <button
                        type="button"
                        class="edit-tab active"
                        data-tab="personalTab"
                    >
                        <i class="fas fa-user"></i>
                        <span>Personal Information</span>
                    </button>

                    <button
                        type="button"
                        class="edit-tab"
                        data-tab="guardianTab"
                    >
                        <i class="fas fa-people-roof"></i>
                        <span>Guardian Information</span>
                    </button>

                </div>


                {{-- =================================================
                     PERSONAL TAB
                ================================================== --}}
                <div
                    id="personalTab"
                    class="edit-tab-content active"
                >

                    <div class="form-section">

                        <div class="form-section-header">

                            <div class="form-section-icon">
                                <i class="fas fa-address-card"></i>
                            </div>

                            <div>

                                <h3>
                                    Personal Details
                                </h3>

                                <p>
                                    Cadet personal information
                                </p>

                            </div>

                        </div>


                        <div class="form-section-body">

                            <div class="form-row">

                                <div class="form-group">

                                    <label class="form-label">
                                        Date of Birth
                                    </label>

                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        id="editDob"
                                        class="edit-input"
                                    >

                                </div>


                                <div class="form-group">

                                    <label class="form-label">
                                        Place of Birth
                                    </label>

                                    <input
                                        type="text"
                                        name="place_of_birth"
                                        id="editPlace"
                                        class="edit-input"
                                    >

                                </div>

                            </div>


                            <div class="form-row">

                                <div class="form-group">

                                    <label class="form-label">
                                        Rank
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="rank"
                                        id="editRank"
                                        class="edit-input"
                                        required
                                    >

                                </div>


                                <div class="form-group">

                                    <label class="form-label">
                                        Contact Number
                                    </label>

                                    <input
                                        type="text"
                                        name="contact_number"
                                        id="editContact"
                                        class="edit-input"
                                        maxlength="20"
                                    >

                                </div>

                            </div>


                            <div class="form-row single">

                                <div class="form-group">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        id="editEmail"
                                        class="edit-input"
                                    >

                                </div>

                            </div>


                            <div class="form-row single">

                                <div class="form-group">

                                    <label class="form-label">
                                        Address
                                    </label>

                                    <textarea
                                        name="address"
                                        id="editAddress"
                                        class="edit-textarea"
                                        rows="4"
                                    ></textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     GUARDIAN TAB
                ================================================== --}}
                <div
                    id="guardianTab"
                    class="edit-tab-content"
                >

                    <div class="form-section">

                        <div class="form-section-header">

                            <div class="form-section-icon">
                                <i class="fas fa-people-roof"></i>
                            </div>

                            <div>

                                <h3>
                                    Guardian Information
                                </h3>

                                <p>
                                    Parent or guardian contact details
                                </p>

                            </div>

                        </div>


                        <div class="form-section-body">

                            <div class="form-row">

                                <div class="form-group">

                                    <label class="form-label">
                                        Relationship
                                    </label>

                                    <input
                                        type="text"
                                        name="guardian_relationship"
                                        id="editGuardianRelationship"
                                        class="edit-input"
                                        placeholder="Father, Mother, Guardian..."
                                    >

                                </div>


                                <div class="form-group">

                                    <label class="form-label">
                                        Guardian Name
                                    </label>

                                    <input
                                        type="text"
                                        name="parent_guardian_name"
                                        id="editGuardianName"
                                        class="edit-input"
                                    >

                                </div>

                            </div>


                            <div class="form-row">

                                <div class="form-group">

                                    <label class="form-label">
                                        Guardian Contact
                                    </label>

                                    <input
                                        type="text"
                                        name="parent_guardian_contact"
                                        id="editGuardianContact"
                                        class="edit-input"
                                        maxlength="20"
                                    >

                                </div>


                                <div class="form-group">

                                    <label class="form-label">
                                        Guardian Email
                                    </label>

                                    <input
                                        type="email"
                                        name="parent_guardian_email"
                                        id="editGuardianEmail"
                                        class="edit-input"
                                    >

                                </div>

                            </div>


                            <div class="form-row single">

                                <div class="form-group">

                                    <label class="form-label">
                                        Guardian Address
                                    </label>

                                    <textarea
                                        name="parent_guardian_address"
                                        id="editGuardianAddress"
                                        class="edit-textarea"
                                        rows="5"
                                    ></textarea>

                                </div>

                            </div>


                            <div class="edit-warning">

                                <i class="fas fa-circle-info"></i>

                                <span>
                                    Guardian information is optional.
                                    Make sure the contact details are accurate
                                    before saving the record.
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="edit-modal-footer">

                <button
                    type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closeEditModal()"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="modal-btn modal-btn-update"
                >
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    |
    | Server-side search.
    | Debounced to prevent a request on every keystroke.
    |
    */

    const searchInput =
        document.getElementById('searchInput');

    const filterForm =
        document.getElementById('cadetFilterForm');

    let searchTimer = null;

    if (searchInput && filterForm) {

        searchInput.addEventListener('input', function () {

            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {

                const value =
                    searchInput.value.trim();

                if (
                    value.length >= 2 ||
                    value.length === 0
                ) {
                    filterForm.submit();
                }

            }, 600);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SELECT FILTERS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '#courseFilter, #batchFilter, #deploymentFilter, #verificationFilter'
        )
        .forEach(function (select) {

            select.addEventListener('change', function () {

                if (filterForm) {
                    filterForm.submit();
                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | EDIT TABS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.edit-tab')
        .forEach(function (tab) {

            tab.addEventListener('click', function () {

                const target =
                    this.dataset.tab;

                document
                    .querySelectorAll('.edit-tab')
                    .forEach(function (item) {

                        item.classList.remove('active');

                    });


                document
                    .querySelectorAll('.edit-tab-content')
                    .forEach(function (content) {

                        content.classList.remove('active');

                    });


                this.classList.add('active');


                const targetElement =
                    document.getElementById(target);

                if (targetElement) {
                    targetElement.classList.add('active');
                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | PHOTO PREVIEW
    |--------------------------------------------------------------------------
    */

    const photoInput =
        document.getElementById('editPhotoInput');

    const photoPreview =
        document.getElementById('editPhotoPreview');

    if (photoInput) {

        photoInput.addEventListener('change', function () {

            const file =
                this.files && this.files[0];

            if (!file) {
                return;
            }


            if (file.size > 2 * 1024 * 1024) {

                alert(
                    'The selected photo must not exceed 2MB.'
                );

                this.value = '';

                return;
            }


            if (
                ![
                    'image/jpeg',
                    'image/png',
                    'image/jpg'
                ].includes(file.type)
            ) {

                alert(
                    'Please select a JPG, JPEG, or PNG image.'
                );

                this.value = '';

                return;
            }


            const reader =
                new FileReader();

            reader.onload =
                function (event) {

                    if (photoPreview) {
                        photoPreview.src =
                            event.target.result;
                    }

                };

            reader.readAsDataURL(file);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE PHOTO
    |--------------------------------------------------------------------------
    */

    const removePhotoBtn =
        document.getElementById('removePhotoBtn');

    if (removePhotoBtn) {

        removePhotoBtn.addEventListener(
            'click',
            function () {

                if (photoInput) {
                    photoInput.value = '';
                }

                if (photoPreview) {

                    photoPreview.src =
                        '{{ asset('images/default-avatar.png') }}';

                }


                let removeInput =
                    document.getElementById(
                        'remove_existing_photo'
                    );


                if (!removeInput) {

                    removeInput =
                        document.createElement('input');

                    removeInput.type =
                        'hidden';

                    removeInput.name =
                        'remove_photo';

                    removeInput.id =
                        'remove_existing_photo';

                    removeInput.value =
                        '1';

                    document
                        .getElementById('editCadetForm')
                        .appendChild(removeInput);

                } else {

                    removeInput.value = '1';

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MODAL BACKDROP CLICK
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.cadet-modal')
        .forEach(function (modal) {

            modal.addEventListener(
                'click',
                function (event) {

                    if (event.target === modal) {

                        modal.classList.remove('show');

                        modal.setAttribute(
                            'aria-hidden',
                            'true'
                        );

                        document.body
                            .classList.remove('modal-open');

                    }

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                closeCadetModal();
                closeEditModal();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SUCCESS MESSAGE
    |--------------------------------------------------------------------------
    */

    setTimeout(function () {

        const notification =
            document.getElementById('success-notif');

        if (notification) {

            notification.classList.add('closing');

            setTimeout(function () {

                notification.remove();

            }, 350);

        }

    }, 5000);

});


/*
|--------------------------------------------------------------------------
| VIEW MODAL
|--------------------------------------------------------------------------
*/

function openCadetModal(button) {

    if (!button) {
        return;
    }

    const data =
        button.dataset;

    const modal =
        document.getElementById('cadetModal');

    if (!modal) {
        return;
    }


    setText(
        'viewName',
        data.name
    );

    setText(
        'viewTrb',
        data.trb
            ? 'TRB: ' + data.trb
            : 'TRB: Not assigned'
    );

    setText(
        'viewCourse',
        data.course
    );

    setText(
        'viewBatch',
        data.batch
    );

    setText(
        'viewRank',
        data.rank
    );

    setText(
        'viewDob',
        data.dob
    );

    setText(
        'viewPlace',
        data.place
    );

    setText(
        'viewContact',
        data.contact
    );

    setText(
        'viewEmail',
        data.email
    );

    setText(
        'viewAddress',
        data.address
    );


    /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

    const viewPhoto =
        document.getElementById('viewPhoto');

    if (viewPhoto) {

        viewPhoto.src =
            data.photo ||
            '{{ asset('images/default-avatar.png') }}';

    }


    /*
    |--------------------------------------------------------------------------
    | VERIFICATION
    |--------------------------------------------------------------------------
    */

    const verification =
        document.getElementById(
            'viewVerification'
        );

    if (verification) {

        verification.textContent =
            data.verification || 'Pending';

        verification.className =
            'view-value verification-value ' +
            getVerificationClass(
                data.verification
            );

    }


    /*
    |--------------------------------------------------------------------------
    | DEPLOYMENT
    |--------------------------------------------------------------------------
    */

    const deployment =
        document.getElementById(
            'viewDeployment'
        );

    if (deployment) {

        deployment.textContent =
            data.deployment || 'Not Deployed';

    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'modal-open'
    );

}


/*
|--------------------------------------------------------------------------
| EDIT MODAL
|--------------------------------------------------------------------------
*/

function openEditModal(button) {

    if (!button) {
        return;
    }

    const data =
        button.dataset;

    const modal =
        document.getElementById(
            'editCadetModal'
        );

    const form =
        document.getElementById(
            'editCadetForm'
        );

    if (!modal || !form) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | FORM ACTION
    |--------------------------------------------------------------------------
    */

    form.action =
        '{{ url('/admin/cadets') }}/' +
        encodeURIComponent(data.id);


    /*
    |--------------------------------------------------------------------------
    | RESET REMOVE PHOTO
    |--------------------------------------------------------------------------
    */

    const removeInput =
        document.getElementById(
            'remove_existing_photo'
        );

    if (removeInput) {
        removeInput.remove();
    }


    /*
    |--------------------------------------------------------------------------
    | PERSONAL INFORMATION
    |--------------------------------------------------------------------------
    */

    setInputValue(
        'editTrb',
        data.trb
    );

    setInputValue(
        'editName',
        data.name
    );

    setInputValue(
        'editCourse',
        data.course
    );

    setInputValue(
        'editBatch',
        data.batchId
    );

    setInputValue(
        'editDob',
        data.dob
    );

    setInputValue(
        'editPlace',
        data.place
    );

    setInputValue(
        'editRank',
        data.rank
    );

    setInputValue(
        'editAddress',
        data.address
    );

    setInputValue(
        'editContact',
        data.contact
    );

    setInputValue(
        'editEmail',
        data.email
    );


    /*
    |--------------------------------------------------------------------------
    | GUARDIAN
    |--------------------------------------------------------------------------
    */

    setInputValue(
        'editGuardianRelationship',
        data.guardianRelationship
    );

    setInputValue(
        'editGuardianName',
        data.guardianName
    );

    setInputValue(
        'editGuardianContact',
        data.guardianContact
    );

    setInputValue(
        'editGuardianEmail',
        data.guardianEmail
    );

    setInputValue(
        'editGuardianAddress',
        data.guardianAddress
    );


    /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

    const preview =
        document.getElementById(
            'editPhotoPreview'
        );

    if (preview) {

        preview.src =
            data.photo ||
            '{{ asset('images/default-avatar.png') }}';

    }


    const photoInput =
        document.getElementById(
            'editPhotoInput'
        );

    if (photoInput) {
        photoInput.value = '';
    }


    /*
    |--------------------------------------------------------------------------
    | RESET TAB
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.edit-tab')
        .forEach(function (tab) {

            tab.classList.remove('active');

        });


    document
        .querySelectorAll('.edit-tab-content')
        .forEach(function (content) {

            content.classList.remove('active');

        });


    const personalTab =
        document.querySelector(
            '[data-tab="personalTab"]'
        );

    if (personalTab) {
        personalTab.classList.add('active');
    }


    const personalContent =
        document.getElementById(
            'personalTab'
        );

    if (personalContent) {
        personalContent.classList.add('active');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'modal-open'
    );

}


/*
|--------------------------------------------------------------------------
| COMPATIBILITY
|--------------------------------------------------------------------------
*/

function openEditModalById(id) {

    const button =
        document.querySelector(
            '.btn-edit[data-id="' +
            CSS.escape(String(id)) +
            '"]'
        );

    if (button) {
        openEditModal(button);
    }

}


/*
|--------------------------------------------------------------------------
| CLOSE VIEW
|--------------------------------------------------------------------------
*/

function closeCadetModal() {

    const modal =
        document.getElementById(
            'cadetModal'
        );

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove(
        'modal-open'
    );

}


/*
|--------------------------------------------------------------------------
| CLOSE EDIT
|--------------------------------------------------------------------------
*/

function closeEditModal() {

    const modal =
        document.getElementById(
            'editCadetModal'
        );

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove(
        'modal-open'
    );

}


/*
|--------------------------------------------------------------------------
| SET TEXT
|--------------------------------------------------------------------------
*/

function setText(id, value) {

    const element =
        document.getElementById(id);

    if (!element) {
        return;
    }

    element.textContent =
        value &&
        String(value).trim()
            ? value
            : '—';

}


/*
|--------------------------------------------------------------------------
| SET INPUT
|--------------------------------------------------------------------------
*/

function setInputValue(id, value) {

    const element =
        document.getElementById(id);

    if (!element) {
        return;
    }

    element.value =
        value ?? '';

}


/*
|--------------------------------------------------------------------------
| VERIFICATION CLASS
|--------------------------------------------------------------------------
*/

function getVerificationClass(status) {

    const value =
        String(status || '')
            .toLowerCase()
            .trim();

    if (
        value === 'approved' ||
        value === 'verified' ||
        value === 'accepted'
    ) {
        return 'approved';
    }

    if (
        value === 'rejected' ||
        value === 'declined' ||
        value === 'denied'
    ) {
        return 'rejected';
    }

    return 'pending';

}


/*
|--------------------------------------------------------------------------
| CLOSE SUCCESS
|--------------------------------------------------------------------------
*/

function closeSuccessNotif() {

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

    setTimeout(function () {

        notification.remove();

    }, 350);

}

</script>

@endsection