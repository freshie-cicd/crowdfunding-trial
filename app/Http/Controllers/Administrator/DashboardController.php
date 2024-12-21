<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\RoutingNumber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        if (!auth()->guard('administrator')->user()->hasRole('superadmin')) {
            return redirect()->route('admin.agreement.requests');
        }

        $packages = Package::orderBy('id', 'desc')
            ->select('id', 'name', 'status')
            ->get();

        $bookingStats = Booking::select(
            'bookings.status',
            DB::raw('SUM(booking_quantity * packages.value) as total_value'),
            'packages.name as package_name'
        )
            ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
            ->groupBy('packages.name', 'bookings.status')
            ->get();

        $statuses = ['pending', 'approved', 'rejected', 'pending_approval', 'migrated', 'withdrawn'];

        foreach ($packages as $package) {
            $package->total_value = $bookingStats->where('package_name', $package->name)->sum('total_value');
            foreach ($statuses as $status) {
                $package->{$status} = $bookingStats->where('package_name', $package->name)->where('status', $status)->sum('total_value');
            }
        }

        $paymentGraph = $this->paymentGraph();

        return view('administrator.dashboard.index', compact('packages', 'bookingStats', 'statuses', 'paymentGraph'));
    }

    public function indexUnauthorized()
    {
        return view('administrator.dashboard.index-unauthorized');
    }

    public function showRouteForm()
    {
        return view('administrator.dashboard.routingNumbers.addRoute');
    }

    public function storeRoute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank' => 'required',
            'branch' => 'required',
            'district' => 'required',
            'routing_number' => ['required', 'max:9', 'min:9', 'unique:routing_numbers'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        RoutingNumber::create([
            'bank' => $request->bank,
            'branch' => $request->branch,
            'district' => $request->district,
            'routing_number' => $request->routing_number,
        ]);

        return back()->with('success', 'successfully added');
    }

    public function viewRoutingNums(Request $request)
    {
        $searchVal = $request->input('search');

        // Query builder with conditional search
        $allRoutingNumbers = RoutingNumber::query()
            ->when($searchVal, function ($query) use ($searchVal) {
                $query->where('routing_number', 'LIKE', "%{$searchVal}%")
                    ->orWhere('bank', 'LIKE', "%{$searchVal}%")
                    ->orWhere('branch', 'LIKE', "%{$searchVal}%")
                    ->orWhere('district', 'LIKE', "%{$searchVal}%");
            })
            ->paginate(50)
            ->appends(['search' => $searchVal]);

        return view('administrator.dashboard.routingNumbers.viewRoutingNum', compact('allRoutingNumbers'));
    }

    public function editRoutingNums($id)
    {
        $singleRouteInfo = RoutingNumber::find($id);

        return view('administrator.dashboard.routingNumbers.editRoutingNumbers', compact('singleRouteInfo'));
    }

    public function updateRoutingNums(Request $request, $id)
    {
        $request->validate([
            'routing_number' => ['required', 'max:9', 'unique:routing_numbers,routing_number,'.$id],
            'bank' => ['required', 'string'],
            'branch' => ['required', 'string'],
            'district' => ['required', 'string'],
        ]);

        $routingNumber = RoutingNumber::findOrFail($id);

        $routingNumber->update([
            'routing_number' => $request->input('routing_number'),
            'bank' => $request->input('bank'),
            'branch' => $request->input('branch'),
            'district' => $request->input('district'),
        ]);

        return back()
            ->with('success', 'Routing number updated successfully.');
    }

    private function paymentGraph()
    {
        $data = Booking::select(
            DB::raw('COUNT(*) as total_bookings'),
            DB::raw('SUM(booking_quantity * packages.value) as total_value'),
            DB::raw('DATE_FORMAT(bookings.created_at, "%Y-%m-%d") as date')
        )
            ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
            ->groupBy('date')
            ->get();

        $labels = $data->pluck('date');
        $series = $data->pluck('total_value');
        $count = $data->pluck('total_bookings');

        return [
            'labels' => $labels,
            'series' => $series,
            'count' => $count,
        ];
    }
}
