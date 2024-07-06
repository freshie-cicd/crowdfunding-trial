@extends('administrator.layouts.application')

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

@section('content')

<div class="">

    <div class="container">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}
        </div>
        @endif
    </div>



    <div class="row">



        <div class="col-md-3 float-end">
            <div class="btn-group mb-2">
                <a href="{{ url('administrator/investor/profiles') }}" type="button" class="{{  Request::get('status') == '' ? 'btn btn-dark' : 'btn btn-outline-dark' }}">All</a>
                <a href="{{ url('administrator/investor/profiles') }}?status=active" type="button" class="{{  Request::get('status') == 'active' ? 'btn btn-dark' : 'btn btn-outline-dark' }}">Active</a>
                <a href="{{ url('administrator/investor/profiles') }}?status=verification_pending" type="button" class="{{  Request::get('status') == 'verification_pending' ? 'btn btn-dark' : 'btn btn-outline-dark' }}">Pending Verification</a>
                <a href="{{ url('administrator/investor/profiles') }}?status=blocked" type="button" class="{{  Request::get('status') == 'blocked' ? 'btn btn-dark' : 'btn btn-outline-dark' }}">Blocked</a>
              </div>
        </div>
        <div class="col-md-12">

            <div class="card">

                <div class="card-header">{{ __('Users') }} </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-striped table-bordered table-hover table-responsive">

                        <thead class="thead-dark" style="background:#222;color:#fff">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Investor Name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">NID</th>
                                <th scope="col">Status</th>
                                <th scope="col">Member Since</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $data)
                            <tr>
                                <td scope="row">{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->phone }} <br />
                                    {{ $data->email }}
                                </td>
                                <td>{{ $data->nid }}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    <div class="flex flex-row">
                                        <a href="{{ route('administrator.investor.profile.show', $data->id) }}" class="">
                                            <svg class="w-8 h-8 mr-2" viewBox="0 -4 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g id="Dribbble-Light-Preview" transform="translate(-260.000000, -4563.000000)" fill="#000000">
                                                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                                                <path d="M216,4409.00052 C216,4410.14768 215.105,4411.07682 214,4411.07682 C212.895,4411.07682 212,4410.14768 212,4409.00052 C212,4407.85336 212.895,4406.92421 214,4406.92421 C215.105,4406.92421 216,4407.85336 216,4409.00052 M214,4412.9237 C211.011,4412.9237 208.195,4411.44744 206.399,4409.00052 C208.195,4406.55359 211.011,4405.0763 214,4405.0763 C216.989,4405.0763 219.805,4406.55359 221.601,4409.00052 C219.805,4411.44744 216.989,4412.9237 214,4412.9237 M214,4403 C209.724,4403 205.999,4405.41682 204,4409.00052 C205.999,4412.58422 209.724,4415 214,4415 C218.276,4415 222.001,4412.58422 224,4409.00052 C222.001,4405.41682 218.276,4403 214,4403" id="view_simple-[#815]"> </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </a>
                                        <a href="{{ url('administrator/investor/change_password') }}/{{ $data->id }}" class="">
                                            <svg class="w-8 h-8 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path d="M12 10V14M10.2676 11L13.7317 13M13.7314 11L10.2673 13" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M6.73241 10V14M4.99999 11L8.46409 13M8.46386 11L4.99976 13" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M17.2681 10V14M15.5356 11L18.9997 13M18.9995 11L15.5354 13" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path d="M22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C21.4816 5.82475 21.7706 6.69989 21.8985 8" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                                                </g>
                                            </svg>
                                        </a>
                                        @if($data->status == "blocked")
                                        <a href="{{ route('investor.unblock', $data->id) }}">
                                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.63604 18.364C9.15076 21.8787 14.8492 21.8787 18.364 18.364C21.8787 14.8492 21.8787 9.15076 18.364 5.63604C14.8492 2.12132 9.15076 2.12132 5.63604 5.63604C2.12132 9.15076 2.12132 14.8492 5.63604 18.364ZM7.80749 17.6067C10.5493 19.6623 14.4562 19.4433 16.9497 16.9497C19.4433 14.4562 19.6623 10.5493 17.6067 7.80749L14.8284 10.5858C14.4379 10.9763 13.8047 10.9763 13.4142 10.5858C13.0237 10.1953 13.0237 9.5621 13.4142 9.17157L16.1925 6.39327C13.4507 4.33767 9.54384 4.55666 7.05025 7.05025C4.55666 9.54384 4.33767 13.4507 6.39327 16.1925L9.17157 13.4142C9.5621 13.0237 10.1953 13.0237 10.5858 13.4142C10.9763 13.8047 10.9763 14.4379 10.5858 14.8284L7.80749 17.6067Z" fill="green"></path> </g></svg>
                                        </a>
                                        @else
                                        <a href="{{ route('investor.block', $data->id) }}">
                                            <svg class="w-8 h-8" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#c51313;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><circle class="cls-1" cx="12" cy="12" r="10.5"></circle><line class="cls-1" x1="19.64" y1="4.36" x2="4.36" y2="19.64"></line></g></svg>
                                        </a>
                                        @endif
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
        buttons: [{
            extend: 'excelHtml5',
            title: 'Freshie_' + currentDate,
            footer: true
        }, ],

        "pageLength": 20,
    });
</script>

@endsection
