<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BSRequirement;
use Illuminate\Http\Request;

class BSRequirementController extends Controller
{
public function index()
{
    $requirements = BSRequirement::orderByRaw("
        CAST(SUBSTRING_INDEX(sort_order, '.', 1) AS UNSIGNED) ASC,
        CASE
            WHEN LOCATE('.', sort_order) > 0
            THEN CAST(SUBSTRING_INDEX(sort_order, '.', -1) AS UNSIGNED)
            ELSE 0
        END ASC
    ")->get();

    return view('admin.settings.bs_requirements', compact('requirements'));
}

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'sort_order' => 'nullable|string|max:20',
        ]);

        BSRequirement::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? '0',
            'is_required' => $request->has('is_required'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'BS Requirement added successfully.');
    }

    public function show(BSRequirement $bsRequirement)
    {
        //
    }

    public function edit(BSRequirement $bsRequirement)
    {
        //
    }

    public function update(Request $request, BSRequirement $bsRequirement)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'sort_order' => 'nullable|string|max:20',
        ]);

        $bsRequirement->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? '0',
            'is_required' => $request->has('is_required'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'BS Requirement updated successfully.');
    }

    public function destroy(BSRequirement $bsRequirement)
    {
        $bsRequirement->delete();

        return redirect()->back()->with('success', 'BS Requirement deleted successfully.');
    }
}