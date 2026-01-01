@extends('layout.mainlayout')

@section('title', 'Shopping Cart')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">

            <h1 class="mb-4">
                <i class="bi bi-bag-check me-2"></i>Shopping Cart
            </h1>

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ================= SHIPPING ADDRESS ================= --}}
            @if(auth()->user()->addresses->isEmpty())
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>No shipping address yet.</strong>
                    <a href="{{ route('user.addresses.create') }}" class="alert-link">Add your first address</a>
                </div>
            @else
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-geo-alt me-2"></i>Shipping Address
                    </div>
                    <div class="card-body">
                        @php
                            $defaultAddress = auth()->user()->defaultAddress;
                            $address = $defaultAddress ?? auth()->user()->addresses->first();
                        @endphp
                        
                        <div class="row">
                            <div class="col-md-8">
                                <p class="mb-2">
                                    <strong>{{ $address->label ?? 'Address' }}</strong>
                                </p>
                                <p class="mb-2 text-muted">
                                    {{ $address->recipient_name }}<br>
                                    {{ $address->phone }}<br>
                                    {{ $address->street }}<br>
                                    {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('user.addresses', ['from' => 'cart']) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i>Change Address
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Empty Cart --}}
            @if($cartItems->isEmpty())
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-bag-x fs-1"></i>
                    <p class="mt-3 mb-0">Your cart is empty</p>
                </div>
            @else

            {{-- ================= CART TABLE ================= --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width:60px;">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Product</th>
                            <th class="text-center" style="width:180px;">Price</th>
                            <th class="text-center" style="width:140px;">Quantity</th>
                            <th class="text-center" style="width:220px;">Subtotal</th>
                            <th class="text-center" style="width:100px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cartItems as $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox"
                                    class="form-check-input item-checkbox"
                                    value="{{ $item->id }}"
                                    data-price="{{ $item->product->price_2025 ?? $item->product->price_2024 }}"
                                    data-quantity="{{ $item->quantity }}">
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->product->image)
                                        <img src="{{ asset($item->product->image) }}"
                                             style="width:60px;height:60px;object-fit:cover;border-radius:4px;">
                                    @endif
                                    <div>
                                        <strong>{{ $item->product->product_type }}</strong><br>
                                        <small class="text-muted">{{ $item->product->collection_name }}</small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                Rp {{ number_format($item->product->price_2025 ?? $item->product->price_2024,0,',','.') }}
                            </td>

                            <td class="text-center">
                                <input type="number"
                                    min="1"
                                    value="{{ $item->quantity }}"
                                    class="form-control quantity-input"
                                    style="width:80px;margin:auto;"
                                    data-cart-id="{{ $item->cart_id }}">
                            </td>

                            <td class="text-center">
                                Rp {{ number_format(($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity,0,',','.') }}
                            </td>

                            {{-- DELETE --}}
                            <td class="text-center">
                                <form action="{{ route('user.cart.remove', $item) }}" method="POST"
                                    onsubmit="return confirm('Remove this item?')">
                                  @csrf
                                  @method('DELETE')
                              
                                  <button class="btn btn-danger btn-sm">
                                      <i class="bi bi-trash"></i>
                                  </button>
                              </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ================= CHECKOUT ================= --}}
            <form action="{{ route('user.checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <div id="selectedInputs"></div> {{-- ini penting --}}
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
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong id="totalAmount">Rp 0</strong>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
    
        const selectAllCheckbox = document.getElementById('selectAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const checkoutForm = document.getElementById('checkoutForm');
        const selectedInput = document.getElementById('selectedItemsInput');
    
        // ================= SELECT ALL =================
        selectAllCheckbox?.addEventListener('change', function () {
            itemCheckboxes.forEach(cb => cb.checked = this.checked);
            updateSummary();
        });
    
        // ================= SINGLE CHECKBOX =================
        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateSummary);
        });
    
        // ================= QUANTITY CHANGE =================
        quantityInputs.forEach(input => {
            input.addEventListener('change', function () {
                const row = this.closest('tr');
                const checkbox = row.querySelector('.item-checkbox');
    
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(this.value);
    
                // update data attribute
                checkbox.dataset.quantity = quantity;
    
                // update subtotal column
                const subtotalCell = row.children[4];
                subtotalCell.textContent =
                    'Rp ' + (price * quantity).toLocaleString('id-ID');
    
                updateSummary();
            });
        });
    
        // ================= SUMMARY =================
        function updateSummary() {
    let totalItems = 0;
    let totalAmount = 0;
    let selectedIds = [];

    document.getElementById('selectedInputs').innerHTML = '';

    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        if (checkbox.checked) {
            const price = parseFloat(checkbox.dataset.price);
            const quantity = parseInt(checkbox.dataset.quantity);

            totalItems += quantity;
            totalAmount += price * quantity;
            selectedIds.push(checkbox.value);

            // ⬇️ BUAT INPUT HIDDEN
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = checkbox.value;
            document.getElementById('selectedInputs').appendChild(input);
        }
    });

    document.getElementById('itemsCount').textContent = totalItems;
    document.getElementById('subtotalAmount').textContent =
        'Rp ' + totalAmount.toLocaleString('id-ID');
    document.getElementById('totalAmount').textContent =
        'Rp ' + totalAmount.toLocaleString('id-ID');

    document.getElementById('checkoutBtn').disabled = selectedIds.length === 0;
}
    
        // ================= PREVENT EMPTY CHECKOUT =================
        checkoutForm?.addEventListener('submit', function (e) {
            if (!selectedInput.value || selectedInput.value === '[]') {
                e.preventDefault();
                alert('Please select at least one item');
            }
        });
    
    });
    </script>

@endsection
