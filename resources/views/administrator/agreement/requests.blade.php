@extends('administrator.layouts.application')

@section('content')

<style>
  #dataTable_filter {
    float: right;
  }

  .form-control-sm {
    min-height: calc(1.6em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.7875rem;
    border-radius: 0.2rem;
    float: right;
    width: 240px !important;
    margin-left: 6px;
  }
</style>

<div class="fixed top-1/2 left-1/2 z-10 hidden">
  <div class="bg-white p-8 min-w-80 min-h-52 rounded-md shadow-2xl">
    <div class="flex flex-row gap-4">
      <div>Status:</div>
      <select class="w-full" name="status" id="status">
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
      </select>
    </div>
  </div>
</div>

<div>
  <div class="row justify-content-center">
    <div class="col-md-12">

      <div class="card">

        <div class="card-header">{{ __('Agreement Paper Requests') }} </div>



        @if (\Session::has('success'))

        <div class="alert alert-success">

          {!! \Session::get('success') !!}

        </div>

        @endif



        <div class="card-body">



          <table id="dataTable" class="table table-striped table-bordered table-hover table-responsive">
            <thead class="thead-dark" style="background:#222;color:#fff">
              <tr>
                <th scope="col">Investor Name</th>
                <th scope="col">Booking Code</th>
                <th scope="col">Package</th>
                <th scope="col">Shipping Address</th>
                <th scope="col">Courier Service</th>
                <th scope="col">Courier Branch</th>
                <th scope="col">Phone</th>
                <th scope="col">Note</th>
                <th scope="col">Status</th>
                <th scope="col">Request Date</th>
                <th scope="col">#</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($dataX as $data)
              <tr>
                <th scope="row">{{ $data->name }}</th>
                <th scope="row">{{ $data->booking_code }}</th>
                <th scope="row">{{ $data->package_name }}</th>
                <th scope="row">{{ $data->shipping_address }}</th>
                <th scope="row">{{ $data->courier_service }}</th>
                <th scope="row">{{ $data->courier_branch }}</th>
                <th scope="row">{{ $data->phone }}</th>
                <td scope="row">{{ $data->note }}</td>
                <td scope="row">{{ $data->status }}</td>
                <td scope="row">{{ $data->created_at }}</td>
                <td scope="row">
                  <div class="flex flex-row gap-2">
                    <a href="{{ route('admin.agreement.download', $data->booking_code) }}" class="btn btn-sm btn-primary">Download</a>
                    <button class="btn btn-sm btn-primary">Change Status</a>
                  </div>
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











<script>
  const date = new Date();



  let day = date.getDate();

  let month = date.getMonth() + 1;

  let year = date.getFullYear();



  let currentDate = `${day}-${month}-${year}`;







  new DataTable('#dataTable', {

    dom: 'Bfrtip',

    buttons: [

      {

        extend: 'excelHtml5',

        title: 'Freshie_' + currentDate,

        footer: true

      },

    ],



    "pageLength": 20,

  });
</script>



@endsection