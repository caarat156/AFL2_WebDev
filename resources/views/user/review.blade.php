@extends('layout.mainlayout')

@section('title', 'My Reviews')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">My Reviews</h1>

    <div class="text-end mb-3">
        <a href="{{ route('user.reviews.create') }}" class="btn btn-primary">Add New Review</a>
    </div>

    <div class="reviews-section mt-10">
        <h3 class="font-bold text-xl mb-4">Ulasan Pembeli</h3>
    
        {{-- Cek apakah ada review? Gunakan @forelse --}}
        @if(isset($product->reviews))
            @forelse($product->reviews as $review)
                {{-- INI LOOPING KALAU ADA REVIEW --}}
                <div class="review-card border-b py-4">
                    <div class="flex items-center mb-2">
                        <div class="font-bold mr-2">{{ $review->user->name ?? 'User' }}</div>
                        <span class="text-yellow-500">★ {{ $review->rating }}</span>
                    </div>
                    <p class="text-gray-600">{{ $review->comment }}</p>
                    <small class="text-gray-400">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            @empty
                {{-- INI YANG MUNCUL KALAU KOSONG --}}
                <div class="text-center py-10 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                </div>
            @endforelse
        @else
            {{-- Jaga-jaga kalau relasi belum dibuat --}}
            <div class="text-center py-10 bg-gray-50 rounded-lg">
                <p class="text-gray-500">Belum ada ulasan.</p>
            </div>
        @endif
    </div>
@endsection
