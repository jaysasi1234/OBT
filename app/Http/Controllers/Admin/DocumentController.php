<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->get();

        return view('admin.requirements.index', compact('documents'));
    }

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

        return redirect()->back()->with('success', 'Requirement Added');
    }

    public function update(Request $request,int $id)
    {
        $document = Document::findOrFail($id);

        $document->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_required' => $request->is_required,
            'course' => $request->course,
        ]);

        return redirect()->back()->with('success', 'Requirement Updated');
    }

    public function destroy(int $id)
    {
        Document::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Requirement Deleted');
    }
}