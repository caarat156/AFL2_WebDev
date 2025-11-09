@extends('layout.mainlayout')

@section('title', 'Our Products')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Lawasan Collection</h1>
    
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.createproduct) }}" class="btn btn-primary">
                    + Add New Product
                </a>
            @endif
        @endauth
    </div>
    
    

    {{-- 🌿 Info ketika user sedang melakukan pencarian --}}
    @if(request('search'))
        <p class="text-center text-muted mb-4">
            Showing results for: <strong>"{{ request('search') }}"</strong>
        </p>
    @endif

    {{-- 🌿 Jika tidak ada produk ditemukan --}}
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
                            class="img-fluid rounded shadow-sm" 
                            style="height: 200px; width: 100%; object-fit: cover;">

                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">{{ $product->collection_name }}</h5>
                            <p class="text-muted mb-1">{{ $product->product_type }}</p>

                            @if ($product->variants)
                                <p class="small text-secondary mb-2">{{ $product->variants }}</p>
                            @endif

                            <p class="fw-bold mb-0">
                                Rp {{ number_format($product->price_2025 ?? $product->price_2024) }}
                            </p>

                            @if ($product->net_price)
                                <p class="text-success small mb-0">
                                    <i>After disc: Rp {{ number_format($product->net_price) }}</i>
                                </p>
                            @endif

                            @if ($product->notes)
                                <p class="mt-2 text-muted small">{{ $product->notes }}</p>
                            @endif

                            {{-- 🌸 Tombol Update & Delete hanya muncul untuk admin --}}
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                        <a href="{{ route('products.edit', $product->id) }}" 
                                            class="btn btn-sm btn-warning px-3">
                                            Update
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
