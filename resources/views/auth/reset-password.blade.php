<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(
                135deg,
                #0a192f 0%,
                #112240 25%,
                #1d3557 50%,
                #2a6f97 100%
            );

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 2rem;
            position: relative;
            overflow-x: hidden;
        }

        .wave-pattern {
            position: absolute;
            inset: 0;

            opacity: 0.08;

            background-image:
                radial-gradient(
                    circle at 20% 80%,
                    rgba(255,255,255,0.1) 0%,
                    transparent 50%
                ),
                radial-gradient(
                    circle at 80% 20%,
                    rgba(255,255,255,0.08) 0%,
                    transparent 50%
                ),
                radial-gradient(
                    circle at 40% 40%,
                    rgba(255,255,255,0.05) 0%,
                    transparent 30%
                );

            pointer-events: none;
        }

        .reset-card {
            width: 100%;
            max-width: 480px;

            background: rgba(255, 255, 255, 0.98);

            border-radius: 20px;

            padding: 2.5rem 2rem;

            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.3);

            position: relative;
            z-index: 1;

            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 80px;
            height: 80px;

            border-radius: 50%;

            object-fit: cover;

            margin-bottom: 1rem;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .system-title {
            font-size: 1.5rem;
            font-weight: 700;

            color: #0a192f;

            line-height: 1.3;

            margin-bottom: 0.5rem;
        }

        .school-name {
            font-size: 0.95rem;
            font-weight: 500;

            color: #4a5568;
        }

        .page-title {
            text-align: center;

            font-size: 1.5rem;
            font-weight: 600;

            color: #1d3557;

            margin-bottom: 0.5rem;
        }

        .description {
            text-align: center;

            color: #718096;

            font-size: 0.9rem;

            line-height: 1.5;

            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;

            font-size: 0.9rem;
            font-weight: 600;

            color: #2d3748;

            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 1rem;
            top: 50%;

            transform: translateY(-50%);

            width: 20px;
            height: 20px;

            color: #718096;

            pointer-events: none;
        }

        .form-input {
            width: 100%;

            padding: 0.875rem 1rem 0.875rem 3rem;

            font-size: 1rem;

            border: 2px solid #e2e8f0;

            border-radius: 12px;

            background: #ffffff;

            color: #1a202c;

            font-family: 'Inter', sans-serif;

            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;

            border-color: #2a6f97;

            box-shadow:
                0 0 0 4px rgba(42, 111, 151, 0.1);
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .error-message {
            color: #e53e3e;

            font-size: 0.85rem;

            margin-top: 0.5rem;
        }

        .reset-btn {
            width: 100%;

            padding: 1rem;

            background: linear-gradient(
                135deg,
                #2a6f97 0%,
                #1d3557 100%
            );

            color: white;

            border: none;

            border-radius: 12px;

            font-size: 1rem;
            font-weight: 600;

            cursor: pointer;

            font-family: 'Inter', sans-serif;

            transition: all 0.3s ease;

            margin-top: 0.5rem;
        }

        .reset-btn:hover {
            background: linear-gradient(
                135deg,
                #1d3557 0%,
                #0a192f 100%
            );

            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(42, 111, 151, 0.4);
        }

        .reset-btn:active {
            transform: translateY(0);
        }

        .back-link {
            display: block;

            text-align: center;

            margin-top: 1.25rem;

            color: #2a6f97;

            font-size: 0.9rem;

            font-weight: 600;

            text-decoration: none;
        }

        .back-link:hover {
            color: #1d3557;

            text-decoration: underline;
        }

        .footer {
            margin-top: 2rem;

            padding-top: 1.5rem;

            border-top: 1px solid #e2e8f0;

            text-align: center;
        }

        .footer-logo {
            width: 40px;
            height: 40px;

            border-radius: 50%;

            object-fit: cover;

            vertical-align: middle;

            margin-right: 0.5rem;
        }

        .footer-name {
            font-size: 0.95rem;

            font-weight: 600;

            color: #0a192f;
        }

        .copyright {
            margin-top: 0.5rem;

            font-size: 0.8rem;

            color: #718096;
        }

        @media (max-width: 640px) {

            body {
                padding: 1rem;
            }

            .reset-card {
                padding: 2rem 1.5rem;
            }

            .system-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>

<div class="wave-pattern"></div>

<div class="reset-card">

    <!-- HEADER -->
    <div class="header">

        <img
            src="{{ asset('images/MMACI Logo.jpg') }}"
            alt="MMACI Logo"
            class="logo"
        >

        <h1 class="system-title">
            On Board Training Report System
        </h1>

        <p class="school-name">
            Merchant Marine Academy of Caraga Inc.
        </p>

    </div>


    <!-- TITLE -->

    <h2 class="page-title">
        Reset Password
    </h2>

    <p class="description">

        @if(request()->is('admin/*'))

            Enter your new password below to regain access to your
            <strong>administrator account</strong>.

        @else

            Enter your new password below to regain access to your
            <strong>cadet account</strong>.

        @endif

    </p>


    <!-- ERRORS -->

    @if ($errors->any())

        <div class="error-message">

            @foreach ($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <!-- RESET FORM -->

        <form
            method="POST"
            action="{{ request()->is('admin/*')
                ? route('admin.password.update')
                : route('password.store') }}"
        >
        @csrf



        <!-- TOKEN -->

<input
    type="hidden"
    name="token"
    value="{{ $token ?? request()->route('token') }}"
>


        <!-- EMAIL -->

        <div class="form-group">

            <label
                for="email"
                class="form-label"
            >
                Email Address
            </label>

            <div class="input-wrapper">

                <svg
                    class="input-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >

                    <path
                        d="M3 8L10.89 13.26C11.54 13.67 12.46 13.67 13.11 13.26L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

                <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-input"
                    value="{{ old('email', $email ?? request('email')) }}"
                    placeholder="Enter your email"
                    required
                    autofocus
                    autocomplete="email"
                >

            </div>

        </div>


        <!-- PASSWORD -->

        <div class="form-group">

            <label
                for="password"
                class="form-label"
            >
                New Password
            </label>

            <div class="input-wrapper">

                <svg
                    class="input-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >

                    <rect
                        x="3"
                        y="11"
                        width="18"
                        height="11"
                        rx="2"
                        stroke="currentColor"
                        stroke-width="2"
                    />

                    <path
                        d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11"
                        stroke="currentColor"
                        stroke-width="2"
                    />

                </svg>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="Enter new password"
                    required
                    autocomplete="new-password"
                >

            </div>

        </div>


        <!-- CONFIRM PASSWORD -->

        <div class="form-group">

            <label
                for="password_confirmation"
                class="form-label"
            >
                Confirm New Password
            </label>

            <div class="input-wrapper">

                <svg
                    class="input-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >

                    <rect
                        x="3"
                        y="11"
                        width="18"
                        height="11"
                        rx="2"
                        stroke="currentColor"
                        stroke-width="2"
                    />

                    <path
                        d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447 8.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447 15.5355 2.52678 17 5.67392 17 7V11"
                        stroke="currentColor"
                        stroke-width="2"
                    />

                </svg>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-input"
                    placeholder="Confirm new password"
                    required
                    autocomplete="new-password"
                >

            </div>

        </div>


        <!-- BUTTON -->

        <button
            type="submit"
            class="reset-btn"
        >
            Reset Password
        </button>

    </form>


    <!-- BACK -->

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


    <!-- FOOTER -->

    <div class="footer">

        <img
            src="{{ asset('images/MMACI Logo.jpg') }}"
            alt="MMACI Logo"
            class="footer-logo"
        >

        <span class="footer-name">
            On Board Training Report System
        </span>

        <p class="copyright">
            2026 Merchant Marine Academy of Caraga Inc.
            All rights reserved.
        </p>

    </div>

</div>

</body>
</html>