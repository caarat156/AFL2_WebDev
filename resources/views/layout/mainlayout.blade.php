<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/js/app.js'])

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coupsaurus')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fontcustom.css') }}">
    @stack('styles')

</head>
<body>

    @include('layout.nav')
    {{-- include untuk menyisipkan otongan file lain --}}
    <main class="min-vh-100">
        @yield('content')
        {{-- yield digunakan untuk menandai bagian yang akan diisi oleh konten dari file lain --}}
    </main>

    @include('layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
