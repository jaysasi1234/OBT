<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">

<title>Verification Report</title>

<style>

@page{
    margin:30px 50px 40px 50px;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#222;
}

.header{
    width:100%;
    border-bottom:3px solid #1f4e79;
    padding-bottom:12px;
    margin-bottom:20px;
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
    margin:20px 0;
}

.report-title h1{
    font-size:22px;
    color:#1f4e79;
}

.report-title p{
    font-size:11px;
    color:#666;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#1f4e79;
    color:white;
    border:1px solid #cfcfcf;
    padding:8px;
    font-size:11px;
}

td{
    border:1px solid #dcdcdc;
    padding:8px;
    font-size:10px;
}

tbody tr:nth-child(even){
    background:#f5f7fb;
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
    margin:25px 35px 0 35px;   /* top right bottom left */
    text-align:right;
    font-size:11px;
    color:#666;
}

.prepared{
    display:inline-block;
    text-align:left;
}

.prepared .line{
    margin-left:8px;
}

.table-wrapper{
    margin: 0 25px;   /* left and right margins */
}

.table-wrapper table{
    width:100%;
    border-collapse:collapse;
}

</style>

</head>

<body>

<div class="header">

    <table style="width:100%; border:none; border-collapse:collapse;">
        <tr>

            <!-- LEFT LOGO -->
            <td style="width:90px; border:none; text-align:left; vertical-align:middle;">

                <img src="{{ public_path('images/MMACI Logo.jpg') }}"
                     width="70">

            </td>

            <!-- CENTER SCHOOL NAME -->
            <td style="border:none; text-align:center; vertical-align:middle;">

                <h2 style="margin:0;font-size:22px;font-weight:bold;">
                    Merchant Marine Academy of Caraga Inc.
                </h2>

                <h4 style="margin:4px 0;font-size:14px;">
                    Onboard Training Report System
                </h4>

                <p style="margin:0;font-size:11px;color:#555;">
                    Butuan City, Agusan del Norte
                </p>

            </td>

            <!-- EMPTY CELL TO KEEP TITLE CENTERED -->
            <td style="width:90px; border:none;"></td>

        </tr>
    </table>

</div>

<div class="report-title">

    <h1>Verification Status Report</h1>

    <p>
        Generated on {{ now()->format('F d, Y h:i A') }}
    </p>

</div>

<div class="table-wrapper">
    <table>

<thead>

<tr>
    <th>TRB No.</th>
    <th>Cadet Name</th>
    <th>Course</th>
    <th>Batch</th>
    <th>Verification Status</th>
    <th>Missing Documents</th>
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
    {{ optional($cadet->batch)->batch_year ?? 'N/A' }}
</td>

<td align="center">
    {{ $cadet->verification_status }}
</td>

<td>
    {{ $cadet->missing_documents ?? 'None' }}
</td>

</tr>

@empty

<tr>

<td colspan="6" align="center">

No verification records found.

</td>

</tr>

@endforelse

</tbody>

</table>
</div>
<div class="generated">
    <div class="prepared">
        <span>Prepared by:</span>
        <span class="line">_______________________</span>
    </div>
</div>

<div class="footer">

Onboard Training Report System • Verification Status Report

</div>

</body>
</html>