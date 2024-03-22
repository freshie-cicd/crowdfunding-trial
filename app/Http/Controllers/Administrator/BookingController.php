<?php



namespace App\Http\Controllers\Administrator;



use App\Http\Controllers\Controller;

use App\Models\Booking;

use App\Models\Batch;

use App\Models\Project;

use App\Models\AgreementRequest;

use App\Models\pacSkage;

use App\Models\User;

use App\Models\BookingPayment;

use App\Http\Controllers\AgreementController;

use Illuminate\Http\Request;

use App\Mail\PaymentConfirmationMail;

use App\Mail\PaymentRejectionMail;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;

use PDF;



class BookingController extends Controller

{



    public function __construct()

    {

        $this->middleware('auth:administrator');
    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $bookings = Booking::where('status', 'pending')->get();



        return view('administrator.booking', compact('bookings'));
    }







    public function payment_pending(Request $request)
    {



        $pendings = BookingPayment::where('bookings.status', 'pending_approval')

            ->join('bookings', 'bookings.id', "=", 'booking_payments.booking_id')

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('users', 'users.id', '=', 'bookings.user_id')

            ->select('packages.name', 'packages.value', 'bookings.booking_quantity', 'bookings.code', 'booking_payments.payment_document', 'booking_payments.document_two', 'booking_payments.document_three', 'booking_payments.bank', 'booking_payments.branch', 'depositors_name', 'booking_payments.depositors_mobile_number', 'booking_payments.deposit_reference', 'booking_payments.payment_date', 'booking_payments.note', 'booking_payments.status', 'booking_payments.booking_id', 'users.name as investor_name', 'users.phone', 'users.email', 'users.id', 'booking_payments.payment_method')

            ->get();



        return view('administrator.payment_pending', compact('pendings'));
    }



    public function payment_approve($booking_id, $note, $user_id)
    {
        $user_id = Booking::where('id', $booking_id)->pluck('user_id');
        $email = User::where('id', $user_id)->pluck('email');
        $check = BookingPayment::where('booking_id', $booking_id)->update(['status' => 'complete']);
        if ($check) {
            Booking::where('id', $booking_id)->update(['status' => 'approved', 'note' => $note, 'discount' => $user_id, 'updated_by' => Auth::guard('administrator')->user()->email]);
            Mail::to($email)->send(new PaymentConfirmationMail());
            return redirect()->back()->with('success', 'Payment Approved Successfully');
        } else {
            echo "error";
        }
    }

    public function payment_reject($booking_id, $note, $user_id)
    {
        $user_id = Booking::where('id', $booking_id)->pluck('user_id');
        $email = User::where('id', $user_id)->pluck('email');
        $check = BookingPayment::where('booking_id', $booking_id)->update(['status' => 'rejected']);
        if ($check) {
            Booking::where('id', $booking_id)->update(['status' => 'rejected', 'note' => $note, 'discount' => $user_id, 'updated_by' => Auth::guard('administrator')->user()->email]);
            Mail::to($email)->send(new PaymentRejectionMail());
            return redirect()->back()->with('success', 'Payment Rejected Successfully');
        } else {
            echo "error";
        }
    }





    public function decision(Request $request)
    {
        if ($request->decision == 'approve') {
            $this->payment_approve($request->booking_id, $request->note, $request->user_id);
            return redirect()->back()->with('success', 'Approved Successfully');
        } else 
        if ($request->decision == 'reject') {
            $this->payment_reject($request->booking_id, $request->note, $request->user_id);
            return redirect()->back()->with('success', 'Rejected Successfully');
        }
    }





    public function modal_info($id)
    {



        $information = User::where('users.id', $id)

            ->join('bookings', 'users.id', '=', 'bookings.user_id')

            ->join('booking_payments', 'bookings.id', '=', 'booking_payments.booking_id')

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('project_batches', 'project_batches.id', '=', 'packages.batch_id')

            ->join('projects', 'projects.id', '=', 'project_batches.project_id')

            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.nid as user_nid',
                'users.phone as user_phone',
                'users.email as user_email',
                'users.father_name as user_father_name',
                'users.present_address as user_present_address',
                'users.nominee_name as user_nominee_name',
                'users.nominee_relation as user_nominee_relation',
                'users.nominee_phone as user_nominee_phone',

                'packages.name as package_name',
                'packages.value as package_value',
                'bookings.booking_quantity as booking_quantity',
                'bookings.status as booking_status',
                'bookings.id as booking_id',
                'bookings.code as booking_code',
                'booking_payments.payment_method as payment_method',
                'booking_payments.payment_document as payment_document',

                'booking_payments.payment_date as payment_date',
                'booking_payments.note as payment_note',
                'booking_payments.status as payment_status'
            )->get();



        return response()->json($information);
    }





    public function approved_list(Request $request)
    {

        $list = BookingPayment::where('booking_payments.status', 'complete')

            ->join('bookings', 'bookings.id', "=", 'booking_payments.booking_id')

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('users', 'users.id', '=', 'bookings.user_id')

            ->select('packages.name', 'packages.value', 'bookings.booking_quantity', 'bookings.code', 'booking_payments.payment_document', 'booking_payments.payment_date', 'booking_payments.note', 'booking_payments.status', 'booking_payments.booking_id', 'users.name as investor_name', 'users.phone', 'users.email', 'users.id', 'bookings.updated_by', 'booking_payments.payment_method')

            ->get();



        return view('administrator.payment_approved', compact('list'));
    }





    public function approved_list_bybatch(Request $request)
    {

        $list = BookingPayment::where('booking_payments.status', 'complete')->where('bookings.package_id', $request->package)

            ->join('bookings', 'bookings.id', "=", 'booking_payments.booking_id')

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('users', 'users.id', '=', 'bookings.user_id')

            ->select('packages.name', 'packages.value', 'bookings.booking_quantity', 'bookings.code', 'booking_payments.payment_document', 'booking_payments.payment_date', 'booking_payments.note', 'booking_payments.status', 'booking_payments.booking_id', 'users.name as investor_name', 'users.phone', 'users.email', 'users.id', 'bookings.updated_by', 'booking_payments.payment_method')

            ->get();



        return view('administrator.payment_approved', compact('list'));
    }





    public function hard_copy_agreement_requests()
    {

        $dataX = AgreementRequest::where('agreement_requests.status', 'requested')
            ->join('bookings', 'bookings.code', '=', 'agreement_requests.booking_code')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->get();



        return view('administrator.agreement.requests', compact('dataX'));
    }



    public function hard_copy_download($code)

    {

        $booking_info = Booking::where('bookings.code', $code)

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('project_batches', 'packages.batch_id', '=', 'project_batches.id')

            ->join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')

            ->join('users', 'users.id', '=', 'bookings.user_id')

            ->select('users.*', 'bookings.booking_quantity', 'packages.value', 'packages.note', 'bookings.code', 'project_batches.ending_date', 'project_batches.starting_date', 'bookings.code', 'booking_payments.payment_date', 'project_batches.project_id')

            ->get();



        $total_value = $booking_info[0]->value * $booking_info[0]->booking_quantity;

        $ac = new AgreementController;

        $inWord = $ac->inWords($total_value);







        $data = [

            'name' => $booking_info[0]->name,

            'nid' => $booking_info[0]->nid,

            'father_name' => $booking_info[0]->father_name,

            'mother_name' => $booking_info[0]->mother_name,

            'permanent_address' => $booking_info[0]->permanent_address,

            'present_address' => $booking_info[0]->present_address,

            'nominee_name' => $booking_info[0]->nominee_name,

            'nominee_address' => $booking_info[0]->nominee_address,

            'nominee_relation' => $booking_info[0]->nominee_relation,

            'booking_id' => $code,

            'project_ending_date' => $booking_info[0]->ending_date,

            'project_starting_date' => $booking_info[0]->starting_date,

            'value' => $booking_info[0]->value,

            'booking_quantity' => $booking_info[0]->booking_quantity,

            'booking_code' => $booking_info[0]->code,

            'inWords' => $inWord,

            'payment_date' => $booking_info[0]->payment_date,

        ];



        $file_name = $booking_info[0]->name . '_' . $code . '.pdf';

        if ($booking_info[0]->project_id == 1) {

            $pdf = PDF::loadView('administrator.agreement.hardcopy', $data, [], [

                'format' => [209.55, 336.55],

            ]);
        } else {
            $pdf = PDF::loadView('agreement.paper_greenify', $data, [], [
                'format' => [209.55, 336.55],
            ]);
        }



        return $pdf->stream($file_name);
    }
}
