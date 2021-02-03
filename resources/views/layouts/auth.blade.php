<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/961e992204.js" crossorigin="anonymous"></script>
    {{-- @include('layouts.extras.css') --}}

</head>

<body>

    <main class="login-page">
        @yield('content')
    </main>

    @include('layouts.extras.js')
</body>

</html>
