<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingPayment;
use App\Services\FileStorageService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private const DOCUMENT_PATHS = [
        'file' => ['path' => 'uploads/payment/documents', 'key' => 'payment_document'],
        'file2' => ['path' => 'uploads/payment/documents', 'key' => 'document_two'],
        'file3' => ['path' => 'uploads/payment/documents', 'key' => 'document_three'],
    ];

    public function __construct(private FileStorageService $fileStorage)
    {
        $this->middleware('auth');
    }

    public function proof($booking_id)
    {
        $checkPendingApproval = Booking::where('user_id', auth()->user()->id)->where('status', 'pending_approval')->count();
        if ($checkPendingApproval > 0) {
            return redirect()->back()->with('warning', 'You have already submitted a payment, please wait until it is approved.');
        }

        $data = Booking::where('user_id', auth()->user()->id)
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->select('bookings.id', 'packages.name', 'packages.value', 'bookings.status', 'packages.name', 'bookings.code', 'bookings.booking_quantity', 'bookings.code')->where('bookings.id', $booking_id)->get();

        $booking_id = $booking_id;

        return view('payment-proof', compact('data', 'booking_id'));
    }

    public function proof_store(Request $request)
    {
        $checkPendingApproval = Booking::where('user_id', auth()->user()->id)->where('status', 'pending_approval')->count();
        if ($checkPendingApproval > 0) {
            return redirect()->route('dashboard')->with('warning', 'You have already submitted a payment, please wait until it is approved.');
        }

        $validated = $request->validate([
            'booking_id' => 'required',
            'payment_method' => 'required',
            'payment_date' => 'required',
            'file' => 'required',
            'bank_name' => 'required',
            'branch' => 'required',
            'depositors_name' => 'required',
            'depositors_mobile_number' => 'required',
            'deposit_reference' => 'required',
        ]);

        $bookingPayment = new BookingPayment();

        // Fill all non-file inputs
        $nonFileInputs = collect(self::DOCUMENT_PATHS)->keys()->toArray();
        $bookingPayment->fill($request->except($nonFileInputs));

        // Process each file input based on DOCUMENT_PATHS configuration
        foreach (self::DOCUMENT_PATHS as $inputName => $config) {
            if ($request->hasFile($inputName)) {
                $bookingPayment->{$config['key']} = $this->fileStorage->replaceFile(
                    $bookingPayment->{$config['key']},
                    $request->file($inputName),
                    $config['path']
                );
            }
        }

        $bookingPayment['booking_id'] = $request->booking_id;
        $bookingPayment['payment_method'] = $request->payment_method;
        $bookingPayment['payment_date'] = $request->payment_date;
        $bookingPayment['bank'] = $request->bank_name;
        $bookingPayment['branch'] = $request->branch;
        $bookingPayment['depositors_name'] = $request->depositors_name;
        $bookingPayment['depositors_mobile_number'] = $request->depositors_mobile_number;
        $bookingPayment['deposit_reference'] = $request->deposit_reference;
        $bookingPayment['note'] = $request->note;
        $check = $bookingPayment->save();

        if ($check) {
            Booking::where('id', $request->booking_id)->update(['status' => 'pending_approval']);

            return redirect('/')->with('success', 'Payment verification request submitted successfully. It may take up to 2-7 Working Days to confirm the payment receiving and activation.');
        }

        return redirect()->back()->with('failure', 'Something went wrong! Please try again.');
    }
}
