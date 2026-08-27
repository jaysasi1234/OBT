<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Account Created</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f7fb;
    font-family:Arial,Helvetica,sans-serif;
">

<table width="100%"
       cellpadding="0"
       cellspacing="0"
       style="padding:40px 15px;">

    <tr>
        <td align="center">

            <table width="600"
                   cellpadding="0"
                   cellspacing="0"
                   style="
                       max-width:600px;
                       width:100%;
                       background:#ffffff;
                       border-radius:16px;
                       overflow:hidden;
                       box-shadow:0 8px 30px rgba(0,0,0,.08);
                   ">

                <!-- HEADER -->

                <tr>
                    <td style="
                        background:#0a192f;
                        padding:30px;
                        text-align:center;
                    ">

                <img
                    src="{{ $message->embed(public_path('images/MMACI Logo.jpg')) }}"
                    width="75"
                    height="75"
                    style="
                        display:block;
                        width:75px;
                        height:75px;
                        border-radius:50%;
                        object-fit:cover;
                        border:3px solid #ffffff;
                        margin:0 auto;
                    "
                    alt="MMACI Logo"
                >

                        <h1 style="
                            margin:18px 0 5px;
                            color:#ffffff;
                            font-size:24px;
                        ">
                            On Board Training Report System
                        </h1>

                        <p style="
                            margin:0;
                            color:#cbd5e1;
                            font-size:14px;
                        ">
                            Merchant Marine Academy of Caraga Inc.
                        </p>

                    </td>
                </tr>


                <!-- CONTENT -->

                <tr>
                    <td style="
                        padding:40px 35px;
                        color:#1f2937;
                    ">

                        <h2 style="
                            margin:0 0 15px;
                            font-size:22px;
                            color:#0a192f;
                        ">
                            Welcome, {{ $user->name }}!
                        </h2>

                        <p style="
                            font-size:15px;
                            line-height:1.7;
                            color:#4b5563;
                        ">
                            Your
                            <strong>
                                {{ ucfirst($user->role) }}
                            </strong>
                            account has been successfully created
                            for the On Board Training Report System.
                        </p>


                        <!-- ACCOUNT INFORMATION -->

                        <table width="100%"
                               cellpadding="0"
                               cellspacing="0"
                               style="
                                   margin:25px 0;
                                   background:#f8fafc;
                                   border:1px solid #e5e7eb;
                                   border-radius:10px;
                               ">

                            <tr>
                                <td style="
                                    padding:12px 15px;
                                    color:#6b7280;
                                    font-size:14px;
                                ">
                                    Name
                                </td>

                                <td style="
                                    padding:12px 15px;
                                    text-align:right;
                                    font-weight:bold;
                                    font-size:14px;
                                ">
                                    {{ $user->name }}
                                </td>
                            </tr>

                            <tr>
                                <td style="
                                    padding:12px 15px;
                                    color:#6b7280;
                                    font-size:14px;
                                ">
                                    Username
                                </td>

                                <td style="
                                    padding:12px 15px;
                                    text-align:right;
                                    font-weight:bold;
                                    font-size:14px;
                                ">
                                    {{ $user->username }}
                                </td>
                            </tr>

                            <tr>
                                <td style="
                                    padding:12px 15px;
                                    color:#6b7280;
                                    font-size:14px;
                                ">
                                    Email
                                </td>

                                <td style="
                                    padding:12px 15px;
                                    text-align:right;
                                    font-weight:bold;
                                    font-size:14px;
                                ">
                                    {{ $user->email }}
                                </td>
                            </tr>

                            <tr>
                                <td style="
                                    padding:12px 15px;
                                    color:#6b7280;
                                    font-size:14px;
                                ">
                                    Role
                                </td>

                                <td style="
                                    padding:12px 15px;
                                    text-align:right;
                                    font-weight:bold;
                                    font-size:14px;
                                ">
                                    {{ ucfirst($user->role) }}
                                </td>
                            </tr>

                        </table>


                        <p style="
                            font-size:15px;
                            line-height:1.7;
                            color:#4b5563;
                        ">
                            For your security, you must create your
                            own password before signing in.
                        </p>


                        <!-- BUTTON -->

                        <div style="
                            text-align:center;
                            margin:30px 0;
                        ">

                            <a
                                href="{{ $user->role === 'dean'
                                    ? route('superadmin.password.reset', [
                                        'token' => $token,
                                        'email' => $user->email
                                    ])
                                    : route('admin.password.reset', [
                                        'token' => $token,
                                        'email' => $user->email
                                    ])
                                }}"
                                style="
                                    display:inline-block;
                                    background:#2a6f97;
                                    color:#ffffff;
                                    text-decoration:none;
                                    padding:14px 28px;
                                    border-radius:9px;
                                    font-size:15px;
                                    font-weight:bold;
                                "
                            >
                                Set Up My Password
                            </a>

                        </div>


                        <!-- SECURITY NOTICE -->

                        <div style="
                            background:#fff7ed;
                            border:1px solid #fed7aa;
                            border-left:4px solid #f97316;
                            padding:15px;
                            border-radius:8px;
                        ">

                            <strong style="
                                color:#9a3412;
                                font-size:14px;
                            ">
                                Security Notice
                            </strong>

                            <p style="
                                margin:6px 0 0;
                                color:#7c2d12;
                                font-size:13px;
                                line-height:1.6;
                            ">
                                Do not share this email or your
                                password setup link with anyone.
                                If you did not expect this account,
                                please contact the system administrator.
                            </p>

                        </div>


                        <p style="
                            margin-top:30px;
                            font-size:14px;
                            color:#6b7280;
                            line-height:1.6;
                        ">
                            Thank you,<br>

                            <strong>
                                OBT Report System Administration
                            </strong>
                        </p>

                    </td>
                </tr>


                <!-- FOOTER -->

                <tr>
                    <td style="
                        background:#f8fafc;
                        border-top:1px solid #e5e7eb;
                        padding:20px;
                        text-align:center;
                    ">

                        <p style="
                            margin:0;
                            color:#9ca3af;
                            font-size:12px;
                        ">
                            © {{ date('Y') }}
                            Merchant Marine Academy of Caraga Inc.
                        </p>

                        <p style="
                            margin:6px 0 0;
                            color:#9ca3af;
                            font-size:12px;
                        ">
                            This is an automated email.
                            Please do not reply.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>

</table>

</body>
</html>