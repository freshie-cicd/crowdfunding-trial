@extends('administrator.layouts.application')

@section('content')

<div class="container">
    @if (\Session::has('success'))
  <div class="alert alert-success">
          {!! \Session::get('success') !!}
  </div>
@endif
    <div class="row justify-content-center">
        

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add a cow profile
                 
                </div>
                <div class="card-body">

                    @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                    @endforeach 
                         
                    <form method="POST" action="{{ route('admin.borga.cow_profile_store') }}" enctype="multipart/form-data">
                        
                        @csrf

                        <div class="row mb-3">
                            <label for="batch_id" class="col-md-4 col-form-label text-md-end">{{ __('Batch') }}</label>

                            <div class="col-md-6">
                                <select id="batch_id" type="batch_id" class="form-select form-control @error('batch_id') is-invalid @enderror" name="batch_id" value=""  autocomplete="batch_id" autofocus>
                                 @foreach($batches as $batch)    
                                    <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                @endforeach
                                </select>
                                @error('batch_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="package_id" class="col-md-4 col-form-label text-md-end">{{ __('Package') }}</label>

                            <div class="col-md-6">
                                <select id="package_id" type="package_id" class="form-select form-control @error('package_id') is-invalid @enderror" name="package_id" value=""  autocomplete="package_id" autofocus>
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
                            <label for="cow_code" class="col-md-4 col-form-label text-md-end">{{ __('Cow Code') }}</label>

                            <div class="col-md-6">
                                <input id="cow_code" type="text" class="form-control @error('cow_code') is-invalid @enderror" name="cow_code" value="" placeholder="Unique Cow Code for Barcode Generation"  autocomplete="cow_code" required>

                                @error('cow_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="purchase_date" class="col-md-4 col-form-label text-md-end">{{ __('Purchase Date') }}</label>

                            <div class="col-md-6">
                                <input id="purchase_date" type="date" class="form-control @error('purchase_date') is-invalid @enderror" name="purchase_date" value=""  autocomplete="purchase_date" required>

                                @error('purchase_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value=""  autocomplete="price" required>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="hasil" class="col-md-4 col-form-label text-md-end">{{ __('Hasil') }}</label>

                            <div class="col-md-6">
                                <input id="hasil" type="text" class="form-control @error('hasil') is-invalid @enderror" name="hasil" value=""  autocomplete="hasil" required>

                                @error('hasil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="transport_cost" class="col-md-4 col-form-label text-md-end">{{ __('Transport Cost') }}</label>

                            <div class="col-md-6">
                                <input id="transport_cost" type="text" class="form-control @error('transport_cost') is-invalid @enderror" name="transport_cost" value=""  autocomplete="transport_cost" required>

                                @error('transport_cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="weight" class="col-md-4 col-form-label text-md-end">{{ __('Weight') }}</label>

                            <div class="col-md-6">
                                <input id="weight" type="text" class="form-control @error('weight') is-invalid @enderror" name="weight" value=""  autocomplete="weight" required>

                                @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="color" class="col-md-4 col-form-label text-md-end">{{ __('Color') }}</label>

                            <div class="col-md-6">
                                <input id="color" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value=""  autocomplete="color" required>

                                @error('color')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="breed" class="col-md-4 col-form-label text-md-end">{{ __('Breed') }}</label>

                            <div class="col-md-6">
                                <input id="breed" type="text" class="form-control @error('breed') is-invalid @enderror" name="breed" value=""  autocomplete="breed" required>

                                @error('breed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="age" class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                            <div class="col-md-6">
                                <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value=""  autocomplete="age" required>

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="adviser" class="col-md-4 col-form-label text-md-end">{{ __('Adviser') }}</label>

                            <div class="col-md-6">
                                <input id="adviser" type="text" class="form-control @error('adviser') is-invalid @enderror" name="adviser" value=""  autocomplete="adviser" required>

                                @error('adviser')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="hat" class="col-md-4 col-form-label text-md-end">{{ __('Hat') }}</label>

                            <div class="col-md-6">
                                <input id="hat" type="text" class="form-control @error('hat') is-invalid @enderror" name="hat" value=""  autocomplete="hat" required>

                                @error('hat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="photo" class="col-md-4 col-form-label text-md-end">{{ __('Photo') }}</label>

                            <div class="col-md-6">
                                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value=""  autocomplete="photo">

                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

                            <div class="col-md-6">
                                <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value=""  autocomplete="note">

                                @error('note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="row mb-0">
                            <div class="col-md-12 offset-md-4">
                                <button type="submit" class="btn btn-dark ">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>


                </div>
            </div>
        </div>
    </div>
</div>




@endsection