<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Project;
use App\Models\ProjectBatch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $batches = ProjectBatch::all();

        return view('administrator.package.create', compact(['batches']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $package = new Package();

        $package['batch_id'] = $request->batch_id;
        $package['name'] = $request->name;
        $package['description'] = $request->description;
        $package['code'] = $request->code;
        $package['value'] = $request->value;
        $package['capacity'] = $request->capacity;
        $package['status'] = $request->status;
        $package['note'] = $request->note;
        $package['start_date'] = $request->start_date;
        $package['end_date'] = $request->end_date;

        $package->save();

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
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = Package::where('id', $id)->get();
        $batches = ProjectBatch::all();

        $project = Project::where('packages.id', '=', $id)
            ->join('project_batches', 'projects.id', '=', 'project_batches.project_id')
            ->join('packages', 'project_batches.id', '=', 'packages.batch_id')
            ->select('projects.id', 'projects.name')
            ->first();
        $packages = Package::where('projects.id', '=', $project->id)
            ->join('project_batches', 'packages.batch_id', '=', 'project_batches.id')
            ->join('projects', 'project_batches.project_id', '=', 'projects.id')
            ->select('packages.id', 'packages.name')
            ->get();

        return view('administrator.package.edit', compact(['data', 'batches', 'packages']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, Package $package)
    {
        $package = [];

        $package['batch_id'] = $request->batch_id;
        $package['name'] = $request->name;
        $package['description'] = $request->description;
        $package['code'] = $request->code;
        $package['value'] = $request->value;
        $package['capacity'] = $request->capacity;
        $package['status'] = $request->status;
        $package['note'] = $request->note;
        $package['maturity'] = $request->maturity;
        $package['return_amount'] = $request->return_amount;
        $package['migration_package_id'] = $request->migration_package_id;
        $package['start_date'] = $request->start_date;
        $package['end_date'] = $request->end_date;

        Package::where('id', $request->id)->update($package);

        return redirect('administrator/packages')->with('success', 'Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        Package::where('id', $id)->delete();

        return redirect('administrator/packages')->with('success', 'Deleted Successfully');
    }
}
