@extends('administrator.layouts.application')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 p-2 bg-white shadow-md">
                        <input type="text" id="search" name="search" placeholder="Search" value="{{ request()->search }}" class="block w-full sm:w-auto flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3">
                        <button onclick="updateFilter()" class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md">Search</button>
                        <select name="package" id="package" onchange="updateFilter()" class="block w-full sm:w-auto flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3">
                            <option value="">All</option>
                            @foreach ($packagesData as $package)
                            <option value="{{ $package->id }}" {{ request()->package == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
                            @endforeach
                        </select>
                        <select name="status" id="status" onchange="updateFilter()" class="block w-full sm:w-auto flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 mr-2">
                            <option value="">All</option>
                            @foreach ($distinctStatus as $status)
                            <option value="{{ $status->status }}" {{ request()->status == $status->status ? 'selected' : '' }}>{{ $status->status }}</option>
                            @endforeach
                        </select>
                        <!-- toggle button -->
                        <div class="flex items center">
                            <div class="flex items center">
                                <label for="toggle" class="flex items-center cursor-pointer">
                                    <!-- toggle -->
                                    <label for="toggle" class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input id="migration" type="checkbox" class="" onchange="updateFilter()" {{ request()->migration == 1 ? 'checked' : '' }}>
                                        </div>
                                    </label>
                                    <!-- label -->
                                    <div class="ml-3 text-gray-700 font-medium">
                                        MigrationOnly
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <th scope="col">Code</th>
                                <th scope="col">Package Name</th>
                                <th scope="col">Investor</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total Value</th>
                                <th scope="col">
                                    <svg class="mx-auto w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M3 21.0001H21M4 18.0001H20M6 18.0001V13.0001M10 18.0001V13.0001M14 18.0001V13.0001M18 18.0001V13.0001M12 7.00695L12.0074 7.00022M21 10.0001L14.126 3.88986C13.3737 3.2212 12.9976 2.88688 12.5732 2.75991C12.1992 2.64806 11.8008 2.64806 11.4268 2.75991C11.0024 2.88688 10.6263 3.2212 9.87404 3.88986L3 10.0001H21Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </th>
                                <th scope="col">
                                    <svg class="mx-auto w-8 h-8" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: #ffffff;
                                                }
                                            </style>
                                            <g>
                                                <polygon class="st0" points="234.234,172.219 236.016,172.219 247.328,172.219 247.359,172.219 247.359,148.047 252.719,148.047 259.734,152.094 259.734,172.219 262.359,172.219 270.328,172.219 272.953,172.219 272.953,158.906 295.234,169.969 295.234,168.281 295.234,157.25 295.234,155.563 266.813,140.531 295.234,125.531 295.234,123.844 295.234,112.828 295.234,111.141 272.953,122.203 272.953,108.875 270.328,108.875 262.359,108.875 259.734,108.875 259.734,129.016 252.688,133.047 247.359,133.047 247.359,108.875 247.328,108.875 236.016,108.875 234.234,108.875 234.234,133.047 216.25,133.047 216.25,148.047 234.234,148.047 "></polygon>
                                                <rect x="292" y="464" class="st0" width="146.672" height="48"></rect>
                                                <path class="st0" d="M418.063,0H93.938C59.719,0,32,25.078,32,56s27.719,56,61.938,56H120V28.094h17.359v345.828h122.672 l4.313,20.328c1.078,5.156,3.703,9.875,7.516,13.5l0.406,0.406l49.813,35.688l0.016-0.031c4.75,4.156,10.828,6.531,17.172,6.531 h70.594c14.438,0,26.125-11.688,26.141-26.125V257.125c0-15.781-4.906-31.156-14.031-44.016l-44.609-62.859V28.094H392V112h26.063 C452.266,112,480,86.922,480,56S452.266,0,418.063,0z M338.641,28.094h22.719v99.625l-0.031-0.047v129.859 c0,2.594-0.984,5.094-2.781,6.984l-19.906,21.016V28.094z M257.688,76.094c35.344,0,64,28.656,64,64s-28.656,64-64,64 s-64-28.656-64-64S222.344,76.094,257.688,76.094z M153.359,357.922V28.094h22.719v265.266 c20.406,4.953,36.234,21.438,40.234,42.172h35.609l4.734,22.391H153.359z M408.922,222.375 c7.203,10.156,11.078,22.281,11.078,34.75v167.094c-0.016,5.594-4.547,10.125-10.141,10.125h-70.594c-2.609,0-5.125-1-7.016-2.797 l-0.391-0.391l-49.109-35.188c-1.375-1.375-2.344-3.109-2.75-5.016l-25.438-120.234l-0.219-2.094c0-3.594,1.906-7,5.094-8.813 l-0.531,0.313l9.969-5.703c1.547-0.891,3.281-1.328,5.016-1.328c0.969,0,1.938,0.125,2.875,0.406l-0.297-0.094l0.313,0.094 c2.656,0.781,4.859,2.625,6.141,5.078l19.578,37.859c3.891,7.516,11.172,12.688,19.563,13.875c1.219,0.156,2.438,0.25,3.656,0.25 c7.125,0,14-2.906,18.969-8.156l25.156-26.547l0.328-0.359c4.594-4.844,7.156-11.281,7.156-17.969v-79.672L408.922,222.375z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </th>
                                <th scope="col">Status</th>
                                <th scope="col">Note</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                            <tr>
                                <th scope="row">{{ $booking->id }}</th>
                                <td>{{ $booking->code }}</td>
                                <td>{{ $booking->package_name }}</td>
                                <td>
                                    {{ $booking->user_name }}
                                    <br>
                                    <small>{{ $booking->user_email }}</small>
                                    <br>
                                    <small>{{ $booking->user_phone }}</small>
                                </td>
                                <td>{{ $booking->booking_quantity }}</td>
                                <td>{{ $booking->total_value }}</td>
                                <td class="text-center">
                                    @if($booking->payment_id > 0)
                                    @if($booking->payment_status == 'complete')
                                    <svg class="mx-auto w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M3 21.0001H21M4 18.0001H20M6 18.0001V13.0001M10 18.0001V13.0001M14 18.0001V13.0001M18 18.0001V13.0001M12 7.00695L12.0074 7.00022M21 10.0001L14.126 3.88986C13.3737 3.2212 12.9976 2.88688 12.5732 2.75991C12.1992 2.64806 11.8008 2.64806 11.4268 2.75991C11.0024 2.88688 10.6263 3.2212 9.87404 3.88986L3 10.0001H21Z" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                    @elseif($booking->payment_status == 'pending')
                                    <svg class="mx-auto w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M3 21.0001H21M4 18.0001H20M6 18.0001V13.0001M10 18.0001V13.0001M14 18.0001V13.0001M18 18.0001V13.0001M12 7.00695L12.0074 7.00022M21 10.0001L14.126 3.88986C13.3737 3.2212 12.9976 2.88688 12.5732 2.75991C12.1992 2.64806 11.8008 2.64806 11.4268 2.75991C11.0024 2.88688 10.6263 3.2212 9.87404 3.88986L3 10.0001H21Z" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                    @else
                                    <svg class="mx-auto w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M3 21.0001H21M4 18.0001H20M6 18.0001V13.0001M10 18.0001V13.0001M14 18.0001V13.0001M18 18.0001V13.0001M12 7.00695L12.0074 7.00022M21 10.0001L14.126 3.88986C13.3737 3.2212 12.9976 2.88688 12.5732 2.75991C12.1992 2.64806 11.8008 2.64806 11.4268 2.75991C11.0024 2.88688 10.6263 3.2212 9.87404 3.88986L3 10.0001H21Z" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                    @endif
                                    @endif
                                    {{ $booking->payment_status }}
                                </td>
                                <td>
                                    @if($booking->closing_id > 0)
                                    <svg class="mx-auto w-8 h-8" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <style type="text/css">
                                                .statm {
                                                    fill: #df35de;
                                                }
                                            </style>
                                            <g>
                                                <polygon class="statm" points="234.234,172.219 236.016,172.219 247.328,172.219 247.359,172.219 247.359,148.047 252.719,148.047 259.734,152.094 259.734,172.219 262.359,172.219 270.328,172.219 272.953,172.219 272.953,158.906 295.234,169.969 295.234,168.281 295.234,157.25 295.234,155.563 266.813,140.531 295.234,125.531 295.234,123.844 295.234,112.828 295.234,111.141 272.953,122.203 272.953,108.875 270.328,108.875 262.359,108.875 259.734,108.875 259.734,129.016 252.688,133.047 247.359,133.047 247.359,108.875 247.328,108.875 236.016,108.875 234.234,108.875 234.234,133.047 216.25,133.047 216.25,148.047 234.234,148.047 "></polygon>
                                                <rect x="292" y="464" class="statm" width="146.672" height="48"></rect>
                                                <path class="statm" d="M418.063,0H93.938C59.719,0,32,25.078,32,56s27.719,56,61.938,56H120V28.094h17.359v345.828h122.672 l4.313,20.328c1.078,5.156,3.703,9.875,7.516,13.5l0.406,0.406l49.813,35.688l0.016-0.031c4.75,4.156,10.828,6.531,17.172,6.531 h70.594c14.438,0,26.125-11.688,26.141-26.125V257.125c0-15.781-4.906-31.156-14.031-44.016l-44.609-62.859V28.094H392V112h26.063 C452.266,112,480,86.922,480,56S452.266,0,418.063,0z M338.641,28.094h22.719v99.625l-0.031-0.047v129.859 c0,2.594-0.984,5.094-2.781,6.984l-19.906,21.016V28.094z M257.688,76.094c35.344,0,64,28.656,64,64s-28.656,64-64,64 s-64-28.656-64-64S222.344,76.094,257.688,76.094z M153.359,357.922V28.094h22.719v265.266 c20.406,4.953,36.234,21.438,40.234,42.172h35.609l4.734,22.391H153.359z M408.922,222.375 c7.203,10.156,11.078,22.281,11.078,34.75v167.094c-0.016,5.594-4.547,10.125-10.141,10.125h-70.594c-2.609,0-5.125-1-7.016-2.797 l-0.391-0.391l-49.109-35.188c-1.375-1.375-2.344-3.109-2.75-5.016l-25.438-120.234l-0.219-2.094c0-3.594,1.906-7,5.094-8.813 l-0.531,0.313l9.969-5.703c1.547-0.891,3.281-1.328,5.016-1.328c0.969,0,1.938,0.125,2.875,0.406l-0.297-0.094l0.313,0.094 c2.656,0.781,4.859,2.625,6.141,5.078l19.578,37.859c3.891,7.516,11.172,12.688,19.563,13.875c1.219,0.156,2.438,0.25,3.656,0.25 c7.125,0,14-2.906,18.969-8.156l25.156-26.547l0.328-0.359c4.594-4.844,7.156-11.281,7.156-17.969v-79.672L408.922,222.375z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    @endif
                                    {{ $booking->closing_status }}
                                </td>
                                <td>{{ $booking->status }}</td>
                                <td>{{ $booking->note }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('administrator.booking.show', $booking->id) }}" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-row">
                    <div class="grow">{{ $bookings->links() }}</div>
                    <div class="flex items-center space-x-2 px-2">
                        <span class="text-[#9CA3AF]">Limit: </span>
                        <div>
                            <select name="dataSize" onchange="updateFilter()" id="dataSizeForm">
                                <option value="10" {{ request()->dataSize == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request()->dataSize == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request()->dataSize == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request()->dataSize == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateFilter() {
            let status = document.getElementById('status').value;
            let dataSize = document.getElementById('dataSizeForm').value;
            let package = document.getElementById('package').value;
            let search = document.getElementById('search').value;
            let checked = document.getElementById('migration').checked;
            console.log(checked);
            let url = new URL(window.location.href);
            url.searchParams.set('status', status);
            url.searchParams.set('dataSize', dataSize);
            url.searchParams.set('package', package);
            url.searchParams.set('search', search);
            if (checked) {
                url.searchParams.set('migration', 1);
            } else {
                url.searchParams.delete('migration');
            }
            window.location.href = url.toString();
        }
    </script>
</div>
@endsection