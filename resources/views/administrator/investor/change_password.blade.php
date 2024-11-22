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

                <div class="card-header">Change Password for <b>{{ $data[0]->name }}</b></div>

                <div class="card-body">



                    @foreach ($errors->all() as $error)

                            <p class="text-danger">{{ $error }}</p>

                         @endforeach 

                         

                    <form method="POST" action="{{ route('admin.investor.store_password') }}">

                        

                        @csrf

                        

                        <div class="row mb-3">

                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>



                            <div class="col-md-6">

                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data[0]->email }}"  autocomplete="email" disabled>

                            </div>

                        </div>

                        

                        <input type="hidden" value="{{ $data[0]->id }}" name="id" />





                        <div class="row mb-3">

                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>



                            <div class="col-md-6">

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value=""  autocomplete="password" autofocus>



                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="row mb-3">

                            <label for="password_confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>



                            <div class="col-md-6">

                                <input id="password_confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" value="" autocomplete="password" >



                                @error('password_confirm')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="row mb-0">

                            <div class="col-md-12 offset-md-4">

                                <button type="submit" class="btn btn-dark ">

                                    {{ __('Change Password') }}

                                </button>

                            </div>

                        </div>





                </div>

            </div>

        </div>

    </div>

</div>

@endsection