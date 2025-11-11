@extends('layout.mainlayout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
<div class="form-container">
    <h2>Create Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Collection Name</label>
            <input type="text" name="collection_name" required>
        </div>

        <div class="form-group">
            <label>Product Type</label>
            <input type="text" name="product_type" required>
        </div>

        <div class="form-group">
            <label>Variants</label>
            <input type="text" name="variants">
        </div>

        <div class="form-group">
            <label>Price 2024</label>
            <input type="number" name="price_2024">
        </div>

        <div class="form-group">
            <label>Price 2025</label>
            <input type="number" name="price_2025">
        </div>

        <div class="form-group">
            <label>Net Price</label>
            <input type="number" name="net_price">
        </div>

        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes"></textarea>
        </div>

        <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="image">
        </div>

        <div class="d-flex justify-content-between">
        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn-submit">Save Product</button>
        </div>
    </form>
</div>
@endsection
