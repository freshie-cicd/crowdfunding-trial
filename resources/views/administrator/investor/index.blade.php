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

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">{{ __('Users') }} </div>



                @if (\Session::has('success'))

                <div class="alert alert-success">

                    {!! \Session::get('success') !!}

                </div>

                @endif



                <div class="card-body">



                    <table id="dataTable" class="table table-striped table-bordered table-hover table-responsive">
                        <thead class="thead-dark" style="background:#222;color:#fff">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Investor Name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Address</th>
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
                                <td>{{ $data->date_of_birth }}</td>
                                <td>@if($data->is_active){{ __('Active') }} @endif</td>
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
                                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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