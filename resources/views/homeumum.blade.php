@extends('layout.mainlayout')

@section('title', 'Welcome')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endpush

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center mb-5">
                    {{-- Logo atau Icon --}}
                    <div class="mb-4">
                        <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px;">
                            <i class="bi bi-shop text-white" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    
                    {{-- Welcome Text --}}
                    <h1 class="display-4 fw-bold mb-3">Welcome to Lawasan</h1>
                    <p class="lead text-muted mb-5">
                        Discover our exclusive collection of premium products. 
                        Join us today to explore and shop with ease.
                    </p>
                    
                    {{-- Action Buttons --}}
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('login') }}" 
                            class="btn btn-primary btn-lg px-5 py-3 shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                            class="btn btn-outline-primary btn-lg px-5 py-3">
                            <i class="bi bi-person-plus me-2"></i>
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection