@extends('administrator.layouts.application')

@section('content')

<div class="flex flex-row">
    <div>
        @include('administrator.dashboard.stats')
        @include('administrator.dashboard.payment-graph')
    </div>
</div>

@endsection