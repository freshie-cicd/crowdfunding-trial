@extends('layouts.dashboard')
@section('content')


<div class="card">
    
    <div class="card-header">Update your bank details</div>

    <div class="card-body">

        @if (\Session::has('success'))
        <div class="alert alert-success">
                {!! \Session::get('success') !!}
        </div>
      @endif



<form method="POST" action="{{ route('investor.bank.details.update') }}" enctype="multipart/form-data">
    @csrf



    <div class="row mb-3">
        <label for="bank_name" class="col-md-4 col-form-label text-md-end">{{ __('Bank Name') }}</label>

        <div class="col-md-6">
            <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ $data[0]->bank_name ?? '' }}" required autocomplete="bank_name">

            @error('bank_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>



    <div class="row mb-3">
        <label for="branch_name" class="col-md-4 col-form-label text-md-end">{{ __('Branch') }}</label>

        <div class="col-md-6">
            <input id="branch_name" type="text" class="form-control @error('branch_name') is-invalid @enderror" name="branch_name" value="{{ $data[0]->branch_name ?? '' }}" required autocomplete="branch_name">

            @error('branch_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>



    <div class="row mb-3">
        <label for="account_name" class="col-md-4 col-form-label text-md-end">{{ __('Account Name') }}</label>

        <div class="col-md-6">
            <input id="account_name" type="text" class="form-control @error('name') is-invalid @enderror" name="account_name" value="{{ $data[0]->account_name ?? '' }}" required autocomplete="account_name">

            @error('account_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="account_number" class="col-md-4 col-form-label text-md-end">{{ __('Account Number') }}</label>

        <div class="col-md-6">
            <input id="account_number" type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ $data[0]->account_number ?? '' }}" required autocomplete="account_number">

            @error('account_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>


    
    <div class="row mb-3">
        <label for="routing_number" class="col-md-4 col-form-label text-md-end">{{ __('Routing Number') }}</label>

        <div class="col-md-6">
            <input id="routing_number" type="text" class="form-control @error('routing_number') is-invalid @enderror" name="routing_number" value="{{ $data[0]->routing_number ?? '' }}" autocomplete="routing_number" >

            @if ($errors->has('routing_number'))
                <span class="text-danger">{{ $errors->first('routing_number') }}</span>
            @endif
        </div>
    </div>



    <div class="row mb-3">
        <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

        <div class="col-md-6">
            <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="" autocomplete="note" >

            @if ($errors->has('note'))
                <span class="text-danger">{{ $errors->first('note') }}</span>
            @endif
        </div>
    </div>



    <div class="row mb-3">
        <label for="Confirm" class="col-md-4 col-form-label text-md-end"></label>

        <div class="col-md-6">
          <button type="submit" name="" class="btn btn-md btn-success">Update</button>

        </div>
    </div>


    </div>
</form>
</div>
</div>
@endsection