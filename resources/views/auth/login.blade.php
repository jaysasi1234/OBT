<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Onboard Training Report System - Cadet Login</title>

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
}

/* CARD */
.login-card {
    background: rgba(255,255,255,0.98);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    width: 100%;
    max-width: 500px;
    padding: 2.5rem;
    text-align: center;
}

/* LOGO */
.logo {
    width: 65px;
    height: 65px;
    object-fit: contain;
    display: block;
    margin: 0 auto 10px auto;
}

/* TITLES */
.system-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0a192f;
}

.system-subtitle {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 20px;
}

.login-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1d3557;
    margin-bottom: 20px;
}

/* INPUT GROUP */
.input-group {
    position: relative;
    margin-bottom: 15px;
}

.input-group input {
    width: 100%;
    padding: 12px 12px 12px 40px;
    border-radius: 10px;
    border: 1px solid #ccc;
    outline: none;
    font-family: inherit;
    transition: 0.2s;
}

.input-group input:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,0.10);
}

/* LEFT ICON */
.input-group > i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #555;
    font-style: normal;
    z-index: 2;
}

/* PASSWORD INPUT */
.password-group input {
    padding-right: 45px;
}

/* SHOW PASSWORD BUTTON */
.password-toggle {
    position: absolute;

    right: 10px;
    top: 50%;

    transform: translateY(-50%);

    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: none;
    background: transparent;

    color: #555;

    font-size: 18px;

    cursor: pointer;

    border-radius: 6px;

    transition: 0.2s;
}

.password-toggle:hover {
    background: #f1f1f1;
    color: #4f46e5;
}

.password-toggle:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(79,70,229,0.15);
}

/* REMEMBER */
.remember {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

/* BUTTON */
.login-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(
        135deg,
        #4f46e5,
        #6366f1
    );

    color: white;
    border: none;
    border-radius: 10px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.3s;
}

.login-btn:hover {
    opacity: 0.9;
}

/* BACK BUTTON */
.back-home-btn {
    display: block;
    width: 100%;

    padding: 12px;
    margin-top: 10px;

    background: #e5e7eb;
    color: #333;

    border-radius: 10px;

    text-decoration: none;
    font-weight: 500;

    transition: 0.3s;
}

.back-home-btn:hover {
    background: #d1d5db;
}

/* DIVIDER */
.divider {
    display: flex;
    align-items: center;
    margin: 20px 0;
    font-size: 0.9rem;
    color: #777;
}

.divider::before,
.divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #ccc;
}

.divider span {
    margin: 0 10px;
}

/* LINKS */
.links {
    font-size: 0.9rem;
}

.links a {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 500;
}

/* FOOTER */
.footer {
    margin-top: 20px;
    font-size: 0.8rem;
    color: #777;
}

.forgot-password {
    margin: 18px 0;
    text-align: center;
}

.forgot-password a {
    color: #4f46e5;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
}

.forgot-password a:hover {
    text-decoration: underline;
}

/* SUCCESS MESSAGE */
.success-message {
    display: flex;
    align-items: center;
    gap: 10px;

    text-align: left;

    background: #ecfdf5;
    color: #166534;

    border: 1px solid #bbf7d0;
    border-radius: 10px;

    padding: 12px 14px;
    margin-bottom: 18px;

    font-size: 0.85rem;
    line-height: 1.4;
}

.success-icon {
    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    width: 24px;
    height: 24px;

    border-radius: 50%;

    background: #22c55e;
    color: white;

    font-weight: 700;
}

/* MOBILE */
@media (max-width: 520px) {

    .login-card {
        width: calc(100% - 24px);
        padding: 2rem 1.4rem;
    }

    .system-title {
        font-size: 1.3rem;
    }

    .system-subtitle {
        font-size: 0.8rem;
    }
}
</style>
</head>

<body>

<div class="login-card">

    <!-- LOGO -->
    <img
        src="{{ asset('images/MMACI Logo.jpg') }}"
        class="logo"
        alt="MMACI Logo"
    >

    <!-- TITLE -->
    <div class="system-title">
        Onboard Training Report System
    </div>

    <div class="system-subtitle">
        Merchant Marine Academy Of Caraga Inc.
    </div>

    <div class="login-title">
        Cadet Login
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if (session('status'))

        <div class="success-message" id="successMessage">

            <span class="success-icon">
                ✓
            </span>

            <span>
                {{ session('status') }}
            </span>

        </div>

    @endif


    {{-- LOGIN FORM --}}
    <form method="POST" action="{{ route('login') }}">

        @csrf


        <!-- EMAIL -->
        <div class="input-group">

            <i>👤</i>

            <input
                type="email"
                name="email"
                placeholder="User Name/Email"
                value="{{ old('email') }}"
                autocomplete="username"
                required
            >

        </div>


        <!-- PASSWORD -->
        <div class="input-group password-group">

            <i>🔒</i>

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Password"
                autocomplete="current-password"
                required
            >

            <!-- SHOW / HIDE PASSWORD -->
            <button
                type="button"
                class="password-toggle"
                id="passwordToggle"
                aria-label="Show password"
                title="Show password"
            >
                👁
            </button>

        </div>


        <!-- REMEMBER -->
        <div class="remember">

            <input
                type="checkbox"
                name="remember"
                id="remember"
            >

            <label for="remember">
                Remember me
            </label>

        </div>


        <!-- LOGIN BUTTON -->
        <button
            type="submit"
            class="login-btn"
        >
            Log In
        </button>


        <!-- GO BACK HOME -->
        <a
            href="{{ url('/') }}"
            class="back-home-btn"
        >
            Go Back Home
        </a>


        <!-- FORGOT PASSWORD -->
        <div class="forgot-password">

            <a href="{{ route('password.request') }}">
                Forgot Password?
            </a>

        </div>


        <!-- SUPPORT -->
        <div
            class="links"
            style="margin-top: 10px;"
        >

            Need Help?

            <a href="#">
                Contact Support
            </a>

        </div>

    </form>


    <!-- FOOTER -->
    <div class="footer">

        Onboard Training Report System
        <br>

        2027 Merchant Marine Academy Of Caraga Inc.
        All rights reserved

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| SHOW / HIDE PASSWORD
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    const passwordInput =
        document.getElementById('password');

    const passwordToggle =
        document.getElementById('passwordToggle');


    if (passwordInput && passwordToggle) {

        passwordToggle.addEventListener('click', function () {

            /*
             * Check current input type
             */
            const isPassword =
                passwordInput.type === 'password';


            /*
             * Toggle input type
             */
            passwordInput.type =
                isPassword ? 'text' : 'password';


            /*
             * Change eye icon
             */
            passwordToggle.textContent =
                isPassword ? '🙈' : '👁';


            /*
             * Update accessibility label
             */
            passwordToggle.setAttribute(
                'aria-label',
                isPassword
                    ? 'Hide password'
                    : 'Show password'
            );


            /*
             * Update tooltip
             */
            passwordToggle.setAttribute(
                'title',
                isPassword
                    ? 'Hide password'
                    : 'Show password'
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | AUTO-HIDE SUCCESS MESSAGE
    |--------------------------------------------------------------------------
    */

    const successMessage =
        document.getElementById('successMessage');


    if (successMessage) {

        setTimeout(function () {

            successMessage.style.transition =
                'opacity 0.5s ease, transform 0.5s ease';

            successMessage.style.opacity = '0';

            successMessage.style.transform =
                'translateY(-10px)';


            setTimeout(function () {

                successMessage.remove();

            }, 500);

        }, 5000);

    }

});

</script>

</body>
</html>