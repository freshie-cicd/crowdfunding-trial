<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
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
        $projects = Project::all();

        return view('administrator.project.index', compact(['projects']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('administrator.project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $project = new Project();

        $project['name'] = $request->project_name;
        $project['description'] = $request->description;
        $project['code'] = $request->code;
        $project['status'] = $request->status;

        if (!empty($request->file('cover_photo'))) {
            $cover_file = $request->file('cover_photo');
            $cover_file_new_name = rand().'.'.$request->file('cover_photo')->getClientOriginalExtension();
            $cover_file->move(public_path('uploads/covers/'), $cover_file_new_name);

            $project['cover_photo'] = 'uploads/covers/'.$cover_file_new_name;
        }

        $project->save();

        return redirect()->back()->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Project $project) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $project = Project::where('id', $id)->get();

        return view('administrator.project.edit', compact(['project']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, Project $project)
    {
        $project = [];
        $project['name'] = $request->project_name;
        $project['description'] = $request->description;
        $project['code'] = $request->code;
        $project['status'] = $request->status;

        if (!empty($request->file('cover_photo'))) {
            $cover_file = $request->file('cover_photo');
            $cover_file_new_name = rand().'.'.$request->file('cover_photo')->getClientOriginalExtension();
            $cover_file->move(public_path('uploads/covers/'), $cover_file_new_name);

            $project['cover_photo'] = 'uploads/covers/'.$cover_file_new_name;
        }

        Project::where('id', $request->id)->update($project);

        return redirect('administrator/projects')->with('success', 'Edited Successfully');
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
        Project::where('id', $id)->delete();

        return redirect('administrator/projects')->with('success', 'Deleted Successfully');
    }
}
