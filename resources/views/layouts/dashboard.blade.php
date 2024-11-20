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

    <div class="container pt-4 pb-4">
      <h1 class="pb-2 mt-4">Welcome <b> {{ auth()->user()->name }} </b></h1>
      @if(!empty($total_investment))
      <h3 class="pb-4 mb-4">Total Investment: <b>{{ $total_investment ?? '' }}</b></h3>
      @endif

      <div class="row mb-4 pb-4 mt-4">
        <div class="col-md-3">
          <div class="card" style="">
            <div class="card-header"> <b> Menu </b></div>
            <ul class="list-group list-group-flush">
              <a href="{{ url('/dashboard') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-home"></i> Home</a>
              <a href="{{ url('/profile') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-bars-staggered"></i> My Profile</a>
              <a href="{{ url('/profile/edit') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-id-card"></i> Edit Profile</a>
              <a href="{{ url('/investor/bank') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-leaf"></i> Add Bank Information</a>
              <a href="{{ url('/mature-batches') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-cube"></i> My Mature Packages</a>
              <a href="{{ url('/profile/change_password') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-key"></i> Change Password</a>
              <a href="{{ url('/packages') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-bars-staggered"></i> Open Packages</a>
              <a class="btn btn-secondary dropdown-toggle list-group-item list-group-item-action" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="text-align: start;background: transparent; color: black;border-bottom:1px solid #ddd">
                <i class="fa-solid fa-list"></i> My Packages
              </a>

              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ url('bookings/approved') }}">Approved Packages</a></li>
                <li><a class="dropdown-item" href="{{ url('bookings/pending_approval') }}">Pending for Approval</a></li>
                <li><a class="dropdown-item" href="{{ url('bookings/pending') }}">Pending for Payment</a></li>
              </ul>
              <a href="{{ url('/agreements') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-bars-staggered"></i> My Agreement Papers</a>
            </ul>
          </div>
        </div>

        <div class="col-md-9">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
  @include('layouts.parts.footer')

</body>

</html>