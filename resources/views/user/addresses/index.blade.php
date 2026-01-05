@extends('layout.mainlayout')

@section('title', 'My Addresses')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <h1 class="mb-4">
                <i class="bi bi-geo-alt me-2"></i>My Addresses
            </h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($addresses->isEmpty())
                <div class="alert alert-info text-center py-5">
                    <p>No addresses yet</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($addresses as $address)
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">
                                            {{ $address->label ?? 'Address' }}
                                        </h5>
                                        @if($address->is_default)
                                            <span class="badge bg-success">Default</span>
                                        @endif
                                    </div>

                                    <p class="text-muted mb-2">
                                        <strong>{{ $address->recipient_name }}</strong><br>
                                        {{ $address->phone }}
                                    </p>

                                    <p class="mb-3">
                                        {{ $address->street }}<br>
                                        {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                                    </p>

                                    <div class="d-flex gap-2">
                                        @if(!$address->is_default)
                                            <form action="{{ route('user.addresses.set-default', $address) }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                                                    Set as Default
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('user.addresses.edit', $address) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('address.destroy', $address->address_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus alamat ini?');">
                                            @csrf
                                            @method('DELETE') <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('user.addresses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Add New Address
                </a>
                <a href="{{ route('user.cart') }}" class="btn btn-secondary">
                    Back to Cart
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
