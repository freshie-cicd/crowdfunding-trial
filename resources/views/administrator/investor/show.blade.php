@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="flex flex-row">
        <div class="grow">
            <h1 class="text-2xl font-semibold"></h1>
        </div>
        <div class="flex items-center space-x-2 px-2">
            <a href="{{ route('admin.investor.profile') }}" class="btn btn-primary">Back</a>
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
                        <div class="flex flex-row justify-between">
                            <h1 class="text-2xl font-semibold">Investor Details</h1>

                        </div>
                        <div class="form-group">
                            <label for="code">Name</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="flex flex-row justify-between">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" readonly>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between">
                            <div class="form-group">
                                <label for="nid">NID</label>
                                <input type="text" class="form-control" id="nid" name="nid" value="{{ $user->nid }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address">Permanent Address</label>
                            <input type="text" class="form-control" id="permanent_address" name="permanent_address" value="{{ $user->permanent_address }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="present_address">Present Address</label>
                            <input type="text" class="form-control" id="present_address" name="present_address" value="{{ $user->present_address }}" readonly>
                        </div>

                        <div class="flex flex-row justify-between">
                            <div class="form-group">
                                <label for="father_name">Father Name</label>
                                <input type="text" class="form-control" id="father_name" name="father_name" value="{{ $user->father_name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mother_name">Mother Name</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{ $user->mother_name }}" readonly>
                            </div>
                        </div>

                        <div class="flex flex-row justify-between">
                            <div class="form-group">
                                <label for="nominee_name">Nominee Name</label>
                                <input type="text" class="form-control" id="nominee_name" name="nominee_name" value="{{ $user->nominee_name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nominee_relation">Nominee Relation</label>
                                <input type="text" class="form-control" id="nominee_relation" name="nominee_relation" value="{{ $user->nominee_relation }}" readonly>
                            </div>
                        </div>

                        <div class="flex flex-row justify-between">
                            <div class="form-group">
                                <label for="nominee_phone">Nominee Phone</label>
                                <input type="text" class="form-control" id="nominee_phone" name="nominee_phone" value="{{ $user->nominee_phone }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nominee_nid">Nominee NID</label>
                                <input type="text" class="form-control" id="nominee_nid" name="nominee_nid" value="{{ $user->nominee_nid }}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nominee_address">Nominee Address</label>
                            <input type="text" class="form-control" id="nominee_address" name="nominee_address" value="{{ $user->nominee_address }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <input type="text" class="form-control" id="is_active" name="is_active" value="{{ $user->is_active ? 'Active' : 'Inactive' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Member Since</label>
                            <input type="text" class="form-control" id="created_at" name="created_at" value="{{ $user->created_at }}" readonly>
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

        <div class="col-span-2 mt-2">
            <div class="grow p-4 bg-white shadow-md rounded-md">
                <div class="flex flex-row">
                    <div class="grow">
                        <h1 class="text-2xl font-semibold">Bookings</h1>
                    </div>
                    <div class="flex items-center space-x-2 px-2">
                        <a href="{{ route('administrator.booking.create', ['investor_id' => $user->id]) }}" class="btn btn-danger">Create Booking</a>
                    </div>
                </div>

                <div class="flex flex-row flex-wrap">
                    @foreach($bookings as $booking)
                    @include('components.admin.booking-card', ['booking' => $booking])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection