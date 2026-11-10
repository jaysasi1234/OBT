
@extends('layouts.admin')

@section('content')

<style>
.shipping-edit-page { color:#fff; padding:10px 0 30px; }
.shipping-edit-page .page-heading { margin-bottom:22px; }
.shipping-edit-page .page-heading h2 {
    font-size:24px;
    font-weight:800;
    margin:0 0 7px;
}
.shipping-edit-page .page-heading p {
    color:#94a3b8;
    font-size:13px;
    margin:0;
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
