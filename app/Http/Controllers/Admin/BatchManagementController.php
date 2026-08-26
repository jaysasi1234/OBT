<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Course;

class BatchManagementController extends Controller
{
public function index()
{
    $batches = Batch::with('courses')->latest()->get();

    $courses = Course::all();

    return view('admin.settings.batch', compact('batches', 'courses'));
}

    public function store(Request $request)
    {
        $request->validate([
            'batch_year' => 'required',
            'courses' => 'required|array',
        ]);

        // ✅ create batch first
        $batch = Batch::create([
            'batch_year' => $request->batch_year,
        ]);

        // ✅ attach selected courses (PIVOT TABLE)
        $batch->courses()->attach($request->courses);

        return back()->with('success', 'Batch Added Successfully');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'batch_year' => 'required',
            'courses' => 'required|array',
        ]);

        $batch = Batch::findOrFail($id);

        // ✅ update batch year
        $batch->update([
            'batch_year' => $request->batch_year,
        ]);

        // ✅ sync courses (replace old ones)
        $batch->courses()->sync($request->courses);

        return back()->with('success', 'Batch Updated Successfully');
    }

    public function destroy(int $id)
    {
        $batch = Batch::findOrFail($id);

        // ✅ detach pivot first
        $batch->courses()->detach();

        $batch->delete();

        return back()->with('success', 'Batch Deleted Successfully');
    }
}