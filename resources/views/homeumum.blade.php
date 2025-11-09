@extends('layout.mainlayout')

@section('title', 'Welcome')

@section('content')
<div class="container text-center my-5">
    <h1>Welcome to Our Website!</h1>
    <p>Silakan <a href="{{ route('login') }}">Login</a> atau <a href="{{ route('register') }}">Register</a> untuk melanjutkan.</p>
</div>
@endsection
