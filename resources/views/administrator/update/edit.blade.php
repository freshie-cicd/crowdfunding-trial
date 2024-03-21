@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add New Expense') }}</div>

                <div class="card-body">

                  @if (\Session::has('success'))
                      <div class="alert alert-success">
                              {!! \Session::get('success') !!}
                      </div>
                  @endif


                  <form method="POST" action="{{ route('expense.update') }}" enctype="multipart/form-data">
                      @csrf

                      <div class="row mb-3">
                          <label for="head" class="col-md-4 col-form-label text-md-end">{{ __('Expense Head') }}</label>

                          <div class="col-md-4">
                              <select id="head" type="text" class="form-control @error('head') is-invalid @enderror" name="head" value="{{ old('head') }}" required autocomplete="head" autofocus>
                                  <option value="{{ $data[0]->head }}">{{ $data[0]->head }}</option>
                                  <option value="">Please Select</option>
                                  @foreach($heads as $head)
                                      <option value="{{ $head->id }}">{{ $head->name }}</option>
                                  @endforeach
                              </select>
                              @error('head')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('Amount') }}</label>

                          <div class="col-md-4">
                              <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $data[0]->amount }}" required autocomplete="amount" autofocus>

                              @error('amount')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="submitted_by" class="col-md-4 col-form-label text-md-end">{{ __('Submitted By') }}</label>

                          <div class="col-md-4">
                              <input id="submitted_by" type="text" class="form-control @error('submitted_by') is-invalid @enderror" name="submitted_by" value="{{ $data[0]->submitted_by }}" required autocomplete="submitted_by" autofocus>

                              @error('submitted_by')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="memo" class="col-md-4 col-form-label text-md-end">{{ __('Memo') }}</label>

                          <div class="col-md-4">
                              <input id="memo" type="text" class="form-control @error('memo') is-invalid @enderror" name="memo" value="{{ $data[0]->memo }}" required autocomplete="memo" autofocus>

                              @error('memo')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Date') }}</label>

                          <div class="col-md-4">
                              <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $data[0]->date }}" required autocomplete="date" autofocus>

                              @error('date')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for="is_approved" class="col-md-4 col-form-label text-md-end">{{ __('Approved?') }}</label>

                          <div class="col-md-4">
                              <select id="is_approved" type="text" class="form-control @error('is_approved') is-invalid @enderror" name="is_approved" value="{{ old('is_approved') }}" required autocomplete="is_approved" autofocus>
                                  <option value="0">NO</option>
                                  <option value="1">YES</option>
                              </select>
                              @error('is_approved')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for="approved_by" class="col-md-4 col-form-label text-md-end">{{ __('Approved By') }}</label>

                          <div class="col-md-4">
                              <input id="approved_by" type="text" class="form-control @error('approved_by') is-invalid @enderror" name="approved_by" value="{{ $data[0]->approved_by }}" required autocomplete="approved_by" autofocus>

                              @error('approved_by')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Type') }}</label>

                          <div class="col-md-4">
                              <select id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autocomplete="type" >
                                <option value="">SELECT ONE</option>
                                <option value="office">Office</option>
                                <option value="project">Project</option>
                                <option value="others">Others</option>
                              </select>
                              @error('type')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for="asset_id" class="col-md-4 col-form-label text-md-end">{{ __('Asset ID') }}</label>

                          <div class="col-md-4">
                              <select id="asset_id" type="text" class="select2 form-control @error('asset_id') is-invalid @enderror" name="asset_id" value="{{ $data[0]->asset_id }}" required autocomplete="asset_id" autofocus>
                                  <option value="">Please Select</option>
                              </select>
                              @error('asset_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>


                      <div class="row mb-3">
                          <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>

                          <div class="col-md-4">
                              <input id="note" type="text" class="form-control @error('note') is-invalid @enderror" name="note" value="{{ $data[0]->note }}" required autocomplete="note" autofocus>

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
