
@extends('layouts.admin')

@section('content')

<style>

/* =========================================================
   EDIT SHIPPING COMPANY
   MATCHED TO DARK NAVY INSURANCE MANAGEMENT THEME
========================================================= */

.shipping-edit-page {
    padding: 10px 0 30px;
    color: #e2e8f0;
}

.shipping-edit-page * {
    box-sizing: border-box;
}

/* PAGE HEADER */

.shipping-edit-page .page-heading {
    margin-bottom: 22px;
}

.shipping-edit-page .page-heading h2 {
    margin: 0 0 7px;
    color: #f1f5f9;
    font-size: 24px;
    font-weight: 800;
}

.shipping-edit-page .page-heading h2 i {
    color: #60a5fa;
}

.shipping-edit-page .page-heading p {
    margin: 0;
    color: #94a3b8;
    font-size: 13px;
}

/* DARK PAGE BACKGROUND */

body:has(.shipping-edit-page) {
    background: #07152f !important;
}

.admin-content:has(.shipping-edit-page),
.admin-main:has(.shipping-edit-page) {
    background: #07152f !important;
}

/* FORM PANEL */

.shipping-edit-page .shipping-form {
    padding: 24px;
    border: 1px solid rgba(96, 165, 250, .22);
    border-radius: 18px;
    background: linear-gradient(145deg, #0d1940, #111f4d);
    box-shadow: 0 12px 30px rgba(0, 0, 0, .20);
    color: #e2e8f0;
}

/* FORM LABELS */

.shipping-edit-page .shipping-form label {
    color: #cbd5e1;
}

/* INPUTS */

.shipping-edit-page .shipping-form input[type="text"],
.shipping-edit-page .shipping-form input[type="file"],
.shipping-edit-page .shipping-form select {
    border: 1px solid rgba(96, 165, 250, .25);
    border-radius: 9px;
    background: rgba(7, 21, 47, .75);
    color: #e2e8f0;
}

.shipping-edit-page .shipping-form input:focus,
.shipping-edit-page .shipping-form select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.shipping-edit-page .shipping-form select option {
    background: #0d1940;
    color: #e2e8f0;
}

.shipping-edit-page .shipping-form input[type="file"]::file-selector-button {
    background: #1d4ed8;
    color: #fff;
}

/* HELP TEXT */

.shipping-edit-page .shipping-form .help-text {
    color: #94a3b8;
}

/* CURRENT LOGO */

.shipping-edit-page .shipping-form .current-logo {
    background: rgba(7, 21, 47, .75);
    border-color: rgba(96, 165, 250, .20);
}

/* BUTTONS */

.shipping-edit-page .shipping-form .save-btn {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: 1px solid rgba(147, 197, 253, .2);
}

.shipping-edit-page .shipping-form .save-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.shipping-edit-page .shipping-form .cancel-btn {
    background: rgba(148, 163, 184, .12);
    border: 1px solid rgba(148, 163, 184, .18);
    color: #cbd5e1;
}

.shipping-edit-page .shipping-form .cancel-btn:hover {
    background: rgba(148, 163, 184, .22);
    color: #fff;
}

/* RESPONSIVE */

@media(max-width: 600px) {
    .shipping-edit-page .shipping-form {
        padding: 17px;
    }

    .shipping-edit-page .page-heading h2 {
        font-size: 21px;
    }

    .shipping-edit-page .shipping-form .form-actions {
        flex-direction: column;
    }

    .shipping-edit-page .shipping-form .save-btn,
    .shipping-edit-page .shipping-form .cancel-btn {
        width: 100%;
    }
}

</style>

<div class="shipping-edit-page">

    <div class="page-heading">
        <h2><i class="fas fa-edit"></i> Edit Shipping Company</h2>
        <p>Update the company name, logo, or accreditation status.</p>
    </div>

    <form
        action="{{ route('admin.shipping-companies.update', $shippingCompany->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.shipping-companies._form', [
            'shippingCompany' => $shippingCompany,
            'buttonText' => 'Update Shipping Company'
        ])

    </form>

</div>

@endsection
