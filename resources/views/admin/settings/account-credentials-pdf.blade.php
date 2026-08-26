<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>
        Account Credentials Report
    </title>

    <style>

        @page {
            size: A4;
            margin: 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 14px;
        }

        .header p {
            margin: 3px 0;
            color: #6b7280;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 9px 7px;
            background: #1e1b4b;
            color: #ffffff;
            border: 1px solid #111827;
            font-size: 9px;
            text-align: left;
        }

        td {
            padding: 8px 7px;
            border: 1px solid #d1d5db;
            font-size: 9px;
        }

        .password {
            font-family: DejaVu Sans Mono, monospace;
            font-weight: bold;
            color: #166534;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            color: #6b7280;
            font-size: 8px;
        }

    </style>

</head>

<body>

    <div class="header">

        <h1>
            MERCHANT MARINE ACADEMY OF CARAGA INC.
        </h1>

        <h2>
            ONBOARD TRAINING REPORT SYSTEM
        </h2>

        <p>
            Account Credentials Report
        </p>

        <p>
            Generated:
            {{ $generatedAt->format('F d, Y h:i A') }}
        </p>

    </div>


    <table>

        <thead>

            <tr>

                <th>
                    #
                </th>

                <th>
                    Name
                </th>

                <th>
                    Username
                </th>

                <th>
                    Email
                </th>

                <th>
                    Temporary Password
                </th>

            </tr>

        </thead>


        <tbody>

            @foreach($credentials as $index => $credential)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $credential['name'] }}
                    </td>

                    <td>
                        {{ $credential['username'] }}
                    </td>

                    <td>
                        {{ $credential['email'] ?: '—' }}
                    </td>

                    <td class="password">
                        {{ $credential['password'] }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <div class="footer">

        Confidential Account Credentials Report

    </div>

</body>
</html>