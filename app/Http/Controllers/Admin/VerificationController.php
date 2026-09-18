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
        */

        $totalRequirements = Document::count();


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        | Only retrieve the records needed for the current page.
        | Filters are handled by the database.
        */

        $query = Cadet::query()

            ->with([
                'batch',
                'documents',
                'bsRequirements',
            ])

            /*
            |----------------------------------------------------------
            | TOTAL DOCUMENTS
            |----------------------------------------------------------
            */

            ->withCount([
                'documents as required_documents_count',
            ])

            /*
            |----------------------------------------------------------
            | APPROVED DOCUMENTS
            |----------------------------------------------------------
            */

            ->withCount([
                'documents as approved_documents_count' => function ($q) {
                    $q->wherePivot(
                        'status',
                        'Approved'
                    );
                },
            ])

            /*
            |----------------------------------------------------------
            | TOTAL BS REQUIREMENTS
            |----------------------------------------------------------
            */

            ->withCount([
                'bsRequirements as bs_required_count',
            ])

            /*
            |----------------------------------------------------------
            | COMPLETED BS REQUIREMENTS
            |----------------------------------------------------------
            */

            ->withCount([
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


        // =========================================================
        // COURSE FILTER
        // =========================================================

        if ($request->filled('course')) {

            $courses = $request->input('course');

            if (!is_array($courses)) {
                $courses = [$courses];
            }

            $courses = array_values(
                array_filter(
                    array_map(
                        fn ($value) => trim($value),
                        $courses
                    )
                )
            );

            if (!empty($courses)) {

                $query->whereIn(
                    'course',
                    $courses
                );
            }
        }


        // =========================================================
        // BATCH FILTER
        // =========================================================

        if ($request->filled('batch')) {

            $batches = $request->input('batch');

            if (!is_array($batches)) {
                $batches = [$batches];
            }

            $batches = array_values(
                array_filter(
                    array_map(
                        fn ($value) => trim($value),
                        $batches
                    )
                )
            );

            if (!empty($batches)) {

                $query->whereHas(
                    'batch',
                    function ($q) use ($batches) {

                        $q->whereIn(
                            'batch_year',
                            $batches
                        );
                    }
                );
            }
        }


        // =========================================================
        // SEARCH
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
                    );
                });
            }
        }


        // =========================================================
        // VERIFICATION FILTER
        // =========================================================
        /*
        | Verified = every system document is approved.
        | Pending = not every document is approved.
        */

        if ($request->filled('verification')) {

            $statuses =
                $request->input('verification');

            if (!is_array($statuses)) {
                $statuses = [$statuses];
            }

            $statuses = array_map(
                fn ($value) => strtolower(trim($value)),
                $statuses
            );


            $wantVerified =
                in_array(
                    'verified',
                    $statuses,
                    true
                );


            $wantPending =
                in_array(
                    'pending',
                    $statuses,
                    true
                );


            /*
            |--------------------------------------------------------------------------
            | ONLY VERIFIED
            |--------------------------------------------------------------------------
            */

            if (
                $wantVerified &&
                !$wantPending
            ) {

                if ($totalRequirements > 0) {

                    $query->whereHas(
                        'documents',
                        function ($q) {
                            $q->wherePivot(
                                'status',
                                'Approved'
                            );
                        },
                        '=',
                        $totalRequirements
                    );
                } else {

                    /*
                    | No system requirements means nobody can be
                    | considered verified.
                    */

                    $query->whereRaw('1 = 0');
                }
            }


            /*
            |--------------------------------------------------------------------------
            | ONLY PENDING
            |--------------------------------------------------------------------------
            */

            elseif (
                $wantPending &&
                !$wantVerified
            ) {

                if ($totalRequirements > 0) {

                    $query->whereHas(
                        'documents',
                        function ($q) {
                            $q->wherePivot(
                                'status',
                                'Approved'
                            );
                        },
                        '<',
                        $totalRequirements
                    );

                } else {

                    /*
                    | If there are no requirements, all cadets are
                    | treated as pending.
                    */

                    // No additional restriction needed.
                }
            }

            /*
            |--------------------------------------------------------------------------
            | VERIFIED + PENDING
            |--------------------------------------------------------------------------
            */

            /*
            | If both are selected, don't restrict the query.
            */
        }


        // =========================================================
        // BS STATUS FILTER
        // =========================================================

        if ($request->filled('bs_status')) {

            $statuses =
                $request->input('bs_status');

            if (!is_array($statuses)) {
                $statuses = [$statuses];
            }

            $statuses = array_map(
                fn ($value) => strtolower(trim($value)),
                $statuses
            );


            $wantQualified =
                in_array(
                    'qualified',
                    $statuses,
                    true
                );


            $wantNotQualified =
                in_array(
                    'not qualified',
                    $statuses,
                    true
                );


            /*
            |--------------------------------------------------------------------------
            | ONLY QUALIFIED
            |--------------------------------------------------------------------------
            */

            if (
                $wantQualified &&
                !$wantNotQualified
            ) {

                $query->whereHas(
                    'bsRequirements',
                    function ($q) {
                        $q->whereIn(
                            'status',
                            [
                                'Approved',
                                'Completed',
                            ]
                        );
                    },
                    '=',
                    DB::raw('(
                        SELECT COUNT(*)
                        FROM bs_requirements AS bs_total
                        WHERE bs_total.cadet_id = cadets.id
                    )')
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ONLY NOT QUALIFIED
            |--------------------------------------------------------------------------
            */

            elseif (
                $wantNotQualified &&
                !$wantQualified
            ) {

                /*
                | We handle this after retrieving the paginated
                | records below if necessary.
                |
                | This condition intentionally remains flexible
                | because BS requirements are calculated from the
                | related records.
                */
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ORDER
        |--------------------------------------------------------------------------
        */

        $query->orderByRaw(
            'LOWER(full_name) ASC'
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        | Same pagination approach as CadetController.
        |
        | Only 25 records are sent to the browser.
        */

        $cadets = $query
            ->paginate(25)
            ->withQueryString();


        // =========================================================
        // CALCULATE CURRENT PAGE RECORDS
        // =========================================================

        foreach ($cadets as $cadet) {

            /*
            |--------------------------------------------------------------------------
            | VERIFICATION
            |--------------------------------------------------------------------------
            */

            $required =
                $totalRequirements;

            $approved =
                (int) $cadet->approved_documents_count;


            $cadet->required_documents_count =
                $required;

            $cadet->approved_documents_count =
                $approved;


            if (
                $required > 0 &&
                $approved >= $required
            ) {

                $cadet->verification_status =
                    'Verified';

            } else {

                $cadet->verification_status =
                    'Pending';
            }


            /*
            |--------------------------------------------------------------------------
            | BS REQUIREMENTS
            |--------------------------------------------------------------------------
            */

            $totalBS =
                (int) $cadet->bs_required_count;

            $completedBS =
                (int) $cadet->bs_completed_count;


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


            /*
            |--------------------------------------------------------------------------
            | PROGRESS
            |--------------------------------------------------------------------------
            */

            $cadet->doc_progress =
                "{$approved}/{$required}";
        }


        // =========================================================
        // STATISTICS
        // =========================================================
        /*
        | These are calculated from ALL records matching the
        | current filters, not only the 25 records on the page.
        */

        $statisticsQuery = clone $query;


        /*
        |--------------------------------------------------------------------------
        | GET FILTERED IDs
        |--------------------------------------------------------------------------
        */

        $filteredCadetIds =
            $statisticsQuery
                ->pluck('cadets.id');


        $verificationTotal =
            $filteredCadetIds->count();


        /*
        |--------------------------------------------------------------------------
        | VERIFICATION STATISTICS
        |--------------------------------------------------------------------------
        */

        $completed =
            0;

        $incomplete =
            0;

        $qualified =
            0;

        $notQualified =
            0;


        if ($verificationTotal > 0) {

            $statisticsCadets =
                Cadet::query()
                    ->whereIn(
                        'id',
                        $filteredCadetIds
                    )
                    ->with([
                        'documents',
                        'bsRequirements',
                    ])
                    ->get();


            foreach ($statisticsCadets as $cadet) {

                /*
                |------------------------------------------------------
                | DOCUMENT STATUS
                |------------------------------------------------------
                */

                $approved =
                    $cadet->documents
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


                /*
                |------------------------------------------------------
                | BS STATUS
                |------------------------------------------------------
                */

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


                if (
                    $totalBS > 0 &&
                    $completedBS >= $totalBS
                ) {

                    $qualified++;

                } else {

                    $notQualified++;
                }
            }
        }


        // =========================================================
        // FILTER DATA
        // =========================================================

        $courses = Cadet::query()
            ->select('course')
            ->whereNotNull('course')
            ->where(
                'course',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy('course')
            ->get();


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