@extends('administrator.layouts.application')

@section('content')

@if (\Session::has('success'))

<div class="alert alert-success">

    {!! \Session::get('success') !!}

</div>

@endif

@if (\Session::has('error'))

<div class="alert alert-danger">

    {!! \Session::get('error') !!}

</div>

@endif
@if ($errors->any())
<div class="alert alert-success">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (\Session::has('warning'))

<div class="alert alert-success">

    {!! \Session::get('warning') !!}

</div>

@endif

<div class="card">
    <div class="card-header">Payment Verification Form</div>
    <div class="card-body">
        <form method="POST" action="{{ route('administrator.booking.proof.store',$booking_id) }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <label for="package" class="col-md-4 col-form-label text-md-end">{{ __('Package') }}</label>
                <div class="col-md-6">
                    <input id="package" type="text" class="form-control @error('package') is-invalid @enderror" value="{{ $data->name }}" required autocomplete="package" disabled>
                    @error('package')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('Total Due') }}</label>
                <div class="col-md-6">
                    <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $data->value*$data->booking_quantity }}" required autocomplete="amount" disabled>
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>



            <div class="row mb-3">
                <label for="payment_method" class="col-md-4 col-form-label text-md-end">{{ __('Payment Method') }}</label>
                <div class="col-md-6 pt-1">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="Bank">
                        <label class="form-check-label" for="payment_method"> Bank Deposit </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="BEFTN" value="BEFTN">
                        <label class="form-check-label" for="BEFTN">BEFTN</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="NPSB" value="NPSB">
                        <label class="form-check-label" for="NPSB">NPSB</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="RTGS" value="RTGS">
                        <label class="form-check-label" for="RTGS">RTGS</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="OTHERS" value="OTHERS">
                        <label class="form-check-label" for="OTHERS">OTHERS</label>
                    </div>

                    @if ($errors->has('payment_method'))
                    <span class="text-danger">{{ $errors->first('payment_method') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="payment_date" class="col-md-4 col-form-label text-md-end">{{ __('When did you deposit?') }} <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="payment_date" type="datetime-local" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" value="" autocomplete="payment_method" autofocus>
                    @if ($errors->has('payment_date'))
                    <span class="text-danger">{{ $errors->first('payment_date') }}</span>
                    @endif
                </div>
            </div>



            <div class="row mb-3">
                <label for="verification_code" class="col-md-4 col-form-label text-md-end">{{ __('Verification Code') }}</label>
                <div class="col-md-6">
                    <input id="file" type="text" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" value="{{ $data->code }}" autocomplete="file" disabled>
                    @if ($errors->has('file'))
                    <span class="text-danger">{{ $errors->first('verification_code') }}</span>
                    @endif
                </div>
            </div>


            <div class="row mb-3">
                <label for="file" class="col-md-4 col-form-label text-md-end">{{ __('Verification Document') }} <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="" autocomplete="file">
                    @if ($errors->has('file'))
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="file2" class="col-md-4 col-form-label text-md-end">{{ __('Verification Document Two') }}</label>
                <div class="col-md-6">
                    <input id="file2" type="file" class="form-control @error('file2') is-invalid @enderror" name="file2" value="" autocomplete="file2">
                    @if ($errors->has('file2'))
                    <span class="text-danger">{{ $errors->first('file2') }}</span>
                    @endif
                </div>
            </div>


            <div class="row mb-3">
                <label for="file3" class="col-md-4 col-form-label text-md-end">{{ __('Verification Document Three') }}</label>
                <div class="col-md-6">
                    <input id="file3" type="file" class="form-control @error('file3') is-invalid @enderror" name="file3" value="" autocomplete="file3">
                    @if ($errors->has('file3'))
                    <span class="text-danger">{{ $errors->first('file3') }}</span>
                    @endif
                </div>
            </div>


            <div class="row mb-3">
                <label for="bank_name" class="col-md-4 col-form-label text-md-end">{{ __('Bank Name') }} <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="" autocomplete="bank_name" autofocus>
                    @if ($errors->has('bank_name'))
                    <span class="text-danger">{{ $errors->first('bank_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="branch" class="col-md-4 col-form-label text-md-end">{{ __('Branch') }} <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="branch" type="text" class="form-control @error('branch') is-invalid @enderror" name="branch" value="" autocomplete="branch" autofocus>
                    @if ($errors->has('branch'))
                    <span class="text-danger">{{ $errors->first('branch') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="depositors_name" class="col-md-4 col-form-label text-md-end">{{ __('Depositors Name') }} <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="depositors_name" type="text" class="form-control @error('depositors_name') is-invalid @enderror" name="depositors_name" value="" autocomplete="depositors_name" autofocus>
                    @if ($errors->has('depositors_name'))
                    <span class="text-danger">{{ $errors->first('depositors_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="depositors_mobile_number" class="col-md-4 col-form-label text-md-end">{{ __('Depositors Mobile Number') }} <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="depositors_mobile_number" type="text" class="form-control @error('depositors_mobile_number') is-invalid @enderror" name="depositors_mobile_number" value="" autocomplete="depositors_mobile_number" autofocus>

                    @if ($errors->has('depositors_mobile_number'))
                    <span class="text-danger">{{ $errors->first('depositors_mobile_number') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="deposit_reference" class="col-md-4 col-form-label text-md-end">{{ __('Deposit Reference') }} <span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="deposit_reference" type="text" class="form-control @error('deposit_reference') is-invalid @enderror" name="deposit_reference" value="" autocomplete="deposit_reference" autofocus>
                    @if ($errors->has('deposit_reference'))
                    <span class="text-danger">{{ $errors->first('deposit_reference') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>
                <div class="col-md-6">
                    <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="" autocomplete="note" autofocus>

                    @if ($errors->has('note'))
                    <span class="text-danger">{{ $errors->first('note') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="Confirm" class="col-md-4 col-form-label text-md-end"></label>
                <div class="col-md-6">
                    <button type="submit" name="" class="btn btn-md btn-success">Confirm Payment</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection