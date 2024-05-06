<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\Controller;
use App\Models\AgreementRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reports extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function agreementRequests()
    {
        $agreementRequests = AgreementRequest::join('bookings', 'bookings.code', '=', 'agreement_requests.booking_code')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->leftJoin('packages', 'packages.id', '=', 'bookings.package_id')
            ->select(
                'agreement_requests.*',
                'users.*',
                'packages.name as package_name',
                'agreement_requests.note as note',
                'agreement_requests.id as id'
            )
            ->get();

        // get all status of agreement request
        $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'agreement_requests' AND COLUMN_NAME = 'status'";
        $dbName = env('DB_DATABASE');
        $statusEnum = DB::select($query, [$dbName]);
        $statuesArray = explode("','", substr($statusEnum[0]->COLUMN_TYPE, 6, -2));

        return view('administrator.agreement.requests', compact('agreementRequests', 'statuesArray'));
    }

    public function updateAgreementRequestStatus(Request $request)
    {
        $agreementRequest = AgreementRequest::find($request->id);
        $agreementRequest->status = $request->status;
        $agreementRequest->save();

        return response()->json(['status' => 'success', 'message' => 'Agreement request status updated successfully']);
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
        $ac = new AgreementController();
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

        $file_name = $booking_info[0]->name.'_'.$code.'.pdf';

        if (1 == $booking_info[0]->project_id) {
            $pdf = \PDF::loadView('administrator.agreement.hardcopy', $data, [], [
                'format' => [209.55, 336.55],
            ]);
        } else {
            $pdf = \PDF::loadView('administrator.agreement.hardcopy_greenify', $data, [], [
                'format' => [209.55, 336.55],
            ]);
        }

        return $pdf->stream($file_name);
    }

    // for customer support
    public function closingReport()
    {
        $role = auth('administrator')->user()->role;

        $data = Booking::whereIn('bookings.status', ['approved', 'withdrawn', 'migrated'])
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('investor_bank_details', 'investor_bank_details.user_id', '=', 'bookings.user_id')
            ->leftJoin('banks', 'banks.id', '=', 'investor_bank_details.bank_name')
            ->leftJoin('closing_requests', 'closing_requests.booking_code', '=', 'bookings.code')
            ->leftJoin('agreement_requests', 'agreement_requests.booking_code', '=', 'bookings.code')
            ->where('bookings.package_id', '=', 2)
            ->select(
                'bookings.*',
                'packages.value as package_value',
                'users.name',
                'users.phone',
                'packages.name as package_name',
                'banks.bank_name',
                'investor_bank_details.account_name',
                'investor_bank_details.account_number',
                'investor_bank_details.routing_number',
                'closing_requests.id as closing_request_id',
                'closing_requests.after_withdrawal_amount as reinvestment_amount',
                'closing_requests.capital_withdrawal_amount as withdrawal_amount',
                'closing_requests.profit_withdrawal_amount as profit_amount',
                'agreement_requests.status as agreement_request_status',
                'closing_requests.status as closing_request_status',
            )
            ->orderBy('bookings.user_id', 'asc')
            ->get();

        return view('administrator.reports.closing', compact('data', 'role'));
    }
}
