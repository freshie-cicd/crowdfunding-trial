<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\InvestorBankDetail;
use App\Models\Package;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

        return view('package', compact('packages'));
    }

    public function book($id)
    {
        $data = Package::where('id', $id)->get();

        return view('book', compact(['data']));
    }

    public function store(Request $request)
    {
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

        return redirect('/bookings')->with('success', 'Booking Successfully Submitted. A confirmation mail has been sent to your email address.');
    }

    public function dashboard()
    {
        $bookings = Booking::where('bookings.user_id', auth()->user()->id)
            ->where('bookings.status', '!=', 'rejected')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('facebook_groups', 'facebook_groups.batch_id', '=', 'packages.batch_id')
            ->leftJoin('closing_requests', 'closing_requests.booking_code', '=', 'bookings.code')
            ->select(
                'bookings.code',
                'packages.code as pcode',
                'packages.value',
                'bookings.booking_quantity',
                'bookings.status',
                'bookings.id',
                'packages.batch_id',
                'facebook_groups.url',
                'packages.maturity',
                'packages.name as package_name',
                'packages.return_amount',
                'closing_requests.id as closing_id',
                'closing_requests.capital_withdrawal_amount as withdraw',
                'closing_requests.after_withdrawal_amount as reinvest',
                'closing_requests.profit_withdrawal_amount as total_profit',
            )
            ->orderByRaw("CASE WHEN bookings.status = 'complete' THEN 1 WHEN bookings.status = 'pending' THEN 2 WHEN bookings.status = 'pending_approval' THEN 3 ELSE 4 END, bookings.id DESC")
            ->get();

        $packages = Package::where('status', 1)->get();

        $total_investment = 0;

        foreach ($bookings as $key => $value) {
            if ('approved' == $value->status) {
                $total_investment += $value->value * $value->booking_quantity;
            }
        }

        $checkPendingApproval = Booking::where('user_id', auth()->user()->id)->where('status', 'pending_approval')->count();

        $bank = DB::table('investor_bank_details')
            ->join('banks', 'banks.id', '=', 'investor_bank_details.bank_name')
            ->where('investor_bank_details.user_id', auth()->user()->id)
            ->first();

        return view('dashboard', compact('bookings', 'packages', 'total_investment', 'checkPendingApproval', 'bank'));
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
        User::where('id', auth()->user()->id)

            ->update(['name' => $request->name, 'permanent_address' => $request->permanent_address, 'present_address' => $request->present_address, 'father_name' => $request->father_name, 'mother_name' => $request->mother_name, 'nid' => $request->nid, 'date_of_birth' => $request->date_of_birth, 'nominee_name' => $request->nominee_name, 'nominee_phone' => $request->nominee_phone, 'nominee_address' => $request->nominee_address, 'nominee_relation' => $request->nominee_relation, 'nominee_nid' => $request->nominee_nid]);

        return redirect()->back()->with('success', 'Profile Edited Successfully');
    }

    public function change_password()
    {
        return view('profile.change_password');
    }

    public function change_password_update(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $check = User::where('id', auth()->user()->id)->update(['password' => Hash::make($request->password)]);

        if ($check) {
            return redirect()->back()->with('success', 'Password Changed Successfully');
        }
    }

    public function bank_details(Request $request)
    {
        $data = InvestorBankDetail::where('user_id', auth()->user()->id)->first();
        $banks = DB::table('banks')->orderBy('bank_name')->get();
        $districts = DB::table('districts')->orderBy('district')->get();

        return view('investor.bank_details', compact('data', 'banks', 'districts'));
    }

    public function bank_details_update(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => ['required'],
            'branch_name' => ['required'],
            'account_name' => ['required'],
            'account_number' => ['required'],
            'routing_number' => ['required'],
        ]);

        $data = InvestorBankDetail::where('user_id', auth()->user()->id)->first();

        // dd($data);
        if (empty($data)) {
            $bank = new InvestorBankDetail();

            $bank['user_id'] = auth()->user()->id;
            $bank['bank_name'] = $request->bank_name;
            $bank['district'] = $request->district;
            $bank['branch_name'] = $request->branch_name;
            $bank['account_name'] = $request->account_name;
            $bank['account_number'] = $request->account_number;
            $bank['routing_number'] = $request->routing_number;
            $bank['note'] = $request->note;

            $check = $bank->save();

            if ($check) {
                return redirect()->back()->with('success', 'Updated Successfully');
            }
            echo 'error';
        } else {
            $check = InvestorBankDetail::where('user_id', auth()->user()->id)->update(['bank_name' => $request->bank_name, 'district' => $request->district, 'branch_name' => $request->branch_name, 'account_name' => $request->account_name, 'account_number' => $request->account_number, 'routing_number' => $request->routing_number, 'note' => $request->note, 'updated_at' => now()]);

            if ($check) {
                return redirect()->back()->with('success', 'Bank Details Changed Successfully');
            }
            echo 'error';
        }
    }
}
