<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BorgaCowProfile;
use App\Models\ProjectBatch;
use App\Models\Package;

class BorgaController extends Controller
{
    
    public function __construct()
    {
      $this->middleware('auth:administrator');
    }



    public function index()
    {
        //
    }


    public function cow_profiles()
    {
        $data = BorgaCowProfile::all();
        return view('administrator.borga.cow_profiles', compact('data'));
    }

    public function cow_profile_create()
    {
        $batches = ProjectBatch::where('status', 1)->get();
        $packages = Package::where('status', 1)->get();
        return view('administrator.borga.cow_profile_create', compact('batches', 'packages'));
    }

    public function cow_profile_store(Request $request)
    {
        $requested = $request->validate([
            'batch_id' => 'required',
            'package_id' => 'required',
            'cow_code' => 'required|unique:borga_cow_profiles',
            'purchase_date' => 'required',
            'price' => 'required',
            'hasil' => 'required',
            'transport_cost' => 'required',
            'weight' => 'required',
            'color' => 'required',
            'breed' => 'required',
            'age' => 'required',
            'adviser' => 'required',
            'hat' => 'required',
        ]);

        
        $cow = new BorgaCowProfile;
        
        $photo = $request->file('photo');

        if(!empty($photo)){
            $photo_new_name = rand() . '.' . $request->file('photo')->getClientOriginalExtension();
            $photo->move(public_path('uploads/cow/'), $photo_new_name);
            $cow['photo'] = "/uploads/cow/" . $photo_new_name;
        }


        $cow['batch_id'] = $request->batch_id;
        $cow['package_id'] = $request->package_id;
        $cow['cow_code'] = $request->cow_code;
        $cow['purchase_date'] = $request->purchase_date;
        $cow['price'] = $request->price;
        $cow['hasil'] = $request->hasil;
        $cow['transport_cost'] = $request->transport_cost;
        $cow['weight'] = $request->weight;
        $cow['color'] = $request->color;
        $cow['breed'] = $request->breed;
        $cow['age'] = $request->age;
        $cow['adviser'] = $request->adviser;
        $cow['hat'] = $request->hat;
        $cow['note'] = $request->note;
  
        
        $q=$cow->save();
        
        if($q)
        {
            return redirect('administrator/borga/cow-profiles')->with('success', 'Added Successfully.');
        }


    }

    
}
