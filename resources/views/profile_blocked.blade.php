@extends('layouts.app')

@section('content')

@if (\Session::has('success'))
<div class="alert alert-success">
    {!! \Session::get('success') !!}
</div>
@endif

@if (\Session::has('warning'))
<div class="alert alert-success">
    {!! \Session::get('warning') !!}
</div>
@endif


<div class="card">
    <div class="card-body">
        <div class="text-center">
            <h2 class="text-danger">Your Profile Is Blocked. Please Contact Our Customer Care!</h2>
        </div>
    </div>
</div>

@endsection
