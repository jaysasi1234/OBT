<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>On Board Training Report System - Admin Login</title>

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
                position: relative;
                overflow-x: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 2rem;
            }

            .wave-pattern {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                opacity: 0.08;
                background-image: 
                    radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(255,255,255,0.05) 0%, transparent 30%);
                pointer-events: none;
            }

            .login-card {
                background: rgba(255, 255, 255, 0.98);
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                width: 100%;
                max-width: 480px;
                padding: 2.5rem 2rem;
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

            .card-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .logo-container {
                margin-bottom: 1rem;
            }

            .logo-container img {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: cover;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            }

            .system-title {
                font-size: 1.75rem;
                font-weight: 700;
                color: #0a192f;
                margin-bottom: 0.5rem;
                line-height: 1.2;
            }

            .school-subtitle {
                font-size: 1rem;
                font-weight: 500;
                color: #4a5568;
            }

            .login-section-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: #1d3557;
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }

            .input-wrapper {
                position: relative;
            }

            .input-icon {
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                color: #718096;
                width: 20px;
                height: 20px;
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
                transition: all 0.3s ease;
                font-family: 'Inter', sans-serif;
            }

            .form-input:focus {
                outline: none;
                border-color: #2a6f97;
                box-shadow: 0 0 0 4px rgba(42, 111, 151, 0.1);
            }

            .form-input::placeholder {
                color: #a0aec0;
            }

            .error-message {
                color: #e53e3e;
                font-size: 0.875rem;
                margin-top: 0.5rem;
            }

            /* =========================================
            SUCCESS NOTIFICATION
            ========================================= */

            .success-message {
                display: flex;
                align-items: center;
                gap: 12px;

                width: 100%;
                margin-bottom: 1.25rem;
                padding: 13px 15px;

                background: #ecfdf5;
                border: 1px solid #a7f3d0;
                border-left: 4px solid #10b981;

                border-radius: 10px;

                color: #065f46;

                animation: successFade 0.35s ease;
            }

            .success-icon {
                width: 30px;
                height: 30px;

                flex-shrink: 0;

                display: flex;
                align-items: center;
                justify-content: center;

                background: #10b981;
                color: white;

                border-radius: 50%;

                font-size: 16px;
                font-weight: 700;
            }

            .success-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 2px;
            }

            .success-title {
                font-size: 0.875rem;
                font-weight: 700;
                color: #047857;
            }

            .success-text {
                font-size: 0.8rem;
                line-height: 1.4;
                color: #065f46;
            }

            .success-close {
                border: none;
                background: transparent;

                color: #059669;

                font-size: 20px;
                font-weight: 500;

                cursor: pointer;

                padding: 2px 5px;

                opacity: 0.65;
                transition: opacity 0.2s ease;
            }

            .success-close:hover {
                opacity: 1;
            }

            @keyframes successFade {
                from {
                    opacity: 0;
                    transform: translateY(-6px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .success-hide {
                animation: successSlideOut 0.4s ease forwards;
            }

            @keyframes successSlideOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }

                to {
                    opacity: 0;
                    transform: translateY(-8px);
                }
            }

            .success-message {
                position: relative;
                overflow: hidden;
            }

            .success-message::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                height: 3px;
                width: 100%;
                background: #10b981;
                transform-origin: left;
                animation: successTimer 5s linear forwards;
            }

            @keyframes successTimer {
                from {
                    transform: scaleX(1);
                }

                to {
                    transform: scaleX(0);
                }
            }

            .login-options {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .remember-wrapper {
                display: flex;
                align-items: center;
                margin-bottom: 0;
            }

            .remember-checkbox {
                width: 18px;
                height: 18px;
                margin-right: 0.75rem;
                cursor: pointer;
                accent-color: #2a6f97;
            }

            .remember-label {
                font-size: 0.95rem;
                color: #4a5568;
                cursor: pointer;
            }

            .forgot-link {
                font-size: 0.9rem;
                font-weight: 600;
                color: #2a6f97;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .forgot-link:hover {
                color: #1d3557;
                text-decoration: underline;
            }

            .login-btn {
                width: 100%;
                padding: 1rem;
                background: linear-gradient(135deg, #2a6f97 0%, #1d3557 100%);
                color: #ffffff;
                border: none;
                border-radius: 12px;
                font-size: 1.1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                font-family: 'Inter', sans-serif;
            }

            .login-btn:hover {
                background: linear-gradient(135deg, #1d3557 0%, #0a192f 100%);
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(42, 111, 151, 0.4);
            }

            .login-btn:active {
                transform: translateY(0);
            }

            .secondary-btn {
                width: 100%;
                padding: 0.875rem;
                background: #e2e8f0;
                color: #4a5568;
                border: none;
                border-radius: 12px;
                font-size: 1rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                font-family: 'Inter', sans-serif;
                text-decoration: none;
                display: inline-block;
                text-align: center;
                margin-top: 1rem;
            }

            .secondary-btn:hover {
                background: #cbd5e0;
                color: #2d3748;
            }

            .support-text {
                text-align: center;
                margin-top: 1.5rem;
                font-size: 0.95rem;
            }

            .support-text span {
                color: #718096;
            }

            .support-link {
                color: #2a6f97;
                font-weight: 600;
                text-decoration: none;
                margin-left: 0.5rem;
                transition: color 0.3s ease;
            }

            .support-link:hover {
                color: #1d3557;
                text-decoration: underline;
            }

            .card-footer {
                margin-top: 2rem;
                padding-top: 1.5rem;
                border-top: 1px solid #e2e8f0;
                text-align: center;
            }

            .footer-logo-text {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                margin-bottom: 0.5rem;
            }

            .footer-logo {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
            }

            .footer-system-name {
                font-size: 1.1rem;
                font-weight: 600;
                color: #0a192f;
            }

            .footer-copyright {
                font-size: 0.85rem;
                color: #718096;
            }

            @media (max-width: 640px) {
                body {
                    padding: 1rem;
                }

                .login-card {
                    padding: 2rem 1.5rem;
                }

                .system-title {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="wave-pattern"></div>

        <div class="login-card">
            <div class="card-header">
                <div class="logo-container">
                    <img src="{{ asset('images/MMACI Logo.jpg') }}" alt="MMACI Logo">
                </div>
                <h1 class="system-title">On Board Training Report System</h1>
                <p class="school-subtitle">Merchant Marine Academy of Caraga Inc.</p>
            </div>

            <h2 class="login-section-title">Admin Login</h2>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

            @if(session('status'))
                <div class="success-message">
                    <div class="success-icon">
                        ✓
                    </div>

                    <div class="success-content">
                        <div class="success-title">
                            Password Reset Successful
                        </div>

                        <div class="success-text">
                            {{ session('status') }}
                        </div>
                    </div>

                    <button 
                        type="button" 
                        class="success-close"
                        onclick="this.parentElement.remove()"
                        aria-label="Close"
                    >
                        ×
                    </button>
                </div>
            @endif

                <div class="form-group">
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8L10.89 13.26C11.54 13.67 12.46 13.67 13.11 13.26L21 8M5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="Enter your email" 
                            required 
                            autofocus 
                            autocomplete="off"
                            data-lpignore="true"
                        >
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="2"/>
                            <path d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Enter your password" 
                            required 
                            autocomplete="new-password"
                            data-lpignore="true"
                        >
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="login-options">
                    <div class="remember-wrapper">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="remember-checkbox" 
                            name="remember"
                        >
                        <label for="remember_me" class="remember-label">
                            Remember me
                        </label>
                    </div>

                    <a href="{{ route('admin.password.request') }}" class="forgot-link">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" class="login-btn">Log In</button>

                <a href="{{ url('/') }}" class="secondary-btn">Go Back Home Page</a>

                <div class="support-text">
                    <span>Need Help?</span>
                    <a href="#" class="support-link">Contact Support</a>
                </div>
            </form>

            <div class="card-footer">
                <div class="footer-logo-text">
                    <img src="{{ asset('images/MMACI Logo.jpg') }}" alt="MMACI Logo" class="footer-logo">
                    <span class="footer-system-name">On Board Training Report System</span>
                </div>
                <p class="footer-copyright">2026 Merchant Marine Academy of Caraga Inc. All rights reserved</p>
            </div>
        </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const successMessage = document.querySelector('.success-message');

        if (successMessage) {

            setTimeout(function () {

                successMessage.classList.add('success-hide');

                setTimeout(function () {
                    successMessage.remove();
                }, 400);

            }, 5000);

        }

    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const notification =
        document.querySelector('.success-message');

    if (!notification) {
        return;
    }

    setTimeout(function () {

        notification.style.transition =
            'opacity 0.4s ease, transform 0.4s ease';

        notification.style.opacity = '0';

        notification.style.transform =
            'translateY(-8px)';

        setTimeout(function () {
            notification.remove();
        }, 400);

    }, 5000);

});
</script>

    </body>
</html>
