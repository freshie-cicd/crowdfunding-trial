@extends('administrator.layouts.application')
<style>
    @import('https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css');



    .dt-search {
        float: right;
        margin-top:-50px;
    }

    .dt-buttons{
        background: #222;
        border-radius: 4px;
        padding: 8px 4px;
        color: white;
        width: 50px;
        text-align: center;
        margin-bottom: 10px;
    }

</style>

@section('content')

<div class="">


    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="col-md-5">
                <form method="get" action="" class="form-control">
                    <div class="row">

                        <div class="col-md-6">
                            <select class="form-control form-select" name='shortlist' id="shortlist" onchange='updateFilter()'>
                                <option value='' {{ request()->shortlist != 1 ? 'selected' : '' }}>Full List</option>
                                <option value='' {{ request()->shortlist == 1 ? 'selected' : '' }}>Short List for Bank</option>

                           </select>
                        </div>

                        <div class="col-md-6">
                            <select class="form-control form-select" name='package_id' id="package_id" onchange='updateFilter()'>
                                <option value=''>Please Select</option>
                               @foreach ($packages as $package)
                                   <option value='{{ $package->id }}' {{ request()->package_id == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
                               @endforeach
                           </select>
                        </div>

                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Closing Bank Sheet Shortlist') }}</div>

                @if (\Session::has('success'))
                <div class="alert alert-success">
                    {!! \Session::get('success') !!}
                </div>
                @endif



                <div class="card-body">

                    <table id="dataTable" class="table table-striped table-bordered table-hover table-responsive">
                        <thead class="thead-dark" style="background:#222;color:#fff">
                            <tr>
                                <th scope="col">SL No</th>
                                <th scope="col">ORGN Account No</th>
                                <th scope="col">ORGN Customer ID</th>
                                <th scope="col">ORGN Name</th>
                                <th scope="col">Company Entry Desc</th>
                                <th scope="col">Company Descri Date</th>
                                <th scope="col">Receiver ID</th>
                                <th scope="col">Receiver Name</th>
                                <th scope="col">DFI Account No</th>
                                <th scope="col">CrDr</th>
                                <th scope="col">RSPD RoutingNo</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Trans Code</th>
                                <th scope="col">SEC code</th>
                                <th scope="col">No Of ADR</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                            @php
                                $totalAmount = 0;

                            @endphp
                                @foreach ($closingInfo as $info)

                                @if($info->user_id == $user->id)
                                    @php
                                        $totalAmount = $totalAmount + $info->capital_withdrawal_amount + $info->profit_withdrawal_amount;
                                        $accountName = $info->account_name;
                                        $phone = Str::replace($check, '', $info->phone);
                                        $accountNumber = Str::replace($check, '', $info->account_number);
                                        $routingNumber = $info->routing_number;
                                        $withdrawalType = $info->capital_withdrawal_amount == 0 ? _('Profit') : __('Capital + Profit');
                                    @endphp
                                @endif

                                @endforeach
                                <tr>
                                    <th scope="row">{{ $counter++ }}</th>
                                    <th scope="row">{{ __('11100007771') }}</th>
                                    <th scope="row">{{ __('0001555105') }}</th>
                                    <th scope="row">{{ __('Freshie Farm') }}</th>
                                    <th scope="row">{{ $withdrawalType }}</th>
                                    <th scope="row">{{ _('July 14, 2024') }}</th>
                                    <th scope="row">{{ $phone }}</th>
                                    <th scope="row"> {{ Str::limit($accountName, 15, '') }} </th>
                                    <th scope="row">'{{ Str::length($accountNumber)==17 ? Str::replaceStart(2050, '' ,$accountNumber) : $accountNumber }}</th>
                                    <th scope="row">{{ __('Cr') }}</th>
                                    <th scope="row">'{{ $routingNumber }}</th>
                                    <th scope="row">{{ $totalAmount }}</th>
                                    <th scope="row">{{ __('32') }}</th>
                                    <th scope="row">{{ __('PPD') }}</th>
                                    <th scope="row">{{ __('0') }}</th>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.tailwindcss.com/3.4.4"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>

<script>
    const date = new Date();

    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    let currentDate = `${day}-${month}-${year}`;


    new DataTable('#dataTable', {
        dom: 'Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                title: 'Batch_Closing_' + currentDate,
                footer: true
            },
        ],

        "pageLength": 50,
    });
</script>


<script>
    function updateFilter() {
        let shortlist = document.getElementById('shortlist').value;
        let package_id = document.getElementById('package_id').value;

        let url = new URL(window.location.href);


        if(package_id){
            url.searchParams.set('package_id', package_id);
        }else{
            url.searchParams.delete('package_id');
        }

        if(shortlist){
            url.searchParams.set('shortlist', shortlist);
        }else{
            url.searchParams.delete('shortlist');
        }
        window.location.href = url.toString();
    }
</script>

@endsection
