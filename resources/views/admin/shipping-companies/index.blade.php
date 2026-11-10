
@extends('layouts.admin')

@section('content')

<style>

/* =========================================================
   ACCREDITED SHIPPING COMPANIES
   MATCHED TO CADET INSURANCE MANAGEMENT DARK NAVY THEME
========================================================= */

.shipping-admin {
    padding: 10px 0 30px;
    color: #e2e8f0;
}

.shipping-admin * {
    box-sizing: border-box;
}

/* PAGE HEADER */

.shipping-admin .page-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}

.shipping-admin .page-heading h2 {
    margin: 0 0 7px;
    color: #f1f5f9;
    font-size: 25px;
    font-weight: 800;
}

.shipping-admin .page-heading p {
    margin: 0;
    color: #94a3b8;
    font-size: 13px;
}

.shipping-admin .add-company-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 12px 18px;
    border: 1px solid rgba(147, 197, 253, .2);
    border-radius: 9px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: .2s ease;
}

.shipping-admin .add-company-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    transform: translateY(-1px);
}

/* STATISTICS */

.shipping-admin .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.shipping-admin .stat-card {
    position: relative;
    padding: 20px;
    border: 1px solid rgba(96, 165, 250, .22);
    border-radius: 15px;
    background: linear-gradient(145deg, #0d1940, #111f4d);
    box-shadow: 0 12px 30px rgba(0, 0, 0, .20);
}

.shipping-admin .stat-card span {
    display: block;
    margin-bottom: 10px;
    color: #94a3b8;
    font-size: 12px;
}

.shipping-admin .stat-card strong {
    color: #f1f5f9;
    font-size: 27px;
    font-weight: 800;
}

.shipping-admin .stat-card > i {
    float: right;
    color: #60a5fa;
    font-size: 22px;
}

/* MAIN PANEL */

.shipping-admin .panel {
    overflow: hidden;
    border: 1px solid rgba(96, 165, 250, .22);
    border-radius: 18px;
    background: linear-gradient(145deg, #0d1940, #111f4d);
    box-shadow: 0 12px 30px rgba(0, 0, 0, .20);
}

.shipping-admin .panel-header {
    padding: 19px 20px;
    border-bottom: 1px solid rgba(148, 163, 184, .15);
}

.shipping-admin .panel-header h3 {
    margin: 0;
    color: #f1f5f9;
    font-size: 16px;
    font-weight: 800;
}

/* SEARCH AND FILTERS */

.shipping-admin .filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 18px 20px;
}

.shipping-admin .filters input,
.shipping-admin .filters select {
    min-height: 42px;
    padding: 9px 13px;
    border: 1px solid rgba(96, 165, 250, .25);
    border-radius: 9px;
    outline: none;
    background: rgba(7, 21, 47, .75);
    color: #e2e8f0;
    font-size: 12px;
}

.shipping-admin .filters input {
    flex: 1;
    min-width: 200px;
}

.shipping-admin .filters input::placeholder {
    color: #64748b;
}

.shipping-admin .filters select {
    min-width: 170px;
}

.shipping-admin .filters select option {
    background: #0d1940;
    color: #e2e8f0;
}

.shipping-admin .filters input:focus,
.shipping-admin .filters select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.shipping-admin .filters button,
.shipping-admin .reset-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 42px;
    padding: 9px 16px;
    border: 1px solid transparent;
    border-radius: 9px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
}

.shipping-admin .filters button:hover {
    background: #3b82f6;
}

.shipping-admin .reset-btn {
    background: rgba(148, 163, 184, .12);
    border-color: rgba(148, 163, 184, .18);
    color: #cbd5e1;
}

.shipping-admin .reset-btn:hover {
    background: rgba(148, 163, 184, .22);
    color: #fff;
}

/* TABLE */

.shipping-admin .table-wrap {
    overflow-x: auto;
}

.shipping-admin table {
    width: 100%;
    min-width: 760px;
    border-collapse: collapse;
    background: transparent;
}

.shipping-admin thead {
    background: rgba(7, 21, 47, .65);
}

.shipping-admin th {
    padding: 14px 17px;
    color: #94a3b8;
    text-align: left;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
    white-space: nowrap;
}

.shipping-admin td {
    padding: 15px 17px;
    border-top: 1px solid rgba(148, 163, 184, .13);
    color: #cbd5e1;
    font-size: 13px;
    vertical-align: middle;
}

.shipping-admin tbody tr {
    background: transparent;
    transition: .2s ease;
}

.shipping-admin tbody tr:hover {
    background: rgba(37, 99, 235, .09);
}

/* COMPANY LOGO AND NAME */

.shipping-admin .company-info {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 230px;
}

.shipping-admin .company-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    padding: 5px;
    overflow: hidden;
    border: 1px solid rgba(96, 165, 250, .20);
    border-radius: 12px;
    background: rgba(7, 21, 47, .75);
}

.shipping-admin .company-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.shipping-admin .company-logo i {
    color: #60a5fa;
    font-size: 21px;
}

.shipping-admin .company-name {
    color: #f1f5f9;
    font-weight: 700;
}

/* ACCREDITATION STATUS */

.shipping-admin .status {
    display: inline-block;
    padding: 6px 10px;
    border: 1px solid transparent;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.shipping-admin .status.accredited {
    border-color: rgba(74, 222, 128, .25);
    background: rgba(22, 163, 74, .16);
    color: #86efac;
}

.shipping-admin .status.not-accredited {
    border-color: rgba(248, 113, 113, .25);
    background: rgba(220, 38, 38, .13);
    color: #fca5a5;
}

/* ACTION BUTTONS */

.shipping-admin .actions {
    display: flex;
    align-items: center;
    gap: 7px;
}

.shipping-admin .action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border: 1px solid transparent;
    border-radius: 8px;
    color: #fff;
    text-decoration: none;
    cursor: pointer;
    transition: .2s ease;
}

.shipping-admin .edit-btn {
    background: rgba(37, 99, 235, .20);
    border-color: rgba(96, 165, 250, .25);
    color: #93c5fd;
}

.shipping-admin .edit-btn:hover {
    background: #2563eb;
    color: #fff;
}

.shipping-admin .delete-btn {
    background: rgba(220, 38, 38, .13);
    border-color: rgba(248, 113, 113, .25);
    color: #fca5a5;
}

.shipping-admin .delete-btn:hover {
    background: #b91c1c;
    color: #fff;
}

/* EMPTY STATE */

.shipping-admin .empty-state {
    padding: 55px 20px;
    color: #94a3b8;
    text-align: center;
}

.shipping-admin .empty-state i {
    display: block;
    margin-bottom: 12px;
    color: #60a5fa;
    font-size: 38px;
}

.shipping-admin .empty-state strong {
    color: #e2e8f0;
}

.shipping-admin .empty-state p {
    margin-top: 7px;
    color: #94a3b8;
    font-size: 12px;
}

/* ALERT */

.shipping-admin .alert-success {
    margin-bottom: 18px;
    padding: 13px 16px;
    border: 1px solid rgba(74, 222, 128, .22);
    border-radius: 10px;
    background: rgba(22, 163, 74, .13);
    color: #86efac;
    font-size: 12px;
}

/* PAGINATION */

.shipping-admin .pagination-area {
    padding: 18px 20px;
    border-top: 1px solid rgba(148, 163, 184, .13);
}

.shipping-admin .pagination-area nav {
    display: flex;
    justify-content: flex-end;
}

.shipping-admin .pagination-area nav p,
.shipping-admin .pagination-area nav span {
    color: #94a3b8;
}

.shipping-admin .pagination-area nav a {
    color: #93c5fd;
}

.shipping-admin .pagination-area nav a:hover {
    color: #fff;
}

/* RESPONSIVE */

@media(max-width: 700px) {
    .shipping-admin .stats-grid {
        grid-template-columns: 1fr;
    }

    .shipping-admin .page-heading h2 {
        font-size: 21px;
    }

    .shipping-admin .add-company-btn {
        width: 100%;
    }

    .shipping-admin .filters {
        flex-direction: column;
    }

    .shipping-admin .filters input,
    .shipping-admin .filters select,
    .shipping-admin .filters button,
    .shipping-admin .reset-btn {
        width: 100%;
    }

    .shipping-admin .panel {
        border-radius: 13px;
    }

    .shipping-admin .pagination-area {
        overflow-x: auto;
    }
}

</style>

<div class="shipping-admin">

    <div class="page-heading">
        <div>
            <h2><i class="fas fa-ship"></i> Accredited Shipping Companies</h2>
            <p>Manage shipping companies recognized by the academy.</p>
        </div>

        <a href="{{ route('admin.shipping-companies.create') }}" class="add-company-btn">
            <i class="fas fa-plus"></i> Add Shipping Company
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-building"></i>
            <span>Total Companies</span>
            <strong>{{ $totalCompanies }}</strong>
        </div>

        <div class="stat-card">
            <i class="fas fa-check-circle"></i>
            <span>Accredited Companies</span>
            <strong>{{ $accreditedCompanies }}</strong>
        </div>

        <div class="stat-card">
            <i class="fas fa-exclamation-circle"></i>
            <span>Not Accredited</span>
            <strong>{{ $notAccreditedCompanies }}</strong>
        </div>
    </div>

    <div class="panel">

        <div class="panel-header">
            <h3><i class="fas fa-list"></i> Company Records</h3>
        </div>

        <form method="GET"
              action="{{ route('admin.shipping-companies.index') }}"
              class="filters">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search company name..."
            >

            <select name="status">
                <option value="">All Accreditation Status</option>
                <option value="accredited" {{ request('status') === 'accredited' ? 'selected' : '' }}>
                    Accredited
                </option>
                <option value="not_accredited" {{ request('status') === 'not_accredited' ? 'selected' : '' }}>
                    Not Accredited
                </option>
            </select>

            <button type="submit">
                <i class="fas fa-search"></i> Search
            </button>

            <a href="{{ route('admin.shipping-companies.index') }}" class="reset-btn">
                <i class="fas fa-rotate-left"></i> Reset
            </a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shipping Company</th>
                        <th>Accreditation Status</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($companies as $company)
                        <tr>
                            <td>{{ $companies->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="company-info">
                                    <div class="company-logo">
                                        @if($company->logo_path)
                                            <img
                                                src="{{ asset('storage/' . $company->logo_path) }}"
                                                alt="Company logo"
                                            >
                                        @else
                                            <i class="fas fa-ship"></i>
                                        @endif
                                    </div>

                                    <span class="company-name">
                                        {{ $company->company_name }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                @if($company->is_accredited)
                                    <span class="status accredited">
                                        <i class="fas fa-check-circle"></i> Accredited
                                    </span>
                                @else
                                    <span class="status not-accredited">
                                        <i class="fas fa-times-circle"></i> Not Accredited
                                    </span>
                                @endif
                            </td>

                            <td>{{ $company->created_at->format('M d, Y') }}</td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('admin.shipping-companies.edit', $company->id) }}"
                                        class="action-btn edit-btn"
                                        title="Edit"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.shipping-companies.destroy', $company->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this shipping company?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-btn delete-btn" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-ship"></i>
                                    <strong>No shipping companies found.</strong>
                                    <p>Add a company or adjust your search filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-area">
            {{ $companies->links() }}
        </div>

    </div>
</div>

@endsection
