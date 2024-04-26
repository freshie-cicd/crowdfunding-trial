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
    <div class="card-header">Withdrawal Request</div>

    <div class="card-body">
      <div class="row">



        <form method="POST" action="{{ route('withdrawal.request.store') }}">
          @csrf
          <hr>
          Investment Information
          <hr>
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
              <input id="package" type="text" class="form-control @error('package') is-invalid @enderror" name="package" value="{{ $data->package_name ?? '' }}({{ $data->booking_code }})" required autocomplete="package" disabled>

              @error('package')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>


          <div class="row mb-3">
            <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('Total Investment') }}</label>

            <div class="col-md-6">
              <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $data->package_value * $data->booking_quantity }}" required disabled>

              @error('amount')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label for="total_profit" class="col-md-4 col-form-label text-md-end">{{ __('Total Profit to Withdraw') }}</label>

            <div class="col-md-6">
              <input id="total_profit" type="text" class="form-control @error('total_profit') is-invalid @enderror" name="total_profit" value="{{ $data->return_amount * $data->booking_quantity }}" disabled>
              <input type="hidden" name="profit" value="{{ $data->return_amount * $data->booking_quantity }}">
              @error('total_profit')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label for="note" class="col-md-4 col-form-label text-md-end text-success">{{ __('Decide Reinvest in '. $migrationPackage->name) }}</label>
            <div class="col-md-6">
              <div class="input-group mb-3">
                <select id="reinvest_quantity" type="text" class="form-select form-control" placeholder="" name="reinvest_quantity">
                  @for($l = 0; $l <= $data->booking_quantity; $l++)
                    <option value="{{ $l }}" @if($l==$data->booking_quantity) selected @endif>{{ $l }}</option>
                    @endfor
                </select>
                <span class="input-group-text">Tk. <b id="total_invest"> {{ $data->booking_quantity * $data->package_value }}</b></span>
              </div>
              <span>
                <strong>
                  {{ $migrationPackage->name }} Starting Date: {{ date('d M Y', strtotime($migrationPackage->start_date)) }} <br>
                  Any investment Before this date will not be considered for profit calculation.
                </strong>
              </span>
              @error('reinvest_quantity')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <label for="withdraw_quantity" class="col-md-4 col-form-label text-md-end text-danger">{{ __('Withdrawal Amount') }}</label>
            <div class="col-md-6">
              <div class="input-group mb-3">
                <input type="text" class="form-control " value="0" id="withdraw_quantity" name="withdraw_quantity" disabled>
                <span class="input-group-text">Tk. <b id="total_withdraw"> {{ __('0') }}</b></span>
              </div>

              @error('note')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>


          <hr>
          <h5>Bank Information Check</h5>
          <hr>

          <div class="offset-md-4 pb-4">
            <p style="line-height: 10px;">Bank Name: <b>{{ $bank->bank_name ?? '' }}</b></p>
            <p style="line-height: 10px">Branch Name: <b>{{ $bank->branch_name ?? '' }}</b></p>
            <p style="line-height: 10px">Account Name: <b>{{ $bank->account_name ?? '' }}</b></p>
            <p style="line-height: 10px">Account Number: <b>{{ $bank->account_number ?? '' }}</b></p>
            <p style="line-height: 10px">Routing Number: <b>{{ $bank->routing_number ?? '' }}</b></p>
          </div>


          <div class="row mb-3">
            <label for="bank" class="col-md-4 col-form-label text-md-end">{{ __('Is your bank details are correct?') }}</label>

            <div class="col-md-6">
              <select id="bank" type="text" class="form-select form-control @error('bank') is-invalid @enderror" name="bank" value="">
                <option value="1">YES, Bank details are coreect.</option>
                <option value="0">NO, I want to change the bank details.</option>
              </select>
              @error('bank')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>



          <div class="row mb-3">
            <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

            <div class="col-md-6">
              <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="" autocomplete="package">

              @error('note')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>

          <input type="hidden" name="package_id" value="{{ $data->package_id }}">
          <input type="hidden" name="booking_code" value="{{ $data->booking_code }}">
          <input type="hidden" id="package_price" name="package_price" value="{{ $data->package_value }}">
          <input type="hidden" id="booking_quantity" name="booking_quantity" value="{{ $data->booking_quantity }}">
          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


          <div class="row mb-3">
            <label for="note" class="col-md-4 col-form-label text-md-end"></label>

            <div class="col-md-6">
              <button type="submit" name="" class="btn btn-md btn-success">Confirm Request</button>

            </div>
          </div>

      </div>
      </form>



    </div>
  </div>
</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
  $(document).ready(function() {
    $('#reinvest_quantity').on('change', function() {
      $('#total_invest').html(
        $('select[name=reinvest_quantity]').val() * $('#package_price').val()
      );

      $('#withdraw_quantity').val(
        $('#booking_quantity').val() - $('select[name=reinvest_quantity]').val()
      );

      $('#total_withdraw').html(
        $('#withdraw_quantity').val() * $('#package_price').val()
      );


    });
  });
</script>

@endsection