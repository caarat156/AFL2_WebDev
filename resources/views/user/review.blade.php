{{-- @extends('layout.mainlayout')

@section('title', 'All Reviews')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">All Customer Reviews</h1>

    <div class="row g-4">
        @forelse ($reviews as $review)
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
                    <div class="card-footer bg-transparent text-end">
                        <small class="text-secondary">Posted on {{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No reviews yet.</p>
        @endforelse
    </div>
</div>
@endsection --}}
