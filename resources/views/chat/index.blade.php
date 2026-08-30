@php

    $isDean =
        auth()->user()->role === 'dean';

    $chatRoute =
        $isDean
            ? 'superadmin.chat'
            : 'chat.index';

@endphp

@extends(
    $isDean
        ? 'layouts.superadmin'
        : (
            auth()->user()->role === 'admin'
                ? 'layouts.admin'
                : 'layouts.cadet'
        )
)

@section('content')

@vite(['resources/css/chat/chat.css'])

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    rel="stylesheet"
>


<div class="chat-page">

    {{-- =====================================================
         SUCCESS / ERROR
    ====================================================== --}}

    @if(session('success'))

        <div class="chat-alert success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="chat-alert error">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>

    @endif


    {{-- =====================================================
         CHAT WRAPPER
    ====================================================== --}}

    <div class="chat-wrapper">


        {{-- =================================================
             SIDEBAR
        ================================================== --}}

        <aside class="users-box">


            {{-- HEADER --}}

            <div class="chat-sidebar-header">

                <div>

                    <h4>
                        Messages
                    </h4>

                    <span>
                        {{ $users->count() + $groups->count() }}
                        conversations
                    </span>

                </div>


                @if(
                    auth()->user()->role === 'admin' ||
                    auth()->user()->role === 'dean'
                )

                    <button
                        type="button"
                        class="create-group-btn"
                        onclick="openGroupModal()"
                        title="Create Group"
                    >

                        <i class="bi bi-people-fill"></i>

                        <span>
                            Create Group
                        </span>

                    </button>

                @endif

            </div>


            {{-- SEARCH --}}

            <div class="search-wrapper">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="searchUser"
                    class="search-user"
                    placeholder="Search people or groups..."
                    autocomplete="off"
                >

            </div>


            {{-- =================================================
                 DIRECT MESSAGES
            ================================================== --}}

            <div class="chat-section direct-section">


                <div class="section-title">

                    <span>
                        Direct Messages
                    </span>

                    <span class="section-count">
                        {{ $users->count() }}
                    </span>

                </div>


                <div
                    id="directList"
                    class="user-list"
                >

                    @forelse($users as $user)

                        <a
                            href="{{ route(
                                $chatRoute,
                                [
                                    'type' => 'direct',
                                    'receiver_id' => $user->id
                                ]
                            ) }}"
                            class="user-link direct-item
                                {{ $type === 'direct' && $receiverId == $user->id
                                    ? 'active-user'
                                    : ''
                                }}"
                            data-search-name="{{ strtolower($user->name) }}"
                        >


                            {{-- AVATAR --}}

                            <div class="avatar-wrapper">

                                @if($user->profile_picture)

                                    <img
                                        src="{{ asset('storage/' . $user->profile_picture) }}"
                                        class="user-avatar-img"
                                        alt="{{ $user->name }}"
                                    >

                                @else

                                    <div class="user-avatar">
                                        {{ strtoupper(
                                            substr(
                                                $user->name,
                                                0,
                                                1
                                            )
                                        ) }}
                                    </div>

                                @endif


                                {{-- STATUS --}}

                                @if(
                                    $user->is_online &&
                                    $user->last_activity &&
                                    $user->last_activity->gt(
                                        now()->subMinutes(2)
                                    )
                                )

                                    <span
                                        class="online-dot"
                                        title="Online"
                                    ></span>

                                @else

                                    <span
                                        class="offline-dot"
                                        title="Offline"
                                    ></span>

                                @endif

                            </div>


                            {{-- USER INFO --}}

                            <div class="user-info">

                                <div class="user-name">

                                    <span>
                                        {{ $user->name }}
                                    </span>


                                    @if(
                                        ($unreadMessages[$user->id] ?? 0) > 0
                                    )

                                        <span class="unread-badge">
                                            {{ $unreadMessages[$user->id] }}
                                        </span>

                                    @endif

                                </div>


                                <small class="last-message">

                                    {{
                                        $lastMessages[$user->id]
                                        ?? 'Start a conversation'
                                    }}

                                </small>

                            </div>

                        </a>

                    @empty

                        <div class="no-contacts">
                            No contacts available.
                        </div>

                    @endforelse

                </div>

            </div>


            {{-- =================================================
                 GROUP CHATS
            ================================================== --}}

            <div class="chat-section groups-section">


                <div class="section-title">

                    <span>
                        Group Chats
                    </span>

                    <span class="section-count">
                        {{ $groups->count() }}
                    </span>

                </div>


                <div
                    id="groupList"
                    class="user-list"
                >

                    @forelse($groups as $group)

                        <a
                            href="{{ route(
                                $chatRoute,
                                [
                                    'type' => 'group',
                                    'group_id' => $group->id
                                ]
                            ) }}"
                            class="user-link group-item
                                {{ $type === 'group' && $groupId == $group->id
                                    ? 'active-user'
                                    : ''
                                }}"
                            data-search-name="{{ strtolower($group->name) }}"
                        >


                            {{-- GROUP AVATAR --}}

                            <div class="avatar-wrapper">

                                @if($group->avatar)

                                    <img
                                        src="{{ asset('storage/' . $group->avatar) }}"
                                        class="user-avatar-img"
                                        alt="{{ $group->name }}"
                                    >

                                @else

                                    <div class="group-avatar">

                                        <i class="bi bi-people-fill"></i>

                                    </div>

                                @endif

                            </div>


                            {{-- GROUP INFO --}}

                            <div class="user-info">

                                <div class="user-name">

                                    <span>
                                        {{ $group->name }}
                                    </span>


                                    @if(
                                        ($groupUnreadMessages[$group->id] ?? 0) > 0
                                    )

                                        <span class="unread-badge">
                                            {{ $groupUnreadMessages[$group->id] }}
                                        </span>

                                    @endif

                                </div>


                                <small class="last-message">

                                    {{
                                        $groupLastMessages[$group->id]
                                        ?? 'No messages yet'
                                    }}

                                </small>

                            </div>

                        </a>

                    @empty

                        <div class="no-groups">

                            <i class="bi bi-people"></i>

                            <span>
                                No groups yet
                            </span>

                            @if(
                                auth()->user()->role === 'admin' ||
                                auth()->user()->role === 'dean'
                            )

                                <button
                                    type="button"
                                    onclick="openGroupModal()"
                                >
                                    Create your first group
                                </button>

                            @endif

                        </div>

                    @endforelse

                </div>

            </div>

        </aside>


        {{-- =================================================
             CHAT BOX
        ================================================== --}}

        <main class="chat-box">


            {{-- =================================================
                 CHAT HEADER
            ================================================== --}}

            @if($type === 'group' && $selectedGroup)

                <div class="chat-header">


                    <div class="chat-header-avatar">

                        @if($selectedGroup->avatar)

                            <img
                                src="{{ asset('storage/' . $selectedGroup->avatar) }}"
                                alt="{{ $selectedGroup->name }}"
                            >

                        @else

                            <div class="group-avatar large">

                                <i class="bi bi-people-fill"></i>

                            </div>

                        @endif

                    </div>


                    <div class="chat-header-info">

                        <h3>
                            {{ $selectedGroup->name }}
                        </h3>

                        <span>
                            {{ $selectedGroup->members_count }}
                            members
                        </span>

                    </div>


                    <div class="chat-header-actions">

                        @if(
                            $selectedGroup->created_by === auth()->id()
                        )

                            <button
                                type="button"
                                class="header-action-btn"
                                onclick="openMembersModal()"
                                title="Manage members"
                            >
                                <i class="bi bi-person-plus-fill"></i>
                            </button>

                            <form
                                method="POST"
                                action="{{ route(
                                    'chat.groups.delete',
                                    $selectedGroup
                                ) }}"
                                onsubmit="return confirm('Delete this group and all its messages?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="header-action-btn danger"
                                    title="Delete group"
                                >
                                    <i class="bi bi-trash3-fill"></i>
                                </button>

                            </form>

                        @else

                            <form
                                method="POST"
                                action="{{ route(
                                    'chat.groups.leave',
                                    $selectedGroup
                                ) }}"
                                onsubmit="return confirm('Leave this group?')"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="header-action-btn danger"
                                    title="Leave group"
                                >
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>

                            </form>

                        @endif

                    </div>

                </div>


            @elseif($type === 'direct' && $receiver)

                <div class="chat-header">


                    <div class="chat-header-avatar">

                        @if($receiver->profile_picture)

                            <img
                                src="{{ asset('storage/' . $receiver->profile_picture) }}"
                                alt="{{ $receiver->name }}"
                            >

                        @else

                            <div class="user-avatar large">
                                {{ strtoupper(
                                    substr(
                                        $receiver->name,
                                        0,
                                        1
                                    )
                                ) }}
                            </div>

                        @endif


                        @if(
                            $receiver->is_online &&
                            $receiver->last_activity &&
                            $receiver->last_activity->gt(
                                now()->subMinutes(2)
                            )
                        )

                            <span class="online-dot"></span>

                        @else

                            <span class="offline-dot"></span>

                        @endif

                    </div>


                    <div class="chat-header-info">

                        <h3>
                            {{ $receiver->name }}
                        </h3>

                        <span>

                            @if(
                                $receiver->is_online &&
                                $receiver->last_activity &&
                                $receiver->last_activity->gt(
                                    now()->subMinutes(2)
                                )
                            )

                                Online

                            @else

                                Offline

                            @endif

                        </span>

                    </div>

                </div>


            @else

                <div class="chat-empty-header">

                    <i class="bi bi-chat-dots-fill"></i>

                    <div>
                        <strong>Messages</strong>
                        <span>Select a conversation</span>
                    </div>

                </div>

            @endif


            {{-- =================================================
                 MESSAGES
            ================================================== --}}

            <div
                id="messages"
                class="messages"
            >

                @if(
                    ($type === 'direct' && $receiverId) ||
                    ($type === 'group' && $groupId)
                )

                    @forelse($messages as $msg)

                        <div
                            class="msg
                                {{ $msg->sender_id == auth()->id()
                                    ? 'me'
                                    : 'other'
                                }}"
                            data-message-id="{{ $msg->id }}"
                        >


                            {{-- GROUP SENDER --}}

                            @if(
                                $type === 'group' &&
                                $msg->sender_id != auth()->id()
                            )

                                <div class="group-sender">

                                    {{ $msg->sender->name ?? 'User' }}

                                </div>

                            @endif


                            {{-- MESSAGE --}}

                            @if($msg->message)

                                <div class="message-text">
                                    {{ $msg->message }}
                                </div>

                            @endif


                            {{-- FILE --}}

                            @if($msg->file)

                                @php

                                    $extension = strtolower(
                                        pathinfo(
                                            $msg->file,
                                            PATHINFO_EXTENSION
                                        )
                                    );

                                    $imageExtensions = [
                                        'jpg',
                                        'jpeg',
                                        'png',
                                        'gif',
                                        'webp',
                                        'svg',
                                    ];

                                @endphp


                                @if(
                                    in_array(
                                        $extension,
                                        $imageExtensions
                                    )
                                )

                                    <img
                                        src="{{ asset(
                                            'storage/' . $msg->file
                                        ) }}"
                                        class="chat-image"
                                        alt="Chat image"
                                        loading="lazy"
                                        onclick="openImageModal(this.src)"
                                    >

                                @else

                                    <a
                                        href="{{ asset(
                                            'storage/' . $msg->file
                                        ) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="file-link"
                                    >

                                        <i class="bi bi-paperclip"></i>

                                        Open / Download File

                                    </a>

                                @endif

                            @endif


                            {{-- TIME --}}

                            <div class="message-meta">

                                {{ $msg->created_at->format('h:i A') }}


                                @if(
                                    $msg->sender_id == auth()->id()
                                )

                                    @if($msg->is_read)

                                        <i
                                            class="bi bi-check2-all read-check"
                                            title="Read"
                                        ></i>

                                    @elseif($msg->is_delivered)

                                        <i
                                            class="bi bi-check2-all"
                                            title="Delivered"
                                        ></i>

                                    @else

                                        <i
                                            class="bi bi-check2"
                                            title="Sent"
                                        ></i>

                                    @endif

                                @endif

                            </div>

                        </div>

                    @empty

                        <div class="empty-text">

                            <i class="bi bi-chat-heart"></i>

                            <strong>
                                No messages yet
                            </strong>

                            <span>
                                Start the conversation.
                            </span>

                        </div>

                    @endforelse

                @else

                    <div class="empty-text">

                        <i class="bi bi-chat-square-text"></i>

                        <strong>
                            Select a conversation
                        </strong>

                        <span>
                            Choose a person or group from the left.
                        </span>

                    </div>

                @endif

            </div>


            {{-- =================================================
                 IMAGE MODAL
            ================================================== --}}

            <div
                id="imageModal"
                class="img-modal"
                onclick="closeImageModal()"
            >

                <button
                    type="button"
                    class="close-btn"
                    onclick="closeImageModal()"
                >
                    &times;
                </button>

                <img
                    id="modalImg"
                    class="modal-content"
                    alt="Image preview"
                    onclick="event.stopPropagation()"
                >

            </div>


            {{-- =================================================
                 MESSAGE FORM
            ================================================== --}}

            @if(
                ($type === 'direct' && $receiverId) ||
                ($type === 'group' && $groupId)
            )

                <form
                    method="POST"
                    action="{{ route('chat.send') }}"
                    class="chat-form"
                    enctype="multipart/form-data"
                >

                    @csrf


                    @if($type === 'direct')

                        <input
                            type="hidden"
                            name="receiver_id"
                            value="{{ $receiverId }}"
                        >

                    @else

                        <input
                            type="hidden"
                            name="group_id"
                            value="{{ $groupId }}"
                        >

                    @endif


                    <div class="chat-input-wrapper">


                        <label
                            for="chatFile"
                            class="file-icon"
                            title="Attach file"
                        >

                            <i class="bi bi-paperclip"></i>

                        </label>


                        <input
                            type="file"
                            id="chatFile"
                            name="file"
                            accept="image/*,.pdf,.doc,.docx"
                            hidden
                        >


                        <div
                            id="filePreview"
                            class="file-preview"
                        >

                            <i class="bi bi-paperclip"></i>

                            <span
                                id="filePreviewName"
                                class="file-preview-name"
                            ></span>

                            <button
                                type="button"
                                id="removeFile"
                                class="file-remove"
                            >
                                &times;
                            </button>

                        </div>


                        <input
                            type="text"
                            name="message"
                            class="chat-input"
                            placeholder="Type a message..."
                            autocomplete="off"
                        >

                    </div>


                    <button
                        type="submit"
                        class="send-btn"
                        title="Send message"
                    >

                        <i class="bi bi-send-fill"></i>

                    </button>

                </form>

            @endif

        </main>

    </div>

</div>


{{-- =========================================================
     CREATE GROUP MODAL
========================================================= --}}

@if(
    auth()->user()->role === 'admin' ||
    auth()->user()->role === 'dean'
)

<div
    id="groupModal"
    class="chat-modal"
>

    <div class="modal-card">


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="modal-header">

            <div>

                <h3>
                    Create New Group
                </h3>

                <span>
                    Create a batch group conversation
                </span>

            </div>


            <button
                type="button"
                onclick="closeGroupModal()"
                class="modal-close"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        {{-- =================================================
             FORM
        ================================================== --}}

        <form
            method="POST"
            action="{{ route('chat.groups.create') }}"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="modal-body">


                {{-- =================================================
                     BATCH
                ================================================== --}}

                <div class="form-field">

                    <label for="groupBatch">
                        Batch
                        <span class="required">*</span>
                    </label>


                    <select
                        name="batch_id"
                        id="groupBatch"
                        class="modal-input"
                        required
                    >

                        <option value="">
                            Select a batch
                        </option>


                        @forelse($batches as $batch)

                            <option
                                value="{{ $batch->id }}"
                                {{ old('batch_id') == $batch->id ? 'selected' : '' }}
                            >

                                {{ $batch->name ?? ('Batch ' . ($batch->batch_year ?? $batch->id)) }}

                            </option>

                        @empty

                            <option
                                value=""
                                disabled
                            >
                                No batches available
                            </option>

                        @endforelse

                    </select>


                    <small class="field-help">
                        Select the batch this group belongs to.
                    </small>

                </div>


                {{-- =================================================
                     GROUP NAME
                ================================================== --}}

                <div class="form-field">

                    <label for="groupName">
                        Group Name
                        <span class="required">*</span>
                    </label>


                    <input
                        type="text"
                        name="name"
                        id="groupName"
                        class="modal-input"
                        placeholder="e.g. Maritime 2026"
                        maxlength="100"
                        value="{{ old('name') }}"
                        required
                    >

                </div>


                {{-- =================================================
                     DESCRIPTION
                ================================================== --}}

                <div class="form-field">

                    <label for="groupDescription">
                        Description
                    </label>


                    <textarea
                        name="description"
                        id="groupDescription"
                        class="modal-input modal-textarea"
                        placeholder="Optional group description..."
                        maxlength="1000"
                    >{{ old('description') }}</textarea>

                </div>


                {{-- =================================================
                     AVATAR
                ================================================== --}}

                <div class="form-field">

                    <label for="groupAvatar">
                        Group Picture
                    </label>


                    <input
                        type="file"
                        name="avatar"
                        id="groupAvatar"
                        class="modal-file"
                        accept="image/jpeg,image/png,image/webp"
                    >

                </div>


                {{-- =================================================
                     MEMBERS
                ================================================== --}}

                <div class="member-heading">

                    <div>

                        <label>
                            Select Members
                        </label>

                        <small class="field-help">
                            Add users to this batch group.
                        </small>

                    </div>


                    <span>
                        {{ $users->count() }} available
                    </span>

                </div>


                <div class="member-list">

                    @forelse($users as $member)

                        <label
                            class="member-option"
                            for="group-member-{{ $member->id }}"
                        >

                            <input
                                type="checkbox"
                                id="group-member-{{ $member->id }}"
                                name="members[]"
                                value="{{ $member->id }}"
                                {{ in_array(
                                    $member->id,
                                    old('members', [])
                                ) ? 'checked' : '' }}
                            >


                            {{-- AVATAR --}}

                            <div class="member-avatar">

                                @if($member->profile_picture)

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $member->profile_picture
                                        ) }}"
                                        alt="{{ $member->name }}"
                                    >

                                @else

                                    {{ strtoupper(
                                        substr(
                                            $member->name,
                                            0,
                                            1
                                        )
                                    ) }}

                                @endif

                            </div>


                            {{-- INFO --}}

                            <div class="member-info">

                                <strong>
                                    {{ $member->name }}
                                </strong>

                                <span>
                                    {{ ucfirst($member->role) }}
                                </span>

                            </div>


                            <i class="bi bi-check-circle-fill"></i>

                        </label>

                    @empty

                        <div class="no-members">

                            <i class="bi bi-people"></i>

                            <span>
                                No available members.
                            </span>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}

            <div class="modal-footer">

                <button
                    type="button"
                    class="modal-btn secondary"
                    onclick="closeGroupModal()"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="modal-btn primary"
                    {{ $batches->isEmpty() ? 'disabled' : '' }}
                >

                    <i class="bi bi-people-fill"></i>

                    Create Group

                </button>

            </div>

        </form>

    </div>

</div>

@endif


{{-- =========================================================
     GROUP MEMBERS MODAL
========================================================= --}}

@if(
    $selectedGroup &&
    $selectedGroup->created_by === auth()->id()
)

<div
    id="membersModal"
    class="chat-modal"
>

    <div class="modal-card">


        <div class="modal-header">

            <div>

                <h3>
                    Group Members
                </h3>

                <span>
                    {{ $selectedGroup->members_count }}
                    members
                </span>

            </div>

            <button
                type="button"
                onclick="closeMembersModal()"
                class="modal-close"
            >
                &times;
            </button>

        </div>


        <div class="modal-body">


            <div class="member-list">

                @foreach($selectedGroup->members as $member)

                    <div class="member-option existing">


                        <div class="member-avatar">

                            @if($member->user?->profile_picture)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $member->user->profile_picture
                                    ) }}"
                                    alt="{{ $member->user->name }}"
                                >

                            @else

                                {{
                                    strtoupper(
                                        substr(
                                            $member->user->name ?? 'U',
                                            0,
                                            1
                                        )
                                    )
                                }}

                            @endif

                        </div>


                        <div class="member-info">

                            <strong>
                                {{ $member->user->name ?? 'User' }}
                            </strong>

                            <span>
                                {{ ucfirst($member->role) }}
                            </span>

                        </div>


                        @if(
                            $member->user_id !==
                            $selectedGroup->created_by
                        )

                            <form
                                method="POST"
                                action="{{ route(
                                    'chat.groups.members.remove',
                                    [
                                        'group' =>
                                            $selectedGroup->id,
                                        'member' =>
                                            $member->user_id,
                                    ]
                                ) }}"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="remove-member-btn"
                                    title="Remove member"
                                >
                                    <i class="bi bi-person-x-fill"></i>
                                </button>

                            </form>

                        @else

                            <span class="creator-badge">
                                Creator
                            </span>

                        @endif

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endif


<script>

/*
|--------------------------------------------------------------------------
| IMAGE MODAL
|--------------------------------------------------------------------------
*/

function openImageModal(src)
{
    const modal =
        document.getElementById('imageModal');

    const image =
        document.getElementById('modalImg');

    if (!modal || !image) {
        return;
    }

    image.src = src;

    modal.classList.add('show');

    document.body.style.overflow = 'hidden';
}


function closeImageModal()
{
    const modal =
        document.getElementById('imageModal');

    const image =
        document.getElementById('modalImg');

    if (!modal || !image) {
        return;
    }

    modal.classList.remove('show');

    image.src = '';

    document.body.style.overflow = '';
}


/*
|--------------------------------------------------------------------------
| GROUP MODAL
|--------------------------------------------------------------------------
*/

function openGroupModal()
{
    const modal =
        document.getElementById('groupModal');

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    document.body.style.overflow = 'hidden';
}


function closeGroupModal()
{
    const modal =
        document.getElementById('groupModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    document.body.style.overflow = '';
}


/*
|--------------------------------------------------------------------------
| MEMBERS MODAL
|--------------------------------------------------------------------------
*/

function openMembersModal()
{
    const modal =
        document.getElementById('membersModal');

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    document.body.style.overflow = 'hidden';
}


function closeMembersModal()
{
    const modal =
        document.getElementById('membersModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    document.body.style.overflow = '';
}


/*
|--------------------------------------------------------------------------
| ESCAPE
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'keydown',
    function(event)
    {
        if (event.key === 'Escape') {

            closeImageModal();

            closeGroupModal();

            closeMembersModal();
        }
    }
);


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

const searchInput =
    document.getElementById('searchUser');


if (searchInput) {

    searchInput.addEventListener(
        'input',
        function()
        {
            const value =
                this.value
                    .trim()
                    .toLowerCase();


            document
                .querySelectorAll(
                    '.direct-item, .group-item'
                )
                .forEach(function(item)
                {
                    const name =
                        item.dataset.searchName
                        || '';

                    item.style.display =
                        name.includes(value)
                            ? 'flex'
                            : 'none';
                });
        }
    );
}


/*
|--------------------------------------------------------------------------
| SCROLL
|--------------------------------------------------------------------------
*/

const messagesBox =
    document.getElementById('messages');


function scrollToBottom()
{
    if (!messagesBox) {
        return;
    }

    messagesBox.scrollTop =
        messagesBox.scrollHeight;
}


scrollToBottom();


/*
|--------------------------------------------------------------------------
| FILE PREVIEW
|--------------------------------------------------------------------------
*/

const chatFile =
    document.getElementById('chatFile');

const filePreview =
    document.getElementById('filePreview');

const filePreviewName =
    document.getElementById('filePreviewName');

const removeFile =
    document.getElementById('removeFile');


if (chatFile) {

    chatFile.addEventListener(
        'change',
        function()
        {
            const file =
                this.files[0];


            if (!file) {

                clearFile();

                return;
            }


            if (filePreviewName) {

                filePreviewName.textContent =
                    file.name;
            }


            if (filePreview) {

                filePreview.classList.add(
                    'show'
                );
            }
        }
    );
}


if (removeFile) {

    removeFile.addEventListener(
        'click',
        function()
        {
            clearFile();
        }
    );
}


function clearFile()
{
    if (chatFile) {

        chatFile.value = '';
    }


    if (filePreviewName) {

        filePreviewName.textContent = '';
    }


    if (filePreview) {

        filePreview.classList.remove(
            'show'
        );
    }
}


/*
|--------------------------------------------------------------------------
| REAL-TIME MESSAGE
|--------------------------------------------------------------------------
*/

window.addEventListener(
    'chat-message',
    function(event)
    {
        const message =
            event.detail;


        if (!message) {
            return;
        }


        const currentUser =
            Number(
                @json(auth()->id())
            );


        const currentReceiver =
            Number(
                @json($receiverId ?? 0)
            );


        const currentGroup =
            Number(
                @json($groupId ?? 0)
            );


        /*
        |--------------------------------------------------------------------------
        | GROUP MESSAGE
        |--------------------------------------------------------------------------
        */

        if (message.chat_group_id) {

            if (
                Number(
                    message.chat_group_id
                ) !== currentGroup
            ) {
                return;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT MESSAGE
        |--------------------------------------------------------------------------
        */

        else {

            if (
                Number(message.sender_id) !==
                    currentReceiver
                &&
                Number(message.receiver_id) !==
                    currentReceiver
            ) {

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DUPLICATE
        |--------------------------------------------------------------------------
        */

        if (
            message.id &&
            document.querySelector(
                `[data-message-id="${message.id}"]`
            )
        ) {

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | BUBBLE
        |--------------------------------------------------------------------------
        */

        const element =
            document.createElement('div');


        const isMine =
            Number(message.sender_id) ===
            currentUser;


        element.className =
            `msg ${isMine ? 'me' : 'other'}`;


        if (message.id) {

            element.dataset.messageId =
                message.id;
        }


        /*
        |--------------------------------------------------------------------------
        | GROUP SENDER
        |--------------------------------------------------------------------------
        */

        if (
            message.chat_group_id &&
            !isMine
        ) {

            const sender =
                document.createElement('div');

            sender.className =
                'group-sender';

            sender.textContent =
                message.sender?.name
                || 'User';

            element.appendChild(
                sender
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TEXT
        |--------------------------------------------------------------------------
        */

        if (message.message) {

            const text =
                document.createElement('div');

            text.className =
                'message-text';

            text.textContent =
                message.message;

            element.appendChild(
                text
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILE
        |--------------------------------------------------------------------------
        */

        if (message.file) {

            const extension =
                message.file
                    .split('.')
                    .pop()
                    .toLowerCase();


            const imageExtensions = [
                'jpg',
                'jpeg',
                'png',
                'gif',
                'webp',
                'svg'
            ];


            const fileUrl =
                `/storage/${message.file}`;


            if (
                imageExtensions.includes(
                    extension
                )
            ) {

                const image =
                    document.createElement('img');

                image.src =
                    fileUrl;

                image.className =
                    'chat-image';

                image.alt =
                    'Chat image';

                image.loading =
                    'lazy';

                image.onclick =
                    function()
                    {
                        openImageModal(
                            this.src
                        );
                    };

                element.appendChild(
                    image
                );

            } else {

                const link =
                    document.createElement('a');

                link.href =
                    fileUrl;

                link.target =
                    '_blank';

                link.rel =
                    'noopener noreferrer';

                link.className =
                    'file-link';

                link.innerHTML =
                    '<i class="bi bi-paperclip"></i> Open / Download File';

                element.appendChild(
                    link
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | META
        |--------------------------------------------------------------------------
        */

        const meta =
            document.createElement('div');

        meta.className =
            'message-meta';

        const now =
            new Date();

        meta.textContent =
            now.toLocaleTimeString(
                [],
                {
                    hour: '2-digit',
                    minute: '2-digit'
                }
            );


        element.appendChild(
            meta
        );


        if (messagesBox) {

            messagesBox.appendChild(
                element
            );

            scrollToBottom();
        }
    }
);
</script>

<script>

(function () {

    function sendHeartbeat()
    {
        fetch('{{ route('user.heartbeat') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}',

                'Accept':
                    'application/json',

                'Content-Type':
                    'application/json'
            },

            body: JSON.stringify({})
        })
        .catch(function (error) {

            console.warn(
                'Heartbeat failed:',
                error
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | IMMEDIATELY MARK ONLINE
    |--------------------------------------------------------------------------
    */

    sendHeartbeat();


    /*
    |--------------------------------------------------------------------------
    | EVERY 30 SECONDS
    |--------------------------------------------------------------------------
    */

    setInterval(
        sendHeartbeat,
        30000
    );

})();

</script>

@endsection