<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\InvestorBankDetail;
use App\Models\Package;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $packages = Package::where('status', 1)->get();

        $checkPendingBooking = Booking::where('user_id', auth()->user()->id)->where('status', 'pending')->count();

        return view('package', compact('packages', 'checkPendingBooking'));
    }

    public function book($id)
    {
        $checkPendingBooking = Booking::where('user_id', auth()->user()->id)->where('status', 'pending')->count();

        if ($checkPendingBooking > 0) {
            return redirect()->back()->with('error', 'You have a pending booking. Please wait for approval.');
        }
        $package = Package::where('id', $id)->first();

        return view('book', compact('package'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required'],
            'package_id' => ['required'],
            'booking_quantity' => ['required'],
            'note' => ['nullable'],
            'terms' => ['required'],
        ]);

        $checkPendingBooking = Booking::where('user_id', auth()->user()->id)->where('status', 'pending')->count();

        if ($checkPendingBooking > 0) {
            return redirect()->back()->with('error', 'You have a pending booking. Please wait for approval.');
        }

        $book = new Booking();
        do {
            $randomNumber = random_int(10000000, 99999999);
            $check = Booking::where('code', $randomNumber)->count();
        } while ($check);

        $book['code'] = $randomNumber;
        $book['user_id'] = $request->user_id;
        $book['package_id'] = $request->package_id;
        $book['booking_quantity'] = $request->booking_quantity;
        $book['note'] = $request->note;
        $book->save();

        $code = $book['code'];

        Mail::to(auth()->user()->email)->send(new BookingConfirmationMail($code));

        return redirect('/dashboard')->with('success', 'Booking Successfully Submitted. A confirmation mail has been sent to your email address.');
    }

    public function dashboard()
    {
        $bookings = Booking::where('bookings.user_id', auth()->user()->id)
            ->where('bookings.status', '!=', 'rejected')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('closing_requests', 'closing_requests.booking_code', '=', 'bookings.code')
            ->select(
                'bookings.code',
                'packages.code as pcode',
                'packages.value',
                'bookings.booking_quantity',
                'bookings.status',
                'bookings.id',
                'packages.project_id',
                'packages.fb_group_url',
                'packages.maturity',
                'packages.name as package_name',
                'packages.return_amount',
                'packages.instructions as package_instructions',
                'closing_requests.id as closing_id',
                'closing_requests.capital_withdrawal_amount as withdraw',
                'closing_requests.after_withdrawal_amount as reinvest',
                'closing_requests.profit_withdrawal_amount as total_profit',
            )
            ->orderByRaw("CASE WHEN bookings.status = 'complete' THEN 1 WHEN bookings.status = 'pending' THEN 2 WHEN bookings.status = 'pending_approval' THEN 3 ELSE 4 END, bookings.id DESC")
            ->get();

        $packages = Package::where('status', 1)->get();

        $checkPendingBooking = Booking::where('user_id', auth()->user()->id)->where('status', 'pending')->count();

        $total_investment = 0;

        foreach ($bookings as $key => $value) {
            if ('approved' == $value->status) {
                $total_investment += $value->value * $value->booking_quantity;
            }
        }

        $checkPendingApproval = Booking::where('user_id', auth()->user()->id)->where('status', 'pending_approval')->count();

        $bank = DB::table('investor_bank_details')
            ->where('investor_bank_details.user_id', auth()->user()->id)
            ->first();
        $status = User::where('id', auth()->user()->id)->value('status');

        return view('dashboard', compact('bookings', 'packages', 'total_investment', 'checkPendingApproval', 'bank', 'status', 'checkPendingBooking'));
    }

    public function profile()
    {
        $user_data = User::where('id', auth()->user()->id)->get();

        return view('profile.index', compact('user_data'));
    }

    public function profile_edit()
    {
        return view('profile.edit');
    }

    public function profile_update(Request $request)
    {
        User::where('id', Auth::user()->id)

            ->update($request->except('_token', 'method', 'password', 'email', 'phone', 'status'));

        return redirect()->back()->with('success', 'Profile Edited Successfully');
    }

    public function change_password()
    {
        return view('profile.change_password');
    }

    public function change_password_update(Request $request)
    {
        $validated = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = auth()->user();

        // Check if the old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Old Password is incorrect');
        }

        // Check if the new password is the same as the old password
        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'New Password cannot be the same as the old password');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password Changed Successfully');
    }

    public function bank_details(Request $request)
    {
        $data = InvestorBankDetail::where('user_id', auth()->user()->id)->first();

        $routInfo = DB::table('routing_numbers')->get();

        return view('investor.bank_details', compact('data', 'routInfo'));
    }

    public function bank_details_update(Request $request)
    {
        $routingDetails = DB::table('routing_numbers')->where('routing_number', $request->routing_number)->first();

        if (empty($routingDetails)) {
            return redirect()->back()->with('warning', 'Routing Number Not Found!');
        }

        $data = InvestorBankDetail::where('user_id', auth()->user()->id)->first();

        if ($data && 1 == $data->is_protected) {
            return redirect()->back()->with('error', 'You are not allowed to change bank details. Please contact with '.env('APP_NAME').' support.');
        }

        // dd($data);
        if (empty($data)) {
            $validator = Validator::make($request->all(), [
                'account_name' => ['required', 'string'],
                'account_number' => ['required', 'string'],
                'routing_number' => ['required', 'max:9', 'min:9'],
                'file' => ['required'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $bank = new InvestorBankDetail();

            $bank['user_id'] = auth()->user()->id;
            $bank['bank_name'] = $request->bank_name;
            $bank['district'] = $request->district;
            $bank['branch_name'] = $request->branch_name;
            $bank['account_name'] = $request->account_name;
            $bank['account_number'] = $request->account_number;
            $bank['routing_number'] = $request->routing_number;
            $bank['note'] = $request->note;
            $bank['is_protected'] = 1; // Set is_protected to 1 for new bank details

            $file = $request->file('file');
            $givenName = $request->user_id;
            $filename = $givenName.'_'.Str::random(40).'.'.$file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('checkleafs', $file, $filename);
            // $path = Storage::putFileAs('checkleafs', $file, $filename);

            $check = InvestorBankDetail::create([
                'user_id' => $request->user_id,
                'bank_name' => $routingDetails->bank,
                'branch_name' => $routingDetails->branch,
                'district' => $routingDetails->district,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'routing_number' => $routingDetails->routing_number,
                'checkbook_url' => $path,
                'is_protected' => 1, // Ensure is_protected is set for new entries
            ]);

            if ($check) {
                return redirect()->back()->with('success', 'Bank Details created Successfully');
            }
        } else {
            $validator = Validator::make($request->all(), [
                'account_name' => ['required', 'string'],
                'account_number' => ['required', 'string'],
                'routing_number' => ['required', 'max:9', 'min:9'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $file = $request->file('file');

            if (!empty($file)) {
                $givenName = $request->user_id;
                $filename = $givenName.'_'.Str::random(40).'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('checkleafs', $file, $filename);
            } else {
                $path = $data->checkbook_url;
            }

            $check = InvestorBankDetail::where('user_id', $request->user_id)->update([
                'bank_name' => $routingDetails->bank,
                'branch_name' => $routingDetails->branch,
                'district' => $routingDetails->district,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'routing_number' => $routingDetails->routing_number,
                'checkbook_url' => $path,
                'is_protected' => 1, // Ensure is_protected is maintained during updates
            ]);

            if ($check) {
                return redirect()->back()->with('success', 'Bank Details Updated Successfully');
            }
        }
    }

    public function profile_blocked()
    {
        return view('profile_blocked');
    }
}
