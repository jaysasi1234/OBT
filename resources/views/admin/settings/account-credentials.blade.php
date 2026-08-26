@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/account-credentials.css'])


<div class="credentials-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="credentials-header">

        <div class="credentials-title">

            <div class="credentials-title-icon">
                <i class="bi bi-key-fill"></i>
            </div>

            <div class="credentials-header-left">

                <h2>
                    Account Credentials
                </h2>

                <p>
                    Select specific accounts, filter by batch,
                    and generate secure temporary login credentials.
                </p>

            </div>

        </div>


        <button
            type="button"
            class="generate-btn"
            id="openGenerateButton"
            onclick="openCredentialsModal()"
            disabled>

            <i class="bi bi-shield-lock-fill"></i>

            Generate Selected

        </button>

    </div>


    {{-- =====================================================
         ALERTS
    ====================================================== --}}

    @if(session('success'))

        <div class="credentials-alert success">

            <i class="bi bi-check-circle-fill"></i>

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="credentials-alert error">

            <i class="bi bi-exclamation-circle-fill"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- =====================================================
         SECURITY NOTICE
    ====================================================== --}}

    <div class="security-notice">

        <div class="security-notice-icon">

            <i class="bi bi-shield-check"></i>

        </div>

        <div>

            <strong>
                Credential Security
            </strong>

            <p>
                Passwords are stored securely as Laravel hashes.
                Only the accounts you select will receive a newly
                generated temporary password.
            </p>

        </div>

    </div>


    {{-- =====================================================
         ACCOUNT CARD
    ====================================================== --}}

    <div class="credentials-card">


        {{-- =================================================
             TOOLBAR
        ================================================== --}}

        <div class="credentials-toolbar">

            <div class="toolbar-info">

                Total Accounts:

                <strong id="totalAccounts">
                    {{ $users->count() }}
                </strong>

            </div>

            <div class="toolbar-info">

                Selected:

                <strong id="selectedCount">
                    0
                </strong>

            </div>

        </div>


        {{-- =================================================
             FILTERS
        ================================================== --}}

        <div class="credentials-filters">

            <div class="filter-group">

                <label
                    for="accountSearch"
                    class="filter-label">

                    Search Account

                </label>

                <input
                    type="text"
                    id="accountSearch"
                    class="filter-input"
                    placeholder="Search name, username, or email...">

            </div>


            <div class="filter-group">

                <label
                    for="batchFilter"
                    class="filter-label">

                    Batch

                </label>

                    <select
                        id="batchFilter"
                        class="filter-select">

                        <option value="">
                            All Batches
                        </option>

                        @foreach($batches as $batch)

                            <option value="{{ strtolower($batch->batch_year) }}">
                                {{ $batch->batch_year }}
                            </option>

                        @endforeach

                    </select>

            </div>


            <div class="filter-actions">

                <button
                    type="button"
                    class="clear-filter-btn"
                    onclick="clearCredentialFilters()">

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Clear Filters

                </button>

            </div>

        </div>


        {{-- =================================================
             SELECTION BAR
        ================================================== --}}

        <div class="selection-bar">

            <div class="selection-left">

                <label class="select-all-label">

                    <input
                        type="checkbox"
                        class="select-all-checkbox"
                        id="selectAllCheckbox">

                    Select All Visible

                </label>


                <div class="selection-count">

                    <strong id="visibleCount">
                        {{ $users->count() }}
                    </strong>

                    visible account(s)

                </div>

            </div>


            <div class="selection-actions">

                <button
                    type="button"
                    class="select-action-btn"
                    onclick="selectVisibleAccounts()">

                    Select Visible

                </button>


                <button
                    type="button"
                    class="select-action-btn"
                    onclick="clearAccountSelection()">

                    Clear Selection

                </button>

            </div>

        </div>


        {{-- =================================================
             ACCOUNT TABLE
        ================================================== --}}

        <div class="credentials-table-wrapper">

            <table class="credentials-table">

                <thead>

                    <tr>

                        <th>
                            Select
                        </th>

                        <th>
                            #
                        </th>

                        <th>
                            Account
                        </th>

                        <th>
                            Username
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Batch
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody id="credentialsTableBody">

                @forelse($users as $index => $user)

                @php
                    $batchName = optional($user->cadet?->batch)->batch_year ?? 'No Batch';
                @endphp


                        <tr
                            data-user-id="{{ $user->id }}"
                            data-batch="{{ strtolower($batchName) }}"
                            data-search="{{ strtolower(
                                ($user->name ?? '') . ' ' .
                                ($user->username ?? '') . ' ' .
                                ($user->email ?? '')
                            ) }}"
                        >


                        {{-- CHECKBOX --}}

                        <td>

                            <input
                                type="checkbox"
                                name="selected_user_ids[]"
                                value="{{ $user->id }}"
                                class="account-checkbox">


                        </td>


                        {{-- NUMBER --}}

                        <td>
                            {{ $index + 1 }}
                        </td>


                        {{-- ACCOUNT --}}

                        <td>

                            <div class="user-name">

                                {{ $user->name }}

                            </div>

                        </td>


                        {{-- USERNAME --}}

                        <td>

                            {{ $user->username
                                ?: 'Will be generated' }}

                        </td>


                        {{-- EMAIL --}}

                        <td>

                            {{ $user->email ?: '—' }}

                        </td>


                        {{-- BATCH --}}

                        <td>
                            <span class="batch-badge">
                                {{ $batchName }}
                            </span>
                        </td>


                        {{-- ROLE --}}

                        <td>

                            <span class="role-badge">

                                {{ ucfirst($user->role) }}

                            </span>

                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($user->is_active)

                                <span class="account-status active">

                                    <span class="status-dot"></span>

                                    Active

                                </span>

                            @else

                                <span class="account-status inactive">

                                    <span class="status-dot"></span>

                                    Inactive

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="empty-credentials">

                            <strong>
                                No accounts found
                            </strong>

                            There are currently no user accounts
                            available.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         GENERATED CREDENTIALS
    ====================================================== --}}

    @if(session('generated_credentials'))

        @php

            $generatedCredentials =
                session('generated_credentials');

        @endphp


        <div class="generated-box">

            <div class="generated-header">

                <div>

                    <h3>
                        Generated Account Credentials
                    </h3>

                    <p>
                        Temporary credentials generated during
                        the latest operation.
                    </p>

                </div>


                <a
                    href="{{ route(
                        'admin.settings.account-credentials.download'
                    ) }}"
                    class="download-btn">

                    <i class="bi bi-file-earmark-pdf-fill"></i>

                    Download PDF

                </a>

            </div>


            <div class="generated-table-wrapper">

                <table class="generated-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Name
                            </th>

                            <th>
                                Username
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Temporary Password
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @foreach(
                        $generatedCredentials
                        as $index => $credential
                    )

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $credential['name'] ?? '—' }}
                            </td>

                            <td>
                                {{ $credential['username'] ?? '—' }}
                            </td>

                            <td>
                                {{ $credential['email'] ?? '—' }}
                            </td>

                            <td>
                                {{ $credential['role'] ?? '—' }}
                            </td>

                            <td>

                                <span class="temporary-password">

                                    {{ $credential['password'] ?? '—' }}

                                </span>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @endif

</div>


{{-- =========================================================
     CONFIRMATION MODAL
========================================================= --}}

<div
    id="credentialsModal"
    class="credentials-modal">

    <div class="credentials-modal-content">


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="credentials-modal-header">

            <h3>
                Generate Selected Credentials
            </h3>


            <button
                type="button"
                class="credentials-modal-close"
                onclick="closeCredentialsModal()">

                &times;

            </button>

        </div>


        {{-- =================================================
             FORM
        ================================================== --}}

        <form
            method="POST"
            action="{{ route(
                'admin.settings.account-credentials.generate'
            ) }}"
            id="credentialsForm">

            @csrf


            <div class="credentials-modal-body">


                {{-- Hidden selected IDs are inserted by JS --}}

                <div id="selectedUserInputs"></div>


                <div class="credentials-warning">

                    <strong>
                        ⚠ Existing passwords will be replaced
                    </strong>

                    Only the accounts listed below will receive
                    a newly generated temporary password.

                    <br><br>

                    Their previous passwords will no longer work.

                </div>


                <div class="batch-summary">

                    <strong id="modalSelectedCount">
                        0
                    </strong>

                    account(s) will be processed.

                    <br>

                    Usernames will automatically be generated
                    for accounts that do not already have one.

                </div>


                {{-- =================================================
                     SELECTED ACCOUNTS
                ================================================== --}}

                <div
                    id="selectedAccountsList"
                    class="selected-accounts-list">

                </div>

            </div>


            <div class="credentials-modal-footer">

                <button
                    type="button"
                    class="modal-btn cancel"
                    onclick="closeCredentialsModal()">

                    Cancel

                </button>


                <button
                    type="submit"
                    class="modal-btn confirm"
                    id="confirmGenerateButton">

                    <i class="bi bi-key-fill"></i>

                    Generate Selected

                </button>

            </div>

        </form>

    </div>

</div>


<script>

/* =========================================================
   ELEMENTS
========================================================= */

const searchInput =
    document.getElementById('accountSearch');

const batchFilter =
    document.getElementById('batchFilter');

const tableBody =
    document.getElementById('credentialsTableBody');

const selectAllCheckbox =
    document.getElementById('selectAllCheckbox');

const selectedCountElement =
    document.getElementById('selectedCount');

const visibleCountElement =
    document.getElementById('visibleCount');

const openGenerateButton =
    document.getElementById('openGenerateButton');

const credentialsModal =
    document.getElementById('credentialsModal');

const selectedAccountsList =
    document.getElementById('selectedAccountsList');

const selectedUserInputs =
    document.getElementById('selectedUserInputs');

const modalSelectedCount =
    document.getElementById('modalSelectedCount');


/* =========================================================
   GET ACCOUNT ROWS
========================================================= */

function getAccountRows()
{
    if (!tableBody) {
        return [];
    }

    return Array.from(
        tableBody.querySelectorAll(
            'tr[data-user-id]'
        )
    );
}


/* =========================================================
   GET CHECKBOXES
========================================================= */

function getAccountCheckboxes()
{
    return Array.from(
        document.querySelectorAll(
            '.account-checkbox'
        )
    );
}


/* =========================================================
   GET SELECTED CHECKBOXES
========================================================= */

function getSelectedCheckboxes()
{
    return getAccountCheckboxes()
        .filter(
            checkbox => checkbox.checked
        );
}


/* =========================================================
   UPDATE SELECTED COUNT
========================================================= */

function updateSelectionUI()
{
    const selected =
        getSelectedCheckboxes();

    const selectedCount =
        selected.length;

    if (selectedCountElement) {

        selectedCountElement.textContent =
            selectedCount;

    }

    if (openGenerateButton) {

        openGenerateButton.disabled =
            selectedCount === 0;

    }


    /*
    |--------------------------------------------------------------------------
    | Highlight selected rows
    |--------------------------------------------------------------------------
    */

    getAccountRows().forEach(
        row => {

            const checkbox =
                row.querySelector(
                    '.account-checkbox'
                );

            row.classList.toggle(
                'selected',
                checkbox &&
                checkbox.checked
            );

        }
    );


    updateSelectAllState();
}


/* =========================================================
   UPDATE SELECT ALL CHECKBOX
========================================================= */

function updateSelectAllState()
{
    if (!selectAllCheckbox) {
        return;
    }

    const visibleCheckboxes =
        getAccountRows()
            .filter(
                row =>
                    !row.classList.contains(
                        'filter-hidden'
                    )
            )
            .map(
                row =>
                    row.querySelector(
                        '.account-checkbox'
                    )
            )
            .filter(Boolean);


    if (visibleCheckboxes.length === 0) {

        selectAllCheckbox.checked = false;

        selectAllCheckbox.indeterminate = false;

        return;
    }


    const checkedCount =
        visibleCheckboxes.filter(
            checkbox =>
                checkbox.checked
        ).length;


    selectAllCheckbox.checked =
        checkedCount === visibleCheckboxes.length;

    selectAllCheckbox.indeterminate =
        checkedCount > 0 &&
        checkedCount < visibleCheckboxes.length;
}


/* =========================================================
   FILTER ACCOUNTS
========================================================= */

function filterAccounts()
{
    const search =
        (
            searchInput?.value || ''
        )
        .trim()
        .toLowerCase();


    const batch =
        batchFilter?.value || '';


    let visibleCount = 0;


    getAccountRows().forEach(
        row => {

            const rowSearch =
                (
                    row.dataset.search || ''
                ).toLowerCase();


            const rowBatch =
                (row.dataset.batch || '').toLowerCase().trim();


            const searchMatch =
                !search ||
                rowSearch.includes(search);


            const batchMatch =
                !batch ||
                rowBatch === batch;


            const visible =
                searchMatch &&
                batchMatch;


            row.classList.toggle(
                'filter-hidden',
                !visible
            );


            if (visible) {
                visibleCount++;
            }

        }
    );


    if (visibleCountElement) {

        visibleCountElement.textContent =
            visibleCount;

    }


    updateSelectAllState();
}


/* =========================================================
   SEARCH EVENT
========================================================= */

if (searchInput) {

    searchInput.addEventListener(
        'input',
        filterAccounts
    );

}


/* =========================================================
   BATCH FILTER EVENT
========================================================= */

if (batchFilter) {

    batchFilter.addEventListener(
        'change',
        filterAccounts
    );

}


/* =========================================================
   SELECT ALL VISIBLE
========================================================= */

if (selectAllCheckbox) {

    selectAllCheckbox.addEventListener(
        'change',
        function() {

            const checked =
                this.checked;


            getAccountRows().forEach(
                row => {

                    if (
                        row.classList.contains(
                            'filter-hidden'
                        )
                    ) {
                        return;
                    }


                    const checkbox =
                        row.querySelector(
                            '.account-checkbox'
                        );


                    if (checkbox) {

                        checkbox.checked =
                            checked;

                    }

                }
            );


            updateSelectionUI();

        }
    );

}


/* =========================================================
   INDIVIDUAL CHECKBOX EVENTS
========================================================= */

document.addEventListener(
    'change',
    function(event) {

        if (
            event.target.classList.contains(
                'account-checkbox'
            )
        ) {

            updateSelectionUI();

        }

    }
);


/* =========================================================
   SELECT VISIBLE
========================================================= */

function selectVisibleAccounts()
{
    getAccountRows().forEach(
        row => {

            if (
                row.classList.contains(
                    'filter-hidden'
                )
            ) {
                return;
            }


            const checkbox =
                row.querySelector(
                    '.account-checkbox'
                );


            if (checkbox) {

                checkbox.checked =
                    true;

            }

        }
    );


    updateSelectionUI();
}


/* =========================================================
   CLEAR SELECTION
========================================================= */

function clearAccountSelection()
{
    getAccountCheckboxes().forEach(
        checkbox => {

            checkbox.checked = false;

        }
    );


    if (selectAllCheckbox) {

        selectAllCheckbox.checked = false;

        selectAllCheckbox.indeterminate =
            false;

    }


    updateSelectionUI();
}


/* =========================================================
   CLEAR FILTERS
========================================================= */

function clearCredentialFilters()
{
    if (searchInput) {

        searchInput.value = '';

    }

    if (batchFilter) {

        batchFilter.value = '';

    }

    filterAccounts();
}


/* =========================================================
   OPEN MODAL
========================================================= */

function openCredentialsModal()
{
    const selected =
        getSelectedCheckboxes();


    if (selected.length === 0) {

        return;

    }


    buildSelectedAccountsModal(
        selected
    );


    credentialsModal.classList.add(
        'show'
    );


    document.body.style.overflow =
        'hidden';
}


/* =========================================================
   BUILD MODAL ACCOUNT LIST
========================================================= */

function buildSelectedAccountsModal(
    selectedCheckboxes
)
{
    if (!selectedAccountsList) {
        return;
    }


    if (selectedUserInputs) {

        selectedUserInputs.innerHTML = '';

    }


    selectedAccountsList.innerHTML = '';


    selectedCheckboxes.forEach(
        checkbox => {

            const row =
                checkbox.closest(
                    'tr[data-user-id]'
                );


            if (!row) {
                return;
            }


            const userId =
                row.dataset.userId;


            /*
            |--------------------------------------------------------------------------
            | Hidden user ID
            |--------------------------------------------------------------------------
            */

            if (selectedUserInputs) {

                const input =
                    document.createElement(
                        'input'
                    );

                input.type = 'hidden';

                input.name =
                    'selected_user_ids[]';

                input.value =
                    userId;

                selectedUserInputs.appendChild(
                    input
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Account data
            |--------------------------------------------------------------------------
            */

            const name =
                row.querySelector(
                    '.user-name'
                )?.textContent.trim()
                || 'Unknown Account';


            const cells =
                row.querySelectorAll(
                    'td'
                );


            const username =
                cells[3]?.textContent.trim()
                || '—';


            const email =
                cells[4]?.textContent.trim()
                || '—';


            const batch =
                cells[5]?.textContent.trim()
                || 'No Batch';


            const role =
                cells[6]?.textContent.trim()
                || '—';


            /*
            |--------------------------------------------------------------------------
            | Modal item
            |--------------------------------------------------------------------------
            */

            const item =
                document.createElement(
                    'div'
                );

            item.className =
                'selected-account-item';


            item.innerHTML = `

                <div>

                    <div class="selected-account-name">
                        ${escapeHtml(name)}
                    </div>

                    <div class="selected-account-meta">
                        ${escapeHtml(username)}
                        &nbsp; • &nbsp;
                        ${escapeHtml(email)}
                        &nbsp; • &nbsp;
                        ${escapeHtml(batch)}
                    </div>

                </div>

                <div class="selected-account-role">
                    ${escapeHtml(role)}
                </div>

            `;


            selectedAccountsList.appendChild(
                item
            );

        }
    );


    if (modalSelectedCount) {

        modalSelectedCount.textContent =
            selectedCheckboxes.length;

    }
}


/* =========================================================
   ESCAPE HTML
========================================================= */

function escapeHtml(value)
{
    return String(value)
        .replace(
            /&/g,
            '&amp;'
        )
        .replace(
            /</g,
            '&lt;'
        )
        .replace(
            />/g,
            '&gt;'
        )
        .replace(
            /"/g,
            '&quot;'
        )
        .replace(
            /'/g,
            '&#039;'
        );
}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closeCredentialsModal()
{
    if (!credentialsModal) {
        return;
    }


    credentialsModal.classList.remove(
        'show'
    );


    document.body.style.overflow =
        '';
}


/* =========================================================
   OUTSIDE CLICK
========================================================= */

window.addEventListener(
    'click',
    function(event) {

        if (
            credentialsModal &&
            event.target === credentialsModal
        ) {

            closeCredentialsModal();

        }

    }
);


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener(
    'keydown',
    function(event) {

        if (
            event.key === 'Escape'
        ) {

            closeCredentialsModal();

        }

    }
);


/* =========================================================
   PREVENT DOUBLE SUBMISSION
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function() {

        const form =
            document.getElementById(
                'credentialsForm'
            );


        if (!form) {
            return;
        }


        form.addEventListener(
            'submit',
            function(event) {

                const selected =
                    getSelectedCheckboxes();


                if (selected.length === 0) {

                    event.preventDefault();

                    closeCredentialsModal();

                    return;

                }


                const button =
                    document.getElementById(
                        'confirmGenerateButton'
                    );


                if (!button) {
                    return;
                }


                button.disabled =
                    true;


                button.innerHTML =
                    '<i class="bi bi-hourglass-split"></i> Generating...';

            }
        );

    }
);


/* =========================================================
   INITIALIZE
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function() {

        filterAccounts();

        updateSelectionUI();

    }
);

</script>

@endsection