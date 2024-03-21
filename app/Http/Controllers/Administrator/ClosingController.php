<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClosingRequest;


class ClosingController extends Controller
{
   

    public function __construct()
      {
        $this->middleware('auth:administrator');
      }


    public function index()
    {
        $data = DB::table('closing_requests')
                ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
                ->join('packages', 'bookings.package_id', '=', 'packages.id')
                ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
                ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
                ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
                ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district' )
                ->get();
      
        return view('administrator.closing.index', compact('data'));
    }


    public function report()
    {
        $data = DB::table('closing_requests')
                ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
                ->join('packages', 'bookings.package_id', '=', 'packages.id')
                ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
                ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
                ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
                ->where('closing_requests.id', '>', 0)
                ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district' )
                ->get();
      
        return view('administrator.closing.report', compact('data'));
    }
    
    
        public function profit_return()
    {
        $data = DB::table('closing_requests')
                ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
                ->join('packages', 'bookings.package_id', '=', 'packages.id')
                ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
                ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
                ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
                ->where('closing_requests.id', '>', '0')
                //->whereRaw('LENGTH(investor_bank_details.routing_number) = 9')
                ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district' )
                ->get();
      
        return view('administrator.closing.profit_return', compact('data'));
    }
    
    
    
    
    public function capital_return_report()
    {
        $data = DB::table('closing_requests')
                ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
                ->join('packages', 'bookings.package_id', '=', 'packages.id')
                ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
                ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
                ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
                ->where('closing_requests.package_to_withdraw', '>', 0)
                ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district' )
                ->get();
      
        return view('administrator.closing.capital', compact('data'));
    }
    
    
    
    

   
}
