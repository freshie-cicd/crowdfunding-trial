@extends('administrator.layouts.application')
@section('content')

<div x-data="{ 
    totalPackages: {{ $booking->booking_quantity ?? 0 }}, 
    packageToWithdraw:  {{ $closing->package_to_withdraw ?? $booking->booking_quantity ?? 0 }},
    packageValue: {{ $package->value }}, 
    totalWithdrawal: 0 , 
    profit: {{ $closing->profit_withdrawal_amount ?? $closingInit->profit_value *  ($closing->package_to_withdraw ?? $booking->booking_quantity ?? 0) ?? 0 }},
    
    statuses: ['requested','processing','disbursed','hold'],
    status: '{{ $closing->status ?? 'requested' }}', 
    note: '{{ $closing->note ?? '' }}'
}">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('administrator.closing.update', $booking->code) }}" method="POST">
        @csrf
        <div class="flex flex-row mt-5">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <div class="flex flex-row justify-between">
                            <h1 class="text-2xl font-semibold">Closing Details</h1>
                            <h3 class="text-2xl font-semibold">Booking Code #{{ $booking->code }}</h3>
                        </div>
                        <div class="flex mt-2">
                            <div class="form-group mr-2">
                                <label for="package_to_withdraw">Package To Withdraw</label>
                                <select id="package_to_withdraw" type="text" class="form-select form-control" placeholder="" name="package_to_withdraw" x-model="packageToWithdraw">
                                    <template x-for="item in [...Array(totalPackages+1 - 0).keys()].map(i => i + 0)">
                                        <option x-text="item" x-bind:value="item" x-bind:selected="item === parseInt(packageToWithdraw)">
                                    </template>
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label for="capital_withdrawal_amount">Capital Withdrawal Amount</label>
                                <input type="number" class="form-control" id="capital_withdrawal_amount" name="capital_withdrawal_amount" x-model="packageToWithdraw * packageValue" readonly>
                            </div>
                            <div class="form-group mr-2">
                                <label for="profit_withdrawal_amount">Profit</label>
                                <input type="number" class="form-control" id="profit_withdrawal_amount" name="profit_withdrawal_amount" x-model="profit">
                            </div>
                            <div class="form-group flex-grow">
                                <label>Total Withdrawal</label>
                                <input type="number" class="form-control btn-outline-danger" x-model="parseInt(packageToWithdraw * packageValue) + parseInt(profit)" readonly>
                            </div>
                        </div>
                        <div class="flex mt-4">
                            <div class="form-group mr-2">
                                <label for="package_after_withdrawal">Migration to Batch 6</label>
                                <input type="text" class="form-control" name="package_after_withdrawal" x-model="totalPackages-packageToWithdraw" readonly>
                            </div>
                            <div class="form-group">
                                <label for="after_withdrawal_amount">Migration Amount</label>
                                <input type="text" class="form-control" id="after_withdrawal_amount" name="after_withdrawal_amount" x-model="(totalPackages-packageToWithdraw) * packageValue" readonly>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" name="note" x-model="note">
                        </div>

                        <div class="form-group mt-2">
                            <label for="status">Status</label>
                            <select id="status" type="text" class="form-select form-control" placeholder="" name="status" x-model="status">
                                <template x-for="item in statuses">
                                    <option x-text="item" x-bind:value="item" x-bind:selected="item === status"></option>
                                </template>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-primary">{{ $closing ? 'Update' : 'Create' }} Closing</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection