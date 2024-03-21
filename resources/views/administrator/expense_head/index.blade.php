@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Expense Heads') }} <a href="{{ route('expense_head.create') }}" class="btn btn-sm btn-success float-end">Add New</a></div>

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
                          <th scope="col">Parent</th>
                          <th scope="col">Name</th>
                          <th scope="col">Status</th>
                          <th scope="col">Note</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($expenseheads as $head)

                        <tr>
                          <th scope="row">{{ $head->id }}</th>
                          <td>{{ $head->parent }}</td>
                          <td>{{ $head->name }}</td>
                          <td>{{ $head->status }}</td>
                          <td>{{ $head->note }}</td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('/administrator/expense-head/edit/' . $head->id ) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/expense-head/delete/' . $head->id ) }}">Delete</a>

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
