<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteSettingRequest;
use App\Models\Models\Administrator\WebsiteSetting;
use Illuminate\Support\Facades\Cache;

class WebsiteSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
        $this->middleware('role:superadmin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = WebsiteSetting::firstOrNew();

        return view('administrator.website_setting.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit()
    {
        $settings = WebsiteSetting::firstOrNew();

        return view('administrator.website_setting.edit', compact('settings'));
    }

    public function update(WebsiteSettingRequest $request)
    {
        $settings = WebsiteSetting::firstOrNew();
        $settings->fill($request->except(['light_logo', 'dark_logo', 'favicon']));

        // Handle logo uploads
        if ($request->hasFile('light_logo')) {
            $settings->light_logo = $request->file('light_logo')->store('logos', 'public');
        }
        if ($request->hasFile('dark_logo')) {
            $settings->dark_logo = $request->file('dark_logo')->store('logos', 'public');
        }
        if ($request->hasFile('favicon')) {
            $settings->favicon = $request->file('favicon')->store('logos', 'public');
        }

        $settings->save();

        Cache::forget('website_settings');
        Cache::remember('website_settings', 3600, function () use ($settings) {
            return $settings->refresh();
        });

        return redirect()->route('admin.website.settings')->with('success', 'Website settings updated successfully.');
    }
}
