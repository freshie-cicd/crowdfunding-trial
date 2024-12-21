@extends('layouts.dashboard')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="card">
    <div class="card-header">
        @if ($data)
        Update
        @else
        add
        @endif your bank details
    </div>
    <div class="card-body">

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

        <form method="POST" action="{{ route('investor.bank.details.update') }}" enctype="multipart/form-data"
            x-data="{
                    accountNumber: '{{ $data->account_number ?? '' }}',
                    routingNumber: '{{ $data->routing_number ?? '' }}',
                    accountNumberIsValid() { return ['62', '63', '64'].includes(this.bank) ? true : this.accountNumber.length >= 13; },
                    routingNumberIsValid() { return ['62', '63', '64'].includes(this.bank) ? true : this.routingNumber.length >= 9; },
                }">

            @csrf

            <div class="row mb-3">
                <label for="routing_number"
                    class="col-md-4 col-form-label text-md-end">{{ __('Routing Number') }}</label>

                <div class="col-md-6">
                    <div>
                        <div class="flex">
                            @if (isset($data->is_protected) && $data->is_protected == true)
                            <input id="routing_number" type="text" class="form-control" name="routing_number"
                                x-model="routingNumber" disabled required>
                            @else
                            <input id="routing_number" type="text" class="form-control"
                                :class="{ 'is-invalid': !routingNumberIsValid() }" name="routing_number"
                                x-model="routingNumber" required>
                            <button id="check" class=" ms-2 bg-blue-500 px-3 py-2 rounded text-white">Check</button>
                            @endif
                        </div>

                        <span class="invalid-feedback" x-show="!routingNumberIsValid()" style="display: none;">
                            Routing number must be at least 9 characters.
                        </span>
                    </div>

                    @if ($errors->has('routing_number'))
                    <span class="text-danger">{{ $errors->first('routing_number') }}</span>
                    @endif
                </div>
            </div>

            <!-- Bank Field -->
            <div class="row mb-3 {{ @!$data->bank_name? 'hidden':'' }}" id="bank_div">
                <label for="bank" class="col-md-4 col-form-label text-md-end">Bank</label>
                <div class="col-md-6">
                    <input id="bank" type="text" class="form-control" name="bank" disabled required value="{{ old('bank', @$data->bank_name) }}">
                </div>
            </div>

            <!-- Branch Field -->
            <div class="row mb-3 {{ @!@$data->branch_name? 'hidden':'' }} " id="branch_div">
                <label for="branch" class="col-md-4 col-form-label text-md-end">Branch</label>
                <div class="col-md-6">
                    <input id="branch" type="text" class="form-control" name="branch" disabled required value="{{ old('branch',@$data->branch_name) }}">
                </div>
            </div>

            <!-- District Field -->
            <div class="row mb-3 {{ @!$data->district? 'hidden':'' }} " id="district_div">
                <label for="district" class="col-md-4 col-form-label text-md-end">District</label>
                <div class="col-md-6">
                    <input id="district" type="text" class="form-control" name="district" disabled required value="{{ old('district',@$data->district) }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="account_number"
                    class="col-md-4 col-form-label text-md-end">{{ __('Account Number') }}</label>

                <div class="col-md-6">
                    <div>
                        <input id="account_number" type="text" class="form-control"
                            :class="{ 'is-invalid': !accountNumberIsValid() }" name="account_number"
                            x-model="accountNumber" autocomplete="account_number" required>
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
                <label for="account_name" class="col-md-4 col-form-label text-md-end">{{ __('Account Name') }}</label>
                <div class="col-md-6">
                    <input id="account_name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="account_name" value="{{ $data->account_name ?? '' }}" required
                        autocomplete="account_name">
                    @error('account_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            @if (!isset($data->is_protected) || $data->is_protected == false)
            <div class="row mb-3">
                <label for="file" class="col-md-4 col-form-label text-md-end">{{ __('CheckBook Photo') }} <span
                        class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror"
                        name="file" value="" autocomplete="file" />
                </div>
            </div>
            @endif

            @if(!empty($data->checkbook_url))
            <div class="row mb-3">
                <label for="cheque_image" class="col-md-4 col-form-label text-md-end">{{ __('Cheque Image') }} <span
                        class="text-danger">*</span></label>
                <div class="col-md-6">
                    <img src="{{ asset('storage/' .$data->checkbook_url) }}" alt="Checkbook Image">
                    @if ($errors->has('file'))
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                    @endif
                </div>
            </div>
            @endif
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let RoutingNumbers = JSON.parse(`@json($routInfo->pluck('routing_number'))`);
    const routingAllData = JSON.parse(`@json($routInfo->keyBy('routing_number'))`);
    const appName = "{{ config('app.name') }}";
    const facebookPageUrl = "{{ env('FACEBOOK_PAGE_URL') }}";
    document.addEventListener('DOMContentLoaded', function() {

        const routingNumberInput = document.getElementById('routing_number');
        const bankInput = document.getElementById('bank');
        const districtInput = document.getElementById('district');
        const branchInput = document.getElementById('branch');
        const check = document.getElementById('check');
        check
        // getting divs

        const bank_div = document.getElementById('bank_div');
        const branch_div = document.getElementById('branch_div');
        const district_div = document.getElementById('district_div');

        `@if(!isset($data-> is_protected) || $data-> is_protected == false)`
        check.addEventListener('click', function(e) {
            e.preventDefault()
            const routingNumber = routingNumberInput.value.trim();

            if (RoutingNumbers.includes(routingNumber)) {
                let details = routingAllData[routingNumber]

                if (details) {
                    bank_div.classList.remove("hidden")
                    district_div.classList.remove("hidden")
                    branch_div.classList.remove("hidden")
                    bankInput.value = details.bank
                    districtInput.value = details.district
                    branchInput.value = details.branch
                }
            } else {
                // SweetAlert to show alert if routing number is wrong

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Routing Number',
                    html: ` Please contact <b>${appName}'s</b> <a href="${facebookPageUrl}" target="_blank">Facebook Page</a> for support.`,
                    confirmButtonText: 'OK'
                });
            }
        })
        `@endif`
    });
</script>
@endsection