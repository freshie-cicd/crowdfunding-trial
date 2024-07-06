<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- fav icon -->
    <link href="https://www.freshie.farm/wp-content/uploads/2021/04/cropped-fre-270x270.png" rel="icon">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        @include('layouts.parts.header')

        <main class=" container py-4">
            @yield('content')
        </main>
    </div>

    @include('layouts.parts.footer')
</body>

</html>