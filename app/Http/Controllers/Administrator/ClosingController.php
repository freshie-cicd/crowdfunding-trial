<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClosingRequest;
use App\Models\User;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\Package;
use App\Mail\MigrationConfirmationMail;
use Illuminate\Support\Facades\Mail;


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
            ->leftJoin('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
            ->leftJoin('districts', 'investor_bank_details.district', '=', 'districts.id')
            ->leftJoin('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
            ->where('closing_requests.status', 'requested')
            ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district')
            ->get();

        return view('administrator.closing.index', compact('data'));
    }

    public function edit($code)
    {
        $closing = ClosingRequest::where('booking_code', $code)->first();
        $package = Package::join('bookings', 'bookings.package_id', '=', 'packages.id')
            ->where('bookings.code', $code)
            ->select('packages.*')
            ->first();

        $booking = Booking::where('code', $code)->first();
        $closingInit = DB::table('closing_init')->where('package_id', $booking->package_id)->first();

        return view('administrator.closing.edit', compact('closing', 'package', 'booking', 'closingInit'));
    }


    public function update(Request $request, $code)
    {
        $validated = $request->validate([
            'package_to_withdraw' => 'required',
            'capital_withdrawal_amount' => 'required',
            'profit_withdrawal_amount' => 'required',
            'package_after_withdrawal' => 'required',
            'after_withdrawal_amount' => 'required',
            'status' => 'required'
        ]);

        $booking = Booking::where('code', $code)->select('id', 'user_id')->first();

        $closing = ClosingRequest::where('booking_code', $code)->first();

        if ($closing) {
            $closing->user_id = $booking->user_id;
            $closing->booking_code = $code;
            $closing->package_to_withdraw = $request->package_to_withdraw;
            $closing->capital_withdrawal_amount = $request->capital_withdrawal_amount;
            $closing->profit_withdrawal_amount = $request->profit_withdrawal_amount;
            $closing->package_after_withdrawal = $request->package_after_withdrawal;
            $closing->after_withdrawal_amount = $request->after_withdrawal_amount;
            $closing->note = $request->note;
            $closing->status = $request->status;

            $closing->update();
            return  redirect()->route('administrator.booking.show', $booking->id)->with('success', 'Closing Request Updated Successfully');
        }

        $closing = new ClosingRequest;

        $closing->user_id = $booking->user_id;
        $closing->booking_code = $code;
        $closing->package_to_withdraw = $request->package_to_withdraw;
        $closing->capital_withdrawal_amount = $request->capital_withdrawal_amount;
        $closing->profit_withdrawal_amount = $request->profit_withdrawal_amount;
        $closing->package_after_withdrawal = $request->package_after_withdrawal;
        $closing->after_withdrawal_amount = $request->after_withdrawal_amount;
        $closing->note = $request->note;
        $closing->status = $request->status;

        $closing->save();

        return  redirect()->route('administrator.booking.show', $booking->id)->with('success', 'Closing Request Updated Successfully');
    }


    public function profitReturn()
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
            ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district')
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
            ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district')
            ->get();

        return view('administrator.closing.capital', compact('data'));
    }



    public function migration($booking_code, $investor_id, $package_id)
    {
        $closing_request = DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->where('status', 'requested')->first();
        $user_email = DB::table('users')->where('id', $investor_id)->select('email')->first();

        // if the user has a package to migrate

        if ($closing_request && $closing_request->package_after_withdrawal > 0) {

            $previousPayment = DB::table('booking_payments')
                ->join('bookings', 'bookings.id', '=', 'booking_payments.booking_id')
                ->where('bookings.code', $booking_code)
                ->select('booking_payments.*')
                ->first();

            if (!$previousPayment) {
                return redirect()->back()->with('info', 'You don\'t have any previous payment proof!');
            }

            $book = new Booking;

            do {
                $randomNumber = random_int(10000000, 99999999);
                $check = Booking::where('code', $randomNumber)->count();
            } while ($check);

            $book['code'] = $randomNumber;
            $book['user_id'] = $investor_id;
            $book['package_id'] = $package_id;
            $book['booking_quantity'] = $closing_request->package_after_withdrawal;
            $book['status'] = 'approved';
            $book['note'] = 'Migrated from batch 4 to 6';
            $check = $book->save();

            if ($check) {

                $previousPaymentId = $previousPayment->id;


                $newBookingPayment = BookingPayment::find($previousPaymentId)->replicate();
                $newBookingPayment->booking_id = $book->id;
                $newBookingPayment->payment_method = 'migration';
                $newBookingPayment->deposit_reference = "Previous Payment ID:" . $previousPaymentId . " and Booking ID: " .  $booking_code . " migrated from Batch 4 to Batch 6";
                $newBookingPayment->status = 'complete';
                $newBookingPayment->note = null;
                $newBookingPayment->save();


                DB::table('bookings')->where('code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'migrated']);
                DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'disbursed']);

                $reinvestAmount = $closing_request->after_withdrawal_amount;
                Mail::to($user_email)->send(new MigrationConfirmationMail($reinvestAmount));

                return redirect()->back()->with('success', "Migrated Successfully, User is informed.");
            }
        } else {
            DB::table('bookings')->where('code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'withdrawn']);
            DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'disbursed']);
            return redirect()->back()->with('success', 'Withdrawal Request Successfully Updated');
        }


        return redirect()->back()->with('info', 'Something is Wrong!');
    }
}
