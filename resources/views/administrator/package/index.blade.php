@extends('administrator.layouts.application')



@section('content')

<div class="">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">{{ __('All Packages') }} <a href="{{ route('package.create') }}" class="btn btn-sm btn-success float-end">Add New</a></div>



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

                          <th scope="col">Package Name</th>

                          <th scope="col">Description</th>

                          <th scope="col">Code</th>

                          <th scope="col">Status</th>

                          <th scope="col">Action</th>

                        </tr>

                      </thead>

                      <tbody>

                      @foreach ($packages as $package)



                        <tr>

                          <th scope="row">{{ $package->id }}</th>

                          <td>{{ $package->name }}</td>

                          <td>{{ $package->description }}</td>

                          <td>{{ $package->code }}</td>

                          <td>{{ $package->status }}</td>

                          <td>

                            <a class="btn btn-primary btn-sm" href="{{ url('/administrator/package/edit/' . $package->id ) }}">Edit</a>

                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/package/delete/' . $package->id ) }}">Delete</a>



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
