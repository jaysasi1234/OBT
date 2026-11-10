
@extends('layouts.admin')

@section('content')

<style>
.shipping-create-page { color:#fff; padding:10px 0 30px; }
.shipping-create-page .page-heading { margin-bottom:22px; }
.shipping-create-page .page-heading h2 {
    font-size:24px;
    font-weight:800;
    margin:0 0 7px;
}
.shipping-create-page .page-heading p {
    color:#94a3b8;
    font-size:13px;
    margin:0;
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
