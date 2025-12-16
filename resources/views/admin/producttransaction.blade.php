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
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <h2 class="text-primary">{{ $transactions->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <h2 class="text-success">{{ $transactions->where('status', 'completed')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <h2 class="text-warning">{{ $transactions->where('status', 'pending')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h5 class="card-title">Cancelled</h5>
                    <h2 class="text-danger">{{ $transactions->where('status', 'cancelled')->count() }}</h2>
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