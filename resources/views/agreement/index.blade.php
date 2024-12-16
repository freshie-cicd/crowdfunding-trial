@extends('layouts.dashboard')

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success">

            {!! \Session::get('success') !!}

        </div>
    @endif



    @if (\Session::has('warning'))
        <div class="alert alert-warning">

            {!! \Session::get('warning') !!}

        </div>
        {{ asset('storage/' . config('website-setting.dark_logo')) }}
    @endif

    <div class="card">

        <div class="card-header">My Approved Packages</div>





        <div class="card-body">



            <div class="row">

                @foreach ($bookings as $booking)
                    <div class="col-md-4">

                        <div class="card mb-2 mt-2" style="">

                            <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshie-farm.png" alt=""
                                style="padding:24px">

                            <div class="card-body">

                                <h5 class="card-title">Booking Code: <b class="text-danger"> {{ $booking->code }}</b></h5>

                                <p class="card-text">{{ $booking->description }}</p>

                                <p class="card-text text-uppercase">Package Code: <b> {{ $booking->pcode }}</b></p>

                                <p class="card-text text-uppercase">Purchase Price:<b>
                                        {{ $booking->value * $booking->booking_quantity }}</b></p>

                                <p class="card-text text-uppercase">Status:<b> {{ $booking->status }}</b></p>

                                <!-- Button trigger modal -->





                                <div class="d-grid gap-2">

                                    <a href="{{ url('profile/edit') }}" type="button"
                                        class="btn btn-success @if ($is_profile_complete) disabled @endif"> Complete
                                        Profile</button>

                                        <a href="{{ url('agreement') }}/{{ $booking->id }}/download/"
                                            class="btn btn-primary @if (!$is_profile_complete) disabled @endif">Download
                                            Instant Agreement Paper</a>



                                        <a href="{{ url('agreement/hard-copy/request') }}/{{ $booking->id }}/"
                                            class="btn btn-warning @if (!$is_profile_complete) disabled @endif">Request
                                            Hard Copy <br>Agreement Paper</a>

                                </div>



                            </div>

                        </div>

                    </div>
                @endforeach





            </div>





        </div>

    </div>
@endsection
