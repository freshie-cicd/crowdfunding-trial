@extends('layouts.dashboard')
@section('content')
@if (\Session::has('success'))
<div class="alert alert-success">
  {!! \Session::get('success') !!}
</div>
@endif

@if (\Session::has('warning'))
<div class="alert alert-warning">
  {!! \Session::get('warning') !!}
</div>
@endif
<div class="card mb-2 mt-2">

  <div class="card-header">
    <h3>My Packages</h3>
  </div>

  <div class="card-body">
    <div class="">
      <div class="row">
        @foreach($bookings as $booking)
        <div class="col-md-4">
          <div class="card" style="">
            <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshie-farm.png" alt="" style="padding:24px">
            <div class="card-body">
              <h5 class="card-title">Booking Code: <b class="text-danger"> {{ $booking->code }}</b></h5>
              <p class="card-text">{{ $booking->description }}</p>
              <p class="card-text text-uppercase">Package Code: <b> {{ $booking->pcode }}</b></p>
              <p class="card-text text-uppercase">Purchase Price:<b> {{ $booking->value*$booking->booking_quantity }}</b></p>
              <p class="card-text text-uppercase">Status:<b> {{ $booking->status }}</b></p>

              @if($booking->status=='pending')
              @if($checkPendingApproval==1)
              <div class="d-grid gap 2">
                <button type="button" class="btn btn-warning" disabled>Wait until admin approve your other Pending Approval Investment</button>
              </div>
              @else
              <div class="d-grid gap-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#instructionModal"> Instruction</button>
                <a href="{{ url('payment-proof') }}/{{ $booking->id }}/submit/" class="btn btn-primary">Submit Payment Proof</a>
              </div>
              @endif
              @else
              <div class="d-grid gap-2">
                <a href="{{ $booking->url }}" class="btn btn-primary" target="__blank"><i class="fa-brands fa-facebook"></i> JOIN FACEBOOK GROUP</a>
              </div>
              @endif

            </div>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>
</div>

<div class="card mt-5 mb-2">
  <div class="card-header">
    <h3>
      Open Packages For Investment
    </h3>
  </div>
  <div class="card-body">
    <div class="">
      <div class="row">
        @foreach($packages as $package)
        <div class="col-md-4">
          <div class="card" style="">
            <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshie-farm.png" alt="" style="padding:24px">
            <div class="card-body">
              <h5 class="card-title">{{ $package->name }}</h5>
              <p class="card-text">{{ $package->description }}</p>
              <p class="card-text">Package Code: {{ $package->code }}</p>
              <p class="card-text">Purchase Price: {{ $package->value }}</p>
              <p class="card-text">Total Capacity: {{ $package->capacity }}</p>
              <a href="{{ url('book/') }}/{{ $package->id }}/package" class="btn btn-primary">Request for Purchase</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>

    </div>

  </div>
</div>

<div class="modal fade" id="instructionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="min-width:60%">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Payment Instruction</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>১. আপনার বুকিং করা বিনিয়োগ প্যাকেজ পেন্ডিং আছে। অনুগ্রহপূর্বক লাল রঙ এর বুকিং কোড সংরক্ষন করুন।</p>
        <p>২. আপনি সরাসরি Bank Deposit করতে পারবেন। অথবা BEFTN, NPSB এর মাধ্যমেও টাকা পাঠাতে পারবেন। </p>
        <br>

        @include('shared.bank-details')

        <p>৩. টাকা পাঠানোর সময় Deposit Slip অথবা ফর্ম এর রেফারেন্সের ঘরে অবশ্যই আপনার বুকিং কোড উল্লেখ করুন।</p>
        <p>৪. টাকা পাঠানোর পর Deposit Slip এর ছবি উঠান অথবা App এর Success Message এর Screenshot নিন।</p>
        <p>৫. আমাদের User Dashboard এর My Bookings এ গিয়ে Submit Payment Proof বাটন প্রেস করুন। </p>
        <p>৬. একটি ফর্ম পাবেন। ফরমটি পুরন করুন এবং পেমেন্ট প্রুফ হিসেবে রাখা ছবিটি সংযোজন করে সেভ করুন।</p>
        <p>৭. আমাদের এডমিনের পক্ষ থেকে পেমেন্ট কনফার্মেশনের জন্য অপেক্ষা করুন।</p>
        <p>
          বিঃ দ্রঃ আপনার যদি কোনো বুকিং "PENDING APPROVAL" অবস্থায় থাকে তাহলে নতুন করে আরেকটি বুকিং কোডে পেমেন্ট প্রুফ সাবমিট করতে পারবেন না।
          আপনার আগের বুকিংটি এপ্রুভ হওয়া পর্যন্ত অপেক্ষা করুন।
        </p>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection