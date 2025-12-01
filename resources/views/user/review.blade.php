@extends('layout.mainlayout')

@section('title', 'My Reviews')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">My Reviews</h1>

    <div class="text-end mb-3">
        <a href="{{ route('user.reviews.create') }}" class="btn btn-primary">Add New Review</a>
    </div>

    <div class="row g-4">
        @forelse ($reviews as $review)
            {{-- Membuat grid untuk review.
    row g-4 → grid Bootstrap dengan gutter 4.
    @forelse → loop $reviews, kalau kosong jalankan @empty. --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">{{ $review->name }}</h5>
                        <div class="text-warning mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        <p class="card-text text-muted">"{{ $review->comment }}"</p>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                        <small class="text-secondary">Posted on {{ $review->created_at->format('M d, Y') }}</small>
                        <div>

                            <a href="{{ route('user.reviews.edit', $review->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('user.reviews.destroy', $review->id) }}" method="POST" class="d-inline" 
                                    onsubmit="return confirm('Are you sure you want to delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                                            {{-- Tombol Edit mengarah ke halaman edit review.
                    Form Delete untuk menghapus review, ada konfirmasi sebelum submit.
                    class="d-inline" supaya form tidak memaksa baris baru. --}}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No reviews yet. Be the first to add one!</p>
        @endforelse
    </div>
</div>
@endsection
