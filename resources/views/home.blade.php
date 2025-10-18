@extends('layout.mainlayout')

@section('title', 'Home Page')

@section('content')
<div class="hero-section">
    <img src="{{ asset('images/welcome2.jpg') }}" alt="Candle Image" class="hero-image">
    <div class="hero-text">
        <h1>Fall, Redefined in Clean Luxury.</h1>
    </div>
</div>
@endsection
