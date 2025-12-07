@extends('layouts.app')

@section('title', 'Register')

@section('content')

<style>
    body {
        background: url('/images/login-bg.jpg') center/cover no-repeat fixed;
    }
    .register-card {
        max-width: 420px;
        margin: 60px auto;
        padding: 35px;
        background: #ffffffd9;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .brand-logo {
        width: 160px;
        margin-bottom: 20px;
    }
</style>

<div class="register-card text-center">

    <img src="/images/logo.jpg" class="brand-logo" alt="Eyematic Logo">

    <h3 class="mb-3">Create Account</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3 text-start">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100 mb-3">Register</button>
    </form>

    <hr>

    <a href="{{ route('google.login') }}" class="btn btn-danger w-100 mb-3">
        <i class="fab fa-google"></i> Register with Google
    </a>

    <a href="{{ route('login') }}" class="d-block">Already have an account? Login</a>

</div>

@endsection
