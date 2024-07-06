<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\InvestorBankDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index(Request $request)
    {
        $status = $request->status;

        $users = User::when($status, function($query, $status){
            $query->where('status', $status);
        })->get();

        return view('administrator.investor.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::where('id', $id)->first();
        $bankDetails = InvestorBankDetail::where('user_id', $id)
            ->leftJoin('banks', 'banks.id', '=', 'investor_bank_details.bank_name')
            ->leftJoin('districts', 'districts.id', '=', 'investor_bank_details.district')
            ->first();

        $bookings = Booking::where('bookings.user_id', $id)
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('facebook_groups', 'facebook_groups.batch_id', '=', 'packages.batch_id')
            ->select('bookings.code', 'packages.value', 'bookings.booking_quantity', 'bookings.status', 'bookings.id', 'packages.batch_id', 'facebook_groups.url', 'packages.status as package_status', 'packages.name as package_name')
            ->get();

        return view('administrator.investor.show', compact('user', 'bankDetails', 'bookings'));
    }

    public function change_password($id)
    {
        $data = User::where('id', $id)->get();

        return view('administrator.investor.change_password', compact('data'));
    }

    public function store_password(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $check = User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        if ($check) {
            return redirect()->back()->with('success', 'Password Changed Successfully');
        }
    }


    public function block($userId)
    {
        $check = User::where('id', $userId)->update(['status' =>'blocked']);

        if($check){
            return redirect()->back()->with('success', 'Blocked Successfully.');
        }

        return redirect()->back()->with('warning', 'Blocking Unccessful.');
    }

    public function unblock($userId)
    {
        $check = User::where('id', $userId)->update(['status' =>'active']);

        if($check){
            return redirect()->back()->with('success', 'Unblocked Successfully.');
        }

        return redirect()->back()->with('warning', 'Unblocking Unccessful.');
    }


}
