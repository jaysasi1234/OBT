<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportSetting;
use Illuminate\Http\Request;

class ReportSettingsController extends Controller
{
    public function index()
    {
        $reports = ReportSetting::all();

        return view('admin.settings.report-settings', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_name' => 'required',
            'description' => 'required',
        ]);

        ReportSetting::create([
            'report_name' => $request->report_name,
            'description' => $request->description,
            'status' => 'Active',
        ]);

        return redirect()->back()->with('success', 'Report Added Successfully');
    }

    public function edit($id)
    {
        $report = ReportSetting::findOrFail($id);

        return response()->json($report);
    }

    public function update(Request $request, $id)
    {
        $report = ReportSetting::findOrFail($id);

        $report->update([
            'report_name' => $request->report_name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Report Updated Successfully');
    }

    public function destroy($id)
    {
        $report = ReportSetting::findOrFail($id);
        $report->delete();

        return redirect()->back()->with('success', 'Report Deleted Successfully');
    }

    public function saveSettings(Request $request)
    {
        $setting = ReportSetting::first();

        if ($setting) {
            $setting->update([
                'include_logo' => $request->include_logo ? 1 : 0,
                'include_date' => $request->include_date ? 1 : 0,
                'report_format' => $request->report_format,
                'default_title' => $request->default_title,
                'export_pdf' => $request->export_pdf ? 1 : 0,
                'export_excel' => $request->export_excel ? 1 : 0,
                'allow_print' => $request->allow_print ? 1 : 0,
            ]);
        }

        return redirect()->back()->with('success', 'Settings Saved Successfully');
    }
}