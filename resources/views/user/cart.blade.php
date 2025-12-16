@extends('layout.mainlayout')

@section('title', 'Shopping Cart')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">
                <i class="bi bi-bag-check me-2"></i>Shopping Cart
            </h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-bag-x" style="font-size: 3rem; color: #6c757d;"></i>
                    <p class="mt-3 mb-0">Your cart is empty</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table border">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($item->product->image)
                                                <img src="{{ asset($item->product->image) }}" 
                                                    alt="{{ $item->product->product_type }}" 
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                    style="width: 60px; height: 60px; border-radius: 4px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $item->product->product_type }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $item->product->collection_name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($item->product->price_2025 ?? $item->product->price_2024, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.cart.update', $item) }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format(($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.cart.remove', $item) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cart Summary -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Order Summary</h5>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format(
                                        $cartItems->sum(function($item) {
                                            return ($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity;
                                        }), 0, ',', '.'
                                    ) }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span class="text-muted">TBD</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong class="text-success fs-5">Rp {{ number_format(
                                        $cartItems->sum(function($item) {
                                            return ($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity;
                                        }), 0, ',', '.'
                                    ) }}</strong>
                                </div>

                                <button class="btn btn-success w-100" disabled>
                                    <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('user.products') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
