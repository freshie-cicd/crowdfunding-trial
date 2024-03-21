@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add New Project') }}</div>

                <div class="card-body">

                  @if (\Session::has('success'))
                      <div class="alert alert-success">
                              {!! \Session::get('success') !!}
                      </div>
                  @endif


                  <form method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
                      @csrf

                      <div class="row mb-3">
                          <label for="project_name" class="col-md-4 col-form-label text-md-end">{{ __('Project Name') }}</label>

                          <div class="col-md-4">
                              <input id="project_name" type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="{{ old('project_name') }}" required autocomplete="project_name" autofocus>

                              @error('project_name')
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
                          <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('Project Code') }}</label>

                          <div class="col-md-4">
                              <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code">

                              @error('code')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="cover_photo" class="col-md-4 col-form-label text-md-end">{{ __('Cover Photo') }}</label>

                          <div class="col-md-4">
                              <input id="cover_photo" type="file" class="form-control @error('cover_photo') is-invalid @enderror" name="cover_photo" value="{{ old('cover_photo') }}" autocomplete="cover_photo">

                              @error('code')
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
