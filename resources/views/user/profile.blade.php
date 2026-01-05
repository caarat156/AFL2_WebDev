@extends('layout.mainlayout')

@section('title', 'User Profile')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Flash Messages --}}
            @if(session('status') == 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>Profile updated successfully!
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Profile Card --}}
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <img src="{{ asset('images/default-avatar.png') }}" 
                             alt="User Profile"
                             class="rounded-circle shadow-sm"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>

                    <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                    
                    @if(Auth::user()->user_phone)
                        <p class="text-muted mb-3">
                            <i class="bi bi-telephone me-2"></i>{{ Auth::user()->user_phone }}
                        </p>
                    @endif

                    <span class="badge bg-secondary px-3 py-2 mb-4">Regular User</span>
                </div>
            </div>

            {{-- Edit Profile Form --}}
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Profile</h5>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="user_phone" class="form-label">Phone Number</label>
                            <input type="text" id="user_phone" name="user_phone" class="form-control @error('user_phone') is-invalid @enderror" 
                                   value="{{ old('user_phone', Auth::user()->user_phone) }}">
                            @error('user_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-check-lg me-2"></i>Save Changes
                        </button>
                    </form>
                </div>
            </div>

            {{-- Addresses Section --}}
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>My Addresses</h5>
                </div>
                <div class="card-body p-5">
                    @if(Auth::user()->addresses->isEmpty())
                        <p class="text-muted text-center mb-0">No addresses yet</p>
                        <a href="{{ route('user.addresses.create') }}" class="btn btn-sm btn-primary w-100 mt-3">
                            <i class="bi bi-plus-lg me-2"></i>Add New Address
                        </a>
                    @else
                        <div class="row g-3 mb-3">
                            @foreach(Auth::user()->addresses as $address)
                                <div class="col-md-6">
                                    <div class="card border-2 @if($address->is_default) border-success @else border-light @endif h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">
                                                    {{ $address->label ?? 'Address' }}
                                                </h6>
                                                @if($address->is_default)
                                                    <span class="badge bg-success">Default</span>
                                                @endif
                                            </div>

                                            <small class="text-muted d-block mb-2">
                                                <strong>{{ $address->recipient_name }}</strong><br>
                                                {{ $address->phone }}
                                            </small>

                                            <small class="text-muted d-block mb-3">
                                                {{ $address->street }}<br>
                                                {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                                            </small>

                                            <div class="d-flex gap-2">
                                                <a href="{{ route('user.addresses.edit', $address) }}" class="btn btn-sm btn-warning flex-grow-1">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('user.addresses.destroy', $address) }}" method="POST" style="flex-grow: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('user.addresses.create') }}" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-plus-lg me-2"></i>Add New Address
                        </a>
                    @endif
                </div>
            </div>

            {{-- Purchase History --}}
<div class="card shadow-lg border-0 rounded-4 mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="bi bi-bag-check me-2"></i>Purchase History
        </h5>
    </div>

    <div class="card-body p-4">
        @if($orders->isEmpty())
            <p class="text-muted text-center mb-0">No purchases yet</p>
        @else
            @foreach($orders as $order)
                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Order #{{ $order->order_id }}</strong>
                        <span class="badge bg-success">Paid</span>
                    </div>

                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                    </small>

                    <ul class="mt-2 mb-2">
                        @foreach($order->items as $item)
                            <li>
                                {{ $item->product->product_type }}
                                × {{ $item->quantity }}
                            </li>
                        @endforeach
                    </ul>

                    <strong>
                        Total: Rp {{ number_format($order->total_price,0,',','.') }}
                    </strong>
                </div>
            @endforeach
        @endif
    </div>
</div>

{{-- Workshop Registration History --}}
<div class="card shadow-lg border-0 rounded-4 mb-4">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">
            <i class="bi bi-journal-check me-2"></i>Workshop Registration History
        </h5>
    </div>

    <div class="card-body p-4">
        @if($workshopRegistrations->isEmpty())
            <p class="text-muted text-center mb-0">No workshop registrations yet</p>
        @else
            @foreach($workshopRegistrations as $registration)
                <div class="border rounded-3 p-3 mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>{{ $registration->workshop->title }}</strong>
                        <span class="badge 
                            @if($registration->payment_status == 'paid') bg-success
                            @elseif($registration->payment_status == 'pending') bg-warning
                            @else bg-danger @endif
                        ">
                            {{ ucfirst($registration->payment_status) }}
                        </span>
                    </div>

                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}
                        | {{ $registration->participant_count }} participant(s)
                    </small>

                    <p class="mt-2 mb-0">
                        Total: Rp {{ number_format($registration->payment_amount ?? ($registration->workshop->price * $registration->participant_count),0,',','.') }}
                    </p>
                </div>
            @endforeach
        @endif
    </div>
</div>

            {{-- Danger Zone --}}
            <div class="card shadow-lg border-0 rounded-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h5>
                </div>
                <div class="card-body p-5">
                    <p class="text-muted mb-3">Once you delete your account, there is no going back. Please be certain.</p>
                    <form action="{{ route('user.profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete Account
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('user.home') }}" class="btn btn-secondary btn-lg w-100">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
