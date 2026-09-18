<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Batch;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Notifications\VerificationRequirementStatusNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class VerificationController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request)
    {
        // =====================================================
        // TOTAL SYSTEM REQUIREMENTS
        // =====================================================

        $totalRequirements = Document::count();


        // =====================================================
        // FILTER VALUES
        // =====================================================

        $coursesFilter = $request->input('course', []);
        $batchesFilter = $request->input('batch', []);
        $verificationFilter = $request->input('verification', []);
        $bsStatusFilter = $request->input('bs_status', []);


        // Always convert filters to arrays
        $coursesFilter = is_array($coursesFilter)
            ? array_values(array_filter($coursesFilter))
            : array_values(array_filter([$coursesFilter]));

        $batchesFilter = is_array($batchesFilter)
            ? array_values(array_filter($batchesFilter))
            : array_values(array_filter([$batchesFilter]));

        $verificationFilter = is_array($verificationFilter)
            ? array_values(array_filter($verificationFilter))
            : array_values(array_filter([$verificationFilter]));

        $bsStatusFilter = is_array($bsStatusFilter)
            ? array_values(array_filter($bsStatusFilter))
            : array_values(array_filter([$bsStatusFilter]));


        // =====================================================
        // BASE QUERY
        // =====================================================

        $query = Cadet::with([
            'batch',
            'documents',
            'bsRequirements',
        ]);


        // =====================================================
        // COURSE FILTER
        // =====================================================

        if (!empty($coursesFilter)) {

            $query->whereIn(
                'course',
                $coursesFilter
            );
        }


        // =====================================================
        // BATCH FILTER
        // =====================================================

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


        // =====================================================
        // SEARCH FILTER
        // =====================================================

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


        // =====================================================
        // GET ALL MATCHING BASE RECORDS
        // =====================================================
        //
        // We intentionally get the matching cadets first.
        //
        // Verification and BS Status are calculated from the
        // actual loaded relationships, exactly like the Blade.
        //
        // This prevents the filter from using a different
        // calculation than the table.
        //
        // =====================================================

        $allCadets = $query
            ->orderBy('full_name')
            ->get();


        // =====================================================
        // CALCULATE STATUS
        // =====================================================

        foreach ($allCadets as $cadet) {

            // -------------------------------------------------
            // VERIFICATION
            // -------------------------------------------------

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


            $cadet->verification_status =
                (
                    $totalRequirements > 0 &&
                    $approved >= $totalRequirements
                )
                    ? 'Verified'
                    : 'Pending';


            // -------------------------------------------------
            // BS STATUS
            // -------------------------------------------------

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


            $cadet->bs_status =
                (
                    $totalBS > 0 &&
                    $completedBS >= $totalBS
                )
                    ? 'Qualified'
                    : 'Not Qualified';


            // -------------------------------------------------
            // DOCUMENT PROGRESS
            // -------------------------------------------------

            $cadet->doc_progress =
                "{$approved}/{$totalRequirements}";
        }


        // =====================================================
        // VERIFICATION FILTER
        // =====================================================
        //
        // This now uses the SAME verification_status calculated
        // above and displayed by the Blade.
        //
        // =====================================================

        if (!empty($verificationFilter)) {

            $allCadets = $allCadets
                ->filter(function ($cadet) use ($verificationFilter) {

                    return in_array(
                        strtolower(
                            $cadet->verification_status
                        ),
                        array_map(
                            'strtolower',
                            $verificationFilter
                        ),
                        true
                    );
                })
                ->values();
        }


        // =====================================================
        // BS STATUS FILTER
        // =====================================================
        //
        // This also uses the SAME bs_status calculated above.
        //
        // =====================================================

        if (!empty($bsStatusFilter)) {

            $allCadets = $allCadets
                ->filter(function ($cadet) use ($bsStatusFilter) {

                    $status =
                        strtolower(
                            $cadet->bs_status
                        );

                    $selectedStatuses =
                        array_map(
                            'strtolower',
                            $bsStatusFilter
                        );

                    return in_array(
                        $status,
                        $selectedStatuses,
                        true
                    );
                })
                ->values();
        }


        // =====================================================
        // STATISTICS
        // =====================================================
        //
        // Statistics are calculated from the SAME collection.
        //
        // Course / Batch / Search are already applied.
        //
        // Verification / BS filters are NOT applied here
        // because these cards represent the complete breakdown.
        //
        // =====================================================

        /*
         * Re-create the statistics collection from the same
         * Course / Batch / Search filters.
         */
        $statisticsQuery = Cadet::with([
            'documents',
            'bsRequirements',
        ]);


        // -----------------------------------------------------
        // COURSE
        // -----------------------------------------------------

        if (!empty($coursesFilter)) {

            $statisticsQuery->whereIn(
                'course',
                $coursesFilter
            );
        }


        // -----------------------------------------------------
        // BATCH
        // -----------------------------------------------------

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


        // -----------------------------------------------------
        // SEARCH
        // -----------------------------------------------------

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
            $statisticsQuery
                ->orderBy('full_name')
                ->get();


        // -----------------------------------------------------
        // INITIAL COUNTERS
        // -----------------------------------------------------

        $verificationTotal =
            $statisticsCadets->count();

        $completed = 0;

        $incomplete = 0;

        $qualified = 0;

        $notQualified = 0;


        // -----------------------------------------------------
        // CALCULATE STATISTICS
        // -----------------------------------------------------

        foreach ($statisticsCadets as $statCadet) {

            // Verification
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


            // BS
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


        // =====================================================
        // MANUAL PAGINATION
        // =====================================================
        //
        // We paginate AFTER the status filters are applied.
        //
        // This is important because Laravel's normal paginate()
        // cannot know about our calculated Verification / BS
        // statuses.
        //
        // =====================================================

        $perPage = 25;

        $currentPage =
            LengthAwarePaginator::resolveCurrentPage();

        $currentItems =
            $allCadets
                ->slice(
                    ($currentPage - 1) * $perPage,
                    $perPage
                )
                ->values();


        $cadets =
            new LengthAwarePaginator(
                $currentItems,
                $allCadets->count(),
                $perPage,
                $currentPage,
                [
                    'path' =>
                        $request->url(),

                    'query' =>
                        $request->query(),
                ]
            );


        // =====================================================
        // COURSE FILTER OPTIONS
        // =====================================================

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


        // =====================================================
        // BATCH FILTER OPTIONS
        // =====================================================

        $batches =
            Batch::orderBy(
                'batch_year',
                'desc'
            )->get();


        // =====================================================
        // RETURN VIEW
        // =====================================================

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


        $cadet->verification_status =
            (
                $totalDocs > 0 &&
                $approvedDocs == $totalDocs
            )
                ? 'Verified'
                : 'Pending';


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


        $cadet->verification_status =
            (
                $totalDocs > 0 &&
                $approvedDocs == $totalDocs
            )
                ? 'Verified'
                : 'Pending';


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