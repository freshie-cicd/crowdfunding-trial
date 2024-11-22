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

    .filter-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-box {
        min-width: 300px;
    }

    .status-buttons .btn {
        border-radius: 0;
    }

    .status-buttons .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .status-buttons .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    /* Add these styles to your existing styles */
    .sort-header {
        color: #000000 !important;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .sort-header:hover {
        color: #676767 !important;
        text-decoration: none;
    }

    .sort-indicator {
        display: inline-block;
        margin-left: 5px;
        color: #030303;
    }

    .sort-indicator.default::after {
        content: "↕";
        opacity: 0.5;
    }

    .sort-indicator.asc::after {
        content: "↑";
    }

    .sort-indicator.desc::after {
        content: "↓";
    }
</style>

@section('content')
<div class="">
    <div class="container">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="filter-row float-end">
                        <!-- Search and Per Page Filter -->
                        <div class="filter-group">
                            <form method="GET" action="{{ route('admin.investor.profile') }}" class="d-flex gap-2">
                                <!-- Preserve other query parameters -->
                                @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                @if (request('sort_by'))
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                <input type="hidden" name="sort_direction"
                                    value="{{ request('sort_direction') }}">
                                @endif

                                <input type="text" name="search" class="form-control form-control-sm search-box"
                                    placeholder="Search by name, email, phone, or NID" value="{{ request('search') }}">

                                <select name="per_page" class="form-control form-control-sm"
                                    onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per
                                        page</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per
                                        page</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per
                                        page</option>
                                </select>

                                <button type="submit" class="btn btn-sm btn-primary" aria-label="Perform search">Search</button>
                                @if (request('search') || request('per_page') != 10)
                                <a href="{{ request()->fullUrlWithQuery(['search' => null, 'per_page' => request()->per_page]) }}"
                                    class="btn btn-sm btn-secondary">
                                    Reset
                                </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover table-responsive">
                        <thead class="thead-dark" style="background:#222;color:#fff">
                            <tr>
                                <th scope="col">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}"
                                        class="sort-header">
                                        #
                                        <span
                                            class="sort-indicator {{ request('sort_by') == 'id' ? (request('sort_direction') == 'asc' ? 'asc' : 'desc') : 'default' }}"></span>
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}"
                                        class="sort-header">
                                        Investor Name
                                        <span
                                            class="sort-indicator {{ request('sort_by') == 'name' ? (request('sort_direction') == 'asc' ? 'asc' : 'desc') : 'default' }}"></span>
                                    </a>
                                </th>
                                <th scope="col">Contact</th>
                                <th scope="col">NID</th>
                                <th scope="col">Status</th>
                                <th scope="col">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}"
                                        class="sort-header">
                                        Member Since
                                        <span
                                            class="sort-indicator {{ request('sort_by') == 'created_at' ? (request('sort_direction') == 'asc' ? 'asc' : 'desc') : 'default' }}"></span>
                                    </a>
                                </th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    {{ $data->phone }}<br>
                                    {{ $data->email }}
                                </td>
                                <td>{{ $data->nid }}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('administrator.investor.profile.show', $data->id) }}"
                                            class="me-2">
                                            <i class="fas fa-eye text-blue-400"></i>
                                        </a>
                                        <a href="{{ url('administrator/investor/change_password', $data->id) }}"
                                            class="me-2">
                                            <i class="fas fa-key text-gray-400"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection