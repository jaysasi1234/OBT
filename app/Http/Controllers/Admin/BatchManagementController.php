<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Course;

class BatchManagementController extends Controller
{
    /**
     * Display the batch management page.
     */
    public function index()
    {
        $batches = Batch::with('courses')
            ->orderBy('batch_year', 'desc')
            ->get();

        $courses = Course::orderBy('course_name')->get();

        return view('admin.settings.batch', compact('batches', 'courses'));
    }

    /**
     * Store a new batch.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_year' => 'required|string|max:20',
            'courses' => 'required|array|min:1',
            'courses.*' => 'exists:courses,id',
        ]);

        // Only use the column that currently exists
        // in the production batches table.
        $batch = Batch::create([
            'batch_year' => $validated['batch_year'],
        ]);

        // Attach selected courses.
        $batch->courses()->attach($validated['courses']);

        return back()->with('success', 'Batch Added Successfully');
    }

    /**
     * Update an existing batch.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'batch_year' => 'required|string|max:20',
            'courses' => 'required|array|min:1',
            'courses.*' => 'exists:courses,id',
        ]);

        $batch = Batch::findOrFail($id);

        // Only update batch_year.
        $batch->update([
            'batch_year' => $validated['batch_year'],
        ]);

        // Replace the existing course assignments.
        $batch->courses()->sync($validated['courses']);

        return back()->with('success', 'Batch Updated Successfully');
    }

    /**
     * Delete a batch.
     */
    public function destroy(int $id)
    {
        $batch = Batch::findOrFail($id);

        // Remove pivot records first.
        $batch->courses()->detach();

        // Delete the batch.
        $batch->delete();

        return back()->with('success', 'Batch Deleted Successfully');
    }
}