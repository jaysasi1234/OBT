<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use Illuminate\Http\Request;
use App\Models\CadetOnboardRequirement;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OnboardRequirementStatusNotification;

class CadetRequirementController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index()
    {
        $cadets = Cadet::with([
            'batch',
            'deployment',
            'onboardRequirements.requirement'
        ])
        ->whereHas('deployment', function ($q) {
            $q->whereIn('status', ['Ongoing', 'Completed']);
        })
        ->orderBy('full_name', 'asc')
        ->get();

        $batches = Batch::orderBy(
            'batch_year',
            'desc'
        )->get();

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->get();

        return view(
            'admin.cadet_requirements.index',
            compact(
                'cadets',
                'batches',
                'courses'
            )
        );
    }


    // =========================================================
    // SHOW
    // =========================================================

    public function show(Cadet $cadet)
    {
        $cadet->load([
            'deployment',
            'onboardRequirements.requirement'
        ]);

        return response()->json($cadet);
    }


    // =========================================================
    // UPDATE REQUIREMENT STATUS
    // =========================================================

    public function update(
        Request $request,
        CadetOnboardRequirement $requirement
    ) {

        // =====================================================
        // VALIDATION
        // =====================================================

        $validated = $request->validate([
            'status' => [
                'required',
                'in:Submitted,Approved,Rejected'
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:500'
            ],
        ]);


        // =====================================================
        // LOAD RELATIONSHIPS
        // =====================================================

        $requirement->load([
            'cadet.user',
            'requirement'
        ]);


        $cadet = $requirement->cadet;

        $onboardRequirement =
            $requirement->requirement;


        // =====================================================
        // SAFETY CHECK
        // =====================================================

        if (!$cadet) {

            return response()->json([
                'success' => false,
                'message' => 'Cadet could not be found.',
            ], 404);
        }


        if (!$onboardRequirement) {

            return response()->json([
                'success' => false,
                'message' => 'Onboard requirement could not be found.',
            ], 404);
        }


        // =====================================================
        // PREVIOUS STATUS
        // =====================================================

        $previousStatus =
            $requirement->status;


        // =====================================================
        // UPDATE STATUS
        // =====================================================

        $requirement->status =
            $validated['status'];


        // =====================================================
        // APPROVAL INFORMATION
        // =====================================================

        if (
            $validated['status'] === 'Approved'
        ) {

            $requirement->approved_at =
                now();

            $requirement->approved_by =
                Auth::id();

        } else {

            $requirement->approved_at =
                null;

            $requirement->approved_by =
                null;
        }


        // =====================================================
        // REMARKS
        // =====================================================

        $requirement->remarks =
            $validated['remarks']
            ?? $requirement->remarks;


        // =====================================================
        // SAVE
        // =====================================================

        $requirement->save();


        // =====================================================
        // NOTIFY CADET
        // =====================================================

        /*
        |--------------------------------------------------------------------------
        | Only notify the cadet when the status actually changes.
        |--------------------------------------------------------------------------
        */

        if (
            $previousStatus !==
            $validated['status']
        ) {

            $user = $cadet->user;

            if ($user) {

                $user->notify(
                    new OnboardRequirementStatusNotification(
                        $cadet,
                        $onboardRequirement,
                        $validated['status'],
                        $requirement->remarks
                    )
                );
            }
        }


        // =====================================================
        // RESPONSE
        // =====================================================

        return response()->json([

            'success' =>
                true,

            'id' =>
                $requirement->id,

            'status' =>
                $requirement->status,

            'remarks' =>
                $requirement->remarks,

            'approved_at' =>
                $requirement->approved_at
                    ? $requirement->approved_at
                        ->format('M d, Y h:i A')
                    : null,

        ]);
    }

// =========================================================
// APPROVE ALL ONBOARD REQUIREMENTS AS LEGACY
// =========================================================

public function approveLegacy(Request $request, Cadet $cadet)
{
    try {

        // =====================================================
        // GET ALL ACTIVE MASTER REQUIREMENTS
        // =====================================================

        $requirements = \App\Models\OnboardRequirement::where(
            'is_active',
            true
        )->get();


        // =====================================================
        // SAFETY CHECK
        // =====================================================

        if ($requirements->isEmpty()) {

            return response()->json([
                'success' => false,
                'message' => 'No active onboard requirements were found.',
            ], 422);

        }


        // =====================================================
        // APPROVE EVERYTHING AS LEGACY
        //
        // IMPORTANT:
        // We DO NOT check for attachment.
        // We DO NOT require the cadet to have submitted anything.
        //
        // This creates the CadetOnboardRequirement records
        // directly for old/graduated cadets.
        // =====================================================

        \Illuminate\Support\Facades\DB::transaction(function () use (
            $cadet,
            $requirements
        ) {

            foreach ($requirements as $onboardRequirement) {

                $record = CadetOnboardRequirement::firstOrNew([
                    'cadet_id' =>
                        $cadet->id,

                    'onboard_requirement_id' =>
                        $onboardRequirement->id,
                ]);


                $record->status =
                    'Approved';


                $record->approved_at =
                    now();


                $record->approved_by =
                    Auth::id();


                $record->remarks =
                    'Approved as legacy requirement. '
                    . 'No digital document submission required '
                    . 'because this cadet completed the requirement '
                    . 'before the system was implemented.';


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | Do NOT set attachment.
                |
                | The whole purpose of LEGACY approval is that
                | the old cadet does not need to upload anything.
                |
                */

                $record->save();
            }


            // =================================================
            // DO NOT REQUIRE SUBMISSIONS
            // =================================================
            //
            // The records above are now Approved even though
            // attachment is NULL.
            //
            // =================================================
        });


        // =====================================================
        // RETURN SUCCESS
        // =====================================================

        return response()->json([

            'success' =>
                true,

            'message' =>
                'All onboard requirements have been approved as legacy requirements.',

            'approved_at' =>
                now()->format('M d, Y h:i A'),

        ]);

    }

    catch (\Throwable $e) {

        \Illuminate\Support\Facades\Log::error(
            'Legacy onboard requirement approval failed.',
            [
                'cadet_id' =>
                    $cadet->id,

                'admin_id' =>
                    Auth::id(),

                'error' =>
                    $e->getMessage(),

                'file' =>
                    $e->getFile(),

                'line' =>
                    $e->getLine(),
            ]
        );


        return response()->json([

            'success' =>
                false,

            'message' =>
                'Legacy approval failed: '
                . $e->getMessage(),

        ], 500);
    }
}    
}