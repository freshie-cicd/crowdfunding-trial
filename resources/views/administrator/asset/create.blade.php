@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add New Asset/Livestock') }}</div>

                <div class="card-body">

                  @if (\Session::has('success'))
                      <div class="alert alert-success">
                              {!! \Session::get('success') !!}
                      </div>
                  @endif


                  <form method="POST" action="{{ route('asset.store') }}" enctype="multipart/form-data">
                      @csrf


                      <div class="row mb-3">
                          <label for="package_id" class="col-md-4 col-form-label text-md-end">{{ __('Package Name') }}</label>

                          <div class="col-md-4">
                              <select id="package_id" type="text" class="form-control @error('package_id') is-invalid @enderror" name="package_id" value="{{ old('package_id') }}" required autocomplete="package_id" >
                                <option value="">PLEASE SELECT</option>
                                @foreach($packages as $package)
                                  <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                              </select>
                              @error('package_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Asset Name') }}</label>

                          <div class="col-md-4">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >

                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                          <div class="col-md-4">
                              <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description">

                              @error('description')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="purchase_price" class="col-md-4 col-form-label text-md-end">{{ __('Purchase Price') }}</label>

                          <div class="col-md-4">
                              <input id="purchase_price" type="text" class="form-control @error('purchase_price') is-invalid @enderror" name="purchase_price" value="{{ old('purchase_price') }}" required autocomplete="purchase_price" >

                              @error('purchase_price')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for="color" class="col-md-4 col-form-label text-md-end">{{ __('Color') }}</label>

                          <div class="col-md-4">
                              <input id="color" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}" required autocomplete="color" >

                              @error('color')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Location') }}</label>

                          <div class="col-md-4">
                              <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location" >

                              @error('location')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>



                      <div class="row mb-3">
                          <label for="asset_code" class="col-md-4 col-form-label text-md-end">{{ __('Asset Code') }}</label>

                          <div class="col-md-4">
                              <input id="asset_code" type="text" class="form-control @error('asset_code') is-invalid @enderror" name="asset_code" value="{{ old('asset_code') }}" required autocomplete="asset_code">

                              @error('asset_code')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>



                      <div class="row mb-3">
                          <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                          <div class="col-md-4">
                              <select id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" autocomplete="status">
                                  <option value="1">Active</option>
                                  <option value="0">Inactive</option>
                              </select>
                              @error('status')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

                          <div class="col-md-4">
                              <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="{{ old('note') }}" required autocomplete="note" >

                              @error('note')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>




                      <div class="row mb-0">
                          <div class="col-md-4 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Save') }}
                              </button>
                          </div>
                      </div>
                  </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
