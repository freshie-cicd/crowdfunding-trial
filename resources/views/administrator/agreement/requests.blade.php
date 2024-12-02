@extends('administrator.layouts.application')

@section('content')
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
        openModal(id, givenStatus, name) {
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
                            <option x-text="status" x-bind:value="status" x-bind:selected="status == givenStatus">
                            </option>
                        </template>
                    </select>
                </div>
                <!-- close button and update button -->
                <div class="flex flex-row gap-4 mt-4">
                    <button @click="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded-md">Close</button>
                    <button @click="updateStatus(agreementId, document.getElementById('status').value)"
                        class="bg-green-500 text-white px-4 py-2 rounded-md">Update</button>
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
                            <div class="filter-row">
                                <div class="filter-group">
                                    <form method="GET" action="{{ route('admin.agreement.requests') }}"
                                        class="d-flex gap-2">
                                        @if (request('sort_by'))
                                            <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                            <input type="hidden" name="sort_direction"
                                                value="{{ request('sort_direction') }}">
                                        @endif

                                        <select name="status" class="form-control form-control-sm"
                                            onchange="this.form.submit()">
                                            <option value="">All Statuses</option>
                                            <option value="requested"
                                                {{ request('status') == 'requested' ? 'selected' : '' }}>Requested</option>
                                            <option value="processing"
                                                {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                                            </option>
                                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>
                                                Shipped</option>
                                            <option value="delivered"
                                                {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="hold" {{ request('status') == 'hold' ? 'selected' : '' }}>Hold
                                            </option>
                                            <option value="rejected"
                                                {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>

                                        <input type="text" name="search" class="form-control form-control-sm search-box"
                                            placeholder="Search by name, phone, booking code, package"
                                            value="{{ request('search') }}">

                                        <select name="per_page" class="form-control form-control-sm"
                                            onchange="this.form.submit()">
                                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10
                                                per page</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per
                                                page</option>
                                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                                per page</option>
                                        </select>

                                        <button type="submit" class="btn btn-sm btn-primary"
                                            aria-label="Perform search">Search</button>
                                        @if (request('search') || request('status') || request('per_page') != 10)
                                            <a href="{{ request()->fullUrlWithQuery(['search' => null, 'status' => null, 'per_page' => request()->per_page]) }}"
                                                class="btn btn-sm btn-secondary">
                                                Reset
                                            </a>
                                        @endif
                                    </form>
                                </div>
                            </div>

                            <div class="table-container mt-4">
                                <table class="table table-striped table-bordered table-hover table-responsive">
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
                                            {{-- @dd($data->booking->user->name) --}}
                                            <tr>
                                                <th scope="row">{{ @$data->booking->user->name }}</th>
                                                <th scope="row">{{ $data->booking_code }}</th>
                                                <th scope="row">{{ @$data->booking->package->name }}</th>
                                                <th scope="row">{{ $data->shipping_address }}</th>
                                                <th scope="row">{{ $data->courier_service }}</th>
                                                <th scope="row">{{ $data->courier_branch }}</th>
                                                <th scope="row">{{ $data->phone }}</th>
                                                <td scope="row">{{ $data->note }}</td>
                                                <td scope="row">{{ $data->status }}</td>
                                                <td scope="row">{{ $data->created_at }}</td>
                                                <td scope="row">
                                                    <div class="flex flex-row gap-2">
                                                        <a href="{{ route('admin.agreement.download', $data->booking_code) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <button
                                                            @click="openModal({{ $data->id }}, '{{ $data->status }}', '{{ $data->name }}')"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="mt-4">
                                    {{ $agreementRequests->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
