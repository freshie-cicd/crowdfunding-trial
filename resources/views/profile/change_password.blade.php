@extends('layouts.dashboard')

@section('content')
<div class="container">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        {!! \Session::get('success') !!}
    </div>
    @endif

    @if (\Session::has('error'))
    <div class="alert alert-danger">
        {!! \Session::get('error') !!}
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                    @endforeach
                    <form method="POST" action="{{ route('change_password.update') }}">
                        @csrf

                        <!-- Old Password Field -->
                        <div class="row mb-3">
                            <label for="old_password"
                                class="col-md-4 col-form-label text-md-end">{{ __('Old Password') }}</label>
                            <div class="col-md-6 relative">
                                <input id="old_password" type="password"
                                    class="form-control @error('old_password') is-invalid @enderror" name="old_password"
                                    value="" autocomplete="current-password" required />
                                <span class="absolute inset-y-0 right-3 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('old_password')">
                                    <i class="fa fa-eye-slash" id="old_password_icon" aria-hidden="true"></i>
                                </span>

                                @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- New Password Field -->
                        <div class="row mb-3">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6 relative">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="" autocomplete="new-password" required />
                                <span class="absolute inset-y-0 right-3 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('password')">
                                    <i class="fa fa-eye-slash" id="password_icon" aria-hidden="true"></i>
                                </span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="row mb-3">
                            <label for="password_confirm"
                                class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6 relative">
                                <input id="password_confirm" type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" value="" autocomplete="new-password" required />
                                <span class="absolute inset-y-0 right-3 flex items-center pr-3 cursor-pointer" onclick="togglePasswordVisibility('password_confirm')">
                                    <i class="fa fa-eye-slash" id="password_confirm_icon" aria-hidden="true"></i>
                                </span>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(id) {
        var input = document.getElementById(id);
        var icon = document.getElementById(id + "_icon");
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }
</script>
@endsection