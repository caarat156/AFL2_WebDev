@extends('layout.mainlayout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">

<div class="form-container">
    <h2>Create Workshop</h2>

    <form action="{{ route('admin.workshops.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 📝 Workshop Title --}}
        <div class="form-group">
            <label>Workshop Title</label>
            <input type="text" name="title" required>
        </div>

        {{-- 📝 Description --}}
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4"></textarea>
        </div>

        {{-- 💰 Price --}}
        <div class="form-group">
            <label>Price (IDR)</label>
            <input type="number" name="price" step="0.01" required>
        </div>

        {{-- 📅 Date --}}
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" required>
        </div>

        {{-- ⏰ Time --}}
        <div class="form-group">
            <label>Time</label>
            <input type="time" name="time" autocomplete="new-time" required>
        </div>

        {{-- 📍 Location --}}
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" required>
        </div>

        {{-- 👥 Capacity --}}
        <div class="form-group">
            <label>Capacity</label>
            <input type="number" name="capacity" required>
        </div>

        {{-- 🖼 Workshop Image --}}
        <div class="form-group">
            <label>Workshop Image</label>
            <input type="file" name="image">
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.workshops') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn-submit">Save Workshop</button>
        </div>

    </form>
</div>
@endsection
