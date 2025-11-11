@extends('layout.mainlayout')

@section('title', 'Our Stores')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Our Stores</h1>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.stores.create') }}" class="btn btn-primary">
                    + Add New Store
                </a>
            @endif
        @endauth
    </div>

    @if($stores->isEmpty())
        <p class="text-center text-secondary fs-5 mt-5">
            No stores found.
        </p>
    @else
        <div class="row justify-content-center">
            @foreach ($stores as $store)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        @php
                            $imagePath = $store->image 
                                ? (Str::startsWith($store->image, 'storage/')
                                    ? asset($store->image)
                                    : asset('images/' . $store->image))
                                : asset('images/default-store.jpg'); 
                        @endphp

                        <img src="{{ $imagePath }}" 
                             alt="{{ $store->name }}" 
                             class="img-fluid rounded shadow-sm"
                             style="height: 200px; width: 100%; object-fit: cover;">

                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">{{ $store->name }}</h5>

                            @if ($store->location)
                                <p class="text-muted small mb-1">{{ $store->location }}</p>
                            @endif

                            @if ($store->description)
                                <p class="text-secondary small mt-2">{{ $store->description }}</p>
                            @endif

                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                        <a href="{{ route('admin.stores.edit', $store->id) }}" 
                                            class="btn btn-sm btn-warning px-3">
                                            Update
                                        </a>
                                        <form action="{{ route('admin.stores.destroy', $store->id) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Are you sure you want to delete this store?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
