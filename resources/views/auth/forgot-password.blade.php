<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Forgot Password - On Board Training Report System
    </title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: 'Inter', sans-serif;

            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    #0a192f 0%,
                    #112240 25%,
                    #1d3557 50%,
                    #2a6f97 100%
                );

            display: flex;

            justify-content: center;
            align-items: center;

            padding: 20px;
        }


        /* =====================================================
           CARD
        ===================================================== */

        .login-card {

            width: 100%;
            max-width: 480px;

            padding: 40px 32px;

            background: rgba(255,255,255,0.98);

            border-radius: 20px;

            box-shadow:
                0 20px 60px rgba(0,0,0,0.3);
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .card-header {

            text-align: center;

            margin-bottom: 28px;
        }


        .logo-container {

            margin-bottom: 14px;
        }


        .logo-container img {

            width: 80px;
            height: 80px;

            border-radius: 50%;

            object-fit: cover;

            box-shadow:
                0 4px 15px rgba(0,0,0,0.15);
        }


        .system-title {

            font-size: 1.55rem;

            font-weight: 700;

            color: #0a192f;

            margin-bottom: 6px;
        }


        .school-subtitle {

            font-size: 0.9rem;

            color: #4a5568;
        }


        /* =====================================================
           PAGE TITLE
        ===================================================== */

        .page-title {

            text-align: center;

            font-size: 1.45rem;

            color: #1d3557;

            margin-bottom: 8px;
        }


        .page-description {

            text-align: center;

            color: #718096;

            font-size: 0.88rem;

            line-height: 1.6;

            margin-bottom: 24px;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-group {

            margin-bottom: 18px;
        }


        .form-label {

            display: block;

            margin-bottom: 8px;

            font-size: 0.9rem;

            font-weight: 600;

            color: #2d3748;
        }


        .input-wrapper {

            position: relative;
        }


        .input-icon {

            position: absolute;

            left: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: #718096;

            pointer-events: none;
        }


        .form-input {

            width: 100%;

            height: 48px;

            padding:
                0 14px 0 42px;

            font-family: 'Inter', sans-serif;

            font-size: 0.92rem;

            border: 2px solid #e2e8f0;

            border-radius: 12px;

            background: #ffffff;

            color: #1a202c;

            outline: none;

            transition: all 0.25s ease;
        }


        .form-input::placeholder {

            color: #a0aec0;
        }


        .form-input:focus {

            border-color: #2a6f97;

            box-shadow:
                0 0 0 4px rgba(42,111,151,0.1);
        }


        /* =====================================================
           ERROR
        ===================================================== */

        .error-message {

            margin-top: 6px;

            color: #e53e3e;

            font-size: 0.78rem;
        }


        /* =====================================================
           SUCCESS
        ===================================================== */

        .success-message {

            display: flex;

            align-items: flex-start;

            gap: 10px;

            background: #ecfdf5;

            color: #166534;

            border: 1px solid #bbf7d0;

            padding: 13px 14px;

            border-radius: 10px;

            margin-bottom: 18px;

            font-size: 0.82rem;

            line-height: 1.5;
        }


        .success-icon {

            flex-shrink: 0;

            font-size: 16px;
        }


        /* =====================================================
           RESET BUTTON
        ===================================================== */

        .reset-btn {

            width: 100%;

            min-height: 48px;

            padding: 12px 16px;

            background:
                linear-gradient(
                    135deg,
                    #2a6f97 0%,
                    #1d3557 100%
                );

            color: white;

            border: none;

            border-radius: 12px;

            font-family: 'Inter', sans-serif;

            font-size: 0.92rem;

            font-weight: 600;

            cursor: pointer;

            transition: all 0.25s ease;
        }


        .reset-btn:hover {

            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(42,111,151,0.4);
        }


        .reset-btn:active {

            transform: translateY(0);
        }


        /* =====================================================
           BACK LINK
        ===================================================== */

        .back-link {

            display: flex;

            justify-content: center;
            align-items: center;

            gap: 6px;

            margin-top: 18px;

            color: #2a6f97;

            text-decoration: none;

            font-size: 0.88rem;

            font-weight: 600;
        }


        .back-link:hover {

            text-decoration: underline;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .card-footer {

            margin-top: 28px;

            padding-top: 20px;

            border-top: 1px solid #e2e8f0;

            text-align: center;
        }


        .footer-logo-text {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            margin-bottom: 7px;
        }


        .footer-logo {

            width: 36px;
            height: 36px;

            border-radius: 50%;

            object-fit: cover;
        }


        .footer-system-name {

            font-size: 0.9rem;

            font-weight: 600;

            color: #0a192f;
        }


        .footer-copyright {

            font-size: 0.72rem;

            color: #718096;

            line-height: 1.5;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 640px) {

            body {

                padding: 14px;
            }


            .login-card {

                padding: 30px 20px;

                border-radius: 16px;
            }


            .logo-container img {

                width: 70px;
                height: 70px;
            }


            .system-title {

                font-size: 1.3rem;
            }


            .school-subtitle {

                font-size: 0.8rem;
            }


            .page-title {

                font-size: 1.25rem;
            }


            .page-description {

                font-size: 0.82rem;
            }


            .footer-logo-text {

                flex-direction: column;

                gap: 7px;
            }

        }

    </style>

</head>


<body>


<div class="login-card">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="card-header">

        <div class="logo-container">

            <img
                src="{{ asset('images/MMACI Logo.jpg') }}"
                alt="MMACI Logo">

        </div>


        <h1 class="system-title">
            On Board Training Report System
        </h1>


        <p class="school-subtitle">
            Merchant Marine Academy of Caraga Inc.
        </p>

    </div>


    <!-- =====================================================
         TITLE
    ====================================================== -->

    <h2 class="page-title">

        Forgot Password?

    </h2>


    <p class="page-description">

        @if(request()->is('admin/*'))

            Enter the email address associated with your
            <strong>admin account</strong> and we will send
            you a secure link to reset your password.

        @else

            Enter the email address associated with your
            <strong>cadet account</strong> and we will send
            you a secure link to reset your password.

        @endif

    </p>


    <!-- =====================================================
         SUCCESS MESSAGE
    ====================================================== -->

    @if (session('status'))

        <div class="success-message">

            <span class="success-icon">
                ✓
            </span>

            <span>
                {{ session('status') }}
            </span>

        </div>

    @endif


    <!-- =====================================================
         FORM
    ====================================================== -->

    <form
        method="POST"

            action="{{ request()->is('admin/*')
                ? route('admin.password.email')
                : route('password.email') }}">

        @csrf


        <div class="form-group">


            <label
                for="email"
                class="form-label">

                Email Address

            </label>


            <div class="input-wrapper">

                <span class="input-icon">
                    ✉️
                </span>


                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-input"
                    value="{{ old('email') }}"
                    placeholder="Enter your email address"
                    autocomplete="email"
                    required
                    autofocus>

            </div>


            @error('email')

                <div class="error-message">

                    {{ $message }}

                </div>

            @enderror


        </div>


        <button
            type="submit"
            class="reset-btn">

            Send Password Reset Link

        </button>


    </form>


    <!-- =====================================================
         BACK TO LOGIN
    ====================================================== -->

    @if(request()->is('admin/*'))

        <a
            href="{{ route('admin.login') }}"
            class="back-link">

            ← Back to Admin Login

        </a>

    @else

        <a
            href="{{ route('login') }}"
            class="back-link">

            ← Back to Cadet Login

        </a>

    @endif


    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <div class="card-footer">

        <div class="footer-logo-text">

            <img
                src="{{ asset('images/MMACI Logo.jpg') }}"
                class="footer-logo"
                alt="MMACI Logo">


            <span class="footer-system-name">

                On Board Training Report System

            </span>

        </div>


        <p class="footer-copyright">

            2027 Merchant Marine Academy of Caraga Inc.
            All rights reserved

        </p>

    </div>


</div>


</body>

</html>