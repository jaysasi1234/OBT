
@php
    $company = $shippingCompany ?? null;
@endphp

<style>
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
.shipping-form input[type="date"],
.shipping-form input[type="file"],
.shipping-form select,
.shipping-form textarea {
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

.shipping-form textarea {
    min-height: 110px;
    resize: vertical;
    line-height: 1.6;
}

.shipping-form input:focus,
.shipping-form select:focus,
.shipping-form textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.shipping-form input::placeholder,
.shipping-form textarea::placeholder {
    color: #8495ad;
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

    {{-- COMPANY NAME --}}
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

    {{-- COMPANY INFORMATION --}}
    <div class="form-group">
        <label for="company_information">
            Company Information
        </label>

        <textarea
            id="company_information"
            name="company_information"
            rows="5"
            maxlength="5000"
            placeholder="Enter a brief description or background of the shipping company..."
        >{{ old('company_information', $company?->company_information) }}</textarea>

        <span class="help-text">
            Provide a brief overview of the shipping company.
        </span>

        @error('company_information')
            <div class="field-error">{{ $message }}</div>
        @enderror
    </div>

{{-- CONTACT INFORMATION --}}
<div class="form-group">
    <label for="company_address">
        Contact Information
    </label>

    <textarea
        id="company_address"
        name="company_address"
        rows="3"
        maxlength="2000"
        placeholder="Enter the company's contact information (phone number, email address, etc.)..."
    >{{ old('company_address', $company?->company_address) }}</textarea>

    <span class="help-text">
        Enter the company's contact details, such as phone number, email address, or other contact information.
    </span>

    @error('company_address')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>


{{-- MARINA ACCREDITATION NUMBER --}}
<div class="form-group">
    <label for="marina_accreditation_number">
        MARINA Accreditation Number
    </label>

    <input
        type="text"
        id="marina_accreditation_number"
        name="marina_accreditation_number"
        value="{{ old('marina_accreditation_number', $company?->marina_accreditation_number) }}"
        placeholder="Enter MARINA accreditation number"
        maxlength="100"
    >

    <span class="help-text">
        Enter the company's official MARINA accreditation number.
    </span>

    @error('marina_accreditation_number')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

{{-- VALIDITY PERIOD --}}
<div class="form-group">
    <label for="valid_from">Valid From</label>

    <input
        type="date"
        id="valid_from"
        name="valid_from"
        value="{{ old('valid_from', $company?->valid_from?->format('Y-m-d')) }}"
    >

    @error('valid_from')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="valid_until">Valid Until</label>

    <input
        type="date"
        id="valid_until"
        name="valid_until"
        value="{{ old('valid_until', $company?->valid_until?->format('Y-m-d')) }}"
    >

    <span class="help-text">
        Enter the expiration date of the MARINA accreditation.
    </span>

    @error('valid_until')
        <div class="field-error">{{ $message }}</div>
    @enderror
</div>


    {{-- COMPANY LOGO --}}
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

    {{-- ACCREDITATION STATUS --}}
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

    {{-- FORM ACTIONS --}}
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
