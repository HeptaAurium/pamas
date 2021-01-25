<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('layouts.extras.css')

</head>

<body>
    @include('layouts.navs.navbars.nav')
    @include('flash::message')
    <div class="flash">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif
    </div>
    <div id="app">
        @include('layouts.navs.navbars.sidebar')
        <main class="pb-4 clear-left bg-default min-vh-100 mt-5">
            @yield('content')
        </main>
    </div>
    @include('layouts.extras.js')
</body>

</html>
