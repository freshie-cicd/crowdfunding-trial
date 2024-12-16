<div class="col-md-4 m-1 w-72">
    <div class="card">
        <img src="{{ asset('storage/' . config('website-setting.dark_logo')) }}" alt="" style="padding:24px">
        <div class="card-body">
            <div class="flex justify-between">
                <h5 class="card-title">Booking Code: </h5>
                <b class="text-danger"> {{ $booking->code }}</b>
            </div>
            <div class="flex justify-between">
                <p class="card-text">Package Name: </p>
                <b> {{ $booking->package_name }}</b>
            </div>
            <div class="flex justify-between">
                <p class="card-text">Booking Quantity: </p>
                <b> {{ $booking->booking_quantity }}</b>
            </div>
            <div class="flex justify-between">
                <p class="card-text">Purchase Price: </p>
                <b> {{ $booking->value * $booking->booking_quantity }}</b>
            </div>
            <div class="flex justify-between">
                <p class="card-text">Status: </p>
                <b> {{ $booking->status }}</b>
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('administrator.booking.show', $booking->id) }}" class="btn btn-primary"
                    target="__blank">View Details</a>
            </div>
        </div>
    </div>
</div>
