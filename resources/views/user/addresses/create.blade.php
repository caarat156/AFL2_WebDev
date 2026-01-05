@extends('layout.mainlayout')

@section('title', 'Add Address')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">

            <h1 class="mb-4">Add New Address</h1>

            <form action="{{ route('user.addresses.store', ['from' => request('from', 'addresses')]) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="label" class="form-label">Label (e.g., Home, Office)</label>
                    <input type="text" id="label" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label') }}">
                    @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="recipient_name" class="form-label">Recipient Name *</label>
                    <input type="text" id="recipient_name" name="recipient_name" class="form-control @error('recipient_name') is-invalid @enderror" value="{{ old('recipient_name') }}" required>
                    @error('recipient_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number *</label>
                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="street" class="form-label">Street Address *</label>
                    <textarea id="street" name="street" class="form-control @error('street') is-invalid @enderror" rows="2" required>{{ old('street') }}</textarea>
                    @error('street') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="city" class="form-label">City *</label>
                        <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="province" class="form-label">Province *</label>
                        <input type="text" id="province" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province') }}" required>
                        @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="postal_code" class="form-label">Postal Code *</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" value="{{ old('postal_code') }}" required>
                    @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                @if($address->is_default)
    <span class="badge bg-success">Default</span>
@else
    <form action="{{ route('address.default', $address->address_id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT') <button type="submit" class="btn btn-sm btn-outline-primary">
            Set as Default
        </button>
    </form>
@endif

<form action="{{ route('address.update', $address->address_id) }}" method="POST">
    @csrf
    @method('PUT') <input type="text" name="recipient_name" value="{{ $address->recipient_name }}">
    
    <button type="submit">Save</button>
</form>

        </div>
    </div>
</div>
@endsection
