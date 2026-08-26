<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password | Dean Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

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

            padding: 2rem;
        }

        .wave-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.08;

            background:
                radial-gradient(
                    circle at 20% 80%,
                    rgba(255,255,255,0.1) 0%,
                    transparent 50%
                ),
                radial-gradient(
                    circle at 80% 20%,
                    rgba(255,255,255,0.08) 0%,
                    transparent 50%
                );

            pointer-events: none;
        }

        .login-card {
            background: rgba(255,255,255,0.98);

            border-radius: 20px;

            width: 100%;
            max-width: 480px;

            padding: 2.5rem 2rem;

            box-shadow:
                0 20px 60px rgba(0,0,0,0.3);

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
            font-size: 1.6rem;
            font-weight: 700;

            color: #0a192f;

            margin-top: 1rem;
        }

        .school-subtitle {
            color: #4a5568;
            margin-top: 0.3rem;
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

            font-family: Inter, sans-serif;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;

            border-color: #2a6f97;

            box-shadow:
                0 0 0 3px rgba(42,111,151,0.2);
        }

        .login-btn {
            width: 100%;

            padding: 1rem;

            background:
                linear-gradient(
                    135deg,
                    #2a6f97,
                    #1d3557
                );

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
            color: #dc2626;

            font-size: 0.85rem;

            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="wave-pattern"></div>

<div class="login-card">

    <div class="card-header">

        <div class="logo-container">

            <img
                src="{{ asset('images/MMACI Logo.jpg') }}"
                alt="MMACI Logo"
            >

        </div>

        <h1 class="system-title">
            On Board Training Report System
        </h1>

        <p class="school-subtitle">
            Merchant Marine Academy of Caraga Inc.
        </p>

    </div>

    <h2 class="login-section-title">
        set up Password
    </h2>

    <form
        method="POST"
        action="{{ route('superadmin.password.update') }}"
    >

        @csrf

        <input
            type="hidden"
            name="token"
            value="{{ $token }}"
        >

        <div class="form-group">

            <input
                type="email"
                name="email"
                class="form-input"
                placeholder="Email"
                value="{{ $email ?? old('email') }}"
                required
            >

            @error('email')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="form-group">

            <input
                type="password"
                name="password"
                class="form-input"
                placeholder="New Password"
                required
            >

            @error('password')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="form-group">

            <input
                type="password"
                name="password_confirmation"
                class="form-input"
                placeholder="Confirm New Password"
                required
            >

        </div>

        <button type="submit" class="login-btn">
            set Password
        </button>

    </form>

    <a
        href="{{ route('superadmin.login') }}"
        class="secondary-btn"
    >
        ← Back to Dean Login
    </a>

</div>

</body>
</html>