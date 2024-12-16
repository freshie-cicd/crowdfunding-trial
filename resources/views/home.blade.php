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
            <div class="card-header">All Packages :: Open</div>
            <div class="card-body">
                <div class="row">
                    @foreach ($packages as $package)
                        <div class="col-md-4">
                            <div class="card" style="">
                                <img src="{{ asset('storage/' . config('website-setting.dark_logo')) }}" alt=""
                                    style="padding:24px">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $package->name }}</h5>
                                    <p class="card-text">{{ $package->description }}</p>
                                    <p class="card-text">Package Code: {{ $package->code }}</p>
                                    <p class="card-text">Purchase Price: {{ $package->value }}</p>
                                    <p class="card-text">Total Capacity: {{ $package->capacity }}</p>
                                    <a href="{{ url('book/') }}/{{ $package->id }}/package"
                                        class="btn btn-primary">Request for Purchase</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection
