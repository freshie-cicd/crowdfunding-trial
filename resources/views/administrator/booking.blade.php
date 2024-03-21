@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Assets') }} <a href="#" class="btn btn-sm btn-success float-end">Add New</a></div>

                @if (\Session::has('success'))
                    <div class="alert alert-success">
                            {!! \Session::get('success') !!}
                    </div>
                @endif

                <div class="card-body">

                    <table class="table table-striped table-bordered table-hover table-responsive">
                      <thead class="thead-dark" style="background:#222;color:#fff">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Package Name</th>
                          <th scope="col">Asset Name</th>
                          <th scope="col">Description</th>
                          <th scope="col">Purchase Price</th>
                          <th scope="col">Color</th>
                          <th scope="col">Shade Location</th>
                          <th scope="col">Asset Code/QR</th>
                          <th scope="col">Status</th>
                          <th scope="col">Note</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($bookings as $booking)

                        <tr>
                          <th scope="row">{{ $booking->id }}</th>
                          <td>{{ $booking->code }}</td>
                          <td>{{ $booking->name }}</td>
                          <td>{{ $booking->description }}</td>
                          <td>{{ $booking->purchase_price }}</td>
                          <td>{{ $booking->color }}</td>
                          <td>{{ $booking->location }}</td>
                          <td>{{ $booking->booking_code }}</td>
                          <td>{{ $booking->status }}</td>
                          <td>{{ $booking->note }}</td>
                          <td>
                            
                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/booking/approve/' . $booking->id ) }}">Approve</a>

                          </td>
                        </tr>

                      @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
