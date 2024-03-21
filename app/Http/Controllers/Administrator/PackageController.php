<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\ProjectBatch;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('administrator.package.index', compact(['packages']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $batches = ProjectBatch::all();
        return view('administrator.package.create', compact(['batches']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = new Package;

        $package['batch_id'] = $request->batch_id;
        $package['name'] = $request->name;
        $package['description'] = $request->description;
        $package['code'] = $request->code;
        $package['value'] = $request->value;
        $package['capacity'] = $request->capacity;
        $package['status'] = $request->status;
        $package['note'] = $request->note;

        $package->save();

        return redirect()->back()->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Package::where('id', $id)->get();
        $batches = ProjectBatch::all();
        return view('administrator.package.edit', compact(['data', 'batches']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
      $package = array();

      $package['batch_id'] = $request->batch_id;
      $package['name'] = $request->name;
      $package['description'] = $request->description;
      $package['code'] = $request->code;
      $package['value'] = $request->value;
      $package['capacity'] = $request->capacity;
      $package['status'] = $request->status;
      $package['note'] = $request->note;

      Package::where('id', $request->id)->update($package);

      return redirect('administrator/packages')->with('success', 'Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Package::where('id', $id)->delete();

        return redirect('administrator/packages')->with('success', 'Deleted Successfully');
    }
}
