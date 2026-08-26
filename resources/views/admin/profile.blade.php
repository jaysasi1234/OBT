@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/profile.css'])



<div class="page-box">

    <div class="profile-header">
        Admin Profile
    </div>

    <div class="profile-wrapper">

    @if(session('success'))

        <div style="
            background:#16a34a;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        ">
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div style="
            background:#dc2626;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        ">
            {{ session('error') }}
        </div>

    @endif

    @if ($errors->any())
        <div style="
            background:#dc2626;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        ">
            <ul style="margin:0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="profile-grid">

            <!-- LEFT PROFILE -->
            <div class="profile-card">

                <div class="profile-image">
                <img id="previewImage"
                src="{{ Auth::user()->profile_picture 
                                            ? Storage::url(Auth::user()->profile_picture)
                    : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}">
                </div>

                <div class="profile-info">

                    <div class="user-name">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="user-email">
                        {{ Auth::user()->email }}
                    </div>

                    <div class="info-item">
                        👤 {{ ucfirst(Auth::user()->role ?? 'User') }}
                    </div>

                    <div class="info-item">🏢 Admin</div>

                    <div class="info-item">
                        💼 {{ Auth::user()->office ?? 'Onboard Training Office' }}
                    </div>

                    <div class="status">
                        @if(Auth::user()->status == 'active')
                            <span style="background:#3ef14b;">Active</span>
                        @else
                            <span style="background:#f44336;">Inactive</span>
                        @endif
                    </div>

                </div>

            </div>

            <!-- RIGHT FORM -->
            <div class="form-section">

                <div class="tabs">

                    <button class="tab-btn active"
                    onclick="showTab(event,'profile')">
                        Edit Profile
                    </button>

                    <button class="tab-btn"
                    onclick="showTab(event,'password')">
                        Change Password
                    </button>

                </div>

                <!-- PROFILE TAB -->
                <div class="tab-content active" id="profile">

                    <form method="POST"
                    action="{{ route('admin.profile.update') }}"
                    enctype="multipart/form-data">

                        @csrf
                        @method('PATCH')

                        <div class="section-title">
                            Profile Information
                        </div>

                        <div class="form-group">
                            <label>
                                Full Name
                                <span class="required">*</span>
                            </label>

                            <input type="text"
                            name="name"
                            class="form-control"
                            value="{{ Auth::user()->name }}">
                        </div>

                        <div class="form-group">
                            <label>
                                Email Address
                                <span class="required">*</span>
                            </label>

                            <input type="email"
                            name="email"
                            class="form-control"
                            value="{{ Auth::user()->email }}">
                        </div>

                        <div class="form-group">
                            <label>Contact Number</label>

                        <input type="text"
                        name="contact"
                        class="form-control"
                        value="{{ Auth::user()->contact }}"
                        placeholder="63 912 345 6789">
                        </div>

                        <div class="form-group">

                            <label>Upload new photo</label>

                            <div class="upload-box">

                                <div class="upload-left">

                                    <img id="smallPreview"
                                    src="{{ Auth::user()->profile_picture 
                                            ? Storage::url(Auth::user()->profile_picture): 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}">

                                    <div>
                                        <div>Upload</div>
                                        <div class="upload-note">
                                            Allowed file types: JPG, PNG, Max size 2MB
                                        </div>
                                    </div>

                                </div>

                                <label class="upload-btn">

                                    ⬆ Upload Photo

                                    <input type="file"
                                    hidden
                                    name="profile_picture"
                                    onchange="previewFile(this)">

                                </label>

                            </div>

                        </div>

                        <div class="bottom-line">

                            <div class="actions">

                                <button type="submit"
                                class="save-btn">
                                    💾 Save changes
                                </button>

                                <button type="reset"
                                class="cancel-btn">
                                    Cancel
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

                <!-- PASSWORD TAB -->
                <div class="tab-content" id="password">

                    <form method="POST"action="{{ route('admin.profile.password') }}">
                        @csrf

                        <div class="section-title">
                            Change Password
                        </div>

                        <div class="password-grid">

                            <div>

                                <div class="form-group">

                                    <label>
                                        Current Password
                                        <span class="required">*</span>
                                    </label>

                                    <input type="password"
                                    name="current_password"
                                    class="form-control">
                                </div>

                                <div class="form-group">

                                    <label>
                                        New Password
                                        <span class="required">*</span>
                                    </label>

                                    <input type="password"
                                    name="new_password"
                                    class="form-control">
                                </div>

                                <div class="form-group">

                                    <label>
                                        Confirm New Password
                                        <span class="required">*</span>
                                    </label>

                                    <input type="password"
                                    name="new_password_confirmation"
                                    class="form-control">
                                </div>

                            </div>

                            <div class="password-req">

                                <strong>Password Requirements:</strong>

                                <div class="green">✔ At least 8 Characters</div>
                                <div class="green">✔ 1 Uppercase Letter</div>
                                <div class="green">✔ 1 Number</div>
                                <div class="green">✔ Special Character</div>

                                <br>

                                <div>
                                    ☑ Force change password on next Login
                                </div>

                                <div style="margin-top:8px;">
                                    The admin will be log out from all devices
                                </div>

                                <div style="margin-top:15px;">
                                    ☐ Send this to via email or SMS
                                </div>

                                <div class="strength">

                                    Strength:
                                    <span class="green">Strong</span>

                                    <div class="strength-bar">
                                        <div class="strength-fill"></div>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="bottom-line">

                            <div class="actions">

                                <button class="save-btn">
                                    💾 Save changes
                                </button>

                                <button type="button"
                                class="cancel-btn">
                                    Cancel
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

<!-- ACTIVITY -->
<div class="activity">

    <div class="activity-title">
        Account Activity
    </div>

    <div class="activity-grid">

        <div class="activity-card">

            <h4>🕒 Last Login</h4>

            @if(Auth::user()->last_login_at)
                {{ Auth::user()->last_login_at->format('F d, Y h:i A') }}
            @else
                No login recorded yet
            @endif

        </div>

        <div class="activity-card">

            <h4>📅 Account created</h4>

            {{ Auth::user()->created_at->format('F d, Y h:i A') }}

        </div>

    </div>

</div>
</div>

<script>

function showTab(event,tabId){

    event.preventDefault();

    document.querySelectorAll('.tab-content')
    .forEach(tab=>{
        tab.classList.remove('active');
    });

    document.querySelectorAll('.tab-btn')
    .forEach(btn=>{
        btn.classList.remove('active');
    });

    document.getElementById(tabId)
    .classList.add('active');

    event.target.classList.add('active');
}

function previewFile(input){

    if(input.files && input.files[0]){

        let reader = new FileReader();

        reader.onload = function(e){

            document.getElementById('previewImage')
            .src = e.target.result;

            document.getElementById('smallPreview')
            .src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

</script>

@endsection