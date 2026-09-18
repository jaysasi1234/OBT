<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Notifications\VerificationRequirementStatusNotification;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================


public function index(Request $request)
{
    // =========================================================
    // TOTAL SYSTEM REQUIREMENTS
    // =========================================================

    $totalRequirements = Document::count();


    // =========================================================
    // GET FILTER VALUES
    // =========================================================

    $coursesFilter = $request->input('course', []);
    $batchesFilter = $request->input('batch', []);
    $verificationFilter = $request->input('verification', []);
    $bsStatusFilter = $request->input('bs_status', []);

    // Make sure everything is an array
    $coursesFilter = is_array($coursesFilter)
        ? array_filter($coursesFilter)
        : [$coursesFilter];

    $batchesFilter = is_array($batchesFilter)
        ? array_filter($batchesFilter)
        : [$batchesFilter];

    $verificationFilter = is_array($verificationFilter)
        ? array_filter($verificationFilter)
        : [$verificationFilter];

    $bsStatusFilter = is_array($bsStatusFilter)
        ? array_filter($bsStatusFilter)
        : [$bsStatusFilter];


    // =========================================================
    // BASE QUERY
    // =========================================================

    $query = Cadet::with([
        'batch',
        'documents',
        'bsRequirements',
    ]);


    // =========================================================
    // COURSE FILTER
    // =========================================================

    if (!empty($coursesFilter)) {

        $query->whereIn(
            'course',
            $coursesFilter
        );
    }


    // =========================================================
    // BATCH FILTER
    // =========================================================

    if (!empty($batchesFilter)) {

        $query->whereHas(
            'batch',
            function ($q) use ($batchesFilter) {

                $q->whereIn(
                    'batch_year',
                    $batchesFilter
                );
            }
        );
    }


    // =========================================================
    // SEARCH FILTER
    // =========================================================

    if ($request->filled('search')) {

        $search = trim(
            $request->input('search')
        );

        if ($search !== '') {

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
    }


    // =========================================================
    // VERIFICATION FILTER
    // =========================================================
    //
    // IMPORTANT:
    // Verification status is based on the SAME calculation
    // used in the Blade:
    //
    // Approved Documents == Total Required Documents
    //
    // Therefore:
    //
    // verified = all required documents approved
    // pending  = not all required documents approved
    //
    // =========================================================

    if (!empty($verificationFilter)) {

        $query->where(function ($q) use (
            $verificationFilter,
            $totalRequirements
        ) {

            // -------------------------------------------------
            // VERIFIED
            // -------------------------------------------------

            if (
                in_array(
                    'verified',
                    $verificationFilter,
                    true
                )
            ) {

                if ($totalRequirements > 0) {

                    $q->whereHas(
                        'documents',
                        function ($documentQuery) {

                            $documentQuery->wherePivot(
                                'status',
                                'Approved'
                            );
                        },
                        '=',
                        $totalRequirements
                    );
                }
            }


            // -------------------------------------------------
            // PENDING
            // -------------------------------------------------

            if (
                in_array(
                    'pending',
                    $verificationFilter,
                    true
                )
            ) {

                if ($totalRequirements > 0) {

                    $q->orWhereHas(
                        'documents',
                        function ($documentQuery) {

                            $documentQuery->wherePivot(
                                'status',
                                'Approved'
                            );
                        },
                        '<',
                        $totalRequirements
                    );
                } else {

                    $q->orWhereDoesntHave(
                        'documents'
                    );
                }
            }
        });
    }


    // =========================================================
    // BS STATUS FILTER
    // =========================================================
    //
    // Qualified:
    // ALL BS requirements are Approved or Completed.
    //
    // Not Qualified:
    // At least one BS requirement is not Approved/Completed
    // OR there are no BS requirements.
    //
    // =========================================================

    if (!empty($bsStatusFilter)) {

        /*
        |---------------------------------------------------------
        | IMPORTANT
        |---------------------------------------------------------
        |
        | BS requirements can differ per cadet.
        |
        | Because of that, we cannot simply compare against one
        | global BS requirement count.
        |
        | We therefore collect the cadet IDs that match the
        | requested BS status first.
        |
        */

        $bsCadetQuery = Cadet::with([
            'bsRequirements',
        ]);

        // Apply the SAME basic filters
        // to the BS status calculation.

        if (!empty($coursesFilter)) {

            $bsCadetQuery->whereIn(
                'course',
                $coursesFilter
            );
        }

        if (!empty($batchesFilter)) {

            $bsCadetQuery->whereHas(
                'batch',
                function ($q) use ($batchesFilter) {

                    $q->whereIn(
                        'batch_year',
                        $batchesFilter
                    );
                }
            );
        }

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            if ($search !== '') {

                $bsCadetQuery->where(function ($q) use ($search) {

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
        }


        $bsCadets = $bsCadetQuery->get();


        $matchingBSIds = [];


        foreach ($bsCadets as $bsCadet) {

            $totalBS =
                $bsCadet->bsRequirements->count();

            $completedBS =
                $bsCadet->bsRequirements
                    ->whereIn(
                        'status',
                        [
                            'Approved',
                            'Completed',
                        ]
                    )
                    ->count();


            $isQualified =
                $totalBS > 0 &&
                $completedBS >= $totalBS;


            // -------------------------------------------------
            // QUALIFIED
            // -------------------------------------------------

            if (
                in_array(
                    'qualified',
                    $bsStatusFilter,
                    true
                )
                &&
                $isQualified
            ) {

                $matchingBSIds[] =
                    $bsCadet->id;
            }


            // -------------------------------------------------
            // NOT QUALIFIED
            // -------------------------------------------------

            if (
                in_array(
                    'not qualified',
                    $bsStatusFilter,
                    true
                )
                &&
                !$isQualified
            ) {

                $matchingBSIds[] =
                    $bsCadet->id;
            }
        }


        /*
        |---------------------------------------------------------
        | Apply matching BS IDs to main query
        |---------------------------------------------------------
        */

        $query->whereIn(
            'id',
            array_unique($matchingBSIds)
        );
    }


    // =========================================================
    // ORDER
    // =========================================================

    $query->orderBy(
        'full_name'
    );


    // =========================================================
    // PAGINATION
    // =========================================================

    $cadets = $query
        ->paginate(25)
        ->withQueryString();


    // =========================================================
    // CALCULATE STATUS FOR CURRENT PAGE
    // =========================================================

    foreach ($cadets as $cadet) {

        // -----------------------------------------------------
        // VERIFICATION
        // -----------------------------------------------------

        $approved =
            $cadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


        $cadet->required_documents_count =
            $totalRequirements;


        $cadet->approved_documents_count =
            $approved;


        if (
            $totalRequirements > 0 &&
            $approved >= $totalRequirements
        ) {

            $cadet->verification_status =
                'Verified';

        } else {

            $cadet->verification_status =
                'Pending';
        }


        // -----------------------------------------------------
        // BS STATUS
        // -----------------------------------------------------

        $totalBS =
            $cadet->bsRequirements->count();


        $completedBS =
            $cadet->bsRequirements
                ->whereIn(
                    'status',
                    [
                        'Approved',
                        'Completed',
                    ]
                )
                ->count();


        $cadet->bs_required_count =
            $totalBS;


        $cadet->bs_completed_count =
            $completedBS;


        if (
            $totalBS > 0 &&
            $completedBS >= $totalBS
        ) {

            $cadet->bs_status =
                'Qualified';

        } else {

            $cadet->bs_status =
                'Not Qualified';
        }


        // -----------------------------------------------------
        // DOCUMENT PROGRESS
        // -----------------------------------------------------

        $cadet->doc_progress =
            "{$approved}/{$totalRequirements}";
    }


    // =========================================================
    // STATISTICS
    // =========================================================
    //
    // Statistics use the same BASIC filters:
    //
    // Course
    // Batch
    // Search
    //
    // The status filters are not used for the statistics
    // themselves because the cards represent the breakdown.
    //
    // =========================================================

    $statisticsQuery = Cadet::with([
        'documents',
        'bsRequirements',
    ]);


    // ---------------------------------------------------------
    // COURSE
    // ---------------------------------------------------------

    if (!empty($coursesFilter)) {

        $statisticsQuery->whereIn(
            'course',
            $coursesFilter
        );
    }


    // ---------------------------------------------------------
    // BATCH
    // ---------------------------------------------------------

    if (!empty($batchesFilter)) {

        $statisticsQuery->whereHas(
            'batch',
            function ($q) use ($batchesFilter) {

                $q->whereIn(
                    'batch_year',
                    $batchesFilter
                );
            }
        );
    }


    // ---------------------------------------------------------
    // SEARCH
    // ---------------------------------------------------------

    if ($request->filled('search')) {

        $search = trim(
            $request->input('search')
        );

        if ($search !== '') {

            $statisticsQuery->where(function ($q) use ($search) {

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
    }


    $statisticsCadets =
        $statisticsQuery->get();


    // ---------------------------------------------------------
    // INITIAL COUNTERS
    // ---------------------------------------------------------

    $verificationTotal =
        $statisticsCadets->count();

    $completed = 0;

    $incomplete = 0;

    $qualified = 0;

    $notQualified = 0;


    // ---------------------------------------------------------
    // CALCULATE STATISTICS
    // ---------------------------------------------------------

    foreach (
        $statisticsCadets as $statCadet
    ) {

        // -----------------------------------------------------
        // VERIFICATION
        // -----------------------------------------------------

        $approved =
            $statCadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


        if (
            $totalRequirements > 0 &&
            $approved >= $totalRequirements
        ) {

            $completed++;

        } else {

            $incomplete++;
        }


        // -----------------------------------------------------
        // BS
        // -----------------------------------------------------

        $totalBS =
            $statCadet->bsRequirements->count();


        $completedBS =
            $statCadet->bsRequirements
                ->whereIn(
                    'status',
                    [
                        'Approved',
                        'Completed',
                    ]
                )
                ->count();


        if (
            $totalBS > 0 &&
            $completedBS >= $totalBS
        ) {

            $qualified++;

        } else {

            $notQualified++;
        }
    }


    // =========================================================
    // COURSE FILTER OPTIONS
    // =========================================================

    $courses =
        Cadet::select('course')
            ->whereNotNull('course')
            ->where(
                'course',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy('course')
            ->get();


    // =========================================================
    // BATCH FILTER OPTIONS
    // =========================================================

    $batches =
        Batch::orderBy(
            'batch_year',
            'desc'
        )->get();


    // =========================================================
    // RETURN VIEW
    // =========================================================

    return view(
        'admin.verification.index',
        compact(
            'cadets',
            'verificationTotal',
            'completed',
            'incomplete',
            'qualified',
            'notQualified',
            'courses',
            'batches'
        )
    );
}

    // =========================================================
    // SHOW
    // =========================================================

    public function show(int $id)
    {
        $cadet = Cadet::with([
            'batch',
            'documents',
        ])->findOrFail($id);


        $documents =
            $cadet->documents;


        $totalDocs =
            $documents->count();


        $approvedDocs =
            $documents
                ->filter(function ($document) {

                    return optional(
                        $document->pivot
                    )->status === 'Approved';

                })
                ->count();


        $progress =
            $totalDocs > 0
                ? round(
                    ($approvedDocs / $totalDocs) * 100
                )
                : 0;


        return view(
            'admin.verification.show',
            compact(
                'cadet',
                'documents',
                'totalDocs',
                'approvedDocs',
                'progress'
            )
        );
    }


    // =========================================================
    // UPLOAD
    // =========================================================

    public function upload(Request $request)
    {
        $request->validate([

            'cadet_id' =>
                'required|exists:cadets,id',

            'document_id' =>
                'required|exists:documents,id',

            'status' =>
                'required',

            'file' =>
                'nullable|file|max:5120',

            'remarks' =>
                'nullable|string',
        ]);


        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        $document =
            Document::findOrFail(
                $request->document_id
            );


        $path = null;


        if ($request->hasFile('file')) {

            $path =
                $request
                    ->file('file')
                    ->store(
                        'documents',
                        'public'
                    );
        }


        $cadet->documents()
            ->updateExistingPivot(
                $request->document_id,
                [

                    'file_path' =>
                        $path,

                    'status' =>
                        $request->status,

                    'submitted_at' =>
                        now(),

                ]
            );


        $cadet->load('documents');


        $totalDocs =
            $cadet->documents->count();


        $approvedDocs =
            $cadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


        if (
            $totalDocs > 0 &&
            $approvedDocs == $totalDocs
        ) {

            $cadet->verification_status =
                'Verified';

        } else {

            $cadet->verification_status =
                'Pending';
        }


        $cadet->save();


        if (
            in_array(
                strtolower(
                    $request->status
                ),
                [
                    'approved',
                    'rejected',
                ]
            )
        ) {

            $user =
                $cadet->user;


            if ($user) {

                $user->notify(

                    new VerificationRequirementStatusNotification(

                        $cadet,

                        $document,

                        $request->status,

                        $request->remarks ?? null

                    )
                );
            }
        }


        return back()
            ->with(
                'success',
                'Verification requirement updated successfully.'
            );
    }


    // =========================================================
    // APPROVE ALL LEGACY DOCUMENTS
    // =========================================================

    public function approveLegacy(Request $request)
    {
        $request->validate([
            'cadet_id' =>
                'required|exists:cadets,id',
        ]);


        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        $documents =
            Document::all();


        DB::transaction(
            function () use (
                $cadet,
                $documents
            ) {

                foreach ($documents as $document) {

                    $cadet->documents()
                        ->syncWithoutDetaching([

                            $document->id => [

                                'status' =>
                                    'Approved',

                                'remarks' =>
                                    'Approved as legacy document. No digital upload required.',

                                'submitted_at' =>
                                    now(),

                            ]

                        ]);
                }


                $cadet->verification_status =
                    'Verified';


                $cadet->save();
            }
        );


        return redirect()
            ->route(
                'admin.verification.show',
                $cadet->id
            )
            ->with(
                'success',
                'All verification requirements have been approved as legacy documents.'
            );
    }


    // =========================================================
    // UPDATE STATUS
    // =========================================================

    public function updateStatus(Request $request)
    {
        $request->validate([

            'cadet_id' =>
                'required|exists:cadets,id',

            'document_id' =>
                'required|exists:documents,id',

            'status' =>
                'required',

            'remarks' =>
                'nullable|string',
        ]);


        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        $document =
            Document::findOrFail(
                $request->document_id
            );


        $cadet->documents()
            ->updateExistingPivot(
                $request->document_id,
                [

                    'status' =>
                        $request->status,

                ]
            );


        $cadet->load('documents');


        $totalDocs =
            $cadet->documents->count();


        $approvedDocs =
            $cadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


        if (
            $totalDocs > 0 &&
            $approvedDocs == $totalDocs
        ) {

            $cadet->verification_status =
                'Verified';

        } else {

            $cadet->verification_status =
                'Pending';
        }


        $cadet->save();


        if (
            in_array(
                strtolower(
                    $request->status
                ),
                [
                    'approved',
                    'rejected',
                ]
            )
        ) {

            $user =
                $cadet->user;


            if ($user) {

                $user->notify(

                    new VerificationRequirementStatusNotification(

                        $cadet,

                        $document,

                        $request->status,

                        $request->remarks ?? null

                    )
                );
            }
        }


        return back()
            ->with(
                'success',
                'Verification status updated successfully.'
            );
    }
}