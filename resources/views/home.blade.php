@extends('layout.mainlayout')

@section('title', 'Home Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="hero-section">
    <img src="{{ asset('images/welcome2.jpg') }}" alt="Candle Image" class="hero-image">
    <div class="hero-overlay">
        <h1 class="hero-text">Fall, Redefined in Clean Luxury.</h1>
    </div>
</div>
@endsection