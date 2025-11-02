@extends('layout.mainlayout')

@section('title', 'Home Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="hero-section-fullscreen">
    <img src="{{ asset('images/welcome5.jpg') }}" alt="Candle Image" class="hero-image">
    <div class="hero-overlay">
        <h1 class="hero-text">A scent can bring back a thousand memories</h1>
    </div>
</div>

<section class="best-sellers-section">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="best-sellers-title mb-0">Best Sellers</h2>
        </div>
        
        <div class="row g-3">
            @foreach($bestSellers as $product)
            {{-- ambil 4 produk sesuai id yang di best sellers, dari controller --}}
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->product_type }}" class="product-image">
                        </div>
                        <div class="product-info">
                            <p class="product-category">{{ $product->collection_name }}</p>
                            <h3 class="product-name">{{ strtoupper($product->product_type) }}</h3>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="refer-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 d-flex align-items-center justify-content-center refer-content-wrapper">
                <div class="refer-content">
                    <p class="refer-subtitle">Suitable for Gifts</p>
                    <h2 class="refer-title">A Gift For Them, A Gift For You</h2>
                    <p class="refer-description">
                        Introduce to your friends and family <br>
                        we will happily pack them up with love for you.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="refer-image-wrapper">
                    <img src="{{ asset('images/info.jpg') }}" alt="Aromatherapy Products" class="refer-image">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="refer-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6">
                <div class="refer-image-wrapper">
                    <img src="{{ asset('images/info2.jpg') }}" alt="Handcrafted Candles" class="refer-image">
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center justify-content-center refer-content-wrapper">
                <div class="refer-content">
                    <p class="refer-subtitle">Handcrafted Quality</p>
                    <h2 class="refer-title">Made with Care, Made for You</h2>
                    <p class="refer-description">
                        Each candle is carefully handcrafted,<br>
                        ensuring the highest quality and a unique experience in every burn.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="reviews-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">What Our Customers Say</h2>

        <div class="row g-4">
            @foreach ($reviews as $review)
            <x-review-card :review="$review" />
            @endforeach
{{-- x-review-card untuk render komponen dari review-card.blade trs : review = "$review" untuk passing data review ke komponen --}}
        </div>
    </div>
</section>
@endsection