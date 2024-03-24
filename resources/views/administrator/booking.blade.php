@extends('administrator.layouts.application')

@section('content')
<div class="">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="flex flex-col sm:flex-row sm:items-center gap-2 p-4 bg-white shadow-md rounded-lg">
            <input type="text" id="search" name="search" placeholder="Search" value="{{ request()->search }}" class="block w-full sm:w-auto flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <button onclick="updateFilter()" class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md">Search</button>
            <select name="package" id="package" onchange="updateFilter()" class="block w-full sm:w-auto flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">All</option>
              @foreach ($packagesData as $package)
              <option value="{{ $package->id }}" {{ request()->package == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
              @endforeach
            </select>
            <select name="status" id="status" onchange="updateFilter()" class="block w-full sm:w-auto flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">All</option>
              @foreach ($distinctStatus as $status)
              <option value="{{ $status->status }}" {{ request()->status == $status->status ? 'selected' : '' }}>{{ $status->status }}</option>
              @endforeach
            </select>
          </div>

        </div>
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
                <th scope="col">Code</th>
                <th scope="col">Package Name</th>
                <th scope="col">Investor</th>
                <th scope="col">Booking Quantity</th>
                <th scope="col">Total Value</th>
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
                <td>{{ $booking->package_name }}</td>
                <td>{{ $booking->user_name }}
                  <br>
                  <small>{{ $booking->user_email }}</small>
                  <br>
                  <small>{{ $booking->user_phone }}</small>
                </td>
                <td>{{ $booking->booking_quantity }}</td>
                <td>{{ $booking->total_value }}</td>
                <td>{{ $booking->status }}</td>
                <td>{{ $booking->note }}</td>
                <td></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="flex flex-row">
          <div class="grow">{{ $bookings->links() }}</div>
          <div class="flex items-center space-x-2 px-2">
            <span class="text-[#9CA3AF]">Limit: </span>
            <div>
              <select name="dataSize" onchange="updateFilter()" id="dataSizeForm">
                <option value="10" {{ request()->dataSize == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request()->dataSize == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request()->dataSize == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request()->dataSize == 100 ? 'selected' : '' }}>100</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function updateFilter() {
      let status = document.getElementById('status').value;
      let dataSize = document.getElementById('dataSizeForm').value;
      let package = document.getElementById('package').value;
      let search = document.getElementById('search').value;
      let url = new URL(window.location.href);
      url.searchParams.set('status', status);
      url.searchParams.set('dataSize', dataSize);
      url.searchParams.set('package', package);
      url.searchParams.set('search', search);
      window.location.href = url.toString();
    }
  </script>
</div>
@endsection