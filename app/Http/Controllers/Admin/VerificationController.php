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
    | Same pagination approach as CadetController.
    */

    $query = Cadet::with([
        'batch',
        'documents',
        'bsRequirements',
    ]);


    // =========================================================
    // COURSE FILTER
    // =========================================================

    if ($request->filled('course')) {

        $courses = $request->input('course');

        if (!is_array($courses)) {
            $courses = [$courses];
        }

        $courses = array_filter($courses);

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

        $batches = array_filter($batches);

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

        $search =
            trim(
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
    | EXACTLY LIKE YOUR CADET CONTROLLER
    |
    | Only 25 cadets are loaded at a time.
    */

    $cadets = $query
        ->paginate(25)
        ->withQueryString();


    // =========================================================
    // CALCULATE CURRENT PAGE
    // =========================================================

    foreach ($cadets as $cadet) {

        /*
        |--------------------------------------------------------------------------
        | VERIFICATION REQUIREMENTS
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | BS REQUIREMENTS
        |--------------------------------------------------------------------------
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
            "{$approved}/{$totalRequirements}";
    }


    // =========================================================
    // STATISTICS
    // =========================================================
    /*
    | IMPORTANT:
    | These statistics use ALL cadets matching the basic
    | course/batch/search filters, not only the 25 displayed.
    |
    | Verification and BS checkbox filters are intentionally
    | applied after calculating the statuses.
    */

    $statisticsQuery = Cadet::with([
        'documents',
        'bsRequirements',
    ]);


    // ---------------------------------------------------------
    // COURSE
    // ---------------------------------------------------------

    if ($request->filled('course')) {

        $courses = $request->input('course');

        if (!is_array($courses)) {
            $courses = [$courses];
        }

        $courses = array_filter($courses);

        if (!empty($courses)) {

            $statisticsQuery->whereIn(
                'course',
                $courses
            );
        }
    }


    // ---------------------------------------------------------
    // BATCH
    // ---------------------------------------------------------

    if ($request->filled('batch')) {

        $batches = $request->input('batch');

        if (!is_array($batches)) {
            $batches = [$batches];
        }

        $batches = array_filter($batches);

        if (!empty($batches)) {

            $statisticsQuery->whereHas(
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


    // ---------------------------------------------------------
    // SEARCH
    // ---------------------------------------------------------

    if ($request->filled('search')) {

        $search =
            trim(
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
                );

            });
        }
    }


    /*
    |--------------------------------------------------------------------------
    | GET STATISTICS RECORDS
    |--------------------------------------------------------------------------
    */

    $statisticsCadets =
        $statisticsQuery->get();


    $verificationTotal =
        $statisticsCadets->count();


    $completed = 0;

    $incomplete = 0;

    $qualified = 0;

    $notQualified = 0;


    foreach (
        $statisticsCadets
        as $statCadet
    ) {

        /*
        |--------------------------------------------------------------------------
        | VERIFICATION
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | BS
        |--------------------------------------------------------------------------
        */

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
    // FILTER DATA
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