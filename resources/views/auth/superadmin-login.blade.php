<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>On Board Training Report System - Super Admin Login</title>

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
            background: linear-gradient(135deg, #0a192f 0%, #112240 25%, #1d3557 50%, #2a6f97 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
        }

        .wave-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.08;
            background:
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .login-card {
            background: rgba(255,255,255,0.98);
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .system-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0a192f;
        }

        .school-subtitle {
            color: #4a5568;
        }

        .login-section-title {
            text-align: center;
            margin: 1.5rem 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #1d3557;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-family: Inter;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #2a6f97;
            box-shadow: 0 0 0 3px rgba(42,111,151,0.2);
        }

        /* PASSWORD WRAPPER */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-input {
            padding-right: 3rem;
        }

        /* EYE BUTTON */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);

            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: none;
            background: transparent;

            color: #64748b;
            font-size: 1.1rem;

            cursor: pointer;
            border-radius: 6px;
        }

        .toggle-password:hover {
            background: #f1f5f9;
            color: #2a6f97;
        }

        .toggle-password:focus {
            outline: 2px solid rgba(42,111,151,0.25);
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg,#2a6f97,#1d3557);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        .secondary-btn {
            display: block;
            text-align: center;
            margin-top: 1rem;
            padding: 0.875rem;
            background: #e2e8f0;
            border-radius: 12px;
            text-decoration: none;
            color: #4a5568;
        }

        .error-message {
            color: red;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .forgot-password {
            text-align: right;
            margin-top: -0.5rem;
            margin-bottom: 1.2rem;
        }

        .forgot-password a {
            color: #2a6f97;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .success-message {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="wave-pattern"></div>

<div class="login-card">

    <div class="card-header">

        <div class="logo-container">
            <img src="{{ asset('images/MMACI Logo.jpg') }}" alt="Logo">
        </div>

        <h1 class="system-title">
            On Board Training Report System
        </h1>

        <p class="school-subtitle">
            Merchant Marine Academy of Caraga Inc.
        </p>

    </div>

    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif

    <h2 class="login-section-title">
        Dean Login
    </h2>

    <form method="POST" action="{{ route('superadmin.login.submit') }}">

        @csrf

        {{-- EMAIL --}}
        <div class="form-group">

            <input
                type="email"
                name="email"
                class="form-input"
                placeholder="Email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
            >

            @error('email')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- PASSWORD --}}
        <div class="form-group">

            <div class="password-wrapper">

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-input"
                    placeholder="Password"
                    required
                    autocomplete="current-password"
                >

                <button
                    type="button"
                    class="toggle-password"
                    id="togglePassword"
                    aria-label="Show password"
                    title="Show password"
                >
                    👁
                </button>

            </div>

            @error('password')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- FORGOT PASSWORD --}}
        <div class="forgot-password">

            <a href="{{ route('superadmin.password.request') }}">
                Forgot Password?
            </a>

        </div>


        {{-- LOGIN --}}
        <button
            type="submit"
            class="login-btn"
        >
            Log In
        </button>


        {{-- BACK HOME --}}
        <a
            href="{{ url('/') }}"
            class="secondary-btn"
        >
            Go Back Home Page
        </a>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const password =
        document.getElementById('password');

    const togglePassword =
        document.getElementById('togglePassword');


    if (!password || !togglePassword) {
        return;
    }


    togglePassword.addEventListener('click', function () {

        const isPassword =
            password.type === 'password';


        if (isPassword) {

            password.type = 'text';

            togglePassword.textContent = '🙈';

            togglePassword.setAttribute(
                'aria-label',
                'Hide password'
            );

            togglePassword.setAttribute(
                'title',
                'Hide password'
            );

        } else {

            password.type = 'password';

            togglePassword.textContent = '👁';

            togglePassword.setAttribute(
                'aria-label',
                'Show password'
            );

            togglePassword.setAttribute(
                'title',
                'Show password'
            );

        }

    });

});

</script>

</body>
</html>