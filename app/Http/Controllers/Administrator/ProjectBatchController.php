<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\ProjectBatch;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batches = ProjectBatch::all();

        return view('administrator.project_batch.index', compact(['batches']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();

        return view('administrator.project_batch.create',compact(['projects']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $batch = new ProjectBatch;

        $batch['project_id'] = $request->project_id;
        $batch['name'] = $request->name;
        $batch['description'] = $request->description;
        $batch['code'] = $request->code;

        if(!empty($request->file('cover_photo'))){
          $cover_file = $request->file('cover_photo');
          $cover_file_new_name = rand() . '.' . $request->file('cover_photo')->getClientOriginalExtension();
          $cover_file->move(public_path('uploads/covers/'), $cover_file_new_name);

          $project['cover_photo'] = "uploads/covers/" . $cover_file_new_name;
        }

        $batch['ending_date'] = $request->ending_date;
        $batch['note'] = $request->note;

        $batch->save();

        return redirect()->back()->with('success', 'Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ProjectBatch::where('id', $id)->get();
        $projects = Project::all();
        return view('administrator.project_batch.edit', compact(['data', 'projects']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectBatch $projectbatch)
    {
      $batch = array();

      $batch['project_id'] = $request->project_id;
      $batch['name'] = $request->name;
      $batch['description'] = $request->description;
      $batch['code'] = $request->code;

      if(!empty($request->file('cover_photo'))){
        $cover_file = $request->file('cover_photo');
        $cover_file_new_name = rand() . '.' . $request->file('cover_photo')->getClientOriginalExtension();
        $cover_file->move(public_path('uploads/covers/'), $cover_file_new_name);

        $project['cover_photo'] = "uploads/covers/" . $cover_file_new_name;
      }

      $batch['ending_date'] = $request->ending_date;
      $batch['note'] = $request->note;

      ProjectBatch::where('id', $request->id)->update($batch);

      return redirect('administrator/batches')->with('success', 'Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        ProjectBatch::where('id', $id)->delete();
        return redirect('administrator/batches')->with('success', 'Edited Successfully');

    }
}
