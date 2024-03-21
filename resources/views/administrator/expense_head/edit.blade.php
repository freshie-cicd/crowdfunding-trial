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


                  <form method="POST" action="{{ route('expense_head.update') }}" enctype="multipart/form-data">
                      @csrf

                      <div class="row mb-3">
                          <label for="parent_id" class="col-md-4 col-form-label text-md-end">{{ __('Parent') }}</label>

                          <div class="col-md-4">
                              <select id="parent_id" type="text" class=" form-select form-control @error('parent_id') is-invalid @enderror" name="parent_id" value="{{ old('parent_id') }}"  autocomplete="parent_id" autofocus>
                                  <option value="{{ $data[0]->parent }}">{{ $data[0]->parent }}</option>
                                  <option value="none">NONE</option>
                                  @foreach($expenseheads as $head)
                                    <option value="{{ $head->id }}">{{ $head->name }}</option>
                                  @endforeach
                              </select>
                              @error('parent_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

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
                          <label for="status" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                          <div class="col-md-4">
                              <select id="status" type="text" class="form-select form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" autocomplete="status">
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
                              <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="{{ $data[0]->note }}" required autocomplete="note">

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
