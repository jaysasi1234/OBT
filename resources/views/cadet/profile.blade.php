@extends('layouts.cadet')

@section('content')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<style>

/* =========================================================
   PROFILE PAGE
========================================================= */

.profile-page {
    width: 100%;
    min-width: 0;
    padding: 20px;
    color: #fff;
}


/* =========================================================
   MAIN CONTAINER
========================================================= */

.profile-container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;

    background:
        linear-gradient(
            145deg,
            #11123a 0%,
            #15164a 55%,
            #101137 100%
        );

    border: 1px solid rgba(255,255,255,.07);
    border-radius: 22px;

    overflow: hidden;

    box-shadow:
        0 20px 50px rgba(0,0,0,.28);
}


/* =========================================================
   PROFILE HERO
========================================================= */

.profile-hero {
    position: relative;

    padding: 30px;

    background:
        radial-gradient(
            circle at 85% 15%,
            rgba(59,130,246,.20),
            transparent 35%
        ),
        radial-gradient(
            circle at 10% 90%,
            rgba(99,102,241,.15),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #17184e,
            #202263
        );

    border-bottom:
        1px solid rgba(255,255,255,.07);
}


.profile-hero-content {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 25px;
}


/* =========================================================
   PROFILE IDENTITY
========================================================= */

.profile-identity {
    display: flex;
    align-items: center;

    gap: 18px;

    min-width: 0;
}


.profile-avatar {
    width: 82px;
    height: 82px;

    flex-shrink: 0;

    border-radius: 50%;

    object-fit: cover;

    border:
        4px solid rgba(96,165,250,.45);

    box-shadow:
        0 10px 30px rgba(0,0,0,.35);
}


.profile-identity-text {
    min-width: 0;
}


.profile-identity-text h1 {
    margin: 0;

    color: #fff;

    font-size: 25px;
    font-weight: 750;

    letter-spacing: -.3px;

    word-break: break-word;
}


.profile-identity-text p {
    margin: 5px 0 0;

    color: #aeb5d5;

    font-size: 13px;
}


.profile-meta {
    display: flex;
    flex-wrap: wrap;

    gap: 7px;

    margin-top: 10px;
}


.profile-meta-badge {
    display: inline-flex;
    align-items: center;

    gap: 6px;

    padding: 6px 10px;

    border-radius: 999px;

    background: rgba(255,255,255,.07);

    border:
        1px solid rgba(255,255,255,.08);

    color: #cbd5e1;

    font-size: 10px;
    font-weight: 650;
}


.profile-meta-badge i {
    color: #93c5fd;
}


/* =========================================================
   HERO ACTION
========================================================= */

.profile-edit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    min-height: 42px;

    padding: 0 17px;

    border: 1px solid rgba(255,255,255,.08);

    border-radius: 10px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #6366f1
        );

    color: #fff;

    font-size: 12px;
    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;

    box-shadow:
        0 8px 20px rgba(59,130,246,.18);
}


.profile-edit-btn:hover {
    transform: translateY(-1px);

    box-shadow:
        0 12px 25px rgba(59,130,246,.28);
}


.profile-edit-btn.editing {
    background:
        linear-gradient(
            135deg,
            #ef4444,
            #dc2626
        );
}


/* =========================================================
   TAB NAVIGATION
========================================================= */

.profile-tabs-wrapper {
    padding: 18px 30px 0;

    background: #15164a;
}


.profile-tabs {
    display: flex;

    gap: 6px;

    overflow-x: auto;

    scrollbar-width: thin;
}


.profile-tab {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 8px;

    min-height: 42px;

    padding: 0 16px;

    border: 1px solid transparent;

    border-radius: 9px 9px 0 0;

    background: transparent;

    color: #8f96ba;

    font-size: 12px;
    font-weight: 650;

    white-space: nowrap;

    cursor: pointer;

    transition: .2s ease;
}


.profile-tab:hover {
    color: #dbe4ff;

    background:
        rgba(255,255,255,.04);
}


.profile-tab.active {
    color: #fff;

    background: #202263;

    border-color:
        rgba(255,255,255,.07);

    border-bottom-color: #202263;
}


.profile-tab.active i {
    color: #60a5fa;
}


/* =========================================================
   TAB CONTENT
========================================================= */

.profile-content {
    padding: 25px 30px 30px;

    background: #11123a;
}


.tab-content {
    display: none;

    animation: profileFade .2s ease;
}


.tab-content.active {
    display: block;
}


@keyframes profileFade {
    from {
        opacity: 0;
        transform: translateY(5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* =========================================================
   SECTION HEADER
========================================================= */

.section-heading {
    margin-bottom: 18px;
}


.section-heading h3 {
    display: flex;
    align-items: center;

    gap: 9px;

    margin: 0;

    color: #fff;

    font-size: 16px;
    font-weight: 700;
}


.section-heading h3 i {
    color: #60a5fa;
}


.section-heading p {
    margin: 5px 0 0;

    color: #858cae;

    font-size: 11px;
}


/* =========================================================
   PERSONAL GRID
========================================================= */

.profile-grid {
    display: grid;

    grid-template-columns:
        minmax(0, 1.8fr)
        minmax(280px, .9fr);

    gap: 20px;

    align-items: start;
}


/* =========================================================
   CARD
========================================================= */

.profile-card {
    background:
        linear-gradient(
            145deg,
            #191a4e,
            #161743
        );

    border:
        1px solid rgba(255,255,255,.065);

    border-radius: 16px;

    overflow: hidden;

    box-shadow:
        0 8px 25px rgba(0,0,0,.20);
}


.profile-card-header {
    display: flex;
    align-items: center;

    gap: 10px;

    padding: 16px 18px;

    background:
        rgba(255,255,255,.025);

    border-bottom:
        1px solid rgba(255,255,255,.055);
}


.profile-card-header i {
    color: #60a5fa;

    font-size: 14px;
}


.profile-card-header h4 {
    margin: 0;

    color: #fff;

    font-size: 13px;
    font-weight: 700;
}


.profile-card-body {
    padding: 5px 18px 12px;
}


/* =========================================================
   INFORMATION ROW
========================================================= */

.profile-row {
    display: grid;

    grid-template-columns:
        minmax(130px, .7fr)
        minmax(0, 1.5fr);

    gap: 20px;

    align-items: center;

    min-height: 56px;

    border-bottom:
        1px solid rgba(255,255,255,.055);
}


.profile-row:last-child {
    border-bottom: none;
}


.profile-label {
    display: flex;
    align-items: center;

    gap: 8px;

    color: #8f97bb;

    font-size: 11px;
    font-weight: 650;
}


.profile-label i {
    width: 16px;

    color: #6474c9;

    text-align: center;
}


.profile-value {
    color: #f1f5f9;

    font-size: 12px;

    text-align: right;

    word-break: break-word;
}


.profile-value.muted {
    color: #737b9e;
}


.profile-value.badge {
    justify-self: end;

    padding: 5px 9px;

    border-radius: 999px;

    background:
        rgba(59,130,246,.10);

    border:
        1px solid rgba(96,165,250,.16);

    color: #93c5fd;

    font-size: 10px;
    font-weight: 700;
}


/* =========================================================
   EDIT INPUT
========================================================= */

.profile-input {
    display: none;

    width: 100%;

    min-height: 40px;

    padding: 9px 11px;

    border:
        1px solid rgba(255,255,255,.09);

    border-radius: 8px;

    outline: none;

    background: #0d0e32;

    color: #fff;

    font-family: inherit;

    font-size: 12px;

    transition: .2s ease;
}


.profile-input:focus {
    border-color:
        rgba(96,165,250,.55);

    box-shadow:
        0 0 0 3px rgba(59,130,246,.10);
}


.edit-mode .profile-value {
    display: none;
}


.edit-mode .profile-input {
    display: block;
}


/* =========================================================
   READONLY FIELD
========================================================= */

.profile-input[readonly] {
    opacity: .65;

    cursor: not-allowed;
}


/* =========================================================
   SAVE AREA
========================================================= */

.profile-save-area {
    display: none;

    justify-content: flex-end;

    gap: 9px;

    padding-top: 18px;
}


.edit-mode .profile-save-area {
    display: flex;
}


.save-btn,
.cancel-edit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    min-height: 40px;

    padding: 0 15px;

    border: none;

    border-radius: 8px;

    font-size: 11px;
    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;
}


.save-btn {
    background:
        linear-gradient(
            135deg,
            #16a34a,
            #22c55e
        );

    color: #fff;
}


.save-btn:hover {
    transform: translateY(-1px);

    box-shadow:
        0 8px 18px rgba(34,197,94,.18);
}


.cancel-edit-btn {
    background: #30324f;

    color: #cbd5e1;
}


.cancel-edit-btn:hover {
    background: #3a3d5d;

    color: #fff;
}


/* =========================================================
   PHOTO CARD
========================================================= */

.photo-card {
    text-align: center;
}


.photo-card-body {
    padding: 25px 20px;
}


.photo-wrapper {
    position: relative;

    width: 170px;
    height: 170px;

    margin: 0 auto 18px;
}


.profile-photo {
    width: 170px;
    height: 170px;

    object-fit: cover;

    border-radius: 50%;

    border:
        5px solid rgba(96,165,250,.22);

    outline:
        1px solid rgba(96,165,250,.25);

    box-shadow:
        0 15px 35px rgba(0,0,0,.35);
}


.photo-status {
    position: absolute;

    right: 7px;
    bottom: 10px;

    width: 22px;
    height: 22px;

    border-radius: 50%;

    background: #22c55e;

    border:
        4px solid #191a4e;
}


.photo-title {
    margin: 0;

    color: #fff;

    font-size: 14px;
    font-weight: 700;
}


.photo-description {
    margin: 6px 0 18px;

    color: #8189aa;

    font-size: 10px;

    line-height: 1.5;
}


/* =========================================================
   FILE INPUT
========================================================= */

.photo-upload {
    width: 100%;

    padding: 10px;

    border:
        1px dashed rgba(255,255,255,.12);

    border-radius: 9px;

    background: #0e0f34;

    color: #b8bfdc;

    font-size: 10px;
}


.photo-upload::file-selector-button {
    margin-right: 8px;

    padding: 7px 10px;

    border: none;

    border-radius: 6px;

    background: #29306f;

    color: #dbe4ff;

    font-size: 10px;
    font-weight: 600;

    cursor: pointer;
}


.photo-upload::file-selector-button:hover {
    background: #3749a0;
}


.upload-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    width: 100%;

    min-height: 40px;

    margin-top: 10px;

    padding: 0 14px;

    border: none;

    border-radius: 8px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #6366f1
        );

    color: #fff;

    font-size: 11px;
    font-weight: 700;

    cursor: pointer;

    transition: .2s ease;
}


.upload-btn:hover {
    transform: translateY(-1px);

    box-shadow:
        0 8px 20px rgba(59,130,246,.20);
}


/* =========================================================
   GUARDIAN
========================================================= */

.single-column-card {
    max-width: 900px;
}


.guardian-grid {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 0 25px;
}


.guardian-grid .profile-row {
    grid-template-columns: 1fr;
    gap: 7px;

    padding: 12px 0;

    min-height: auto;
}


.guardian-grid .profile-value {
    text-align: left;
}


.guardian-grid .profile-input {
    width: 100%;
}


/* =========================================================
   SECURITY
========================================================= */

.security-card {
    max-width: 760px;
}


.security-warning {
    display: flex;
    align-items: flex-start;

    gap: 11px;

    margin: 18px;

    padding: 13px;

    border:
        1px solid rgba(245,158,11,.18);

    border-radius: 10px;

    background:
        rgba(245,158,11,.07);

    color: #fcd34d;

    font-size: 11px;

    line-height: 1.5;
}


.security-warning i {
    margin-top: 1px;

    font-size: 14px;
}


.security-form-body {
    padding: 8px 18px 18px;
}


.security-field {
    margin-bottom: 15px;
}


.security-field:last-child {
    margin-bottom: 0;
}


.security-field label {
    display: block;

    margin-bottom: 7px;

    color: #aeb5d5;

    font-size: 11px;
    font-weight: 650;
}


.security-field input {
    width: 100%;

    height: 42px;

    padding: 0 12px;

    border:
        1px solid rgba(255,255,255,.09);

    border-radius: 8px;

    outline: none;

    background: #0d0e32;

    color: #fff;

    font-size: 12px;
}


.security-field input:focus {
    border-color: rgba(96,165,250,.55);

    box-shadow:
        0 0 0 3px rgba(59,130,246,.10);
}


.security-submit {
    margin-top: 18px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 7px;

    min-height: 40px;

    padding: 0 16px;

    border: none;

    border-radius: 8px;

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #6366f1
        );

    color: #fff;

    font-size: 11px;
    font-weight: 700;

    cursor: pointer;
}


/* =========================================================
   ALERTS
========================================================= */

.profile-alert {
    display: flex;
    align-items: flex-start;

    gap: 10px;

    margin-bottom: 18px;

    padding: 13px 15px;

    border-radius: 10px;

    font-size: 11px;

    line-height: 1.5;
}


.profile-alert.success {
    background:
        rgba(34,197,94,.09);

    border:
        1px solid rgba(34,197,94,.20);

    color: #86efac;
}


.profile-alert.error {
    background:
        rgba(239,68,68,.09);

    border:
        1px solid rgba(239,68,68,.20);

    color: #fca5a5;
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 1000px) {

    .profile-grid {
        grid-template-columns: 1fr;
    }

    .photo-card {
        max-width: none;
    }

}


@media (max-width: 768px) {

    .profile-page {
        padding: 12px;
    }

    .profile-hero {
        padding: 22px 18px;
    }

    .profile-hero-content {
        align-items: flex-start;
        flex-direction: column;
    }

    .profile-edit-btn {
        width: 100%;
    }

    .profile-avatar {
        width: 68px;
        height: 68px;
    }

    .profile-identity-text h1 {
        font-size: 20px;
    }

    .profile-tabs-wrapper {
        padding: 12px 12px 0;
    }

    .profile-content {
        padding: 18px 12px 22px;
    }

    .profile-tabs {
        gap: 4px;
    }

    .profile-tab {
        flex: 1;

        min-width: 130px;

        padding: 0 12px;
    }

    .profile-row {
        grid-template-columns: 1fr;

        gap: 7px;

        padding: 13px 0;
    }

    .profile-value {
        text-align: left;
    }

    .profile-value.badge {
        justify-self: start;
    }

    .guardian-grid {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 480px) {

    .profile-page {
        padding: 8px;
    }

    .profile-container {
        border-radius: 15px;
    }

    .profile-hero {
        padding: 18px 15px;
    }

    .profile-identity {
        align-items: flex-start;
    }

    .profile-avatar {
        width: 58px;
        height: 58px;
    }

    .profile-identity-text h1 {
        font-size: 17px;
    }

    .profile-identity-text p {
        font-size: 11px;
    }

    .profile-meta-badge {
        font-size: 9px;
        padding: 5px 8px;
    }

    .profile-tab {
        min-width: 115px;

        font-size: 10px;
    }

    .profile-card-header {
        padding: 14px;
    }

    .profile-card-body,
    .security-form-body {
        padding-left: 14px;
        padding-right: 14px;
    }

    .photo-card-body {
        padding: 20px 14px;
    }

    .photo-wrapper,
    .profile-photo {
        width: 140px;
        height: 140px;
    }

    .profile-save-area {
        flex-direction: column;
    }

    .save-btn,
    .cancel-edit-btn {
        width: 100%;
    }

}

</style>


<div class="profile-page">

    <div class="profile-container">

        {{-- =====================================================
             HERO
        ====================================================== --}}

        <div class="profile-hero">

            <div class="profile-hero-content">

                <div class="profile-identity">

                        <img
                            id="profilePreview"
                            class="profile-avatar"
                            src="{{ $user->profile_picture
                                ? Storage::disk('public')->url($user->profile_picture) . '?v=' . ($user->updated_at?->timestamp ?? time())
                                : asset('images/default-avatar.png') }}"
                            alt="Profile Photo"
                            onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';">

                    <div class="profile-identity-text">

                        <h1>
                            {{ $user->name }}
                        </h1>

                        <p>
                            {{ $user->email ?? 'No email address' }}
                        </p>

                        <div class="profile-meta">

                            <span class="profile-meta-badge">
                                <i class="bi bi-person-badge"></i>
                                {{ $user->role ? ucfirst($user->role) : 'Cadet' }}
                            </span>

                            <span class="profile-meta-badge">
                                <i class="bi bi-book"></i>
                                {{ $user->course ?? 'N/A' }}
                            </span>

                            <span class="profile-meta-badge">
                                <i class="bi bi-card-text"></i>
                                TRB {{ $user->trb_no ?? 'N/A' }}
                            </span>

                        </div>

                    </div>

                </div>


                <button
                    type="button"
                    class="profile-edit-btn"
                    id="globalEditButton"
                    onclick="toggleEditMode()">

                    <i class="bi bi-pencil-square"></i>

                    <span id="editButtonText">
                        Edit Profile
                    </span>

                </button>

            </div>

        </div>


        {{-- =====================================================
             ALERTS
        ====================================================== --}}

        @if(session('success'))

            <div style="padding:18px 30px 0;">

                <div class="profile-alert success">

                    <i class="bi bi-check-circle-fill"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            </div>

        @endif


        @if(session('error'))

            <div style="padding:18px 30px 0;">

                <div class="profile-alert error">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            </div>

        @endif


        {{-- =====================================================
             TABS
        ====================================================== --}}

        <div class="profile-tabs-wrapper">

            <div class="profile-tabs">

                <button
                    type="button"
                    class="profile-tab active"
                    onclick="showTab(event, 'personal')">

                    <i class="bi bi-person-vcard"></i>

                    Personal Information

                </button>


                <button
                    type="button"
                    class="profile-tab"
                    onclick="showTab(event, 'guardian')">

                    <i class="bi bi-people"></i>

                    Guardian

                </button>


                <button
                    type="button"
                    class="profile-tab"
                    onclick="showTab(event, 'security')">

                    <i class="bi bi-shield-lock"></i>

                    Account Security

                </button>

            </div>

        </div>


        {{-- =====================================================
             CONTENT
        ====================================================== --}}

        <div class="profile-content">


            {{-- =================================================
                 PERSONAL INFORMATION
            ================================================== --}}

            <div
                id="personal"
                class="tab-content active">

                <div class="section-heading">

                    <h3>
                        <i class="bi bi-person-lines-fill"></i>

                        Personal Information
                    </h3>

                    <p>
                        View and update your personal information.
                    </p>

                </div>


                <div class="profile-grid">


                    {{-- =================================================
                         PERSONAL DETAILS
                    ================================================== --}}

                    <form
                        method="POST"
                        action="{{ route('cadet.profile.update') }}"
                        class="profile-card"
                        id="personalForm">

                        @csrf
                        @method('PUT')


                        <div class="profile-card-header">

                            <i class="bi bi-person-circle"></i>

                            <h4>
                                Basic Information
                            </h4>

                        </div>


                        <div class="profile-card-body">

                            {{-- FULL NAME --}}

                            <div class="profile-row">

                                <div class="profile-label">

                                    <i class="bi bi-person"></i>

                                    Full Name

                                </div>

                                <div>

                                    <span class="profile-value">

                                        {{ $user->name ?? 'N/A' }}

                                    </span>

                                    <input
                                        type="text"
                                        name="name"
                                        class="profile-input"
                                        value="{{ $user->name }}"
                                        autocomplete="name">

                                </div>

                            </div>


                            {{-- RANK --}}


                            <div class="profile-row">

                                <div class="profile-label">
                                    <i class="bi bi-award"></i>
                                    Rank
                                </div>

                                <div>

                                    <span class="profile-value">
                                        {{ $user->cadet?->rank ?? 'N/A' }}
                                    </span>

                                </div>

                            </div>


                            {{-- COURSE --}}

                    <div class="profile-row">

                        <div class="profile-label">
                            <i class="bi bi-mortarboard"></i>
                            Course
                        </div>

                        <div>

                            <span class="profile-value">
                                {{ $user->course ?? $user->cadet?->course ?? 'N/A' }}
                            </span>

                        </div>

                    </div>


                            {{-- BATCH --}}

                            <div class="profile-row">

                                <div class="profile-label">

                                    <i class="bi bi-calendar3"></i>

                                    Batch

                                </div>

                                <div>

                                    <span class="profile-value">

                                        {{ $user->cadet?->batch?->batch_year
                                            ?? $user->cadet?->batch_id
                                            ?? 'N/A' }}

                                    </span>

                                    <input
                                        type="text"
                                        class="profile-input"
                                        value="{{ $user->cadet?->batch?->batch_year
                                            ?? $user->cadet?->batch_id
                                            ?? '' }}"
                                        readonly>

                                </div>

                            </div>


                            {{-- DATE OF BIRTH --}}

                            <div class="profile-row">

                                <div class="profile-label">

                                    <i class="bi bi-calendar-event"></i>

                                    Date of Birth

                                </div>

                                <div>

                                    <span class="profile-value">

                                        {{ $user->cadet?->date_of_birth
                                            ? \Carbon\Carbon::parse(
                                                $user->cadet->date_of_birth
                                            )->format('F d, Y')
                                            : 'N/A' }}

                                    </span>

                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        class="profile-input"
                                        value="{{ $user->cadet?->date_of_birth
                                            ? \Carbon\Carbon::parse(
                                                $user->cadet->date_of_birth
                                            )->format('Y-m-d')
                                            : '' }}">

                                </div>

                            </div>


                            {{-- PLACE OF BIRTH --}}

                            <div class="profile-row">

                                <div class="profile-label">

                                    <i class="bi bi-geo-alt"></i>

                                    Place of Birth

                                </div>

                                <div>

                                    <span class="profile-value">

                                        {{ $user->cadet?->place_of_birth ?? 'N/A' }}

                                    </span>

                                    <input
                                        type="text"
                                        name="place_of_birth"
                                        class="profile-input"
                                        value="{{ $user->cadet?->place_of_birth ?? '' }}">

                                </div>

                            </div>


                            {{-- ADDRESS --}}

                            <div class="profile-row">

                                <div class="profile-label">

                                    <i class="bi bi-house"></i>

                                    Address

                                </div>

                                <div>

                                    <span class="profile-value">

                                        {{ $user->cadet?->address ?? 'N/A' }}

                                    </span>

                                    <input
                                        type="text"
                                        name="address"
                                        class="profile-input"
                                        value="{{ $user->cadet?->address ?? '' }}">

                                </div>

                            </div>


                            {{-- CONTACT --}}

                            <div class="profile-row">

                                <div class="profile-label">

                                    <i class="bi bi-telephone"></i>

                                    Contact

                                </div>

                                <div>

                                    <span class="profile-value">

                                        {{ $user->cadet?->contact_number ?? 'N/A' }}

                                    </span>

                                    <input
                                        type="text"
                                        name="contact_number"
                                        class="profile-input"
                                        value="{{ $user->cadet?->contact_number ?? '' }}"
                                        autocomplete="tel">

                                </div>

                            </div>


                            {{-- EMAIL --}}

                            <div class="profile-row">

                                <div class="profile-label">

                                    <i class="bi bi-envelope"></i>

                                    Email

                                </div>

                                <div>

                                    <span class="profile-value">

                                        {{ $user->email ?? 'N/A' }}

                                    </span>

                                    <input
                                        type="email"
                                        name="email"
                                        class="profile-input"
                                        value="{{ $user->email ?? '' }}"
                                        autocomplete="email">

                                </div>

                            </div>


                            {{-- SAVE --}}

                            <div class="profile-save-area">

                                <button
                                    type="button"
                                    class="cancel-edit-btn"
                                    onclick="cancelEditMode()">

                                    <i class="bi bi-x-lg"></i>

                                    Cancel

                                </button>


                                <button
                                    type="submit"
                                    class="save-btn">

                                    <i class="bi bi-check-lg"></i>

                                    Save Changes

                                </button>

                            </div>

                        </div>

                    </form>


                    {{-- =================================================
                         PHOTO
                    ================================================== --}}

                    <div class="profile-card photo-card">

                        <div class="profile-card-header">

                            <i class="bi bi-camera"></i>

                            <h4>
                                Profile Photo
                            </h4>

                        </div>


                        <div class="photo-card-body">

                            <div class="photo-wrapper">
                                
                                    <img
                                        id="photoPreview"
                                        class="profile-photo"
                                        src="{{ $user->profile_picture
                                            ? Storage::disk('public')->url($user->profile_picture) . '?v=' . ($user->updated_at?->timestamp ?? time())
                                            : asset('images/default-avatar.png') }}"
                                        alt="Profile Photo"
                                        onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';">

                                <span class="photo-status"></span>

                            </div>


                            <h3 class="photo-title">
                                {{ $user->name }}
                            </h3>


                            <p class="photo-description">

                                Upload a clear profile photo.
                                Maximum file size is 2MB.

                            </p>


                            <form
                                method="POST"
                                action="{{ route('cadet.profile.upload') }}"
                                enctype="multipart/form-data">

                                @csrf


                                <input
                                    type="file"
                                    name="photo"
                                    id="photoInput"
                                    class="photo-upload"
                                    accept="image/jpeg,image/png,image/webp"
                                    required>


                                <button
                                    type="submit"
                                    class="upload-btn">

                                    <i class="bi bi-cloud-arrow-up"></i>

                                    Upload Photo

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 GUARDIAN INFORMATION
            ================================================== --}}

            <div
                id="guardian"
                class="tab-content">

                <div class="section-heading">

                    <h3>
                        <i class="bi bi-people-fill"></i>

                        Guardian Information
                    </h3>

                    <p>
                        Keep your emergency contact and guardian
                        information up to date.
                    </p>

                </div>


                    <form
                        method="POST"
                        action="{{ route('cadet.profile.guardian.update') }}"
                        class="profile-card single-column-card">

                        @csrf
                        @method('PUT')


                    <div class="profile-card-header">

                        <i class="bi bi-person-hearts"></i>

                        <h4>
                            Guardian Details
                        </h4>

                    </div>


                    <div class="profile-card-body guardian-grid">


                        {{-- NAME --}}

                        <div class="profile-row">

                            <div class="profile-label">

                                <i class="bi bi-person"></i>

                                Guardian Name

                            </div>

                            <div>

                                <span class="profile-value">

                                    {{ $user->guardian_name ?? 'N/A' }}

                                </span>

                                <input
                                    type="text"
                                    name="guardian_name"
                                    class="profile-input"
                                    value="{{ $user->guardian_name ?? '' }}">

                            </div>

                        </div>


                        {{-- RELATIONSHIP --}}

                        <div class="profile-row">

                            <div class="profile-label">

                                <i class="bi bi-diagram-3"></i>

                                Relationship

                            </div>

                            <div>

                                <span class="profile-value">

                                    {{ $user->relationship ?? 'N/A' }}

                                </span>

                                <input
                                    type="text"
                                    name="relationship"
                                    class="profile-input"
                                    value="{{ $user->relationship ?? '' }}">

                            </div>

                        </div>


                        {{-- CONTACT --}}

                        <div class="profile-row">

                            <div class="profile-label">

                                <i class="bi bi-telephone"></i>

                                Contact Number

                            </div>

                            <div>

                                <span class="profile-value">

                                    {{ $user->guardian_contact ?? 'N/A' }}

                                </span>

                                <input
                                    type="text"
                                    name="guardian_contact"
                                    class="profile-input"
                                    value="{{ $user->guardian_contact ?? '' }}">

                            </div>

                        </div>


                        {{-- ADDRESS --}}

                        <div class="profile-row">

                            <div class="profile-label">

                                <i class="bi bi-geo-alt"></i>

                                Address

                            </div>

                            <div>

                                <span class="profile-value">

                                    {{ $user->guardian_address ?? 'N/A' }}

                                </span>

                                <input
                                    type="text"
                                    name="guardian_address"
                                    class="profile-input"
                                    value="{{ $user->guardian_address ?? '' }}">

                            </div>

                        </div>


                        <div class="profile-save-area"
                             style="grid-column:1/-1;">

                            <button
                                type="button"
                                class="cancel-edit-btn"
                                onclick="cancelEditMode()">

                                <i class="bi bi-x-lg"></i>

                                Cancel

                            </button>


                            <button
                                type="submit"
                                class="save-btn">

                                <i class="bi bi-check-lg"></i>

                                Save Guardian

                            </button>

                        </div>

                    </div>

                </form>

            </div>


            {{-- =================================================
                 SECURITY
            ================================================== --}}

            <div
                id="security"
                class="tab-content">

                <div class="section-heading">

                    <h3>
                        <i class="bi bi-shield-lock-fill"></i>

                        Account Security
                    </h3>

                    <p>
                        Update your password to keep your account secure.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('cadet.profile.password.update') }}"
                    class="profile-card security-card">

                    @csrf
                    @method('PUT')


                    <div class="profile-card-header">

                        <i class="bi bi-key"></i>

                        <h4>
                            Change Password
                        </h4>

                    </div>


                    <div class="security-warning">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        <div>

                            <strong>
                                Password Security
                            </strong>

                            <br>

                            Use a strong password containing a combination
                            of letters, numbers, and special characters.

                        </div>

                    </div>


                    <div class="security-form-body">


                        <div class="security-field">

                            <label for="current_password">
                                Current Password
                            </label>

                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                autocomplete="current-password"
                                placeholder="Enter your current password"
                                required>

                        </div>


                        <div class="security-field">

                            <label for="new_password">
                                New Password
                            </label>

                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                autocomplete="new-password"
                                placeholder="Enter your new password"
                                required>

                        </div>


                        <div class="security-field">

                            <label for="new_password_confirmation">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                autocomplete="new-password"
                                placeholder="Confirm your new password"
                                required>

                        </div>


                        <button
                            type="submit"
                            class="security-submit">

                            <i class="bi bi-shield-check"></i>

                            Change Password

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<script>
function showTab(event, tabId)
{
    /*
     * Cancel current editing when switching tabs
     */
    profileEditing = false;

    /*
     * Remove active tab
     */
    document
        .querySelectorAll('.profile-tab')
        .forEach(tab => {
            tab.classList.remove('active');
        });


    /*
     * Hide all tab contents
     */
    document
        .querySelectorAll('.tab-content')
        .forEach(content => {
            content.classList.remove('active');
        });


    /*
     * Activate clicked tab
     */
    event.currentTarget.classList.add('active');


    const target =
        document.getElementById(tabId);


    if (target) {

        target.classList.add('active');

    }


    /*
     * Reset edit mode
     */
    applyEditMode();
}


/* =========================================================
   EDIT MODE
========================================================= */

let profileEditing = false;


/*
 * Get the currently visible tab
 */
function getActiveTab()
{
    return document.querySelector('.tab-content.active');
}


/*
 * Toggle edit mode only for the active tab
 */
function toggleEditMode()
{
    const activeTab = getActiveTab();

    if (!activeTab) {
        return;
    }

    /*
     * Security tab has its own form.
     * Do not activate profile edit mode there.
     */
    if (activeTab.id === 'security') {
        return;
    }

    profileEditing = !profileEditing;

    applyEditMode();
}


/*
 * Apply edit mode only to the active tab
 */
function applyEditMode()
{
    const activeTab = getActiveTab();

    /*
     * Remove edit mode from every profile card first.
     */
    document
        .querySelectorAll('.profile-card')
        .forEach(card => {

            card.classList.remove('edit-mode');

        });


    /*
     * If editing is enabled,
     * activate only the card inside the current tab.
     */
    if (profileEditing && activeTab) {

        activeTab
            .querySelectorAll('.profile-card')
            .forEach(card => {

                /*
                 * Never edit photo/security cards.
                 */
                if (
                    card.classList.contains('security-card') ||
                    card.classList.contains('photo-card')
                ) {
                    return;
                }

                card.classList.add('edit-mode');

            });

    }


    /*
     * Update Edit button
     */
    const button =
        document.getElementById('globalEditButton');

    const text =
        document.getElementById('editButtonText');

    if (!button || !text) {
        return;
    }


    if (profileEditing) {

        button.classList.add('editing');

        text.textContent =
            'Cancel Editing';

        const icon =
            button.querySelector('i');

        if (icon) {
            icon.className =
                'bi bi-x-lg';
        }

    } else {

        button.classList.remove('editing');

        text.textContent =
            'Edit Profile';

        const icon =
            button.querySelector('i');

        if (icon) {
            icon.className =
                'bi bi-pencil-square';
        }

    }
}


/*
 * Cancel editing
 */
function cancelEditMode()
{
    profileEditing = false;

    applyEditMode();
}


/* =========================================================
   PHOTO PREVIEW
========================================================= */

const photoInput =
    document.getElementById('photoInput');

const photoPreview =
    document.getElementById('photoPreview');

const profilePreview =
    document.getElementById('profilePreview');


if (photoInput) {

    photoInput.addEventListener(
        'change',
        function(event) {

            const file =
                event.target.files?.[0];


            if (!file) {
                return;
            }


            /*
             * Maximum 2MB
             */

            if (
                file.size >
                2 * 1024 * 1024
            ) {

                alert(
                    'Image too large. Maximum allowed size is 2MB.'
                );

                this.value = '';

                return;

            }


            /*
             * Validate image type
             */

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            if (
                !allowedTypes.includes(
                    file.type
                )
            ) {

                alert(
                    'Please select a JPG, PNG, or WEBP image.'
                );

                this.value = '';

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function(e) {

                    const source =
                        e.target.result;


                    if (photoPreview) {

                        photoPreview.src =
                            source;

                    }


                    if (profilePreview) {

                        profilePreview.src =
                            source;

                    }

                };


            reader.readAsDataURL(file);

        }
    );

}


/* =========================================================
   PASSWORD MATCH CHECK
========================================================= */

const passwordForm =
    document.querySelector(
        'form[action*="password"]'
    );


if (passwordForm) {

    passwordForm.addEventListener(
        'submit',
        function(event) {

            const password =
                document.getElementById(
                    'new_password'
                )?.value;


            const confirmation =
                document.getElementById(
                    'new_password_confirmation'
                )?.value;


            if (
                password &&
                confirmation &&
                password !== confirmation
            ) {

                event.preventDefault();

                alert(
                    'New password and confirmation do not match.'
                );

            }

        }
    );

}

</script>

@endsection