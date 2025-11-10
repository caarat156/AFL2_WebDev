@extends('layout.mainlayout')

@section('title', 'Admin Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg border-0 rounded-4 p-4">
                <div class="text-center mb-4">
                    {{-- 🖼️ Foto Profil --}}
                    <div class="position-relative d-inline-block">
                        <img src="{{ asset('images/default-avatar.png') }}" 
                             alt="Admin Profile"
                             class="rounded-circle shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <h4 class="mt-3">Admin Name</h4>
                    <p class="text-muted mb-0">admin@example.com</p>
                    <span class="badge bg-primary mt-2">Administrator</span>
                </div>

                <hr>

                {{-- ✏️ Form Edit Profil (dummy UI) --}}
                <form>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="Admin Name" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="admin@example.com" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" placeholder="********">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        {{-- 🏠 Back ke halaman Admin Product --}}
                        <a href="{{ route('admin.product') }}" class="btn btn-secondary px-4">Back</a>
                        <button type="button" class="btn btn-success px-4">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
