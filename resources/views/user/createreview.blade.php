@extends('layout.mainlayout')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tambah Review Baru</h2>


    <form action="{{ route('user.reviews.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Choose Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Choose Product --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_type }}</option>
                @endforeach
            </select>
        </div>         
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1–5)</label>
            <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-dark">Save</button>
    </form>
</div>
@endsection
