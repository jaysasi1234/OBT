<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Course;
use App\Models\OnboardRequirement;
use Illuminate\Http\Request;

class OnboardRequirementController extends Controller
{
public function index()
{
    $requirements = OnboardRequirement::orderByRaw("
        CAST(SUBSTRING_INDEX(sort_order, '.', 1) AS UNSIGNED) ASC,
        CASE
            WHEN LOCATE('.', sort_order) > 0
            THEN CAST(SUBSTRING_INDEX(sort_order, '.', -1) AS UNSIGNED)
            ELSE 0
        END ASC
    ")->get();

    $cadets = Cadet::whereHas('deployment', function ($query) {
        $query->whereNotNull('date_deployed')
              ->whereNull('date_disembarked');
    })
    ->with([
        'batch',
        'deployment',
        'onboardRequirements.requirement'
    ])
    ->get();


    $batches = Batch::orderBy('batch_year')->get();

    $courses = Course::orderBy('course_name')->get();


    return view(
        'admin.settings.onboard_requirements',
        compact(
            'requirements',
            'cadets',
            'batches',
            'courses'
        )
    );
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:onboard_requirements,title',
            'description' => 'nullable',
            'frequency' => 'required',
            'due_after_days' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|string|max:20',
        ]);

        OnboardRequirement::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'frequency' => $validated['frequency'],
            'due_after_days' => $validated['due_after_days'] ?? null,
            'sort_order' => $validated['sort_order'] ?? '0',
            'is_required' => $request->boolean('is_required'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.settings.onboard-requirements.index')
            ->with('success', 'Onboard Requirement added successfully.');
    }

    public function update(Request $request, OnboardRequirement $onboardRequirement)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|unique:onboard_requirements,title,' . $onboardRequirement->id,
            'description' => 'nullable',
            'frequency' => 'required',
            'due_after_days' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|string|max:20',
        ]);

        $onboardRequirement->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'frequency' => $validated['frequency'],
            'due_after_days' => $validated['due_after_days'] ?? null,
            'sort_order' => $validated['sort_order'] ?? '0',
            'is_required' => $request->boolean('is_required'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.settings.onboard-requirements.index')
            ->with('success', 'Onboard Requirement updated successfully.');
    }

    public function destroy(OnboardRequirement $onboardRequirement)
    {
        $onboardRequirement->delete();

        return redirect()
            ->route('admin.settings.onboard-requirements.index')
            ->with('success', 'Requirement deleted successfully.');
    }
}