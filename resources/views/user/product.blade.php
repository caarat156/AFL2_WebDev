@extends('layout.mainlayout')

@section('title', 'Our Products')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Lawasan Collection</h1>

    @if(request('search'))
        <p class="text-center text-muted mb-4">
            Showing results for: <strong>"{{ request('search') }}"</strong>
        </p>
    @endif
    {{-- Menampilkan info pencarian jika ada query search di URL (?search=xxx).
request('search') → ambil nilai search.
Teks muncul di tengah dan warna abu-abu (text-muted). --}}

    @if($products->isEmpty())
        <p class="text-center text-secondary fs-5 mt-5">
            No products found.
        </p>
    @else
        <div class="row justify-content-center">
            @foreach ($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <img src="{{ asset($product->image) }}" 
                            alt="{{ $product->product_type }}" 
                            class="img-fluid rounded-top" 
                            style="height: 250px; width: 100%; object-fit: cover;">

                        <div class="card-body text-center">
                            <h5 class="card-title mb-2">{{ $product->product_type }}</h5>
                            <p class="fw-bold text-success mb-3">
                                Rp {{ number_format($product->price_2025 ?? $product->price_2024) }}
                            </p>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i>See Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
        </div>

</div>
@endsection
