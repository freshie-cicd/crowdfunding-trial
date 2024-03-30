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

                                <th scope="col">Phone</th>

                                <th scope="col">Email</th>

                                <th scope="col">Address</th>

                                <th scope="col">Fathers Name</th>

                                <th scope="col">Mothers Name</th>

                                <th scope="col">NID</th>

                                <th scope="col">Date of Birth</th>

                                <th scope="col">Nominee Name</th>

                                <th scope="col">Nominee Relation</th>

                                <th scope="col">Status</th>

                                <th scope="col">Member Since</th>

                                <th scope="col">#</th>



                            </tr>

                        </thead>

                        <tbody>



                            @foreach($users as $data)



                            <tr>

                                <th scope="row">{{ $data->id }}</th>

                                <td><a href="javascript:void(0)" id="show-user" data-id="{{ $data->id }}" data-url="{{ route('admin.booking.modal_info', $data->id) }}">{{ $data->name }}</a></td>

                                <td>{{ $data->phone }}</td>

                                <td>{{ $data->email }}</td>

                                <td>{{ $data->present_address }}</td>

                                <td>{{ $data->father_name }}</td>

                                <td>{{ $data->mother_name }}</td>

                                <td>{{ $data->nid }}</td>

                                <td>{{ $data->date_of_birth }}</td>

                                <td>{{ $data->nominee_name }}</td>

                                <td>{{ $data->nominee_relatiom }}</td>

                                <td>@if($data->is_active){{ __('Active') }} @endif</td>

                                <td>{{ $data->created_at }}</td>

                                <td> <a href="{{ url('administrator/investor/change_password') }}/{{ $data->id }}" class="btn btn-primary">Change Passowrd</a></td>

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