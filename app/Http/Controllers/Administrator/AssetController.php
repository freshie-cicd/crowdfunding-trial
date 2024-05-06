<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $assets = Asset::all();

        return view('administrator.asset.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $packages = Package::all();

        return view('administrator.asset.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $asset = new Asset();

        $asset['package_id'] = $request->package_id;
        $asset['name'] = $request->name;
        $asset['description'] = $request->description;
        $asset['purchase_price'] = $request->purchase_price;
        $asset['color'] = $request->color;
        $asset['location'] = $request->location;
        $asset['asset_code'] = $request->asset_code;
        $asset['status'] = $request->status;
        $asset['note'] = $request->note;

        $asset->save();

        return redirect()->back()->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Asset $asset) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = Asset::where('id', $id)->get();
        $packages = Package::all();

        return view('administrator.asset.edit', compact(['data', 'packages']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, Asset $asset)
    {
        $asset = [];

        $asset['package_id'] = $request->package_id;
        $asset['name'] = $request->name;
        $asset['description'] = $request->description;
        $asset['purchase_price'] = $request->purchase_price;
        $asset['color'] = $request->color;
        $asset['location'] = $request->location;
        $asset['asset_code'] = $request->asset_code;
        $asset['status'] = $request->status;
        $asset['note'] = $request->note;

        Asset::where('id', $request->id)->update($asset);

        return redirect('administrator/assets')->with('success', 'Edited Successfully');
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
        Asset::where('id', $id)->delete();

        return redirect('administrator/assets')->with('success', 'Deleted Successfully');
    }
}
