@extends('layout.mainlayout')

@section('title', 'User Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4 p-4 text-center">
                {{-- 🖼️ Foto Profil --}}
                <div class="mb-4">
                    <img src="{{ asset('images/default-avatar.png') }}" 
                    {{-- Menampilkan avatar/default user image. --}}
                         alt="User Profile"
                         class="rounded-circle shadow-sm"
                         style="width: 120px; height: 120px; object-fit: cover;">
                </div>

                {{-- 👤 Informasi User --}}
                <h4 class="mb-1">{{ Auth::user()->name ?? 'User Name' }}</h4>
                <p class="text-muted mb-3">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                    {{-- Menampilkan nama dan email user yang login.
    Jika Auth::user() kosong, fallback ke placeholder 'User Name' dan 'user@example.com'. --}}

                <span class="badge bg-secondary px-3 py-2">Regular User</span>
                {{-- Badge untuk menandai role user. --}}
                <hr class="my-4">

                {{-- 🏠 Tombol Back ke halaman Product --}}
                <a href="{{ route('user.product') }}" class="btn btn-outline-primary px-4">
                    Back to Products
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
