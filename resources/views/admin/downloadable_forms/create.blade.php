@extends('layouts.admin')

@section('header-title', 'Upload Downloadable Form')

@section('content')

<style>
    .upload-page {
        max-width: 850px;
        margin: 25px auto;
        padding: 25px;
        color: #eaf0ff;
    }

    .upload-panel {
        background: #101c39;
        border: 1px solid #26375e;
        border-radius: 16px;
        padding: 25px;
    }

    .upload-page h2 {
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .upload-description {
        color: #9eafd0;
        margin-bottom: 25px;
    }

    .upload-group {
        margin-bottom: 20px;
    }

    .upload-group label {
        display: block;
        color: #dce7ff;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .upload-group input,
    .upload-group textarea {
        width: 100%;
        background: #0a1530;
        border: 1px solid #344a78;
        border-radius: 9px;
        padding: 12px;
        color: #fff;
        outline: none;
    }

    .upload-group input:focus,
    .upload-group textarea:focus {
        border-color: #5b8cff;
    }

    .upload-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .upload-help {
        color: #9eafd0;
        font-size: 12px;
        margin-top: 7px;
    }

    .upload-check {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        background: #142448;
        border: 1px solid #344a78;
        border-radius: 10px;
        margin-bottom: 22px;
    }

    .upload-check input {
        width: 18px;
        height: 18px;
    }

    .upload-check label {
        color: #eaf0ff;
        margin: 0;
    }

    .upload-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .upload-btn {
        padding: 11px 18px;
        border: none;
        border-radius: 9px;
        background: #315ed1;
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .upload-cancel {
        background: #26375e;
    }

    .upload-error {
        color: #fca5a5;
        font-size: 13px;
        margin-top: 6px;
    }
</style>

<div class="upload-page">

    <div class="upload-panel">

        <h2><i class="bi bi-cloud-arrow-up"></i> Upload New Form</h2>

        <p class="upload-description">
            Upload a document that will be available for cadets to download.
        </p>

        <form action="{{ route('admin.downloadable-forms.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="upload-group">
                <label>Form Title *</label>

                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="Example: On Board Training Application Form"
                       required>

                @error('title')
                    <div class="upload-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="upload-group">
                <label>Description</label>

                <textarea name="description"
                          placeholder="Write a short description of this form...">{{ old('description') }}</textarea>

                @error('description')
                    <div class="upload-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="upload-group">
                <label>Select File *</label>

                <input type="file"
                       name="file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx"
                       required>

                <div class="upload-help">
                    Allowed files: PDF, DOC, DOCX, XLS, XLSX. Maximum size: 20 MB.
                </div>

                @error('file')
                    <div class="upload-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="upload-check">
                <input type="checkbox"
                       name="is_published"
                       value="1"
                       id="is_published"
                       {{ old('is_published') ? 'checked' : '' }}>

                <label for="is_published">
                    Publish this form immediately so all cadets can download it.
                </label>
            </div>

            <div class="upload-actions">

                <button type="submit" class="upload-btn">
                    <i class="bi bi-upload"></i>
                    Upload Form
                </button>

                <a href="{{ route('admin.downloadable-forms.index') }}"
                   class="upload-btn upload-cancel">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection