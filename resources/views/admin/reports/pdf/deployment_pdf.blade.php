<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">


<style>

@page{
    size: A4 landscape;
    margin:20px;
}


body{

    font-family: DejaVu Sans, sans-serif;

    font-size:11px;

    color:#222;

}


.header{

    text-align:center;

    border-bottom:2px solid #0B3D91;

    padding-bottom:10px;

    margin-bottom:20px;

}


.logo{

    width:70px;

}


h2{

    color:#0B3D91;

    margin:5px;

}


table{

    width:100%;

    border-collapse:collapse;

}


th{

    background:#0B3D91;

    color:white;

    padding:8px;

    border:1px solid black;

}


td{

    padding:8px;

    border:1px solid black;

    text-align:center;

}


tr:nth-child(even){

    background:#f3f6fb;

}


.footer{

    position:fixed;

    bottom:0;

    text-align:center;

    width:100%;

    font-size:10px;

}

.summary-table th{

background:#9dc3e6;
color:#000;
border:1px solid black;
font-size:10px;
padding:5px;

}


.summary-table td{

border:1px solid black;
padding:5px;
text-align:center;
font-size:10px;

}


.summary-table th:nth-child(4),
.summary-table th:nth-child(5){

background:#a9d18e;

}

/* ================= SIGNATORY SECTION ================= */

.signatory-table{
    width:350px;
    border:none;
    text-align:left;
}

.signatory-table td{
    border:none;
    text-align:left;
    padding:5px 0;
    font-size:10px;
}

.signatory-label{
    padding-top:10px !important;
    font-size:10px;
}

.signatory-name{
    padding-left:90px !important;
    font-size:10px;
    font-weight:bold;
}

.signatory-position{
    font-size:10px;
}

</style>

</head>


<body>



<div class="header">


<p>
Generated:
{{ now()->format('F d,Y h:i A') }}
</p>


</div>


<h3 style="text-align:center;">
SUMMARY OF DEPLOYMENT PERCENTAGE
</h3>


<table class="summary-table">

<thead>

<tr>

<th rowspan="2">AY</th>

<th colspan="2">BSMT</th>

<th colspan="2">BSMARE</th>


<th colspan="3">BSMT DEPLOYMENT</th>

<th colspan="3">BSMARE DEPLOYMENT</th>


<th colspan="2">DEPLOYMENT %</th>

</tr>


<tr>

<th>CCI</th>
<th>AOU</th>

<th>CCI</th>
<th>AOU</th>


<th>DOM.</th>
<th>INT.</th>
<th>TOTAL</th>


<th>DOM.</th>
<th>INT.</th>
<th>TOTAL</th>


<th>BSMT</th>
<th>BSMARE</th>

</tr>

</thead>


<tbody>


@foreach($summary as $row)

<tr>

<td>{{ $row['ay'] }}</td>


<td>{{ $row['bsmt_cci'] }}</td>

<td>{{ $row['bsmt_aou'] }}</td>


<td>{{ $row['bsmare_cci'] }}</td>

<td>{{ $row['bsmare_aou'] }}</td>


<td>{{ $row['bsmt_domestic'] }}</td>

<td>{{ $row['bsmt_international'] }}</td>

<td>{{ $row['bsmt_total'] }}</td>


<td>{{ $row['bsmare_domestic'] }}</td>

<td>{{ $row['bsmare_international'] }}</td>

<td>{{ $row['bsmare_total'] }}</td>


<td>{{ $row['bsmt_percentage'] }}%</td>

<td>{{ $row['bsmare_percentage'] }}%</td>


</tr>


@endforeach


</tbody>

</table>


<br>


<table class="summary-table">

<thead>

<tr>

<th rowspan="2">AY</th>

<th colspan="2">ON-BOARD</th>

<th colspan="2">DISEMBARKED</th>

<th colspan="2">FOR DELIBERATION</th>

<th colspan="2">ENDORSED FOR S.O.</th>

<th colspan="2">WITH S.O.</th>


</tr>


<tr>

<th>BSMT</th>
<th>BSMARE</th>


<th>BSMT</th>
<th>BSMARE</th>


<th>BSMT</th>
<th>BSMARE</th>


<th>BSMT</th>
<th>BSMARE</th>


<th>BSMT</th>
<th>BSMARE</th>


</tr>

</thead>


<tbody>


@foreach($summary as $row)

<tr>

<td>{{ $row['ay'] }}</td>


<td>{{ $row['onboard_bsmt'] }}</td>

<td>{{ $row['onboard_bsmare'] }}</td>


<td>{{ $row['disembarked_bsmt'] }}</td>

<td>{{ $row['disembarked_bsmare'] }}</td>


<td>{{ $row['deliberation_bsmt'] }}</td>

<td>{{ $row['deliberation_bsmare'] }}</td>


<td>{{ $row['endorsed_bsmt'] }}</td>

<td>{{ $row['endorsed_bsmare'] }}</td>


<td>{{ $row['so_bsmt'] }}</td>

<td>{{ $row['so_bsmare'] }}</td>


</tr>

@endforeach


</tbody>

</table>


<br><br>

<table class="signatory-table">

<tr>
<td>
    PREPARED BY:
</td>
</tr>

<tr>
<td class="signatory-name">
    <b>2M. ALEX H. TONGCO JR.</b><br>
    <span class="signatory-position">OBT Supervisor</span>
</td>
</tr>


<tr>
<td class="signatory-label">
    CHECKED AND REVIEWED BY:
</td>
</tr>

<tr>
<td class="signatory-name">
    <b>ENGR. DEREK MAR O. MONTAL</b><br>
    <span class="signatory-position">MMACI-CME Dean</span>
</td>
</tr>


<tr>
<td class="signatory-label">
    VERIFIED BY:
</td>
</tr>

<tr>
<td class="signatory-name">
    <b>DR. JOCELYN D. RAMOS</b><br>
    <span class="signatory-position">MMACI-VPAA</span>
</td>
</tr>


<tr>
<td class="signatory-label">
    APPROVED BY:
</td>
</tr>

<tr>
<td class="signatory-name">
    <b>DR. DENNIS P. MAUSISA</b><br>
    <span class="signatory-position">School President</span>
</td>
</tr>

</table>


<div class="footer">

Onboard Training Report System |
MMACI Deployment Report

</div>


</body>

</html>