@extends('layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header flex flex-row justify-between">
        <div> My Profile</div>
        <div>
            <a href="{{ url('profile/edit') }}" class="btn btn-sm btn-primary">Edit Profile</a>
            <a href="{{ url('/profile/change_password') }}" class="btn btn-sm btn-primary">Change Password</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Information</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user_data as $data)
                <tr>
                    <th scope="row">Name</th>
                    <td>{{ $data->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>{{ $data->email }}</td>
                </tr>
                <tr>
                    <th scope="row">Phone</th>
                    <td>{{ $data->phone }}</td>
                </tr>
                <tr>
                    <th scope="row">Present Address</th>
                    <td>{{ $data->present_address }}</td>
                </tr>
                <tr>
                    <th scope="row">Permanent Address</th>
                    <td>{{ $data->permanent_address }}</td>
                </tr>
                <tr>
                    <th scope="row">Father Name</th>
                    <td>{{ $data->father_name }}</td>
                </tr>
                <tr>
                    <th scope="row">Mother Name</th>
                    <td>{{ $data->mother_name }}</td>
                </tr>
                <tr>
                    <th scope="row">National ID</th>
                    <td>{{ $data->nid }}</td>
                </tr>
                <tr>
                    <th scope="row">Date of Birth</th>
                    <td>{{ $data->date_of_birth }}</td>
                </tr>
                <tr>
                    <th scope="row">Nominee Name</th>
                    <td>{{ $data->nominee_name }}</td>
                </tr>
                <tr>
                    <th scope="row">Nominee Phone</th>
                    <td>{{ $data->nominee_phone }}</td>
                </tr>
                <tr>
                    <th scope="row">Nominee Address</th>
                    <td>{{ $data->nominee_address }}</td>
                </tr>
                <tr>
                    <th scope="row">Nominee Relation</th>
                    <td>{{ $data->nominee_relation }}</td>
                </tr>
                <tr>
                    <th scope="row">Nominee NID</th>
                    <td>{{ $data->nominee_nid }}</td>
                </tr>
                <tr>
                    <th scope="row">Registered Since</th>
                    <td>{{ $data->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection