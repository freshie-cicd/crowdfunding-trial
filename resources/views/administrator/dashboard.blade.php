@extends('administrator.layouts.application')

@section('content')

<div class="flex flex-row">
    <script>
        function formatNumberBangladeshi(x) {
            x = x.toString();
            let afterPoint = '';
            if (x.indexOf('.') > 0) {
                afterPoint = x.substring(x.indexOf('.'), x.length);
            }
            x = Math.floor(x);
            x = x.toString();
            let lastThree = x.substring(x.length - 3);
            const otherNumbers = x.substring(0, x.length - 3);
            if (otherNumbers != '') {
                lastThree = ',' + lastThree;
            }
            return otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
        }
    </script>
    <div x-data="{
            package: '',
            packages: {{$packages}},
            stats: {{$bookingStats}},
            getTotalValueByStatus(status) {
                return this.stats
                    .filter(stat => stat.package_id === this.package && stat.status === status)
                    .reduce((total, stat) => total + stat.total_value, 0);
            }
        }">
        <div class="pb-2">
            <select name="package" id="package" class="border border-gray-300 rounded-md p-2 bg-white" x-model="package">
                <option value="">Select Package</option>
                <template x-for="package in packages" :key="package.id">
                    <option x-bind:value="package.id" x-text="package.name"></option>
                </template>
            </select>
        </div>
        <div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2">Package</th>
                        <th class="border border-gray-300 p-2">Pending</th>
                        <th class="border border-gray-300 p-2">Pending Approval</th>
                        <th class="border border-gray-300 p-2">Approved</th>
                        <th class="border border-gray-300 p-2">Rejected</th>
                        <th class="border border-gray-300 p-2">Total Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr x-show="package">
                        <td class="border border-gray-300 p-2" x-text="`${packages.find(p => p.id == package)?.name} [${packages.find(p => p.id == package)?.status? 'active': 'inactive'}]`"></td>
                        <td class="border border-gray-300 p-2" x-text="formatNumberBangladeshi(getTotalValueByStatus('pending'))"></td>
                        <td class="border border-gray-300 p-2" x-text="formatNumberBangladeshi(getTotalValueByStatus('pending_approval'))"></td>
                        <td class="border border-gray-300 p-2" x-text="formatNumberBangladeshi(getTotalValueByStatus('approved'))"></td>
                        <td class="border border-gray-300 p-2" x-text="formatNumberBangladeshi(getTotalValueByStatus('rejected'))"></td>
                        <td class="border border-gray-300 p-2">
                            <span x-text="formatNumberBangladeshi(stats.filter(stat => stat.package_id === package).reduce((total, stat) => total + stat.total_value, 0))"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection