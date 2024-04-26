@extends('layouts.dashboard')

@section('content')

<div class="">

  @if (\Session::has('success'))
  <div class="alert alert-success">
    {!! \Session::get('success') !!}
  </div>
  @endif

  @if (\Session::has('warning'))
  <div class="alert alert-warning">
    {!! \Session::get('warning') !!}
  </div>
  @endif



  <div class="card">
    <div class="card-header">My Mature Investments</div>
    <div class="card-body">
      <div class="row">

        @foreach($bookings as $booking)

        @include('components.user.booking-card', ['booking' => $booking])

        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection