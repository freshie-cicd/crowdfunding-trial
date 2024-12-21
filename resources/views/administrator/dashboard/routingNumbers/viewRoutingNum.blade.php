@extends('administrator.layouts.application')

@section('content')
    <form class=" mx-auto mb-3" method="GET">

        <input type="text" id="search" name="search" placeholder="Search " value="{{ request()->search }}"
            class=" w-full sm:w-auto flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3">
        <button
            class="px-4 py-2 ms-2 text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md">Search</button>
    </form>


    <div class="relative overflow-x-auto px-5">

        <table class="w-full text-lg text-center rtl:text-right  ">
            <thead class="text-xs text-gray-700 uppercase  ">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">Bank</th>
                    <th scope="col" class="px-6 py-3">Branch</th>
                    <th scope="col" class="px-6 py-3">District</th>
                    <th scope="col" class="px-6 py-3">Routing Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allRoutingNumbers as $routingNumber)
                    <tr class="border-b">
                        <th cope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $loop->iteration }}</th>
                        <td class="px-3 py-4">{{ $routingNumber->bank }}</td>
                        <td class="px-3 py-4">{{ $routingNumber->branch }}</td>
                        <td class="px-3 py-4">{{ $routingNumber->district }}</td>
                        <td class="px-3 py-4">{{ $routingNumber->routing_number }}</td>
                        <td class="px-3 py-4"><a href="{{ route('administrator.editRoutingNums', $routingNumber->id) }}"
                                class="btn btn-success">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $allRoutingNumbers->links() }}
    </div>
@endsection
