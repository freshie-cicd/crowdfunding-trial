@extends('layouts.dashboard')

@section('content')

<div class="">

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



<div class="card">
  <div class="card-header">My Mature Investments</div>
      <div class="card-body">
        <div class="row">

            @foreach($bookings as $booking)
            
            @if($booking->processing_status)

                  <div class="col-md-4">
                    <div class="card mb-2 mt-2 text-center" style="">
                      <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshie-farm.png" alt="" style="padding:24px">

                      <div class="card-body">
                        <h4 class="card-title text-uppercase" style="line-height: 34px">Booking Code <br> <b class="text-danger"> {{ $booking->code }}</b></h4>
                        <h5 class="card-text text-uppercase">
                          <span class="text-success"> Your Request to withdraw <b>{{ $booking->capital_withdrawal_amount }}/- Taka </b> and <b>Batch 6</b>  Re-Investmment Request of <b>{{ $booking->after_withdrawal_amount }}/- Taka</b> is Accepted and Being Processed.  Your Total Profit <b>{{ $booking->profit_withdrawal_amount }}/- Taka </b> is also under processing.</span> </h5>

                        @if($booking->closing_status=='initiated')
                          <div class="d-grid gap-2 mt-4">
                                <a href="{{ url('/mature-batches/request/') }}/{{ $booking->code }}/withdrawal/" class="btn btn-info disabled">Already Requested</a>
                          </div>
                        @endif

                      </div>
                    </div>
                  </div>

                  @else

            <div class="col-md-4">

              <div class="card mb-2 mt-2 text-center" style="">

                <img src="https://www.freshie.farm/wp-content/uploads/2021/04/freshie-farm.png" alt="" style="padding:24px">

                <div class="card-body">
                  <h4 class="card-title text-uppercase" style="line-height: 34px">Booking Code <br> <b class="text-danger"> {{ $booking->code }}</b></h4>
                  <h4 class="card-text text-uppercase" style="line-height: 34px">Total Investment <br><b class="text-success"> {{ $booking->value*$booking->booking_quantity }}</b></h4>
                  <h4 class="card-text text-uppercase" style="line-height: 34px">Total Profit <br> <b class="text-success"> {{ $booking->profit_value*$booking->booking_quantity }}</b></h4>

                  @if($booking->closing_status=='initiated')
                  <div class="d-grid gap-2 mt-4">
                        <a href="{{ url('/mature-batches/request/') }}/{{ $booking->code }}/withdrawal/" class="btn btn-success">Re-Invest & Withdrawal</a>
                  </div>
                      
                          
                    
                @endif

                </div>

              </div>

            </div>
            @endif
            @endforeach

        </div>
      </div>
  </div>
</div>











@endsection

