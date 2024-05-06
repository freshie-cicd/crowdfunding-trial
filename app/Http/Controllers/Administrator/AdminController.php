<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {}

    public function create(Request $request)
    {
        // dd(Auth::guard('administrator')->user()->email);
        return view('administrator.team.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required'],
            'role' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $admin = new Administrator();

        $admin['name'] = $request->full_name;
        $admin['email'] = $request->email;
        $admin['password'] = Hash::make($request->password);
        $admin['role'] = $request->role;

        $check = $admin->save();

        if ($check) {
            dd('Success');
        }
    }
}
