<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\AgreementRequest;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class AgreementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        $bookings = Booking::where('bookings.user_id', auth()->user()->id)
            ->where('bookings.status', 'approved')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->select('bookings.code', 'packages.code as pcode', 'packages.value', 'bookings.booking_quantity', 'bookings.status', 'bookings.id')
            ->get();


        if (auth()->user()->permanent_address != NULL && auth()->user()->present_address != NULL && auth()->user()->father_name != NULL && auth()->user()->mother_name != NULL && auth()->user()->nid != NULL && auth()->user()->date_of_birth != NULL && auth()->user()->nominee_name != NULL && auth()->user()->nominee_phone != NULL && auth()->user()->nominee_address != NULL && auth()->user()->nominee_relation != NULL && auth()->user()->nominee_nid != NULL && auth()->user()->nominee_relation != NULL) {
            $is_profile_complete = true;
        } else {
            $is_profile_complete = false;
            return redirect('/profile/edit')->with('message', 'Please complete your profile before downloading agreement paper.');
        }

        // dump($is_profile_complete);



        return view('agreement.index', compact('bookings', 'is_profile_complete'));
    }



    public function download($booking_id)
    {

        $booking_info = Booking::where('bookings.id', $booking_id)
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->join('project_batches', 'packages.batch_id', '=', 'project_batches.id')
            ->join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->select('bookings.booking_quantity', 'packages.value', 'packages.note', 'bookings.code', 'project_batches.starting_date', 'project_batches.ending_date', 'bookings.code', 'booking_payments.payment_date', 'project_batches.project_id')
            ->get();

        $total_value = $booking_info[0]->value * $booking_info[0]->booking_quantity;
        $inWord = $this->inWords($total_value);


        $data = [
            'name' => auth()->user()->name,
            'nid' => auth()->user()->nid,
            'father_name' => auth()->user()->father_name,
            'mother_name' => auth()->user()->mother_name,
            'permanent_address' => auth()->user()->permanent_address,
            'present_address' => auth()->user()->present_address,
            'nominee_name' => auth()->user()->nominee_name,
            'nominee_address' => auth()->user()->nominee_address,
            'nominee_relation' => auth()->user()->nominee_relation,
            'booking_id' => $booking_id,
            'project_ending_date' => $booking_info[0]->ending_date,
            'project_starting_date' => $booking_info[0]->starting_date,
            'value' => $booking_info[0]->value,
            'booking_quantity' => $booking_info[0]->booking_quantity,
            'booking_code' => $booking_info[0]->code,
            'inWords' => $inWord,
            'payment_date' => $booking_info[0]->payment_date,
        ];

        $file_name = auth()->user()->name . '_' . $booking_id . '.pdf';

        if ($booking_info[0]->project_id == 1) {
            $pdf = PDF::loadView('agreement.paper', $data);
        } else if ($booking_info[0]->project_id == 2) {
            $pdf = PDF::loadView('agreement.paper_greenify', $data);
        } else {
            dd('Invalid Project');
        }


        return $pdf->stream($file_name);
    }



    public function inWords($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Taka = implode('', array_reverse($str));
        $poysa = ($decimal) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' poysa' : '';
        return ($Taka ? $Taka . 'taka ' : '') . $poysa;
    }



    public function hard_copy_request(Request $request, $id)
    {
        $booking_code_x = Booking::where('id', $id)->select('code')->get();
        $count = AgreementRequest::where('booking_code', $booking_code_x[0]->code)->count();

        if ($count > 0) {
            return redirect('/agreements')->with('warning', 'You have already requested for hard copy against this booking.');
        } else {

            $data = Booking::where('bookings.id', $id)->where('bookings.status', 'approved')
                ->join('packages', 'packages.id', '=', 'bookings.package_id')
                ->join('project_batches', 'packages.batch_id', '=', 'project_batches.id')
                ->join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
                ->select('bookings.booking_quantity', 'packages.value', 'packages.note', 'bookings.code', 'project_batches.ending_date', 'bookings.code', 'booking_payments.payment_date')
                ->get();

            //dump($data);

            return view('agreement.hardcopy_request', compact('data'));
        }
    }


    public function hard_copy_request_store(Request $request)
    {
        $validated = $request->validate([
            'booking_code_x' => 'required',
            'courier' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'courier_branch' => 'required',
        ]);

        $count = AgreementRequest::where('booking_code', $request->booking_code_x)->count();

        if ($count > 0) {
            return redirect('/agreements')->with('success', 'You have already requested for hard copy against this booking.');
        } else {

            $req = new AgreementRequest;

            $req['booking_code'] = $request->booking_code_x;
            $req['shipping_address'] = $request->address;
            $req['courier_service'] = $request->courier;
            $req['courier_branch'] = $request->courier_branch;
            $req['phone'] = $request->phone;
            $req['note'] = $request->note;

            $q = $req->save();

            if ($q) {
                return redirect('/agreements')->with('success', 'Hard Copy Agreement Requested Successfully');
            }
        }
    }
}
