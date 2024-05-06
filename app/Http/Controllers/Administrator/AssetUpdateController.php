<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\AssetUpdate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssetUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $updates = AssetUpdate::all();

        return view('administrator.update.index', compact('updates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('administrator.update.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(AssetUpdate $assetUpdate) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(AssetUpdate $assetUpdate) {}

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, AssetUpdate $assetUpdate) {}

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(AssetUpdate $assetUpdate) {}
}
