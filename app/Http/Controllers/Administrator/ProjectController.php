<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $projects = Project::all();
      return view('administrator.project.index', compact(['projects']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return view('administrator.project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $project = new Project;

        $project['name'] = $request->project_name;
        $project['description'] = $request->description;
        $project['code'] = $request->code;
        $project['status'] = $request->status;

        if(!empty($request->file('cover_photo'))){
          $cover_file = $request->file('cover_photo');
          $cover_file_new_name = rand() . '.' . $request->file('cover_photo')->getClientOriginalExtension();
          $cover_file->move(public_path('uploads/covers/'), $cover_file_new_name);

          $project['cover_photo'] = "uploads/covers/" . $cover_file_new_name;
        }

        $project->save();

        return redirect()->back()->with('success', 'Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::where('id', $id)->get();
        return view('administrator.project.edit', compact(['project']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
      $project = array();
      $project['name'] = $request->project_name;
      $project['description'] = $request->description;
      $project['code'] = $request->code;
      $project['status'] = $request->status;

      if(!empty($request->file('cover_photo'))){
        $cover_file = $request->file('cover_photo');
        $cover_file_new_name = rand() . '.' . $request->file('cover_photo')->getClientOriginalExtension();
        $cover_file->move(public_path('uploads/covers/'), $cover_file_new_name);

        $project['cover_photo'] = "uploads/covers/" . $cover_file_new_name;
      }

      Project::where('id', $request->id)->update($project);

      return redirect('administrator/projects')->with('success', 'Edited Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      Project::where('id', $id)->delete();
      return redirect('administrator/projects')->with('success', 'Deleted Successfully');

    }
}
