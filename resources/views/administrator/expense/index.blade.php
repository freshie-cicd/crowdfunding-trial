@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Expenses') }} <a href="{{ route('expense.create') }}" class="btn btn-sm btn-success float-end">Add New</a></div>

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
                      @foreach ($expenses as $expense)

                        <tr>
                          <th scope="row">{{ $expense->id }}</th>
                          <td>{{ $expense->name }}</td>
                          <td>{{ $expense->description }}</td>
                          <td>{{ $expense->code }}</td>
                          <td>{{ $expense->status }}</td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('/administrator/expense/edit/' . $expense->id ) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/expense/delete/' . $expense->id ) }}">Delete</a>

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
