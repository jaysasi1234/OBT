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

        // Create batch with both the legacy `name`
        // and the newer `batch_year` field.
        $batch = Batch::create([
            'name' => $request->batch_year,
            'batch_year' => $request->batch_year,
        ]);

        // Attach selected courses to the batch.
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

        // Keep both fields synchronized.
        $batch->update([
            'name' => $request->batch_year,
            'batch_year' => $request->batch_year,
        ]);

        // Replace existing courses with the selected courses.
        $batch->courses()->sync($request->courses);

        return back()->with('success', 'Batch Updated Successfully');
    }

    public function destroy(int $id)
    {
        $batch = Batch::findOrFail($id);

        // Detach pivot records before deleting the batch.
        $batch->courses()->detach();

        $batch->delete();

        return back()->with('success', 'Batch Deleted Successfully');
    }
}