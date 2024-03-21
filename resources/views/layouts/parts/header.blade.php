<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>{{ config('app.name', 'Laravel') }}</title>



    <link href="https://www.freshie.farm/wp-content/uploads/2021/04/cropped-fre-270x270.png" rel="icon">

    <link rel="apple-touch-icon" sizes="57x57" href="https://cloudhousebd.com/assets/icons/apple-icon-57x57.png">

    <link rel="apple-touch-icon" sizes="60x60" href="https://cloudhousebd.com/assets/icons/apple-icon-60x60.png">

    <link rel="apple-touch-icon" sizes="72x72" href="https://cloudhousebd.com/assets/icons/apple-icon-72x72.png">

    <link rel="apple-touch-icon" sizes="76x76" href="https://cloudhousebd.com/assets/icons/apple-icon-76x76.png">

    <link rel="apple-touch-icon" sizes="114x114" href="https://cloudhousebd.com/assets/icons/apple-icon-114x114.png">

    <link rel="apple-touch-icon" sizes="120x120" href="https://cloudhousebd.com/assets/icons/apple-icon-120x120.png">

    <link rel="apple-touch-icon" sizes="144x144" href="https://cloudhousebd.com/assets/icons/apple-icon-144x144.png">

    <link rel="apple-touch-icon" sizes="152x152" href="https://cloudhousebd.com/assets/icons/apple-icon-152x152.png">

    <link rel="apple-touch-icon" sizes="180x180" href="https://cloudhousebd.com/assets/icons/apple-icon-180x180.png">

    <link rel="icon" type="image/png" sizes="192x192" href="https://cloudhousebd.com/assets/icons/android-icon-192x192.png">

    <link rel="icon" type="image/png" sizes="32x32" href="https://cloudhousebd.com/assets/icons/favicon-32x32.png">

    <link rel="icon" type="image/png" sizes="96x96" href="https://cloudhousebd.com/assets/icons/favicon-96x96.png">

    <link rel="icon" type="image/png" sizes="16x16" href="https://cloudhousebd.com/assets/icons/favicon-16x16.png">

    <link rel="manifest" href="https://cloudhousebd.com/assets/icons/manifest.json">



    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>



    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">



    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">





</head>

<body>

    <div id="app">

        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">

            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">

                    <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshi_light.png" width="100px" />

                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">

                    <span class="navbar-toggler-icon"></span>

                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav me-auto">



                    </ul>



                    <!-- Right Side Of Navbar -->

                    <ul class="navbar-nav ms-auto">

                        <!-- Authentication Links -->

                        @guest

                        @if (Route::has('login'))

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>

                        </li>

                        @endif



                        @if (Route::has('register'))

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>

                        </li>

                        @endif

                        @else

                        <li class="nav-item dropdown">

                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                {{ Auth::user()->name }}

                            </a>



                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();

                                                     document.getElementById('logout-form').submit();">

                                    {{ __('Logout') }}

                                </a>



                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                                    @csrf

                                </form>

                            </div>

                        </li>

                        @endguest

                    </ul>

                </div>

            </div>

        </nav>