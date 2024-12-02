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

    public function agreementRequests(Request $request)
    {
        $query = AgreementRequest::query()
            ->with(['booking.user' => function ($query) {
                $query->select('id', 'name');
            }, 'booking.package' => function ($query) {
                $query->select('id', 'name');
            }]);

        // Handle status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('courier_service', 'LIKE', "%{$search}%")
                    ->orWhere('courier_branch', 'LIKE', "%{$search}%")
                    ->orWhereHas('booking.package', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('booking.user', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Handle sorting
        $sortField = $request->input('sort_by', 'status');
        $sortDirection = $request->input('sort_direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Paginate results
        $agreementRequests = $query->paginate($request->per_page ?? 10)->appends($request->query());

        // Define the statuses array
        $statuesArray = ['requested', 'processing', 'shipped', 'delivered', 'hold', 'rejected'];

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
            ->join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select('users.*', 'bookings.booking_quantity', 'packages.value', 'packages.note', 'bookings.code', 'packages.end_date', 'packages.start_date', 'bookings.code', 'booking_payments.payment_date', 'packages.project_id')
            ->get();
        // dd($booking_info);

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
            'project_ending_date' => $booking_info[0]->end_date,
            'project_starting_date' => $booking_info[0]->start_date,
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
    public function closingReport(Request $request)
    {
        $role = auth('administrator')->user()->role;
        $packages = DB::table('packages')->where('maturity', 1)->get();

        $data = Booking::whereIn('bookings.status', ['approved', 'withdrawn', 'migrated'])->where('packages.maturity', 1)
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('investor_bank_details', 'investor_bank_details.user_id', '=', 'bookings.user_id')
            ->leftJoin('banks', 'banks.id', '=', 'investor_bank_details.bank_name')
            ->leftJoin('closing_requests', 'closing_requests.booking_code', '=', 'bookings.code')
            ->leftJoin('agreement_requests', 'agreement_requests.booking_code', '=', 'bookings.code')
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

        if (!empty($request->package_id)) {
            $data = $data->where('package_id', '=', $request->package_id);
        }

        return view('administrator.reports.closing', compact('data', 'role', 'packages'));
    }

    public function closingSheet(Request $request)
    {
        $filterPackage = $request->package_id;

        $closingInfo = DB::table('closing_requests')
            ->leftJoin('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
            ->leftJoin('investor_bank_details', 'investor_bank_details.user_id', '=', 'bookings.user_id')
            ->leftJoin('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('agreement_requests', 'agreement_requests.booking_code', '=', 'bookings.code')
            ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
            ->select(
                'bookings.id',
                'bookings.code as booking_code',
                'bookings.booking_quantity as booking_quantity',
                'bookings.status',
                'investor_bank_details.account_name',
                'investor_bank_details.account_number',
                'investor_bank_details.routing_number',
                'closing_requests.capital_withdrawal_amount',
                'closing_requests.profit_withdrawal_amount',
                'users.phone',
                'closing_requests.user_id'
            )
            ->when($filterPackage, function ($query, $filterPackage) {
                $query->where('bookings.package_id', $filterPackage);
            })
            ->orderBy('closing_requests.id')->get();

        $counter = 1;
        $check = [' ', '.', '-', '+'];

        $packages = DB::table('packages')->where('maturity', 1)->get();

        if ($request->shortlist) {
            $users = DB::table('users')->join('bookings', 'bookings.user_id', '=', 'users.id')->join('closing_requests', 'closing_requests.booking_code', '=', 'bookings.code')
                ->when($filterPackage, function ($query, $filterPackage) {
                    $query->where('bookings.package_id', $filterPackage);
                })->distinct()->select('users.id')->orderBy('closing_requests.id')->get();

            return view('administrator.reports.bank_sheet_shortlist', compact('closingInfo', 'counter', 'check', 'packages', 'users'));
        }

        return view('administrator.reports.bank_sheet', compact('closingInfo', 'counter', 'check', 'packages'));
    }
}
