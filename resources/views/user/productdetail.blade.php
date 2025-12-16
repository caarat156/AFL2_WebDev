@extends('layout.mainlayout')

@section('title', $product->product_type)

@section('content')
<div class="container my-4">
    <div class="row g-4">
        <!-- Left Side - Image -->
        <div class="col-lg-6 col-md-12">
            @if($product->image)
                <img src="{{ asset($product->image) }}" 
                    alt="{{ $product->product_type }}" 
                    class="img-fluid rounded shadow w-100" 
                    style="object-fit: cover; max-height: 600px;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" 
                    style="height: 500px;">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif
        </div>

        <!-- Right Side - Details -->
        <div class="col-lg-6 col-md-12">
            <h1 class="mb-2">{{ $product->product_type }}</h1>
            <p class="text-muted mb-3">Collection: <strong>{{ $product->collection_name }}</strong></p>
            
            <!-- Description -->
            @if($product->notes)
                <p class="text-muted mb-3" style="white-space: pre-line;">{{ $product->notes }}</p>
            @endif
            
            <!-- Price -->
            <h2 class="text-success fw-bold mb-3">Rp {{ number_format($product->price_2025 ?? $product->price_2024, 0, ',', '.') }}</h2>

            @if($product->net_price)
                <p class="text-info mb-3">
                    <i class="bi bi-percent"></i> After Discount: <strong>Rp {{ number_format($product->net_price, 0, ',', '.') }}</strong>
                </p>
            @endif

            <hr class="my-4">

            <!-- Product Details -->
            <h5 class="mb-3">Product Information</h5>
            
            <div class="row g-3 mb-3">
                @if($product->variants)
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-palette text-primary fs-4 me-3"></i>
                            <div>
                                <small class="text-muted d-block">Variants</small>
                                <strong>{{ $product->variants }}</strong>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-box text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Collection</small>
                            <strong>{{ $product->collection_name }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">


            <!-- Add to Cart & Back Buttons -->
            <div class="d-grid gap-2">
                <form action="{{ route('user.cart.add') }}" method="POST" id="addToCartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="quantityInput" value="1">
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                    </button>
                </form>
                <a href="{{ route('user.products') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart() {
        const quantity = document.getElementById('quantity').value;
        alert('Added ' + quantity + ' item(s) to cart!');
    }
</script>
@endsection
