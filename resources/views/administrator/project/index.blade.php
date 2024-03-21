@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Project') }} <a href="{{ route('project.create') }}" class="btn btn-sm btn-success float-end">Add New</a></div>

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
                          <th scope="col">Project Name</th>
                          <th scope="col">Description</th>
                          <th scope="col">Code</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($projects as $project)

                        <tr>
                          <th scope="row">{{ $project->id }}</th>
                          <td>{{ $project->name }}</td>
                          <td>{{ $project->description }}</td>
                          <td>{{ $project->code }}</td>
                          <td>{{ $project->status }}</td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('/administrator/project/edit/' . $project->id ) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/project/delete/' . $project->id ) }}">Delete</a>

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
