{{-- resources/views/home.blade.php --}}
@extends('layout.mainlayout')

@section('title', 'Home Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-fullscreen">
    <img src="{{ asset('images/welcome4.png') }}" alt="Candle Image" class="hero-image">
    <div class="hero-overlay">
        <h1 class="hero-text">Natural, Nostalgic and Created with Love</h1>
    </div>
</div>

<!-- Best Sellers Section -->
<section class="best-sellers-section">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="best-sellers-title mb-0">Best Sellers</h2>
        </div>
        
        <div class="row g-3">
            @foreach($bestSellers as $product)
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

<!-- Refer a Friend Section -->
<section class="refer-section">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-6 d-flex align-items-center justify-content-center refer-content-wrapper">
                <div class="refer-content">
                    <p class="refer-subtitle">Suitable for Gifts</p>
                    <h2 class="refer-title">A Gift For Them, A Gift For You</h2>
                    <p class="refer-description">
                        Introduce your friends and family to Aromatherapy Associates,<br>
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

<!-- Second Refer Section -->
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
                        Each candle is carefully handcrafted using premium natural ingredients,<br>
                        ensuring the highest quality and a unique experience in every burn.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Reviews Section -->
<section class="reviews-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">What Our Customers Say</h2>

        <div class="row g-4">
            @foreach ($reviews as $review)
                <div class="col-lg-4 col-md-6">
                    <div class="review-card p-4 shadow-sm rounded-3 bg-light">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="bi bi-person-circle fs-2 text-secondary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $review->name }}</h5>
                                <div class="text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="mb-0 text-muted">"{{ $review->comment }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection