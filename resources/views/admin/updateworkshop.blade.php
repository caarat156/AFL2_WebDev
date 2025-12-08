@extends('layout.mainlayout')

@section('title', 'Edit Workshop')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Edit Workshop</h2>

    <div class="card p-4 shadow-sm mx-auto" style="max-width: 650px;">
        <form action="{{ route('admin.workshops.update', $workshop->workshop_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Workshop Title --}}
            <div class="mb-3">
                <label class="form-label">Workshop Title</label>
                <input type="text" name="title" class="form-control"
                    value="{{ old('title', $workshop->title) }}" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $workshop->description) }}</textarea>
            </div>

            {{-- Price --}}
            <div class="mb-3">
                <label class="form-label">Price (IDR)</label>
                <input type="number" name="price" class="form-control" step="0.01"
                    value="{{ old('price', $workshop->price) }}" required>
            </div>

            {{-- Date --}}
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control"
                    value="{{ old('date', $workshop->date) }}" required>
            </div>

            {{-- Time --}}
            <div class="mb-3">
                <label class="form-label">Time</label>
                <input type="time" name="time" class="form-control"
                    value="{{ old('time', $workshop->time) }}" required>
            </div>

            {{-- Location --}}
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control"
                    value="{{ old('location', $workshop->location) }}" required>
            </div>

            {{-- Capacity --}}
            <div class="mb-3">
                <label class="form-label">Capacity</label>
                <input type="number" name="capacity" class="form-control"
                    value="{{ old('capacity', $workshop->capacity) }}" required>
            </div>

            {{-- Image Upload --}}
            <div class="mb-3">
                <label class="form-label">Workshop Image</label>
                <input type="file" name="image" class="form-control">

                @if ($workshop->image)
                    <div class="mt-3 text-center">
                        <p class="small text-muted mb-1">Current Image:</p>
                        <img src="{{ asset($workshop->image) }}" class="img-fluid rounded shadow-sm"
                             style="height: 150px; object-fit: cover;">
                    </div>
                @endif
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.workshops') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Update Workshop</button>
            </div>
        </form>
    </div>
</div>
@endsection
