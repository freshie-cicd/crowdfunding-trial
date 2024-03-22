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
      'bookings.package_id',
      'bookings.status',
      DB::raw('SUM(booking_quantity * packages.value) as total_value')
    )
      ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
      ->groupBy('bookings.package_id', 'bookings.status')
      ->get();

    return view('administrator.dashboard', compact('packages', 'bookingStats'));
  }
}
