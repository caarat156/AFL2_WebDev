@extends('layout.mainlayout')

@section('title', 'Our Stores')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Our Stores</h1>

    <div class="row justify-content-center">
        @foreach ($stores as $store)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0">
                    @php
                        $imagePath = $store->image;
                        if (!str_starts_with($imagePath, 'storage/')) {
                            $imagePath = 'storage/products/' . $imagePath;
                        }
                    @endphp
                    {{-- Menentukan path gambar dinamis.
                    Kalau nama file tidak dimulai dengan 'storage/', maka otomatis ditambahkan prefix 'storage/products/'.
                    Ini agar asset($imagePath) bisa menampilkan gambar dengan benar. --}}

                    <img src="{{ asset($imagePath) }}" 
                        class="card-img-top" 
                        alt="{{ $store->name }}"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">{{ $store->name }}</h5>
                        <p class="text-muted">{{ $store->location }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
