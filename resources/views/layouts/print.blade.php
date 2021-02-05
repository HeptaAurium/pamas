<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <main class="pb-4 clear-left bg-default min-vh-100 mt-5">
        @yield('content')
    </main>
    </div>
    @yield('script')

    @include('layouts.extras.js')
</body>

</html>
