<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClosingRequest;
use App\Models\User;
use App\Models\Booking;
use App\Mail\MigrationConfirmationMail;
use Illuminate\Support\Facades\Mail;


class ClosingController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:administrator');
    }


    public function index()
    {
        $data = DB::table('closing_requests')
            ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
            ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
            ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
            ->where('closing_requests.status', 'requested')
            ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district')
            ->get();

        return view('administrator.closing.index', compact('data'));
    }


    public function report()
    {
        $data = DB::table('closing_requests')
            ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
            ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
            ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
            ->where('closing_requests.id', '>', 0)
            ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district')
            ->get();

        return view('administrator.closing.report', compact('data'));
    }


    public function profit_return()
    {
        $data = DB::table('closing_requests')
            ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
            ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
            ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
            ->where('closing_requests.id', '>', '0')
            //->whereRaw('LENGTH(investor_bank_details.routing_number) = 9')
            ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district')
            ->get();

        return view('administrator.closing.profit_return', compact('data'));
    }




    public function capital_return_report()
    {
        $data = DB::table('closing_requests')
            ->join('bookings', 'bookings.code', '=', 'closing_requests.booking_code')
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->join('closing_init', 'bookings.package_id', '=', 'closing_init.package_id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('investor_bank_details', 'investor_bank_details.user_id', '=', 'users.id')
            ->join('districts', 'investor_bank_details.district', '=', 'districts.id')
            ->join('banks', 'investor_bank_details.bank_name', '=', 'banks.id')
            ->where('closing_requests.package_to_withdraw', '>', 0)
            ->select('closing_requests.*', 'closing_init.profit_value', 'packages.name as package_name', 'packages.value as package_value', 'bookings.booking_quantity', 'bookings.status as booking_status', 'users.name as user_name', 'users.phone as user_phone', 'users.email as user_email', 'investor_bank_details.branch_name', 'investor_bank_details.account_name', 'investor_bank_details.account_number', 'investor_bank_details.routing_number', 'banks.bank_name', 'districts.district')
            ->get();

        return view('administrator.closing.capital', compact('data'));
    }



    public function migration($booking_code, $investor_id, $package_id)
    {
        $migration_info = DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->where('status', 'requested')->first();
        $user_email = DB::table('users')->where('id', $investor_id)->select('email')->first();

        if ($migration_info) {
            if ($migration_info->package_after_withdrawal > 0) {

                $book = new Booking;

                do {
                    $randomNumber = random_int(10000000, 99999999);
                    $check = Booking::where('code', $randomNumber)->count();
                } while ($check);

                $book['code'] = $randomNumber;
                $book['user_id'] = $investor_id;
                $book['package_id'] = $package_id;
                $book['booking_quantity'] = $migration_info->package_after_withdrawal;
                $book['status'] = 'approved';
                $book['note'] = 'Migrated';
                $check = $book->save();

                if ($check) {

                    $reinvestAmount = $migration_info->after_withdrawal_amount;

                    DB::table('bookings')->where('code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'migrated']);
                    DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'disbursed']);

                    Mail::to($user_email)->send(new MigrationConfirmationMail($reinvestAmount));

                    return redirect()->back()->with('success', "Migrated Successfully, User is informed.");
                }
            } else {
                DB::table('bookings')->where('code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'withdrawn']);
                DB::table('closing_requests')->where('booking_code', $booking_code)->where('user_id', $investor_id)->update(['status' => 'disbursed']);
                return redirect()->back()->with('success', 'Withdrawal Request Successfully Updated');
            }
        }

        return redirect()->back()->with('info', 'Something is Wrong!');
    }
}
