{{-- resources/views/home.blade.php --}}
@extends('layout.mainlayout')

@section('title', 'Home Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section-fullscreen">
    <img src="{{ asset('images/welcome2.jpg') }}" alt="Candle Image" class="hero-image">
    <div class="hero-overlay">
        <h1 class="hero-text">Natural, Nostalgic and Created with Love</h1>
    </div>
</div>

<!-- Best Sellers Section -->
<section class="best-sellers-section">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="best-sellers-title mb-0">Best Sellers</h2>
            <div class="carousel-controls d-none d-md-flex">
                <button class="carousel-btn" type="button" data-bs-target="#productsCarousel" data-bs-slide="prev">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="carousel-btn" type="button" data-bs-target="#productsCarousel" data-bs-slide="next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
        
        <!-- Bootstrap Carousel -->
        <div id="productsCarousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <img src="{{ asset('images/product1.jpg') }}" alt="Scented Candle" class="product-image">
                                </div>
                                <div class="product-info">
                                    <p class="product-category">Best Selling Candles</p>
                                    <h3 class="product-name">SCENTED CANDLE</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <img src="{{ asset('images/product2.jpg') }}" alt="Egyptian Moonstone" class="product-image">
                                </div>
                                <div class="product-info">
                                    <p class="product-category">Best Selling Candles</p>
                                    <h3 class="product-name">REED DIFFUSER</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 d-none d-lg-block">
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <img src="{{ asset('images/product3.jpg') }}" alt="Orange Blossom" class="product-image">
                                </div>
                                <div class="product-info">
                                    <p class="product-category">Best Selling Candles</p>
                                    <h3 class="product-name">EAU DE PARFUM</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 d-none d-lg-block">
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <img src="{{ asset('images/product4.jpg') }}" alt="Caribbean Teakwood" class="product-image">
                                </div>
                                <div class="product-info">
                                    <p class="product-category">Best Selling Candles</p>
                                    <h3 class="product-name">HANGING MINI DIFFUSER</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Indicators for mobile -->
            <div class="carousel-indicators d-md-none">
                <button type="button" data-bs-target="#productsCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#productsCarousel" data-bs-slide-to="1"></button>
            </div>
        </div>
    </div>
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
                        <p class="mb-0 text-muted">“{{ $review->comment }}”</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
</section>
@endsection