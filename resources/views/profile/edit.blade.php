@extends('layouts.dashboard')

@section('content')

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">{{ __('Edit Profile') }}</div>



                @if (\Session::has('success'))

                    <div class="alert alert-success">

                        {!! \Session::get('success') !!}

                    </div>

                @endif

                

                

                @if (\Session::has('message'))

                    <div class="alert alert-danger">

                     {!! \Session::get('message') !!}

                    </div>

                @endif



                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}">

                        @csrf



 

         <h4 class="text-success">ব্যাক্তিগত  তথ্য বাংলায় পুরন করুন</h4>

         <hr>

                        <div class="row mb-3">

                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('নাম') }}</label>



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

                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('ই-মেইল') }}</label>



                            <div class="col-md-6">

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror " name="email" value="{{ auth()->user()->email ?? '' }}"  autocomplete="email" disabled>



                                @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>



                        <div class="row mb-3">

                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('ফোন নাম্বার'  ) }}</label>



                            <div class="col-md-6">

                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror " name="phone" value="{{ auth()->user()->phone ?? '' }}"  autocomplete="phone" disabled>



                                @error('phone')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                            </div>

                        </div>





                        <div class="row mb-3">

                            <label for="permanent_address" class="col-md-4 col-form-label text-md-end">{{ __('স্থায়ী ঠিকানা') }}</label>



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

                            <label for="present_address" class="col-md-4 col-form-label text-md-end">{{ __('বর্তমান ঠিকানা') }}</label>



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

                            <label for="father_name" class="col-md-4 col-form-label text-md-end">{{ __('বাবার নাম') }}</label>



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

                            <label for="mother_name" class="col-md-4 col-form-label text-md-end">{{ __('মায়ের নাম') }}</label>



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

                            <label for="nid" class="col-md-4 col-form-label text-md-end">{{ __('জাতীয় পরিচয় পত্র') }}</label>



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

                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">{{ __('জন্ম তারিখ') }}</label>



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

                        <p>নমিনির তথ্য</p>

                        <hr>

                                                <div class="row mb-3">

                            <label for="nominee_name" class="col-md-4 col-form-label text-md-end">{{ __('নমিনির নাম') }}</label>



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

                            <label for="nominee_phone" class="col-md-4 col-form-label text-md-end">{{ __('নমিনির ফোন নাম্বার') }}</label>



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
                            <label for="nominee_email" class="col-md-4 col-form-label text-md-end">{{ __('নমিনির ই-মেইল') }}</label>
                            <div class="col-md-6">
                                <input id="nominee_email" type="email" class="form-control @error('nominee_email') is-invalid @enderror" name="nominee_email" value="{{ auth()->user()->nominee_email ?? '' }}"  autocomplete="nominee_email">

                                @error('nominee_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="row mb-3">

                            <label for="nominee_address" class="col-md-4 col-form-label text-md-end">{{ __('নমিনির ঠিকানা') }}</label>



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

                            <label for="nominee_relation" class="col-md-4 col-form-label text-md-end">{{ __('সম্পর্ক') }}</label>



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

                            <label for="nominee_nid" class="col-md-4 col-form-label text-md-end">{{ __('নমিনির জাতীয় পরিচয়পত্র') }}</label>



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

                                    {{ __('জমা করুন') }}

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
