@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<style>
    body {
        background: url('/images/login-bg.jpg') center/cover no-repeat fixed;
    }
    .reset-card {
        max-width: 420px;
        margin: 70px auto;
        padding: 35px;
        background: #ffffffdd;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .brand-logo {
        width: 150px;
        margin-bottom: 20px;
    }
</style>

<div class="reset-card text-center">

    <!-- Logo -->
    <img src="/images/logo.jpg" class="brand-logo" alt="Eyematic Logo">

    <h3 class="fw-bold mb-2">Forgot Password?</h3>
    <p class="text-muted mb-4">Enter your email and we'll send a reset link.</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    <!-- Password Reset Form -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3 text-start">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="height: 45px;">
            Send Reset Link
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>

</div>

@endsection
