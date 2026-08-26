@extends('layouts.superadmin')

@section('content')

@if(session('success'))
    <div id="success-notification" class="success-notification">
        <span class="success-icon">✓</span>

        <div>
            <strong>Success</strong>
            <p>{{ session('success') }}</p>
        </div>

        <button type="button" onclick="closeSuccessNotification()">
            ×
        </button>
    </div>
@endif

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {
    --profile-bg: #0b0b2d;
    --profile-card: #221d70;
    --profile-card-light: #2c267f;
    --profile-border: rgba(255, 255, 255, 0.12);

    --profile-text: #ffffff;
    --profile-muted: #94a3b8;

    --profile-primary: #3b82f6;
    --profile-primary-dark: #2563eb;

    --profile-success: #22c55e;
    --profile-danger: #ef4444;

    --profile-radius: 18px;
}

/* =========================================================
   SUCCESS NOTIFICATION
========================================================= */

.success-notification {
    position: fixed;
    top: 25px;
    right: 25px;

    z-index: 100000;

    display: flex;
    align-items: center;

    gap: 12px;

    min-width: 300px;
    max-width: 420px;

    padding: 15px 18px;

    background: #132c7a;

    border: 1px solid rgba(34, 197, 94, 0.4);
    border-left: 5px solid #22c55e;

    border-radius: 12px;

    color: white;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.4);

    animation:
        successSlideIn 0.35s ease;
}

.success-icon {
    width: 34px;
    height: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border-radius: 50%;

    background: rgba(34, 197, 94, 0.15);

    color: #4ade80;

    font-size: 20px;
    font-weight: bold;
}

.success-notification strong {
    display: block;

    margin-bottom: 2px;

    color: #4ade80;

    font-size: 14px;
}

.success-notification p {
    margin: 0;

    color: #e2e8f0;

    font-size: 13px;
}

.success-notification button {
    margin-left: auto;

    width: 28px;
    height: 28px;

    border: none;
    border-radius: 7px;

    background: transparent;

    color: #94a3b8;

    font-size: 20px;

    cursor: pointer;

    transition: 0.2s;
}

.success-notification button:hover {
    background: rgba(255,255,255,0.1);

    color: white;
}

@keyframes successSlideIn {

    from {
        opacity: 0;
        transform: translateX(30px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }

}

@keyframes successSlideOut {

    from {
        opacity: 1;
        transform: translateX(0);
    }

    to {
        opacity: 0;
        transform: translateX(30px);
    }

}

@media(max-width:480px) {

    .success-notification {
        top: 15px;
        right: 15px;
        left: 15px;

        min-width: auto;
        max-width: none;
    }

}


/* =========================================================
   PAGE
========================================================= */

.profile-container {
    width: 100%;
    color: var(--profile-text);
}


/* =========================================================
   MAIN PROFILE CARD
========================================================= */

.profile-card {
    width: 100%;
    overflow: hidden;

    background: var(--profile-card);

    border: 1px solid var(--profile-border);
    border-radius: 20px;

    box-shadow:
        0 15px 40px rgba(0, 0, 0, 0.25);
}


/* =========================================================
   PROFILE HEADER
========================================================= */

.profile-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    padding: 22px 30px;

    border-bottom:
        1px solid var(--profile-border);
}

.profile-header-content h2 {
    margin: 0;

    color: var(--profile-text);

    font-size: 28px;
    font-weight: 700;
}

.profile-header-content p {
    margin: 5px 0 0;

    color: var(--profile-muted);

    font-size: 13px;
}


/* =========================================================
   EDIT PROFILE BUTTON
========================================================= */

.edit-profile-btn {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 10px 17px;

    border: none;
    border-radius: 10px;

    background:
        linear-gradient(
            135deg,
            var(--profile-primary),
            var(--profile-primary-dark)
        );

    color: #fff;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.edit-profile-btn:hover {
    transform: translateY(-2px);

    box-shadow:
        0 8px 20px rgba(59, 130, 246, 0.3);
}


/* =========================================================
   PROFILE BODY
========================================================= */

.profile-body {
    display: flex;

    min-width: 0;
}


/* =========================================================
   LEFT PROFILE
========================================================= */

.profile-left {
    width: 320px;

    flex-shrink: 0;

    padding: 30px;

    border-right:
        1px solid var(--profile-border);

    box-sizing: border-box;
}


/* =========================================================
   PROFILE AVATAR
========================================================= */

.profile-avatar {
    width: 170px;
    height: 170px;

    margin: 0 auto;

    overflow: hidden;

    border:
        5px solid rgba(255, 255, 255, 0.15);

    border-radius: 50%;

    background:
        var(--profile-card-light);

    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.3);
}

.profile-avatar img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;
}


/* =========================================================
   PROFILE NAME
========================================================= */

.profile-name {
    margin-top: 20px;

    text-align: center;
}

.profile-name h3 {
    margin: 0;

    color: var(--profile-text);

    font-size: 21px;
    font-weight: 700;

    word-break: break-word;
}

.profile-role {
    margin-top: 6px;

    color: var(--profile-muted);

    font-size: 13px;
}


/* =========================================================
   STATUS
========================================================= */

.status-badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 6px;

    margin-top: 14px;

    padding: 7px 16px;

    border-radius: 30px;

    background:
        rgba(34, 197, 94, 0.15);

    border:
        1px solid rgba(34, 197, 94, 0.3);

    color: #4ade80;

    font-size: 12px;
    font-weight: 700;
}

.status-dot {
    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #22c55e;
}


/* =========================================================
   LEFT PROFILE INFORMATION
========================================================= */

.profile-info {
    margin-top: 28px;
}

.profile-info-item {
    margin-bottom: 18px;
}

.profile-info-item:last-child {
    margin-bottom: 0;
}

.profile-info-label {
    margin-bottom: 4px;

    color: var(--profile-muted);

    font-size: 11px;
    font-weight: 600;

    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.profile-info-value {
    color: var(--profile-text);

    font-size: 14px;

    word-break: break-word;
}


/* =========================================================
   RIGHT PROFILE
========================================================= */

.profile-right {
    flex: 1;

    min-width: 0;

    padding: 30px;
}


/* =========================================================
   SECTION TITLE
========================================================= */

.section-heading {
    margin-bottom: 20px;
}

.section-title {
    margin: 0;

    color: var(--profile-text);

    font-size: 20px;
    font-weight: 700;
}

.section-subtitle {
    margin: 5px 0 0;

    color: var(--profile-muted);

    font-size: 13px;
}


/* =========================================================
   INFORMATION GRID
========================================================= */

.info-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 15px;
}

.info-box {
    padding: 17px;

    background:
        var(--profile-card-light);

    border:
        1px solid rgba(255, 255, 255, 0.06);

    border-radius: 13px;

    transition:
        border-color 0.2s ease,
        transform 0.2s ease;
}

.info-box:hover {
    border-color:
        rgba(59, 130, 246, 0.35);

    transform: translateY(-2px);
}

.info-box label {
    display: block;

    margin-bottom: 7px;

    color: var(--profile-muted);

    font-size: 11px;
    font-weight: 600;

    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-box p {
    margin: 0;

    color: var(--profile-text);

    font-size: 15px;
    font-weight: 600;

    word-break: break-word;
}


/* =========================================================
   ACCOUNT ACTIVITY
========================================================= */

.activity-card {
    margin-top: 25px;

    padding: 20px;

    background:
        var(--profile-card-light);

    border:
        1px solid rgba(255, 255, 255, 0.06);

    border-radius: 15px;
}

.activity-card h4 {
    margin: 0 0 15px;

    color: var(--profile-text);

    font-size: 16px;
}

.activity-item {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    padding: 12px 0;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.08);
}

.activity-item:first-of-type {
    padding-top: 0;
}

.activity-item:last-child {
    padding-bottom: 0;

    border-bottom: none;
}

.activity-label {
    color: var(--profile-muted);

    font-size: 13px;
}

.activity-value {
    color: var(--profile-text);

    font-size: 13px;
    font-weight: 600;

    text-align: right;
}


/* =========================================================
   MODAL OVERLAY
========================================================= */

.profile-modal {
    position: fixed;

    inset: 0;

    z-index: 99999;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background:
        rgba(0, 0, 0, 0.78);

    backdrop-filter: blur(5px);

    box-sizing: border-box;
}

.profile-modal.show {
    display: flex;
}


/* =========================================================
   MODAL CONTAINER
========================================================= */

.profile-modal-content {
    width: 100%;
    max-width: 620px;

    max-height: 92vh;

    overflow-y: auto;

    background:
        var(--profile-card);

    border:
        1px solid rgba(255, 255, 255, 0.12);

    border-radius: 18px;

    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.55);

    animation:
        profileModalOpen 0.2s ease;
}

@keyframes profileModalOpen {

    from {
        opacity: 0;

        transform:
            translateY(15px)
            scale(0.97);
    }

    to {
        opacity: 1;

        transform:
            translateY(0)
            scale(1);
    }
}


/* =========================================================
   MODAL HEADER
========================================================= */

.profile-modal-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 15px;

    padding: 20px 24px;

    background:
        var(--profile-card-light);

    border-bottom:
        1px solid var(--profile-border);
}

.profile-modal-header h3 {
    margin: 0;

    color: #fff;

    font-size: 19px;
}

.profile-modal-header p {
    margin: 4px 0 0;

    color: var(--profile-muted);

    font-size: 12px;
}

.modal-close-btn {
    width: 36px;
    height: 36px;

    display: flex;

    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    border: none;
    border-radius: 10px;

    background:
        rgba(255, 255, 255, 0.08);

    color: #fff;

    font-size: 22px;

    cursor: pointer;

    transition:
        background 0.2s ease;
}

.modal-close-btn:hover {
    background:
        var(--profile-danger);
}


/* =========================================================
   MODAL BODY
========================================================= */

.profile-modal-body {
    padding: 24px;
}


/* =========================================================
   PROFILE PICTURE PREVIEW
========================================================= */

.profile-picture-section {
    display: flex;

    align-items: center;

    gap: 18px;

    margin-bottom: 25px;

    padding: 16px;

    background:
        rgba(255, 255, 255, 0.04);

    border:
        1px solid rgba(255, 255, 255, 0.06);

    border-radius: 13px;
}

.edit-avatar {
    width: 75px;
    height: 75px;

    flex-shrink: 0;

    object-fit: cover;

    border:
        3px solid rgba(255, 255, 255, 0.15);

    border-radius: 50%;

    background:
        var(--profile-card-light);
}

.profile-picture-text h4 {
    margin: 0 0 5px;

    color: #fff;

    font-size: 14px;
}

.profile-picture-text p {
    margin: 0;

    color: var(--profile-muted);

    font-size: 12px;
}


/* =========================================================
   FORM
========================================================= */

.profile-form-group {
    margin-bottom: 18px;
}

.profile-form-label {
    display: block;

    margin-bottom: 7px;

    color: #fff;

    font-size: 13px;
    font-weight: 600;
}

.profile-form-label .optional {
    color: var(--profile-muted);

    font-size: 11px;
    font-weight: 400;
}


/* INPUT */

.profile-input {
    width: 100%;
    height: 45px;

    padding: 0 13px;

    box-sizing: border-box;

    border:
        1px solid rgba(255, 255, 255, 0.1);

    border-radius: 10px;

    background:
        #171d55;

    color: #fff;

    font-family: inherit;
    font-size: 13px;

    outline: none;

    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.profile-input::placeholder {
    color:
        rgba(255, 255, 255, 0.4);
}

.profile-input:focus {
    border-color:
        var(--profile-primary);

    box-shadow:
        0 0 0 3px rgba(59, 130, 246, 0.15);
}


/* FILE INPUT */

.profile-file-input {
    width: 100%;

    padding: 10px;

    box-sizing: border-box;

    border:
        1px dashed rgba(255, 255, 255, 0.2);

    border-radius: 10px;

    background:
        #171d55;

    color: var(--profile-muted);

    font-size: 12px;

    cursor: pointer;
}

.profile-file-input::file-selector-button {
    margin-right: 10px;

    padding: 7px 11px;

    border: none;
    border-radius: 7px;

    background:
        var(--profile-primary);

    color: #fff;

    cursor: pointer;
}


/* PASSWORD WRAPPER */

.password-wrapper {
    position: relative;
}

.password-wrapper .profile-input {
    padding-right: 48px;
}

.password-toggle {
    position: absolute;

    top: 50%;
    right: 10px;

    width: 32px;
    height: 32px;

    transform: translateY(-50%);

    border: none;
    border-radius: 7px;

    background:
        transparent;

    color: var(--profile-muted);

    cursor: pointer;
}

.password-toggle:hover {
    background:
        rgba(255, 255, 255, 0.08);

    color: #fff;
}


/* =========================================================
   PASSWORD SECTION
========================================================= */

.password-section {
    margin-top: 25px;
    padding-top: 22px;

    border-top:
        1px solid rgba(255, 255, 255, 0.1);
}

.password-section-title {
    margin: 0 0 5px;

    color: #fff;

    font-size: 16px;
}

.password-section-description {
    margin: 0 0 18px;

    color: var(--profile-muted);

    font-size: 12px;
}


/* =========================================================
   MODAL FOOTER
========================================================= */

.profile-modal-footer {
    display: flex;

    justify-content: flex-end;

    gap: 10px;

    padding: 16px 24px;

    background:
        rgba(0, 0, 0, 0.12);

    border-top:
        1px solid var(--profile-border);
}

.modal-btn {
    min-width: 100px;

    padding: 10px 16px;

    border: none;

    border-radius: 9px;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.modal-btn:hover {
    transform: translateY(-1px);
}

.modal-btn-cancel {
    background:
        #4b5563;

    color: #fff;
}

.modal-btn-cancel:hover {
    background:
        #374151;
}

.modal-btn-save {
    background:
        linear-gradient(
            135deg,
            var(--profile-success),
            #16a34a
        );

    color: #fff;
}

.modal-btn-save:hover {
    box-shadow:
        0 8px 18px rgba(34, 197, 94, 0.25);
}


/* =========================================================
   VALIDATION ERROR
========================================================= */

.profile-error {
    margin-top: 6px;

    color: #f87171;

    font-size: 11px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 992px) {

    .profile-body {
        flex-direction: column;
    }

    .profile-left {
        width: 100%;

        border-right: none;

        border-bottom:
            1px solid var(--profile-border);
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 768px) {

    .profile-header {
        align-items: flex-start;

        flex-direction: column;

        padding: 20px;
    }

    .edit-profile-btn {
        width: 100%;
    }

    .profile-left,
    .profile-right {
        padding: 22px;
    }

    .profile-avatar {
        width: 145px;
        height: 145px;
    }

    .activity-item {
        align-items: flex-start;

        flex-direction: column;

        gap: 5px;
    }

    .activity-value {
        text-align: left;
    }

    .profile-modal {
        padding: 12px;
    }

    .profile-modal-content {
        max-height: 95vh;

        border-radius: 15px;
    }

    .profile-modal-header {
        padding: 16px 18px;
    }

    .profile-modal-body {
        padding: 18px;
    }

    .profile-modal-footer {
        padding: 14px 18px;
    }

}


@media (max-width: 480px) {

    .profile-header-content h2 {
        font-size: 22px;
    }

    .profile-header-content p {
        font-size: 12px;
    }

    .profile-name h3 {
        font-size: 19px;
    }

    .profile-picture-section {
        align-items: flex-start;
    }

    .edit-avatar {
        width: 65px;
        height: 65px;
    }

    .profile-modal-footer {
        flex-direction: column-reverse;
    }

    .modal-btn {
        width: 100%;
    }

}

</style>


{{-- =========================================================
     PROFILE PAGE
========================================================= --}}

<div class="profile-container">

    <div class="profile-card">


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="profile-header">

            <div class="profile-header-content">

                <h2>
                    Super Admin Profile
                </h2>

                <p>
                    Manage your account information and security settings
                </p>

            </div>


            <button
                type="button"
                class="edit-profile-btn"
                onclick="openEditModal()"
            >
                ✏️ Edit Profile
            </button>

        </div>


        {{-- =====================================================
             PROFILE BODY
        ====================================================== --}}

        <div class="profile-body">


            {{-- =================================================
                 LEFT PROFILE
            ================================================== --}}

            <div class="profile-left">


                {{-- AVATAR --}}

                <div class="profile-avatar">

                    @if($user->profile_picture)

                        <img
                            src="{{ asset('storage/' . $user->profile_picture) }}"
                            alt="{{ $user->name }}"
                        >

                    @else

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4338ca&color=fff&size=300"
                            alt="{{ $user->name }}"
                        >

                    @endif

                </div>


                {{-- NAME --}}

                <div class="profile-name">

                    <h3>
                        {{ $user->name }}
                    </h3>

                    <div class="profile-role">
                        Super Administrator
                    </div>


                    <div class="status-badge">

                        <span class="status-dot"></span>

                        Active

                    </div>

                </div>


                {{-- BASIC INFORMATION --}}

                <div class="profile-info">


                    <div class="profile-info-item">

                        <div class="profile-info-label">
                            Email Address
                        </div>

                        <div class="profile-info-value">
                            {{ $user->email }}
                        </div>

                    </div>


                    <div class="profile-info-item">

                        <div class="profile-info-label">
                            Role
                        </div>

                        <div class="profile-info-value">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </div>

                    </div>


                    <div class="profile-info-item">

                        <div class="profile-info-label">
                            Member Since
                        </div>

                        <div class="profile-info-value">
                            {{ $user->created_at->format('F d, Y') }}
                        </div>

                    </div>


                </div>

            </div>


            {{-- =================================================
                 RIGHT CONTENT
            ================================================== --}}

            <div class="profile-right">


                {{-- SECTION TITLE --}}

                <div class="section-heading">

                    <h3 class="section-title">
                        Profile Information
                    </h3>

                    <p class="section-subtitle">
                        Your current account details
                    </p>

                </div>


                {{-- INFORMATION GRID --}}

                <div class="info-grid">


                    <div class="info-box">

                        <label>
                            Full Name
                        </label>

                        <p>
                            {{ $user->name }}
                        </p>

                    </div>


                    <div class="info-box">

                        <label>
                            Email Address
                        </label>

                        <p>
                            {{ $user->email }}
                        </p>

                    </div>


                    <div class="info-box">

                        <label>
                            Role
                        </label>

                        <p>
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </p>

                    </div>


                    <div class="info-box">

                        <label>
                            Account Status
                        </label>

                        <p>
                            Active
                        </p>

                    </div>


                </div>


                {{-- ACCOUNT ACTIVITY --}}

                <div class="activity-card">

                    <h4>
                        Account Activity
                    </h4>


                    <div class="activity-item">

                        <span class="activity-label">
                            Account Created
                        </span>

                        <span class="activity-value">
                            {{ $user->created_at->format('F d, Y h:i A') }}
                        </span>

                    </div>


                    <div class="activity-item">

                        <span class="activity-label">
                            Last Updated
                        </span>

                        <span class="activity-value">
                            {{ $user->updated_at->format('F d, Y h:i A') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
     EDIT PROFILE MODAL
============================================================= --}}

<div
    id="editModal"
    class="profile-modal"
    aria-hidden="true"
>

    <div
        class="profile-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="editProfileTitle"
    >


        {{-- =====================================================
             MODAL HEADER
        ====================================================== --}}

        <div class="profile-modal-header">

            <div>

                <h3 id="editProfileTitle">
                    Edit Profile
                </h3>

                <p>
                    Update your account information
                </p>

            </div>


            <button
                type="button"
                class="modal-close-btn"
                onclick="closeEditModal()"
                aria-label="Close"
            >
                &times;
            </button>

        </div>


        {{-- =====================================================
             MODAL BODY
        ====================================================== --}}

        <form
            method="POST"
            action="{{ route('superadmin.profile.update') }}"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PATCH')


            <div class="profile-modal-body">


                {{-- =================================================
                     PROFILE PICTURE
                ================================================== --}}

                <div class="profile-picture-section">

                    @if($user->profile_picture)

                        <img
                            id="editAvatarPreview"
                            class="edit-avatar"
                            src="{{ asset('storage/' . $user->profile_picture) }}"
                            alt="Profile Picture"
                        >

                    @else

                        <img
                            id="editAvatarPreview"
                            class="edit-avatar"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4338ca&color=fff&size=300"
                            alt="Profile Picture"
                        >

                    @endif


                    <div class="profile-picture-text">

                        <h4>
                            Profile Picture
                        </h4>

                        <p>
                            Upload a new profile picture.
                        </p>

                    </div>

                </div>


                {{-- FILE --}}

                <div class="profile-form-group">

                    <label
                        for="profilePicture"
                        class="profile-form-label"
                    >
                        Choose Image
                    </label>

                    <input
                        type="file"
                        id="profilePicture"
                        name="avatar"
                        class="profile-file-input"
                        accept="image/*"
                    >

                </div>


                {{-- =================================================
                     NAME
                ================================================== --}}

                <div class="profile-form-group">

                    <label
                        for="profileName"
                        class="profile-form-label"
                    >
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="profileName"
                        name="name"
                        class="profile-input"
                        value="{{ old('name', $user->name) }}"
                        required
                    >

                    @error('name')

                        <div class="profile-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- =================================================
                     EMAIL
                ================================================== --}}

                <div class="profile-form-group">

                    <label
                        for="profileEmail"
                        class="profile-form-label"
                    >
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="profileEmail"
                        name="email"
                        class="profile-input"
                        value="{{ old('email', $user->email) }}"
                        required
                    >

                    @error('email')

                        <div class="profile-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- =================================================
                     PASSWORD SECTION
                ================================================== --}}

                <div class="password-section">

                    <h4 class="password-section-title">
                        Change Password
                    </h4>

                    <p class="password-section-description">
                        Leave these fields empty if you do not want to change your password.
                    </p>


                    {{-- NEW PASSWORD --}}

                    <div class="profile-form-group">

                        <label
                            for="newPassword"
                            class="profile-form-label"
                        >
                            New Password
                            <span class="optional">
                                (Optional)
                            </span>
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                id="newPassword"
                                name="password"
                                class="profile-input"
                                placeholder="Enter new password"
                                autocomplete="new-password"
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword('newPassword', this)"
                                aria-label="Show password"
                            >
                                👁
                            </button>

                        </div>

                        @error('password')

                            <div class="profile-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- CONFIRM PASSWORD --}}

                    <div class="profile-form-group">

                        <label
                            for="confirmPassword"
                            class="profile-form-label"
                        >
                            Confirm Password
                            <span class="optional">
                                (Optional)
                            </span>
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                id="confirmPassword"
                                name="password_confirmation"
                                class="profile-input"
                                placeholder="Confirm new password"
                                autocomplete="new-password"
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword('confirmPassword', this)"
                                aria-label="Show password"
                            >
                                👁
                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 MODAL FOOTER
            ====================================================== --}}

            <div class="profile-modal-footer">

                <button
                    type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closeEditModal()"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="modal-btn modal-btn-save"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


<script>

/* =========================================================
   EDIT MODAL
========================================================= */

function openEditModal() {

    const modal =
        document.getElementById('editModal');

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.style.overflow = 'hidden';
}


function closeEditModal() {

    const modal =
        document.getElementById('editModal');

    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.style.overflow = '';
}


/* =========================================================
   CLOSE MODAL WHEN CLICKING OUTSIDE
========================================================= */

document
    .getElementById('editModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {

            closeEditModal();

        }

    });


/* =========================================================
   ESCAPE KEY
========================================================= */

document.addEventListener('keydown', function (event) {

    if (
        event.key === 'Escape' &&
        document
            .getElementById('editModal')
            .classList.contains('show')
    ) {

        closeEditModal();

    }

});


/* =========================================================
   PASSWORD VISIBILITY
========================================================= */

function togglePassword(inputId, button) {

    const input =
        document.getElementById(inputId);

    if (input.type === 'password') {

        input.type = 'text';

        button.textContent = '🙈';

        button.setAttribute(
            'aria-label',
            'Hide password'
        );

    } else {

        input.type = 'password';

        button.textContent = '👁';

        button.setAttribute(
            'aria-label',
            'Show password'
        );

    }

}


/* =========================================================
   PROFILE IMAGE PREVIEW
========================================================= */

document
    .getElementById('profilePicture')
    .addEventListener('change', function (event) {

        const file =
            event.target.files[0];

        if (!file) {
            return;
        }

        if (!file.type.startsWith('image/')) {
            return;
        }

        const reader =
            new FileReader();

        reader.onload = function (e) {

            document
                .getElementById('editAvatarPreview')
                .src = e.target.result;

        };

        reader.readAsDataURL(file);

    });

const successNotification =
    document.getElementById('success-notification');

if (successNotification) {

    setTimeout(() => {
        closeSuccessNotification();
    }, 5000);

}


function closeSuccessNotification() {

    const notification =
        document.getElementById('success-notification');

    if (!notification) {
        return;
    }

    notification.style.animation =
        'successSlideOut 0.3s ease forwards';

    setTimeout(() => {
        notification.remove();
    }, 300);

}
</script>

@endsection