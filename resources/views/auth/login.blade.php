<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eyematic - Login</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f2f5f8;
        }
        .login-card {
            max-width: 420px;
            margin: auto;
            margin-top: 6%;
            padding: 35px;
            border-radius: 12px;
            background: white;
            box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.08);
        }
        .eyematic-logo {
            height: 80px;
        }
        .google-btn {
            background: white;
            border: 1px solid #dcdcdc;
        }
        .google-btn:hover {
            background: #f5f5f5;
        }
        body {
        background: url('{{ asset('images/login-bg.jpg') }}') no-repeat center center fixed;
        background-size: cover;
        backdrop-filter: blur(3px);
        }

        .login-card {
            max-width: 420px;
            margin: auto;
            margin-top: 6%;
            padding: 35px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(6px);
            box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>

<div class="login-card">

    <!-- Eyematic Logo -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo.jpg') }}"
             class="eyematic-logo" alt="Eyematic Logo">
    </div>

    <h3 class="text-center fw-bold mb-3">Login</h3>
    <p class="text-center text-muted mb-4">Welcome back! Please login to continue.</p>

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" required autofocus>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <!-- Forgot Password -->
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
        </div>

        <!-- Login Button -->
        <button class="btn btn-primary w-100 mb-3" style="height: 45px;">
            Login
        </button>
    </form>

    <!-- Divider -->
    <div class="text-center text-muted mb-3">OR</div>

    <!-- Google Login -->
    <a href="{{ route('google.login') }}"
       class="btn google-btn d-flex align-items-center justify-content-center w-100"
       style="height: 45px;">
        <img src="{{ asset('images/GoogleLogo.jpg') }}" class="me-2" style="height: 22px;">
        Continue with Google
    </a>

    <!-- Register -->
    <p class="mt-4 text-center">
        Don't have an account?
        <a href="{{ route('register') }}">Register</a>
    </p>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
