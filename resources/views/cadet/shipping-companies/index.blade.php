
@extends('layouts.cadet')

@section('content')

<style>
.shipping-page {
    color: #fff;
}

.shipping-header {
    margin-bottom: 25px;
}

.shipping-header h2 {
    font-size: 25px;
    font-weight: 700;
    margin-bottom: 8px;
}

.shipping-header p {
    color: #94a3b8;
    font-size: 14px;
}

.shipping-search {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
}

.shipping-search input {
    flex: 1;
    min-width: 0;
    padding: 13px 16px;
    border-radius: 10px;
    border: 1px solid #263e68;
    background: #10203e;
    color: #fff;
    outline: none;
}

.shipping-search input:focus {
    border-color: #3b82f6;
}

.shipping-search button {
    padding: 0 20px;
    border: none;
    border-radius: 10px;
    background: #2563eb;
    color: white;
    font-weight: 600;
    cursor: pointer;
}

.shipping-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 18px;
}

.shipping-card {
    min-width: 0;
    padding: 25px 18px;
    text-align: center;
    background: linear-gradient(145deg, #10203e, #142b50);
    border: 1px solid rgba(96, 165, 250, .15);
    border-radius: 15px;
    transition: .25s ease;
    cursor: pointer;
}

.shipping-card:hover {
    transform: translateY(-4px);
    border-color: #3b82f6;
    box-shadow: 0 12px 25px rgba(0, 0, 0, .2);
}

.shipping-logo {
    width: 105px;
    height: 105px;
    margin: 0 auto 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: 50%;
    background: #fff;
    padding: 10px;
}

.shipping-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.shipping-logo i {
    font-size: 38px;
    color: #64748b;
}

.shipping-card h3 {
    font-size: 15px;
    line-height: 1.5;
    font-weight: 700;
    color: #fff;
    overflow-wrap: anywhere;
}

.shipping-card .view-hint {
    display: block;
    margin-top: 10px;
    color: #93c5fd;
    font-size: 11px;
}


.shipping-modal {
    /* FORCE MODAL TO THE CENTER OF THE SCREEN */
    position: fixed !important;
    top: 50% !important;
    left: 50% !important;
    right: auto !important;
    bottom: auto !important;
    inset: 50% auto auto 50% !important;
    transform: translate(-50%, -50%) !important;

    /* REMOVE DEFAULT DIALOG MARGIN */
    margin: 0 !important;

    /* MODAL SIZE */
    width: min(540px, calc(100vw - 30px));
    max-width: 540px;
    max-height: calc(100vh - 30px);

    /* MODAL DESIGN */
    padding: 0;
    overflow: auto;
    border: 1px solid #294365;
    border-radius: 17px;
    background: #0d1940;
    color: #fff;
    box-shadow: 0 25px 70px rgba(0, 0, 0, .5);
}


.shipping-modal::backdrop {
    background: rgba(2, 8, 23, .82);
    backdrop-filter: blur(5px);
}

.shipping-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 18px 20px;
    border-bottom: 1px solid rgba(148, 163, 184, .15);
}

.shipping-modal-header h3 {
    margin: 0;
    color: #f1f5f9;
    font-size: 16px;
    font-weight: 800;
}

.shipping-modal-close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border: 1px solid #294365;
    border-radius: 8px;
    background: #172b4d;
    color: #cbd5e1;
    cursor: pointer;
}

.shipping-modal-close:hover {
    background: #263b59;
    color: #fff;
}

.shipping-modal-body {
    padding: 25px;
}

.shipping-modal-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 110px;
    height: 110px;
    margin: 0 auto 15px;
    padding: 10px;
    border-radius: 15px;
    background: #fff;
}

.shipping-modal-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.shipping-modal-logo i {
    color: #64748b;
    font-size: 42px;
}

.shipping-modal-name {
    margin-bottom: 25px;
    color: #f8fafc;
    text-align: center;
    font-size: 20px;
    font-weight: 800;
    line-height: 1.5;
    overflow-wrap: anywhere;
}

.shipping-detail {
    margin-bottom: 15px;
    padding: 16px;
    border: 1px solid rgba(96, 165, 250, .18);
    border-radius: 11px;
    background: rgba(7, 21, 47, .65);
}

.shipping-detail-label {
    display: block;
    margin-bottom: 9px;
    color: #93c5fd;
    font-size: 12px;
    font-weight: 800;
}

.shipping-detail-content {
    margin: 0;
    color: #cbd5e1;
    font-size: 13px;
    line-height: 1.8;
    overflow-wrap: anywhere;
    white-space: pre-line;
}

.shipping-modal-footer {
    display: flex;
    justify-content: flex-end;
    padding: 15px 20px;
    border-top: 1px solid rgba(148, 163, 184, .15);
}

.shipping-modal-footer button {
    padding: 11px 20px;
    border: 0;
    border-radius: 9px;
    background: #2563eb;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}

.shipping-modal-footer button:hover {
    background: #1d4ed8;
}

/* EMPTY STATE */

.shipping-empty {
    grid-column: 1 / -1;
    padding: 55px 20px;
    text-align: center;
    background: #10203e;
    border: 1px solid #263e68;
    border-radius: 15px;
    color: #94a3b8;
}

.shipping-empty i {
    display: block;
    font-size: 40px;
    margin-bottom: 15px;
}

.shipping-pagination {
    margin-top: 25px;
}

/* RESPONSIVE */

@media(max-width: 480px) {
    .shipping-search {
        flex-direction: column;
    }

    .shipping-search button {
        padding: 13px;
    }

    .shipping-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .shipping-card {
        padding: 18px 10px;
    }

    .shipping-logo {
        width: 80px;
        height: 80px;
    }

    .shipping-card h3 {
        font-size: 13px;
    }

    .shipping-modal-body {
        padding: 17px;
    }

    .shipping-modal-name {
        font-size: 17px;
    }
}
</style>

<div class="shipping-page">

    {{-- PAGE HEADER --}}
    <div class="shipping-header">
        <h2>
            <i class="fas fa-ship"></i>
            Accredited Shipping Companies
        </h2>

        <p>
            Browse the shipping companies accredited by the academy.
            Click a company to view its information and contact details.
        </p>
    </div>

    {{-- SEARCH --}}
    <form method="GET"
          action="{{ route('cadet.shipping-companies.index') }}"
          class="shipping-search">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search shipping company..."
        >

        <button type="submit">
            <i class="fas fa-search"></i>
            Search
        </button>

    </form>

    {{-- SHIPPING COMPANY CARDS --}}
    <div class="shipping-grid">

        @forelse($companies as $company)

            <div
                class="shipping-card"
                role="button"
                tabindex="0"
                aria-label="View details for {{ $company->company_name }}"
                onclick="document.getElementById('shippingModal{{ $company->id }}').showModal()"
                onkeydown="if(event.key === 'Enter' || event.key === ' '){event.preventDefault();document.getElementById('shippingModal{{ $company->id }}').showModal();}"
            >

                <div class="shipping-logo">

                    @if($company->logo_path)
                        <img
                            src="{{ asset('storage/' . $company->logo_path) }}"
                            alt="{{ $company->company_name }} logo"
                        >
                    @else
                        <i class="fas fa-ship"></i>
                    @endif

                </div>

                <h3>{{ $company->company_name }}</h3>

                <span class="view-hint">
                    <i class="fas fa-eye"></i>
                    Click to view company details
                </span>

            </div>

            {{-- COMPANY DETAILS MODAL --}}
            <dialog
                class="shipping-modal"
                id="shippingModal{{ $company->id }}"
            >

                <div class="shipping-modal-header">

                    <h3>
                        <i class="fas fa-building"></i>
                        Shipping Company Details
                    </h3>

                    <button
                        type="button"
                        class="shipping-modal-close"
                        onclick="this.closest('dialog').close()"
                        aria-label="Close modal"
                    >
                        <i class="fas fa-times"></i>
                    </button>

                </div>

                <div class="shipping-modal-body">

                    {{-- COMPANY LOGO --}}
                    <div class="shipping-modal-logo">

                        @if($company->logo_path)
                            <img
                                src="{{ asset('storage/' . $company->logo_path) }}"
                                alt="{{ $company->company_name }} logo"
                            >
                        @else
                            <i class="fas fa-ship"></i>
                        @endif

                    </div>

                    {{-- COMPANY NAME --}}
                    <div class="shipping-modal-name">
                        {{ $company->company_name }}
                    </div>

                    {{-- COMPANY INFORMATION --}}
                    <div class="shipping-detail">

                        <span class="shipping-detail-label">
                            <i class="fas fa-info-circle"></i>
                            Company Information
                        </span>

                        <p class="shipping-detail-content">
                            {{ $company->company_information ?: 'Company information is not yet available.' }}
                        </p>

                    </div>

{{-- CONTACT INFORMATION --}}
<div class="shipping-detail">

    <span class="shipping-detail-label">
        <i class="fas fa-address-card"></i>
        Contact Information
    </span>

    <p class="shipping-detail-content">
        {{ $company->company_address ?: 'Contact information is not yet available.' }}
    </p>

</div>


{{-- MARINA ACCREDITATION NUMBER --}}
<div class="shipping-detail">

    <span class="shipping-detail-label">
        <i class="fas fa-certificate"></i>
        MARINA Accreditation Number
    </span>

    <p class="shipping-detail-content">
        {{ $company->marina_accreditation_number ?: 'Not provided.' }}
    </p>

</div>

{{-- VALID FROM --}}
<div class="shipping-detail">

    <span class="shipping-detail-label">
        <i class="fas fa-calendar-check"></i>
        Valid From
    </span>

    <p class="shipping-detail-content">
        {{ $company->valid_from?->format('F d, Y') ?? 'Not specified.' }}
    </p>

</div>

{{-- VALID UNTIL --}}
<div class="shipping-detail">

    <span class="shipping-detail-label">
        <i class="fas fa-calendar-times"></i>
        Valid Until
    </span>

    <p class="shipping-detail-content">
        {{ $company->valid_until?->format('F d, Y') ?? 'Not specified.' }}
    </p>

</div>


                </div>

                <div class="shipping-modal-footer">

                    <button
                        type="button"
                        onclick="this.closest('dialog').close()"
                    >
                        <i class="fas fa-times"></i>
                        Close
                    </button>

                </div>

            </dialog>

        @empty

            <div class="shipping-empty">

                <i class="fas fa-ship"></i>

                <h3>No Accredited Shipping Companies Found</h3>

                <p>
                    @if(request('search'))
                        No company matches your search.
                    @else
                        There are currently no accredited shipping companies available.
                    @endif
                </p>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="shipping-pagination">
        {{ $companies->links() }}
    </div>

</div>

@endsection
