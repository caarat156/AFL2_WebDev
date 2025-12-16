@extends('layout.mainlayout')

@section('title', 'Admin Workshops')

@section('content')
<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Manage Workshops</h1>

        {{-- tombol tambah workshop --}}
        <a href="{{ route('admin.workshops.create') }}" class="btn btn-primary">
            + Add New Workshop
        </a>
    </div>

    @if($workshops->isEmpty())
        <p class="text-center text-secondary fs-5 mt-5">
            No workshops found.
        </p>
    @else
        <div class="row justify-content-center">
            @foreach ($workshops as $workshop)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0 h-100">

                        @php
                            $imagePath = $workshop->image
                                ? (Str::startsWith($workshop->image, 'storage/')
                                    ? asset($workshop->image)
                                    : asset($workshop->image))
                                : asset('images/default-workshop.jpg');
                        @endphp

                        <img src="{{ $imagePath }}" 
                            alt="{{ $workshop->title }}" 
                            class="img-fluid rounded shadow-sm"
                            style="height: 200px; width: 100%; object-fit: cover;">

                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $workshop->title }}</h5>

                            <p class="text-muted small mb-1">
                                {{ \Carbon\Carbon::parse($workshop->date)->format('d M Y') }}
                                • {{ \Carbon\Carbon::parse($workshop->time)->format('H:i') }}
                            </p>

                            @if($workshop->location)
                                <p class="text-secondary small mb-1">
                                    {{ $workshop->location }}
                                </p>
                            @endif

                            <p class="text-dark fw-semibold mt-2 mb-3">
                                Rp {{ number_format($workshop->price, 0, ',', '.') }}
                            </p>

                            {{-- admin buttons - dengan flex-column untuk vertikal --}}
                            <div class="mt-auto">
                                <a href="{{ route('admin.workshops.participants', $workshop) }}" 
                                    class="btn btn-sm btn-info w-100 mb-2 text-white">
                                    See Participants
                                </a>
                                
                                <a href="{{ route('admin.workshops.edit', $workshop) }}" 
                                    class="btn btn-sm btn-warning w-100 mb-2">
                                    Update
                                </a>

                                <form action="{{ route('admin.workshops.destroy', $workshop) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this workshop?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
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
</div>
@endsection