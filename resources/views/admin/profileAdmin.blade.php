@extends('layout.mainlayout')

@section('title', 'Admin Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4 p-4 text-center">
                {{-- 🖼️ Profile Picture --}}
                <div class="mb-4">
                    <img src="{{ asset('images/default-avatar.png') }}" 
                         alt="Admin Profile"
                         class="rounded-circle shadow-sm"
                         style="width: 120px; height: 120px; object-fit: cover;">
                </div>

                {{-- 👤 Admin Info --}}
                <h4 class="mb-1">{{ Auth::user()->name ?? 'Admin Name' }}</h4>
                <p class="text-muted mb-3">{{ Auth::user()->email ?? 'admin@example.com' }}</p>

                <span class="badge bg-primary px-3 py-2">Administrator</span>
                {{-- Menampilkan nama admin dan email dari user yang login.
                ?? 'Admin Name' → fallback kalau tidak ada data.
                Badge untuk menandai role Administrator. --}}

                <hr class="my-4">

                {{-- 🏠 Back to Admin Product Page --}}
                <a href="{{ route('admin.products') }}" class="btn btn-outline-primary px-4">
                    Back to Product Management
                </a>
            </div>

        </div>
    </div>
</div>
@endsection