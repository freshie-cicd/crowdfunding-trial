<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Mail\PaymentConfirmationMail;
use App\Mail\PaymentRejectionMail;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\ClosingRequest;
use App\Models\InvestorBankDetail;
use App\Models\Package;
use App\Models\User;
use App\Traits\FormatsNumbers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    use FormatsNumbers;

    public function __construct()
    {
        $this->middleware('auth:administrator');
        $this->middleware('role:superadmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dataSize = $request->query('dataSize', 10);
        $dataSize = filter_var($dataSize, FILTER_VALIDATE_INT, [
            'options' => [
                'default' => 10,
                'min_range' => 1,
                'max_range' => 100,
            ],
        ]);

        $status = $request->query('status', '');
        $package = $request->query('package', '');
        $search = $request->query('search', '');
        $migration = $request->query('migration', '');

        $bookings = Booking::when($status, function ($query, $status) {
            return $query->where('bookings.status', $status);
        })->when($package, function ($query, $package) {
            return $query->where('bookings.package_id', $package);
        })->when($search, function ($query, $search) {
            return $query->where('bookings.code', 'like', '%'.$search.'%')
                ->orWhere('users.name', 'like', '%'.$search.'%')
                ->orWhere('users.phone', 'like', '%'.$search.'%')
                ->orWhere('users.email', 'like', '%'.$search.'%')
                ->orWhere('bookings.note', 'like', '%'.$search.'%');
        })
            ->when($migration, function ($query, $migration) {
                return $query->where('closing_requests.package_after_withdrawal', '>', 0);
            })
            ->leftJoin('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
            ->leftJoin('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->leftJoin('closing_requests', 'closing_requests.booking_code', '=', 'bookings.code')
            ->select(
                'bookings.*',
                'packages.name as package_name',
                'packages.value as package_value',
                'users.name as user_name',
                'users.phone as user_phone',
                'users.email as user_email',
                'booking_payments.status as payment_status',
                'booking_payments.id as payment_id',
                'closing_requests.status as closing_status',
                'closing_requests.id as closing_id'
            )
            ->latest()->paginate($dataSize);
        $distinctStatus = Booking::select('status')->distinct()->get();

        $packagesData = Package::select('id', 'name')->latest()->get();

        foreach ($bookings as $booking) {
            $booking->total_value = $this->numberFormatBangladeshi($booking->package_value * $booking->booking_quantity);
        }

        $bookings->appends(['dataSize' => $dataSize, 'status' => $status, 'package' => $package, 'search' => $search, 'migration' => $migration]);

        return view('administrator.booking.index', compact('bookings', 'distinctStatus', 'packagesData'));
    }

    public function show($id)
    {
        $booking = Booking::where('bookings.id', $id)
            ->leftJoin('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
            ->select('bookings.*', 'packages.name as package_name', 'packages.value as package_value', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'packages.migration_package_id', 'packages.maturity')
            ->first();

        $booking->total_value = $this->numberFormatBangladeshi($booking->package_value * $booking->booking_quantity);

        $payment = BookingPayment::where('booking_id', '=', $id)->first();

        $closing = ClosingRequest::where('booking_code', $booking->code)->first();
        $bankDetails = InvestorBankDetail::where('user_id', $booking->user_id)
            ->leftJoin('banks', 'banks.id', '=', 'investor_bank_details.bank_name')
            ->leftJoin('districts', 'districts.id', '=', 'investor_bank_details.district')
            ->first();

        return view('administrator.booking.show', compact('booking', 'payment', 'closing', 'bankDetails'));
    }

    public function edit($id)
    {
        $booking = Booking::where('bookings.id', $id)
            ->leftJoin('packages', 'packages.id', '=', 'bookings.package_id')
            ->leftJoin('users', 'users.id', '=', 'bookings.user_id')
            ->select('bookings.*', 'packages.name as package_name', 'packages.value as package_value', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email')
            ->first();

        $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'bookings' AND COLUMN_NAME = 'status'";
        $dbName = env('DB_DATABASE');
        $statusEnum = DB::select($query, [$dbName]);
        $statuesArray = explode("','", substr($statusEnum[0]->COLUMN_TYPE, 6, -2));

        return view('administrator.booking.edit', compact('booking', 'statuesArray'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'booking_quantity' => 'required|numeric|min:1',
            'note' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $booking = Booking::find($id);
        $booking->booking_quantity = $request->booking_quantity;
        $booking->note = $request->note;
        $booking->status = $request->status;
        $booking->updated_by = Auth::guard('administrator')->user()->email;
        $booking->save();

        return redirect()->route('administrator.booking.show', $id)->with('success', 'Booking updated successfully');
    }

    public function create($investor_id)
    {
        $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'bookings' AND COLUMN_NAME = 'status'";
        $dbName = env('DB_DATABASE');
        $statusEnum = DB::select($query, [$dbName]);
        $statuesArray = explode("','", substr($statusEnum[0]->COLUMN_TYPE, 6, -2));

        $packages = Package::select('id', 'name', 'value')->latest()->get();

        return view('administrator.booking.create', compact('statuesArray', 'packages', 'investor_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|numeric',
            'booking_quantity' => 'required|numeric|min:1',
            'note' => 'nullable|string',
            'status' => 'required|string',
            'investor_id' => 'required|numeric',
        ]);

        $availableCode = $this->getAvailableBookingCode();

        if (!$availableCode) {
            return redirect()->back()->with('error', 'Failed to generate booking code');
        }

        $booking = new Booking();
        $booking->code = $availableCode;
        $booking->package_id = $request->package_id;
        $booking->booking_quantity = $request->booking_quantity;
        $booking->note = $request->note;
        $booking->status = $request->status;
        $booking->created_by = Auth::guard('administrator')->user()->email;
        $booking->user_id = $request->investor_id;
        $booking->save();

        return redirect()->route('administrator.booking.show', $booking->id)->with('success', 'Booking created successfully');
    }

    public function payment_pending(Request $request)
    {
        $pendings = BookingPayment::where('bookings.status', 'pending_approval')
            ->join('bookings', 'bookings.id', '=', 'booking_payments.booking_id')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select('packages.name', 'packages.value', 'bookings.booking_quantity', 'bookings.code', 'booking_payments.payment_document', 'booking_payments.document_two', 'booking_payments.document_three', 'booking_payments.bank', 'booking_payments.branch', 'depositors_name', 'booking_payments.depositors_mobile_number', 'booking_payments.deposit_reference', 'booking_payments.payment_date', 'booking_payments.note', 'booking_payments.status', 'booking_payments.booking_id', 'users.name as investor_name', 'users.phone', 'users.email', 'users.id', 'booking_payments.payment_method')
            ->get();

        return view('administrator.payment.pending', compact('pendings'));
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
        }
        echo 'error';
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
        }
        echo 'error';
    }

    public function payment_delete(Booking $booking, BookingPayment $payment)
    {
        try {
            if (!empty($payment->document_one) && Storage::disk('public')->exists($payment->payment_document)) {
                Storage::disk('public')->delete($payment->payment_document);
            }

            if (!empty($payment->document_one) && Storage::disk('public')->exists($payment->document_two)) {
                Storage::disk('public')->delete($payment->document_two);
            }

            if (!empty($payment->document_one) && Storage::disk('public')->exists($payment->document_three)) {
                Storage::disk('public')->delete($payment->document_three);
            }

            DB::beginTransaction();

            $payment->delete();
            $booking->update(['status' => 'pending']);

            DB::commit();

            return redirect()->back()->with('success', 'Payment Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to delete payment');
        }
    }

    public function decision(Request $request)
    {
        if ('approve' == $request->decision) {
            $this->payment_approve($request->booking_id, $request->note, $request->user_id);

            return redirect()->back()->with('success', 'Approved Successfully');
        }
        if ('reject' == $request->decision) {
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
            ->join('projects', 'projects.id', '=', 'packages.project_id')
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

    public function paymentProof(Request $request)
    {
        $list = BookingPayment::where('booking_payments.status', 'complete')
            ->join('bookings', 'bookings.id', '=', 'booking_payments.booking_id')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select('packages.name', 'packages.value', 'bookings.booking_quantity', 'bookings.code', 'booking_payments.payment_document', 'booking_payments.payment_date', 'booking_payments.note', 'booking_payments.status', 'booking_payments.booking_id', 'users.name as investor_name', 'users.phone', 'users.email', 'users.id', 'bookings.updated_by', 'booking_payments.payment_method')
            ->get();

        return view('administrator.payment.approved', compact('list'));
    }

    public function approved_list_bybatch(Request $request)
    {
        $list = BookingPayment::where('booking_payments.status', 'complete')->where('bookings.package_id', $request->package)
            ->join('bookings', 'bookings.id', '=', 'booking_payments.booking_id')
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select('packages.name', 'packages.value', 'bookings.booking_quantity', 'bookings.code', 'booking_payments.payment_document', 'booking_payments.payment_date', 'booking_payments.note', 'booking_payments.status', 'booking_payments.booking_id', 'users.name as investor_name', 'users.phone', 'users.email', 'users.id', 'bookings.updated_by', 'booking_payments.payment_method')
            ->get();

        return view('administrator.payment_approved', compact('list'));
    }

    protected function getAvailableBookingCode()
    {
        $attemptLimit = 10;
        $attemptCount = 0;

        while ($attemptCount < $attemptLimit) {
            ++$attemptCount;
            $codes = collect();

            for ($i = 0; $i < 5; ++$i) {
                $codes->push(random_int(10000000, 99999999));
            }

            $usedCodes = Booking::whereIn('code', $codes)->pluck('code');
            $availableCodes = $codes->diff($usedCodes);

            if ($availableCode = $availableCodes->first()) {
                return $availableCode; // Return the first available code
            }
        }

        return null; // Return null if no available code found after attempts
    }
}
