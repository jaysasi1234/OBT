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
        $query = Cadet::with('batch')
            ->withCount([
                'documents',
                'bsRequirements'
            ])
        ->orderByRaw('LOWER(full_name) ASC');


        // =====================================================
        // FILTERS
        // =====================================================

        if ($request->filled('course')) {

            $query->where(
                'course',
                $request->course
            );
        }


        if ($request->filled('batch')) {

            $query->whereHas(
                'batch',
                function ($q) use ($request) {

                    $q->where(
                        'batch_year',
                        $request->batch
                    );

                }
            );
        }


        /*
         * Verification filter
         *
         * IMPORTANT:
         * Verification status is calculated from the documents,
         * so we apply this filter AFTER the calculations below.
         */


        /*
         * BS status filter
         *
         * IMPORTANT:
         * BS status is also calculated from BS requirements,
         * so we apply this filter AFTER the calculations below.
         */


        // =====================================================
        // SEARCH
        // =====================================================

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'full_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'trb_control_number',
                    'like',
                    "%{$search}%"
                );

            });
        }


        // =====================================================
        // GET FILTERED BASE RECORDS
        // =====================================================

        $allCadets = $query->get();


        // =====================================================
        // TOTAL SYSTEM REQUIREMENTS
        // =====================================================

        $totalRequirements = Document::count();


        // =====================================================
        // CALCULATE EACH CADET
        // =====================================================

        foreach ($allCadets as $cadet) {


            // -------------------------------------------------
            // VERIFICATION
            // -------------------------------------------------

            $approved = $cadet->documents
                ->where(
                    'pivot.status',
                    'Approved'
                )
                ->count();


            $cadet->required_documents_count =
                $totalRequirements;


            $cadet->approved_documents_count =
                $approved;


            $isVerified =
                $totalRequirements > 0 &&
                $approved == $totalRequirements;


            $cadet->verification_status =
                $isVerified
                    ? 'Verified'
                    : 'Pending';


            // -------------------------------------------------
            // BS REQUIREMENTS
            // -------------------------------------------------

            $totalBS =
                $cadet->bsRequirements->count();


            $completedBS =
                $cadet->bsRequirements
                    ->whereIn(
                        'status',
                        [
                            'Approved',
                            'Completed'
                        ]
                    )
                    ->count();


            $cadet->bs_required_count =
                $totalBS;


            $cadet->bs_completed_count =
                $completedBS;


            $isBSQualified =
                $totalBS > 0 &&
                $completedBS == $totalBS;


            $cadet->bs_status =
                $isBSQualified
                    ? 'Qualified'
                    : 'Not Qualified';


            // -------------------------------------------------
            // PROGRESS
            // -------------------------------------------------

            $cadet->doc_progress =
                "{$approved}/{$totalRequirements}";
        }


        // =====================================================
        // APPLY CALCULATED VERIFICATION FILTER
        // =====================================================

        if ($request->filled('verification_status')) {

            $verificationStatus =
                strtolower(
                    trim($request->verification_status)
                );


            $allCadets =
                $allCadets->filter(function ($cadet) use ($verificationStatus) {

                    return strtolower(
                        $cadet->verification_status
                    ) === $verificationStatus;

                });
        }


        // =====================================================
        // APPLY CALCULATED BS STATUS FILTER
        // =====================================================

        if ($request->filled('bs_status')) {

            $bsStatus =
                strtolower(
                    trim($request->bs_status)
                );


            $allCadets =
                $allCadets->filter(function ($cadet) use ($bsStatus) {

                    return strtolower(
                        $cadet->bs_status
                    ) === $bsStatus;

                });
        }


        // =====================================================
        // STATISTICS
        // =====================================================

        $verificationTotal =
            $allCadets->count();


        $completed =
            $allCadets
                ->where(
                    'verification_status',
                    'Verified'
                )
                ->count();


        $incomplete =
            $allCadets
                ->where(
                    'verification_status',
                    'Pending'
                )
                ->count();


        $qualified =
            $allCadets
                ->where(
                    'bs_status',
                    'Qualified'
                )
                ->count();


        $notQualified =
            $allCadets
                ->where(
                    'bs_status',
                    'Not Qualified'
                )
                ->count();


        // =====================================================
        // MANUAL PAGINATION
        // =====================================================
        /*
         * We calculate verification and BS status in PHP,
         * therefore normal query->paginate() cannot be used
         * after those calculations.
         *
         * This creates a Laravel paginator from the calculated
         * collection.
         */

        $perPage = 25;

        $currentPage =
            LengthAwarePaginator::resolveCurrentPage();

        $currentPageItems =
            $allCadets
                ->slice(
                    ($currentPage - 1) * $perPage,
                    $perPage
                )
                ->values();


        $cadets =
            new LengthAwarePaginator(
                $currentPageItems,
                $allCadets->count(),
                $perPage,
                $currentPage,
                [
                    'path' =>
                        LengthAwarePaginator::resolveCurrentPath(),

                    'query' =>
                        $request->query()
                ]
            );


        // =====================================================
        // FILTER DATA
        // =====================================================

        $courses =
            Cadet::select('course')
                ->whereNotNull('course')
                ->where('course', '!=', '')
                ->distinct()
                ->orderBy('course')
                ->get();


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

    public function show(Request $request, int $id)
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


        /*
         * Preserve the filters from the verification page.
         *
         * Example:
         *
         * ?course=bsmt
         * &batch=2025
         * &verification_status=verified
         * &bs_status=qualified
         * &search=john
         */

        $filters = $request->only([
            'course',
            'batch',
            'verification_status',
            'bs_status',
            'search',
            'page'
        ]);


        return view(
            'admin.verification.show',
            compact(
                'cadet',
                'documents',
                'totalDocs',
                'approvedDocs',
                'progress',
                'filters'
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


        // =====================================================
        // GET CADET
        // =====================================================

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        // =====================================================
        // GET DOCUMENT
        // =====================================================

        $document =
            Document::findOrFail(
                $request->document_id
            );


        // =====================================================
        // FILE
        // =====================================================

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


        // =====================================================
        // UPDATE PIVOT
        // =====================================================

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

                    'remarks' =>
                        $request->remarks ?? null,

                ]
            );


        // =====================================================
        // RECALCULATE VERIFICATION
        // =====================================================

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


        // =====================================================
        // SEND CADET NOTIFICATION
        // =====================================================

        if (
            in_array(
                strtolower(
                    $request->status
                ),
                [
                    'approved',
                    'rejected'
                ]
            )
        ) {

            $user = $cadet->user;


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


        // =====================================================
        // REDIRECT BACK WITH FILTERS
        // =====================================================

        return redirect()
            ->route(
                'admin.verification.index',
                $this->getFilterParameters($request)
            )
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


        // =====================================================
        // GET CADET
        // =====================================================

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        // =====================================================
        // GET ALL SYSTEM DOCUMENT REQUIREMENTS
        // =====================================================

        $documents =
            Document::all();


        // =====================================================
        // APPROVE EVERYTHING AS LEGACY
        // =====================================================

        DB::transaction(function () use ($cadet, $documents) {

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


            // =================================================
            // MARK CADET AS VERIFIED
            // =================================================

            $cadet->verification_status =
                'Verified';


            $cadet->save();

        });


        // =====================================================
        // REDIRECT BACK TO INDEX WITH FILTERS
        // =====================================================

        return redirect()
            ->route(
                'admin.verification.index',
                $this->getFilterParameters($request)
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


        // =====================================================
        // GET CADET
        // =====================================================

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        // =====================================================
        // GET DOCUMENT
        // =====================================================

        $document =
            Document::findOrFail(
                $request->document_id
            );


        // =====================================================
        // UPDATE STATUS
        // =====================================================

        $cadet->documents()
            ->updateExistingPivot(
                $request->document_id,
                [

                    'status' =>
                        $request->status,

                    'remarks' =>
                        $request->remarks ?? null,

                ]
            );


        // =====================================================
        // RECALCULATE
        // =====================================================

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


        // =====================================================
        // SEND NOTIFICATION
        // =====================================================

        if (
            in_array(
                strtolower(
                    $request->status
                ),
                [
                    'approved',
                    'rejected'
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


        // =====================================================
        // REDIRECT TO INDEX WITH FILTERS
        // =====================================================

        return redirect()
            ->route(
                'admin.verification.index',
                $this->getFilterParameters($request)
            )
            ->with(
                'success',
                'Verification status updated successfully.'
            );
    }


    // =========================================================
    // FILTER PARAMETERS
    // =========================================================

    private function getFilterParameters(Request $request): array
    {
        return array_filter(

            $request->only([
                'course',
                'batch',
                'verification_status',
                'bs_status',
                'search',
                'page'
            ]),

            function ($value) {

                return $value !== null &&
                       $value !== '';

            }

        );
    }
}