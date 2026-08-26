<?php

// app/Http/Controllers/Admin/SystemSettingsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = [];

        if (File::exists(storage_path('app/settings.json'))) {
            $settings = json_decode(
                File::get(storage_path('app/settings.json')),
                true
            );
        }

        return view('admin.settings.system', compact('settings'));
    }

    public function save(Request $request)
    {
        $data = [
            'system_name' => $request->system_name,
            'organization' => $request->organization,
            'version' => $request->version,
            'timezone' => $request->timezone,
            'description' => $request->description,

            'allow_registration' => $request->has('allow_registration'),
            'allow_upload' => $request->has('allow_upload'),
            'allow_complaint' => $request->has('allow_complaint'),

            'password_length' => $request->password_length,
            'max_attempts' => $request->max_attempts,
            'special_characters' => $request->special_characters,
            'session_timeout' => $request->session_timeout,
        ];

        // LOGO
        if ($request->hasFile('logo')) {

            $logo = $request->file('logo');

            $logoName = time() . '.' . $logo->getClientOriginalExtension();

            $logo->move(public_path('uploads/settings'), $logoName);

            $data['logo'] = 'uploads/settings/' . $logoName;
        } else {

            if (File::exists(storage_path('app/settings.json'))) {

                $old = json_decode(
                    File::get(storage_path('app/settings.json')),
                    true
                );

                $data['logo'] = $old['logo'] ?? null;
            }
        }

        File::put(
            storage_path('app/settings.json'),
            json_encode($data, JSON_PRETTY_PRINT)
        );

        return back()->with('success', 'Settings saved successfully.');
    }
}