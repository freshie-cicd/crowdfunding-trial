@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="flex flex-row">
        <div class="grow">
            <h1 class="text-2xl font-semibold"></h1>
        </div>
        <div class="flex items-center space-x-2 px-2">
            <a href="{{ route('administrator.booking.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>

    @if (\Session::has('success'))
    <div class="alert alert-success">
        {!! \Session::get('success') !!}
    </div>
    @endif

    @if (\Session::has('info'))
    <div class="alert alert-info">
        {!! \Session::get('info') !!}
    </div>
    @endif

    <div class="grid grid-cols-2 gap-2">
        <div class="flex flex-row mt-2">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <h1 class="text-2xl font-semibold">Booking Details</h1>
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ $booking->code }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="package_name">Package Name</label>
                            <input type="text" class="form-control" id="package_name" name="package_name" value="{{ $booking->package_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_name">Investor</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $booking->user_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="text" class="form-control" id="user_email" name="user_email" value="{{ $booking->user_email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_phone">Phone</label>
                            <input type="text" class="form-control" id="user_phone" name="user_phone" value="{{ $booking->user_phone }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="booking_quantity">Booking Quantity</label>
                            <input type="text" class="form-control" id="booking_quantity" name="booking_quantity" value="{{ $booking->booking_quantity }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="total_value">Total Value</label>
                            <input type="text" class="form-control" id="total_value" name="total_value" value="{{ $booking->total_value }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status" value="{{ $booking->status }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" id="note" name="note" value="{{ $booking->note }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row mt-2">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <h1 class="text-2xl font-semibold">Bank Details</h1>
                        @if($bankDetails)
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $bankDetails->bank_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="branch_name">Branch Name</label>
                            <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ $bankDetails->branch_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="account_name">Account Name</label>
                            <input type="text" class="form-control" id="account_name" name="account_name" value="{{ $bankDetails->account_name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="text" class="form-control" id="account_number" name="account_number" value="{{ $bankDetails->account_number }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="routing_number">Routing Number</label>
                            <input type="text" class="form-control" id="routing_number" name="routing_number" value="{{ $bankDetails->routing_number }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="district">District</label>
                            <input type="text" class="form-control" id="district" name="district" value="{{ $bankDetails->district }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" id="note" name="note" value="{{ $bankDetails->note }}" readonly>
                        </div>


                        @else
                        <h1 class="mt-4 text-2xl font-semibold text-red-500">No Bank Details</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div class="flex flex-row mt-5">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <h1 class="text-2xl font-semibold">Payment Details
                            #{{ $payment ? $payment->id : '' }}
                        </h1>
                        @if($payment)
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <input type="text" class="form-control" id="payment_method" name="payment_method" value="{{ $payment->payment_method }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Payment Date</label>
                            <input type="text" class="form-control" id="payment_date" name="payment_date" value="{{ $payment->payment_date }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="payment_document">Payment Document</label>
                            @if($payment->payment_document)
                            <img src="{{ asset($payment->payment_document) }}" alt="Payment Document" class="w-1/4">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="document_two">Document Two</label>
                            @if($payment->document_two)
                            <img src="{{ asset($payment->document_two) }}" alt="Document Two" class="w-1/4">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="document_three">Document Three</label>
                            @if($payment->document_three)
                            <img src="{{ asset($payment->document_three) }}" alt="Document Three" class="w-1/4">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="bank">Bank</label>
                            <input type="text" class="form-control" id="bank" name="bank" value="{{ $payment->bank }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="branch">Branch</label>
                            <input type="text" class="form-control" id="branch" name="branch" value="{{ $payment->branch }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="depositors_name">Depositors Name</label>
                            <input type="text" class="form-control" id="depositors_name" name="depositors_name" value="{{ $payment->depositors_name }}" readonly>
                        </div>
                        <div class="form-group ">
                            <label for="depositors_mobile_number">Depositors Mobile Number</label>
                            <input type="text" class="form-control" id="depositors_mobile_number" name="depositors_mobile_number" value="{{ $payment->depositors_mobile_number }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="deposit_reference">Deposit Reference</label>
                            <input type="text" class="form-control" id="deposit_reference" name="deposit_reference" value="{{ $payment->deposit_reference }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" id="note" name="note" value="{{ $payment->note }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status" value="{{ $payment->status }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Created At</label>
                            <input type="text" class="form-control" id="created_at" name="created_at" value="{{ $payment->created_at }}" readonly>
                        </div>
                        @else
                        <h1 class="mt-4 text-2xl font-semibold text-red-500">No Payment Proof</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="flex flex-row mt-5">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <div class="flex flex-row justify-between">
                            <h1 class="text-2xl font-semibold">Closing Details</h1>

                            <div class="flex items center space-x-2 px-2">
                                <a href="{{ route('administrator.closing.edit', $booking->code) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                        @if($closing)
                        <div class="form-group">
                            <label for="package_to_withdraw">Package To Withdraw</label>
                            <input type="text" class="form-control" id="package_to_withdraw" name="package_to_withdraw" value="{{ $closing->package_to_withdraw }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="capital_withdrawal_amount">Capital Withdrawal Amount</label>
                            <input type="text" class="form-control" id="capital_withdrawal_amount" name="capital_withdrawal_amount" value="{{ $closing->capital_withdrawal_amount }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="profit_withdrawal_amount">Profit Withdrawal Amount</label>
                            <input type="text" class="form-control" id="profit_withdrawal_amount" name="profit_withdrawal_amount" value="{{ $closing->profit_withdrawal_amount }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="package_after_withdrawal">Package For Migration</label>
                            <input type="text" class="form-control" id="package_after_withdrawal" name="package_after_withdrawal" value="{{ $closing->package_after_withdrawal }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="after_withdrawal_amount">Migration Amount</label>
                            <input type="text" class="form-control" id="after_withdrawal_amount" name="after_withdrawal_amount" value="{{ $closing->after_withdrawal_amount }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="is_bank_detail_correct">Is Bank Detail Correct</label>
                            <input type="text" class="form-control" id="is_bank_detail_correct" name="is_bank_detail_correct" value="{{ $closing->is_bank_detail_correct }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" id="note" name="note" value="{{ $closing->note }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" id="status" name="status" value="{{ $closing->status }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Created At</label>
                            <input type="text" class="form-control" id="created_at" name="created_at" value="{{ $closing->created_at }}" readonly>
                        </div>
                        @if($closing->status == 'requested' || $closing->status == 'processing')
                        <div class="form-group mt-4">
                            <a href="{{ url('administrator/migration') }}/{{ $booking->code }}/i/{{ $booking->user_id }}/p/5" class="btn btn-success btn-sm">Settle the investment</a>
                        </div>
                        @endif
                        @else
                        <h1 class="mt-4 text-2xl font-semibold text-red-500">No Closing Details</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection