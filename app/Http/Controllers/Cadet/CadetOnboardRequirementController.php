<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\CadetOnboardRequirement;
use App\Models\OnboardRequirement;
use App\Models\User;
use App\Notifications\CadetRequirementSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CadetOnboardRequirementController extends Controller
{
    /**
     * Upload or replace an onboard requirement.
     */
    public function upload(Request $request)
    {
        // Validate uploaded data
        $validated = $request->validate([
            'requirement_id' => [
                'required',
                'exists:onboard_requirements,id',
            ],

            'attachment' => [
                'required',
                'file',
                'max:10240', // 10 MB
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        // Get the currently authenticated cadet
        $cadet = Cadet::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        // Get the requirement
        $requirement = OnboardRequirement::findOrFail(
            $validated['requirement_id']
        );

        // Store uploaded file
        $path = $request
            ->file('attachment')
            ->store(
                'onboard_requirements',
                'public'
            );

        // Create or update the cadet submission
        CadetOnboardRequirement::updateOrCreate(
            [
                'cadet_id' => $cadet->id,
                'onboard_requirement_id' => $requirement->id,
            ],
            [
                'attachment' => $path,
                'remarks' => $validated['remarks'] ?? null,

                // Cadet has submitted the requirement.
                // Admin will review it later.
                'status' => 'Submitted',

                'submitted_at' => now(),
            ]
        );

        // Notify all administrators
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(
                new CadetRequirementSubmitted(
                    $cadet,
                    $requirement
                )
            );
        }

        return back()->with(
            'success',
            'Requirement submitted successfully and is awaiting verification.'
        );
    }
}