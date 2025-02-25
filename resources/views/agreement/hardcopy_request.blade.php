@extends('layouts.dashboard')

@section('content')



<div class="card">
    <div class="card-header">Request Hard Copy Agreement Paper</div>
    <div class="card-body">
        <form method="POST" action="{{ route('agreement.hard_copy.store') }}">
            @csrf

            <h4 class="text-success">স্ট্যাম্পে চুক্তিপত্র পেতে ফর্মটি পুরন করুন। কিছু শর্ত সমুহ - </h4>

            <ul>
                <li>ষ্ট্যাম্পের খরচ বাবদ ৪৫০ টাকা চার্জ হবে, যা আপনার মুনাফা থেকে কেটে নেওয়া হবে।</li>
                <li>চুক্তিপত্র শুধুমাত্র সুন্দরবন কুরিয়ারে পাঠানো হয়।</li>
                <li>আপনার নিকটস্থ সুন্দরবন কুরিয়ারের অফিস থেকে সংগ্রহ করতে হবে।</li>
            </ul>

            <hr>

            <div class="row mb-3">
                <label for="booking_code" class="col-md-4 col-form-label text-md-end">{{ __('Booking Code') }}</label>

                <div class="col-md-6">
                    <input id="booking_code" type="text" class="form-control @error('booking_code') is-invalid @enderror " name="booking_code" value="{{ $data[0]->code ?? '' }}" autocomplete="booking_code" disabled>
                    @error('booking_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="total_booking_value" class="col-md-4 col-form-label text-md-end">{{ __('Quantity') }}</label>
                <div class="col-md-6">
                    <input id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror " name="quantity" value="{{  $data[0]->booking_quantity ?? '' }}" autocomplete="quantity" disabled>
                    @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="total_booking_value" class="col-md-4 col-form-label text-md-end">{{ __('Total Amount ') }}</label>
                <div class="col-md-6">
                    <input id="total_booking_value" type="text" class="form-control @error('total_booking_value') is-invalid @enderror " name="total_booking_value" value="{{  $data[0]->value *  $data[0]->booking_quantity ?? '' }}" autocomplete="total_booking_value" disabled>

                    @error('total_booking_value')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="courier" class="col-md-4 col-form-label text-md-end">{{ __('Courier Service') }}</label>
                <div class="col-md-6">
                    <select id="courier" type="text" class="form-select form-control @error('courier') is-invalid @enderror " name="courier" value="{{ auth()->user()->courier ?? '' }}" autocomplete="courier" required>
                        <option value="Sundarban Courier Service (Pvt.) Ltd.">Sundarban Courier Service (Pvt.) Ltd.</option>
                    </select>
                    @error('courier')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="courier_branch" class="col-md-4 col-form-label text-md-end">{{ __('Nearest Courier Service Branch') }}</label>
                <div class="col-md-6">
                    <input id="courier_branch" type="text" class="form-control @error('courier_branch') is-invalid @enderror " name="courier_branch" value="" autocomplete="courier_branch">
                    @error('courier_branch')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Receiver Phone Number') }}</label>
                <div class="col-md-6">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror " name="phone" value="" autocomplete="phone">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Delivery Address') }}</label>
                <div class="col-md-6">
                    <textarea id="address" type="text" class="form-control @error('address') is-invalid @enderror " name="address" value="{{ auth()->user()->address ?? '' }}" autocomplete="address" required>
                    </textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <input type="hidden" name="booking_code_x" value=" {{ $data[0]->code }}">

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Send Request') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection