<?php

namespace App\Http\Controllers\Administrator;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:administrator');
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
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


    return view('administrator.dashboard', compact('packages', 'bookingStats', 'statuses'));
  }
}
