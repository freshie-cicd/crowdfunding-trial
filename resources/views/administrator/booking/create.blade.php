@extends('administrator.layouts.application')
@section('content')

<div x-data="{ 
    statuses: {{ json_encode($statuesArray) }},
    status: 'pending',
    packages: {{ json_encode($packages) }},
    package_id: null,
    booking_quantity: 1,
    total: 0,
    }" x-init="    

    if (packages.length > 0) {
        package_id = packages[0].id;
        total = packages[0].value;
    }

    $watch('package_id', value => {
        let selectedPackage = packages.find(item => item.id == value);
        if (selectedPackage && booking_quantity) {
            total = selectedPackage.value * booking_quantity;
        }
    });
    $watch('booking_quantity', value => {
        let selectedPackage = packages.find(item => item.id == package_id);        
        if (selectedPackage && value) {
            total = selectedPackage.value * value;
        }
    });">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('administrator.booking.store') }}" method="POST">
        @method('POST')
        @csrf
        <div class="flex flex-row mt-5">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <div class="form-group">
                            <label for="package_id">Package</label>
                            <select id="package_id" type="text" class="form-select form-control" placeholder="" name="package_id" x-model="package_id">
                                <template x-for="item in packages">
                                    <option x-bind:value="item.id" x-text="item.name"></option>
                                </template>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="booking_quantity" class="block mb-2 text-sm font-medium text-gray-900">Package quantity:</label>
                            <div class="relative flex items-center max-w-[11rem]">
                                <button type="button" id="decrement-button" data-input-counter-decrement="booking_quantity" class="bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" @click=" booking_quantity >=2 ? booking_quantity = parseInt(booking_quantity) - 1: 0">
                                    <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                    </svg>
                                </button>
                                <input type="text" id="booking_quantity" data-input-counter data-input-counter-min="1" data-input-counter-max="10" aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 font-medium text-center text-sm focus:ring-blue-500 focus:border-blue-500 block w-full pb-6 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required x-model="booking_quantity" name="booking_quantity">
                                <div class=" absolute bottom-1 start-1/2 -translate-x-1/2 rtl:translate-x-1/2 flex items-center text-xs space-x-1 rtl:space-x-reverse">
                                    <svg class="w-4 h-4 text-gray-400" aria-hidden="true" fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M22,9H13V6a3,3,0,0,1,3-3,1,1,0,0,0,0-2,4.993,4.993,0,0,0-4.495,2.851,6.328,6.328,0,0,0-8.02-.708,1,1,0,0,0-.414,1.228,6.179,6.179,0,0,0,3.32,3.218,5.785,5.785,0,0,0,2.07.372A7.889,7.889,0,0,0,11,7.491V9H2a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1H22a1,1,0,0,0,1-1V10A1,1,0,0,0,22,9ZM7.123,5.728A3.914,3.914,0,0,1,5.4,4.409,4.332,4.332,0,0,1,10.421,5.59,4.809,4.809,0,0,1,7.123,5.728ZM21,19.184A2.987,2.987,0,0,0,19.184,21H4.816A2.987,2.987,0,0,0,3,19.184V12.816A2.987,2.987,0,0,0,4.816,11H19.184A2.987,2.987,0,0,0,21,12.816ZM14,16a2,2,0,1,1-2-2A2,2,0,0,1,14,16Z"></path>
                                        </g>
                                    </svg>
                                    <span>Qty</span>
                                </div>
                                <button type="button" id="increment-button" data-input-counter-increment="booking_quantity" class="bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none" @click="booking_quantity < 10 ? booking_quantity = parseInt(booking_quantity) + 1: 0">
                                    <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="total" x-model="total" readonly>
                        </div>
                        <input type="hidden" name="investor_id" value="{{ $investor_id }}">
                        <div class="form-group mt-2">
                            <label for="note">Note</label>
                            <input type="text" class="form-control" name="note" id="note" value="{{ old('note') }}">
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
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

@endsection