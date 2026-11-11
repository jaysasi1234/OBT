@extends('layouts.admin')

@section('header-title', 'Upload Downloadable Form')

@section('content')

<style>
    /* =========================================
       UPLOAD DOWNLOADABLE FORM
       DARK NAVY ADMIN THEME
    ========================================= */

    .upload-page {
        width: 100%;
        min-height: calc(100vh - 84px);
        margin: 0;
        padding: 30px 3.5%;
        background: #07152d !important;
        color: #eaf0ff;
        box-sizing: border-box;
    }

    .upload-panel {
        max-width: 1000px;
        margin: 0 auto;
        padding: 30px;
        background: linear-gradient(135deg, #153568 0%, #0d2345 100%);
        border: 1px solid #244b80;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.20);
    }

    .upload-page h2 {
        color: #ffffff;
        font-size: 25px;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .upload-description {
        color: #bdcce5;
        font-size: 14px;
        margin-bottom: 28px;
    }

    .upload-group {
        margin-bottom: 22px;
    }

    .upload-group label {
        display: block;
        color: #e3ecff;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 9px;
    }

    .upload-group input,
    .upload-group textarea {
        display: block;
        width: 100%;
        background: #0a1935 !important;
        border: 1px solid #294775;
        border-radius: 10px;
        padding: 13px 15px;
        color: #ffffff !important;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .upload-group input:focus,
    .upload-group textarea:focus {
        border-color: #4385ff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .upload-group input::placeholder,
    .upload-group textarea::placeholder {
        color: #7185a8;
    }

    .upload-group input[type="file"] {
        padding: 12px;
        cursor: pointer;
    }

    .upload-group input[type="file"]::file-selector-button {
        background: #244d91;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 9px 14px;
        margin-right: 12px;
        cursor: pointer;
        font-weight: 600;
    }

    .upload-group textarea {
        min-height: 130px;
        resize: vertical;
    }

    .upload-help {
        color: #9eb2d4;
        font-size: 12px;
        margin-top: 8px;
    }

    .upload-check {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 17px;
        background: #10284e;
        border: 1px solid #294775;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .upload-check input {
        width: 18px;
        height: 18px;
        accent-color: #3478ed;
        cursor: pointer;
        flex-shrink: 0;
    }

    .upload-check label {
        color: #eaf0ff;
        font-size: 13px;
        margin: 0;
        cursor: pointer;
    }

    .upload-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 5px;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 12px 22px;
        border: none;
        border-radius: 9px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .upload-btn:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.25);
    }

    .upload-cancel {
        background: #263d60;
    }

    .upload-cancel:hover {
        background: #344e75;
    }

    .upload-error {
        color: #fca5a5;
        font-size: 13px;
        margin-top: 7px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .upload-page {
            padding: 20px 12px;
        }

        .upload-panel {
            padding: 20px;
        }

        .upload-page h2 {
            font-size: 21px;
        }

        .upload-actions {
            flex-direction: column;
        }

        .upload-btn {
            width: 100%;
            box-sizing: border-box;
        }



/* =========================================
   REMOVE WHITE BACKGROUND FROM ADMIN CONTENT
========================================= */

html,
body {
    background: #07152d !important;
}

body,
#app {
    background-color: #07152d !important;
}

main,
.main-content,
.content-wrapper,
.admin-content,
.page-content,
.content,
.container-fluid {
    background-color: #07152d !important;
}

/* Upload page must fill its parent */
.upload-page {
    background: #07152d !important;
    width: 100%;
    min-height: 100vh;
    margin: 0 !important;
    padding: 30px 3.5%;
    box-sizing: border-box;
}

    }
</style>

<div class="upload-page">

    <div class="upload-panel">

        <h2>
            <i class="bi bi-cloud-arrow-up"></i>
            Upload New Form
        </h2>

        <p class="upload-description">
            Upload a document that will be available for cadets to download.
        </p>

        <form action="{{ route('admin.downloadable-forms.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- FORM TITLE --}}
            <div class="upload-group">

                <label for="title">Form Title *</label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Example: On Board Training Application Form"
                    required
                >

                @error('title')
                    <div class="upload-error">{{ $message }}</div>
                @enderror

            </div>

            {{-- DESCRIPTION --}}
            <div class="upload-group">

                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Write a short description of this form..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="upload-error">{{ $message }}</div>
                @enderror

            </div>

            {{-- FILE UPLOAD --}}
            <div class="upload-group">

                <label for="file">Select File *</label>

                <input
                    type="file"
                    id="file"
                    name="file"
                    accept=".pdf,.doc,.docx,.xls,.xlsx"
                    required
                >

                <div class="upload-help">
                    Allowed files: PDF, DOC, DOCX, XLS, XLSX.
                    Maximum size: 20 MB.
                </div>

                @error('file')
                    <div class="upload-error">{{ $message }}</div>
                @enderror

            </div>

            {{-- PUBLISH OPTION --}}
            <div class="upload-check">

                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    id="is_published"
                    {{ old('is_published') ? 'checked' : '' }}
                >

                <label for="is_published">
                    Publish this form immediately so all cadets can download it.
                </label>

            </div>

            {{-- ACTION BUTTONS --}}
            <div class="upload-actions">

                <button type="submit" class="upload-btn">
                    <i class="bi bi-upload"></i>
                    Upload Form
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
