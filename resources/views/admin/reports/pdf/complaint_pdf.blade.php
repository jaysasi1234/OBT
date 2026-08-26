<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>Complaint Report</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: DejaVu Sans, sans-serif;
    color:#222;
    font-size:12px;
}

.header{
    width:100%;
    border-bottom:3px solid #1f4e79;
    padding-bottom:12px;
    margin-bottom:20px;
}

.school{
    text-align:center;
}

.school h2{
    font-size:20px;
    margin-bottom:3px;
}

.school h4{
    font-size:14px;
    color:#444;
    margin-bottom:2px;
}

.school p{
    font-size:11px;
    color:#666;
}

.report-title{
    text-align:center;
    margin-top:18px;
    margin-bottom:20px;
}

.report-title h1{
    font-size:22px;
    color:#1f4e79;
}

.report-title p{
    font-size:11px;
    color:#666;
}

.summary{
    width:100%;
    margin-bottom:20px;
}

.summary table{
    width:100%;
    border-collapse:collapse;
}

.summary td{
    width:33.33%;
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

.summary .value{
    font-size:20px;
    font-weight:bold;
    color:#1f4e79;
}

.summary .label{
    font-size:11px;
    color:#666;
}

table.report{
    width:100%;
    border-collapse:collapse;
}

table.report th{

    background:#1f4e79;
    color:white;
    padding:8px;
    border:1px solid #cfcfcf;
    font-size:11px;
}

table.report td{

    border:1px solid #dcdcdc;
    padding:8px;
    font-size:10px;
}

table.report tbody tr:nth-child(even){

    background:#f4f6fb;

}

.status{

    font-weight:bold;
    text-align:center;
}

.open{

    color:#d32f2f;

}

.resolved{

    color:#2e7d32;

}

.footer{

    position:fixed;
    bottom:10px;
    left:0;
    right:0;
    text-align:center;
    font-size:10px;
    color:#777;
}

.generated{

    margin-top:15px;
    font-size:11px;
    text-align:right;
    color:#666;
}

</style>

</head>

<body>

<div class="header">

    <table style="width:100%; border:none; border-collapse:collapse;">
        <tr>

            <!-- Logo -->
            <td style="width:90px; border:none; vertical-align:middle;">

                <img src="{{ public_path('images/MMACI Logo.jpg') }}"
                     width="75"
                     height="75">

            </td>

            <!-- School Information -->
            <td style="border:none; text-align:center; vertical-align:middle;">

                <h2 style="margin:0; font-size:22px;">
                    Merchant Marine Academy of Caraga Inc.
                </h2>

                <h4 style="margin:5px 0;">
                    Onboard Training Report System
                </h4>

                <p style="margin:0;">
                    Butuan City, Agusan del Norte
                </p>

            </td>

        </tr>
    </table>

</div>

<div class="report-title">

    <h1>Concern Summary Report</h1>

    <p>
        Generated on {{ now()->format('F d, Y h:i A') }}
    </p>

</div>

@php

$total = $complaints->count();

$resolved = $complaints->where('status','Resolved')->count();

$open = $complaints->where('status','!=','Resolved')->count();

@endphp

<div class="summary">

</div>

<table class="report">

<thead>

<tr>

<th width="8%">TBR No.</th>
<th width="18%">Cadet Name</th>
<th width="10%">Course</th>
<th width="8%">Batch</th>
<th width="16%">Concern Type</th>
<th width="10%">Date Filed</th>
<th width="10%">Status</th>
<th width="10%">Date Resolved</th>
<th width="10%">Resolution</th>

</tr>

</thead>

<tbody>

@forelse($complaints as $complaint)

@php

$dateFiled = $complaint->created_at;

$dateResolved = $complaint->resolved_at;

$resolution = '-';

if($dateResolved){

$resolution = $dateFiled->diffInDays($dateResolved).' Days';

}

@endphp

<tr>

<td align="center">
TBR-{{ $complaint->id }}
</td>

<td>
{{ $complaint->cadet->full_name ?? 'N/A' }}
</td>

<td align="center">
{{ $complaint->cadet->course ?? 'N/A' }}
</td>

<td align="center">
{{ optional($complaint->cadet->batch)->batch_year ?? 'N/A' }}
</td>

<td>
{{ $complaint->subject }}
</td>

<td align="center">
{{ optional($complaint->created_at)->format('M d, Y') }}
</td>

<td class="status">

@if($complaint->status=='Resolved')

<span class="resolved">

Resolved

</span>

@else

<span class="open">

Open

</span>

@endif

</td>

<td align="center">

{{ $dateResolved ? $dateResolved->format('M d, Y') : '-' }}

</td>

<td align="center">

{{ $resolution }}

</td>

</tr>

@empty

<tr>

<td colspan="9" align="center">

No concern records found.

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="generated">

Prepared by: _______________________

</div>

<div class="footer">

Onboard Training Report System • Concern Report

</div>

</body>
</html>