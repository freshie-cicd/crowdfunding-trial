@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All Assets') }} <a href="{{ route('asset.create') }}" class="btn btn-sm btn-success float-end">Add New</a></div>

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
                          <th scope="col">Asset Name</th>
                          <th scope="col">Description</th>
                          <th scope="col">Purchase Price</th>
                          <th scope="col">Color</th>
                          <th scope="col">Shade Location</th>
                          <th scope="col">Asset Code/QR</th>
                          <th scope="col">Status</th>
                          <th scope="col">Note</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($assets as $asset)

                        <tr>
                          <th scope="row">{{ $asset->id }}</th>
                          <td>{{ $asset->package_id }}</td>
                          <td>{{ $asset->name }}</td>
                          <td>{{ $asset->description }}</td>
                          <td>{{ $asset->purchase_price }}</td>
                          <td>{{ $asset->color }}</td>
                          <td>{{ $asset->location }}</td>
                          <td>{{ $asset->asset_code }}</td>
                          <td>{{ $asset->status }}</td>
                          <td>{{ $asset->note }}</td>
                          <td>
                            <a class="btn btn-primary btn-sm" href="{{ url('/administrator/asset/edit/' . $asset->id ) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ url('/administrator/asset/delete/' . $asset->id ) }}">Delete</a>

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
