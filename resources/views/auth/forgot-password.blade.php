@extends('layout.mainlayout')

@section('title', 'Forgot Password')

@push('styles')
<style>
    .login-wrapper {
        min-height: 100vh;
        background-color: #f6efe8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .login-logo img {
        height: 70px;
    }

    .login-title {
        color: #5a4634;
        font-weight: 600;
    }

    .login-btn {
        background-color: #6b4e3d;
        border: none;
    }

    .login-btn:hover {
        background-color: #5a4634;
    }

    .form-label {
        color: #5a4634;
        font-weight: 500;
    }

    .back-link {
        color: #6b4e3d;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        {{-- LOGO --}}
        <div class="login-logo text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Band Logo">
        </div>

        <h4 class="text-center mb-2 login-title">Forgot Password</h4>
        <p class="text-center text-muted mb-4 small">
            Enter your email and we’ll send you a password reset link
        </p>

        {{-- SESSION STATUS --}}
        @if (session('status'))
            <div class="alert alert-success text-center mb-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <button type="submit" class="btn login-btn text-white w-100 py-2 mb-3">
                Email Password Reset Link
            </button>

            <p class="text-center small">
                Remember your password?
                <a href="{{ route('login') }}" class="back-link">
                    Back to login
                </a>
            </p>

        </form>
    </div>
</div>
@endsection
