@extends('administrator.layouts.application')

@section('content')

<div>
    @include('administrator.dashboard.stats')
    @include('administrator.dashboard.payment-graph')
</div>

@endsection