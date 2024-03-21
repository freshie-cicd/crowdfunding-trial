@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add New Project Batch') }}</div>

                <div class="card-body">

                  @if (\Session::has('success'))
                      <div class="alert alert-success">
                              {!! \Session::get('success') !!}
                      </div>
                  @endif


                  <form method="POST" action="{{ route('batch.update') }}" enctype="multipart/form-data">
                      @csrf

                      <div class="row mb-3">
                          <label for="project_id" class="col-md-4 col-form-label text-md-end">{{ __('SELECT PROJECT') }}</label>

                          <div class="col-md-4">
                              <select id="project_id" type="text" class="form-control @error('project_id') is-invalid @enderror" name="project_id" value="{{ old('project_id') }}" required autocomplete="project_id" autofocus>
                                  <option value="{{ $data[0]->project_id }}">{{ $data[0]->project_id }}</option>
                                  <option value="">PLEASE SELECT</option>

                                  @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                  @endforeach

                              </select>
                              @error('project_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Batch Name') }}</label>

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
                          <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                          <div class="col-md-4">
                              <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $data[0]->description }}" required autocomplete="description">

                              @error('description')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('Batch Code') }}</label>

                          <div class="col-md-4">
                              <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ $data[0]->code }}" required autocomplete="code">

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
                              <input id="cover_photo" type="file" class="form-control @error('cover_photo') is-invalid @enderror" name="cover_photo" value="{{ $data[0]->cover_photo }}" autocomplete="cover_photo">

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
                              <select id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ $data[0]->status }}" autocomplete="status">
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
                          <label for="ending_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>

                          <div class="col-md-4">
                              <input id="ending_date" type="date" class="form-control @error('ending_date') is-invalid @enderror" name="ending_date" value="{{ $data[0]->ending_date }}" autocomplete="ending_date">

                              @error('ending_date')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

                          <div class="col-md-4">
                              <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="{{ $data[0]->note }}" autocomplete="note">

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
