
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
}
</style>

<div class="shipping-page">

    <div class="shipping-header">
        <h2>
            <i class="fas fa-ship"></i>
            Accredited Shipping Companies
        </h2>

        <p>
            Browse the shipping companies accredited by the academy.
        </p>
    </div>

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

    <div class="shipping-grid">

        @forelse($companies as $company)

            <div class="shipping-card">

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

            </div>

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

    <div class="shipping-pagination">
        {{ $companies->links() }}
    </div>

</div>

@endsection
