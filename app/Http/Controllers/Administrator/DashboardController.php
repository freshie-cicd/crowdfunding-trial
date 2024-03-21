<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

      /**
       * Create a new controller instance.
       *
       * @return void
       */
      public function __construct()
      {
        $this->middleware('auth:administrator');
      }
      /**
       * Show the application dashboard.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
          return view('administrator.dashboard');
      }

}
