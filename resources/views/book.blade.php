@extends('layouts.dashboard')
@section('content')
<div class="">


    <div class="card">
        <div class="card-header">Book this opportunity</div>

        <div class="card-body">

            <div class="row">
                @foreach($data as $package)
                <div class="col-md-4">
                    <div class="card" style="">
                        <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshie-farm.png" alt="" style="padding:24px">
                        <div class="card-body">

                            <h5 class="card-title">{{ $package->name }}</h5>
                            <p class="card-text">{{ $package->description }}</p>
                            <p class="card-text">Package Code: {{ $package->code }}</p>
                            <p class="card-text">Purchase Price: {{ $package->value }}</p>
                            <p class="card-text">Total Capacity: {{ $package->capacity }}</p>

                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-md-8 mt-5">

                    <form method="POST" action="{{ route('book.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required autocomplete="name" disabled>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="package" class="col-md-4 col-form-label text-md-end">{{ __('Package') }}</label>

                            <div class="col-md-6">
                                <input id="package" type="text" class="form-control @error('package') is-invalid @enderror" name="package" value="{{ $data[0]->name }}({{ $data[0]->code }})" required autocomplete="package" disabled>

                                @error('package')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="booking_quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantity') }}</label>

                            <div class="col-md-6">
                                <select id="booking_quantity" type="text" class="form-control form-select @error('booking_quantity') is-invalid @enderror" name="booking_quantity" required autocomplete="booking_quantity">
                                    @for($x=1; $x<=100; $x++) <option value="{{ $x }}">{{ $x }}</option>
                                        @endfor
                                </select>
                                @error('booking_quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('Total Due') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $data[0]->value }}" required autocomplete="amount" disabled>

                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

                            <div class="col-md-6">
                                <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="" autocomplete="package" autofocus>

                                @error('note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="package_id" value="{{ $data[0]->id }}">
                        <input type="hidden" name="package_price" value="{{ $data[0]->value }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


                        <div class="row mb-3">
                            <label for="note" class="col-md-4 col-form-label text-md-end"></label>

                            <div class="col-md-6">
                                <button type="submit" name="" class="btn btn-md btn-success">Confirm Booking</button>

                            </div>
                        </div>

                </div>
                </form>


            </div>

        </div>
    </div>

</div>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // this will run on every select value change. if you want it to only run for those specific selects, add the same class in all of them and change the selector to $('select.yourclass')
        $('select').on('change', function() {

            $('#amount').val(

                $('select[name=booking_quantity]').val() * $('input[name=package_price]').val()

            );

        });

    });
</script>

@endsection