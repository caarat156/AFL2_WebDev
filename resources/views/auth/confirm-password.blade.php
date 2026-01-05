@extends('layout.mainlayout')

@section('title', 'Confirm Password')

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

        <h4 class="text-center mb-2 login-title">Confirm Password</h4>
        <p class="text-center text-muted mb-4 small">
            This is a secure area. Please confirm your password to continue.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            {{-- PASSWORD --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                    autofocus
                >
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- ACTION --}}
            <button type="submit" class="btn login-btn text-white w-100 py-2">
                Confirm
            </button>

        </form>
    </div>
</div>
@endsection
