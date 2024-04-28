@extends('administrator.layouts.application')



@section('content')
<!-- $data = Booking::where('bookings.status', 'approved')
->join('users', 'users.id', '=', 'bookings.user_id')
->join('packages', 'packages.id', '=', 'bookings.package_id')
->where('bookings.package_id', '=', 2)
->select('bookings.*', 'users.name', 'users.phone', 'packages.name as package_name')
->get();

return view('administrator.reports.closing', compact('data')); -->

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
                                    <th>AC. Name</th>
                                    @if($role == 'superadmin')
                                    <th>Account</th>
                                    <th>Routing</th>
                                    @endif
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
                                    <td>{{ $item->account_name }}</td>
                                    @if($role == 'superadmin')
                                    <td>{{ $item->account_number }}</td>
                                    <td>{{ $item->routing_number }}</td>
                                    @endif
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