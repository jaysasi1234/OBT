@extends('layouts.cadet')

@section('content')

<style>
/* =========================================================
   NOTIFICATION PAGE
========================================================= */

.notification-page {
    background: #0f1f3d;
    padding: 25px;
    border-radius: 18px;
    min-height: 70vh;
    color: #fff;
}

/* =========================================================
   HEADER
========================================================= */

.notification-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 25px;
}

.notification-header h2 {
    margin: 0;
    color: #fff;
    font-size: 26px;
    font-weight: 700;
}

.notification-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* =========================================================
   BUTTONS
========================================================= */

.btn-action {
    border: none;
    padding: 9px 15px;
    border-radius: 10px;
    cursor: pointer;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    transition: .2s ease;
}

.btn-action:hover {
    transform: translateY(-1px);
}

.btn-read {
    background: #2563eb;
}

.btn-read:hover {
    background: #1d4ed8;
}

.btn-delete {
    background: #ef4444;
}

.btn-delete:hover {
    background: #dc2626;
}

/* =========================================================
   SELECT ALL
========================================================= */

.select-area {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    margin-bottom: 15px;
    font-size: 13px;
}

.select-area input {
    width: 17px;
    height: 17px;
    cursor: pointer;
}

/* =========================================================
   NOTIFICATION CARD
========================================================= */

.notification-card {
    display: flex;
    align-items: flex-start;
    gap: 15px;

    background: #162b52;

    padding: 18px;

    border-radius: 15px;

    margin-bottom: 15px;

    color: #fff;

    transition:
        background .2s ease,
        transform .2s ease,
        border-color .2s ease;

    border: 1px solid transparent;
}

.notification-card:hover {
    background: #1b3566;
    transform: translateY(-1px);
}

.notification-card.unread {
    border-left: 4px solid #3b82f6;
    background: #1d3b72;
}

/* =========================================================
   CHECKBOX
========================================================= */

.notification-checkbox {
    width: 18px;
    height: 18px;
    margin-top: 4px;
    flex-shrink: 0;
    cursor: pointer;
}

/* =========================================================
   CLICKABLE CONTENT
========================================================= */

.notification-link {
    display: block;
    flex: 1;
    min-width: 0;

    color: inherit;
    text-decoration: none;
    cursor: pointer;
}

.notification-link:hover {
    color: inherit;
}

/* =========================================================
   CONTENT
========================================================= */

.notification-content {
    min-width: 0;
}

.notification-title {
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.4;
}

.notification-message {
    color: #cbd5e1;
    margin-top: 5px;
    font-size: 13px;
    line-height: 1.5;
}

.notification-time {
    color: #94a3b8;
    font-size: 12px;
    margin-top: 8px;
}

/* =========================================================
   NEW BADGE
========================================================= */

.new-badge {
    display: inline-block;
    margin-top: 8px;

    background: #ef4444;

    padding: 3px 8px;

    border-radius: 10px;

    font-size: 10px;
    font-weight: 700;
    color: #fff;
}

/* =========================================================
   DELETE SINGLE
========================================================= */

.delete-single {
    width: 36px;
    height: 36px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: rgba(239, 68, 68, .08);

    border: none;
    border-radius: 9px;

    color: #ef4444;

    cursor: pointer;

    flex-shrink: 0;

    transition: .2s ease;
}

.delete-single:hover {
    background: rgba(239, 68, 68, .18);
    color: #f87171;
}

/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {
    text-align: center;
    color: #94a3b8;
    padding: 70px 20px;
}

.empty-state h3 {
    margin-bottom: 8px;
    color: #fff;
}

.empty-state p {
    margin: 0;
}

/* =========================================================
   DELETE MODAL
========================================================= */

.modal-overlay {
    position: fixed;
    inset: 0;

    background: rgba(0, 0, 0, .65);

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    z-index: 9999;
}

.delete-modal {
    width: 350px;
    max-width: 100%;

    background: #10203e;

    padding: 25px;

    border-radius: 18px;

    color: #fff;

    text-align: center;

    box-shadow: 0 20px 50px rgba(0, 0, 0, .5);
}

.delete-modal h3 {
    margin: 0 0 15px;
}

.delete-modal p {
    margin: 0;
    color: #cbd5e1;
    line-height: 1.5;
}

.modal-buttons {
    margin-top: 25px;

    display: flex;
    justify-content: center;

    gap: 15px;
}

.cancel-btn,
.confirm-btn {
    padding: 10px 20px;

    border: none;
    border-radius: 10px;

    cursor: pointer;

    color: #fff;
    font-weight: 600;
}

.cancel-btn {
    background: #475569;
}

.cancel-btn:hover {
    background: #334155;
}

.confirm-btn {
    background: #ef4444;
}

.confirm-btn:hover {
    background: #dc2626;
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 700px) {

    .notification-page {
        padding: 16px;
        border-radius: 14px;
    }

    .notification-header {
        flex-direction: column;
        align-items: stretch;
    }

    .notification-header h2 {
        font-size: 21px;
    }

    .notification-actions {
        width: 100%;
    }

    .notification-actions .btn-action {
        flex: 1;
    }

    .notification-card {
        padding: 14px;
        gap: 10px;
    }

    .notification-title {
        font-size: 14px;
    }

    .notification-message {
        font-size: 12px;
    }
}
</style>


<div class="notification-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="notification-header">

        <h2>
            🔔 Notifications
        </h2>

        <div class="notification-actions">

            <button
                type="button"
                class="btn-action btn-read"
                onclick="markAllRead()"
            >
                ✓ Mark All Read
            </button>

            <button
                type="button"
                id="deleteSelectedBtn"
                class="btn-action btn-delete"
                style="display:none;"
                onclick="openDeleteModal()"
            >
                🗑 Delete Selected
                (<span id="selectedCount">0</span>)
            </button>

        </div>

    </div>


    {{-- =====================================================
         DELETE FORM
    ====================================================== --}}

    <form
        method="POST"
        id="deleteForm"
        action="{{ route('cadet.notifications.deleteSelected') }}"
    >

        @csrf
        @method('DELETE')


        {{-- =================================================
             SELECT ALL
        ================================================== --}}

        @if($notifications->count())

            <div class="select-area">

                <input
                    type="checkbox"
                    id="selectAll"
                    onchange="toggleSelectAll()"
                >

                <label for="selectAll">
                    Select All
                </label>

            </div>

        @endif


        {{-- =================================================
             NOTIFICATIONS
        ================================================== --}}

        @forelse($notifications as $note)

            @php
                $data = $note->data ?? [];

                $title = $data['title']
                    ?? 'System Notification';

                $message = $data['message']
                    ?? $data['body']
                    ?? 'You have a new notification.';
            @endphp


            <div
                class="notification-card {{ is_null($note->read_at) ? 'unread' : '' }}"
                data-notification-id="{{ $note->id }}"
            >

                {{-- CHECKBOX --}}

                <input
                    type="checkbox"
                    class="notification-checkbox"
                    name="notifications[]"
                    value="{{ $note->id }}"
                    onclick="event.stopPropagation(); updateDeleteButton();"
                >


                {{-- CLICKABLE NOTIFICATION --}}

                <a
                    href="{{ route('notifications.open', $note->id) }}"
                    class="notification-link"
                >

                    <div class="notification-content">

                        <div class="notification-title">
                            {{ $title }}
                        </div>

                        <div class="notification-message">
                            {{ $message }}
                        </div>

                        <div class="notification-time">
                            {{ $note->created_at?->diffForHumans() }}
                        </div>


                        @if(is_null($note->read_at))

                            <span class="new-badge">
                                NEW
                            </span>

                        @endif

                    </div>

                </a>


                {{-- DELETE --}}

                <button
                    type="button"
                    class="delete-single"
                    title="Delete notification"
                    onclick="event.stopPropagation(); deleteNotification('{{ $note->id }}')"
                >
                    🗑
                </button>

            </div>

        @empty

            <div class="empty-state">

                <h3>
                    No Notifications
                </h3>

                <p>
                    You don't have any notifications yet.
                </p>

            </div>

        @endforelse

    </form>


    {{-- =====================================================
         DELETE MODAL
    ====================================================== --}}

    <div
        id="deleteModal"
        class="modal-overlay"
    >

        <div class="delete-modal">

            <h3>
                🗑 Delete Notifications
            </h3>

            <p>
                Are you sure you want to delete the selected
                notifications?
            </p>

            <div class="modal-buttons">

                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeDeleteModal()"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="confirm-btn"
                    onclick="submitDelete()"
                >
                    Delete
                </button>

            </div>

        </div>

    </div>

</div>


<script>
/* =========================================================
   VARIABLES
========================================================= */

let deleteId = null;
let deleteMode = null;


/* =========================================================
   SELECT ALL
========================================================= */

function toggleSelectAll()
{
    const selectAll = document.getElementById('selectAll');

    const checkboxes = document.querySelectorAll(
        '.notification-checkbox'
    );

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = selectAll.checked;
    });

    updateDeleteButton();
}


/* =========================================================
   UPDATE DELETE BUTTON
========================================================= */

function updateDeleteButton()
{
    const selected = document.querySelectorAll(
        '.notification-checkbox:checked'
    );

    const button = document.getElementById(
        'deleteSelectedBtn'
    );

    const count = document.getElementById(
        'selectedCount'
    );

    if (!button || !count) {
        return;
    }

    count.textContent = selected.length;

    button.style.display =
        selected.length > 0
            ? 'block'
            : 'none';

    /*
     * Update Select All state.
     */

    const all = document.querySelectorAll(
        '.notification-checkbox'
    );

    const selectAll = document.getElementById(
        'selectAll'
    );

    if (selectAll && all.length) {

        selectAll.checked =
            selected.length === all.length;

        selectAll.indeterminate =
            selected.length > 0 &&
            selected.length < all.length;
    }
}


/* =========================================================
   MARK ALL READ
========================================================= */

function markAllRead()
{
    fetch(
        "{{ route('cadet.notifications.readAll') }}",
        {
            method: "POST",

            headers: {
                "X-CSRF-TOKEN":
                    "{{ csrf_token() }}",

                "Accept":
                    "application/json"
            }
        }
    )
    .then(function (response) {

        if (!response.ok) {
            throw new Error(
                'Failed to mark notifications as read.'
            );
        }

        return response.json();
    })
    .then(function () {

        window.location.reload();

    })
    .catch(function (error) {

        console.error(error);

        alert(
            'Unable to mark notifications as read.'
        );

    });
}


/* =========================================================
   DELETE SINGLE
========================================================= */

function deleteNotification(id)
{
    deleteId = id;
    deleteMode = 'single';

    openDeleteModal();
}


/* =========================================================
   DELETE SELECTED
========================================================= */

function openDeleteModal()
{
    const modal =
        document.getElementById('deleteModal');

    if (!modal) {
        return;
    }

    modal.style.display = 'flex';
}


/* =========================================================
   CLOSE DELETE MODAL
========================================================= */

function closeDeleteModal()
{
    const modal =
        document.getElementById('deleteModal');

    if (!modal) {
        return;
    }

    modal.style.display = 'none';
}


/* =========================================================
   SUBMIT DELETE
========================================================= */

function submitDelete()
{
    /*
     * SINGLE NOTIFICATION
     */

    if (
        deleteMode === 'single' &&
        deleteId
    ) {

        fetch(
            `/cadet/notifications/delete/${deleteId}`,
            {
                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN':
                        "{{ csrf_token() }}",

                    'Accept':
                        'application/json',

                    'Content-Type':
                        'application/json'
                },

                body: JSON.stringify({
                    _method: 'DELETE'
                })
            }
        )
        .then(function (response) {

            if (!response.ok) {
                throw new Error(
                    'Failed to delete notification.'
                );
            }

            return response.json();
        })
        .then(function () {

            window.location.reload();

        })
        .catch(function (error) {

            console.error(error);

            alert(
                'Unable to delete notification.'
            );

        });

        return;
    }


    /*
     * MULTIPLE NOTIFICATIONS
     */

    if (deleteMode === 'multiple') {

        const selected =
            document.querySelectorAll(
                '.notification-checkbox:checked'
            );

        if (!selected.length) {
            closeDeleteModal();
            return;
        }

        document
            .getElementById('deleteForm')
            .submit();
    }
}


/* =========================================================
   MODAL BACKDROP CLICK
========================================================= */

document.addEventListener(
    'click',
    function (event) {

        const modal =
            document.getElementById(
                'deleteModal'
            );

        if (
            modal &&
            event.target === modal
        ) {
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

        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    }
);


/* =========================================================
   DELETE SELECTED BUTTON
========================================================= */

document
    .getElementById('deleteSelectedBtn')
    ?.addEventListener(
        'click',
        function () {

            const selected =
                document.querySelectorAll(
                    '.notification-checkbox:checked'
                );

            if (!selected.length) {
                return;
            }

            deleteId = null;
            deleteMode = 'multiple';

            openDeleteModal();
        }
    );


/* =========================================================
   INITIAL STATE
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {
        updateDeleteButton();
    }
);
</script>

@endsection