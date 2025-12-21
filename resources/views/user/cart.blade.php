@extends('layout.mainlayout')

@section('title', 'Shopping Cart')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <h1 class="mb-4">
                <i class="bi bi-bag-check me-2"></i>Shopping Cart
            </h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-bag-x" style="font-size: 3rem; color: #6c757d;"></i>
                    <p class="mt-3 mb-0">Your cart is empty</p>
                </div>
            @else
                <form id="checkoutForm" action="{{ route('user.checkout') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>Product</th>
                                    <th class="text-center text-nowrap" style="width:180px;">Price</th>
                                    <th class="text-center text-nowrap" style="width:140px;">Quantity</th>
                                    <th class="text-center text-nowrap" style="width:220px;">Subtotal</th>
                                    <th class="text-center" style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td class="text-center align-middle">
                                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                                                class="form-check-input item-checkbox"
                                                data-price="{{ $item->product->price_2025 ?? $item->product->price_2024 }}"
                                                data-quantity="{{ $item->quantity }}">
                                        </td>
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
                                        <td class="text-center text-nowrap">
                                            <strong>Rp {{ number_format($item->product->price_2025 ?? $item->product->price_2024, 0, ',', '.') }}</strong>
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{-- ✅ INPUT AUTO-SAVE (tanpa tombol update) --}}
                                            <input type="number" 
                                                value="{{ $item->quantity }}" 
                                                min="1" 
                                                class="form-control quantity-input" 
                                                style="width: 80px; margin: 0 auto;"
                                                data-cart-id="{{ $item->id }}"
                                                data-price="{{ $item->product->price_2025 ?? $item->product->price_2024 }}"
                                                title="Press Enter or click outside to save">
                                        </td>
                                        <td class="text-center text-nowrap">
                                            <strong class="item-subtotal" data-cart-id="{{ $item->id }}">
                                                Rp {{ number_format(($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" 
                                                class="btn btn-sm btn-danger delete-item-btn d-inline-flex align-items-center justify-content-center"
                                                data-cart-id="{{ $item->id }}"
                                                title="Remove item">
                                                <i class="bi bi-trash"></i>
                                            </button>
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
                                        <span>Items Selected:</span>
                                        <span id="itemsCount">0</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span id="subtotalAmount">Rp 0</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping:</span>
                                        <span class="text-muted">TBD</span>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Total:</strong>
                                        <strong class="text-success fs-5" id="totalAmount">Rp 0</strong>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100" id="checkoutBtn" disabled>
                                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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