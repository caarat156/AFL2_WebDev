@extends('layout.mainlayout')

@section('title', 'All Transactions')

@section('content')
<div class="container my-5">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">All User Transactions</h1>
        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
            ← Back to Products
        </a>
    </div>

    {{-- Filter & Stats --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center border-primary h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Total Transactions</h5>
                    <h2 class="text-primary mb-0">
                        {{ $transactions->count() }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center border-success h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Completed</h5>
                    <h2 class="text-success mb-0">
                        {{ $transactions->where('status', 'completed')->count() }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center border-warning h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Pending</h5>
                    <h2 class="text-warning mb-0">
                        {{ $transactions->where('status', 'pending')->count() }}
                    </h2>
                </div>
            </div>
        </div>
    </div>


    {{-- Transactions Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Transaction List</h4>
        </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <p class="text-center text-muted py-5">
                    No transactions found.
                </p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Transaction ID</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>#{{ $transaction->id }}</strong></td>
                                    <td>
                                        {{ $transaction->user->name }}<br>
                                        <small class="text-muted">{{ $transaction->user->email }}</small>
                                    </td>
                                    <td>{{ $transaction->product->collection_name }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($transaction->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($transaction->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($transaction->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" 
                                            class="btn btn-sm btn-info text-white">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection