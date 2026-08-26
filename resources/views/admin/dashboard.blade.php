@extends('layouts.admin')

@section('content')

@vite(['resources/css/admin/dashboard.css'])


<div class="main">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="hero">

        <div class="hero-content">

            <div class="hero-left">

                <div class="hero-label">

                    <i class="fas fa-chart-line"></i>

                    OBT Monitoring System

                </div>


                @php

                    $hour = now()->hour;

                    if ($hour < 12) {

                        $greeting = 'Good Morning';

                        $icon = '☀️';

                    } elseif ($hour < 18) {

                        $greeting = 'Good Afternoon';

                        $icon = '🌤️';

                    } else {

                        $greeting = 'Good Evening';

                        $icon = '🌙';

                    }

                @endphp


                <h2>

                    {{ $icon }}

                    {{ $greeting }},

                    {{ Auth::user()->name }}

                </h2>


                <p class="hero-description">

                    Onboard Training Report System Dashboard

                    <br>

                    Monitor cadets, deployments, requirements,

                    verification, and training progress.

                </p>


                <div class="hero-buttons">

                    <a
                        href="{{ route('admin.cadets.index') }}"
                        class="hero-btn"
                    >

                        <i class="fas fa-user-graduate"></i>

                        Manage Cadets

                    </a>


                    <a
                        href="{{ route('admin.deployment.index') }}"
                        class="hero-btn"
                    >

                        <i class="fas fa-ship"></i>

                        Deployments

                    </a>


                    <a
                        href="{{ route('admin.complaints.index') }}"
                        class="hero-btn"
                    >

                        <i class="fas fa-file-circle-exclamation"></i>

                        Complaints

                    </a>

                </div>

            </div>


            <div class="hero-right">

                <div class="hero-date">

                    {{ now()->format('l, F d, Y') }}

                </div>


                <div class="hero-rate">

                    {{ $deploymentPercentage }}%

                </div>


                <div class="hero-rate-label">

                    Overall Deployment Rate

                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         KPI CARDS
    ====================================================== --}}

    <section class="cards">


        {{-- TOTAL CADETS --}}

        <a
            href="{{ route('admin.cadets.index') }}"
            class="card blue"
        >

            <div class="card-top">

                <div>

                    <div class="card-title">
                        Total Cadets
                    </div>

                    <div class="card-number">
                        {{ $totalCadets }}
                    </div>

                </div>


                <div class="card-icon">

                    <i class="fas fa-user-graduate"></i>

                </div>

            </div>


            <div class="card-footer">

                <span>
                    Total Registered
                </span>

                <span>
                    100%
                </span>

            </div>

        </a>



        {{-- ONGOING DEPLOYMENT --}}

        <a
            href="{{ route('admin.deployment.index') }}"
            class="card green"
        >

            <div class="card-top">

                <div>

                    <div class="card-title">
                        Ongoing Deployment
                    </div>

                    <div class="card-number">
                        {{ $totalDeployed }}
                    </div>

                </div>


                <div class="card-icon">

                    <i class="fas fa-ship"></i>

                </div>

            </div>


            <div class="card-footer">

                <span>
                    Currently Onboard
                </span>

                <span>
                    Active
                </span>

            </div>

        </a>



        {{-- COMPLETED --}}

        <div class="card cyan">

            <div class="card-top">

                <div>

                    <div class="card-title">
                        Completed
                    </div>

                    <div class="card-number">
                        {{ $totalCompleted }}
                    </div>

                </div>


                <div class="card-icon">

                    <i class="fas fa-circle-check"></i>

                </div>

            </div>


            <div class="card-footer">

                <span>
                    Finished OBT
                </span>

                <span>
                    Done
                </span>

            </div>

        </div>



        {{-- VERIFICATION --}}

        <div class="card orange">

            <div class="card-top">

                <div>

                    <div class="card-title">
                        Pending Verification
                    </div>

                    <div class="card-number">
                        {{ $pendingVerification }}
                    </div>

                </div>


                <div class="card-icon">

                    <i class="fas fa-file-circle-check"></i>

                </div>

            </div>


            <div class="card-footer">

                <span>
                    Awaiting Review
                </span>

                <span>
                    Pending
                </span>

            </div>

        </div>



        {{-- COMPLAINTS --}}

        <a
            href="{{ route('admin.complaints.index') }}"
            class="card red"
        >

            <div class="card-top">

                <div>

                    <div class="card-title">
                        Complaints
                    </div>

                    <div class="card-number">
                        {{ $withComplaints }}
                    </div>

                </div>


                <div class="card-icon">

                    <i class="fas fa-triangle-exclamation"></i>

                </div>

            </div>


            <div class="card-footer">

                <span>
                    Open Reports
                </span>

                <span>
                    Attention
                </span>

            </div>

        </a>

    </section>



    {{-- =====================================================
         DEPLOYMENT + VERIFICATION
    ====================================================== --}}

    <section class="grid">


        {{-- DEPLOYMENT ANALYTICS --}}

        <div class="box">

            <div class="chart-header">

                <div>

                    <h3>
                        Deployment Analytics
                    </h3>

                    <small>
                        Current cadet deployment status
                    </small>

                </div>


                <span class="badge-chart">
                    Live
                </span>

            </div>


            <canvas id="barChart"></canvas>

        </div>



        {{-- VERIFICATION --}}

        <div class="box">

            <div class="chart-header">

                <div>

                    <h3>
                        Verification Overview
                    </h3>

                    <small>
                        Document verification status
                    </small>

                </div>


                <span class="badge-chart green">
                    Updated
                </span>

            </div>


            <canvas id="pieChart"></canvas>

        </div>

    </section>



    {{-- =====================================================
         BATCH ANALYTICS
    ====================================================== --}}

    <section class="box analytics-box">

        <div class="chart-header">

            <div>

                <h3>
                    📈 Batch Deployment Graphical Summary
                </h3>

                <small>
                    Comparison of total cadets,
                    deployed cadets, and deployment percentage
                </small>

            </div>


            <span class="badge-chart">
                Batch Statistics
            </span>

        </div>


        <canvas id="batchLineChart"></canvas>

    </section>



    {{-- =====================================================
         LOWER ANALYTICS
    ====================================================== --}}

    <section class="analytics-grid">


        {{-- =================================================
             LEFT COLUMN
        ================================================== --}}

        <div>


            {{-- DEPLOYMENT PROGRESS --}}

            <div class="box analytics-box">

                <div class="section-title">

                    <h3>
                        📈 Deployment Progress
                    </h3>

                    <span>
                        {{ $deploymentPercentage }}%
                    </span>

                </div>


                <div class="overall-progress">

                    <div
                        class="overall-fill"
                        style="
                            width:
                            {{ min(100, max(0, $deploymentPercentage)) }}%;
                        "
                    ></div>

                </div>


                @foreach($courseDeployment as $course)

                    <div class="course-progress">

                        <div class="course-header">

                            <span>
                                {{ $course['course'] }}
                            </span>

                            <strong>

                                {{ $course['deployed'] }}

                                /

                                {{ $course['total'] }}

                                ·

                                {{ $course['percentage'] }}%

                            </strong>

                        </div>


                        <div class="progress">

                            <div
                                class="progress-bar"
                                style="
                                    width:
                                    {{ min(100, max(0, $course['percentage'])) }}%;
                                "
                            >

                                @if($course['percentage'] >= 10)

                                    {{ $course['percentage'] }}%

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>



            {{-- COMPLAINT ANALYTICS --}}

            <div class="box analytics-box">

                <div class="chart-header">

                    <div>

                        <h3>
                            📋 Concern Analytics
                        </h3>

                        <small>
                            Current complaint monitoring
                        </small>

                    </div>


                    <span class="badge-chart">

                        Monitoring

                    </span>

                </div>


                <div class="stats-row">


                    <div class="mini-card red">

                        <h1>
                            {{ $withComplaints }}
                        </h1>

                        <small>
                            Open
                        </small>

                    </div>


                    <div class="mini-card green">

                        <h1>
                            {{ $resolvedComplaints }}
                        </h1>

                        <small>
                            Resolved
                        </small>

                    </div>


                    <div class="mini-card blue">

                        <h1>
                            {{ $withComplaints + $resolvedComplaints }}
                        </h1>

                        <small>
                            Total
                        </small>

                    </div>

                </div>

            </div>

        </div>



        {{-- =================================================
             RIGHT COLUMN
        ================================================== --}}

        <div>


            {{-- INCOMPLETE REQUIREMENTS --}}

            <div class="box analytics-box">

                <div class="chart-header">

                    <div>

                        <h3>
                            ⚠ Incomplete Requirements
                        </h3>

                        <small>
                            Cadets requiring attention
                        </small>

                    </div>


                    <span class="badge-chart">

                        {{ count($incompleteRequirements) }}

                    </span>

                </div>


                <div class="requirements-list">

                    @forelse($incompleteRequirements as $cadet)

                        <div class="requirement-card">

                            <div>

                                <strong>
                                    {{ $cadet->full_name }}
                                </strong>

                                <small>
                                    {{ $cadet->course }}
                                </small>

                            </div>


                            <span class="badge-warning">

                                Pending

                            </span>

                        </div>

                    @empty

                        <div class="empty-box">

                            <i class="fas fa-circle-check"></i>

                            No incomplete requirements.

                        </div>

                    @endforelse

                </div>

            </div>



            {{-- SYSTEM SUMMARY --}}

            <div class="box analytics-box">

                <div class="chart-header">

                    <div>

                        <h3>
                            ⚓ System Summary
                        </h3>

                        <small>
                            Current OBT statistics
                        </small>

                    </div>

                </div>


                <div class="summary-row">

                    <span>
                        Total Cadets
                    </span>

                    <strong>
                        {{ $totalCadets }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Ongoing Deployment
                    </span>

                    <strong>
                        {{ $totalDeployed }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Completed OBT
                    </span>

                    <strong>
                        {{ $totalCompleted }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Not Deployed
                    </span>

                    <strong>
                        {{ $notDeployed }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Pending Verification
                    </span>

                    <strong>
                        {{ $pendingVerification }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Deficiency
                    </span>

                    <strong>
                        {{ $deficiency }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Verified
                    </span>

                    <strong>
                        {{ $verified }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        BS Qualified
                    </span>

                    <strong>
                        {{ $bsCompleted }}
                    </strong>

                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="dashboard-footer">

        <i class="fas fa-clock"></i>

        Last Updated

        {{ now()->format('M d, Y · h:i A') }}

    </div>

</div>



{{-- =========================================================
     CHART.JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       CHART GLOBAL SETTINGS
    ===================================================== */

    Chart.defaults.font.family =
        'Inter, sans-serif';

    Chart.defaults.color =
        '#94a3b8';



    /* =====================================================
       DEPLOYMENT BAR CHART
    ===================================================== */

    const barCanvas =
        document.getElementById('barChart');


    if (barCanvas) {

        const barCtx =
            barCanvas.getContext('2d');


        const barGradient1 =
            barCtx.createLinearGradient(
                0,
                0,
                0,
                360
            );

        barGradient1.addColorStop(
            0,
            '#f87171'
        );

        barGradient1.addColorStop(
            1,
            '#dc2626'
        );


        const barGradient2 =
            barCtx.createLinearGradient(
                0,
                0,
                0,
                360
            );

        barGradient2.addColorStop(
            0,
            '#60a5fa'
        );

        barGradient2.addColorStop(
            1,
            '#1d4ed8'
        );


        const barGradient3 =
            barCtx.createLinearGradient(
                0,
                0,
                0,
                360
            );

        barGradient3.addColorStop(
            0,
            '#34d399'
        );

        barGradient3.addColorStop(
            1,
            '#059669'
        );


        new Chart(barCtx, {

            type: 'bar',

            data: {

                labels: [

                    'Not Deployed',

                    'Ongoing',

                    'Completed'

                ],

                datasets: [{

                    label: 'Cadets',

                    data: [

                        {{ $notDeployed }},

                        {{ $totalDeployed }},

                        {{ $totalCompleted }}

                    ],

                    backgroundColor: [

                        barGradient1,

                        barGradient2,

                        barGradient3

                    ],

                    borderRadius: 12,

                    borderSkipped: false,

                    maxBarThickness: 65

                }]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                animation: {

                    duration: 1200,

                    easing: 'easeOutQuart'

                },


                plugins: {

                    legend: {

                        display: false

                    },


                    tooltip: {

                        backgroundColor:
                            '#0f172a',

                        titleColor:
                            '#fff',

                        bodyColor:
                            '#cbd5e1',

                        padding: 12,

                        cornerRadius: 10,

                        displayColors: true

                    }

                },


                scales: {

                    y: {

                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        grid: {

                            color:
                                'rgba(148,163,184,.08)'

                        },

                        ticks: {

                            color:
                                '#94a3b8',

                            precision: 0,

                            padding: 8

                        }

                    },


                    x: {

                        border: {
                            display: false
                        },

                        grid: {

                            display: false

                        },

                        ticks: {

                            color:
                                '#cbd5e1',

                            font: {

                                size: 11,

                                weight: '600'

                            }

                        }

                    }

                }

            }

        });

    }



    /* =====================================================
       VERIFICATION DONUT
    ===================================================== */

    const pieCanvas =
        document.getElementById('pieChart');


    if (pieCanvas) {

        const pieCtx =
            pieCanvas.getContext('2d');


        const verifiedGradient =
            pieCtx.createLinearGradient(
                0,
                0,
                0,
                360
            );

        verifiedGradient.addColorStop(
            0,
            '#34d399'
        );

        verifiedGradient.addColorStop(
            1,
            '#059669'
        );


        const pendingGradient =
            pieCtx.createLinearGradient(
                0,
                0,
                0,
                360
            );

        pendingGradient.addColorStop(
            0,
            '#fbbf24'
        );

        pendingGradient.addColorStop(
            1,
            '#d97706'
        );


        const deficiencyGradient =
            pieCtx.createLinearGradient(
                0,
                0,
                0,
                360
            );

        deficiencyGradient.addColorStop(
            0,
            '#f87171'
        );

        deficiencyGradient.addColorStop(
            1,
            '#dc2626'
        );


        new Chart(pieCtx, {

            type: 'doughnut',

            data: {

                labels: [

                    'Verified',

                    'Pending',

                    'Deficiency'

                ],

                datasets: [{

                    data: [

                        {{ $verified }},

                        {{ $pendingVerification }},

                        {{ $deficiency }}

                    ],

                    backgroundColor: [

                        verifiedGradient,

                        pendingGradient,

                        deficiencyGradient

                    ],

                    borderWidth: 5,

                    borderColor:
                        '#101B48',

                    hoverOffset: 10,

                    cutout: '70%'

                }]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                animation: {

                    duration: 1200,

                    animateRotate: true,

                    animateScale: true

                },


                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            color:
                                '#cbd5e1',

                            padding: 18,

                            boxWidth: 12,

                            boxHeight: 12,

                            usePointStyle: true,

                            pointStyle: 'circle',

                            font: {

                                size: 11,

                                weight: '600'

                            }

                        }

                    },


                    tooltip: {

                        backgroundColor:
                            '#0f172a',

                        padding: 12,

                        cornerRadius: 10,

                        titleColor:
                            '#fff',

                        bodyColor:
                            '#cbd5e1'

                    }

                }

            }

        });

    }



    /* =====================================================
       BATCH DEPLOYMENT CHART
    ===================================================== */

    const batchCanvas =
        document.getElementById('batchLineChart');


    if (batchCanvas) {

        const batchCtx =
            batchCanvas.getContext('2d');


        new Chart(batchCtx, {

            data: {

                labels:
                    @json($batchLabels),


                datasets: [

                    {

                        type: 'bar',

                        label:
                            'Total Cadets',

                        data:
                            @json($batchTotals),

                        backgroundColor:
                            'rgba(148,163,184,.45)',

                        borderColor:
                            '#94a3b8',

                        borderWidth: 1,

                        borderRadius: 8,

                        maxBarThickness: 45

                    },


                    {

                        type: 'bar',

                        label:
                            'Deployed',

                        data:
                            @json($batchDeployed),

                        backgroundColor:
                            'rgba(59,130,246,.78)',

                        borderColor:
                            '#3b82f6',

                        borderWidth: 1,

                        borderRadius: 8,

                        maxBarThickness: 45

                    },


                    {

                        type: 'line',

                        label:
                            'Deployment %',

                        data:
                            @json($batchPercentages),

                        borderColor:
                            '#10b981',

                        backgroundColor:
                            '#10b981',

                        borderWidth: 3,

                        tension: .35,

                        fill: false,

                        yAxisID:
                            'percentage',

                        pointRadius: 5,

                        pointHoverRadius: 8,

                        pointBorderWidth: 2,

                        pointBackgroundColor:
                            '#10b981'

                    }

                ]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                interaction: {

                    mode: 'index',

                    intersect: false

                },


                animation: {

                    duration: 1200,

                    easing: 'easeOutQuart'

                },


                plugins: {

                    legend: {

                        position: 'top',

                        align: 'end',

                        labels: {

                            color:
                                '#cbd5e1',

                            usePointStyle: true,

                            pointStyle: 'circle',

                            padding: 15,

                            font: {

                                size: 11,

                                weight: '600'

                            }

                        }

                    },


                    tooltip: {

                        backgroundColor:
                            '#0f172a',

                        titleColor:
                            '#fff',

                        bodyColor:
                            '#cbd5e1',

                        padding: 12,

                        cornerRadius: 10

                    }

                },


                scales: {

                    x: {

                        border: {

                            display: false

                        },

                        grid: {

                            color:
                                'rgba(148,163,184,.05)'

                        },

                        ticks: {

                            color:
                                '#94a3b8',

                            font: {

                                size: 10,

                                weight: '600'

                            }

                        }

                    },


                    y: {

                        beginAtZero: true,

                        border: {

                            display: false

                        },

                        grid: {

                            color:
                                'rgba(148,163,184,.08)'

                        },

                        ticks: {

                            color:
                                '#94a3b8',

                            precision: 0

                        },

                        title: {

                            display: true,

                            text:
                                'Cadets',

                            color:
                                '#64748b',

                            font: {

                                size: 10

                            }

                        }

                    },


                    percentage: {

                        position: 'right',

                        beginAtZero: true,

                        max: 100,

                        border: {

                            display: false

                        },

                        grid: {

                            drawOnChartArea: false

                        },

                        ticks: {

                            color:
                                '#34d399',

                            callback:
                                function(value) {

                                    return value + '%';

                                }

                        },

                        title: {

                            display: true,

                            text:
                                'Deployment %',

                            color:
                                '#34d399',

                            font: {

                                size: 10

                            }

                        }

                    }

                }

            }

        });

    }

});

</script>

@endsection