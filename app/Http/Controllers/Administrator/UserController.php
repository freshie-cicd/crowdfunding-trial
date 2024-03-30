<?php



namespace App\Http\Controllers\Administrator;



use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;



class UserController extends Controller

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index()
    {
        $users = User::all();
        return view('administrator.investor.index', compact('users'));
    }

    public function change_password($id)
    {
        $data = User::where('id', $id)->get();

        return view('administrator.investor.change_password', compact('data'));
    }



    public function store_password(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $check = User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        if ($check) {

            return redirect()->back()->with('success', 'Password Changed Successfully');
        }
    }
}
