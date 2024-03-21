<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\AssetUpdate;
use Illuminate\Http\Request;

class AssetUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $updates = AssetUpdate::all();
        return view('administrator.update.index', compact('updates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('administrator.update.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetUpdate  $assetUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(AssetUpdate $assetUpdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssetUpdate  $assetUpdate
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetUpdate $assetUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssetUpdate  $assetUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetUpdate $assetUpdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetUpdate  $assetUpdate
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetUpdate $assetUpdate)
    {
        //
    }
}
