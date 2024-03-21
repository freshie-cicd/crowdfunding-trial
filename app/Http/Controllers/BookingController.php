<?php



namespace App\Http\Controllers;



use App\Models\Booking;

use App\Models\BookingPayment;

use Illuminate\Http\Request;

use App\Mail\PaymentConfirmationMail;

use Illuminate\Support\Facades\Mail;



class BookingController extends Controller

{



    public function __construct()

    {

        $this->middleware('auth');
    }





    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $bookings = Booking::where('bookings.user_id', auth()->user()->id)

            ->where('bookings.status', 'pending')

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('facebook_groups', 'facebook_groups.batch_id', '=', 'packages.batch_id')

            ->select('bookings.code', 'packages.code as pcode', 'packages.value', 'bookings.booking_quantity', 'bookings.status', 'bookings.id', 'packages.batch_id', 'facebook_groups.url')

            ->get();





        $bookings_ = Booking::where('bookings.user_id', auth()->user()->id)->where('booking_payments.status', 'complete')

            ->join('packages', 'bookings.package_id', '=', 'packages.id')

            ->join('booking_payments', 'bookings.id', '=', 'booking_payments.booking_id')

            ->select('bookings.id', 'packages.name', 'packages.value', 'packages.name', 'bookings.code', 'bookings.booking_quantity', 'booking_payments.status')

            ->get();

        // dump($bookings_);

        $total_investment = 0;

        foreach ($bookings_ as $booking) {

            $total_investment = $total_investment + $booking->value * $booking->booking_quantity;
        }

        return view('mybooking', compact('bookings', 'total_investment'));
    }





    public function mybookings($status)
    {



        $bookings = Booking::where('bookings.user_id', auth()->user()->id)

            ->where('bookings.status', $status)

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('facebook_groups', 'facebook_groups.batch_id', '=', 'packages.batch_id')

            ->select('bookings.code', 'packages.code as pcode', 'packages.value', 'bookings.booking_quantity', 'bookings.status', 'bookings.id', 'packages.batch_id', 'facebook_groups.url', 'packages.status as package_status')

            ->get();


        if ($status == 'pending') {
            $bookings = $bookings->where('package_status', 1);
        }





        $bookings_ = Booking::where('bookings.user_id', auth()->user()->id)->where('booking_payments.status', 'complete')

            ->join('packages', 'bookings.package_id', '=', 'packages.id')

            ->join('booking_payments', 'bookings.id', '=', 'booking_payments.booking_id')

            ->select('bookings.id', 'packages.name', 'packages.value', 'packages.name', 'bookings.code', 'bookings.booking_quantity', 'booking_payments.status')

            ->get();

        // dump($bookings_);

        $total_investment = 0;

        foreach ($bookings_ as $booking) {

            $total_investment = $total_investment + $booking->value * $booking->booking_quantity;
        }

        return view('mybooking', compact('bookings', 'total_investment'));
    }









    public function proof($booking_id)
    {



        $data = Booking::where('user_id', auth()->user()->id)

            ->join('packages', 'bookings.package_id', '=', 'packages.id')

            ->select('bookings.id', 'packages.name', 'packages.value', 'bookings.status', 'packages.name', 'bookings.code', 'bookings.booking_quantity', 'bookings.code')->where('bookings.id', $booking_id)->get();



        $booking_id = $booking_id;



        return view('payment-proof', compact('data', 'booking_id'));
    }











    public function proof_store(Request $request)

    {

        //dd($request->all());

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



        $check_pending_approval = Booking::where('user_id', auth()->user()->id)->where('status', 'pending_approval')->count();



        if ($check_pending_approval > 0) {

            return redirect()->back()->with('warning', 'You have already submitted a payment, please wait until it is approved.');
        } else {



            $bookingPayment = new BookingPayment;



            $bookingPayment['booking_id'] = $request->booking_id;

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



            $check = $bookingPayment->save();



            if ($check) {

                Booking::where('id', $request->booking_id)->update(['status' => 'pending_approval']);

                return redirect('/')->with('success', 'Payment verification request submitted successfully. It may take up to 2 Working Days to confirm the payment receiving and activation.');
            } else {

                return redirect()->back()->with('failure', 'Something went wrong! Please try again.');
            }
        }
    }
}
