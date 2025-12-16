@extends('layout.mainlayout')

@section('title', 'Our Workshops')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Lawasan Workshops</h1>

    @if(request('search'))
        <p class="text-center text-muted mb-4">
            Showing results for: <strong>"{{ request('search') }}"</strong>
        </p>
    @endif

    @if($workshops->isEmpty())
        <p class="text-center text-secondary fs-5 mt-5">
            No workshops found.
        </p>
    @else
        <div class="row justify-content-center">
            @foreach ($workshops as $workshop)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        
                        @if($workshop->image)
                            <img src="{{ asset($workshop->image) }}" 
                                alt="{{ $workshop->title }}" 
                                class="img-fluid rounded-top" 
                                style="height: 250px; width: 100%; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-top" 
                                style="height: 250px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ $workshop->title }}</h5>

                            <div class="mb-2">
                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                <span class="small">{{ \Carbon\Carbon::parse($workshop->date)->format('d M Y') }}</span>
                            </div>

                            <div class="mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <span class="small">{{ $workshop->location }}</span>
                            </div>

                            <div class="mb-3">
                                <i class="bi bi-people text-primary me-2"></i>
                                <span class="small">Capacity: {{ $workshop->capacity }} people</span>
                            </div>

                            <div class="mb-3">
                                <p class="fw-bold text-success mb-0 fs-5">
                                    Rp {{ number_format($workshop->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <a href="{{ route('workshops.show', $workshop) }}" class="btn btn-primary w-100">
                                See Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection