@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/settings/system.css'])

<div class="main">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="settings-wrapper">

        <a href="{{ route('admin.settings.index') }}"
   class="close-btn">
    ×
</a>

        <!-- HEADER -->
        <div class="settings-header">
            <h2>System Settings</h2>
            <p>Configure system information and preferences</p>
        </div>

        <form action="{{ route('admin.system.settings.save') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- SYSTEM INFO -->

            <div class="box">

                <div class="box-title">
                    System Information
                </div>

                <div class="form-group">
                    <label>System Name *</label>

                    <input type="text"
                           name="system_name"
                           value="{{ $settings['system_name'] ?? 'Onboard Training Report System' }}">
                </div>

                <div class="form-group">
                    <label>Organization / School *</label>

                    <input type="text"
                           name="organization"
                           value="{{ $settings['organization'] ?? 'Merchant Marine Academy Of Caraga Inc.' }}">
                </div>



                <div class="form-group">
                    <textarea name="description">{{ $settings['description'] ?? 'System for managing cadet records and deployments' }}</textarea>
                </div>

            </div>

            <!-- SECOND GRID -->

            <div class="grid-2">

                <!-- ACCESS -->

                <div class="box">

                    <div class="box-title">
                        System Access Settings
                    </div>

                    <div class="toggle-row">
                        <span>Allow Cadet Registration</span>

                        <label class="switch">
                            <input type="checkbox"
                                   name="allow_registration"
                                   {{ !empty($settings['allow_registration']) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <span>Allow Document Upload</span>

                        <label class="switch">
                            <input type="checkbox"
                                   name="allow_upload"
                                   {{ !empty($settings['allow_upload']) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <span>Allow Complaint Submission</span>

                        <label class="switch">
                            <input type="checkbox"
                                   name="allow_complaint"
                                   {{ !empty($settings['allow_complaint']) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>

                </div>

                <!-- SECURITY -->

                <div class="box">

                    <div class="box-title">
                        Security Settings
                    </div>

                    <div class="form-group">
                        <label>Password Minimum Length</label>

                        <input type="number"
                               name="password_length"
                               value="{{ $settings['password_length'] ?? 8 }}">
                    </div>

                    <div class="form-group">
                        <label>Maximum Login Attempts</label>

                        <input type="number"
                               name="max_attempts"
                               value="{{ $settings['max_attempts'] ?? 5 }}">
                    </div>

                    <div class="form-group">
                        <label>Required Special Characters</label>

                        <select name="special_characters">

                            <option value="Yes"
                                {{ ($settings['special_characters'] ?? '') == 'Yes' ? 'selected' : '' }}>
                                Yes
                            </option>

                            <option value="No"
                                {{ ($settings['special_characters'] ?? '') == 'No' ? 'selected' : '' }}>
                                No
                            </option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Session Timeout</label>

                        <input type="text"
                               name="session_timeout"
                               value="{{ $settings['session_timeout'] ?? '20 Minutes' }}">
                    </div>

                </div>

            </div>

            <button class="save-btn">
                Save Settings
            </button>

        </form>

    </div>

</div>

@endsection