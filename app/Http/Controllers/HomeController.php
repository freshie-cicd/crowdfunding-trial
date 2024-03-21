<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\Package;

use App\Models\User;

use App\Models\InvestorBankDetail;

use App\Models\Booking;

use App\Mail\BookingConfirmationMail;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('auth');
    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function index()

    {

        $packages = Package::where('status', 1)->get();



        return view('package', compact('packages'));
    }



    public function book($id)

    {

        $data = Package::where('id', $id)->get();



        return view('book', compact(['data']));
    }



    public function store(Request $request)

    {

        $book = new Booking;



        do {

            $randomNumber = random_int(10000000, 99999999);

            $check = Booking::where('code', $randomNumber)->count();
        } while ($check);



        $book['code'] = $randomNumber;



        $book['user_id'] = $request->user_id;

        $book['package_id'] = $request->package_id;

        $book['booking_quantity'] = $request->booking_quantity;

        $book['note'] = $request->note;



        $book->save();





        Mail::to(auth()->user()->email)->send(new BookingConfirmationMail());

        return redirect('/bookings')->with('success', 'Booking Successfully Submitted. A confirmation mail has been sent to your email address.');
    }







    public function dashboard()
    {



        $bookings = Booking::where('bookings.user_id', auth()->user()->id)->where('packages.status', 1)

            ->join('packages', 'packages.id', '=', 'bookings.package_id')

            ->join('facebook_groups', 'facebook_groups.batch_id', '=', 'packages.batch_id')

            ->select('bookings.code', 'packages.code as pcode', 'packages.value', 'bookings.booking_quantity', 'bookings.status', 'bookings.id', 'packages.batch_id', 'facebook_groups.url')

            ->get();





        $packages = Package::where('status', 1)->get();





        $bookings_ = Booking::where('bookings.user_id', auth()->user()->id)->where('booking_payments.status', 'complete')

            ->join('packages', 'bookings.package_id', '=', 'packages.id')

            ->join('booking_payments', 'bookings.id', '=', 'booking_payments.booking_id')

            ->select('bookings.id', 'packages.name', 'packages.value', 'packages.name', 'bookings.code', 'bookings.booking_quantity', 'booking_payments.status')

            ->get();

        //dump($bookings);

        //dump($packages);

        $total_investment = 0;

        foreach ($bookings_ as $booking) {

            $total_investment = $total_investment + $booking->value * $booking->booking_quantity;
        }



        // dump($total_investment);



        return view('dashboard', compact('bookings', 'packages', 'total_investment'));
    }



    public function profile()
    {







        $user_data = User::where('id', auth()->user()->id)->get();



        return view('profile.index', compact('user_data'));
    }





    public function profile_edit()
    {





        return view('profile.edit');
    }





    public function profile_update(Request $request)
    {



        User::where('id', auth()->user()->id)

            ->update(['name' => $request->name, 'permanent_address' => $request->permanent_address, 'present_address' => $request->present_address, 'father_name' => $request->father_name,  'mother_name' => $request->mother_name, 'nid' => $request->nid, 'date_of_birth' => $request->date_of_birth, 'nominee_name' => $request->nominee_name, 'nominee_phone' => $request->nominee_phone, 'nominee_address' => $request->nominee_address, 'nominee_relation' => $request->nominee_relation, 'nominee_nid' => $request->nominee_nid,]);





        return redirect()->back()->with('success', 'Profile Edited Successfully');
    }



    public function change_password()
    {

        return view('profile.change_password');
    }



    public function change_password_update(Request $request)
    {



        $validated = $request->validate([



            'password' => ['required', 'confirmed', 'min:8'],



        ]);



        $check = User::where('id', auth()->user()->id)->update(['password' => Hash::make($request->password)]);



        if ($check) {

            return redirect()->back()->with('success', 'Password Changed Successfully');
        }
    }





    public function bank_details(Request $request)
    {

        $data = InvestorBankDetail::where('user_id', auth()->user()->id)->first();
        $banks = DB::table('banks')->orderBy('bank_name')->get();
        $districts = DB::table('districts')->orderBy('district')->get();


        return view('investor.bank_details', compact('data', 'banks', 'districts'));
    }





    public function bank_details_update(Request $request)
    {


        $validated =  $request->validate([

            'bank_name' => ['required'],
            'branch_name' => ['required'],
            'account_name' => ['required'],
            'account_number' => ['required'],
            'routing_number' => ['required'],

        ]);



        $data = InvestorBankDetail::where('user_id', auth()->user()->id)->first();

        //dd($data);
        if (empty($data)) {

            $bank = new InvestorBankDetail;

            $bank['user_id'] = auth()->user()->id;
            $bank['bank_name'] = $request->bank_name;
            $bank['district'] = $request->district;
            $bank['branch_name'] = $request->branch_name;
            $bank['account_name'] = $request->account_name;
            $bank['account_number'] = $request->account_number;
            $bank['routing_number'] = $request->routing_number;
            $bank['note'] = $request->note;

            $check = $bank->save();

            if ($check) {
                return redirect()->back()->with('success', 'Updated Successfully');
            } else {
                print "error";
            }
        } else {

            $check = InvestorBankDetail::where('user_id', auth()->user()->id)->update(['bank_name' => $request->bank_name, 'district' => $request->district, 'branch_name' => $request->branch_name, 'account_name' => $request->account_name, 'account_number' => $request->account_number, 'routing_number' => $request->routing_number, 'note' => $request->note, 'updated_at' => now()]);

            if ($check) {
                return redirect()->back()->with('success', 'Bank Details Changed Successfully');
            } else {
                print "error";
            }
        }
    }
}
