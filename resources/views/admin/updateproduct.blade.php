@extends('layout.mainlayout')

@section('title', 'Edit Product')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Edit Product</h2>

    <div class="card p-4 shadow-sm mx-auto" style="max-width: 600px;">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="collection_name" class="form-label">Collection Name</label>
                <input type="text" name="collection_name" id="collection_name"
                        class="form-control" value="{{ old('collection_name', $product->collection_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="product_type" class="form-label">Product Type</label>
                <input type="text" name="product_type" id="product_type"
                        class="form-control" value="{{ old('product_type', $product->product_type) }}" required>
            </div>

            <div class="mb-3">
                <label for="price_2025" class="form-label">Price (2025)</label>
                <input type="number" name="price_2025" id="price_2025"
                        class="form-control" value="{{ old('price_2025', $product->price_2025) }}">
            </div>

            <div class="mb-3">
                <label for="variants" class="form-label">Variants</label>
                <input type="text" name="variants" id="variants"
                        class="form-control" value="{{ old('variants', $product->variants) }}">
            </div>

            <div class="mb-3">
                <label for="net_price" class="form-label">Net Price (After Disc)</label>
                <input type="number" name="net_price" id="net_price"
                        class="form-control" value="{{ old('net_price', $product->net_price) }}">
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $product->notes) }}</textarea>
            </div>

            {{-- Gambar produk --}}
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($product->image)
                    <div class="mt-3 text-center">
                        <p class="small text-muted mb-1">Current Image:</p>
                        <img src="{{ asset($product->image) }}" class="img-fluid rounded shadow-sm" style="height: 150px;">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
