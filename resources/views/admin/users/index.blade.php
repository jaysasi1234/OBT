@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/users/users.css'])


{{-- =========================================================
     MAIN
========================================================= --}}

<div class="main">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="header">

        <h2>
            User Account Management
        </h2>


        <div class="header-buttons">

            {{-- CREATE SINGLE USER --}}
            <button
                type="button"
                class="add-btn"
                onclick="openModal()">

                <i class="bi bi-person-plus-fill"></i>

                Add User Account

            </button>


            {{-- CREATE BATCH ACCOUNTS --}}
            <button
                type="button"
                class="add-btn"
                onclick="openBatchAccountModal()">

                <i class="bi bi-people-fill"></i>

                Create Batch Cadet Accounts

            </button>

        </div>

    </div>


    {{-- =====================================================
         SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
         ERROR
    ====================================================== --}}

    @if(session('error'))

        <div class="alert-error">

            {{ session('error') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         SEARCH
    ====================================================== --}}

    <div class="table-toolbar">

        <div class="search-box">

            <input
                type="text"
                id="userSearch"
                placeholder="Search by name, email, or role..."
                oninput="searchUsers()">

        </div>

    </div>


    {{-- =====================================================
         USER TABLE
    ====================================================== --}}

    <div class="table-box">

        <table id="usersTable">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Role</th>

                    <th>Status</th>

                    <th width="220">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            {{ $user->name }}
                        </td>


                        <td>
                            {{ $user->email }}
                        </td>


                        <td>
                            {{ ucfirst($user->role) }}
                        </td>


                        <td>

                            @if($user->is_active)

                                <span class="status-active">
                                    Active
                                </span>

                            @else

                                <span class="status-inactive">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        <td class="action-buttons">


                            {{-- VIEW --}}
                            <button
                                type="button"
                                class="btn btn-blue"
                                onclick='openViewModal(
                                    @json($user->name),
                                    @json($user->email),
                                    @json(ucfirst($user->role)),
                                    @json($user->is_active ? "Active" : "Inactive"),
                                    @json($user->created_at?->format("F d, Y")),
                                    @json($user->updated_at?->format("F d, Y")),
                                    @json(
                                        $user->cadet && $user->cadet->photo
                                            ? asset("storage/".$user->cadet->photo)
                                            : "https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                                    )
                                )'>

                                View

                            </button>


                            {{-- EDIT --}}
                            <button
                                type="button"
                                class="btn btn-gray"
                                onclick='openEditModal(
                                    @json($user->id),
                                    @json($user->name),
                                    @json($user->email),
                                    @json($user->role),
                                    @json($user->is_active)
                                )'>

                                Edit

                            </button>


                            {{-- DELETE --}}
                            <button
                                type="button"
                                class="btn btn-red"
                                onclick='openDeleteModal(
                                    @json(route("admin.users.destroy", $user->id)),
                                    @json($user->name)
                                )'>

                                Delete

                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center;">

                            No users found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- =========================================================
     CREATE USER ACCOUNT MODAL
========================================================= --}}

<div
    id="cadetModal"
    class="modal">

    <div class="create-user-modal">


        {{-- HEADER --}}
        <div class="modal-header">

            <div>

                <h3>
                    Create User Account
                </h3>

                <p class="modal-subtitle">
                    Add a new administrator, dean, or cadet account.
                </p>

            </div>


            <button
                type="button"
                class="close-btn"
                onclick="closeModal()">

                &times;

            </button>

        </div>


        {{-- FORM --}}
        <form
            method="POST"
            action="{{ route('admin.users.store') }}">

            @csrf


            <div class="modal-body">


                {{-- PERSONAL --}}
                <div class="form-section-title">
                    Personal Information
                </div>


                <div class="form-row">


                    <div class="input-group">

                        <label for="first_name">
                            First Name
                        </label>

                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            placeholder="Enter first name"
                            required>

                    </div>


                    <div class="input-group">

                        <label for="last_name">
                            Last Name
                        </label>

                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            placeholder="Enter last name"
                            required>

                    </div>

                </div>


                <div class="input-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="example@gmail.com"
                        required>

                </div>


                {{-- ACCOUNT --}}
                <div class="form-section-title">
                    Account Information
                </div>


                <div class="form-row">


                    <div class="input-group">

                        <label for="create_role">
                            Role
                        </label>

                        <select
                            name="role"
                            id="create_role"
                            required
                            onchange="toggleCadetFields()">

                            <option value="">
                                Select Role
                            </option>

                            <option value="admin">
                                Administrator
                            </option>

                            <option value="dean">
                                Dean
                            </option>

                            <option value="cadet">
                                Cadet
                            </option>

                        </select>

                    </div>


                    <div class="input-group">

                        <label for="create_status">
                            Status
                        </label>

                        <select
                            name="status"
                            id="create_status"
                            required>

                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>


                {{-- CADET FIELDS --}}
                <div
                    id="cadetFields"
                    class="cadet-fields">


                    <div class="form-section-title">
                        Cadet Information
                    </div>


                    <div class="input-group">

                        <label for="trb_no">
                            TRB Number
                        </label>

                        <input
                            type="text"
                            name="trb_no"
                            id="trb_no"
                            placeholder="Enter TRB number">

                    </div>


                    <div class="input-group">

                        <label for="course">
                            Course
                        </label>

                        <select
                            name="course"
                            id="course">

                            <option value="">
                                Select Course
                            </option>

                            @foreach($courses as $course)

                                <option
                                    value="{{ $course->course_code }}">

                                    {{ $course->course_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- SECURITY --}}
                <div class="form-section-title">
                    Security
                </div>


                <div class="security-info">

                    <div class="security-icon">
                        🔐
                    </div>


                    <div class="security-content">

                        <strong>
                            Secure Account Setup
                        </strong>

                        <p>
                            A secure temporary password will be generated
                            automatically for this account. The user will
                            receive an email with instructions to set their
                            password.
                        </p>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-gray"
                    onclick="closeModal()">

                    Cancel

                </button>


                <button
                    type="submit"
                    class="btn btn-blue">

                    Create Account

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     CREATE BATCH CADET ACCOUNTS MODAL
========================================================= --}}

<div
    id="batchAccountModal"
    class="modal">

    <div class="batch-account-content">


        {{-- HEADER --}}
        <div class="batch-modal-header">

            <div class="batch-modal-title">

                <div class="batch-modal-icon">

                    <i class="bi bi-people-fill"></i>

                </div>


                <div>

                    <h3>
                        Create Batch Cadet Accounts
                    </h3>

                    <p>
                        Create user accounts for all cadets in a selected batch,
                        including cadets who do not have an email address.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="batch-modal-close"
                onclick="closeBatchAccountModal()"
                aria-label="Close">

                &times;

            </button>

        </div>


        {{-- FORM --}}
        <form
            method="POST"
            action="{{ route('admin.users.createBatchAccounts') }}"
            id="batchAccountForm">

            @csrf


            <div class="batch-modal-body">


                {{-- INFORMATION --}}
                <div class="batch-info">
                    <div class="batch-info-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div>
                        <strong>
                            Batch Account Creation
                        </strong>

                        <p>
                            Select a batch and the system will automatically
                            create an account for every cadet who does not
                            already have an account.
                        </p>

                        <p>
                            Cadets without an email address will still receive
                            an account. The system will automatically generate
                            a unique system email address using their name.
                        </p>
                    </div>
                </div>


                {{-- BATCH --}}
                <div class="batch-field">

                    <label for="batch_id">

                        <i class="bi bi-collection-fill"></i>

                        Select Batch

                    </label>


                    <select
                        name="batch_id"
                        id="batch_id"
                        required>

                        <option value="">
                            Select a batch
                        </option>


                        @foreach($batches as $batch)

                            @php

                                $availableCadets =
                                    $cadetsByBatch[$batch->id]
                                    ?? collect();

                            @endphp


                            <option
                                value="{{ $batch->id }}"
                                data-count="{{ $availableCadets->count() }}">

                                Batch {{ $batch->batch_year }}
                                —
                                {{ $availableCadets->count() }}
                                cadet(s) eligible for account creation

                            </option>

                        @endforeach

                    </select>

                    <small>
                        Cadets who already have accounts will be skipped.
                        Cadets without email addresses will still receive accounts
                        using an automatically generated system email address.
                    </small>

                </div>


                {{-- SELECTED BATCH --}}
                <div
                    id="selectedBatchPreview"
                    class="selected-batch-preview">

                    <div class="selected-batch-icon">

                        <i class="bi bi-people-fill"></i>

                    </div>


                    <div class="selected-batch-content">

                        <strong
                            id="selectedBatchTitle">

                            Selected Batch

                        </strong>


                        <span
                            id="selectedBatchCount">
                            0 cadets are eligible for account creation.
                        </span>

                    </div>

                </div>


                {{-- AUTOMATIC CREDENTIALS --}}
                <div class="batch-security">
                    <div class="batch-security-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <strong>
                            Automatic Account Credentials
                        </strong>

                        <p>
                            A secure temporary password and unique username
                            will be generated automatically for each new
                            cadet account.
                        </p>
                    </div>
                </div>


                {{-- SECURITY --}}
                <div class="batch-security">
                    <div class="batch-security-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <strong>
                            No Cadet Will Be Skipped Because of Missing Email
                        </strong>

                        <p>
                            Existing accounts will not be duplicated.
                            Cadets without email addresses will automatically
                            receive a unique system email address based on
                            their full name.
                        </p>
                    </div>
                </div>

            </div>


            {{-- FOOTER --}}
            <div class="batch-modal-footer">

                <button
                    type="button"
                    class="batch-btn batch-btn-cancel"
                    onclick="closeBatchAccountModal()">

                    <i class="bi bi-x-lg"></i>

                    Cancel

                </button>


                <button
                    type="submit"
                    class="batch-btn batch-btn-create"
                    id="createBatchAccountsButton">

                    <i class="bi bi-people-fill"></i>

                    Create Batch Accounts

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     EDIT MODAL
========================================================= --}}

<div
    id="editModal"
    class="modal">

    <div class="edit-modal-content">


        <div class="modal-header">

            <h3>
                Edit Account
            </h3>


            <button
                type="button"
                class="close-btn"
                onclick="closeEditModal()">

                &times;

            </button>

        </div>


        <form
            method="POST"
            id="editForm">

            @csrf

            @method('PUT')


            <div class="edit-modal-body">

                <input
                    type="text"
                    name="name"
                    id="edit_name"
                    placeholder="Full Name"
                    required>


                <input
                    type="email"
                    name="email"
                    id="edit_email"
                    placeholder="Email"
                    required>


                <div class="edit-row">

                    <select
                        name="role"
                        id="edit_role">

                        <option value="dean">
                            Dean
                        </option>

                        <option value="admin">
                            Admin
                        </option>

                        <option value="cadet">
                            Cadet
                        </option>

                    </select>


                    <select
                        name="is_active"
                        id="edit_status">

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
                            Inactive
                        </option>

                    </select>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-gray"
                    onclick="closeEditModal()">

                    Cancel

                </button>


                <button
                    type="submit"
                    class="btn btn-blue">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     VIEW MODAL
========================================================= --}}

<div
    id="viewModal"
    class="modal">

    <div class="view-modal-content">


        <div class="modal-header">

            <h3>
                User Account
            </h3>


            <button
                type="button"
                class="close-btn"
                onclick="closeViewModal()">

                &times;

            </button>

        </div>


        <div class="modal-body">

            <div class="view-profile">

                <img
                    id="view_photo"
                    src=""
                    alt="Profile">


                <div class="view-details">

                    <p>
                        <strong>Name:</strong>

                        <span id="view_name"></span>
                    </p>


                    <p>
                        <strong>Email:</strong>

                        <span id="view_email"></span>
                    </p>


                    <p>
                        <strong>Role:</strong>

                        <span id="view_role"></span>
                    </p>


                    <p>
                        <strong>Status:</strong>

                        <span id="view_status"></span>
                    </p>


                    <p>
                        <strong>Created:</strong>

                        <span id="view_created"></span>
                    </p>


                    <p>
                        <strong>Updated:</strong>

                        <span id="view_updated"></span>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- =========================================================
     BATCH ACCOUNT CONFIRMATION MODAL
========================================================= --}}
<div
    id="batchConfirmModal"
    class="modal">

    <div class="batch-confirm-content">

        {{-- ICON --}}
        <div class="batch-confirm-icon">
            <i class="bi bi-person-plus-fill"></i>
        </div>

        {{-- HEADER --}}
        <div class="batch-confirm-header">
            <h3>
                Confirm Batch Account Creation
            </h3>

            <p>
                Please review the account creation details before continuing.
            </p>
        </div>

        {{-- DETAILS --}}
        <div class="batch-confirm-details">

            <div class="confirm-detail">
                <span class="confirm-label">
                    <i class="bi bi-collection-fill"></i>
                    Batch
                </span>

                <strong id="confirmBatchName">
                    —
                </strong>
            </div>

            <div class="confirm-detail">
                <span class="confirm-label">
                    <i class="bi bi-people-fill"></i>
                    Accounts to Create
                </span>

                <strong id="confirmBatchCount">
                    0
                </strong>
            </div>

        </div>

        {{-- INFORMATION --}}
        <div class="batch-confirm-info">

            <div class="confirm-info-item">
                <i class="bi bi-check-circle-fill"></i>

                <div>
                    <strong>Existing accounts will be skipped</strong>

                    <p>
                        Cadets who already have user accounts will not
                        receive duplicate accounts.
                    </p>
                </div>
            </div>

            <div class="confirm-info-item">
                <i class="bi bi-envelope-check-fill"></i>

                <div>
                    <strong>Missing email addresses are supported</strong>

                    <p>
                        Cadets without an email address will automatically
                        receive a unique system email address.
                    </p>
                </div>
            </div>

            <div class="confirm-info-item">
                <i class="bi bi-shield-check"></i>

                <div>
                    <strong>Credentials will be generated automatically</strong>

                    <p>
                        A unique username and secure temporary password
                        will be generated for each new account.
                    </p>
                </div>
            </div>

        </div>

        {{-- WARNING --}}
        <div class="batch-confirm-warning">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                Please make sure the selected batch is correct before
                creating the accounts.
            </span>

        </div>

        {{-- FOOTER --}}
        <div class="batch-confirm-footer">

            <button
                type="button"
                class="batch-confirm-cancel"
                onclick="closeBatchConfirmModal()">

                <i class="bi bi-x-lg"></i>

                Cancel
            </button>

            <button
                type="button"
                class="batch-confirm-create"
                id="confirmCreateBatchButton"
                onclick="confirmBatchAccountCreation()">

                <i class="bi bi-person-plus-fill"></i>

                Create Accounts
            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     DELETE MODAL
========================================================= --}}

<div
    id="deleteModal"
    class="modal">

    <div class="delete-modal">


        <div class="delete-icon">

            <div class="icon-circle">
                🗑️
            </div>

        </div>


        <h2>
            Delete User Account
        </h2>


        <p class="delete-text">
            Are you sure you want to permanently delete
        </p>


        <h3 id="deleteUserName"></h3>


        <p class="delete-warning">
            This action is permanent and cannot be undone.
            All information associated with this account may be removed.
        </p>


        <div class="delete-actions">


            <button
                type="button"
                class="btn btn-gray"
                onclick="closeDeleteModal()">

                Cancel

            </button>


            <form
                id="deleteForm"
                method="POST">

                @csrf

                @method('DELETE')


                <button
                    type="submit"
                    class="btn btn-red">

                    Yes, Delete User

                </button>

            </form>

        </div>

    </div>

</div>


<script>

/* =========================================================
   MODAL HELPERS
========================================================= */

function lockBody()
{
    document.body.classList.add('modal-open');
}


function unlockBody()
{
    const anyModalOpen =
        document.querySelector('.modal.show');

    if (!anyModalOpen) {

        document.body.classList.remove(
            'modal-open'
        );

    }
}


/* =========================================================
   CREATE USER MODAL
========================================================= */

function openModal()
{
    const modal =
        document.getElementById(
            'cadetModal'
        );

    modal.classList.add('show');

    lockBody();
}


function closeModal()
{
    const modal =
        document.getElementById(
            'cadetModal'
        );

    modal.classList.remove('show');

    unlockBody();
}


/* =========================================================
   BATCH ACCOUNT MODAL
========================================================= */

function openBatchAccountModal()
{
    const modal =
        document.getElementById(
            'batchAccountModal'
        );

    modal.classList.add('show');

    lockBody();
}


function closeBatchAccountModal()
{
    const modal =
        document.getElementById(
            'batchAccountModal'
        );

    modal.classList.remove('show');

    unlockBody();
}


/* =========================================================
   BATCH SELECTION
========================================================= */

const batchSelect =
    document.getElementById(
        'batch_id'
    );

const selectedBatchPreview =
    document.getElementById(
        'selectedBatchPreview'
    );

const selectedBatchTitle =
    document.getElementById(
        'selectedBatchTitle'
    );

const selectedBatchCount =
    document.getElementById(
        'selectedBatchCount'
    );


if (batchSelect) {

    batchSelect.addEventListener(
        'change',
        function () {

            if (!this.value) {

                selectedBatchPreview
                    .classList
                    .remove('show');

                return;
            }


            const selectedOption =
                this.options[
                    this.selectedIndex
                ];


            const count =
                Number(
                    selectedOption
                        .dataset
                        .count || 0
                );


            const batchText =
                selectedOption.textContent
                    .trim()
                    .split('—')[0]
                    .trim();


            selectedBatchTitle.textContent =
                batchText;


            selectedBatchCount.textContent =
                count === 1
                    ? '1 cadet is eligible for account creation.'
                    : `${count} cadets are eligible for account creation.`;


            selectedBatchPreview
                .classList
                .add('show');

        }
    );

}


/* =========================================================
   BATCH ACCOUNT CONFIRMATION
========================================================= */

const batchAccountForm =
    document.getElementById('batchAccountForm');

const batchConfirmModal =
    document.getElementById('batchConfirmModal');

const confirmBatchName =
    document.getElementById('confirmBatchName');

const confirmBatchCount =
    document.getElementById('confirmBatchCount');

const confirmCreateBatchButton =
    document.getElementById('confirmCreateBatchButton');

const createBatchAccountsButton =
    document.getElementById('createBatchAccountsButton');

let batchCreationConfirmed = false;


/* =========================================================
   OPEN BATCH CONFIRMATION
========================================================= */

function openBatchConfirmModal()
{
    const batch =
        document.getElementById('batch_id');

    if (!batch || !batch.value) {

        return;
    }

    const selectedOption =
        batch.options[batch.selectedIndex];

    const count =
        Number(
            selectedOption.dataset.count || 0
        );

    const batchText =
        selectedOption.textContent
            .trim()
            .split('—')[0]
            .trim();


    /* Update confirmation information */

    if (confirmBatchName) {

        confirmBatchName.textContent =
            batchText;
    }


    if (confirmBatchCount) {

        confirmBatchCount.textContent =
            count;
    }


    /* Reset confirmation button */

    if (confirmCreateBatchButton) {

        confirmCreateBatchButton.disabled =
            false;

        confirmCreateBatchButton.innerHTML =
            '<i class="bi bi-person-plus-fill"></i> Create Accounts';
    }


    /* Show modal */

    batchConfirmModal.classList.add('show');

    lockBody();
}


/* =========================================================
   CLOSE BATCH CONFIRMATION
========================================================= */

function closeBatchConfirmModal()
{
    if (!batchConfirmModal) {

        return;
    }

    batchConfirmModal.classList.remove('show');

    unlockBody();
}


/* =========================================================
   CONFIRM BATCH ACCOUNT CREATION
========================================================= */

function confirmBatchAccountCreation()
{
    if (!batchAccountForm) {

        return;
    }


    const batch =
        document.getElementById('batch_id');


    if (!batch || !batch.value) {

        closeBatchConfirmModal();

        return;
    }


    const selectedOption =
        batch.options[batch.selectedIndex];


    const count =
        Number(
            selectedOption.dataset.count || 0
        );


    /* Safety check */

    if (count <= 0) {

        closeBatchConfirmModal();

        return;
    }


    /*
     * Mark the form as confirmed.
     *
     * This is important because the submit event
     * below normally opens this modal.
     */

    batchCreationConfirmed = true;


    /* Disable confirmation button */

    if (confirmCreateBatchButton) {

        confirmCreateBatchButton.disabled =
            true;

        confirmCreateBatchButton.innerHTML =
            '<i class="bi bi-hourglass-split"></i> Creating Accounts...';
    }


    /* Disable original button */

    if (createBatchAccountsButton) {

        createBatchAccountsButton.disabled =
            true;

        createBatchAccountsButton.innerHTML =
            '<i class="bi bi-hourglass-split"></i> Creating Accounts...';
    }


    /*
     * Close custom modal first.
     */

    closeBatchConfirmModal();


    /*
     * Submit normally.
     *
     * Using requestSubmit would trigger the submit
     * listener again, so use the native form submit.
     */

    HTMLFormElement.prototype.submit.call(
        batchAccountForm
    );
}


/* =========================================================
   BATCH FORM SUBMIT
========================================================= */

if (batchAccountForm) {

    batchAccountForm.addEventListener(
        'submit',
        function(event) {

            /*
             * If the user already confirmed,
             * allow normal submission.
             */

            if (batchCreationConfirmed) {

                return;
            }


            /*
             * STOP normal submission.
             */

            event.preventDefault();


            const batch =
                document.getElementById('batch_id');


            /*
             * No batch selected.
             */

            if (!batch || !batch.value) {

                /*
                 * DO NOT use alert() here either.
                 */

                openBatchAccountModal();

                batch.focus();

                return;
            }


            const selectedOption =
                batch.options[batch.selectedIndex];


            const count =
                Number(
                    selectedOption.dataset.count || 0
                );


            /*
             * No eligible cadets.
             */

            if (count <= 0) {

                /*
                 * Update the preview instead of
                 * showing a browser alert.
                 */

                if (selectedBatchPreview) {

                    selectedBatchPreview.classList.add(
                        'show'
                    );
                }

                if (selectedBatchCount) {

                    selectedBatchCount.textContent =
                        'No cadets are eligible for account creation.';
                }

                return;
            }


            /*
             * OPEN CUSTOM CONFIRMATION MODAL.
             *
             * There is intentionally NO confirm()
             * anywhere in this process.
             */

            openBatchConfirmModal();
        }
    );
}


/* =========================================================
   PASSWORD TOGGLE
========================================================= */

function togglePassword(
    inputId,
    button
)
{
    const input =
        document.getElementById(
            inputId
        );

    const icon =
        button.querySelector('i');


    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove(
            'bi-eye'
        );

        icon.classList.add(
            'bi-eye-slash'
        );

        button.setAttribute(
            'aria-label',
            'Hide password'
        );

    } else {

        input.type = 'password';

        icon.classList.remove(
            'bi-eye-slash'
        );

        icon.classList.add(
            'bi-eye'
        );

        button.setAttribute(
            'aria-label',
            'Show password'
        );

    }
}


/* =========================================================
   TOGGLE CADET FIELDS
========================================================= */

function toggleCadetFields()
{
    const role =
        document.getElementById(
            'create_role'
        ).value;


    const fields =
        document.getElementById(
            'cadetFields'
        );


    const trb =
        document.getElementById(
            'trb_no'
        );


    const course =
        document.getElementById(
            'course'
        );


    if (role === 'cadet') {

        fields.style.display =
            'block';

        trb.required = true;

        course.required = true;

    } else {

        fields.style.display =
            'none';

        trb.required = false;

        course.required = false;

        trb.value = '';

        course.value = '';

    }
}


/* =========================================================
   VIEW MODAL
========================================================= */

function openViewModal(
    name,
    email,
    role,
    status,
    created,
    updated,
    photo
)
{
    document.getElementById(
        'view_name'
    ).innerText = name;


    document.getElementById(
        'view_email'
    ).innerText = email;


    document.getElementById(
        'view_role'
    ).innerText = role;


    document.getElementById(
        'view_status'
    ).innerText = status;


    document.getElementById(
        'view_created'
    ).innerText = created;


    document.getElementById(
        'view_updated'
    ).innerText = updated;


    document.getElementById(
        'view_photo'
    ).src = photo;


    document
        .getElementById('viewModal')
        .classList
        .add('show');


    lockBody();
}


function closeViewModal()
{
    document
        .getElementById('viewModal')
        .classList
        .remove('show');


    unlockBody();
}


/* =========================================================
   EDIT MODAL
========================================================= */

function openEditModal(
    id,
    name,
    email,
    role,
    status
)
{
    document.getElementById(
        'edit_name'
    ).value = name;


    document.getElementById(
        'edit_email'
    ).value = email;


    document.getElementById(
        'edit_role'
    ).value = role;


    document.getElementById(
        'edit_status'
    ).value =
        status ? '1' : '0';


    document.getElementById(
        'editForm'
    ).action =
        '/admin/users/' + id;


    document
        .getElementById('editModal')
        .classList
        .add('show');


    lockBody();
}


function closeEditModal()
{
    document
        .getElementById('editModal')
        .classList
        .remove('show');


    unlockBody();
}


/* =========================================================
   DELETE MODAL
========================================================= */

function openDeleteModal(
    action,
    name
)
{
    document.getElementById(
        'deleteForm'
    ).action = action;


    document.getElementById(
        'deleteUserName'
    ).innerText = name;


    document
        .getElementById('deleteModal')
        .classList
        .add('show');


    lockBody();
}


function closeDeleteModal()
{
    document
        .getElementById('deleteModal')
        .classList
        .remove('show');


    unlockBody();
}


/* =========================================================
   SEARCH USERS
========================================================= */

function searchUsers()
{
    const input =
        document.getElementById(
            'userSearch'
        );


    const filter =
        input.value.toUpperCase();


    const table =
        document.getElementById(
            'usersTable'
        );


    const rows =
        table.getElementsByTagName(
            'tr'
        );


    for (
        let i = 1;
        i < rows.length;
        i++
    ) {

        const row = rows[i];


        const text =
            row.textContent ||
            row.innerText;


        row.style.display =
            text
                .toUpperCase()
                .includes(filter)
                ? ''
                : 'none';
    }
}


/* =========================================================
   BACKDROP CLICK
========================================================= */

window.addEventListener(
    'click',
    function (event) {

        const createModal =
            document.getElementById(
                'cadetModal'
            );


        const batchModal =
            document.getElementById(
                'batchAccountModal'
            );


        const viewModal =
            document.getElementById(
                'viewModal'
            );


        const editModal =
            document.getElementById(
                'editModal'
            );


        const deleteModal =
            document.getElementById(
                'deleteModal'
            );


        if (event.target === createModal) {
            closeModal();
        }


        if (event.target === batchModal) {
            closeBatchAccountModal();
        }


        if (event.target === viewModal) {
            closeViewModal();
        }


        if (event.target === editModal) {
            closeEditModal();
        }


        if (event.target === deleteModal) {
            closeDeleteModal();
        }

    }
);


/* =========================================================
   ESC KEY
========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        if (event.key !== 'Escape') {
            return;
        }


        closeModal();

        closeBatchAccountModal();

        closeViewModal();

        closeEditModal();

        closeDeleteModal();

    }
);


/* =========================================================
   VALIDATION ERROR
========================================================= */

@if($errors->any())

    openModal();

@endif

</script>

@endsection