@extends('layouts.admin')

@section('header-title', 'Edit Downloadable Form')

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

    .upload-description,
    .upload-help {
        color: #9eafd0;
    }

    .upload-description {
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
    }

    .upload-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .upload-help {
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

        <h2><i class="bi bi-pencil-square"></i> Edit Form</h2>

        <p class="upload-description">
            Update the form information, replace its file, or change its publication status.
        </p>

        <form action="{{ route('admin.downloadable-forms.update', $downloadableForm) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="upload-group">
                <label>Form Title *</label>

                <input type="text"
                       name="title"
                       value="{{ old('title', $downloadableForm->title) }}"
                       required>

                @error('title')
                    <div class="upload-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="upload-group">
                <label>Description</label>

                <textarea name="description">{{ old('description', $downloadableForm->description) }}</textarea>

                @error('description')
                    <div class="upload-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="upload-group">
                <label>Current File</label>

                <div class="upload-help">
                    {{ $downloadableForm->original_name }}
                </div>
            </div>

            <div class="upload-group">
                <label>Replace File (Optional)</label>

                <input type="file"
                       name="file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx">

                <div class="upload-help">
                    Leave this empty to keep the current file. Maximum size: 20 MB.
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
                       {{ old('is_published', $downloadableForm->is_published) ? 'checked' : '' }}>

                <label for="is_published">
                    Published – visible and downloadable by all cadets.
                </label>
            </div>

            <div class="upload-actions">

                <button type="submit" class="upload-btn">
                    <i class="bi bi-save"></i>
                    Save Changes
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