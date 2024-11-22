@extends('layouts.dashboard')

@section('content')




<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        @if (\Session::has('error'))
        <div class="alert alert-danger">
            {!! \Session::get('error') !!}
        </div>
        @endif






        <form method="POST" action="{{ route('investor.bank.details.update') }}" enctype="multipart/form-data" x-data="{ accountNumber: '{{ $data->account_number ?? '' }}', 
        routingNumber: '{{ $data->routing_number ?? '' }}',
        bank: '{{ $data->bank_name ?? '' }}',
        accountNumberIsValid() { return ['62','63','64'].includes(this.bank) ? true: this.accountNumber.length >= 13 ; },
        routingNumberIsValid() {  return ['62','63','64'].includes(this.bank) ? true: this.routingNumber.length >= 9;  },
        }">

            @csrf







            <div class=" row mb-3">

                <label for="bank_name" class="col-md-4 col-form-label text-md-end">{{ __('Bank Name') }}</label>




                <div class=" col-md-6">

                    <select id="bank_name" type="text" class="form-select form-control @error('bank_name') is-invalid @enderror" name="bank_name" required autocomplete="bank_name" x-model="bank">
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
                    <div>
                        <input id="account_number" type="text" class="form-control" :class="{ 'is-invalid': !accountNumberIsValid() }" name="account_number" x-model="accountNumber" autocomplete="account_number" required>
                        <span class="invalid-feedback" x-show="!accountNumberIsValid()" style="display: none;">
                            Account number must be at least 13 characters.
                        </span>
                    </div>

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
                    <div>
                        <input id="routing_number" type="text" class="form-control" :class="{ 'is-invalid': !routingNumberIsValid() }" name="routing_number" x-model="routingNumber" autocomplete="routing_number" required>
                        <span class="invalid-feedback" x-show="!routingNumberIsValid()" style="display: none;">
                            Routing number must be at least 9 characters.
                        </span>
                    </div>

                    @if ($errors->has('routing_number'))
                    <span class="text-danger">{{ $errors->first('routing_number') }}</span>
                    @endif
                </div>
            </div>
            @if (isset($data->is_protected) && $data->is_protected == true)
            <div class="row mb-3 mt-4">
                <p class="text-info text-center">You can't modify your bank details after updating them. For assistance, please contact {{ env('APP_NAME') }} support.</p>
            </div>
            @else
            <div class="row mb-3">
                <label for="Confirm" class="col-md-4 col-form-label text-md-end"></label>
                <div class="col-md-6">
                    <button type="submit" name="" class="btn btn-md btn-success"
                        :disabled="!accountNumberIsValid() || !routingNumberIsValid()">Update</button>
                </div>
            </div>
            @endif





    </div>

    </form>

</div>

</div>

@endsection