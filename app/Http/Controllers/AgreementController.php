<?php

namespace App\Http\Controllers;

use App\Models\AgreementRequest;
use App\Models\Booking;
use Illuminate\Http\Request;

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

        if (null != auth()->user()->permanent_address && null != auth()->user()->present_address && null != auth()->user()->father_name && null != auth()->user()->mother_name && null != auth()->user()->nid && null != auth()->user()->date_of_birth && null != auth()->user()->nominee_name && null != auth()->user()->nominee_phone && null != auth()->user()->nominee_address && null != auth()->user()->nominee_relation && null != auth()->user()->nominee_nid && null != auth()->user()->nominee_relation) {
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
        $booking_info = Booking::with('package', 'bookingPayment', 'user')->whereId($booking_id)->first();

        $total_value = $booking_info->package->value * $booking_info->booking_quantity;

        $inWord = $this->inWords($total_value);

        $data = [
            'name' => $booking_info->user->name,
            'nid' => $booking_info->user->nid,
            'father_name' => $booking_info->user->father_name,
            'mother_name' => $booking_info->user->mother_name,
            'permanent_address' => $booking_info->user->permanent_address,
            'present_address' => $booking_info->user->present_address,
            'nominee_name' => $booking_info->user->nominee_name,
            'nominee_address' => $booking_info->user->nominee_address,
            'nominee_relation' => $booking_info->user->nominee_relation,
            'booking_id' => $booking_id,
            'project_ending_date' => $booking_info->package->end_date,
            'project_starting_date' => $booking_info->package->start_date,
            'value' => $booking_info->package->value,
            'booking_quantity' => $booking_info->booking_quantity,
            'booking_code' => $booking_info->code,
            'inWords' => $inWord,
            'payment_date' => $booking_info->bookingPayment->payment_date,
        ];

        $file_name = $booking_info->user->name.'_'.$booking_id.'.pdf';

        if (1 == $booking_info->package->project_id) {
            $pdf = \PDF::loadView('agreement.paper', $data);
        } elseif (2 == $booking_info->package->project_id) {
            $pdf = \PDF::loadView('agreement.paper_greenify', $data);
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
        $str = [];
        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
        ];
        $digits = ['', 'hundred', 'thousand', 'lakh', 'crore'];
        while ($i < $digits_length) {
            $divider = (2 == $i) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += 10 == $divider ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = (1 == $counter && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number].' '.$digits[$counter].$plural.' '.$hundred : $words[floor($number / 10) * 10].' '.$words[$number % 10].' '.$digits[$counter].$plural.' '.$hundred;
            } else {
                $str[] = null;
            }
        }
        $Taka = implode('', array_reverse($str));
        $poysa = ($decimal) ? ' and '.($words[$decimal / 10].' '.$words[$decimal % 10]).' poysa' : '';

        return ($Taka ? $Taka.'taka ' : '').$poysa;
    }

    public function hard_copy_request(Request $request, $id)
    {
        $booking_code = Booking::where('id', $id)->pluck('code')->first();
        $count = AgreementRequest::where('booking_code', $booking_code)->count();

        if ($count > 0) {
            return redirect()->route('agreement.index')->with('warning', 'You have already requested for hard copy against this booking.');
        }

        $data = Booking::where('bookings.id', $id)->where('bookings.status', 'approved')
            ->leftJoin('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->select('bookings.booking_quantity', 'packages.value', 'packages.note', 'bookings.code', 'packages.end_date', 'bookings.code', 'booking_payments.payment_date')
            ->get();

        return view('agreement.hardcopy_request', compact('data'));
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
        }

        $req = new AgreementRequest();

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
