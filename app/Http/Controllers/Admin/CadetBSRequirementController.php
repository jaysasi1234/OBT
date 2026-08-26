<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\CadetBSRequirement;
use App\Models\BSRequirement;
use App\Models\Batch;
use Illuminate\Http\Request;
use App\Events\BSRequirementUpdated;
use App\Notifications\BSRequirementStatusNotification;
use Carbon\Carbon;

class CadetBSRequirementController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request)
    {
        $query = Cadet::with([
            'batch',
            'deployment',
            'bsRequirements.requirement',
        ])
        ->whereHas('deployment', function ($q) {
            $q->where('status', 'Completed');
        });

        // =====================================================
        // SEARCH
        // =====================================================

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'full_name',
                    'like',
                    '%' . $request->search . '%'
                )
                ->orWhere(
                    'trb_control_number',
                    'like',
                    '%' . $request->search . '%'
                );

            });
        }

        // =====================================================
        // COURSE FILTER
        // =====================================================

        if ($request->filled('course')) {

            $query->where(
                'course',
                $request->course
            );
        }

        // =====================================================
        // BATCH FILTER
        // =====================================================

        if ($request->filled('batch')) {

            $query->where(
                'batch_id',
                $request->batch
            );
        }

        // =====================================================
        // GET CADETS
        // =====================================================

        $cadets = $query
            ->get()
            ->sortBy(function ($cadet) {

                return strtolower(
                    $cadet->full_name
                );

            })
            ->values();

        // =====================================================
        // FILTER DATA
        // =====================================================

        $batches = Batch::orderBy(
            'batch_year'
        )->get();

        $courses = Cadet::select('course')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        $totalRequirements = BSRequirement::count();

        // =====================================================
        // VIEW
        // =====================================================

        return view(
            'admin.cadet_bs_requirements.index',
            compact(
                'cadets',
                'totalRequirements',
                'courses',
                'batches'
            )
        );
    }


    // =========================================================
    // SHOW
    // =========================================================

    public function show(Cadet $cadet)
    {
        $cadet->load([
            'batch',
            'deployment',
            'bsRequirements.requirement',
        ]);

        return view(
            'admin.cadet_bs_requirements.show',
            compact('cadet')
        );
    }


    // =========================================================
    // UPDATE BS REQUIREMENT STATUS
    // =========================================================

    public function update(
        Request $request,
        CadetBSRequirement $submission
    ) {

        // =====================================================
        // VALIDATION
        // =====================================================

        $request->validate([
            'status' =>
                'required|in:Approved,Rejected',

            'remarks' =>
                'nullable|string|max:500',
        ]);


        // =====================================================
        // LOAD RELATIONSHIPS
        // =====================================================

        $submission->load([
            'cadet.user',
            'requirement',
        ]);

        $cadet = $submission->cadet;

        $requirement = $submission->requirement;


        // =====================================================
        // SAFETY CHECK
        // =====================================================

        if (!$cadet) {

            return response()->json([
                'success' => false,
                'message' => 'Cadet could not be found.',
            ], 404);
        }


        if (!$requirement) {

            return response()->json([
                'success' => false,
                'message' => 'BS requirement could not be found.',
            ], 404);
        }


        // =====================================================
        // CHECK PREVIOUS STATUS
        // =====================================================

        $previousStatus = $submission->status;


        // =====================================================
        // UPDATE SUBMISSION
        // =====================================================

        $submission->update([
            'status' =>
                $request->status,

            'remarks' =>
                $request->remarks,
        ]);


        // =====================================================
        // REFRESH
        // =====================================================

        $submission->refresh();


        // =====================================================
        // UPDATE CADET BS STATUS
        // =====================================================

        $cadet->load([
            'bsRequirements',
        ]);

        $totalBS =
            $cadet->bsRequirements->count();

        $approvedBS =
            $cadet->bsRequirements
                ->where(
                    'status',
                    'Approved'
                )
                ->count();


        if (
            $totalBS > 0 &&
            $approvedBS === $totalBS
        ) {

            $cadet->bs_status =
                'Qualified';

        } else {

            $cadet->bs_status =
                'Not Qualified';
        }


        $cadet->save();


        // =====================================================
        // SEND NOTIFICATION
        // =====================================================

        /*
        |--------------------------------------------------------------------------
        | Only notify when the status actually changes.
        |--------------------------------------------------------------------------
        */

        if (
            $previousStatus !== $request->status
        ) {

            $user = $cadet->user;

            if ($user) {

                $user->notify(
                    new BSRequirementStatusNotification(
                        $cadet,
                        $requirement,
                        $request->status,
                        $request->remarks
                    )
                );
            }
        }


        // =====================================================
        // REALTIME BS EVENT
        // =====================================================

        broadcast(
            new BSRequirementUpdated(
                $submission
            )
        )->toOthers();


        // =====================================================
        // RESPONSE
        // =====================================================

        return response()->json([

            'success' =>
                true,

            'id' =>
                $submission->id,

            'status' =>
                $submission->status,

            'remarks' =>
                $submission->remarks,

            'cadet_id' =>
                $cadet->id,

            'bs_status' =>
                $cadet->bs_status,

        ]);
    }


    // =========================================================
    // LEGACY APPROVAL
    // =========================================================

    public function approveLegacy(Cadet $cadet)
    {
        // =====================================================
        // PREVENT DUPLICATE PROCESSING
        // =====================================================

        if (
            $cadet->bs_status ===
            'Legacy Qualified'
        ) {

            return back()->with(
                'info',
                'Cadet is already marked as Legacy Qualified.'
            );
        }


        // =====================================================
        // UPDATE CADET STATUS
        // =====================================================

        $cadet->update([
            'bs_status' =>
                'Legacy Qualified',
        ]);


        // =====================================================
        // LOAD USER
        // =====================================================

        $cadet->load('user');

        $user = $cadet->user;


        // =====================================================
        // GET ALL BS REQUIREMENTS
        // =====================================================

        $requirements =
            BSRequirement::all();


        // =====================================================
        // APPROVE ALL REQUIREMENTS
        // =====================================================

        foreach ($requirements as $requirement) {

            $submission =
                CadetBSRequirement::firstOrCreate(

                    [
                        'cadet_id' =>
                            $cadet->id,

                        'b_s_requirement_id' =>
                            $requirement->id,
                    ],

                    [
                        'status' =>
                            'Approved',

                        'remarks' =>
                            'Legacy Graduate',

                        'attachment' =>
                            null,

                        'submitted_at' =>
                            Carbon::now(),
                    ]
                );


            // =================================================
            // NOTIFY CADET
            // =================================================

            if ($user) {

                $user->notify(
                    new BSRequirementStatusNotification(
                        $cadet,
                        $requirement,
                        'Approved',
                        'Legacy Graduate'
                    )
                );
            }
        }


        // =====================================================
        // SUCCESS
        // =====================================================

        return back()->with(
            'success',
            'Legacy graduate approved successfully.'
        );
    }
}