@extends('layout.mainlayout')

@section('title', 'Login')

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
</style>
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        {{-- LOGO BAND --}}
        <div class="login-logo text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Band Logo">
        </div>

        <h4 class="text-center mb-4 login-title">Welcome Back</h4>

        {{-- SESSION STATUS --}}
        @if (session('status'))
            <div class="alert alert-success text-center mb-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
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

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                >
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- REMEMBER ME --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    Remember me
                </label>
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color:#6b4e3d;">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn login-btn text-white w-100 py-2">
                Log In
            </button>
        </form>
    </div>
</div>
@endsection
