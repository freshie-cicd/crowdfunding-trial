<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPayment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
        $this->middleware('role:superadmin');
    }

    public function proof($booking_id)
    {
        $data = Booking::where('bookings.id', $booking_id)
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->select('bookings.*', 'bookings.id as id', 'packages.name', 'packages.value', 'bookings.status', 'packages.name', 'bookings.code', 'bookings.booking_quantity', 'bookings.code')
            ->first();

        return view('administrator.payment.create', compact('data', 'booking_id'));
    }


    public function proof_store(Request $request, $booking_id)
    {


        $validated = $request->validate([
            'payment_method' => 'required',
            'payment_date' => 'required',
            'file' => 'required',
            'bank_name' => 'required',
            'branch' => 'required',
            'depositors_name' => 'required',
            'depositors_mobile_number' => 'required',
            'deposit_reference' => 'required',
        ]);



        $bookingPayment = new BookingPayment;
        $bookingPayment['booking_id'] = $booking_id;
        $bookingPayment['payment_method'] = $request->payment_method;
        $bookingPayment['payment_date'] = $request->payment_date;

        $file = $request->file('file');
        if (!empty($file)) {
            $file_new_name = rand() . '.' . $request->file('file')->getClientOriginalExtension();
            $file->move(public_path('uploads/payment/documents/'), $file_new_name);
            $bookingPayment['payment_document'] = "/uploads/payment/documents/" . $file_new_name;
        }

        $file2 = $request->file('file2');
        if (!empty($file2)) {
            $file2_new_name = rand() . '.' . $request->file('file2')->getClientOriginalExtension();
            $file2->move(public_path('uploads/payment/documents/'), $file2_new_name);
            $bookingPayment['document_two'] = "/uploads/payment/documents/" . $file2_new_name;
        }


        $file3 = $request->file('file3');
        if (!empty($file3)) {
            $file3_new_name = rand() . '.' . $request->file('file3')->getClientOriginalExtension();
            $file3->move(public_path('uploads/payment/documents/'), $file3_new_name);
            $bookingPayment['document_three'] = "/uploads/payment/documents/" . $file3_new_name;
        }


        $bookingPayment['bank'] = $request->bank_name;
        $bookingPayment['branch'] = $request->branch;
        $bookingPayment['depositors_name'] = $request->depositors_name;
        $bookingPayment['depositors_mobile_number'] = $request->depositors_mobile_number;
        $bookingPayment['deposit_reference'] = $request->deposit_reference;
        $bookingPayment['note'] = $request->note;
        $bookingPayment['status'] = 'complete';
        $check = $bookingPayment->save();

        if ($check) {
            Booking::where('id', $booking_id)->update(['status' => 'approved']);

            return redirect()->route('administrator.booking.show', $booking_id)->with('success', 'Payment verification request approved successfully and booking approved.');
        }

        return redirect()->back()->with('failure', 'Something went wrong! Please try again.');
    }
}
