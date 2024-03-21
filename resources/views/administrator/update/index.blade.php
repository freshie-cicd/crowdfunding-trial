@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Updates') }} <a href="{{ route('update.create') }}" class="btn btn-sm btn-success float-end">Add New</a></div>

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
                          <th scope="col">expense Name</th>
                          <th scope="col">Description</th>
                          <th scope="col">Code</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($updates as $update)

                        <tr>
                          <th scope="row">{{ $update->id }}</th>
                          <td>{{ $update->name }}</td>
                          <td>{{ $update->description }}</td>
                          <td>{{ $update->code }}</td>
                          <td>{{ $update->status }}</td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('/administrator/update/edit/' . $update->id ) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/update/delete/' . $update->id ) }}">Delete</a>

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
