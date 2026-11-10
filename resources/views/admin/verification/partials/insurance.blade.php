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
.insurance-management-card {
    margin-top: 25px;
    padding: 24px;
    border-radius: 18px;
    background: #fff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 25px rgba(15, 23, 42, .06);
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
    color: #172554;
    font-size: 18px;
    font-weight: 800;
}

.insurance-management-header p {
    margin: 0;
    color: #64748b;
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
    color: #15803d;
    background: #dcfce7;
}

.insurance-badge.missing {
    color: #b45309;
    background: #fef3c7;
}

.insurance-file-details {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 13px;
    background: #f8fafc;
}

.insurance-file-icon {
    width: 45px;
    height: 45px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    border-radius: 12px;
    background: #dbeafe;
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
    color: #1e293b;
    font-size: 13px;
}

.insurance-file-info small {
    margin-top: 4px;
    color: #64748b;
    font-size: 11px;
}

.insurance-file-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.insurance-action,
.insurance-upload-button,
.insurance-delete-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 7px;
    padding: 10px 13px;
    border: 0;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}

.insurance-action.view {
    background: #e0f2fe;
    color: #0369a1;
}

.insurance-action.download {
    background: #dbeafe;
    color: #1d4ed8;
}

.insurance-divider {
    height: 1px;
    margin: 22px 0;
    background: #e2e8f0;
}

.insurance-form-title {
    margin: 0 0 14px;
    color: #334155;
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
    border: 1px dashed #cbd5e1;
    border-radius: 12px;
    text-align: center;
    background: #f8fafc;
}

.insurance-empty-icon {
    font-size: 27px;
}

.insurance-empty strong {
    color: #334155;
    font-size: 13px;
}

.insurance-empty span {
    color: #64748b;
    font-size: 11px;
}

.insurance-upload-field label {
    display: block;
    margin-bottom: 8px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.insurance-upload-field input {
    width: 100%;
    padding: 11px;
    border: 1px dashed #94a3b8;
    border-radius: 9px;
    background: #f8fafc;
    color: #334155;
    box-sizing: border-box;
}

.insurance-upload-field small {
    display: block;
    margin-top: 7px;
    color: #64748b;
    font-size: 10px;
}

.insurance-upload-button {
    margin-top: 15px;
    background: #1d4ed8;
    color: #fff;
}

.insurance-delete-area {
    margin-top: 15px;
}

.insurance-delete-button {
    background: #fee2e2;
    color: #b91c1c;
}

.insurance-message {
    margin-bottom: 15px;
    padding: 11px 14px;
    border-radius: 9px;
    font-size: 12px;
}

.insurance-message.success {
    color: #166534;
    background: #dcfce7;
}

.insurance-message.error {
    color: #991b1b;
    background: #fee2e2;
}

@media(max-width: 650px) {
    .insurance-management-header,
    .insurance-file-details {
        align-items: flex-start;
        flex-direction: column;
    }

    .insurance-file-actions {
        width: 100%;
    }
}
</style>