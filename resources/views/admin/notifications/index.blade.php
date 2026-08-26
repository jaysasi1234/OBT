@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/notifications/notification.css'])

<div class="notifications-page">

    {{-- =====================================================
         SUCCESS TOAST
    ====================================================== --}}

    @if(session('success'))

        <div
            id="successToast"
            class="success-toast"
            role="alert"
        >
            ✅ {{ session('success') }}
        </div>

    @endif


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="notifications-header">

        <div>

            <h2>
                🔔 All Notifications
            </h2>

            <p>
                {{ $notifications->total() }}
                Notification{{ $notifications->total() != 1 ? 's' : '' }}
            </p>

        </div>


        <div class="header-actions">

            {{-- SELECT ALL --}}

            <label
                class="select-all-box"
                for="selectAll"
            >

                <input
                    type="checkbox"
                    id="selectAll"
                >

                <span>
                    Select All
                </span>

            </label>


            {{-- MARK ALL READ --}}

            <form
                action="{{ route('admin.notifications.readAll') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="btn-primary"
                >
                    <i class="fas fa-check-double"></i>
                    Mark All Read
                </button>

            </form>

        </div>

    </div>


    {{-- =====================================================
         BULK DELETE FORM
    ====================================================== --}}

    <form
        id="bulkDeleteForm"
        action="{{ route('admin.notifications.deleteSelected') }}"
        method="POST"
    >

        @csrf

        @method('DELETE')


        {{-- =================================================
             NOTIFICATION LIST
        ================================================== --}}

        <div class="notifications-list">

            @forelse($notifications as $notification)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Notification Data
                    |--------------------------------------------------------------------------
                    */

                    $data = is_array($notification->data)
                        ? $notification->data
                        : [];

                    /*
                    |--------------------------------------------------------------------------
                    | Message
                    |--------------------------------------------------------------------------
                    */

                    $message =
                        $data['message']
                        ?? $data['text']
                        ?? $data['title']
                        ?? 'Notification';

                    /*
                    |--------------------------------------------------------------------------
                    | Icon
                    |--------------------------------------------------------------------------
                    */

                    $icon =
                        $data['icon']
                        ?? 'fa-bell';

                    /*
                    |--------------------------------------------------------------------------
                    | URL
                    |--------------------------------------------------------------------------
                    */

                    $notificationUrl =
                        $data['url']
                        ?? route(
                            'notifications.open',
                            $notification->id
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Determine Icon Type
                    |--------------------------------------------------------------------------
                    |
                    | Supports:
                    |
                    | fa-file-circle-check
                    | fas fa-file-circle-check
                    | fa-solid fa-file-circle-check
                    | emoji
                    |
                    */

                    $isFontAwesome =
                        is_string($icon)
                        &&
                        (
                            str_contains($icon, 'fa-')
                            ||
                            str_contains($icon, 'fas ')
                            ||
                            str_contains($icon, 'far ')
                            ||
                            str_contains($icon, 'fab ')
                            ||
                            str_contains($icon, 'fa-solid ')
                            ||
                            str_contains($icon, 'fa-regular ')
                            ||
                            str_contains($icon, 'fa-brands ')
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Normalize Font Awesome Class
                    |--------------------------------------------------------------------------
                    */

                    if ($isFontAwesome) {

                        $iconClasses = trim($icon);

                        /*
                        |--------------------------------------------------------------------------
                        | If only "fa-file..." is stored,
                        | automatically add "fas".
                        |--------------------------------------------------------------------------
                        */

                        if (
                            str_starts_with(
                                $iconClasses,
                                'fa-'
                            )
                        ) {

                            $iconClasses =
                                'fas ' . $iconClasses;

                        }

                    }

                @endphp


                <div
                    class="notification-card {{ $notification->read_at ? '' : 'is-unread' }}"
                    data-notification-id="{{ $notification->id }}"
                >

                    {{-- =================================================
                         CHECKBOX
                    ================================================== --}}

                    <div class="card-check">

                        <input
                            type="checkbox"
                            name="notifications[]"
                            value="{{ $notification->id }}"
                            class="notification-check"
                            aria-label="Select notification"
                        >

                    </div>


                    {{-- =================================================
                         ICON
                    ================================================== --}}

                    <div
                        class="notification-icon"
                        aria-hidden="true"
                    >

                        @if($isFontAwesome)

                            <i class="{{ $iconClasses }}"></i>

                        @else

                            {{ $icon }}

                        @endif

                    </div>


                    {{-- =================================================
                         MESSAGE
                    ================================================== --}}

                    <div class="notification-content">

                        <div class="notification-message">

                            {{ $message }}

                        </div>


                        <div class="notification-time">

                            <i class="far fa-clock"></i>

                            {{ $notification->created_at->diffForHumans() }}

                        </div>

                    </div>


                    {{-- =================================================
                         STATUS
                    ================================================== --}}

                    <div class="notification-status">

                        @if($notification->read_at)

                            <span class="badge badge-read">

                                <i class="fas fa-check"></i>

                                Read

                            </span>

                        @else

                            <span class="badge badge-unread">

                                <i class="fas fa-circle"></i>

                                Unread

                            </span>

                        @endif

                    </div>


                    {{-- =================================================
                         OPEN
                    ================================================== --}}

                    <div class="notification-action">

                        <a
                            href="{{ $notificationUrl }}"
                            class="btn-view"
                        >

                            <i class="fas fa-eye"></i>

                            Open

                        </a>

                    </div>


                    {{-- =================================================
                         DELETE
                    ================================================== --}}

                    <div class="notification-delete">

                        <button
                            type="button"
                            class="btn-delete single-delete-btn"
                            data-delete-url="{{ route('admin.notifications.delete', $notification->id) }}"
                            aria-label="Delete notification"
                            title="Delete notification"
                        >

                            <i class="fas fa-trash"></i>

                        </button>

                    </div>

                </div>

            @empty


                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}

                <div class="empty-box">

                    <div
                        class="empty-box-icon"
                        aria-hidden="true"
                    >
                        <i class="far fa-bell-slash"></i>
                    </div>

                    <h3>
                        No Notifications
                    </h3>

                    <p>
                        You're all caught up.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- =====================================================
             BULK DELETE
        ====================================================== --}}

        <div class="bulk-actions">

            <button
                type="button"
                id="bulkDeleteBtn"
                class="btn-danger"
            >

                <i class="fas fa-trash"></i>

                <span>
                    Delete Selected
                </span>

                <span id="selectedCount">
                    (0)
                </span>

            </button>

        </div>

    </form>


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}

    @if($notifications->hasPages())

        <div class="pagination-box">

            {{ $notifications->links() }}

        </div>

    @endif

</div>


{{-- =========================================================
     SINGLE DELETE MODAL
========================================================= --}}

<div
    class="modal-overlay"
    id="singleModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="singleModalTitle"
    aria-hidden="true"
>

    <div class="modal-box">

        <h3 id="singleModalTitle">

            Delete Notification

        </h3>

        <p>

            Are you sure you want to delete this notification?

            <br>

            This action cannot be undone.

        </p>

        <div class="modal-buttons">

            <button
                type="button"
                class="btn-cancel"
                id="singleCancelBtn"
            >

                Cancel

            </button>

            <button
                type="button"
                class="btn-confirm"
                id="singleConfirmBtn"
            >

                Delete

            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     BULK DELETE MODAL
========================================================= --}}

<div
    class="modal-overlay"
    id="bulkModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="bulkModalTitle"
    aria-hidden="true"
>

    <div class="modal-box">

        <h3 id="bulkModalTitle">

            Delete Selected Notifications

        </h3>

        <p id="bulkModalMessage">

            Are you sure you want to delete the selected notifications?

        </p>

        <div class="modal-buttons">

            <button
                type="button"
                class="btn-cancel"
                id="bulkCancelBtn"
            >

                Cancel

            </button>

            <button
                type="button"
                class="btn-confirm"
                id="bulkConfirmBtn"
            >

                Delete

            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     HIDDEN SINGLE DELETE FORM
========================================================= --}}

<form
    id="singleDeleteForm"
    method="POST"
    style="display:none;"
>

    @csrf

    @method('DELETE')

</form>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

@once

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       ELEMENTS
    ====================================================== */

    const selectAll =
        document.getElementById('selectAll');

    const checks =
        document.querySelectorAll(
            '.notification-check'
        );

    const bulkDeleteBtn =
        document.getElementById(
            'bulkDeleteBtn'
        );

    const selectedCount =
        document.getElementById(
            'selectedCount'
        );

    const bulkDeleteForm =
        document.getElementById(
            'bulkDeleteForm'
        );

    const singleDeleteForm =
        document.getElementById(
            'singleDeleteForm'
        );

    const singleModal =
        document.getElementById(
            'singleModal'
        );

    const bulkModal =
        document.getElementById(
            'bulkModal'
        );

    const singleCancelBtn =
        document.getElementById(
            'singleCancelBtn'
        );

    const singleConfirmBtn =
        document.getElementById(
            'singleConfirmBtn'
        );

    const bulkCancelBtn =
        document.getElementById(
            'bulkCancelBtn'
        );

    const bulkConfirmBtn =
        document.getElementById(
            'bulkConfirmBtn'
        );

    const bulkModalMessage =
        document.getElementById(
            'bulkModalMessage'
        );


    let deleteUrl = '';

    let lastFocusedElement = null;


    /* =====================================================
       GET SELECTED
    ====================================================== */

    function getCheckedNotifications() {

        return document.querySelectorAll(
            '.notification-check:checked'
        );

    }


    /* =====================================================
       UPDATE SELECTION
    ====================================================== */

    function updateSelectionState() {

        const checked =
            getCheckedNotifications();

        const count =
            checked.length;


        /*
        |--------------------------------------------------------------------------
        | Selected counter
        |--------------------------------------------------------------------------
        */

        selectedCount.textContent =
            `(${count})`;


        /*
        |--------------------------------------------------------------------------
        | Delete button
        |--------------------------------------------------------------------------
        */

        bulkDeleteBtn.style.display =
            count > 0
                ? 'inline-flex'
                : 'none';


        /*
        |--------------------------------------------------------------------------
        | Select all state
        |--------------------------------------------------------------------------
        */

        if (checks.length === 0) {

            selectAll.checked = false;

            selectAll.indeterminate = false;

            return;

        }


        if (count === 0) {

            selectAll.checked = false;

            selectAll.indeterminate = false;

        }
        else if (count === checks.length) {

            selectAll.checked = true;

            selectAll.indeterminate = false;

        }
        else {

            selectAll.checked = false;

            selectAll.indeterminate = true;

        }

    }


    /* =====================================================
       SELECT ALL
    ====================================================== */

    if (selectAll) {

        selectAll.addEventListener(
            'change',
            function () {

                checks.forEach(
                    function (checkbox) {

                        checkbox.checked =
                            selectAll.checked;

                    }
                );

                selectAll.indeterminate =
                    false;

                updateSelectionState();

            }
        );

    }


    /* =====================================================
       INDIVIDUAL CHECKBOX
    ====================================================== */

    checks.forEach(
        function (checkbox) {

            checkbox.addEventListener(
                'change',
                function () {

                    updateSelectionState();

                }
            );

        }
    );


    /* =====================================================
       OPEN SINGLE DELETE
    ====================================================== */

    function openSingleModal(url) {

        if (!url) {

            return;

        }


        deleteUrl = url;

        lastFocusedElement =
            document.activeElement;


        singleModal.classList.add(
            'is-open'
        );

        singleModal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.style.overflow =
            'hidden';


        setTimeout(
            function () {

                singleConfirmBtn.focus();

            },
            50
        );

    }


    /* =====================================================
       CLOSE SINGLE DELETE
    ====================================================== */

    function closeSingleModal() {

        singleModal.classList.remove(
            'is-open'
        );

        singleModal.setAttribute(
            'aria-hidden',
            'true'
        );


        document.body.style.overflow =
            '';


        deleteUrl = '';


        if (
            lastFocusedElement &&
            typeof lastFocusedElement.focus ===
                'function'
        ) {

            lastFocusedElement.focus();

        }

    }


    /* =====================================================
       SINGLE DELETE BUTTONS
    ====================================================== */

    document
        .querySelectorAll(
            '.single-delete-btn'
        )
        .forEach(
            function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        openSingleModal(
                            button.dataset.deleteUrl
                        );

                    }
                );

            }
        );


    /* =====================================================
       CONFIRM SINGLE DELETE
    ====================================================== */

    singleConfirmBtn.addEventListener(
        'click',
        function () {

            if (!deleteUrl) {

                return;

            }


            singleDeleteForm.action =
                deleteUrl;


            singleConfirmBtn.disabled =
                true;


            singleConfirmBtn.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Deleting...';


            singleDeleteForm.submit();

        }
    );


    /* =====================================================
       CANCEL SINGLE DELETE
    ====================================================== */

    singleCancelBtn.addEventListener(
        'click',
        function () {

            closeSingleModal();

        }
    );


    /* =====================================================
       OPEN BULK DELETE
    ====================================================== */

    function openBulkModal() {

        const checked =
            getCheckedNotifications();

        const count =
            checked.length;


        if (count === 0) {

            return;

        }


        lastFocusedElement =
            document.activeElement;


        bulkModalMessage.textContent =
            `Are you sure you want to delete ${count} selected notification${count !== 1 ? 's' : ''}? This action cannot be undone.`;


        bulkModal.classList.add(
            'is-open'
        );

        bulkModal.setAttribute(
            'aria-hidden',
            'false'
        );


        document.body.style.overflow =
            'hidden';


        setTimeout(
            function () {

                bulkConfirmBtn.focus();

            },
            50
        );

    }


    /* =====================================================
       CLOSE BULK DELETE
    ====================================================== */

    function closeBulkModal() {

        bulkModal.classList.remove(
            'is-open'
        );

        bulkModal.setAttribute(
            'aria-hidden',
            'true'
        );


        document.body.style.overflow =
            '';


        if (
            lastFocusedElement &&
            typeof lastFocusedElement.focus ===
                'function'
        ) {

            lastFocusedElement.focus();

        }

    }


    /* =====================================================
       BULK DELETE BUTTON
    ====================================================== */

    bulkDeleteBtn.addEventListener(
        'click',
        function () {

            openBulkModal();

        }
    );


    /* =====================================================
       CANCEL BULK DELETE
    ====================================================== */

    bulkCancelBtn.addEventListener(
        'click',
        function () {

            closeBulkModal();

        }
    );


    /* =====================================================
       CONFIRM BULK DELETE
    ====================================================== */

    bulkConfirmBtn.addEventListener(
        'click',
        function () {

            const checked =
                getCheckedNotifications();


            if (checked.length === 0) {

                closeBulkModal();

                return;

            }


            bulkConfirmBtn.disabled =
                true;


            bulkConfirmBtn.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Deleting...';


            bulkDeleteForm.submit();

        }
    );


    /* =====================================================
       CLOSE WHEN CLICKING OUTSIDE
    ====================================================== */

    [singleModal, bulkModal]
        .forEach(
            function (modal) {

                modal.addEventListener(
                    'click',
                    function (event) {

                        if (
                            event.target !== modal
                        ) {

                            return;

                        }


                        if (
                            modal === singleModal
                        ) {

                            closeSingleModal();

                        }
                        else {

                            closeBulkModal();

                        }

                    }
                );

            }
        );


    /* =====================================================
       ESCAPE KEY
    ====================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key !== 'Escape'
            ) {

                return;

            }


            if (
                singleModal.classList.contains(
                    'is-open'
                )
            ) {

                closeSingleModal();

                return;

            }


            if (
                bulkModal.classList.contains(
                    'is-open'
                )
            ) {

                closeBulkModal();

            }

        }
    );


    /* =====================================================
       SUCCESS TOAST
    ====================================================== */

    const toast =
        document.getElementById(
            'successToast'
        );


    if (toast) {

        setTimeout(
            function () {

                toast.style.transition =
                    'opacity .4s ease, transform .4s ease';

                toast.style.opacity =
                    '0';

                toast.style.transform =
                    'translateY(-20px)';


                setTimeout(
                    function () {

                        if (toast) {

                            toast.remove();

                        }

                    },
                    450
                );

            },
            3000
        );

    }


    /* =====================================================
       INITIAL STATE
    ====================================================== */

    updateSelectionState();

});

</script>

@endonce

@endsection