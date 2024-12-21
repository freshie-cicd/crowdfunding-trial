@extends('administrator.layouts.application')

@section('content')
    <div class="card  justify-content-center  ms-5">
        <div class="card-header mb-3">
            Edit Routing Numbers
        </div>
        <div class="container d-flex justify-content-center">
            @if (session('success'))
                <div class="alert alert-success block" style="width: 100%"> {{ session('success') }} </div>
            @endif
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('administrator.updateRoutingNums', $singleRouteInfo->id) }}">
                @csrf
                @method('PUT')
                {{-- @dd($singleRouteInfo->id) --}}
                <div class="row mb-3">

                    <label for="routing_number"
                        class="col-md-4 col-form-label text-md-end">{{ __('Routing Number') }}</label>
                    <div class="col-md-6">
                        <div>
                            <div class="flex">
                                <input id="routing_number" type="text" class="form-control" name="routing_number"
                                    value="{{ old('routing_number', $singleRouteInfo->routing_number) }}" required>
                            </div>
                        </div>

                        @if ($errors->has('routing_number'))
                            <span class="text-danger">{{ $errors->first('routing_number') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Bank Field -->
                <div class="row mb-3 " id="bank_div">
                    <label for="bank" class="col-md-4 col-form-label text-md-end">Bank</label>
                    <div class="col-md-6">

                        <input id="bank" type="text" class="form-control" name="bank" required
                            value="{{ old('bank', $singleRouteInfo->bank) }}">

                    </div>
                    @if ($errors->has('bank'))
                        <span class="text-danger">{{ $errors->first('bank') }}</span>
                    @endif
                </div>

                <!-- Branch Field -->
                <div class="row mb-3 " id="branch_div">
                    <label for="branch" class="col-md-4 col-form-label text-md-end">Branch</label>
                    <div class="col-md-6">
                        <input id="branch" type="text" class="form-control" name="branch" required
                            value="{{ old('branch', $singleRouteInfo->branch) }}">

                    </div>
                    @if ($errors->has('branch'))
                        <span class="text-danger">{{ $errors->first('branch') }}</span>
                    @endif
                </div>

                <!-- District Field -->
                <div class="row mb-3 " id="district_div">
                    <label for="district" class="col-md-4 col-form-label text-md-end">District</label>
                    <div class="col-md-6">
                        <input id="district" type="text" class="form-control" name="district" required
                            value="{{ old('district', $singleRouteInfo->district) }}">

                    </div>
                    @if ($errors->has('district'))
                        <span class="text-danger">{{ $errors->first('district') }}</span>
                    @endif
                </div>
                <div class="row mb-3">
                    <label for="Confirm" class="col-md-4 col-form-label text-md-end"></label>
                    <div class="col-md-6">
                        <button type="submit" name="" class="btn btn-md btn-success">
                            Update
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    </div>
@endsection
