
<title>Set Up Two-Factor Authentication | OBT System</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet"
>

<style>
/* =========================================================
   RESET
========================================================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    width: 100%;
    min-height: 100%;
    scroll-behavior: smooth;
}

body {
    width: 100%;
    min-height: 100vh;

    font-family: 'Inter', sans-serif;

    color: #172033;

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(42, 111, 151, 0.35),
            transparent 30%
        ),
        radial-gradient(
            circle at 90% 90%,
            rgba(29, 53, 87, 0.45),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #071525 0%,
            #0a192f 35%,
            #112240 70%,
            #1d3557 100%
        );

    overflow-x: hidden;
}


/* =========================================================
   VARIABLES
========================================================= */

:root {
    --navy: #0a192f;
    --navy-light: #112240;

    --blue: #2a6f97;
    --blue-dark: #1d3557;

    --text-dark: #172033;
    --text: #4a5568;
    --text-light: #718096;

    --border: #e2e8f0;
    --background: #f8fafc;

    --success: #059669;
    --success-bg: #ecfdf5;

    --danger: #dc2626;
    --danger-bg: #fef2f2;
}


/* =========================================================
   PAGE WRAPPER
========================================================= */

.page-wrapper {
    width: 100%;
    min-height: 100vh;

    display: flex;
    align-items: center;
    justify-content: center;

    padding:
        clamp(16px, 4vw, 40px)
        clamp(12px, 4vw, 24px);

    position: relative;
}


/* =========================================================
   BACKGROUND DECORATION
========================================================= */

.background-decoration {
    position: fixed;
    inset: 0;

    pointer-events: none;
    overflow: hidden;

    z-index: 0;
}

.background-decoration::before,
.background-decoration::after {
    content: "";

    position: absolute;

    width: clamp(220px, 35vw, 400px);
    height: clamp(220px, 35vw, 400px);

    border-radius: 50%;

    border: 1px solid rgba(255, 255, 255, 0.06);
}

.background-decoration::before {
    top: -180px;
    left: -150px;
}

.background-decoration::after {
    right: -180px;
    bottom: -180px;
}


/* =========================================================
   MAIN CARD
========================================================= */

.card {
    width: 100%;
    max-width: 570px;

    position: relative;
    z-index: 2;

    background: rgba(255, 255, 255, 0.98);

    border-radius: clamp(16px, 3vw, 24px);

    padding: clamp(18px, 5vw, 38px);

    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.35),
        0 5px 20px rgba(0, 0, 0, 0.08);

    animation: cardEnter 0.55s ease-out;
}

@keyframes cardEnter {
    from {
        opacity: 0;
        transform: translateY(25px) scale(0.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}


/* =========================================================
   HEADER
========================================================= */

.header {
    width: 100%;

    text-align: center;

    margin-bottom: clamp(20px, 5vw, 30px);
}

.logo-wrapper {
    position: relative;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    margin-bottom: clamp(12px, 3vw, 18px);
}

.logo-ring {
    position: absolute;

    width: clamp(78px, 20vw, 96px);
    height: clamp(78px, 20vw, 96px);

    border-radius: 50%;

    border: 1px solid rgba(42, 111, 151, 0.25);
}

.logo {
    width: clamp(62px, 17vw, 78px);
    height: clamp(62px, 17vw, 78px);

    object-fit: cover;

    border-radius: 50%;

    position: relative;

    background: white;

    padding: 3px;

    box-shadow:
        0 8px 25px rgba(29, 53, 87, 0.18);
}

.badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 7px;

    padding: 6px 12px;

    max-width: 100%;

    border-radius: 999px;

    background: #eff6ff;

    border: 1px solid #dbeafe;

    color: var(--blue-dark);

    font-size: 10px;
    font-weight: 700;

    letter-spacing: 0.04em;

    text-transform: uppercase;

    margin-bottom: 10px;
}

.badge-dot {
    width: 7px;
    height: 7px;

    flex-shrink: 0;

    border-radius: 50%;

    background: var(--blue);
}

h1 {
    color: var(--navy);

    font-size: clamp(1.3rem, 5vw, 1.65rem);

    line-height: 1.25;

    font-weight: 800;

    margin-bottom: 8px;
}

.subtitle {
    width: 100%;
    max-width: 430px;

    margin: 0 auto;

    color: var(--text-light);

    font-size: clamp(0.78rem, 2.5vw, 0.92rem);

    line-height: 1.6;
}


/* =========================================================
   PROGRESS
========================================================= */

.progress {
    width: 100%;

    display: flex;
    align-items: center;

    margin: clamp(20px, 5vw, 28px) 0
            clamp(20px, 5vw, 30px);
}

.progress-step {
    display: flex;
    align-items: center;

    gap: 8px;

    white-space: nowrap;

    min-width: 0;
}

.step-number {
    width: clamp(27px, 8vw, 30px);
    height: clamp(27px, 8vw, 30px);

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: var(--blue);

    color: white;

    font-size: 0.75rem;
    font-weight: 700;

    box-shadow:
        0 4px 10px rgba(42, 111, 151, 0.25);
}

.step-label {
    color: var(--blue-dark);

    font-size: clamp(0.62rem, 2vw, 0.78rem);

    font-weight: 700;
}

.progress-line {
    flex: 1;

    min-width: 15px;

    height: 2px;

    margin: 0 clamp(7px, 2vw, 12px);

    background: #dbe3ec;
}


/* =========================================================
   STEP CARD
========================================================= */

.step-card {
    width: 100%;

    border: 1px solid var(--border);

    border-radius: 16px;

    padding: clamp(14px, 4vw, 20px);

    background: #ffffff;

    margin-bottom: 16px;
}

.step-header {
    display: flex;

    align-items: flex-start;

    gap: 10px;

    margin-bottom: 8px;
}

.step-icon {
    width: 36px;
    height: 36px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #eff6ff;

    color: var(--blue);

    font-size: 17px;
}

.step-title {
    color: var(--blue-dark);

    font-size: clamp(0.88rem, 2.8vw, 0.98rem);

    font-weight: 700;

    line-height: 1.4;
}

.step-text {
    color: var(--text);

    font-size: clamp(0.78rem, 2.5vw, 0.86rem);

    line-height: 1.65;
}


/* =========================================================
   QR CODE
========================================================= */

.qr-section {
    width: 100%;

    display: flex;
    flex-direction: column;
    align-items: center;

    margin: 18px 0;
}

.qr-container {
    width: min(250px, 70vw);
    height: min(250px, 70vw);

    display: flex;
    align-items: center;
    justify-content: center;

    padding: clamp(8px, 3vw, 14px);

    background: #ffffff;

    border: 1px solid #dbe3ec;

    border-radius: 18px;

    box-shadow:
        0 10px 30px rgba(29, 53, 87, 0.08);
}

.qr-container img {
    width: 100%;
    height: 100%;

    max-width: 220px;
    max-height: 220px;

    display: block;

    object-fit: contain;
}

.qr-caption {
    width: 100%;

    margin-top: 9px;

    color: var(--text-light);

    font-size: clamp(0.65rem, 2.2vw, 0.75rem);

    text-align: center;

    line-height: 1.4;
}


/* =========================================================
   SECRET
========================================================= */

.secret-box {
    width: 100%;

    margin-top: 15px;

    padding: clamp(11px, 3vw, 13px);

    border-radius: 12px;

    background: #f8fafc;

    border: 1px solid var(--border);

    overflow: hidden;
}

.secret-top {
    display: flex;

    justify-content: space-between;
    align-items: center;

    gap: 10px;

    margin-bottom: 7px;
}

.secret-label {
    color: var(--text-light);

    font-size: 0.68rem;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 0.04em;
}

.copy-btn {
    flex-shrink: 0;

    min-height: 32px;

    border: none;

    background: transparent;

    color: var(--blue);

    font-family: inherit;

    font-size: 0.72rem;

    font-weight: 700;

    cursor: pointer;

    padding: 5px 7px;

    border-radius: 6px;

    transition: 0.2s;
}

.copy-btn:hover {
    background: #eaf3f9;
}

.secret {
    width: 100%;

    font-family: 'Courier New', monospace;

    color: var(--blue-dark);

    font-size: clamp(0.75rem, 2.5vw, 0.92rem);

    font-weight: 700;

    letter-spacing: 0.06em;

    line-height: 1.5;

    word-break: break-all;

    overflow-wrap: anywhere;

    transition: filter 0.2s;
}

.secret.hidden {
    filter: blur(5px);

    user-select: none;
}

.secret-actions {
    display: flex;

    justify-content: flex-end;

    margin-top: 6px;
}

.toggle-secret {
    min-height: 28px;

    border: none;

    background: transparent;

    color: var(--text-light);

    font-family: inherit;

    font-size: 0.7rem;

    cursor: pointer;

    padding: 4px;

    touch-action: manipulation;
}

.toggle-secret:hover {
    color: var(--blue);
}


/* =========================================================
   VERIFICATION
========================================================= */

.verification-card {
    width: 100%;

    margin-top: 18px;

    padding: clamp(14px, 4vw, 20px);

    border-radius: 16px;

    background:
        linear-gradient(
            180deg,
            #ffffff 0%,
            #f8fafc 100%
        );

    border: 1px solid var(--border);
}

.verification-header {
    display: flex;

    gap: 10px;

    align-items: center;

    margin-bottom: 8px;
}

.verification-icon {
    width: 36px;
    height: 36px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #ecfdf5;

    color: var(--success);

    font-size: 17px;
}

.verification-title {
    color: var(--blue-dark);

    font-size: clamp(0.88rem, 2.8vw, 0.98rem);

    font-weight: 700;
}

.verification-description {
    color: var(--text);

    font-size: clamp(0.77rem, 2.5vw, 0.86rem);

    line-height: 1.6;

    margin-bottom: 16px;
}

.form-group {
    width: 100%;

    position: relative;
}

label {
    display: block;

    color: #2d3748;

    font-size: 0.78rem;

    font-weight: 700;

    margin-bottom: 8px;
}

.code-input {
    width: 100%;

    min-height: 54px;

    padding: 13px 12px;

    border: 2px solid var(--border);

    border-radius: 12px;

    background: #ffffff;

    color: var(--navy);

    font-family: 'Courier New', monospace;

    font-size: clamp(1.05rem, 5vw, 1.35rem);

    font-weight: 700;

    text-align: center;

    letter-spacing: clamp(0.25rem, 2vw, 0.45rem);

    outline: none;

    transition:
        border-color 0.2s,
        box-shadow 0.2s,
        background 0.2s;

    -webkit-appearance: none;
    appearance: none;
}

.code-input::placeholder {
    color: #cbd5e0;

    letter-spacing: 0.25rem;
}

.code-input:focus {
    border-color: var(--blue);

    background: #ffffff;

    box-shadow:
        0 0 0 4px rgba(42, 111, 151, 0.1);
}

.code-input.valid {
    border-color: var(--success);

    background: var(--success-bg);
}

.error {
    width: 100%;

    margin-top: 8px;

    padding: 9px 11px;

    border-radius: 8px;

    background: var(--danger-bg);

    color: var(--danger);

    font-size: 0.76rem;

    line-height: 1.4;
}


/* =========================================================
   BUTTON
========================================================= */

.btn {
    width: 100%;

    min-height: 52px;

    display: flex;

    align-items: center;
    justify-content: center;

    gap: 9px;

    margin-top: 14px;

    padding: 13px 18px;

    border: none;

    border-radius: 12px;

    background:
        linear-gradient(
            135deg,
            var(--blue) 0%,
            var(--blue-dark) 100%
        );

    color: white;

    font-family: inherit;

    font-size: 0.92rem;

    font-weight: 700;

    cursor: pointer;

    transition:
        transform 0.2s,
        box-shadow 0.2s,
        opacity 0.2s;

    touch-action: manipulation;
}

.btn:hover {
    transform: translateY(-2px);

    box-shadow:
        0 10px 25px rgba(42, 111, 151, 0.3);
}

.btn:active {
    transform: translateY(0);
}

.btn:disabled {
    opacity: 0.7;

    cursor: not-allowed;

    transform: none;

    box-shadow: none;
}

.spinner {
    width: 16px;
    height: 16px;

    border: 2px solid rgba(255, 255, 255, 0.35);

    border-top-color: white;

    border-radius: 50%;

    animation: spin 0.7s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}


/* =========================================================
   SECURITY NOTE
========================================================= */

.security-note {
    width: 100%;

    display: flex;

    align-items: flex-start;

    gap: 9px;

    margin-top: 18px;

    padding: 12px 13px;

    background: #eff6ff;

    border: 1px solid #dbeafe;

    border-radius: 12px;

    color: #1e3a8a;

    font-size: clamp(0.68rem, 2.3vw, 0.75rem);

    line-height: 1.55;
}

.security-icon {
    flex-shrink: 0;

    font-size: 15px;
}


/* =========================================================
   FOOTER
========================================================= */

.footer {
    width: 100%;

    text-align: center;

    margin-top: 20px;

    padding-top: 17px;

    border-top: 1px solid var(--border);
}

.footer-brand {
    color: var(--navy);

    font-size: 0.72rem;

    font-weight: 700;
}

.footer-text {
    margin-top: 4px;

    color: var(--text-light);

    font-size: 0.64rem;

    line-height: 1.5;
}

.back-link {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-height: 36px;

    gap: 5px;

    margin-top: 8px;

    padding: 4px 8px;

    color: var(--blue);

    text-decoration: none;

    font-size: 0.73rem;

    font-weight: 600;

    border-radius: 7px;
}

.back-link:hover {
    text-decoration: underline;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 768px) {

    .page-wrapper {
        align-items: flex-start;

        padding-top: 20px;
        padding-bottom: 20px;
    }

    .card {
        max-width: 620px;
    }
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 600px) {

    body {
        background:
            linear-gradient(
                135deg,
                #071525 0%,
                #0a192f 50%,
                #1d3557 100%
            );
    }

    .page-wrapper {
        padding:
            10px
            10px
            20px;
    }

    .card {
        padding: 20px 15px;

        border-radius: 18px;
    }

    .header {
        margin-bottom: 20px;
    }

    .subtitle {
        padding: 0 5px;
    }

    .progress {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .step-card,
    .verification-card {
        border-radius: 14px;
    }

    .qr-container {
        width: min(220px, 68vw);
        height: min(220px, 68vw);
    }

    .qr-container img {
        max-width: 190px;
        max-height: 190px;
    }
}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 420px) {

    .page-wrapper {
        padding:
            6px
            6px
            16px;
    }

    .card {
        padding: 17px 12px;

        border-radius: 16px;
    }

    .logo {
        width: 60px;
        height: 60px;
    }

    .logo-ring {
        width: 76px;
        height: 76px;
    }

    h1 {
        font-size: 1.25rem;
    }

    .subtitle {
        font-size: 0.76rem;
    }

    .badge {
        font-size: 9px;
        padding: 5px 9px;
    }

    .step-label {
        font-size: 0.6rem;
    }

    .step-number {
        width: 26px;
        height: 26px;
    }

    .progress-line {
        margin-left: 6px;
        margin-right: 6px;
    }

    .step-card,
    .verification-card {
        padding: 13px;
    }

    .step-icon,
    .verification-icon {
        width: 34px;
        height: 34px;
    }

    .qr-container {
        width: min(195px, 62vw);
        height: min(195px, 62vw);

        padding: 8px;

        border-radius: 14px;
    }

    .qr-container img {
        max-width: 175px;
        max-height: 175px;
    }

    .secret-top {
        align-items: flex-start;
    }

    .secret-label {
        font-size: 0.62rem;
    }

    .copy-btn {
        font-size: 0.65rem;
    }

    .code-input {
        min-height: 50px;

        font-size: 1.05rem;

        letter-spacing: 0.25rem;
    }

    .btn {
        min-height: 50px;
    }

    .security-note {
        font-size: 0.67rem;
    }
}


/* =========================================================
   VERY SMALL PHONES
========================================================= */

@media (max-width: 350px) {

    .card {
        padding: 15px 10px;
    }

    .step-label {
        display: none;
    }

    .progress-line {
        margin-left: 8px;
        margin-right: 8px;
    }

    .qr-container {
        width: 175px;
        height: 175px;
    }

    .qr-container img {
        max-width: 155px;
        max-height: 155px;
    }

    .secret {
        font-size: 0.68rem;
    }

    .code-input {
        letter-spacing: 0.18rem;
    }
}


/* =========================================================
   LANDSCAPE PHONES
========================================================= */

@media (max-height: 650px) and (orientation: landscape) {

    .page-wrapper {
        align-items: flex-start;

        padding-top: 10px;
        padding-bottom: 15px;
    }

    .card {
        max-width: 620px;
    }

    .header {
        margin-bottom: 12px;
    }

    .logo-wrapper {
        margin-bottom: 8px;
    }

    .logo {
        width: 52px;
        height: 52px;
    }

    .logo-ring {
        width: 66px;
        height: 66px;
    }

    .progress {
        margin: 12px 0 15px;
    }

    .qr-container {
        width: 170px;
        height: 170px;
    }

    .qr-container img {
        max-width: 150px;
        max-height: 150px;
    }

    .qr-section {
        margin: 12px 0;
    }
}


/* =========================================================
   ACCESSIBILITY
========================================================= */

button,
input,
a {
    -webkit-tap-highlight-color: transparent;
}

button:focus-visible,
a:focus-visible,
input:focus-visible {
    outline: 3px solid rgba(42, 111, 151, 0.35);
    outline-offset: 2px;
}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        scroll-behavior: auto !important;
        transition-duration: 0.01ms !important;
    }
}
</style>
```

```html
<div class="page-wrapper">

    <div class="background-decoration"></div>

    <div class="card">

        {{-- =========================================
             HEADER
        ========================================== --}}

        <div class="header">

            <div class="logo-wrapper">

                <div class="logo-ring"></div>

                <img
                    src="{{ asset('images/MMACI Logo.jpg') }}"
                    alt="Merchant Marine Academy of Caraga Inc. Logo"
                    class="logo"
                >

            </div>

            <div class="badge">
                <span class="badge-dot"></span>
                Account Security
            </div>

            <h1>
                Set Up Two-Factor Authentication
            </h1>

            <p class="subtitle">
                Add an extra layer of security to your administrator
                account before continuing to the system.
            </p>

        </div>


        {{-- =========================================
             PROGRESS
        ========================================== --}}

        <div class="progress">

            <div class="progress-step">

                <div class="step-number">
                    1
                </div>

                <div class="step-label">
                    Scan QR Code
                </div>

            </div>

            <div class="progress-line"></div>

            <div class="progress-step">

                <div class="step-number">
                    2
                </div>

                <div class="step-label">
                    Verify Code
                </div>

            </div>

        </div>


        {{-- =========================================
             STEP 1
        ========================================== --}}

        <div class="step-card">

            <div class="step-header">

                <div class="step-icon">
                    📱
                </div>

                <div class="step-title">
                    Scan the QR Code
                </div>

            </div>

            <p class="step-text">
                Open an authenticator app such as
                <strong>Google Authenticator</strong> or
                <strong>Microsoft Authenticator</strong>.
                Scan the QR code below to connect your administrator
                account to your authenticator app.
            </p>


            <div class="qr-section">

                <div class="qr-container">

                    <img
                        src="{{ $qrCodeUrl }}"
                        alt="Two-factor authentication QR code"
                    >

                </div>

                <div class="qr-caption">
                    Scan this code using your authenticator app
                </div>

            </div>


            {{-- SECRET --}}

            <div class="secret-box">

                <div class="secret-top">

                    <span class="secret-label">
                        Manual Setup Key
                    </span>

                    <button
                        type="button"
                        class="copy-btn"
                        id="copySecret"
                    >
                        Copy Key
                    </button>

                </div>

                <div
                    class="secret hidden"
                    id="secretValue"
                >
                    {{ $secret }}
                </div>

                <div class="secret-actions">

                    <button
                        type="button"
                        class="toggle-secret"
                        id="toggleSecret"
                    >
                        Show key
                    </button>

                </div>

            </div>

        </div>


        {{-- =========================================
             STEP 2
        ========================================== --}}

        <div class="verification-card">

            <div class="verification-header">

                <div class="verification-icon">
                    ✓
                </div>

                <div class="verification-title">
                    Verify Your Authenticator
                </div>

            </div>

            <p class="verification-description">
                Enter the current 6-digit verification code displayed
                in your authenticator app. The code changes automatically
                every few seconds.
            </p>


            <form
                method="POST"
                action="{{ route('admin.two-factor.confirm') }}"
                id="twoFactorForm"
            >

                @csrf

                <div class="form-group">

                    <label for="code">
                        Authentication Code
                    </label>

                    <input
                        id="code"
                        type="text"
                        name="code"
                        class="code-input"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        placeholder="000000"
                        required
                        autofocus
                    >

                    @error('code')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="btn"
                    id="confirmButton"
                >

                    <span id="buttonText">
                        Confirm & Continue
                    </span>

                </button>

            </form>

        </div>


        {{-- =========================================
             SECURITY NOTE
        ========================================== --}}

        <div class="security-note">

            <div class="security-icon">
                🔐
            </div>

            <div>
                <strong>Keep your setup key private.</strong>
                Never share your QR code, manual setup key, or
                authentication codes with anyone.
            </div>

        </div>


        {{-- =========================================
             FOOTER
        ========================================== --}}

        <div class="footer">

            <div class="footer-brand">
                On Board Training Report System
            </div>

            <div class="footer-text">
                Merchant Marine Academy of Caraga Inc. © 2026
            </div>

            <a
                href="{{ route('admin.login') }}"
                class="back-link"
            >
                ← Return to Admin Login
            </a>

        </div>

    </div>

</div>
```

```html
<script>
document.addEventListener('DOMContentLoaded', function () {

    const secret = document.getElementById('secretValue');
    const toggle = document.getElementById('toggleSecret');
    const copy = document.getElementById('copySecret');

    const codeInput = document.getElementById('code');
    const form = document.getElementById('twoFactorForm');
    const button = document.getElementById('confirmButton');
    const buttonText = document.getElementById('buttonText');


    /* =========================================
       SHOW / HIDE SECRET
    ========================================== */

    if (toggle && secret) {

        toggle.addEventListener('click', function () {

            const hidden = secret.classList.contains('hidden');

            if (hidden) {

                secret.classList.remove('hidden');

                toggle.textContent = 'Hide key';

            } else {

                secret.classList.add('hidden');

                toggle.textContent = 'Show key';

            }

        });

    }


    /* =========================================
       COPY SECRET
    ========================================== */

    if (copy && secret) {

        copy.addEventListener('click', async function () {

            const value = secret.textContent.trim();

            try {

                await navigator.clipboard.writeText(value);

                copy.textContent = 'Copied!';

                setTimeout(function () {
                    copy.textContent = 'Copy Key';
                }, 1800);

            } catch (error) {

                const temporary = document.createElement('textarea');

                temporary.value = value;

                document.body.appendChild(temporary);

                temporary.select();

                document.execCommand('copy');

                temporary.remove();

                copy.textContent = 'Copied!';

                setTimeout(function () {
                    copy.textContent = 'Copy Key';
                }, 1800);
            }

        });

    }


    /* =========================================
       ONLY ALLOW NUMBERS
    ========================================== */

    if (codeInput) {

        codeInput.addEventListener('input', function () {

            this.value = this.value
                .replace(/\D/g, '')
                .slice(0, 6);

            if (this.value.length === 6) {

                this.classList.add('valid');

            } else {

                this.classList.remove('valid');

            }

        });

    }


    /* =========================================
       FORM SUBMIT
    ========================================== */

    if (form && button && buttonText) {

        form.addEventListener('submit', function (event) {

            if (!codeInput || codeInput.value.length !== 6) {

                event.preventDefault();

                codeInput.focus();

                return;
            }

            button.disabled = true;

            buttonText.innerHTML = `
                <span class="spinner"></span>
                Verifying...
            `;

        });

    }

});
</script>