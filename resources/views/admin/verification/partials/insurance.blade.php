<div class="insurance-management-card">

    <div class="insurance-management-header">
        <div>
            <h3>🛡️ Cadet Insurance Management</h3>
            <p>Upload and manage this cadet's insurance document.</p>
        </div>

        @if($cadet->insurance)
            <span class="insurance-badge uploaded">
                ● Uploaded
            </span>
        @else
            <span class="insurance-badge missing">
                ● Not Uploaded
            </span>
        @endif
    </div>

    @if(session('success'))
        <div class="insurance-message success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="insurance-message error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if($cadet->insurance)

        <div class="insurance-file-details">

            <div class="insurance-file-icon">
                📄
            </div>

            <div class="insurance-file-info">
                <strong>
                    {{ $cadet->insurance->original_name }}
                </strong>

                <small>
                    Uploaded:
                    {{ $cadet->insurance->created_at?->format('M d, Y h:i A') }}
                </small>

                <small>
                    File size:
                    {{ $cadet->insurance->file_size
                        ? number_format($cadet->insurance->file_size / 1048576, 2).' MB'
                        : 'Not available' }}
                </small>
            </div>

            <div class="insurance-file-actions">

                <a
                    href="{{ route('admin.insurance.view', $cadet->id) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="insurance-action view">
                    👁 View
                </a>

                <a
                    href="{{ route('admin.insurance.download', $cadet->id) }}"
                    class="insurance-action download">
                    ⬇ Download
                </a>

            </div>

        </div>

        <div class="insurance-divider"></div>

        <h4 class="insurance-form-title">
            Replace Insurance Document
        </h4>

    @else

        <div class="insurance-empty">
            <div class="insurance-empty-icon">📋</div>
            <strong>No insurance document uploaded yet.</strong>
            <span>Upload the cadet's insurance document below.</span>
        </div>

        <h4 class="insurance-form-title">
            Upload Insurance Document
        </h4>

    @endif

    <form
        action="{{ route('admin.insurance.upload', $cadet->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="insurance-upload-field">

            <label for="insuranceFile">
                Select Insurance Document
            </label>

            <input
                type="file"
                name="file"
                id="insuranceFile"
                accept=".pdf,.jpg,.jpeg,.png"
                required>

            <small>
                Accepted formats: PDF, JPG, JPEG, PNG. Maximum size: 10 MB.
            </small>

        </div>

        <button type="submit" class="insurance-upload-button">
            📤
            {{ $cadet->insurance ? 'Replace Insurance Document' : 'Upload Insurance Document' }}
        </button>

    </form>

    @if($cadet->insurance)

        <div class="insurance-delete-area">

            <form
                action="{{ route('admin.insurance.delete', $cadet->id) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this cadet insurance document?');">

                @csrf
                @method('DELETE')

                <button type="submit" class="insurance-delete-button">
                    🗑 Delete Insurance Document
                </button>

            </form>

        </div>

    @endif

</div>

<style>

/* =========================================================
   INSURANCE MANAGEMENT - DARK NAVY VERIFICATION THEME
========================================================= */

.insurance-management-card {
    margin-top: 25px;
    padding: 24px;
    border-radius: 18px;
    background: linear-gradient(145deg, #0d1940, #111f4d);
    border: 1px solid rgba(96, 165, 250, .22);
    box-shadow: 0 12px 30px rgba(0, 0, 0, .20);
    color: #e2e8f0;
}

.insurance-management-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 22px;
}

.insurance-management-header h3 {
    margin: 0 0 6px;
    color: #f1f5f9;
    font-size: 18px;
    font-weight: 800;
}

.insurance-management-header p {
    margin: 0;
    color: #94a3b8;
    font-size: 12px;
}

.insurance-badge {
    padding: 7px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.insurance-badge.uploaded {
    color: #86efac;
    background: rgba(22, 163, 74, .16);
    border: 1px solid rgba(74, 222, 128, .25);
}

.insurance-badge.missing {
    color: #fcd34d;
    background: rgba(217, 119, 6, .15);
    border: 1px solid rgba(251, 191, 36, .25);
}

/* FILE DETAILS */

.insurance-file-details {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px;
    border: 1px solid rgba(96, 165, 250, .20);
    border-radius: 13px;
    background: rgba(7, 21, 47, .75);
}

.insurance-file-icon {
    width: 45px;
    height: 45px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    border-radius: 12px;
    background: rgba(37, 99, 235, .20);
    border: 1px solid rgba(96, 165, 250, .20);
    font-size: 21px;
}

.insurance-file-info {
    min-width: 0;
    flex: 1;
}

.insurance-file-info strong,
.insurance-file-info small {
    display: block;
    overflow-wrap: anywhere;
}

.insurance-file-info strong {
    color: #f1f5f9;
    font-size: 13px;
}

.insurance-file-info small {
    margin-top: 4px;
    color: #94a3b8;
    font-size: 11px;
}

.insurance-file-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

/* ACTION BUTTONS */

.insurance-action,
.insurance-upload-button,
.insurance-delete-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 7px;
    padding: 10px 13px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
}

.insurance-action.view {
    background: rgba(14, 165, 233, .15);
    color: #7dd3fc;
    border-color: rgba(56, 189, 248, .25);
}

.insurance-action.view:hover {
    background: #0284c7;
    color: #fff;
}

.insurance-action.download {
    background: rgba(37, 99, 235, .20);
    color: #93c5fd;
    border-color: rgba(96, 165, 250, .25);
}

.insurance-action.download:hover {
    background: #2563eb;
    color: #fff;
}

.insurance-divider {
    height: 1px;
    margin: 22px 0;
    background: rgba(148, 163, 184, .18);
}

/* FORM */

.insurance-form-title {
    margin: 0 0 14px;
    color: #e2e8f0;
    font-size: 13px;
    font-weight: 800;
}

.insurance-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 7px;
    padding: 25px 15px;
    margin-bottom: 20px;
    border: 1px dashed rgba(96, 165, 250, .35);
    border-radius: 12px;
    text-align: center;
    background: rgba(7, 21, 47, .55);
}

.insurance-empty-icon {
    font-size: 27px;
}

.insurance-empty strong {
    color: #e2e8f0;
    font-size: 13px;
}

.insurance-empty span {
    color: #94a3b8;
    font-size: 11px;
}

.insurance-upload-field label {
    display: block;
    margin-bottom: 8px;
    color: #cbd5e1;
    font-size: 12px;
    font-weight: 700;
}

.insurance-upload-field input {
    width: 100%;
    padding: 11px;
    border: 1px dashed #475569;
    border-radius: 9px;
    background: rgba(7, 21, 47, .75);
    color: #e2e8f0;
    box-sizing: border-box;
}

.insurance-upload-field input::file-selector-button {
    padding: 7px 12px;
    margin-right: 10px;
    border: 0;
    border-radius: 6px;
    background: #1d4ed8;
    color: #fff;
    font-weight: 700;
    cursor: pointer;
}

.insurance-upload-field small {
    display: block;
    margin-top: 7px;
    color: #94a3b8;
    font-size: 10px;
}

.insurance-upload-button {
    margin-top: 15px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    border-color: rgba(147, 197, 253, .2);
}

.insurance-upload-button:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    transform: translateY(-1px);
}

/* DELETE */

.insurance-delete-area {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid rgba(148, 163, 184, .15);
}

.insurance-delete-button {
    background: rgba(220, 38, 38, .13);
    color: #fca5a5;
    border-color: rgba(248, 113, 113, .25);
}

.insurance-delete-button:hover {
    background: #b91c1c;
    color: #fff;
}

/* MESSAGES */

.insurance-message {
    margin-bottom: 15px;
    padding: 11px 14px;
    border-radius: 9px;
    font-size: 12px;
}

.insurance-message.success {
    color: #86efac;
    background: rgba(22, 163, 74, .13);
    border: 1px solid rgba(74, 222, 128, .22);
}

.insurance-message.error {
    color: #fca5a5;
    background: rgba(220, 38, 38, .13);
    border: 1px solid rgba(248, 113, 113, .22);
}

/* RESPONSIVE */

@media(max-width: 650px) {
    .insurance-management-header,
    .insurance-file-details {
        align-items: flex-start;
        flex-direction: column;
    }

    .insurance-file-actions {
        width: 100%;
    }

    .insurance-action {
        flex: 1;
    }

    .insurance-management-card {
        padding: 17px;
    }
}

</style>