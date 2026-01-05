@extends('layout.mainlayout')

@section('title', 'Register')

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

    .register-link {
        color: #6b4e3d;
        text-decoration: none;
    }

    .register-link:hover {
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

        <h4 class="text-center mb-4 login-title">Create Account</h4>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- NAME --}}
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                    autofocus
                >
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

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

            {{-- CONFIRM PASSWORD --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    required
                >
                @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <button type="submit" class="btn login-btn text-white w-100 py-2 mb-3">
                Register
            </button>

            <p class="text-center small">
                Already registered?
                <a href="{{ route('login') }}" class="register-link">
                    Login
                </a>
            </p>

        </form>
    </div>
</div>
@endsection
