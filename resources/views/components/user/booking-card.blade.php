<div class="col-md-4 m-1 w-72">
    <div class="card">
        <img src="{{ asset('storage/' . config('website-setting.dark_logo')) }}" alt="" style="padding:24px">
        <div class="card-body">
            <div>
                <h4 class="card-title text-uppercase" style="line-height: 34px">Booking Code <br> <b class="text-danger">
                        {{ $booking->code }}</b></h4>
            </div>
            <div class="flex justify-between">
                <p class="card-text">Package Name: <b> {{ $booking->package_name }}</b></p>

            </div>
            <div class="flex justify-between">
                <p class="card-text">Booking Quantity: <b> {{ $booking->booking_quantity }}</b></p>

            </div>
            <div class="flex justify-between">
                <p class="card-text">Purchase Price: <b> {{ $booking->value * $booking->booking_quantity }} </b></p>
            </div>

            @if ($booking->maturity)
                <div class="flex justify-between">
                    <p class="card-text text-success">Total Profit: <b>
                            {{ $booking->return_amount * $booking->booking_quantity }} </b></p>
                </div>
            @endif

            <div class="flex justify-between">
                <p class="card-text">Status: <b> {{ $booking->status }}</b></p>
            </div>

            @if ($booking->status == 'pending')

                @if ($checkPendingApproval == 1)
                    <div class="d-grid gap 2">
                        <button type="button" class="btn btn-warning" disabled>Wait until admin approve your other
                            Pending Approval Investment</button>
                    </div>
                @else
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#instructionModal"> Instruction</button>
                        <a href="{{ url('payment-proof') }}/{{ $booking->id }}/submit/" class="btn btn-primary">Submit
                            Payment Proof</a>
                    </div>
                @endif
            @elseif($booking->status == 'approved')
                @if ($booking->maturity)

                    @if ($booking->closing_id)
                        <div class="d-grid gap-2 mt-4"
                            style="color: white; background: #017b46; display: grid; gap: 10px; margin-top: 1.5rem;border:1px solid grey;padding:8px; border-radius: 10px;">
                            <div class="card-text" style="font-size: 1rem;">You Requested</div>
                            <div class="card-text" style="font-size: 1rem;">Withdrawal: <b
                                    style="font-weight: bold;">{{ $booking->withdraw }}</b></div>
                            <div class="card-text" style="font-size: 1rem;">Re-Invest: <b
                                    style="font-weight: bold;">{{ $booking->reinvest }}</b></div>
                            <div class="card-text" style="font-size: 1rem;">Profit: <b
                                    style="font-weight: bold;">{{ $booking->total_profit }}</b></div>
                        </div>
                    @else
                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ url('/mature-batches/request/') }}/{{ $booking->code }}/withdrawal/"
                                class="btn btn-success">Re-Invest Or Withdrawal</a>
                        </div>
                    @endif
                @else
                    <div class="d-grid gap-2">
                        <a href="{{ @$booking->fb_group_url }}" class="btn btn-primary" target="__blank"><i
                                class="fa-brands fa-facebook"></i> JOIN FACEBOOK GROUP</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="instructionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Payment Instruction</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! $booking->package_instructions !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
