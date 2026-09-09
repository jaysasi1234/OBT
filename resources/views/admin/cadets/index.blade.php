@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/cadets/cadets.css'])

<div class="cadet-management-page">

    {{-- =====================================================
         SUCCESS NOTIFICATION
    ====================================================== --}}
    @if(session('success'))
        <div id="success-notif" class="notif success-notif">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
            <button type="button" onclick="closeSuccessNotif()">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    @endif


    {{-- =====================================================
         VALIDATION ERRORS
    ====================================================== --}}
    @if($errors->any())
        <div class="notif error-notif">
            <i class="fas fa-circle-exclamation"></i>

            <div>
                <strong>Please check the following:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            <button type="button" onclick="this.parentElement.remove()">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    @endif


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}
    <div class="page-header">

        <div class="page-header-left">

            <div class="page-title-icon">
                <i class="fas fa-user-graduate"></i>
            </div>

            <div>
                <h1>Cadet Management</h1>
                <p>Manage cadet records, deployment and verification status.</p>
            </div>

        </div>

        <a href="{{ route('admin.cadets.create') }}" class="btn-primary">
            <i class="fas fa-user-plus"></i>
            <span>Add New Cadet</span>
        </a>

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}
    <div class="stats-grid">

        {{-- Total --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Total Cadets</span>
                <strong>{{ number_format($totalCadets) }}</strong>
            </div>

        </div>


        {{-- Active --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Active Cadets</span>
                <strong>{{ number_format($activeCadets) }}</strong>
            </div>

        </div>


        {{-- Deployed --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="fas fa-ship"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">Currently Deployed</span>
                <strong>{{ number_format($withDeployment) }}</strong>
            </div>

        </div>


        {{-- No Deployment --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="fas fa-user-clock"></i>
            </div>

            <div class="stat-content">
                <span class="stat-label">No Deployment</span>
                <strong>{{ number_format($noDeployment) }}</strong>
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER PANEL
    ====================================================== --}}
    <form
        method="GET"
        action="{{ route('admin.cadets.index') }}"
        class="filter-panel"
        id="cadetFilterForm"
    >

        <div class="filter-header">

            <div>
                <h3>
                    <i class="fas fa-filter"></i>
                    Filter Cadets
                </h3>

                <p>
                    Search and filter cadet records.
                </p>
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
            <div class="filter-group search-group">

                <label for="searchInput">
                    Search
                </label>

                <div class="search-input-wrapper">

                    <i class="fas fa-magnifying-glass"></i>

                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        value="{{ request('search') }}"
                        placeholder="Search name, TRB, course, rank..."
                        autocomplete="off"
                    >

                </div>

            </div>


            {{-- COURSE --}}
            <div class="filter-group">

                <label for="courseFilter">
                    Course
                </label>

                <select
                    name="course"
                    id="courseFilter"
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
                                {{ request('course') == $courseValue ? 'selected' : '' }}
                            >
                                {{ $courseValue }}
                            </option>
                        @endif
                    @endforeach

                </select>

            </div>


            {{-- BATCH --}}
            <div class="filter-group">

                <label for="batchFilter">
                    Batch
                </label>

                <select
                    name="batch"
                    id="batchFilter"
                >

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


            {{-- DEPLOYMENT --}}
            <div class="filter-group">

                <label for="deploymentFilter">
                    Deployment
                </label>

                <select
                    name="deployment"
                    id="deploymentFilter"
                >

                    <option value="">
                        All Deployment
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

                    <option
                        value="not_deployed"
                        {{ request('deployment') === 'not_deployed' ? 'selected' : '' }}
                    >
                        Not Deployed
                    </option>

                </select>

            </div>


            {{-- VERIFICATION --}}
            <div class="filter-group">

                <label for="verificationFilter">
                    Verification
                </label>

                <select
                    name="verification"
                    id="verificationFilter"
                >

                    <option value="">
                        All Verification
                    </option>

                    <option
                        value="approved"
                        {{ request('verification') === 'approved' ? 'selected' : '' }}
                    >
                        Approved
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
                        Rejected
                    </option>

                </select>

            </div>


            {{-- FILTER BUTTON --}}
            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn-filter"
                >
                    <i class="fas fa-filter"></i>
                    Apply Filters
                </button>

            </div>

        </div>

    </form>


    {{-- =====================================================
         TABLE CARD
    ====================================================== --}}
    <div class="table-card">

        {{-- TABLE HEADER --}}
        <div class="table-card-header">

            <div>

                <h3>
                    <i class="fas fa-users"></i>
                    Cadet Records
                </h3>

                <p>
                    Showing
                    <strong>{{ $cadets->firstItem() ?? 0 }}</strong>
                    –
                    <strong>{{ $cadets->lastItem() ?? 0 }}</strong>
                    of
                    <strong>{{ $cadets->total() }}</strong>
                    cadets
                </p>

            </div>

            @if(request()->hasAny([
                'search',
                'course',
                'batch',
                'deployment',
                'verification'
            ]))
                <div class="active-filter-label">
                    <i class="fas fa-filter"></i>
                    Filters applied
                </div>
            @endif

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}
        <div class="table-responsive">

            <table
                class="cadet-table"
                id="cadetTable"
            >

                <thead>

                    <tr>

                        <th>TRB</th>

                        <th>CADET</th>

                        <th>COURSE</th>

                        <th>BATCH</th>

                        <th>RANK</th>

                        <th>VERIFICATION</th>

                        <th>DEPLOYMENT</th>

                        <th>ACTION</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($cadets as $cadet)

                        {{-- =================================================
                             NORMALIZE STATUS
                        ================================================== --}}

                        @php

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
                                    ['verified', 'approved', 'accepted', 'complete', 'completed']
                                )
                            ) {
                                $verificationStatus = 'approved';
                                $verificationText = 'Approved';
                                $verificationClass = 'status-approved';

                            } elseif (
                                in_array(
                                    $verificationRaw,
                                    ['rejected', 'declined', 'denied']
                                )
                            ) {
                                $verificationStatus = 'rejected';
                                $verificationText = 'Rejected';
                                $verificationClass = 'status-rejected';

                            } else {
                                $verificationStatus = 'pending';
                                $verificationText = 'Pending';
                                $verificationClass = 'status-pending';
                            }


                            $deploymentRaw = strtolower(
                                trim(
                                    optional($cadet->deployment)->status ?? ''
                                )
                            );

                            if ($deploymentRaw === 'ongoing') {

                                $deploymentStatus = 'ongoing';
                                $deploymentText = 'Ongoing';
                                $deploymentClass = 'status-ongoing';

                            } elseif ($deploymentRaw === 'completed') {

                                $deploymentStatus = 'completed';
                                $deploymentText = 'Completed';
                                $deploymentClass = 'status-completed';

                            } else {

                                $deploymentStatus = 'not_deployed';
                                $deploymentText = 'Not Deployed';
                                $deploymentClass = 'status-not-deployed';

                            }


                            $batchYear = optional($cadet->batch)->batch_year
                                ?? '—';


                            /*
                            |--------------------------------------------------------------------------
                            | PHOTO
                            |--------------------------------------------------------------------------
                            */

                            $photoUrl = $cadet->photo
                                ? asset('storage/' . ltrim($cadet->photo, '/'))
                                : asset('images/default-avatar.png');


                            /*
                            |--------------------------------------------------------------------------
                            | FULL NAME
                            |--------------------------------------------------------------------------
                            */

                            $fullName = $cadet->full_name ?: 'Unnamed Cadet';

                        @endphp


                        {{-- =================================================
                             CADET ROW
                        ================================================== --}}

                        <tr class="cadet-row">

                            {{-- TRB --}}
                            <td>

                                <span class="trb-number">

                                    {{ $cadet->trb_control_number ?: '—' }}

                                </span>

                            </td>


                            {{-- CADET --}}
                            <td>

                                <div class="cadet-identity">

                                    <img
                                        src="{{ $photoUrl }}"
                                        alt="{{ $fullName }}"
                                        class="cadet-avatar"
                                        loading="lazy"
                                        decoding="async"
                                    >

                                    <div class="cadet-info">

                                        <strong>
                                            {{ $fullName }}
                                        </strong>

                                        @if($cadet->email)
                                            <small>
                                                {{ $cadet->email }}
                                            </small>
                                        @endif

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

                                <span class="batch-badge">
                                    {{ $batchYear }}
                                </span>

                            </td>


                            {{-- RANK --}}
                            <td>

                                <span class="rank-text">
                                    {{ $cadet->rank ?: '—' }}
                                </span>

                            </td>


                            {{-- VERIFICATION --}}
                            <td>

                                <span class="status-badge {{ $verificationClass }}">

                                    @if($verificationStatus === 'approved')

                                        <i class="fas fa-circle-check"></i>

                                    @elseif($verificationStatus === 'rejected')

                                        <i class="fas fa-circle-xmark"></i>

                                    @else

                                        <i class="fas fa-clock"></i>

                                    @endif

                                    {{ $verificationText }}

                                </span>

                            </td>


                            {{-- DEPLOYMENT --}}
                            <td>

                                <span class="status-badge {{ $deploymentClass }}">

                                    @if($deploymentStatus === 'ongoing')

                                        <i class="fas fa-ship"></i>

                                    @elseif($deploymentStatus === 'completed')

                                        <i class="fas fa-circle-check"></i>

                                    @else

                                        <i class="fas fa-minus-circle"></i>

                                    @endif

                                    {{ $deploymentText }}

                                </span>

                            </td>


                            {{-- ACTION --}}
                            <td>

                                <div class="action-buttons">

                                    {{-- VIEW --}}
                                    <button
                                        type="button"
                                        class="action-btn view-btn"
                                        title="View Cadet"
                                        onclick="openCadetModal(this)"
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

                                    </button>


                                    {{-- EDIT --}}
                                    <button
                                        type="button"
                                        class="action-btn edit-btn"
                                        title="Edit Cadet"
                                        onclick="openEditModal(this)"
                                        data-id="{{ $cadet->id }}"
                                        data-name="{{ $fullName }}"
                                        data-course="{{ $cadet->course ?? '' }}"
                                        data-batch-id="{{ $cadet->batch_id ?? '' }}"
                                        data-batch="{{ $batchYear }}"
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

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="empty-state"
                            >

                                <div class="empty-state-content">

                                    <div class="empty-state-icon">
                                        <i class="fas fa-user-slash"></i>
                                    </div>

                                    <h3>No Cadets Found</h3>

                                    <p>
                                        No cadet records match your current filters.
                                    </p>

                                    @if(request()->hasAny([
                                        'search',
                                        'course',
                                        'batch',
                                        'deployment',
                                        'verification'
                                    ]))
                                        <a
                                            href="{{ route('admin.cadets.index') }}"
                                            class="btn-secondary"
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


        {{-- =================================================
             PAGINATION
        ================================================== --}}

        @if($cadets->hasPages())

            <div class="pagination-wrapper">

                <div class="pagination-info">

                    Showing
                    <strong>{{ $cadets->firstItem() }}</strong>
                    to
                    <strong>{{ $cadets->lastItem() }}</strong>
                    of
                    <strong>{{ $cadets->total() }}</strong>
                    results

                </div>

                <div class="pagination-links">

                    {{ $cadets->links() }}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     VIEW CADET MODAL
========================================================= --}}

<div
    id="cadetModal"
    class="modal-overlay"
    aria-hidden="true"
>

    <div
        class="modal-container cadet-view-modal"
        role="dialog"
        aria-modal="true"
    >

        <div class="modal-header">

            <div>
                <h2>
                    <i class="fas fa-user-graduate"></i>
                    Cadet Information
                </h2>

                <p>
                    View cadet record
                </p>
            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeCadetModal()"
            >
                <i class="fas fa-xmark"></i>
            </button>

        </div>


        <div class="modal-body">

            <div class="profile-summary">

                <img
                    id="viewPhoto"
                    src=""
                    alt="Cadet"
                    class="modal-profile-photo"
                >

                <div class="profile-summary-info">

                    <h3 id="viewName">
                        —
                    </h3>

                    <p id="viewTrb">
                        —
                    </p>

                    <div class="profile-statuses">

                        <span
                            id="viewVerification"
                            class="status-badge"
                        >
                            —
                        </span>

                        <span
                            id="viewDeployment"
                            class="status-badge"
                        >
                            —
                        </span>

                    </div>

                </div>

            </div>


            <div class="details-grid">

                <div class="detail-item">

                    <span>
                        <i class="fas fa-graduation-cap"></i>
                        Course
                    </span>

                    <strong id="viewCourse">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        <i class="fas fa-layer-group"></i>
                        Batch
                    </span>

                    <strong id="viewBatch">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        <i class="fas fa-id-badge"></i>
                        Rank
                    </span>

                    <strong id="viewRank">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        <i class="fas fa-calendar"></i>
                        Date of Birth
                    </span>

                    <strong id="viewDob">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        <i class="fas fa-location-dot"></i>
                        Place of Birth
                    </span>

                    <strong id="viewPlace">
                        —
                    </strong>

                </div>


                <div class="detail-item">

                    <span>
                        <i class="fas fa-phone"></i>
                        Contact Number
                    </span>

                    <strong id="viewContact">
                        —
                    </strong>

                </div>


                <div class="detail-item full-width">

                    <span>
                        <i class="fas fa-envelope"></i>
                        Email
                    </span>

                    <strong id="viewEmail">
                        —
                    </strong>

                </div>


                <div class="detail-item full-width">

                    <span>
                        <i class="fas fa-map-marker-alt"></i>
                        Address
                    </span>

                    <strong id="viewAddress">
                        —
                    </strong>

                </div>

            </div>

        </div>


        <div class="modal-footer">

            <button
                type="button"
                class="btn-secondary"
                onclick="closeCadetModal()"
            >
                Close
            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     EDIT CADET MODAL
========================================================= --}}

<div
    id="editCadetModal"
    class="modal-overlay"
    aria-hidden="true"
>

    <div
        class="modal-container edit-cadet-modal"
        role="dialog"
        aria-modal="true"
    >

        <div class="modal-header">

            <div>

                <h2>
                    <i class="fas fa-user-pen"></i>
                    Edit Cadet
                </h2>

                <p>
                    Update cadet information
                </p>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeEditModal()"
            >
                <i class="fas fa-xmark"></i>
            </button>

        </div>


        <form
            id="editCadetForm"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            <div class="modal-body">

                {{-- =================================================
                     PHOTO
                ================================================== --}}

                <div class="edit-photo-section">

                    <div class="edit-photo-preview">

                        <img
                            id="editPhotoPreview"
                            src="{{ asset('images/default-avatar.png') }}"
                            alt="Cadet photo"
                        >

                    </div>

                    <div class="edit-photo-actions">

                        <label class="btn-secondary photo-upload-btn">

                            <i class="fas fa-camera"></i>

                            Change Photo

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
                            class="btn-danger-outline"
                            id="removePhotoBtn"
                        >
                            <i class="fas fa-trash"></i>
                            Remove
                        </button>

                        <small>
                            JPG, JPEG or PNG. Maximum 2MB.
                        </small>

                    </div>

                </div>


                {{-- =================================================
                     TABS
                ================================================== --}}

                <div class="form-tabs">

                    <button
                        type="button"
                        class="form-tab active"
                        data-tab="personalTab"
                    >
                        <i class="fas fa-user"></i>
                        Personal Information
                    </button>

                    <button
                        type="button"
                        class="form-tab"
                        data-tab="guardianTab"
                    >
                        <i class="fas fa-people-roof"></i>
                        Guardian Information
                    </button>

                </div>


                {{-- =================================================
                     PERSONAL TAB
                ================================================== --}}

                <div
                    id="personalTab"
                    class="form-tab-content active"
                >

                    <div class="form-grid">


                        {{-- TRB --}}
                        <div class="form-group">

                            <label for="editTrb">
                                TRB Control Number
                                <span class="optional-label">
                                    Optional
                                </span>
                            </label>

                            <input
                                type="text"
                                name="trb_control_number"
                                id="editTrb"
                                maxlength="255"
                                placeholder="Enter TRB control number"
                            >

                        </div>


                        {{-- FULL NAME --}}
                        <div class="form-group">

                            <label for="editName">
                                Full Name
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="full_name"
                                id="editName"
                                required
                            >

                        </div>


                        {{-- COURSE --}}
                        <div class="form-group">

                            <label for="editCourse">
                                Course
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="course"
                                id="editCourse"
                                required
                            >

                        </div>


                        {{-- BATCH --}}
                        <div class="form-group">

                            <label for="editBatch">
                                Batch
                            </label>

                            <select
                                name="batch_id"
                                id="editBatch"
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


                        {{-- DOB --}}
                        <div class="form-group">

                            <label for="editDob">
                                Date of Birth
                            </label>

                            <input
                                type="date"
                                name="date_of_birth"
                                id="editDob"
                            >

                        </div>


                        {{-- PLACE OF BIRTH --}}
                        <div class="form-group">

                            <label for="editPlace">
                                Place of Birth
                            </label>

                            <input
                                type="text"
                                name="place_of_birth"
                                id="editPlace"
                            >

                        </div>


                        {{-- RANK --}}
                        <div class="form-group">

                            <label for="editRank">
                                Rank
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="rank"
                                id="editRank"
                                required
                            >

                        </div>


                        {{-- CONTACT --}}
                        <div class="form-group">

                            <label for="editContact">
                                Contact Number
                            </label>

                            <input
                                type="text"
                                name="contact_number"
                                id="editContact"
                                maxlength="20"
                            >

                        </div>


                        {{-- EMAIL --}}
                        <div class="form-group">

                            <label for="editEmail">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="editEmail"
                            >

                        </div>


                        {{-- ADDRESS --}}
                        <div class="form-group full-width">

                            <label for="editAddress">
                                Address
                            </label>

                            <textarea
                                name="address"
                                id="editAddress"
                                rows="3"
                            ></textarea>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     GUARDIAN TAB
                ================================================== --}}

                <div
                    id="guardianTab"
                    class="form-tab-content"
                >

                    <div class="form-grid">


                        {{-- RELATIONSHIP --}}
                        <div class="form-group">

                            <label for="editGuardianRelationship">
                                Relationship
                            </label>

                            <input
                                type="text"
                                name="guardian_relationship"
                                id="editGuardianRelationship"
                                placeholder="e.g. Father, Mother, Guardian"
                            >

                        </div>


                        {{-- GUARDIAN NAME --}}
                        <div class="form-group">

                            <label for="editGuardianName">
                                Guardian Name
                            </label>

                            <input
                                type="text"
                                name="parent_guardian_name"
                                id="editGuardianName"
                            >

                        </div>


                        {{-- GUARDIAN CONTACT --}}
                        <div class="form-group">

                            <label for="editGuardianContact">
                                Guardian Contact
                            </label>

                            <input
                                type="text"
                                name="parent_guardian_contact"
                                id="editGuardianContact"
                                maxlength="20"
                            >

                        </div>


                        {{-- GUARDIAN EMAIL --}}
                        <div class="form-group">

                            <label for="editGuardianEmail">
                                Guardian Email
                            </label>

                            <input
                                type="email"
                                name="parent_guardian_email"
                                id="editGuardianEmail"
                            >

                        </div>


                        {{-- GUARDIAN ADDRESS --}}
                        <div class="form-group full-width">

                            <label for="editGuardianAddress">
                                Guardian Address
                            </label>

                            <textarea
                                name="parent_guardian_address"
                                id="editGuardianAddress"
                                rows="4"
                            ></textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 EDIT FOOTER
            ================================================== --}}

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="closeEditModal()"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn-primary"
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
    | AUTO SUBMIT SEARCH
    |--------------------------------------------------------------------------
    */

    const searchInput = document.getElementById('searchInput');
    const filterForm = document.getElementById('cadetFilterForm');

    let searchTimer = null;

    if (searchInput && filterForm) {

        searchInput.addEventListener('input', function () {

            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {

                /*
                 * Only submit when the search has at least
                 * 2 characters or is cleared.
                 */
                if (
                    searchInput.value.trim().length >= 2 ||
                    searchInput.value.trim().length === 0
                ) {
                    filterForm.submit();
                }

            }, 500);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SELECT FILTERS
    |--------------------------------------------------------------------------
    */

    const selectFilters = document.querySelectorAll(
        '#courseFilter, #batchFilter, #deploymentFilter, #verificationFilter'
    );

    selectFilters.forEach(function (select) {

        select.addEventListener('change', function () {

            filterForm.submit();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | FORM TABS
    |--------------------------------------------------------------------------
    */

    const tabs = document.querySelectorAll('.form-tab');

    tabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            const target = this.dataset.tab;

            tabs.forEach(function (item) {
                item.classList.remove('active');
            });

            document
                .querySelectorAll('.form-tab-content')
                .forEach(function (content) {
                    content.classList.remove('active');
                });

            this.classList.add('active');

            const targetElement = document.getElementById(target);

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

    const photoInput = document.getElementById('editPhotoInput');
    const photoPreview = document.getElementById('editPhotoPreview');

    if (photoInput) {

        photoInput.addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {
                return;
            }


            /*
             * 2MB max
             */

            if (file.size > 2 * 1024 * 1024) {

                alert('The selected photo must not exceed 2MB.');

                this.value = '';

                return;
            }


            /*
             * Preview
             */

            const reader = new FileReader();

            reader.onload = function (event) {

                if (photoPreview) {
                    photoPreview.src = event.target.result;
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

    const removePhotoBtn = document.getElementById('removePhotoBtn');

    if (removePhotoBtn) {

        removePhotoBtn.addEventListener('click', function () {

            if (photoInput) {
                photoInput.value = '';
            }

            if (photoPreview) {
                photoPreview.src =
                    '{{ asset('images/default-avatar.png') }}';
            }

            /*
             * Hidden input tells controller to remove
             * existing photo.
             */

            let removeInput =
                document.getElementById('remove_existing_photo');

            if (!removeInput) {

                removeInput = document.createElement('input');

                removeInput.type = 'hidden';
                removeInput.name = 'remove_photo';
                removeInput.id = 'remove_existing_photo';
                removeInput.value = '1';

                document
                    .getElementById('editCadetForm')
                    .appendChild(removeInput);

            } else {

                removeInput.value = '1';

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | MODAL OUTSIDE CLICK
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.modal-overlay')
        .forEach(function (modal) {

            modal.addEventListener('click', function (event) {

                if (event.target === modal) {

                    modal.classList.remove('active');

                    modal.setAttribute(
                        'aria-hidden',
                        'true'
                    );

                    document.body.classList.remove('modal-open');

                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        closeCadetModal();
        closeEditModal();

    });


    /*
    |--------------------------------------------------------------------------
    | SUCCESS NOTIFICATION
    |--------------------------------------------------------------------------
    */

    setTimeout(function () {

        const notification =
            document.getElementById('success-notif');

        if (notification) {

            notification.style.opacity = '0';

            setTimeout(function () {
                notification.remove();
            }, 300);

        }

    }, 5000);

});


/*
|--------------------------------------------------------------------------
| VIEW CADET MODAL
|--------------------------------------------------------------------------
*/

function openCadetModal(button) {

    if (!button) {
        return;
    }


    const modal =
        document.getElementById('cadetModal');

    if (!modal) {
        return;
    }


    /*
     * Get data from button
     */

    const data = button.dataset;


    /*
     * Basic information
     */

    setText('viewName', data.name);
    setText(
        'viewTrb',
        data.trb
            ? 'TRB: ' + data.trb
            : 'TRB: Not assigned'
    );

    setText('viewCourse', data.course);
    setText('viewBatch', data.batch);
    setText('viewRank', data.rank);
    setText('viewDob', data.dob);
    setText('viewPlace', data.place);
    setText('viewContact', data.contact);
    setText('viewEmail', data.email);
    setText('viewAddress', data.address);


    /*
     * Photo
     */

    const photo =
        document.getElementById('viewPhoto');

    if (photo) {

        photo.src =
            data.photo ||
            '{{ asset('images/default-avatar.png') }}';

    }


    /*
     * Verification
     */

    const verification =
        document.getElementById('viewVerification');

    if (verification) {

        verification.textContent =
            data.verification || 'Pending';

        verification.className =
            'status-badge ' +
            getVerificationClass(
                data.verification
            );

    }


    /*
     * Deployment
     */

    const deployment =
        document.getElementById('viewDeployment');

    if (deployment) {

        deployment.textContent =
            data.deployment || 'Not Deployed';

        deployment.className =
            'status-badge ' +
            getDeploymentClass(
                data.deployment
            );

    }


    /*
     * Show modal
     */

    modal.classList.add('active');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add('modal-open');

}


/*
|--------------------------------------------------------------------------
| EDIT CADET MODAL
|--------------------------------------------------------------------------
*/

function openEditModal(button) {

    if (!button) {
        return;
    }


    const data = button.dataset;

    const modal =
        document.getElementById('editCadetModal');

    const form =
        document.getElementById('editCadetForm');

    if (!modal || !form) {
        return;
    }


    /*
     * Set form action
     */

    form.action =
        '{{ url('/admin/cadets') }}/' +
        encodeURIComponent(data.id);


    /*
     * Clear old remove-photo instruction
     */

    const oldRemoveInput =
        document.getElementById('remove_existing_photo');

    if (oldRemoveInput) {
        oldRemoveInput.remove();
    }


    /*
     * Fill fields
     */

    setInputValue('editTrb', data.trb);
    setInputValue('editName', data.name);
    setInputValue('editCourse', data.course);
    setInputValue('editBatch', data.batchId);
    setInputValue('editDob', data.dob);
    setInputValue('editPlace', data.place);
    setInputValue('editRank', data.rank);
    setInputValue('editAddress', data.address);
    setInputValue('editContact', data.contact);
    setInputValue('editEmail', data.email);

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
     * Photo
     */

    const preview =
        document.getElementById('editPhotoPreview');

    if (preview) {

        preview.src =
            data.photo ||
            '{{ asset('images/default-avatar.png') }}';

    }


    /*
     * Reset photo input
     */

    const photoInput =
        document.getElementById('editPhotoInput');

    if (photoInput) {
        photoInput.value = '';
    }


    /*
     * Always open Personal Information tab
     */

    document
        .querySelectorAll('.form-tab')
        .forEach(function (tab) {
            tab.classList.remove('active');
        });

    document
        .querySelectorAll('.form-tab-content')
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

    document
        .getElementById('personalTab')
        ?.classList.add('active');


    /*
     * Show modal
     */

    modal.classList.add('active');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add('modal-open');

}


/*
|--------------------------------------------------------------------------
| OPEN EDIT MODAL BY ID
|--------------------------------------------------------------------------
|
| Kept for compatibility with any existing code
| that may call this function.
|
*/

function openEditModalById(id) {

    const button =
        document.querySelector(
            '.edit-btn[data-id="' +
            CSS.escape(String(id)) +
            '"]'
        );

    if (button) {
        openEditModal(button);
    }

}


/*
|--------------------------------------------------------------------------
| CLOSE VIEW MODAL
|--------------------------------------------------------------------------
*/

function closeCadetModal() {

    const modal =
        document.getElementById('cadetModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('active');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove('modal-open');

}


/*
|--------------------------------------------------------------------------
| CLOSE EDIT MODAL
|--------------------------------------------------------------------------
*/

function closeEditModal() {

    const modal =
        document.getElementById('editCadetModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('active');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove('modal-open');

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
        value && String(value).trim()
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
        String(status || '').toLowerCase().trim();

    if (
        value === 'approved' ||
        value === 'verified' ||
        value === 'accepted'
    ) {
        return 'status-approved';
    }

    if (
        value === 'rejected' ||
        value === 'declined' ||
        value === 'denied'
    ) {
        return 'status-rejected';
    }

    return 'status-pending';

}


/*
|--------------------------------------------------------------------------
| DEPLOYMENT CLASS
|--------------------------------------------------------------------------
*/

function getDeploymentClass(status) {

    const value =
        String(status || '').toLowerCase().trim();

    if (value === 'ongoing') {
        return 'status-ongoing';
    }

    if (value === 'completed') {
        return 'status-completed';
    }

    return 'status-not-deployed';

}


/*
|--------------------------------------------------------------------------
| SUCCESS NOTIFICATION
|--------------------------------------------------------------------------
*/

function closeSuccessNotif() {

    const notification =
        document.getElementById('success-notif');

    if (!notification) {
        return;
    }

    notification.style.opacity = '0';

    setTimeout(function () {
        notification.remove();
    }, 300);

}

</script>

@endsection