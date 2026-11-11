
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Generated Remarks Report</title>

    <style>
        @page {
            margin: 25px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #172033;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
            border-bottom: 2px solid #142c50;
            padding-bottom: 12px;
        }

        .header h2 {
            font-size: 16px;
            margin: 0 0 5px;
            color: #142c50;
        }

        .header p {
            font-size: 9px;
            margin: 3px 0;
        }

        .generated {
            text-align: right;
            font-size: 8px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background: #142c50;
            color: white;
            padding: 8px 5px;
            font-size: 8px;
            text-align: left;
        }

        td {
            border: 1px solid #d4dce8;
            padding: 7px 5px;
            vertical-align: top;
            overflow-wrap: break-word;
        }

        tr:nth-child(even) {
            background: #f1f5fa;
        }

        .remark {
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        .empty {
            text-align: center;
            padding: 20px;
        }

        .footer {
            margin-top: 15px;
            font-size: 8px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">

        <h2>ON BOARD TRAINING REPORT SYSTEM</h2>

        <p>MERCHANT MARINE ACADEMY OF CARAGA INC.</p>

        <p><strong>GENERATED REMARKS REPORT</strong></p>

    </div>

    <div class="generated">

        Generated Date:
        {{ now()->format('F d, Y h:i A') }}

    </div>

    <table>

        <thead>
            <tr>
                <th style="width:10%;">TRB Number</th>
                <th style="width:14%;">Cadet Name</th>
                <th style="width:7%;">Course</th>
                <th style="width:8%;">Batch</th>
                <th style="width:8%;">Month</th>
                <th style="width:6%;">Year</th>
                <th style="width:25%;">Remarks</th>
                <th style="width:12%;">Updated By</th>
                <th style="width:10%;">Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($cadets as $cadet)

                <tr>

                    <td>
                        {{ $cadet->trb_control_number ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $cadet->full_name ?? 'N/A' }}
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

                    <td class="remark">
                        {{ filled($cadet->remarks)
                            ? $cadet->remarks
                            : 'No remarks recorded.' }}
                    </td>

                    <td>
                        {{ $cadet->remarks_updated_by ?? 'N/A' }}
                    </td>

                    <td>
                        {{ filled($cadet->remarks)
                            ? 'WITH REMARKS'
                            : 'NO REMARKS' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" class="empty">
                        No records found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="footer">
        Total Records: {{ $cadets->count() }}
    </div>

</body>
</html>
