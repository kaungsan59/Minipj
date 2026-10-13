<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f4ff;
            padding: 20px;
        }

        .register-box {
            width: 380px;
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(50, 80, 150, 0.12);
        }

        h2 {
            text-align: center;
            color: #2563eb;
            font-size: 28px;
            margin: 0 0 8px;
        }

        .subtitle {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #444;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #dce2ee;
            border-radius: 8px;
            outline: none;
            font-size: 13px;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px #2563eb15;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 5px;
        }

        button:hover {
            background: #1d4ed8;
        }

        .bottom-text {
            text-align: center;
            color: #777;
            font-size: 12px;
            margin: 22px 0 0;
        }

        a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-list {
            color: #dc2626;
            font-size: 12px;
            padding-left: 20px;
            margin-bottom: 15px;
        }

        @media (max-width: 420px) {
            .register-box {
                width: 100%;
                padding: 25px;
            }
        }
    </style>
</head>

<body>

<div class="register-box">

    <h2>Create Account</h2>
    <p class="subtitle">Please fill in your details</p>

    @if ($errors->any())
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ url('/register') }}" method="POST">
        @csrf

        <label>Full Name</label>
        <input type="text" name="name"
               placeholder="Enter your full name"
               value="{{ old('name') }}" required>

        <label>Email Address</label>
        <input type="email" name="email"
               placeholder="Enter your email"
               value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password"
               placeholder="Create a password"
               minlength="8" required>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation"
               placeholder="Confirm your password"
               minlength="8" required>

        <button type="submit">Create Account</button>
    </form>

    <p class="bottom-text">
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </p>

</div>

</body>
</html>