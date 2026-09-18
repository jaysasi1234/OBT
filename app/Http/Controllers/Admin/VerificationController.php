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
        /*
        |--------------------------------------------------------------------------
        | TOTAL SYSTEM REQUIREMENTS
        |--------------------------------------------------------------------------
        |
        | We only need the number of documents here.
        | We DO NOT load all Document models for every cadet.
        |
        */

        $totalRequirements = Document::count();


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $query = Cadet::query()
            ->with([
                'batch',
            ])
            ->withCount([
                'documents',
                'bsRequirements',
            ])
            ->orderByRaw('LOWER(full_name) ASC');


        /*
        |--------------------------------------------------------------------------
        | COURSE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('course')) {

            $query->where(
                'course',
                $request->course
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BATCH FILTER
        |--------------------------------------------------------------------------
        */

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
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'full_name',
                    'like',
                    "%{$search}%"
                );

                $q->orWhere(
                    'trb_control_number',
                    'like',
                    "%{$search}%"
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | APPROVED DOCUMENT COUNT
        |--------------------------------------------------------------------------
        |
        | Instead of loading every document for every cadet,
        | ask the database for the number of approved documents.
        |
        */

        $query->withCount([
            'documents as approved_documents_count' => function ($q) {

                $q->where(
                    'cadet_document.status',
                    'Approved'
                );
            },
        ]);


        /*
        |--------------------------------------------------------------------------
        | COMPLETED BS REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $query->withCount([
            'bsRequirements as bs_completed_count' => function ($q) {

                $q->whereIn(
                    'status',
                    [
                        'Approved',
                        'Completed',
                    ]
                );
            },
        ]);


        /*
        |--------------------------------------------------------------------------
        | VERIFICATION STATUS FILTER
        |--------------------------------------------------------------------------
        |
        | Verification is calculated from:
        |
        | approved documents == total system documents
        |
        | Because this is an aggregate calculation, use HAVING
        | after selecting the approved count.
        |
        */

        if ($request->filled('verification_status')) {

            $verificationStatus =
                strtolower(
                    trim($request->verification_status)
                );


            if ($verificationStatus === 'verified') {

                if ($totalRequirements > 0) {

                    $query->having(
                        'approved_documents_count',
                        '=',
                        $totalRequirements
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | If there are no system documents, nobody should be
                    | automatically considered verified.
                    |--------------------------------------------------------------------------
                    */

                    $query->whereRaw('1 = 0');
                }

            } elseif ($verificationStatus === 'pending') {

                if ($totalRequirements > 0) {

                    $query->having(
                        'approved_documents_count',
                        '<',
                        $totalRequirements
                    );

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | If there are no requirements, all records remain
                    | pending because there is nothing to verify.
                    |--------------------------------------------------------------------------
                    */

                    $query->whereRaw('1 = 0');
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | BS STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('bs_status')) {

            $bsStatus =
                strtolower(
                    trim($request->bs_status)
                );


            if ($bsStatus === 'qualified') {

                $query->havingRaw(
                    'bs_completed_count = bs_requirements_count
                     AND bs_requirements_count > 0'
                );

            } elseif ($bsStatus === 'not qualified') {

                $query->havingRaw(
                    'bs_completed_count < bs_requirements_count
                     OR bs_requirements_count = 0'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | The old controller used:
        |
        |     ->get()
        |     foreach(...)
        |     ->filter(...)
        |     ->slice(...)
        |
        | This caused the entire verification dataset to be loaded
        | into memory before pagination.
        |
        | Now Laravel asks the database for only the current page.
        |
        */

        $cadets = $query
            ->paginate(25)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | ADD CALCULATED DISPLAY VALUES
        |--------------------------------------------------------------------------
        |
        | Only the 25 records on the current page are processed here.
        |
        */

        foreach ($cadets as $cadet) {

            /*
            |--------------------------------------------------------------------------
            | DOCUMENT COUNTS
            |--------------------------------------------------------------------------
            */

            $required =
                $totalRequirements;

            $approved =
                (int) ($cadet->approved_documents_count ?? 0);


            $cadet->required_documents_count =
                $required;

            $cadet->approved_documents_count =
                $approved;


            /*
            |--------------------------------------------------------------------------
            | VERIFICATION STATUS
            |--------------------------------------------------------------------------
            */

            $cadet->verification_status =
                (
                    $required > 0 &&
                    $approved >= $required
                )
                    ? 'Verified'
                    : 'Pending';


            /*
            |--------------------------------------------------------------------------
            | BS COUNTS
            |--------------------------------------------------------------------------
            */

            $bsRequired =
                (int) ($cadet->bs_requirements_count ?? 0);

            $bsCompleted =
                (int) ($cadet->bs_completed_count ?? 0);


            $cadet->bs_required_count =
                $bsRequired;

            $cadet->bs_completed_count =
                $bsCompleted;


            /*
            |--------------------------------------------------------------------------
            | BS STATUS
            |--------------------------------------------------------------------------
            */

            $cadet->bs_status =
                (
                    $bsRequired > 0 &&
                    $bsCompleted >= $bsRequired
                )
                    ? 'Qualified'
                    : 'Not Qualified';


            /*
            |--------------------------------------------------------------------------
            | PROGRESS
            |--------------------------------------------------------------------------
            */

            $cadet->doc_progress =
                "{$approved}/{$required}";
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        |
        | These statistics are calculated separately so the cards
        | represent the complete filtered result set, not just the
        | 25 records currently visible on the page.
        |
        */

        $statisticsQuery = clone $query;


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $verificationTotal =
            $this->countAggregateQuery(
                clone $statisticsQuery
            );


        /*
        |--------------------------------------------------------------------------
        | COMPLETED / VERIFIED
        |--------------------------------------------------------------------------
        */

        $completed = 0;

        if ($totalRequirements > 0) {

            $completed =
                $this->countAggregateQuery(
                    (clone $query)->having(
                        'approved_documents_count',
                        '=',
                        $totalRequirements
                    )
                );
        }


        /*
        |--------------------------------------------------------------------------
        | INCOMPLETE / PENDING
        |--------------------------------------------------------------------------
        */

        $incomplete = 0;

        if ($totalRequirements > 0) {

            $incomplete =
                $this->countAggregateQuery(
                    (clone $query)->having(
                        'approved_documents_count',
                        '<',
                        $totalRequirements
                    )
                );
        }


        /*
        |--------------------------------------------------------------------------
        | QUALIFIED
        |--------------------------------------------------------------------------
        */

        $qualified =
            $this->countAggregateQuery(
                (clone $query)->havingRaw(
                    'bs_completed_count = bs_requirements_count
                     AND bs_requirements_count > 0'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | NOT QUALIFIED
        |--------------------------------------------------------------------------
        */

        $notQualified =
            $this->countAggregateQuery(
                (clone $query)->havingRaw(
                    'bs_completed_count < bs_requirements_count
                     OR bs_requirements_count = 0'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | FILTER DATA
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

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
    // AGGREGATE COUNT HELPER
    // =========================================================

    private function countAggregateQuery($query): int
    {
        /*
        |--------------------------------------------------------------------------
        | Clone the query and remove pagination-related pieces.
        |--------------------------------------------------------------------------
        */

        return $query
            ->reorder()
            ->get()
            ->count();
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
        |--------------------------------------------------------------------------
        | PRESERVE FILTERS
        |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | GET CADET
        |--------------------------------------------------------------------------
        */

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        /*
        |--------------------------------------------------------------------------
        | GET DOCUMENT
        |--------------------------------------------------------------------------
        */

        $document =
            Document::findOrFail(
                $request->document_id
            );


        /*
        |--------------------------------------------------------------------------
        | FILE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | UPDATE PIVOT
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | RECALCULATE VERIFICATION
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SEND NOTIFICATION
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | GET CADET
        |--------------------------------------------------------------------------
        */

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        /*
        |--------------------------------------------------------------------------
        | GET ALL DOCUMENT REQUIREMENTS
        |--------------------------------------------------------------------------
        */

        $documents =
            Document::all();


        /*
        |--------------------------------------------------------------------------
        | APPROVE EVERYTHING
        |--------------------------------------------------------------------------
        */

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


            /*
            |--------------------------------------------------------------------------
            | MARK VERIFIED
            |--------------------------------------------------------------------------
            */

            $cadet->verification_status =
                'Verified';


            $cadet->save();
        });


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | GET CADET
        |--------------------------------------------------------------------------
        */

        $cadet =
            Cadet::findOrFail(
                $request->cadet_id
            );


        /*
        |--------------------------------------------------------------------------
        | GET DOCUMENT
        |--------------------------------------------------------------------------
        */

        $document =
            Document::findOrFail(
                $request->document_id
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | RECALCULATE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SEND NOTIFICATION
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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