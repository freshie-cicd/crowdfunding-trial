@extends('administrator.layouts.application')


@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add New Package') }}</div>

                <div class="card-body">

                  @if (\Session::has('success'))
                      <div class="alert alert-success">
                              {!! \Session::get('success') !!}
                      </div>
                  @endif


                  <form method="POST" action="{{ route('package.update') }}" enctype="multipart/form-data">
                      @csrf

                      <div class="row mb-3">
                          <label for='batch_id' class="col-md-4 col-form-label text-md-end">{{ __('Batch ID') }}</label>

                          <div class="col-md-4">
                              <select id='batch_id' type="text" class="form-control @error('batch_id') is-invalid @enderror" name='batch_id' value="{{ $data[0]->batch_id }}" required autocomplete='batch_id' autofocus>
                                <option value="{{ $data[0]->batch_id }}">{{ $data[0]->batch_id }}</option>
                                <option value="">PLEASE SELECT</option>
                                @foreach ($batches as $batch)
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
                          <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Package Name') }}</label>

                          <div class="col-md-4">
                              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data[0]->name }}" required autocomplete="name">

                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for='description' class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                          <div class="col-md-4">
                              <input id='description' type="text" class="form-control @error('description') is-invalid @enderror" name='description' value="{{ $data[0]->description }}" required autocomplete='description' >

                              @error('description')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for='code' class="col-md-4 col-form-label text-md-end">{{ __('Code') }}</label>

                          <div class="col-md-4">
                              <input id='code' type="text" class="form-control @error('code') is-invalid @enderror" name='code' value="{{ $data[0]->code }}" required autocomplete='code'>

                              @error('code')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for='value' class="col-md-4 col-form-label text-md-end">{{ __('Package Value') }}</label>

                          <div class="col-md-4">
                              <input id='value' type="text" class="form-control @error('value') is-invalid @enderror" name='value' value="{{ $data[0]->value }}" required autocomplete='value'>

                              @error('value')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for='capacity' class="col-md-4 col-form-label text-md-end">{{ __('Package Capacity') }}</label>

                          <div class="col-md-4">
                              <input id='capacity' type="text" class="form-control @error('capacity') is-invalid @enderror" name='capacity' value="{{ $data[0]->capacity }}" required autocomplete='capacity'>

                              @error('capacity')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>



                      <div class="row mb-3">
                          <label for='status' class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                          <div class="col-md-4">
                              <select id='status' type="text" class="form-control @error('status') is-invalid @enderror" name='status' value="{{ $data[0]->status }}" required autocomplete='status' autofocus>
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
                          <label for='note' class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

                          <div class="col-md-4">
                              <input id='note' type="text" class="form-control @error('note') is-invalid @enderror" name='note' value="{{ $data[0]->note }}" autocomplete='note' >

                              @error('note')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <input type="hidden" name="id" value="{{ $data[0]->id }}">

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
