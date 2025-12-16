@extends('layout.mainlayout')

@section('title', $workshop->title)

@section('content')
<div class="container my-4">
    <div class="row g-4">
        <!-- Left Side - Image -->
        <div class="col-lg-6 col-md-12">
            @if($workshop->image)
                <img src="{{ asset($workshop->image) }}" 
                    alt="{{ $workshop->title }}" 
                    class="img-fluid rounded shadow w-100" 
                    style="object-fit: cover; max-height: 600px;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" 
                    style="height: 500px;">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif
        </div>

        <!-- Right Side - Details -->
        <div class="col-lg-6 col-md-12">
            <h1 class="mb-3">{{ $workshop->title }}</h1>
            
            <!-- Description -->
            <p class="text-muted mb-3" style="white-space: pre-line;">{{ $workshop->description }}</p>
            
            <!-- Price -->
            <h2 class="text-success fw-bold mb-3">Rp {{ number_format($workshop->price, 0, ',', '.') }}</h2>

            <hr class="my-4">

            <!-- Workshop Details -->
            <h5 class="mb-3">Workshop Details</h5>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-calendar-event text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Date</small>
                            <strong>{{ \Carbon\Carbon::parse($workshop->date)->format('d M Y') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-clock text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Time</small>
                            <strong>{{ $workshop->time }}</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-geo-alt text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Location</small>
                            <strong>{{ $workshop->location }}</strong>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-people text-primary fs-4 me-3"></i>
                        <div>
                            <small class="text-muted d-block">Capacity</small>
                            <strong>{{ $workshop->capacity }} people</strong>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Register Button -->
            <div class="d-grid gap-2">
                <a href="{{ route('workshops.register', $workshop) }}" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Register Now
                </a>
                <a href="{{ route('workshops.index') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Back to Workshops
                </a>
            </div>
        </div>
    </div>
</div>
@endsection