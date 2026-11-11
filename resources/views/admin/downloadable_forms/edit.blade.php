
@extends('layouts.admin')

@section('header-title', 'Edit Downloadable Form')

@section('content')

<style>
    /* =====================================================
       EDIT DOWNLOADABLE FORM - DARK ADMIN THEME
    ===================================================== */

    html,
    body {
        background: #07152d !important;
    }

    main,
    .main-content,
    .content-wrapper,
    .admin-content,
    .page-content {
        background: #07152d !important;
        color: #eaf0ff;
    }

    .upload-page {
        width: 100%;
        max-width: 900px;
        min-height: 100vh;
        margin: 0 auto;
        padding: 25px;
        color: #eaf0ff;
        background: #07152d !important;
        box-sizing: border-box;
    }

    .upload-page * {
        box-sizing: border-box;
    }

    /* PANEL */

    .upload-panel {
        background: linear-gradient(145deg, #142548, #101c39);
        border: 1px solid #26375e;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .2);
    }

    /* HEADER */

    .upload-page h2 {
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .upload-page h2 i {
        color: #70a0ff;
        margin-right: 5px;
    }

    .upload-description {
        color: #9eafd0;
        margin-bottom: 25px;
        font-size: 14px;
        line-height: 1.6;
    }

    /* FORM GROUPS */

    .upload-group {
        margin-bottom: 21px;
    }

    .upload-group label {
        display: block;
        color: #dce7ff;
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .upload-group input[type="text"],
    .upload-group input[type="file"],
    .upload-group textarea {
        display: block;
        width: 100%;
        background: #0a1530 !important;
        border: 1px solid #344a78;
        border-radius: 9px;
        padding: 12px;
        color: #fff !important;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .upload-group input[type="text"]:focus,
    .upload-group input[type="file"]:focus,
    .upload-group textarea:focus {
        border-color: #5686f5;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .13);
    }

    .upload-group input[type="file"] {
        cursor: pointer;
    }

    .upload-group input[type="file"]::file-selector-button {
        background: #263f75;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        margin-right: 12px;
        cursor: pointer;
    }

    .upload-group input[type="file"]::file-selector-button:hover {
        background: #365ba0;
    }

    .upload-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .upload-help {
        color: #9eafd0;
        font-size: 12px;
        margin-top: 7px;
        line-height: 1.6;
    }

    /* CURRENT FILE */

    .current-file {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: #0a1530;
        border: 1px solid #344a78;
        border-radius: 10px;
        color: #dce7ff;
        overflow-wrap: anywhere;
    }

    .current-file i {
        color: #70a0ff;
        font-size: 23px;
        flex-shrink: 0;
    }

    .current-file-info {
        min-width: 0;
    }

    .current-file-info strong {
        display: block;
        color: #fff;
        font-size: 13px;
        margin-bottom: 4px;
    }

    /* PUBLISH CHECKBOX */

    .upload-check {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: #142448;
        border: 1px solid #344a78;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .upload-check input {
        width: 18px;
        height: 18px;
        accent-color: #3b82f6;
        cursor: pointer;
        flex-shrink: 0;
    }

    .upload-check label {
        color: #eaf0ff;
        font-size: 13px;
        font-weight: 600;
        margin: 0;
        cursor: pointer;
    }

    /* VALIDATION */

    .upload-error {
        color: #fca5a5;
        font-size: 12px;
        margin-top: 7px;
    }

    /* BUTTONS */

    .upload-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 5px;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 19px;
        border: 1px solid transparent;
        border-radius: 9px;
        background: linear-gradient(135deg, #3867e8, #2448ad);
        color: #fff !important;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none !important;
        cursor: pointer;
        transition: .2s ease;
    }

    .upload-btn:hover {
        color: #fff !important;
        filter: brightness(1.15);
        transform: translateY(-2px);
    }

    .upload-cancel {
        background: #26375e;
        border-color: #40547d;
    }

    .upload-cancel:hover {
        background: #354b78;
    }

    /* RESPONSIVE */

    @media(max-width: 768px) {
        .upload-page {
            padding: 18px;
        }

        .upload-panel {
            padding: 22px;
        }
    }

    @media(max-width: 500px) {
        .upload-page {
            padding: 12px;
        }

        .upload-panel {
            padding: 18px;
        }

        .upload-page h2 {
            font-size: 21px;
        }

        .upload-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .upload-btn {
            width: 100%;
        }
    }
</style>

<div class="upload-page">

    <div class="upload-panel">

        <h2>
            <i class="bi bi-pencil-square"></i>
            Edit Form
        </h2>

        <p class="upload-description">
            Update the form information, replace its file, or change its publication status.
        </p>

        <form action="{{ route('admin.downloadable-forms.update', $downloadableForm) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- FORM TITLE --}}
            <div class="upload-group">

                <label for="title">Form Title *</label>

                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', $downloadableForm->title) }}"
                       placeholder="Enter form title"
                       required>

                @error('title')
                    <div class="upload-error">{{ $message }}</div>
                @enderror

            </div>

            {{-- DESCRIPTION --}}
            <div class="upload-group">

                <label for="description">Description</label>

                <textarea id="description"
                          name="description"
                          placeholder="Enter form description">{{ old('description', $downloadableForm->description) }}</textarea>

                @error('description')
                    <div class="upload-error">{{ $message }}</div>
                @enderror

            </div>

            {{-- CURRENT FILE --}}
            <div class="upload-group">

                <label>Current File</label>

                <div class="current-file">
                    <i class="bi bi-file-earmark-text"></i>

                    <div class="current-file-info">
                        <strong>Currently Uploaded File</strong>
                        <div class="upload-help">
                            {{ $downloadableForm->original_name }}
                        </div>
                    </div>
                </div>

            </div>

            {{-- REPLACE FILE --}}
            <div class="upload-group">

                <label for="file">Replace File (Optional)</label>

                <input type="file"
                       id="file"
                       name="file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx">

                <div class="upload-help">
                    Leave this empty to keep the current file.
                    Maximum size: 20 MB.
                    Accepted formats: PDF, DOC, DOCX, XLS, XLSX.
                </div>

                @error('file')
                    <div class="upload-error">{{ $message }}</div>
                @enderror

            </div>

            {{-- PUBLICATION STATUS --}}
            <div class="upload-check">

                <input type="checkbox"
                       name="is_published"
                       value="1"
                       id="is_published"
                       {{ old('is_published', $downloadableForm->is_published) ? 'checked' : '' }}>

                <label for="is_published">
                    Published – visible and downloadable by all cadets.
                </label>

            </div>

            {{-- ACTION BUTTONS --}}
            <div class="upload-actions">

                <button type="submit" class="upload-btn">
                    <i class="bi bi-save"></i>
                    Save Changes
                </button>

                <a href="{{ route('admin.downloadable-forms.index') }}"
                   class="upload-btn upload-cancel">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
