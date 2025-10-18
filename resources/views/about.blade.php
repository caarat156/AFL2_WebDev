{{-- resources/views/about.blade.php --}}
@extends('layout.mainlayout')

@section('title', 'About Lawasan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')
<div class="container my-5 py-4">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5 pb-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="position-relative py-4">
                <span class="quote-mark quote-open">"</span>
                <h1 class="display-4 fw-light mb-4 position-relative" style="color: #6b4e3d;">
                    a scent can bring back a thousand memories
                </h1>
                <span class="quote-mark quote-close">"</span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <p class="lead mb-4 text-muted" style="line-height: 1.8;">
                    Lawasan is a family business founded in 2019 by a mother and daughter who share the same hobbies and likings.
                </p>
                <p class="lead mb-4 text-muted" style="line-height: 1.8;">
                    The name 'Lawasan' was chosen as all of the products are 100% handmade with natural ingredients, to uphold the authenticity with freedom of making art. The products are especially made to remind you of the good old times and celebrate those happy memories.
                </p>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <hr class="my-5" style="border-color: #e8ddd4; opacity: 0.5;">

    <!-- Product Evolution Section -->
    <div class="row mb-5 pb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="mb-4 fw-light" style="color: #6b4e3d;">Our Journey</h2>
            <p class="text-muted fs-5" style="line-height: 1.8;">
                Our signature products keep on evolving and improving, started with only scented candles to eau de perfume and the newest healing roll on. By always keeping you in mind, we carefully and especially craft all of the products with personal touch, to enlighten and inspire everyone.
            </p>
        </div>
    </div>

    <!-- Values Section -->
    <div class="row g-4 mb-5 pb-4">
        <div class="col-md-4">
            <div class="card border-0 text-center p-4 h-100" style="background-color: #faf8f6;">
                <div class="card-body">
                    <div class="mb-3 fs-1">🌿</div>
                    <h4 class="card-title fw-light mb-3" style="color: #6b4e3d;">100% Natural</h4>
                    <p class="card-text text-muted">Handcrafted with natural ingredients for authentic quality</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center p-4 h-100" style="background-color: #faf8f6;">
                <div class="card-body">
                    <div class="mb-3 fs-1">❤️</div>
                    <h4 class="card-title fw-light mb-3" style="color: #6b4e3d;">Family Made</h4>
                    <p class="card-text text-muted">Created with love by a mother-daughter duo since 2019</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center p-4 h-100" style="background-color: #faf8f6;">
                <div class="card-body">
                    <div class="mb-3 fs-1">✨</div>
                    <h4 class="card-title fw-light mb-3" style="color: #6b4e3d;">Nostalgic</h4>
                    <p class="card-text text-muted">Designed to evoke cherished memories and happy moments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 text-center p-5" style="background-color: #f5f0eb; border-radius: 10px;">
                <div class="card-body">
                    <h3 class="mb-3 fw-light" style="color: #6b4e3d;">Experience the Memories</h3>
                    <p class="mb-4 text-muted">Discover our handcrafted collection of scented products</p>
                    <a href="{{ url('/product') }}" class="btn btn-lg px-5 py-3" style="background-color: #6b4e3d; color: white; border: none; border-radius: 30px;">
                        Explore Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection