@extends('administrator.layouts.application')



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Closing Reports</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking Code</th>
                                    <th>Investor Name</th>
                                    <th>Investor Phone</th>
                                    <th>Package Name</th>
                                    <th>Bank Name</th>
                                    <th>AC. Name</th>
                                    @if($role == 'superadmin')
                                    <th>Account</th>
                                    <th>Routing</th>
                                    @endif
                                    <th>Agreement</th>
                                    <th>Reinvest</th>
                                    <th>Capital</th>
                                    <th>Profit</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $item->code }}
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->package_name }}: {{$item->package_value*$item->booking_quantity}}/{{$item->booking_quantity}}</td>
                                    <td>{{ $item->bank_name }}</td>
                                    <td>{{ $item->account_name }}</td>
                                    @if($role == 'superadmin')
                                    <td>{{ $item->account_number }}</td>
                                    <td>{{ $item->routing_number }}</td>
                                    @endif
                                    <td>{{ $item->agreement_request_status === "delivered" ? 'Yes' : 'No' }}</td>
                                    <td>{{ $item->reinvestment_amount }}</td>
                                    <td>{{ $item->withdrawal_amount }}</td>
                                    <td>{{ $item->profit_amount }}</td>
                                    <td>{{ $item->withdrawal_amount + $item->profit_amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection