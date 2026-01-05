@extends('layout.mainlayout')

@section('title', 'All Transactions')

@section('content')
<div class="container my-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Transaction History</h1>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center border-primary h-100">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Transactions</h5>
                    <h2 class="text-primary fw-bold">{{ $transactions->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-success h-100">
                <div class="card-body">
                    <h5 class="card-title text-muted">Completed</h5>
                    <h2 class="text-success fw-bold">{{ $transactions->where('payment_status', 'paid')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-warning h-100">
                <div class="card-body">
                    <h5 class="card-title text-muted">Pending</h5>
                    <h2 class="text-warning fw-bold">{{ $transactions->where('payment_status', 'pending')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Transaction List</h5>
        </div>
        <div class="card-body p-0">
            @if($transactions->isEmpty())
                <div class="text-center py-5">
                    <p class="text-muted mb-0">No transactions found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Total Items</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="ps-4 fw-bold">
                                        #{{ substr($transaction->midtrans_order_id, -8) }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ $transaction->user->name ?? 'Guest' }}</span>
                                            <small class="text-muted">{{ $transaction->user->email ?? '-' }}</small>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->order_date)->format('d M Y') }}</td>
                                    <td>{{ $transaction->orderItems->sum('quantity') }} Items</td>
                                    <td class="fw-bold text-primary">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if($transaction->payment_status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($transaction->payment_status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalTx-{{ $transaction->order_id }}">
                                            View Details
                                        </button>
                                    </td>
                                </tr>

                                {{-- ================= MODAL DETAIL (Ditaruh di dalam loop) ================= --}}
                                <div class="modal fade" id="modalTx-{{ $transaction->order_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Order Detail: #{{ substr($transaction->midtrans_order_id, -8) }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                {{-- Info Customer --}}
                                                <div class="row mb-3 bg-light p-3 rounded mx-1">
                                                    <div class="col-md-6">
                                                        <strong>Customer:</strong> {{ $transaction->user->name ?? 'Guest' }}<br>
                                                        <strong>Email:</strong> {{ $transaction->user->email ?? '-' }}
                                                    </div>
                                                    <div class="col-md-6 text-md-end">
                                                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($transaction->order_date)->format('d M Y H:i') }}<br>
                                                        <strong>Payment:</strong> {{ strtoupper($transaction->payment_method ?? '-') }}
                                                    </div>
                                                </div>

                                                {{-- Tabel Barang --}}
                                                <table class="table table-bordered">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Price</th>
                                                            <th>Qty</th>
                                                            <th class="text-end">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($transaction->orderItems as $item)
                                                            <tr>
                                                                <td>{{ $item->product->title ?? 'Item Deleted' }}</td>
                                                                <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                                <td class="text-center">{{ $item->quantity }}</td>
                                                                <td class="text-end">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-end fw-bold">Total</td>
                                                            <td class="text-end fw-bold text-primary">
                                                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ================= END MODAL ================= --}}

                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection