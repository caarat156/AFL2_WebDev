@extends('layout.mainlayout')

@section('title', 'Checkout')

@section('content')
<div class="container my-5">
    <h3>Checkout Summary</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->product->product_type }}</td>
                <td>{{ $item->quantity }}</td>
                <td>
                    Rp {{ number_format(($item->product->price_2025 ?? $item->product->price_2024) * $item->quantity,0,',','.') }}
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: Rp {{ number_format($total,0,',','.') }}</h4>

    <h5 class="mt-4">Payment Method</h5>

<div class="form-check">
    <input class="form-check-input" type="radio" name="payment_method" value="gopay" checked>
    <label class="form-check-label">GoPay</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio" name="payment_method" value="shopeepay">
    <label class="form-check-label">ShopeePay</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer">
    <label class="form-check-label">Bank Transfer</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio" name="payment_method" value="credit_card">
    <label class="form-check-label">Credit Card</label>
</div>


<button id="payBtn" class="btn btn-success mt-3">
    Pay Now
</button>

{{-- Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

{{-- Script Payment --}}
<script>
    document.getElementById('payBtn').addEventListener('click', function () {
        const paymentMethod = document.querySelector(
            'input[name="payment_method"]:checked'
        ).value;
    
        fetch('/user/payment/snap-token', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
        order_id: @json($order->order_id),
        payment_method: paymentMethod
    })
})
.then(async res => {
    const text = await res.text();
    console.log('RAW RESPONSE:', text);
    try {
        return JSON.parse(text);
    } catch (e) {
        throw new Error('Response bukan JSON');
    }
})
.then(data => {
    console.log('JSON DATA:', data);

    if (!data.snap_token) {
        alert('Snap token tidak ditemukan');
        return;
    }

    snap.pay(data.snap_token, {
        onSuccess: function (result) {
            window.location.href =
                "{{ route('user.payment.finish') }}" +
                "?order_id=" + result.order_id +
                "&transaction_status=" + result.transaction_status;
        },
        onPending: function (result) {
            window.location.href =
                "{{ route('user.payment.finish') }}" +
                "?order_id=" + result.order_id +
                "&transaction_status=" + result.transaction_status;
        },
        onError: function () {
            alert('Pembayaran gagal');
        }
    });
})
.catch(err => {
    console.error('FETCH ERROR:', err);
    alert('Terjadi error. Cek console!');
});

    });
    </script>

    </div>
@endsection
