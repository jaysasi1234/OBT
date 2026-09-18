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
        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        | Only cadets with Completed deployment are shown.
        */

        $query = Cadet::query()
            ->with([
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

            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {

                $q->where(
                    'full_name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'trb_control_number',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'course',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'rank',
                    'like',
                    '%' . $search . '%'
                );

            });
        }

        // =====================================================
        // COURSE FILTER
        // =====================================================

        if ($request->filled('course')) {

            $query->where(
                'course',
                $request->input('course')
            );
        }

        // =====================================================
        // BATCH FILTER
        // =====================================================

        if ($request->filled('batch')) {

            $query->where(
                'batch_id',
                $request->input('batch')
            );
        }

        // =====================================================
        // TOTAL REQUIREMENTS
        // =====================================================

        $totalRequirements = BSRequirement::count();

        // =====================================================
        // SUMMARY STATISTICS
        // =====================================================
        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | We calculate the statistics from the FULL FILTERED RESULT,
        | not only the current pagination page.
        |--------------------------------------------------------------------------
        */

        $summaryCadets = (clone $query)
            ->with([
                'bsRequirements:id,cadet_id,status,attachment',
            ])
            ->get();

        $totalCadets = $summaryCadets->count();

        $requirementsSubmitted = $summaryCadets->sum(
            fn ($cadet) =>
                $cadet->bsRequirements->count()
        );

        $pendingCadets = $summaryCadets->filter(
            fn ($cadet) =>
                $cadet->bsRequirements->count() < $totalRequirements
        )->count();

        $completedCadets = $summaryCadets->filter(
            fn ($cadet) =>
                $cadet->bsRequirements->count() == $totalRequirements
        )->count();

        // =====================================================
        // PAGINATION
        // =====================================================

        $cadets = $query
            ->orderBy('full_name')
            ->paginate(25)
            ->withQueryString();

        // =====================================================
        // FILTER DATA
        // =====================================================

        $batches = Batch::orderBy('batch_year', 'desc')
            ->get();

        $courses = Cadet::whereHas('deployment', function ($q) {
                $q->where('status', 'Completed');
            })
            ->select('course')
            ->whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->orderBy('course')
            ->pluck('course');

        // =====================================================
        // VIEW
        // =====================================================

        return view(
            'admin.cadet_bs_requirements.index',
            compact(
                'cadets',
                'totalRequirements',
                'courses',
                'batches',
                'totalCadets',
                'requirementsSubmitted',
                'pendingCadets',
                'completedCadets'
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

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'remarks' => 'nullable|string|max:500',
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
        // PREVIOUS STATUS
        // =====================================================

        $previousStatus = $submission->status;

        // =====================================================
        // UPDATE SUBMISSION
        // =====================================================

        $submission->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        $submission->refresh();

        // =====================================================
        // UPDATE CADET BS STATUS
        // =====================================================

        $cadet->load([
            'bsRequirements',
        ]);

        $totalBS = $cadet->bsRequirements->count();

        $approvedBS = $cadet->bsRequirements
            ->where('status', 'Approved')
            ->count();

        if (
            $totalBS > 0 &&
            $approvedBS === $totalBS
        ) {

            $cadet->bs_status = 'Qualified';

        } else {

            $cadet->bs_status = 'Not Qualified';
        }

        $cadet->save();

        // =====================================================
        // SEND NOTIFICATION
        // =====================================================

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
        // REALTIME EVENT
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
            'success' => true,
            'id' => $submission->id,
            'status' => $submission->status,
            'remarks' => $submission->remarks,
            'cadet_id' => $cadet->id,
            'bs_status' => $cadet->bs_status,
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
            $cadet->bs_status === 'Legacy Qualified'
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
            'bs_status' => 'Legacy Qualified',
        ]);

        // =====================================================
        // LOAD USER
        // =====================================================

        $cadet->load('user');

        $user = $cadet->user;

        // =====================================================
        // GET ALL BS REQUIREMENTS
        // =====================================================

        $requirements = BSRequirement::all();

        // =====================================================
        // APPROVE ALL REQUIREMENTS
        // =====================================================

        foreach ($requirements as $requirement) {

            CadetBSRequirement::firstOrCreate(

                [
                    'cadet_id' => $cadet->id,

                    'b_s_requirement_id' =>
                        $requirement->id,
                ],

                [
                    'status' => 'Approved',

                    'remarks' =>
                        'Legacy Graduate',

                    'attachment' => null,

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