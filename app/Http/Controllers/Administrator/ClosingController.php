<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Mail\MigrationConfirmationMail;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\ClosingRequest;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClosingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
        $this->middleware('role:superadmin');
    }

    public function edit($code)
    {
        $closing = ClosingRequest::where('booking_code', $code)->first();
        $package = Package::join('bookings', 'bookings.package_id', '=', 'packages.id')
            ->where('bookings.code', $code)
            ->select('packages.*')
            ->first();
        $migrationPackage = Package::where('id', $package->migration_package_id)->first();

        $booking = Booking::where('code', $code)->first();

        return view('administrator.closing.edit', compact('closing', 'package', 'booking', 'migrationPackage'));
    }

    public function update(Request $request, $code)
    {
        $validated = $request->validate([
            'package_to_withdraw' => 'required',
            'capital_withdrawal_amount' => 'required',
            'profit_withdrawal_amount' => 'required',
            'package_after_withdrawal' => 'required',
            'after_withdrawal_amount' => 'required',
            'status' => 'required',
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

            return redirect()->route('administrator.booking.show', $booking->id)->with('success', 'Closing Request Updated Successfully');
        }

        $closing = new ClosingRequest();

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

        return redirect()->route('administrator.booking.show', $booking->id)->with('success', 'Closing Request Updated Successfully');
    }

    public function migration($booking_code, $investor_id, $package_id)
    {
        $bookingPackage = DB::table('packages')
            ->join('bookings', 'bookings.package_id', '=', 'packages.id')
            ->where('bookings.code', $booking_code)
            ->select('packages.*')
            ->first();
        $migrationPackage = DB::table('packages')->where('id', $package_id)->first();
        $note = 'Migrated from '.$bookingPackage->name.' to '.$migrationPackage->name;

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

            $book = new Booking();

            do {
                $randomNumber = random_int(10000000, 99999999);
                $check = Booking::where('code', $randomNumber)->count();
            } while ($check);

            $book['code'] = $randomNumber;
            $book['user_id'] = $investor_id;
            $book['package_id'] = $package_id;
            $book['booking_quantity'] = $closing_request->package_after_withdrawal;
            $book['status'] = 'approved';
            $book['note'] = $note;
            $check = $book->save();

            if ($check) {
                $previousPaymentId = $previousPayment->id;

                $newBookingPayment = BookingPayment::find($previousPaymentId)->replicate();
                $newBookingPayment->booking_id = $book->id;
                $newBookingPayment->payment_method = 'migration';
                $newBookingPayment->deposit_reference = 'Previous Payment ID:'.$previousPaymentId.' and Booking ID: '.$booking_code.'. '.$note;
                $newBookingPayment->status = 'complete';
                $newBookingPayment->note = null;
                $newBookingPayment->save();

                DB::table('bookings')->where('code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'migrated']);
                DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'disbursed']);

                $reinvestAmount = $closing_request->after_withdrawal_amount;
                Mail::to($user_email)->send(new MigrationConfirmationMail($reinvestAmount));

                return redirect()->back()->with('success', 'Migrated Successfully, User is informed.');
            }
        } else {
            DB::table('bookings')->where('code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'withdrawn']);
            DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'disbursed']);

            return redirect()->back()->with('success', 'Withdrawal Request Successfully Updated');
        }

        return redirect()->back()->with('info', 'Something is Wrong!');
    }
}
