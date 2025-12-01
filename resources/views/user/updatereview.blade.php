@extends('layout.mainlayout')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Edit Review</h2>

    <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px; border-radius: 12px;">
        <form action="{{ route('user.reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Form akan mengirim data ke route reviews.update dengan method PUT.
            @csrf → token keamanan Laravel.
            @method('PUT') → override method POST menjadi PUT (update resource). --}}


            <div class="mb-3">
                <label for="product_id" class="form-label fw-semibold">Choose Product</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <option value="">-- Choose Product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" 
                            {{ $review->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->product_type }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Dropdown untuk memilih produk yang di-review.
            selected → menandai produk yang sudah ada di review ini. --}}

            <div class="mb-3">
                <label for="rating" class="form-label fw-semibold">Rating (1–5)</label>
                <input type="number" 
                        name="rating" 
                        id="rating" 
                        class="form-control" 
                        min="1" 
                        max="5" 
                        value="{{ $review->rating }}" 
                        required>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label fw-semibold">Comment</label>
                <textarea name="comment" 
                            id="comment" 
                            class="form-control" 
                            rows="4" 
                            required>{{ $review->comment }}</textarea>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('user.reviews.index') }}" class="btn btn-outline-secondary px-4">
                    Cancel
                </a>
                <button type="submit" class="btn btn-dark px-4">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
