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

    <button class="btn btn-primary mt-3">Pay Now</button>
</div>
@endsection
