@extends('layout.mainlayout')

@section('title', 'User Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4 p-4 text-center">
                <div class="mb-4">
                    <img src="{{ asset('images/default-avatar.png') }}" 
                        alt="User Profile"
                        class="rounded-circle shadow-sm"
                        style="width: 120px; height: 120px; object-fit: cover;">
                </div>

                <h4 class="mb-1">{{ Auth::user()->name ?? 'User Name' }}</h4>
                <p class="text-muted mb-3">{{ Auth::user()->email ?? 'user@example.com' }}</p>

                <span class="badge bg-secondary px-3 py-2">Regular User</span>

                <hr class="my-4">

                <a href="{{ route('user.products') }}" class="btn btn-outline-primary px-4">
                    Back to Products
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
