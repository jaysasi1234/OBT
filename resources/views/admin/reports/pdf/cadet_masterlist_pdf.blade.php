<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Cadet Masterlist Report</title>

<style>

@page{
    margin:30px 35px 40px 35px;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:DejaVu Sans,sans-serif;
    font-size:12px;
    color:#222;
    margin:0;
    padding:0;
}

.page{
    margin-left:20px;
    margin-right:20px;
}

.header{
    border-bottom:3px solid #1f4e79;
    padding-bottom:12px;
    margin-bottom:20px;
}

.report-title{
    text-align:center;
    margin:20px 0;
}

.report-title h1{
    color:#1f4e79;
    font-size:22px;
}

.report-title p{
    color:#666;
    font-size:11px;
}

.summary{
    margin-bottom:20px;
}

.summary table{
    width:95%;
    margin:auto;
    border-collapse:collapse;
}

.summary td{
    border:1px solid #ddd;
    text-align:center;
    padding:10px;
    width:25%;
}

.value{
    font-size:20px;
    color:#1f4e79;
    font-weight:bold;
}

.label{
    font-size:11px;
    color:#666;
}

.report{
    width:95%;
    margin:auto;
    border-collapse:collapse;
}

.report th{
    background:#1f4e79;
    color:white;
    padding:8px;
    border:1px solid #ccc;
    font-size:11px;
}

.report td{
    border:1px solid #ddd;
    padding:8px;
    font-size:10px;
}

.footer{
    position:fixed;
    bottom:10px;
    left:0;
    right:0;
    text-align:center;
    font-size:10px;
    color:#666;
}

.generated{
    margin-top:60px;
    margin-right:20px;
    text-align:right;
    font-size:11px;
}

</style>

</head>

<body>

<div class="page">

<div class="header">

<table style="width:100%;border:none;">

<tr>

<td style="border:none;text-align:center;">

<h2 style="margin:0;">
Merchant Marine Academy of Caraga Inc.
</h2>

<h4 style="margin:4px 0;">
Onboard Training Report System
</h4>

<p>
Butuan City, Agusan del Norte
</p>

</td>

</tr>

</table>

</div>

<div class="report-title">

<h1>Cadet Masterlist Report</h1>

<p>

Generated on

{{ now()->format('F d, Y h:i A') }}

</p>

</div>

@php

$total = $cadets->count();

$verified = $cadets->where('verification_status','Verified')->count();

$ongoing = $cadets->filter(function($c){

return optional($c->deployment)->status=='Ongoing';

})->count();

$completed = $cadets->filter(function($c){

return optional($c->deployment)->status=='Completed';

})->count();

@endphp

<div class="summary">

</div>

<table class="report">

<thead>

<tr>

<th>TRB No.</th>
<th>Cadet Name</th>
<th>Course</th>
<th>Batch</th>
<th>Progress</th>
<th>Boarding Status</th>
<th>Verification</th>
<th>Concerns</th>

</tr>

</thead>

<tbody>

@forelse($cadets as $cadet)

<tr>

<td align="center">
{{ $cadet->trb_control_number }}
</td>


<td>
{{ $cadet->full_name }}
</td>


<td align="center">
{{ $cadet->course }}
</td>


<td align="center">
{{ optional($cadet->batch)->batch_year }}
</td>


<td align="center">

{{ optional($cadet->deployment)->percentage ?? 0 }}%

</td>


<td align="center">

{{ optional($cadet->deployment)->status ?? 'Not Deployed' }}

</td>


<td align="center">

{{ $cadet->verification_status ?? 'Not Submitted' }}

</td>


<td align="center">

{{ $cadet->complaints_count ?? 0 }}

</td>


</tr>


@empty

<tr>

<td colspan="8" align="center">
No records found.
</td>

</tr>

@endforelse


</tbody>

</table>

<div class="generated">

Prepared by: __________________________

</div>

<div class="footer">

Onboard Training Report System • Cadet Masterlist Report

</div>

</div>

</body>

</html>