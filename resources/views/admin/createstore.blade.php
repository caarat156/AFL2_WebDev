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

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" required>
        </div>

        <div class="form-group">
            <label>Google Maps Link</label>
            <input type="text" name="linkgmap">

        <div class="form-group">
            <label>Store Image</label>
            <input type="file" name="image">
        </div>

        <div class="d-flex justify-content-between">
        <a href="{{ route('admin.stores') }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn-submit">Save Store</button>
        </div>
    </form>
</div>
@endsection
