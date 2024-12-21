<?php

namespace App\Http\Controllers\Administrator;

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
        $query = User::query();

        // Handle status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('nid', 'LIKE', "%{$search}%");
            });
        }

        // Handle sorting
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Paginate results
        $users = $query->paginate($request->per_page)->withQueryString();

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
            ->select('bookings.code', 'packages.value', 'bookings.booking_quantity', 'bookings.status', 'bookings.id', 'packages.project_id', 'package.fb_group_url', 'packages.status as package_status', 'packages.name as package_name')
            ->get();

        return view('administrator.investor.show', compact('user', 'bankDetails', 'bookings'));
    }

    public function update(Request $request)
    {
        $check = User::where('id', $request->user_id)->update(['status' => $request->status]);

        if ($check) {
            return redirect()->back()->with('success', 'Status Update Successful');
        }

        return redirect()->back()->with('warning', 'Status Update Failed');
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
        $check = User::where('id', $userId)->update(['status' => 'blocked']);

        if ($check) {
            return redirect()->back()->with('success', 'Blocked Successfully.');
        }

        return redirect()->back()->with('warning', 'Blocking Unccessful.');
    }

    public function unblock($userId)
    {
        $check = User::where('id', $userId)->update(['status' => 'active']);

        if ($check) {
            return redirect()->back()->with('success', 'Unblocked Successfully.');
        }

        return redirect()->back()->with('warning', 'Unblocking Unccessful.');
    }

    public function bank_update(Request $request)
    {
        $data = $request->only('user_id', 'is_protected');

        $check = InvestorBankDetail::where('user_id', $request->user_id)->update(['is_protected' => $data['is_protected']]);

        if ($check) {
            return redirect()->back()->with('success', 'Bank Details Updated Successfully');
        }

        return redirect()->back()->with('info', 'Bank Details Update Failed');
    }
}
