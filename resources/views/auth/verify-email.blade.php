@extends('layout.mainlayout')

@section('title', 'Verify Email')

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

    .logout-btn {
        background: none;
        border: none;
        color: #6b4e3d;
        padding: 0;
    }

    .logout-btn:hover {
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

        <h4 class="text-center mb-3 login-title">Verify Your Email</h4>

        <p class="text-center text-muted mb-4 small">
            Thanks for signing up! Please verify your email address by clicking the link we sent to your email.
            If you didn’t receive it, you can request another below.
        </p>

        {{-- STATUS MESSAGE --}}
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success text-center mb-3">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-4">

            {{-- RESEND EMAIL --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn login-btn text-white px-4">
                    Resend Email
                </button>
            </form>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn small">
                    Log Out
                </button>
            </form>

        </div>

    </div>
</div>
@endsection
