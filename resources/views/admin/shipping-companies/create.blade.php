
@extends('layouts.admin')

@section('content')

<style>

/* =========================================================
   ADD SHIPPING COMPANY
   MATCHED TO DARK NAVY INSURANCE MANAGEMENT THEME
========================================================= */

.shipping-create-page {
    padding: 10px 0 30px;
    color: #e2e8f0;
}

.shipping-create-page * {
    box-sizing: border-box;
}

/* PAGE HEADER */

.shipping-create-page .page-heading {
    margin-bottom: 22px;
}

.shipping-create-page .page-heading h2 {
    margin: 0 0 7px;
    color: #f1f5f9;
    font-size: 24px;
    font-weight: 800;
}

.shipping-create-page .page-heading h2 i {
    color: #60a5fa;
}

.shipping-create-page .page-heading p {
    margin: 0;
    color: #94a3b8;
    font-size: 13px;
}

/* DARK PAGE BACKGROUND */

body:has(.shipping-create-page) {
    background: #07152f !important;
}

.admin-content:has(.shipping-create-page),
.admin-main:has(.shipping-create-page) {
    background: #07152f !important;
}

/* FORM PANEL */

.shipping-create-page .shipping-form {
    padding: 24px;
    border: 1px solid rgba(96, 165, 250, .22);
    border-radius: 18px;
    background: linear-gradient(145deg, #0d1940, #111f4d);
    box-shadow: 0 12px 30px rgba(0, 0, 0, .20);
    color: #e2e8f0;
}

/* FORM LABELS */

.shipping-create-page .shipping-form label {
    color: #cbd5e1;
}

/* INPUTS */

.shipping-create-page .shipping-form input[type="text"],
.shipping-create-page .shipping-form input[type="file"],
.shipping-create-page .shipping-form select {
    border: 1px solid rgba(96, 165, 250, .25);
    border-radius: 9px;
    background: rgba(7, 21, 47, .75);
    color: #e2e8f0;
}

.shipping-create-page .shipping-form input:focus,
.shipping-create-page .shipping-form select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.shipping-create-page .shipping-form select option {
    background: #0d1940;
    color: #e2e8f0;
}

.shipping-create-page .shipping-form input[type="file"]::file-selector-button {
    background: #1d4ed8;
    color: #fff;
}

/* HELP TEXT */

.shipping-create-page .shipping-form .help-text {
    color: #94a3b8;
}

/* CURRENT LOGO */

.shipping-create-page .shipping-form .current-logo {
    background: rgba(7, 21, 47, .75);
    border-color: rgba(96, 165, 250, .20);
}

/* BUTTONS */

.shipping-create-page .shipping-form .save-btn {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: 1px solid rgba(147, 197, 253, .2);
}

.shipping-create-page .shipping-form .save-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.shipping-create-page .shipping-form .cancel-btn {
    background: rgba(148, 163, 184, .12);
    border: 1px solid rgba(148, 163, 184, .18);
    color: #cbd5e1;
}

.shipping-create-page .shipping-form .cancel-btn:hover {
    background: rgba(148, 163, 184, .22);
    color: #fff;
}

/* RESPONSIVE */

@media(max-width: 600px) {
    .shipping-create-page .shipping-form {
        padding: 17px;
    }

    .shipping-create-page .page-heading h2 {
        font-size: 21px;
    }

    .shipping-create-page .shipping-form .form-actions {
        flex-direction: column;
    }

    .shipping-create-page .shipping-form .save-btn,
    .shipping-create-page .shipping-form .cancel-btn {
        width: 100%;
    }
}

</style>

<div class="shipping-create-page">

    <div class="page-heading">
        <h2><i class="fas fa-plus-circle"></i> Add Shipping Company</h2>
        <p>Register a shipping company in the OBT system.</p>
    </div>

    <form
        action="{{ route('admin.shipping-companies.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @include('admin.shipping-companies._form', [
            'buttonText' => 'Save Shipping Company'
        ])

    </form>

</div>

@endsection
