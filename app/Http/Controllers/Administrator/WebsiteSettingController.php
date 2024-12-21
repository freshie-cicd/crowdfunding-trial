<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteSettingRequest;
use App\Models\Models\Administrator\WebsiteSetting;
use App\Services\FileStorageService;

class WebsiteSettingController extends Controller
{
    private const DOCUMENT_PATHS = [
        'light_logo' => ['path' => 'uploads/logos', 'key' => 'light_logo'],
        'dark_logo' => ['path' => 'uploads/logos', 'key' => 'dark_logo'],
        'favicon' => ['path' => 'uploads/logos', 'key' => 'favicon'],
    ];

    public function __construct(private FileStorageService $fileStorage)
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
     * Show the form for editing the resource.
     */
    public function edit()
    {
        $settings = WebsiteSetting::firstOrNew();

        return view('administrator.website_setting.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebsiteSettingRequest $request)
    {
        $settings = WebsiteSetting::firstOrNew();

        // Fill all non-file inputs
        $nonFileInputs = collect(self::DOCUMENT_PATHS)->keys()->toArray();
        $settings->fill($request->except($nonFileInputs));

        // Process each file input based on DOCUMENT_PATHS configuration
        foreach (self::DOCUMENT_PATHS as $inputName => $config) {
            if ($request->hasFile($inputName)) {
                $settings->{$config['key']} = $this->fileStorage->replaceFile(
                    $settings->{$config['key']},
                    $request->file($inputName),
                    $config['path']
                );
            }
        }

        $settings->save();

        return redirect()->route('admin.website.settings')->with('success', 'Website settings updated successfully.');
    }
}
