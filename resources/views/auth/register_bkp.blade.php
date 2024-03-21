@extends('layouts.dashboard')

@section('content')
<div class="container">
    @if (\Session::has('success'))
  <div class="alert alert-success">
          {!! \Session::get('success') !!}
  </div>
@endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit PRofile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

         <p>Personal Information</p>
         <hr>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name ?? '' }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email ?? '' }}"  autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ auth()->user()->phone ?? '' }}"  autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="permanent_address" class="col-md-4 col-form-label text-md-end">{{ __('Permanent Address') }}</label>

                            <div class="col-md-6">
                                <input id="permanent_address" type="text" class="form-control @error('permanent_address') is-invalid @enderror" name="permanent_address" value="{{ auth()->user()->permanent_address ?? '' }}"  autocomplete="permanent_address">

                                @error('permanent_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="present_address" class="col-md-4 col-form-label text-md-end">{{ __('Present Address') }}</label>

                            <div class="col-md-6">
                                <input id="present_address" type="text" class="form-control @error('present_address') is-invalid @enderror" name="present_address" value="{{ auth()->user()->present_address ?? '' }}"  autocomplete="present_address">

                                @error('present_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="father_name" class="col-md-4 col-form-label text-md-end">{{ __('Father Name') }}</label>

                            <div class="col-md-6">
                                <input id="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ auth()->user()->father_name ?? '' }}"  autocomplete="father_name">

                                @error('father_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mother_name" class="col-md-4 col-form-label text-md-end">{{ __('Mother Name') }}</label>

                            <div class="col-md-6">
                                <input id="mother_name" type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ auth()->user()->mother_name ?? '' }}"  autocomplete="mother_name">

                                @error('mother_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="row mb-3">
                            <label for="nid" class="col-md-4 col-form-label text-md-end">{{ __('National ID') }}</label>

                            <div class="col-md-6">
                                <input id="nid" type="nid" class="form-control @error('nid') is-invalid @enderror" name="nid" value="{{ auth()->user()->nid ?? '' }}"  autocomplete="nid">

                                @error('nid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">{{ __('Date Of Birth') }}</label>

                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ auth()->user()->date_of_birth ?? '' }}"  autocomplete="date_of_birth">

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <p>Nominee Information</p>
                        <hr>
                                                <div class="row mb-3">
                            <label for="nominee_name" class="col-md-4 col-form-label text-md-end">{{ __('Nominee Name') }}</label>

                            <div class="col-md-6">
                                <input id="nominee_name" type="nominee_name" class="form-control @error('nominee_name') is-invalid @enderror" name="nominee_name" value="{{ auth()->user()->nominee_name ?? '' }}"  autocomplete="nominee_name">

                                @error('nominee_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nominee_phone" class="col-md-4 col-form-label text-md-end">{{ __('Nominee Phone') }}</label>

                            <div class="col-md-6">
                                <input id="nominee_phone" type="nominee_phone" class="form-control @error('nominee_phone') is-invalid @enderror" name="nominee_phone" value="{{ auth()->user()->nominee_phone ?? '' }}"  autocomplete="nominee_phone">

                                @error('nominee_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nominee_address" class="col-md-4 col-form-label text-md-end">{{ __('Nominee Address') }}</label>

                            <div class="col-md-6">
                                <input id="nominee_address" type="nominee_address" class="form-control @error('nominee_address') is-invalid @enderror" name="nominee_address" value="{{ auth()->user()->nominee_address ?? '' }}"  autocomplete="nominee_address">

                                @error('nominee_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nominee_relation" class="col-md-4 col-form-label text-md-end">{{ __('Relation') }}</label>

                            <div class="col-md-6">
                                <input id="nominee_relation" type="text" class="form-control @error('nominee_relation') is-invalid @enderror" name="nominee_relation" value="{{ auth()->user()->nominee_relation ?? '' }}"  autocomplete="nominee_relation">

                                @error('nominee_relation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nominee_nid" class="col-md-4 col-form-label text-md-end">{{ __('Nominee NID') }}</label>

                            <div class="col-md-6">
                                <input id="nominee_nid" type="nominee_nid" class="form-control @error('nominee_nid') is-invalid @enderror" name="nominee_nid" value="{{ auth()->user()->nominee_nid ?? '' }}"  autocomplete="nominee_nid">

                                @error('nominee_nid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

     

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Change Password</div>
                <div class="card-body">

                    @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach 
                         
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-12 col-form-label text-md-start">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value=""  autocomplete="password" autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirm" class="col-md-12 col-form-label text-md-start">{{ __('Confirm Password') }}</label>

                            <div class="col-md-12">
                                <input id="password_confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" value="" autocomplete="password" >

                                @error('password_confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark">
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
