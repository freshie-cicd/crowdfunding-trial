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
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card mb-2 mt-2">

        <div class="card-header">
            <h3>My Packages</h3>
        </div>

        <div class="card-body">
            <div class="">
                <div class="row">
                    @foreach ($bookings as $booking)
                        @include('components.user.booking-card', ['booking' => $booking])
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-5 mb-2">
        <div class="card-header">
            <h3>
                Open Packages For Investment
            </h3>
        </div>
        <div class="card-body">
            <div class="">
                <div class="row">
                    @foreach ($packages as $package)
                        <div class="col-md-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . config('website-setting.dark_logo')) }}" alt=""
                                    style="padding:24px">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $package->name }}</h5>
                                    <p class="card-text">{{ $package->description }}</p>
                                    <p class="card-text">Package Code: {{ $package->code }}</p>
                                    <p class="card-text">Purchase Price: {{ $package->value }}</p>
                                    <p class="card-text">Total Capacity: {{ $package->capacity }}</p>
                                    {{-- if user is blocked, user can not book a new package anymore --}}
                                    @if ($status !== 'blocked')
                                    <a href="{{ url('book/') }}/{{ $package->id }}/package"
                                        class="btn btn-primary @if ($checkPendingBooking > 0) disabled @endif">Request
                                        for Purchase</a>

                                        {{-- if user has a booking pending, user can not book another one unless last one is done --}}
                                        @if ($checkPendingBooking > 0)
                                            <p class="text-danger">You have a pending booking. Please wait for approval.</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const disabled_btn = document.getElementById("disabled_btn")
        disabled_btn.addEventListener('click' , function(){
            Swal.fire({
                    icon: 'warning',
                    title: 'we are unable to allocate new booking for  now',
                    confirmButtonText: 'OK'
                });
        })
    </script>
@endsection
