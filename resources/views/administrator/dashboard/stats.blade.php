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
<div>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 p-2">Package</th>
                <th class="border border-gray-300 p-2">Pending</th>
                <th class="border border-gray-300 p-2">Pending Approval</th>
                <th class="border border-gray-300 p-2">Approved</th>
                <th class="border border-gray-300 p-2">Rejected</th>
                <th class="border border-gray-300 p-2">Migrated</th>
                <th class="border border-gray-300 p-2">Withdrawn</th>
                <th class="border border-gray-300 p-2">Total Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $package)
            <tr>
                <td class="border border-gray-300 p-2">
                    {{$package->name}}
                </td>
                <td class="border border-gray-300 p-2">
                    <script>
                        document.write(formatNumberBangladeshi(`{{$package->pending}}`))
                    </script>
                </td>
                <td class="border border-gray-300 p-2">
                    <script>
                        document.write(formatNumberBangladeshi(`{{$package->pending_approval}}`))
                    </script>
                </td>
                <td class="border border-gray-300 p-2">
                    <script>
                        document.write(formatNumberBangladeshi(`{{$package->approved}}`))
                    </script>
                </td>
                <td class="border border-gray-300 p-2">
                    <script>
                        document.write(formatNumberBangladeshi(`{{$package->rejected}}`))
                    </script>
                </td>
                <td class="border border-gray-300 p-2">
                    <script>
                        document.write(formatNumberBangladeshi(`{{$package->migrated}}`))
                    </script>
                </td>
                <td class="border border-gray-300 p-2">
                    <script>
                        document.write(formatNumberBangladeshi(`{{$package->withdrawn}}`))
                    </script>
                </td>
                <td class="border border-gray-300 p-2">
                    <script>
                        document.write(formatNumberBangladeshi(`{{$package->total_value}}`));
                    </script>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>