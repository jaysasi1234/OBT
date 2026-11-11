
@extends('layouts.admin')

@section('content')

<style>
.remarks-report-page {
    min-height: 100vh;
    padding: 28px;
    background: #07152f;
    color: #eaf1ff;
}

.remarks-report-page .report-header {
    margin-bottom: 25px;
}

.remarks-report-page h1 {
    font-size: 26px;
    font-weight: 800;
    margin-bottom: 7px;
}

.remarks-report-page .subtitle {
    color: #9eb1d0;
    font-size: 13px;
}

.remarks-report-page .panel {
    background: #0d2042;
    border: 1px solid #1d365e;
    border-radius: 14px;
    padding: 22px;
    margin-bottom: 22px;
}

.remarks-report-page .stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}

.remarks-report-page .stat-card {
    background: #10284e;
    border: 1px solid #29446c;
    border-radius: 13px;
    padding: 20px;
}

.remarks-report-page .stat-card small {
    color: #a8bad7;
    font-size: 12px;
}

.remarks-report-page .stat-card h2 {
    font-size: 28px;
    font-weight: 800;
    margin: 10px 0 0;
}

.remarks-report-page .filters {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    align-items: end;
}

.remarks-report-page label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 7px;
    color: #c5d5ef;
}

.remarks-report-page input,
.remarks-report-page select {
    width: 100%;
    padding: 11px 12px;
    border-radius: 8px;
    background: #071832;
    border: 1px solid #30496f;
    color: white;
    outline: none;
}

.remarks-report-page .actions {
    display: flex;
    gap: 9px;
    flex-wrap: wrap;
    margin-top: 18px;
}

.remarks-report-page .btn {
    border: 0;
    border-radius: 8px;
    padding: 11px 16px;
    text-decoration: none;
    color: white;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-block;
}

.remarks-report-page .btn-primary {
    background: #2563eb;
}

.remarks-report-page .btn-secondary {
    background: #334b70;
}

.remarks-report-page .btn-danger {
    background: #b42332;
}

.remarks-report-page .table-wrap {
    overflow-x: auto;
}

.remarks-report-page table {
    width: 100%;
    min-width: 1050px;
    border-collapse: collapse;
}

.remarks-report-page th {
    background: #142c50;
    color: #a9c7f4;
    font-size: 11px;
    text-transform: uppercase;
    padding: 14px 12px;
    text-align: left;
    white-space: nowrap;
}

.remarks-report-page td {
    padding: 14px 12px;
    border-bottom: 1px solid #263c60;
    font-size: 12px;
    vertical-align: top;
}

.remarks-report-page tbody tr:hover {
    background: #13294b;
}

.remarks-report-page .remark-text {
    min-width: 220px;
    max-width: 380px;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
    color: #dce8fb;
}

.remarks-report-page .status {
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 800;
    white-space: nowrap;
}

.remarks-report-page .has-remarks {
    background: #123f36;
    color: #6ee7b7;
}

.remarks-report-page .no-remarks {
    background: #49301b;
    color: #fdba74;
}

.remarks-report-page .pagination {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.remarks-report-page .pagination a,
.remarks-report-page .pagination span {
    background: #142c50;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
}

.remarks-report-page .pagination .active span {
    background: #2563eb;
}

.remarks-report-page .pagination .disabled span {
    opacity: .4;
}

.remarks-report-page .empty {
    text-align: center;
    padding: 35px;
    color: #9eb1d0;
}

@media(max-width: 850px) {
    .remarks-report-page .stats {
        grid-template-columns: 1fr;
    }

    .remarks-report-page .filters {
        grid-template-columns: 1fr 1fr;
    }
}

@media(max-width: 550px) {
    .remarks-report-page {
        padding: 14px;
    }

    .remarks-report-page .filters {
        grid-template-columns: 1fr;
    }
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

        <!-- PAGINATION -->
        <div class="pagination">
            {{ $cadets->links() }}
        </div>

    </div>

</div>

@endsection
