@extends('layouts.app')

@section('content')

<div class="container" style="min-height: 75vh;margin-top:5vh">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card">
              <div class="logo" align="center">
                <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshie-farm.png" alt="logo" width="260px" style="padding: 6px 6px 10px 6px">
                <h4><b style="color:#017b46">ADMIN LOGIN</b></h4>
                <hr style="width:96%;min-width:320px;">
              </div>
                <div class="card-body" style="padding:30px 30px 48px 30px">
                    <form method="POST" action="{{ route('administrator.login.process') }}">
                        @csrf

                        <div class="row mb-1">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <div class="input-group mb-1">
                                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2" style="height:40px;color:#017b46"><i class="fa-solid fa-at"></i></span>
                                  </div>
                                </div>


                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">

                                <div class="input-group mb-1">
                                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                  <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2" style="height:40px;color:#017b46"><i class="fa-solid fa-key"></i></span>
                                  </div>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-dark" style="background:#017b46;border: 2px solid #017b46">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          <!--<div class="mt-4 pt-4" align="center">
              <h5 class="pb-2 text-uppercase">Not Registered?</h5>
              <a href="{{ route('register') }" class="btn btn-success btn-lg" >Create an Account</a>
          </div>-->
        </div>
    </div>
</div>
@endsection
