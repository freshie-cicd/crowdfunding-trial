@extends('administrator.layouts.application')



@section('content')
<div class="container-fluid">


    <div class="row">
        <div class="col-12">
            <div class="row justify-content-end">
            <div class="col-3 mb-2">
                <form method="get" action="" class="form-control">
                    <select class="form-control form-select" name='package_id' id="package_id" onchange='updateFilter()'>
                         <option value=''>Please Select</option>
                        @foreach ($packages as $package)
                            <option value='{{ $package->id }}' {{ request()->package_id == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
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
                                    @if($role == 'superadmin' || $role == 'customersupport')
                                    <th>Account</th>
                                    <th>Routing</th>
                                    @endif
                                    <th>Agreement</th>
                                    <th>Reinvest</th>
                                    <th>Capital</th>
                                    <th>Profit</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $keyX=1;
                                @endphp
                                @foreach($data as $key => $item)
                                @php
                                $isAgreementDelivered = $item->agreement_request_status === "delivered";
                                $isPaid = $item->closing_request_status === "disbursed";
                                @endphp
                                <tr>
                                    <td>{{ $keyX++}}</td>
                                    <td>
                                        {{ $item->code }}
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->package_name }}: {{$item->package_value*$item->booking_quantity}}/{{$item->booking_quantity}}</td>
                                    <td>{{ $item->bank_name }}</td>
                                    <td>{{ $item->account_name }}</td>
                                    @if($role == 'superadmin' || $role == 'customersupport')
                                    <td>{{ $item->account_number }}</td>
                                    <td>{{ $item->routing_number }}</td>
                                    @endif
                                    <td>{{ $isAgreementDelivered ? 'Yes' : 'No' }}</td>
                                    <td>{{ $item->reinvestment_amount }}</td>
                                    <td>{{ $item->withdrawal_amount }}</td>
                                    <td>{{ $item->profit_amount }}</td>
                                    <td>{{ $item->withdrawal_amount + $item->profit_amount - ($isAgreementDelivered ? 450 : 0) }}</td>
                                    <td>{{ $isPaid ? 'Yes' : 'No' }}</td>
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



<script>
    function updateFilter() {
        let package_id = document.getElementById('package_id').value;

        let url = new URL(window.location.href);
        url.searchParams.set('package_id', package_id);

        window.location.href = url.toString();
    }
</script>

@endsection
