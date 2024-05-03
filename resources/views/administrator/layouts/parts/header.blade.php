<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

  <meta name="description" content="Responsive layout with advanced sidebar menu built with SCSS and vanilla Javascript" />

  <title>{{ config('app.name', 'Laravel') }}</title>



  <!-- CSRF Token -->

  <meta name="csrf-token" content="{{ csrf_token() }}">



  <link href="https://www.freshie.farm/wp-content/uploads/2021/04/cropped-fre-270x270.png" rel="icon">



  <!-- Below we include the jQuery Library -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>







  <!-- Fonts -->

  <link rel="dns-prefetch" href="//fonts.gstatic.com">

  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">



  <!-- Styles -->

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="{{ url('/css/main.css') }}" />

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
  <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body>

  <div class="layout has-sidebar fixed-sidebar fixed-header">

    @include('administrator.layouts.parts.sidenav')

    <div id="overlay" class="overlay"></div>

    <div class="layout">

      <header class="header">

        <!--Desktop Collapsable Button-->

        <a id="btn-collapse" href="#"><i class="fa-solid fa-bars" style="height:1.5em"></i></a>

        <!--Mobile Collapsable Button-->

        <a id="btn-toggle" href="#" class="sidebar-toggler break-point-lg"><i class="fa-solid fa-bars" style="height:1.5em"></i></a>

      </header>