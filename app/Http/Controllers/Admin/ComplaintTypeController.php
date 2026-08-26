<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintType;
use Illuminate\Http\Request;

class ComplaintTypeController extends Controller
{
    public function index()
    {
        $complaints = ComplaintType::latest()->get();

        return view('admin.settings.complaint-types', compact('complaints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'complaint_type' => 'required',
            'description' => 'required',
        ]);

        ComplaintType::create([
            'complaint_type' => $request->complaint_type,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Complaint type added successfully.');
    }

    public function update(Request $request,int $id)
    {
        $request->validate([
            'complaint_type' => 'required',
            'description' => 'required',
        ]);

        $complaint = ComplaintType::findOrFail($id);

        $complaint->update([
            'complaint_type' => $request->complaint_type,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Complaint type updated successfully.');
    }

    public function destroy(int $id)
    {
        ComplaintType::findOrFail($id)->delete();

        return back()->with('success', 'Complaint type deleted successfully.');
    }
}