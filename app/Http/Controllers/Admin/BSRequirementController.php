<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BSRequirement;
use Illuminate\Http\Request;

class BSRequirementController extends Controller
{
    /**
     * Display all BS requirements.
     */
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

        return view(
            'admin.settings.bs_requirements',
            compact('requirements')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        //
    }

    /**
     * Store a new BS requirement.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            /*
             * Increased from 255 to 500 characters.
             */
            'title' => 'required|string|max:500',

            /*
             * Description can contain much more text.
             */
            'description' => 'nullable|string|max:5000',

            /*
             * Example: 1, 1.1, 1.2, 2, 2.1
             */
            'sort_order' => 'nullable|string|max:20',
        ]);

        BSRequirement::create([
            'title' => $validated['title'],

            'description' => $validated['description'] ?? null,

            'sort_order' => $validated['sort_order'] ?? '0',

            'is_required' => $request->has('is_required'),

            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'BS Requirement added successfully.'
            );
    }

    /**
     * Display a specific BS requirement.
     */
    public function show(BSRequirement $bsRequirement)
    {
        //
    }

    /**
     * Show edit form.
     */
    public function edit(BSRequirement $bsRequirement)
    {
        //
    }

    /**
     * Update an existing BS requirement.
     */
    public function update(
        Request $request,
        BSRequirement $bsRequirement
    ) {
        $validated = $request->validate([
            /*
             * Increased from 255 to 500 characters.
             */
            'title' => 'required|string|max:500',

            /*
             * Allow longer descriptions.
             */
            'description' => 'nullable|string|max:5000',

            'sort_order' => 'nullable|string|max:20',
        ]);

        $bsRequirement->update([
            'title' => $validated['title'],

            'description' => $validated['description'] ?? null,

            'sort_order' => $validated['sort_order'] ?? '0',

            'is_required' => $request->has('is_required'),

            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'BS Requirement updated successfully.'
            );
    }

    /**
     * Delete a BS requirement.
     */
    public function destroy(BSRequirement $bsRequirement)
    {
        $bsRequirement->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'BS Requirement deleted successfully.'
            );
    }
}