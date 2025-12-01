@extends('layout.mainlayout')

@section('title', 'Edit Store')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Edit Store</h2>

    <div class="card p-4 shadow-sm mx-auto" style="max-width: 600px;">
        <form action="{{ route('admin.stores.update', $store->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                {{-- Form mengarah ke route update store berdasarkan id.
    @csrf → token CSRF untuk keamanan.
    @method('PUT') → override method HTML menjadi PUT, karena update biasanya menggunakan method PUT/PATCH.
    enctype="multipart/form-data" → supaya bisa upload gambar baru. --}}

            <div class="mb-3">
                <label for="name" class="form-label">Store Name</label>
                <input type="text" name="name" id="name"
                        class="form-control"
                        value="{{ old('name', $store->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location"
                        class="form-control"
                        value="{{ old('location', $store->location) }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Store Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($store->image)
                    <div class="mt-3 text-center">
                        <p class="small text-muted mb-1">Current Image:</p>
                        <img src="{{ asset($store->image) }}"
                            alt="{{ $store->name }}"
                            class="img-fluid rounded shadow-sm"
                            style="height: 150px; object-fit: cover;">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.stores') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Update Store</button>
            </div>
        </form>
    </div>
</div>
@endsection
