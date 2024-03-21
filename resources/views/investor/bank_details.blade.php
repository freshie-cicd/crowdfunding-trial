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

        @if (\Session::has('warning'))

        <div class="alert alert-success">

            {!! \Session::get('warning') !!}

        </div>

        @endif






        <form method="POST" action="{{ route('investor.bank.details.update') }}" enctype="multipart/form-data">

            @csrf







            <div class="row mb-3">

                <label for="bank_name" class="col-md-4 col-form-label text-md-end">{{ __('Bank Name') }}</label>




                <div class="col-md-6">

                    <select id="bank_name" type="text" class="form-select form-control @error('bank_name') is-invalid @enderror" name="bank_name" required autocomplete="bank_name">
                        <option>PLEASE SELECT</option>

                        @foreach($banks as $bank)
                        <option value="{{ $bank->id ?? '' }}" @if(!empty($data->bank_name)) @if($data->bank_name==$bank->id) selected @endif @endif>{{ $bank->bank_name }}</option>

                        @endforeach
                    </select>

                    @error('bank_name')

                    <span class="invalid-feedback" role="alert">

                        <strong>{{ $message }}</strong>

                    </span>

                    @enderror

                </div>

            </div>




            <div class="row mb-3">

                <label for="district" class="col-md-4 col-form-label text-md-end">{{ __('District') }}</label>



                <div class="col-md-6">

                    <select id="district" type="text" class="form-select form-control @error('district') is-invalid @enderror" name="district" required autocomplete="district">
                        <option>PLEASE SELECT</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->id ?? '' }}" @if(!empty($data->district)) @if($data->district==$district->id) selected @endif @endif>{{ $district->district ?? '' }}</option>

                        @endforeach
                    </select>

                    @error('district')

                    <span class="invalid-feedback" role="alert">

                        <strong>{{ $message }}</strong>

                    </span>

                    @enderror

                </div>

            </div>



            <div class="row mb-3">

                <label for="branch_name" class="col-md-4 col-form-label text-md-end">{{ __('Branch') }}</label>



                <div class="col-md-6">

                    <input id="branch_name" type="text" class="form-control @error('branch_name') is-invalid @enderror" name="branch_name" value="{{ $data->branch_name ?? '' }}" required autocomplete="branch_name">



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

                    <input id="account_name" type="text" class="form-control @error('name') is-invalid @enderror" name="account_name" value="{{ $data->account_name ?? '' }}" required autocomplete="account_name">



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

                    <input id="account_number" type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ $data->account_number ?? '' }}" required autocomplete="account_number">



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

                    <input id="routing_number" type="text" class="form-control @error('routing_number') is-invalid @enderror" name="routing_number" value="{{ $data->routing_number ?? '' }}" autocomplete="routing_number">



                    @if ($errors->has('routing_number'))

                    <span class="text-danger">{{ $errors->first('routing_number') }}</span>

                    @endif

                </div>

            </div>







            <div class="row mb-3">

                <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>



                <div class="col-md-6">

                    <input id="note" type="hidden" class="form-control @error('note') is-invalid @enderror" name="note" value="{{ $data->note ?? '' }}" autocomplete="note" maxlength="80">



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