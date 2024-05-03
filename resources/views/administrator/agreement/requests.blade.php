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

<script>
  function updateStatus(id, status) {
    fetch(`{{ route('admin.agreement.status-update') }}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        id: id,
        status: status
      })
    }).then(response => {
      if (response.ok) {
        return response.json();
      }
      throw new Error('Network response was not ok.');
    }).then(data => {
      console.log(data);
      if (data.status) {
        alert('Status updated successfully');
        location.reload();
      } else {
        alert('Failed to update status');
      }
    }).catch(error => {
      console.error('There has been a problem with your fetch operation:', error);
    });

  }
</script>

<div x-data="{ 
  modal: false,
  agreementId: null,
  givenStatus: null,
  name: null,
  openModal(id,givenStatus,name) {
    this.agreementId = id;
    this.modal = true;
    this.givenStatus = givenStatus;
    this.name = name;
  },
  closeModal() {
    this.modal = false;
    this.agreementId = null;
    this.givenStatus = null;
    this.name = null;
  },
  statuses: {{ json_encode($statuesArray) }},
 }">

  <div class="fixed top-1/2 left-1/2 z-10 bg-white p-8 min-w-80 rounded-md shadow-2xl" x-cloak x-show="modal">
    <!-- close button -->
    <div class="absolute right-5 top-2">
      <button @click="closeModal()" class="text-2xl">&times;</button>
    </div>
    <div>Name: <span x-text="name"></span></div>
    <div class="flex flex-col gap-4 mt-4">
      <div class="flex flex-row gap-4">
        <div>Status:</div>
        <select class="w-full" name="status" id="status">
          <template x-for="status in statuses">
            <option x-text="status" x-bind:value="status" x-bind:selected="status == givenStatus"></option>
          </template>
        </select>
      </div>
      <!-- close button and update button -->
      <div class="flex flex-row gap-4 mt-4">
        <button @click="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded-md">Close</button>
        <button @click="updateStatus(agreementId, document.getElementById('status').value)" class="bg-green-500 text-white px-4 py-2 rounded-md">Update</button>
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

                @foreach ($agreementRequests as $data)
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
                      <button @click="openModal({{ $data->id }}, '{{ $data->status }}', '{{ $data->name }}')" class="btn btn-sm btn-primary">Update Status</button>
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
</div>

<script>
  const date = new Date();
  let day = date.getDate();
  let month = date.getMonth() + 1;
  let year = date.getFullYear();
  let currentDate = `${day}-${month}-${year}`;

  new DataTable('#dataTable', {
    dom: 'Bfrtip',
    buttons: [{
      extend: 'excelHtml5',
      title: 'Freshie_' + currentDate,
      footer: true
    }, ],
    "pageLength": 20,
  });
</script>

@endsection