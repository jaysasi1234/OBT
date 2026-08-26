@extends('layouts.admin')

@section('header-title', 'Deployment Report')

@section('content')

@vite(['resources/css/admin/reports/deployments.css'])

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="container">

    <div class="main">

        <!-- =====================================================
                            PAGE HEADER
        ====================================================== -->

        <div class="topbar">

            <div>

                <h2>📊 Report Dashboard</h2>

                <p>
                    Monitor deployment performance, cadet statistics,
                    and generate analytical reports in one place.
                </p>

            </div>

            <a href="{{ route('admin.reports.index') }}" class="back-btn">

                <div class="back-content">
                    <span class="back-title">Back</span>
                </div>

            </a>

        </div>


        <!-- =====================================================
                            KPI CARDS
        ====================================================== -->

        <div class="stats-grid">

            <!-- =================================================
                                TOTAL CADETS
            ================================================== -->

            <div class="stat-card">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                ">

                    <div>

                        <div class="stat-title">
                            Total Cadets
                        </div>

                        <div class="stat-value">
                            {{ $grandTotal }}
                        </div>

                        <div class="stat-footer">
                            All registered cadets
                        </div>

                    </div>

                    <div style="
                        width:65px;
                        height:65px;
                        border-radius:18px;
                        background:rgba(59,130,246,.15);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:30px;
                    ">
                        👨‍🎓
                    </div>

                </div>

            </div>


            <!-- =================================================
                                COMPLETED
            ================================================== -->

            <div class="stat-card">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                ">

                    <div>

                        <div class="stat-title">
                            Completed
                        </div>

                        <div class="stat-value"
                             style="color:#22c55e;">

                            {{ $grandCompleted }}

                        </div>

                        <div class="stat-footer">

                            {{
                                $grandTotal
                                ? round(($grandCompleted / $grandTotal) * 100, 1)
                                : 0
                            }}%

                            deployment completion

                        </div>

                    </div>

                    <div style="
                        width:65px;
                        height:65px;
                        border-radius:18px;
                        background:rgba(34,197,94,.15);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:30px;
                    ">
                        ✅
                    </div>

                </div>

            </div>


            <!-- =================================================
                                ONGOING
            ================================================== -->

            <div class="stat-card">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                ">

                    <div>

                        <div class="stat-title">
                            Ongoing
                        </div>

                        <div class="stat-value"
                             style="color:#f59e0b;">

                            {{ $grandOngoing }}

                        </div>

                        <div class="stat-footer">

                            {{
                                $grandTotal
                                ? round(($grandOngoing / $grandTotal) * 100, 1)
                                : 0
                            }}%

                            currently deployed

                        </div>

                    </div>

                    <div style="
                        width:65px;
                        height:65px;
                        border-radius:18px;
                        background:rgba(245,158,11,.15);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:30px;
                    ">
                        🚢
                    </div>

                </div>

            </div>


            <!-- =================================================
                                NOT DEPLOYED
            ================================================== -->

            <div class="stat-card">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                ">

                    <div>

                        <div class="stat-title">
                            Not Deployed
                        </div>

                        <div class="stat-value"
                             style="color:#ef4444;">

                            {{ $grandNot }}

                        </div>

                        <div class="stat-footer">

                            {{
                                $grandTotal
                                ? round(($grandNot / $grandTotal) * 100, 1)
                                : 0
                            }}%

                            waiting for deployment

                        </div>

                    </div>

                    <div style="
                        width:65px;
                        height:65px;
                        border-radius:18px;
                        background:rgba(239,68,68,.15);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:30px;
                    ">
                        ⏳
                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
                            FILTER PANEL
        ====================================================== -->

        <form id="filterForm" method="GET">

            <div class="card">

                <div class="filter-top">

                    <div>

                        <h3 class="filter-title">
                            Filter Analytics
                        </h3>

                        <p class="filter-subtitle">
                            Refine the deployment report by course or batch.
                        </p>

                    </div>

                </div>


                <div class="filter-grid">

                    <!-- COURSE -->

                    <div class="filter-group">

                        <label for="courseFilter">
                            Course
                        </label>

                        <select
                            name="course"
                            id="courseFilter"
                        >

                            <option value="">
                                All Courses
                            </option>

                            @foreach($courses as $course)

                                <option
                                    value="{{ $course->course }}"
                                    {{ request('course') == $course->course ? 'selected' : '' }}
                                >

                                    {{ $course->course }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- BATCH -->

                    <div class="filter-group">

                        <label for="batchFilter">
                            Batch
                        </label>

                        <select
                            name="batch"
                            id="batchFilter"
                        >

                            <option value="">
                                All Batches
                            </option>

                            @foreach($batches as $batch)

                                <option
                                    value="{{ $batch->id }}"
                                    {{ request('batch') == $batch->id ? 'selected' : '' }}
                                >

                                    {{ $batch->batch_year }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

        </form>


        <!-- =====================================================
                            DEPLOYMENT REPORT
        ====================================================== -->

        <div class="card">

            <div class="table-header">

                <div>

                    <h3 class="table-heading">
                        Deployment Percentage Report
                    </h3>

                    <p class="table-subheading">
                        Summary of deployment statistics grouped by course and batch.
                    </p>

                </div>

                <div class="table-badge">

                    {{ count($grouped) }}

                    Group{{ count($grouped) != 1 ? 's' : '' }}

                </div>

            </div>


            <div class="table-responsive">

                <table class="report-table">

                    <thead>

                        <tr>

                            <th>Course</th>

                            <th>Batch</th>

                            <th>Total</th>

                            {{-- KEEP DOMESTIC --}}

                            <th>Domestic</th>

                            {{-- KEEP INTERNATIONAL --}}

                            <th>International</th>

                            <th>Deployment%</th>

                            <th>OBT Comp.</th>

                            <th>Ongoing</th>

                            <th>Not Deployed</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($grouped as $group)

                        @php

                            $total = $group['total'];

                            $completed = collect($group['cadets'])
                                ->where('status', 'Completed')
                                ->count();

                            $ongoing = collect($group['cadets'])
                                ->where('status', 'Ongoing')
                                ->count();

                            $not = collect($group['cadets'])
                                ->where('status', 'Not Deployed')
                                ->count();

                            $deployed = $completed + $ongoing;

                            $deploymentPercent = $total
                                ? round(($deployed / $total) * 100, 1)
                                : 0;

                            $completedPercent = $total
                                ? round(($completed / $total) * 100, 1)
                                : 0;

                            $ongoingPercent = $total
                                ? round(($ongoing / $total) * 100, 1)
                                : 0;

                            $notPercent = $total
                                ? round(($not / $total) * 100, 1)
                                : 0;

                        @endphp


                        <tr>

                            <!-- COURSE -->

                            <td>

                                <span class="course-pill">

                                    {{ $group['course'] }}

                                </span>

                            </td>


                            <!-- BATCH -->

                            <td>

                                {{ $group['batch_year'] }}

                            </td>


                            <!-- TOTAL -->

                            <td>

                                <strong>
                                    {{ $total }}
                                </strong>

                            </td>


                            <!-- DOMESTIC -->

                            <td>

                                <span
                                    class="value"
                                    style="color:#38bdf8;"
                                >

                                    {{ $group['domestic'] }}

                                </span>

                            </td>


                            <!-- INTERNATIONAL -->

                            <td>

                                <span
                                    class="value"
                                    style="color:#a855f7;"
                                >

                                    {{ $group['international'] }}

                                </span>

                            </td>


                            <!-- DEPLOYMENT PERCENTAGE -->

                            <td>

                                <div class="progress">

                                    <div
                                        class="progress-success"
                                        style="
                                            width:{{ $deploymentPercent }}%;
                                            background:#3b82f6;
                                        "
                                    >
                                    </div>

                                </div>

                                <span
                                    class="value"
                                    style="color:#60a5fa;"
                                >

                                    {{ $deploymentPercent }}%

                                </span>

                            </td>


                            <!-- OBT COMPLETED -->

                            <td>

                                <div class="progress-cell">

                                    <div class="progress">

                                        <div
                                            class="progress-success"
                                            style="
                                                width:{{ $completedPercent }}%;
                                            "
                                        >
                                        </div>

                                    </div>

                                    <span class="value success">

                                        {{ $completed }}

                                        ({{ $completedPercent }}%)

                                    </span>

                                </div>

                            </td>


                            <!-- ONGOING -->

                            <td>

                                <div class="progress-cell">

                                    <div class="progress">

                                        <div
                                            class="progress-warning"
                                            style="
                                                width:{{ $ongoingPercent }}%;
                                            "
                                        >
                                        </div>

                                    </div>

                                    <span class="value warning">

                                        {{ $ongoing }}

                                        ({{ $ongoingPercent }}%)

                                    </span>

                                </div>

                            </td>


                            <!-- NOT DEPLOYED -->

                            <td>

                                <div class="progress-cell">

                                    <div class="progress">

                                        <div
                                            class="progress-danger"
                                            style="
                                                width:{{ $notPercent }}%;
                                            "
                                        >
                                        </div>

                                    </div>

                                    <span class="value danger">

                                        {{ $not }}

                                        ({{ $notPercent }}%)

                                    </span>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="9">

                                <div class="empty-state">

                                    📄

                                    <h3>
                                        No Report Data Found
                                    </h3>

                                    <p>
                                        No deployment records match the selected filters.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>


                    <!-- =================================================
                                        TOTAL FOOTER
                    ================================================== -->

                    @php

                        $grandDeploymentPercent = $grandTotal
                            ? round(
                                (
                                    ($grandCompleted + $grandOngoing)
                                    / $grandTotal
                                ) * 100,
                                1
                            )
                            : 0;

                    @endphp


                    <tfoot>

                        <tr>

                            <th>
                                Total
                            </th>

                            <th>

                                {{ $totalBatches }}

                                Batch{{ $totalBatches != 1 ? 'es' : '' }}

                            </th>

                            <th>
                                {{ $grandTotal }}
                            </th>

                            {{-- DOMESTIC TOTAL --}}

                            <th>
                                {{ $grandDomestic }}
                            </th>

                            {{-- INTERNATIONAL TOTAL --}}

                            <th>
                                {{ $grandInternational }}
                            </th>

                            <th style="color:#60a5fa;">

                                {{ $grandDeploymentPercent }}%

                            </th>

                            <th>
                                {{ $grandCompleted }}
                            </th>

                            <th>
                                {{ $grandOngoing }}
                            </th>

                            <th>
                                {{ $grandNot }}
                            </th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>


        <!-- =====================================================
                            ANALYTICS
        ====================================================== -->

        <div class="analytics-header">

            <div>

                <h3 class="analytics-title">
                    Deployment Analytics
                </h3>

                <p class="analytics-subtitle">
                    Visual overview of cadet deployment distribution.
                </p>

            </div>

        </div>


        <div class="chart-grid">

            <!-- =================================================
                                    PIE CHART
            ================================================== -->

            <div class="chart-card">

                <div class="chart-card-header">

                    <div>

                        <h4>
                            Deployment Distribution
                        </h4>

                        <small>
                            Percentage of all cadets
                        </small>

                    </div>

                    <div class="chart-icon">
                        🥧
                    </div>

                </div>

                <div class="chart-body">

                    <canvas id="pieChart"></canvas>

                </div>

            </div>


            <!-- =================================================
                                    BAR CHART
            ================================================== -->

            <div class="chart-card">

                <div class="chart-card-header">

                    <div>

                        <h4>
                            Deployment Comparison
                        </h4>

                        <small>
                            Completed vs Ongoing vs Waiting
                        </small>

                    </div>

                    <div class="chart-icon">
                        📊
                    </div>

                </div>

                <div class="chart-body">

                    <canvas id="barChart"></canvas>

                </div>

            </div>

        </div>


        <!-- =====================================================
                            REPORT ACTIONS
        ====================================================== -->

        <div class="report-toolbar">

            <div>

                <h3 class="toolbar-title">
                    Report Actions
                </h3>

                <p class="toolbar-subtitle">
                    Generate the deployment report in PDF format.
                </p>

            </div>

            <div class="toolbar-buttons">

                <a
                    href="{{ route('admin.reports.deployment.pdf', request()->all()) }}"
                    class="btn btn-report"
                >

                    📄 Generate Report

                </a>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
                        CHART DATA
========================================================= -->

<script>

const domestic =
    {{ $grandDomestic }};

const international =
    {{ $grandInternational }};

const completed =
    {{ $grandCompleted }};

const ongoing =
    {{ $grandOngoing }};

const notDeployed =
    {{ $grandNot }};

</script>


<!-- =========================================================
                        CHARTS
========================================================= -->

<script>

/* =========================================================
   PIE CHART
========================================================= */

const pieCanvas =
    document.getElementById('pieChart');

if (pieCanvas) {

    new Chart(pieCanvas, {

        type: 'pie',

        data: {

            labels: [
                'Completed',
                'Ongoing',
                'Not Deployed'
            ],

            datasets: [{

                data: [
                    completed,
                    ongoing,
                    notDeployed
                ],

                backgroundColor: [
                    '#1f4fff',
                    '#ff7b7b',
                    '#5f9cff'
                ],

                borderColor: '#122446',

                borderWidth: 3

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {

                        color: '#e2e8f0',

                        padding: 20,

                        boxWidth: 16,

                        font: {

                            size: 13,

                            weight: '600'

                        }

                    }

                },

                tooltip: {

                    backgroundColor: '#122446',

                    titleColor: '#ffffff',

                    bodyColor: '#ffffff',

                    borderColor: '#3b82f6',

                    borderWidth: 1

                }

            }

        }

    });

}


/* =========================================================
   BAR CHART
========================================================= */

const barCanvas =
    document.getElementById('barChart');

if (barCanvas) {

    new Chart(barCanvas, {

        type: 'bar',

        data: {

            labels: [
                'Completed',
                'Ongoing',
                'Not Deployed'
            ],

            datasets: [{

                label: 'Cadets',

                data: [
                    completed,
                    ongoing,
                    notDeployed
                ],

                backgroundColor: [
                    '#1f4fff',
                    '#ff7b7b',
                    '#5f9cff'
                ],

                borderRadius: 8,

                borderSkipped: false,

                barThickness: 45

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    labels: {

                        color: '#ffffff'

                    }

                }

            },

            scales: {

                x: {

                    ticks: {

                        color: '#ffffff'

                    },

                    grid: {

                        color:
                            'rgba(255,255,255,0.08)'

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {

                        color: '#ffffff',

                        precision: 0

                    },

                    grid: {

                        color:
                            'rgba(255,255,255,0.08)'

                    }

                }

            }

        }

    });

}


/* =========================================================
   FILTERS
========================================================= */

const form =
    document.getElementById('filterForm');

const course =
    document.getElementById('courseFilter');

const batch =
    document.getElementById('batchFilter');


if (course) {

    course.addEventListener('change', function () {

        form.submit();

    });

}


if (batch) {

    batch.addEventListener('change', function () {

        form.submit();

    });

}

</script>

@endsection