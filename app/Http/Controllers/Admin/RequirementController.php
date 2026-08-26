<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::latest()->get();

        return view('admin.settings.requirement', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'course' => 'required',
        ]);

        Document::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_required' => $request->is_required,
            'course' => $request->course,
        ]);

        return redirect()->back()->with('success', 'Requirement Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Document::findOrFail($id);

        return response()->json($document);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $document = Document::findOrFail($id);

        return response()->json($document);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'course' => 'required',
        ]);

        $document->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_required' => $request->is_required,
            'course' => $request->course,
        ]);

        return redirect()->back()->with('success', 'Requirement Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);

        $document->delete();

        return redirect()->back()->with('success', 'Requirement Deleted Successfully');
    }
}