
@php
    $company = $shippingCompany ?? null;
@endphp

<style>
/* =========================================================
   SHIPPING COMPANY FORM
   MATCHED TO VERIFICATION MONITORING DARK NAVY THEME
   ========================================================= */

.shipping-form {
    background: #0d1940;
    border: 1px solid #203858;
    border-radius: 15px;
    padding: 25px;
    color: #ffffff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
}

.shipping-form .form-group {
    margin-bottom: 22px;
}

.shipping-form label {
    display: block;
    margin-bottom: 9px;
    color: #cbd5e1;
    font-size: 13px;
    font-weight: 700;
}

.shipping-form input[type="text"],
.shipping-form input[type="file"],
.shipping-form select {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #294365;
    border-radius: 9px;
    background: #102344;
    color: #ffffff;
    outline: none;
    font-size: 13px;
    transition: .2s ease;
}

.shipping-form input:focus,
.shipping-form select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.shipping-form select option {
    background: #102344;
    color: #ffffff;
}

.shipping-form input[type="file"] {
    cursor: pointer;
}

.shipping-form input[type="file"]::file-selector-button {
    background: #263b59;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    padding: 8px 12px;
    margin-right: 12px;
    cursor: pointer;
}

.shipping-form .help-text {
    display: block;
    color: #94a3b8;
    font-size: 11px;
    margin-top: 7px;
}

.shipping-form .field-error {
    color: #fca5a5;
    font-size: 12px;
    margin-top: 6px;
}

.shipping-form .current-logo {
    width: 110px;
    height: 110px;
    padding: 8px;
    background: #ffffff;
    border: 1px solid #294365;
    border-radius: 12px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.shipping-form .current-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.shipping-form .form-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 25px;
}

.shipping-form .save-btn,
.shipping-form .cancel-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 19px;
    border: 0;
    border-radius: 9px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s ease;
}

.shipping-form .save-btn {
    background: #2563eb;
    color: #ffffff;
}

.shipping-form .save-btn:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}

.shipping-form .cancel-btn {
    background: #263b59;
    color: #dbeafe;
}

.shipping-form .cancel-btn:hover {
    background: #344d70;
}

@media(max-width: 500px) {
    .shipping-form {
        padding: 17px;
    }

    .shipping-form .form-actions a,
    .shipping-form .form-actions button {
        width: 100%;
    }
}
</style>

<div class="shipping-form">

    <div class="form-group">
        <label for="company_name">
            Shipping Company Name
            <span style="color:#f87171;">*</span>
        </label>

        <input
            type="text"
            id="company_name"
            name="company_name"
            value="{{ old('company_name', $company?->company_name) }}"
            placeholder="Enter shipping company name"
            maxlength="255"
            required
        >

        @error('company_name')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="logo">Company Logo</label>

        @if($company?->logo_path)
            <div class="current-logo">
                <img
                    src="{{ asset('storage/' . $company->logo_path) }}"
                    alt="Current company logo"
                >
            </div>

            <span class="help-text">
                Current logo. Upload another image only if you want to replace it.
            </span>
        @endif

        <input
            type="file"
            id="logo"
            name="logo"
            accept=".jpg,.jpeg,.png,.webp"
        >

        <span class="help-text">
            Accepted formats: JPG, JPEG, PNG, WEBP. Maximum file size: 5 MB.
        </span>

        @error('logo')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="is_accredited">
            Accreditation Status
            <span style="color:#f87171;">*</span>
        </label>

        <select id="is_accredited" name="is_accredited" required>

            <option value="1"
                {{ (string) old('is_accredited', $company ? (int) $company->is_accredited : 1) === '1' ? 'selected' : '' }}>
                Accredited
            </option>

            <option value="0"
                {{ (string) old('is_accredited', $company ? (int) $company->is_accredited : 1) === '0' ? 'selected' : '' }}>
                Not Accredited
            </option>

        </select>

        <span class="help-text">
            Only companies marked Accredited will appear in the Dean and Cadet portals.
        </span>

        @error('is_accredited')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-actions">

        <button type="submit" class="save-btn">
            <i class="fas fa-save"></i>
            {{ $buttonText }}
        </button>

        <a
            href="{{ route('admin.shipping-companies.index') }}"
            class="cancel-btn"
        >
            <i class="fas fa-times"></i>
            Cancel
        </a>

    </div>

</div>
