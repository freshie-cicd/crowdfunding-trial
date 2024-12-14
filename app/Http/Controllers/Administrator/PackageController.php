<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PackageController extends Controller
{
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
    public function index()
    {
        $packages = Package::all();

        return view('administrator.package.index', compact(['packages']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $projects = Project::all();

        return view('administrator.package.create', compact(['projects']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Package::create($request->except('_token', '_method'));

        return redirect()->back()->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Package $package) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package): View
    {
        $packages = Package::whereNot('id', $package->id)->get(['id', 'name']);
        $projects = Project::get(['id', 'name']);

        return view('administrator.package.edit', compact('package', 'packages', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, Package $package)
    {
        $package->update($request->except('_token', '_method'));

        return redirect('administrator/packages')->with('success', 'Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect('administrator/packages')->with('success', 'Deleted Successfully');
    }
}
