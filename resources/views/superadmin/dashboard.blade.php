@extends('layouts.superadmin')

@section('content')

<style>
/* ===============================
   IMPORT FONT
=================================*/
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    background:#07122F;
    color:#fff;
}

.dashboard-container{
    width:100%;
    max-width:1600px;
    margin:0 auto;
}

/* ===============================
   HERO HEADER
=================================*/

.hero{
    position:relative;
    overflow:hidden;
    padding:35px;
    border-radius:22px;

    background:
    linear-gradient(135deg,#1D4ED8,#2563EB,#0EA5E9);

    box-shadow:
    0 20px 45px rgba(0,0,0,.35);

    margin-bottom:30px;
}

.hero::before{

    content:'';

    position:absolute;

    width:450px;
    height:450px;

    background:rgba(255,255,255,.06);

    border-radius:50%;

    top:-220px;
    right:-120px;

    pointer-events:none;
}

.hero::after{

    content:'';

    position:absolute;

    width:300px;
    height:300px;

    background:rgba(255,255,255,.04);

    border-radius:50%;

    bottom:-170px;
    left:-80px;

    pointer-events:none;
}

.hero-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:40px;
    position:relative;
    z-index:2;
}

.hero-content > div:first-child{
    flex:1;
}

.hero-right{
    min-width:220px;
}

.hero h2{

    font-size:34px;
    font-weight:800;
}

.hero p{

    margin-top:8px;

    color:#dbeafe;

    font-size:15px;
}

.hero-right{

    text-align:right;
}

.hero-right h4{

    font-size:14px;
    color:#dbeafe;
}

.hero-right h1{

    font-size:38px;
    font-weight:800;
}

.hero-buttons{

    margin-top:18px;

    display:flex;
    gap:12px;
    flex-wrap:wrap;
}

.hero-btn{

    display:inline-flex;
    align-items:center;
    gap:10px;

    padding:12px 20px;

    border-radius:12px;

    text-decoration:none;

    color:white;

    background:rgba(255,255,255,.15);

    border:1px solid rgba(255,255,255,.2);

    transition:.35s;

    position:relative;
    z-index:3;
}

.hero-btn:hover{

    transform:translateY(-3px);

    background:white;

    color:#2563EB;
}

/* ===============================
   KPI CARDS
=================================*/

.cards{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:20px;
    margin-bottom:30px;
}

@media(max-width:1300px){
    .cards{
        grid-template-columns:repeat(3,1fr);
    }
}

@media(max-width:900px){
    .cards{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:600px){
    .cards{
        grid-template-columns:1fr;
    }
}

.card{

    position:relative;

    overflow:hidden;

    padding:22px;

    border-radius:18px;

    background:#101B48;

    border:1px solid rgba(255,255,255,.06);

    box-shadow:0 12px 25px rgba(0,0,0,.25);

    transition:.35s;

    color:white;

    text-decoration:none;
}

.card{
    min-height:160px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.card:hover{

    transform:translateY(-8px);

    box-shadow:0 25px 40px rgba(37,99,235,.30);
}

.card::before{

    content:'';

    position:absolute;

    width:140px;
    height:140px;

    border-radius:50%;

    right:-40px;
    top:-40px;

    background:rgba(255,255,255,.05);
}

.card-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;
}

.card-icon{
    width:58px;
    height:58px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    background:rgba(255,255,255,.08);
}

.card-number{
    font-size:36px;
    font-weight:800;
}

.card-title{
    font-size:15px;
    font-weight:600;
    color:#eef4ff;
    letter-spacing:.3px;
}

.card-footer{
    margin-top:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:14px;
    font-weight:700;
    color:#ffffff;
    text-shadow:0 1px 2px rgba(0,0,0,.4);
    opacity:.95;
}

.blue{
    background:linear-gradient(135deg,#2563EB,#1D4ED8);
}

.green{
    background:linear-gradient(135deg,#10B981,#059669);
}

.orange{
    background:linear-gradient(135deg,#F59E0B,#D97706);
}

.red{
    background:linear-gradient(135deg,#EF4444,#DC2626);
}

.cyan{
    background:linear-gradient(135deg,#06B6D4,#0891B2);
}

/* ===============================
   GRID
=================================*/

.grid{
    display:grid;
    grid-template-columns:2.2fr 1fr;
    gap:22px;
    align-items:stretch;

    margin-bottom:25px;   /* add this */
}

.box{
    background:rgba(16,27,72,.82);
    backdrop-filter:blur(12px);
    padding:25px;
    display:flex;
    flex-direction:column;
    height:100%;
    border-radius:20px;
    border:1px solid rgba(255,255,255,.08);
    box-shadow:0 12px 25px rgba(0,0,0,.25);
}

.progress{
    width:100%;
    height:10px;
    background:#23315d;
    border-radius:20px;
    overflow:hidden;
}

.progress-bar{
    height:100%;
    background:linear-gradient(90deg,#2563eb,#38bdf8);
    border-radius:20px;
    transition:.5s;
}

.box{
    transition:.35s;
}

.box:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 45px rgba(0,0,0,.35);
}

.box h3{
    margin-bottom:20px;
    font-size:19px;
    font-weight:700;
}

.dashboard-footer{
    margin-top:25px;
    text-align:center;
    color:#94a3b8;
    font-size:13px;
}

/* Responsive */

@media(max-width:1100px){

.grid{

grid-template-columns:1fr;

}

.hero-content{

flex-direction:column;

align-items:flex-start;

}

.hero-right{

text-align:left;

}

}

@keyframes fadeIn{

from{

opacity:0;

transform:translateY(25px);

}

to{

opacity:1;

transform:translateY(0);

}

}


/* ==========================
CHART BOX
==========================*/

.chart-header{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:20px;

}

.chart-header h3{

font-size:20px;

margin-bottom:5px;

font-weight:700;

}

.chart-header small{

color:#94a3b8;

}

.badge-chart{

background:#2563eb;

padding:8px 14px;

border-radius:20px;

font-size:12px;

font-weight:600;

}

.badge-chart.green{

background:#10b981;

}

.chart-container {
    position: relative;
    width: 100%;
    height: 320px;
}

/* =====================================
ANALYTICS GRID
=====================================*/

.analytics-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:22px;
    align-items:start;
}

.analytics-box{

margin-bottom:25px;

}

.section-title{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:18px;

}

.section-title span{

font-size:28px;

font-weight:700;

color:#3b82f6;

}

.overall-progress{

height:18px;

background:#1e293b;

border-radius:30px;

overflow:hidden;

margin-bottom:25px;

}

.overall-fill{

height:100%;

background:linear-gradient(90deg,#2563eb,#06b6d4);

border-radius:30px;

}

.course-progress{

margin-bottom:20px;

}

.course-header{

display:flex;

justify-content:space-between;

margin-bottom:8px;

font-size:14px;

}

.stats-row{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:15px;

margin-top:20px;

}

.mini-card{

padding:20px;

border-radius:16px;

text-align:center;

color:white;

}

.mini-card h1{

font-size:34px;

margin-bottom:5px;

}

.mini-card small{

opacity:.9;

}

.requirement-card{

display:flex;

justify-content:space-between;

align-items:center;

padding:16px;

margin-bottom:12px;

background:#18234d;

border-radius:14px;

transition:.3s;

}

.requirement-card:hover{

transform:translateX(6px);

background:#21305f;

}

.requirement-card strong{

display:block;

font-size:15px;

}

.requirement-card small{

color:#94a3b8;

}

.badge-warning{

background:#f59e0b;

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;

}

.summary-row{

display:flex;

justify-content:space-between;

padding:14px 0;

border-bottom:1px solid rgba(255,255,255,.08);

}

.summary-row:last-child{

border-bottom:none;

}

.empty-box{

padding:40px;

text-align:center;

color:#94a3b8;

}

@media(max-width:1000px){

.analytics-grid{

grid-template-columns:1fr;

}

.stats-row{

grid-template-columns:1fr;

}

}
</style>

<div class="dashboard-container">

<div class="hero">

    <div class="hero-content">

        <div>
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

                    <h2>{{ $icon }} {{ $greeting }}, {{ Auth::user()->name }}</h2>

                        <p>
                            Onboard Training Report System Dashboard
                        </p>

            <div class="hero-buttons">

                <a href="{{ route('superadmin.cadets.index') }}" class="hero-btn">
                    <i class="fas fa-user-graduate"></i>
                    <span>Manage Cadets</span>
                </a>

                <a href="{{ route('superadmin.deployments.index') }}" class="hero-btn">
                    <i class="fas fa-ship"></i>
                    <span>Deployments</span>
                </a>

                <a href="{{ route('superadmin.complaints.index') }}" class="hero-btn">
                    <i class="fas fa-file-circle-exclamation"></i>
                    <span>Complaints</span>
                </a>

            </div>

        </div>

        <div class="hero-right">

            <h4>{{ now()->format('l, F d, Y') }}</h4>

            <h1>{{ $deploymentPercentage }}%</h1>

            <p>Overall Deployment Rate</p>

        </div>

    </div>

</div>


<div class="cards">

        <a href="{{ route('superadmin.cadets.index') }}" class="card blue">

            <div class="card-top">

                <div>

                        <div class="card-title">Total Cadets</div>

                        <div class="card-number">{{ $totalCadets }}</div>

                </div>

                    <div class="card-icon"><i class="fas fa-user-graduate"></i></div>

            </div>

            <div class="card-footer">

                <span>Total Registered</span>

                        <span>100%</span>

            </div>

        </a>

<a href="{{ route('superadmin.deployments.index') }}" class="card green">

            <div class="card-top">

                <div>

                        <div class="card-title">Ongoing Deployment</div>

                        <div class="card-number">{{ $totalDeployed }}</div>

                </div>

                    <div class="card-icon"><i class="fas fa-ship"></i></div>

            </div>

            <div class="card-footer">

                <span>Currently Onboard</span>

                        <span>Active</span>

            </div>

        </a>

<a href="#" class="card cyan">

            <div class="card-top">

                <div>

                        <div class="card-title">Completed</div>

                        <div class="card-number">{{ $totalCompleted }}</div>

                </div>

                    <div class="card-icon"><i class="fas fa-check"></i></div>

            </div>

            <div class="card-footer">

                <span>Finished OBT</span>

                        <span>Done</span>

            </div>

        </a>

        <a href="#" class="card orange">

            <div class="card-top">

                <div>

                        <div class="card-title">Pending Verification</div>

                        <div class="card-number">{{ $pendingVerification }}</div>

                </div>

                    <div class="card-icon"><i class="fas fa-file"></i></div>

            </div>

            <div class="card-footer">

                <span>Awaiting Review</span>

                        <span>Pending</span>

            </div>

        </a>

        <a href="#" class="card red">

            <div class="card-top">

                <div>

                        <div class="card-title">Complaints</div>

                        <div class="card-number">{{ $withComplaints }}</div>

                </div>

                    <div class="card-icon"><i class="fas fa-exclamation-triangle"></i></div>

            </div>

            <div class="card-footer">

                <span>Open Reports</span>

                                <span>Attention</span>

            </div>

        </a>

</div>


<div class="grid">

    <!-- Deployment Analytics -->
        <div class="box">

            <div class="chart-header">
                <div>
                    <h3>Deployment Analytics</h3>
                    <small>Current cadet deployment status</small>
                </div>

                <span class="badge-chart">
                    Live
                </span>
            </div>

            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>

        </div>

        <canvas id="barChart"></canvas>

    </div>

    <!-- Verification -->
    <div class="box">

        <div class="chart-header">
            <div>
                <h3>Verification Overview</h3>
                <small>Document verification status</small>
            </div>

            <span class="badge-chart green">
                Updated
            </span>
        </div>

        <div class="chart-container">
            <canvas id="pieChart"></canvas>
        </div>

    </div>

</div>

        <div class="box analytics-box">

            <div class="chart-header">

                <div>
                    <h3>📈 Batch Deployment Graphical Summary</h3>
                    <small>Deployment comparison by batch</small>
                </div>

                <span class="badge-chart">
                    Batch Statistics
                </span>

            </div>

            <div class="chart-container">
                <canvas id="batchLineChart"></canvas>
            </div>

        </div>

<!-- ===========================
     ANALYTICS SECTION
=========================== -->

<div class="analytics-grid">

    <!-- LEFT -->
    <div>

        <!-- Deployment Progress -->
        <div class="box analytics-box">

            <div class="section-title">

                <h3>📈 Deployment Progress</h3>

                <span>{{ $deploymentPercentage }}%</span>

            </div>

            <div class="overall-progress">

                <div class="overall-fill"
                    style="width:{{ $deploymentPercentage }}%;">
                </div>

            </div>

            @foreach($courseDeployment as $course)

            <div class="course-progress">

                <div class="course-header">

                    <span>{{ $course['course'] }}</span>

                    <strong>
                        {{ $course['deployed'] }}/{{ $course['total'] }}
                    </strong>

                </div>

                <div class="progress">
                    <div class="progress-bar"
                        style="width: {{ $course['percentage'] }}%;">
                        {{ $course['percentage'] }}%
                    </div>
                </div>

            </div>

            @endforeach

        </div>

        <!-- Complaint Analytics -->

        <div class="box analytics-box">

            <h3>📋 Concern Analytics</h3>

            <div class="stats-row">

                <div class="mini-card red">

                    <h1>{{ $withComplaints }}</h1>

                    <small>Open</small>

                </div>

                <div class="mini-card green">

                    <h1>{{ $resolvedComplaints }}</h1>

                    <small>Resolved</small>

                </div>

                <div class="mini-card blue">

                    <h1>{{ $withComplaints+$resolvedComplaints }}</h1>

                    <small>Total</small>

                </div>

            </div>

        </div>

    </div>

    <!-- RIGHT -->

    <div>

        <!-- Requirements -->

<div class="box analytics-box">

    <h3>⚠ Incomplete Requirements</h3>

    <div class="requirements-list">

        @forelse($incompleteRequirements as $cadet)

        <div class="requirement-card">

            <div>
                <strong>{{ $cadet->full_name }}</strong>
                <small>{{ $cadet->course }}</small>
            </div>

            <span class="badge-warning">
                Pending
            </span>

        </div>

        @empty

        <div class="empty-box">
            🎉 No incomplete requirements
        </div>

        @endforelse

    </div>

</div>

        <!-- Quick Summary -->

        <div class="box analytics-box">

            <h3>⚓ System Summary</h3>

            <div class="summary-row">

                <span>Total Cadets</span>

                <strong>{{ $totalCadets }}</strong>

            </div>

            <div class="summary-row">

                <span>Ongoing</span>

                <strong>{{ $totalDeployed }}</strong>

            </div>

            <div class="summary-row">

                <span>Completed</span>

                <strong>{{ $totalCompleted }}</strong>

            </div>

            <div class="summary-row">

                <span>Not Deployed</span>

                <strong>{{ $notDeployed }}</strong>

            </div>

            <div class="summary-row">

                <span>Pending Verification</span>

                <strong>{{ $pendingVerification }}</strong>

            </div>

            <div class="summary-row">

                <span>Verified</span>

                <strong>{{ $verified }}</strong>

            </div>

            <div class="summary-row">
                <span>BS Qualified</span>
                <strong>{{ $bsCompleted }}</strong>
            </div>

        </div>

    </div>

</div>

<div class="dashboard-footer">

Last Updated

{{ now()->format('M d, Y h:i A') }}

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const barCtx=document.getElementById('barChart');

const barGradient1=barCtx.getContext('2d').createLinearGradient(0,0,0,400);
barGradient1.addColorStop(0,'#ef4444');
barGradient1.addColorStop(1,'#dc2626');

const barGradient2=barCtx.getContext('2d').createLinearGradient(0,0,0,400);
barGradient2.addColorStop(0,'#3b82f6');
barGradient2.addColorStop(1,'#1d4ed8');

const barGradient3=barCtx.getContext('2d').createLinearGradient(0,0,0,400);
barGradient3.addColorStop(0,'#10b981');
barGradient3.addColorStop(1,'#059669');

new Chart(barCtx,{

type:'bar',

data:{

labels:[
'Not Deployed',
'Ongoing',
'Completed'
],

datasets:[{

label:'Cadets',

data:[
{{ $notDeployed }},
{{ $totalDeployed }},
{{ $totalCompleted }}
],

backgroundColor:[
barGradient1,
barGradient2,
barGradient3
],

borderRadius:18,

borderSkipped:false,

barThickness:55

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

animation:{

duration:2500,

easing:'easeOutExpo'

},

plugins:{

legend:{
display:false
},

tooltip:{

backgroundColor:'#111827',

titleColor:'#fff',

bodyColor:'#fff',

padding:14,

cornerRadius:12,

displayColors:true

}

},

scales:{

y:{

beginAtZero:true,

grid:{
color:'rgba(255,255,255,.05)'
},

ticks:{
color:'#cbd5e1',
font:{
weight:'600'
}
}

},

x:{

grid:{
display:false
},

ticks:{
color:'#fff',
font:{
size:13,
weight:'600'
}
}

}

}

}

});


const pie=document.getElementById('pieChart').getContext('2d');

const verifiedGradient=pie.createLinearGradient(0,0,0,400);
verifiedGradient.addColorStop(0,'#22c55e');
verifiedGradient.addColorStop(1,'#16a34a');

const pendingGradient=pie.createLinearGradient(0,0,0,400);
pendingGradient.addColorStop(0,'#f59e0b');
pendingGradient.addColorStop(1,'#d97706');

const deficiencyGradient=pie.createLinearGradient(0,0,0,400);
deficiencyGradient.addColorStop(0,'#ef4444');
deficiencyGradient.addColorStop(1,'#dc2626');

new Chart(pie,{

type:'doughnut',

data:{

labels:[
'Verified',
'Pending',
'Deficiency'
],

datasets:[{

data:[
{{ $verified }},
{{ $pendingVerification }},
{{ $deficiency }}
],

backgroundColor:[

verifiedGradient,
pendingGradient,
deficiencyGradient

],

borderWidth:5,

borderColor:'#101B48',

hoverOffset:18,

cutout:'70%'

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

animation:{

animateRotate:true,

animateScale:true,

duration:2800

},

plugins:{

legend:{

position:'bottom',

labels:{

color:'#fff',

padding:22,

boxWidth:16,

boxHeight:16,

font:{

size:13,

weight:'600'

}

}

},

tooltip:{

backgroundColor:'#111827',

padding:14,

cornerRadius:10,

titleColor:'#fff',

bodyColor:'#fff'

}

}

}

});

const ctx = document.getElementById('batchLineChart').getContext('2d');

new Chart(ctx, {

    data: {

        labels: @json($batchLabels),

        datasets: [

            {
                type: 'bar',
                label: 'Total Cadets',
                data: @json($batchTotals),
                backgroundColor: '#94a3b8',
                borderRadius: 8
            },

            {
                type: 'bar',
                label: 'Deployed',
                data: @json($batchDeployed),
                backgroundColor: '#3b82f6',
                borderRadius: 8
            },

            {
                type: 'line',
                label: 'Deployment %',
                data: @json($batchPercentages),
                borderColor: '#10b981',
                backgroundColor: '#10b981',
                tension: 0.35,
                fill: false,
                yAxisID: 'y1',
                pointRadius: 6,
                pointHoverRadius: 8
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

        plugins: {

            legend: {
                labels: {
                    color: '#fff'
                }
            }

        },

        scales: {

            x: {
                ticks: {
                    color: '#fff'
                },
                grid: {
                    color: 'rgba(255,255,255,.05)'
                }
            },

            y: {
                beginAtZero: true,
                ticks: {
                    color: '#fff'
                },
                grid: {
                    color: 'rgba(255,255,255,.05)'
                },
                title: {
                    display: true,
                    text: 'Cadets',
                    color: '#fff'
                }
            },

            y1: {
                position: 'right',
                beginAtZero: true,
                max: 100,
                ticks: {
                    color: '#10b981',
                    callback: value => value + '%'
                },
                grid: {
                    drawOnChartArea: false
                },
                title: {
                    display: true,
                    text: 'Deployment %',
                    color: '#10b981'
                }
            }

        }

    }

});
</script>

@endsection