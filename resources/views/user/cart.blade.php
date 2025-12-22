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

            {{-- ================= CHECKOUT ================= --}}
            <form action="{{ route('user.checkout') }}" method="POST" id="checkoutForm">
                @csrf
                
                <!-- Hidden input untuk selected items -->
                <input type="hidden" id="selectedItemsInput" name="selected_items" value="">

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
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const checkoutForm = document.getElementById('checkoutForm');

    // Select All functionality
    selectAllCheckbox?.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSummary();
    });

    // Individual checkbox change
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSummary);
    });

    // Update quantity
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const cartId = this.dataset.cartId;
            const quantity = this.value;

            fetch(`/user/cart/${cartId}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update data-quantity untuk recalc summary
                    const checkbox = input.closest('tr').querySelector('.item-checkbox');
                    checkbox.dataset.quantity = quantity;
                    updateSummary();
                }
            })
            .catch(err => console.error('Error:', err));
        });
    });

    // Update summary
    function updateSummary() {
        let totalItems = 0;
        let totalAmount = 0;
        let selectedIds = [];

        itemCheckboxes.forEach(checkbox => {
            if(checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                const subtotal = price * quantity;

                totalItems += quantity;
                totalAmount += subtotal;
                selectedIds.push(checkbox.value);
            }
        });

        document.getElementById('itemsCount').textContent = totalItems;
        document.getElementById('subtotalAmount').textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');
        document.getElementById('totalAmount').textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');
        document.getElementById('selectedItemsInput').value = JSON.stringify(selectedIds);
        
        checkoutBtn.disabled = selectedIds.length === 0;
    }

    // Prevent checkout if no items selected
    checkoutForm?.addEventListener('submit', function(e) {
        const selectedIds = JSON.parse(document.getElementById('selectedItemsInput').value || '[]');
        if(selectedIds.length === 0) {
            e.preventDefault();
            alert('Please select at least one item');
        }
    });
});
</script>
@endsection
