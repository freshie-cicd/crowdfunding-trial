<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class ClosingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $bookings = DB::table('closing_init')->where('closing_init.status', 'initiated')->where('bookings.user_id', auth()->user()->id)->where('bookings.status', 'approved')
            ->join('bookings', 'bookings.package_id', '=', 'closing_init.package_id')
            ->join('packages', 'packages.id', '=', 'closing_init.package_id')
            ->join('closing_requests', 'closing_requests.booking_code', '=', 'bookings.code', 'left outer')
            ->select('bookings.code', 'packages.code as pcode', 'packages.value', 'bookings.booking_quantity', 'bookings.status', 'bookings.id', 'packages.batch_id', 'closing_init.status as closing_status', 'closing_init.profit_value', 'closing_requests.status as processing_status', 'closing_requests.package_to_withdraw', 'closing_requests.capital_withdrawal_amount', 'closing_requests.package_after_withdrawal', 'closing_requests.after_withdrawal_amount', 'closing_requests.profit_withdrawal_amount',)
            ->get();

        return view('closing.index', compact('bookings'));
    }


    public function withdrawal_request($code)
    {

        $bank = DB::table('investor_bank_details')->join('banks', 'banks.id', '=', 'investor_bank_details.bank_name')->where('investor_bank_details.user_id', auth()->user()->id)->first();

        if (!$bank) {
            return redirect('investor/bank')->with('warning', 'You have to fillup bank information before requesting for withdrawal.');
        }

        $check = DB::table('closing_requests')->where('booking_code', $code)->count();

        if (!$check) {

            $data = Booking::where('bookings.code', $code)->where('bookings.user_id', auth()->user()->id)
                ->join('packages', 'bookings.package_id', '=', 'packages.id')
                ->join('closing_init', 'closing_init.package_id', '=', 'bookings.package_id')
                ->select('bookings.code as booking_code', 'bookings.booking_quantity', 'bookings.status as booking_status', 'packages.id as package_id', 'packages.name as package_name', 'packages.value as package_value', 'packages.status as package_status', 'closing_init.profit_value')
                ->first();


            if ($data) {
                return view('closing.request', compact('data', 'bank'));
            } else {
                return "Cheating?";
            }
        } else {
            return redirect()->back()->with('warning', 'You already have a request pending for this booking code.');
        }
    }



    public function withdrawal_request_store(Request $request)
    {

        $validated = $request->validate([
            'booking_code' => 'required',
            'reinvest_quantity' => 'required',
            'bank' => 'required',
            'profit' => 'required',
            'reinvest_quantity' => 'required',
            'package_price' => 'required',
        ]);

        $withdrawal_quantity = $request->booking_quantity - $request->reinvest_quantity;
        $withdrawal_amount = $withdrawal_quantity * $request->package_price;
        $reinvest_amount = $request->reinvest_quantity * $request->package_price;

        $check = DB::table('closing_requests')->insert(['user_id' => auth()->user()->id, 'booking_code' => $request->booking_code, 'package_to_withdraw' => $withdrawal_quantity, 'capital_withdrawal_amount' => $withdrawal_amount, 'package_after_withdrawal' => $request->reinvest_quantity, 'after_withdrawal_amount' => $reinvest_amount, 'profit_withdrawal_amount' => $request->profit, 'is_bank_detail_correct' => $request->bank, 'note' => $request->note]);

        if ($check) {
            return redirect('mature-batches')->with('success', 'Withdrawal Request Submitted Successfully');
        } else {
            return redirect()->back()->with('warning', 'Please try again.');
        }
    }
}
