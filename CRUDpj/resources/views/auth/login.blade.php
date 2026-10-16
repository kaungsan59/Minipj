<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
        }

        .login-box {
            width: 360px;
            background: white;
            padding: 35px;
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
            margin-bottom: 28px;
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
            margin-bottom: 18px;
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

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Welcome Back</h2>
    <p class="subtitle">Please login to your account</p>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label>Email Address</label>
        <input type="email" name="email"
               placeholder="Enter your email"
               value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password"
               placeholder="Enter your password" required>

        <button type="submit">Login</button>
    </form>

    <p class="bottom-text">
        Don't have an account?
        <a href="{{ route('register') }}">Sign Up</a>
    </p>

</div>

</body>
</html>