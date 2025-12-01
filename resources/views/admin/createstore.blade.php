@extends('layout.mainlayout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
<div class="form-container">
    <h2>Create Store</h2>

    <form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Form POST ke route admin.stores.store → akan memanggil method store di StoreController.
enctype="multipart/form-data" → wajib kalau ada upload file (gambar).
@csrf → token CSRF Laravel untuk keamanan. --}}
        
    {{-- 🏪 Nama Toko --}}
        <div class="form-group">
            <label>Store Name</label>
            <input type="text" name="name" required>
        </div>

        {{-- 📍 Lokasi --}}
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" required>
        </div>

        {{-- 🖼️ Gambar --}}
        <div class="form-group">
            <label>Store Image</label>
            <input type="file" name="image">
        </div>

        <button type="submit" class="btn-submit">Save Store</button>
    </form>
</div>
@endsection
