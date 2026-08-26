
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Two-Factor Authentication</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: #0b0b2d;
        }

        .card {
            width: 100%;
            max-width: 430px;
            padding: 35px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .25);
        }

        h2 {
            margin: 0 0 10px;
            text-align: center;
        }

        p {
            color: #666;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 18px;
            text-align: center;
            letter-spacing: 5px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #0b0b2d;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            opacity: .9;
        }

        .error {
            margin-bottom: 15px;
            padding: 10px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<div class="card">

    <h2>Two-Factor Authentication</h2>

    <p>
        Enter the 6-digit code from your authenticator app.
    </p>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.two-factor.challenge.verify') }}"
    >
        @csrf

        <label for="code">
            Authentication Code
        </label>

        <input
            type="text"
            id="code"
            name="code"
            inputmode="numeric"
            autocomplete="one-time-code"
            maxlength="6"
            pattern="[0-9]{6}"
            required
            autofocus
        >

        <button type="submit">
            Verify Code
        </button>

    </form>

</div>

</body>
</html>
