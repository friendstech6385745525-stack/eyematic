@extends('layouts.app')

@section('title', 'Reset Password - Eyematic')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="max-width: 450px; width: 100%;">

        <div class="text-center mb-3">
            <img src="{{ asset('images/logo.jpg') }}" width="140" alt="Eyematic Logo">
            <h4 class="mt-3">Reset Your Password</h4>
            <p class="text-muted">Enter your new password below.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ request()->email }}">

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Reset Password</button>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
            </div>
        </form>
    </div>
</div>
@endsection
