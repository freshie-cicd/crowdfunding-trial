@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Batches') }} <a href="{{ route('batch.create') }}" class="btn btn-sm btn-success float-end">Add New</a></div>

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
                          <th scope="col">Batch Name</th>
                          <th scope="col">Description</th>
                          <th scope="col">Code</th>
                          <th scope="col">Cover</th>
                          <th scope="col">Status</th>
                          <th scope="col">Ending Date</th>
                          <th scope="col">Note</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($batches as $batch)

                        <tr>
                          <th scope="row">{{ $batch->id }}</th>
                          <th scope="row">{{ $batch->project_id }}</th>
                          <td>{{ $batch->name }}</td>
                          <td>{{ $batch->description }}</td>
                          <td>{{ $batch->code }}</td>
                          <td>{{ $batch->cover }}</td>
                          <td>{{ $batch->status }}</td>
                          <td>{{ $batch->ending_date }}</td>
                          <td>{{ $batch->note }}</td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('/administrator/batch/edit/' . $batch->id ) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/batch/delete/' . $batch->id ) }}">Delete</a>

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
