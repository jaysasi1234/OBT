
@extends('layouts.admin')

@section('content')

<style>
.shipping-admin {
    color: #eaf1ff;
    padding: 10px 0 30px;
}
.shipping-admin * { box-sizing: border-box; }

.shipping-admin .page-heading {
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:25px;
}
.shipping-admin .page-heading h2 {
    font-size:25px;
    font-weight:800;
    margin:0 0 7px;
    color:#fff;
}
.shipping-admin .page-heading p {
    color:#94a3b8;
    margin:0;
    font-size:13px;
}
.shipping-admin .add-company-btn {
    display:inline-flex;
    align-items:center;
    gap:9px;
    padding:12px 18px;
    border-radius:10px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    font-weight:700;
    font-size:13px;
}
.shipping-admin .add-company-btn:hover {
    background:#1d4ed8;
    color:#fff;
}
.shipping-admin .stats-grid {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:16px;
    margin-bottom:22px;
}
.shipping-admin .stat-card {
    background:linear-gradient(145deg,#102344,#142d52);
    border:1px solid rgba(96,165,250,.15);
    border-radius:14px;
    padding:20px;
}
.shipping-admin .stat-card span {
    display:block;
    color:#94a3b8;
    font-size:12px;
    margin-bottom:10px;
}
.shipping-admin .stat-card strong {
    font-size:27px;
    color:#fff;
    font-weight:800;
}
.shipping-admin .stat-card i {
    float:right;
    font-size:22px;
    color:#60a5fa;
}
.shipping-admin .panel {
    background:#0d1b35;
    border:1px solid #203858;
    border-radius:15px;
    overflow:hidden;
}
.shipping-admin .panel-header {
    padding:19px 20px;
    border-bottom:1px solid #203858;
}
.shipping-admin .panel-header h3 {
    color:#fff;
    font-size:16px;
    font-weight:750;
    margin:0;
}
.shipping-admin .filters {
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    padding:18px 20px;
}
.shipping-admin .filters input,
.shipping-admin .filters select {
    min-height:42px;
    padding:9px 13px;
    border:1px solid #294365;
    border-radius:9px;
    background:#102344;
    color:#fff;
    outline:none;
}
.shipping-admin .filters input {
    flex:1;
    min-width:200px;
}
.shipping-admin .filters select { min-width:170px; }
.shipping-admin .filters button,
.shipping-admin .reset-btn {
    min-height:42px;
    padding:9px 16px;
    border:0;
    border-radius:9px;
    background:#2563eb;
    color:#fff;
    font-weight:700;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
}
.shipping-admin .reset-btn {
    background:#263b59;
}
.shipping-admin .table-wrap { overflow-x:auto; }
.shipping-admin table {
    width:100%;
    min-width:760px;
    border-collapse:collapse;
}
.shipping-admin thead { background:#132746; }
.shipping-admin th {
    color:#9fb4d2;
    text-align:left;
    padding:14px 17px;
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.5px;
    white-space:nowrap;
}
.shipping-admin td {
    padding:15px 17px;
    border-top:1px solid #203858;
    color:#dbeafe;
    font-size:13px;
    vertical-align:middle;
}
.shipping-admin tbody tr:hover { background:rgba(37,99,235,.07); }
.shipping-admin .company-info {
    display:flex;
    align-items:center;
    gap:12px;
    min-width:230px;
}
.shipping-admin .company-logo {
    width:48px;
    height:48px;
    flex-shrink:0;
    border-radius:10px;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:5px;
    overflow:hidden;
}
.shipping-admin .company-logo img {
    width:100%;
    height:100%;
    object-fit:contain;
}
.shipping-admin .company-logo i {
    color:#64748b;
    font-size:21px;
}
.shipping-admin .company-name {
    color:#fff;
    font-weight:700;
}
.shipping-admin .status {
    display:inline-block;
    padding:6px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
}
.shipping-admin .status.accredited {
    color:#86efac;
    background:rgba(34,197,94,.13);
}
.shipping-admin .status.not-accredited {
    color:#fca5a5;
    background:rgba(239,68,68,.13);
}
.shipping-admin .actions {
    display:flex;
    align-items:center;
    gap:7px;
}
.shipping-admin .action-btn {
    width:34px;
    height:34px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border:0;
    border-radius:8px;
    color:#fff;
    text-decoration:none;
    cursor:pointer;
}
.shipping-admin .edit-btn { background:#1d4ed8; }
.shipping-admin .delete-btn { background:#991b1b; }
.shipping-admin .empty-state {
    text-align:center;
    padding:55px 20px;
    color:#94a3b8;
}
.shipping-admin .empty-state i {
    font-size:38px;
    margin-bottom:12px;
    display:block;
}
.shipping-admin .pagination-area { padding:18px 20px; }
.shipping-admin .alert-success {
    padding:13px 16px;
    background:rgba(34,197,94,.12);
    border:1px solid rgba(34,197,94,.3);
    color:#86efac;
    border-radius:10px;
    margin-bottom:18px;
}
.shipping-admin .pagination-area nav { display:flex; justify-content:flex-end; }
.shipping-admin .pagination-area nav p { color:#94a3b8; }
.shipping-admin .pagination-area nav a,
.shipping-admin .pagination-area nav span {
    color:#dbeafe;
}
@media(max-width:700px) {
    .shipping-admin .stats-grid { grid-template-columns:1fr; }
    .shipping-admin .page-heading h2 { font-size:21px; }
    .shipping-admin .add-company-btn { width:100%; justify-content:center; }
    .shipping-admin .filters { flex-direction:column; }
    .shipping-admin .filters input,
    .shipping-admin .filters select,
    .shipping-admin .filters button,
    .shipping-admin .reset-btn { width:100%; }
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
