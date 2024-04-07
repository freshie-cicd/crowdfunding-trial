@extends('administrator.layouts.application')
@section('content')

<div x-data="{ 
    statuses: {{ json_encode($statuesArray) }},
    status: '{{ $booking->status }}',
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
    <form action="{{ route('administrator.booking.update', $booking->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="flex flex-row mt-5">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <div class="flex flex-row justify-between">
                            <h1 class="text-2xl font-semibold">Booking Details</h1>
                            <h3 class="text-2xl font-semibold">Booking Code #{{ $booking->code }}</h3>
                        </div>
                        <div class="flex mt-2">
                            <div class="form-group mr-2">
                                <label for="booking_quantity">Package Quantity</label>
                                <input type="number" class="form-control" id="booking_quantity" name="booking_quantity" value="{{ old('booking_quantity', $booking->booking_quantity) }}">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" name="note" id="note" value="{{ old('note', $booking->note) }}">
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
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection