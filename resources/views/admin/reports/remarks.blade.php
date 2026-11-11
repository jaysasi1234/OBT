
@extends('layouts.admin')

@section('content')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>

<style>

/* =========================================================
   GENERATED REMARKS REPORT
   MATCHES CADET MASTERLIST DARK NAVY THEME
========================================================= */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

.remarks-report-page {
    --rr-bg: #070d25;
    --rr-panel: #11183b;
    --rr-panel-2: #151e48;
    --rr-primary: #3b82f6;
    --rr-text: #f8fafc;
    --rr-muted: #94a3b8;
    --rr-border: rgba(255,255,255,.08);

    min-height: 100vh;
    width: 100%;
    padding: 28px;
    font-family: 'Inter', Arial, sans-serif;
    color: var(--rr-text);

    background:
        radial-gradient(circle at 0% 0%, rgba(37,99,235,.20), transparent 32%),
        radial-gradient(circle at 100% 100%, rgba(79,70,229,.16), transparent 32%),
        linear-gradient(180deg, #070d25, #05091c);
}

/* HEADER */

.remarks-report-page .report-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
    padding: 26px 30px;
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 20px;

    background: linear-gradient(135deg, #1b3f9c, #173783 48%, #11285f);

    box-shadow: 0 18px 45px rgba(0,0,0,.32);
}

.remarks-report-page h1 {
    margin: 0;
    color: #fff;
    font-size: 28px;
    font-weight: 800;
}

.remarks-report-page .subtitle {
    margin-top: 8px;
    color: #bdc9ef;
    font-size: 13px;
}

/* PANELS */

.remarks-report-page .panel {
    padding: 25px;
    margin-bottom: 24px;
    background: linear-gradient(180deg, rgba(20,30,70,.96), rgba(13,20,50,.96));
    border: 1px solid var(--rr-border);
    border-radius: 20px;
    box-shadow: 0 18px 45px rgba(0,0,0,.28);
}

.remarks-report-page .panel h3 {
    color: #fff;
    font-size: 17px;
    font-weight: 750;
}

/* STATISTICS */

.remarks-report-page .stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.remarks-report-page .stat-card {
    padding: 22px;
    background: linear-gradient(145deg, #151e48, #11183b);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,.20);
}

.remarks-report-page .stat-card small {
    color: #aebbe2;
    font-size: 12px;
    font-weight: 600;
}

.remarks-report-page .stat-card h2 {
    margin: 10px 0 0;
    color: #fff;
    font-size: 29px;
    font-weight: 800;
}

/* FILTERS */

.remarks-report-page .filters {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 16px;
}

.remarks-report-page label {
    display: block;
    margin-bottom: 7px;
    color: #bcc8ed;
    font-size: 12px;
    font-weight: 700;
}

.remarks-report-page input,
.remarks-report-page select {
    width: 100%;
    min-width: 0;
    min-height: 44px;
    padding: 10px 13px;
    border: 1px solid #303b78;
    border-radius: 10px;
    background: #0d1435;
    color: #f8fafc;
    font-family: inherit;
    font-size: 13px;
    outline: none;
}

.remarks-report-page input:focus,
.remarks-report-page select:focus {
    border-color: #5b78ff;
    box-shadow: 0 0 0 3px rgba(91,120,255,.14);
}

.remarks-report-page select option {
    background: #11183b;
    color: #fff;
}

.remarks-report-page input::placeholder {
    color: #7180a8;
}

/* BUTTONS */

.remarks-report-page .actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
}

.remarks-report-page .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 42px;
    padding: 10px 17px;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 10px;
    color: #fff;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: .25s ease;
}

.remarks-report-page .btn:hover {
    transform: translateY(-2px);
}

.remarks-report-page .btn-primary {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.remarks-report-page .btn-secondary {
    background: linear-gradient(135deg, #475569, #334155);
}

.remarks-report-page .btn-danger {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

/* TABLE */

.remarks-report-page .table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid rgba(255,255,255,.06);
    border-radius: 14px;
}

.remarks-report-page table {
    width: 100%;
    min-width: 1150px;
    border-collapse: separate;
    border-spacing: 0;
    color: #fff;
}

.remarks-report-page thead {
    position: sticky;
    top: 0;
    z-index: 5;
}

.remarks-report-page thead tr {
    background: linear-gradient(135deg, #294db6, #1d367e);
}

.remarks-report-page th {
    padding: 15px 14px;
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: .5px;
    white-space: nowrap;
    border-bottom: 1px solid rgba(255,255,255,.12);
}

.remarks-report-page td {
    padding: 15px 14px;
    color: #d7def7;
    font-size: 12px;
    text-align: center;
    vertical-align: middle;
    border-bottom: 1px solid rgba(255,255,255,.05);
}

.remarks-report-page tbody tr {
    background: #151c40;
    transition: .25s ease;
}

.remarks-report-page tbody tr:nth-child(even) {
    background: #121938;
}

.remarks-report-page tbody tr:hover {
    background: #1e3477;
    box-shadow: inset 4px 0 0 #60a5fa;
}

.remarks-report-page tbody tr:last-child td {
    border-bottom: none;
}

/* REMARKS TEXT */

.remarks-report-page .remark-text {
    min-width: 220px;
    max-width: 380px;
    margin: 0 auto;
    color: #dce8fb;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
    text-align: left;
}

/* STATUS BADGES */

.remarks-report-page .status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 27px;
    padding: 6px 11px;
    border: 1px solid transparent;
    border-radius: 30px;
    font-size: 10px;
    font-weight: 800;
    white-space: nowrap;
}

.remarks-report-page .has-remarks {
    background: rgba(22,163,74,.17);
    border-color: rgba(74,222,128,.18);
    color: #86efac;
}

.remarks-report-page .no-remarks {
    background: rgba(217,119,6,.17);
    border-color: rgba(251,191,36,.18);
    color: #fcd34d;
}

/* EMPTY STATE */

.remarks-report-page .empty {
    padding: 55px 20px;
    color: #9eadd5;
    text-align: center;
}

/* PAGINATION - DARK THEME */

.remarks-report-page .pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 22px 15px;
    border-top: 1px solid rgba(255,255,255,.08);
    overflow-x: auto;
}

.remarks-report-page .pagination-wrapper nav > div:first-child {
    display: none;
}

.remarks-report-page .pagination-wrapper nav > div:last-child {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
}

.remarks-report-page .pagination-wrapper a,
.remarks-report-page .pagination-wrapper span[aria-current="page"] span,
.remarks-report-page .pagination-wrapper span[aria-disabled="true"] span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 12px;
    border: 1px solid #303b78;
    border-radius: 9px;
    background: #151e48;
    color: #dce6ff;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
}

.remarks-report-page .pagination-wrapper a:hover {
    background: #1e3477;
    border-color: #60a5fa;
    color: #fff;
}

.remarks-report-page .pagination-wrapper span[aria-current="page"] span {
    background: #2563eb;
    border-color: #2563eb;
    color: #fff;
}

.remarks-report-page .pagination-wrapper span[aria-disabled="true"] span {
    opacity: .4;
}

/* RESPONSIVE */

@media(max-width: 992px) {
    .remarks-report-page {
        padding: 18px;
    }

    .remarks-report-page .filters {
        grid-template-columns: repeat(2, minmax(0,1fr));
    }
}

@media(max-width: 768px) {
    .remarks-report-page {
        padding: 13px;
    }

    .remarks-report-page .stats {
        grid-template-columns: 1fr;
    }

    .remarks-report-page .panel {
        padding: 17px;
    }

    .remarks-report-page .report-header {
        padding: 20px;
    }

    .remarks-report-page h1 {
        font-size: 23px;
    }
}

@media(max-width: 550px) {
    .remarks-report-page .filters {
        grid-template-columns: 1fr;
    }

    .remarks-report-page .actions {
        flex-direction: column;
    }

    .remarks-report-page .actions .btn {
        width: 100%;
    }
}



/* =========================================================
   FIX WHITE BACKGROUND OUTSIDE GENERATED REMARKS REPORT
   ========================================================= */

/* Main browser page background */
body:has(.remarks-report-page) {
    background: #070d25 !important;
}

/* Admin content background */
body:has(.remarks-report-page) main,
body:has(.remarks-report-page) .main-content,
body:has(.remarks-report-page) .content,
body:has(.remarks-report-page) .content-wrapper,
body:has(.remarks-report-page) .admin-content,
body:has(.remarks-report-page) .page-content,
body:has(.remarks-report-page) #content {
    background: #070d25 !important;
    background-image:
        radial-gradient(
            circle at 0% 0%,
            rgba(37, 99, 235, .12),
            transparent 35%
        ),
        linear-gradient(
            180deg,
            #070d25,
            #05091c
        ) !important;
}

/* Make sure the report fills the available content area */
body:has(.remarks-report-page) .remarks-report-page {
    background-color: transparent;
    min-height: 100vh;
    width: 100%;
    box-sizing: border-box;
}

/* Prevent white backgrounds from appearing around report sections */
body:has(.remarks-report-page) .remarks-report-page .panel,
body:has(.remarks-report-page) .remarks-report-page .stat-card {
    background-color: #11183b;
}


</style>

<div class="remarks-report-page">

    <!-- HEADER -->
    <div class="report-header">

        <h1>Generated Remarks Report</h1>

        <div class="subtitle">
            Consolidated remarks records of registered OBT cadets.
        </div>

    </div>

    <!-- SUMMARY -->
    <div class="stats">

        <div class="stat-card">
            <small>Total Cadet Records</small>
            <h2>{{ number_format($total) }}</h2>
        </div>

        <div class="stat-card">
            <small>Cadets With Remarks</small>
            <h2>{{ number_format($withRemarks) }}</h2>
        </div>

        <div class="stat-card">
            <small>Cadets Without Remarks</small>
            <h2>{{ number_format($noRemarks) }}</h2>
        </div>

    </div>

    <!-- FILTERS -->
    <div class="panel">

        <h3 style="margin:0 0 20px;font-size:17px;">
            <i class="bi bi-funnel"></i>
            Report Filters
        </h3>

        <form method="GET"
              action="{{ route('admin.reports.remarks') }}">

            <div class="filters">

                <div>
                    <label>Search Cadet</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Name or TRB number..."
                    >
                </div>

                <div>
                    <label>Course</label>
                    <select name="course">
                        <option value="">All Courses</option>

                        @foreach($courses as $course)
                            <option
                                value="{{ $course }}"
                                @selected(request('course') == $course)
                            >
                                {{ $course }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Batch</label>
                    <select name="batch">
                        <option value="">All Batches</option>

                        @foreach($batches as $batch)
                            <option
                                value="{{ $batch->id }}"
                                @selected(request('batch') == $batch->id)
                            >
                                {{ $batch->batch_year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Remarks Month</label>
                    <select name="month">
                        <option value="">All Months</option>

                        @foreach([
                            'January', 'February', 'March',
                            'April', 'May', 'June',
                            'July', 'August', 'September',
                            'October', 'November', 'December'
                        ] as $month)
                            <option
                                value="{{ $month }}"
                                @selected(request('month') == $month)
                            >
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Remarks Year</label>
                    <select name="year">
                        <option value="">All Years</option>

                        @foreach($years as $year)
                            <option
                                value="{{ $year }}"
                                @selected(request('year') == $year)
                            >
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Remarks Status</label>
                    <select name="remarks_status">
                        <option value="">All Cadets</option>

                        <option
                            value="with"
                            @selected(request('remarks_status') == 'with')
                        >
                            With Remarks
                        </option>

                        <option
                            value="without"
                            @selected(request('remarks_status') == 'without')
                        >
                            Without Remarks
                        </option>
                    </select>
                </div>

            </div>

            <div class="actions">

                <button type="submit"
                        class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    Apply Filters
                </button>

                <a href="{{ route('admin.reports.remarks') }}"
                   class="btn btn-secondary">
                    Reset
                </a>

                <a href="{{ route('admin.reports.remarks.pdf', request()->query()) }}"
                   class="btn btn-danger"
                   target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Generate PDF
                </a>

            </div>

        </form>

    </div>

    <!-- TABLE -->
    <div class="panel">

        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px;">

            <h3 style="margin:0;font-size:17px;">
                Remarks Records
            </h3>

            <small style="color:#9eb1d0;">
                Showing {{ $cadets->firstItem() ?? 0 }}
                - {{ $cadets->lastItem() ?? 0 }}
                of {{ $cadets->total() }} records
            </small>

        </div>

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>TRB Number</th>
                        <th>Cadet Name</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Remarks</th>
                        <th>Updated By</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($cadets as $cadet)

                        <tr>

                            <td>
                                {{ $cadet->trb_control_number ?? 'N/A' }}
                            </td>

                            <td>
                                <strong>
                                    {{ $cadet->full_name ?? 'N/A' }}
                                </strong>
                            </td>

                            <td>
                                {{ $cadet->course ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $cadet->batch?->batch_year ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $cadet->remarks_month ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $cadet->remarks_year ?? 'N/A' }}
                            </td>

                            <td>
                                <div class="remark-text">
                                    {{ filled($cadet->remarks)
                                        ? $cadet->remarks
                                        : 'No remarks recorded.' }}
                                </div>
                            </td>

                            <td>
                                {{ $cadet->remarks_updated_by ?? 'N/A' }}
                            </td>

                            <td>
                                @if(filled($cadet->remarks))
                                    <span class="status has-remarks">
                                        WITH REMARKS
                                    </span>
                                @else
                                    <span class="status no-remarks">
                                        NO REMARKS
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty">
                                No cadet records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

@if($cadets->hasPages())

    <div class="pagination-wrapper">
        {{ $cadets->links() }}
    </div>

@endif

    </div>

</div>

@endsection
